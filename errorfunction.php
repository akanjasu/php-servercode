<?php
	function errorfunction($errormsg) {
		require 'xmlheader.php';
		echo '<error><message>' . $errormsg . '</message></error>';
		mysqli_rollback($mysqli);
		require 'disconnect.php';
		exit;
	}
?>
