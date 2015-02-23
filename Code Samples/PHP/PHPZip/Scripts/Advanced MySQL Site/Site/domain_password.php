<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=domain_password");
	exit(); // Quit the script.
} 
require( "include/dbconfig.php" );

$domain_pass = $HTTP_POST_VARS["password1"];

$sld = $_GET["sld"];
$tld = $_GET["tld"];
$command = $_GET["command"];
$action = $HTTP_POST_VARS["action"];

	if(($action == "changepass")||($command == "changepass")){
		//Validate form fields
		// Check for a password and match against the confirmed password.
		if (empty($_POST['password1'])) {
			$domain_pass = FALSE;
			$message .= '<br>You Must enter a password to continue!</br>';
		} else {
			if ($_POST['password1'] == $_POST['password2']) {
				$domain_pass = $_POST['password1'];
			} else {
				$domain_pass = FALSE;
				$message .= '<br>Your Passwords did not match!</br>';
			}
		}
		//End form validation
		
	if ($domain_pass) { 
	// If it passed validation, lets do it.

					include( "include/EnomInterface_inc.php" );
					include( "include/DomainFns_inc.php" );
					if ( WasPasswordModified() == 1 ) {
						ModifyPassword();
						
					$status = "center> <span class=\"basictext\">$message</span>
					<br> <center><a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_back.gif\" border=\"0\"></a></center>";}
				}
			}

	$page = "myaccount";
	$PageTitle = $SiteTitle . " - Change or Assign a Domain access Password";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Change / Set Domain access Password </span></td>
			    </tr>
				<tr>
			      <td colspan="2" valign="top" class="content2">
<center><b><?php if(isset($message)) {echo "<span class=\"red\">$message </span>";} else {echo "$status";}?>
<br>
<form method="post" action="<?php echo "domain_password.php?command=changepass&sld=$sld&tld=$tld";?>">
  <input type="hidden" name="action" id="action" value="changepass">
		
			  <br><br><table height="92" align="center" class="tableOO">
		<tr> 
	<td height="19" colspan="2" class="titlepic"><span class="whiteheader">Change / Set Domain Password</span></td>
</tr>
<tr> 
	<td width="133" height="24" valign="middle" ><span class="main">Password:&nbsp;&nbsp;</span></td>
	<td width="197" valign="middle" >&nbsp;&nbsp;<input type="password" name="password1" id="password1" maxlength="16" value=""></td>
</tr>
<tr> 
	<td height="24" valign="middle" ><span class="main">Retype&nbsp;Password:&nbsp;&nbsp;</span></td>
	<td valign="middle" >&nbsp;&nbsp;<input type="password" name="password2"  id="password2" maxlength="16" value=""></td>
</tr>
<tr> 
	<td colspan="2" align="center" valign="middle" ><input name="submit" type="image" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0"><a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>"><img src="images/btn_cancel.gif" border="0"></a></td>
</tr>
  </table>
		<p align="center"><b>All Domains using Dynamic DNS </b><span class="red"><b color="red">MUST </b></span><b>have a domain access password set.</b> <br>

				  </p>
			      </form>
					<br> 
                    </p>
      <tr>
	                <td colspan="3" valign="top" class="content2">                    
</table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>