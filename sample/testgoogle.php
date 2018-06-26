<?php
include 'conn.php';	
$From=$_GET['From'];
$Value=$_GET['Value'];
//$client=$_GET['client'];
//$service=$_GET['service'];

if($From=="displaybook"){
	echo "Value--".$Value."<br>";
	/*echo "client--";
	$x=(array) $client;
	var_dump($x);
	$newclient=json_decode($client,true);
	print_r($newclient);
	echo "<br>";
	echo "service--".$service."<br>";*/
	
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
			//'q' => "fullText contains 'ae' and '0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents",
			//'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and (fullText contains 'se' or name contains 'se')",
			'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and fullText contains '".$Value."'",
			//'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and (fullText contains '".$Value."' or name contains '".$Value."')",
			'spaces' => 'drive',
			'pageToken' => $pageToken,
			'fields' => 'nextPageToken, files(*)',
		));
		
		foreach ($response->files as $file) {
		   printf("Found file: %s (%s) |%s| @%s@\n", $file->name, $file->id, $file->hasThumbnail, $file->thumbnailLink);
		  // echo "the first one is";
		  // print_r($file);
		   //echo "<br>";
		   //$file = $service->files->get($file->id);
		   $file = $service->files->get($file->id);
		  // print_r($file);
		 //  echo "<br><br>";
		  // $c=downloadFile($service, $file);
		   echo '<img src="https://drive.google.com/thumbnail?id='.$file->id.'" onclick='.'"alert(\'1\');onclick=OpenFile(\''.$file->id.'\');"'.' />';
		   /*echo '<iframe src="https://docs.google.com/viewer?srcid='.
				$file->id.'&pid=explorer&efh=false&a=v&chrome=false&embedded=true" width="580px" height="480px"></iframe>';*/
			//print_r($c);
			//break;
		}
		

		$pageToken = $repsonse->pageToken;
	} while ($pageToken != null);
	
}

?>
