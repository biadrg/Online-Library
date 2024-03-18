<?php
	include_once 'header2.php';
?>

<section class="main-content">
<div class="grid">
<section class="content">

<?php  
	if (isset($_GET["carte"]) !== true) {

		header("location: ../biblioteca.php");
		exit();}
require_once ("includes/dbh.inc.php");
$carte_id = $_GET["carte"];
$_SESSION['goback'] = substr($_SERVER['PHP_SELF'],9) . "?carte=".$carte_id;
$_SESSION['carte_id'] = $carte_id;
$query = "select * from carti where carte_id = '$carte_id'"; 
$result = mysqli_query($conn,$query);
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
			<td class="td-cell">Recenzii</td>
			<td><?php include_once "showcomments.php";	?></td>
		</tr>
		<tr>
        <td class="td-cell">Utilizatori carora le-a placut aceasta carte</td>
            <?php
            // Assuming $conn is your MySQLi database connection
            // Adjust the SQL query to select the username column
            $sql = "SELECT utilizatori.nume_de_utilizator
                    FROM recenzii
                    JOIN utilizatori ON recenzii.utilizator_id = utilizatori.utilizator_id
                    JOIN carti ON recenzii.carte_id = carti.carte_id
                    WHERE carti.carte_id = ?";

            if ($stmt = $conn->prepare($sql)) {
                // Bind the book ID to the query
                $stmt->bind_param("i", $row['carte_id']);

                // Execute the query
                $stmt->execute();

                // Bind the result to a variable
                $stmt->bind_result($nume_de_utilizator);

                // Fetch and display the results
                while ($stmt->fetch()) {
					?>
		<td><?php echo $row["nume_de_utilizator"];?></td>
		<?php
                $stmt->close();
            }
		}
            ?>
        </td>
    </tr>
	</table>
</div>





<div class="book-container">
	<table align="center" cellpadding="5" cellspacing="5">
		<tr>
			<th colspan="2" class="th-cell">Adauga o noua recenzie</th>
		</tr>
		<tr>
			<td class="td-cell">
				<form action="includes/addcomment.inc.php" method="post">
					<div class="review-note">
						<label for="nota_recenzie">Nota recenzie:</label>
						<input type="number" min="1" max="10" id="nota_recenzie" name="nota_recenzie" required>
						<h2>/ 10</h2>
					</div>
					<label for="comentariu">Comentariu:</label>
					<textarea id="comentariu" name="comentariu" rows="4" cols="50"></textarea>	
					<button type="submit" name="submit">Submit</button>
				</form>
			</td>
		</tr>
	</table>
</div>

</section>
</div>
</section>

<?php
}}
?>


<?php
	include_once 'footer.php';
?>