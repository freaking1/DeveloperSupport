<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$sld = $_GET['sld'];
$tld = $_GET['tld'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=view_cart");
	exit(); 
} 

$action = $HTTP_POST_VARS[ "action" ];
$Domain = $_GET["Domain"];
$sld = $_GET["sld"];
$tld = $_GET["tld"];
$refer = $_GET["refer"];
$command = $_GET["command"];
$cart_id = $_GET["cart_id"];

if ($refer != "view_cart"){
	header ("Location:  $secure_site_url/login.php?target=view_cart");
	exit(); // Quit the script.
}

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

include("functions/escape_data.php");

	if ( $action == "go" ) {
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

  		$Enom = new CEnomInterface;
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
			
		$reg_phone = '+'.$_POST['countrycode'].'.'.$phone;
		$reg_fax = '+'.$_POST['countrycode'].'.'.$fax;
  		// Fill in registrant contact information
  		$Enom->AddParam( "RegistrantEmailAddress", $email);
  		$Enom->AddParam( "RegistrantFax", $reg_fax);
  		$Enom->AddParam( "RegistrantPhone", $reg_phone);
  		$Enom->AddParam( "RegistrantCountry", $country);
  		$Enom->AddParam( "RegistrantPostalCode", $zip);
			if ( $rspchoice == "1" ) {
				$Enom->AddParam( "RegistrantStateProvinceChoice", "S" );
				$Enom->AddParam( "RegistrantStateProvince", $state);
			} else if ( $HTTP_POST_VARS[ "rspchoice" ] == "2" ) {
				$Enom->AddParam( "RegistrantStateProvinceChoice", "P" );
				$Enom->AddParam( "RegistrantStateProvince", $province);
			} else {
				$Enom->AddParam( "RegistrantStateProvinceChoice", "Blank" );
				$Enom->AddParam( "RegistrantStateProvince", "" );
				}
  		$Enom->AddParam( "RegistrantCity", $city);
  		$Enom->AddParam( "RegistrantAddress2", $add2);
  		$Enom->AddParam( "RegistrantAddress1", $add1);
  		$Enom->AddParam( "RegistrantLastName", $lname);
  		$Enom->AddParam( "RegistrantFirstName", $fname);
  		$Enom->AddParam( "RegistrantJobTitle", $jtitle );
  		$Enom->AddParam( "RegistrantOrganizationName", $orgname );
		//Nexus info if sent

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
			<table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Register Domain Name</span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td height="320" colspan="3" valign="top" class="content2"><p align="center">
				  <table align="center"><tr><td>
<?php if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center>';}?>
			      </td></tr></table>
			        <div align="center"></div>
			        <table class="tableOO" width="665" border="0" align="center">
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
		<table class="tableOO" width="720" border="0" align="center">
        <tr> 
          <td colspan="2" height="5" class="titlepic" align="center"><span class="whiteheader">Registrant&nbsp;&nbsp;Contact</span></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Organization&nbsp;Name:&nbsp;&nbsp;</td>
          <td width="50%" valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantOrganizationName" id="idRegistrantOrg"
				value="<?php echo $RegistrantOrganizationName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Job Title:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantJobTitle" id="idRegistrantJobTitle"
				value="<?php echo $RegistrantJobTitle; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>First&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantFirstName" id="idRegistrantFName"
				value="<?php echo $RegistrantFirstName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Last&nbsp;Name:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantLastName" id="idRegistrantLName"
				value="<?php echo $RegistrantLastName; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantAddress1" id="idRegistrantAddress"
				value="<?php echo $RegistrantAddress1; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>City:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="60" name="RegistrantCity" id="idRegistrantCity"
				value="<?php echo $RegistrantCity; ?>"></td>
        </tr>
        <tr> 
          <?
				$strStateValue = trim( $RegistrantStateProvince );
				?>
          <td valign="middle" ><b class="red">*</b>US State&nbsp;&nbsp; 
            <input type="radio" value="S" id="idRegistrantStateProvince" name="RegistrantStateProvince" 
				<?php if ($RegistrantStateProvinceChoice == "S" || $RegistrantStateProvinceChoice == "" ) { echo "checked"; }?> OnClick="fnRegistrantStateSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <select name="RegistrantState" id="idRegistrantState" size="1">
              <?php include( "include/StateList.php"); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" >Province&nbsp;&nbsp; <input type="radio" size="14" value="P" name="RegistrantStateProvince" id="idRegistrantStateProvince" <?php if ( $RegistrantStateProvinceChoice == "P" ) { echo "checked"; } ?> OnClick="fnRegistrantProvinceSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" name="RegistrantProvince" id="idRegistrantProvince" maxlength="60"
				value="<?php if ($RegistrantStateProvinceChoice == "P") { echo $strStateValue; }?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Not&nbsp;Applicable&nbsp;&nbsp; <input type="radio" value="Blank" name="RegistrantStateProvince" id="idRegistrantStateProvince" <?if ($RegistrantStateProvinceChoice == "Blank") { echo "checked"; } ?> OnClick="fnRegistrantNoneSelected()"></td>
          <td valign="middle" >&nbsp;&nbsp;(the state2/province field 
            will be left blank)</td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Zip/Postal&nbsp;Code:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="15" name="RegistrantPostalCode" id="idRegistrantZip" value="<?php echo $RegistrantPostalCode; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Country:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <select name="RegistrantCountry" id="idRegistrantCountry">
              <option selected value="<?php echo $RegistrantCountry; ?>"><?php echo $RegistrantCountry; ?> 
              </option>
              <?php include( "include/country.php" ); ?>
            </select></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantPhone" id="idRegistrantPhone"
				value="<?php echo $RegistrantPhone; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" >Fax:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="20" name="RegistrantFax" id="idRegistrantFax"
				value="<?php echo $RegistrantFax; ?>"></td>
        </tr>
        <tr> 
          <td valign="middle" ><b class="red">*</b>Email&nbsp;Address:&nbsp;&nbsp;</td>
          <td valign="middle" >&nbsp;&nbsp; <input type="text" maxlength="128" name="RegistrantEmailAddress" id="idRegistrantEmail"
				value="<?php echo $RegistrantEmailAddress; ?>"></td>
        </tr>
        <tr> 
          <td colspan="2" valign="middle" >&nbsp;</td>
        </tr>
		</table><br>
        <table class="tableOO" width="720" border="0" align="center">
			<?php 
			if( $tld=="us" ) { 
			include "include/cctld/nexus.php";
			}
			else if ( $tld=="ca" ) { 
			include "include/cctld/ca.php";
			}
			else if ( $tld=="co.uk" ) { 
			include "include/cctld/uk.php";
			}
			else if ( $tld=="org.uk" ) { 
			include "include/cctld/uk.php";
			}
			?>
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
			        <div align="center"><br>
			        Note: Your account information will show here. Previously saved info is saved, but wont be displayed here.<br>Saving your information again will overwrite any previously saved information.
		      </div>
			        </table>
	      </td>
      </tr>
</table></table>
<?php include('include/footer.php');?>