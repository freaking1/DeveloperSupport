<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=checkout");
	exit(); // Quit the script.
}

include("include/dbconfig.php");

$command = $_GET["command"];
$query_total = "SELECT sum(price * qty) FROM cart where user_id='$user_id'";		
$result_total = @mysql_query ($query_total);
$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
$total_price = $row_total[0];
$page_title = 'Check Out';

if($action == "GO"){

	include_once('include/config.inc.php'); 
	include_once('include/global_config.inc.php');
	include("include/dbconfig.php");
	
	$query_invoice = "SELECT invoice_count FROM extra";
	$result_invoice = @mysql_query($query_invoice);
	$row_invoice = mysql_fetch_array($result_invoice, MYSQL_NUM);
	$invoice_id = ($row_invoice[0]+1);
	$query_check = "SELECT invoice_id FROM customer_invoice WHERE invoice_id='$invoice_id'";
	//Runs the qyery and Sets the variable for Invoice Starting position
	$result_check = @mysql_query ($query_check);
		if(mysql_num_rows($result_check) == 0){
				//Inserts the New Invoice into the invoice table
				$query2 = "INSERT INTO customer_invoice (user_id, username, invoice_id, paid, status, amount_due, date)
							VALUES ('$user_id', '$username', '$invoice_id', '0', '0', '$total_price', NOW() )";
				$result2 = @mysql_query($query2);
				//Inser the Invoice Items into the invoice_items table
				$query3 = "SELECT COUNT(*) FROM cart WHERE user_id='$user_id' ORDER BY cart_id ASC";
				$result3 = @mysql_query($query3);
				$row3 = mysql_fetch_array($result3, MYSQL_NUM);
				$number = ($row3[0] -1);
	$sql = " SELECT * FROM cart WHERE user_id='$user_id' ORDER BY cart_id ASC";
	$result4 = mysql_query($sql); 
while ($row4 = mysql_fetch_array($result4)) {
				$sld = $row4[cartsld];
				$tld = $row4[carttld];
				$prodid = $row4[prodid];
				$price = $row4[price];
				$qty = $row4[qty];
				$command = $row4[extra1];
				$host_password = $row4[host_pass];
				$host_username = $row4[extra4];
				$qstring = $row4[extra2];
				$dns = $row4[dns];
				$full_name = $row4[full_name];
				$email_addy = $row4[email_addy];
				$p_name = $row4[p_name];
				$package_id = $row4[extra3];
				
    $query5 = "INSERT INTO invoice_items (user_id, invoice_id, sld, tld, status, prodid, price, qty, extra, command, host_package, host_username, host_password, dns, string, full_name, email_addy, p_name)
    VALUES ('$user_id', '$invoice_id', '$sld', '$tld', '0', '$prodid', '$price', '$qty', '$extra', '$command', '$package_id', '$host_username', '$host_password', '$dns', '$qstring', '$full_name', '$email_addy', '$p_name')";
	$result5 = @mysql_query($query5);
}
				$query1 = "UPDATE extra SET invoice_count='$invoice_id' WHERE id='1'";
				$result1 = @mysql_query($query1);
	
	$query_info = "SELECT fname, lname, email FROM users WHERE username='$username' AND id='$user_id'";
	$result_info = @mysql_query($query_info);
	$row_info = mysql_fetch_array($result_info, MYSQL_ASSOC);
	$fname = $row_info[fname];
	$lname = $row_info[lname];
	$email = $row_info[email];
	
					$query = "SELECT * FROM cart WHERE user_id='$user_id' ORDER BY cart_id ASC";
					$result = @mysql_query ($query);
					while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
					$cart_id = $row[cart_id];
					
					$query2 = "SELECT * FROM products where prodid='$row[prodid]'";		
					$result2 = @mysql_query ($query2);
					$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
					$product_name = $row2[product_name];
						if($product_name == "Web Hosting"){
						$product_name .= " - $row[extra1]";
						}
						if($prodid == '3'){
						$OrderType = $row2[extra3];
						}
					
					$selectqty = "SELECT (price * qty) FROM cart WHERE cart_id='$cart_id'";
					$returnqty = @mysql_query($selectqty);
					$rowqty = mysql_fetch_array($returnqty, MYSQL_NUM);
					
					$price = $rowqty[0];
					
		if($row[extra1] == "CreateHostAccount"){
		$domain = "Username: $row[extra4] - $row[p_name] Plan";
		} else {
		$domain = "$row[cartsld].$row[carttld]";
		} 
 
		// Print the row.
		$body3 .= "$product_name  $domain  \$$price\n\r";
		}
						//Send email for invoice
			include("include/emails/order_conf.php");
		}// End If statement
		$post_options = "?invoice=$invoice_id&option=pay&target=pay_invoice&refer=checkout&generateSucCesS=1";
		header ("Location:  $secure_site_url/pay_invoice.php$post_options");
		exit();
	}//End if action = Go
	
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
				  <td height="19" colspan="8"  class="titlepic"><div align="center"><span class="whiteheader">Check Out </span></div></td>
			    </tr>
				<tr valign="top">
			      <td height="369" colspan="3" valign="top" class="content2"><br>
				  
				  <table width="80%"  border="0" align="center" class="tableO1">
                    <tr>
                      <td><span class="BasicText"><b>[Order Type]</b></span></td>
					  <td colspan="2"><span class="BasicText"><b>[Description]</b></span></td>
					  <td align="right"><span class="BasicText"><b>[Price]</b></span></td>
					  </tr>
					  
