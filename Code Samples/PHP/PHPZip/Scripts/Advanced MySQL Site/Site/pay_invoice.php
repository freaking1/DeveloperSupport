<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
	
//If the user is not logged in, redirect to the login page			
if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=myinvoices");
	exit(); // Quit the script.
}

$invoice = $_GET["invoice"];
$action = $_GET["action"];

if (!isset($invoice)) {
	header ("Location:  $secure_site_url/myinvoices.php");
	exit(); // Quit the script.
}

include("include/dbconfig.php");
include_once('include/config.inc.php'); 
include_once('include/global_config.inc.php');

	$query_total = "SELECT id, amount_due, date FROM customer_invoice where user_id='$user_id' AND username='$username' AND invoice_id='$invoice'";		
	$result_total = @mysql_query ($query_total);
	$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
	$invoice_id = $row_total[0];
	$amount_due = $row_total[1];
	$invoice_date = $row_total[2];
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
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">My Invoices / Payments</span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2"><br>			        
				  <br>
<center><span class="BasicText"><b><u><?php if(isset($message)) {echo '<span class=\"red\">', $message, '</span>';}  ?>
</center></span></u></b>
				  <br>
			        <table width="700"  border="0" align="center" class="tableO1"><tr>
					<td width="234" colspan="1" align="right"><div align="center"><span class="BasicText">[Invoice #]: 
			        <?=$invoice;?>
				    </span></div></td>
					<td width="179" colspan="1" align="right"><div align="center"><span class="BasicText">[Invoice ID]: 
                    <?=$invoice_id;?>
			        </span></div></td>
					<td colspan="2" align="right"><div align="center"><span class="BasicText">[Invoice Date]: 
			        <?=$invoice_date;?>
				    </span></div></td>
					</tr>
					  <tr><td colspan="4"></td></tr>
                      <tr class="titlepic">
                        <td align="left" class="titlepic"><span class="whiteheader"><b>[Description]</b></span></td>
                        <td align="center" class="titlepic"><div align="center"><span class="whiteheader"><b>[Order Type]</b></span></div></td>
                        <td width="119" align="center" class="titlepic"><span class="whiteheader"><b>[Qty/Years]</b></span></td>
                        <td width="150" align="center" class="titlepic"><span class="whiteheader"><b>[Amount]</b></span></td>
                      </tr>
					  <tr><td colspan="4"></td></tr>
                     <?php
	$query2 = "SELECT * FROM invoice_items WHERE user_id='$user_id' AND invoice_id='$invoice'";
	$result2 = @mysql_query ($query2);
	$bg = '#eeeeee'; //Set the background color
while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
	$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround
	//Determine if Registrar lock is turned on for this domain name or not, and display the results
		$sld = $row2[sld];
		$tld = $row2[tld];
		$prodid = $row2[prodid];
		$price = $row2[price];
		$qty = $row2[qty];
		$extra = $row2[extra];
		$p_name = $row2[p_name];

		if ($row2[prodid] == 1){
		$order_type = "Register";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 2){
		$order_type = "Renew";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 3){
		$order_type = "Transfer";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 4){
		$order_type = "ID Protect Purchase";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 5){
		$order_type = "Pop Email Boxes";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 6){
		$order_type = "URL Forwarding/Frame";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 7){
		$order_type = "URL Forwarding/Frame";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 8){
		$order_type = "Email Forwarding";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 9){
		$order_type = "WSB";
		$description = "$sld.$tld";
		}
		elseif($row2[prodid] == 10){
		$order_type = "WSC";
		$description = "$row2[host_username]";
		}
		elseif($row2[prodid] == 11){
		$order_type = "Web Hosting";
		$description = "Username: $row2[host_username] Plan:$p_name";
		}
		elseif($row2[prodid] == 12){
		$order_type = "DNS only Hosting";
		$description = "$sld.$tld";
		}
					 echo "<tr bgcolor=\"$bg\">
                        <td align=\"left\"><span class=\"BasicText\">$description</td>
                        <td align=\"center\"><span class=\"BasicText\">$order_type</td>
                        <td align=\"center\"><span class=\"BasicText\">$qty</td>
                        <td align=\"center\"><span class=\"BasicText\">$price</td>
                      </tr>";
					 }
?>
					 <tr><td colspan="4"></td></tr>
					 <tr>
					 <td colspan="2" align="center">
					 </td>
					 <td align="right"><span class="BasicText"><b>Total:</b></span>
					 </td>
					 <td align="center"><span class="BasicText"><b>$<?=$amount_due;?></b></span>
					 </td>
					 </tr>
					 <tr>
					 <td colspan="1" align="center">
				<?php if($UsePaypal == 1){ ?>
					<form method="post" action="<?php echo "pay_invoice.php?type=paypal&action=go&invoice=$invoice"?>">
					<input type="hidden" name="action" value="go">
					<input type="hidden" name="invoice" value="<?=$invoice;?>">
					<input type="hidden" name="amount" value="<?=$amount_due;?>">
					<input type="hidden" name="custom" value="<?=$PaypalAuthKey;?>">
					<input type="hidden" name="item_name" value="<?php echo "$CompanyName - Domain Names";?>">
					<input type="submit" class="button" value="Paypal Checkout">
					</form>
					<?php
						 } 
					echo '</td>
					 <td colspan="1" align="center">';
					if($UseCreditCard == 1){ 
					$_SESSION['invoice'] = $invoice;
					$_SESSION['amount_due'] = $amount_due;
					echo "<form action=\"processcc.php\" method=POST>
					<input type=\"hidden\" name=\"action\" value=\"pay\">
					<input type=\"hidden\" name=\"refer\" value=\"pay_invoice\">
					<input type=submit class=\"button\" value=\"Credit Card Checkout\"> 
					</form>";
					}
					echo '</td>
					 <td colspan="1" align="center"></td>
					 <td colspan="1" align="center">
					</tr></table>
					<p>
					<table>';

if($action == "go"){
$processing = 1;
	include_once('include/config.inc.php'); 
	include_once('include/global_config.inc.php');
?> 
	<body onLoad="document.paypal_form.submit();">
	<form method="post" name="paypal_form" action="<?=$paypal[url]?>">
<?php 
showVariables(); 
}
echo '</form></table>';

	if($processing == 1){
		echo '<center><span class="BasicTextBIG">Processing Transaction . . . </span></center>';
	}
?>
		      <tr>
	          </table>
</table>
<?php include('include/footer.php');?>