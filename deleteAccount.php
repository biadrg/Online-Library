<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['utilizator_id'])) {
    require_once 'includes/dbh.inc.php';
    $utilizator_id = $_SESSION['utilizator_id'];

    // SQL to delete user account
    $sql = "DELETE FROM utilizatori WHERE utilizator_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $utilizator_id);
        if(mysqli_stmt_execute($stmt)) {
            // Account deletion successful
            echo "Your account has been deleted.";
        } else {
            // Error occurred
            echo "Error: Unable to delete account.";
        }
    } else {
        echo "SQL statement failed.";
    }

    // Close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Destroy session and redirect to homepage or login page
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}
?>
