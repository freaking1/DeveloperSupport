<?php

$RegStatus = $_SESSION['RegStatus'];
	if($RegStatus != 1){
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
		$postvars = "sld=$sld&tld=$tld";
		header ("Location: DomainMainHosted.php?$postvars");
		exit;
	}

		include( "include/sessions.php" );
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
	include( "include/DomainFns_inc.php" );
	include( "include/LoggedIn.php" );
	include( "include/EnomInterface_inc.php" );
	
	// Check if we're supposed to modify something
	if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
		// Check if any DNS entries were modified
		if ( WereDNSEntriesModified() == 1 ) {
			if ( ModifyDNS() == 1 ) {
  			// Success, so get back to main page
  			header ("Location: DomainMain.php");
  			exit;
  		}
		}
	}
	//Page name - DO NOT CHANGE
	$PageName = "DomainNs";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Update Your NameServers.";

	//This file must be inluded.
	include('include/header.php'); 
	
	// Begin page content
?>

<tr> 
	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
		
	<!-- begin page content -->
			<tr> 
				<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">DNS&nbsp;&nbsp;Information</span></td>
			</tr>
			
			<tr> 
				<td class="tdcolorone" height="5">&nbsp;</td>
				<td width="40%" height="5" class="tdcolorone"><span class=cattitle>View/Modify Nameservers</span></td>
				<td class="rowpic" align="right" colspan="2">&nbsp;</td>
			</tr>
			
			<tr> 
				<td width="5%" height=50 align="center" valign="middle" class="row1">&nbsp;</td>
				<td width="40%" height=50 align="center" valign="middle" class="row1" colspan="2"><span class="main">
				<form method="post" action="DomainNs.php" id=form1 name=form1>
				<input type="hidden" name="action" value="modify">
									<?php
										// Create URL Interface class
										$Enom = new CEnomInterface;
									
										$Enom->NewRequest();
										$Enom->AddParam( "uid", $username );
										$Enom->AddParam( "pw", $password );
										$Enom->AddParam( "tld", $tld );
										$Enom->AddParam( "sld", $sld );
									
										$Enom->AddParam( "command", "getdns" );
										$Enom->DoTransaction();
										
										$dnstest = $Enom->Values[ "UseDNS" ];	
										
							// Make sure it was successful
							if ( $Enom->Values[ "ErrCount" ] == "0" ) {
									?>
										<table width="70%" border="0" cellpadding="4" cellspacing="2">
											<tr>
												<td align="right"><b class="red">*</b>Use:&nbsp;&nbsp;<?php echo $dnstest; ?></td>
												<td>&nbsp;</td>
												<td>
													<select name="UseNameserver" id="idUseNameserver" OnChange="fnSelectNS()">
								<?php
									if ( $Enom->Values[ "UseDNS" ] == "default" ) {
										$OldUseNameserver = "default";
									} else {
										$OldUseNameserver = "custom";
									}
								?>
								<option <?php if ( $OldUseNameserver == "default" ) { echo "selected"; }?> value="default">Our nameservers</option>
								<option <?php if ( $OldUseNameserver == "custom" ) { echo "selected"; }?> value="custom">Your own nameservers</option>
								<input type="hidden" name="OldUseNameserver" value="<?php echo "$OldUseNameserver"; ?>">
												</select></td>
											</tr>
											<tr>
								<?php
										// If custom nameservers, print out namesever info
										if ( $OldUseNameserver == "custom" ) {
											// Make enough edit boxes for the existing entries plus 2 more
											$nDNSCount = $Enom->Values[ "NSCount" ] + 2;
								?>
																	<td align="right" valign="top" rowspan="<?php echo $nDNSCount; ?>">Custom&nbsp;NameServers:&nbsp;&nbsp;<br /><small class="small">(must select "Your own&nbsp;&nbsp;&nbsp;<br />NameServers" above)</small>&nbsp;&nbsp;</td>
								<?
											// Make sure the page we link to knows how many edit boxes there are
											echo "<input type=\"hidden\" name=\"DNSCount\" value=\"$nDNSCount\">";
										
											// Create all the edit boxes
											for ( $i = 1; $i <= $nDNSCount; $i++ ) {
												// Display edit boxes
												if ( $i == 1 ) {
													echo "<td>";
												} else {
													echo "<tr><td>";
												}
												echo "&nbsp;$i)&nbsp;</td><td><input type=\"text\" maxlength=\"60\" name=\"DNS$i\" id=\"idDNS$i\" value=\"{$Enom->Values[ "DNS" . $i ]}\"><br /></td></tr>";
													
												// Insert hidden fields with previous info
												echo "<input type=\"hidden\" name=\"OldDNS$i\" value=\"{$Enom->Values[ "DNS" . i ]}\">";
											}
										} else {
											// Otherwise print out blank boxes so they don't see eNom nameservers
								?>
								<td align="right" valign="top" rowspan="4">Custom&nbsp;NameServers:&nbsp;&nbsp;<br /><small class="small">(must select "Your own&nbsp;&nbsp;&nbsp;<br />NameServers" above)</small>&nbsp;&nbsp;</td>
								<?
											// Make sure the page we link to knows how many edit boxes there are
											echo "<input type=\"hidden\" name=\"DNSCount\" value=\"4\">";
											
											for ( $i = 1; $i <= 4; $i++ ) {
											// Display edit boxes
											if ( $i == 1 ) {
												echo "<td>";
											} else {
												echo "<tr><td>";
											}
											echo "&nbsp;$i)&nbsp;</td><td><input maxlength=\"60\" disabled type=\"text\" id=\"idDNS$i\" name=\"DNS$i\" value=\"\"><br /></td>";
																						
											// Insert hidden fields with previous info
											echo "<input type=\"hidden\" id=\"idOldDNS$i\" name=\"OldDNS$i\" value=\"\">";
											}
										}
								?>
												</td>
											</tr>
											<tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td valign="middle"><br /><input name="image1" type="image" id="image1" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0"><br />
												<a href="DomainMain.php"><img src="images/btn_cancel.gif" border="0" WIDTH="74" HEIGHT="22"></a></td>
											</tr>
				<?
					} else {
						// The eNom server returned an error, print it out
						echo "<table width=\"70%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\">";
						echo "<tr><td class=\"red\" align=\"center\" colspan=\"3\">There were errors getting the DNS list: ";
						echo $Enom->Values[ "Err1" ] . "<br /><br /><a href=\"DomainMain.php\"><img src=\"images/btn_cancel.gif\" border=\"0\" WIDTH=\"74\" HEIGHT=\"22\"></a></td></tr>";
					}
				?>
												
										</table></td>
				<td width="5%" height=50 align="center" valign="middle" noWrap class="row1"><img src="images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			
			
			<tr> 
				<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
			</tr>

</form>

	  
	<!-- end of page content -->
	
	  </table>
	</td>
</tr>
		  
	<? include('include/footer.php'); ?>