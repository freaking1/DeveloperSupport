	<tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		  </tr>
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;Canada&nbsp;Registration&nbsp;Information</span></td>
		  </tr>
		  <tr> 
			<td width="40%" height="5" class="tdcolorone" colspan="2">&nbsp;</td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td  class="row1" valign="top" colspan="2"><b class="red">*</b>Legal Type
       			(Only applies to and is required for .CA domain names)</span></td>
			<td valign="middle" class="row1" colspan="2">			
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
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
</table>
	<tr>
			<td align="center" valign="middle" noWrap class="row1" colspan="4">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td class="row1">Registrant of domain (individual or company's name)  </div></td>
                      <td class="row1"><input name="cira_registrant" type="text" id="cira_registrant" size="50" maxlength="50"></td>
                    </tr>
                    <tr>
                      <td class="row1"> Optional description of Registrant  </td>
                      <td class="row1"><input name="cira_registrant_desc" type="text" id="cira_registrant_desc" size="50" maxlength="50"></td>
                    </tr>
                    <tr>
                      <td class="row1"> Trademark Number  </td>
                      <td class="row1"><input name="cira_trademark_no" type="text" id="cira_trademark_no" size="50" maxlength="50"></td>
                    </tr>
                    <tr>
                      <td class="row1"> Organization registered location  </td>
                      <td class="row1"><input name="cira_org_registered_in" type="text" id="cira_org_registered_in" size="50" maxlength="50"></td>
                    </tr>
</table>
</td>
		  </tr>