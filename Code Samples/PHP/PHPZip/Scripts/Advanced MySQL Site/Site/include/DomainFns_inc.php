<?php

function GetAgreement() {

	$Enom = new CEnomInterface;
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "command", "GetAgreementPage" );
	$Enom->DoTransaction();

	$text = html_entity_decode($Enom->Values[ "content" ]);

echo $text;
}

function WereHostsModified() {
	global $HTTP_POST_VARS;
	$Ret = 0;

	// Loop through number of hosts specified
	$nHostCount = $HTTP_POST_VARS[ "HostCount" ];

	for ( $i = 1; $i <= $nHostCount; $i++ ) {
		// Check new fields against old fields
		if ( $HTTP_POST_VARS[ "HostName" . $i ] != $HTTP_POST_VARS[ "OldHostName" . $i ] or
			$HTTP_POST_VARS[ "Address" . $i ] != $HTTP_POST_VARS[ "OldAddress" . $i ] or
			$HTTP_POST_VARS[ "RecordType" . $i ] != $HTTP_POST_VARS[ "OldRecordType" . $i ] or
			$HTTP_POST_VARS[ "MXPref" . $i ] != $HTTP_POST_VARS[ "OldMXPref" . $i ] ) {

			// Fields were modified
			$Ret = 1;
		}
	}

	return $Ret;
}

function WereEmailsModified() {
	global $HTTP_POST_VARS;
	$Ret = 0;

	// Loop through number of emails specified
	$nEmailCount = $HTTP_POST_VARS[ "EmailCount" ];

	for ( $i = 1; $i <= $nEmailCount; $i++ ) {
		// Check new fields against old fields
		if ( $HTTP_POST_VARS[ "Username" . $i ] != $HTTP_POST_VARS[ "OldUsername" . $i ] or
			$HTTP_POST_VARS[ "ForwardTo" . $i ] != $HTTP_POST_VARS[ "OldForwardTo" . $i ] ) {

			// Fields were modified
			$Ret = 1;
		}
	}

	return $Ret;
}

function WereDNSEntriesModified() {
	global $HTTP_POST_VARS;
	$Ret = 0;

	// Check UseNameserver option
	if ( $HTTP_POST_VARS[ "UseNameserver" ] != $HTTP_POST_VARS[ "OldUseNameserver" ] ) {
		$Ret = 1;
	}

	// Loop through number of DNS servers specified
	$nDNSCount = $HTTP_POST_VARS[ "DNSCount" ];

	for ( $i = 1; $i <= $nDNSCount; $i++ ) {
		// Check new fields against old fields
		if ( $HTTP_POST_VARS[ "DNS" . $i ] != $HTTP_POST_VARS[ "OldDNS" . $i ] ) {
			// Fields were modified
			$Ret = 1;
		}
	}

	return $Ret;
}

function ModifyHosts() {
	global $HTTP_POST_VARS;
	global $enom_username;
	global $enom_password;
	global $tld;
	global $sld;
	global $dns;
	global $message;
	// Create URL Interface object
	$Enom = new CEnomInterface;
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "tld", $tld );

	// Get number of hosts
	$nHostCount = $HTTP_POST_VARS[ "HostCount" ];

	// Loop through all hosts
	for ( $i = 1; $i <= $nHostCount; $i++ ) {
		// Add this host
		$Enom->AddParam( "HostName" . $i, $HTTP_POST_VARS[ "HostName". $i ] );
		$Enom->AddParam( "RecordType" . $i, $HTTP_POST_VARS[ "RecordType" . $i ] );
		$Enom->AddParam( "Address" . $i, $HTTP_POST_VARS[ "Address" . $i ] );
		$Enom->AddParam( "MXPref" . $i, $HTTP_POST_VARS[ "MXPref" . $i ] );
	}

	//Add IP address of end user
 	$Enom->AddParam( "EndUserIP", $enduserip );

	// Modify hosts
	$Enom->AddParam( "command", "sethosts" );
	$Enom->DoTransaction();

	// Check if there were errors
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
					$message = "<table width=\"70%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\">";
					$message .= "<tr><td class=\"red\" align=\"center\" colspan=\"3\">There were errors getting the DNS list: ";
					$message .=  $Enom->Values[ "Err1" ] . "<br /><br /><a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_cancel.gif\" border=\"0\" WIDTH=\"74\" HEIGHT=\"22\"></a></td></tr>";
	}
}

