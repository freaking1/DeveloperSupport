<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

	$query_idpro = "SELECT * FROM product_pricing WHERE prodid='4'";
	$result_idpro = @mysql_query ($query_idpro);
	$row_idpro = mysql_fetch_array ($result_idpro, MYSQL_ASSOC);
		$page = "services";

?>
	
<link rel="stylesheet" href= "css/styles.css" type="text/css">
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style4 {
	font-size: large;
	color: #006600;
}
-->
</style>
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">ID Protection services </span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2">
			        <table cellpadding="6" cellspacing="0" class="tableO1">
                      <tr>
                        <td height="443" align="center"><table cellpadding="2" cellspacing="0" class="tableO1">
                            <tr>
                              <td align="center"><strong>PROTECT YOUR INFORMATION </strong></td>
                            </tr>
                            <tr>
                              <td height="395"><table cellpadding="12" cellspacing="0">
                                  <tr>
                                    <td width="65%" rowspan="2" valign="top"><strong>Did you know that current ICANN regulations require that your Private contact information (WhoIs Info) be included in a publicly accessible Database? </strong><br>
                                        <br>
                  This means that your private information is displayed and made available to anyone who wants to see it, 24 hours a day, 365 days a year. <br>
                  <br>
                  Now you can protect your private WhoIs information by switching your "public" domain registration to a "private" unlisted registration through <strong><?=$sitename;?>'s ID Protect </strong>. <br>
                  <br>
                  <a href="<?=$site_url;?>/mydomains.php"><img src="images/id_protect_med.gif" width="92" height="67" border="0"></a><strong><br>
                  ID PROTECT works by: <br>
                  - Shielding your <span class="tableOO">private</span> information <br>
                  - Forwarding important communication <br>
                  - Offering you complete control </strong><br>
                  <br>
                  <strong class="red">"<?=$sitename;?>'s ID Protect is the best investment you can make on your domain name, if you value your privacy" </strong><br>
                  <br>
                  <a href="<?=$site_url;?>/mydomains.php" class="available">GET STARTED NOW - PROTECT YOUR NAMES </a><strong>(Look&nbsp;for&nbsp;this&nbsp;icon&nbsp; <a href="<?=$site_url;?>/mydomains.php"><img src="images/ID_notprotected.gif" width="23" height="16" border="0"></a>&nbsp;) </strong><br>
                  <br></td>
                                    <td width="35%" height="246" valign="top" class="windowinside"><strong>Adding ID Protect to your domain can shield you from... </strong><br>
                                        <br>
                                        <table cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="187" class="OutlineOne"><ul class="available style1">
                                                <li class="available style4">Spam </li>
                                                <li class="available style4">Identity Theft </li>
                                                <li class="available style4">Data mining </li>
                                                <li class="available style4">Name Hijackers </li>
                                                <li class="available style4">and more... </li>
                                            </ul></td>
                                          </tr>
                                        </table>
                                        <strong>Protect your Privacy with ID Protect. </strong><br>
                                        <br>
                                        <span class="red"><strong>Only $
                                        <?=$row_idpro[price]?>
                                    /yr (per&nbsp;domain)</strong></span><strong> </strong></td>
                                  </tr>
                                  <tr>
                                    <td valign="top">&nbsp;</td>
                                  </tr>
                              </table></td>
                            </tr>
                          </table>
                            <strong class="available">Note: Currently only .com, .net, .org, .info, .biz and .us domains can use ID Protect. </strong></td>
                      </tr>
                      <tr>
                        <td align="center"><br>
                            <table cellpadding="4" cellspacing="1" class="tableO1">
                              <tr>
                                <td colspan="2" align="center"><strong>Example of a WhoIs output (Registrant Information) </strong></td>
                              </tr>
                              <tr>
                                <td align="right" width="50%"><strong>First Name: </strong></td>
                                <td>John </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>Last Name: </strong></td>
                                <td>Smith </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>Address 1: </strong></td>
                                <td>123 main St. </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>City: </strong></td>
                                <td>Honolulu </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>State / Province: </strong></td>
                                <td>Hawaii </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>Postal / Zip Code: </strong></td>
                                <td>90000 </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>Country: </strong></td>
                                <td>United States </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>Phone: </strong></td>
                                <td>(555)555-1234 </td>
                              </tr>
                              <tr>
                                <td align="right"><strong>Email Address: </strong></td>
                                <td>mrsmith@example.com </td>
                              </tr>
                              <tr>
                                <td colspan="2" align="center"><img src="blank_blank.gif" height="1" width="1"></td>
                              </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="center" width="98%"><span class="BasicText"><strong>Note: ICANN requires you to have correct Registrant Information on file</strong></span></td>
                      </tr>
                      <tr>
                        <td align="center" width="98%" class="windowinside"><strong>How does ID Protect work? </strong></td>
                      </tr>
                      <tr>
                        <td width="98%" class="tableO1"><strong>Shielding your private information </strong><br>
      Your private contact information is not exposed. It is held in confidentiality and protected by the Domain Privacy Protection Service. Their contact information is displayed to provide you with the highest level of protection against spammers and identity theft. <br>
      <br>
      <strong>Dynamic eMail System which stops spammers dead in their tracks </strong><br>
      Without Privacy ID, spammers can obtain your email address from harvesting and then use it for spamming purposes and redistribution to marketing firms. Your email address can stay on file with various spammers and marketing firms for years. Due to <?=$sitename;?>'s dynamic email system, the visible email address is constantly changing, so while it is being harvested and redistributed, it will change and the previous address will no longer work for the spammer. The Domain Privacy Protection Service (an affiliate of eNom.com) secures and maintains your real email address on file so you receive important information regarding your domain. <br>
      <br>
      <strong>Offering you complete control </strong><br>
      You retain full legal ownership and control over your domain name. You can sell, renew, transfer and change settings to your domain name just the same as before. Your domain control panel provides you real-time access to easily manage your domain name. <br>
      <br></td>
                      </tr>
                      <tr>
                        <td width="98%" align="center" class="windowinside"><a href="<?=$site_url;?>/mydomains.php" class="available"><strong>- - GET STARTED NOW AND PROTECT YOUR NAMES - - </strong></a></td>
                      </tr>
                    </table>
              <tr>
	                <td colspan="3" valign="top" class="content2">                    
		      </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>