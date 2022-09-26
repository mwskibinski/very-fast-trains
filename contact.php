<?php
	session_start();
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
				<li><a href = "contact.php" id = "current">Contact</a></li>
				<li><a href = "authors.php">About authors</a></li>
			</nav>
			<section class = "main_section">
				<h2>Contact</h2>
				<p>Give us feedback!</p>
				<form action = "comment.php" method = "post" id = "com_form">
					<textarea name = "comment" cols = "50" rows = "10"><?php
							if (isset($_SESSION['temp_comment']))
								echo $_SESSION['temp_comment'];
						?></textarea>
					<input type = "submit" value = "Comment!"/>
				</form>
				</br>
				<h2>Comments</h2>
				<?php
					require_once "connect.php";
						
					$conn = new mysqli($servername, $username, $password, $dbname);
							
					if ($conn->connect_error)
						die("Connection failed: " . $conn->connect_error);
					
					$stmt = "select u.nameuser, c.comment, c.date from comments c, users u where c.iduser = u.iduser order by c.date desc";
								
					$result = $conn->query($stmt);
					
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo '<div class = "comment">';
							echo '<div class = "left">';
								echo '<label>' . $row["nameuser"] . '</label>';
								echo '<label>' . $row["date"] . '</label>';
							echo '</div>';
							echo '<div class = "right">';
								echo nl2br($row["comment"]);
							echo '</div>';
							echo '</div>';
						}
					} else
						echo "No comments!";
					
					$conn->close();
				?>
			</section>
		</div>
	</body>
</html>
