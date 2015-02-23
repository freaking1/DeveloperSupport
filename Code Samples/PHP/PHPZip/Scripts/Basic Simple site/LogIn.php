<?php
	// Begin page content
	include( "include/EnomInterface_inc.php" );
	include( "include/sessions.php" );
	include( "include/EditFns_inc.php" );

		$sld = $_SESSION['sld']; 
		$tld = $_SESSION['tld'];
		$action = $_POST['action'];
		
	$domain_name = $HTTP_POST_VARS[ "sldtld" ];

if($action == 'login'){
	$Enom1 = new CEnomInterface;
	$Enom1->AddParam( "uid", $username );
	$Enom1->AddParam( "pw", $password );
	$Enom1->AddParam( "PassedDomain", $domain_name);
	$Enom1->AddParam( "command", "parsedomain" );
	$Enom1->DoTransaction();
		$sld = $Enom1->Values[ "SLD" ];
		$tld = $Enom1->Values[ "TLD" ];

	$Enom = new CEnomInterface;
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );	
	$Enom->AddParam( "domainpassword", $HTTP_POST_VARS[ "password" ] );
	$Enom->AddParam( "command", "validatepassword" );
	$Enom->DoTransaction();
	
	if ( $Enom->Values[ "ErrCount" ] == "0" ) {
		
		$postvars = "sld=$sld&tld=$tld";
		$Enom = new CEnomInterface;
		$Enom->NewRequest();
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "command", "GetRegistrationStatus" );
		$Enom->DoTransaction();
		
		setcookie ("LoggedIn", '1');
		setcookie ("sld", $sld);
		setcookie ("tld", $tld);
		$_SESSION['LoggedIn'] = 1;
		$_SESSION['sld'] = $sld;
		$_SESSION['tld'] = $tld;

		
		$RegistrationStatus = $Enom->Values[ "RegistrationStatus" ];
			if($RegistrationStatus == 'Hosted'){
				$RegStatus = 0;
				$_SESSION['RegStatus'] = 0;
				setcookie ("RegStatus", $RegStatus);

				header ("Location: $site_url/DomainMainHosted.php?$postvars");
			    exit;
			} elseif($RegistrationStatus == 'Registered'){
				$RegStatus = 1;
				$_SESSION['RegStatus'] = 1;
				setcookie ("RegStatus", $RegStatus);
				
				header ("Location: $site_url/DomainMain.php?$postvars");
			    exit;
			} 	
		} else {
		$errorcount = 1;
		}
	}
	//Page name - DO NOT CHANGE
	$PageName = "LogIn";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Log In";

	//This file must be inluded.
	include('include/header.php'); 
?>
<tr> 
	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
	<!-- begin page content -->	
			<tr> 
              <td colspan="2" align="center" valign="middle" class="titlepic"><span class="whiteheader">User&nbsp;&nbsp;Log-in</span></td>
            </tr>
            <tr> 
              <td height="5" colspan="2" class="tdcolorone">&nbsp;</td>
            </tr>
			<tr> 
				<td width="35%" height=50 align="center" valign="middle" class="row1"> <?php if($errorcount == "1") { echo '<span class="red">There was a problem:<br />'; echo "{$Enom->Values[ "Err1" ]}";?></span><? } ?></td>
				<td width="65%" height=50 align="center" valign="middle" class="row2">
				<table width="340" border="0" cellpadding="2" cellspacing="2">
				<form method="post" action="LogIn.php" id="form2" name="form2">
					<input type="hidden" name="action" value="login">
						<tr>
							<td width="90" align="right" valign="top" class="main">Domain:&nbsp;&nbsp;</td>
							<td><input type="text" maxlength="272" name="sldtld" value="<?php echo "$sld.$tld";?>">
							</td>
						</tr>
						<tr>
							<td align="right" valign="top" class="main">Password:&nbsp;&nbsp;</td>
							<td><input type="password" maxlength="60" name="password"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><br />
                  <input name="image1" type="image" id="image1" src="images/btn_login.gif" WIDTH="74" HEIGHT="22" border="0">
                  &nbsp;<a href="index.php" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
						</tr>
					</form>
					</table>				</td>
			</tr>
	  </table>
	</td>
</tr>
	<!-- end of page content -->
		  
	<? include('include/footer.php'); ?>	