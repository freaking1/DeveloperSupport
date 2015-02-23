										<form method="post" action="<?php echo "userman.php?show=add&action=add";?>" id="form1" name="form1">
										<input type="hidden" name="action" value="adduser">
                                        <span class="red">
                                        <?php
				  //Print the error message if there is one
	if(isset($message)) {echo '<span class=\"red\">', $message, '</span>';}?>
                                        </span>
  <table width="100%" class="tableO1">                                            <tr>
      <td colspan="2" align="right" valign="top" class="titlepic"><span class="whiteheader"><div align="center">Add User </div></span></td>
                                              </tr>
                                            <tr>
                                              <td width="47%" align="right" valign="top"><b class="red">*</b>Username:&nbsp;&nbsp;</td>
                                              <td width="53%" class="smallblue">                                                  <input name="reguName" type="text" class="formfield" id="reguName" value="<?php if(isset($_POST['reguName'])) echo $_POST['reguName']; ?>" size="18" maxlength="18">                                                  </td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="top"><b class="red">*</b>Password:&nbsp;&nbsp;</td>
                                              <td class="smallblue">
											<input name="password1" type="password" class="formfield" value="" size="18" maxlength="18">                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="top"><b class="red">*</b>Re-type Password:&nbsp;&nbsp;</td>
                                              <td class="smallblue">
                                              <input name="password2" type="password" class="formfield" id="idpassword2" value="" size="18" maxlength="18">                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="top"><b class="red">*</b>Secret Question:&nbsp;&nbsp;</td>
                                              <td class="smallblue">
                                                <input size="40" class="formfield" name="lpquestion" maxlength="250" value="<?php if(isset($_POST['lpquestion'])) echo $_POST['lpquestion']; ?>" type="text">                                                </td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="top"><b class="red">*</b>Secret Answer:&nbsp;</td>
                                              <td class="smallblue">
                                                <input size="40" class="formfield" name="lpanswer" maxlength="250" value="<?php if(isset($_POST['lpanswer'])) echo $_POST['lpanswer']; ?>" type="text">
                                                </td>
                                            </tr>
                                            <tr>
                                              <td align="right">*Make Admin? </td>
                                              <td><select name="isadmin" id="isadmin">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                              </select></td>
                                            </tr>
                                            <tr>
                                              <td align="right">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td align="right"><b class="red">*</b>First Name:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="fname" id="fname" maxlength="60" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right"><b class="red">*</b>Last Name:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="lname" id="lname" maxlength="60" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right"><b class="red">*</b>Email Address:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="email" id="email" maxlength="128" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">Secondary email address:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="second_email" id="second_email" maxlength="128" value="<?php if(isset($_POST['second_email'])) echo $_POST['second_email']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right"><b class="red">*</b>Address1:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="add1" id="add1" maxlength="60" value="<?php if(isset($_POST['add1'])) echo $_POST['add1']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">Address2:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="add2" id="add2" maxlength="60" value="<?php if(isset($_POST['add2'])) echo $_POST['add2']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right"><b class="red">*</b>City:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="city" id="city" maxlength="60" value="<?php if(isset($_POST['city'])) echo $_POST['city']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right"> US State&nbsp;&nbsp;
                                                  <input class="formfield" value="1" name="rspchoice" checked="checked" type="radio">
                                              </td>
                                              <td>
                                                <select name="strStateValue" class="formfield" size="1">
                                                  <option value="<?php if(isset($_POST['strStateValue'])) echo $_POST['strStateValue']; ?>" selected="selected"> </option>
                                                  <option value="AL">Alabama </option>
                                                  <option value="AK">Alaska </option>
                                                  <option value="AS">American Samoa </option>
                                                  <option value="AZ">Arizona </option>
                                                  <option value="AR">Arkansas </option>
                                                  <option value="CA">California </option>
                                                  <option value="CO">Colorado </option>
                                                  <option value="CT">Connecticut </option>
                                                  <option value="DE">Delaware </option>
                                                  <option value="DC">District of Columbia </option>
                                                  <option value="FM">Fed. States of Micronesia </option>
                                                  <option value="FL">Florida </option>
                                                  <option value="GA">Georgia </option>
                                                  <option value="GU">Guam </option>
                                                  <option value="HI">Hawaii </option>
                                                  <option value="ID">Idaho </option>
                                                  <option value="IL">Illinois </option>
                                                  <option value="IN">Indiana </option>
                                                  <option value="IA">Iowa </option>
                                                  <option value="KS">Kansas </option>
                                                  <option value="KY">Kentucky </option>
                                                  <option value="LA">Louisiana </option>
                                                  <option value="ME">Maine </option>
                                                  <option value="MH">Marshall Islands </option>
                                                  <option value="MD">Maryland </option>
                                                  <option value="MA">Massachusetts </option>
                                                  <option value="MI">Michigan </option>
                                                  <option value="MN">Minnesota </option>
                                                  <option value="MS">Mississippi </option>
                                                  <option value="MO">Missouri </option>
                                                  <option value="MT">Montana </option>
                                                  <option value="NE">Nebraska </option>
                                                  <option value="NV">Nevada </option>
                                                  <option value="NH">New Hampshire </option>
                                                  <option value="NJ">New Jersey </option>
                                                  <option value="NM">New Mexico </option>
                                                  <option value="NY">New York </option>
                                                  <option value="NC">North Carolina </option>
                                                  <option value="ND">North Dakota </option>
                                                  <option value="MP">Northern Mariana Is. </option>
                                                  <option value="OH">Ohio </option>
                                                  <option value="OK">Oklahoma </option>
                                                  <option value="OR">Oregon </option>
                                                  <option value="PW">Palau </option>
                                                  <option value="PA">Pennsylvania </option>
                                                  <option value="PR">Puerto Rico </option>
                                                  <option value="RI">Rhode Island </option>
                                                  <option value="SC">South Carolina </option>
                                                  <option value="SD">South Dakota </option>
                                                  <option value="TN">Tennessee </option>
                                                  <option value="TX">Texas </option>
                                                  <option value="UT">Utah </option>
                                                  <option value="VT">Vermont </option>
                                                  <option value="VA">Virginia </option>
                                                  <option value="VI">Virgin Islands </option>
                                                  <option value="WA">Washington </option>
                                                  <option value="WV">West Virginia </option>
                                                  <option value="WI">Wisconsin </option>
                                                  <option value="WY">Wyoming </option>
                                                  <option value="AA">Armed Forces the Americas </option>
                                                  <option value="AE">Armed Forces Europe </option>
                                                  <option value="AP">Armed Forces Pacific </option>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">Province&nbsp;&nbsp;
                                                  <input class="formfield" value="2" name="rspchoice" type="radio"></td>
                                              <td><input name="province" maxlength="60" class="formfield" value="<?php if(isset($_POST['province'])) echo $_POST['province']; ?>" type="text"></td>
                                            </tr>
                                            <tr>
                                              <td align="right">Not Applicable&nbsp;&nbsp;
                                                  <input class="formfield" value="3" name="rspchoice" type="radio"></td>
                                              <td>(the state/province field will be left blank)</td>
                                            </tr>
                                            <tr>
                                              <td align="right"><b class="red">*</b>Postal/ZIP Code:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="zip" id="zip" maxlength="15" value="<?php if(isset($_POST['zip'])) echo $_POST['zip']; ?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right"><b class="red">*</b>Country:&nbsp;&nbsp;</td>
                                              <td><select name="country" class="formfield" id="country" value="<?php if(isset($_POST['reguName'])) echo $_POST['reguName']; ?>">
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
                                              <td align="right"><b class="red">*</b>Country Phone Code:&nbsp;&nbsp;</td>
                                              <td><select name="countrycode" class="formfield" id="countrycode" value="<?php if(isset($_POST['countrycode'])) echo $_POST['countrycode']; ?>">
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
                                            <tr>
                                              <td align="right" valign="top"><b class="red">*</b>Phone:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="phone" id="phone" maxlength="20" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" type="text">
                                                <br>
    (numbers only, no dashes or dots)</td>
                                            </tr>
                                            <tr>
                                              <td height="41" align="right" valign="top">Fax:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="fax" id="fax" maxlength="20" value="<?php if(isset($_POST['fax'])) echo $_POST['fax']; ?>" type="text">
                                                <br>
    (numbers only, no dashes or dots) </td>
                                            </tr>
                                            <tr>
                                              <td colspan="2" align="right" valign="top"><div align="center">
  <input name="image" type="image" src="../../../images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">
&nbsp;<a href="userman.php" class="main"><img src="../../../images/btn_cancel.gif" width="74" height="22" border="0"></a></div></td>
                                            </tr>
                                    </table>
</form>
