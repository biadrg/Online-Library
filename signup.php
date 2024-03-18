<?php
	include_once 'header2.php';
?>


<section class="main-content">
	<div class="grid">
		<section class="content">
			<hgroup>
				<h2>Welcome to GreenBug Library</h2>
				<h3>Create a new account</h3>
			</hgroup>
			<section class="signup">
				<form action="includes/signup.inc.php" method="post">
					<div class="row">
						<div class="column">
							<label for="nume">Last name:</label>
							<input type="text" id="nume" name="nume" required><br><br>
							<label for="prenume">Given name:</label>
							<input type="text" id="prenume" name="prenume" required><br><br>
							<label for="nume_de_utilizator">Username:</label>
							<input type="text" id="nume_de_utilizator" name="nume_de_utilizator" required><br><br>
							<label for="email">Email:</label>
							<input type="text" id="email" name="email" required><br><br>
							<label for="adresa">Home address:</label>
							<input type="text" id="adresa" name="adresa" required><br><br>
						</div>
						<div class="column">
							<label for="numar_adresa">Home address number:</label>
							<input type="text" id="numar_adresa" name="numar_adresa" required><br><br>
							<label for="oras">City:</label>
							<input type="text" id="oras" name="oras" required><br><br>
							<label for="judet">Region:</label>
							<input type="text" id="judet" name="judet" required><br><br>
							<label for="numar_telefon">Phone number:</label>
							<input type="text" id="numar_telefon" name="numar_telefon" required><br><br>
							<label for="parola">Password:</label>
							<input type="password" id="parola" name="parola" required><br><br>
						</div>
					</div>
					<button type="submit" name="submit">Sign up</button>
				</form>

<?php  
	if (isset($_GET["error"])) {
		if($_GET["error"] == "emptyinput"){
			echo "<div class='err'>Completează toate câmpurile!</div>";
		}
		else if ($_GET["error"] == "invaliduid") {
			echo "<div class='err'>Alege un alt nume de utilizator!</div>";
		}
		else if ($_GET["error"] == "invalidemail") {
			echo "<div class='err'>Adresa de email nu este validă!</div>";
		}
		else if ($_GET["error"] == "passwordsdontmatch") {
			echo "<div class='err'>Parolele nu se potrivest. Încearcă din nou!</div>";
		}
		else if ($_GET["error"] == "stmtfailed") {
			echo "<div class='err'>Ceva nu a funcționat!</div>";
		}
		else if ($_GET["error"] == "usertaken") {
			echo "<div class='err'>Numele de utilizator există deja!</div>";
		}
		else if ($_GET["error"] == "none") {

			echo "<div class='ok'>You have registered succesfully. You can log in now.</div>";
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