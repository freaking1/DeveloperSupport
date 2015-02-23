<?php


if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  index.php");
	exit(); 
} else {
	setcookie("loggedin", "");
	setcookie ("loggedin_user", "", time()-300, "/", "$siteurl", 0);
	setcookie ("id", "", time()-300, "/", "$siteurl", 0);
	setcookie ("AdminUserName", "", time()-300, "/", "$siteurl", 0);
	setcookie ("AdminUser", "", time()-300, "/", "$siteurl", 0);
	
	session_unregister($_SESSION['loggedin']);
	session_unregister($_SESSION['loggedin_user']);
	session_unregister($_SESSION['id']);
	session_unregister($_SESSION['AdminUserName']);
	session_unregister($_SESSION['AdminUser']);
	
	unset($_COOKIE["loggedin"]);
	unset($_COOKIE["loggedin_user"]);
	unset($_COOKIE["id"]);
	unset($_COOKIE["AdminUserName"]);
	unset($_COOKIE["AdminUser"]);
	
	$_SESSION=array();
	session_destroy('API-PHPSESSID');
	
	header ("Location:  index.php");
	exit(); 
}
?>