<?php

if (isset($_POST["submit"])) {
	$username = $_POST["nume_de_utilizator"];
	$pwd = $_POST["parola"];

	require_once 'dbh.inc.php';
	require_once 'functions.inc.php';

	if(emptyInputLogin($username, $pwd) !== false) {
		header("location: ../login.php?error=emptyinput");
		exit();
	}

	loginUser($conn, $username, $pwd);
}

else{
	header("location: ../login.php");
	
}