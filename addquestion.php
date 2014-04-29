<?php
header("Content-type: text/xml");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['token']) && isset($_POST['U_ID'])) {
		require_once 'connectmysqli.php';
		$tokenquery = "SELECT `token` FROM `UserTable` WHERE U_ID = " . intval($_POST['U_ID']) .";";
		$result = mysqli_query($mysqli, $tokenquery);
		if(!$result) 
			require 'errorstatus.php';
		$resultarray = mysqli_fetch_assoc($result);
		if($resultarray["token"] == $_POST['token']) {
			if(isset($_POST['question'])) {
				$query = "INSERT INTO `QuestionTable` (`Q_ID`,`U_ID`,`question`) VALUES ('" . mysqli_real_escape_string($mysqli,sha1($_POST['question'])) . "'," . intval($_POST['U_ID']) . ",'" . mysqli_real_escape_string($mysqli,$_POST['question']) . "');";
				if(!mysqli_query($mysqli,$query)) {
					require 'xmlheader.php';
					echo '<error><message>Question already asked</message></error>';
					exit;
				}
				if(isset($_POST['R_ID'])) {
					$query = "UPDATE `QuestionTable` SET R_ID=" . intval($_POST['R_ID']) . " WHERE question='" . mysqli_real_escape_string($mysqli,$_POST['question']) ."' AND U_ID=" . intval($_POST['U_ID']) .";";
					if(!mysqli_query($mysqli,$query))	
						require 'errorstatus.php';
				}
				if(isset($_POST['engword'])) {
					$query = "UPDATE `QuestionTable` SET engword='" . mysqli_real_escape_string($mysqli,$_POST['engword']) . "' WHERE question='" . mysqli_real_escape_string($mysqli,$_POST['question']) ."' AND U_ID=" . intval($_POST['U_ID']) . ";";
					if(!mysqli_query($mysqli,$query))	
						require 'errorstatus.php';
				}	
				if(isset($_POST['kanword'])) {
					$query = "UPDATE `QuestionTable` SET kanword='" . mysqli_real_escape_string($mysqli,$_POST['kanword']) . "' WHERE question='" . mysqli_real_escape_string($mysqli,$_POST['question']) ."' AND U_ID=" . intval($_POST['U_ID']) . ";";
					if(!mysqli_query($mysqli,$query))	
						require 'errorstatus.php';
				}
				include 'xmlheader.php';
				echo '<info><message>question set</message></info>';
			} else {
				include 'xmlheader.php';
				echo '<error><questionblank>Question Blank</questionblank></error>';
				require 'disconnect.php';
				exit;
			}
		} else {
			include 'xmlheader.php';
			echo '<error><message>Unauthenicated Request</message></error>';
			require 'disconnect.php';
			exit;
		}
		mysqli_free_result($result);
		require 'disconnect.php';
	} else {
		include 'xmlheader.php';
		echo '<error><message>Bad Request</message></error>';
		require 'disconnect.php';
		exit;
	} 
} else {
	include 'xmlheader.php';
	echo '<error><message>Bad Request</message></error>';
	exit;
}
?>