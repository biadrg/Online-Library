<?php
session_start();
if (isset($_POST["submit"])) {
    // First, ensure the user is logged in
    if (!isset($_SESSION['utilizator_id'])) {
        header("location: ../welcome.php");
        exit();
    }

    $user = $_SESSION['utilizator_id'];
    $book = $_SESSION['carte_id'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

	$purchase_check_query = "
		SELECT * FROM comenzi_detalii cd
		WHERE cd.carte_id = ? AND cd.comanda_id IN (
			SELECT comanda_id FROM comenzi
			WHERE utilizator_id = ?
		);
	";

    $stmt = $conn->prepare($purchase_check_query);
    $stmt->bind_param("ii", $book, $user);
    $stmt->execute();
    $purchase_result = $stmt->get_result();

    if($purchase_result->num_rows == 0) {
        // If the user hasn't purchased the book, redirect and exit the script
        header("location: ../carte.php?carte=" . $book . "&error=notpurchased");
        exit();
    }

    // Continue with comment creation if the book was purchased
    $date = date("Y-m-d");
    $stars = $_POST['nota_recenzie'];
    $com = $_POST['comentariu'];

    if (emptyComment($com) !== false) {
        header("location: ../biblioteca.php?error=emptycomment");
        exit();
    }

    createComment($conn, $book, $user, $date, $stars, $com);
    header("location: ../carte.php?carte=" . $book . "&comment=success");
    exit();

} else {
    header("location: ../index.php");
    exit();
}
?>
