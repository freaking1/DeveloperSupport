<?php
	session_start();
	
	$tldArray = array("com", "net", "org", "info", "us", "biz", "name", "ca", "tv", "ws", "bz", "nu", "cn", "cc", "co.uk", "org.uk");
	//remove periods (.) from the next array
	$tldArray_2 = array("com", "net", "org", "info", "us", "biz", "name", "ca", "tv", "ws", "bz", "nu", "cn", "cc", "couk", "orguk");
	$count = count($tldArray);

	$tldselected = $HTTP_POST_VARS[ "tldselect" ];

	$tldcount = count ($tldselected);
	for ($j = 0; $j < $tldcount; $j++)
	{
			$tldList .= "<option <?php if ( \$cTld==\"" . $tldselected[$j] . "\" ) { echo \"selected\"; } ?>>" . $tldselected[$j] . "</option>\n";
			$tldHoldList .= "\$" . str_replace(".", "", $tldselected[$j]) . "= 1;\n";
	}

	//set up TLD list
	
	if ($HTTP_POST_VARS[ "tldsetup" ] == 1 or $HTTP_POST_VARS[ "original" ] == 1) {		
		$tldfile = fopen("./tldListOne.php", "w");
		fwrite($tldfile, "<select name=\"tld\">\n" . $tldList . "</select>");
		fclose($tldfile);		
		$tldHoldfile = fopen("./tldHoldList.php", "w");
		fwrite($tldHoldfile, "<?php\n" . $tldHoldList . "?>");
		fclose($tldHoldfile);
	}	
	include ('./tldHoldList.php');
	
	//set page name
	$PageName = "TLDSetup";
	
	//Set Page Title
	$PageTitle = "Style Sheet Set Up Page";

	//This file must be inluded.
	include('../include/header.php'); 
	
	// Begin page content
?>
<script language="JavaScript">

    function ToggleAll(e)
    {
	if (e.checked) {
	    CheckAll();
	}
	else {
	    ClearAll();
	}
	
    function Check(e)
    {
	e.checked = true;
    }

    function Clear(e)
    {
	e.checked = false;
    }
	
	function CheckAll()
    {
	var ml = document.messageList;
	var len = ml.elements.length;
	for (var i = 0; i < len; i++) {
	    var e = ml.elements[i];
	    if (e.name == "tldselect[]") {
		Check(e);
	    }
	}
	ml.toggleAll.checked = true;
    }

    function ClearAll()
    {
	var ml = document.messageList;
	var len = ml.elements.length;
	for (var i = 0; i < len; i++) {
	    var e = ml.elements[i];
	    if (e.name == "tldselect[]") {
		Clear(e);
	    }
	}
	ml.toggleAll.checked = false;
    }
}
</script>
<tr> 

	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="740" border="0" align="center">
		<form action="TLDSetup.php" method="post" name="messageList">
		<input type="hidden" name="tldsetup" value="1">
		<!-- Choose TLDs -->
			<tr> 
				<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Configure TLDs Offered</span></td>
			</tr>
				<tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
				<td width="40%" height="5" class="tdcolorone"><span class=cattitle>Choose TLDs</span></td>
				<td class="rowpic" align="right" colspan="2">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
				<td width="40%" align="left" valign="middle" class="row1">&nbsp;</td>
				<td width="50%" align="left" valign="middle" class="row2" >&nbsp;&nbsp;<input name="toggleAll" type="checkbox" title="Select or deselect all messages" onclick="ToggleAll(this);">&nbsp;<strong>Select/Clear All</strong></td>
				<td width="5%" align="center" valign="middle" noWrap class="row2">&nbsp;</td>
			</tr>
						
			<?php 
			//put future tlds in the array
			for ($i=0;$i<$count;$i++) {
					echo "<tr>\n";
					echo "<td width=\"5%\" valign=\"middle\" class=\"row1\">&nbsp;</td>\n";
					echo "<td width=\"40%\" align=\"right\" valign=\"middle\" class=\"row1\">.";
					echo $tldArray[$i];
					echo "</td>\n";
					echo "<td width=\"50%\" valign=\"middle\" class=\"row2\">&nbsp;&nbsp;<input name=\"tldselect[]\" type=\"checkbox\" value=\"";
					echo $tldArray[$i];
					echo "\"";
					if ($$tldArray_2[$i] == 1){
						echo "checked";
					}
					echo "></td>\n";
					echo "<td width=\"5%\" valign=\"middle\" noWrap class=\"row2\"><img src=\"../images/blank.gif\" width=\"8\" height=\"10\" border=\"0\"></td>\n";
					echo "</tr>\n";
				}
			?>
			<tr>
				<td align="center" valign="middle" class="row1">&nbsp;</td>
				<td align="left" valign="middle" class="row1">&nbsp;</td>
				<td align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="image" src="../images/btn_submit.gif" border="0" width="74" height="22"></td>
				<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
			</tr>
			
			<tr> 
				<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
			</tr>
		</form>
			</table>
			</td>
			</tr>
			  
			<? include('../include/footer.php'); ?>