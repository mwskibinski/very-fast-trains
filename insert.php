<?php
	session_start();
	
	if (!isset($_SESSION['logged_in'])) {
		$_SESSION['error_log'] = 'You need to be logged in to do this!';
		header('Location: log.php');
		exit();
	}
	
	if (!isset($_POST['money'])) {
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

		$money_to_pay = $_POST['money'];
		
		if ($money_user < $money_to_pay) {
			$_SESSION['e_money'] = "You don't have enough money !";
		
			$stmt->close();
			$conn->close();
			header('Location: user_content.php');
		}
		
		$stmt = $conn->prepare("update users set money = (money - ?) where iduser = ?");
		$stmt->bind_param("di", $money_to_pay, $iduser);
	
		$iduser = $_SESSION['id'];
		
		$stmt->execute();
	
		$stmt = $conn->prepare("insert into bought_tickets(iduser, nameto, namefrom, timeto, timefrom, dayweek) values (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("isssss", $iduser, $nameto, $namefrom, $timeto, $timefrom, $dayweek);

		$iduser = $_SESSION['id'];
		$nameto = $_POST['nameto'];
		$namefrom = $_POST['namefrom'];
		$timeto = $_POST['timeto'];
		$timefrom = $_POST['timefrom'];
		$dayweek = $_POST['dayweek'];
		
		$stmt->execute();
	
		$stmt->close();
		$conn->close();
		header('Location: user_content.php');
	}
?>
