<?php
require_once 'includes/dbh.inc.php';
$carte_id = $_SESSION['carte_id'];

$query = "SELECT * from recenzii where carte_id = '$carte_id'";

$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0)if(mysqli_num_rows($result)>0)

{
?>


<table align="center" cellpadding="5" cellspacing="5">

<tr>
<th> Utilizator </th>
<th> Data </th>
<th> Nota </th>
<th> Comentariu </th>

</tr>

<?php while($row = mysqli_fetch_assoc($result))
{
?>
<tr>
	<td>

	<?php
	$uaux = $row["utilizator_id"];
	$query3 = "SELECT nume_de_utilizator from utilizatori where utilizator_id = '$uaux';";
	$result3 = mysqli_query($conn, $query3);
	$row3 = mysqli_fetch_assoc($result3);
	echo $row3['nume_de_utilizator'];
	?>

	</td>
<td><?php echo $row["data_recenzie"];?> </td>
<td><?php echo $row["nota_recenzie"];?> </td>
<td><?php echo $row["comentariu"];?> </td>
</tr>


<?php
}
}
else
echo "<center>Nu exista comentarii</center>" ;
?>
</table>
