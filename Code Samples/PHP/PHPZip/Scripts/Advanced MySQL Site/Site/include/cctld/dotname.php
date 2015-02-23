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
			<td align="center" valign="middle">&nbsp;</td>
			<td align="center" valign="middle">&nbsp;</td>
			<td align="center" valign="middle">&nbsp;</td>
		    <td align="center" valign="middle">&nbsp;</td>
	</tr>
		<!-- this begins section Four -->
		<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader"> <strong>.Name</strong> Email Forwarding Information</span></td>
		</tr>
		<tr> 
			<td height="3" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="40%" valign="middle"><b class="red">*</b>Add Email Forwarding (additional Fee) </td>
			<td colspan="2" valign="middle">&nbsp;&nbsp;&nbsp;<input type="radio" name="idforwardOptionYes" id="idforwardOptionYes" value="yes" onclick="yesshow();" checked>
			&nbsp;Yes&nbsp;<input type="radio" name="idforwardOptionNo" id="idforwardOptionNo" value="no" onclick="noshow();">&nbsp;No</td>
		</tr>
		<tr>
			<td valign="middle">Email Forwarding Address</td>
			<td colspan="2" valign="middle">&nbsp;&nbsp;&nbsp;<input type="text" name="forwardmailto" value="Enter email address" onClick="this.value=''" /></td>
		</tr>
		<tr>
		  <td valign="middle">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
  </tr>
		
		
