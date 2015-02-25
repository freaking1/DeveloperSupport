<?php
	require("include/sessions.php");
	require( "include/EnomInterface_inc.php" );
	
	// Get vars
	$cAction = $HTTP_POST_VARS[ "action" ];
	$tld = $HTTP_POST_VARS[ "tld" ];
	$sld = $HTTP_POST_VARS[ "sld" ];
	$_SESSION["sld"] = $sld;
	$_SESSION["tld"] = $tld;
	$bError = 0;
	$bAvailable = 0;
	
	// Get some form variables
	$cAction = $HTTP_POST_VARS[ "action" ];
	$cPW1 = $HTTP_POST_VARS[ "password1" ];
	$cPW2 = $HTTP_POST_VARS[ "password2" ];
	
	// Do we need to register a name?
	if ( $cAction == "register" ) {
	$sld = $_GET['sld'];
	$tld = $_GET['tld'];
		// Verify fields
		if ( $cPW1 != $cPW2 ) {
			$bError = 1;
			$cErrorMsg ="Passwords do not match";
		} else if ( ( $HTTP_POST_VARS[ "RegistrantEmailAddress" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantPhone" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantCountry" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantPostalCode" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantCity" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantAddress1" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantLastName" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantFirstName" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantJobTitle" ] == "" ) ||
			( $HTTP_POST_VARS[ "RegistrantOrganizationName" ] == "" ) ) {

			$bError = 1;
			$cErrorMsg ="All required fields are not filled out";
		} else if ( ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "S" ) &&
			( $HTTP_POST_VARS[ "RegistrantState" ] == "" )) {

			$bError = 1;
			$cErrorMsg ="All required fields are not filled out";
		} else if ( ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "P" ) &&
			( $HTTP_POST_VARS[ "RegistrantProvince" ] == "" )) {

			$bError = 1;
			$cErrorMsg ="All required fields are not filled out";
		} else {
		
		//#####################################################################

		//	THIS IS A GOOD PLACE TO DO THE CREDIT CARD TRANSACTION
		//	IF YOU PROCESS ORDERS THROUGH YOUR OWN MERCHANT ACCOUNT
		
		//  IT IS RECOMMENDED YOU DO A PRE-AUTHORIZATION BEFORE REGISTERING
		//  THEN, PROCESS THE CLIENTS CREDIT CARD AFTER REGISTRATION SUCCESS
		
		//#####################################################################

  		// Create URL Interface class
  		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
  		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "sld", $sld );
  		$Enom->AddParam( "site", "Enomitron" );
  		
  		// Set number of years to register
  		if ( $HTTP_POST_VARS[ "NumYears" ] != "" ) {
  			$Enom->AddParam( "NumYears", $HTTP_POST_VARS[ "NumYears" ] );
  		}

  		// Fill in registrant contact information
  		$Enom->AddParam( "RegistrantEmailAddress", $HTTP_POST_VARS[ "RegistrantEmailAddress" ] );
  		$Enom->AddParam( "RegistrantFax", $HTTP_POST_VARS[ "RegistrantFax" ] );
  		$Enom->AddParam( "RegistrantPhone", $HTTP_POST_VARS[ "RegistrantPhone" ] );
  		$Enom->AddParam( "RegistrantCountry", $HTTP_POST_VARS[ "RegistrantCountry" ] );
  		$Enom->AddParam( "RegistrantPostalCode", $HTTP_POST_VARS[ "RegistrantPostalCode" ] );
  		if ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "S" ) {
    		$Enom->AddParam( "RegistrantStateProvinceChoice", "S" );
    		$Enom->AddParam( "RegistrantStateProvince", $HTTP_POST_VARS[ "RegistrantState" ] );
    	} else if ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "P" ) {
    		$Enom->AddParam( "RegistrantStateProvinceChoice", "Province" );
    		$Enom->AddParam( "RegistrantStateProvince", $HTTP_POST_VARS[ "RegistrantProvince" ] );
    	} else {
    		$Enom->AddParam( "RegistrantStateProvinceChoice", "Blank" );
    		$Enom->AddParam( "RegistrantStateProvince", "" );
    	}
  		$Enom->AddParam( "RegistrantCity", $HTTP_POST_VARS[ "RegistrantCity" ] );
  		$Enom->AddParam( "RegistrantAddress2", $HTTP_POST_VARS[ "RegistrantAddress2" ] );
  		$Enom->AddParam( "RegistrantAddress1", $HTTP_POST_VARS[ "RegistrantAddress1" ] );
  		$Enom->AddParam( "RegistrantLastName", $HTTP_POST_VARS[ "RegistrantLastName" ] );
  		$Enom->AddParam( "RegistrantFirstName", $HTTP_POST_VARS[ "RegistrantFirstName" ] );
  		$Enom->AddParam( "RegistrantJobTitle", $HTTP_POST_VARS[ "RegistrantJobTitle" ] );
  		$Enom->AddParam( "RegistrantOrganizationName", $HTTP_POST_VARS[ "RegistrantOrganizationName" ] );
  		
  		// Fill in Administrator contact information
  		/* You will need to add in the form fields, modeled after the Registrant information collected
		
  		$Enom->AddParam( "AdminEmailAddress", $HTTP_POST_VARS[ "AdminEmailAddress" ] );
  		$Enom->AddParam( "AdminFax", $HTTP_POST_VARS[ "AdminFax" ] );
  		$Enom->AddParam( "AdminPhone", $HTTP_POST_VARS[ "AdminPhone" ] );
  		$Enom->AddParam( "AdminCountry", $HTTP_POST_VARS[ "AdminCountry" ] );
  		$Enom->AddParam( "AdminPostalCode", $HTTP_POST_VARS[ "AdminPostalCode" ] );
  		$Enom->AddParam( "AdminStateProvinceChoice", $HTTP_POST_VARS[ "AdminStateProvinceChoice" ] );
  		$Enom->AddParam( "AdminStateProvince", $HTTP_POST_VARS[ "AdminStateProvince" ] );
  		$Enom->AddParam( "AdminCity", $HTTP_POST_VARS[ "AdminCity" ] );
  		$Enom->AddParam( "AdminAddress2", $HTTP_POST_VARS[ "AdminAddress2" ] );
  		$Enom->AddParam( "AdminAddress1", $HTTP_POST_VARS[ "AdminAddress1" ] );
  		$Enom->AddParam( "AdminLastName", $HTTP_POST_VARS[ "AdminLastName" ] );
  		$Enom->AddParam( "AdminFirstName", $HTTP_POST_VARS[ "AdminFirstName" ] );
  		$Enom->AddParam( "AdminJobTitle", $HTTP_POST_VARS[ "AdminJobTitle" ] );
  		$Enom->AddParam( "AdminOrganizationName", $HTTP_POST_VARS[ "AdminOrganizationName" ] );
  		*/
  		
  		// Fill in technical contact information
  		/* You will need to add in the form fields, modeled after the Registrant information collected
		
  		$Enom->AddParam( "TechEmailAddress", $HTTP_POST_VARS[ "TechEmailAddress" ] );
  		$Enom->AddParam( "TechFax", $HTTP_POST_VARS[ "TechFax" ] );
  		$Enom->AddParam( "TechPhone", $HTTP_POST_VARS[ "TechPhone" ] );
  		$Enom->AddParam( "TechCountry", $HTTP_POST_VARS[ "TechCountry" ] );
  		$Enom->AddParam( "TechPostalCode", $HTTP_POST_VARS[ "TechPostalCode" ] );
  		$Enom->AddParam( "TechStateProvinceChoice", $HTTP_POST_VARS[ "TechStateProvinceChoice" ] );
  		$Enom->AddParam( "TechStateProvince", $HTTP_POST_VARS[ "TechStateProvince" ] );
  		$Enom->AddParam( "TechCity", $HTTP_POST_VARS[ "TechCity" ] );
  		$Enom->AddParam( "TechAddress2", $HTTP_POST_VARS[ "TechAddress2" ] );
  		$Enom->AddParam( "TechAddress1", $HTTP_POST_VARS[ "TechAddress1" ] );
  		$Enom->AddParam( "TechLastName", $HTTP_POST_VARS[ "TechLastName" ] );
  		$Enom->AddParam( "TechFirstName", $HTTP_POST_VARS[ "TechFirstName" ] );
  		$Enom->AddParam( "TechJobTitle", $HTTP_POST_VARS[ "TechJobTitle" ] );
  		$Enom->AddParam( "TechOrganizationName", $HTTP_POST_VARS[ "TechOrganizationName" ] );
  		*/

  		// Fill in Aux Billing contact information
  		/* You will need to add in the form fields, modeled after the Registrant information collected
		
  		$Enom->AddParam( "AuxBillingEmailAddress", $HTTP_POST_VARS[ "AuxBillingEmailAddress" ] );
  		$Enom->AddParam( "AuxBillingFax", $HTTP_POST_VARS[ "AuxBillingFax" ] );
  		$Enom->AddParam( "AuxBillingPhone", $HTTP_POST_VARS[ "AuxBillingPhone" ] );
  		$Enom->AddParam( "AuxBillingCountry", $HTTP_POST_VARS[ "AuxBillingCountry" ] );
  		$Enom->AddParam( "AuxBillingPostalCode", $HTTP_POST_VARS[ "AuxBillingPostalCode" ] );
  		$Enom->AddParam( "AuxBillingStateProvinceChoice", $HTTP_POST_VARS[ "AuxBillingStateProvinceChoice" ] );
  		$Enom->AddParam( "AuxBillingStateProvince", $HTTP_POST_VARS[ "AuxBillingStateProvince" ] );
  		$Enom->AddParam( "AuxBillingCity", $HTTP_POST_VARS[ "AuxBillingCity" ] );
  		$Enom->AddParam( "AuxBillingAddress2", $HTTP_POST_VARS[ "AuxBillingAddress2" ] );
  		$Enom->AddParam( "AuxBillingAddress1", $HTTP_POST_VARS[ "AuxBillingAddress1" ] );
  		$Enom->AddParam( "AuxBillingLastName", $HTTP_POST_VARS[ "AuxBillingLastName" ] );
  		$Enom->AddParam( "AuxBillingFirstName", $HTTP_POST_VARS[ "AuxBillingFirstName" ] );
  		$Enom->AddParam( "AuxBillingJobTitle", $HTTP_POST_VARS[ "AuxBillingJobTitle" ] );
  		$Enom->AddParam( "AuxBillingOrganizationName", $HTTP_POST_VARS[ "AuxBillingOrganizationName" ] );
  		*/
				
		//Nexus info if sent
		if ($tld =="us") {
			$nexus = $HTTP_POST_VARS[ "NexusCategory" ];
			$countrycode = $HTTP_POST_VARS[ "NexusCountry" ];
			$purpose = $HTTP_POST_VARS[ "AppPurpose" ];
			switch ($nexus){
			case 'C11':
			case 'C12':
			case 'C21':
				$Enom->AddParam( "us_nexus", $nexus );
				break;
			case 'C31':
          	case 'C32':
				$Enom->AddParam( "us_nexus", $nexus );
				$Enom->AddParam( "global_cc_us", $countrycode);
				break;
			}
			$Enom->AddParam( "us_purpose", $purpose );
		}
				
		//Nexus info if sent
		if ($tld =="ca") {
			$Enom->AddParam( "cira_legal_type", $cira_legal_type );
		}
				
		//UK info if sent
		if ($tld =="co.uk") {
		$uk_legal_type = $HTTP_POST_VARS[ "uk_legal_type" ];
		$uk_reg_co_no = $HTTP_POST_VARS[ "uk_reg_co_no" ];
		$registered_for = $HTTP_POST_VARS[ "registered_for" ];
			$Enom->AddParam( "uk_legal_type", $uk_legal_type );
			$Enom->AddParam( "uk_reg_co_no", $uk_reg_co_no );
			$Enom->AddParam( "registered_for", $registered_for );
		} else if ($tld =="org.uk") {
		$uk_legal_type = $HTTP_POST_VARS[ "uk_legal_type" ];
		$uk_reg_co_no = $HTTP_POST_VARS[ "uk_reg_co_no" ];
		$registered_for = $HTTP_POST_VARS[ "registered_for" ];
			$Enom->AddParam( "uk_legal_type", $uk_legal_type );
			$Enom->AddParam( "uk_reg_co_no", $uk_reg_co_no );
			$Enom->AddParam( "registered_for", $registered_for );
		}
		
		// If you are using eNom credit card processor
		// Make sure to set $UseCreditCard to 1
		
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
			case "cc": 
				$ChargeAmount =  $compricedns ;
				break;
			case  "info":
				$ChargeAmount =  $infopricedns ;
				break;
			case  "us":
				$ChargeAmount =  $uspricedns ;
				break;
			case  "biz":
				$ChargeAmount =  $bizpricedns ;
				break;
			case  "bz":
				$ChargeAmount =  $bspricedns ;
				break;
			case  "ca":
				$ChargeAmount =  $capricedns ;
				break;
			case  "nu":
				$ChargeAmount =  $nupricedns ;
				break;
			case  "co.uk":
				$ChargeAmount =  $ukpricedns ;
			case  "org.uk":
				$ChargeAmount =  $ukpricedns ;
				break;
			case  "tv":
				$ChargeAmount =  $tvpricedns ;
				break;
			case  "ws":
				$ChargeAmount =  $wspricedns ;
				break;
			case  "in":
				$ChargeAmount =  $inpricedns ;
				break;
			case  "jp":
				$ChargeAmount =  $jppricedns ;
				break;
			case  "tc":
				$ChargeAmount =  $tcpricedns ;
				break;
			case  "vg":
				$ChargeAmount =  $vgpricedns ;
				break;
			case  "ms":
				$ChargeAmount =  $mspricedns ;
				break;
			case  "gs":
				$ChargeAmount =  $gspricedns ;
				break;
			case  "name":
				$ChargeAmount =  $namepricedns ;
				break;
			default: //anything not listed will use this price
				$ChargeAmount =  $othertlddns ;
				break;
			}
			$Enom->AddParam ("ChargeAmount", $ChargeAmount) ;
		}
		
		// Now set the password
		$Enom->AddParam( "EmailNotify", "0" );
		$Enom->AddParam( "DomainPassword", $cPW1 );
  		$Enom->AddParam( "EndUserIP", $enduserip );
  		$Enom->AddParam( "command", "PurchaseHosting" );
  		$Enom->DoTransaction();
		
  		if ( $Enom->Values[ "ErrCount" ] == "0" ) {
  			$bError = 0;
			$_SESSION['OrderID'] = $Enom->Values[ "OrderID" ];
			$OrderID = $Enom->Values[ "OrderID" ];
			$_SESSION['userpassword'] = $cPW1;
			$_SESSION['LoggedIn'] = 1;
			$_SESSION['tld'] = $tld;
			$_SESSION['sld'] =  $sld;
				if ($UseEmail == "1") {
					$myname = "admin"; 
					$myemail = "admin@enomitron.com"; 
					$myURL = "www.enomitron.com";
					$mysig = "Your Name";
					
					$contactname = $HTTP_POST_VARS[ "RegistrantFirstName" ]; 
					$contactemail = $HTTP_POST_VARS[ "RegistrantEmailAddress" ]; 
					$subject = "Congratulations, your name is now registered"; 
					$message = "Congratulations, you have purchased DNS Hosting for $sld.$tld.\nYour password is : $cPW1\n\n";
					$message .= "Your OrderID is : $OrderID\n\n";
					$message .= "Please go to $myURL to login and configure your new domain name\n";
					$message .= "You can also return anytime to manage your domain name\n\n";
					$message .= "Sincerely,\n\n$mysig";
					$headers .= "From: " . $myname." <" . $myemail . ">\r\n";
					$headers .= "Reply-To: " . $myname. " <" . $myemail . ">\r\n";
					mail($contactemail, $subject, $message, $headers);
				}
				// Redirect to a success page
				header ("Location: Success.php");
				exit;
		} else {
  			$cErrorMsg = $Enom->Values[ "Err1" ];
  			$bError = 1;
			}
  		}
	}
	$PageName= "RegisterName";
	$PageTitle = $SiteTitle . " - Register your domain name";
	include('include/header.php'); 
