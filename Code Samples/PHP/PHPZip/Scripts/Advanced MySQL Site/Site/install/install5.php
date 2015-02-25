<?php
session_name ('API-PHPSESSID-INSTALL');
session_start(); // Start the session.

require("../include/dbconfig.php");

$StepNumber = $_SESSION['StepNumber'];
$continue = $_GET['done'];
if ($StepNumber != 5){
	header ("Location:  $site_url/install/install$StepNumber.php");
	exit(); // Quit the script.
}

$query = "SELECT id, tld, register_price, renew_price, transfer_price FROM `tld_config` ORDER BY id ASC" ;
$result = mysql_query ($query);
$resultidprotect = mysql_query("select * from product_pricing where prodid='4'");
$row_idprotect = mysql_fetch_row($resultidprotect);
$idprice = $row_idprotect[1];
$resultpop = mysql_query("select * from product_pricing where prodid='5'");
$row_pop = mysql_fetch_row($resultpop);
$popprice = $row_pop[1];
$resultdnshosting = mysql_query("select * from product_pricing where prodid='12'");
$row_dnshosting = mysql_fetch_row($resultdnshosting);
$dnshostingprice = $row_dnshosting[1];
$resultrgp = mysql_query("select * from product_pricing where prodid='13'");
$row_rgp = mysql_fetch_row($resultrgp);
$rgpprice = $row_rgp[1];
$resultname = mysql_query("select * from product_pricing where prodid='14'");
$row_name = mysql_fetch_row($resultname);
$nameprice = $row_name[1];
$action = $_POST[ "action" ];
	if ( $action == "update" ) {
		$sqlupdatecom = mysql_query("update tld_config SET register_price = '$regcom', renew_price = '$rencom', transfer_price = '$trancom' where tld='com'");
		$sqlupdatenet = mysql_query("update tld_config SET register_price = '$regnet', renew_price = '$rennet', transfer_price = '$trannet' where tld='net'");
		$sqlupdateorg = mysql_query("update tld_config SET register_price = '$regorg', renew_price = '$renorg', transfer_price = '$tranorg' where tld='org'");
		$sqlupdatebiz = mysql_query("update tld_config SET register_price = '$regbiz', renew_price = '$renbiz', transfer_price = '$tranbiz' where tld='biz'");
		$sqlupdateus = mysql_query("update tld_config SET register_price = '$regus', renew_price = '$renus', transfer_price = '$tranus' where tld='us'");
		$sqlupdateinfo = mysql_query("update tld_config SET register_price = '$reginfo', renew_price = '$reninfo', transfer_price = '$traninfo' where tld='info'");
		$sqlupdatename = mysql_query("update tld_config SET register_price = '$regname', renew_price = '$renname' where tld='name'");
		$sqlupdatews = mysql_query("update tld_config SET register_price = '$regws', renew_price = '$renws' where tld='ws'");
		$sqlupdatencc = mysql_query("update tld_config SET register_price = '$regcc', renew_price = '$rencc', transfer_price = '$trancc' where tld='cc'");
		$sqlupdatenca = mysql_query("update tld_config SET register_price = '$regca', renew_price = '$renca' where tld='ca'");
		$sqlupdatencouk = mysql_query("update tld_config SET register_price = '$regcouk', renew_price = '$rencouk', transfer_price = '$trancouk' where tld='co.uk'");
		$sqlupdateorguk = mysql_query("update tld_config SET register_price = '$regorguk', renew_price = '$renorguk', transfer_price = '$tranorguk' where tld='org.uk'");
		$sqlupdateuscom = mysql_query("update tld_config SET register_price = '$reguscom' where tld='us.com'");
		$sqlupdateeucom = mysql_query("update tld_config SET register_price = '$regeucom' where tld='eu.com'");
		$sqlupdatede = mysql_query("update tld_config SET register_price = '$regde' where tld='de'");
		$sqlupdatetv = mysql_query("update tld_config SET register_price = '$regtv', renew_price = '$rentv' where tld='tv'");
		$sqlupdatein = mysql_query("update tld_config SET register_price = '$regin', renew_price = '$renin', transfer_price = '$tranin' where tld='in'");
		$sqlupdatetc = mysql_query("update tld_config SET register_price = '$regtc', renew_price = '$rentc' where tld='tc'");
		$sqlupdatevg = mysql_query("update tld_config SET register_price = '$regvg', renew_price = '$renvg' where tld='vg'");
		$sqlupdatems = mysql_query("update tld_config SET register_price = '$regms', renew_price = '$renms' where tld='ms'");
		$sqlupdategs = mysql_query("update tld_config SET register_price = '$reggs', renew_price = '$rengs' where tld='gs'");
		$sqlupdatejp = mysql_query("update tld_config SET register_price = '$regjp', renew_price = '$renjp', transfer_price = '$tranjp' where tld='jp'");
		$sqlupdatenu = mysql_query("update tld_config SET register_price = '$regnu', renew_price = '$rennu' where tld='nu'");
		$sqlupdatebz = mysql_query("update tld_config SET register_price = '$regbz', renew_price = '$renbz' where tld='bz'");
		$sqlupdatecn = mysql_query("update tld_config SET register_price = '$regcn', renew_price = '$rencn', transfer_price = '$trancn' where tld='cn'");

		//Now update the products
			$newidprice = $HTTP_POST_VARS['Idprotect'];
			$newdnsprice = $HTTP_POST_VARS['DNSHosting'];
			$newpopprice = $HTTP_POST_VARS['PopMail'];
			$newrgpprice = $HTTP_POST_VARS['RGP'];
			$newnameprice = $HTTP_POST_VARS['NameForwarding'];

		$updateid = mysql_query("update product_pricing SET price = '$newidprice' where prodid='4'");
		$updatepop = mysql_query("update product_pricing SET price = '$newpopprice' where prodid='5'");
		$updatednshosting = mysql_query("update product_pricing SET price = '$newdnsprice' where prodid='12'");
		$updatergp = mysql_query("update product_pricing SET price = '$newrgpprice' where prodid='13'");
		$updatename = mysql_query("update product_pricing SET price = '$newnameprice' where prodid='14'");
				header ("Location:  $site_url/install/install5.php?done=1");
				exit(); // Quit the script.
}
?>
<link rel="stylesheet" href="../css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('../include/header.php')?>
	    </tr>