function WasPasswordModified() {
	global $HTTP_POST_VARS;
	global $message;
	$Ret = 0;

	// Check if passwords match
	if ( $HTTP_POST_VARS[ "password1" ] != $HTTP_POST_VARS[ "password2" ] ) {
		$message .= "<font color=\"red\">Error: passwords don't match</font>";
	} else {
		// Check if password was changed
		if ( $HTTP_POST_VARS[ "password1" ] != "**********" ) {
			$Ret = 1;
		}
	}

	return ( $Ret );
}

function ModifyPassword() {
	global $HTTP_POST_VARS;
	global $enom_username;
	global $enom_password;
	global $tld;
	global $sld;
	global $message;
	global $domain_pass;
	$domain_pass = $HTTP_POST_VARS[ "password1" ];

	// Create URL Interface object
	$Enom = new CEnomInterface;

	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
 	$Enom->AddParam( "EndUserIP", $enduserip );
	$Enom->AddParam( "domainpassword", $domain_pass);
	$Enom->AddParam( "accesslevel", "1" );
	$Enom->AddParam( "command", "setpassword" );
	$Enom->DoTransaction();
	// Check if there were errors
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		$message .= "Errors setting password: {$Enom->Values[ "Err1" ]}";
	} else {
		//Update Password in Sql
		$query = "UPDATE domains SET password = '$domain_pass' WHERE sld = '$sld' AND tld = '$tld'";
		$result = @mysql_query ($query);
			if ($result) { // If it ran OK.
			$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><b font=\"red\">Your password has been changed</b></td></tr>
			<tr><td nowrap><br><center><a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_back.gif\" border=\"0\"></a></center></td></tr></table>";
			} else {
			//It failed
			$message .= "<br>Password Update Failed.  Please contact support</br>";
			}
	}
}

function ModifyEmails() {
	global $HTTP_POST_VARS;
	global $enom_username;
	global $enom_password;
	global $tld;
	global $sld;
	global $message;
	// Create URL Interface object
	$Enom = new CEnomInterface;
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "site", $sitename );
	$Enom->AddParam( "enduserip", $enduserip );
	$nEmailCount = $HTTP_POST_VARS[ "EmailCount" ];
	// Loop through all hosts
	for ( $i = 1; $i <= $nEmailCount; $i++ ) {
		// Add this email
		$Enom->AddParam( "Address" . $i, $HTTP_POST_VARS[ "Username" . $i ] );
		$Enom->AddParam( "ForwardTo" . $i, $HTTP_POST_VARS[ "ForwardTo" . $i ] );
	}
 	$Enom->AddParam( "EndUserIP", $enduserip );
	$Enom->AddParam( "command", "forwarding" );
	$Enom->DoTransaction();

	// Check if there were errors
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		$message .= "Errors modifying email forwarding: {$Enom->Values[ "Err1" ]}";
	} else {
		$message .= "Successfully set the forwarding records";
		}
}

function ModifyDNS() {
	global $HTTP_POST_VARS;
	global $enom_username;
	global $enom_password;
	global $tld;
	global $sld;
	global $dns;
	global $message;
	$Ret = 0;

	// Create URL Interface object
	$Enom = new CEnomInterface;

	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "tld", $tld );

	// Do they want to use our (eNom's) nameservers?
	if ( $HTTP_POST_VARS[ "UseNameserver" ] == "default" ) {
		// Set to use eNom DNS
		$Enom->AddParam( "UseDNS", "default" );
		$dns = 1;
	} else {
		$dns = 0;
		// Get number of DNS servers
		$nDNSCount = $HTTP_POST_VARS[ "DNSCount" ];

		// Loop through all DNS servers
		for ( $i = 1; $i <= $nDNSCount; $i++ ) {
			// Add this server
			$Enom->AddParam( "NS" . $i, $HTTP_POST_VARS[ "DNS" . $i ] );
		}
	}

	//Add IP address of end user
 	$Enom->AddParam( "EndUserIP", $enduserip );

	// Modify nameservers
	$Enom->AddParam( "command", "modifyns" );
	$Enom->DoTransaction();

	// Check if there were errors
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		$message .= "Errors modifying nameservers: {$Enom->Values[ "Err1" ]}";
	} else {
		// Modifying nameservers in an RRP function, check response from NSI
		if ( $Enom->Values[ "RRPCode" ] != "200" ) {
			$message .= "Errors modifying nameservers: {$Enom->Values[ "RRPText" ]}";
		} else {
			// Success
			$Ret = 1;
		}
	}

	return $Ret;
}
?>