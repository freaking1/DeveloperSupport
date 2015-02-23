<?php
include( "include/sessions.php" );

$RegStatus = $_SESSION['RegStatus'];

	if($RegStatus != 1){
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
		$postvars = "sld=$sld&tld=$tld";
		header ("Location: DomainMainHosted.php?$postvars");
		exit;
	}
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
	include( "include/DomainFns_inc.php" );
	include( "include/LoggedIn.php" );
	include( "include/EnomInterface_inc.php" );

  	$Enom = new CEnomInterface;
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "command", "getreglock" );
	$Enom->DoTransaction();
	//error handling
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		// Yes, get the first one
		$expMsg = $Enom->Values[ "Err1" ];
		echo $expMsg;
		$lockMSG = "There was an error checking for the lock status; please try again later.";
	} else {
		if ($Enom->Values[ "RegLock" ] == 1){
			$lock1 = "checked";
		} else if ($Enom->Values[ "RegLock" ] == 0){
			$lock2 = "checked";
		} else {
			$lockMSG = "There was an error checking for the lock status; try again later.";
		}
	}

	
		$Enom = new CEnomInterface;
		$Enom->NewRequest();
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "command", "GetIDProtectInfo" );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->DoTransaction();
		
		$WPPSEnabled = $Enom->Values[ "WPPSEnabled" ];
		$WPPSExpDate = $Enom->Values[ "WPPSExpDate" ];
		$WPPSExists = $Enom->Values[ "WPPSExists" ];
		//error handling
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			// Yes, get the first one
			$message .= $Enom->Values[ "Err1" ];
			$message .= "There was an error checking for the lock status; please try again later.";
		} else {
			if ($Enom->Values[ "WPPSEnabled" ] == 1){
				$WPPSEnabled1 = "checked";
			} else if ($Enom->Values[ "WPPSEnabled" ] == 0){
				$WPPSEnabled2 = "checked";
			} else {
				$message = "There was an error checking for the lock status; try again later.";
			}
		}

$wppsaction = $HTTP_POST_VARS["wppsaction"];
$wppsvar = $HTTP_POST_VARS[ "wppsvar" ];
if($wppsaction == 'change'){
	
	if($wppsvar == 0){
		$wpps = 1120;
		} 
	elseif($wppsvar == 1){
		$wpps = 1123;
		}
		
	$Enom = new CEnomInterface;
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "NewOptionID", $wpps );
	$Enom->AddParam( "Service", "wpps" );
	$Enom->AddParam( "Update", "true" );
	$Enom->AddParam( "command", "serviceselect" );
	$Enom->AddParam( "enduserip", $enduserip );
	$Enom->AddParam( "site", $sitename );
	$Enom->DoTransaction();
	
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		// Yes, get the first one
		$message .= $Enom->Values[ "Err1" ];
			} else {
				header ("Location: DomainMain.php?sld=$sld&tld=$tld");
				exit;
			}
	}

$lockvar = $HTTP_POST_VARS[ "lock" ];
$lockaction = $HTTP_POST_VARS["lockaction"];

if($lockaction == "change" ) {
		$Enom2 = new CEnomInterface;
		$Enom2->NewRequest();
		$Enom2->AddParam( "uid", $username );
		$Enom2->AddParam( "pw", $password );
		$Enom2->AddParam( "tld", $tld );
		$Enom2->AddParam( "sld", $sld );
		$Enom2->AddParam( "UnlockRegistrar", $lockvar );
		$Enom2->AddParam( "command", "setreglock" );
		$Enom2->DoTransaction();
		//echo $Enom2->PostString;
		// Check if there were errors
		if ( $Enom2->Values[ "ErrCount" ] != "0" ) {
			echo "Errors modifying services: {$Enom2->Values[ "Err1" ]}";
		} else {
			header ("Location: DomainMain.php?sld=$sld&tld=$tld");
			exit;
		}
	}
	
	$PageName = "DomainMain";
	$PageTitle = $SiteTitle . " - Administer your domain name";
	include('include/header.php'); 
