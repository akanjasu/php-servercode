<?php
	//user himself can edit or a user with answer up points higher that an limit
	//TODO need to update the editU_ID after editing from other
	header("Content-type: text/xml");
	require_once 'token.php';
	if(isset($_POST['Q_ID']) && isset($_POST['U_ID'])) {
		$query = "SELECT `U_ID` FROM `QuestionTable` WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . "';";
		$result = mysqli_query($mysqli,$query);
		if(!$result)
			require 'errorstatus.php';
		$resultarray = mysqli_fetch_assoc($result);
		if(intval($resultarray["U_ID"]) == intval($_POST['U_ID'])) {
			if(isset($_POST['editquestion'])) {
				$editquestionquery = "UPDATE `QuestionTable` SET question='" . mysqli_real_escape_string($mysqli,$_POST['editquestion']) . "' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . ";";
				if(!mysqli_query($mysqli,$editquestionquery))
					require 'errorstatus.php';
			} 
			if (isset($_POST['editkanword'])) {
				$editkanwordquery = "UPDATE `QuestionTable` SET kanword='" . mysqli_real_escape_string($mysqli,$_POST['editkanword']) ."' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) ."';";
				if(!mysqli_query($mysqli,$editkanwordquery))
					require 'errorstatus.php';
			} 
			if (isset($_POST['editengword'])) {
				$editengwordquery = "UPDATE `QuestionTable` SET engword='" . mysqli_real_escape_string($mysqli,$_POST['editengword']) ."' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) ."';";
				if(!mysqli_query($mysqli,$editengwordquery))
					require 'errorstatus.php';
			}
		} else {
			$query = "SELECT `kannada` FROM `UserTable` WHERE U_ID=" . intval($_POST['U_ID']) .";";
			$resultkannada = mysqli_query($mysqli,$query);
			if(!$resultkannada)
				require 'errorstatus.php';
			$resultarray = mysqli_fetch_assoc($resultkannada);
			if(intval($resultarray['kannada']) == 1) {
				$queryknd = "SELECT `aupvotepoints` FROM `KannadaPointsTable` WHERE U_ID=" . intval($_POST['U_ID']) . ";";
				$resultpoints = mysqli_query($mysqli,$queryknd);
				if(!$resultpoints)
					require 'errorstatus.php';
				$resultpointsarray = mysqli_fetch_assoc($resultpoints);
				if(intval($resultpointsarray['aupvotepoints']) >= 50 ) {
					if(isset($_POST['editquestion'])) {
						$editquestionquery = "UPDATE `QuestionTable` SET question='" . mysqli_real_escape_string($mysqli,$_POST['editquestion']) . "' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . "';";
						if(!mysqli_query($mysqli,$editquestionquery))
							require 'errorstatus.php';			
					}
					if (isset($_POST['editkanword'])) {
						$editkanwordquery = "UPDATE `QuestionTable` SET kanword='" . mysqli_real_escape_string($mysqli,$_POST['editkanword']) ."' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) ."';";
						if(!mysqli_query($mysqli,$editkanwordquery))
							require 'errorstatus.php';
					}
					if (isset($_POST['editengword'])) {
						$editengwordquery = "UPDATE `QuestionTable` SET engword='" . mysqli_real_escape_string($mysqli,$_POST['editengword']) ."' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) ."';";
						if(!mysqli_query($mysqli,$editengwordquery))
							require 'errorstatus.php';
					} 
				} else {
					require 'xmlheader.php';
					echo '<error><message>Not allowed to modify</message></error>';
					require 'disconnect.php';
					exit;
				}
				mysqli_free_result($resultpoints);
			} else {
				$queryeng = "SELECT `aupvotepoints` FROM `EnglishPointsTable` WHERE U_ID=" . intval($_POST['U_ID']) . ";";
				$resultpoints = mysqli_query($mysqli,$queryeng);
				if(!$resultpoints)
					require 'errorstatus.php';
				$resultpointsarray = mysqli_fetch_assoc($resultpoints);
				if(intval($resultpointsarray['aupvotepoints']) >= 50 ) {
					if(isset($_POST['editquestion'])) {
						$editquestionquery = "UPDATE `QuestionTable` SET question='" . mysqli_real_escape_string($mysqli,$_POST['editquestion']) . "' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . "';";
						if(!mysqli_query($mysqli,$editquestionquery))
							require 'errorstatus.php';
					}
					if (isset($_POST['editkanword'])) {
						$editkanwordquery = "UPDATE `QuestionTable` SET kanword='" . mysqli_real_escape_string($mysqli,$_POST['editkanword']) ."' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) ."';";
						if(!mysqli_query($mysqli,$editkanwordquery))
							require 'errorstatus.php';
					}
					if (isset($_POST['editengword'])) {
						$editengwordquery = "UPDATE `QuestionTable` SET engword='" . mysqli_real_escape_string($mysqli,$_POST['editengword']) ."' WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) ."';";
						if(!mysqli_query($mysqli,$editengwordquery))
							require 'errorstatus.php';
					}
					mysqli_free_result($resultpoints);	
				} else {
					require 'xmlheader.php';
					echo '<error><message>Not allowed to modify</message></error>';
					require 'disconnect.php';
					exit;
				}
			}
			$queryupdateeditu_id = "UPDATE `QuestionTable` SET editU_ID=" . intval($_POST['U_ID']) . " WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['U_ID']) . "';";
			if(!mysqli_query()) 
			mysqli_free_result($resultkannada);	
		}
	require 'disconnect.php';
	} else {
		require 'xmlheader.php';
		echo '<error><message>Bad request</message></error>';
		require 'disconnect.php';
		exit;
	}
?>
