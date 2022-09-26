<?php
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		$_SESSION['error_log'] = 'You need to be logged in to do this!';
		header('Location: log.php');
		exit();
	} else if (!isset($_POST['money'])) {
		header('Location: user_content.php');
		exit();
	}

	if (!is_numeric($_POST['money'])) {
		$_SESSION['error_log_money'] = 'Wrong data!';
		header('Location: money.php');
		exit();
	} else if ((($where = strpos($_POST['money'], ".")) !== FALSE) && (strlen($_POST['money']) - $where > 3)) {
		$_SESSION['error_log_money'] = 'Too many decimals!';
		header('Location: money.php');
		exit();
	}

	require_once "connect.php";
	
	$conn = @new mysqli($servername, $username, $password, $dbname);	
	if ($conn->connect_errno != 0) {
		echo "Error: " . $conn->connect_errno;
		exit();
	} else {
		$iduser = $_SESSION['id'];
		$money = $_POST['money'];
		
		$stmt = $conn->prepare("update users set money = money + ? where iduser = ?");
		$stmt->bind_param("di", $money, $iduser);
	
		$iduser = $_SESSION['id'];
	
		$stmt->execute();
		
		unset($_POST['money']);
		
		$stmt->close();
		$conn->close();
		header('Location: user_content.php');
	}
?>
