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
	
    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory('credentials.json');
	//echo "cred-path=".$credentialsPath;
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
	//echo "homedir=".$homeDirectory;
    return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
if (!class_exists('Google_Client')) {
  require_once __DIR__ . '/vendor/autoload.php';
}


$client = getClient();
$service = new Google_Service_Drive($client);

$pageToken = null;



do {
    $response = $service->files->listFiles(array(
        //'q' => "mimeType='image/jpeg'",
		'q' => "fullText contains 'spear'",
        'spaces' => 'drive',
        'pageToken' => $pageToken,
        'fields' => 'nextPageToken, files(*)',
    ));
	
    /*foreach ($response->files as $file) {
        printf("Found file: %s (%s) {%s}\n", $file->name, $file->id, $file->webContentLink);
	}*/
    

    $pageToken = $repsonse->pageToken;
} while ($pageToken != null);

$fileId = '0B7JhzNLs-FQEdVF6eVMtVS1fOGM';
$fileParm = $service->files->get($fileId);
$file_name = $fileParm->getName();
$extension = "";
$mime_type = $fileParm->getmimeType();

echo "filename=".$file_name;
echo "extension=".$extension;
echo "mimetype=".$mime_type;

$getUrl = 'https://drive.google.com/a/vedicsociety.org/uc?id=0B7JhzNLs-FQEMFlnM3J5VDhicms'; //&export=download';


file_put_contents($file_name, fopen($getUrl, 'r'));

?>
<a href="<?php echo $file_name ?>">This is your PDF document</a>
<!--<iframe src="https://drive.google.com/viewerng/viewer?url=http://docs.google.com/fileview?id=1DFy6gOB-U07uJ80yIXg-gP5EWtEg3Ua1mqV4bfyFHtg&hl=en&pid=explorer&efh=false&a=v&chrome=false&embedded=true" frameborder="0"></iframe>

<iframe src="https://docs.google.com/viewer?url=http://docs.google.com/fileview?id=0B5ImRpiNhCfGZDVhMGEyYmUtZTdmMy00YWEyLWEyMTQtN2E2YzM3MDg3MTZh&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>-->

<!--<iframe src="https://docs.google.com/viewer?srcid=0B7JhzNLs-FQETXFPdWZ4X3o5S2M&pid=explorer&efh=false&a=v&chrome=false&embedded=true" width="580px" height="480px"></iframe>-->
