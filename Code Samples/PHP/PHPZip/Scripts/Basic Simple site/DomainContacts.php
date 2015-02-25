<?php
$RegStatus = $_SESSION['RegStatus'];
	if($RegStatus == 1){
	$Link = 'DomainMain.php';
	} elseif($RegStatus == 0){
	$Link = 'DomainMainHosted.php';
	}

		include( "include/sessions.php" );
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
	include( "include/LoggedIn.php" );
	include( "include/EnomInterface_inc.php" );
	
	// Get URL Interface object
	$Enom = new CEnomInterface;

	if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
		// Modify contact information

		// Set TLD and SLD of domain to register
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );

		// Set account username and password
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
		
		//This is set up to send all four sets of contact data
		$contacttype = array("Registrant","Admin","Tech","AuxBilling");
		
		for ($i=0;$i<=3;$i++) {
			if ($HTTP_POST_VARS[  "Opt" . $contacttype[$i] ] == "UseRegistrant") {
				// Fill in $contacttype[$i] contact information
				$Enom->AddParam( $contacttype[$i] . "EmailAddress", $HTTP_POST_VARS[ $contacttype[0] . "EmailAddress" ] );
				$Enom->AddParam( $contacttype[$i] . "Fax", $HTTP_POST_VARS[ $contacttype[0] . "Fax" ] );
				$Enom->AddParam( $contacttype[$i] . "Phone", $HTTP_POST_VARS[ $contacttype[0] . "Phone" ] );
				$Enom->AddParam( $contacttype[$i] . "Country", $HTTP_POST_VARS[ $contacttype[0] . "Country" ] );
				$Enom->AddParam( $contacttype[$i] . "PostalCode", $HTTP_POST_VARS[ $contacttype[0] . "PostalCode" ] );
				if ( $HTTP_POST_VARS[ $contacttype[0] . "StateProvince" ] == "S" ) {
					$Enom->AddParam( $contacttype[$i] . "StateProvinceChoice", "S" );
					$Enom->AddParam( $contacttype[$i] . "StateProvince", $HTTP_POST_VARS[ $contacttype[0] . "State" ] );
				} else if ( $HTTP_POST_VARS[ $contacttype[0] . "StateProvince" ] == "P" ) {
					$Enom->AddParam( $contacttype[$i] . "StateProvinceChoice", "P" );
					$Enom->AddParam( $contacttype[$i] . "StateProvince", $HTTP_POST_VARS[ $contacttype[0] . "Province" ] );
				} else {
					$Enom->AddParam( $contacttype[$i] . "StateProvinceChoice", "Blank" );
					$Enom->AddParam( $contacttype[$i] . "StateProvince", "" );
				}
				$Enom->AddParam( $contacttype[$i] . "City", $HTTP_POST_VARS[ $contacttype[0] . "City" ] );
				$Enom->AddParam( $contacttype[$i] . "Address2", $HTTP_POST_VARS[ $contacttype[0] . "Address2" ] );
				$Enom->AddParam( $contacttype[$i] . "Address1", $HTTP_POST_VARS[ $contacttype[0] . "Address1" ] );
				$Enom->AddParam( $contacttype[$i] . "LastName", $HTTP_POST_VARS[ $contacttype[0] . "LastName" ] );
				$Enom->AddParam( $contacttype[$i] . "FirstName", $HTTP_POST_VARS[ $contacttype[0] . "FirstName" ] );
				$Enom->AddParam( $contacttype[$i] . "JobTitle", $HTTP_POST_VARS[ $contacttype[0] . "JobTitle" ] );
				$Enom->AddParam( $contacttype[$i] . "OrganizationName", $HTTP_POST_VARS[ $contacttype[0] . "OrganizationName" ] );
				
			} else {
				// Fill in $contacttype[$i] contact information
				$Enom->AddParam( $contacttype[$i] . "EmailAddress", $HTTP_POST_VARS[ $contacttype[$i] . "EmailAddress" ] );
				$Enom->AddParam( $contacttype[$i] . "Fax", $HTTP_POST_VARS[ $contacttype[$i] . "Fax" ] );
				$Enom->AddParam( $contacttype[$i] . "Phone", $HTTP_POST_VARS[ $contacttype[$i] . "Phone" ] );
				$Enom->AddParam( $contacttype[$i] . "Country", $HTTP_POST_VARS[ $contacttype[$i] . "Country" ] );
				$Enom->AddParam( $contacttype[$i] . "PostalCode", $HTTP_POST_VARS[ $contacttype[$i] . "PostalCode" ] );
				if ( $HTTP_POST_VARS[ $contacttype[$i] . "StateProvince" ] == "S" ) {
					$Enom->AddParam( $contacttype[$i] . "StateProvinceChoice", "S" );
					$Enom->AddParam( $contacttype[$i] . "StateProvince", $HTTP_POST_VARS[ $contacttype[$i] . "State" ] );
				} else if ( $HTTP_POST_VARS[ $contacttype[$i] . "StateProvince" ] == "P" ) {
					$Enom->AddParam( $contacttype[$i] . "StateProvinceChoice", "P" );
					$Enom->AddParam( $contacttype[$i] . "StateProvince", $HTTP_POST_VARS[ $contacttype[$i] . "Province" ] );
				} else {
					$Enom->AddParam( $contacttype[$i] . "StateProvinceChoice", "Blank" );
					$Enom->AddParam( $contacttype[$i] . "StateProvince", "" );
				}
				$Enom->AddParam( $contacttype[$i] . "City", $HTTP_POST_VARS[ $contacttype[$i] . "City" ] );
				$Enom->AddParam( $contacttype[$i] . "Address2", $HTTP_POST_VARS[ $contacttype[$i] . "Address2" ] );
				$Enom->AddParam( $contacttype[$i] . "Address1", $HTTP_POST_VARS[ $contacttype[$i] . "Address1" ] );
				$Enom->AddParam( $contacttype[$i] . "LastName", $HTTP_POST_VARS[ $contacttype[$i] . "LastName" ] );
				$Enom->AddParam( $contacttype[$i] . "FirstName", $HTTP_POST_VARS[ $contacttype[$i] . "FirstName" ] );
				$Enom->AddParam( $contacttype[$i] . "JobTitle", $HTTP_POST_VARS[ $contacttype[$i] . "JobTitle" ] );
				$Enom->AddParam( $contacttype[$i] . "OrganizationName", $HTTP_POST_VARS[ $contacttype[$i] . "OrganizationName" ] );
			}
		}
		
		//Nexus info if sent
		if ($tld =="us") {
			$nexus = $HTTP_POST_VARS[ "NexusCategory" ];
			$countrycode = $HTTP_POST_VARS[ "NexusCountry" ];
			$appendednexus = $nexus . "/" . $countrycode;
			$purpose = $HTTP_POST_VARS[ "AppPurpose" ];
			
			switch ($nexus) {
				case "c11":
				$Enom->AddParam( "Nexus", $nexus );
				echo $nexus;
				break;
				
				case "c12":
				$Enom->AddParam( "Nexus", $nexus );
				echo $nexus;
				break;
				
				case "c21":
				$Enom->AddParam( "Nexus", $nexus );
				echo $nexus;
				break;
				
				default:
				$Enom->AddParam( "Nexus", $appendednexus);
				break;
			}
		
			$Enom->AddParam( "Purpose", $purpose );
		}
				
		//Nexus info if sent
		if ($tld =="ca") {
			$Enom->AddParam( "cira_legal_type", $cira_legal_type );
		}  
				
		//Add IP address of end user
  		$Enom->AddParam( "EndUserIP", $enduserip );
		
		// Modify contacts
		$Enom->AddParam( "command", "contacts" );
		$Enom->DoTransaction();
	
		// Get number of errors
		$nNumErrors = $Enom->Values[ "ErrCount" ];
	
		if ( $nNumErrors > 0 ) {
			
			// Loop through all errors and print them out
			for ( $i = 1; $i <= $nNumErrors; $i++ ) {
				echo "$i) {$Enom->Values[ "Err" . $i ]}<br />";
			// There were errors
			echo "There were errors:<br />";
			}
		} else {
			// No errors, success
			header ("Location: DomainMain.php");
			exit;
		}
	}
	
		// Get all the contact information
  	$Enom->NewRequest();
	
	// Set TLD and SLD of domain to register
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );

	// Set account username and password
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	
	// Get contacts
	$Enom->AddParam( "command", "getcontacts" );
	$Enom->DoTransaction();
	
	// Get number of errors
	$nNumErrors = $Enom->Values[ "ErrCount" ];
	
	// Get all the contact information
  	$Enom->NewRequest();
	
	// Set TLD and SLD of domain to register
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );

	// Set account username and password
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	
	// Get contacts
	$Enom->AddParam( "command", "getcontacts" );
	$Enom->DoTransaction();
	
	// Get number of errors
	$nNumErrors = $Enom->Values[ "ErrCount" ];
	
	if ( $nNumErrors > 0 ) {
		// There were errors
		echo "There were errors:<br />";
			
		// Loop through all errors and print them out
		for ( $i = 1; $i <= $nNumErrors; $i++ ) {
			echo"$i) {$Enom->Values[ "Err" . $i ]}<br />";
		}
	} else {
		// Get values from Enom object and put into vars
		include( "include/Enom2HTML_inc.php" );
	}

	//Page name - DO NOT CHANGE
	$PageName = "DomainContacts";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Success! Your name has been registered.";

	//This file must be inluded.
	include('include/header.php'); 
	
	// Begin page content
