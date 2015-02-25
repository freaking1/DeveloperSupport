<?php
if($testmode == 1){
		$worldpay_values				= array
	(
		"instId"				=> $instId,
		"authPW"				=> $authPW,
		"amount"				=> $amount_due,
		"currency"				=> $currency,
		"desc"					=> "$CompanyName - Invoice #$invoice",
		"cartId"				=> $invoice,
		"testMode"				=> "100",
		"cardName"				=> "$CCFName $CCLName",
		"address"				=> $CCAddress,
		"postcode"				=> $CCZip,
		"country"				=> $country,
		"tel"					=> $CCPhone,
		"email"					=> $CCEmail,
		"city"					=> $CCCity,
		"state"					=> $CCState,
		"cardNo"				=> $CardNumber,
		"cardCVV"				=> $CVV2,
		"cardExpMonth"			=> $CardExpMonth,
		"cardExpYear"			=> $CardExpYear,
	);
} else {
//Not in test mode
		$worldpay_values				= array
	(
		"instId"				=> $instId,
		"authPW"				=> $authPW,
		"amount"				=> $amount_due,
		"currency"				=> $currency,
		"desc"					=> "$CompanyName - Invoice #$invoice",
		"cartId"				=> $invoice,
		"testMode"				=> "0",
		"cardName"				=> "$CCFName $CCLName",
		"address"				=> $CCAddress,
		"postcode"				=> $CCZip,
		"country"				=> $country,
		"tel"					=> $CCPhone,
		"email"					=> $CCEmail,
		"city"					=> $CCCity,
		"state"					=> $CCState,
		"cardNo"				=> $CardNumber,
		"cardCVV"				=> $CVV2,
		"cardExpMonth"			=> $CardExpMonth,
		"cardExpYear"			=> $CardExpYear,
	);
}

$fields = "";
foreach( $worldpay_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";

		$ch = curl_init("https://select.worldpay.com/wcc/authorise"); // URL of gateway for cURL to post to
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
$text = $resp;

	$Lines = explode( ",", $text );
		$rawAuthCode = $Lines[0];
		$rawResponseText = $Lines[2];

	switch($rawAuthCode){
		case "A":
			$AuthStatus = "Approved";
			$transID = $Lines[1];
			
			//Update the database
			#----------------------
			$query = "select * from customer_invoice where invoice_id = '$invoice'";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
				$user_id2 = $row[user_id];
				$username2 = $row[username];
				$status = $row[status];
				$amount_due2 = $row[amount_due];
			$query_info = "SELECT fname, lname, email FROM users WHERE username='$username2' AND id='$user_id2'";
			$result_info = @mysql_query($query_info);
			$row_info = mysql_fetch_array($result_info, MYSQL_ASSOC);
			$fname = $row_info[fname];
			$lname = $row_info[lname];
			$email = $row_info[email];

				$query2 = "UPDATE customer_invoice SET paid='1', paid_by='2', cc_transId = '$transID' WHERE user_id='$user_id' AND username='$username' AND invoice_id='$invoice'";
				$result2 = mysql_query($query2);
					if($result2){
						$query_delete = "DELETE FROM cart WHERE user_id='$user_id'";
						$result_delete = mysql_query($query_delete);

						include("include/emails/cc_reciept.php");
						$_SESSION["referpage"] = 'CCProcess';
						$_SESSION["invoice"] = $invoice;
						$_SESSION["fname"] = $fname;
						$_SESSION["lname"] = $lname;
						$_SESSION["email"] = $email;
						$_SESSION["transID"] = $transID;
						$_SESSION["amount"] = $amount_due;
						header ("Location:  $secure_site_url/ccthanks.php");
						exit();	
					} else {
						$message .= "ERROR COULD NOT WRITE TO DATABASE - Contact Support with this error";
					}
			break;
		case "R":
			$message .= "Declined<br>";
			$message .= "We're sorry, but your card has been declined.<br>$rawResponseText";
				include("include/emails/cc_cancelled.php");
			break;
		case "D":
			$message .= "Declined<br>";
			$message .= "We're sorry, but your card has been declined.<br>$rawResponseText";
				include("include/emails/cc_cancelled.php");
			break;
		default:
			$message .= "No Response<br>";
			$message .= "The merchant processor did not respond - please try again later.<br>You were not charged for the transaction.";
			break;
		}
?>