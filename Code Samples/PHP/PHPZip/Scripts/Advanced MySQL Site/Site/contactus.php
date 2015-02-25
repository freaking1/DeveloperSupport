<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	include( "include/dbconfig.php" );
	
$action = $HTTP_POST_VARS['action'];
$mailto = $HTTP_POST_VARS['mailto'];
$name = $HTTP_POST_VARS['name'];
$username = $HTTP_POST_VARS['username'];
$phone = $HTTP_POST_VARS['phone'];
$email = $HTTP_POST_VARS['email'];
$comments = $HTTP_POST_VARS['comments'];

if ($action == "contact" ) {
if (empty($_POST['name'])) {
	$name = FALSE;
	$message .= '<br>Please enter your name</br>';
} else {
	$name = mysql_escape_string($_POST['name']);
}
if (empty($_POST['phone'])) {
	$phone = FALSE;
	$message .= '<br>Please enter a phone number to reach you at</br>';
} else {
	$phone = mysql_escape_string($_POST['phone']);
}
if (empty($_POST['email'])) {
	$email = FALSE;
	$message .= '<br>Please enter your email address</br>';
} else {
	$email = mysql_escape_string($_POST['email']);
}
if (empty($_POST['comments'])) {
	$comments = FALSE;
	$message .= '<br>You did not enter in a message</br>';
} else {
	$comments = mysql_escape_string($_POST['comments']);
}
	
	if($comments && $email && $phone && $name){
			//Write SQL to store in the DB
			$query = "INSERT INTO contact (name, username, phone, email, message, answered, date)
						VALUES ('$name', '$username', '$phone', '$email', '$comments', '0', NOW())";
			$result = @mysql_query ($query);
			if(!$result){
				$message = "There was an error in submitting the form.  Please alert Support";}
					//If the result,then sent the email
						$subject = "Contact Us form from submitted"; 
						$body = "A contact us form has been submitted \n";
						$body .= "Name: $name \n";
						$body .= "Site Username : $username \n";
						$body .= "Phone number: $phone\n";
						$body .= "Email Address: $email\n";
						$body .= "Message: $comments\n\n\n";
						$headers .= "From: $email\r\n";
						$headers .= "Reply-To: $email\r\n";
						$headers .= "CC: " . $email_fromsupport. " <" . $support_email . ">\r\n";
						mail($info_email, $subject, $body, $headers);
						//End Email
						$submit = 1;
						}
				}
	$PageName = "ContactUs";
	$PageTitle .= "Conact Us.";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Contact Us </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">&nbsp;			          </p>
			        <table width="521" border="0" align="center">
                      <tr>
                        <td width="167" class="tableO1"><span class="row1">Sales:<br>
                          </span>
                            <a href="mailto:<?=$sales_email;?>"><?=$sales_email;?></a>
                            <br>
                        <?=$sales_phone;?></td>
                        <td width="7" rowspan="2">&nbsp;</td>
                        <td width="167" class="tableO1">Support: <br>
                            <a href="mailto:<?=$support_email;?>"><?=$support_email;?></a>
                            <br>
                        <?=$support_phone;?></td>
                        <td width="9" rowspan="2">&nbsp;</td>
                        <td width="167" class="tableO1">General Info: <br>
                            <a href="mailto:<?=$info_email;?>"><?=$info_email;?></a>
                            <br>
                        <?=$general_phone;?></td>
                      </tr>
                    </table>	
        </p><?php if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center><br>';}?>
        <div align="center"><br>
            					  <?php
					  if($submit == 1){
					  echo "<table width=\"622\" border=\"0\" align=\"center\" class=\"table01\">
					<tr>
					  <td width=\"526\" class=\"OutlineOne\" align=\"center\">Thank you for contacting $sitename, We will respond to all inquiries in the order as they are recieved, as soon as it is possible.</span></td>
					</tr>
				  </table>  <br>If you are an existing user in need of support, please contact support for prompt assistance. <br>";
				 } else {
				 echo ' <center>If you are an existing user in need of support, please contact support for prompt assistance. </center><br>';}?>
<br>
        </div>
        <table width="424" border="0" align="center" class="tableO1">
	<form name="form1" method="post" action="contactus.php">
                          <input type="hidden" name="action" value="contact">
                      <tr class="OutlineOne">
                        <td colspan="2" class="titlepic"><div align="center"><span class="whiteheader">Contact Form</span> </div></td>
                </tr>
                      <tr>
                        <td>Name</td>
                        <td>
                          <input name="name" type="text" class="formfield" value="<?php echo $name;?>">
                        </td>
                      </tr>
                      <tr>
                        <td>Email Address </td>
                        <td><input name="email" type="text" class="formfield" value="<?php echo $email;?>"></td>
                      </tr>
                      <tr>
                        <td>Phone Number </td>
                        <td><input name="phone" type="text" class="formfield" value="<?php echo $phone;?>"></td>
                      </tr>
                      <tr>
                        <td height="20">Username <br>
                        (if you have one) </td>
                        <td><input name="username" type="text" class="formfield" value="<?php echo $username;?>"></td>
                      </tr>
                      <tr>
                        <td height="86">Message / Comments </td>
                        <td><textarea name="comments" cols="30" rows="5" class="formlogin" value="<?php echo $comments;?>"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td height="20" colspan="2"><center><input name="image2" type="image" src="images/btn_submit.gif" align="middle"></center></td>
                      </tr>
	</form>
                    </table>                    <blockquote>
                      <p align="center"> 
                      </p>
                      <p>                    <br> 
                      </p>
                    </blockquote>
		      <tr>
	                <td colspan="3" valign="top" class="content2">                    
</table></table>		          <?php include('include/footer.php');?>
</table>
