<?php
		$subject = "Contact Form responded to"; 
		$body = "Hello $name, \n\n";
		$body .= "$myresponse2\n\n";
		$body .= "\n\n";
		$body .= "Sincerely,\n\n$email_fromsupport\n";
		$body .= "$support_email\n";
		$body .= "$support_phone\n";
		$headers = "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
		$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
		$headers .= "BCC: " . $email_fromsupport. " <" . $support_email . ">\r\n";
		mail($email, $subject, $body, $headers);
?>