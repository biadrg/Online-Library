<?php
	include_once 'header2.php';
?>

<section class="main-content">
	<div class="grid">
		<section class="content">
			<hgroup style="font-size: 20px;">
				<h2>Welcome to GreenBug Library</h2>
				<h3>Bine ai venit, <?php echo $_SESSION["nume_de_utilizator"]."!"?></h3>
			</hgroup>
		</section>
	</div>
</section>

<?php	
	include_once 'footer.php'
?>
