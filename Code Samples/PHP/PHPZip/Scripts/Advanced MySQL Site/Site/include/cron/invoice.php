<link rel="stylesheet" href="../../css/styles.css" type="text/css"> 
<?php  
include ("../dbconfig.php");

#--- Cron invoice Function ---#
if(isset($_GET['Z-debug-mode'])){
	$debug = $_GET['Z-debug-mode'];
} elseif(isset($showscreen)){
	$debug = $showscreen;
	}
 
$query = "SELECT COUNT( * )
FROM domains
WHERE status='1'";
$result = @mysql_query ($query);
$row = mysql_fetch_array($result, MYSQL_NUM);

$getdate = "select curdate()";
$gotdate = mysql_query($getdate);
$currentdate = mysql_result($gotdate,0);

if($debug == 1){
echo "Current date is: $currentdate<br>";
echo "Checking $row[0] Domain(s) Expiration dates.";
echo "<br>Sending Invoices Where applicable - Please wait, this may take a few minutes<br>";
}
//Start the admin email containing the results of the invoice run
#--------Build the Result Email for the admin---------------#
$subject = "Nightly Invoice Run results"; 
$body = "Result of the Invoice generation Run:\n\n";
$body .= "Domains:\n";
			
# - - 30 day run - - #
$time = '30';

	$body .= "\n\n Domains Expiring in $time Days:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_add(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);

#--------------------- Domain Invoicing Section ------------#
$sql = "select * from domains WHERE status='1' ORDER BY sld DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$sld = $row[sld];
	$tld = $row[tld];
	$domainID = $row[e_domain_id];
	$order_date = $row[order_date];
	$exp_date = $row[exp_date];
	$user_id = $row[user_id];
	
	//determine if renewal is in the next X amount of days - and if so then send an email to the user
				$getuser = "select * from users where id='$user_id'";
				$gotuser = mysql_query($getuser);
				$row = mysql_fetch_array($gotuser, MYSQL_ASSOC);
				$username = $row[username];
				$email = $row[email];
				$fname = $row[fname];
				$lname = $row[lname];
			if($exp_date == $expiredate){ 
				$body .= "Domain: $sld.$tld	 User: $username Expiration Date: $exp_date";
if($debug == 1){
				echo "Domain: $sld.$tld	 User: $username Order Date: $order_date Expiration: $exp_date<br>";
}
				//Now process the domains exp date and send a reminder email if ncessary
						#--------Build the Email ---------------#
						$subject = "Domain Renewal Notice! -- $sld.$tld"; 
						$body = "Hello $fname $lname,\n\n";
						$body .= "Your domain $sld.$tld at $CompanyName is going to expire within $time days in your $username account.\n\n";
						$body .= "If this is a domain that you wish to keep please login to your account and from the 'My Account' section, go to my domains, and upon clicking on the domain name will take you to the domains control panel.  Once in the domains control panel there is a place in the first section for domain name renewal.\n\n";
						$body .= "If The domain is currently expired (its now past $time days from the reciept of the email) the domain will be in the 'Expired Domains' tab under 'My Account'.\n\n";
						$body .= "\n\n";
						$body .= "Sincerely,\n\n$email_fromsupport\n";
						$body .= "$support_email\n";
						$body .= "$support_phone\n";
						$headers = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email, $subject, $body, $headers);
					#-----End the email section ---------#
				$body .=  "\nEmail Sent to $fname $lname at $email\n\n";
if($debug == 1){
				echo "<span class=\"BasicText\">Email Sent to $fname $lname at $email</span><br>";
}				
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domains WHERE exp_date ='$expiredate' AND status='1'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
				if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>There are No domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n There are no domains are expiring in $time days\n";
			} else {
				if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Sent emails for $count3[0] domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] domains expiring in $time days\n";
			}
#--------------------- END 30 day section ------------#

# - - 14 day run - - #
$time = '14';
	$body .= "\n\n Domains Expiring in $time Days:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_add(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);
#--------------------- Domain Invoicing Section ------------#

