<table width="145" height="100%" border="0" cellpadding="2" cellspacing="1" class="titlepic" id="table10">
<?php 						
if($AdminUser == 1){  ?>
						<tr>
						  <td height="23" class="formfield"><span class="whiteheader style5"> <a href="/admin/index.php"> Admin Section</a></span></td>
  </tr> <? } ?>
						<tr>
                          <td height="23" class="tableOO"><span class="whiteheader style5"> <a href="/index.php"> Home</a></span></td>
  </tr>
						<tr>
                          <td height="23" class="tableOO"><span class="whiteheader style5"> <a href="pricing.php">Pricing</a></span></td>
  </tr>
						<tr>
                          <td height="23" class="tableOO"><span class="whiteheader style5"> <a href="services.php">Services</a></span></td>
  </tr>
	<?php if($page == "services"){ ?>					<tr>
						  <td height="23" class="formfield"><span class="whiteheader style5"><img src="images/white_dot.gif" name="arrow2" border="0" height="12" width="12"><a href="popemail.php">Pop Email </a></span>                        
  <tr>
                          <td height="23" class="formfield"><span class="whiteheader style5"><img src="images/white_dot.gif" name="arrow2" border="0" height="12" width="12"><a href="idprotect.php">ID Protect </a></span>      <? } ?>                  
  <tr>
    <td height="23" class="tableOO"><span class="whiteheader style5"> 
	  <?php
	 
						  if (isset($_COOKIE['loggedin_user'])){
						  	echo "<a href=\"myaccount.php\">My Account</a>";
                           
						  echo "
						  	</span>					
</td>
  </tr>";
						 if($page == "myaccount"){
						echo " <tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"changepass.php\">Change Password</a></span></td>
  </tr>
						<tr>
                          <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"myinfo.php\">My Info</a></span></td>
  </tr>
						<tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"myinvoices.php\">My Invoices</a></span></td>
  </tr>
						<tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"mydomains.php\">My Domains</a></span></td>
  </tr>
						<tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"expired.php\">Expired Domains</a></span></td>
  </tr>
												<tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"mydnshosted.php\">Hosted Domains</a></span></td>
  </tr>
<tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"domain_push.php\">Push Domain</a></span></td>
  </tr>
						<tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"mytransfers.php\">My Transfers</a></span></td>
  </tr>
						<tr>
                           <td height\23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"myhosting.php\">My Hosting</a></span></td>
  </tr>";
						} 
  	 
							} else { ?>
							 <a href="<?=$secure_site_url;?>/createacct.php">Create Account</a>
  	  <?php
						}	
						?>		
  <tr>
                          <td height="23" class="tableOO"><span class="whiteheader style5"><a href="check.php">Register Name </a></span> </td>
  </tr>
						    <tr>
						 <td height="23" class="tableOO"><span class="whiteheader style5"><a href="dnshosting.php">DNS Hosting</a></span></td>

  </tr>
 <?php
 if($page == "dnshost"){
echo "<tr>
<td height=\"23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"mydnshosted.php\">Hosted Domains</a></span></td>
</tr>";
}?>
<tr>
  <td height="23" class="tableOO"><span class="whiteheader style5"><a href="transfers.php">Transfer Name </a></span></td>
						  
  </tr>
  <?php
  if($page == "transfer"){
						echo "<tr>
                           <td height=\"23\" class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"mytransfers.php\">My Transfers</a></span></td>
  </tr>";
}  ?>
<tr>
  <td height="23" class="tableOO"><span class="whiteheader style5"><a href="webhosting.php">Web Hosting </a></span></td>
  </tr>
  <?php
  if($page == "webhosting"){ 
						echo "<tr>
                           <td height=\"23\"  class=\"formfield\"><span class=\"whiteheader style5\"><img src=\"images/white_dot.gif\" name=\"arrow2\" border=\"0\" height=\"12\" width=\"12\"><a href=\"myhosting.php\">My Hosting</a></span></td>
  </tr>";
}  ?>
<tr>
  <td height="23" class="tableOO"><span class="whiteheader style5"> <a href="whois.php">Whois Lookup </a></span></td>
  </tr>
  <tr>
<td height="23" class="tableOO"><span class="whiteheader style5"> <a href="contactus.php">Contact Us</a></span></td>
  
	<tr>
	  <td height="23" class="tableOO"><span class="whiteheader style5"><img src="images/white_dot.gif" name="arrow2" border="0" height="12" width="12">
	  <?php
	  if (isset($_COOKIE['loggedin_user'])){
		?><a href="<?=$secure_site_url;?>/logout.php">Logout</a><?
		} else { ?>
		<a href="<?=$secure_site_url;?>/login.php">Login</a><?php
		}
		?>
	   &nbsp;</span></td> 
</tr></table>
						
<?php
if (isset($_COOKIE['loggedin_user']) AND (substr($_SERVER['PHP_SELF'], -10) != 'logout.php')){
echo '<table>';
echo '<tr>';
echo '<td width="137" height="23" class="titlepic"><span class="whiteheader"><center><b><u><b>';
echo ($_COOKIE['loggedin_user']);
echo '</b></span></center></b></u>';
echo '</td></tr></table>';
}
?>