<?php
	session_start();
	
	if (!isset($_POST['comment'])) {
		header('Location: contact.php');
		exit();
	}
	
	$_SESSION['temp_comment'] = $_POST['comment'];
	
	if (!isset($_SESSION['logged_in'])) {
		$_SESSION['error_log'] = 'You need to be logged in to comment!';
		header('Location: log.php');
		exit();
	}
	
	require_once "connect.php";
	
	$conn = @new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_errno != 0) {
		echo "Error: " . $conn->connect_errno;
	} else {
		$iduser = $_SESSION['id'];
		$today = getdate();
		$date = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"] . " " . $today["hours"] . ":" . $today["minutes"] . ":" .$today["seconds"] ;
		$message = $_POST["comment"];
		
		$stmt = "insert into comments(iduser, comment, date) values ($iduser, '$message', '$date')";
		$conn->query($stmt);
		$conn->close();
		
		header('Location: contact.php');
		exit();
	}
?>
