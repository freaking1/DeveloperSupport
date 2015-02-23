<?php 
		$subject = "Your order has been processed (#$invoice) "; 
		$body .= "Dear $fname $lname, \n\n\n";
		$body .= "Thank you for your recent order.  Below you will find a summary of the products and services ordered for your account (LoginID = $username):\n\n";
		$body .= "===============================================================================\n";
		$body .= "InvoiceID      : $invoice\n";
		$body .= "Invoice Date   : $time\n";
		$body .= "FirstName      : $fname\n";
		$body .= "LastName       : $lname\n\n";
		$body .= "Details of the Order:\n";
		$body .= $body3;
		$body .= "\n\nTotal Billed  : \$$amount_billed\n";
		$body .= "===============================================================================\n\n\n";
		$body .= "Your account is fully setup and ready to begin using.  Your may view your invoice online anytime by visiting: \n";
		$body .= " $site_url/viewinvoice.php?invoice=$invoice&refer=myinvoices&target=viewinvoice\n";
		$body .= "===============================================================================\n\n\n";
		$body .= "Sincerely,\n\n$email_fromsupport\n";
		$body .= "$support_email\n";
		$body .= "$support_phone\n";
		$headers = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
		$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
		$headers .= "Bcc: " . $email_fromsupport. " <" . $support_email . ">\r\n";
		mail($email, $subject, $body, $headers);
?>