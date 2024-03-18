<?php
	session_start();
?>
<html>
	<head>
		<title>Libraria GreenBug</title>
		<link rel="stylesheet" type="text/css" href="css/auth.css?ts=<?=time()?>">
		<!-- <link rel="stylesheet" type="text/css" href="http://www.example.com/style.css?ts=<?=time()?>" /> -->
	</head>

<body>

<section class = "header">
	<nav>
		<!--cream o noua clasa pentru a-i aplica o serie de modificari in css-->
			<div class = "nav-links">
				<ul>
					<!--linkurile de navigare-->
					<li>
						<?php
							if (isset($_SESSION['utilizator_id'])) {
								// User is logged in
								echo '<a href="welcome.php">GreenBug Library</a>';
							} else {
								// User is not logged in
								echo '<a href="index.php">GreenBug Library</a>';
							}
						?>
					</li>
					<!-- <li>
						<a href="welcome.php">GreenBug Library</a>
					</li> -->
					<li>
						<a href="biblioteca.php">Books</a>
					</li>
					<li>
						<a href="profile.php">Profile</a>
					</li>
					<li>
						<a href="contact.php">Contact</a>
					</li>
					<li>
						<a href="statpage.php">Statistici</a>
					</li>
				</ul>
			</div>
			<form action="displaybooks.php" method="get" class="search-bar">
				<input type="text" name="search" placeholder="Search...">
				<button type="submit">
					<p class="submit-icon">⌕</p>
				</button>
			</form>



			<div class = "nav-links">
				<ul>
					<!--linkurile de navigare-->
					<li>
						<a href="login.php">Log in</a>
					</li>
					<li>
						<a href="signup.php">Register</a>
					</li>
				</ul>
			</div>
	</nav>
</section>

