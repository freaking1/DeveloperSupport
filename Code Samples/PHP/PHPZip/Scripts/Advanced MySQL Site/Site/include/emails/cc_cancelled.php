<?php
				$subject = "Payment for your payment (#$invoice) "; 
				$body .= "Dear $fname $lname, \n\n\n";
				$body .= "Your recent payment for invoice $cartId was either cancelled by you, or rejected by your bank.\n\n";
				$body .= "If this was not canceled by you, please contact your bank directly regarding this transaction.\n";
				$body .= "===============================================================================\n\n\n";
				$body .= "Regards,\n";
				$body .= "$email_fromadmin \n";
				$headers .= "From: " . $email_fromsales." <" . $sales_email . ">\r\n";
				$headers .= "Reply-To: " . $email_fromsales. " <" . $sales_email . ">\r\n";
				$headers .= "Bcc: " . $email_fromsales. " <" . $sales_email . ">\r\n";
				mail($email, $subject, $body, $headers);
?>