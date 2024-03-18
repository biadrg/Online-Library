<?php
	include_once 'header2.php';
?>


<script>
function removeFromCart(carteId) {
    // Make an AJAX call to your PHP script for removing from the cart
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "removeFromCart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (this.status == 200) {
            alert('Book removed from cart!');
            location.reload(); // Refresh the page to update the cart display
        }
    }
    xhr.send("carte_id=" + carteId);
}
</script>

<section class="main-content">
<div class="grid">
<section class="content">

<?php
	if(!isset($_SESSION["nume_de_utilizator"])) {
		header("location: signup.php?error=notconnected");}
		
	require_once 'includes/dbh.inc.php';
	$nume_de_utilizator = $_SESSION['nume_de_utilizator'];


	$query = "SELECT * from utilizatori where nume_de_utilizator = '$nume_de_utilizator'";
$result = mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)if(mysqli_num_rows($result)>0)

{
?>

<div class="book-container">
	<table  align="center" cellpadding="5" cellspacing="5">
		<tr>
			<th><center>Utilizator</center></th>
		</tr>
			<?php while($row = mysqli_fetch_assoc($result))
			{
				$_SESSION["utilizator_id"] = $row["utilizator_id"];
			?>
		<tr>
			<td><center><?php echo $row["nume_de_utilizator"];?></center></td>
		</tr>
		<tr>
			<button onclick="location.href = 'logout.php'">Deconectare</button>
		</tr>
		<tr>
			<button onclick="confirmAccountDeletion()">Delete Account</button>

			<script>
				function confirmAccountDeletion() {
					var confirmDelete = confirm("Are you sure you want to delete your account? This action cannot be undone.");
					if (confirmDelete) {
						window.location.href = "deleteAccount.php"; // Redirect to delete account script
					}
				}
			</script>
		</tr>
	</table>
</div>




<div class="book-container">
	<form action="includes/passwordChange.inc.php" method="post">
		<input type="password" name="oldPwd" placeholder="Old Password">
		<input type="password" name="newPwd" placeholder="New Password">
		<button type="submit" name="changePwdSubmit">Change Password</button>
	</form>
</div>

<?php
}}
?>


<div class="book-container">
	<?php if(isset($result) && mysqli_num_rows($result) > 0): ?>
	<table align="center" cellpadding="5" cellspacing="5">
		<tr>
		<th colspan="10" class="th-cell"><center>Order Details</center></th>
		</tr>
		<tr>
			<td class="td-cell">ID</td>
			<td class="td-cell">Cantitate</td>
			<td class="td-cell">Carte</td>
			<td class="td-cell">Pret carte</td>
			<td class="td-cell">Total</td>
			<td class="td-cell">Status</td>
			<td class="td-cell">Data</td>
			<td colspan="2" class="td-cell"><center>Adresa</center></td>
			<!-- <td class="td-cell">Delivery Number</td> -->
			<td class="td-cell">Oras</td>
			<td class="td-cell">Judet</td>
		</tr>
		<?php
		require_once 'includes/dbh.inc.php'; // Database connection file

		// Check if the user is logged in and has a session variable for user_id
		if(isset($_SESSION['utilizator_id'])) {
			$utilizator_id = $_SESSION['utilizator_id'];

			// SQL to fetch orders for the logged-in user
			$sql = "SELECT 
						comenzi.comanda_id, comenzi.data, comenzi.total_de_achitat,
						comenzi_detalii.status_comanda, comenzi_detalii.carte_id, comenzi_detalii.cantitate,
						comenzi_detalii.pret_carte, comenzi_detalii.adresa_de_livrare, comenzi_detalii.numar_adresa_de_librare,
						comenzi_detalii.oras_de_livrare, comenzi_detalii.judet_de_livrare,
						carti.titlu
					FROM comenzi
					JOIN comenzi_detalii ON comenzi.comanda_id = comenzi_detalii.comanda_id
					JOIN carti ON comenzi_detalii.carte_id = carti.carte_id
					WHERE comenzi.utilizator_id = ?
					ORDER BY comenzi.data DESC";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "SQL error";
			} else {
				mysqli_stmt_bind_param($stmt, "i", $utilizator_id);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				
				// Now you can fetch the rows and output them within your HTML
			}
		} else {
			echo "User is not logged in.";
			// Redirect to login page or display an error
		}
		?>
		<?php while($row = mysqli_fetch_assoc($result)): ?>
		<tr>
			<td class="td-cell"><?php echo $row['comanda_id'];?></td>
			<td class="td-cell"><?php echo $row['cantitate'];?></td>
			<td class="td-cell"><?php echo $row['titlu'];?></td>
			<td class="td-cell"><?php echo $row['pret_carte'];?></td>
			<td class="td-cell"><?php echo $row['total_de_achitat'];?></td>
			<td class="td-cell"><?php echo $row['status_comanda'];?></td>
			<td class="td-cell"><?php echo $row['data'];?></td>
			<td class="td-cell"><?php echo $row['adresa_de_livrare'];?></td>
			<td class="td-cell"><?php echo $row['numar_adresa_de_librare'];?></td>
			<td class="td-cell"><?php echo $row['oras_de_livrare'];?></td>
			<td class="td-cell"><?php echo $row['judet_de_livrare'];?></td>
		</tr>
		<?php endwhile; ?>
	</table>
	<?php else: ?>
	<p>No orders found.</p>
	<?php endif; ?>
</div>


<div class="book-container">
    <table align="center" cellpadding="5" cellspacing="5">
        <tr>
            <th colspan="10" class="th-cell"><center>Shopping Cart</center></th>
        </tr>
        <tr>
            <td class="td-cell">Carte</td>
            <td class="td-cell">Cantitate</td>
            <td class="td-cell">Pret</td>
            <td class="td-cell">Total</td>
            <td class="td-cell"></td>
        </tr>
        <?php
            $stmt = $conn->prepare("SELECT cart.*, carti.titlu, carti.pret_carte FROM cart JOIN carti ON cart.carte_id = carti.carte_id WHERE utilizator_id = ?");
            $stmt->bind_param("i", $utilizator_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='td-cell'>" . htmlspecialchars($row['titlu']) . "</td>";
                    echo "<td class='td-cell'>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td class='td-cell'>" . htmlspecialchars($row['pret_carte']) . "</td>";
                    echo "<td class='td-cell'>" . htmlspecialchars($row['quantity'] * $row['pret_carte']) . "</td>";
                    echo "<td class='td-cell'><button onclick='removeFromCart(" . $row['carte_id'] . ")'>Remove</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='td-cell'>Your cart is empty.</td></tr>";
            }
        ?>
    </table>
</div>



</section>
</div>
</section>
</body>
</html>






