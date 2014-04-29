<?php
//Purpose : Flaging a question with a given Q_ID by a U_ID which has the badge earned (can flag)
//GET/POST: get whether the flag is 'not constructive' or 'locked for answers'
//add a tag to Qtable on that q along with U_ID
require_once 'connectmysqli.php';
$question = $_POST["Q_ID"];
$user = $_POST["U_ID"];
if(isset($_POST["NC"])) {
	$notconstruct = $_POST["NC"];
	//query to flag the question as not constructive
	
} else if(isset($_POST["LK"])) {
	$locked = $_POST["LK"];
	//query to flag the question as locked for answering
}
require_once 'disconnect.php';
?>