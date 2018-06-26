<?php

//echo "im back";
//require_once __DIR__.'autoload.php';
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secret.json');
$client->setRedirectUri('http://kts.kaivalyatech.com/arindra-test/google-api-php-client-2.2.1/oauth2callback.php');
//$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
$client->addScope("https://www.googleapis.com/auth/drive");

/*
if (! isset($_GET['code'])) {
	  $auth_url = $client->createAuthUrl();
	  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
	  $client->authenticate($_GET['code']);
	  $_SESSION['access_token'] = $client->getAccessToken();
	  //$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/arindra-test/';
	  //header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	  $service = new Google_Service_Drive($client);


	  
	  // Print the names and IDs for up to 10 files.
	$optParams = array(
	  'pageSize' => 20,
	  'fields' => 'nextPageToken, files(id, name)'
	);
	$results = $service->files->listFiles($optParams);

	if (count($results->getFiles()) == 0) {
		print "No files found.\n";
	} else {
		print "Files:\n";
		foreach ($results->getFiles() as $file) {
			printf("%s (%s)\n", $file->getName(), $file->getId());
		}
	}
  
}*/




?>
