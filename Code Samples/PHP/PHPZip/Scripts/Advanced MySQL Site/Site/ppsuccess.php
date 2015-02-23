<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

	$frompaypal = $_POST["custom"];

//If the user didnt come from the paypal patyment page, redirect to viewing the cart
if($frompaypal != $PaypalAuthKey){
	header ("Location:  $site_url/view_cart.php?target=view_cart");
	exit(); // Quit the script.
}

if($frompaypal == $PaypalAuthKey){
$query = "UPDATE customer_invoice SET paid='1', paid_by='1' WHERE user_id='$user_id' AND username='$username' AND invoice_id=$invoice";
$result = @mysql_query($query);
if($result){
	$query_delete = "DELETE FROM cart WHERE user_id='$user_id'";
	$result_delete = mysql_query($query_delete);

//Send the IPN Email
#--------------------------
$email = $sales_email;
function doTheCurl ()
{
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value)
	{
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
	$ch = curl_init();
	
	// check to see if this is sandbox or not
	if ($_POST["test_ipn"] == 1)
	{
		curl_setopt($ch, CURLOPT_URL, "https://www.sandbox.paypal.com/cgi-bin/webscr"); 
	}
	else
	{
		curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com/cgi-bin/webscr"); 
	}
	
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$fp = curl_exec ($ch);
	curl_close($ch);
	return $fp;
}

function doTheHttp ()
{
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value)
	{
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
	if ($_POST["test_ipn"] == 1)
	{
		$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
	}
	else
	{
		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
	}
	
	if (!$fp) {
		return "ERROR";
	} 
	else
	{
		fputs ($fp, $header . $req);
		while (!feof($fp))
		{
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0)
			{
				return "VERIFIED";
			}
			else if (strcmp ($res, "INVALID") == 0)
			{
				return "INVALID";
			}
		}
		fclose ($fp);
	}
	return "ERROR";
}
function doEmail ($title,$email)
{
include("include/dbconfig.php");
		$body = "-----------HTTP POST VARS------------\n";
		foreach ($_POST as $key => $value)
		{
		$body .= "$key = $value \n\n";
		}
		$body .= "-------------------------------------\n\n\n";
		$headers .= "From: " . $email_fromsales." <" . $sales_email . ">\r\n";
		$headers .= "Reply-To: " . $email_fromsales. " <" . $sales_email . ">\r\n";
		mail($email, $title, $body, $headers);
}

$fp = doTheCurl();
if (!$fp)
{
	doEmail("cURL ERROR, SWITCHING TO HTTP",$email);
	$fp = doTheHttp();
}
$res = $fp;

if (strcmp ($res, "VERIFIED") == 0)
{
	doEmail("PayPal Purchase Success",$email);
}
else if (strcmp ($res, "INVALID") == 0)
{
	doEmail("INVALID PayPal Purchase!!",$email);
}
else
{
	doEmail("Error in IPN Code - Normally HTTP Error",$email);
}
#----------------------------
$PaypalAuthKey = '';
$_SESSION['PaypalAuthKey'] = '';
} else {
	echo "No Rows";
	exit;
		$options = "target=myinvoices&invoice=$invoice&refer=myinvoices";
		header ("Location:  $site_url/viewinvoice.php?$options");
	}
}
if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=view_cart");
	exit(); // Quit the script.
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
                         <td colspan="2" bgcolor="#EEEEEE"><?=$_POST[invoice]?></td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td bgcolor="#EEEEEE">Date:</td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$_POST[payment_date]?>
                          </td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td width="19%" bgcolor="#EEEEEE"> First Name: </td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$_POST[first_name]?>
                          </td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td bgcolor="#EEEEEE">Last Name:</td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$_POST[last_name]?>
                          </td>
                       </tr>
                       <tr align="left" valign="top"> 
                          <td bgcolor="#EEEEEE">Email:</td>
                          <td colspan="2" bgcolor="#EEEEEE"> 
                             <?=$_POST[payer_email]?>
                          </td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">Username:</td>
                         <td colspan="2" bgcolor="#EEEEEE"><?=$username;?></td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">Total:</td>
                         <td colspan="2" bgcolor="#EEEEEE">$<?=$_POST[payment_gross]?></td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">Paid by: </td>
                         <td colspan="2" bgcolor="#EEEEEE">PayPal</td>
                       </tr>
                       <tr align="left" valign="top">
                         <td bgcolor="#EEEEEE">&nbsp;</td>
                         <td colspan="2" bgcolor="#EEEEEE">&nbsp;</td>
                       </tr>
                       <tr align="center" valign="top">
                         <td colspan="2" bgcolor="#EEEEEE"><a href="<?php echo "viewinvoice.php?invoice=$invoice&refer=ppsuccess"?>"><strong>View Invoice details</strong></a>&nbsp;</td>
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
