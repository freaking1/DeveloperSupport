<?php 
		$subject = "Order Confirmation (#$invoice_id)  "; 
		$body .= "Dear $fname $lname, \n\n\n";
		$body .= "Thank you for your recent order.  Below you will find a summary of the products and services ordered for your account (LoginID = $username):\n\n";
		$body .= "===============================================================================\n";
		$body .= "InvoiceID      : $invoice_id\n";
		$body .= "Invoice Date   : $time\n";
		$body .= "FirstName      : $fname\n";
		$body .= "LastName       : $lname\n\n";
		$body .= "Details of the Order:\n";
		$body .= "$body3\n";
		$body .= "\n\nTotal Due  : \$$total_price\n";
		$body .= "===============================================================================\n\n\n";
		$body .= "Please note that this is only a confirmation of us recieving your order request.  You will recieve a seperate email once your order has finished processing.  Thanks again for using $CompanyName for your online services.\n\n";
		$body .= "Regards,\n";
		$body .= "$email_fromadmin \n";
		$headers .= "From: " . $email_fromsales." <" . $sales_email . ">\r\n";
		$headers .= "Reply-To: " . $email_fromsales. " <" . $sales_email . ">\r\n";
		$headers .= "Bcc: " . $email_fromsales. " <" . $sales_email . ">\r\n";
		mail($email, $subject, $body, $headers);
		?>