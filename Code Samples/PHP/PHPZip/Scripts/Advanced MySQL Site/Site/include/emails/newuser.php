<?php
				$subject = "Your account at $sitename Has been created!"; 
				$body .= "Hello $fname $lname, \n";
				$body .= "Thank you for signing up for an account at $sitename.\n";
				$body .= "Your account is fully setup and ready to begin using,\n";
				$body .= "Please write down this information for your records.\n\n\n";
				$body .= "===============================================================================\n";
				$body .= "Your Username is : $reguName\n";
				$body .= "Your Password is : $password\n\n\n";
				$body .= "We have the following email addresses listed for your account:\n";
				$body .= "Primary: $email\n";
				$body .= "Secondary: $second_email\n";
				$body .= "===============================================================================\n\n";
				$body .= "A copy of this email has been sent to both places.\n\n";
				$body .= "Please go to $site_url to login and begin to purchase and manage your services.\n";
				$body .= "\n\n";
				$body .= "Sincerely,\n\n$email_fromsupport\n";
				$body .= "$support_email\n";
				$body .= "$support_phone\n";
				
				$headers .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
				$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
				$headers .= "Bcc: " . $email_fromsupport. " <" . $support_email . ">\r\n";
				$headers .= "Bcc: " . $second_email. " <" . $second_email . ">\r\n";
				mail($email, $subject, $body, $headers);
?>