<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];
if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=change_whois");
	exit(); // Quit the script.
} 

	require( "include/dbconfig.php" );
	require( "include/EnomInterface_inc.php" );

$sld = $_GET["sld"];
$tld = $_GET["tld"];
$command = $_GET["command"];
$action = $HTTP_POST_VARS[ "action" ];

if (($sld == '')||($tld == '')) {
	header ("Location:  $site_url/dmain.php");
	exit(); // Quit the script.
} 

	$Enom = new CEnomInterface;
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "command", "getcontacts" );
	$Enom->DoTransaction();
	
	// Get number of errors
	$nNumErrors = $Enom->Values[ "ErrCount" ];
	
	if ( $nNumErrors > 0 ) {
		// There were errors
		$message .= "There were errors:<br />";
			
		// Loop through all errors and print them out
		for ( $i = 1; $i <= $nNumErrors; $i++ ) {
			$message .= "$i) {$Enom->Values[ "Err" . $i ]}<br />";
		}
	} else {
		// Get values from Enom object and put into vars
		include( "include/Enom2HTML_inc.php" );
	}

	if (($action == "change")||($command == "change")){
	$message = NULL  ;
	
  	$Enom->NewRequest();
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
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
		
		if ($tld =="us") {
					$AppPurpose = $_POST['AppPurpose'];
					$NexusCategory = $_POST['NexusCategory'];
					$NexusCountry = $_POST['NexusCountry'];
			$Enom->AddParam( "us_nexus", $NexusCategory );
			$Enom->AddParam( "global_cc_us", $NexusCountry);
			$Enom->AddParam( "us_purpose", $AppPurpose );
		}
		
		if ($tld =="ca") {
		$cira_legal_type = $HTTP_POST_VARS[ "cira_legal_type" ];
		$cira_org_registered_in = $HTTP_POST_VARS[ "cira-org-registered-in" ];
		$cira_trademark_no = $HTTP_POST_VARS[ "cira-trademark-no" ];
		$cira_registrant = $HTTP_POST_VARS[ "cira-registrant" ];
		$cira_registrant_desc = $HTTP_POST_VARS[ "cira-registrant-desc" ];
			$Enom->AddParam( "cira_legal_type", $cira_legal_type );
			$Enom->AddParam( "cira-org-registered-in", $cira_org_registered_in);
			$Enom->AddParam( "cira-trademark-no", $cira_trademark_no );
			$Enom->AddParam( "cira-registrant", $cira_registrant );
			$Enom->AddParam( "cira-registrant-desc", $cira_registrant_desc );
		}
		if ($tld =="co.uk") {
		$uk_legal_type = $HTTP_POST_VARS[ "uk_legal_type" ];
		$uk_reg_co_no = $HTTP_POST_VARS[ "uk_reg_co_no" ];
		$registered_for = $HTTP_POST_VARS[ "registered_for" ];
			$Enom->AddParam( "uk_legal_type", $uk_legal_type );
			$Enom->AddParam( "uk_reg_co_no", $uk_reg_co_no );
			$Enom->AddParam( "registered_for", $registered_for );
		} 
		else if ($tld =="org.uk") {
		$uk_legal_type = $HTTP_POST_VARS[ "uk_legal_type" ];
		$uk_reg_co_no = $HTTP_POST_VARS[ "uk_reg_co_no" ];
		$registered_for = $HTTP_POST_VARS[ "registered_for" ];
			$Enom->AddParam( "uk_legal_type", $uk_legal_type );
			$Enom->AddParam( "uk_reg_co_no", $uk_reg_co_no );
			$Enom->AddParam( "registered_for", $registered_for );
			}
		if ($tld == "name") {
			$idforwardOptionYes = $HTTP_POST_VARS[ "idforwardOptionYes" ];
			$forwardmailto = $HTTP_POST_VARS[ "forwardmailto" ];
			$everything = "everything";
				if ($idforwardOptionYes == "yes"){
					$Enom->AddParam( "ForwardName", $everything );
					$Enom->AddParam( "ForwardMailTo", $forwardmailto );	
					}
			}
  		$Enom->AddParam( "EndUserIP", $enduserip );
		$Enom->AddParam( "command", "contacts" );
		$Enom->DoTransaction();
		//echo $Enom->PostString;
	
		// Get number of errors
		$nNumErrors = $Enom->Values[ "ErrCount" ];
	
		if ( $nNumErrors > 0 ) {
			
			// Loop through all errors and print them out
			for ( $i = 1; $i <= $nNumErrors; $i++ ) {
			$message = "Your update was successfull.";
			$message .= "$i) {$Enom->Values[ 'Err' . $i ]}<br />";
			// There were errors
			$message .= "There were errors:<br />";
			}
		} else {
			// No errors, success
			$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><b font=\"red\">Your update was successfull</b></td></tr>
			<tr><td nowrap><br><center><a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_back.gif\" border=\"0\"></a></center></td></tr></table>";
					}
	}
	
	// Get all the contact information
  	$Enom->NewRequest();
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "command", "getcontacts" );
	$Enom->DoTransaction();
		//echo '<br><br>'.$Enom->PostString;
	// Get number of errors
	$nNumErrors = $Enom->Values[ "ErrCount" ];
	
	if ( $nNumErrors > 0 ) {
		// There were errors
		$message .= "There were errors:<br />";
			
		// Loop through all errors and print them out
		for ( $i = 1; $i <= $nNumErrors; $i++ ) {
			$message .= "$i) {$Enom->Values[ "Err" . $i ]}<br />";
		}
	} else {
		// Get values from Enom object and put into vars
		include( "include/Enom2HTML_inc.php" );
	}