$sql = "select * from domains WHERE status='1' ORDER BY sld DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$sld = $row[sld];
	$tld = $row[tld];
	$domainID = $row[e_domain_id];
	$order_date = $row[order_date];
	$exp_date = $row[exp_date];
	$user_id = $row[user_id];
	
	//determine if renewal is in the next X amount of days - and if so then send an email to the user
				$getuser = "select * from users where id='$user_id'";
				$gotuser = mysql_query($getuser);
				$row = mysql_fetch_array($gotuser, MYSQL_ASSOC);
				$username = $row[username];
				$email = $row[email];
				$fname = $row[fname];
				$lname = $row[lname];
			if($exp_date == $expiredate){ 
				$body .= "Domain: $sld.$tld	 User: $username Expiration Date: $exp_date";
			if($debug == 1){
				echo "Domain: $sld.$tld	 User: $username Order Date: $order_date Expiration: $exp_date<br>";
				}
				//Now process the domains exp date and send a reminder email if ncessary
						#--------Build the Email ---------------#
						$subject2 = "Domain Renewal Notice! -- $sld.$tld"; 
						$body2 = "Hello $fname $lname,\n\n";
						$body2 .= "Your domain $sld.$tld at $CompanyName is going to expire within $time days in your $username account.\n\n";
						$body2 .= "If this is a domain that you wish to keep please login to your account and from the 'My Account' section, go to my domains, and upon clicking on the domain name will take you to the domains control panel.  Once in the domains control panel there is a place in the first section for domain name renewal.\n\n";
						$body2 .= "If The domain is currently expired (its now past $time days from the reciept of the email) the domain will be in the 'Expired Domains' tab under 'My Account' .\n\n";
						$body2 .= "\n\n";
						$body2 .= "Sincerely,\n\n$email_fromsupport\n";
						$body2 .= "$support_email\n";
						$body2 .= "$support_phone\n";
						$headers2 = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers2 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email2, $subject2, $body2, $headers2);
					#-----End the email section ---------#
				$body .=  "\nEmail Sent to $fname $lname at $email\n\n";
			if($debug == 1){
				echo "<span class=\"BasicText\">Email Sent to $fname $lname at $email</span><br>";
				}
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domains WHERE exp_date ='$expiredate' AND status='1'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>There are No domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n There are no domains are expiring in $time days\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Sent emails for $count3[0] domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] domains expiring in $time days\n";
			}
#--------------------- END 30 day section ------------#

# - - 7 day run - - #
$time = '7';
	$body .= "\n\n Domains Expiring in $time Days:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_add(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);
#--------------------- Domain Invoicing Section ------------#

$sql = "select * from domains WHERE status='1' ORDER BY sld DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$sld = $row[sld];
	$tld = $row[tld];
	$domainID = $row[e_domain_id];
	$order_date = $row[order_date];
	$exp_date = $row[exp_date];
	$user_id = $row[user_id];
	
	//determine if renewal is in the next X amount of days - and if so then send an email to the user
				$getuser = "select * from users where id='$user_id'";
				$gotuser = mysql_query($getuser);
				$row = mysql_fetch_array($gotuser, MYSQL_ASSOC);
				$username = $row[username];
				$email3 = $row[email];
				$fname = $row[fname];
				$lname = $row[lname];
			if($exp_date == $expiredate){ 
				$body .= "Domain: $sld.$tld	 User: $username Expiration Date: $exp_date";
			if($debug == 1){
				echo "Domain: $sld.$tld	 User: $username Order Date: $order_date Expiration: $exp_date<br>";
				}
				//Now process the domains exp date and send a reminder email if ncessary
						#--------Build the Email ---------------#
						$subject3 = "Domain Renewal Notice! -- $sld.$tld"; 
						$body3 = "Hello $fname $lname,\n\n";
						$body3 .= "Your domain $sld.$tld at $CompanyName is going to expire within $time days in your $username account.\n\n";
						$body3 .= "If this is a domain that you wish to keep please login to your account and from the 'My Account' section, go to my domains, and upon clicking on the domain name will take you to the domains control panel.  Once in the domains control panel there is a place in the first section for domain name renewal.\n\n";
						$body3 .= "If The domain is currently expired (its now past $time days from the reciept of the email) the domain will be in the 'Expired Domains' tab under 'My Account' .\n\n";
						$body3 .= "\n\n";
						$body3 .= "Sincerely,\n\n$email_fromsupport\n";
						$body3 .= "$support_email\n";
						$body3 .= "$support_phone\n";
						$headers3 = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers3 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email3, $subject3, $body3, $headers3);
					#-----End the email section ---------#
				$body .=  "\nEmail Sent to $fname $lname at $email\n\n";
			if($debug == 1){
				echo "<span class=\"BasicText\">Email Sent to $fname $lname at $email</span><br>";
				}
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domains WHERE exp_date ='$expiredate' AND status='1'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>There are No domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n There are no domains are expiring in $time days\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Sent emails for $count3[0] domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] domains expiring in $time days\n";
			}
