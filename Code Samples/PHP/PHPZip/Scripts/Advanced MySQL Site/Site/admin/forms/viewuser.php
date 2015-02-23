<?php
$show = $_GET["show"];
$action = $_GET["action"];
//Form Post Vars into variables
		//Section One
		$question = $HTTP_POST_VARS[ "lpquestion" ];
		$answer = $HTTP_POST_VARS[ "lpanswer" ];
		$isadmin = $HTTP_POST_VARS[ "isadmin" ];
		//Section Two
  		$fname = $HTTP_POST_VARS[ "fname" ];
  		$lname = $HTTP_POST_VARS[ "lname" ];
  		$add1 = $HTTP_POST_VARS[ "add1" ];
  		$add2  = $HTTP_POST_VARS[ "add2" ];
		$email = $HTTP_POST_VARS['email1'];
		$email2 = $HTTP_POST_VARS['email2'];
  		$city = $HTTP_POST_VARS[ "city" ];
		$state = $HTTP_POST_VARS[ "state" ];
  		$country = $HTTP_POST_VARS[ "country" ];
  		$countrycode = $HTTP_POST_VARS[ "countrycode" ];
  		$fax = $HTTP_POST_VARS[ "fax" ];
  		$phone = $HTTP_POST_VARS[ "phone" ];
  		$rspchoice = $HTTP_POST_VARS[ "rspchoice" ];
  		$zip = $HTTP_POST_VARS[ "zip" ];
		//Section three
		$billingCard_Type = $HTTP_POST_VARS[ "billingCard_Type" ];
		$billingname = $HTTP_POST_VARS[ "billingname" ];
		$billingcc_num = $HTTP_POST_VARS[ "billingcc_num" ];
		$billingexp_month = $HTTP_POST_VARS[ "billingexp_month" ];
		$billingexp_year = $HTTP_POST_VARS[ "billingexp_year" ];
		$billingaddress = $HTTP_POST_VARS[ "billingaddress" ];
		$billingcity = $HTTP_POST_VARS[ "billingcity" ];
		$stateprovince = $HTTP_POST_VARS[ "billingstateprovince" ];
		$billingzip = $HTTP_POST_VARS[ "billingzip" ];
		$billingcountry = $HTTP_POST_VARS[ "billingcountry" ];
		$billingcountrycode = $countrycode;
		$billingphone = $HTTP_POST_VARS[ "billingphone" ];
		$cvv2 = $HTTP_POST_VARS[ "cvv2" ];
	//End variable definitions
	
	//Write call to submit the variables
//End PHP Vars Section, start HTML form
echo "<br>$message";
?>
<form name="form" method="post" action="<?php echo "userman.php?action=modify&show=view&user=$viewuser&";?>">
<table width="373" border="0" align="center" class="tableO1" style="table01">
    <tr class="tableO1"><br>
      <td colspan="2" class="titlepic"><div align="center"><span class="whiteheader">Account Information </span></div></td>
    </tr>
    <tr class="tableO1">
      <td width="124"><div align="right">User Name:</div></td>
      <td width="235"><?=$row[username];?></td>
    </tr>
    <tr class="tableO1">
      <td><div align="right">Last Login:</div></td>
      <td><?=$row[last_login];?></td>
    </tr>
    <tr class="tableO1">
      <td><div align="right">Last Login IP:</div></td>
      <td><?=$row[login_IP];?></td>
    </tr>
    <tr class="tableO1">
      <td> <div align="right">Member Since: </div></td>
      <td><?=$row[signup_date];?></td>
    </tr>
    <tr class="tableO1">
      <td> <div align="right">Member #: </div></td>
      <td><?=$row[id];?></td>
    </tr>
    <tr class="tableO1">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tableO1">
      <td><div align="right">Admin User: </div></td>
      <td><select name="isadmin" id="isadmin">
<OPTION value="0" <? if ( $row[isadmin] == "0" ) { echo "selected"; } ?> >No
<OPTION value="1" <? if ( $row[isadmin] == "1" ) { echo "selected"; } ?> >Yes
      </select></td>
    </tr>
    <tr class="tableO1">
      <td><div align="right"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="tableO1">
      <td><div align="right">Security Question:</div></td>
      <td>&nbsp;&nbsp;&nbsp;<input name="lpquestion" type="text" id="lpquestion"
	value="<?php echo $row[lpquestion]; ?>" size="35" maxlength="60"></td>

    <tr class="tableO1">
      <td><div align="right">Answer:</div></td>
      <td>&nbsp;&nbsp;&nbsp;<input name="lpanswer" type="text" id="lpanswer"
	value="<?php echo $row[lpanswer]; ?>" size="35" maxlength="60"></td>
    </tr>
