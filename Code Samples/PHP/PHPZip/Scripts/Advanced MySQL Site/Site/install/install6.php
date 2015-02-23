<?php
session_name ('API-PHPSESSID-INSTALL');
session_start(); // Start the session.

require("../include/dbconfig.php");

$StepNumber = $_SESSION['StepNumber'];
if ($StepNumber != 6){
	header ("Location:  $site_url/install/install$StepNumber.php");
	exit(); // Quit the script.
}

$action = $HTTP_POST_VARS['action'];

?>
<link rel="stylesheet" href="../css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('../include/header.php')?>
      </tr>
</table>
    <table width="964" height="200" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td height="196" valign="top">
			  <table width="100%" height="100" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader"> Step 6 - Import your existing domains</span></div></td>
			    </tr>
				<tr>
			      <td height="100" colspan="3" valign="top" class="content2">
			        <p>&nbsp;</p>
			        <table width="501" height="86" border="0" align="center" cellpadding="0" cellspacing="0" class="tableOO">
                      <tr>
                        <th width="497" scope="col">Step 6 - Import domains</th>
                      </tr>
                      <tr>
                        <td><p>We will now import any existing domains in your enom account into the <?=$sitename;?> account of the first user that you created during the installation.</p>
                          <p>This may take a few minutes depending on the number of domains being imported. Please do not hit refresh, back, or close this page. When your ready, click on GO below: </p></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>
						<?php
						if($action != 'go'){
						echo '<form name="form1" method="post" action="install6.php">
							<input type="hidden" name="action" value="go">
                          <center><input name="Go" type="submit" class="button" id="Go" value="Go">
                          </center>
                        </form>';
						} else {
						echo "<center>Processing Your Domains - please wait</center>";
						}
						?> <a href="install7.php">Skip this step</a></td>
                      </td>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
			        <p><center><?php
if($action == 'go'){
	include( "../include/DomainFns_inc.php" );
	include( "../include/EnomInterface_inc.php" );

		$Enom = new CEnomInterface;

			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "command", "GetDomainCount" );
			$Enom->DoTransaction();

			$RegisteredCount = $Enom->Values[ "RegisteredCount" ];
			$HostCount = $Enom->Values[ "HostCount" ];
			$ExpiredDomainsCount = $Enom->Values[ "ExpiredDomainsCount" ];

if($RegisteredCount == 0){
	$message_registered = "You have no registered domains in your account.<br>";
	} else {

	$start = 1;
	$import = 0;
	$skipped = 0;

	while ($start < $RegisteredCount){
		$DisplayTo = ($start + 25);
		if($DisplayTo > $RegisteredCount){
			$DisplayTo = $RegisteredCount;
			$show = $DisplayTo - $start;
			} else {
			$show = 25;
			}

		echo "Domains $start - $DisplayTo out of $RegisteredCount<br>";

		for ( $i = 1; $i <= $show ; $i++ ){
			$Enom2 = new CEnomInterface;
			$Enom2->NewRequest();
			$Enom2->AddParam( "uid", $enom_username );
			$Enom2->AddParam( "pw", $enom_password );
			$Enom2->AddParam( "enduserip", $enduserip );
			$Enom2->AddParam( "site", $sitename );
			$Enom2->AddParam( "command", "GetDomains" );
			$Enom2->AddParam( "tab", "iown" );
			$Enom2->AddParam( "start", $start );
			//echo $Enom2->PostString.'<br>';
			$Enom2->DoTransaction();

			$e_domain_id = $Enom2->Values[ "DomainNameID"."$i" ];
			$sld = $Enom2->Values[ "sld"."$i" ];
			$tld = $Enom2->Values[ "tld"."$i" ];

			list($month, $day, $year) = split('[/]', $Enom2->Values[ "expiration-date"."$i" ]);
				if(strlen($day) != 2){
					$day = '0'.$day;
					}
				if(strlen($month) != 2){
					$month = '0'.$month;
					}
				$expdate = "$year-$month-$day";

				$getdate = 'select date_sub(\''.$expdate.'\', interval 1 year)';
				$gotdate = mysql_query($getdate);
				$orderdate = mysql_result($gotdate,0);


				if($Enom2->Values[ "ns-status"."$i" ] == 'YES'){
					$dns = "1";
					} else {
					$dns = "0";
					}

				if($Enom2->Values[ "wppsstatus"."$i" ] == "disabled"){
					$wpps = "0";
					} else {
					$wpps = "1";
					}

				$query = "SELECT sld, tld FROM domains WHERE sld='$sld' and tld = '$tld'";
				$result = @mysql_query ($query);
						if(mysql_num_rows($result) == 0){
							$SQL = "INSERT INTO domains (user_id, e_domain_id, sld, tld, exp_date, order_date, dns,  mail, webhosted, status, pop, idprotect, auto_renew, reg_lock, tv, parking, name_phone, name_map, lastupdate)
									VALUES ('1', '$e_domain_id', '$sld', '$tld', '$expdate', '$orderdate', '$dns', '0', '0', '1', '0', '$wpps', '0', '0', '0', '0', '0', '0', NOW())";
							$RUN = @mysql_query($SQL);
								if($RUN){
								echo "#$i Domain = $sld.$tld - Imported <br>";
								$import = $import + 1;
								} else {
								echo "ERROR - COULD NOT IMPORT <br>$SQL";
									exit;
									}
							} elseif(mysql_num_rows($result) == 1){
								echo "#$i Domain = $sld.$tld - Skipped <br>";
								$skipped = $skipped + 1;
							} else {
								echo "ERROR - COULD NOT READ DATABASE OR SQL FAILED <br>$query";
								exit;
								}
					}
					echo '<br>';
				$start = ($start + 25);
		}
	}
		$_SESSION['StepNumber'] = 7;
		#$skipped = $RegisteredCount - $import;
		echo "Imported $import domain(s) into the $CompanyName system<br>";
		echo "Skipped $skipped domain(s) as they already existed.<br><br><br>";
		echo '<a href="install7.php"><center><b>Go to Step 7</b></a></center>';
}
					?></center>
					</p>
			      <tr>
          </table></td>
		</table>