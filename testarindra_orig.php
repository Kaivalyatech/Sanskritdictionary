<?php

// Call set_include_path() as needed to point to your client library.
set_include_path(get_include_path() . PATH_SEPARATOR . '/var/www/websites/arindra-test/google-api-php-client-2.2.1/src/Google');
require_once 'vendor/autoload.php';
require_once 'src/Google/Client.php';
//require_once 'Google/Model.php';
//require_once 'Google/Service.php';
//require_once 'Google/Collection.php';
//require_once 'Google/Service/Resource.php';
//require_once 'google-api-php-client/src/Google/Service/YouTube.php';
session_start();

/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * Google Developers Console <https://console.developers.google.com/>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */
$OAUTH2_CLIENT_ID = '793800951067-d27nt68l1tjgcpgol6751lgr94acrsh2.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'R1E7jZyJB6NWfTaXrVjWuPEW';

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/drive');
//$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],FILTER_SANITIZE_URL);
//$client->setRedirectUri('http://kts.kaivalyatech.com/arindra-test/google-api-php-client-2.2.1/oauth2callback.php');
$client->setRedirectUri('http://kts.kaivalyatech.com');
// Define an object that will be used to make all API requests.
$service = new Google_Service_Drive($client);


if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}
$htmlBody = '';
//$playlistId = 'PLGA8Lv0hEqzFIxbtwpbLV2SNSWpZTMjfB';
$pageToken = 'nextPageToken';
// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try {
    // Call the channels.list method to retrieve information about the
    // currently authenticated user's channel.
    /*$channelsResponse = $youtube->channels->listChannels('contentDetails', array(
      'mine' => 'true',
    ));*/

    //$htmlBody = '';
    //foreach ($channelsResponse['items'] as $channel) {
      // Extract the unique playlist ID that identifies the list of videos
      // uploaded to the channel, and then call the playlistItems.list method
      // to retrieve that list.
      //$uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];

      $optParams = array(
	  'pageSize' => 50,
	  'fields' => 'nextPageToken, files(id, name)'
	);
	$results = $service->files->listFiles($optParams);
	foreach ($results->getFiles() as $searchResult) {
		$htmlBody .="ID::".$searchResult->getId()."     "."NAME::".$searchResult->getName().'<br>';
	}

      $htmlBody .= '</ul>';
    //}
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }

  $_SESSION['token'] = $client->getAccessToken();
} else {
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>

<!doctype html>
<html>
  <head>
    <title>My Uploads</title>
  </head>
  <body>
    <?=$htmlBody?>
  </body>
</html>
