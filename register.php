<?php
	session_start();
	require_once("msg.php");
	
	if (!isset($_POST['user']) && !isset($_POST['pass'])) {
		header('Location: index.php');
		exit();
	}
	else {
		$user = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");
		$pass = htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");
		
		if (($user=="") or ($pass==""))
			msg('Username and Password fields cannot be empty!', 'index.php');
		else {		
			require_once "/connect.php";
			$sql = "SELECT * FROM t7_users WHERE Nickname='$user'";
			$result = $conn->query($sql);
			$howmany = $result->num_rows;
		
			if ($howmany>0)
				msg('User with such a nickname already exists.', 'index.php');
			else {
				$sql = "INSERT INTO t7_users (user, pass) VALUES ('$user', '$pass')";
				if ($conn->query($sql) === FALSE) 
					echo "Error: " . $sql . "<br>" . $conn->error;
				else {
					mkdir("/z7/$user", 0777, true);
					msg('Successfully registered! You can log in as a $user.', 'index.php');
				}
			}
			
			$conn->close();
		}
	}
?>