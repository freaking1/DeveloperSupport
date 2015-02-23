<?PHP
	$Enom = new CEnomInterface;
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );

	$Enom->AddParam( "command", "getdns" );
	$Enom->DoTransaction();

	$nDNSCount = $Enom->Values[ "NSCount" ];

	// Create all the rows of name server info
	for ( $i = 1; $i <= $nDNSCount; $i++ ) {
		// Display edit boxes
		echo $Enom->Values[ "DNS" . $i ] . "<br />";
	}
?>