#--------------------- END 7 day section ------------#

# - - 3 day run - - #
$time = '3';
	$body .= "\n\n Domains Expiring in $time Days:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_add(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);
#--------------------- Domain Invoicing Section ------------#

$sql = "select * from domains WHERE status='1' ORDER BY sld DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$sld = $row[sld];
	$tld = $row[tld];
	$domainID = $row[e_domain_id];
	$order_date = $row[order_date];
	$exp_date = $row[exp_date];
	$user_id = $row[user_id];
	
	//determine if renewal is in the next X amount of days - and if so then send an email to the user
				$getuser = "select * from users where id='$user_id'";
				$gotuser = mysql_query($getuser);
				$row = mysql_fetch_array($gotuser, MYSQL_ASSOC);
				$username = $row[username];
				$email4 = $row[email];
				$fname = $row[fname];
				$lname = $row[lname];
			if($exp_date == $expiredate){ 
				$body .= "Domain: $sld.$tld	 User: $username Expiration Date: $exp_date";
			if($debug == 1){
				echo "Domain: $sld.$tld	 User: $username Order Date: $order_date Expiration: $exp_date<br>";
			}	
				//Now process the domains exp date and send a reminder email if ncessary
						#--------Build the Email ---------------#
						$subject4 = "Domain Renewal Notice! -- $sld.$tld"; 
						$body4 = "Hello $fname $lname,\n\n";
						$body4 .= "Your domain $sld.$tld at $CompanyName is going to expire within $time days in your $username account.\n\n";
						$body4 .= "If this is a domain that you wish to keep please login to your account and from the 'My Account' section, go to my domains, and upon clicking on the domain name will take you to the domains control panel.  Once in the domains control panel there is a place in the first section for domain name renewal.\n\n";
						$body4 .= "If The domain is currently expired (its now past $time days from the reciept of the email) the domain will be in the 'Expired Domains' tab under 'My Account' .\n\n";
						$body4 .= "\n\n";
						$body4 .= "Sincerely,\n\n$email_fromsupport\n";
						$body4 .= "$support_email\n";
						$body4 .= "$support_phone\n";
						$headers4 = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers4 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email4, $subject4, $body4, $headers4);
					#-----End the email section ---------#
				$body .=  "\nEmail Sent to $fname $lname at $email\n\n";
			if($debug == 1){
				echo "<span class=\"BasicText\">Email Sent to $fname $lname at $email</span><br>";
				}
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domains WHERE exp_date ='$expiredate' AND status='1'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>There are No domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n There are no domains are expiring in $time days\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Sent emails for $count3[0] domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] domains expiring in $time days\n";
			}
#--------------------- END 3 day section ------------#

# - - 1 day run - - #
$time = '1';
	$body .= "\n\n Domains Expiring in $time Days:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_add(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);
#--------------------- Domain Invoicing Section ------------#

$sql = "select * from domains WHERE status='1' ORDER BY sld DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$sld = $row[sld];
	$tld = $row[tld];
	$domainID = $row[e_domain_id];
	$order_date = $row[order_date];
	$exp_date = $row[exp_date];
	$user_id = $row[user_id];
	
	//determine if renewal is in the next X amount of days - and if so then send an email to the user
				$getuser = "select * from users where id='$user_id'";
				$gotuser = mysql_query($getuser);
				$row = mysql_fetch_array($gotuser, MYSQL_ASSOC);
				$username = $row[username];
				$email5 = $row[email];
				$fname = $row[fname];
				$lname = $row[lname];
			if($exp_date == $expiredate){ 
				$body .= "Domain: $sld.$tld	 User: $username Expiration Date: $exp_date";
			if($debug == 1){
				echo "Domain: $sld.$tld	 User: $username Order Date: $order_date Expiration: $exp_date<br>";
				}
				//Now process the domains exp date and send a reminder email if ncessary
						#--------Build the Email ---------------#
						$subject5 = "Domain Renewal Notice! -- $sld.$tld"; 
						$body5 = "Hello $fname $lname,\n\n";
						$body5 .= "Your domain $sld.$tld at $CompanyName is going to expire within $time days in your $username account.\n\n";
						$body5 .= "If this is a domain that you wish to keep please login to your account and from the 'My Account' section, go to my domains, and upon clicking on the domain name will take you to the domains control panel.  Once in the domains control panel there is a place in the first section for domain name renewal.\n\n";
						$body5 .= "If The domain is currently expired (its now past $time days from the reciept of the email) the domain will be in the 'Expired Domains' tab under 'My Account' .\n\n";
						$body5 .= "\n\n";
						$body5 .= "Sincerely,\n\n$email_fromsupport\n";
						$body5 .= "$support_email\n";
						$body5 .= "$support_phone\n";
						$headers5 = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers5 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email5, $subject5, $body5, $headers5);
					#-----End the email section ---------#
				$body .=  "\nEmail Sent to $fname $lname at $email\n\n";
			if($debug == 1){
				echo "<span class=\"BasicText\">Email Sent to $fname $lname at $email</span><br>";
				}
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domains WHERE exp_date ='$expiredate' AND status='1'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>There are No domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n There are no domains are expiring in $time days\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Sent emails for $count3[0] domains expiring in $time days</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] domains expiring in $time days\n";
			}
