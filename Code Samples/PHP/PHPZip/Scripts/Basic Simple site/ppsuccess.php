<?php

include("include/sessions.php");

	$sld = $_COOKIE['enomsld'];
	$tld = $_COOKIE['enomtld'];
	$method = $_COOKIE['enommethod'];
	$price = $_COOKIE['enomprice'];
	
	$paypalpost = $_POST["custom"];
	$formoptions = "sld=$sld&tld=$tld&method=$method";

if($paypalpost != $PaypalAuthKey){
		echo "paypalpost = $paypalpost - Sessions = $PaypalAuthKey";
		//header ("Location: PayforName.php?$formoptions");
		exit;
} else {

	$PaypalAuthKey = '';
	$_SESSION['PaypalAuthKey'] = '';
	$_SESSION['Referer'] = 'ppsuccess';
	$_SESSION['success'] = '1';


	header ("Location: $site_url/RegisterName.php?$formoptions");
	}
?>