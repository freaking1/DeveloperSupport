<?php
session_name ('API-PHPSESSID');
session_start();
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$sld = $_GET['sld'];
$tld = $_GET['tld'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=namemap?sld=$sld&tld=$tld");
	exit();
}

require( "include/dbconfig.php" );
include("include/EnomInterface_inc.php");

$getDNS = "SELECT dns FROM domains WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
$gotDNS = mysql_query($getDNS);
$DNS = mysql_result($gotDNS,0);

$getMAP = "SELECT name_map FROM domains WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
$gotMAP = mysql_query($getMAP);
$MAPOn = mysql_result($gotMAP,0);

	if($MAPOn == 1){
		$MAPText = 'Enabled (Turned On)';
		} elseif($MAPOn == 0){
		$MAPText = 'Disabled (Turned Off)';
		}

$domain = "sld=$sld&tld=$tld";

if ($DNS != 1){
	header ("Location:  $site_url/dmain.php?$domain");
	exit(); // Quit the script.
}

  		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "command", "GetDomainMAP" );
  		$Enom->AddParam( "site", $sitename );
  		$Enom->AddParam( "enduserip", $enduserip );
  		$Enom->DoTransaction();

		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$message .= $Enom->Values[ "Err1" ];
				} else {
				$HostName  = $Enom->Values[ "Host-Name"];
				$Address2 = $Enom->Values[ "address"];
				$City2 = $Enom->Values[ "city"];
				$StateProvince2  = $Enom->Values[ "stateprovince"];
				$PostalCode2 = $Enom->Values[ "postalcode"];
				$Country2 = $Enom->Values[ "country"];
				}

$action = $_GET["action"];

if($action == "change"){
	if($_GET[status] == 0){
	//Since its currently off lets turn it on
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "Service", "Map" );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "NewOptionID", "1111" );
			$Enom->AddParam( "Update", "true" );
			$Enom->AddParam( "command", "ServiceSelect" );
			$Enom->DoTransaction();

	$update1 = "Update domains SET name_map = '1' WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
	$update2 = mysql_query($update1);
		if($update2){
			header ("Location:  $site_url/namemap.php?$domain");
			exit(); // Quit the script.
		}
	} else {
	//Turn off
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "Service", "Map" );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "NewOptionID", "1108" );
			$Enom->AddParam( "Update", "true" );
			$Enom->AddParam( "command", "ServiceSelect" );
			$Enom->DoTransaction();

			$update1 = "Update domains SET name_map = '0' WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
			$update2 = mysql_query($update1);
		if($update2){
			header ("Location:  $site_url/dmain.php?$domain");
			exit(); // Quit the script.
			}
		}
	}

if($action == "modify"){

	if (empty($_POST['Address'])) {
		$Address = FALSE;
		$message .= '<br>You must enter an Address.</br>';
	} else {
		$Address = $_POST['Address'];
		}
	if (empty($_POST['City'])) {
		$City = FALSE;
		$message .= '<br>You must enter a City.</br>';
	} else {
		$City = $_POST['City'];
		}
	if (empty($_POST['StateProvince'])) {
		$City = FALSE;
		$message .= '<br>You must enter a State or Province.</br>';
	} else {
		$StateProvince = $_POST['StateProvince'];
		}
	if (empty($_POST['PostalCode'])) {
		$PostalCode = FALSE;
		$message .= '<br>You must enter a Postal Code.</br>';
	} else {
		$PostalCode = $_POST['PostalCode'];
		}
	if (empty($_POST['Country'])) {
		$Country = FALSE;
		$message .= '<br>You must choose a country.</br>';
	} else {
		$Country = $_POST['Country'];
		}

		if($Address && $City && $StateProvince && $PostalCode && $Country){
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "HostName", "map" );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "Address", $Address );
			$Enom->AddParam( "City", $City );
			$Enom->AddParam( "StateProvince", $StateProvince);
			$Enom->AddParam( "PostalCode", $PostalCode);
			$Enom->AddParam( "Country", $Country);
			$Enom->AddParam( "command", "SetDomainmap" );
			$Enom->DoTransaction();

		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$message .= $Enom->Values[ "Err1" ];
				} else {

			//Update the db
			$update1 = "Update domains SET name_map = '1' WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
			$update2 = mysql_query($update1);
				if($update2){
					header ("Location:  $site_url/dmain.php?$domain");
					exit(); // Quit the script.
				}
		}
	}
}
	$page = "myaccount";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Name My Map </span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center"><br>
			        <?php 	if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center><br>';
	} else { echo '<br><br><br>';}