#--------------------- END 1 day section ------------#

# - -   What to do when the domain is expired - - - #

$time = '1';
	$body .= "\n\n Expired Domains:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_sub(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);
#--------------------- Domain Invoicing Section ------------#

$sql = "select * from domains WHERE status='1' ORDER BY sld DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$sld = $row[sld];
	$tld = $row[tld];
	$domainID = $row[e_domain_id];
	$order_date = $row[order_date];
	$exp_date = $row[exp_date];
	$user_id = $row[user_id];
			if($exp_date == $expiredate){ 
				$sql = "UPDATE domains SET status='0' WHERE e_domain_id = '$domainID' AND user_id='$user_id'";
				$sql_result = mysql_query($sql);
					if($sql_result){
						$body .= "Domain: $sld.$tld	 User: $username - Marked as Expired\n";
					if($debug == 1){
						echo "Domain: $sld.$tld	 User: $username - Marked as Expired<br>";
					}
						}
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domains WHERE exp_date ='$expiredate'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>No Domains Expired today</span></b></center><br>";
				}
				$body .= "\n No Domains Expired today\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Marked $count3[0] domains as expired</span></b></center><br>";
				}
				$body .= "\n Marked $count3[0] domains as expired\n";
			}
#--------------------- END Expire the domain section ------------#

# - -   Does the domain need to be in RGP - - - #

$time = '29';
	$body .= "\n\n Domains Entering RGP:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_sub(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);
#--------------------- Domain Invoicing Section ------------#

$sql = "select * from domains WHERE status='0' ORDER BY sld DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$sld = $row[sld];
	$tld = $row[tld];
	$domainID = $row[e_domain_id];
	$order_date = $row[order_date];
	$exp_date = $row[exp_date];
	$user_id = $row[user_id];
			if($exp_date == $expiredate){ 
				$sql = "UPDATE domains SET status='3' WHERE e_domain_id = '$domainID' AND user_id='$user_id' AND status='0'";
				$sql_result = mysql_query($sql);
					if($sql_result){
						$body .= "Domain: $sld.$tld	 User: $username - Entered Redemption\n";
						}
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domains WHERE exp_date ='$expiredate'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>No Domains Expired today</span></b></center><br>";
				}
				$body .= "\n No Domains entered RGP today\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Marked $count3[0] domains as expired</span></b></center><br>";
				}
				$body .= "\n $count3[0] domains went into RGP today\n";
			}
#--------------------- END RGP section ------------#
# - -  - -  - -  - -  - -  - - -  - - - - - - - - - end domain section - - - - - - - - -

# - -  - -  - -  - -  - -  - - -  - - - - - - - - - - - - - - - - - - - - -- - - - - - - 
#   WEB HOSTING INVOICE SECTION
#--- Cron invoice Function ---# 

$query = "SELECT COUNT( * )
FROM webhosting
WHERE status='1'";
$result = @mysql_query ($query);
$row = mysql_fetch_array($result, MYSQL_NUM);

$getdate = "select curdate()";
$gotdate = mysql_query($getdate);
$currentdate = mysql_result($gotdate,0); 

