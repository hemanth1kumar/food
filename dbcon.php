<?php
	#session_start();
	$username = "root";
	$password = "hem@1234";
	$server = "localhost";
	$dbname = "food";
	//$conn = new mysqli($server,$username,$password);
	//$conn = mysqli_connect($server, $username, $password);
	$conn = mysqli_connect($server,$username,$password,$dbname);
	if(!$conn) {
		die("connection failed" . mysqli_connect_error());
	}
	else {
		#echo "yo";
		return true;

	}
?>