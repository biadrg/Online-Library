<?php
if (isset($_POST['changePwdSubmit'])) {
    session_start();
    require 'dbh.inc.php';
    require 'functions.inc.php';

    $oldPwd = $_POST['oldPwd'];
    $newPwd = $_POST['newPwd'];
    $userId = $_SESSION['utilizator_id'];

// Check for empty input
if (empty($oldPwd) || empty($newPwd)) {
    header("location: ../profile.php?error=emptyinput");
    exit();
}

changePassword($conn, $userId, $oldPwd, $newPwd);
} else {
header("location: ../profile.php");
exit();
}
?>