if($debug == 1){
echo "<br>Checking Hosting Accounts.<br>";
echo "Checking $row[0] Hosting account(s) Expiration dates.";
}
# - - 7 day run - - #
$time = '7';

	$body .= "\n\n Hosting accounts coming up for renewal in $time Days:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_add(\''.$currentdate.'\', interval '.$time.' day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);

#--------------------- Domain Invoicing Section ------------#
$sql = "select * from webhosting WHERE status='1' ORDER BY host_id DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$userid = $row[user_id];
	$username = $row[username];
	$full_name = $row[full_name];
	$host_username = $row[host_username];
	$host_password = $row[host_password];
	$email6 = $row[email];
	$package_id  = $row[package_id];
	$package_name = $row[package_name];
	$price = $row[price];
	$next_renew = $row[next_renew];
	
if($expiredate == $next_renew){ 
	$body .= " Username: $username\n Hosting Username: $host_username \n Renewal Date: $next_renew \n Package: $package_name";
if($debug == 1){
	echo "Username: $username	Hosting Username: $host_username Next Renewal Date: $next_renew Package: $package_name<br>";
}
	//Create the user an invoice
	$query_invoice = "SELECT invoice_count FROM extra";
	$result_invoice = @mysql_query($query_invoice);
	$row_invoice = mysql_fetch_array($result_invoice, MYSQL_NUM); 
	$invoice_id = ($row_invoice[0]+1);
	$query_check = "SELECT invoice_id FROM customer_invoice WHERE invoice_id='$invoice_id'";
	//Runs the qyery and Sets the variable for Invoice Starting position
	$result_check = @mysql_query ($query_check);
		if(mysql_num_rows($result_check) == 0){
				//Inserts the New Invoice into the invoice table
				$query1 = "INSERT INTO customer_invoice (user_id, username, invoice_id, paid, status, amount_due, date)
							VALUES ('$userid', '$username', '$invoice_id', '0', '0', '$price', NOW() )";
				$result1 = mysql_query($query1); 
				$query2 = "INSERT INTO invoice_items (user_id, invoice_id, status, prodid, price, qty, command, host_package, host_username, host_password, full_name, email_addy, p_name)
				VALUES ('$userid', '$invoice_id', '0', '15', '$price', '1', 'Renew Hosting', '$package_id', '$host_username', '$host_password', '$full_name', '$email', '$package_name')";
				$result2 = mysql_query($query2);
		if($result2){	
				//Update the Invoice Count
				$query1 = "UPDATE extra SET invoice_count='$invoice_id' WHERE id='1'";
				$result1 = @mysql_query($query1);
				//Now process the renew date and send a reminder email if ncessary
						#--------Build the Email ---------------#
						$subject6 = "Web Hosting Renewal Invoice"; 
						$body6 = "Hello $full_name,\n\n";
						$body6 .= "Your Hosting account at $CompanyName is up for renewal in 7 days in your $username account.\n\n";
						$body6 .= "This is in reference to the hosting account with the username $host_username with the $package_name plan.\n\n";
						$body6 .= "We have created invoice $invoice_id for your convenience, and it can be viewed by going to $site_url/viewinvoice.php?invoice=$invoice_id&refer=myinvoices\n\n";
						$body6 .= "\n\n";
						$body6 .= "To Pay your invoice please go to $site_url/pay_invoice.php?invoice=695&action=pay or from the 'My Invoices' page, click on the 'View/Pay Invoice' of the invoice you wish to pay for.\n\n";
						$body6 .= "Due to the number of accounts we manage, this is going to be the only renewal notice we send out.  If we do not recieve payment for the hosting account it will be automatically terminated on $expiredate\n\n\n";
						$body6 .= "Sincerely,\n\n$email_fromsupport\n";
						$body6 .= "$support_email\n";
						$body6 .= "$support_phone\n";
						$headers6 = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers6 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email6, $subject6, $body6, $headers6);
						
						$getuserinfo = "select * from users where id='$userid'";
						$gotuserinfo = mysql_query($getuserinfo);
						$row2 = mysql_fetch_array($gotuserinfo, MYSQL_ASSOC);
						$username = $row2[username];
						$email7 = $row2[email];
						$fname = $row2[fname];
						$lname = $row2[lname];
						
			if($debug == 1){
						echo $getuserinfo.'<br>';
				}
						
						//Send the invoice Generation emails
						$subject7 = "New Invoice has been Created at $CompanyName"; 
						$body7 .= "Hello $fname $lname, \n\n\n";
						$body7 .= "Below is a summary or your recent transaction:\n\n";
						$body7 .= "------------------------------------------------------------------\n";
						$body7 .= "InvoiceID      : $invoice_id\n";
						$body7 .= "Invoice Date   : $currentdate\n";
						$body7 .= "FirstName      : $fname\n";
						$body7 .= "LastName       : $lname\n";
						$body7 .= "Total Charges  : \$$price\n";
						$body7 .= "------------------------------------------------------------------\n\n\n";
						$body7 .= "Regards,\n";
						$body7 .= "$email_fromadmin \n";
						$headers7 .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers7 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email7, $subject7, $body7, $headers7);

					#-----End the email section ---------#
				$body .=  "\n Email Sent to $full_name at $email\n\n";
			if($debug == 1){
				echo "<span class=\"BasicText\">Email Sent to $full_name at $email</span><br>";
				}
		} else {
	if($debug == 1){
		echo "<span class=\"BasicText\">Could not create invoice - Email not sent</span><br>";
	}
		}
			}
	} 
}
			$count1 = "SELECT COUNT(*) FROM webhosting WHERE next_renew ='$expiredate' AND status='1'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>There are No Hosting accounts expiring in $time days</span></b></center><br>";
				}
				$body .= "\n There are no hosting accounts up for renewal in the next $time days\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Sent emails for $count3[0] Hosting accounts up for renewal in $time days</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] hosting accounts up for renewal in the next $time days\n";
			}
