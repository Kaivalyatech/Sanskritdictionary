<?php
if (!class_exists('Google_Client')) {
  require_once __DIR__ . '/vendor/autoload.php';
}

session_start();

$client = new Google_Client();
$client->setApplicationName("My Application");
$client->setDeveloperKey("AIzaSyAjiSBCbYLC1iXY5Q2LJaOD1CM8MURhazE");
//$client->setDeveloperKey("AIzaSyCh8zXyMWRDU19TjpPGA-nvXnes6frbw5A"); AIzaSyCfyfYWeSINNhS8pvcUEbTIT3ZI8hZClk8
$service = new Google_Service_Books($client);
$optParams = array();
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
foreach ($results as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}

?>
