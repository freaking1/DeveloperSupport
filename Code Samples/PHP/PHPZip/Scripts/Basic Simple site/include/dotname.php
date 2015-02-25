		<script language="JavaScript">
		function noshow() {
			document.form1.forwardmailto.value="";
			document.form1.forwardmailto.disabled=true;
		}
		function yesshow() {
			document.form1.forwardmailto.value="Enter email address";
			document.form1.forwardmailto.disabled=false;
		}
		function eraseName() {
			document.form1.forwardmailto.reset;
		}
		</script>
		<tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		</tr>
		<!-- this begins section Four -->
		<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader"> <strong>dot name</strong> Email Forwarding Information</span></td>
		</tr>
		<tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" class="tdcolorone">&nbsp;</td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td class="row1" valign="middle"><b class="red">*</b>Add Email Forwarding</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;<input type="radio" name="idforwardOptionYes" id="idforwardOptionYes" value="yes" onclick="yesshow();" checked>
			&nbsp;Yes&nbsp;<input type="radio" name="idforwardOptionNo" id="idforwardOptionNo" value="no" onclick="noshow();">&nbsp;No</td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td class="row1" valign="middle">Email Forwarding Address</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;&nbsp;<input type="text" name="forwardmailto" value="Enter email address" onClick="this.value=''" /></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		</tr>
		