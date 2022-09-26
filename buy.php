<?php
	session_start();
	
	if (!isset($_SESSION['logged_in'])) {
		$_SESSION['error_log'] = 'You need to be logged in to do this!';
		header('Location: log.php');
		exit();
	}
	
	if (isset($_POST['discount']))
		$_SESSION['temp_discount'] = $_POST['discount'];
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
				<h2>Your ticket:</h2>
				<div id = "ticket_data">
					<div class = "row">
						<label>Name of route</label>
						<div><?php echo $_SESSION['nameroute']; ?></div><br>
					</div>
					<div class = "row">
						<label>From station</label>
						<div><?php echo $_SESSION['namefrom']; ?></div><br>
					</div>
					<div class = "row">
						<label>To station</label>
						<div><?php echo $_SESSION['nameto']; ?></div><br>
					</div>
					<div class = "row">
						<label>Time of start</label>
						<div><?php echo $_SESSION['timefrom']; ?></div><br>
					</div>
					<div class = "row">
						<label>Time of end</label>
						<div><?php echo $_SESSION['timeto']; ?></div><br>
					</div>
					<div class = "row">
						<label>Dayweek</label>
						<div><?php echo $_SESSION['dayweek']; ?></div><br>
					</div>
					<div class = "row">
						<label>Price</label>
						<div><?php 
							if (isset($_POST['discount'])) {
								$money = (float) $_SESSION['money_to_pay'];
								$money *= (float) $_POST['discount'];
								$_SESSION['money'] = number_format((float) $money, 2, '.', '');
								
								echo $_SESSION['money'] . " zł";
							} else
								echo "<b>Select discount first!</b>";
						?></div><br>
					</div>
				</div>
				<?php
					require_once "connect.php";
					
					$conn = new mysqli($servername, $username, $password, $dbname);
						
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					}
					
					$stmt = "select namediscount, discountrate from discount";
					$result = $conn->query($stmt);
				
					echo '<form method = "post" id = "discount_form">';
					echo '<select name = "discount" onchange = "this.form.submit();">';
				
					if (!isset($_POST['discount']))
						echo '<option value = "-1">Discount</option>';
				
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$discountrate = $row['discountrate'];
							$namediscount = $row['namediscount'];

							echo "<option value = $discountrate ";
							if (isset($_SESSION['temp_discount']) && $_SESSION['temp_discount'] == $discountrate) {
								echo 'selected = "selected"';
								unset($_SESSION['temp_discount']);
							}
							echo " >$namediscount</option>";
						}
					}
				
					echo "</select>";
					echo "</form>";
				?>
				<form action = "insert.php" method = "post"> 
					<input type = "hidden" name = "namefrom" value = "<?php echo $_SESSION['namefrom']; ?>"/>
					<input type = "hidden" name = "nameto" value = "<?php echo $_SESSION['nameto']; ?>"/>
					<input type = "hidden" name = "timefrom" value = "<?php echo $_SESSION['timefrom']; ?>"/>
					<input type = "hidden" name = "timeto" value = "<?php echo $_SESSION['timeto']; ?>"/>
					<input type = "hidden" name = "dayweek" value = "<?php echo $_SESSION['dayweek']; ?>"/>
					<input type = "hidden" name = "nameroute" value = "<?php echo $_SESSION['nameroute']; ?>"/>
					<input type = "hidden" name = "money" value = "<?php echo $_SESSION['money']; ?>"/>
					<input type = "submit" value = "Buy!" id = "buy_button" <?php if(!isset($_POST['discount'])) echo "disabled"; ?>/>
				</form>
			</section>
		</div>
	</body>
</html>