?>
<tr> 
	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
		<form method="post" action="<?php echo "DnsHosting.php?sld=$sld&tld=$tld";?>" id="form1" name="form1">
		<input type="hidden" name="action" value="register">
		  <?
		  	if ( $cAction == "register" ) {
				if ($bError == 1 OR $bRegistered == 0)
				{
					include ('include/RegistrationError.php');
				} 
			}
			?>
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Register 
			  Your Domain (Note: all required fields have a red star *)</span></td>
		  </tr>
		  <tr> 
			<td height="5" colspan="4" class="tdcolorone">&nbsp;</td>
		  </tr>
		  <tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" class="row1">Domain&nbsp;name:&nbsp;</td>
			<td width="50%" valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input disabled type="text" name="sld" id="sld2" maxlength="256" value="<?php echo "$sld.$tld"; ?>"> 
			  <br>
			  &nbsp;<a href="index.php" class="style1">Click here to choose a different domain name</a></td>
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
			  <input type="password" name="password2" id="password22" maxlength="60" value="<?php echo $HTTP_POST_VARS[ "password2" ]?>">
			  </b></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
		  </tr>
		  <tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%"  class="row1"><b class="red">*</b>Period&nbsp;to&nbsp;Register:&nbsp;</td>
			<td width="50%" valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <select name="NumYears">
				<?php
					if ($tld == "nu") {
						$nyts = 2;
					} else {
						$nyts = 1;
					}
					// Display option list
					for ( $i = $nyts; $i <= 10; $i++ ) {
					// Output option tag
					echo "<option ";
					// Is this one selected?
					if ( $HTTP_POST_VARS[ "NumYears" ] == $i ) {
					// Yes, output selected attribute
					echo "selected ";
					}
					// End the tag
					echo ">" . $i . "</option>";
					}
				?>
			  </select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
		  </tr>
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		  </tr>
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;Registrant&nbsp;&nbsp;Information</span></td>
		  </tr>
		  <tr> 
			<td height="5" colspan="4" class="tdcolorone">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>First&nbsp;Name:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantFirstName" id="RegistrantFirstName" maxlength="60"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantFirstName" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Last&nbsp;Name:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantLastName" id="RegistrantLastName" maxlength="60"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantLastName" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Job&nbsp;Title:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantJobTitle" id="RegistrantJobTitle" maxlength="60"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantJobTitle" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Organization&nbsp;Name:</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantOrganizationName" id="RegistrantOrganizationName" maxlength="60"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantOrganizationName" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Address1:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantAddress1" id="RegistrantAddress1" maxlength="60"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantAddress1" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1">&nbsp;&nbsp;Address2:</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantAddress2" id="RegistrantAddress2" maxlength="60"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantAddress2" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>City:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantCity" id="RegistrantCity" maxlength="60"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantCity" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"> 
			  <?php
	$strStateValue = trim( $HTTP_POST_VARS[ "RegistrantState" ] );
	?>
			  US State&nbsp;&nbsp; <input type="radio" value="S" id="radio" name="RegistrantStateProvinceChoice"
	<?php if ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "State" || $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "" ) { echo "checked"; }?>
	onClick="fnRegistrantStateSelected()"></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <select name="RegistrantState" id="select" size="1">
				<?php include( "include/StateList.php" ); ?>
			  </select></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1">Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="RegistrantStateProvinceChoice" id="radio2" <?php if ( $AuxBillingStateProvinceChoice == "Province" ) { echo "checked"; } ?> onClick="fnRegistrantProvinceSelected()"></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantProvince" id="RegistrantProvince" maxlength="60"
	value="<?php if ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "Province") { echo $strStateValue; } ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1">Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="RegistrantStateProvinceChoice" id="radio3" <?php if ($HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "Blank") { echo "checked"; }?> onClick="fnRegistrantNoneSelected()"></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;(the state/province field 
			  will be left blank) <b class="red"></b></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Postal/ZIP&nbsp;Code:&nbsp;&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantPostalCode" id="RegistrantPostalCode" maxlength="15"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantPostalCode" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Country:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <select name="RegistrantCountry" id="idRegistrantCountry">
				<option selected value="<?php echo $RegistrantCountry; ?>"><?php echo $RegistrantCountry; ?> 
				</option>
				<?php include( "include/country.php" ); ?>
			  </select></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Fax:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantFax" id="RegistrantFax" maxlength="20"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantFax" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Phone:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantPhone" id="RegistrantPhone" maxlength="20"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantPhone" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Email&nbsp;Address:&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input type="text" name="RegistrantEmailAddress" id="RegistrantEmailAddress" maxlength="128"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantEmailAddress" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
			<?php 
			if( $tld=="us" ) { 
			include "include/nexus.php";
			}
			else if ( $tld=="ca" ) { 
			include "include/ca.php";
			}
			else if ( $tld=="name" ) { 
			include "include/dotname.php";
			}
			else if ( $tld=="co.uk" ) { 
			include "include/uk.php";
			}
			else if ( $tld=="org.uk" ) { 
			include "include/uk.php";
			}
			?>
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		  </tr>
	<? 
	if ($UseCreditCard == "1") {
		include ('include/creditcard.php');
	}
	?>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1" colspan="2" align="center">&nbsp;<input type="image" src="images/btn_submit.gif" border="0" WIDTH="74" HEIGHT="22">
	&nbsp;<a href="/" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
			<td align="center" valign="middle" noWrap class="row1">&nbsp;</td>
		  </tr>
		</form>
	</table>

	</td>
</tr>
<? include('include/footer.php'); ?>