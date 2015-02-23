<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];
	$tld = $_GET['tld'];
	$sld = $_GET['sld'];

	require( "include/dbconfig.php" );
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );
	
if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=hosts&sld=$sld&tld=$tld");
	exit(); // Quit the script.
} 

$action = $HTTP_POST_VARS["action"];
	$page = "myaccount";
?>
	
<link rel="stylesheet" href="css/styles.css" type="text/css">
	<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="149" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td width="145" height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
		<td width="801">
		<form method="post" action="<?php echo "hosts.php?sld=$sld&tld=$tld";?>" name="theForm" id="theForm">
		<input type="hidden" name="action" value="modify">	
			<table width="101%" height="218" border="0" align="center" cellpadding="0" cellspacing="0" class="tableOO" id="table13">
			      <tr>
	              <td colspan="3" valign="top" >     
			<tr> 
				<td height="5" colspan="4" class="titlepic"><span class="whiteheader">Modify Zone File / Host Records</span></td>
			</tr>
			
			<tr> 
				<td width="5%" height=50 align="center" valign="middle" >&nbsp;</td>
				<td width="40%" height=50 align="center" valign="middle" colspan="2" class="tableO1">
				<?php
				
					$Enom = new CEnomInterface;
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $enom_username );
					$Enom->AddParam( "pw", $enom_password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "enduserip", $enduserip );
					$Enom->AddParam( "site", $sitename );
					$Enom->AddParam( "User_ID", $_COOKIE['id'] );
					$Enom->AddParam( "command", "getdnsstatus" );
					$Enom->DoTransaction();
					
					$bEnomDNS = 0;
					if ( $Enom->Values[ "ErrCount" ] == "0" ) {
						if ( $Enom->Values[ "UseDNS" ] == "default" ) {
							$bEnomDNS = 1;
						}
					} else {
						echo "Error checking nameserver status: {$Enom->Values[ "Err1" ]}";
					}
				
					if ( $bEnomDNS == 1 ) {
						$displayInsOn = 1;
						
						$Enom->NewRequest();
						$Enom->AddParam( "uid", $enom_username );
						$Enom->AddParam( "pw", $enom_password );
						$Enom->AddParam( "tld", $tld );
						$Enom->AddParam( "sld", $sld );
						$Enom->AddParam( "enduserip", $enduserip );
						$Enom->AddParam( "site", $sitename );
						$Enom->AddParam( "User_ID", $_COOKIE['id'] );
						$Enom->AddParam( "command", "gethosts" );
						$Enom->DoTransaction();	
					
						if ( $Enom->Values[ "ErrCount" ] == "0" ) {
							$nHostCount = $Enom->Values[ "HostCount" ] + 5;
							echo "<input type=\"hidden\" name=\"HostCount\" value=\"$nHostCount\">";
							echo "<table border=\"0\" cellpadding=\"4\" cellspacing=\"0\">";
							
							if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
								if ( WereHostsModified() == 1 ) {
									echo "<tr><td>";
									ModifyHosts();
									echo "<tr><td>";
									
						$Enom->NewRequest();
						$Enom->AddParam( "uid", $enom_username );
						$Enom->AddParam( "pw", $enom_password );
						$Enom->AddParam( "tld", $tld );
						$Enom->AddParam( "sld", $sld );
						$Enom->AddParam( "enduserip", $enduserip );
						$Enom->AddParam( "site", $sitename );
						$Enom->AddParam( "User_ID", $_COOKIE['id'] );
						$Enom->AddParam( "command", "gethosts" );
						$Enom->DoTransaction();	
								}
							}
							
							echo "<tr><td>&nbsp;</td><td align=\"center\"><b>Hostname</b></td>";
							echo "<td align=\"center\"><b>Record Type</b></td><td align=\"center\"><b>Address</b></td></tr>";
								
							for ( $i = 1; $i <= $nHostCount; $i++ ) {
							
								$RecType = $Enom->Values[ "RecordType$i" ];
								echo "<tr>";
								echo "<td align=\"right\">$i)</td><td align=\"center\"><input size=\"7\" maxlength=\"60\" type=\"text\" id=\"idHostName$i\" name=\"HostName$i\" value=\"{$Enom->Values[ "HostName" . $i ]}\"></td>";
								echo "<td><input size=\"12\" maxlength=\"130\" type=\"text\" id=\"idAddress$i\" name=\"Address$i\" value=\"{$Enom->Values[ "Address" . $i ]}\"></td>";
								echo "<td><select name=\"RecordType$i\">";
								?>
								<option value="A" <?php if ( $RecType=="A" ) { echo "selected"; } ?>>A (Address)</option>
								<option value="CNAME" <?php if ( $RecType=="CNAME" ) { echo "selected"; } ?>>CNAME (Alias)</option>
								<option value="URL" <?php if ( $RecType=="URL" ) { echo "selected"; } ?>>URL Redirect</option>
								<option value="FRAME" <?php if ( $RecType=="FRAME" ) { echo "selected"; } ?>>URL Frame</option>
								<option value="TXT" <?php if ( $RecType=="TXT" ) { echo "selected"; } ?>>TXT</option>
								<option value="MX" <?php if ( $RecType=="MX" ) { echo "selected"; } ?>>MX (By Name)</option>
								<option value="MXE" <?php if ( $RecType=="MXE" ) { echo "selected"; } ?>>MXE (By IP)</option>
								</select></td>
								<?php
								
								echo "<td><input maxlength=\"4\" size=\"6\" type=\"text\" id=\"idMXPref$i\" name=\"MXPref$i\" value=\"{$Enom->Values[ "MXPref" . $i ]}\"></td></tr>";
								echo "<input type=\"hidden\" name=\"OldHostName$i\" value=\"{$Enom->Values[ "HostName" . $i ]}\">";
								echo "<input type=\"hidden\" name=\"OldAddress$i\" value=\"{$Enom->Values[ "Address" . $i ]}\">";
								echo "<input type=\"hidden\" name=\"OldRecordType$i\" value=\"{$Enom->Values[ "RecordType" . $i ]}\">";
								echo "<input type=\"hidden\" name=\"OldMXPref$i\" value=\"{$Enom->Values[ "MXPref" . $i ]}\">";
							}
							echo "</table>";
						} else {
							echo "There were errors getting the host list: {$Enom->Values[ "Err1" ]}<br />";
						}
					} else {
						echo "Not using our nameservers<br />";
					}
				?></td>
				<td width="5%" height=50 align="center" valign="middle" noWrap ><img src="../images/blank.gif" width="8" height="10" border="0"></td>
			</tr>
				<td colspan="4" align="center" valign="middle" ><input name="" type="image" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0"><?php echo "<a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_cancel.gif\" border=\"0\" WIDTH=\"74\" HEIGHT=\"22\"></a>";?></td>
			</tr>
			<tr> 
			<td colspan="4" align="left" ><br><b>NOTE</b>: The MX Pref column only applies to the MX Record Type.
            For all	other Record Types, this field is ignored. <br />
            <b>
            NOTE</b>: Use the &quot;@&quot; in the Address column to mean <?php echo "$sld.$tld"; ?>. <br />
            <b>
            NOTE</b>: If you run out of lines, submit the form and come back
            to this page, more blank lines will automatically appear.</td></tr>
			<tr>
			<? if ($displayInsOn == 1) {include ('include/hostInstructions.php');} ?>           
              </table>
</table>
		          <?php include('include/footer.php');?>