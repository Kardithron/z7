<?php
	session_start();
	require_once('msg.php');
	
	if (is_uploaded_file($_FILES['file']['tmp_name'])) {
		move_uploaded_file($_FILES['file']['tmp_name'], "/z7/{$_SESSION['user']}/" . $_SESSION['dir'] . "/" . $_FILES['file']['name']);
		msg('File uploaded: '.$_FILES['file']['name'], 'home.php');
	}
	else 
		msg('There was a problem with sending data. Please try again.', 'home.php');
?>