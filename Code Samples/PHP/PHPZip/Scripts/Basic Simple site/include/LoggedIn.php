<?php
$LoggedIn = $_SESSION['LoggedIn'];
	if ( $LoggedIn != "1" ) {
		header ("Location: index.php");
		exit;
	}
?>
