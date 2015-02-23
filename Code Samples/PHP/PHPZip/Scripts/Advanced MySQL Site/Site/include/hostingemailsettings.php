<?php
			//email info sent to registrant
			
 {
				$myname = "admin"; 
				$myemail = "admin@enomitron.com"; 
				$myURL = "www.enomitron.com";
				$mysig = "Your Name";
				
				$contactname = $HTTP_POST_VARS[ "RegistrantFirstName" ]; 
				$contactemail = $HTTP_POST_VARS[ "RegistrantEmailAddress" ]; 
				 
				$subject = "Congratulations, your Hosting account is created!"; 
				
				$message = "Congrats, you have Setup Your hosting account.\n\n";
				
				//keep the next line commented out if you do not use CC processing
				//$message .= "The amount charged to your card is : $ChargeAmount\n";
				
				$message .= "Your OrderID is : $OrderID\n\n";
				$message .= "Please go to $myURL to login and configure your domain name to use the new hosting account\n";
				$message .= "You can also return anytime to manage your domain name or the hosting account itself \n\n";
				$message .= "Sincerely,\n\n$mysig";
		
				$headers .= "From: " . $myname." <" . $myemail . ">\r\n";
				$headers .= "Reply-To: " . $myname. " <" . $myemail . ">\r\n";
				
				mail($HostAccountEmail, $subject, $message, $headers);
			}
?>
