<?php 
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=view_cart");
	exit(); // Quit the script.
}

require( "include/dbconfig.php" );

$shop = $_GET['shop'];

if($shop == ''){
$shopsite = 'check.php';
} else {
$shopsite = "$shop.php";
}

$command = $_GET["command"];
$query_total = "SELECT sum(price) FROM cart where user_id='$user_id'";		
$result_total = @mysql_query ($query_total);
$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
$total_price = $row_total[0];

$query_count = "SELECT COUNT(*) FROM cart WHERE user_id='$user_id'";
$result_count = @mysql_query ($query_count);
$row_count = mysql_fetch_array($result_count, MYSQL_NUM);
$item_count = $row_count[0];

if($item_count >= 1){
	$has_items = 1; 
	}

if($command == "delete"){
	$query_delete = "DELETE FROM cart WHERE cart_id='$cart_id'";		
	$result_delete = @mysql_query($query_delete);
	if($result_delete){
	$message = "Successfully Removed Selected Item";
	$query_total = "SELECT sum(price) FROM cart where user_id='$user_id'";		
	$result_total = @mysql_query ($query_total);
	$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
	} else { $message = "didnt";}
}

if(($action == "update_cart") || ($command == "update_cart")){
$command = $_GET["command"];
$old_qty = $_GET["old_qty"];
$new_qty = $_GET["new_qty"];
$cart_id = $_GET["cart_id"];
} else {
$action = $HTTP_POST_VARS[ "action" ];
$new_qty = $HTTP_POST_VARS['newqty'];
}

if(($action == "update_cart") || ($command == "update_cart")){
	$old_qty = $HTTP_POST_VARS['oldqty'];
	$new_qty = $HTTP_POST_VARS['newqty'];
	$cart_id = $HTTP_POST_VARS['cart_id'];
	
	if($new_qty == $old_qty){
	$message = "Cart contents not changed";}
	
	if($new_qty != 0){
		$query2 = "SELECT * FROM products where prodid='$row[prodid]'";		
		$result2 = @mysql_query ($query2);
		$num = mysql_num_rows($result2);
				if($new_qty != $old_qty) {
					$query_update = "UPDATE cart SET qty='$new_qty' WHERE cart_id='$cart_id'";		
					$result_update = @mysql_query($query_update);
					if(mysql_affected_rows() == 1){
					$message = "Successfully updated Cart Contents";
					$query_total = "SELECT sum(price) FROM cart where user_id='$user_id'";		
					$result_total = @mysql_query ($query_total);
					$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
					}
				}
	}
	
	if($new_qty == 0){
			$query_delete = "DELETE FROM cart WHERE cart_id='$cart_id'";		
			$result_delete = @mysql_query ($query_delete);
			$message = "The item has been removed from your cart.";
			if(mysql_affected_rows() == 1){
			$message = "Successfully Removed Selected Item";
			$query_total = "SELECT sum(price) FROM cart where user_id='$user_id'";		
			$result_total = @mysql_query ($query_total);
			$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
			$total_price = $row_total[0];
			}
	}
}
$page_title = 'View Your Shopping Cart';
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
				  <td height="19" colspan="6"  class="titlepic"><span class="whiteheader">My Cart</span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td class="table00" colspan="2" valign="top" >
			        <table width="100%" border="0" align="center" class="tableOO" valign="top">
                    <tr>
                      <td width="100%">
				<?php
	if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center>';
	}

				//QTY LINE 114
	echo '<center><table border="0" width="100%" cellspacing="3" cellpadding="3" align="center" class="tableO1" valign="top">
	<tr class="titlepic">
		<td align="left" width="2%" nowrap><b></b></td>
		<td align="left" width="2%" nowrap><b></b></td>
		<td align="left" width="30%" nowrap><b><span class="whiteheader">Product Description</b></span></td>
                          <td width="15% valign="top"><span class="whiteheader"><strong>Per Year</strong></span></td>
                          <td width="30% valign="top" align="left" nowrap><span class="whiteheader"><strong>Domain Name </strong></span></td>
                          <td width="8% valign="top" nowrap><span class="whiteheader"><strong>QTY</strong></span></td>
                          <td colspan="2" width="30% valign="top" align="middle"><span class="whiteheader"><b>Price<b></span></td>
	</tr>
