<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=DomainNs");
	exit(); // Quit the script.
} 
	
	require( "include/dbconfig.php" );
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );

	$tld = $_GET['tld'];
	$sld = $_GET['sld'];
	
	// Check if we're supposed to modify something
	if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
		// Check if any DNS entries were modified
		if ( WereDNSEntriesModified() == 1 ) {
			if ( ModifyDNS() == 1 ) {
	$query = "UPDATE domains SET dns='$dns' WHERE sld ='$sld' AND tld ='$tld'";
	$result = @mysql_query($query);
  			// Success, so get back to main page
  			header ("Location: dmain.php?sld=$sld&tld=$tld");
  			exit;
  		}
		}
	}
	//Page name - DO NOT CHANGE
	$page = "myaccount";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Update Your NameServers.";
	?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="147" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td width="145" height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
			<td class="content" align="center" valign="top" width="815">
			<table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic">&nbsp;</td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">&nbsp;			          </p>
			        <p align="center" class="BasicText"><b></b>
 <?php
				  //Print the error message if there is one
	if(isset($message)) {echo '<span class=\"red\">', $message, '</span>';}?>		</b><p></p><table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
		
	<!-- begin page content -->
			<tr> 
				<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">View/Modify Nameservers</span></td>
			</tr>
			<tr> 
				<td width="5%" height=50 align="center" valign="middle" >&nbsp;</td>
				<td width="40%" height=50 align="center" valign="middle"  colspan="2"><span class="main">
				<form method="post" action="<?php echo "DomainNs.php?sld=$sld&tld=$tld" ; ?>" id=form1 name=form1>
				<input type="hidden" name="action" value="modify">
									<?php
										// Create URL Interface class
										$Enom = new CEnomInterface;
									
										$Enom->NewRequest();
										$Enom->AddParam( "uid", $enom_username );
										$Enom->AddParam( "pw", $enom_password );
										$Enom->AddParam( "tld", $tld );
										$Enom->AddParam( "sld", $sld );
										$Enom->AddParam( "enduserip", $enduserip );
										$Enom->AddParam( "site", $sitename );
										$Enom->AddParam( "User_ID", $_COOKIE['id'] );
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
										$dns = 1;
									} else {
										$OldUseNameserver = "custom";
										$dns = 0;
									}
								?>
								<option <?php if ( $OldUseNameserver == "default" )  { 
								$dns = 1;
								echo "selected"; }?> value="default">Our nameservers</option>
								<option <?php if ( $OldUseNameserver == "custom" ) { 
								$dns = 0;
								echo "selected"; }?> value="custom">Your own nameservers</option>
								<input type="hidden" name="OldUseNameserver" value="<?php echo "$OldUseNameserver"; ?>">
												</select></td>
											</tr>
											<tr>
								<?php
										// If custom nameservers, print out namesever info
										if ( $OldUseNameserver == "custom" ) {
											// Make enough edit boxes for the existing entries plus 2 more
											$nDNSCount = $Enom->Values[ "NSCount" ] + 5;
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
											echo "&nbsp;$i)&nbsp;</td><td><input maxlength=\"60\"  type=\"text\" id=\"idDNS$i\" name=\"DNS$i\" value=\"\"><br /></td>";
																						
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
												<td valign="middle"><br /><input name="image1" type="image" id="image1" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">
												<?php echo "<a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_cancel.gif\" border=\"0\" WIDTH=\"74\" HEIGHT=\"22\"></a>";?></td>
											</tr> 
				<?
					} else {
					$error = $Enom->Values[ "Err1" ];
					$message = "<table width=\"70%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\">";
					$message .= "<tr><td class=\"red\" align=\"center\" colspan=\"3\">There were errors getting the DNS list: ";
					$message .=  $error. "<br /><br /><a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_cancel.gif\" border=\"0\" WIDTH=\"74\" HEIGHT=\"22\"></a></td></tr>";
					}
				?>	
					</table></td>
				<td width="5%" height=50 align="center" valign="middle" noWrap ><img src="images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
			<tr> 
				<td colspan="4" align="center" valign="middle" ></td>
			</tr>
</form>
	
	  </table>
					<br> 
                    </p>
		          <tr>
	                <td colspan="3" valign="top" class="content2">                    
		      </table>
</table>
		          <?php include('include/footer.php');?>