?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="147" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td width="145" height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
			<td class="content" align="center" valign="top" width="815">
			<table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic">&nbsp;</td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top"><p align="center"><span class="red">
			       <?php
				  //Print the error message if there is one
	if(isset($message)) {echo '<br><br><span class=\"red\">', $message, '<br></span>';}?>
			      </span>				          </p>				</td></tr><tr>
			      <td colspan="3" valign="top"><p align="center"><span class="red">

			        <table align="center" width="486" border="0">
     <form method="post" action="<?php echo "change_whois.php?command=$action&sld=$sld&tld=$tld";?>" NAME="form1" id="form1" onSubmit="return CheckFields()">
        <input type="hidden" name="action" id="idName" value="change">
        <!-- required for js page validation -->
        <input type="hidden" name="CallingAppl" id="idCallingAppl" value="Access">
                      <tr>
                        <td width="480"><table width="459" border="0" align="center" cellPadding="5" cellSpacing="1" class="tableOO">
        <? //  Registrant Contact section ?>
        <tr><td height="5" colspan="3" class="titlepic"><span class="whiteheader">Registrant&nbsp;&nbsp;Contact</span></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td width="287" valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantOrganizationName" id="idRegistrantOrg"
				value="<?php echo $RegistrantOrganizationName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Job Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantJobTitle" id="idRegistrantJobTitle"
				value="<?php echo $RegistrantJobTitle; ?>"></td>
        </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantFirstName" id="idRegistrantFName"
				value="<?php echo $RegistrantFirstName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantLastName" id="idRegistrantLName"
				value="<?php echo $RegistrantLastName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantAddress1" id="idRegistrantAddress"
				value="<?php echo $RegistrantAddress1; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantCity" id="idRegistrantCity"
				value="<?php echo $RegistrantCity; ?>"></td></tr>
        <tr>
          <?
				$strStateValue = trim( $RegistrantStateProvince );
				?>
          <td width="107" valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; </td>
          <td width="31" valign="middle" ><input type="radio" value="S" id="radio3" name="RegistrantStateProvince" 
				<?php if ($RegistrantStateProvinceChoice == "S" || $RegistrantStateProvinceChoice == "" ) { echo "checked"; }?> onClick="fnRegistrantStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;
              <select name="RegistrantState" id="idRegistrantState" size="1">
              <option selected value="<?php echo $idRegistrantState; ?>"><?php echo $idRegistrantState; ?> 
              </option>
			    <?php include( "include/StateList.php"); ?>
                          </select></td>
        </tr>
        <tr>
          <td valign="middle" >Province&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" size="14" value="P" name="RegistrantStateProvince" id="radio2" <?php if ( $RegistrantStateProvinceChoice == "P" ) { echo "checked"; } ?> onClick="fnRegistrantProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;
              <input type="text" name="RegistrantProvince" id="idRegistrantProvince" maxlength="60"
				value="<?php if ($RegistrantStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
        </tr>
        <tr>
          <td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" value="Blank" name="RegistrantStateProvince" id="radio" <?php if ($RegistrantStateProvinceChoice == "Blank") { echo "checked"; } ?> onClick="fnRegistrantNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(N/A)</td>
        </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="RegistrantPostalCode" id="idRegistrantZip" value="<?php echo $RegistrantPostalCode; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="RegistrantCountry" id="idRegistrantCountry">
              <option selected value="<?php echo $RegistrantCountry; ?>"><?php echo $RegistrantCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantPhone" id="idRegistrantPhone"
				value="<?php echo $RegistrantPhone; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantFax" id="idRegistrantFax"
				value="<?php echo $RegistrantFax; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="RegistrantEmailAddress" id="idRegistrantEmail"
				value="<?php echo $RegistrantEmailAddress; ?>"></td></tr>
        <tr>
          <td colspan="2" valign="middle" >&nbsp;</td>
          <td valign="middle" >&nbsp;</td>
        </tr>
    </table>                        </td>
                      </tr>

                      <tr>
                        <td><table width="459" border="0" align="center" cellPadding="5" cellSpacing="1" class="tableOO">
        <tr><td height="5" colspan="3" class="titlepic"><span class="whiteheader">Administrator&nbsp;&nbsp;Contact</span></td></tr>
        <tr> 
          <td colspan="3" valign="middle" ><input type="radio" name="OptAdmin" id="idOptAdmin" value="UseRegistrant" onclick="AdminUseRegistrantInfo()">
            Use the Registrant Information (Above)<br /><input type="radio" name="OptAdmin" id="idOptAdmin" value="UseExisting" onclick="EnableAdmin(true)" checked>
          Use the following Information</td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td width="287" valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminOrganizationName" id="idAdminOrg"
				value="<?php echo $AdminOrganizationName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Job&nbsp;Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminJobTitle" id="idAdminJobTitle"
				value="<?php echo $AdminJobTitle; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminFirstName" id="idAdminFName"
				value="<?php echo $AdminFirstName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminLastName" id="idAdminLName"
				value="<?php echo $AdminLastName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminAddress1" id="idAdminAddress"
				value="<?php echo $AdminAddress1; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminCity" id="idAdminCity"
				value="<?php echo $AdminCity; ?>"></td></tr>
        <tr> 
          <?
				$strStateValue = trim( $AdminStateProvince );
				?><td width="107" valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; 
            </td>
          <td width="31" valign="middle" ><input type="radio" value="S" id="radio4" name="AdminStateProvince" 
				<?php if ($AdminStateProvinceChoice == "S" || $AdminStateProvinceChoice == "" ) { echo "checked"; }?> onClick="fnAdminStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AdminState" id="idAdminState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td></tr>
        <tr><td valign="middle" >Province&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" size="14" value="P" name="AdminStateProvince" id="radio5" <?php if ( $AdminStateProvinceChoice == "P" ) { echo "checked"; } ?> onClick="fnAdminProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" name="AdminProvince" id="idAdminProvince" maxlength="60"
				value="<?php if ($AdminStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
