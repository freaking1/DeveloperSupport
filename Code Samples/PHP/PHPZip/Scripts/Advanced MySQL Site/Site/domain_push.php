<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=domain_push");
	exit(); // Quit the script.
} 
include( "include/dbconfig.php" );

$from_user = $username;


//Get / Set the form variables
$action = $HTTP_POST_VARS["action"];
	$message = NULL  ;
//User submits the form
if($action == "push"){

	if (empty($_POST['push_domain'])) {
		$push_domain = FALSE;
		$message .= '<br>You must enter a domain name</br>';
	} else { 
		$push_domain = $_POST['push_domain'];
		}
	if (empty($_POST['to_user'])) {
		$to_user = FALSE;
		$message .= '<br>You must enter a user to push to</br>';
	} else { 
		$to_user = $_POST['to_user'];
		}
if( $push_domain && $to_user){ 

include( "include/dbconfig.php" );
		include( "include/EnomInterface_inc.php" );
  		$Enom3 = new CEnomInterface;
		$Enom3->AddParam( "uid", $enom_username );
		$Enom3->AddParam( "pw", $enom_password );
  		$Enom3->AddParam( "command", "ParseDomain" );
  		$Enom3->AddParam( "PassedDomain", $push_domain );
  		$Enom3->DoTransaction();
				$sld = $Enom3->Values[ "SLD" ];
				$tld = $Enom3->Values[ "TLD" ];

//See if the user has the domain in their account
	$query = "select * from domains where user_id='$user_id' AND sld='$sld' AND tld='$tld'";
	$result = @mysql_query($query);
	$num = mysql_num_rows($result);
		if($num == 1){
		//User does have the domain, so now we find the other users info and transfer the domain name
			//Get your own data for the confirmation emails
			$query1 = "select * from users where id = '$user_id'";
			$result1 = @mysql_query($query1);
			$row1 = mysql_fetch_array($result1, MYSQL_ASSOC);
				$from_user = $row1[username];
				$from_user_email = $row1[email];
			//Get new Users Info
			$query2 = "select * from users where username = '$to_user'";
			$result2 = @mysql_query($query2);
			$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$new_id = $row2[id];
				$to_user = $row2[username];
				$to_user_email = $row2[email];
					$query4 = "select * from domains where user_id='$user_id' AND sld='$sld' AND tld='$tld'";
					$result4 = @mysql_query($query4);
					$row4 = mysql_fetch_array($result4, MYSQL_ASSOC);
					$dom_id = $row4[domain_id];
			//Now update the domain name to the new users info and redirect back to the domain list page
			$query3 = "UPDATE domains SET user_id ='$new_id' WHERE domain_id = '$dom_id'";
			$result3 = @mysql_query($query3);
			if (mysql_affected_rows() == 1){
				//it did work
				$message = "Domain Pushed successfully to <b><u>Login ID $to_user</u></b>";
				//Since all that went OK - Lets log the push so we can keep track of these things
				$query4 = "INSERT INTO push_log (sld, tld, date, IP, from_user, to_user, status)
					VALUES ('$sld', '$tld', NOW(), '$enduserip', '$from_user', '$to_user', 'Success')";
				//Run the query
				$result4 = @mysql_query ($query4);
				echo $query4;exit;
						//Email the user the push confirmation
						$subject = "A Domain has been pushed from your account\n"; 
						$body = "Your domain $sld.$tld has been successfully pushed to the specicfied user \"$to_user\".\n";
						$body .= "If you did not do or authorize this, please contact support immediately\n";
						$body .= "and give them the domain name, the username pushed to, and the IP of the user.\n\n\n";
						$body .= "User: $to_user\n";
						$body .= "Domain: $sld.$tld\n";
						$body .= "IP of user: $enduserip\n";
						$body .= "Pushed on: $time";
						$body .= "\n\n\n";
						$body .= "Sincerely,\n\n$email_fromsupport";
						$headers .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($from_user_email, $subject, $body, $headers);
						//Send a confirmation to the second user as well
						$subject = "A Domain has been pushed to your account"; 
						$body = "Congratulations, \nA Domain has been pushed to your account\n\n";
						$body .= "The Domain name is : $sld.$tld\n";
						$body .= "It was pushed from : $from_user\n";
						$body .= "It was pushed to : $to_user\n";
						$body .= "Performed by user with the IP address of: $enduserip\n";
						$body .= "Pushed on: $time\n";
						$body .= "\n\n";
						$body .= "Sincerely,\n\n$email_fromsupport";
						$headers .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
						$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($to_user_email, $subject, $body, $headers);
				} else {
				//It failed
				$query4 = "INSERT INTO push_log (sld, tld, date, IP, from_user, to_user, status)
						VALUES ('$sld', '$tld', NOW(), '$enduserip', '$from_user', '$to_user', 'Failed Push')";
					$result4 = @mysql_query ($query4);
					$message .= "<br>Domain push failed.  Please try again later or contact support";
				}
			} else {
		
		$message = "The domain $sld.$tld is NOT in your account!";
				$query4 = "INSERT INTO push_log (sld, tld, date, IP, from_user, to_user, status)
					VALUES ('$sld', '$tld', NOW(), '$enduserip', '$from_user', '$to_user', 'Not in account')";
					$result4 = @mysql_query ($query4);
		}
	}
} 
	$page = "myaccount";

?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="147" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td width="145" height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
			<td class="content" align="center" valign="top" width="815">
			<table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Push a Name</span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">&nbsp;			
			        <?php
include('account_top.php');?>

			        <form name="form1" method="post" action="domain_push.php">
						<input type="hidden" name="action" value="push"><br>
		              <table width="389" border="0" align="center" class="tableO1">
                        <tr>
                          <td colspan="2" class="titlepic"><span class="whiteheader">Push A Name</span></td>
                        </tr>
                        <tr>
                          <td><div align="right">Domain to push:</div></td>
                          <td><input name="push_domain" type="text" id="push_domain"></td>
                        </tr>
                        <tr>
                          <td><div align="right">User to push to:</div></td>
                          <td><input name="to_user" type="text" id="to_user"></td>
                        </tr>
                        <tr>
                          <td colspan="2"><div align="center">
						  <input type="image" name="submit" src="images/btn_accept.gif" value="submit" />
						  <a href="mydomains.php"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a>
						  </div></td>
                        </tr>
                      </table>
		              <p align="center">		            
</p>
		              <p>&nbsp;</p>
			        </form>			        <p align="center" class="BasicText"><br> 
                    </p>
		          <tr>
	                <td colspan="3" valign="top" class="content2">                    
		      </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>