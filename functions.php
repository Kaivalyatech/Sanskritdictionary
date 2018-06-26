<?php	
include "conn.php";
$Value=$_GET['Value'];
$WhichField=$_GET['WhichField'];
//echo "Value--".$Value."<br>";
//echo "WhichField--".$WhichField."<br>";
function getClient()
{
	$client = new Google_Client();
	$client->setApplicationName('Google Drive API PHP Quickstart');
	$client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
	$client->setAuthConfig('client_secret.json');
	$client->setAccessType('offline');
	$client->setRedirectUri('http://kts.kaivalyatech.com/arindra-test/google-api-php-client-2.2.1/oauth2callback.php');
	
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
$pageToken = null;

if($WhichField=="author"){
	$keyword="a";
}else if($WhichField=="subject"){
	$keyword="s";
}else if($WhichField=="title"){
	$keyword="t";
}else if($WhichField=="institution"){
	$keyword="i";
}else if($WhichField=="rangefilter"){
	$keyword="d";
}

do {
	if($Value!=""){
		if($keyword){
			$response = $service->files->listFiles(array(
				'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and properties has { key='".$keyword."' and value='".$Value."'}",
				'spaces' => 'drive',
				'pageToken' => $pageToken,
				'fields' => 'nextPageToken, files(id, name)',
			));
		}else{
			$response = $service->files->listFiles(array(
				'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and (fullText contains '".$Value."' or name contains '".$Value."')",
				'spaces' => 'drive',
				'pageToken' => $pageToken,
				'fields' => 'nextPageToken, files(id, name)',
			));
		}
		foreach ($response->files as $file) {
			$sql="SELECT dc_title, dc_contributor_author, google_drive_id FROM books WHERE `google_drive_id` IN ('".$file->id."')";
			$result = mysqli_query($conn,$sql);
			$row=mysqli_fetch_assoc($result);
			
			/*$file_headers = get_headers('https://drive.google.com/thumbnail?id='.$file->id);			
			if ($file_headers[0] == 'HTTP/1.0 404 Not Found') {
				$ImagePath="img/empty.png";
			} else {
				$ImagePath="https://drive.google.com/thumbnail?id=".$file->id;
			}*/
			
			echo '<div class="bookdiv"><img src="https://drive.google.com/thumbnail?id='.$file->id.'" onclick='.'"onclick=OpenFile(\''.$file->id.'\');"'.' /><div class="text">'.$row['dc_contributor_author'].'<br>'.$row['dc_title'].'</div></div>';
		}
		
		if(sizeof($response->files)==0){
			echo "<script>$('#searchresult').css('height','326px');</script>";
			echo "<div class='emptydiv'>No Data Found</div>";		
		}else{
			echo "<script>$('#searchresult').css('height','auto');</script>";
		}
		
		$pageToken = $repsonse->pageToken;
	}else{
		echo "<script>$('#searchresult').css('height','326px');</script>";
	}
} while ($pageToken != null); 
?>
