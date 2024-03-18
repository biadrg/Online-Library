

<?php

function emptyInputSignup($lastname, $givenname, $username, $email, $adr, $adrno, $city, $county, $phonenumber, $pwd) {
	$results;
	if(empty($lastname) || empty($givenname) || empty($username) || empty($email) || empty($adr) || empty($adrno) || empty($city) || empty($county) || empty($phonenumber) || empty($pwd)){
		$result = true;
	}
	else{
		$result = false;
	}
	return $result;
 }

 function invalidUid($username) {
	$results;
	if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
		$result = true;
	}
	else{
		$result = false;
	}
	return $result;
 }

  function invalidEmail($email) {
	$results;
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$result = true;
	}
	else{
		$result = false;
	}
	return $result;
 }


 function uidExists($conn, $username) {
	$sql = "SELECT * FROM utilizatori WHERE nume_de_utilizator = ?;";
 	$stmt = mysqli_stmt_init($conn);
 	if(!mysqli_stmt_prepare($stmt, $sql)){
 		header("location: ../signup.php?error=stmtfailed");
	exit();
 	}

 	mysqli_stmt_bind_param($stmt, "s", $username);
 	mysqli_stmt_execute($stmt);

 	$resultData = mysqli_stmt_get_result($stmt);

 	if($row = mysqli_fetch_assoc($resultData)){
 			return $row;
 	}
 	else{
 		$result = false;
 		return $result;
 	}

 	mysqli_stmt_close($stmt);

 }

function createUser($conn, $lastname, $givenname, $username, $email, $adr, $adrno, $city, $county, $phonenumber, $pwd) {
	$sql = "INSERT INTO utilizatori (nume, prenume, nume_de_utilizator, email, adresa, numar_adresa, oras, judet, numar_telefon, parola) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
 	$stmt = mysqli_stmt_init($conn);
 	if(!mysqli_stmt_prepare($stmt, $sql)){
 		header("location: ../signup.php?error=stmtfailed");
	exit();
 	}

 	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

 	mysqli_stmt_bind_param($stmt, "ssssssssss", $lastname, $givenname, $username, $email, $adr, $adrno, $city, $county, $phonenumber, $hashedPwd);
 	mysqli_stmt_execute($stmt);
 	mysqli_stmt_close($stmt);
 	header("location: ../signup.php?error=none");
 	exit();
 }

function emptyInputLogin($username, $pwd) {
	$results;
	if(empty($username) || empty($pwd)){
		$result = true;
	}
	else{
		$result = false;
	}
	return $result;
 }

function loginUser($conn, $username, $pwd) {
	$uidExists = uidExists($conn, $username);

	if ($uidExists === false) {
		header("location: ../login.php?error=wronglogin");
		exit();
	}

	$pwdHashed = $uidExists["parola"];
	$checkPwd = password_verify($pwd, $pwdHashed);

	if ($checkPwd === false) {
		header("location: ../login.php?error=wronglogin");
		exit();
	}
	else if($checkPwd === true) {
		session_start();
		$_SESSION["utilizator_id"] = $uidExists["utilizator_id"];
		$_SESSION["nume_de_utilizator"] = $uidExists["nume_de_utilizator"];
		header("location: ../welcome.php");
		exit();
	}
}

function changePassword($conn, $userId, $oldPwd, $newPwd) {
    // Fetch the current hashed password from the database
    $sql = "SELECT parola FROM utilizatori WHERE utilizator_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultData);

    // Verify old password
    $pwdCheck = password_verify($oldPwd, $row['parola']);
    if ($pwdCheck == false) {
        header("location: ../profile.php?error=wrongpassword");
        exit();
    } else {
        // Update with the new password
        $sql = "UPDATE utilizatori SET parola = ? WHERE utilizator_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }

        $hashedNewPwd = password_hash($newPwd, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "si", $hashedNewPwd, $userId);
        mysqli_stmt_execute($stmt);
        header("location: ../profile.php?error=none");
        exit();
    }
}


function bookExists($conn, $title, $author)
{
$sql = "SELECT * FROM carti WHERE titlu = ? AND autor = ?;";
 	$stmt = mysqli_stmt_init($conn);
 	if(!mysqli_stmt_prepare($stmt, $sql)){
 		header("location: ../addbooks.php?error=stmtfailed");
	exit();
 	}

 	mysqli_stmt_bind_param($stmt, "ss", $title, $author);
 	mysqli_stmt_execute($stmt);

 	$resultData = mysqli_stmt_get_result($stmt);

 	if($row = mysqli_fetch_assoc($resultData)){
 			return $row;
 	}
 	else{
 		$result = false;
 		return $result;
 	}

 	mysqli_stmt_close($stmt);

}


function emptyComment($comentariu)
{
$results;
	if(empty($comentariu)){
		$result = true;
	}
	else{
		$result = false;
	}
	return $result;
}

function createComment($conn, $book, $user, $date, $stars, $com){
	$sql = "INSERT INTO recenzii (carte_id, utilizator_id, data_recenzie, nota_recenzie, comentariu) VALUES (?, ?, ?, ?, ?);";
 	$stmt = mysqli_stmt_init($conn);
 	if(!mysqli_stmt_prepare($stmt, $sql)){
 		header("location: ../biblioteca.php?error=stmtfailed");
	exit();
 	} 

 	mysqli_stmt_bind_param($stmt, "iisss", $book, $user, $date, $stars, $com);
 	mysqli_stmt_execute($stmt);
 	mysqli_stmt_close($stmt);
 	session_start();
 	// header("location: ../". $_SESSION['goback']);
	header("location: ../carte.php?carte=$book");
 	exit();
}
