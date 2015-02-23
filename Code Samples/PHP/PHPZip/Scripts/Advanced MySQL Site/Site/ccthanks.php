<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];
	
include("include/dbconfig.php");

if ($_SESSION['referpage'] != 'CCProcess') {
	include("include/emails/cc_fraud.php");
	header ("Location:  $secure_site_url/login.php?target=myinvoices");
	exit(); // Quit the script.
}

if (!isset($_COOKIE['loggedin_user'])) {
	include("include/emails/cc_fraud.php");
	header ("Location:  $secure_site_url/login.php?target=myinvoices");
	exit(); // Quit the script.
}
	
if($CCMerchantChoice == 1){	
	$md5hash1 = $_SESSION['md5hash1'];
	$md5hash2 = $_SESSION['md5hash2'];
	$custID = $_SESSION["custusername"];
	$CCFname = $_SESSION["custfname"];
	$CCLname = $_SESSION["custlname"];
	$CCEmail = $_SESSION["custemail"];
	$invoice = $_GET["invoice"];
	$transID = $_GET['transID'];
	$amount = $_GET['amount'];
	$md5hashPost = $_GET['hs'];
	$userpost = $_GET['us'];
	$MD5Hash1 = $_SESSION["MD5Hash"];

	if($MD5Hash1 = $md5hashPost){
	$hashvars = "$md5hash$authnetlogin$transID$amount";
	$MD5Hash2 = strtoupper(md5($hashvars));
		if($md5hashPost != $MD5Hash2){
			header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "pay_invoice.php");
			include("include/emails/cc_fraud.php");
			exit(); // Quit the script.
			}
		}
} elseif($CCMerchantChoice == 2){
		$invoice = $_SESSION["invoice"];
		$CCFname = $_SESSION["fname"];
		$CCLname = $_SESSION["lname"];
		$CCEmail = $_SESSION["email"];
		$transID = $_SESSION["transID"];
		$amount = $_SESSION["amount"];
}
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
				  <td height="19" colspan="3"  class="titlepic"><div align="center"></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2"><br>
			        <br>
			        <table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
     <tr> 
        <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                 <td align="center" bgcolor="#EEEEEE"> <p>&nbsp;</p>
                    <p>Thank you! Your order has been successfully processed.</p>
                    <p>&nbsp;</p></td>
              </tr>
           </table></td>
     </tr>
  </table>
  <br>
  <table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
     <tr> 
        <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> 
                 <td width="20%" bgcolor="#EEEEEE"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">Invoice #:</td>
                         <td colspan="2" bgcolor="#EEEEEE"><?=$invoice;?></td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td bgcolor="#EEEEEE">Date:</td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$time;?>
                          </td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td width="19%" bgcolor="#EEEEEE"> First Name: </td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$CCFname;?>
                          </td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td bgcolor="#EEEEEE">Last Name:</td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$CCLname;?>
                          </td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td bgcolor="#EEEEEE">Email:</td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$CCEmail?>
                          </td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">Username:</td>
                         <td colspan="2" bgcolor="#EEEEEE"><?=$username;?></td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">Total:</td>
                         <td colspan="2" bgcolor="#EEEEEE">$<?=$amount;?></td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">Paid by: </td>
                         <td colspan="2" bgcolor="#EEEEEE">Credit Card - Credit Card Transaction ID: <?=$transID;?></td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">&nbsp;</td>
                         <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                       </tr>
                       <tr align="center" valign="top">
                         <td colspan="2" bgcolor="#EEEEEE"><a href="<?php echo "viewinvoice.php?invoice=$invoice&refer=ccthanks"?>"><strong>View Invoice details</strong></a>&nbsp;</td>
                         <td width="50%" bgcolor="#EEEEEE"><a href="myaccount.php"><strong>Account Overview</strong></a> </td>
                         </tr>
                    </table></td>
              </tr>
           </table></td>
     </tr>
  </table>                  
			    <p>&nbsp;</p>
			    <p></p>
		      <tr>
	          </table>
</table>
<?php include('include/footer.php');?>
