<?php
	session_start();
	if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in'] == true)) {
		header('Location: user_content.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>VERY FAST TRAINS !</title>
		<link rel = "stylesheet" href = "stylesheet_css.css">
		<link rel = "shortcut icon" type = "image/x-icon" href = "img/trains_1.png">
	</head>
	<body>
		<header class = "main_header">
			<div class = "left">
				<img src = "img/trains_1.png" style = "margin-right: 0.5em;">
				<h1><a href = "index.php">Very fast trains</a></h1>
			</div>
			<div class = "right">
				<a href = "log.php" id = "current">Log in</a>
			</div>
		</header>
		<div class = "main">
			<nav class = "main_nav">
				<li><a href = "index.php">Home</a></li>
				<li><a href = "schedules.php">Schedules</a></li>
				<li><a href = "ticket.php">Buy a ticket</a></li>
				<li><a href = "map.php">Map</a></li>
				<li><a href = "contact.php">Contact</a></li>
				<li><a href = "authors.php">About authors</a></li>
			</nav>
			<section class = "main_section">
				<h2>Log in</h2>
				<form action="log_in.php" method="post" id = "log_form">
					<div class = "row">
						<label>Login</label>
						<input type="text" name="login"><br>
					</div>
					<div class = "row">
						<label>Password</label>
						<input type="password" name="pass"><br>
					</div>
					<div class = "row">
						<input type="submit" value="Log in!" class = "log_button">
					</div>
					<div class = "row">
						<div class = "reg_button"><a href = "registration.php">Don't have an account? Register!</a></div>	
					</div>
				</form>
				<br>
				<?php
					if (isset($_SESSION['error_log'])) {
						echo '<div class = "error_tmp">';
						echo $_SESSION['error_log'];
						echo '</div>';
						unset($_SESSION['error_log']);
					}
				?>
			</section>
		</div>
	</body>
</html>
