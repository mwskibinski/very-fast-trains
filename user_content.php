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
				<h2>Your account</h2>
				<?php
					echo '<div id = "user_data">';
					echo '<div class = "row">';
					echo 
					'<div class = "left">Welcome '. $_SESSION['user'] . 
					'! </div><a href = "money.php" >Add money!</a>' . 
					'<a href = "logout.php" >Log out!</a>'; 
					
					echo '</div>';
					echo '<div class = "row">';
					echo '<label>Your E-mail:</label><div class = "data">' . $_SESSION['email'];
					echo '</div></div>';
					
					require_once "connect.php";
		
					$conn = @new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_errno != 0) {
						echo '</div>';
						echo "Couldn't connect to database!<br />";
						echo "Error: " . $conn->connect_error;
					} else {
						$id = $_SESSION['id'];
						
						$result = @$conn->query(
						"select money from users where iduser = $id"
						);
						
						$row = $result->fetch_assoc();
						
						echo '<div class = "row">';
						echo "<label>Your money:</label>" . $row['money'] . " zł";
						echo '</div>';
						echo '</div>';
						
						if (isset($_SESSION['e_money'])) {
							echo '<div class = "error_tmp">' . $_SESSION['e_money'] . '</div>';
							unset($_SESSION['e_money']);
						}
						
						$result = @$conn->query(
						"select namefrom, nameto, timefrom, timeto, dayweek from bought_tickets where iduser = $id"
						);
						
						echo "<p><b>Your tickets:</b></p>";
						
						if ($how_many = $result->num_rows > 0) {
							echo '<div id = "your_tickets">';
							
							echo '<div class = "ticket_labels">';
							echo '<label>From station</label>';
							echo '<label>To station</label>';
							echo '<label>Time of start</label>';
							echo '<label>Time of end</label>';
							echo '<label>Day of week</label>';
							echo '</div>';
							
							while ($row = $result->fetch_assoc()) {
								echo '<div class = "ticket_info">';
								echo '<label>' . $row['namefrom'] . '</label>';
								echo '<label>' . $row['nameto'] . '</label>';
								echo '<label>' . $row['timefrom'] . '</label>';
								echo '<label>' . $row['timeto'] . '</label>';
								echo '<label>' . $row['dayweek'] . '</label>';
								echo '</div>';
							}
							
							echo '</div>';
						} else {
							echo "no tickets";
						}
						
						$conn->close();
					}
				?>
			</section>
		</div>
	</body>
</html>
