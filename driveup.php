<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'env.php';
require __DIR__ . '/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=credentials/service_account_credentials.json');

function uploadToDrive($filePath) {

  $client = new Google_Client();
  $client->useApplicationDefaultCredentials();
  $client->setScopes(array('https://www.googleapis.com/auth/drive'));

  $service = new Google_Service_Drive($client);

  $fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => basename($filePath),
    'parents' => array(DRIVE_FOLDER_ID)
  ));

  $result = $service->files->create($fileMetadata, array(
    'data' => file_get_contents($filePath),
    'mimeType' => 'application/octet-stream',
    'uploadType' => 'media'
  ));

  return $result;
}
