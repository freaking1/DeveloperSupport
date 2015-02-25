<?php
	session_start();
	
	//Set the default style sheet
	if ($HTTP_POST_VARS[ "original" ] == 1) {		
		$othernewfile = fopen("./stylevalues.php", "w");
		fwrite($othernewfile, "
		<?php
		\$scrollbarfacecolor = \"#dee3e7\";
		\$scrollbarhighlightcolor = \"#ffffff\"; 
		\$scrollbarshadowcolor = \"#dee3e7\"; 
		\$scrollbar3Dlightcolor = \"#d1d7dc\"; 
		\$scrollbararrowcolor =\"#313187\"; 
		\$scrollbartrackcolor = \"#efefef\"; 
		\$scrollbardarkshadowcolor = \"#98aab1\";
		\$backgroundcolor = \"#e5e5e5\"; 
		\$headerfontweight  = \"bold\";
		\$headerfontsize  = \"14px\";
		\$headercolor  = \"#000000\";
		\$whiteheaderfontweight  = \"bold\";
		\$whiteheaderfontsize  = \"14px\";
		\$whiteheadercolor  = \"#ffffff\";
		\$alinkcolor  = \"#313187\";
		\$aactivecolor  = \"#313187\";
		\$avdc  = \"#313187\";
		\$ahcol  = \"red\";
		\$ahtdx  = \"none\";
		\$borderrt = \"#313187\"; 
		\$bordertop = \"#313187\"; 
		\$borderlt = \"#313187\";
		\$borderbt = \"#313187\"; 
		\$tableOO = \"#ffffff\";
		\$mainf = \"12px\";
		\$mainc = \"#000000\";
		\$mainff = \"Verdana, Arial\";
		\$cattitlefw = \"bold\";
		\$ctfsz = \"12px\";
		\$ctc = \"#ffffff\"; 
		\$ctlsg = \"1px\";
		\$tpbgi1 = \"cellpic3.gif\";
		\$tpbgr1 = \"repeat-x\";
		\$tpbgc1 = \"\";
		\$tdfsz = \"12px\";
		\$tdcolor = \"#000000\"; 
		\$tdff = \"Verdana, Arial\";
		\$tdr1bgc = \"#efefef\";
		\$tdr2bgc = \"#D6D6D6\";
		\$tdrpbgi = \"cellpic2.jpg\"; 
		\$tdrpbgr = \"repeat-y\";
		\$tdrpbgc = \"#ffffff\";
		\$tdcobgc = \"#BF3155\";
		\$tdoutbr = \"#98aab1\";
		\$tdoutbt = \"#98aab1\"; 
		\$tdoutbl = \"#98aab1\"; 
		\$tdoutbb = \"#98aab1\";  
		\$tdoutbgc = \"#ffffff\";
		\$crfsz = \"10px\"; 
		\$crcolor = \"#444444\";
		\$crff = \"Verdana, sans-serif\";
		\$crspace = \"-1px\";
		\$accolor = \"#444444\"; 
		\$actextd = \"none\";
		\$achoverc = \"#000000\"; 
		\$achovertd = \"underline\";
		?>
		");
		fclose($othernewfile);
		
	} else if($HTTP_POST_VARS[ "update" ] == 1) {
		//Set up the custom style sheet	
		$newfile = fopen("../css/styles.css", "w");
		fwrite($newfile, "
		body {background-color: $backgroundcolor;scrollbar-face-color: $scrollbarfacecolor; scrollbar-highlight-color: $scrollbarhighlightcolor; scrollbar-shadow-color: $scrollbarshadowcolor; scrollbar-3Dlight-color: $scrollbar3Dlightcolor; scrollbar-arrow-color: $scrollbararrowcolor; scrollbar-track-color: $scrollbartrackcolor; scrollbar-darkshadow-color: $scrollbardarkshadowcolor; }
		.header {font-weight: $headerfontweight; font-size: $headerfontsize; color: $headercolor;}
		.whiteheader {font-weight: $whiteheaderfontweight; font-size: $whiteheaderfontsize; color: $whiteheadercolor;}
		a:link {color: $alinkcolor}
		a:active {color: $aactivecolor}
		a:visited {color: $avdc}
		a:hover {color: $ahcol; text-decoration: $ahtdx;}
		.tableOO {border-right: $borderrt 2px solid; border-top: $bordertop 2px solid; border-left: $borderlt 2px solid; border-bottom: $borderbt 2px solid; background-color: $tableOO}
		.main {font-size: $mainf; color: $mainc; font-family: $mainff;}
		.cattitle {font-weight: $cattitlefw; font-size: $ctfsz; color: $ctc; letter-spacing: $ctlsg;}
		.titlepic {background-image:  url(../images/$tpbgi1);background-repeat: $tpbgr1; background-color: $tpbgc1;}
		.red {color: red}
		td {font-size: $tdfsz; color: $tdcolor; font-family: $tdff;}
		td.row1 {background-color: $tdr1bgc;}
		td.row2 {background-color: $tdr2bgc;}
		td.rowpic {background-image:  url(../images/$tdrpbgi); background-repeat: $tdrpbgr;background-color: $tdrpbgc;}
		td.tdcolorone {background-color:  $tdcobgc;}
		td.OutlineOne {border-right: $tdoutbr 1px solid; border-top: $tdoutbt 1px solid; border-left: $tdoutbl 1px solid; border-bottom: $tdoutbb 1px solid;  background-color: $tdoutbgc;}
		.copyright {font-size: $crfsz; color: $crcolor; font-family: $crff;letter-spacing: $crspace;}
		a.copyright {color: $accolor; text-decoration: $actextd;}
		a.copyright:hover {color: $achoverc; text-decoration: $achovertd;}
		");
		fclose($newfile);
		
		//write the include to prefill the form fields
		$othernewfile = fopen("./stylevalues.php", "w");
		fwrite($othernewfile, "
		<?php
		\$scrollbarfacecolor = \"$scrollbarfacecolor\"; 
		\$scrollbarhighlightcolor = \"$scrollbarhighlightcolor\"; 
		\$scrollbarshadowcolor = \"$scrollbarshadowcolor\"; 
		\$scrollbar3Dlightcolor = \"$scrollbar3Dlightcolor\";
		\$scrollbararrowcolor =\"$scrollbararrowcolor\"; 
		\$scrollbartrackcolor = \"$scrollbartrackcolor\"; 
		\$scrollbardarkshadowcolor = \"$scrollbardarkshadowcolor\";
		\$backgroundcolor = \"$backgroundcolor\"; 
		\$headerfontweight  = \"$headerfontweight\";
		\$headerfontsize  = \"$headerfontsize\";
		\$headercolor  = \"$headercolor\";
		\$whiteheaderfontweight  = \"$whiteheaderfontweight\";
		\$whiteheaderfontsize  = \"$whiteheaderfontsize\";
		\$whiteheadercolor  = \"$whiteheadercolor\";
		\$alinkcolor  = \"$alinkcolor\";
		\$aactivecolor  = \"$aactivecolor\";
		\$avdc  = \"$avdc\";
		\$ahcol  = \"$ahcol\";
		\$ahtdx  = \"$ahtdx\";
		\$borderrt = \"$borderrt\"; 
		\$bordertop = \"$bordertop\"; 
		\$borderlt = \"$borderlt\";
		\$borderbt = \"$borderbt\"; 
		\$tableOO = \"$tableOO\";
		\$mainf = \"$mainf\";
		\$mainc = \"$mainc\";
		\$mainff = \"$mainff\";
		\$cattitlefw = \"$cattitlefw\";
		\$ctfsz = \"$ctfsz\";
		\$ctc = \"$ctc\"; 
		\$ctlsg = \"$ctlsg\";
		\$tpbgi1 = \"$tpbgi1\";
		\$tpbgr1 = \"$tpbgr1\";
		\$tpbgc1 = \"$tpbgc1\";
		\$tdfsz = \"$tdfsz\";
		\$tdcolor = \"$tdcolor\"; 
		\$tdff = \"$tdff\";
		\$tdr1bgc = \"$tdr1bgc\";
		\$tdr2bgc = \"$tdr2bgc\";
		\$tdrpbgi = \"$tdrpbgi\"; 
		\$tdrpbgr = \"$tdrpbgr\";
		\$tdrpbgc = \"$tdrpbgc\";
		\$tdcobgc = \"$tdcobgc\";
		\$tdoutbr = \"$tdoutbr\";
		\$tdoutbt = \"$tdoutbt\"; 
		\$tdoutbl = \"$tdoutbl\"; 
		\$tdoutbb = \"$tdoutbb\";  
		\$tdoutbgc = \"$tdoutbgc\";
		\$crfsz = \"$crfsz\"; 
		\$crcolor = \"$crcolor\";
		\$crff = \"$crff\";
		\$crspace = \"$crspace\";
		\$accolor = \"$accolor\"; 
		\$actextd = \"$actextd\";
		\$achoverc = \"$achoverc\"; 
		\$achovertd = \"$achovertd\";
		?>
		");
		fclose($othernewfile);
	}

	//This file must be inluded for the auto value fill in on the text fields
	include('stylevalues.php'); 
	
	//set page name
	$PageName = "StyleSetup";
	
	//Set Page Title
	$PageTitle = "Style Sheet Set Up Page";

	//This file must be inluded.
	include('../include/header.php'); 
	
	// Begin page content
?>
<script>
function refresh()
{ alert('Hit REFRESH to see your changes!')}
</script>
<tr> 
	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="740" border="0" align="center">
		<form action="StyleSetup.php" method="post" name="originalstyleform">
		<input type="hidden" name="original" value="1">
		
			<tr> 
				<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Style Sheet Updater</span></td>
			</tr>
			<tr> 
				<td class="tdcolorone" height="5">&nbsp;</td>
				<td width="40%" height="5" align="left" valign="middle" class="tdcolorone"><span class=cattitle>Instructions</span></td>
				<td class="rowpic" align="right" colspan="2">&nbsp;</td>
			</tr>
					
			<tr>
				<td height="124" align="center" valign="middle" class="row1">&nbsp;</td>
				<td colspan="2" align="center" valign="middle" class="row1">
				<p>Here you can set the values for your style sheet.</p>
				<p>For colors, you can enter the hex value (ex. #000000), or one of the color words that is natively read, such as red, blue, yellow, black, etc.
				</p>
				<p>For the background cell images in both titlepic and TD.rowpic, first put the image you want to use in the folder 'images'. Then, type in the name of image in the form field.</p>
				  <table width="500" border="0">
					<tr>
					  <td width="426" align="center" valign="middle">Click SUBMIT to reset the style sheet back to its original values:&nbsp;</td>
					  <td width="74" align="center" valign="middle"><input type="image"  src="../images/btn_submit.gif" width="74" height="22" border="0"></td>
					</tr>
				  </table><br /></td>
				<td align="center" valign="middle" noWrap class="row1">&nbsp;</td>
			</tr>
			
			<tr> 
				<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Table Cell, class="whiteheader"</span></td>
			</tr>
			
			<tr> 
				<td class="tdcolorone" height="5">&nbsp;</td>
				<td width="40%" height="5" class="tdcolorone"><span class=cattitle>Cell Title, class=cattitle</span></td>
				<td class="rowpic" align="right" colspan="2">&nbsp;</td>
			</tr>
			
			<tr> 
				<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
				<td width="40%" align="center" valign="middle" class="row1"><span class=main>class="row1"; class=main</span></td>
				<td width="50%" align="center" valign="middle" class="row2"><span class=main>class="row2"; class=main</span></td>
				<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
			<tr> 
				<td colspan="4" align="center" valign="middle" class="row1">Test the link <a href="#">here</a> or <a href="#">here</a> or <a href="#">here</a></td>
			</tr>
			
			<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;</span></td>
			</tr>
			<tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" align="left" valign="middle" class="tdcolorone"><span class=cattitle>Classes</span></td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
			</tr>
			</form>
			<form action="StyleSetup.php" method="post" name="setupform">
			<input type="hidden" name="update" value="1">
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>body</strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">scrollbar-face-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input name="scrollbarfacecolor" type="text" id="scrollbarfacecolor" value="<? echo $scrollbarfacecolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">scrollbar-highlight-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="scrollbarhighlightcolor" value="<? echo $scrollbarhighlightcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
							
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">scrollbar-shadow-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="scrollbarshadowcolor" value="<? echo $scrollbarshadowcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">scrollbar-3Dlight-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="scrollbar3Dlightcolor" value="<? echo $scrollbar3Dlightcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr> 
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">scrollbar-arrow-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="scrollbararrowcolor" value="<? echo $scrollbararrowcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr> 
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">scrollbar-track-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="scrollbartrackcolor" value="<? echo $scrollbartrackcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr> 
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">scrollbar-darkshadow-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="scrollbardarkshadowcolor" value="<? echo $scrollbardarkshadowcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr> 
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:&nbsp;</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="backgroundcolor" value="<? echo $backgroundcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>.header </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">headerfont-weight: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="headerfontweight">
			<?php if ($headerfontweight != "") { ?><option value="<? echo $headerfontweight; ?>"><? echo $headerfontweight; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="normal">normal</option>
			<option value="bold">bold</option>
			<option value="bolder">bolder</option>
			<option value="lighter">lighter</option>
			<option value="100">100</option>
			<option value="200">200</option>
			<option value="300">300</option>
			<option value="400">400</option>
			<option value="500">500</option>
			<option value="600">600</option>
			<option value="700">700</option>
			<option value="800">800</option>
			<option value="900">900</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">headerfont-size: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="headerfontsize">
			<?php if ($headerfontsize != "") { ?><option value="<? echo $headerfontsize; ?>"><? echo $headerfontsize; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="6px">6px</option>
			<option value="8px">8px</option>
			<option value="10px">10px</option>
			<option value="12px">12px</option>
			<option value="14px">14px</option>
			<option value="16px">16px</option>
			<option value="18px">18px</option>
			<option value="20px">20px</option>
			<option value="24px">24px</option>
			<option value="28px">28px</option>
			<option value="32px">32px</option>
			<option value="36px">36px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">headercolor: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="headercolor" value="<? echo $headercolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>.whiteheader </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-weight: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="whiteheaderfontweight">
			<?php if ($whiteheaderfontweight != "") { ?><option value="<? echo $whiteheaderfontweight; ?>"><? echo $whiteheaderfontweight; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="normal">normal</option>
			<option value="bold">bold</option>
			<option value="bolder">bolder</option>
			<option value="lighter">lighter</option>
			<option value="100">100</option>
			<option value="200">200</option>
			<option value="300">300</option>
			<option value="400">400</option>
			<option value="500">500</option>
			<option value="600">600</option>
			<option value="700">700</option>
			<option value="800">800</option>
			<option value="900">900</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-size: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="whiteheaderfontsize">
			<?php if ($whiteheaderfontsize != "") { ?><option value="<? echo $whiteheaderfontsize; ?>"><? echo $whiteheaderfontsize; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="6px">6px</option>
			<option value="8px">8px</option>
			<option value="10px">10px</option>
			<option value="12px">12px</option>
			<option value="14px">14px</option>
			<option value="16px">16px</option>
			<option value="18px">18px</option>
			<option value="20px">20px</option>
			<option value="24px">24px</option>
			<option value="28px">28px</option>
			<option value="32px">32px</option>
			<option value="36px">36px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="whiteheadercolor" value="<? echo $whiteheadercolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>a:link </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="alinkcolor" value="<? echo $alinkcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>a:active </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="aactivecolor" value="<? echo $aactivecolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>a:visited </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="avdc" value="<? echo $avdc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>a:hover </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color: red; </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="ahcol" value="<? echo $ahcol; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">text-decoration: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select type="text" name="ahtdx">
			<?php if ($ahtdx != "") { ?><option value="<? echo $ahtdx; ?>"><? echo $ahtdx; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="none">none</option>
			<option value="underline">underline</option>
			<option value="overline">overline</option>
			<option value="line-through">line-through</option>
			<option value="blink">blink</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
								
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>.tableOO</strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-right: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="borderrt" value="<? echo $borderrt; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-top:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="bordertop" value="<? echo $bordertop; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-left:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="borderlt" value="<? echo $borderlt; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-bottom:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="borderbt" value="<? echo $borderbt; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tableOO" value="<? echo $tableOO; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>.main </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-size: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="mainf">
			<?php if ($mainf != "") { ?><option value="<? echo $mainf; ?>"><? echo $mainf; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="6px">6px</option>
			<option value="8px">8px</option>
			<option value="10px">10px</option>
			<option value="12px">12px</option>
			<option value="14px">14px</option>
			<option value="16px">16px</option>
			<option value="18px">18px</option>
			<option value="20px">20px</option>
			<option value="24px">24px</option>
			<option value="28px">28px</option>
			<option value="32px">32px</option>
			<option value="36px">36px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="mainc" value="<? echo $mainc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-family:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="mainff" value="<? echo $mainff; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>.cattitle </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-weight:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="cattitlefw">
			<?php if ($cattitlefw != "") { ?><option value="<? echo $cattitlefw; ?>"><? echo $cattitlefw; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="normal">normal</option>
			<option value="bold">bold</option>
			<option value="bolder">bolder</option>
			<option value="lighter">lighter</option>
			<option value="100">100</option>
			<option value="200">200</option>
			<option value="300">300</option>
			<option value="400">400</option>
			<option value="500">500</option>
			<option value="600">600</option>
			<option value="700">700</option>
			<option value="800">800</option>
			<option value="900">900</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-size: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="ctfsz">
			<?php if ($ctfsz != "") { ?><option value="<? echo $ctfsz; ?>"><? echo $ctfsz; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="6px">6px</option>
			<option value="8px">8px</option>
			<option value="10px">10px</option>
			<option value="12px">12px</option>
			<option value="14px">14px</option>
			<option value="16px">16px</option>
			<option value="18px">18px</option>
			<option value="20px">20px</option>
			<option value="24px">24px</option>
			<option value="28px">28px</option>
			<option value="32px">32px</option>
			<option value="36px">36px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="ctc" value="<? echo $ctc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">letter-spacing: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="ctlsg">
			<?php if ($ctlsg != "") { ?><option value="<? echo $ctlsg; ?>"><? echo $ctlsg; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="-1px">-1px</option>
			<option value="-2px">-2px</option>
			<option value="1px">1px</option>
			<option value="2px">2px</option>
			<option value="3px">3px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>.titlepic </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-image: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tpbgi1" value="<? echo $tpbgi1; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-repeat: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="tpbgr1">
			<?php if ($tpbgr1 != "") { ?><option value="<? echo $tpbgr1; ?>"><? echo $tpbgr1; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="repeat">repeat</option>
			<option value="repeat-x">repeat-x</option>
			<option value="repeat-y">repeat-y</option>
			<option value="no-repeat">no-repeat</option>
			</select> </td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tpbgc1" value="<? echo $tpbgc1; ?>"> 
			  &nbsp;(leave blank if using image)</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>td</strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td align="left" valign="middle" class="row1">font-family: </td>
			<td align="left" valign="middle" class="row2"><input type="text" name="tdff" value="<? echo $tdff; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
			</tr>
			<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td align="left" valign="middle" class="row1">color:</td>
			<td align="left" valign="middle" class="row2"><input type="text" name="tdcolor" value="<? echo $tdcolor; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-size: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="tdfsz">
			<?php if ($tdfsz != "") { ?><option value="<? echo $tdfsz; ?>"><? echo $tdfsz; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="6px">6px</option>
			<option value="8px">8px</option>
			<option value="10px">10px</option>
			<option value="12px">12px</option>
			<option value="14px">14px</option>
			<option value="16px">16px</option>
			<option value="18px">18px</option>
			<option value="20px">20px</option>
			<option value="24px">24px</option>
			<option value="28px">28px</option>
			<option value="32px">32px</option>
			<option value="36px">36px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>td.row1 </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdr1bgc" value="<? echo $tdr1bgc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>td.row2 </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdr2bgc" value="<? echo $tdr2bgc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>td.rowpic </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-image: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdrpbgi" value="<? echo $tdrpbgi; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-repeat:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="tdrpbgr">
			<?php if ($tdrpbgr != "") { ?><option value="<? echo $tdrpbgr; ?>"><? echo $tdrpbgr; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="repeat">repeat</option>
			<option value="repeat-x">repeat-x</option>
			<option value="repeat-y">repeat-y</option>
			<option value="no-repeat">no-repeat</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdrpbgc" value="<? echo $tdrpbgc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>td.tdcolorone </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdcobgc" value="<? echo $tdcobgc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>td.OutlineOne </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-right: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdoutbr" value="<? echo $tdoutbr; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-top: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdoutbt" value="<? echo $tdoutbt; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-left: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdoutbl" value="<? echo $tdoutbl; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">border-bottom: </td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdoutbb" value="<? echo $tdoutbb; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">background-color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="tdoutbgc" value="<? echo $tdoutbgc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>.copyright </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-size:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="crfsz">
			<?php if ($crfsz != "") { ?><option value="<? echo $crfsz; ?>"><? echo $crfsz; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="6px">6px</option>
			<option value="8px">8px</option>
			<option value="10px">10px</option>
			<option value="12px">12px</option>
			<option value="14px">14px</option>
			<option value="16px">16px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="crcolor" value="<? echo $crcolor; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">font-family:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="crff" value="<? echo $crff; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">letter-spacing:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="crspace">
			<?php if ($crspace != "") { ?><option value="<? echo $crspace; ?>"><? echo $crspace; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="-1px">-1px</option>
			<option value="-2px">-2px</option>
			<option value="1px">1px</option>
			<option value="2px">2px</option>
			<option value="3px">3px</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>a.copyright</strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td align="left" valign="middle" class="row1"> color:</td>
			<td align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="accolor" value="<? echo $accolor; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">text-decoration:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="actextd">
			<?php if ($actextd != "") { ?><option value="<? echo $actextd; ?>"><? echo $actextd; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="none">none</option>
			<option value="underline">underline</option>
			<option value="overline">overline</option>
			<option value="line-through">line-through</option>
			<option value="blink">blink</option>
			</select></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1"><strong>a.copyright:hover </strong></td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;</td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
										
			<tr> 
			<td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
			<td width="40%" align="left" valign="middle" class="row1">color:</td>
			<td width="50%" align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="achoverc" value="<? echo $achoverc; ?>"></td>
			<td width="5%" align="center" valign="middle" noWrap class="row2"><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td align="left" valign="middle" class="row1">text-decoration:</td>
			<td align="left" valign="middle" class="row2">&nbsp;&nbsp;<select name="achovertd">
			<?php if ($achovertd != "") { ?><option value="<? echo $achovertd; ?>"><? echo $achovertd; ?></option><?php ;} ?>
			<option>-----</option>
			<option value="none">none</option>
			<option value="underline">underline</option>
			<option value="overline">overline</option>
			<option value="line-through">line-through</option>
			<option value="blink">blink</option>
			</select></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
			</tr>
			<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td align="left" valign="middle" class="row1">&nbsp;</td>
			<td align="left" valign="middle" class="row2">&nbsp;&nbsp;<input type="image" src="../images/btn_submit.gif" onclick="refresh();" border="0" width="74" height="22"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
			</tr>
			
			<tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
			</tr>
			<!-- end of page content -->
			</form>
			</table>
			</td>
			</tr>
			  
			<? include('../include/footer.php'); ?>