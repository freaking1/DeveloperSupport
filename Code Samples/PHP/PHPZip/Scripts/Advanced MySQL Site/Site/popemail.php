<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

	$query_pop = "SELECT * FROM product_pricing WHERE prodid='5'";
	$result_pop = @mysql_query ($query_pop);
	$row_pop = mysql_fetch_array ($result_pop, MYSQL_ASSOC);
		$page = "services";

?>
	
<link rel="stylesheet" href= "css/styles.css" type="text/css">
<style type="text/css">
<!--
.style1 {color: #006600}
-->
</style>
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Pop Email services </span></td>
			    </tr>
				<tr>
		      <tr>
			        <td class="tableO1"><table cellpadding="12" cellspacing="0">
                        <tr>
                          <td width="65%" height="388" valign="top"> <?=$sitename;?> offers POP email accounts with or with out hosting. All you need is a domain name. <br>
                            <br>
We offer POP3 email accounts by packages of 10. This is completely independent of hosting package Pop accounts, and is more often purchased by those who do not have or do not need web hosting at this time, but simply need a domain name and email. <br>
<br>
These packages are called Email Paks. Each Email Pak is $
<?=$row_pop[price]?> 
per year per domain. <br>
<br>
Also, all POP3 accounts come witha web mai interfacel. All Pop packs can be used in either outlook, eudora, netscapte, or any other SMTP ready email client; and can be accessed via the web from any web browser, anywhere on the planet. The webmail interface is very similar to what you may see at hotmail, or yahoo for when you are away from home or the office. <br>
<br>
Please note in order to be able to order Email Packs you must have your domain registered with or transferred to 
<?=$sitename;?>
and be logged in to your  account.  Just select the <span class="BasicText"><strong>POP3</strong></span> option from the <span class="BasicText"><strong>Mail Settings</strong></span> menu to purchase and configure your pop pack. <br>
<br>
If you do not have an account you can click here to sign up for a <a href="<?=$site_url;?>/createacct.php"><strong>FREE 
<?=$sitename;?> 
account</strong></a>.   <br>                       </td>
                          <td class="windowinside" valign="top" width="35%"><strong>Need Help configuring your email client to use our Pop/Smtp mail? Use one of these guides:</strong><br>
                              <br>
                              <table cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="262" class="OutlineOne"><ul class="available style1">
                                      <li class="available"><a href="/help/pop_mail/email_help_outlook_express_win.htm" target="_blank" class="style1">Outlook Express (Windows)</a></li>
                                      <li class="available"><a href="/help/pop_mail/email_help_outlook_express_mac.htm" target="_blank">Outlook Express (Mac)</a> </li>
                                      <li class="available"><a href="/help/pop_mail/email_help_outlook2000.htm" target="_blank">Outlook 2000</a> </li>
                                      <li class="available"><a href="/help/pop_mail/email_help_outlook2002.htm" target="_blank">Outlook 2002</a> </li>
                                      <li class="available"><a href="/help/pop_mail/email_help_netscape_win.htm" target="_blank">Netscape (Windows)</a> </li>
                                      <li class="available"><a href="/help/pop_mail/email_help_netscape_mac.htm" target="_blank">Netscape (Mac)</a></li>
                                      <li class="available"><a href="/help/pop_mail/email_help_other.htm" target="_blank">Other Email Client (general setup help)</a> </li>
                                  </ul></td>
                                </tr>
                              </table>
                              <br>
                                  <br>
                                  <span class="red"><strong>Only $
                                  <?=$row_pop[price]?>
                                  /yr (per&nbsp;domain)</strong></span><strong> <br>
                                  <span class="available">(price listed is per email pack)
</span></strong></p>
                          <p>&nbsp;</p>
                          <p><a href="<?=$site_url;?>/check.php">Click Here to register a new domain </a><br>
or <br>
<a href="<?=$site_url;?>/transfers.php">Click Here to transfer your existing domains </a></p></td>
                        </tr>
                    </table></td>
              </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>