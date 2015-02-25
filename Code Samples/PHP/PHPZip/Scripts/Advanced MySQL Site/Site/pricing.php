<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

	$PageName = "pricing";
	$PageTitle = $SiteTitle . " - Product Pricing";
?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="149" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
			<td class="content" align="center" valign="top" width="811">
			<table width="100%" height="218" border="0" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td width="47%" height="19"  colspan="2" align="center" class="titlepic"><span class="whiteheader">TLD Pricing Per Year</span></td>
			      <td height="19"  class="titlepic" align="center"><span class="whiteheader">Other Product Pricing</span></td>
				</tr>
				<tr>
				  <td colspan="3" valign="top" >                
			  <tr>
			    <td colspan="2" valign="top" class="OutlineOne" ><br>
			     <?php echo' <table valign="center" align="center" width="321" border="0" class="tableO1">
                    <tr bordercolor="#313187" class=\"OutlineOne\">
                      <td width="71" align="center"><div align="center" class="style2"><strong>TLD</strong></div></td>
                      <td width="77" align="center"><div align="center" class="style2"><strong>Register</strong></div></td>
                      <td width="71" align="center"><div align="center" class="style2"><strong>Renew</strong></div></td>
                      <td width="84" align="center"><div align="center" class="style2"><strong>Transfer</strong></div></td>
                    </tr>';
	$query2 = "SELECT * FROM `tld_config` ORDER BY id ASC LIMIT 0 , 30" ;
	$result2 = mysql_query ($query2);
$bg = '#eeeeee'; //Set the background color
while($row2 = mysql_fetch_array ($result2, MYSQL_ASSOC)){
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround
		if ($row2[transfer_price] == 0.00){
		//Domain is not using our name servers 
		$transfer_price = "N/A";
		} else {
		$transfer_price = $row2[transfer_price];
		}
		if ($row2[renew_price] == 0.00){
		//Domain is not using our name servers 
		$renew_price = "N/A";
		} else {
		$renew_price = $row2[renew_price];
		}

echo 
"<tr bgcolor=\"$bg\" >
<td align=\"center\"><b><u><span class=\"BasicText\">$row2[tld]</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$row2[register_price]</b></td>
<td align=\"center\" ><b><span class=\"BasicText\">$renew_price</b></td>
<td align=\"center\" ><b><span class=\"BasicText\">$transfer_price</b></td>
</tr>\n";
} 
//End the While loop
echo
'</table>';?>
<?php
	$query_idpro = "SELECT * FROM product_pricing WHERE prodid='4'";
	$result_idpro = @mysql_query ($query_idpro);
	$row_idpro = mysql_fetch_array ($result_idpro, MYSQL_ASSOC);

	$query_dnsonly = "SELECT * FROM product_pricing WHERE prodid='12'";
	$result_dnsonly = @mysql_query ($query_dnsonly);
	$row_dnsonly = mysql_fetch_array ($result_dnsonly, MYSQL_ASSOC);
	
	$query_pop = "SELECT * FROM product_pricing WHERE prodid='5'";
	$result_pop = @mysql_query ($query_pop);
	$row_pop = mysql_fetch_array ($result_pop, MYSQL_ASSOC);
	?>
			      <br>                
			    <td width="53%" valign="top" class="OutlineOne" ><br>
			      <table valign="center" align="center" width="321" border="0" class="OutlineOne" >
                  <tr bgcolor="#FFFFFF">
                    <td class="OutlineOne"> <div align="left"><strong>ID Protect <br>
                    </strong><strong>
                      $<?=$row_idpro[price]?>
/year per domain <br>
<strong class="BasicText"><a href="idprotect.php" class="windowinside">-Learn More -</a> </strong><br>
</strong></div>                      </td>
                    </tr>
                  <tr bgcolor="#FFFFFF">
                    <td><div align="left"></div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td class="OutlineOne"> <div align="left"><strong>POP email accounts  </strong></div>                      <strong class="BasicText">
                      $<?=$row_pop[price]?>
/year per domain <br>
</strong><strong><strong class="BasicText"><a href="popemail.php" class="windowinside">-Learn More -</a></strong></strong><strong class="BasicText"><br>
                  </strong>
                    <div align="left"></div></td>
                    </tr>
                  <tr bgcolor="#FFFFFF">
                    <td><div align="left"></div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td class="OutlineOne"> <div align="left"><strong>DNS Only Hosting  </strong></div>                      <strong class="BasicText">
                      $<?=$row_dnsonly[price]?>
/year <br>
</strong><strong><strong class="BasicText"><a href="dnshosting.php" class="windowinside">-Learn More -</a></strong></strong><strong class="BasicText"><br>
</strong>
                    <div align="left"></div></td>
                    </tr>
                  <tr bgcolor="#FFFFFF">
                    <td><div align="left"></div></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td class="OutlineOne"> <div align="left"><strong>Web Site Hosting Accounts  </strong></div>                      
                      <strong>
                      <a href="webhosting.php" class="windowinside">- View Hosting Plans -</a></strong>
                      <div align="left"></div></td>
                    </tr>
                </table>                
			      <blockquote>
			        <p>&nbsp;</p>
		          </blockquote>
		      <tr>
		        <td colspan="3" valign="top" ><p align="center"><br>
All prices are in US dollars and are the complete fee to register a domain name or use that service. There are no "hidden" fees to any other parties. 
                  </p>
	            <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>