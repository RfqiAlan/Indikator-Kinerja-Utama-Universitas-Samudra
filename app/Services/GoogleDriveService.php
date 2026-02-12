<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected Drive $driveService;
    protected string $folderId;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(config('google.service_account_json'));
        $client->addScope(Drive::DRIVE_FILE);

        $this->driveService = new Drive($client);
        $this->folderId = config('google.drive_folder_id');
    }

    /**
     * Upload file to Google Drive and return the shareable link.
     */
    public function upload(UploadedFile $file, string $subfolder = ''): ?string
    {
        try {
            // Determine target folder
            $parentId = $subfolder ? $this->getOrCreateSubfolder($subfolder) : $this->folderId;

            $driveFile = new DriveFile([
                'name' => time() . '_' . $file->getClientOriginalName(),
                'parents' => [$parentId],
            ]);

            // Upload (Shared Drive: supportsAllDrives wajib)
            $result = $this->driveService->files->create($driveFile, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink',
                'supportsAllDrives' => true,
            ]);

            // Set permission: anyone with link can view
            // NOTE: di sebagian Shared Drive, permission "anyone" bisa diblok oleh admin.
            try {
                $this->driveService->permissions->create(
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
                $this->driveService->files->delete($fileId, [
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
        // Shared Drive: listFiles perlu supportsAllDrives + includeItemsFromAllDrives
        $safeName = addslashes($name);
        $query = "name='{$safeName}' and '{$this->folderId}' in parents and mimeType='application/vnd.google-apps.folder' and trashed=false";

        $results = $this->driveService->files->listFiles([
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

        $created = $this->driveService->files->create($folder, [
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
}
