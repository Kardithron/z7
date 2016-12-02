<?php
	function msg ($msg, $loc) {
		$_SESSION['msg'] = $msg;
		header('Location: ' . $loc);
		exit();
	}
	
	if (isset($_SESSION['msg'])) {
		echo "<br><br>";
		echo $_SESSION['msg']; 
		unset($_SESSION['msg']);
	} 
?>