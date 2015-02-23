<?php

if($frompaypal == $PaypalAuthKey){

//Send the IPN Email
#--------------------------
$email = $paypal_id;
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
		$body = "-----------HTTP POST VARS------------\n";
		foreach ($_POST as $key => $value)
		{
		$body .= "$key = $value \n\n";
		}
		$body .= "-------------------------------------\n\n\n";
		$headers .= "From: " . $paypal_id." <" . $paypal_id . ">\r\n";
		$headers .= "Reply-To: " . $paypal_id. " <" . $paypal_id . ">\r\n";
		mail($email, $title, $body, $headers);
}

$fp = doTheCurl();
if (!$fp)
	{
		doEmail("cURL ERROR, SWITCHING TO HTTP",$email);
		$fp = doTheHttp();
	}
$res = $fp;

if (strcmp ($res, "VERIFIED") == 0)
	{
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
}
?>