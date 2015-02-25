<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.

$username = $_SESSION['loggedin_user'];
$user_id = $_SESSION['id'];
$action = $HTTP_POST_VARS[ "action" ];
$Domain = $_GET["Domain"];
$sld = $_GET["sld"];
$tld = $_GET["tld"];
$refer = $_GET["refer"];
$command = $_GET["command"];
$cart_id = $_GET["cart_id"];


	require( "include/dbconfig.php" );
	include( "include/EnomInterface_inc.php" );
	
$get_data = "SELECT * FROM users WHERE id='$user_id'";
$data = @mysql_query($get_data);
$row = mysql_fetch_array($data, MYSQL_ASSOC);

$fname = $row[fname]; 
$lname = $row[lname]; 
$email = $row[email]; 
$add1 = $row[add1]; 
$add2 = $row[add2]; 
$city = $row[city]; 
$state = $row[state];
$country = $row[country ];
$zip = $row[zip]; 
$fax = $row[fax ]; 
$phone = $row[phone ]; 
$province = $row[province]; 
$rspchoice = $row[rspchoice];
$countrycode = $row[countrycode]; 

$row[state] = trim($row[state]);

function escape_data($data) {
	global $dbc;
	if (ini_get('magic_quotes_gpc')){
		$data = stripslashes($data);
	}
return mysql_real_escape_string($data, $dbc);
}


	// Get URL Interface object
	$Enom = new CEnomInterface;

	if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
	if(empty($_POST['fname'])) {
		$fname = FALSE;
		$message .= '<br>You forgot to enter your First name</br>';
	} else { 
		$fname = escape_data(urlencode($_POST['fname']));
		}
	
	if(empty($_POST['lname'])) {
		$lname = FALSE;
		$message .= '<br>You forgot enter your last name</br>';
	} else { 
		$lname = escape_data(urlencode($_POST['lname']));
		}
	
	if(empty($_POST['email1'])) {
		$email = FALSE;
		$message .= '<br>You must enter an email address</br>';
	} else { 
		$email = $_POST['email1'];
		}
	
	if(empty($_POST['add1'])) {
		$add1 = FALSE;
		$message .= '<br>You did not enter your address</br>';
	} else { 
		$add1 = escape_data(urlencode($_POST['add1']));
		}
	
	if(isset($_POST['add2'])) {
		$add2 = escape_data(urlencode($_POST['add2']));
	}
	
	if(empty($_POST['city'])) {
		$city = FALSE;
		$message .= '<br>You forgot to enter a city</br>';
	} else { 
		$city = escape_data(urlencode($_POST['city']));
		}
	
	if(isset($_POST['state'])) {
		$state = escape_data(urlencode($_POST['state']));
	}

	if(isset($_POST['province'])) {
		$province = escape_data(urlencode($_POST['province']));
	}
	
	if(isset($_POST['rspchoice'])) {
		$rspchoice = TRUE;
	}
	
	if(empty($_POST['zip'])) {
		$zip = FALSE;
		$message .= '<br>You did not enter a zip code</br>';
	} else { 
		$zip = escape_data(urlencode($_POST['zip']));
		}
	
	if(empty($_POST['country'])) {
		$country = FALSE;
		$message .= '<br>The country field is required to continue</br>';
	} else { 
		$country = escape_data(urlencode($_POST['country']));
		}
	
	if(empty($_POST['countrycode'])) {
		$countrycode = FALSE;
		$message .= '<br>The country code field is required to continue</br>';
	} else { 
		$countrycode = escape_data(urlencode($_POST['countrycode']));
		}
	
	if(empty($_POST['phone'])) {
		$phone = FALSE;
		$message .= '<br>A valid phone number is required</br>';
	} else { 
		$phone = escape_data(urlencode($_POST['phone']));
		}
	
	if(isset($_POST['fax'])) {
		$fax = escape_data(urlencode($_POST['fax']));
		}

	

