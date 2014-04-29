<?php
	//To be tested
	header("Content-type: text/xml");
	require_once 'token.php';
	if(isset($_POST['Q_ID'])) {
		$query = "SELECT `U_ID` FROM `QuestionTable` WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . "';";
		$result = mysqli_query($mysqli,$query);
		if(!$result)
			require 'errorstatus.php';
		$resultarray = mysqli_fetch_assoc($result);
		if($resultarray['U_ID'] == $_POST['U_ID']) {
			$deletequery = "DELETE FROM `QuestionTable` WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . "' AND U_ID=" . intval($_POST['U_ID']) . ";";
			if(!mysqli_query($mysqli,$deletequery)) 
				errorfunction('Deletion Failed');
			require 'disconnect.php';
		} else {
			errorfunction('Not Authenticated');
		}
	} else {
		errorfunction('Bad Request');	
	}
?>