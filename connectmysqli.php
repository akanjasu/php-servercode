<?php
//connecting using mysqli
$mysqli = mysqli_connect("sql201.byethost5.com", "b5_12829947","xZ9tWnEm","b5_12829947_1");
if (mysqli_connect_errno($mysqli)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit;
}
mysqli_autocommit($link, FALSE);
?>