<?php
	require("include/sessions.php");
	require( "include/EnomInterface_inc.php" );
	
		if($_POST["method"] == ""){
			$tld = $_COOKIE["enomtld"];
			$sld = $_COOKIE["enomsld"];
			$method = $_COOKIE["enommethod"];
			$refer = $_SESSION['Referer'] = 'ppsuccess';
			$success = $_SESSION['success'] = '1';
			$price = $_COOKIE['enomprice'];
			
			if(($refer != 'ppsuccess') ||($success != '1')) {
				$formoptions = "sld=$sld&tld=$tld";
				header ("Location: PayForName.php?$formoptions");
				exit;
			}
			
		} else {
			$method = $_POST['method'];
			$tld = $_POST["tld"];
			$sld = $_POST["sld"];
		}
	
	
	$price = ($regprice * $numyears);
	$_SESSION["price"] = $price;
	
	if((empty($method)) || ($method == ""))
		{
			header ("Location: Check.php");
			exit;
		}
	
	$cAction = $HTTP_POST_VARS[ "cAction" ];
	$cPW1 = $HTTP_POST_VARS[ "password1" ];
	$cPW2 = $HTTP_POST_VARS[ "password2" ];
	$bError = 0;
	$bAvailable = 0;

	// Do we need to register a name?
	if ( $cAction == "register" ) {
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
		
  		$Enom = new CEnomInterface;
  		
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
  		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "sld", $sld );
  		$Enom->AddParam( "enduserip", $enduserip );
  		$Enom->AddParam( "site", "Enomitron-php" );
  		
  		// Set number of years to register
  		if ( $HTTP_POST_VARS[ "NumYears" ] != "" ) {
  			$Enom->AddParam( "RegisterYears", $HTTP_POST_VARS[ "NumYears" ] );
  		}

  		// Do they want to use default (eNom) nameservers?
  		if ( $HTTP_POST_VARS[ "UseNameserver" ] == "default" ) {
  			// Yes, use default eNom nameservers
  			$Enom->AddParam( "UseDNS", "default" );
  		} else {
  			// They want to use their own nameservers
  			for ( $iNameServer = 1; $iNameServer < 4; $iNameServer++ ) {
  				if ( $HTTP_POST_VARS[ "NameServer" . $iNameServer ] != "" ) {
  					$Enom->AddParam( "NS" . $iNameServer, $HTTP_POST_VARS[ "NameServer" . $iNameServer ] );
  				}
  			}
  		}
		
		//#####################################################################
		
		// Or, you can cut out the DNS completely and simply send in your DNS or eNoms
		// Remember to remove the FORM section for DNS entry if you do this
		
		//For eNom DNS only
		//$Enom->AddParam( "UseDNS", "default" );
		
		// For JUST your DNS, Add nameserver info
		//$Enom->AddParam( "NS1", "yourDNS.yourDomain.com" );
		//$Enom->AddParam( "NS2", "yourDNS.yourDomain.com" );
		//$Enom->AddParam( "NS3", "yourDNS.yourDomain.com" );
		//$Enom->AddParam( "NS4", "yourDNS.yourDomain.com" );
		//$Enom->AddParam( "NS5", "yourDNS.yourDomain.com" );
		//$Enom->AddParam( "NS6", "yourDNS.yourDomain.com" );
		
		//#####################################################################

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
		
		$cira_legal_type = $HTTP_POST_VARS['cira_legal_type'];
		$cira_registrant = $HTTP_POST_VARS['cira_registrant'];
		$cira_registrant_desc = $HTTP_POST_VARS['cira_registrant_desc'];
		$cira_trademark_no = $HTTP_POST_VARS['cira_trademark_no'];
		$cira_org_registered_in = $HTTP_POST_VARS['cira_org_registered_in'];
		
			$Enom->AddParam( "cira_legal_type", $cira_legal_type );
			$Enom->AddParam( "cira-registrant", $cira_registrant );
			$Enom->AddParam( "cira-registrant-desc", $cira_registrant_desc );
			$Enom->AddParam( "cira-trademark-no", $cira_trademark_no );
			$Enom->AddParam( "cira-org-registered-in", $cira_org_registered_in );
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
		
		//dot name info if sent
		if ($tld == "name") {
			$idforwardOptionYes = $HTTP_POST_VARS[ "idforwardOptionYes" ];
			$forwardmailto = $HTTP_POST_VARS[ "forwardmailto" ];
			$everything = "everything";
			if ($idforwardOptionYes == "yes"){
				$Enom->AddParam( "ForwardName", $everything );
				$Enom->AddParam( "ForwardMailTo", $forwardmailto );	
			}
		}
		
		if ($UseCreditCard == "1") {
			if($method == "creditcard"){
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
				$Enom->AddParam ("ChargeAmount", $_SESSION["enomprice"]);
			}
		}
		
		$Enom->AddParam( "DomainPassword", $cPW1 );
		if ($HTTP_POST_VARS[ "UnLockRegistrar" ] == "ON") {
			$Enom->AddParam( "UnLockRegistrar", "0" );
		}
		
  		$Enom->AddParam( "command", "purchase" );
  		$Enom->DoTransaction();
  		
		#-- Debug Section
		# Do not uncomment these lines if you are in production or anyone else can view your site
		# It will reveal your enom username and password to visitors.
		# Only use if you need to see the post string or raw response this page is sending / recieving
		
		#
		#echo $Enom->PostString.'<br>';
		#foreach ($Enom->Values as $key => $value)
		#{
		#	echo("$key = \"$value\"<BR/>\r\n");
		#}
  		#-- End Debug Section
		
  		// Were there errors?
  		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
  			// Yes, get the first one
  			$cErrorMsg = $Enom->Values[ "Err1" ];
  			
  			// Flag an error
  			$bError = 1;
  		} else {
  			// No interface errors
  			$bError = 0;
  			
  			// Check code from NSI (200 = name registered)
  			switch ( $Enom->Values[ "RRPCode" ] ) {
  			case "200":
			// The name was registered
  			$bRegistered = 1;

			//**************************************************************************************
			// At this point, you need to charge your client's credit card using eNom CC processing
			//*************************************************************************************
  				
			// Set the session vars
				
			//register OrderID and retrieve it from HTTP VARS
			$_SESSION['OrderID'] = $Enom->Values[ "OrderID" ];
			$OrderID = $Enom->Values[ "OrderID" ];
			$_SESSION['userpassword'] = $cPW1;
			$_SESSION['LoggedIn'] = 1;
			$_SESSION['tld'] = $tld;
			$_SESSION['sld'] =  $sld;
			
			//email info sent to registrant
			
			if ($UseEmail == "1") {
				$contactname = $HTTP_POST_VARS[ "RegistrantFirstName" ] . ' ' . $HTTP_POST_VARS[ "RegistrantLastName" ] ; 
				$contactemail = $HTTP_POST_VARS[ "RegistrantEmailAddress" ]; 
				require("include/class.phpmailer.php");
				
				$mail = new PHPMailer();
				$mail->From = $YourEmailAddress; //mail from
				$mail->FromName = $Yourname;
				$mail->Host = $MailServer; //mail server 
				$mail->Mailer = "smtp"; // mail server type
				
				$mail->SMTPAuth = true; // turn on SMTP authentication
				$mail->Username = $MailUsername; // SMTP username
				$mail->Password = $MailPassword; // SMTP password
				
				$mail->AddAddress($contactemail, $contactname);
				$mail->AddReplyTo($YourEmailAddress, $Yourname);
				
				$mail->WordWrap = 50; // set word wrap to 50 characters
				$mail->IsHTML($mailtypetosend); // True for HTML, FALSE for plain text
				$mail->SetLanguage("en", "include/language/");
				
				$mail->Subject = "Congratulations, your name is now registered"; 
				
				if(strtolower($MailType) == 'html'){
					$mail->Body = "Congratulations $contactname, <br /><br />You have registered $sld.$tld.<br /><br />Your password is : $cPW1<br /><br />";
					$mail->Body .= "The total amount of your order is: $price<br />";
					$mail->Body .= "Your OrderID is : $OrderID<br /><br />";
					$mail->Body .= "Please go to $myURL to login and configure your new domain name<br />";
					$mail->Body .= "You can also return anytime to manage your domain name<br /><br />";
					$mail->Body .= "Sincerely,<br /><br />$Yourname";
				} else {
					$mail->Body = "Congratulations $contactname, \nYou have registered $sld.$tld.\nYour password is : $cPW1\n\n";
					$mail->Body .= "The total amount of your order is: $price\n";
					$mail->Body .= "Your OrderID is : $OrderID\n\n";
					$mail->Body .= "Please go to $myURL to login and configure your new domain name\n";
					$mail->Body .= "You can also return anytime to manage your domain name\n\n";
					$mail->Body .= "Sincerely,\n\n$Yourname";
				}

				if(!$mail->Send())
				{
				echo "Message could not be sent. <p>";
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit;
				}
			}

			header ("Location: Success.php");
			  exit;
  				break;
  				
  			case "554":
  				// The name is not available (already registered by eNom)
  				$bRegistered = 0;
  				break;

  			case "540":
  				// The name is not available (already registered by another registarar)
  				$bRegistered = 0;
  				break;

  			case "1300":
  				// The UK Domain name was successfully submitted to the registry
  				$bRegistered = 1;
  				break;
  				
  			default:
  				// There was an error from NSI
  				$bError = 1;
  				$cErrorMsg = $Enom->Values[ "RRPText" ];
  				break;
  			}
  		}
		}
	}
	//Page name - DO NOT CHANGE
	$PageName= "RegisterName";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Register your domain name";

	//This file must be inluded.
	include('include/header.php'); 
	
	// Begin page content
