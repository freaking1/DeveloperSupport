<?php
	include( "include/EnomInterface_inc.php" );
	include( "include/sessions.php" );
		
	// Get vars
	$cAction = $HTTP_POST_VARS[ "action" ];
	$tld = $HTTP_POST_VARS[ "tld" ];
	$sld = $HTTP_POST_VARS[ "sld" ];
	$_SESSION["sld"] = $sld;
	$_SESSION["tld"] = $tld;
	$bError = 0;
	$bAvailable = 0;
	$showerrorbox = 0;
	
	// Do we need to check a name?
	if ( $cAction == "check" ) {
		// Create an instance of the url interface class
		$showerrorbox = 1;
 		$Enom = new CEnomInterface; 
						
		// Set account username and password
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );

		// Set the domain name to check
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		
		// Check the name
		$Enom->AddParam( "command", "check" );
		$Enom->DoTransaction();
	
		// Were there errors?
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			// Yes, get the first one
			$cErrorMsg = $Enom->Values[ "Err1" ];
		
			// Flag an error
			$bError = 1;
		} else {
			// No interface errors
			$bError = 0;
			
			// Check code from NSI (210 = name available)
			switch ( $Enom->Values[ "RRPCode" ] ) {
			case "210":
				// The name is available
				$bAvailable = 1;
				break;
				
			case "211":
				// The name is not available
				$bAvailable = 0;
				break;
				
			default:
				// There was an error from NSI
				$bError = 1;
				$cErrorMsg = $Enom->Values[ "RRPText" ];
				break;
			}
		}
	}
	//Page name - DO NOT CHANGE
	$PageName = "Check";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Check for a domain name";

	//This file must be inluded.
	include('include/header.php'); 
	
	// Begin page content
?>			

<tr> 
	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
			
<tr> 
				<td colspan="4" align="center" valign="middle" class="titlepic">&nbsp;</td>
			</tr>
<?php if($showerrorbox == 1){ ?>
			<tr> 
				<td class="tdcolorone" height="5">&nbsp;</td>
				<td width="40%" height="5" class="tdcolorone"><?
					if ( $cAction == "check" ) {
						if ( $bError == 1 ) {
							// There was some kind of error, print that out
							echo "<strong class=\"cattitle\">Error</strong>";
						} else if ( $bAvailable == 0 ) {
							// The domain name is already registered
							echo "<strong class=\"cattitle\">Already registered</strong>";
						} else if ( $bAvailable == 1 ) {
							// The domain name is available, display a link to go register it
							echo "<strong class=\"cattitle\">Congratulations!</strong>";
						} else {
							// If we get here the page didn't work right
							echo "<strong class=\"cattitle\">Unknown error</strong>";
						}
					}
					?></td>
				<td class="rowpic" align="right" colspan="2">&nbsp;</td>
			</tr>
			
			<tr> 
				<td width="5%" height=50 align="center" valign="middle" class="row1">&nbsp;</td>
				<td class="row1" colspan="3">
				<br />			  
				<div class="main">
					<?
					if ( $cAction == "check" ) {
						if ( $bError == 1 ) {
							// There was some kind of error, print that out
							echo "We're sorry, there was an error checking the availability of the domain name <b>$sld.$tld</b>. <br />";
							echo "The error was <strong class=red>\"$cErrorMsg\"</strong>";
							if ($tld == "name") {
								echo "<br /><br />";
								echo ".name SLD formatting must be like this: <strong>firstname.lastname.name</strong>";
								echo "<br />";
								echo "Example:&nbsp;<strong>john.doe.name</strong>";
							}
							echo "<br /><br />";
							echo "Would you like to try again</a>?&nbsp;Enter a name in below.";
						} else if ( $bAvailable == 0 ) {
							// The domain name is already registered
							echo "<strong>We're sorry, the domain name <b>$sld.$tld";
							echo "</b><br /> has already been registered.</strong><br /><br />Look-up a different name?&nbsp;Enter a name in below.";
						} else if ( $bAvailable == 1 ) {
							// The domain name is available, display a link to go register it
							echo "<strong>The domain name <b>$sld.$tld";
							echo "</b> is available!<br /> <a href=\"PayforName.php?sld=$sld&tld=$tld&action=register";
							echo "\">Register it now by clicking ";
							echo "here!</a></strong><br /><br />Or would you like to look-up a different name?&nbsp;Enter a name in below.";
						} else {
							// If we get here the page didn't work right
							echo "Unknown error. Please try again!";
						}
					}
					?>
				</div><br /></td>
			</tr>
			
			<tr> 
				<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
			</tr>
			
			<tr> 
				<td colspan="4" align="center" valign="middle" class="titlepic">&nbsp;</td>
			</tr>
			<? } ?>
			<tr> 
				<td class="tdcolorone" height="5">&nbsp;</td>
				<td width="40%" height="5" class="tdcolorone"><span class=cattitle>Check Name</span></td>
				<td class="rowpic" align="right" colspan="2">&nbsp;</td>
			</tr>
			
			<tr> 
				<td width="5%" height=50 align="center" valign="middle" class="row1">&nbsp;</td>
				<td width="40%" height=50 align="left" valign="middle" class="row1"><span class="main">Verify that the name you want is available</span></td>
				<td width="50%" height=50 align="center" valign="middle" class="row2">
					<table border="0" cellpadding="2" cellspacing="2" align="center">
						<form method="post" action="Check.php" id="form1" name="form1">
						<input type="hidden" name="action" value="check">
						<tr> 
							<td valign="middle" align="center" width="90" class="main">Domain:</td>
							<td valign="middle" align="center"><input type="text" maxlength="272" name="sld" id="idsld"> 
							&nbsp;.&nbsp;<?php include ('Setup/tldListOne.php'); ?></td>
						</tr>
					
						<tr> 
							<td valign="middle" align="center" colspan="2"><input name="image2" type="image" src="images/btn_checkavail_g.gif" WIDTH="144" HEIGHT="22" border="0">
				<br /></td>
						</tr>
						</form>
					</table>
				</td>
				<td width="5%" height=50 align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="100" border="0"></td>
			</tr>
			
			<tr> 
				<td width="5%" height=50 align="center" valign="middle" class="row1">&nbsp;</td>
				<td width="40%" height=50 align="center" valign="middle" class="row1"><span class="main">Already 
				registered with us?<br />
				Log-in here to administer your domain!</span></td>
				<td width="45%" height=50 align="center" valign="middle" class="row2">
					<table border="0" cellpadding="2" cellspacing="2" align="center">
					<form method="post" action="LogIn.php" id="form2" name="form2">
						<tr> 
							<td align="right" valign="top" width="90" class="main">Domain:&nbsp;&nbsp;</td>
							<td align="center" valign="middle"> 
							<input type="text" maxlength="272" name="sldtld" id="idsldtld"></td>
						<tr> 
							<td align="right" valign="top" class="main">Password:&nbsp;&nbsp;</td>
							<td align="center" valign="middle"> 
							<input type="password" maxlength="60" name="password" id="idpassword"></td>
						</tr>
						<tr> 
							<td>&nbsp;</td>
							<td align="center" valign="middle"> 
							<input name="image" type="image" src="images/btn_login_g.gif" WIDTH="74" HEIGHT="22" border="0"></td>
						</tr></form>
					</table></td>
				<td width="5%" height=50 align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="100" border="0"></td>
			</tr>
			
			<tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
			</tr>
			
		</table>
	</td>
</tr>


<!-- end of page content -->

<? include('include/footer.php'); ?>