<?php
	session_start();
	
	if (isset($_POST['schedules']))
		$_SESSION['temp_schedules'] = $_POST['schedules'];
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
				<li><a href = "schedules.php" id = "current">Schedules</a></li>
				<li><a href = "ticket.php">Buy a ticket</a></li>
				<li><a href = "map.php">Map</a></li>
				<li><a href = "contact.php">Contact</a></li>
				<li><a href = "authors.php">About authors</a></li>
			</nav>
			<section class = "main_section">
				<h2>Schedules</h2>
				<p>Select route which schedules you want to check</p>
				<?php
					require_once "connect.php";
					
					$conn = new mysqli($servername, $username, $password, $dbname);
						
					if ($conn->connect_error){
						die("Connection failed: " . $conn->connect_error);
					}
					
					$stmt = "select idroute, nameroute from routegeneral";
					$result = $conn->query($stmt);
				
					if ($result->num_rows < 0) {
							echo "No routes<br />";
					} else {
						echo '<form method = "post" id = "schedules_form">';
						echo '<select multiple name = "schedules">';
						
						while ($row = $result->fetch_assoc()) {
							$idroute = $row['idroute'];
							$nameroute = $row['nameroute'];
							
							$nameroute = str_replace("-", " --> ", $nameroute);
						
							echo "<option value = '$idroute' ";
							if (isset($_SESSION['temp_schedules']) && $_SESSION['temp_schedules'] == $idroute) {
								echo 'selected = "selected" id = "selected"';
								unset($_SESSION['temp_schedules']);
							}
							echo " >$nameroute</option>";
						}
						
						echo '</select><br />';
						echo '<div class = "buttons">';
						echo '<input type = "submit" name = "find_schedules" value = "Find schedules"/>';
						echo '<input type = "submit" name = "find_stations" value = "Find stations"/>';
						echo '</div>';
						echo '</form>';
					}
				?>
				<?php
					if (isset($_POST['find_schedules'])) {
						require_once "connect.php";
						
						$conn = new mysqli($servername, $username, $password, $dbname);
						
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
						
						$stmt = $conn->prepare("
								select s.dayweek, s.timestart, s.timeend, rg.nameroute from schedules s, routegeneral rg where s.IdRoute = rg.idRoute AND s.idroute = ? and s.dayweek = ?;
								");
						
						$dayweeks = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
						
						foreach ($dayweeks as $dayweek) {
							$stmt->bind_param("is", $_POST['schedules'], $dayweek);
							$stmt->execute();
							
							$result = $stmt->get_result();
							
							if ($result->num_rows > 0) {
								$row = $result->fetch_assoc();
								
								if ($dayweek == "Monday") {
									echo "<br><br>";
									echo '<div id = "schedules_search">';
									echo '<div class = "row_nameroute">';
									echo "<label><b>Schedules for route</b></label><div>" . $row['nameroute'] . "</div>";
									echo '</div>';
									echo '<div class = "row_labels row">';
									echo '<label>Day of the week</label>';
									echo '<label>Time of start</label>';
									echo '<label>Time of end</label>';
									echo '</div>';
								}
								
								do {
									echo '<div class = "row">';
									echo '<label>' . $row['dayweek'] 	. '</label>';
									echo '<label>' . $row['timestart'] 	. '</label>';
									echo '<label>' . $row['timeend'] 	. '</label>';
									echo '</div>';
								} while ($row = $result->fetch_assoc());
							}
						}
						
						echo '</div>';
						$conn->close();
					} else if(isset($_POST['find_stations'])) {
						require_once "connect.php";
						
						$conn = new mysqli($servername, $username, $password, $dbname);
						
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
						
						$stmt = $conn->prepare("
								select rg.nameroute, s.namestation from routegeneral rg, station s, route r WHERE
								r.IdRoute = rg.idRoute and s.idstation = r.IdStation
								and r.idroute = ?
								order by r.DistanceTraveled
								");
							
						$stmt->bind_param("i", $_POST['schedules']);
						$stmt->execute();
						
						$result = $stmt->get_result();
						
						if ($result->num_rows > 0) {
							$row = $result->fetch_assoc();
							$i = 1;
							
							echo "<br><br>";
							echo '<div id = "stations_search">';
							echo '<div class = "row_nameroute">';
							echo "<label><b>Stations with order kept for route</b></label><div>" . $row['nameroute'] . "</div>";
							echo "</div>";
							
							echo '<div class = "row_labels row">';
							echo '<label>Order</label>';
							echo '<label>Station</label>';
							echo '</div>';
							
							do {
								echo '<div class = "row">';
								echo '<label class = "order_label">';
								echo $i++;
								echo '</label>';
								echo '<label class = "namestation">';
								echo $row['namestation'];
								echo '</label>';
								echo '</div>';
							} while ($row = $result->fetch_assoc());
						}
						
						echo '</div>';
						$conn->close();
						
						
					}
				?>
			</section>
		</div>
	</body>
</html>