</table>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td height="313" valign="top">
			  <table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader"> Welcome to the Enom  API Installer script - Installation - Step
				    <?=$StepNumber;?></span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">
			        <p><form action="install5.php" method="post"></p>
						<input type="hidden" name="action" value="update">
			   <?php
			   if($continue == 1){
			   echo "<center><span class=\"BasicText\"> Your changes have been saved.  If you would like to change them again, please do so - other wise click on the \"Next Step\" Button to continue</span><br><br>";
			   } else {
			   echo "<center><span class=\"BasicText\"> Please be patient after submitting, this may take a minute</span><br><br>";
			   }

		echo'        <table width="501" height="58" border="0" align="center" cellpadding="0" cellspacing="0" class="tableOO">
	  <tr>
		<th width="497" height="18" class="titlepic" scope="col"><span class="whiteheader">Setup Domain and product pricing.</span></th>
	  </tr>
	  <tr>
		<td><br>                          <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
		  <tr>
			<th width="20%" scope="col"><div align="center">TLD</div></th>
			<th width="26%" scope="col"><div align="center">Register</div></th>
			<th width="23%" scope="col"><div align="center">Renew</div></th>
			<th width="31%" scope="col"><div align="center">Transfer</div></th>

		  </tr>';
$bg = '#eeeeee'; //Set the background color
while($row = mysql_fetch_array ($result, MYSQL_ASSOC)){
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround

		if($row[tld] == 'co.uk'){
			$tld = 'couk';
			}elseif($row[tld] == 'org.uk'){
			$tld = 'orguk';
			}elseif($row[tld] == 'us.com'){
			$tld = 'uscom';
			}elseif($row[tld] == 'eu.com'){
			$tld = 'eucom';
			} else {
			$tld = $row[tld];
			}
			$tld2 = $row[tld];

		if ($row[transfer_price] == 0.00){
		//Domain is not using our name servers
		$TranPrice = "N/A";
		} else {
		$TranPrice =  '<input name="tran'.$tld.'" type="text" id="tran'.$tld.'" size="6" maxlength="6" value="'.$row[transfer_price].'">';
		}

		if ($row[renew_price] == 0.00){
		//Domain is not using our name servers
		$RenPrice = "N/A";
		} else {
		$RenPrice =  '<input name="ren'.$tld.'" type="text" id="ren'.$tld.'" size="6" maxlength="6" value="'.$row[renew_price].'">';
		}

		$RegPrice =  '<input name="reg'.$tld.'" type="text" id="reg'.$tld.'" size="6" maxlength="6" value="'.$row[register_price].'">';


       echo'                   <tr bgcolor="'.$bg.'">
                            <td><div align="center">'.$tld2.'</div></td>
                            <td><div align="center">
                              '.$RegPrice.'
                            </div></td>
                            <td><div align="center">
                              '.$RenPrice.'
                            </div></td>
                            <td><div align="center">
                              '.$TranPrice.'
                            </div></td>
                          </tr>';
}
echo '</table>';
?>
                          <br>
                          <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                            <tr>
                              <th width="42%" scope="col"><div align="center">Product</div></th>
                              <th width="32%" scope="col"><div align="center">Price</div></th>
                            </tr>
                            <tr>
                              <td><div align="center">ID Protect </div></td>
                              <td><div align="center">
                                <input name="Idprotect" type="text" size="6" maxlength="6" value="<?php if(isset($idprice)){ echo $idprice;}?>">
                              </div></td>
                            </tr>
                            <tr>
                              <td> <div align="center">Pop Email Boxes </div></td>
                              <td><div align="center">
                                <input name="PopMail" type="text" size="6" maxlength="6" value="<?php if(isset($popprice)){ echo $popprice;}?>">
                              </div></td>
                            </tr>
                            <tr>
                              <td> <div align="center">DNS only Hosting </div></td>
                              <td><div align="center">
                                <input name="DNSHosting" type="text" size="6" maxlength="6" value="<?php if(isset($dnshostingprice)){ echo $dnshostingprice;}?>">
                              </div></td>
                            </tr>
                            <tr>
                              <td> <div align="center">Redemption Recovery</div></td>
                              <td><div align="center">
                                <input name="RGP" type="text" size="6" maxlength="6" value="<?php if(isset($rgpprice)){ echo $rgpprice;}?>">
                              </div></td>
                            </tr>
                            <tr>
                              <td> <div align="center">.Name Forwarding </div></td>
                              <td><div align="center">
                                <input name="NameForwarding" type="text" size="6" maxlength="6" value="<?php if(isset($nameprice)){ echo $nameprice;}?>">
                              </div></td>
                            </tr>
                          </table>
                          <p>
                           <center>
						   <?php
						   if($continue == 1){
						   $_SESSION['StepNumber'] = 6;
						   echo '<input name="Change" type="submit" class="button" value="Change">&nbsp;&nbsp;&nbsp;&nbsp;<a href="install6.php">Next Step</a>';
						   } else {
						   echo '<input name="Submit" type="submit" class="button" value="Submit">';
						   }
						   ?>
                             <br>
                             <br>
                           </center>
                        </p></td>
                      </tr>
                    </table>
			        <p></form></p>
		        <tr>
            </table></td>
		</table>