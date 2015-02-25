<?php
	//Remember to change this file once you are ready to go live
	include( "include/sessions.php" );
	include( "include/EnomInterface_inc.php" );
			$_SESSION['transferorderid'] = $Enom->Values[ "transferorderid" ];
			$_SESSION['transferorderid'] = $Enom->Values[ "transferorderid" ];
			$_SESSION['userpassword'] = $cPW1;
			$_SESSION['LoggedIn'] = 1;
			$Enom->Values[ "transferorderid" ] = $transferorder;

	//Turn credit cards ON or OFF
	//1 = ON 0 = OFF
	$UseCreditCard = 0;
	
	// Get some form variables
	$cAction = $HTTP_POST_VARS[ "action" ];
	$cPW1 = $HTTP_POST_VARS[ "password1" ];
	$cPW2 = $HTTP_POST_VARS[ "password2" ];

  		// Create URL Interface class
		$Enom = new CEnomInterface;
  		
  		// Set account username and password
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
		$Enom->AddParam( "ordertype", "AutoVerification" );

  		// Set domain name
		$sld = $HTTP_POST_VARS[ "sld" ]; 
		$tld = $HTTP_POST_VARS[ "tld" ]; 
		
		//Set domain password variables
		$cPW1 = $HTTP_POST_VARS[ "password1" ]; 
		$cPW2 = $HTTP_POST_VARS[ "password2" ]; 


	// Do we need to register a name?
	if ( $cAction == "transfer" ) {
		// Verify fields
		if ( $cPW1 != $cPW2 ) {
			$bError = 1;
			$cErrorMsg ="Passwords do not match";
		} else { 
		 $Enom->AddParam( "domainpassowrd", $cPW1);}			}

  		$Enom->AddParam( "tld1", $tld );
  		$Enom->AddParam( "sld1", $sld );

		//Set Transfer specific details
		$Enom->AddParam( "domaincount", "1" );
		
	// Begin page content

		if ($UseCreditCard == "1") {
			//Charge amount
			$Enom->AddParam( "UseCreditCard", "yes" );
			$Enom->AddParam( "CreditCardNumber", $HTTP_POST_VARS[ "CreditCardNumber" ] );
			$Enom->AddParam( "CreditCardExpMonth", $HTTP_POST_VARS[ "CreditCardExpMonth" ] );
			$Enom->AddParam( "CreditCardExpYear", $HTTP_POST_VARS[ "CreditCardExpYear" ] );
			$Enom->AddParam( "CCName", $HTTP_POST_VARS[ "CCName" ] );
			$Enom->AddParam( "CardType", $HTTP_POST_VARS[ "CardType" ] );
			$Enom->AddParam( "CCAddress", $HTTP_POST_VARS[ "CCAddress" ] ); //Address of the credit card owner
			$Enom->AddParam( "CCZip", $HTTP_POST_VARS[ "CCZip" ] ); //Zip code of the credit card owner
			$Enom->AddParam( "CVV2", $HTTP_POST_VARS[ "CVV2" ] ); //Card verification number// You will need to adjust the pricing
			
			//pricing info
			switch ($tld) {
			case  ".co.uk":
				$ChargeAmount =  "15.95" ;
				break;
			case  ".org.uk":
				$ChargeAmount =  "15.95" ;
				break;
			case  ".com":
				$ChargeAmount =  "15.95" ;
				break;
			case  ".net":
				$ChargeAmount =  "15.95" ;
				break;
			case  ".cc":
				$ChargeAmount =  "29.95" ;
				break;
			}
			//Now, add charge amount for purchase
			$Enom->AddParam ("ChargeAmount", $ChargeAmount) ; }
	

		//Set Lock and Renewal
		if ($HTTP_POST_VARS[ "lock" ] == "ON") {
			$Enom->AddParam( "lock", "1" );
		} else {
		$Enom->AddParam( "lock", "0" );
				}

		//Set Use contacts or not
		if ($HTTP_POST_VARS[ "setcontacts" ] == "ON") {
			$Enom->AddParam( "setcontacts", "1" );
		} else {
		$Enom->AddParam( "setcontacts", "0" );
				}
		//Set AutoRenew
		if ($HTTP_POST_VARS[ "renew" ] == "ON") {
			$Enom->AddParam( "renew", "1" );
		} else {
		$Enom->AddParam( "renew", "0" );
				}
		
		//Add IP address of end user
  		$Enom->AddParam( "EndUserIP", $enduserip );
		

		$Enom->AddParam( "command", "tp_createorder" );
		if ($bError == 0) {
		$Enom->DoTransaction(); }
	
	//Page name - DO NOT CHANGE
	$PageName= "RegisterName";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Transfer your domain name";

	//This file must be inluded.
	include('include/header.php'); 
	
	// Begin page content
