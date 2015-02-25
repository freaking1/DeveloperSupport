	<tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		  </tr>
		  <!-- this begins section Four -->
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;United
			    Kingdon Registration&nbsp;Information</span></td>
		  </tr>
		  <tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" class="tdcolorone">&nbsp;</td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1" valign="top"><b class="red">*</b>Legal Type
       			(Only applies to and is required for .UK domain names)</span></td>
			<td valign="middle" class="row2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="IND" <?php if ( $uk_legal_type == "IND" ) { echo  "checked"; } ?>></td>
				<td><b>IND</b>: Individual (our default value)</td></tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="LTD" <?php if ( $uk_legal_type == "LTD" ) { echo  "checked"; } ?>></td>
				<td><b>LTD</b>: UK Limited Company<br /><span class="red">(Company identification number REQUIRED)</span></td>
				</tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="PLC" <?php if ( $uk_legal_type == "PLC" ) { echo  "checked"; } ?>></td>
				<td><b>PLC</b>: UK Public Limited Company<br /><span class="red">(Company identification number REQUIRED)</span></td>
				</tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="PTNR" <?php if ( $uk_legal_type == "PTNR" ) { echo  "checked"; } ?>></td>
				<td><b>PTNR</b>: UK Partnership</td></tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="LLP" <?php if ( $uk_legal_type == "LLP" ) { echo  "checked"; } ?>></td>
				<td><b>LLP</b>: UK Limited Liability Partnership</td></tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="STRA" <?php if ( $uk_legal_type == "STRA" ) { echo  "checked"; } ?>></td>
				<td><b>STRA</b>: Sole Trader</td></tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="RCHAR" <?php if ( $uk_legal_type == "RCHAR" ) { echo  "checked"; } ?>></td>
				<td><b>RCHAR</b>: UK Registered Charity</td></tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="OTHER" <?php if ( $uk_legal_type == "OTHER" ) { echo  "checked"; } ?>></td>
				<td><b>OTHER</b>: UK Entity (other)</</td></tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="FCORP" <?php if ( $uk_legal_type == "FCORP" ) { echo  "checked"; } ?>></td>
				<td><b>FCORP</b>: Foreign Organization</td></tr>
				<tr><td valign=top><input type="radio" name="uk_legal_type" value="FOTHER" <?php if ( $uk_legal_type == "FOTHER" ) { echo  "checked"; } ?>></td>
				<td><b>FOTHER</b>: Other foreign organizations</td></tr>
				</table></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1" valign="top"><b class="red">*</b>Company identification number<br />(required for Legal Types noted)</span></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input name="uk_reg_co_no" type="text" value="<?php echo $uk_reg_co_no; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <td>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1" valign="top"><b class="red">*</b>Name of the Registrant / Company <br />
			(Careful - This can not be changed easily)</span></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input name="registered_for" type="text" value="<?php echo $registered_for; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>