#--------------------- END 30 day section ------------#

# - -  Now what to do when its past paydate
	$body .= "\n\n Cancelled overdue Hosting accounts:\n";
	$body .= "--------------------------------";

#--------------------- Invoicing Section ------------#
$sql = "select * from webhosting WHERE status='1' ORDER BY host_id DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	
	$userid = $row[user_id];
	$username = $row[username];
	$full_name = $row[full_name];
	$host_username = $row[host_username];
	$host_password = $row[host_password];
	$email = $row[email];
	$package_id  = $row[package_id];
	$package_name = $row[package_name];
	$price = $row[price];
	$next_renew = $row[next_renew];
	
if($currentdate == $next_renew){ 
	$sql1 = "UPDATE webhosting SET status='3' WHERE user_id='$userid' AND host_username='$host_username'";
	$sql2 = mysql_query($sql1);
		if($sql2){ 
		//If the result was ok - then Set the host account deletion flag
				require ("../EnomInterface_inc.php");
		 		$Enom = new CEnomInterface; 
				$Enom->AddParam( "uid", $enom_username );
				$Enom->AddParam( "pw", $enom_password );
				$Enom->AddParam( "site", $sitename );
				$Enom->AddParam( "HostAccount", $host_username );
				$Enom->AddParam( "Delete", "1" );
				$Enom->AddParam( "Enable", "0" );
				$Enom->AddParam( "command", "CancelHostAccount" );
				$Enom->DoTransaction();
				
				if($Enom->Values[ "ErrCount" ] != '0'){
						$Err1 = $Enom->Values[ "Err1" ];
					//Error, send an email to the admin
						$subject8 = "$CompanyName ERROR - Delete Hosting"; 
						$body8 = "Hello $CompanyName support,\n\n\n";
						$body8 .= "The site recently encountered an error in attempting the following action:\n\n";
						$body8 .= "------------------------------------------------------------------\n";
						$body8 .= "Action	      : Cancel Hosting Account\n";
						$body8 .= "Host Account   : $host_username\n";
						$body8 .= "Plan		      : $package_name\n";
						$body8 .= "Error          : $Err1\n";
						$body8 .= "------------------------------------------------------------------\n\n\n";
						$body8 .= "Regards,\n";
						$body8 .= "$email_fromadmin \n";
						$headers8 .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers8 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($support_email, $subject8, $body8, $headers8);
					} elseif($Enom->Values[ "ErrCount" ] == '0'){
						$body .= " Username: $username\n Hosting Username: $host_username Package: $package_name";
			if($debug == 1){
						echo "Username: $username Hosting Username: $host_username Package: $package_name<br>";
						}
					}
			}
	} 
}
			$count1 = "SELECT COUNT(*) FROM webhosting WHERE next_renew ='$currentdate' AND status='3'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<span class=\"BasicText\"><b>There are No Past Due Hosting accounts</span></b></center><br><br>";
				}
				$body .= "\n There are No Past Due Hosting accounts\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Cancelled $count3[0] Hosting accounts for being past due</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] Hosting accounts for being past due\n";
			}
