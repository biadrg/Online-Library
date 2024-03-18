

    <?php
    require_once ("includes/dbh.inc.php");
    // JOIN SELECT queries
    $joinQueries = [
        "Reviews for Each Book" => "SELECT carti.titlu, carti.autor, recenzii.comentariu FROM carti JOIN recenzii ON carti.carte_id = recenzii.carte_id",
        "User details with orders" => "SELECT utilizatori.nume, utilizatori.prenume, comenzi.data FROM comenzi JOIN utilizatori ON comenzi.utilizator_id = utilizatori.utilizator_id", // User details with orders
        "Books and their inventory quantities" => "SELECT carti.titlu, inventar.cantitate FROM carti JOIN inventar ON carti.carte_id = inventar.carte_id", // Books and their inventory quantities
        "Users and their cart contents" => "SELECT utilizatori.nume, carti.titlu FROM utilizatori JOIN cart ON utilizatori.utilizator_id = cart.utilizator_id JOIN carti ON cart.carte_id = carti.carte_id", // Users and their cart contents
        "Orders with book details" => "SELECT comenzi.data, carti.titlu, carti.autor FROM comenzi JOIN comenzi_detalii ON comenzi.comanda_id = comenzi_detalii.comanda_id JOIN carti ON comenzi_detalii.carte_id = carti.carte_id", // Orders with book details
        "Users who have reviewed a particular book" => "SELECT utilizatori.nume, utilizatori.prenume, carti.titlu FROM recenzii JOIN utilizatori ON recenzii.utilizator_id = utilizatori.utilizator_id JOIN carti ON recenzii.carte_id = carti.carte_id" // Users who have reviewed a particular book
    ];

    // Complex queries (TWO SELECTs)
    $complexQueries = [
        "Users who have placed orders" => "SELECT DISTINCT utilizatori.nume, utilizatori.prenume FROM utilizatori WHERE EXISTS (SELECT 1 FROM comenzi WHERE utilizatori.utilizator_id = comenzi.utilizator_id)", // Users who have placed orders
        "Books in inventory not reviewed" => "SELECT carti.titlu, carti.autor FROM carti WHERE EXISTS (SELECT 1 FROM inventar WHERE carti.carte_id = inventar.carte_id) AND NOT EXISTS (SELECT 1 FROM recenzii WHERE carti.carte_id = recenzii.carte_id)", // Books in inventory not reviewed
        "Books ordered but not in any cart" => "SELECT carti.titlu FROM carti WHERE EXISTS (SELECT 1 FROM comenzi_detalii WHERE carti.carte_id = comenzi_detalii.carte_id) AND NOT EXISTS (SELECT 1 FROM cart WHERE carti.carte_id = cart.carte_id)", // Books ordered but not in any cart
        "Users who have reviewed but not placed orders" => "SELECT utilizatori.nume, utilizatori.prenume FROM utilizatori WHERE EXISTS (SELECT 1 FROM recenzii WHERE utilizatori.utilizator_id = recenzii.utilizator_id) AND NOT EXISTS (SELECT 1 FROM comenzi WHERE utilizatori.utilizator_id = comenzi.utilizator_id)", // Users who have reviewed but not placed orders
        "Users who have reviewed but not placed orders" => "SELECT carti.autor, COUNT(*) AS numar_carti FROM carti JOIN inventar ON carti.carte_id = inventar.carte_id GROUP BY carti.autor HAVING COUNT(*) > 1" // Authors with more than one book in inventory
    ];

    // Execute JOIN SELECT queries
    foreach ($joinQueries as $title => $query) {
        echo "<h2>$title</h2>";
        if ($result = mysqli_query($conn, $query)) {
            echo "<table align='center' cellpadding='10' cellspacing='20'><tr>";
            // Header row
            while ($fieldinfo = mysqli_fetch_field($result)) {
                echo "<th>" . $fieldinfo->name . "</th>";
            }
            echo "</tr>";
    
            // Data rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td>" . htmlspecialchars($item) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table><br>";
        }
    }
    
    // Execute complex queries
    foreach ($complexQueries as $title => $query) {
        echo "<h2>$title</h2>";
        if ($result = mysqli_query($conn, $query)) {
            echo "<table align='center' cellpadding='10' cellspacing='20'><tr>";
    
            // Header row
            while ($fieldinfo = mysqli_fetch_field($result)) {
                echo "<th>" . $fieldinfo->name . "</th>";
            }
            echo "</tr>";
    
            // Data rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td>" . htmlspecialchars($item) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table><br>";
        }
    }
    ?>