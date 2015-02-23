<?php

session_name ('API-PHPSESSID');
session_start(); // Start the session.

if(isset($_GET['Z-debug-mode'])){
	$debug = $_GET['Z-debug-mode'];
} elseif(isset($showscreen)){
	$debug = $showscreen;
	}

if(isset($_GET['showraw'])){
	$showraw = $_GET['showraw'];
	} else {
	$showraw = 0;
	}	

if($refer != 'vque'){
require ("../EnomInterface_inc.php");
}

require ("../dbconfig.php");

	$sql_count = "SELECT COUNT(*) FROM customer_invoice WHERE paid = '1' AND status = '0' ORDER BY invoice_id";
	$result_count = mysql_query($sql_count);
	$row_count = mysql_result ($result_count,0);
	
			if($row_count == '0'){
				echo "Queue is empty<br>";
				exit();
			} else {
				echo "Queue is Not empty<br>";

$getdate = "SELECT curdate()";
$gotdate = mysql_query($getdate);
$currentdate = mysql_result($gotdate,0);

	$sql_getinvoice = "SELECT * FROM customer_invoice WHERE (paid = '1' AND status = '0') ORDER BY invoice_id ASC";
	$result_getinvoice = mysql_query($sql_getinvoice); 

	while ($row_getinvoice = @mysql_fetch_array($result_getinvoice, MYSQL_ASSOC)){
	$invoice = $row_getinvoice[invoice_id];
	$username = $row_getinvoice[username];
	echo "<br>Invoice $invoice	Username:  $username<br><br>";

	$sqlcount = "SELECT COUNT(*) FROM invoice_items WHERE invoice_id='$invoice'";
	$result_count = mysql_query($sqlcount);
	$count3 = mysql_result ($result_count,0);

	$sql_GetinvoiceItems = "SELECT * FROM invoice_items WHERE invoice_id = '$invoice' AND status='0'";
	$result_GetinvoiceItems = mysql_query($sql_GetinvoiceItems); 
	# ---------------Start Invoice Loop ----------#
	$Num = 1; 
			while ($row_GetinvoiceItems = mysql_fetch_array ($result_GetinvoiceItems, MYSQL_ASSOC)) {
				$user_id = $row_GetinvoiceItems[user_id];
				$invoice = $row_GetinvoiceItems[invoice_id];
				$sld = $row_GetinvoiceItems[sld];
				$tld = $row_GetinvoiceItems[tld];
				$prodid = $row_GetinvoiceItems[prodid];
				$qty = $row_GetinvoiceItems[qty];
				$extra = $row_GetinvoiceItems[extra];
				$action = $row_GetinvoiceItems[command];
				$host_package = $row_GetinvoiceItems[host_package];
				$extra3 = $row_GetinvoiceItems[host_username];
				$host_password = $row_GetinvoiceItems[host_password];
				$qstring = $row_GetinvoiceItems[string];
				$paid = $row_GetinvoiceItems[paid];
				$paid_by = $row_GetinvoiceItems[paid_by];
				$status = $row_GetinvoiceItems[status];
				$dns = $row_GetinvoiceItems[dns];
				$table_id = $row_GetinvoiceItems[table_id];
				$full_name = $row_GetinvoiceItems[full_name];
				$email_addy = $row_GetinvoiceItems[email_addy];
				$p_name = $row_GetinvoiceItems[p_name];
				$charge = $row_GetinvoiceItems[price];
				
		#--------Being the original Call -----# 
		$Enom = new CEnomInterface;
		$Enom->NewRequest();
		$string = "uid=$enom_username&pw=$enom_password&$qstring";
		$Enom->DoTransaction2($string,$testmode);
		
		$errors = $Enom->Values[ "ErrCount" ];
		$OrderID = $Enom->Values[ "OrderID" ] ;
		$ret_command = $Enom->Values[ "Command" ] ;
		$Err1 = $Enom->Values[ "Err1" ] ;
		
			foreach ($Enom->Values as $key => $value)
			{
				$raw .= ("$key = \"$value\"\r\n<br>");	
			}
		
			//Error for .name
			if($Enom->Values[ "RRPCode" ] == '2306'){
				$errors = 1;
				echo "<br>Error: $err1<br>";
				}// if RRP value

				switch ($errors) 
				{
				case "0":
				$message = "<br>No Error<br>";
				$Enom3 = new CEnomInterface;
				$Enom3->NewRequest();
				$Enom3->AddParam( "uid", $enom_username );
				$Enom3->AddParam( "pw", $enom_password );
				$Enom3->AddParam( "tld", $tld );
				$Enom3->AddParam( "sld", $sld );
					
					if($prodid == 1){
						$Enom3->AddParam( "RenewFlag", "0" );
						$Enom2 = new CEnomInterface;
						$Enom2->NewRequest();
						$Enom2->AddParam( "uid", $enom_username );
						$Enom2->AddParam( "pw", $enom_password );
						$Enom2->AddParam( "tld", $tld );
						$Enom2->AddParam( "sld", $sld );
						$Enom2->AddParam( "Command", "GetDomainInfo" );
						$Enom2->DoTransaction();
						
						$domainID = $Enom2->Values[ "domainnameid" ];
						$exp = $Enom2->Values[ "expiration" ];
						
						$query = "INSERT INTO domains (user_id , e_domain_id, sld, tld, exp_date, order_date, dns,  mail, webhosted, status, pop, idprotect, auto_renew, reg_lock, tv, parking, name_phone, name_map, password, lastupdate, e_order_id)
								  VALUES ('$user_id', $domainID, '$sld', '$tld', '$exp', curdate(), '$dns', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', 'NULL', curdate(), '$OrderID')";
						$result = mysql_query ($query);
						$query2 = "select order_date from domains where e_domain_id='$domainID'";
						$result2 = mysql_query($query2);
						$order_date = mysql_result($result2,0);
						$sql = 'select date_add(\''.$order_date.'\', interval '.$qty.' year)';
						$result_sql = mysql_query($sql);
						$exp_date = mysql_result($result_sql,0);
						$query3 = "UPDATE domains SET exp_date = '$exp_date' where e_domain_id='$domainID'";
						$result3 = mysql_query($query3);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
						$result_update = mysql_query($sql_update);
						$message .=  "Success! <br> $ret_command submitted in Order ID $OrderID <br>";

					} elseif($prodid == 2){
						$Enom3->AddParam( "RenewFlag", "0" );
						$Enom2 = new CEnomInterface;
						$Enom2->NewRequest();
						$Enom2->AddParam( "uid", $enom_username );
						$Enom2->AddParam( "pw", $enom_password );
						$Enom2->AddParam( "tld", $tld );
						$Enom2->AddParam( "sld", $sld );
						$Enom2->AddParam( "Command", "GetDomainInfo" );
						$Enom2->DoTransaction();
									
						//Figure out the new exp date
						$getdate2 = 'select date_add(\''.$currentdate.'\', interval '.$qty.' year)';
						$gotdate2 = mysql_query($getdate2);
						$new_renew = mysql_result($gotdate2,0);
						
						$domainID = $Enom2->Values[ "domainnameid" ];
						$exp_renew = $Enom2->Values[ "expiration" ];
						$sql = "UPDATE domains SET exp_date = '$new_renew', status = '1' WHERE sld='$sld' AND tld='$tld' AND user_id = '$user_id'";
						$result = mysql_query($sql);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
						$result_update = mysql_query($sql_update);
						$message .=  "Success! $ret_command submitted in Order ID $OrderID <br>";
												
					} elseif($prodid == 3){
						$orderdate =$Enom->Values[ "orderdate" ];
						$ordertypeid = $Enom->Values[ "ordertypeid" ];
						$ordertypedesc = $Enom->Values[ "ordertypedesc" ];
						$statusdesc  = $Enom->Values[ "statusdesc" ];
						$statusid = $Enom->Values[ "statusid1" ];
						$TransferOrderID = $Enom->Values[ "transferorderid" ];
						$sld = $Enom->Values[ "sld1" ];
						$tld = $Enom->Values[ "tld1" ];
									
						//Process Transfer
						$sql = "INSERT INTO transfers (user_id, order_id, order_type, order_status, ordertypedesc, statusid, sld, tld, create_date)
								VALUES ('$user_id', '$TransferOrderID', '$ordertypeid', 'statusdesc', '$ordertypedesc', '$statusid', '$sld', '$tld', '$orderdate' )";
						$result = mysql_query($sql);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
						$result_update = mysql_query($sql_update);
								$message .=  "Success! $ret_command submitted in Order ID $TransferOrderID <br>";

				} elseif($prodid == 4){						
						$Enom3->AddParam( "IDProtectRenew", "0" );
						$sql = "UPDATE domains SET idprotect='1' WHERE sld='$sld' AND tld='$tld'";
						$result = mysql_query($sql);
						//Place it in the domain_addons table
						$getid = "SELECT e_domain_id FROM domains WHERE sld='$sld' AND tld='$tld'";
						$gotid = mysql_query($getid);
						$e_domain_id = mysql_result($gotid,0);
						
						$getdate2 = 'select date_add(\''.$currentdate.'\', interval 1 year)';
						$gotdate2 = mysql_query($getdate2);
						$next_renew = mysql_result($gotdate2,0);
						
						$addon = "INSERT INTO domain_addons (user_id , e_domain_id, prodid, order_date, renew_date,  last_renew, extra, orderid)
							VALUES ('$user_id', $e_domain_id, '4', '$currentdate', '$next_renew', '$currentdate', 'ID Protect', '$OrderID')";
						$addon_go = mysql_query($addon);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE invoice_id='$invoice' AND sld='$sld' AND tld='$tld' AND prodid='$prodid' AND user_id='$user_id'";
						$result_update = mysql_query($sql_update);
						$message .=  "Success! $ret_command submitted in Order ID $OrderID for $sld.$tld <br>";
												
					} elseif($prodid == 5){
					
						$Enom3->AddParam( "AutoPakRenew", "0" );
						$bundleid = $Enom->Values[ "bundleid" ];
						$OrderID = $Enom->Values[ "orderid" ];
						$sql = "UPDATE domains SET pop='1' WHERE sld='$sld' AND tld='$tld'";
						$result = mysql_query($sql);
						$getid = "SELECT e_domain_id FROM domains WHERE sld='$sld' AND tld='$tld'";
						$gotid = mysql_query($getid);
						$e_domain_id = mysql_result($gotid,0);
						$getdate2 = 'select date_add(\''.$currentdate.'\', interval 1 year)';
						$gotdate2 = mysql_query($getdate2);
						$next_renew = mysql_result($gotdate2,0);
						$addon = "INSERT INTO domain_addons (user_id , e_domain_id, prodid, order_date, renew_date,  last_renew, bundleid, extra, orderid)
							VALUES ('$user_id', $e_domain_id, '5', '$currentdate', '$next_renew', curdate(), '$bundleid', 'Pop Pack', '$OrderID')";
						echo "<br>$addon<br>";
						$addon_go = mysql_query($addon);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
						$result_update = mysql_query($sql_update);
						$message .=  "Success! $ret_command submitted in Order ID $OrderID for $sld.$tld in Bundle $bundleid <br>";
												
					} elseif($prodid == 10){
						$sql = "UPDATE webhosting SET WSC='1' AND wsc_option='$wsc_option' WHERE host_id='$host_id' AND username ='$username'";
						$result = mysql_query($sql);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
						$result_update = mysql_query($sql_update);
						$message .=  "Success! $ret_command submitted in Order ID $OrderID for $sld.$tld in Bundle $bundleid <br>";
												
					} elseif($prodid == 11){
						$Enom2 = new CEnomInterface;
						$Enom2->NewRequest();
						$Enom2->AddParam( "uid", $enom_username );
						$Enom2->AddParam( "pw", $enom_password );
						$Enom2->AddParam( "HostAccount", $extra3 );
						$Enom2->AddParam( "Command", "GetHostAccount" );
						$Enom2->DoTransaction();
									
						$HostAccount = $Enom2->Values[ "HostAccount"];
						$Password = $Enom2->Values[ "Password"];
						$BandwidthGB = $Enom2->Values[ "BandwidthGB"];
						$WebStorageMB = $Enom2->Values[ "WebStorageMB"];
						$POPMailBoxes = $Enom2->Values[ "POPMailBoxes"];
						$BillingDate = $Enom2->Values[ "BillingDate"];
						
						 if($Enom2->Values[ "DatabaseType"] == 'SQL Server'){
						 $dbtype = '1';
						 $db_storage = $Enom2->Values[ "DBStorageMB"];
						 } elseif($Enom2->Values[ "DatabaseType"] == 'Access'){
						 $dbtype = '0';
						 $db_storage = $Enom2->Values[ "DatabaseType"];
						 }
						
						$getdate = "select curdate()";
						$gotdate = mysql_query($getdate);
						$currentdate = mysql_result($gotdate,0);
								 
						$getdate = 'select date_sub(\''.$currentdate.'\', interval 1 day)';
						$gotdate = mysql_query($getdate);
						$orderdate = mysql_result($gotdate,0);
						
						$getdate2 = 'select date_add(\''.$orderdate.'\', interval 1 month)';
						$gotdate2 = mysql_query($getdate2);
						$duedate = mysql_result($gotdate2,0);

						$Enom4 = new CEnomInterface;
						$Enom4->NewRequest();
						$Enom4->AddParam( "uid", $enom_username );
						$Enom4->AddParam( "pw", $enom_password );
						$Enom4->AddParam( "HostAccount", $HostAccount );
						$Enom4->AddParam( "Command", "WEBHOSTHELPINFO" );
						$Enom4->DoTransaction();

						$Server = $Enom4->Values[ "HostURI"];
										 
						$query = "INSERT INTO webhosting (user_id, username , host_username, host_password, full_name, email, package_name, product_id, package_id, db_type, db_storage, pop_boxes, disk_storage, bandwidth,  next_renew, date, order_id, price, status, IP)
						VALUES ('$user_id', '$username', '$HostAccount', '$Password', '$full_name', '$email_addy', '$p_name', '11', '$host_package', '$dbtype', '$db_storage', '$POPMailBoxes', '$WebStorageMB', '$BandwidthGB', '$duedate', '$orderdate', '$OrderID', '$charge', '0', '$Server')";
						$result = mysql_query($query);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
						$result_update = mysql_query($sql_update);
						$message .=  "Success! $ret_command submitted in Order ID $OrderID<br>";
						include("../emails/wh_order.php");
								
					} elseif($prodid == 12){
						$Enom2 = new CEnomInterface;
						$Enom2->NewRequest();
						$Enom2->AddParam( "uid", $enom_username );
						$Enom2->AddParam( "pw", $enom_password );
						$Enom2->AddParam( "tld", $tld );
						$Enom2->AddParam( "sld", $sld );
						$Enom2->AddParam( "Command", "GetDomainInfo" );
						$Enom2->DoTransaction();
						
						$domainID = $Enom2->Values[ "domainnameid" ];
						$expiration = $Enom2->Values[ "expiration" ];
						
						$query = "INSERT INTO domains (user_id , e_domain_id, sld, tld, exp_date, order_date, dns,  mail, webhosted, status, pop, idprotect, auto_renew, reg_lock, tv, parking, name_phone, name_map, password, lastupdate, e_order_id)
								  VALUES ('$user_id', $domainID, '$sld', '$tld', '$expiration', curdate(), '$dns', '0', '0', '2', '0', '0', '0', '0', '0', '0', '0', '0', 'NULL', current_timestamp(), '$OrderID')";
						$result = mysql_query ($query);
						$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
						$result_update = mysql_query($sql_update);
						$message .= "Success! $ret_command submitted in Order ID $OrderID <br>";
							
						} elseif($prodid == 15){
							$gotdate = mysql_query("select curdate()");
							$currentdate = mysql_result($gotdate,0);
							$old_renew_date2 = "SELECT next_renew FROM webhosting WHERE host_username='$extra3' AND user_id ='$user_id'"; 
							$old_renew_date1 = mysql_query($old_renew_date2);
							$old_renew_date = mysql_result($old_renew_date1,0);
							$gotdate2 = mysql_query('select date_add(\''.$old_renew_date.'\', interval 1 month)');
							$new_renew_date = mysql_result($gotdate2,0);
							$query = "UPDATE webhosting SET next_renew ='$new_renew_date', last_renew ='$currentdate' WHERE host_username='$extra3' AND user_id ='$user_id'";
							$result = mysql_query ($query);
							$sql_update = "UPDATE invoice_items SET status = '1' WHERE table_id='$table_id'";
							$result_update = mysql_query($sql_update);
							$message .= "Success! $ret_command submitted in Order ID $OrderID <br>";
							$raw = 'Succesfully Renewed Hosting Account'; 
						}//End Prodid
					
						$Enom3->AddParam( "Command", "SetRenew" );
						$Enom3->DoTransaction();
						
							$OrderID = $Enom->Values[ "OrderID" ];
							$Command  = $Enom->Values[ "Command" ];
								if(isset($Enom->Values[ "Successful" ])){
									 $Successful  = "<br>Successful = ".$Enom->Values[ "Successful" ];
								}
							$ErrCount  = $Enom->Values[ "ErrCount" ];
							$err1  = $Enom->Values[ "ErrCount" ];
							echo "<br><br>Result:<br>OrderID = $OrderID<br>Command = $Command$Successful<br>ErrCount = $ErrCount<br><br>";
						
						break;
						default:
							$error_msg = $Enom->Values[ "Err1" ] ;
							$message =  "Updating the Status of the order in the DB to failed";
							$sql_update = "UPDATE invoice_items SET status = '2', err1 = '$error_msg' WHERE table_id='$table_id'";
							$result_update = mysql_query($sql_update);
						break;
						}  // END OF SWITCH
						
		echo "$Num/$count3.) Invoice: $invoice Domain: $sld.$tld Action:$action $message<br>";
		if($errors >= 1){
			echo "<br>ERROR: $Err1<br>";
			}
		echo "Recording API Response in the Log <br>";
		$response = "UPDATE invoice_items SET response='$raw' WHERE table_id='$table_id'";
		if($showraw == 1){
				echo $response . '<br>';
		}
		$write_response = mysql_query($response);
		echo "Done Updating Response<br><br>";
		
		$raw = '';
		$Num = ($Num + 1);
	} //END OF THE SECOND WHILE
	
					$sqlcount = "SELECT COUNT(*) FROM invoice_items WHERE NOT status = '0' AND invoice_id='$invoice'";
					$result_count = mysql_query($sqlcount);
					$count2 = mysql_result ($result_count,0);
							if($count2 == $count3){
								//echo "Count2 = Count3.  That means close the invoice<br>";
								$close_invoice = "UPDATE customer_invoice SET status='1' WHERE invoice_id='$invoice'";
								$result_close = mysql_query($close_invoice);
								echo "<br>Invoice $invoice has been closed.";
								# _ _ _ _ MAIL HERE _ _ _ _ #			
					$query_info = "SELECT fname, lname, email FROM users WHERE username='$username' AND id='$user_id'";
					$result_info = @mysql_query($query_info);
					$row_info = mysql_fetch_array($result_info, MYSQL_ASSOC);
					$fname = $row_info[fname];
					$lname = $row_info[lname];
					$email = $row_info[email];
	
					$query11 = "SELECT * FROM invoice_items WHERE invoice_id='$invoice'";
					$result11 = @mysql_query ($query11);
					while ($row11 = mysql_fetch_array ($result11, MYSQL_ASSOC)) {
					$prodid = $row11[prodid];
					$table_id = $row11[table_id];
					$err1 = $row11[err1];
					$status = $row11[status];
					
					if($status == 1){
					} elseif($status == 2){
						$StatusOrder = "Failed    - ";
						$price = '0.00';
					}
					
					$query21 = "SELECT * FROM products where prodid='$prodid'";		
					$result21 = @mysql_query ($query21);
					$row21 = mysql_fetch_array($result21, MYSQL_ASSOC);
					$product_name = $row21[product_name];
						if($product_name == "Web Hosting"){
						$product_name .= " - $row11[extra]";
						}
						if($prodid == '3'){
						$OrderType = $row21[extra3];
						}
					
				if($row[extra1] == "CreateHostAccount"){
				$domain = "Username: $row11[extra] - $row11[p_name] Plan";
				} else {
				$domain = "$row11[sld].$row11[tld]";
				} 
		
		$GetCount = "SELECT count(*) from invoice_items WHERE invoice_id='$invoice' AND status='1'";
		$GetCount_result = @mysql_query ($GetCount);
		$GetCount_row = mysql_fetch_array($GetCount_result, MYSQL_NUM);
		
			if(($GetCount_row[0] == '0') || ($GetCount_row[0] == '')){
				$amount_billed = '0.00';
				} else {
				$query_billed = "SELECT SUM(qty * price) FROM invoice_items WHERE invoice_id='$invoice' AND status='1'";
				$result_billed = @mysql_query ($query_billed);
				$row_billed = mysql_fetch_array($result_billed, MYSQL_NUM);
				$amount_billed = $row_billed[0];
				}
			
			if($status == 1){
			$body3 .= "Succesfull- $product_name $domain\n";
			} elseif($status == 2){
			$body3 .= "Failed    - $product_name $domain\n   -$err1\n";
			}
		}													
									include("../emails/close_invoice.php");

									#------------------------
									$sql = mysql_query("OPTIMIZE TABLE cart");
									$sql = mysql_query("OPTIMIZE TABLE invoice_items");
									$sql = mysql_query("OPTIMIZE TABLE check_log");
									$sql = mysql_query("OPTIMIZE TABLE contact");
									$sql = mysql_query("OPTIMIZE TABLE customer_invoice");
									$sql = mysql_query("OPTIMIZE TABLE domains");
									$sql = mysql_query("OPTIMIZE TABLE domain_addons");
									$sql = mysql_query("OPTIMIZE TABLE news");
									$sql = mysql_query("OPTIMIZE TABLE push_log");
									$sql = mysql_query("OPTIMIZE TABLE transfers");
									$sql = mysql_query("OPTIMIZE TABLE webhosting");
									$sql = mysql_query("OPTIMIZE TABLE users");
									$sql = mysql_query("OPTIMIZE TABLE whois_log");
									#------------------------
									
										$sql_count = "SELECT COUNT(*) FROM customer_invoice WHERE paid = '1' AND status = '0' ORDER BY invoice_id";
										$result_count = mysql_query($sql_count);
										$row_count = mysql_result ($result_count,0);
								}//END IF
	}//END FIRST WHILE
}//END IF row_count