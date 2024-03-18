<?php

if (isset($_POST["submit"])) {
	
	$lastname = $_POST["nume"];
	$givenname = $_POST["prenume"];
	$username = $_POST["nume_de_utilizator"];
	$email = $_POST["email"];
	$adr = $_POST["adresa"];
	$adrno = $_POST["numar_adresa"];
	$city = $_POST["oras"];
	$county = $_POST["judet"];
	$phonenumber = $_POST["numar_telefon"];
	$pwd = $_POST["parola"];

	require_once 'dbh.inc.php';
	require_once 'functions.inc.php';

	if(emptyInputSignup($lastname, $givenname, $username, $email, $adr, $adrno, $city, $county, $phonenumber, $pwd) !== false) {
		header("location: ../signup.php?error=emptyinput");
		exit();
	}

	if(invalidUid($username) !== false) {
		header("location: ../signup.php?error=invaliduid");
		exit();
	}
	if(invalidEmail($email) !== false) {
		header("location: ../signup.php?error=invalidemail");
		exit();
	}
	if(uidExists($conn, $username, $email) !== false) {
		header("location: ../signup.php?error=usertaken");
		exit();
	}

	createUser($conn, $lastname, $givenname, $username, $email, $adr, $adrno, $city, $county, $phonenumber, $pwd);
}

else{
	header("location: ../signup.php");
	exit();
}