?>

<tr> 
	<td class="OutlineOne">
	
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
		
		<form method="post" action="avtransfer.php" id="form1" name="form1">
		<input type="hidden" name="action" value="transfer">
		  
<?
		  	if ( $cAction == "transfer" ) {
				if ($bError == 1 OR $bAuth == 1)
				{
					include ('include/TransferError.php');
				} else {
				include ('include/TransferSuccess.php');
					}
				}
			?>


		  <!-- this begins section ONE -->
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Transfer 
			  Your Domain </span></td>
		  </tr>
		  <tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" class="tdcolorone">&nbsp;</td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" class="row1">Domain&nbsp;name:&nbsp;</td>
			<td width="50%" valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="sld" id="sld2" maxlength="256" value="<?php echo "$sld"; ?>"> 
			  &nbsp;.&nbsp;<?php include ('Setup/tldListThree.php'); ?></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
		  </tr>
		  <tr> 
			<td width="5%" valign="middle" class="row1">&nbsp;</td>
			<td width="40%"  class="row1"> <b class="red">*</b>Domain&nbsp;Password:&nbsp;&nbsp;</td>
			<td width="50%" valign="middle" class="row2"><b class="red"> &nbsp;&nbsp;&nbsp; 
			  <input type="password" name="password1"  maxlength="60" value="<?php echo $HTTP_POST_VARS[ "password1" ]?>">
			  </b></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
		  </tr>
		  <tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%"  class="row1"><b class="red">*</b>Re-type&nbsp;Password:&nbsp;</td>
			<td width="50%" valign="middle" class="row2"><b class="red">&nbsp;&nbsp;&nbsp; 
			  <input type="password" name="password2" id="password2" maxlength="60" value="<?php echo $HTTP_POST_VARS[ "password2" ]?>">
			  </b></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
		  </tr>
		  <!-- this ends section ONE -->
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		  </tr>

		  <!-- this begins The form section -->
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;Additional&nbsp;&nbsp;Settings</span></td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
		<td align="right"  class="row1">Do not allow this name to be transferred to another registrar (recommended)</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="lock" value="ON" checked></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
            <td align="center" valign="middle" class="row1">&nbsp;</td>
            <td align="right"  class="row1"> Renew the registration of this domain name when it expires. (recommended)</td>
            <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="renew" value="ON" checked></td>
            <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
	      </tr>
		  <tr>
            <td align="center" valign="middle" class="row1">&nbsp;</td>
            <td align="right"  class="row1"> Use Current domain contacts? </td>
            <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="setcontacts" value="ON" checked></td>
            <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
	      </tr>
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1" colspan="2" align="center">&nbsp;<input type="image" src="images/btn_submit.gif" border="0" WIDTH="74" HEIGHT="22">
	<a href="index.php" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
			<td align="center" valign="middle" noWrap class="row1">&nbsp;</td>
		  </tr>
		</form>
	</table>
	</td>
</tr>

<!-- this ends The form -->
<? include('include/footer.php'); ?>