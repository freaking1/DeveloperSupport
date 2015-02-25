<?
require("include/sessions.php");
require( "include/EnomInterface_inc.php" );
	
	$tld = $_GET["tld"];
	$sld = $_GET["sld"];
	$method = $_GET["method"];
	$price = $_POST['price'];
	$PaypalAuthKey2 = $_POST["PaypalAuthKey2"];
	
	if($PaypalAuthKey2 != $PaypalAuthKey){
			echo "PaypalAuthKey2 = $PaypalAuthKey2 - PaypalAuthKey = $PaypalAuthKey";
			//header ("Location: Check.php");
			//exit;
	}
	
			echo "Key2 from post: $PaypalAuthKey2 <br> Key from sessions: $PaypalAuthKey";

	
require('include/config.inc.php'); 
require('include/global_config.inc.php');

?>
			<body onLoad="document.paypal_form.submit();">
			<form method="post" name="paypal_form" action="<?=$paypal[url]?>">
		<?php 
		showVariables(); 
		?>
		</form>