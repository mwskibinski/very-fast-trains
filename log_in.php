<?php
	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['pass']))) {
		header('Location: log.php');
		exit();
	}

	require_once "connect.php";

	$conn = @new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_errno != 0) {
		echo "Error: " . $conn->connect_errno;
	} else {
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$pass = htmlentities($pass, ENT_QUOTES, "UTF-8");
	
		if ($result = @$conn->query(
		sprintf("SELECT iduser, nameuser, email, password, money FROM users WHERE nameuser = '%s'", // zmien zapytanie
		mysqli_real_escape_string($conn, $login))))
		{
			if ($result->num_rows > 0) {
				$result_row = $result->fetch_assoc();
				
				if (password_verify($pass, $result_row['password'])) {
					$_SESSION['logged_in'] = true;
					$_SESSION['id'] = $result_row['iduser'];
					$_SESSION['user'] = $result_row['nameuser'];
					$_SESSION['email'] = $result_row['email'];
					$_SESSION['money'] = $result_row['money'];
					
					unset($_SESSION['error_log']);
					$result->free_result();
					header('Location: user_content.php');
				} else {
					$_SESSION['error_log'] = 'Invalid login or/and password !';
					header('Location: log.php');
				}
			} else {
				$_SESSION['error_log'] = 'Invalid login or/and password !';
				header('Location: log.php');	
			}	
		}
		
		$conn->close();
	}
?>
