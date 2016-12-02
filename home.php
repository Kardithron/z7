<?php 
	session_start();
	if ((!isset($_SESSION['loggedin'])) or ($_SESSION['loggedin'] == false)) {
		header('Location: index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Zadanie 7 - profil użytkownika
		</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<?php
			echo "Logged in as a {$_SESSION['user']}.<br>";
			
			// checking last failed login attempt
			
			require_once "/connect.php";
			$sql = "SELECT timestamp FROM t7_log 
						WHERE ID_users=(SELECT ID FROM t7_users WHERE user='{$_SESSION['user']}') AND fail=1
						ORDER BY ID DESC LIMIT 1;";
			$result = $conn->query($sql);
			$conn->close();
			$row = $result->fetch_assoc();
			if ($row)
				echo "WARNING! Your last failed login attempt: " . $row['timestamp'] . "<br>";
			
			// -----------------------------------------
			
			if (isset($_POST['dir']))
				$_SESSION['dir'] = $_POST['dir'];
			else
				$_SESSION['dir'] = "";
			
			if ( isset($_POST['newfolder']) and !file_exists($_SESSION['user'] . "/" . $_POST['newfolder']) ) {
				mkdir($_SESSION['user'] . "/" . $_POST['newfolder']);
				unset($_POST['newfolder']);
			}
			
		?> 
		<a href="logout.php">Log out.</a>
		<br>
		<br>
		<form action="home.php" method="POST">
			Choose folder: 
			<select name="dir">
			<?php
				echo "<option value=''>{$_SESSION['user']}</option>";
				foreach (new DirectoryIterator($_SESSION['user']) as $file)
					if (!$file->isFile() && !$file->isDot())
						echo "<option value='" . $file->getFilename() . "'>" . $file->getFilename() . "</option>";
			?>
			</select>
			<br>
			<input type="submit" value="List files"/>
		<form>
		<br>
		<br>
		<form action="home.php" method="POST">
			Create folder: 
			<input type="text" name="newfolder">
			<br>
			<input type="submit" value="Create folder"/>
		</form>
		<br>
		<?php
			echo "<h2>z7/{$_SESSION['user']}/" . $_SESSION['dir'] . "</h2>";
		?> 
		<table border="1">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Size</th>
					<th>Last modified</th>
				</tr>
			</thead>
			<tbody>
					<?php
						foreach (new DirectoryIterator($_SESSION['user'] . "/" . $_SESSION['dir']) as $file) {
							if ($file->isFile() && !$file->isDot()) {
								echo "<tr><td><a href='" . $_SESSION['user'] . "/" . $file->getFilename() . "' download>" . $file->getFilename() . "</a></td>";
								echo '<td>' . $file->getSize() . ' bytes</td>';
								echo '<td>' . date('Y-m-d H:i:s', filemtime($file->getPathName())) . '</td>';
							}
						}
					?>
			</tbody>
		</table>
		<br>
		<form action="receive.php" method="POST" ENCTYPE="multipart/form-data">
			<input type="file" id="file" name="file"/>
			<br>
			<br>
			<input type="submit" name="submit" value="Send"/>
		</form>
		<script>
			<!-- using script for validating size of uploaded file -->
			/* document.forms[0].addEventListener('submit', function( evt ) {
				var file = document.getElementById('file').files[0];
				if (file && file.size < 10000) {} 
				else evt.preventDefault();
			}, false); */
		</script>
		<?php
			require_once('msg.php');
		?>
	</body>
</html>