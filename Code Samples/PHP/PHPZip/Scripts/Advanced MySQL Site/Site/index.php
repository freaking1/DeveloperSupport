<?php

$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

		$query = "SELECT register_price from tld_config where tld='com'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		
		$installed = "select installed from extra";
		$installedresult = @mysql_query ($installed);
		$installedvar = mysql_result($installedresult,0);
		if($installedvar != 1){
			header ("Location:  $site_url/install/");
			exit(); // Quit the script.
		} 

		if($_COOKIE['loggedin_user'] != ''){
			header ("Location:  $site_url/myaccount.php");
			exit(); // Quit the script.
		} 
	$page = "index";
	$PageTitle = $SiteTitle . " - eNom's PHP Reseller Sample Site";

	?>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
      </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="429" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="149" height="429" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>	      </td>
			<td class="content" align="center" valign="top" width="811">
			<table width="101%" height="388" border="0" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">Welcome to 
		          <?=$CompanyName;?>
			      </span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2"><table width="100%" height="81%" border="0">
  <tr>
    <td height="159" valign="top"><table cellspacing="0" cellpadding="0">
      <tr>
        <td><table cellpadding="0" cellspacing="0">
            <tr>
              <td class="content" align="center" valign="top" width="100%"><table cellpadding="0" cellspacing="0">
                  <tr>
                    <td><table cellpadding="0" cellspacing="0">
                        <tr>
                          <td><table cellpadding="0" cellspacing="1">
                              <tr>
                                <td align="center" valign="top">
								  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <th scope="col"><table width="100%"  border="0" class="tableO1">
                                  <tr>
                                    <td class="titlepic"><div align="center" class="whiteheader">My Account</div></td>
                                  </tr>
                                  <tr>
                                    <td><strong>&raquo;Returning users:<br>
                                          <a href="<?=$secure_site_url;?>/login.php"><strong>Click here</strong></a> </strong>to login to your account. </td>
                                  </tr>
                                  <tr>
                                    <td><strong>&raquo;New users: </strong><a href="<?=$secure_site_url;?>/createacct.php"><br>
                                          <strong>Click here</strong> </a> to sign up for your free account. </td>
                                  </tr>
                                </table>

  <br>
  <table width = "100%" class="tableO1" border="0" >
    <tr>
      <td class="titlepic"><div align="center" class="whiteheader">Great Value </div></td>
    </tr>
    <tr>
      <td><p> Here at eNomiTron we offer Domain Registration and Web Hosting solutions to establish your web presence at prices you can afford! <br>
              <br>
        Our web hosting plans are designed with premium features at great prices. <br>
        <br>
        Our <a href="<?=$site_url;?>/services.php"><strong>domain name services </strong></a> are unbeatable, with <a href="<?=$site_url;?>/prices.php"><strong>registration prices </strong></a> as low as $<?=$row[0];?> and an easy to use domain management system. <br>
        <br>
        We offer great versatility to each domain name through easy to use and powerful tools for beginner users and advanced users alike. <br>
        <br>
        Our domain names have all tools included! You do not have to pay extra like the other discount registrars for such services as email forwarding and URL redirection. <br>
      </p></td>
    </tr>
  </table>
</blockquote>
</th>
                                    </tr>
                                  </table>
                                <td class="grayBack" align="center" valign="top" width="50%"><table border="0" cellpadding="4" class="separator">
						
						<tr>

							<th class="windowinsidewhite">FEATURED SERVICES</th>
						</tr>
						<tr>
							<td class="separator">
								
 - <strong>Web site hosting</strong> - <br>
Place a website for your domain name, comes with full ftp capability, email addresses, database acecss, and more <a href="<?=$site_url;?>/webhosting.php"><strong>more...</strong></a><br /><br />

 - <strong>Pop Email</strong> - <br>
Create up to 100 personalized email addresses and access them from any email client (like outlook), as well as from any internet ready computer via the webmail interface.  <a href="<?=$site_url;?>/popemail.php"><strong>more...</strong></a><br />
<br /> 
 - <strong>ID Protect</strong> - <br>
Protect your personal contact information from spammers and scammers. Keeps all your personal information private and hides everything from prying eyes. Able to turn on/off at will. <a href="<?=$site_url;?>/idprotect.php"><strong>more...</strong></a><br>
<br>
- <strong>DNS ONLY hosting</strong> - <br>
Host your domains DNS records with us on our redundant servers. <a href="<?=$site_url;?>/dnshosting.php"><strong>more...</strong></a> </td>
						</tr>
						
						<tr>

							<th class="windowinsidewhite">FREE SERVICES with domain registration</th>
						</tr>
						<tr>
							<td>	
								<b>- 100 personalized email addresses -</b><br />Create up to 100 personalized email addresses and forward them to other email addresses.<br /><br /><b>- Web/URL forwarding -</b><br />Forward/redirect/frame your domain name to any other URL/website on the web.<br /><br /><b>- DNS Services -</b><br /> <b>- Domain Portfolio Management -</b><br /> 				 				<b>- Parking Page -</b><br /> 				 				<b>- and more...</b><br /><br /> 				<b>See our <a href="<?=$site_url;?>/services.php">Complete services</a> page for more.</b><br />

								<img src="/images/blank.gif" width="300" height="1" border="0" /><!-- For Netscape 4 to do 50% width -->
							</td>
						</tr>
						
					</table></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td class="footer"><table cellpadding="0" cellspacing="0">
            <tr>
              <td valign="top" width="126"><img src="index_blank.gif" height="1" width="126"></td>
              <td align="center" valign="top" width="100%"><table cellpadding="4" cellspacing="0">
                  <tr>
                    <td class="footer" align="center"></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
</table>
<tr>
	          </table>
</table>
<p>&nbsp;</p>
<?php include('include/footer.php');?>