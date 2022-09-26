<?php
	session_start();
	
	if(!isset($_SESSION['logged_in'])) {
		$_SESSION['error_log'] = 'You need to be logged in to do this!';
		header('Location: log.php');
		exit();
	}
	
	if (!isset($_POST['nameroute'])) {
		header('Location: ticket.php');
		exit();
	}
	
	require_once "connect.php";
		
	$conn = @new mysqli($servername, $username, $password, $dbname);	
	if ($conn->connect_errno != 0) {
		echo "Error: " . $conn->connect_errno;
	} else {
		$iduser = $_SESSION['id'];
	
		$stmt = $conn->prepare("select money from users where iduser = ?");
		$stmt->bind_param("i", $iduser);
	
		$stmt->execute();
		
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$money_user = $row['money'];
		
		$stmt = $conn->prepare("		
			select (r2.DistanceTraveled - r1.DistanceTraveled) * 0.5 as 'MoneyToPay' from route r1, route r2 where
			r1.IdRoute = (
				select rg.idroute from routegeneral rg
				where rg.nameroute = ?
			)
			and
			r2.IdRoute = (
				select rg.idroute from routegeneral rg
				where rg.nameroute = ?
			)
			AND
			r1.IdStation = (
				select s.idStation from station s
				where namestation = ?
				)
			AND
			r2.IdStation = (
				select s.idStation from station s
				where namestation = ?
				)
		");
		$stmt->bind_param("ssss", $_SESSION['nameroute'], $_SESSION['nameroute'], $_SESSION['namefrom'], $_SESSION['nameto']);
		
		$_SESSION['nameroute'] = $_POST['nameroute'];
		$_SESSION['nameto'] = $_POST['nameto'];
		$_SESSION['namefrom'] = $_POST['namefrom'];
		$_SESSION['timefrom'] = $_POST['timefrom'];
		$_SESSION['timeto'] = $_POST['timeto'];
		$_SESSION['dayweek'] = $_POST['dayweek'];
	
		$stmt->execute();
		
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$_SESSION['money_to_pay'] = $row['MoneyToPay'];
		
		header('Location: buy.php');
	}
?>
