<?php
session_start();
if(isset($_POST['carte_id'])) {
    if(isset($_SESSION['utilizator_id'])) {
        require_once 'includes/dbh.inc.php';

        $utilizator_id = $_SESSION['utilizator_id'];
        $carte_id = $_POST['carte_id'];

        // Complex query to check both inventory availability and current cart quantity
        $query = "
            SELECT i.cantitate AS inventory_qty, IFNULL(c.quantity, 0) AS cart_qty
            FROM inventar i
            LEFT JOIN (
                SELECT carte_id, quantity
                FROM cart
                WHERE utilizator_id = ? AND carte_id = ?
            ) c ON i.carte_id = c.carte_id
            WHERE i.carte_id = ?;
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $utilizator_id, $carte_id, $carte_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row && $row['inventory_qty'] > $row['cart_qty']) {
            // If book is available and user doesn't have max quantity in cart, add or update cart
            if($row['cart_qty'] == 0) {
                // Book not in cart, insert it
                $insert_stmt = $conn->prepare("INSERT INTO cart (utilizator_id, carte_id, quantity) VALUES (?, ?, 1)");
                $insert_stmt->bind_param("ii", $utilizator_id, $carte_id);
                $insert_stmt->execute();
                echo "Book added to cart";
            } else {
                // Book already in cart, increment quantity
                $newQuantity = $row['cart_qty'] + 1;
                $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE utilizator_id = ? AND carte_id = ?");
                $update_stmt->bind_param("iii", $newQuantity, $utilizator_id, $carte_id);
                $update_stmt->execute();
                echo "Cart updated";
            }
        } else {
            echo "Not enough books in inventory or maximum quantity in cart reached";
        }
    } else {
        echo "User not logged in";
    }
}
?>
