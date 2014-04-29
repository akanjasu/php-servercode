<?php
//request parameters
//1. kannada/english user
//2. username
//3. xp points earned (fixed)
//4. password
//5. email
//6. region
//REVISION - DEBUGGED AND WORKING DO NOT TOUCH! FINAL!
header("Content-type: text/xml");
require_once 'errorfunction.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['starttoken'])) {
		if($_POST['starttoken'] == 'f45e8v23jk5x3p917q106npuwlh94v3zpige9d80') {
			require_once 'connectmysqli.php';
			$token = sha1(mysqli_real_escape_string($mysqli,$_POST['username']) . mysqli_real_escape_string($mysqli,$_POST['password']) . mysqli_real_escape_string($mysqli,$_POST['mail']) . 'f45e8v23jk5x3p917q106npuwlh94v3zpige9d80');
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['regionID']) && isset($_POST['mail']) && isset($_POST['kannada'])) {
				$query = "INSERT INTO `UserTable`(`username`,`password`,`mail`,`R_ID`,`kannada`,`token`) VALUES ('". mysqli_real_escape_string($mysqli,$_POST['username']) . "','" 
								. crypt($_POST['password']) . "','" . mysqli_real_escape_string($mysqli,$_POST['mail']) . "'," . intval($_POST['regionID']) . "," . intval($_POST['kannada']) . ",'" . $token . "');";				
				if(!(mysqli_query($mysqli,$query))) {
					errorfunction('User not created');
				} else {
					//mysqli_commit($mysqli);
					$query1 = "SELECT * FROM `UserTable` WHERE username='" . mysqli_real_escape_string($mysqli,$_POST['username']) ."';";
					$queryresult = mysqli_query($mysqli,$query1); 
					if(!$queryresult) {
						errorfunction('Error Fetching Data');
					}
					$result = mysqli_fetch_assoc($queryresult);
					require 'xmlheader.php';
					echo "<reguserdetails><username>" . $result["username"] . "</username><password>" . $result["password"] . "</password><mail>" . 
							$result["mail"] . "</mail><regionID>" . $result["R_ID"] . "</regionID><userID>"	. $result["U_ID"] . "</userID><kannada>" . $result["kannada"] . "</kannada><token>" . 
							$result["token"] . "</token></reguserdetails>";
					if(intval($_POST['kannada']) == 1) {
						$querypointstable = "INSERT INTO `KannadaPointsTable` (`U_ID`, `R_ID`) VALUES (" . intval($result["U_ID"]) . "," . intval($result["R_ID"]) . ");";
						$querybadgestable = "INSERT INTO `KannadaBadgesTable` (`U_ID`, `R_ID`) VALUES (" . intval($result["U_ID"]) . "," . intval($result["R_ID"]) . ");";
						if(!(mysqli_query($mysqli,$querypointstable)))
							errorfunction('Could not create record in points table');
						if(!(mysqli_query($mysqli,$querybadgestable)))
							errorfunction('Could not create record in badges table');
						if(isset($_POST['phrasedone']) && ($_POST['phrasedone'] == 'true' || $_POST['phrasedone'] == 'TRUE' || $_POST['phrasedone'] == 'True')) {
							$querypointsxptable = "UPDATE `KannadaPointsTable` SET xppoints=5 WHERE U_ID=" . intval($result["U_ID"]) . ";";
							if(!(mysqli_query($mysqli,$querypointsxptable)))
								errorfunction('Could not update xp points');
						}
					} else {
						$querypointstable = "INSERT INTO `EnglishPointsTable` (`U_ID`, `R_ID`) VALUES (" . intval($result["U_ID"]) . "," . intval($result["R_ID"]) . ");";
						$querybadgestable = "INSERT INTO `EnglishBadgesTable` (`U_ID`, `R_ID`) VALUES (" . intval($result["U_ID"]) . "," . intval($result["R_ID"]) . ");";
						if(!(mysqli_query($mysqli,$querypointstable)))
							errorfunction('Could not create record in points table');
						if(!(mysqli_query($mysqli,$querybadgestable)))
							errorfunction('Could not create record in badges table');
						if(isBoolean($_POST['phrasedone'])) {
							$querypointsxptable = "UPDATE `EnglishPointsTable` SET xppoints=2 WHERE U_ID=" . intval($result["U_ID"]) . ";";
							if(!(mysqli_query($mysqli,$querypointsxptable)))
								errorfunction('Could not update xp points');
					}
					mysqli_commit($mysqli);
					mysqli_free_result($queryresult);
				}
				require 'disconnect.php';							 
			}
		} else {
			require 'xmlheader.php';
			echo '<error><message>Bad Request</message></error>';
		}
	} else {
		require 'xmlheader.php';
		echo "<error><message>Unautheticated Request</message></error>";
		require 'disconnect.php';
		exit;
	}
	} else {
		require 'xmlheader.php';
		echo "<error><message>Unautheticated Request</message></error>";
		exit;
	}
} else  {
	require 'xmlheader.php';
	echo "<error><message>Unautheticated Request</message></error>";
	exit;
}		
?>