<?php
$query = "SELECT * FROM cart WHERE user_id='$user_id' ORDER BY cart_id ASC";
$result = @mysql_query ($query);
while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
$cart_id = $row[cart_id];

$query2 = "SELECT * FROM products where prodid='$row[prodid]'";		
$result2 = @mysql_query ($query2);
$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
$product_name = $row2[product_name];
	if($product_name == "Web Hosting"){
	$product_name .= " - $row[extra1]";
	}
	if($prodid == '3'){
	$OrderType = $row2[extra3];
	}

$selectqty = "SELECT (price * qty) FROM cart WHERE cart_id='$cart_id'";
$returnqty = @mysql_query($selectqty);
$rowqty = mysql_fetch_array($returnqty, MYSQL_NUM);

$price = $rowqty[0];
/*
if($row[qty] == '1'	){
$price = $row[price];
} else {
$price = ($row[price] * $row[qty]);
}
$prod_price = $row[price];
$cart_id = $row[cart_id];
*/

if($row[extra1] == "CreateHostAccount"){
$domain = "Username: $row[extra4] - $row[p_name] Plan";
} else {
$domain = "$row[cartsld].$row[carttld]";
} 
 
		// Print the row.
		echo "	<tr>
        <td nowrap align=\"left\"><input type=\"hidden\" maxlength=\"2\" size=\"2\" name=\"cart_id\" value=\"$cart_id\">$product_name</td>
		<td colspan=\"2\" align=\"left\">$domain</td>
		<td align=\"right\">$price</td>
	</tr>";
$query_total = "SELECT sum(price * qty) FROM cart where user_id='$user_id'";		
$result_total = @mysql_query ($query_total);
$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
$total_price = $row_total[0];



	} // End of the WHILE loop.
	
	echo "<tr><td colspan=\"6\" align=\"right\"><b>Total:</b></td><td align=\"left\"> <b>$total_price</b></td></tr>";
	// Print the footer, close the table, and the form.
?></td>
                    </tr> </table>
					  <br>
<table width="687" align="center">
  <form method="post" action="<?php echo "checkout.php?action=GO";?>">
                    <tr>
                      <td width="209" colspan="1"><div align="center">
                        <input name="image2" type="image" src="images/btn_purchase.gif" border="0">
					    </div></td>
                      <td width="466">
						Proceed to payment options.  By clicking purchase, you are agreeing to the
						<a onclick="window.open(agreement.php,width=1050,height=500,status=no,scrollbars=1,resizable=1&quot;);return false;" target="_blank" href="agreement.php"> <b>Domain Registration Agreement.</b></a>
						All sales are final, no refunds will be issued.<br>
<br>

					</td>
    </tr>
                    <tr>
                      <td colspan="1">
					    <div align="center">
					     <a href="view_cart.php" ><input name="image2" type="image" src="images/btn_gotocart_114x22.gif" border="0"></a>
					      </div></td>
					<td colspan="2">
    Go to your shopping cart to make any changes.					</td></tr>
  </form>
                   </table>                  </table>                  
                    
                    <center>
	<?php
	if($action == "GO"){ ?>
<br><center><span class="BasicTextBIG"><b>Generating Invoice</b></span></center>
<? } ?>
					<br>
                    
                    <table width="80%"  border="0" valign="top" align="center" >
                      <tr valign="top" >
                        <td><center></td>
                      </tr>
              </table>
					<p>&nbsp;</p></td>
				</tr>
			      <tr>
	          </table>
</table> 
<?php include('include/footer.php');?>
