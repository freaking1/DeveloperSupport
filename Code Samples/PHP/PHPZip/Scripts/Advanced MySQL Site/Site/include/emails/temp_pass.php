<?php
				$subject = "Your temporary password to $sitename";
				$body = "Your password to $sitename has been temporarily changed to $new_password.\n\n";
				$body .= "Please login using this password and your username.\n\n";
				$body .= "Please go to $site_url/login.php to login and change your password to something more familiar.\n";
				$body .= "\n\n";
				$body .= "Sincerely,\n\n$email_fromsupport";
				$headers .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
				$headers .= "Reply-To: " . $email_fromsupport. " <" . $$support_email . ">\r\n";
				mail($email, $subject, $body, $headers);
?>