?>
			<?php
			# ---------------------------------------------------------
		if($MAPOn == 1){
		?>
              <form name="form" method="post" action="<?php echo "namemap.php?sld=$sld&tld=$tld&action=modify";?>">
                <table width="450" border="0" align="center" class="tableOO">
                  <tr class="titlepic">
                    <td colspan="2"><div align="center" class="whiteheader"> <strong>map.<?php echo "$sld.$tld";?></strong></div></td>
                  </tr>
                  <tr>
                    <td width="37%" align="center">
                      <div align="left"><strong>Address</strong> </div></td>
                    <td width="63%" align="center"><div align="left">
                        <input name="Address" type="text" id="Address" size="40" maxlength="60" value="<?php if(isset($Address2)){ echo $Address2;}?>">
                    </div></td>
                  </tr>
                  <tr>
                    <td width="37%" align="center">
                      <div align="left"> <strong>City </strong> </div></td>
                    <td width="63%" align="center"><div align="left">
                        <input name="City" type="text" id="City" size="40" maxlength="60" value="<?php if(isset($City2)){ echo $City2;}?>">
                    </div></td>
                  </tr>
                  <tr>
                    <td width="37%" align="center">
                      <div align="left"><strong>State / Province</strong> </div></td>
                    <td width="63%" align="center"><div align="left">
                        <input name="StateProvince" type="text" id="StateProvince" size="40" maxlength="60" value="<?php if(isset($StateProvince2)){ echo $StateProvince2;}?>">
                    </div></td>
                  </tr>
                  <tr>
                    <td width="37%" align="center">
                      <div align="left"> <strong>Postal Code </strong> </div></td>
                    <td width="63%" align="center"><div align="left">
                        <input name="PostalCode" type="text" id="PostalCode" size="15" maxlength="60" value="<?php if(isset($PostalCode2)){ echo $PostalCode2;}?>">
                    </div></td>
                  </tr>
                  <tr>
                    <td height="21"><strong>Country</strong></td>
                    <td height="21">
                      <select name="Country" class="formfield" id="Country" value="<?php if(isset($Country2)) echo $Country2; ?>">
                                              <option value="us">United States</option>
                                              <option value="af">Afghanistan</option>
                                              <option value="al">Albania</option>
                                              <option value="dz">Algeria</option>
                                              <option value="as">American Samoa</option>
                                              <option value="ad">Andorra, Principality of</option>
                                              <option value="ao">Angola</option>
                                              <option value="ai">Anguilla</option>
                                              <option value="aq">Antarctica</option>
                                              <option value="ag">Antigua and Barbuda</option>
                                              <option value="ar">Argentina</option>
                                              <option value="am">Armenia</option>
                                              <option value="aw">Aruba</option>
                                              <option value="au">Australia</option>
                                              <option value="at">Austria</option>
                                              <option value="az">Azerbaidjan</option>
                                              <option value="bs">Bahamas</option>
                                              <option value="bh">Bahrain</option>
                                              <option value="bd">Bangladesh</option>
                                              <option value="bb">Barbados</option>
                                              <option value="by">Belarus</option>
                                              <option value="be">Belgium</option>
                                              <option value="bz">Belize</option>
                                              <option value="bj">Benin</option>
                                              <option value="bm">Bermuda</option>
                                              <option value="bt">Bhutan</option>
                                              <option value="bo">Bolivia</option>
                                              <option value="ba">Bosnia-Herzegovina</option>
                                              <option value="bw">Botswana</option>
                                              <option value="bv">Bouvet Island</option>
                                              <option value="br">Brazil</option>
                                              <option value="io">British Indian Ocean Territory</option>
                                              <option value="bn">Brunei Darussalam</option>
                                              <option value="bg">Bulgaria</option>
                                              <option value="bf">Burkina Faso</option>
                                              <option value="bi">Burundi</option>
                                              <option value="kh">Cambodia, Kingdom of</option>
                                              <option value="cm">Cameroon</option>
                                              <option value="ca">Canada</option>
                                              <option value="cv">Cape Verde</option>
                                              <option value="ky">Cayman Islands</option>
                                              <option value="cf">Central African Republic</option>
                                              <option value="td">Chad</option>
                                              <option value="cl">Chile</option>
                                              <option value="cn">China</option>
                                              <option value="cx">Christmas Island</option>
                                              <option value="cc">Cocos (Keeling) Islands</option>
                                              <option value="co">Colombia</option>
                                              <option value="km">Comoros</option>
                                              <option value="cg">Congo</option>
                                              <option value="cd">Congo, The Democratic Republic of the</option>
                                              <option value="ck">Cook Islands</option>
                                              <option value="cr">Costa Rica</option>
                                              <option value="hr">Croatia</option>
                                              <option value="cu">Cuba</option>
                                              <option value="cy">Cyprus</option>
                                              <option value="cz">Czech Republic</option>
                                              <option value="dk">Denmark</option>
                                              <option value="dj">Djibouti</option>
                                              <option value="dm">Dominica</option>
                                              <option value="do">Dominican Republic</option>
                                              <option value="tp">East Timor</option>
                                              <option value="ec">Ecuador</option>
                                              <option value="eg">Egypt</option>
                                              <option value="sv">El Salvador</option>
                                              <option value="gq">Equatorial Guinea</option>
                                              <option value="er">Eritrea</option>
                                              <option value="ee">Estonia</option>
                                              <option value="et">Ethiopia</option>
                                              <option value="fk">Falkland Islands</option>
                                              <option value="fo">Faroe Islands</option>
                                              <option value="fj">Fiji</option>
                                              <option value="fi">Finland</option>
                                              <option value="cs">Former Czechoslovakia</option>
                                              <option value="su">Former USSR</option>
                                              <option value="fr">France</option>
                                              <option value="fx">France (European Territory)</option>
                                              <option value="gf">French Guyana</option>
                                              <option value="tf">French Southern Territories</option>
                                              <option value="ga">Gabon</option>
                                              <option value="gm">Gambia</option>
                                              <option value="ge">Georgia</option>
                                              <option value="de">Germany</option>
                                              <option value="gh">Ghana</option>
                                              <option value="gi">Gibraltar</option>
                                              <option value="gb">Great Britain</option>
                                              <option value="gr">Greece</option>
                                              <option value="gl">Greenland</option>
                                              <option value="gd">Grenada</option>
                                              <option value="gp">Guadeloupe (French)</option>
                                              <option value="gu">Guam (USA)</option>
                                              <option value="gt">Guatemala</option>
                                              <option value="gn">Guinea</option>
                                              <option value="gw">Guinea Bissau</option>
                                              <option value="gy">Guyana</option>
                                              <option value="ht">Haiti</option>
                                              <option value="hm">Heard and McDonald Islands</option>
                                              <option value="va">Holy See (Vatican City State)</option>
                                              <option value="hn">Honduras</option>
                                              <option value="hk">Hong Kong</option>
                                              <option value="hu">Hungary</option>
                                              <option value="is">Iceland</option>
                                              <option value="in">India</option>
                                              <option value="id">Indonesia</option>
                                              <option value="ir">Iran</option>
                                              <option value="iq">Iraq</option>
                                              <option value="ie">Ireland</option>
                                              <option value="il">Israel</option>
                                              <option value="it">Italy</option>
                                              <option value="ci">Ivory Coast (Cote DIvoire)</option>
                                              <option value="jm">Jamaica</option>
                                              <option value="jp">Japan</option>
                                              <option value="jo">Jordan</option>
                                              <option value="kz">Kazakhstan</option>
                                              <option value="ke">Kenya</option>
                                              <option value="ki">Kiribati</option>
                                              <option value="kw">Kuwait</option>
                                              <option value="kg">Kyrgyz Republic (Kyrgyzstan)</option>
                                              <option value="la">Laos</option>
                                              <option value="lv">Latvia</option>
                                              <option value="lb">Lebanon</option>
                                              <option value="ls">Lesotho</option>
                                              <option value="lr">Liberia</option>
                                              <option value="ly">Libya</option>
                                              <option value="li">Liechtenstein</option>
                                              <option value="lt">Lithuania</option>
                                              <option value="lu">Luxembourg</option>
                                              <option value="mo">Macau</option>
                                              <option value="mk">Macedonia</option>
                                              <option value="mg">Madagascar</option>
                                              <option value="mw">Malawi</option>
                                              <option value="my">Malaysia</option>
                                              <option value="mv">Maldives</option>
                                              <option value="ml">Mali</option>
                                              <option value="mt">Malta</option>
                                              <option value="mh">Marshall Islands</option>
                                              <option value="mq">Martinique (French)</option>
                                              <option value="mr">Mauritania</option>
                                              <option value="mu">Mauritius</option>
                                              <option value="yt">Mayotte</option>
                                              <option value="mx">Mexico</option>
                                              <option value="fm">Micronesia</option>
                                              <option value="md">Moldavia</option>
                                              <option value="mc">Monaco</option>
                                              <option value="mn">Mongolia</option>
                                              <option value="ms">Montserrat</option>
                                              <option value="ma">Morocco</option>
                                              <option value="mz">Mozambique</option>
                                              <option value="mm">Myanmar</option>
                                              <option value="na">Namibia</option>
                                              <option value="nr">Nauru</option>
                                              <option value="np">Nepal</option>
                                              <option value="nl">Netherlands</option>
                                              <option value="an">Netherlands Antilles</option>
                                              <option value="nc">New Caledonia (French)</option>
                                              <option value="nz">New Zealand</option>
                                              <option value="ni">Nicaragua</option>
                                              <option value="ne">Niger</option>
                                              <option value="ng">Nigeria</option>
                                              <option value="nu">Niue</option>
                                              <option value="nf">Norfolk Island</option>
                                              <option value="kp">North Korea</option>
                                              <option value="mp">Northern Mariana Islands</option>
                                              <option value="no">Norway</option>
                                              <option value="om">Oman</option>
                                              <option value="pk">Pakistan</option>
                                              <option value="pw">Palau</option>
                                              <option value="pa">Panama</option>
                                              <option value="pg">Papua New Guinea</option>
                                              <option value="py">Paraguay</option>
                                              <option value="pe">Peru</option>
                                              <option value="ph">Philippines</option>
                                              <option value="pn">Pitcairn Island</option>
                                              <option value="pl">Poland</option>
                                              <option value="pf">Polynesia (French)</option>
                                              <option value="pt">Portugal</option>
                                              <option value="pr">Puerto Rico</option>
                                              <option value="qa">Qatar</option>
                                              <option value="re">Reunion (French)</option>
                                              <option value="ro">Romania</option>
                                              <option value="ru">Russian Federation</option>
                                              <option value="rw">Rwanda</option>
                                              <option value="gs">S. Georgia &amp; S. Sandwich Isls.</option>
                                              <option value="sh">Saint Helena</option>
                                              <option value="kn">Saint Kitts &amp; Nevis Anguilla</option>
                                              <option value="lc">Saint Lucia</option>
                                              <option value="pm">Saint Pierre and Miquelon</option>
                                              <option value="st">Saint Tome (Sao Tome) and Principe</option>
                                              <option value="vc">Saint Vincent &amp; Grenadines</option>
                                              <option value="ws">Samoa</option>
                                              <option value="sm">San Marino</option>
                                              <option value="sa">Saudi Arabia</option>
                                              <option value="sn">Senegal</option>
                                              <option value="sc">Seychelles</option>
                                              <option value="sl">Sierra Leone</option>
                                              <option value="sg">Singapore</option>
                                              <option value="sk">Slovak Republic</option>
                                              <option value="si">Slovenia</option>
                                              <option value="sb">Solomon Islands</option>
                                              <option value="so">Somalia</option>
                                              <option value="za">South Africa</option>
                                              <option value="kr">South Korea</option>
                                              <option value="es">Spain</option>
                                              <option value="lk">Sri Lanka</option>
                                              <option value="sd">Sudan</option>
                                              <option value="sr">Suriname</option>
                                              <option value="sj">Svalbard and Jan Mayen Islands</option>
                                              <option value="sz">Swaziland</option>
                                              <option value="se">Sweden</option>
                                              <option value="ch">Switzerland</option>
                                              <option value="sy">Syria</option>
                                              <option value="tj">Tadjikistan</option>
                                              <option value="tw">Taiwan</option>
                                              <option value="tz">Tanzania</option>
                                              <option value="th">Thailand</option>
                                              <option value="tg">Togo</option>
                                              <option value="tk">Tokelau</option>
                                              <option value="to">Tonga</option>
                                              <option value="tt">Trinidad and Tobago</option>
                                              <option value="tn">Tunisia</option>
                                              <option value="tr">Turkey</option>
                                              <option value="tm">Turkmenistan</option>
                                              <option value="tc">Turks and Caicos Islands</option>
                                              <option value="tv">Tuvalu</option>
                                              <option value="ug">Uganda</option>
                                              <option value="ua">Ukraine</option>
                                              <option value="ae">United Arab Emirates</option>
                                              <option value="gb">United Kingdom</option>
                                              <option value="uy">Uruguay</option>
                                              <option value="um">USA Minor Outlying Islands</option>
                                              <option value="uz">Uzbekistan</option>
                                              <option value="vu">Vanuatu</option>
                                              <option value="ve">Venezuela</option>
                                              <option value="vn">Vietnam</option>
                                              <option value="vg">Virgin Islands (British)</option>
                                              <option value="vi">Virgin Islands (USA)</option>
                                              <option value="wf">Wallis and Futuna Islands</option>
                                              <option value="eh">Western Sahara</option>
                                              <option value="ye">Yemen</option>
                                              <option value="yu">Yugoslavia</option>
                                              <option value="zr">Zaire</option>
                                              <option value="zm">Zambia</option>
                                              <option value="zw">Zimbabwe</option>
                                          </select></td>
                  </tr>
                  <tr>
                    <td height="54" colspan="2"><div align="center">
					<input name="Submit" type="image" src="images/btn_submit.gif" align="middle" border="0"/>
                        <a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>">
					<input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/>
						</form>
                    </a></div></td>
                  </tr>
                </table>
			<? } ?>


                <br>
                <table width="450" border="0" align="center" class="tableOO">

					<?php
					$status = $_POST['status'];
					?>
<form name="form2" method="post" action="<?php echo "namemap.php?sld=$sld&tld=$tld&action=change&status=$MAPOn";?>">
<table width="450" border="0" align="center" class="tableOO">
	  <tr>
		<td width="43%" height="20">Currently <?php echo "$MAPText" ;?></td>
		<td width="43%" height="20">
		<?php
		if($MAPOn == 1){
		echo '<input name="Disable" type="image" src="images/btn_disable_g.gif" align="middle" border="0" />';
			} else {
		echo '<input name="Enable" type="image" src="images/btn_enable_g.gif" align="middle" border="0"/>';
		}
		?>
</table>
</form>
                <p>&nbsp;</p>
		              <p>&nbsp;</p>
			        </form>			        <p align="center" class="BasicText"><br>
                    </p>
	          <tr>
	                <td colspan="3" valign="top" class="content2">
		      </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>