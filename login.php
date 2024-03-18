<?php
	include_once 'header2.php';
?>


	<!-- <section class="login-form">
		<h2 style="color:black;">Autentificare</h2>
		<form action="includes/login.inc.php" method="post">
			<input type="text" name="uid" placeholder="Utilizator/Email...">
			<input type="password" name="pwd" placeholder="Parola...">
			<button type="submit" name="submit" style="position:relative;margin-top:10px; ">Autentificare</button>
		<a href="signup.php">Sau da click aici pentru <span id="sau">Inregistrare</span></a>
		</form>

		
	</section> -->


<section class="main-content">
	<div class="grid">
		<section class="content">
			<hgroup>
				<h2>Welcome to GreenBug Library</h2>
				<h3>Login to proceed</h3>
			</hgroup>
			<section class="login">
				<form action="includes/login.inc.php" method="post">
					<label for="nume_de_utilizator">Username:</label>
					<input type="text" id="nume_de_utilizator" name="nume_de_utilizator" required><br>
					<label for="parola">Password:</label>
					<input type="password" id="parola" name="parola" required><br>		
					<button type="submit" name="submit">Login</button>
				</form>

					
<?php  
	if (isset($_GET["error"])) {
		if($_GET["error"] == "emptyinput"){
			echo "<p class='err'>Completează toate câmpurile!</p>";
		}
		else if ($_GET["error"] == "wronglogin") {
			echo "<p class='err'>Date de autentificare incorecte!</p>";
		}
	}
?>					
			

			</section>
		</section>
	</div>
</section>





<?php
	include_once 'footer.php';
?>