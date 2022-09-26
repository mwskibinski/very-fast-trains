<?php
	session_start();
	
	if (isset($_SESSION['logged_in'])) {
		header('Location: user_content.php');
		exit();
	}
	
	if (isset($_POST['email'])) {
		$OK=true;
		
		$login = $_POST['login'];
		
		if ((strlen($login) < 3) || (strlen($login) > 20)) {
			$OK = false;
			$_SESSION['e_login'] = "Login must be at least 3 characters long and less than 20!";
		}
		
		if (!ctype_alnum($login)) {
			$OK = false;
			$_SESSION['e_login'] = "Login must have only alphanumeric characters!";
		}
		
		$email = $_POST['email'];
		$email_san = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($email_san, FILTER_VALIDATE_EMAIL)==false) || ($email_san != $email)) {
			$OK = false;
			$_SESSION['e_email'] = "Invalid e-mail !";
		}
		
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1) < 7) || (strlen($password1) > 21)) {
			$OK = false;
			$_SESSION['e_password'] = "Password must be at least 7 characters long and less than 21!";
		}
		
		if ($password1 != $password2) {
			$OK = false;
			$_SESSION['e_password'] = "Password did not match!";
		}

		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		if (!isset($_POST['terms'])) {
			$OK = false;
			$_SESSION['e_terms'] = "You need to check the checkbox!";
		}				
		
		$secret_key = "6LdZb8UUAAAAALKggmMxgDYYENJW1CVcwysIwjDn";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);
		$response = json_decode($check);
		
		if (!($response->success)) {
			$OK = false;
			$_SESSION['e_captcha'] = "Do the captcha!";
		}
		
		$_SESSION['temp_login'] = $login;
		$_SESSION['temp_email'] = $email;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try {
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_errno != 0) {
				throw new Exception(mysqli_connect_errno());
			} else {
				$result = $conn->query("select iduser from users where email = '$email'");
				
				if (!$result)
					throw new Exception($conn->error);
				
				$email_n = $result->num_rows;
				if ($email_n > 0) {
					$OK = false;
					$_SESSION['e_email'] = "This email is already taken!";
				}		

				$result = $conn->query("select iduser from users where nameuser = '$login'");
				
				if (!$result)
					throw new Exception($conn->error);
				
				$login_n = $result->num_rows;
				if ($login_n > 0) {
					$OK = false;
					$_SESSION['e_login'] = "This login is already taken!";
				}
				
				if ($OK == true) {
					if ($conn->query("insert into users(nameuser, password, money, email, admin) values ('$login', '$password_hash', 0, '$email', 0)")) {
						$_SESSION['registration_done'] = true;
						header('Location: welcome.php');
					} else
						throw new Exception($conn->error);
				}
				
				$conn->close();
			}
		} catch(Exception $e) {
			echo '<span style = "color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
	}
?>


<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>VERY FAST TRAINS !</title>
		<link rel = "stylesheet" href = "stylesheet_css.css">
		<link rel = "shortcut icon" type = "image/x-icon" href = "img/trains_1.png">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<style>
		.error {
			color: red;
		}
		</style>
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
				<h2>Register</h2>
				<form method = "post" id = "reg_form">
					<div class = "main_form">
						<div class = "row">
							<label>Login</label>
							<input type = "text" value = "<?php
								if (isset($_SESSION['temp_login'])) {
									echo $_SESSION['temp_login'];
									unset($_SESSION['temp_login']);
								}
								?>" name = "login"><br>
						</div>
						<div class = "row">
							<label>E-mail</label>
							<input type = "text" value = "<?php
								if (isset($_SESSION['temp_email'])) {
									echo $_SESSION['temp_email'];
									unset($_SESSION['temp_email']);
								}
							?>" name = "email"><br>
						</div>
						<div class = "row">
							<label>Password</label>
							<input type = "password" name = "password1"><br>
						</div>
						<div class = "row">
							<label>Confirm Password</label>
							<input type = "password" name = "password2"><br>
						</div>
						<div class = "row" id = "reg_check">
							<label>I agree to the terms</label>
							<input type = "checkbox" name = "terms">
						</div>
					</div>
					<div class="g-recaptcha" data-sitekey="6LdZb8UUAAAAAP1UqgeqPr7d26r-JWAwy5RHHkKS"></div>
					<input type = "submit" value = "Register!" form = "reg_form">
				</form>
					<?php
						if (isset($_SESSION['e_login'])) {
							echo '<div class = "error_tmp">' . $_SESSION['e_login'] . '</div>';
							unset($_SESSION['e_login']);
						}
					?>
					<?php
						if (isset($_SESSION['e_email'])) {
							echo '<div class = "error_tmp">' . $_SESSION['e_email'] . '</div>';
							unset($_SESSION['e_email']);
						}
					?>
					<?php
						if (isset($_SESSION['e_password'])) {
							echo '<div class = "error_tmp">' . $_SESSION['e_password'] . '</div>';
							unset($_SESSION['e_password']);
						}
					?>
					<?php
						if (isset($_SESSION['e_terms'])) {
							echo '<div class="error_tmp">' . $_SESSION['e_terms'] . '</div>';
							unset($_SESSION['e_terms']);
						}
					?>	
					<?php
						if (isset($_SESSION['e_captcha'])) {
							echo '<div class="error_tmp">' . $_SESSION['e_captcha'] . '</div>';
							unset($_SESSION['e_captcha']);
						}
					?>	
			</section>
		</div>
	</body>
</html>