?>
<tr> 
	<td class="OutlineOne">
		<table align="center" class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0">
      <form method="post" action="DomainContacts.php" NAME="form1" id="form1" onSubmit="return CheckFields()">
        <input type="hidden" name="action" id="idName" value="modify">
        <!-- required for js page validation -->
        <input type="hidden" name="CallingAppl" id="idCallingAppl" value="Access">
        <? //  Registrant Contact section ?>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Domain 
            Contact Information For:&nbsp;<strong><?php echo "$sld.$tld"; ?></strong></span></td>
        </tr>
        <tr> 
          <td colspan="4" align="center" valign="middle" class="row2"><span class=red>Note: 
            all required fields have a red star *.</span></td>
        </tr>
        <tr> 
          <td class="tdcolorone" height="5">&nbsp;</td>
          <td width="40%" height="5" class="tdcolorone"><span class=cattitle>Registrant&nbsp;&nbsp;Contact</span></td>
          <td class="rowpic" align="right" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantOrganizationName" id="idRegistrantOrg"
				value="<?php echo $RegistrantOrganizationName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Job Title:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantJobTitle" id="idRegistrantJobTitle"
				value="<?php echo $RegistrantJobTitle; ?>"></td>
          <td valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantFirstName" id="idRegistrantFName"
				value="<?php echo $RegistrantFirstName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantLastName" id="idRegistrantLName"
				value="<?php echo $RegistrantLastName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantAddress1" id="idRegistrantAddress"
				value="<?php echo $RegistrantAddress1; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantCity" id="idRegistrantCity"
				value="<?php echo $RegistrantCity; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $RegistrantStateProvince );
				?>
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idRegistrantStateProvince" name="RegistrantStateProvince" 
				<?php if ($RegistrantStateProvinceChoice == "S" || $RegistrantStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnRegistrantStateSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="RegistrantState" id="idRegistrantState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="RegistrantStateProvince" id="idRegistrantStateProvince" <?php if ( $RegistrantStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnRegistrantProvinceSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" name="RegistrantProvince" id="idRegistrantProvince" maxlength="60"
				value="<?php if ($RegistrantStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="RegistrantStateProvince" id="idRegistrantStateProvince" <?if ($RegistrantStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnRegistrantNoneSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="15" name="RegistrantPostalCode" id="idRegistrantZip" value="<?php echo $RegistrantPostalCode; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="RegistrantCountry" id="idRegistrantCountry">
              <option selected value="<?php echo $RegistrantCountry; ?>"><?php echo $RegistrantCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantPhone" id="idRegistrantPhone"
				value="<?php echo $RegistrantPhone; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Fax:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantFax" id="idRegistrantFax"
				value="<?php echo $RegistrantFax; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="128" name="RegistrantEmailAddress" id="idRegistrantEmail"
				value="<?php echo $RegistrantEmailAddress; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td colspan="4" valign="middle" class="row1">&nbsp;</td>
        </tr>
        <? //  Us or CA section ?>
        <?php 
			//If .us name is chosen, this section will be shoen
			
			if( $tld=="us" ) { 
			include "include/nexus.php";
			}
			else if ( $tld=="ca" ) { 
			include "include/ca.php";
			}
			?>
        <? //  Admin Contact section ?>
        <tr> 
          <td colspan="4" valign="middle" class="titlepic">&nbsp;</td>
        </tr>
        <tr> 
          <td class="tdcolorone" height="5">&nbsp;</td>
          <td width="40%" height="5" class="tdcolorone"><span class=cattitle>Administrator&nbsp;&nbsp;Contact</span></td>
          <td class="rowpic" align="right" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5%" valign="middle" class="row1">&nbsp;</td>
          <td width="40%" valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="radio" name="OptAdmin" id="idOptAdmin" value="UseRegistrant" onclick="AdminUseRegistrantInfo()">
            Use the Registrant Information (Above)<br /> &nbsp;&nbsp; <input type="radio" name="OptAdmin" id="idOptAdmin" value="UseExisting" onclick="EnableAdmin(true)" checked>
            Use the following Information<br /></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminOrganizationName" id="idAdminOrg"
				value="<?php echo $AdminOrganizationName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Job&nbsp;Title:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminJobTitle" id="idAdminJobTitle"
				value="<?php echo $AdminJobTitle; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminFirstName" id="idAdminFName"
				value="<?php echo $AdminFirstName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminLastName" id="idAdminLName"
				value="<?php echo $AdminLastName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminAddress1" id="idAdminAddress"
				value="<?php echo $AdminAddress1; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminCity" id="idAdminCity"
				value="<?php echo $AdminCity; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $AdminStateProvince );
				?>
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idAdminStateProvince" name="AdminStateProvince" 
				<?php if ($AdminStateProvinceChoice == "S" || $AdminStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnAdminStateSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="AdminState" id="idAdminState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="AdminStateProvince" id="idAdminStateProvince" <?php if ( $AdminStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnAdminProvinceSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" name="AdminProvince" id="idAdminProvince" maxlength="60"
				value="<?php if ($AdminStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="AdminStateProvince" id="idAdminStateProvince" <?php if ($AdminStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnAdminNoneSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="15" name="AdminPostalCode" id="idAdminZip" value="<?php echo $AdminPostalCode; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="AdminCountry" id="idAdminCountry">
              <option selected value="<?php echo $AdminCountry; ?>"><?php echo $AdminCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="AdminPhone" id="idAdminPhone"
				value="<?php echo $AdminPhone; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Fax:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="AdminFax" id="idAdminFax"
				value="<?php echo $AdminFax; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="128" name="AdminEmailAddress" id="idAdminEmail"
				value="<?php echo $AdminEmailAddress; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td colspan="4" valign="middle" class="row1">&nbsp;</td>
        </tr>
        <? //  Technical Contact section ?>
        <tr> 
          <td colspan="4" valign="middle" class="titlepic">&nbsp;</td>
        </tr>
        <tr> 
          <td class="tdcolorone" height="5">&nbsp;</td>
          <td width="40%" height="5" class="tdcolorone"><span class=cattitle>Technical&nbsp;&nbsp;Contact</span></td>
          <td class="rowpic" align="right" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5%" valign="middle" class="row1">&nbsp;</td>
          <td width="40%" valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="radio" name="OptTech" id="idOptTechnical" value="UseRegistrant" onclick="TechUseRegistrantInfo()">
            Use the Registrant Information (Above)<br /> &nbsp;&nbsp; <input type="radio" name="OptTech" id="idOptTechnical" value="UseExisting" onclick="EnableTechnicalContact(true)" checked>
            Use the following Information<br /></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="TechOrganizationName" id="idTechOrg"
				value="<?php echo $TechOrganizationName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Job&nbsp;Title:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="TechJobTitle" id="idTechJobTitle"
				value="<?php echo $TechJobTitle; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="TechFirstName" id="idTechFName"
				value="<?php echo $TechFirstName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="TechLastName" id="idTechLName"
				value="<?php echo $TechLastName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="TechAddress1" id="idTechAddress"
				value="<?php echo $TechAddress1; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="TechCity" id="idTechCity"
				value="<?php echo $TechCity; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $TechStateProvince );
				?>
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idTechStateProvince" name="TechStateProvince" 
				<?php if ($TechStateProvinceChoice == "S" || $TechStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnTechStateSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="TechState" id="idTechState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="TechStateProvince" id="idTechStateProvince" <?php if ( $TechStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnTechProvinceSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" name="TechProvince" id="idTechProvince" maxlength="60"
				value="<?php if ($TechStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="TechStateProvince" id="idTechStateProvince" <?php if ($TechStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnTechNoneSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="15" name="TechPostalCode" id="idTechZip" value="<?php echo $TechPostalCode; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="TechCountry" id="idTechCountry">
              <option selected value="<?php echo $TechCountry; ?>"><?php echo $TechCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="TechPhone" id="idTechPhone"
				value="<?php echo $TechPhone; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Fax:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="TechFax" id="idTechFax"
				value="<?php echo $TechFax; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="128" name="TechEmailAddress" id="idTechEmail"
				value="<?php echo $TechEmailAddress; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td colspan="4" valign="middle" class="row1">&nbsp;</td>
        </tr>
        <? //  AuxBilling Contact section ?>
        <tr> 
          <td colspan="4" valign="middle" class="titlepic">&nbsp;</td>
        </tr>
        <tr> 
          <td class="tdcolorone" height="5">&nbsp;</td>
          <td width="40%" height="5" class="tdcolorone"><span class=cattitle>Auxillary 
            Billing&nbsp;&nbsp;Contact</span></td>
          <td class="rowpic" align="right" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5%" valign="middle" class="row1">&nbsp;</td>
          <td width="40%" valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="radio" name="OptAuxBilling" id="idOptAuxBilling" value="UseRegistrant" onclick="AuxUseRegistrantInfo()">
            Use the Registrant Information (Above)<br /> &nbsp;&nbsp; <input type="radio" name="OptAuxBilling" id="idOptAuxBilling" value="UseExisting" onclick="EnableAuxBilling(true)" checked>
            Use the following Information<br /></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingOrganizationName" id="idAuxBillingOrg"
				value="<?php echo $AuxBillingOrganizationName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Job Title:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingJobTitle" id="idAuxBillingJobTitle"
				value="<?php echo $AuxBillingJobTitle; ?>"></td>
          <td valign="middle" noWrap class="row2">&nbsp;</td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingFirstName" id="idAuxBillingFName"
				value="<?php echo $AuxBillingFirstName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingLastName" id="idAuxBillingLName"
				value="<?php echo $AuxBillingLastName; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingAddress1" id="idAuxBillingAddress"
				value="<?php echo $AuxBillingAddress1; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingCity" id="idAuxBillingCity"
				value="<?php echo $AuxBillingCity; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $AuxBillingStateProvince );
				?>
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idAuxBillingStateProvince" name="AuxBillingStateProvince" 
				<?php if ($AuxBillingStateProvinceChoice == "S" || $AuxBillingStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnAuxBillingStateSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="AuxBillingState" id="idAuxBillingState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="AuxBillingStateProvince" id="idAuxBillingStateProvince" <?php if ( $AuxBillingStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnAuxBillingProvinceSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" name="AuxBillingProvince" id="idAuxBillingProvince" maxlength="60"
				value="<?php if ($AuxBillingStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="AuxBillingStateProvince" id="idAuxBillingStateProvince" <?php if ($AuxBillingStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnAuxBillingNoneSelected()"></td>
          <td valign="middle" class="row2">&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="15" name="AuxBillingPostalCode" id="idAuxBillingZip" value="<?php echo $AuxBillingPostalCode; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <select name="AuxBillingCountry" id="idAuxBillingCountry">
              <option selected value="<?php echo $AuxBillingCountry; ?>"><?php echo $AuxBillingCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="AuxBillingPhone" id="idAuxBillingPhone"
				value="<?php echo $AuxBillingPhone; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1">Fax:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="20" name="AuxBillingFax" id="idAuxBillingFax"
				value="<?php echo $AuxBillingFax; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td valign="middle" class="row1">&nbsp;</td>
          <td valign="middle" class="row1"><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" class="row2">&nbsp;&nbsp; <input type="text" maxlength="128" name="AuxBillingEmailAddress" id="idAuxBillingEmail"
				value="<?php echo $AuxBillingEmailAddress; ?>"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td colspan="4" valign="middle" class="row1">&nbsp;</td>
        </tr>
        <? // Apply changes section ?>
        <tr> 
          <td colspan="4" valign="middle" class="titlepic">&nbsp;</td>
        </tr>
        <tr> 
          <td class="tdcolorone" height="5">&nbsp;</td>
          <td width="40%" height="5" class="tdcolorone"><span class=cattitle>&nbsp;Apply&nbsp;&nbsp;Changes</span></td>
          <td class="rowpic" align="right" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5%" valign="middle" class="row1">&nbsp;</td>
          <td width="40%" valign="middle" class="row1"><span class="main">Click 
            here to apply your changes.</span></td>
          <td width="50%" valign="middle" class="row2">&nbsp;&nbsp; <input type="hidden" value="FullForm" name="FormType"> 
            <input type="image" name="image" src="images/btn_submit.gif" WIDTH="79" HEIGHT="25" border="0"></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td width="5%" valign="middle" class="row1">&nbsp;</td>
          <td width="40%" valign="middle" class="row1"><span class="main">Click 
            here to cancel</span></td>
          <td width="50%" valign="middle" class="row2">&nbsp;&nbsp;&nbsp;<a href="<?=$Link;?>"><img src="images/btn_cancel.gif" border="0" WIDTH="74" HEIGHT="22"></a></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td width="5%" valign="middle" class="row1">&nbsp;</td>
          <td width="40%" valign="middle" class="row1"><span class="main">Click 
            here to reset this form</span></td>
          <td width="50%" valign="middle" class="row2">&nbsp;&nbsp;&nbsp;<a href="javascript:document.forms.form1.reset()"><img src="images/btn_reset.gif" width="74" height="22" border="0"></a></td>
          <td width="5%" valign="middle" noWrap class="row2"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <tr> 
          <td colspan="4" valign="middle" class="row1">&nbsp;</td>
        </tr>
      </form>
      <!-- end of page content -->
    </table>
	</td>
</tr>
		  
	<? include('include/footer.php'); ?>