#--------------------- END Cancellation section ------------#
#---------------------------------# END	WEB HOSTING SECTION #------------------------------------#


#---------------------------------##---------------------------------##--------------------------#
#---------------------------------# START DOMAIN ADDON SECTION #---------------------------------#

#--- Cron invoice ---#

$query = "SELECT COUNT( * )
FROM domain_addons";
$result = @mysql_query ($query);
$row = mysql_fetch_array($result, MYSQL_NUM);

$getdate = "select curdate()";
$gotdate = mysql_query($getdate);
$currentdate = mysql_result($gotdate,0);

if($debug == 1){
echo "Checking $row[0] Domain(s) Addon Expiration dates.";
}

# - - 7 day run - - #
	$body .= "\n\n Addons Expiring in 7 Days:\n";
	$body .= "--------------------------------";

$getdate2 = 'select date_add(\''.$currentdate.'\', interval 7 day)';
$gotdate2 = mysql_query($getdate2);
$expiredate = mysql_result($gotdate2,0);
#--------------------- Domain Invoicing Section ------------#

$sql = "select * from domain_addons ORDER BY id DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	$rowid = $row[id];
	$e_domain_id = $row[e_domain_id];
	$prodid = $row[prodid];
	$order_date = $row[order_date];
	$renew_date = $row[renew_date];
	$last_renew = $row[last_renew];
	$extra = $row[extra];
	
	if($prodid == '5'){
		$bundleid = $row[bundleid];
		$num_bunlde = $row[num_bunlde];
	}

	$sql2 = mysql_query("SELECT user_id, sld, tld FROM domains WHERE e_domain_id = '$e_domain_id'");
	$results = mysql_fetch_row($sql2);
	$user_id = $results[0];
	$sld = $results[1];
	$tld = $results[2];
	
	//determine if renewal is in the next X amount of days - and if so then send an email to the user
	
				$getuser = "select * from users where id='$user_id'";
				$gotuser = mysql_query($getuser);
				$row = mysql_fetch_array($gotuser, MYSQL_ASSOC);
				$username = $row[username];
				$email9 = $row[email];
				$fname = $row[fname];
				$lname = $row[lname];
				
			if($renew_date == $expiredate){ 
				$body .= "Domain: $sld.$tld Addon: $extra Expiration: $renew_date";
				$body .= " User: $username Domain ID: $e_domain_id\n\n";
			if($debug == 1){
				echo "Domain: $sld.$tld Addon: $extra Expiration: $renew_date";
				echo "User: $username Domain ID: $e_domain_id<br>";
			}
				//Now process the domains exp date and send a reminder email if ncessary
						#--------Build the Email ---------------#
						$subject9 = "Domain Addon Renewal Notice! -- $extra for $sld.$tld"; 
						$body9 = "Hello $fname $lname,\n\n";
						$body9 .= "Your domain addon - $extra for $sld.$tld at $CompanyName is going to expire within 7 days in your $username account.\n\n";
						$body9 .= "If this is a service that you wish to keep please login to your account and from the 'My Account' section, go to my domains, and upon clicking on the domain name will take you to the domains control panel.  Once in the domains control panel there is a place in the first section for domain name renewal.\n\n";
						$body9 .= "If The domain or service is currently expired then it will need to be re-ordered to become active again.\n\n";
						$body9 .= "\n\n";
						$body9 .= "Sincerely,\n\n$email_fromsupport\n";
						$body9 .= "$support_email\n";
						$body9 .= "$support_phone\n";
						$headers9 = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers9 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($email9, $subject9, $body9, $headers9);
					#-----End the email section ---------#
			if($debug == 1){
				echo "<span class=\"BasicText\">Email Sent to $fname $lname at $email</span><br>";
				}
			} 
	}
			$count1 = "SELECT COUNT(*) FROM domain_addons WHERE renew_date ='$expiredate'";
			$count2 = @mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);

			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>There are No Domain Addons expiring within 7 days</span></b></center><br>";
				}
				$body .= "\n There are no Domain Addons expiring within 7 days\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Sent emails for $count3[0] Domain Addons expiring within 7 days</span></b></center><br>";
				}
				$body .= "\n Sent emails for $count3[0] Domain Addons expiring within 7 days\n";
			}
