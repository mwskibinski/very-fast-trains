<?php
	session_start();
	
	if (isset($_POST['to']))
		$_SESSION['temp_to'] = $_POST['to'];
	if (isset($_POST['from']))
		$_SESSION['temp_from'] = $_POST['from'];
	if (isset($_POST['dayweek']))
		$_SESSION['temp_dayweek'] = $_POST['dayweek'];
	if (isset($_POST['timestart']))
		$_SESSION['temp_timestart'] = $_POST['timestart'];

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
				<li><a href = "ticket.php" id = "current">Buy a ticket</a></li>
				<li><a href = "map.php">Map</a></li>
				<li><a href = "contact.php">Contact</a></li>
				<li><a href = "authors.php">About authors</a></li>
			</nav>
			<section class = "main_section">
				<h2>Buy a ticket</h2>
				<form action = "" method = "post" id = "ticket_form">
					<div id = "ticket_main">
						<div class = "left">
							<div class = "row">
								<label>From</label>
								<input type = "text" value = "<?php
									if (isset($_SESSION['temp_from']))
										echo $_SESSION['temp_from'];
									?>" name = "from"/><br/>
							</div>
							<div class = "row">
								<label>To</label>
								<input type = "text" value = "<?php
									if (isset($_SESSION['temp_to']))
										echo $_SESSION['temp_to'];
									?>" name = "to"/><br/>
							</div>
							<div class = "row">
								<label>Time</label>
								<input type = "text" value = "<?php
									if (isset($_SESSION['temp_timestart']))
										echo $_SESSION['temp_timestart'];
									?>" name = "timestart"/><br/>
							</div>
						</div>
						<div class = "right">
							<label>Dayweek</label>
							<select multiple name = "dayweek">
								<option value = "Monday" <?php 
								if (isset($_SESSION['temp_dayweek']) && $_SESSION['temp_dayweek'] == "Monday")
									echo 'selected="selected" ';		
								?>>Monday</option>
								<option value = "Tuesday" <?php 
								if (isset($_SESSION['temp_dayweek']) && $_SESSION['temp_dayweek'] == "Tuesday")
									echo 'selected="selected" ';
								?>>Tuesday</option>
								<option value = "Wednesday" <?php 
								if (isset($_SESSION['temp_dayweek']) && $_SESSION['temp_dayweek'] == "Wednesday")
									echo 'selected="selected" ';
								?>>Wednesday</option>
								<option value = "Thursday" <?php 
								if (isset($_SESSION['temp_dayweek']) && $_SESSION['temp_dayweek'] == "Thursday")
									echo 'selected="selected" ';		
								?>>Thursday</option>
								<option value = "Friday" <?php 
								if (isset($_SESSION['temp_dayweek']) && $_SESSION['temp_dayweek'] == "Friday")
									echo 'selected="selected" ';				
								?>>Friday</option>
								<option value = "Saturday" <?php
								if (isset($_SESSION['temp_dayweek']) && $_SESSION['temp_dayweek'] == "Saturday")
									echo 'selected="selected" ';
								?>>Saturday</option>
								<option value = "Sunday" <?php
								if (isset($_SESSION['temp_dayweek']) && $_SESSION['temp_dayweek'] == "Sunday")
									echo 'selected="selected" ';				
								?>>Sunday</option>
							</select></br>
						</div>
					</div>
					<input type = "submit" value = "Find" class = "button">
				</form>
				</br>
				<?php
					if ($_POST) {
							require_once "connect.php";
						
							$conn = new mysqli($servername, $username, $password, $dbname);
							
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}
						
							$valid_data = True;
							$stmt = $conn->prepare("
								select distinct r.IdRoute
								from route r, station s
								where r.Idstation = s.idstation and s.NameStation = ?;
								");
						
							$stmt->bind_param("s", $_POST["from"]);
							$stmt->execute();
							$result = $stmt->get_result();
						
							if ($result->num_rows <= 0) {
								$valid_data = False;
								echo "<div class = \"error_tmp\">No 'from' station!</div>";
							}
							
							$stmt = $conn->prepare("
								select distinct r.IdRoute
								from route r, station s
								where r.Idstation = s.idstation and s.NameStation = ?;
								");
						
							$stmt->bind_param("s", $_POST["to"]);
							$stmt->execute();
							$result = $stmt->get_result();

							if ($result->num_rows <= 0) {
								$valid_data = False;
								echo "<div class = \"error_tmp\">No 'to' station!</div>";
							}
						
							if ($valid_data == False)
								exit();
							
							$stmt = $conn->prepare("
								create temporary table if not exists temp_id_from
								select distinct r.IdRoute
								from route r, station s
								where r.Idstation = s.idstation and s.NameStation = ?;
								");
						
							$stmt->bind_param("s", $_POST["from"]);
							$stmt->execute();
							
							$stmt = $conn->prepare("
								create temporary table if not exists temp_id_to
								select distinct r.IdRoute
								from route r, station s
								where r.Idstation = s.idstation and s.NameStation = ?;
								");
							$stmt->bind_param("s", $_POST["to"]);
							$stmt->execute();
							
							$stmt = "
								create temporary table if not exists temp_route
								select distinct f.idroute from temp_id_from f, temp_id_to t
								where f.idroute = t.idroute;
								";
								
							$conn->query($stmt);
							
							$stmt = $conn->prepare("
								create temporary table if not exists temp_idroutes
								select distinct tr.idroute from temp_route tr where (
								select r.distancetraveled from route r, station s where s.idstation = r.IdStation and s.NameStation = ? and r.IdRoute = tr.idroute
								) <  (
								select r.distancetraveled from route r, station s where s.idstation = r.IdStation and s.NameStation = ? and r.IdRoute = tr.idroute
								)");
							
							$stmt->bind_param("ss", $_POST["from"], $_POST["to"]);
							$stmt->execute();
							
							$stmt = "
								select idroute from temp_idroutes
								";
							
							$result = $conn->query($stmt);
							
							if ($result->num_rows <= 0) {
								$valid_data = False;
								echo "<div class = \"error_tmp\">No such route!</div>";
								exit();
							}
							
							$result = $conn->query($stmt);
							
							$stmt = $conn->prepare("
								set @name_from = ?
								");
							$stmt->bind_param("s", $_POST["from"]);
							$stmt->execute();
							
							$stmt = $conn->prepare("
								set @name_to = ?
								");
							$stmt->bind_param("s", $_POST["to"]);
							$stmt->execute();
							
							$stmt = $conn->prepare("
								set @id_from = (
									select idstation from station
									where namestation = ?
								)");
								
							$stmt->bind_param("s", $_POST["from"]);
							$stmt->execute();
							
							$stmt = $conn->prepare("
								set @id_to = (
									select idstation from station
									where namestation = ?
								)");
								
							$stmt->bind_param("s", $_POST["to"]);
							$stmt->execute();
							
							$stmt = $conn->prepare("
								select @name_from as 'NameFrom', @name_to 'NameTo', time_format(
								(
									
								select addtime(timestart, 
								(
								select sec_to_time(time_to_sec(timediff(timeend, timestart)) *
								(
								select r1.distancetraveled / rg.distance from route r1, routegeneral rg
								where r1.idroute = sch.idroute and r1.idstation = @id_from AND
									  rg.idroute = sch.idroute 
									))
								)
											   
								)                                                                                        
								)                                       
								, '%H:%i') as 'TimeFrom' ,
								 time_format(
								(
									
								select addtime(timestart, 
								(
								select sec_to_time(time_to_sec(timediff(timeend, timestart)) *
								(
								select r1.distancetraveled / rg.distance from route r1, routegeneral rg
								where r1.idroute = sch.idroute and r1.idstation = @id_to AND
									  rg.idroute = sch.idroute
									))
								)
											   
								)                                                                                        
								)                                         
								, '%H:%i') as 'TimeTo',
								dayweek,
								rg.nameroute
								from schedules sch, routegeneral rg
								where rg.idroute = sch.IdRoute AND sch.idroute in (
								# where rg.idroute = sch.IdRoute AND sch.idroute in (
									select * from temp_idroutes

								)
								# and sch.timestart >= ? and sch.timestart <= addtime(?, '08:00:00')
								and sch.dayweek = ?
								having TimeFrom >= ? and TimeFrom <= addtime(?, '06:00')
								");
								
								$stmt->bind_param("sss", $_POST["dayweek"], $_POST["timestart"], $_POST["timestart"]);
								$stmt->execute();
								
								$result = $stmt->get_result();
							
							if ($result->num_rows > 0) {
								echo '<div id = "ticket_search">';
								
								echo '<div class = "row_labels row">';
								echo '<label>From</label>';
								echo '<label>To</label>';
								echo '<label>Time of start</label>';
								echo '<label>Time of end</label>';
								echo '<label>Day of week</label>';
								echo '<label class = "nameroute_data">Name of route</label>';
								echo '<label id = "null_label"></label>';
								echo '</div>';
								
								while ($row = $result->fetch_assoc()) {
									
									echo '<div class = "row">';
									echo '<label>' . $row["NameFrom"] . '</label>';
									echo '<label>' . $row["NameTo"] . '</label>';
									echo '<label>' . $row["TimeFrom"] . '</label>';
									echo '<label>' . $row["TimeTo"] . '</label>';
									echo '<label>' . $row["dayweek"] . '</label>';
									echo '<label class = "nameroute_data">' . $row["nameroute"] . '</label>';

									$nameroute = $row["nameroute"];
									$namefrom = $row["NameFrom"];
									$nameto = $row["NameTo"];
									$timefrom = $row["TimeFrom"];
									$timeto = $row["TimeTo"];
									$dayweek = $row["dayweek"];
									
									echo "
									<form action=\"money_to_pay.php\" method=\"post\" id = \"buy_first_button\"> 
										<input type=\"hidden\" name=\"namefrom\" value=\"$namefrom\">
										<input type=\"hidden\" name=\"nameto\" value=\"$nameto\">
										<input type=\"hidden\" name=\"timefrom\" value=\"$timefrom\">
										<input type=\"hidden\" name=\"timeto\" value=\"$timeto\">
										<input type=\"hidden\" name=\"dayweek\" value=\"$dayweek\">
										<input type=\"hidden\" name=\"nameroute\" value=\"$nameroute\">
										<input type=\"submit\" value=\"Buy!\" class = \"button\">
									</form>
									";
									
									echo '</div>';
								}
								
								echo '</div>';
							} else {
								echo '<div class = "null_res"> 0 results</div>';
							}
						
						$conn->close();
					}
				?>
			</section>
		</div>
	</body>
</html>