</table>
  <br>  
  <table width="471" border="0" align="center" class="tableO1" style="table01">
    <tr>
      <td colspan="2" class="titlepic"><div align="center"><span class="whiteheader">Personal Information </span></div></td>
    </tr>
    <tr class="tableO1">
      <td width="148"  ><div align="right">First&nbsp;Name:&nbsp;</div></td>
      <td width="309" valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="fname" id="fname" maxlength="60"
	value="<?php echo $row[fname]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Last&nbsp;Name:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="lname" id="lname" maxlength="60"
	value="<?php echo $row[lname]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Address1:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="add1" id="add1" maxlength="60"
	value="<?php echo $row[add1]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  >&nbsp;&nbsp;
      <div align="right">Address2:</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="add2" id="add2" maxlength="60"
	value="<?php echo $row[add2]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">City:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="city" id="city" maxlength="60"
	value="<?php echo $row[city]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  >
        <?php
	$row[state] = trim( $row[state] );
	?>
        <div align="right">US State&nbsp;&nbsp;
          <input type="radio" value="1" id="radio" name="rspchoice"
	<?php if ( $row[rspchoice] == "1") { echo "checked"; }?>>
      </div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <select name="state" id="select" size="1">
<OPTION value="" <? if ( $row[state] == "" ) { echo "selected"; } ?> >
<OPTION value="AL" <? if ( $row[state] == "AL" ) { echo "selected"; } ?> >Alabama
<OPTION value="AK" <? if ( $row[state] == "AK" ) { echo "selected"; } ?> >Alaska
<OPTION value="AS" <? if ( $row[state] == "AS" ) { echo "selected"; } ?> >American Samoa
<OPTION value="AZ" <? if ( $row[state] == "AZ" ) { echo "selected"; } ?> >Arizona
<OPTION value="AR" <? if ( $row[state] == "AR" ) { echo "selected"; } ?> >Arkansas
<OPTION value="CA" <? if ( $row[state] == "CA" ) { echo "selected"; } ?> >California
<OPTION value="CO" <? if ( $row[state] == "CO" ) { echo "selected"; } ?> >Colorado
<OPTION value="CT" <? if ( $row[state] == "CT" ) { echo "selected"; } ?> >Connecticut
<OPTION value="DE" <? if ( $row[state] == "DE" ) { echo "selected"; } ?> >Delaware
<OPTION value="DC" <? if ( $row[state] == "DC" ) { echo "selected"; } ?> >District of Columbia
<OPTION value="FM" <? if ( $row[state] == "FM" ) { echo "selected"; } ?> >Fed. States of Micronesia
<OPTION value="FL" <? if ( $row[state] == "FL" ) { echo "selected"; } ?> >Florida
<OPTION value="GA" <? if ( $row[state] == "GA" ) { echo "selected"; } ?> >Georgia
<OPTION value="GU" <? if ( $row[state] == "GU" ) { echo "selected"; } ?> >Guam
<OPTION value="HI" <? if ( $row[state] == "HI" ) { echo "selected"; } ?> >Hawaii
<OPTION value="ID" <? if ( $row[state] == "ID" ) { echo "selected"; } ?> >Idaho
<OPTION value="IL" <? if ( $row[state] == "IL" ) { echo "selected"; } ?> >Illinois
<OPTION value="IN" <? if ( $row[state] == "IN" ) { echo "selected"; } ?> >Indiana
<OPTION value="IA" <? if ( $row[state] == "IA" ) { echo "selected"; } ?> >Iowa
<OPTION value="KS" <? if ( $row[state] == "KS" ) { echo "selected"; } ?> >Kansas
<OPTION value="KY" <? if ( $row[state] == "KY" ) { echo "selected"; } ?> >Kentucky
<OPTION value="LA" <? if ( $row[state] == "LA" ) { echo "selected"; } ?> >Louisiana
<OPTION value="ME" <? if ( $row[state] == "ME" ) { echo "selected"; } ?> >Maine
<OPTION value="MH" <? if ( $row[state] == "MH" ) { echo "selected"; } ?> >Marshall Islands
<OPTION value="MD" <? if ( $row[state] == "MD" ) { echo "selected"; } ?> >Maryland
<OPTION value="MA" <? if ( $row[state] == "MA" ) { echo "selected"; } ?> >Massachusetts
<OPTION value="MI" <? if ( $row[state] == "MI" ) { echo "selected"; } ?> >Michigan
<OPTION value="MN" <? if ( $row[state] == "MN" ) { echo "selected"; } ?> >Minnesota
<OPTION value="MS" <? if ( $row[state] == "MS" ) { echo "selected"; } ?> >Mississippi
<OPTION value="MO" <? if ( $row[state] == "MO" ) { echo "selected"; } ?> >Missouri
<OPTION value="MT" <? if ( $row[state] == "MT" ) { echo "selected"; } ?> >Montana
<OPTION value="NE" <? if ( $row[state] == "NE" ) { echo "selected"; } ?> >Nebraska
<OPTION value="NV" <? if ( $row[state] == "NV" ) { echo "selected"; } ?> >Nevada
<OPTION value="NH" <? if ( $row[state] == "NH" ) { echo "selected"; } ?> >New Hampshire
<OPTION value="NJ" <? if ( $row[state] == "NJ" ) { echo "selected"; } ?> >New Jersey
<OPTION value="NM" <? if ( $row[state] == "NM" ) { echo "selected"; } ?> >New Mexico
<OPTION value="NY" <? if ( $row[state] == "NY" ) { echo "selected"; } ?> >New York
<OPTION value="NC" <? if ( $row[state] == "NC" ) { echo "selected"; } ?> >North Carolina
<OPTION value="ND" <? if ( $row[state] == "ND" ) { echo "selected"; } ?> >North Dakota
<OPTION value="MP" <? if ( $row[state] == "MP" ) { echo "selected"; } ?> >Northern Mariana Is.
<OPTION value="OH" <? if ( $row[state] == "OH" ) { echo "selected"; } ?> >Ohio
<OPTION value="OK" <? if ( $row[state] == "OK" ) { echo "selected"; } ?> >Oklahoma
<OPTION value="OR" <? if ( $row[state] == "OR" ) { echo "selected"; } ?> >Oregon
<OPTION value="PW" <? if ( $row[state] == "PW" ) { echo "selected"; } ?> >Palau
<OPTION value="PA" <? if ( $row[state] == "PA" ) { echo "selected"; } ?> >Pennsylvania
<OPTION value="PR" <? if ( $row[state] == "PR" ) { echo "selected"; } ?> >Puerto Rico
<OPTION value="RI" <? if ( $row[state] == "RI" ) { echo "selected"; } ?> >Rhode Island
<OPTION value="SC" <? if ( $row[state] == "SC" ) { echo "selected"; } ?> >South Carolina
<OPTION value="SD" <? if ( $row[state] == "SD" ) { echo "selected"; } ?> >South Dakota
<OPTION value="TN" <? if ( $row[state] == "TN" ) { echo "selected"; } ?> >Tennessee
<OPTION value="TX" <? if ( $row[state] == "TX" ) { echo "selected"; } ?> >Texas
<OPTION value="UT" <? if ( $row[state] == "UT" ) { echo "selected"; } ?> >Utah
<OPTION value="VT" <? if ( $row[state] == "VT" ) { echo "selected"; } ?> >Vermont
<OPTION value="VA" <? if ( $row[state] == "VA" ) { echo "selected"; } ?> >Virginia
<OPTION value="VI" <? if ( $row[state] == "VI" ) { echo "selected"; } ?> >Virgin Islands
<OPTION value="WA" <? if ( $row[state] == "WA" ) { echo "selected"; } ?> >Washington
<OPTION value="WV" <? if ( $row[state] == "WV" ) { echo "selected"; } ?> >West Virginia
<OPTION value="WI" <? if ( $row[state] == "WI" ) { echo "selected"; } ?> >Wisconsin
<OPTION value="WY" <? if ( $row[state] == "WY" ) { echo "selected"; } ?> >Wyoming
<OPTION value="AA" <? if ( $row[state] == "AA" ) { echo "selected"; } ?> >Armed Forces the Americas
<OPTION value="AE" <? if ( $row[state] == "AE" ) { echo "selected"; } ?> >Armed Forces Europe
<OPTION value="AP" <? if ( $row[state] == "AP" ) { echo "selected"; } ?> >Armed Forces Pacific        </select></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Province&nbsp;&nbsp;
          <input type="radio" size="14" value="2" name="rspchoice" id="radio2" <?php if ( $row[rspchoice] == "2" ) { echo "checked"; } ?> >
      </div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="rspchoice" id="rspchoice" maxlength="60"
	value="<?php if ( $row[rspchoice] == "2" ) { echo $row[province]; } ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Not&nbsp;Applicable&nbsp;&nbsp;
          <input type="radio" value="3" name="rspchoice" id="radio3" <?php if ($row[rspchoice] == "3") { echo "checked"; }?> >
      </div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;(the state/province field will be left blank) <b class="red"></b></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Postal/ZIP&nbsp;Code:&nbsp;&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="zip" id="zip" maxlength="15"
	value="<?php echo $row[zip]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Country:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
