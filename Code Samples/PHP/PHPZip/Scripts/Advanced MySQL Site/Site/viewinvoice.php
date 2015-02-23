<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
	
//If the user is not logged in, redirect to the login page			
if (!isset($_COOKIE['loggedin_user'])) {
$invoice = $_GET["invoice"];

	header ("Location:  $secure_site_url/login.php?invoice=$invoice&refer=myinvoices&target=viewinvoice");
	exit(); // Quit the script.
}
$invoice = $_GET["invoice"];
$refer = $_GET["refer"];
if (!isset($invoice) || !isset($refer)) {
	header ("Location:  $site_url/myinvoices.php");
	exit(); // Quit the script.
}

include("include/dbconfig.php");

	$query_total = "SELECT id, amount_due, date, paid_by FROM customer_invoice where user_id='$user_id' AND username='$username' AND invoice_id='$invoice'";		
	$result_total = @mysql_query ($query_total);
	$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
	$invoice_id = $row_total[0];
	$amount_due = $row_total[1];
	$invoice_date = $row_total[2];

		$GetCount = "SELECT count(*) from invoice_items WHERE invoice_id='$invoice' AND status='1'";
		$GetCount_result = @mysql_query ($GetCount);
		$GetCount_row = mysql_fetch_array($GetCount_result, MYSQL_NUM);
		
			if(($GetCount_row[0] == '0') || ($GetCount_row[0] == '')){
				$amount_billed = '0.00';
				} else {
				$query_billed = "SELECT SUM(qty * price) FROM invoice_items WHERE invoice_id='$invoice' AND status='1'";
				$result_billed = @mysql_query ($query_billed);
				$row_billed = mysql_fetch_array($result_billed, MYSQL_NUM);
				$amount_billed = $row_billed[0];
				}
	
		if ($row_total[3] == 0){
		$paidby = 'Not Yet Paid';
		}
		elseif ($row_total[3] == 1){
		$paidby = 'Paypal';
		}
		elseif ($row_total[3] == 2){
		$paidby = 'Credit Card';
		}
		elseif ($row_total[3] == 3){
		$paidby = 'Check/Money Order';
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
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">My Invoices / Payments</span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2"><br>			        
			        <?php
include('account_top.php');?>
				  <br>
				  <br>
			        <table width="100%"  border="0" align="center" class="tableO1">
                      <tr>
                        <td width="25%" align="left" ></td>
                        <td width="19%" align="left" >&nbsp;</td>
                        <td width="16%" align="left" >&nbsp;</td>
                        <td width="20%" align="right" ><b><a href="myinvoices.php?show=paid">[ Paid Invoices ]</a></b></td>
                        <td width="20%" align="left" ><b><a href="myinvoices.php?show=open">[ Open Invoices ]</a></b></td>
                      </tr>
				    </table>
					<table width="100%"  border="0" align="center" class="tableO1">
					<tr>
					<td width="149" colspan="1" align="right"><div align="left"><span class="BasicText">[Invoice #]: 
			        <?=$invoice;?>
					  </span></div></td>
					<td width="38" align="right">&nbsp;</td>
					<td width="148" colspan="1" align="right"><div align="left"><span class="BasicText">[Invoice ID]: 
			        <?=$invoice_id;?>
					  </span></div></td>
					<td width="30" align="right">&nbsp;</td>
					<td colspan="2" align="right"><div align="center"><span class="BasicText">[Invoice Date]: 
			        <?=$invoice_date;?>
					  </span></div></td>
					</tr>
                      <tr class="titlepic">
                        <td colspan="2" align="left" class="titlepic"><span class="whiteheader"><b>[Description]</b></span></td>
                        <td colspan="2" align="center" class="titlepic"><span class="whiteheader"><b>[Order Type]</b></span></td>
                        <td width="150" align="center" class="titlepic"><span class="whiteheader"><b>[Qty/Years]</b></span></td>
                        <td width="175" align="center" class="titlepic"><span class="whiteheader"><b>[Status]</b></span></td>
                        <td width="150" align="center" class="titlepic"><span class="whiteheader"><b>[Amount]</b></span></td>
                      </tr>

<?php
	$query2 = "SELECT * FROM invoice_items WHERE user_id='$user_id' AND invoice_id='$invoice'";
	$result2 = @mysql_query ($query2);
	$bg = '#eeeeee'; //Set the background color
while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
	$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround
	$prodid = $row2[prodid];
	$status = $row2[status];
	$table_id = $row2[table_id];
	
switch ($prodid){
	case "1":
		$order_type = "Register";
		$description = "$row2[sld].$row2[tld]";
	break;
	case "2":
		$order_type = "Renew";
		$description = "$row2[sld].$row2[tld]";
	break;
	case "3":
		$order_type = "Transfer";
		$description = "$row2[sld].$row2[tld]";
	break;
	case "4":
		$order_type = "ID Protect Purchase";
		$description = "$row2[sld].$row2[tld]";
	break;
	case "5":
		$order_type = "Pop Email Boxes";
		$description = "$row2[sld].$row2[tld]";
	break;
	case "7":
		$order_type = "URL Forwarding/Frame";
		$description = "$row2[sld].$row2[tld]";
	break;
	case "8":
		$order_type = "Email Forwarding";
		$description = "$row2[sld].$row2[tld]";
	break;
	case "11":
		$order_type = "Web Hosting";
		$description = "$row2[host_username]";
	break;
	case "12":
		$order_type = "DNS only Hosting";
		$description = "$row2[sld].$row2[tld]";
	break;
		}
		
switch ($status){
	case "0":
		$status = "Processing";
	break;
	case "1":
		$status = "Completed Successfully";
	break;
	case "2":
		$status = "Order Failed";
	break;
	}

$getit = "select (price * qty) from invoice_items WHERE table_id='$table_id'";
$gotit = mysql_query($getit);
$row = mysql_fetch_array($gotit, MYSQL_NUM);
$price = $row[0];


			 echo "<tr bgcolor=\"$bg\">
				<td colspan=\"2\" align=\"left\"><span class=\"BasicText\">$description</td>
				<td colspan=\"2\" align=\"center\"><span class=\"BasicText\">$order_type</td>
				<td align=\"center\"><span class=\"BasicText\">$row2[qty]</td>
				<td align=\"center\"><span class=\"BasicText\">$status</td>
				<td align=\"center\"><span class=\"BasicText\">$price</td>
			  </tr>";
 }
?><tr><td><br></td></tr>
					 <tr>
					   <td colspan="5" align="center"></td>
					   <td align="right" class="BasicTextMED">Amount Billed:</td>
					   <td align="center" class="BasicTextMED"><span class="BasicText"><strong>
					     $<?=$amount_billed;?>
					   </strong></span></td>
				      </tr>
					 <tr>
					 <td colspan="5" align="center">
					 </td>
					 <td align="right" class="BasicTextMED"><span class="BasicTextMED">Amount Paid</span>:
					 </td>
					 <td align="center" class="BasicTextMED"><span class="BasicText"><strong>
				     $<?=$amount_due;?>
					 </strong></span>
					 </td>
					 </tr>
					 <tr>
					 <td colspan="5" align="center">
					 </td>
					 <td align="right" class="BasicTextMED">Paid By:
					 </td>
					 <td align="center" class="BasicTextMED"><span class="BasicText"><strong>
				     <?=$paidby;?>
					 </strong></span>
					 </td>
					 </tr>
                    </table>
		            <p align="center" class="BasicText"><strong><a href="myinvoices.php?show=paid"><u>Back to My Invoices</u></a></strong></p>
		      <tr>
	          </table>
</table>
<?php include('include/footer.php');?>