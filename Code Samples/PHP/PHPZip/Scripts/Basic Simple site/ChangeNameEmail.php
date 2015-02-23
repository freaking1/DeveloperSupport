<?php
		include( "include/sessions.php" );
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
	include( "include/DomainFns_inc.php" );
	include( "include/LoggedIn.php" );
	include( "include/EnomInterface_inc.php" );		
	
	// Create URL Interface class
  	$Enom = new CEnomInterface;
	
	//Grab current email address		
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "command", "getdotnameforwarding" );
	$Enom->DoTransaction();
	
	//error handling
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		// Yes, get the first one
		$expMsg = $Enom->Values[ "Err1" ];
		$nameError = 1;
	} else {
		$dotNameFor = $Enom->Values[ "address" ];
	}
	
	$updateForward  = $HTTP_POST_VARS[ "updateForward" ];
	
	if ($updateForward == 1) {
	
		$forwardto  = $HTTP_POST_VARS[ "forwardto" ];
	
		//change email address		
		$Enom->NewRequest();
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "forwardto", $forwardto );
		$Enom->AddParam( "command", "setdotnameforwarding" );
		$Enom->DoTransaction();
		//error handling
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			// Yes, get the first one
			$expMsg = $Enom->Values[ "Err1" ];
			$nameError = 1;
		} else {
			header ("Location: DomainMain.php");
  			exit;
		}
	}
	
	//Page name - DO NOT CHANGE
	$PageName = "changeNameEmail";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Change dot Name Email address";

	//This file must be inluded.
	include('include/header.php'); 
?>
<tr> 
	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
	<!-- begin page content -->
		<form name="dotnameform" action="ChangeNameEmail.php" method="post">
		<!-- this begins section Four -->
		<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Change&nbsp;<strong>dot name</strong> Email Forwarding Address</span></td>
		</tr>
		<tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" class="tdcolorone">&nbsp;</td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td class="row1" valign="middle">Email Forwarding Address<?php if ($nameError == 1){echo "<br />" . $expMsg;} ?></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;<input name="forwardto" type="text" value="<?php echo $dotNameFor; ?>" size="40" maxlength="40" /></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td class="row1" valign="middle">&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;<input name="image1" type="image" id="image1" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">&nbsp;&nbsp;<a href="DomainMain.php"><img src="images/btn_cancel.gif" border="0" WIDTH="74" HEIGHT="22"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		</tr>
		<input type="hidden" name="updateForward" value="1">
		</form>
	<!-- end of page content -->
	  	</table>
	</td>
</tr>
<? include('include/footer.php'); ?>	

		