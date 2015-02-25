<?php
	require('include/sessions.php');
	$PageName = "index";
	$PageTitle = $SiteTitle . " - eNom's PHP Reseller Sample Site";
	include('include/header.php'); 
?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<tr> 
  <td class="OutlineOne">
<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
        <tr> 
              <td colspan="3" align="center" valign="middle" class="titlepic"><span class="whiteheader">Welcome</span></td>
        </tr>
            <tr>
              <td height="5" colspan="3">
				<?php include("include/price_small.php");?>			  
			  </td>
            </tr>            <tr> 
              <td height="5" colspan="3" class="tdcolorone"><span class=cattitle>Register a domain name:</span></td>
            </tr>
            <tr> 
              <td width="45%" align="center" valign="middle" class="row1"><span class="main">Verify 
          that the name you want is available.</span></td>
              
        <td width="55%" align="center" valign="middle" class="row2">
<table border="0" cellpadding="2" cellspacing="2" align="center">
            <form method="post" action="Check.php" id="form1" name="form1">
              <input type="hidden" name="action" value="check">
              <tr> 
                <td valign="middle" align="center" width="90" class="main">Domain:</td>
                <td valign="middle" align="center"><input type="text" maxlength="272" name="sld" id="idsld"> 
                  &nbsp;.&nbsp;<?php include ('Setup/tldListOne.php'); ?></td>
              </tr>
              <tr> 
                <td colspan="2" align="center" valign="middle"><input name="image2" type="image" src="images/btn_checkavail_g.gif" WIDTH="144" HEIGHT="22" border="0"></td>
              </tr>
            </form>
          </table>        </td>
          </tr><tr> 
            <td height="5" colspan="3" class="tdcolorone"><span class=cattitle>Purchase DNS Hosting: </span></td>
              </tr>
            <tr> 
              <td align="center" valign="middle" class="row1">Subscribe to our domain name hosting services, while leaving the registration of the domain name at another 
          registrar.</td>
              
        <td align="center" valign="middle" class="row2">
<table border="0" cellpadding="2" cellspacing="2" align="center">
            <form method="post" action="DnsHosting.php" id="form1" name="form1">
              <input type="hidden" name="action" value="check">
              <tr> 
                <td valign="middle" align="center" width="90" class="main">Domain:</td>
                <td valign="middle" align="center"><input type="text" maxlength="272" name="sld" id="idsld"> 
                  &nbsp;.&nbsp;<?php include ('Setup/tldListOne.php'); ?></td>
              </tr>
              <tr> 
                <td colspan="2" align="center" valign="middle"><input name="image2" type="image" src="images/btn_continue.gif" WIDTH="114" HEIGHT="22" border="0"></td>
              </tr>
            </form>
          </table>        </td>
          </tr>
            <tr>
              <td height="5" colspan="3" class="tdcolorone"><span class=cattitle>Transfer your domain </span></td>
            </tr>
            <tr>
              <td align="center" valign="middle" class="row1"><p class="main">Please select your order type</p>                <p class="main"><span class="style1">*NOTE: </span><strong>.info, .biz, .us, .org </strong> domains require an EPP code (authorization key)  to transfer. </p></td>
              <td align="center" valign="middle" class="row2">              <table width="399" height="65" border="0" align="center" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="284" align="center" valign="middle">
                    <div align="left"><strong><a href="avtransfer.php">Auto Verification </a>(Use for .com, .net, .cc, .co.uk, and .org.uk domains only) </strong></div></td>
                </tr>
            </table>                <table width="403" border="0" align="center" cellpadding="2" cellspacing="2">
                    <tr>
                      <td width="395" align="center" valign="middle"><div align="left"><strong><a href="epptransfer.php">EPP Transfers</a> (Use for .info, .biz, .us, .org  domains) </strong> <br>
                      </div></td>
                    </tr>
              </table>            </td>
            </tr>
            <tr> 
              <td height="5" colspan="3" class="tdcolorone"><span class=cattitle>Login</span></td>
            </tr>
            <tr> 
              <td align="center" valign="middle" class="row1"><span class="main">Already 
				  registered with us?<br />
			  Log-in here to administer your domain!</span></td>
              <td align="center" valign="middle" class="row2"><table border="0" cellpadding="2" cellspacing="2" align="center">
				<form method="post" action="LogIn.php" id="form2" name="form2">
					<input type="hidden" name="action" value="login">
					<tr> 
						<td align="right" valign="top" width="90" class="main">Domain:&nbsp;&nbsp;</td>
						<td align="center" valign="middle"><input type="text" maxlength="272" name="sldtld" id="idsldtld"></td>
					</tr>
					<tr> 
						<td align="right" valign="top" class="main">Password:&nbsp;&nbsp;</td>
						<td align="center" valign="middle"><input type="password" maxlength="60" name="password" id="idpassword"></td>
					</tr>
					<tr> 
						<td>&nbsp;</td>
						<td align="center" valign="middle"><input name="image" type="image" src="images/btn_login_g.gif" WIDTH="74" HEIGHT="22" border="0"></td>
					</tr>
				</form>
			  </table>                </td>
            </tr>
            <tr>
              <td height="5" colspan="3" class="tdcolorone"><span class=cattitle>Whois Lookup </span></td>
            </tr>
            <tr>
              <td align="center" valign="middle" class="row1"> Find out who is the owner (the "registrant") of a particular domain name.</td>
              <td align="center" valign="middle" class="row2">
                <table border="0" cellpadding="2" cellspacing="2" align="center">
                  <form method="post" action="whois.php" id="form1" name="form1">
                    <input type="hidden" name="action" value="check">
                    <tr>
                      <td valign="middle" align="center" width="90" class="main">Domain:</td>
                      <td valign="middle" align="center"><input type="text" maxlength="272" name="sld" id="idsld">
&nbsp;.&nbsp;
            <?php include ('Setup/tldListOne.php'); ?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" valign="middle"><input name="image2" type="image" src="images/btn_next.gif" WIDTH="114" HEIGHT="22" border="0"></td>
                    </tr>
                  </form>
              </table>                </td>
            </tr>
          </table>
  </td>
</tr>
	  
	  <!-- end of page content -->
	  
		<? include('include/footer.php'); ?>
