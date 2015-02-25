<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=myinvoices");
	exit(); // Quit the script.
}

$invoice = $_SESSION['invoice'] ;
$amount_due = $_SESSION['amount_due'];
$refer = $_POST['refer'];
$ccaction = $_GET['ccaction'];

	$get_data2 = "SELECT * FROM users WHERE id='$user_id'";
	$data2 = @mysql_query($get_data2);
	$row2 = mysql_fetch_array($data2, MYSQL_ASSOC);
	
	$fname = $row2[fname];
	$lname = $row2[lname];
	$address1 = $row2[add1];
	$address2 = $row2[add2];
	$city = $row2[city];
	$state = $row2[state];
	$zip = $row2[zip];
	$country = $row2[country];
	$phone = $row2[phone];
	$email = $row2[email];
	$fax = $row2[fax];
	
if($ccaction == 'process'){
	if (empty($_POST['CCFName'])) {
		$CCFName = FALSE;
		$message .= '<br>You must enter the card holders first name</br>';
	} else { 
		$CCFName = $HTTP_POST_VARS['CCFName'];
		}
	if (empty($_POST['CCLName'])) {
		$CCLName = FALSE;
		$message .= '<br>You must enter the card holders last name</br>';
	} else { 
		$CCLName = $HTTP_POST_VARS['CCLName'];
		}
	if (empty($_POST['CCAddress'])) {
		$CCAddress = FALSE;
		$message .= '<br>You must enter the card holders address</br>';
	} else { 
		$CCAddress = $HTTP_POST_VARS['CCAddress'];
		}
	if (empty($_POST['CCCity'])) {
		$CCCity = FALSE;
		$message .= '<br>You must enter the card holders city</br>';
	} else { 
		$CCCity = $HTTP_POST_VARS['CCCity'];
		}
	if (empty($_POST['CCState'])) {
		$CCState = FALSE;
		$message .= '<br>You must enter the card holders state</br>';
	} else { 
		$CCState = $HTTP_POST_VARS['CCState'];
		}
	if (empty($_POST['CCZip'])) {
		$CCZip = FALSE;
		$message .= '<br>You must enter the card holders zip code</br>';
	} else { 
		$CCZip = $HTTP_POST_VARS['CCZip'];
		}
	if (empty($_POST['CCPhone'])) {
		$CCPhone = FALSE;
		$message .= '<br>You must enter the card holders phone number</br>';
	} else { 
		$CCPhone = $HTTP_POST_VARS['CCPhone'];
		}
	if(isset($_POST['CCFax'])) {
		$CCFax = $HTTP_POST_VARS['CCFax'];
	}
	if (empty($_POST['CCEmail'])) {
		$CCEmail = FALSE;
		$message .= '<br>You must enter the card holders Email address</br>';
	} else { 
		$CCEmail = $HTTP_POST_VARS['CCEmail'];
		}
	if (empty($_POST['CreditCardNumber'])) {
		$CardNumber = FALSE;
		$message .= '<br>Credit card number can not be blank</br>';
	} else { 
		$CardNumber = $HTTP_POST_VARS['CreditCardNumber'];
		}
	if (empty($_POST['CVV2'])) {
		$CVV2 = FALSE;
		$message .= '<br>Cvv2 number can not be blank</br>';
	} else { 
		$CVV2 = $HTTP_POST_VARS['CVV2'];
		}
	
	$CardExpMonth = $HTTP_POST_VARS['CreditCardExpMonth'];
	$CardExpYear = $HTTP_POST_VARS['CreditCardExpYear'];
	$country = $HTTP_POST_VARS['country'];

if($CVV2 && $CardNumber && $CCZip && $CCEmail && $CCPhone && $CCState && $CCCity && $CCAddress && $CCFName && $CCLName){
			if($CCMerchantChoice == 1){
			require("include/creditcard/process_auth_cc.php");
			 } elseif($CCMerchantChoice == 2){
			require("include/creditcard/process_worldpay_cc.php");
			 }
	}
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
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">Credit Card Checkout </span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">
<?php
if(isset($message)) {
echo "<br>";
echo "<center><b><span class=\"BasicText\">$message</span></b></center>";
}
require("include/creditcard.php");
?>
			  <tr>
	          </table>
</table>
<?php include('include/footer.php');?>