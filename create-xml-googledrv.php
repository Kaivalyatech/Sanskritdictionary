<?php
$htmlBody = '';
$xmlroot;
$xml;
$DriveDetails = array();
$searchResponse;
session_start();
drive_search('');
function drive_search($next_page_token='',$Col=0){
// Call set_include_path() as needed to point to your client library.
/*set_include_path(get_include_path() . PATH_SEPARATOR . '/media/arindra/webdata/websites/saa.bootstrap.local/google-api/google-api-php-client/src/Google');
require_once 'google-api-php-client/vendor/autoload.php';
require_once 'google-api-php-client/src/Google/Client.php';
require_once 'google-api-php-client/src/Google/Service/YouTube.php';*/

require_once __DIR__.'/vendor/autoload.php';
global $DriveDetails;
echo "here";
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
$client->setRedirectUri('http://kts.kaivalyatech.com/arindra-test/google-api-php-client-2.2.1/oauth2callback.php');
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
//echo "sessiontoken=".$client->getAccessToken();
global $htmlBody;
//$playlistId = 'PLGA8Lv0hEqzEiF-xVD-CxOV7fDbcGUese';
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
      $params = array(
            'pageSize'=>50,
			'fields' => 'files(id, name)'
        );
      if(!empty($next_page_token)){
            $params['pageToken'] = $next_page_token;
        }
      //echo $next_page_token;
      //$searchResponse = $youtube->playlistItems->listPlaylistItems('id,snippet,contentDetails', $params);
	  $searchResponse = $service->files->listFiles($params);
      //$htmlBody .= $params;foreach ($results->getFiles() as $file) {
      foreach ($searchResponse->getFiles() as $searchResult) {
        /*$VideoDetails[$Col][0]=$searchResult['snippet']['title'];
        $VideoDetails[$Col][1]=$searchResult['snippet']['resourceId']['videoId'];
        $VideoDetails[$Col][2]=$searchResult['snippet']['thumbnails']['high']['url'];*/
		$DriveDetails[$Col][0]=$searchResult->getId();
        $DriveDetails[$Col][1]=$searchResult->getName();
		//$htmlBody .="ID::".$searchResult->getId()."     "."NAME::".$searchResult->getName().'<br>';
        echo "id=".$DriveDetails[$Col][0].'<br>';
        echo "name=".$DriveDetails[$Col][1].'<br>';
        //echo "VideoThumb=".$VideoDetails[$Col][2].'<br>';
        $Col++;
        //$htmlBody .= sprintf('<li>%s (%s)</li>', $searchResult['snippet']['title'],
          //$searchResult['snippet']['resourceId']['videoId']);
      }

      //$htmlBody .= '</ul>';
      //echo $playlistItem['nextPageToken'];
      if(isset($searchResponse['nextPageToken'])){
              // return to our function and loop again
            return drive_search($searchResponse['nextPageToken'],$Col);
      }
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
	echo "no access token";
  
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();

  $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
}

function createPath($thumbfolderpath) {
	echo "folderpath=".$thumbfolderpath;
	if(!mkdir($thumbfolderpath, 0777, true)){
	    echo "<br/><br/>ERROR: Fail to create the folder...<br/><br/>"; 
	}  else echo "<br/><br/>!! Folder Created...<br/><br/>";

       chmod($thumbfolderpath, 0777);
}




?>


<?php
	//drive_search('');
	//include "../function.php";
	//echo $htmlBody;
	$rootpath="/var/www/websites/arindra-test/google-api-php-client-2.2.1";
    echo "rootpath=  ".$rootpath;
	//$servername="http://".$_SERVER['SERVER_NAME']; 
	//$root=$rootpath."/arindra-test/google-api-php-client-2.2.1";
	//global $DriveDetails;
	global $xml;
	global $xmlroot;
	//global $htmlBody;
	$xml = new DOMDocument("1.0");
     	//$xml = simplexml_load_file($rootpath."/XMLData/video/interviews_with_disciples_and_devotees.xml");
	$xmlroot = $xml->createElement("drivecontent");
	$xml->appendChild($xmlroot);
	//myScanDir($root); 
	$Count = count($DriveDetails);
	$idn="";
	$name="";

	//$path_parts = pathinfo($path."/".$entry); 
	//$navigateurl="";
	//$thumburl='';
	//echo "htmlbody=".$htmlBody;
	echo "Total files=".$Count;
	for ($x = 0; $x < $Count; $x++) {
		//echo "Title=".$VideoDetails[$x][0].'<br>';
		//echo "VideoId=".$VideoDetails[$x][1].'<br>';
		//echo "Thumbnail=".$VideoDetails[$x][2].'<br>';
		//$navigateurl="https://youtu.be/".$VideoDetails[$x][1];
		//$navigateurl="https://www.youtube.com/embed/".$VideoDetails[$x][1];
		//$thumburl=$VideoDetails[$x][2];
		//   echo "video url=".$navigateurl."<br>";
		//     echo "asmpos=".strpos($navigateurl,"asm"). "savitripos".strpos(strtolower($navigateurl),"savitri");
		//echo $navigateurl."<br>";
		$idn=$DriveDetails[$x][0];
		$name=$DriveDetails[$x][1];
		
		$drive = $xml->createElement("drive");
		$id   = $xml->createElement("ID");
		$idText = $xml->createTextNode($idn);
		$id->appendChild($idText);

		$name   = $xml->createElement("Name");
		$nameText = $xml->createTextNode($name);
		$name->appendChild($nameText);

		$drive->appendChild($id);
		$drive->appendChild($name);

		$xmlroot->appendChild($drive); 
	}
		   //echo "</ul>";
		   //echo "</div>";
		   $xml->formatOutput = true;
		  // echo "<xmp>". $GLOBALS['xml']->saveXML() ."</xmp>";
		  if (!is_dir($rootpath."/XMLData/drive")) {
		         echo "coming here";
			 createPath($rootpath."/XMLData/drive");

		  }
		 
	     //}
			      
	//}
	$xml->save($rootpath."/XMLData/drive/drive-content.xml") or die("Error");
   

  //}
?>
  