</tr>        <tr><td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; </td>
  <td valign="middle" ><input type="radio" value="Blank" name="AdminStateProvince" id="idAdminStateProvince" <?php if ($AdminStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnAdminNoneSelected()"></td>
  <br>
          <td valign="middle" >&nbsp;&nbsp;(N/A)</td>
           </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="AdminPostalCode" id="idAdminZip" value="<?php echo $AdminPostalCode; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AdminCountry" id="idAdminCountry">
              <option selected value="<?php echo $AdminCountry; ?>"><?php echo $AdminCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AdminPhone" id="idAdminPhone"
				value="<?php echo $AdminPhone; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AdminFax" id="idAdminFax"
				value="<?php echo $AdminFax; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="AdminEmailAddress" id="idAdminEmail"
				value="<?php echo $AdminEmailAddress; ?>"></td></tr>
    </table></td>
                      </tr>
                      <tr>
                        <td><table width="459" border="0" align="center" cellPadding="5" cellSpacing="1" class="tableOO">
        <tr><td height="5" colspan="3" class="titlepic"><span class="whiteheader">Technical&nbsp;&nbsp;Contact</span></td></tr>
        <tr> 
          <td colspan="3" valign="middle" ><input type="radio" name="OptTech" id="idOptTechnical" value="UseRegistrant" onclick="TechUseRegistrantInfo()">
            Use the Registrant Information (Above)<br><input type="radio" name="OptTech" id="idOptTechnical" value="UseExisting" onclick="EnableTechnicalContact(true)" checked>
          Use the following Information</td>
          </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td width="287" valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechOrganizationName" id="idTechOrg"
				value="<?php echo $TechOrganizationName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Job&nbsp;Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechJobTitle" id="idTechJobTitle"
				value="<?php echo $TechJobTitle; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechFirstName" id="idTechFName"
				value="<?php echo $TechFirstName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechLastName" id="idTechLName"
				value="<?php echo $TechLastName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechAddress1" id="idTechAddress"
				value="<?php echo $TechAddress1; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechCity" id="idTechCity"
				value="<?php echo $TechCity; ?>"></td></tr>
        <tr>
          <?
				$strStateValue = trim( $AuxBillingStateProvince );
				?>
          <td width="107" valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; </td>
          <td width="31" valign="middle" ><input type="radio" value="S" id="radio3" name="TechStateProvince" 
				<?php if ($AuxBillingStateProvinceChoice == "S" || $AuxBillingStateProvinceChoice == "" ) { echo "checked"; }?> onClick="fnAuxBillingStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;
              <select name="TechState" id="idAuxBillingState" size="1">
                <?php include( "include/StateList.php"); ?>
                          </select></td>
        </tr>
        <tr>
          <td valign="middle" >Province&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" size="14" value="P" name="TechStateProvince" id="radio2" <?php if ( $AuxBillingStateProvinceChoice == "P" ) { echo "checked"; } ?> onClick="fnAuxBillingProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;
              <input type="text" name="TechProvince" id="idAuxBillingProvince" maxlength="60"
				value="<?php if ($TechStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
        </tr>
        <tr>
          <td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" value="Blank" name="TechStateProvince" id="radio" <?php if ($AuxBillingStateProvinceChoice == "Blank") { echo "checked"; } ?> onClick="fnAuxBillingNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(N/A)</td>
        </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="TechPostalCode" id="idTechZip" value="<?php echo $TechPostalCode; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="TechCountry" id="idTechCountry">
              <option selected value="<?php echo $TechCountry; ?>"><?php echo $TechCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="TechPhone" id="idTechPhone"
				value="<?php echo $TechPhone; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="TechFax" id="idTechFax"
				value="<?php echo $TechFax; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="TechEmailAddress" id="idTechEmail"
				value="<?php echo $TechEmailAddress; ?>"></td></tr>
    </table></td>
                      </tr>
					  <tr><td>
					  <table width="459" border="0" align="center" cellPadding="5" cellSpacing="1" class="tableOO">
<tr><td height="5" colspan="3" class="titlepic"><span class="whiteheader">Auxillary 
            Billing&nbsp;&nbsp;Contact</span></td></tr>
        <tr> 
          <td colspan="3" valign="middle" ><input type="radio" name="OptAuxBilling" id="idOptAuxBilling" value="UseRegistrant" onclick="AuxUseRegistrantInfo()">
            Use the Registrant Information (Above)<br />
            
            <input type="radio" name="OptAuxBilling" id="idOptAuxBilling" value="UseExisting" onclick="EnableAuxBilling(true)" checked>
          Use the following Information</td>
          </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td width="287" valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingOrganizationName" id="idAuxBillingOrg"
				value="<?php echo $AuxBillingOrganizationName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Job Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingJobTitle" id="idAuxBillingJobTitle"
				value="<?php echo $AuxBillingJobTitle; ?>"></td>
        </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingFirstName" id="idAuxBillingFName"
				value="<?php echo $AuxBillingFirstName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingLastName" id="idAuxBillingLName"
				value="<?php echo $AuxBillingLastName; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingAddress1" id="idAuxBillingAddress"
				value="<?php echo $AuxBillingAddress1; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingCity" id="idAuxBillingCity"
				value="<?php echo $AuxBillingCity; ?>"></td></tr>
        <tr> 
          <?
				$strStateValue = trim( $AuxBillingStateProvince );
				?><td width="107" valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; 
            </td>
          <td width="31" valign="middle" ><input type="radio" value="S" id="radio3" name="AuxBillingStateProvince" 
				<?php if ($AuxBillingStateProvinceChoice == "S" || $AuxBillingStateProvinceChoice == "" ) { echo "checked"; }?> onClick="fnAuxBillingStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AuxBillingState" id="idAuxBillingState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td></tr>
        <tr><td valign="middle" >Province&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" size="14" value="P" name="AuxBillingStateProvince" id="radio2" <?php if ( $AuxBillingStateProvinceChoice == "P" ) { echo "checked"; } ?> onClick="fnAuxBillingProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" name="AuxBillingProvince" id="idAuxBillingProvince" maxlength="60"
				value="<?php if ($AuxBillingStateProvinceChoice == "P") { echo $strStateValue; }?>"></td></tr>
        <tr><td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" value="Blank" name="AuxBillingStateProvince" id="radio" <?php if ($AuxBillingStateProvinceChoice == "Blank") { echo "checked"; } ?> onClick="fnAuxBillingNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(N/A)</td>
        </tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="AuxBillingPostalCode" id="idAuxBillingZip" value="<?php echo $AuxBillingPostalCode; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AuxBillingCountry" id="idAuxBillingCountry">
              <option selected value="<?php echo $AuxBillingCountry; ?>"><?php echo $AuxBillingCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AuxBillingPhone" id="idAuxBillingPhone"
				value="<?php echo $AuxBillingPhone; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AuxBillingFax" id="idAuxBillingFax"
				value="<?php echo $AuxBillingFax; ?>"></td></tr>
        <tr><td colspan="2" valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="AuxBillingEmailAddress" id="idAuxBillingEmail"
				value="<?php echo $AuxBillingEmailAddress; ?>"></td></tr>
        <?php 
			//If Extended paramaters are needed, then this section will be shown
			if( $tld=="us" ) { 
			include "include/cctld/nexus.php";
			}
			if(($tld=="co.uk" )||($tld=="org.uk")){ 
			include "include/cctld/ukl.php";
			}
			else if ( $tld=="ca" ) { 
			include "include/cctld/ca.php";
			}
			else if ( $tld=="name" ) { 
			include "include/cctld/dotname.php";
			}
			?>
        <tr> 
          <td colspan="3" valign="middle" ><div align="center">
              <input type="hidden" value="FullForm" name="FormType">
              <input type="image" name="image" src="images/btn_submit.gif" border="0">            
              <a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>"><img src="images/btn_cancel.gif" border="0"></a></div></td>
          </tr>
      </form>
    </table>
					</tr></td>
                    <br>		          
		      </table>
		      </table>
</table>
		          <?php include('include/footer.php');?>