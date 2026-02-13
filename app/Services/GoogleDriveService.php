<?php

namespace App\Services;

use App\Models\GoogleDriveToken;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected ?Drive $driveService = null;
    protected string $folderId;
    protected ?GoogleDriveToken $token;

    public function __construct()
    {
        $this->folderId = config('google.drive_folder_id');
        $this->token = auth()->check() ? auth()->user()->googleDriveToken : null;
    }

    /**
     * Upload file to Google Drive and return the shareable link.
     */
    public function upload(UploadedFile $file, string $subfolder = ''): ?string
    {
        try {
            $driveService = $this->getDriveService();
            if (!$driveService) {
                return null;
            }

            // Determine target folder
            $parentId = $subfolder ? $this->getOrCreateSubfolder($subfolder) : $this->folderId;

            $driveFile = new DriveFile([
                'name' => time() . '_' . $file->getClientOriginalName(),
                'parents' => [$parentId],
            ]);

            // Upload (Shared Drive: supportsAllDrives wajib)
            $result = $driveService->files->create($driveFile, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink',
                'supportsAllDrives' => true,
            ]);

            // Set permission: anyone with link can view
            // NOTE: di sebagian Shared Drive, permission "anyone" bisa diblok oleh admin.
            try {
                $driveService->permissions->create(
                    $result->id,
                    new Permission([
                        'type' => 'anyone',
                        'role' => 'reader',
                    ]),
                    [
                        'supportsAllDrives' => true,
                    ]
                );
            } catch (\Exception $permEx) {
                Log::warning('Google Drive permission set failed (file uploaded but may be private): ' . $permEx->getMessage());
                // Tetap return webViewLink, tapi mungkin perlu login/akses drive.
            }

            return $result->webViewLink;

        } catch (\Exception $e) {
            Log::error('Google Drive upload failed: ' . $e->getMessage(), [
                'folderId' => $this->folderId,
                'subfolder' => $subfolder,
            ]);
            return null;
        }
    }

    /**
     * Delete file from Drive by its link.
     */
    public function deleteByLink(string $link): bool
    {
        try {
            $fileId = $this->extractFileId($link);
            if ($fileId) {
                $driveService = $this->getDriveService();
                if (!$driveService) {
                    return false;
                }
                $driveService->files->delete($fileId, [
                    'supportsAllDrives' => true,
                ]);
                return true;
            }
        } catch (\Exception $e) {
            Log::warning('Google Drive delete failed: ' . $e->getMessage());
        }
        return false;
    }

    /**
     * Get or create a subfolder inside the main Drive folder.
     */
    protected function getOrCreateSubfolder(string $name): string
    {
        $driveService = $this->getDriveService();
        if (!$driveService) {
            return $this->folderId;
        }

        // Shared Drive: listFiles perlu supportsAllDrives + includeItemsFromAllDrives
        $safeName = addslashes($name);
        $query = "name='{$safeName}' and '{$this->folderId}' in parents and mimeType='application/vnd.google-apps.folder' and trashed=false";

        $results = $driveService->files->listFiles([
            'q' => $query,
            'fields' => 'files(id)',
            'pageSize' => 1,
            'supportsAllDrives' => true,
            'includeItemsFromAllDrives' => true,
        ]);

        if (count($results->getFiles()) > 0) {
            return $results->getFiles()[0]->getId();
        }

        // Create folder (Shared Drive: supportsAllDrives)
        $folder = new DriveFile([
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => [$this->folderId],
        ]);

        $created = $driveService->files->create($folder, [
            'fields' => 'id',
            'supportsAllDrives' => true,
        ]);

        return $created->getId();
    }

    /**
     * Extract file ID from a Google Drive link.
     */
    protected function extractFileId(string $link): ?string
    {
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $link, $m)) {
            return $m[1];
        }
        if (preg_match('/id=([a-zA-Z0-9_-]+)/', $link, $m)) {
            return $m[1];
        }
        return null;
    }

    protected function getDriveService(): ?Drive
    {
        if ($this->driveService) {
            return $this->driveService;
        }

        $client = $this->buildClient();
        if (!$client) {
            return null;
        }

        $this->driveService = new Drive($client);
        return $this->driveService;
    }

    protected function buildClient(): ?Client
    {
        if ($this->shouldUseOauth()) {
            if (!$this->token) {
                Log::warning('Google Drive OAuth token missing for user.', [
                    'user_id' => auth()->id(),
                ]);
                return null;
            }

            $client = new Client();
            $client->setAuthConfig(config('google.oauth_client_json'));
            $client->setRedirectUri(config('google.redirect_uri'));
            $client->setAccessType('offline');
            $client->setPrompt('consent');
            $client->addScope(Drive::DRIVE);
            $client->setAccessToken([
                'access_token' => $this->token->access_token,
                'refresh_token' => $this->token->refresh_token,
                'token_type' => $this->token->token_type,
                'expires_in' => $this->token->expires_at?->diffInSeconds(now()) ?? 0,
                'created' => $this->token->updated_at?->timestamp ?? now()->timestamp,
            ]);

            if ($client->isAccessTokenExpired()) {
                $refreshToken = $client->getRefreshToken();
                if (!$refreshToken) {
                    Log::warning('Google Drive refresh token missing for user.', [
                        'user_id' => auth()->id(),
                    ]);
                    return null;
                }

                $newToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
                if (isset($newToken['error'])) {
                    Log::warning('Google Drive token refresh failed.', [
                        'user_id' => auth()->id(),
                        'error' => $newToken['error'],
                    ]);
                    return null;
                }

                $this->updateToken($newToken);
            }

            return $client;
        }

        $client = new Client();
        $client->setAuthConfig(config('google.service_account_json'));
        $client->addScope(Drive::DRIVE_FILE);

        return $client;
    }

    protected function shouldUseOauth(): bool
    {
        return auth()->check()
            && is_file(config('google.oauth_client_json'))
            && config('google.redirect_uri');
    }

    protected function updateToken(array $newToken): void
    {
        if (!$this->token) {
            return;
        }

        if (!empty($newToken['access_token'])) {
            $this->token->access_token = $newToken['access_token'];
        }
        if (!empty($newToken['refresh_token'])) {
            $this->token->refresh_token = $newToken['refresh_token'];
        }
        if (!empty($newToken['token_type'])) {
            $this->token->token_type = $newToken['token_type'];
        }
        if (!empty($newToken['scope'])) {
            $this->token->scopes = $newToken['scope'];
        }
        if (!empty($newToken['expires_in'])) {
            $this->token->expires_at = now()->addSeconds($newToken['expires_in']);
        }

        $this->token->save();
    }
}
