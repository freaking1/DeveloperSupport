<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=myinvoices");
	exit(); 
} 

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

$display = $_GET["d"];

	if($display == ''){
		$display = 15;}


$show = $_GET["show"];
if($show == "paid"){
$query_invoice = "SELECT COUNT(*) FROM customer_invoice WHERE status = '1' AND username = '$username'";
$paid = 'status=1';
} 
elseif($show == "open"){
$query_invoice = "SELECT COUNT(*) FROM customer_invoice WHERE status = '0' AND username = '$username'";
$paid = 'status=0';
}
elseif($show == ''){
$query_invoice = "SELECT COUNT(*) FROM customer_invoice WHERE username = '$username'";
$paid = "(status='1' OR status='0')";

}
elseif($show == 'all'){
$query_invoice = "SELECT COUNT(*) FROM customer_invoice WHERE username = '$username'";
$paid = "(status='1' OR status='0')";
}

	$result_invoice = @mysql_query($query_invoice);
	$row_invoice = mysql_fetch_array($result_invoice, MYSQL_NUM);
	$num_invoice = $row_invoice[0];

	if($num_invoice >= 1){ 
	$has_invoice = 1;
	} else {
	$has_invoice = 0;
	}
	
$action = $_GET["action"];

if($action == "delete"){
	$invoice = $_GET["invoice"];
	$query_del = "DELETE FROM customer_invoice WHERE user_id='$user_id' AND username='$username' AND invoice_id='$invoice'";
	$result_del = @mysql_query($query_del);
		if($result_del){
			$query2_del = "DELETE FROM invoice_items WHERE user_id='$user_id' AND invoice_id='$invoice'";
			$result2_del = @mysql_query($query2_del);
			$optomize_table = "OPTIMIZE TABLE `invoice_items` ";
			$result_optomize = @mysql_query($optomize_table);
			$message .= "Invoice $invoice has been deleted and the Order has been cancelled";
			$error = 0;
		} else {
		$message .= "there was an error deleting the order, please try again later.";
		$error = 1;
		}
}
	$page = "myaccount";
?>

<script language="JavaScript">
<!-- 
function goToURL(form)
{
var myindex=form.dropdownmenu.selectedIndex
if(!myindex=="")
  {
	window.location.href=form.dropdownmenu.options[myindex].value;
  }
}
//-->
</script>
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
				  <td height="19" colspan="3" align="center" class="titlepic"><span class="whiteheader">My Invoices / Payments</span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="OutlineOne"><p align="center">
			        <?php include('account_top.php');?>
				  <br>
				  <br>
			        <table width="100%"  border="0" align="center" class="tableO1">
                      <tr>
                        <td width="20%" align="left" ></td>
                        <td width="20%" align="left" >&nbsp;</td>
                        <td width="10%" align="left" >&nbsp;</td>
                        <td width="50%" align="right" ><div align="center" class="BasicText"><strong>[ <a href="myinvoices.php?show=all">Show All</a> ] | [ <a href="myinvoices.php?show=paid">Paid Invoices</a> ] | [ <a href="myinvoices.php?show=open">Open Invoices</a> ]</strong></div></td>
                      </tr>
					  </table>
			        <table width="100%"  border="0" align="center" class="tableO1">
                      <tr class="titlepic">
                        <td align="left" class="titlepic"><span class="whiteheader"><b>[ID]</b></span></td>
                        <td align="center" class="titlepic"><span class="whiteheader"><b>[Date]</b></span></td>
                        <td align="center" class="titlepic"><span class="whiteheader"><b>[Amount]</b></span></td>
                        <td align="center" class="titlepic"><span class="whiteheader"><b>[Status]</b></span></td>
                        <td align="center" class="titlepic"><span class="whiteheader"><b>[Actions]</b></span></td>
                      </tr>
                     <?php
