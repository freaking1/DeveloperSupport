<?php
	$authnet_values				= array
	(
		"x_login"				=> $authnetlogin,
		"x_version"				=> "3.1",
		"x_delim_char"			=> "|",
		"x_delim_data"			=> "TRUE",
		"x_url"					=> "FALSE",
		"x_type"				=> "AUTH_CAPTURE",
		"x_method"				=> "CC",
		"x_tran_key"			=> $transactionkey,
		"x_relay_response"		=> "FALSE",
		"x_card_num"			=> $CardNumber,
		"x_exp_date"			=> "$CardExpMonth/$CardExpYear",
		"x_description"			=> "$CompanyName - Invoice #$invoice",
		"x_invoice_num"			=> $invoice,
		"x_amount"				=> $amount_due,
		"x_card_code"			=> $CVV2,
		"x_cust_id"				=> $username,
		"x_merchant_email"		=> $sales_email,
		"x_first_name"			=> $CCFName,
		"x_last_name"			=> $CCLName,
		"x_address"				=> $CCAddress,
		"x_zip"					=> $CCZip,
		"x_email"				=> $CCEmail,
		"x_city"				=> $CCCity,
		"x_phone"				=> $CCPhone,
		"x_fax"					=> $CCFax,
		"x_state"				=> $CCState,
		"x_country"				=> $country,
		"x_ship_to_first_name"	=> $CCFName,
		"x_ship_to_last_name"	=> $CCLName,
		"x_ship_to_address"		=> $CCAddress,
		"x_ship_to_zip"			=> $CCZip,
		"x_ship_to_city"		=> $CCCity,
		"x_ship_to_state"		=> $CCState,
		"x_ship_to_country"		=> $country,
		"x_CustomerIP"			=> $enduserip
	);

$fields = "";
foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";

//echo $fields;
		$ch = curl_init("https://secure.authorize.net/gateway/transact.dll"); // URL of gateway for cURL to post to
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
		### curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
//echo $resp;
$text = $resp;
$h = substr_count($text, "|");
$h++;

	for($j=1; $j <= $h; $j++){

	$p = strpos($text, "|");

	if ($p === false) { // note: three equal signs

	}else{

		$p++;

		$pstr = substr($text, 0, $p);

		$pstr_trimmed = substr($pstr, 0, -1); // removes "|" at the end

		if($pstr_trimmed==""){
			$pstr_trimmed="NO VALUE RETURNED";
		}

		switch($j){

			case 1:
				$fval="";
				if($pstr_trimmed=="1"){
					$fval="Approved";
				}elseif($pstr_trimmed=="2"){
					$fval="Declined";
				}elseif($pstr_trimmed=="3"){
					$fval="Error";
				}
				break;
			case 2:
				$response_subcode = $pstr_trimmed;
				break;
			case 3:
				$response_reason_code = $pstr_trimmed;
				break;
			case 4:
				$response_reason_text = $pstr_trimmed;
				break;
			case 5:
				$approval_code = $pstr_trimmed;
				break;
			case 6:
				$avs_result = $pstr_trimmed;
				break;
			case 7:
				$transID = $pstr_trimmed;
				break;
			case 8:
				$invoice = $pstr_trimmed;
				break;
			case 9:
				$description = $pstr_trimmed;
				break;
			case 10:
				$amount = $pstr_trimmed;
				break;
			case 13:
				$custID = $pstr_trimmed;
				break;
			case 24:
				$cust_email = $pstr_trimmed;
				break;
			case 38:
				$MD5Hash = $pstr_trimmed;
				break;
			}
		$text = substr($text, $p);
	}
}

if($fval == "Approved"){
			
			$query_delete = "DELETE FROM cart WHERE user_id='$user_id'";
			$result_delete = mysql_query($query_delete);

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

			$hashvars = "$md5hash$authnetlogin$transID$amount";
			$MD5Hash2 = strtoupper(md5($hashvars));
			
			if($MD5Hash == $MD5Hash2){
			
				$_SESSION["md5hash1"] = $MD5Hash;
				$_SESSION["md5hash2"] = $MD5Hash2;
				$_SESSION["transID"] = $transID;
				$_SESSION["amount"] = $amount;
				$_SESSION["custusername"] = $custID;
				$_SESSION["invoice"] = $invoice;
				$_SESSION["custfname"] = $fname;
				$_SESSION["custlname"] = $lname;
				$_SESSION["custemail"] = $email;
				
				$query2 = "UPDATE customer_invoice SET paid='1', paid_by='2', cc_transId = '$transID' WHERE user_id='$user_id' AND username='$username' AND invoice_id='$invoice'";
				$result2 = mysql_query($query2);
				//echo $query2;
					if($result2){
						include("include/emails/cc_reciept.php");
							$_SESSION["referpage"] = 'CCProcess';
						$formvars = "hs=$MD5Hash&us=$username&transID=$transID&invoice=$invoice&amount=$amount";
						header ("Location:  $secure_site_url/ccthanks.php?$formvars");
						exit();	
					} else {
						$message .= "ERROR COULD NOT WRITE TO DATABASE - Contact Support with this error";
					}
				} else {
				include("include/emails/cc_fraud.php");
				}
		} else {
		$message.=  "<center>There was a problem with payment. The error was: \"$fval $response_subcode $response_subcode_reason : $response_reason_text\"<br>";
		$message.=  "<center>Please correct the error and try again.<br>";
		include("include/emails/cc_cancelled.php");
		}
?>