<?php
//echo "start<br>";
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Mother';
$dbname = 'dli';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
//echo "after conn<br>";
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else{
	//echo "connected<br>";
}
$dbselect=mysqli_select_db($conn,$dbname) or die("could not select");
/*if ($conn)
	echo "opened<br>";
else
	echo "not ok<br>";

if ($dbselect)
	echo "open<br>";
else
	echo "db issue<br>";*/
?>