<form action="view_cart.php" method="post">
<input type="hidden" name="action" value="update_cart">
';
if($has_items == 1){
	// Print each item.
	$total = 0; // Total cost of the order.
$query = "SELECT * FROM cart WHERE user_id='$user_id' ORDER BY cart_id ASC";
$result = @mysql_query ($query);
$bg = '#eeeeee'; //Set the background color
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround
$query2 = "SELECT * FROM products where prodid='$row[prodid]'";		
$result2 = @mysql_query ($query2);
$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
$product_name = $row2[product_name];
$cart_id = $row[cart_id];
	if($product_name == "Web Hosting"){
	$product_name = "Web Hosting Account";
	$prod_price = $row[price].''.' /Month';
	} elseif ($product_name == "Domain name Transfer"){
	$prod_price = $row[price];
	} else {
	$prod_price = $row[price].''.' /Year';
	}
$selectqty = "SELECT (price * qty) FROM cart WHERE cart_id='$cart_id'";
$returnqty = @mysql_query($selectqty);
$rowqty = mysql_fetch_array($returnqty, MYSQL_NUM);

$price = $rowqty[0];
	
$cart_id = $row[cart_id];
$prodid = $row[prodid];
$tld = $row[carttld];
$sld = $row[cartsld];
$pf = $row[preconfig];

if($row[extra1] == "CreateHostAccount"){
$domain = "Username: $row[extra4] <br> Plan: \"$row[p_name]\"";
} else {
$domain = "$row[cartsld].$row[carttld]";
} 


if ((($tld == "us") || ($tld == "co.uk") || ($tld == "org.uk") || ($tld == "ca")) && $prodid == "1"){
	$preconfig_tld = 1;
	} else {
	$preconfig_tld = 0; 
	}
if(($preconfig_tld == 1) && ($pf != 1)){
		$preconfig = "<a href=\"preconfig.php?command=config&sld=$sld&tld=$tld&cart_id=$cart_id&refer=view_cart\"><img alt=\"Preconfiguration is Required\" src=\"images/preconfig.gif\" border=\"2\"></a>";
		} else {
			if($row[prodid] == 1){
		$preconfig = "<a href=\"preconfig.php?command=config&sld=$sld&tld=$tld&cart_id=$cart_id&refer=view_cart\"><img alt=\"Preconfiguration is Required\" src=\"images/preconfig.gif\" border=\"0\"></a>";
				} else {
				$preconfig = '';
				}
		}

$delete_item = "<a href=\"view_cart.php?command=delete&cart_id=$cart_id\"><img alt=\"Delete from cart\" src=\"images/delete.gif\" border=\"0\"></a>";

		// Print the row.
		echo "	<tr bgcolor=\"$bg\">
         <td align=\"left\" nowrap>$preconfig</td><td align=\"left\" nowrap> $delete_item
		<input type=\"hidden\" maxlength=\"4\" size=\"4\" name=\"cart_id\" value=\"$cart_id\"></td>
        <td nowrap align=\"left\">$product_name</td><td nowrap align=\"left\">$prod_price</td>
		  <td colspan=\"1\" align=\"left\">$domain</td>
		<td align=\"center\">$row[qty]</td>
		<td colspan=\"2\" align=\"center\">
		<input type=\"hidden\" size=\"1\" maxlength=\"1\" name=\"oldqty\" value=\"$row[qty]\" />
		<input type=\"hidden\" size=\"1\" maxlength=\"1\" name=\"newqty\" value=\"$row[qty]\" />
		$price</td>
	</tr>";
$query_total = "SELECT sum(price) FROM cart where user_id='$user_id'";		
$result_total = @mysql_query ($query_total);
$row_total = mysql_fetch_array($result_total, MYSQL_NUM);
$total_price = $row_total[0];
	} // End of the WHILE loop.
} else {
	echo "<tr><td colspan=\"8\" align=\"center\"><span class=\"BasicTextMED\">Your shopping cart is empty<br></span></td></tr>";
	echo "<tr><td colspan=\"8\" align=\"center\"><span class=\"BasicText\">Would you like to:</span><br></td></tr>";
	echo "<tr><td colspan=\"8\" align=\"center\"><span class=\"BasicText\"><b><u><a href=\"check.php\">-Register a new Domain Name</a></span></b></u></td></tr>";
	echo "<tr><td colspan=\"8\" align=\"center\"><span class=\"BasicText\"><b><u><a href=\"webhosting.php\">-Purchase a Web Hosting account</a></span></b></u></td></tr>";
	echo "<tr><td colspan=\"8\" align=\"center\"><span class=\"BasicTextD\"><b><u><a href=\"transfers.php\">-Transfer a Domain name</a></span></td><b></u></tr>";
	}
	
	#Display a total of all items cost
	//if($has_items == 1){
	//echo "<tr><td colspan=\"6\" class=\"basictext\" align=\"right\"><b>Total:</b></td><td class=\"basictext\" align=\"left\"> <b>\$$row_total[0]</b></td></tr>	</table>";
	//}
	
	echo "<br>";
	echo "<table class=\"tableO1\"><tr><td colspan=\"2\" nowrap ><center> Legend</center></td></tr>";
	echo "<tr><td align=\"left\"><img alt=\"Delete from cart\" src=\"images/delete.gif\" border=\"0\"></td><td align=\"left\"> Delete From Cart </td></tr>";
	echo "<tr><td align=\"left\"><img alt=\"Preconfiguration is Required\" src=\"images/preconfig.gif\" border=\"2\"></td><td =\"left\">Preconfiguration Required</td></tr>";
	echo "<tr><td align=\"left\"><img alt=\"Preconfigure Domain\" src=\"images/preconfig.gif\" border=\"0\"></td><td =\"left\">Preconfiguration Optional</td></tr>";
	// Print the footer, close the table, and the form.
	echo '</table>	<div align="center">';
	echo '<br>';

$query = "SELECT COUNT(*) FROM cart WHERE preconfig = '0'";
$result = @mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_NUM);

if($has_items == 1){
	if($row[0] != 0){
	$checkout = "<td> </td><td nowrap><span class=\"BasicText\"><b>Please preconfigure all domains that require it before checking out</b></span></td>";
	} else {
	$checkout = '<td><a href="checkout.php"><img src="images/btn_checkout.gif" border="0"></a></td><td nowrap>Checkout all selected items and view totals.</td>';
	}
}
	echo '<p><table width="60%">';
	# UPDATE CART - PLACE BACK IN ONCE THE QTY IS RESTORED
	#<tr><td><input name="" type="image" src="images/btn_updatecart.gif" border="0"></a></td><td nowrap>Update the cart with your new changes.</td></tr>
	echo '<tr><td><a href="'.$shopsite.'"><img src="images/btn_contshop.gif" border="0"></a></td><td nowrap>Look for more domain names.</td></tr>';
echo	"<tr>$checkout</tr>
	</table>
	</form><br /><br /></div>";
		    ?>
					  </td>
                    </tr>
                  </table>     
			      <p>
                    </p>
       			  <td width="0%"></form>
<br>
			        <p align="center"><br> 
                    </p>
		      <tr>
	              <td colspan="2" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>