?>
<style type="text/css">
<!--
.style1 {font-size: 12px}
.style2 {font-size: 14px}
-->
</style>


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
					
					// Check if any DNS entries were modified
					if ( WereDNSEntriesModified() == 1 ) {
						ModifyDNS();
					}
				
					// Check if the password was modified
					if ( WasPasswordModified() == 1 ) {
						ModifyPassword();
					}
				}
			?>
			</div>
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
		<form method="post" action="DomainMain.php" name="theForm" id="theForm">
		<input type="hidden" name="action" value="modify">	
			<tr> 
				<td colspan="3" align="center" valign="middle" class="titlepic"><span class="whiteheader">Domain Name Maintainance For&nbsp;<b><?php echo "$sld.$tld"; ?></b></span></td>
			</tr>
			
			<tr> 
				<td height="5" colspan="3" class="tdcolorone"><span class=cattitle>View/Modify Nameservers</span></td>
			</tr>
			
			<tr> 
				<td colspan="3" align="center" valign="middle" class="row1"><p class="main">					<br />
					Current NameServers:					<br />
					<?PHP include( "include/showDNS.php" ); ?>
					<br />
					<br />
				Modify&nbsp;<a href="DomainNs.php">Nameservers</a><br>
				<a href="nsmaint.php">Create / manage name servers</a> </p>				  </td>
			</tr>
			
			<tr> 
				<td height="5" colspan="3" class="tdcolorone"><span class=cattitle>Expiration Date</span></td>
			</tr>
			
			<tr> 
				<td colspan="3" align="center" valign="middle" class="row1">
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
              <td height="5" colspan="3" class="tdcolorone"><span class=cattitle>Modify Contact Information</span></td>
		  </tr>
			<tr>
              <td colspan="3" align="center" valign="middle" class="row1"><span class="main"> <br />
    Modify&nbsp;<a href="DomainContacts.php">Contact Information</a> <br />
    <img src="images/blank.gif" width="8" height="10" border="0"></span></td>
		  </tr>
			<tr>
              <td colspan="3" align="center" valign="middle" class="row1"><span class="main">For Help look at our <a href="javascript:openWin('popUps/faq.htm', 'FAQ');">FAQ Page</a> or our <a href="javascript:openWin('popUps/help.htm', 'FAQ');">Definitions Page</a>.</span> <br />
                  <img src="images/blank.gif" width="8" height="1" border="0"></td>
		  </tr>
			
			<tr> 
				<td height="5" colspan="3" class="tdcolorone"><span class=cattitle>ID Protect </span></td>
			</tr>
			
			<tr> 
				<td colspan="3" align="center" valign="middle" class="row1"><?php
		if(($tld ==	'com') || ($tld == 'net') ||($tld == 'org') ||($tld == 'info')){
				if($WPPSExists == '1'){ ?>				
				<table width="100%" ="100%" border="0" align="center">
				<form method="post" action="DomainMain.php" name="wppsvar" id="wppsvar">
				<input type="hidden" name="wppsaction" value="change">
                  <tr>
                    <td width="217"><b>Change Status</b></td>
                    <td width="400" valign="middle">&nbsp;&nbsp;
                          <input type="radio" name="wppsvar" value="0" <?php echo $WPPSEnabled1; ?>>
					&nbsp;&nbsp;On&nbsp;&nbsp;
						  <input type="radio" name="wppsvar" value="1" <?php echo $WPPSEnabled2; ?>>
					&nbsp;&nbsp;Off</strong></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center">&nbsp;&nbsp;
                        <input name="Input" type="image" src="images/btn_submit.gif" border="0"></td>
                  </tr></form>
                </table>	<? } else { ?>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="center"><span class="style2">ID Protect is not enabled - Your contact information is publicly available</span> <a href="<?php echo "getidprotect.php?sld=$sld&tld=$tld";?>" class="style1"><br>
  Click here to buy</a> </td>
				  </tr>
				</table>
			<? } 
			} else { 
				echo '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="center"><span class="style2">ID Protect is not available for .'.$tld.' domains</td>
				  </tr>
				</table>';
			}
			?>				  <span class="main">
					</td>
			</tr>
				<tr> 
				<td colspan="3" valign="middle" class="tdcolorone"><span class="whiteheader">&nbsp;Registrar&nbsp;&nbsp;Lock</span></td>
			</tr>
			<tr>
				<td colspan="3" align="center" valign="middle" class="row1"><?php
		if(($tld ==	'com') || ($tld == 'net') ||($tld == 'org') ||($tld == 'cc')
		 || ($tld == 'tv') || ($tld == 'biz') ||($tld == 'nu') ||($tld == 'bz')
		 || ($tld == 'us')){ ?>	
				<table width="100%" ="100%" border="0" align="center">
                  <tr>
                    <td width="217"><b>Change Status</b></td>
                    <td width="400" valign="middle">&nbsp;&nbsp;
				<form method="post" action="DomainMain.php" name="lockvar" id="lockvar">
				<input type="hidden" name="lockaction" value="change">
				<input type="radio" name="lock" value="0" <?php echo $lock1; ?>>&nbsp;&nbsp;On&nbsp;&nbsp;
				<input type="radio" name="lock" value="1" <?php echo $lock2; ?>>&nbsp;&nbsp;Off</strong></td>
                  <tr>
                    <td colspan="4" align="center">&nbsp;&nbsp;
                        <input name="Input" type="image" src="images/btn_submit.gif" border="0"></td>
                  </tr></form>
                </table>	
			<?
			} else { 
				echo '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="center"><span class="style2">Registrar Lock is not available for .'.$tld.' domains</td>
				  </tr>
				</table>';
			} ?>
			</td></tr> 
			</form>
		<form method="post" action="DomainMain.php" name="theForm" id="theForm">
		<input type="hidden" name="action" value="modify">	
			<? 
			include ('include/hosts.php');
			include ('include/forwarding.php'); 
			?>
			<tr> 
				<td height="5" colspan="3" class="tdcolorone"><span class=cattitle>&nbsp;Change&nbsp;&nbsp;Password</span></td>
			</tr>
			<tr> 
				<td align="center" valign="middle" class="row1"><div align="right"><span class="main">Password:&nbsp;&nbsp;</span></div></td>
				<td valign="middle" class="row2">&nbsp;&nbsp;<input type="password" name="password1" id="idpassword1" maxlength="60" value="<?php if ( $HTTP_POST_VARS[ "password1" ] != "" ) { echo $HTTP_POST_VARS[ "password1" ]; } else { echo "**********"; } ?>">				  <img src="images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<tr> 
				<td align="center" valign="middle" class="row1"><div align="right"><span class="main">Retype&nbsp;Password:&nbsp;&nbsp;</span></div></td>
				<td valign="middle" class="row2">&nbsp;&nbsp;<input type="password" name="password2"  id="idpassword2" maxlength="60" value="<?php if ( $HTTP_POST_VARS[ "password2" ] != "" ) { echo $HTTP_POST_VARS[ "password2" ]; } else { echo "**********"; } ?>">				  <img src="images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<?php
				// Check if we're supposed to modify something
				if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
					// Check if the password was modified
					if ( WasPasswordModified() == 1 ) {
						ModifyPassword();
					}
				}
			?>
			<input type="hidden" value="FullForm" name="FormType">
			<input type="hidden" value="FullForm" name="FormType">
			<tr> 
				<td height="5" colspan="3" class="tdcolorone"><span class="whiteheader">&nbsp;Apply&nbsp;&nbsp;Changes</span></td>
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
		</form>
		</table>
	</td>
</tr>
				<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
			</tr>
		</form>
		</table>
	</td>
</tr>
<? include('include/footer.php'); ?>