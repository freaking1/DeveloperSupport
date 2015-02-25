<center>Importing Your Domains - please wait</center>
<?php
require("../include/dbconfig.php");
require("../include/EnomInterface_inc.php");
require( "../include/DomainFns_inc.php" );

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
		echo "You have no registered domains in your account.<br>";
		exit;
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
		echo "Imported $import domain(s)<br>";
		echo "Skipped $skipped domain(s)<br><br><br>";
		echo '<center>You may now Close this window as we are all finished here.</center>';