<?php
				$subject = "Reciept for your payment (#$invoice) "; 
				$body .= "Dear $fname $lname, \n\n\n";
				$body .= "Thank you for your recent order.  This is your confirmation of payment for order #$invoice (LoginID = $username):\n\n";
				$body .= "===============================================================================\n";
				$body .= "InvoiceID      : $invoice\n";
				$body .= "Invoice Date   : $time\n";
				$body .= "FirstName      : $fname\n";
				$body .= "LastName       : $lname\n";
				$body .= "Paid By        : Credit Card\n\n\n";
				$body .= "Total Paid  : \$$amount\n";
				$body .= "===============================================================================\n\n\n";
				$body .= "Please note this is only a reciept for the Credit Card transaction.  You will recieve a seperate email once your order has finished processing.  Thanks again for using $CompanyName for your online services.\n\n";
				$body .= "Regards,\n";
				$body .= "$email_fromadmin \n";
				$headers .= "From: " . $email_fromsales." <" . $sales_email . ">\r\n";
				$headers .= "Reply-To: " . $email_fromsales. " <" . $sales_email . ">\r\n";
				$headers .= "BCC: " . $email_fromsales. " <" . $sales_email . ">\r\n";
				mail($email, $subject, $body, $headers);
?>