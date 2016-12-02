<?php
	header('Content-Description: File Transfer'); 
	header('Content-Type: application/octet-stream'); 
	header("Content-Disposition: attachment; filename='" . basename($_POST['name']) . "'"); 
	readfile($_POST['name']); 
?>