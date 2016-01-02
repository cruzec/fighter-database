<?php
	
session_start();
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "cruze-db", $mypassword, "cruze-db");
if($mysqli->connect_errno) {
	echo "<h3>Error</h3>";
	echo "<p>Could not connect to database</p>";
}

?>