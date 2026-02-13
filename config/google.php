<?php

return [
    'service_account_json' => storage_path('app/google/drive.json'),
    'oauth_client_json' => storage_path('app/google/oauth.json'),
    'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
    'drive_folder_id' => env('GOOGLE_DRIVE_FOLDER_ID', '1Cv0iYte2kgOxjUBFmDeS0xK2tY5f07DE'),
];
