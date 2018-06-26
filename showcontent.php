<?php
require_once __DIR__ . '/vendor/autoload.php';
//putenv('GOOGLE_APPLICATION_CREDENTIALS=/mySecretFile.json');

$client = new Google_Client();
//$client->useApplicationDefaultCredentials();
//$client->setApplicationName('Google Drive API PHP Quickstart');
//$client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
//$client->setAuthConfig('client_secret.json');
//$client->setDeveloperKey("AIzaSyCfyfYWeSINNhS8pvcUEbTIT3ZI8hZClk8");

$OAUTH2_CLIENT_ID = '793800951067-d27nt68l1tjgcpgol6751lgr94acrsh2.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'R1E7jZyJB6NWfTaXrVjWuPEW';



$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->addScope("https://www.googleapis.com/auth/drive");
$service = new Google_Service_Drive($client);

$files = $service->files->listFiles()->getFiles();

foreach($files as $file){
    print_r($file); 
}
?>