if($has_invoice == '0'){
 echo "<tr bgcolor=\"$bg\">
	<td colspan=\"5\" align=\"center\"><span class=\"BasicTextMED\">You have no $show Invoices!</td>
  </tr>"; } else {

	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT * FROM customer_invoice WHERE user_id='$user_id' AND username='$username' AND $paid ORDER BY invoice_id DESC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_invoice > $display) { // More than 1 page.
			$num_pages = ceil ($num_invoice/$display);
		} else {
			$num_pages = 1;
		}
	}

	$bg = '#eeeeee'; //Set the background color
	if (isset($_GET['s'])) { // Already been determined.
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
	$query2 = "SELECT * FROM customer_invoice WHERE user_id='$user_id' AND username='$username' AND $paid ORDER BY invoice_id DESC LIMIT $start, $display";
	$result2 = @mysql_query($query2);
while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
	$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround
	//Determine if Registrar lock is turned on for this domain name or not, and display the results
		$invoice_id = $row2[invoice_id];
		if($row2[status] == 0){
			$status = "Processing";
			} 
			elseif($row2[status] == 1){
			$status = "Completed";
			}
			elseif($row2[status] == 2){
			$status = "Failed";
			}
		if ($row2[paid] == 0){
		$action2 = "<a href=\"myinvoices.php?invoice=$invoice_id&action=delete\">Delete Order</a>";
		$action1 = "<a href=\"pay_invoice.php?invoice=$invoice_id&action=pay\">View/Pay Invoice</a>";
		$actions = "<b><u>$action1</u></b> &nbsp;&nbsp;|&nbsp;&nbsp; <b><u>$action2</u></b>";
		} else if
		($row2[paid] == 1){
		//reg lock is on
		$actions = "<b><u><a href=\"viewinvoice.php?invoice=$invoice_id&refer=myinvoices\">View Invoice</a><b><u>";
		}
					 echo "<tr bgcolor=\"$bg\">
                        <td align=\"left\"><span class=\"BasicText\">$invoice_id</td>
                        <td align=\"center\"><span class=\"BasicText\">$row2[date]</td>
                        <td align=\"center\"><span class=\"BasicText\">$row2[amount_due]</td>
                        <td align=\"center\"><span class=\"BasicText\">$status</td>
                        <td align=\"center\"><span class=\"BasicText\">$actions</td>
                      </tr>";
					 }

}
                    echo '</table>'; 
					echo '<table width="100%"  border="0" align="center">';
					?>
										<tr><td align="center" bgcolor="#eeeeee" width="10%">
						  <form name="Name">
<select name="dropdownmenu" size=1 onChange="goToURL(this.form)">
<option selected value="">
Display</option>
<option value="<?php echo "$site_url/myinvoices.php?show=$show&d=15";?>">
15</option>
<option value="<?php echo "$site_url/myinvoices.php?show=$show&d=25";?>">
25</option>
<option value="<?php echo "$site_url/myinvoices.php?show=$show&d=50";?>">
50</option>
<option value="<?php echo "$site_url/myinvoices.php?show=$show&d=75";?>">
75</option>
<option value="<?php echo "$site_url/myinvoices.php.php?show=$show&d=100";?>">
100</option>
</select></form></td><td bgcolor="#eeeeee" align="center" width="90%"><span class="BasicTextMED"><b><?
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT * FROM customer_invoice WHERE user_id='$user_id' AND username='$username' AND $paid ORDER BY invoice_id DESC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_records > $display) { // More than 1 page.
			$num_pages = ceil ($num_records/$display);
		} else {
			$num_pages = 1;
		}
	}
	if (isset($_GET['s'])) { // Already been determined.
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
	$query_all = "SELECT * FROM customer_invoice WHERE user_id='$user_id' AND username='$username' AND $paid ORDER BY invoice_id DESC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	if ($num > 0) { // If it ran OK, display the records.
		if ($num_pages > 1) {
			$current_page = ($start/$display) + 1;
			if ($current_page != 1) {
				echo '<u><a href="myinvoices.php?show='.$show.'&d='.$display.'&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a></u> ';
			}
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo ' <u><a href="myinvoices.php?show='.$show.'&d='.$display.'&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a></u> ';
				} else {
					echo $i . ' ';
				}
			}
			if ($current_page != $num_pages) {
				echo ' <u><a href="myinvoices.php?show='.$show.'&d='.$display.'&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a></u>';
			}
		} // End of links section.
	}
} ?>
</span></td></tr></table>		
			        <p>&nbsp;</p>
			    <p></p>
		      <tr>
	          </table>
</table>
<?php include('include/footer.php');?>