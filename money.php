<?php
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: log.php');
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
				<a href = "log.php">Log in</a>
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
				<h2>Add Money</h2>
				<form method = "post" action = "add_money.php" id = "money_form">
					<div class = "main_form">
						<label>How much ?</label>
						<input type = "text" name = "money"><br>
					</div>
					<input type = "submit" value = "Add money!">
				</form>
				<?php
					if(isset($_SESSION['error_log_money'])) {
						echo '<div class = "error_tmp">';
						echo $_SESSION['error_log_money'];
						echo '</div>';
						unset($_SESSION['error_log_money']);
					}
				?>
			</section>
		</div>
	</body>
</html>