		  <tr> 
			<td colspan="5" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;Canada&nbsp;Registration&nbsp;Information</span></td>
		  </tr>
		  <tr>
			<td width="181" valign="top"><b class="red">*</b>Legal Type
       			(REQUIRED)</span></td>
			<td colspan="2" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="CCO" <?php if ( $cira_legal_type == "CCO" ) { echo  "checked"; } ?>></td>
				<td><b>CCO</b>: Corporation (Canada or Canadian province or territory)</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="CCT" <?php if ( $cira_legal_type == "CCT" ) { echo  "checked"; } ?>></td>
				<td><b>CCT</b>: Canadian Citizen</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="RES" <?php if ( $cira_legal_type == "RES" ) { echo  "checked"; } ?>></td>
				<td><b>RES</b>: Permanent Resident of Canada</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="GOV" <?php if ( $cira_legal_type == "GOV" ) { echo  "checked"; } ?>></td>
				<td><b>GOV</b>: Government or government entity in Canada</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="EDU" <?php if ( $cira_legal_type == "EDU" ) { echo  "checked"; } ?>></td>
				<td><b>EDU</b>: Canadian Educational Institution</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="ASS" <?php if ( $cira_legal_type == "ASS" ) { echo  "checked"; } ?>></td>
				<td><b>ASS</b>: Canadian Unincorporated Association</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="HOP" <?php if ( $cira_legal_type == "HOP" ) { echo  "checked"; } ?>></td>
				<td><b>HOP</b>: Canadian Hospital</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="PRT" <?php if ( $cira_legal_type == "PRT" ) { echo  "checked"; } ?>></td>
				<td><b>PRT</b>: Partnership Registered in Canada</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="TDM" <?php if ( $cira_legal_type == "TDM" ) { echo  "checked"; } ?>></td>
				<td><b>TDM</b>: Trade-mark registered in Canada (by a non-Canadian owner)</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="TRD" <?php if ( $cira_legal_type == "TRD" ) { echo  "checked"; } ?>></td>
				<td><b>TRD</b>: Canadian Trade Union</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="PLT" <?php if ( $cira_legal_type == "PLT" ) { echo  "checked"; } ?>></td>
				<td><b>PLT</b>: Canadian Political Party</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="LAM" <?php if ( $cira_legal_type == "LAM" ) { echo  "checked"; } ?>></td>
				<td><b>LAM</b>: Canadian Library, Archive, or Museum</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="TRS" <?php if ( $cira_legal_type == "TRS" ) { echo  "checked"; } ?>></td>
				<td><b>TRS</b>: Trust established in Canada</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="ABO" <?php if ( $cira_legal_type == "ABO" ) { echo  "checked"; } ?>></td>
				<td><b>ABO</b>: Aboriginal Peoples (individuals or groups) indigenous to Canada</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="INB" <?php if ( $cira_legal_type == "INB" ) { echo  "checked"; } ?>></td>
				<td><b>INB</b>: Indian Band Description14=Indian Band recognized by the Indian Act of Canada</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="LGR" <?php if ( $cira_legal_type == "LGR" ) { echo  "checked"; } ?>></td>
				<td><b>LGR</b>: Legal Representative of a Canadian Citizen or Permanent Resident</td></tr>
				<tr><td valign=top><input type="radio" name="cira_legal_type" value="OMK" <?php if ( $cira_legal_type == "OMK" ) { echo  "checked"; } ?>></td>
				<td><b>OMK</b>: Official mark registered in Canada</td></tr>
				<tr>
					<td valign=top><input type="radio" name="cira_legal_type" value="MAJ" <?php if ( $cira_legal_type == "MAJ" ) { echo  "checked"; } ?>></td>
					<td><b>MAJ</b>: Her Majesty the Queen</td>
				</tr>
				</table></td>
		  </tr>
		  <tr>
		    <td colspan="2" valign="top"> <strong>Registrant of domain (individual or company's name) </strong><strong>* </strong> </td>
		    <td width="364" valign="middle" ><input name="cira-registrant" type="text" value="<?php if(isset($_POST['cira-registrant'])) echo $_POST['cira-registrant']; ?>" size="20"></td>
  </tr>
		  <tr>
		    <td colspan="2" valign="top"> <strong>Optional description of Registrant </strong> </td>
		    <td valign="middle" ><input name="cira-registrant-desc" type="text" value="<?php if(isset($_POST['cira-registrant-desc'])) echo $_POST['cira-registrant-desc']; ?>" size="20"></td>
  </tr>
		  <tr>
		    <td colspan="2" valign="top"> <strong>Trademark Number </strong> </td>
		    <td valign="middle"><input name="cira-trademark-no" type="text" value="<?php if(isset($_POST['cira-trademark-no'])) echo $_POST['cira-trademark-no']; ?>" size="20"></td>
  </tr>
		  <tr>
		    <td colspan="2" valign="top"> <strong>Organization registered location </strong> </td>
		    <td valign="middle"><input name="cira-org-registered-in" type="text" value="<?php if(isset($_POST['cira-org-registered-in'])) echo $_POST['cira-org-registered-in']; ?>" size="20"></td>
  </tr>
		  <tr>
		    <td colspan="4" valign="top" class="BasicText" > <strong>Note: </strong>Updates to registration data cannot be made after successful registration - Please verify data before hitting submit. <br>
              <br>
Please note that CIRA, the Canadian organization that operates the .ca registry, requires everyone who registers a domain name with the .ca registry to meet the .ca Canadian Presence Requirements (CPR). You can find these at: <a href="http://www.cira.ca/en/cat_Registration.html">http://www.cira.ca/en/cat_Registration.html </a>. <br>
<br>
If you do not meet any of the Canadian Presence Requirements please do not apply for a .ca domain name. If you do not meet the CPR when you apply for a registration, CIRA will reject your Registration Request and you may forfeit your registration fees. <br>
<br>
If you have an Organization Name in the Registrant Information above, do not select <strong>Canadian Citizen </strong> from the <strong>Legal Type of registrant </strong> contact dropdown. The Registry will not process your order. If you enter an organization, it must be your legally registered company name, followed by the geographical location, i.e., Water Lily Florist, Inc. (BC). <br>
<br>
After a successful registration, CIRA will send the administrative contact an email to authorize the registration. You must approve the registration within seven days or CIRA will cancel the domain and the domain becomes available for registration to anyone. <br>
<br>
CIRA may require additional information after a successful registration to prove you meet the Canadian Presence Requirements. This may include a copy of your passport or business registration as an example. <br>
<br>
See the <strong>Legal type of registrant contact </strong> list above for complete requirements for each legal type. If you do not meet the CPR after you are granted a .ca domain name registration, CIRA may cancel all of your domain name registrations without a refund. </Div><br></td>
  </tr>
		  
		  
