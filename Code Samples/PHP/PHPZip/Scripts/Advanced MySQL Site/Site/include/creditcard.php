	<br>
	<form action="processcc.php?ccaction=process" method="POST">
	<input type="hidden" name="amount_due" value="<?=$amount_due;?>">
	<table align="center" class="tableO1">
		  <tr> 
			<td colspan="4" valign="center" class="titlepic"><span class="whiteheader">&nbsp;Billing&nbsp;&nbsp;Information</span></td>
		  </tr>
		  <tr>
			<td width="262"  class="row1"><b class="red">*</b>Credit&nbsp;Card&nbsp;type:&nbsp;&nbsp;&nbsp;</td>
			<td width="317" valign="middle" class="row2">&nbsp;&nbsp;<select name="CardType">
				<option value="VISA">VISA</option>
				<option value="AMERICAN EXPRESS">American Express</option>
				<option value="MASTERCARD">Mastercard</option>
				<option value="DISCOVER">Discover</option>
				</select></td>
		  </tr>
		  <tr>
			<td  class="row1"><b class="red">*</b>Cardholder's&nbsp;Name<br />&nbsp;&nbsp;<font size=2>(as it appears on the card)</font>&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" size="25" maxlength="60" name="CCFName" id="CCFName" value="<?php if(isset($fname)) echo $fname;?>">
&nbsp;&nbsp;&nbsp;			<input type="text" size="25" maxlength="60" name="CCLName" id="CCLName" value="<?php if(isset($lname)) echo $lname; ?>"></td>
		  </tr>
		  <tr>
			<td  class="row1"><b class="red">*</b>Cardholder's Address:&nbsp;&nbsp;&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="CCAddress" id="idCCAddress" maxlength="60" value="<?php if(isset($address1)) echo $address1; ?>"> </td>
		  </tr>
		  <tr>
		    <td  class="row1"><b class="red">*</b>Cardholder's City </td>
		    <td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="CCCity" id="CCCity" maxlength="60" value="<?php if(isset($city)) echo $city; ?>"></td>
      </tr>
		  <tr>
		    <td  class="row1"><b class="red">*</b>Cardholder's State /Province: </td>
		    <td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="CCState" id="CCState" maxlength="60" value="<?php if(isset($state)) echo $state; ?>"></td>
      </tr>
		  <tr>
		    <td  class="row1"><b class="red">*</b>Cardholder's Zip:&nbsp;&nbsp;&nbsp;</td>
		    <td valign="middle" class="row2">&nbsp;
		      <input type="text" name="CCZip" id="idCCZip" value="<?php if(isset($zip)) echo $zip; ?>" size="15" maxlength="20">
            </td>
		  </tr>
		  <tr>
		    <td  class="row1"><b class="red">*</b>Cardholder's Phone Number:&nbsp;&nbsp;&nbsp;</td>
		    <td valign="middle" class="row2">&nbsp;
	        <input type="text" name="CCPhone" id="idCCPhone" value="<?php if(isset($phone)) echo $phone; ?>" size="20" maxlength="20">            </td>
		  </tr>
		  <tr>
		    <td  class="row1"><b class="red">*</b>Cardholder's Fax:&nbsp;&nbsp;&nbsp;</td>
		    <td valign="middle" class="row2">&nbsp;
		        <input type="text" name="CCFax" id="idCCFax" value="<?php if(isset($fax)) echo $fax; ?>" size="20" maxlength="20">            </td>
		  </tr>
		  <tr>
		    <td  class="row1"><b class="red">*</b>Cardholder's Email address:&nbsp;&nbsp;&nbsp;</td>
		    <td valign="middle" class="row2">&nbsp;
		        <input type="text" name="CCEmail" id="idCCEmail" value="<?php if(isset($email)) echo $email; ?>" size="30" maxlength="30">            </td>
		  </tr>
		  <tr>
		    <td  class="row1"><b class="red">*</b>Cardholder's Country</td>
		    <td valign="middle" class="row2">&nbsp;
				<select name="country">
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
			</select></td>
      </tr>
		  <tr>
		    <td  class="row1">&nbsp;</td>
		    <td valign="middle" class="row2">&nbsp;</td>
      </tr>
		  <tr>
			<td  class="row1"><b class="red">*</b>Credit&nbsp;Card&nbsp;number:&nbsp;&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" maxlength="16" name="CreditCardNumber" value="<?php if(isset($CardNumber)) echo $CardNumber; ?>"> </td>
		  </tr>
		  <tr>
			<td  class="row1"><b class="red">*</b>CVV2 Number<br />(located on back of card):</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input name="CVV2" type="text" id="idCVV2" value="<?php if(isset($CVV2)) echo $CVV2; ?>" size="5" maxlength="3"> <a href="../images/cvv2.bmp" target="_blank" class="BasicText" onClick='window.open("images/cvv2.bmp","Cvv2","width=180,height=335,status=yes,scrollbars=0,resizable=0");return false;' ><strong>Where is my Cvv2?</strong></a> </td>
			
		  </tr>
		  <tr>
			<td  class="row1"><b class="red">*</b>Expiration&nbsp;Date:&nbsp;&nbsp;<br /></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;
			<select name="CreditCardExpMonth" value="<?php 
			if(isset($CardExpMonth)){
			 echo $CardExpMonth; 
			 } else {
			 $CardExpMonth = $HTTP_POST_VARS['CreditCardExpMonth']; }?>">
				<option>01</option>
				<option>02</option>
				<option>03</option>
				<option>04</option>
				<option>05</option>
				<option>06</option>
				<option>07</option>
				<option>08</option>
				<option>09</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
			  </select> &nbsp;&nbsp; <select name="CreditCardExpYear" value="<?php if(isset($CardExpYear)) echo $CardExpYear; ?>">
				<option>2005</option>
				<option>2006</option>
				<option>2007</option>
				<option>2008</option>
				<option>2009</option>
				<option>2010</option>
				<option>2011</option>
				<option>2012</option>
				<option>2013</option>
				<option>2014</option>
				<option>2015</option>
				<option>2016</option>
				<option>2017</option>
				<option>2018</option>
				<option>2019</option>
				<option>2020</option>
				</select> &nbsp;&nbsp;</td>
		  </tr>
			<tr>
			  <td  class="row1">&nbsp;</td>
			  <td valign="middle" class="row2">&nbsp;</td>
	  <tr>
	  <td  class="row1"><b><span class="basictextMED">Total Charge Amount:</span></b>&nbsp;&nbsp;&nbsp;</td>
		<td valign="middle" class="row2"><span class="BasicTextMED"><b>&nbsp;&nbsp;$<?=$amount_due;?></span>
	    </td>
	  <tr>
	    <td colspan="2" align="center" class="row1">&nbsp;</td>
      </tr>
	  <tr>
		<td colspan="2" align="center" class="row1"><input type=submit class="button" value="Process Transaction">
	    </td></tr>


</table>
    <p>&nbsp;</p>
