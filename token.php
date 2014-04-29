<?php
//Checks for the validity of the token sent by the client
require_once 'errorfunction.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['starttoken']) && isset($_POST['U_ID'])) {
		require_once 'connectmysqli.php';
		$tokenquery = "SELECT `token` FROM `UserTable` WHERE U_ID = " . intval($_POST['U_ID']) .";";
		$result = mysqli_query($mysqli, $tokenquery);
		if(!$result)
			require 'errorstatus.php';
		$resultarray = mysqli_fetch_assoc($result);
		if($resultarray["token"] != $_POST['token']) {
			include 'xmlheader.php';
			echo '<error><message>Unautheticated Request</message></error>';
			mysqli_free_result($result);
			require 'disconnect.php';
		}
	} else {
		include 'xmlheader.php';
		echo '<error><message>BAD REQUEST</message></error>';
		exit;
	}
} else {
	include 'xmlheader.php';
	echo '<error><message>BAD REQUEST</message></error>';
	exit;
}

?>