<select name="country" id="country">
				<option selected value="<?php echo $row[country]; ?>"><?php echo $row[country]; ?> 
				</option>
<option value="US">United States</option>
<option value="AF">Afghanistan</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option>
<option value="AO">Angola</option>
<option value="AI">Anguilla</option>
<option value="AQ">Antarctica</option>
<option value="AG">Antigua and Barbuda</option>
<option value="AR">Argentina</option>
<option value="AM">Armenia</option>
<option value="AW">Aruba</option>
<option value="AC">Ascension Island</option> 
<option value="AU">Australia</option>
<option value="AT">Austria</option>
<option value="AZ">Azerbaijan</option>
<option value="BS">The Bahamas</option>
<option value="BH">Bahrain</option>
<option value="BD">Bangladesh</option>
<option value="BB">Barbados</option>
<option value="BY">Belarus</option>
<option value="BE">Belgium</option>
<option value="BZ">Belize</option>
<option value="BJ">Benin</option>
<option value="BM">Bermuda</option>
<option value="BT">Bhutan</option>
<option value="BO">Bolivia</option>
<option value="BA">Bosnia and Herzegovina</option>
<option value="BW">Botswana</option>
<option value="BV">Bouvet Island</option>
<option value="BR">Brazil</option>
<option value="IO">British Indian Ocean Territory</option>
<option value="BN">Brunei Darussalam</option>
<option value="BG">Bulgaria</option>
<option value="BF">Burkina Faso</option>
<option value="BI">Burundi</option>
<option value="CM">Cambodia</option>
<option value="CM">Cameroon</option>
<option value="CA">Canada</option>
<option value="CV">Cape Verde</option>
<option value="KY">Cayman Islands</option>
<option value="CF">Central African Republic</option> 
<option value="TD">Chad</option>
<option value="CL">Chile</option>
<option value="CN">China</option>
<option value="CX">Christmas Island</option>
<option value="CC">Cocos (Keeling) Islands</option>
<option value="CO">Colombia</option>
<option value="CM">Comoros</option>
<option value="CG">Congo, Republic of</option>
<option value="CD">Congo, Democratic Rep. of</option>
<option value="CK">Cook Islands</option>
<option value="CR">Costa Rica</option>
<option value="CI">Côte d'Ivoire</option>
<option value="HR">Croatia</option>
<option value="CU">Cuba</option>
<option value="CY">Cyprus</option>
<option value="CZ">Czech Republic</option>
<option value="DK">Denmark</option>
<option value="DJ">Djibouti</option>
<option value="DM">Dominica</option>
<option value="DO">Dominican Republic</option>  
<option value="TP">East Timor</option>
<option value="EC">Ecuador</option>
<option value="EG">Egypt</option>
<option value="SV">El Salvador</option>
<option value="GC">Equatorial Guinea</option>
<option value="ER">Eritrea</option>
<option value="EE">Estonia</option>
<option value="ET">Ethiopia</option>
<option value="FK">Falkland Islands (Malvinas)</option>
<option value="FO">Faroe Islands</option>
<option value="FJ">Fiji</option>
<option value="FI">Finland</option>
<option value="FR">France</option>
<option value="FX">France Métropolitaine</option>
<option value="GF">French Guyana</option>
<option value="PF">French Polynesia</option>
<option value="TF">French Southern Territories</option>
<option value="GA">Gabon</option>
<option value="GM">Gambia</option>
<option value="GE">Georgia</option>
<option value="DE">Germany</option>
<option value="GA">Ghana</option>
<option value="BI">Gibraltar</option>
<option value="GR">Greece</option>
<option value="GL">Greenland</option>
<option value="GD">Grenada</option>
<option value="GP">Guadeloupe</option>
<option value="GU">Guam</option>
<option value="GT">Guatemala</option>
<option value="GG">Guernsey</option>
<option value="GN">Guinea</option>
<option value="GW">Guinea-Bissau</option>
<option value="GY">Guyana</option>
<option value="HT">Haiti</option>
<option value="HM">Heard and McDonald Islands</option>
<option value="HN">Honduras</option>
<option value="HK">Hong Kong</option>
<option value="HU">Hungary</option>
<option value="IS">Iceland</option>
<option value="IN">India</option>
<option value="ID">Indonesia</option>
<option value="IR">Iran</option>
<option value="IQ">Iraq</option>
<option value="IE">Ireland</option>
<option value="GB4">Isle of Man</option>
<option value="IL">Israel</option>
<option value="IT">Italy</option>
<option value="JM">Jamaica</option>
<option value="JP">Japan</option>
<option value="JR">Jersey</option>
<option value="JO">Jordan</option>
<option value="KZ">Kazakhstan</option>
<option value="KE">Kenya</option>
<option value="KI">Kiribati</option>
<option value="KP">Korea, North</option>
<option value="KR">Korea, South</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Laos</option>
<option value="LV">Latvia</option>
<option value="LB">Lebanon</option>
<option value="LS">Lesotho</option>
<option value="LR">Liberia</option>
<option value="LY">Libya</option>
<option value="LI">Liechtenstein</option>
<option value="LT">Lithuania</option>
<option value="LU">Luxembourg</option>
<option value="MO">Macao</option>
<option value="MK">Macedonia, F.Y.R.O.</option>
<option value="MG">Madagascar</option>
<option value="MW">Malawi</option>
<option value="MY">Malaysia</option>
<option value="MV">Maldives</option>
<option value="ML">Mali</option>
<option value="MT">Malta</option>
<option value="MH">Marshall Islands</option>
<option value="MQ">Martinique</option>
<option value="MR">Mauritania</option>
<option value="MU">Mauritius</option>
<option value="YT">Mayotte</option>
<option value="MX">Mexico</option>
<option value="FM">Micronesia</option>
<option value="MD">Moldova</option>
<option value="MC">Monaco</option>
<option value="MN">Mongolia</option>
<option value="MS">Montserrat</option>
<option value="MA">Morocco</option>
<option value="MZ">Mozambique</option>
<option value="MM">Myanmar</option>
<option value="NA">Namibia</option>
<option value="NR">Nauru</option>
<option value="NP">Nepal</option>
<option value="NL">Netherlands</option>
<option value="AN">Netherlands Antilles</option>
<option value="NC">New Caledonia</option>
<option value="NZ">New Zealand</option>
<option value="NI">Nicaragua</option>
<option value="NE">Niger</option>
<option value="NG">Nigeria</option>
<option value="NU">Niue</option>
<option value="NF">Norfolk Island</option>
<option value="NP">Northern Mariana Islands</option> 
<option value="NO">Norway</option>
<option value="OM">Oman</option>
<option value="PK">Pakistan</option>
<option value="PW">Palau</option>
<option value="PA">Panama</option>
<option value="PG">Papua New Guinea</option>
<option value="PY">Paraguay</option>
<option value="PE">Peru</option>
<option value="PH">Philippines</option>
<option value="PN">Pitcairn Island</option>
<option value="PL" >Poland</option>
<option value="PT">Portugal</option>
<option value="PR">Puerto Rico</option>
<option value="QA">Qatar</option>
<option value="RE">Reunion</option>
<option value="RO">Romania</option>
<option value="RU">Russia</option>
<option value="RW">Rwanda</option>
<option value="KN">Saint Kitts and Nevis</option>
<option value="LC">Saint Lucia</option>
<option value="VC">Saint Vincent and the Grenadines</option>
<option value="WS">Samoa</option>
<option value="SM">San Marino</option>
<option value="ST">Sao Tome and Principe</option>
<option value="SA">Saudi Arabia</option>
<option value="SN">Senegal</option>
<option value="SC">Seychelles</option>
<option value="SL">Sierra Leone</option>
<option value="SG">Singapore</option>
<option value="DK">Slovakia</option>
<option value="SI">Slovenia</option>
<option value="SB">Solomon Islands</option>
<option value="SO">Somalia</option>
<option value="ZA">South Africa</option>
<option value="GS">S Georgia and S Sandwich Islands</option>
<option value="ES">Spain</option>
<option value="LK">Sri Lanka</option>
<option value="SH">St. Helena</option>
<option value="PM">St. Pierre and Miquelon</option>
<option value="SD">Sudan</option>
<option value="SR">Suriname</option>
<option value="SJ">Svalbard and Jan Mayen Islands</option>
<option value="SZ">Swaziland</option>
<option value="SE">Sweden</option>
<option value="CH">Switzerland</option>
<option value="SY">Syria</option>
<option value="TW">Taiwan</option>
<option value="TJ">Tajikistan</option>
<option value="TZ">Tanzania</option>
<option value="TH">Thailand</option>
<option value="TG">Togo</option>
<option value="TK">Tokelau</option>
<option value="TO">Tonga</option>
<option value="TT">Trinidad and Tobago</option>
<option value="TN">Tunisia</option>
<option value="TR">Turkey</option>
<option value="TM">Turkmenistan</option>
<option value="TC">Turk and Caicos Islands</option>
<option value="TV">Tuvalu</option>
<option value="UG">Uganda</option>
<option value="UA">Ukraine</option>
<option value="AE">United Arab Emirates</option>
<option value="GB">United Kingdom</option>
<option value="US"> United States</option>
<option value="UM">U.S. Minor Outlying Islands</option>
<option value="UY">Uruguay</option>
<option value="UZ">Uzbekistan</option>
<option value="VU">Vanuatu</option>
<option value="VA">Vatican City State</option>
<option value="VE">Venezeula</option>
<option value="VN">Vietnam</option>
<option value="VG">Virgin Islands (British)</option>
<option value="VI">U.S. Virgin Islands</option>
<option value="WF">Wallis and Futuna Islands</option>
<option value="WS">Western Samoa</option>
<option value="EH">Western Sahara</option>
<option value="YE">Yemen</option>
<option value="YU">Yugoslavia</option>
<option value="ZR">Zaire</option>
<option value="ZM">Zambia</option>
<option value="ZW">Zimbabwe</option>			  
</select></td>    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Fax:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="fax" id="fax" maxlength="20"
	value="<?php echo $row[fax]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Country Code: </div></td>
      <td valign="middle" >&nbsp; &nbsp;
        <select name="countrycode" class="formfield" id="countrycode" value="<?php if(isset($row[country_code])) echo $row[country_code]; ?>">
          <option value="1">US / Canada (+ 001)</option>
          <option value="93">Afghanistan (+ 093)</option>
          <option value="355">Albania (+ 355)</option>
          <option value="213">Algeria (+ 213)</option>
          <option value="684">American Somoa (+ 684)</option>
          <option value="376">Andorra (+ 376)</option>
          <option value="244">Angola (+ 244)</option>
          <option value="672">Antartica (+ 672)</option>
          <option value="54">Argentina (+ 054)</option>
          <option value="374">Armenia (+ 374)</option>
          <option value="297">Aruba (+ 297)</option>
          <option value="61">Australia (+ 061)</option>
          <option value="43">Austria (+ 043)</option>
          <option value="994">Azerbaijan (+ 994)</option>
          <option value="973">Bahrain (+ 973)</option>
          <option value="880">Bangladesh (+ 880)</option>
          <option value="375">Belarus (+ 375)</option>
          <option value="32">Belgium (+ 032)</option>
          <option value="501">Belize (+ 501)</option>
          <option value="229">Benin (+ 229)</option>
          <option value="975">Bhutan (+ 975)</option>
          <option value="591">Bolivia (+ 591) </option>
          <option value="387">Bosnia and Herzegovina (+ 387) </option>
          <option value="267">Botswana (+ 267) </option>
          <option value="47">Bouvet Islands (+ 047) </option>
          <option value="55">Brazil (+ 055) </option>
          <option value="246">British Indian Ocean Territory (+ 246) </option>
          <option value="673">Brunei (+ 673) </option>
          <option value="359">Bulgaria (+ 359) </option>
          <option value="226">Burkina Faso (+ 226) </option>
          <option value="257">Burundi (+ 257) </option>
          <option value="855">Cambodia (+ 855) </option>
          <option value="237">Cameroon (+ 237) </option>
          <option value="238">Cape Verde (+ 238) </option>
          <option value="236">Central African Republic (+ 236) </option>
          <option value="235">Chad (+ 235) </option>
          <option value="56">Chile (+ 056) </option>
          <option value="86">China (+ 086) </option>
          <option value="618">Christmas Islands (+ 618) </option>
          <option value="57">Colombia (+ 057) </option>
          <option value="269">Comoros (+ 269) </option>
          <option value="242">Congo (+ 242) </option>
          <option value="243">Congo, Democratic Republic of (+ 243) </option>
          <option value="682">Cook Island (+ 682) </option>
          <option value="506">Costa Rica (+ 506) </option>
          <option value="225">Cote Divoire (+ 225) </option>
          <option value="385">Croatia (+ 385) </option>
          <option value="357">Cyprus (+ 357) </option>
          <option value="420">Czech Republic (+ 420) </option>
          <option value="45">Denmark (+ 045) </option>
          <option value="253">Djibouti (+ 253) </option>
          <option value="670">East Timor (+ 670) </option>
          <option value="20">Egypt (+ 020) </option>
          <option value="503">El Salvador (+ 503) </option>
          <option value="593">Equador (+ 593) </option>
          <option value="240">Equatorial Guinea (+ 240) </option>
          <option value="291">Eritrea (+ 291) </option>
          <option value="372">Estonia (+ 372) </option>
          <option value="251">Ethiopia (+ 251) </option>
          <option value="500">Falkland Islands (+ 500) </option>
          <option value="298">Faroe Islands (+ 298) </option>
          <option value="691">Federated States of Micronesia (+ 691) </option>
          <option value="679">Fiji (+ 679) </option>
          <option value="358">Finland (+ 358) </option>
          <option value="33">France (+ 033) </option>
          <option value="594">French Guiana (+ 594) </option>
          <option value="689">French Polynesia (+ 689) </option>
          <option value="596">French Southern Territories (+ 596) </option>
          <option value="241">Gabon (+ 241) </option>
          <option value="220">Gambia (+ 220) </option>
          <option value="995">Georgia (+ 995) </option>
          <option value="49">Germany (+ 049) </option>
          <option value="233">Ghana (+ 233) </option>
          <option value="350">Gibraltar (+ 350) </option>
          <option value="30">Greece (+ 030) </option>
          <option value="299">Greenland (+ 299) </option>
          <option value="590">Guadeloupe (+ 590) </option>
          <option value="502">Guatemala (+ 502) </option>
          <option value="224">Guinea (+ 224) </option>
          <option value="245">Guinea-Bissau (+ 245) </option>
          <option value="592">Guyana (+ 592) </option>
          <option value="509">Haiti (+ 509) </option>
          <option value="504">Honduras (+ 504) </option>
          <option value="852">Hong Kong (+ 852) </option>
          <option value="36">Hungary (+ 036) </option>
          <option value="354">Iceland (+ 354) </option>
          <option value="91">India (+ 091) </option>
          <option value="62">Indonesia (+ 062) </option>
          <option value="98">Iran (+ 098) </option>
          <option value="353">Ireland (+ 353) </option>
          <option value="972">Israel (+ 972) </option>
          <option value="39">Italy (+ 039) </option>
          <option value="81">Japan (+ 081) </option>
          <option value="962">Jordan (+ 962) </option>
          <option value="7">Kazakhstan (+ 007) </option>
          <option value="254">Kenya (+ 254) </option>
          <option value="686">Kiribati (+ 686) </option>
          <option value="850">Korea, North (+ 850) </option>
          <option value="82">Korea, South (+ 082) </option>
          <option value="965">Kuwait (+ 965) </option>
          <option value="996">Kyrgyzstan (+ 996) </option>
          <option value="856">Laos (+ 856) </option>
          <option value="371">Latvia (+ 371) </option>
          <option value="961">Lebanon (+ 961) </option>
          <option value="266">Lesotho (+ 266) </option>
          <option value="231">Liberia (+ 231) </option>
          <option value="423">Liechtenstein (+ 423) </option>
          <option value="370">Lithuania (+ 370) </option>
          <option value="352">Luxembourg (+ 352) </option>
          <option value="853">Macau (+ 853) </option>
          <option value="381">Macedonia (+ 381) </option>
          <option value="261">Madagascar (+ 261) </option>
          <option value="265">Malawi (+ 265) </option>
          <option value="60">Malaysia (+ 060) </option>
          <option value="960">Maldives (+ 960) </option>
          <option value="269">Mali (+ 269) </option>
          <option value="356">Malta (+ 356) </option>
          <option value="692">Marshall Islands (+ 692) </option>
          <option value="596">Martinique (+ 596) </option>
          <option value="222">Mauritania (+ 222) </option>
          <option value="230">Mauritius (+ 230) </option>
          <option value="269">Mayotte (+ 269) </option>
          <option value="33">Metropolitan France (+ 033) </option>
          <option value="52">Mexico (+ 052) </option>
          <option value="373">Moldova (+ 373) </option>
          <option value="377">Monaco (+ 377) </option>
          <option value="976">Mongolia (+ 976) </option>
          <option value="212">Morocco (+ 212) </option>
          <option value="258">Mozambique (+ 258) </option>
          <option value="95">Myanmar (+ 095) </option>
          <option value="264">Namibia (+ 264) </option>
          <option value="674">Nauru (+ 674) </option>
          <option value="977">Nepal (+ 977) </option>
          <option value="31">Netherlands (+ 031) </option>
          <option value="599">Netherlands Antilles (+ 599) </option>
          <option value="687">New Caledonia (+ 687) </option>
          <option value="64">New Zealand (+ 064) </option>
          <option value="505">Nicaragua (+ 505) </option>
          <option value="683">Nieu (+ 683) </option>
          <option value="227">Niger (+ 227) </option>
          <option value="234">Nigeria (+ 234) </option>
          <option value="672">Norfolk Island (+ 672) </option>
          <option value="47">Norway (+ 047) </option>
          <option value="968">Oman (+ 968) </option>
          <option value="92">Pakistan (+ 092) </option>
          <option value="680">Palau (+ 680) </option>
          <option value="970">Palestinian Territory, Occupied (+ 970) </option>
          <option value="507">Panama (+ 507) </option>
          <option value="675">Papua New Guinea (+ 675) </option>
          <option value="595">Paraguay (+ 595) </option>
          <option value="51">Peru (+ 051) </option>
          <option value="63">Philippines (+ 063) </option>
          <option value="872">Pitcairn (+ 872) </option>
          <option value="48">Poland (+ 048) </option>
          <option value="351">Portugal (+ 351) </option>
          <option value="974">Qatar (+ 974) </option>
          <option value="262">Reunion (+ 262) </option>
          <option value="40">Romania (+ 040) </option>
          <option value="7">Russia (+ 007) </option>
          <option value="250">Rwanda (+ 250) </option>
          <option value="684">Samoa (+ 684) </option>
          <option value="378">San Marino (+ 378) </option>
          <option value="239">Sao Tome and Principe (+ 239) </option>
          <option value="966">Saudi Arabia (+ 966) </option>
          <option value="221">Senegal (+ 221) </option>
          <option value="248">Seychelles (+ 248) </option>
          <option value="232">Sierra Leone (+ 232) </option>
          <option value="65">Singapore (+ 065) </option>
          <option value="421">Slovakia (+ 421) </option>
          <option value="386">Slovenia (+ 386) </option>
          <option value="677">Solomon Islands (+ 677) </option>
          <option value="252">Somalia (+ 252) </option>
          <option value="27">South Africa (+ 027) </option>
          <option value="995">S. Georgia/S. Sandwich Islands (+ 995) </option>
          <option value="34">Spain (+ 034) </option>
          <option value="94">Sri Lanka (+ 094) </option>
          <option value="290">St Helena (+ 290) </option>
          <option value="508">St Pierre and Miquelon (+ 508) </option>
          <option value="249">Sudan (+ 249) </option>
          <option value="597">Suriname (+ 597) </option>
          <option value="47">Svalbard and Jan Mayen Islands (+ 047) </option>
          <option value="268">Swaziland (+ 268) </option>
          <option value="46">Sweden (+ 046) </option>
          <option value="41">Switzerland (+ 041) </option>
          <option value="963">Syria (+ 963) </option>
          <option value="886">Taiwan (+ 886) </option>
          <option value="992">Tajikistan (+ 992) </option>
          <option value="255">Tanzania (+ 255) </option>
          <option value="66">Thailand (+ 066) </option>
          <option value="228">Togo (+ 228) </option>
          <option value="690">Tokelau (+ 690) </option>
          <option value="676">Tonga (+ 676) </option>
          <option value="216">Tunisia (+ 216) </option>
          <option value="90">Turkey (+ 090) </option>
          <option value="993">Turkmenistan (+ 993) </option>
          <option value="688">Tuvalu (+ 688) </option>
          <option value="256">Uganda (+ 256) </option>
          <option value="380">Ukraine (+ 380) </option>
          <option value="971">United Arab Emirates (+ 971) </option>
          <option value="44">United Kingdom (+ 044) </option>
          <option value="598">Uruguay (+ 598) </option>
          <option value="998">Uzbekistan (+ 998) </option>
          <option value="678">Vanuatu (+ 678) </option>
          <option value="39">Vatican City (+ 039) </option>
          <option value="58">Venezuela (+ 058) </option>
          <option value="84">Vietnam (+ 084) </option>
          <option value="340">Virgin Islands - US (+ 340) </option>
          <option value="681">Wallis and Futuna Islands (+ 681) </option>
          <option value="212">Western Sahura (+ 212) </option>
          <option value="967">Yemen (+ 967) </option>
          <option value="381">Yugoslavia (+ 381) </option>
          <option value="243">Zaire (+ 243) </option>
          <option value="260">Zambia (+ 260) </option>
          <option value="263">Zimbabwe (+ 263) </option>
      </select></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Phone:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="phone" id="phone" maxlength="20"
	value="<?php echo $row[phone]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Primary Email&nbsp;Address:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="email1" id="email1" maxlength="128"
	value="<?php echo $row[email]; ?>"></td>
    </tr>
    <tr class="tableO1">
      <td  ><div align="right">Secondary&nbsp;Address:&nbsp;</div></td>
      <td valign="middle" >&nbsp;&nbsp;&nbsp;
          <input type="text" name="email2" id="email2" maxlength="128"
	value="<?php echo $row[second_email]; ?>"></td>
    </tr>
  </table>
           <div align="center"><br>
             <input type="submit"class="button" border="0" name="Submit" value="Submit"> 
  </div>
</form>  