if( $fname && $lname& $email && $add1 && $city && $zip && $country && $countrycode && $phone)
		{

$orgname = urlencode($_POST['orgname']);
$jtitle = urlencode($_POST['jtitle']);

  		$Enom->AddParam( "userid", $user_id );
  		$Enom->AddParam( "username", $username );
  		$Enom->AddParam( "enduserip", $enduserip );
  		$Enom->AddParam( "site", $sitename );
  		$Enom->AddParam( "sld", $sld );
  		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "command", "Purchase" );
			//DNS
			if ( $HTTP_POST_VARS[ "UseNameserver" ] == "default" ) {
				$Enom->AddParam( "usedns", "default" );
				$use_dns = 1;
			} else {
				$use_dns = 0;
				for ( $iNameServer = 1; $iNameServer < 4; $iNameServer++ ) {
					if ( $HTTP_POST_VARS[ "NameServer" . $iNameServer ] != "" ) {
						$Enom->AddParam( "NS" . $iNameServer, $HTTP_POST_VARS[ "NameServer" . $iNameServer ] );
					}
				}
			}
			//End DNS
			
			
		$reg_phone = '+'.$_POST['countrycode'].'.'.$phone;
		$reg_fax = '+'.$_POST['countrycode'].'.'.$fax;

		$admin_phone = '+'.$_POST['countrycode'].'.'.$phone;
		$admin_fax = '+'.$_POST['countrycode'].'.'.$fax;

		$tech_phone = '+'.$_POST['countrycode'].'.'.$phone;
		$tech_fax = '+'.$_POST['countrycode'].'.'.$fax;

		$aux_phone = '+'.$_POST['countrycode'].'.'.$phone;
		$aux_fax = '+'.$_POST['countrycode'].'.'.$fax;
			//Contacts
  		$Enom->AddParam( "RegistrantEmailAddress", $HTTP_POST_VARS[ "RegistrantEmailAddress" ] );
  		$Enom->AddParam( "RegistrantFax", $HTTP_POST_VARS[ "RegistrantFax" ] );
  		$Enom->AddParam( "RegistrantPhone", $HTTP_POST_VARS[ "RegistrantPhone" ] );
  		$Enom->AddParam( "RegistrantCountry", $HTTP_POST_VARS[ "RegistrantCountry" ] );
  		$Enom->AddParam( "RegistrantPostalCode", $HTTP_POST_VARS[ "RegistrantPostalCode" ] );
  		if ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "S" ) {
    		$Enom->AddParam( "RegistrantStateProvinceChoice", "S" );
    		$Enom->AddParam( "RegistrantStateProvince", $HTTP_POST_VARS[ "RegistrantState" ] );
    	} else if ( $HTTP_POST_VARS[ "RegistrantStateProvinceChoice" ] == "P" ) {
    		$Enom->AddParam( "RegistrantStateProvinceChoice", "P" );
    		$Enom->AddParam( "RegistrantStateProvince", $HTTP_POST_VARS[ "RegistrantProvince" ] );
    	} else {
    		$Enom->AddParam( "RegistrantStateProvinceChoice", "" );
    		$Enom->AddParam( "RegistrantStateProvince", "" );
    	}
  		$Enom->AddParam( "RegistrantCity", $HTTP_POST_VARS[ "RegistrantCity" ] );
  		$Enom->AddParam( "RegistrantAddress2", $HTTP_POST_VARS[ "RegistrantAddress2" ] );
  		$Enom->AddParam( "RegistrantAddress1", $HTTP_POST_VARS[ "RegistrantAddress1" ] );
  		$Enom->AddParam( "RegistrantLastName", $HTTP_POST_VARS[ "RegistrantLastName" ] );
  		$Enom->AddParam( "RegistrantFirstName", $HTTP_POST_VARS[ "RegistrantFirstName" ] );
  		$Enom->AddParam( "RegistrantJobTitle", $HTTP_POST_VARS[ "RegistrantJobTitle" ] );
  		$Enom->AddParam( "RegistrantOrganizationName", $HTTP_POST_VARS[ "RegistrantOrganizationName" ] );
			
  		$Enom->AddParam( "AdminEmailAddress", $HTTP_POST_VARS[ "AdminEmailAddress" ] );
  		$Enom->AddParam( "AdminFax", $HTTP_POST_VARS[ "AdminFax" ] );
  		$Enom->AddParam( "AdminPhone", $HTTP_POST_VARS[ "AdminPhone" ] );
  		$Enom->AddParam( "AdminCountry", $HTTP_POST_VARS[ "AdminCountry" ] );
  		$Enom->AddParam( "AdminPostalCode", $HTTP_POST_VARS[ "AdminPostalCode" ] );
  		if ( $HTTP_POST_VARS[ "AdminStateProvinceChoice" ] == "S" ) {
    		$Enom->AddParam( "AdminStateProvinceChoice", "S" );
    		$Enom->AddParam( "AdminStateProvince", $HTTP_POST_VARS[ "AdminStateProvince" ] );
    	} else if ( $HTTP_POST_VARS[ "AdminStateProvinceChoice" ] == "P" ) {
    		$Enom->AddParam( "RegistrantStateProvinceChoice", "P" );
    		$Enom->AddParam( "AdminStateProvince", $HTTP_POST_VARS[ "AdminStateProvince" ] );
    	} else {
    		$Enom->AddParam( "AdminStateProvinceChoice", "" );
    		$Enom->AddParam( "RegistrantStateProvince", "" );
    	}
  		$Enom->AddParam( "AdminCity", $HTTP_POST_VARS[ "AdminCity" ] );
  		$Enom->AddParam( "AdminAddress2", $HTTP_POST_VARS[ "AdminAddress2" ] );
  		$Enom->AddParam( "AdminAddress1", $HTTP_POST_VARS[ "AdminAddress1" ] );
  		$Enom->AddParam( "AdminLastName", $HTTP_POST_VARS[ "AdminLastName" ] );
  		$Enom->AddParam( "AdminFirstName", $HTTP_POST_VARS[ "AdminFirstName" ] );
  		$Enom->AddParam( "AdminJobTitle", $HTTP_POST_VARS[ "AdminJobTitle" ] );

  		$Enom->AddParam( "TechEmailAddress", $HTTP_POST_VARS[ "TechEmailAddress" ] );
  		$Enom->AddParam( "TechFax", $HTTP_POST_VARS[ "TechFax" ] );
  		$Enom->AddParam( "TechPhone", $HTTP_POST_VARS[ "TechPhone" ] );
  		$Enom->AddParam( "TechCountry", $HTTP_POST_VARS[ "TechCountry" ] );
  		$Enom->AddParam( "TechPostalCode", $HTTP_POST_VARS[ "TechPostalCode" ] );
  		if ( $HTTP_POST_VARS[ "TechStateProvinceChoice" ] == "S" ) {
    		$Enom->AddParam( "TechStateProvinceChoice", "S" );
    		$Enom->AddParam( "TechStateProvince", $HTTP_POST_VARS[ "TechStateProvince" ] );
    	} else if ( $HTTP_POST_VARS[ "TechStateProvinceChoice" ] == "P" ) {
    		$Enom->AddParam( "TechStateProvinceChoice", "P" );
    		$Enom->AddParam( "TechStateProvince", $HTTP_POST_VARS[ "TechStateProvince" ] );
    	} else {
    		$Enom->AddParam( "TechStateProvinceChoice", "" );
    		$Enom->AddParam( "TechStateProvince", "" );
    	}
  		$Enom->AddParam( "TechCity", $HTTP_POST_VARS[ "TechCity" ] );
  		$Enom->AddParam( "TechAddress2", $HTTP_POST_VARS[ "TechAddress2" ] );
  		$Enom->AddParam( "TechAddress1", $HTTP_POST_VARS[ "TechAddress1" ] );
  		$Enom->AddParam( "TechLastName", $HTTP_POST_VARS[ "TechLastName" ] );
  		$Enom->AddParam( "TechFirstName", $HTTP_POST_VARS[ "TechFirstName" ] );
  		$Enom->AddParam( "TechJobTitle", $HTTP_POST_VARS[ "TechJobTitle" ] );
  		$Enom->AddParam( "TechOrganizationName", $HTTP_POST_VARS[ "TechOrganizationName" ] );
		
  		$Enom->AddParam( "AuxBillingEmailAddress", $HTTP_POST_VARS[ "AuxBillingEmailAddress" ] );
  		$Enom->AddParam( "AuxBillingFax", $HTTP_POST_VARS[ "AuxBillingFax" ] );
  		$Enom->AddParam( "AuxBillingPhone", $HTTP_POST_VARS[ "AuxBillingPhone" ] );
  		$Enom->AddParam( "AuxBillingCountry", $HTTP_POST_VARS[ "AuxBillingCountry" ] );
  		$Enom->AddParam( "AuxBillingPostalCode", $HTTP_POST_VARS[ "AuxBillingPostalCode" ] );
  		if ( $HTTP_POST_VARS[ "AuxBillingStateProvinceChoice" ] == "S" ) {
    		$Enom->AddParam( "AuxBillingStateProvinceChoice", "S" );
    		$Enom->AddParam( "AuxBillingStateProvince", $HTTP_POST_VARS[ "AuxBillingStateProvince" ] );
    	} else if ( $HTTP_POST_VARS[ "AuxBillingStateProvinceChoice" ] == "P" ) {
    		$Enom->AddParam( "AuxBillingStateProvinceChoice", "P" );
    		$Enom->AddParam( "AuxBillingStateProvince", $HTTP_POST_VARS[ "AuxBillingStateProvince" ] );
    	} else {
    		$Enom->AddParam( "AuxBillingStateProvinceChoice", "" );
    		$Enom->AddParam( "AuxBillingStateProvince", "" );
    	}
  		$Enom->AddParam( "AuxBillingCity", $HTTP_POST_VARS[ "AuxBillingCity" ] );
  		$Enom->AddParam( "AuxBillingAddress2", $HTTP_POST_VARS[ "AuxBillingAddress2" ] );
  		$Enom->AddParam( "AuxBillingAddress1", $HTTP_POST_VARS[ "AuxBillingAddress1" ] );
  		$Enom->AddParam( "AuxBillingLastName", $HTTP_POST_VARS[ "AuxBillingLastName" ] );
  		$Enom->AddParam( "AuxBillingFirstName", $HTTP_POST_VARS[ "AuxBillingFirstName" ] );
  		$Enom->AddParam( "AuxBillingJobTitle", $HTTP_POST_VARS[ "AuxBillingJobTitle" ] );
  		$Enom->AddParam( "AuxBillingOrganizationName", $HTTP_POST_VARS[ "AuxBillingOrganizationName" ] );
			
		//Nexus info if sent
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
			

		$qstring = $Enom->PostString;
		$query = "UPDATE cart SET preconfig='1' WHERE cartsld='$sld' AND carttld='$tld' AND cart_id='$cart_id'";
		$result = @mysql_query ($query);
			if($result){
				$query1 = "UPDATE cart SET extra1='Purchase' WHERE cartsld='$sld' AND carttld='$tld' AND cart_id='$cart_id'";
				$result1 = @mysql_query ($query1);
					if($result1){
						$query2 = "UPDATE cart SET extra2='$qstring', dns='$use_dns' WHERE cartsld='$sld' AND carttld='$tld' AND cart_id='$cart_id'";
						$result2 = @mysql_query ($query2);
							if($result2){
								header ("Location: view_cart.php");
							}//End if result2
					} //End If Result1
			} else {
			header ("Location: error.php");
			}
		}//End If Error Result statement
	}
	$PageName= "RegisterName";
	$PageTitle = $SiteTitle . " - Register your domain name";
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
			<table width="100%" height="659" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19"  class="titlepic"><span class="whiteheader">Register Domain Name</span><b>                                 </b></td>
			    </tr>
				<tr>
				  <td height="320" valign="top" class="content2">                
			  <tr>
		        <td height="320" valign="top" class="content2"><p align="center">
				  <table align="center"><tr><td>