?>
<style type="text/css">
<!--
.style1 {font-size: 9px}
-->
</style>


<tr> 
	
  <td class="OutlineOne"> 
  <?php
  if($method == 'paypal'){ ?>
  <table width="720" border="0" align="center" class="tableOO">
      <tr> 
        <td colspan="2" align="center" valign="middle" class="titlepic"><span class="whiteheader">Paypal Payment 
          Accepted </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="2"><div align="center">Your payment using paypal has been 
            approved. <br>
            The last step will be to fill out the registration info below, and 
            submit the order. </div></td>
      </tr>
    </table>
	
<?php } ?>	
<br />
    <table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
      <form method="post" action="<?php echo "RegisterName.php";?>" id="form1" name="form1">
        <input type="hidden" name="sld" value="<?php echo $sld;?>">
        <input type="hidden" name="tld" value="<?php echo $tld;?>">
        <input type="hidden" name="method" value="<?php echo $method;?>">
        <input type="hidden" name="cAction" value="register">
        <?
		  	if ( $cAction == "register" ) {
				if ($bError == 1 OR $bRegistered == 0)
				{
					include ('include/RegistrationError.php');
				} 
			}
			?>
        <!-- this begins section ONE -->
        <tr> 
          <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Register 
            Your Domain (Note: all required fields have a red star *)</span></td>
        </tr>
        <tr> 
          <td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
          <td width="40%" class="row1">Domain&nbsp;name:&nbsp;</td>
          <td width="50%" valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="sld" type="text" disabled id="sld2" value="<?php echo "$sld.$tld"; ?>" size="50" maxlength="256"> 
            <br> <?php if($method != 'paypal') { ?>&nbsp;<a href="index.php" class="style1">Click here to choose 
            a different domain name</a><? } ?></td>
          <td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
        </tr>
        <tr> 
          <td width="5%" valign="middle" class="row1">&nbsp;</td>
          <td width="40%"  class="row1"> <b class="red">*</b>Domain&nbsp;Password:&nbsp;&nbsp;</td>
          <td width="50%" valign="middle" class="row2"><b class="red"> &nbsp;&nbsp;&nbsp; 
            <input name="password1" type="password" value="<?php echo $HTTP_POST_VARS[ "password1" ]?>" size="25"  maxlength="60">
            </b></td>
          <td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
        </tr>
        <tr> 
          <td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
          <td width="40%"  class="row1"><b class="red">*</b>Re-type&nbsp;Password:&nbsp;</td>
          <td width="50%" valign="middle" class="row2"><b class="red">&nbsp;&nbsp;&nbsp; 
            <input name="password2" type="password" id="password22" value="<?php echo $HTTP_POST_VARS[ "password2" ]?>" size="25" maxlength="60">
            </b></td>
          <td width="5%" align="center" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="25" border="0"></td>
        </tr>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;Registrant&nbsp;&nbsp;Information</span></td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>First&nbsp;Name:&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantFirstName" type="text" id="RegistrantFirstName"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantFirstName" ]; ?>" size="40" maxlength="60"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Last&nbsp;Name:&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantLastName" type="text" id="RegistrantLastName"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantLastName" ]; ?>" size="40" maxlength="60"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Job&nbsp;Title: </td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantJobTitle" type="text" id="RegistrantJobTitle"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantJobTitle" ]; ?>" size="40" maxlength="60"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Organization&nbsp;Name:</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantOrganizationName" type="text" id="RegistrantOrganizationName"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantOrganizationName" ]; ?>" size="40" maxlength="60"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Address1:&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantAddress1" type="text" id="RegistrantAddress1"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantAddress1" ]; ?>" size="40" maxlength="60"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1">&nbsp;&nbsp;Address2:</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantAddress2" type="text" id="RegistrantAddress2"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantAddress2" ]; ?>" size="40" maxlength="60"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>City:&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantCity" type="text" id="RegistrantCity"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantCity" ]; ?>" size="40" maxlength="60"></td>
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
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantProvince" type="text" id="RegistrantProvince"
	value="<?php if ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "Province") { echo $strStateValue; } ?>" size="40" maxlength="60"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1">Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="RegistrantStateProvinceChoice" id="radio3" <?php if ($HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "Blank") { echo "checked"; }?> onClick="fnRegistrantNoneSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;(the state/province 
            field will be left blank) <b class="red"></b></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Postal/ZIP&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantPostalCode" type="text" id="RegistrantPostalCode"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantPostalCode" ]; ?>" size="15" maxlength="15"></td>
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
          <td  class="row1">Fax:&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantFax" type="text" id="RegistrantFax"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantFax" ]; ?>" size="20" maxlength="20"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Phone:&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantPhone" type="text" id="RegistrantPhone3"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantPhone" ]; ?>" size="20" maxlength="20"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Email&nbsp;Address:&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp; <input name="RegistrantEmailAddress" type="text" id="RegistrantEmailAddress"
	value="<?php echo $HTTP_POST_VARS[ "RegistrantEmailAddress" ]; ?>" size="40" maxlength="128"></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <!-- this ends section TWO -->
        <?php 
			//If .us name is chosen, this section will be shoen
			
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
        <? 
			//#####################################################################
			
			// Remember to remove this section IF you are simply sending in DNS info
			
			//##################################################################### 
			?>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
        </tr>
        <!-- this begins section THREE -->
        <tr> 
          <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;NameServer&nbsp;&nbsp;Information</span></td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1"><b class="red">*</b>Use:</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;
            <select name="UseNameserver" id="idUseNameserver">
              <option <?php if ( $HTTP_POST_VARS[ "UseNameserver" ] == "default" ) { echo "selected"; } ?> value="default">Our 
              nameservers</option>
              <option <?php if ( $HTTP_POST_VARS[ "UseNameserver" ] == "custom" ) { echo "selected"; } ?> value="custom">Your 
              own nameservers</option>
            </select></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1">Custom&nbsp;NameServers:&nbsp;&nbsp;<br />
            <small>(must select &quot;Your own&nbsp;&nbsp;&nbsp;<br />
            NameServers&quot; above)</small></td>
          <td valign="middle" class="row2"> &nbsp;&nbsp;&nbsp;
            <input name="NameServer1" type="text" id="idnameserver1"
				value="<?php echo $HTTP_POST_VARS[ "NameServer1" ]; ?>" size="40" maxlength="60">
            <br /> &nbsp;&nbsp;&nbsp;
            <input name="NameServer2" type="text" id="idnameserver2"
				value="<?php echo $HTTP_POST_VARS[ "NameServer2" ]; ?>" size="40" maxlength="60">
            <br /> &nbsp;&nbsp;&nbsp;
            <input name="NameServer3" type="text" id="idnameserver3"
				value="<?php echo $HTTP_POST_VARS[ "NameServer3" ]; ?>" size="40" maxlength="60">
            <br /> &nbsp;&nbsp;&nbsp;
            <input name="NameServer4" type="text" id="idnameserver4"
				value="<?php echo $HTTP_POST_VARS[ "NameServer4" ]; ?>" size="40" maxlength="60">
            <br /></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <? 
	if ($UseCreditCard == "1") {
		if($method == "creditcard")
			{
				include ('include/creditcard.php');
			}
	}
	
	?>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;Additional&nbsp;&nbsp;Settings</span></td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td align="right"  class="row1">Do not allow this name to be transferred 
            to another registrar (recommended)</td>
          <td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="UnLockRegistrar" value="ON" checked></td>
          <td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="row1"
		  
<div align="center">By Continuing you are agreeing to the terms listed in the <a onclick="window.open(&quot;agreement.php&quot;,&quot;&quot;,&quot;status=no,scrollbars=1,resizable=1&quot;);return false;" target="_blank" href="agreement.php"><b>Domain name Agreement</b></a></div>		  </td>
        </tr>
        <tr> 
          <td align="center" valign="middle" class="row1">&nbsp;</td>
          <td  class="row1" colspan="2" align="center">&nbsp;
            <input type="image" src="images/btn_submit.gif" border="0" WIDTH="74" HEIGHT="22"> 
            &nbsp;<a href="/" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
          <td align="center" valign="middle" noWrap class="row1">&nbsp;</td>
        </tr>
      </form>
    </table>
	</td>
</tr>

<? include('include/footer.php'); ?>