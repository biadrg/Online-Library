<?php
session_start();
if(isset($_POST['carte_id']) && isset($_SESSION['utilizator_id'])) {
    require_once 'includes/dbh.inc.php';

    $carte_id = $_POST['carte_id'];
    $utilizator_id = $_SESSION['utilizator_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE carte_id = ? AND utilizator_id = ?");
    $stmt->bind_param("ii", $carte_id, $utilizator_id);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        echo "Item removed from cart";
    } else {
        echo "Failed to remove item";
    }
} else {
    echo "Invalid request";
}
?>