<?php if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center>';}?>
			      </td></tr></table>
		
		          <div align="center"></div>
                      <form method="post" action="<?php echo "preconfig.php?sld=$sld&tld=$tld&cart_id=$cart_id&refer=view_cart";?>" id="form1" name="form1">
                        <input type="hidden" name="action" value="go">
                        <?
		  	if ( $action == "go" ) {
				if ($bError == 1)
				{
					echo "$message";
				} 
			}
			?>
			        <div align="center"><br>
			        Note: Your account information will show here. Previously saved info is saved, but wont be displayed here.<br>Saving your information again will overwrite any previously saved information.
		      </div>
		<table class="tableOO" width="720" border="0" align="center">
        <tr> 
          <td colspan="3" height="5" class="titlepic" align="center"><span class="whiteheader">Registrant&nbsp;&nbsp;Contact</span></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td width="60%" valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantOrganizationName" id="idRegistrantOrg"
				value="<?php echo $RegistrantOrganizationName; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Job Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantJobTitle" id="idRegistrantJobTitle"
				value="<?php echo $RegistrantJobTitle; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantFirstName" id="idRegistrantFName"
				value="<?php echo $RegistrantFirstName; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantLastName" id="idRegistrantLName"
				value="<?php echo $RegistrantLastName; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantAddress1" id="idRegistrantAddress"
				value="<?php echo $RegistrantAddress1; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantCity" id="idRegistrantCity"
				value="<?php echo $RegistrantCity; ?>"></td>
        </tr>
        <tr> 
          <? $strStateValue = trim( $RegistrantStateProvince );?>
          <td width="37%" valign="middle" ><b class="red">*</b>US State</td>
          <td width="2%" valign="middle" ><input type="radio" value="S" id="radio5" name="RegistrantStateProvince" 
				<?php if ($RegistrantStateProvinceChoice == "S" || $RegistrantStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnRegistrantStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;
              <select name="RegistrantState" id="idRegistrantState" size="1">
                <?php include( "include/StateList.php"); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" >Province&nbsp;&nbsp;<br></td>
          <td valign="middle" ><input type="radio" size="14" value="P" name="RegistrantStateProvince" id="radio6" <?php if ( $RegistrantProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnRegistrantProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;
              <input type="text" name="RegistrantProvince" id="idRegistrantProvince" maxlength="60"
				value="<?php if ($RegistrantStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; </td>
          <td valign="middle" ><input type="radio" value="Blank" name="RegistrantStateProvince" id="radio7" <?php if ($RegistrantProvinceChoice == "Blank") { echo "checked"; } ?> onClick="fnRegistrantNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(the state/province field will be left blank)</td>
        </tr>
		        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="RegistrantPostalCode" id="idRegistrantZip" value="<?php echo $RegistrantPostalCode; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="RegistrantCountry" id="idRegistrantCountry">
              <option selected value="<?php echo $RegistrantCountry; ?>"><?php echo $RegistrantCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantPhone" id="idRegistrantPhone"
				value="<?php echo $RegistrantPhone; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantFax" id="idRegistrantFax"
				value="<?php echo $RegistrantFax; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="RegistrantEmailAddress" id="idRegistrantEmail"
				value="<?php echo $RegistrantEmailAddress; ?>"></td>
        </tr>
        <tr> 
          <td colspan="3" valign="middle" >&nbsp;</td>
        </tr>
		</table>
		<br>
        <?php 
			if( $tld=="us" ) { 
			include "include/nexus.php";
			}
			else if ( $tld=="ca" ) { 
			include "include/ca.php";
			}
			?>
				<table class="tableOO" width="720" border="0" align="center">
        <tr> 
          <td colspan="2" height="5" class="titlepic" align="center"><span class="whiteheader">Administrator&nbsp;&nbsp;Contact</span></td>
        </tr>
        <tr> 
          <td width="40%" valign="middle" >&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="radio" name="OptAdmin" id="idOptAdmin" value="UseRegistrant" onclick="AdminUseRegistrantInfo()">
            Use the Registrant Information (Above)<br /> &nbsp;&nbsp; <input type="radio" name="OptAdmin" id="idOptAdmin" value="UseExisting" onclick="EnableAdmin(true)" checked>
            Use the following Information<br /></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminOrganizationName" id="idAdminOrg"
				value="<?php echo $AdminOrganizationName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Job&nbsp;Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminJobTitle" id="idAdminJobTitle"
				value="<?php echo $AdminJobTitle; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminFirstName" id="idAdminFName"
				value="<?php echo $AdminFirstName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminLastName" id="idAdminLName"
				value="<?php echo $AdminLastName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminAddress1" id="idAdminAddress"
				value="<?php echo $AdminAddress1; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AdminCity" id="idAdminCity"
				value="<?php echo $AdminCity; ?>"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $AdminStateProvince );
				?>
          <td valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idAdminStateProvince" name="AdminStateProvince" 
				<?php if ($AdminStateProvinceChoice == "S" || $AdminStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnAdminStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AdminState" id="idAdminState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" >Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="AdminStateProvince" id="idAdminStateProvince" <?php if ( $AdminStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnAdminProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" name="AdminProvince" id="idAdminProvince" maxlength="60"
				value="<?php if ($AdminStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="AdminStateProvince" id="idAdminStateProvince" <?php if ($AdminStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnAdminNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="AdminPostalCode" id="idAdminZip" value="<?php echo $AdminPostalCode; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AdminCountry" id="idAdminCountry">
              <option selected value="<?php echo $AdminCountry; ?>"><?php echo $AdminCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AdminPhone" id="idAdminPhone"
				value="<?php echo $AdminPhone; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AdminFax" id="idAdminFax"
				value="<?php echo $AdminFax; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="AdminEmailAddress" id="idAdminEmail"
				value="<?php echo $AdminEmailAddress; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" >&nbsp;</td>
        </tr>
		</table><br>
        <? //  Technical Contact section ?>
		
		<table class="tableOO" width="720" border="0" align="center">
        <tr> 
          <td colspan="2" height="5" class="titlepic" align="center"><span class="whiteheader">Technical&nbsp;&nbsp;Contact</span></td>
        </tr>
         <td width="40%" valign="middle" >&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="radio" name="OptTech" id="idOptTechnical" value="UseRegistrant" onclick="TechUseRegistrantInfo()">
            Use the Registrant Information (Above)<br /> &nbsp;&nbsp; <input type="radio" name="OptTech" id="idOptTechnical" value="UseExisting" onclick="EnableTechnicalContact(true)" checked>
            Use the following Information<br /></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechOrganizationName" id="idTechOrg"
				value="<?php echo $TechOrganizationName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Job&nbsp;Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechJobTitle" id="idTechJobTitle"
				value="<?php echo $TechJobTitle; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechFirstName" id="idTechFName"
				value="<?php echo $TechFirstName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechLastName" id="idTechLName"
				value="<?php echo $TechLastName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechAddress1" id="idTechAddress"
				value="<?php echo $TechAddress1; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="TechCity" id="idTechCity"
				value="<?php echo $TechCity; ?>"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $TechStateProvince );
				?>
          <td valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idTechStateProvince" name="TechStateProvince" 
				<?php if ($TechStateProvinceChoice == "S" || $TechStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnTechStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <select name="TechState" id="idTechState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" >Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="TechStateProvince" id="idTechStateProvince" <?php if ( $TechStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnTechProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" name="TechProvince" id="idTechProvince" maxlength="60"
				value="<?php if ($TechStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="TechStateProvince" id="idTechStateProvince" <?php if ($TechStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnTechNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="TechPostalCode" id="idTechZip" value="<?php echo $TechPostalCode; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="TechCountry" id="idTechCountry">
              <option selected value="<?php echo $TechCountry; ?>"><?php echo $TechCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="TechPhone" id="idTechPhone"
				value="<?php echo $TechPhone; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="TechFax" id="idTechFax"
				value="<?php echo $TechFax; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="TechEmailAddress" id="idTechEmail"
				value="<?php echo $TechEmailAddress; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" >&nbsp;</td>
        </tr>
		</table><br>
        <? //  AuxBilling Contact section ?>
		<table class="tableOO" width="720" border="0" align="center">
        <tr> 
          <td colspan="2" height="5" class="titlepic" align="center"><span class="whiteheader">Auxillary Billing&nbsp;&nbsp;Contact</span></td>
        </tr>
        <tr> 
          <td width="40%" valign="middle" >&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="radio" name="OptAuxBilling" id="idOptAuxBilling" value="UseRegistrant" onclick="AuxUseRegistrantInfo()">
            Use the Registrant Information (Above)<br /> &nbsp;&nbsp; <input type="radio" name="OptAuxBilling" id="idOptAuxBilling" value="UseExisting" onclick="EnableAuxBilling(true)" checked>
            Use the following Information<br /></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingOrganizationName" id="idAuxBillingOrg"
				value="<?php echo $AuxBillingOrganizationName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Job Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingJobTitle" id="idAuxBillingJobTitle"
				value="<?php echo $AuxBillingJobTitle; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingFirstName" id="idAuxBillingFName"
				value="<?php echo $AuxBillingFirstName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingLastName" id="idAuxBillingLName"
				value="<?php echo $AuxBillingLastName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingAddress1" id="idAuxBillingAddress"
				value="<?php echo $AuxBillingAddress1; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="AuxBillingCity" id="idAuxBillingCity"
				value="<?php echo $AuxBillingCity; ?>"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $AuxBillingStateProvince );
				?>
          <td valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idAuxBillingStateProvince" name="AuxBillingStateProvince" 
				<?php if ($AuxBillingStateProvinceChoice == "S" || $AuxBillingStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnAuxBillingStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AuxBillingState" id="idAuxBillingState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" >Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="AuxBillingStateProvince" id="idAuxBillingStateProvince" <?php if ( $AuxBillingStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnAuxBillingProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" name="AuxBillingProvince" id="idAuxBillingProvince" maxlength="60"
				value="<?php if ($AuxBillingStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="AuxBillingStateProvince" id="idAuxBillingStateProvince" <?php if ($AuxBillingStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnAuxBillingNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="AuxBillingPostalCode" id="idAuxBillingZip" value="<?php echo $AuxBillingPostalCode; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="AuxBillingCountry" id="idAuxBillingCountry">
              <option selected value="<?php echo $AuxBillingCountry; ?>"><?php echo $AuxBillingCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AuxBillingPhone" id="idAuxBillingPhone"
				value="<?php echo $AuxBillingPhone; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="AuxBillingFax" id="idAuxBillingFax"
				value="<?php echo $AuxBillingFax; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="AuxBillingEmailAddress" id="idAuxBillingEmail"
				value="<?php echo $AuxBillingEmailAddress; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" >&nbsp;</td>
        </tr>
		</table>
		<br>
		<table class="tableOO" width="720" border="0" align="center">
        <tr> 
          <td colspan="2" class="titlepic" align="center"><span class="whiteheader">NameServer&nbsp;&nbsp;Information</span></td>
        </tr>
                        <tr>
                          <td ><b class="red">*</b>Use:</td>
                          <td valign="middle" >&nbsp;&nbsp;&nbsp;
                              <select name="UseNameserver" id="idUseNameserver">
                                <option <?php if ( $HTTP_POST_VARS[ "UseNameserver" ] == "default" ) { echo "selected"; } ?> value="default">Our nameservers</option>
                                <option <?php if ( $HTTP_POST_VARS[ "UseNameserver" ] == "custom" ) { echo "selected"; } ?> value="custom">Your own nameservers</option>
                            </select></td>
                        </tr>
                        <tr>
                          <td ><p><b class="red">*</b> Custom&nbsp;NameServers:&nbsp;&nbsp;<br />
                              <small>(must select &quot;Your own&nbsp;&nbsp;&nbsp;<br />
                              NameServers&quot; above)</small></p>
                            <p><b class="red">*</b> Must Use Default (ours) for our Hosting and our <br>email / dns services.</p></td>
                          <td valign="middle" > &nbsp;&nbsp;&nbsp;
                              <input type="text" name="NameServer1" id="idnameserver1" size="40" maxlength="60"
				value="<?php echo $HTTP_POST_VARS[ "NameServer1" ]; ?>">
                              <br />
&nbsp;&nbsp;&nbsp;
        <input type="text" name="NameServer2" id="idnameserver2" size="40" maxlength="60"
				value="<?php echo $HTTP_POST_VARS[ "NameServer2" ]; ?>">
        <br />
&nbsp;&nbsp;&nbsp;
        <input type="text" name="NameServer3" id="idnameserver3" size="40" maxlength="60"
				value="<?php echo $HTTP_POST_VARS[ "NameServer3" ]; ?>">
        <br />
&nbsp;&nbsp;&nbsp;
        <input type="text" name="NameServer4" id="idnameserver4" size="40" maxlength="60"
				value="<?php echo $HTTP_POST_VARS[ "NameServer4" ]; ?>"></td>
                        </tr>
                        <tr>
                          <td   align="center">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center">&nbsp;
                              <input name="image" type="image" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">
&nbsp;<a href="view_cart.php" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
                        </tr>
	              </table>		        
      </form>
    </table>
			        </table>
	      </td>
      </tr>
</table></table>
<?php include('include/footer.php');?>