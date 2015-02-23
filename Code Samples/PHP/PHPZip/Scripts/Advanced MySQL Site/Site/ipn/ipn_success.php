<?php
//log successful transaction to file or database
include_once('../include/global_config.inc.php'); 
create_csv_file("logs/ipn_success.txt",$_POST);

include("../include/dbconfig.php");
$email = $sales_email;
#$paypal_id;

function doTheCurl ()
{
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value)
	{
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
	$ch = curl_init();
	
	// check to see if this is sandbox or not
	if ($_POST["test_ipn"] == 1)
	{
		curl_setopt($ch, CURLOPT_URL, "https://www.sandbox.paypal.com/cgi-bin/webscr"); 
	}
	else
	{
		curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com/cgi-bin/webscr"); 
	}
	
	
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$fp = curl_exec ($ch);
	curl_close($ch);
	return $fp;
}

function doTheHttp ()
{
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value)
	{
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
	// check to see if this is sandbox or not.
	if ($_POST["test_ipn"] == 1)
	{
		$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
	}
	else
	{
		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
	}
	
	if (!$fp) {
		return "ERROR";
	} 
	else
	{
		fputs ($fp, $header . $req);
		while (!feof($fp))
		{
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0)
			{
				return "VERIFIED";
			}
			else if (strcmp ($res, "INVALID") == 0)
			{
				return "INVALID";
			}
		}
		fclose ($fp);
	}
	return "ERROR";
}

function doEmail ($title,$email)
{
	$alsomail = "$title\n\n-----------HTTP POST VARS------------\n\n";
	foreach ($_POST as $key => $value)
	{
		$alsomail .= "$key = $value \n\n";
	}
	mail($email,$title,$alsomail);
}

/*
now with both of those functions defined, you can run
a simple check to get back your responce:
*/

$fp = doTheCurl();
if (!$fp)
{
	doEmail("cURL ERROR, SWITCHING TO HTTP",$email);
	$fp = doTheHttp();
}
$res = $fp;

/*
and after that, you can check to see if $res is
invalid or verified
*/

if (strcmp ($res, "VERIFIED") == 0)
{
	/*
	log stuff into your database here!

	Also, it's a good idea to send yourself an e-mail with all _POST params, just so you know what's going on.  The e-mail code is here, the database code is not.
	*/
	doEmail("PayPal Purchase Success",$email);
}
else if (strcmp ($res, "INVALID") == 0)
{
	doEmail("INVALID PayPal Purchase!!",$email);
}
else
{
	doEmail("Error in IPN Code - Normally HTTP Error",$email);
}
?> 