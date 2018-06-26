<?php
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
    $client->setAuthConfig('client_secret.json');
	//$client->setClientId('793800951067-nbhl0huheiofo57pskmo9kjmn3hv9qus.apps.googleusercontent.com');
	//$client->setClientSecret('bEvPIqZtU_oRJLopTSdAGh6n');
	//$client->setDeveloperKey("AIzaSyAjiSBCbYLC1iXY5Q2LJaOD1CM8MURhazE");
	//$client->setApprovalPrompt('consent');
    $client->setAccessType('offline');
	//$client->setIncludeGrantedScopes(true);
	$client->setRedirectUri('http://kts.kaivalyatech.com/arindra-test/google-api-php-client-2.2.1/oauth2callback.php');
	
	/*// Call set_include_path() as needed to point to your client library.
	set_include_path(get_include_path() . PATH_SEPARATOR . '/var/www/websites/arindra-test/GoogleDrive/google-api-php-client/src/Google');
	require_once __DIR__ . '/google-api-php-client/vendor/autoload.php';
	require_once __DIR__ . '/google-api-php-client/src/Google/Client.php';
	//require_once 'Google/Model.php';
	//require_once 'Google/Service.php';
	//require_once 'Google/Collection.php';
	//require_once 'Google/Service/Resource.php';
	require_once __DIR__ . '/google-api-php-client/src/Google/Service/Drive.php';
	$OAUTH2_CLIENT_ID = '793800951067-nbhl0huheiofo57pskmo9kjmn3hv9qus.apps.googleusercontent.com';
	$OAUTH2_CLIENT_SECRET = 'bEvPIqZtU_oRJLopTSdAGh6n';

	$client = new Google_Client();
	$client->setClientId($OAUTH2_CLIENT_ID);
	$client->setClientSecret($OAUTH2_CLIENT_SECRET);
	$client->setScopes('https://www.googleapis.com/auth/drive');
	//$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
	$redirect = "http://kts.kaivalyatech.com/arindra-test/GoogleDrive/";
	$client->setRedirectUri($redirect);*/

    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory('credentials.json');
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path)
{
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
if (!class_exists('Google_Client')) {
  require_once __DIR__ . '/vendor/autoload.php';
}


$client = getClient();
$service = new Google_Service_Drive($client);

// Print the names and IDs for up to 10 files.
$optParams = array(
  'pageSize' => 10,
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
?>