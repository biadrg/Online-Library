<?php
	include_once 'header2.php';
?>

<script>
function addToCart(carteId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkAndAddToCart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (this.status == 200) {
            alert(this.responseText); // This will display the response from the PHP script
        }
    }
    xhr.send("carte_id=" + carteId);
}
</script>



<section class="main-content">
<div class="grid">
<section class="content">

<div class="book-container">
<?php
include_once ("includes/dbh.inc.php");
$query = "
    SELECT c.titlu, SUM(cd.cantitate) AS total_quantity
    FROM carti c
    JOIN comenzi_detalii cd ON c.carte_id = cd.carte_id
    GROUP BY c.carte_id
    ORDER BY total_quantity DESC;
";
$result = mysqli_query($conn, $query);
echo "Most popular books<br><br>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "Title: " . $row['titlu'] . ", Total Ordered: " . $row['total_quantity'] . "<br>";
}
?>
</div>



<?php
include_once ("includes/dbh.inc.php");
$query = "SELECT carti.*, inventar.cantitate AS available_quantity FROM carti JOIN inventar ON carti.carte_id = inventar.carte_id";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
    // Start a counter for the books
    $bookCount = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        // For every third book, close the previous row and start a new one
        if($bookCount % 2 == 0){
            if($bookCount != 0){
                echo '</div>'; // close the previous book-row if it's not the first book
            }
            echo '<div class="book-row">'; // start a new book-row
        }
?>

    <div class="book-container">
        <table align="center" cellpadding="5" cellspacing="5">
            <tr>
                <th colspan="2" class="th-cell">Book Details</th>
            </tr>
            <tr>
                <td class="td-cell">Title</td>
                <td><a style="text-decoration: none;" href="carte.php?carte=<?php echo $row['carte_id']; ?>"><?php echo $row["titlu"]; ?></a></td>
            </tr>
			<tr>
				<td class="td-cell">Author</td>
				<td><?php echo $row["autor"];?></td>
			</tr>
			<tr>
				<td class="td-cell">Publisher</td>
				<td><?php echo $row["editura"];?></td>
			</tr>
			<tr>
				<td class="td-cell">Price</td>
				<td><?php echo $row["pret_carte"];?></td>
			</tr>
			<tr>
				<td class="td-cell">Year</td>
				<td><?php echo $row["an_publicare"];?></td>
			</tr>
			<tr>
				<td class="td-cell">Pages</td>
				<td><?php echo $row["numar_pagini"];?></td>
			</tr>
			<tr>
				<td class="td-cell">Category</td>
				<td><?php echo $row["domeniu_categorie"];?></td>
			</tr>
			<tr>
				<td class="td-cell">Description</td>
				<td><?php echo $row["descriere"];?></td>
			</tr>
			<tr>
				<td class="td-cell">Quantity Available</td>
    			<td><?php echo $row["available_quantity"]; ?></td>
			</tr>
			<tr>
				<td colspan="2"><button onclick="addToCart(<?php echo $row['carte_id']; ?>)">Add to Cart</button></td>
			</tr>
        </table>
    </div>

<?php
        $bookCount++; // Increment the book counter
    }
    echo '</div>'; // close the last book-row
}
else
{
    echo "<div class='err'><center>No books found in the library.</center></div>";
}
?>

</section>
</div>
</section>

<?php
	include_once 'footer.php';
?>