<?php
#--------Build the Email ---------------#
	$subject = "Your new hosting account is ready!"; 
	$body .= "Hello $full_name, \n";
	$body .= "Your hosting account has been processed and is now setup.  Please make note of your login details listed below:\n\n";
	$body .= "Username: $HostAccount\n";
	$body .= "Password: $Password\n";
	$body .= "Email Address: $email_addy\n";
	$body .= "Plan: $p_name\n";
	$body .= "Package #: $host_package\n";
	$body .= "Monthly Charge: $charge\n\n";
	$body .= "Please go to $site_url/viewinvoice.php?invoice=$invoice&refer=myinvoices&target=viewinvoice to View the status of your invoice.\n";
	$body .= "Please go to $site_url/myhosting.php to View the status of your hosting account and login to the control panel.  Your FTP and Email information will be listed there as well.\n";
	$body .= "\n\n";
	$body .= "You will use the username and password listed above to login via FTP, as well as access the control panel.";
	$body .= "\n\n";
	$body .= "How to access the control panel:\n";
	$body .= "You can access your control panel at any time by going to http://webhosting.name-services.com\n\n";
	$body .= "How to access FTP/Upload\n";
	$body .= "Server: $Server\n\n";
	$body .= "Access via Explorer: ftp://$Server\n";
	$body .= "Access via FTP Client: $Server\n\n";
	$body .= "\n\n";
	$body .= "Please be aware that the webhosting will not work by direct domain name until the domain name has hads its name servers changed, and the chagnes propogate.  This propogation typically takes aprox 24 hours from the time of the chagne.\n\n";
	$body .= "Please make sure the domains name servers are changed to the following:\n";
	$body .= "dns1.name-services.com\n";
	$body .= "dns2.name-services.com\n";
	$body .= "dns3.name-services.com\n";
	$body .= "dns4.name-services.com\n";
	$body .= "dns5.name-services.com\n";
	$body .= "\n\n";
	$body .= "Please note that your webhosting account is active as of now, and you can begin using it immediately.  Thanks again for using $CompanyName for your online services.\n\n";
	$body .= "Sincerely,\n\n$email_fromsupport\n";
	$body .= "$support_email\n";
	$body .= "$support_phone\n";
	$headers .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
	$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
	mail($email_addy, $subject, $body, $headers);
#-----End the email section ---------#

# --- Sending a copy to the admin --------#
	$subject2 = "Admin Copy: new hosting account created"; 
	$body2 = "This is your administrative copy of the invoice \n\n\n";
	$body2 .= "Hello $full_name, \n";
	$body2 .= "Your hosting account has been processed and is now setup.  Please make note of your login details listed below:\n\n";
	$body2 .= "Username: $extra3\n";
	$body2 .= "Password: $host_password\n";
	$body2 .= "Email Address: $host_username\n";
	$body2 .= "Plan: $p_name\n";
	$body2 .= "Package #: $host_package\n";
	$body2 .= "Monthly Charge: $charge\n\n";
	$body2 .= "Please go to $site_url/viewinvoice.php?invoice=$invoice&refer=myinvoices&target=viewinvoice to View the status of your invoice.\n";
	$body2 .= "Please go to $site_url/myhosting.php to View the status of your hosting account and login to the control panel.  Your FTP and Email information will be listed there as well.\n";
	$body2 .= "\n\n";
	$body2 .= "Sincerely,\n\n$email_fromsupport\n";
	$body2 .= "$support_email\n";
	$body2 .= "$support_phone\n";
	$headers2 .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
	$headers2 .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
	mail($support_email, $subject2, $body2, $headers2);
#-----End the email section ---------#
?>