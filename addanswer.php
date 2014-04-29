<?php
	//adds answer to a Q_ID and increases the answer count at question table
	header("Content-type: text/xml");
	require_once 'token.php';
	if(isset($_POST['Q_ID']) && isset($_POST['answer'])) {
		$query = "INSERT INTO `AnswerTable` (`A_ID`,`U_ID`,`Q_ID`,`answer`) VALUES ('" . mysqli_real_escape_string($mysqli,sha1($_POST['answer'])) . "'," . intval($_POST['U_ID']) . ",'" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . "','" . mysqli_real_escape_string($mysqli,$_POST['answer']) . "');";
		$result = mysqli_query($mysqli,$query);
		if(!$result)
			errorfunction('Answer not posted');
		if(isset($_POST['R_ID'])) {
			$query1 = "UPDATE `AnswerTable` SET R_ID=" . intval($_POST['R_ID']) . " WHERE Q_ID='" . mysqli_real_escape_string($mysqli,$_POST['Q_ID']) . "' AND U_ID='" . 
		}
			
		
	}
