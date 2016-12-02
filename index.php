<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Zadanie 7
		</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h2>Login</h2>
		<form method="POST" action="login.php">
			Username:
			<br>
			<input type="text" name="user" value="">
			<br>
			Password:
			<br>
			<input type="password" name="pass" value="">
			<br>
			<input type="submit" value="Sign In">
		</form>
		<h2>Sign Up</h2>
		<form method="POST" action="register.php">
			Username:
			<br>
			<input type="text" name="user" value="">
			<br>
			Password:
			<br>
			<input type="password" name="pass" value="">
			<br>
			<input type="submit" value="Sign Up">
		</form>
		<br>
		<a href="http://102653.panda5.pl/">102653.panda5.pl</a>
		<?php 
			require_once('msg.php');
		?>
	</body>
</html>