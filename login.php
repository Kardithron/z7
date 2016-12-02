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
			$sql = "SELECT * FROM t7_users WHERE BINARY user='$user';";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			
			if (!$row)
				// incorrect username
				msg('Incorrect login credentials!', 'index.php');
			else
				if ($row['pass'] == $pass) {
					if ($row['fail_counter'] < 3) {
												
						// reset counter
						
						$sql = "UPDATE t7_users SET fail_counter=0 WHERE user='$user';";
						if (!$conn->query($sql)) die("Error: " . $sql . "<br>" . $conn->error);
						
						$sql = "INSERT INTO t7_log (ID_users, timestamp, fail) 
									SELECT ID, CURRENT_TIMESTAMP, 0 FROM t7_users WHERE user='$user'";
						if (!$conn->query($sql)) die("Error: " . $sql . "<br>" . $conn->error);
						
						$_SESSION['loggedin'] = true;
						$_SESSION['userid'] = $row['ID'];
						$_SESSION['user'] = $user;
						header('Location: home.php');
					}
					else
						msg('This account is locked down because of too many failed login attempts.', 'index.php');
				}
				else {
					// failed attempt: incorrect password for existing account, fail_counter++
					
					$sql = "UPDATE t7_users SET fail_counter=fail_counter+1 WHERE user='$user'";
					if (!$conn->query($sql)) die("Error: " . $sql . "<br>" . $conn->error);
						
					$sql = "INSERT INTO t7_log (ID_users, timestamp, fail) 
								SELECT ID, CURRENT_TIMESTAMP, 1 FROM t7_users WHERE user='$user'";
					if (!$conn->query($sql)) die("Error: " . $sql . "<br>" . $conn->error);	
					
					msg('Incorrect login credentials!', 'index.php');
				}
			
			$conn->close();
		}
	}
?>