#--------------------- END 7 day section ------------#

# - -  -  - Delete the Addon Service and remove it from the domains db
	$body .= "\n\n Addons Removed from DB/Domains:\n";
	$body .= "--------------------------------\n";

			$count1 = "SELECT COUNT(*) FROM domain_addons WHERE renew_date ='$currentdate'";
			$count2 = mysql_query ($count1);
			$count3 = mysql_fetch_array($count2, MYSQL_NUM);


$sql = "SELECT domain_addons.id as addons_id, domains.user_id as user_id, domains.e_domain_id as e_domain_id, domains.sld as sld, domains.tld as tld, domain_addons.order_date AS order_date, domain_addons.renew_date AS exp_date, domains.pop as pop, domains.idprotect as idprotect, domain_addons.bundleid as bundleid, domain_addons.num_bundle, domain_addons.prodid as prodid, domain_addons.extra as extra
FROM domains, domain_addons
WHERE domain_addons.e_domain_id = domains.e_domain_id
AND domains.user_id = domain_addons.user_id
ORDER BY addons_id, domains.user_id DESC";
$sql_result = mysql_query($sql);
while ($row = mysql_fetch_array ($sql_result, MYSQL_ASSOC)) { 
	$rowid = $row[addons_id];
	$user_id = $row[user_id];
	$e_domain_id = $row[e_domain_id];
	$prodid = $row[prodid];
	$order_date = $row[order_date];
	$renew_date = $row[exp_date];
	$last_renew = $row[last_renew];
	$extra = $row[extra];
	$bundleid = $row[bundleid];
	$num_bunlde = $row[num_bundle];
	$sld = $row[sld];
	$tld = $row[tld];

		if($renew_date == $currentdate){
			if($prodid == '4'){
				$sql_update = "DELETE from domain_addons WHERE id = '$rowid' and extra='$extra'";
				$run_sql = mysql_query($sql_update);
					if($run_sql){
						$sql2 = "UPDATE domains SET idprotect = '0' WHERE e_domain_id = '$e_domain_id'";
						$run_sql2 = mysql_query($sql2);
							if($run_sql2){
								if($debug == 1){
								echo "Updated $sld.$tld - Removed $extra<br>";
								}
								$body .= "Updated $sld.$tld - Removed $extra\n";
								}
							}
		} elseif($prodid == 5){
		echo "<br>Domain $sld.$tld Number of Bundles: $num_bunlde<br>";
			if($num_bunlde >= 2){
				$new_num = $num_bunlde - 1;
				$sql2 = "UPDATE domain_addons SET num_bundle = '$new_num' WHERE e_domain_id = '$e_domain_id'";
				$run_sql2 = mysql_query($sql2);
					if($run_sql2){
						if($debug == 1){
						echo "Updated $extra for Domain $sld.$tld - adjusted to $new_num Bundles<br>";
							}
						$body .= "Updated $extra for Domain $sld.$tld - adjusted to $new_num Bundles\n";
					}
			} else {
				$sql_update = "DELETE from domain_addons WHERE id = '$rowid' and extra='$extra'";
				$run_sql = mysql_query($sql_update);
					if($run_sql){
						$sql3 = "UPDATE domains SET	pop = '0' WHERE WHERE e_domain_id = '$e_domain_id'";
						$result3 = mysql_query($sql3);
						$new_num = "$num_bunlde - 1";
						if($debug == 1){
						echo "Updated $extra for Domain $sld.$tld - Removed Pop Bundles<br>";
						}
						$body .= "Updated $extra for Domain $sld.$tld - Removed Pop Bundles\n";
					}
				} 
			}
		}
	}
			if($count3[0] == '0'){
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>No Domain Addons Removed</span></b></center><br>";
				}
				$body .= "\n No Domain Addons Removed\n";
			} else {
			if($debug == 1){
				echo "<br><span class=\"BasicText\"><b>Removed $count3[0] expired Domain Addons</span></b></center><br>";
				}
				$body .= "\n Removed $count3[0] expired Domain Addons\n";
			}
#---------------------------------# END	DOMAIN ADDON SECTION #------------------------------------#
#---------------------------------##---------------------------------##--------------------------#


#end the Status email to the admin user / support email
#-----The rest of the admin email ---------#
	$headers = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
	$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
	mail($support_email, $subject, $body, $headers);
#-----End the admin email section ---------#
?>
