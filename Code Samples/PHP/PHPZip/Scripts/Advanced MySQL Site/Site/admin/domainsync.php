<center>Syncing Your Domains - please wait</center>
<?php
require("../include/dbconfig.php");
require("../include/EnomInterface_inc.php");
require( "../include/DomainFns_inc.php" );

$import = 0;
$update = 0;

			$Enom = new CEnomInterface;
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "command", "getexpireddomains" );
			$Enom->DoTransaction();

	$domaincount = $Enom->Values[ "domaincount" ];
	
if($domaincount == 0){
	echo "Congratulations!  You have no Expired, or RGP/ERGP domains in your account.<br>";
	exit;
} else {

	for ( $i = 1; $i <= $domaincount ; $i++ ){
		$DomainName  = $Enom->Values[ "DomainName"."$i" ];
		$e_domain_id = $Enom->Values[ "DomainNameID"."$i" ];
	
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
		
		if($Enom->Values[ "lockstatus"."$i"] == 'Locked'){
			$lockstatus = '1'; //locked
			} else {
			$lockstatus = '0'; //Unlocked
			}
	
		if($Enom->Values[ "status"."$i" ] == 'Expired'){
			$status = '0'; //expired status
			} elseif($Enom->Values[ "status"."$i" ] == 'RGP'){
			$status = '3'; //RGP status
			} elseif($Enom->Values[ "status"."$i" ] == 'Extended RGP'){
			$status = '4'; //ERGP status
			} 
		
				$Enom2 = new CEnomInterface;
				$Enom2->NewRequest();
				$Enom2->AddParam( "uid", $enom_username );
				$Enom2->AddParam( "pw", $enom_password );
				$Enom2->AddParam( "enduserip", $enduserip );
				$Enom2->AddParam( "site", $sitename );
				$Enom2->AddParam( "PassedDomain", $DomainName );
				$Enom2->AddParam( "command", "parsedomain" );
				$Enom2->DoTransaction();
				
				$sld = $Enom2->Values[ "SLD" ];
				$tld = $Enom2->Values[ "TLD" ];
		
			$query = "select * from domains where sld = '$sld' and tld = '$tld' and e_domain_id = '$e_domain_id'";
			$result = @mysql_query ($query);
				if(mysql_num_rows($result) == 0){
					$SQL = "INSERT INTO domains (user_id, e_domain_id, sld, tld, exp_date, order_date, dns,  mail, webhosted, status, pop, idprotect, auto_renew, reg_lock, tv, parking, name_phone, name_map, lastupdate)
							VALUES ('1', '$e_domain_id', '$sld', '$tld', '$expdate', '$orderdate', '1', '0', '0', '$status', '0', '0', '0', '$lockstatus', '0', '0', '0', '0', NOW())";
					$RUN = @mysql_query($SQL);
						if($RUN){
						echo "#$i.) Imported ".$Enom->Values[ "status"."$i" ] ." Domain $sld.$tld<br>";
						$import = $import + 1;
						} else {
						echo "ERROR - COULD NOT IMPORT <br>$SQL";
							exit;
							}
				}elseif(mysql_num_rows($result) != 0){
					$SQL = "update domains set status = '$status' where sld='$sld' and tld='$tld' and e_domain_id = '$e_domain_id'";
					$RUN = @mysql_query($SQL);
						if($RUN){
						echo "#$i.) Updated Domain $sld.$tld to ".$Enom->Values[ "status"."$i" ]." Status<br>";
						$update = $update + 1;
						} else {
						echo "ERROR - COULD NOT UPDATE <br>$SQL";
							exit;
							}
					}
	}//For loop
}//if			
		echo "Imported $import domain(s)<br>";
		echo "Updated $update domain(s)<br><br><br>";
		echo '<center>You may now Close this window as we are all finished here.</center>';
?>