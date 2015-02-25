		  <tr> 
			<td colspan="3" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;United
			    Kingdon Registration&nbsp;Information</span></td>
		  </tr>
		  <tr>
			<td colspan="2"  valign="top"><b class="red">*</b>Legal Type (REQUIRED)</span></td>
			<td  valign="top">&nbsp;</td>
		  <tr>
		    <td><div align="right">
                <input type="radio" name="uk_legal_type" value="IND" <?php if ( $uk_legal_type == "LTD" ) { echo  "checked"; } ?>>
            </div></td>
		    <td colspan="2"><b>IND</b>: Individual / UK Citizen <br />
		        </td>
  </tr>
				<tr><td><div align="right">
				  <input type="radio" name="uk_legal_type" value="LTD" <?php if ( $uk_legal_type == "LTD" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>LTD</b>: UK Limited Company<br /><span class="red">(Company identification number REQUIRED)</span></td>
				</tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="PLC" <?php if ( $uk_legal_type == "PLC" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>PLC</b>: UK Public Limited Company<br /><span class="red">(Company identification number REQUIRED)</span></td>
				</tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="PTNR" <?php if ( $uk_legal_type == "PTNR" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>PTNR</b>: UK Partnership</td></tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="LLP" <?php if ( $uk_legal_type == "LLP" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>LLP</b>: UK Limited Liability Partnership</td></tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="STRA" <?php if ( $uk_legal_type == "STRA" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>STRA</b>: Sole Trader</td></tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="RCHAR" <?php if ( $uk_legal_type == "RCHAR" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>RCHAR</b>: UK Registered Charity</td></tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="OTHER" <?php if ( $uk_legal_type == "OTHER" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>OTHER</b>: UK Entity (other)</td></tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="FCORP" <?php if ( $uk_legal_type == "FCORP" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>FCORP</b>: Foreign Organization</td></tr>
				<tr><td valign=top><div align="right">
				  <input type="radio" name="uk_legal_type" value="FOTHER" <?php if ( $uk_legal_type == "FOTHER" ) { echo  "checked"; } ?>>
				  </div></td>
				<td colspan="2"><b>FOTHER</b>: Other foreign organizations</td></tr>
		        <tr>
		          <td valign="top">&nbsp;</td>
		          <td width="206" valign="middle">&nbsp;</td>
		          <td valign="middle">&nbsp;</td>
  </tr>
          <tr>
			<td colspan="2" valign="top"><b class="red">*</b>Company ID number <br>(Only for Legal Types noted above)</span></td>
			<td width="224" valign="middle"><input name="uk_reg_co_no" type="text" value="<?php echo $uk_reg_co_no; ?>" size="20"></td>
          </tr>		  <tr>
			<td colspan="2" valign="top"><b class="red">*</b>Registered For <b class="red"></b></td>
			<td valign="middle"><input name="registered_for" type="text" value="<?php echo $registered_for; ?>" size="20"></td>
</tr>


