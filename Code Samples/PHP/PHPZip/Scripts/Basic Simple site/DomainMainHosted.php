<?php
$RegStatus = $_SESSION['RegStatus'];
	if($RegStatus != 0){
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
		$postvars = "sld=$sld&tld=$tld";
		header ("Location: DomainMain.php?$postvars");
		exit;
	}

	include( "include/sessions.php" );
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
	
	include( "include/DomainFns_inc.php" );
	include( "include/LoggedIn.php" );
	include( "include/EnomInterface_inc.php" );

	$PageName = "DomainMain";
	$PageTitle = $SiteTitle . " - Administer your domain name";
	include('include/header.php'); 
?>

<tr> 
	<td class="OutlineOne">
			<div align="center">
			<?php
				// Check if we're supposed to modify something
				if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
					// Check if any hosts were modified
					if ( WereHostsModified() == 1 ) {
						ModifyHosts();
					}
					
					// Check if any email forwarding entries were modified
					if ( WereEmailsModified() == 1 ) {
						ModifyEmails();
					}
					
					// Check if the password was modified
					if ( WasPasswordModified() == 1 ) {
						ModifyPassword();
					}
				}
			?>
			</div>
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
		<form method="post" action="DomainMainHosted.php" name="theForm" id="theForm">
		<input type="hidden" name="action" value="modify">	
			<tr> 
				<td colspan="2" align="center" valign="middle" class="titlepic"><span class="whiteheader">DNS Hosted Name Maintainance For&nbsp;<b><?php echo "$sld.$tld"; ?></b></span></td>
			</tr>
			
			<tr> 
				<td height="5" colspan="2" class="tdcolorone"><span class=cattitle>Domain's Nameservers</span></td>
			</tr>
			
			<tr> 
				<td colspan="2" align="center" valign="middle" class="row1"><p class="main">				  Current NameServers:
					<br>
					<br>
					Dns1.Name-Services.com<br>
					Dns2.Name-Services.com<br>
					Dns3.Name-Services.com<br>
					Dns4.Name-Services.com<br>
					Dns5.Name-Services.com<br>
			    </p>				  </td>
			</tr>
			
			<tr> 
				<td height="5" colspan="2" class="tdcolorone"><span class=cattitle>Expiration Date</span></td>
			</tr>
			
			<tr> 
				<td colspan="2" align="center" valign="middle" class="row1">
				<?php
					// Create URL Interface class
					$Enom = new CEnomInterface;
				
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $username );
					$Enom->AddParam( "pw", $password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "command", "getwhoiscontact" );
					$Enom->DoTransaction();
					//error handling
					if ( $Enom->Values[ "ErrCount" ] != "0" ) {
						// Yes, get the first one
						$expMsg = $Enom->Values[ "Err1" ];
						echo $expMsg;
					} else {
						if ($Enom->Values[ "Whoisregistration-expiration-date" ] != ""){
							$fooba = $Enom->Values[ "Whoisregistration-expiration-date" ]; 
							$expdate = substr($fooba,0,10);
							list ($year, $day, $month) = explode("-", $expdate);
						} else {
							$fooba = $Enom->Values[ "Whoisexdate" ];
							$expdate = substr($fooba,0,10);
							list ($year, $day, $month) = explode("-", $expdate);
						}
						//print out the expiration date
						echo "<br /><br />";
						echo "<span class=\"main\">Expiration Date:</span>";
						echo "&nbsp;<strong class=red>";
						echo $day . "/" . $month . "/" . $year;
						echo "</strong>";
					}
				?>				<br />				<br />
				<table>
				<tr align="center" valign="middle"><td>Add years : </td><td><a href="DomainExp.php"><img src="images/btn_continue.gif" width="114" height="22" border="0"></a></td></tr>
				</table>				</td>
			</tr>
			
			<tr> 
				<td height="5" colspan="2" class="tdcolorone"><span class=cattitle>Modify Contact Information</span></td>
			</tr>
			
			<tr> 
				<td colspan="2" align="center" valign="middle" class="row1"><span class="main">
				Modify&nbsp;<a href="DomainContacts.php">Contact Information</a>					<img src="images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
			<tr> 
				<td colspan="2" align="center" valign="middle" class="row1"><span class="main">For Help look at our <a href="javascript:openWin('popUps/faq.htm', 'FAQ');">FAQ Page</a> or our <a href="javascript:openWin('popUps/help.htm', 'FAQ');">Definitions Page</a>.</span>				  <br />				  <img src="images/blank.gif" width="8" height="1" border="0"></td>
			</tr>
			<? 
			include ('include/hosts.php');
			include ('include/forwarding.php'); 
			if ($tld == "name") {
				include ('include/dotnameforwarding.php');
				} 
			?>
			<tr> 
				<td height="5" colspan="2" class="tdcolorone"><span class=cattitle>&nbsp;Change&nbsp;&nbsp;Password</span></td>
			</tr>
			<tr> 
				<td width="293" align="center" valign="middle" class="row1"><div align="right"><span class="main">Password:&nbsp;&nbsp;</span></div></td>
				<td width="404" valign="middle" class="row2">&nbsp;&nbsp;<input type="password" name="password1" id="idpassword1" maxlength="60" value="<?php if ( $HTTP_POST_VARS[ "password1" ] != "" ) { echo $HTTP_POST_VARS[ "password1" ]; } else { echo "**********"; } ?>">				  <img src="images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<tr> 
				<td align="center" valign="middle" class="row1"><div align="right"><span class="main">Retype&nbsp;Password:&nbsp;&nbsp;</span></div></td>
				<td valign="middle" class="row2">&nbsp;&nbsp;<input type="password" name="password2"  id="idpassword2" maxlength="60" value="<?php if ( $HTTP_POST_VARS[ "password2" ] != "" ) { echo $HTTP_POST_VARS[ "password2" ]; } else { echo "**********"; } ?>">				  <img src="images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<tr> 
				<td colspan="2" align="center" valign="middle" class="row1">

			<?php
				// Check if we're supposed to modify something
				if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
					// Check if the password was modified
					if ( WasPasswordModified() == 1 ) {
						ModifyPassword();
					}
				}
			?>&nbsp;</td>
			</tr>
			<input type="hidden" value="FullForm" name="FormType">
			<tr> 
				<td height="5" colspan="2" class="tdcolorone"><span class=cattitle>&nbsp;Apply&nbsp;&nbsp;Changes</span></td>
			</tr>
			<tr> 
				<td align="center" valign="middle" class="row1"><div align="right"><span class="main">Click here to apply your changes.</span></div></td>
				<td valign="middle" class="row2">&nbsp;&nbsp;<input name="" type="image" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">				  <img src="images/blank.gif" width="8" height="1" border="0"></td>
			</tr>
			<tr> 
				<td align="center" valign="middle" class="row1"><div align="right"><span class="main">Logout</span></div></td>
				<td valign="middle" class="row2">&nbsp;&nbsp;<a href="include/LogOut.php"><img src="images/btn_logout.gif" border="0" WIDTH="74" HEIGHT="22"></a><img src="images/blank.gif" width="8" height="1" border="0"></td>
			</tr>
			<tr> 
				<td align="center" valign="middle" class="row1"><div align="right"><span class="main">Click here to reset this form</span></div></td>
				<td valign="middle" class="row2">&nbsp;&nbsp;<a href="javascript:document.forms.theForm.reset()"><img src="images/btn_reset.gif" width="74" height="22" border="0"></a><img src="images/blank.gif" width="8" height="1" border="0"></td>
			</tr>
			<tr> 
				<td colspan="2" align="center" valign="middle" class="row1">&nbsp;</td>
			</tr>
		</form>
		</table>
	</td>
</tr>
<? include('include/footer.php'); ?>