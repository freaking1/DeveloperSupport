<?php
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
	global $username;
	global $password;
	global $tld;
	global $sld;
	
	// Create URL Interface object
	$Enom = new CEnomInterface;
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
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
		echo "Errors modifying hosts: {$Enom->Values[ "Err1" ]}";
	}
}

function WasPasswordModified() {
	global $HTTP_POST_VARS;
	$Ret = 0;
	
	// Check if passwords match
	if ( $HTTP_POST_VARS[ "password1" ] != $HTTP_POST_VARS[ "password2" ] ) {
		echo "<font color=\"red\">Error: passwords don't match</font>";
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
	global $username;
	global $password;
	global $tld;
	global $sld;
	
	// Create URL Interface object
	$Enom = new CEnomInterface;
	
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
				
	//Add IP address of end user
 	$Enom->AddParam( "EndUserIP", $enduserip );
	
	// Modify password
	$Enom->AddParam( "domainpassword", $HTTP_POST_VARS[ "password1" ] );
	$Enom->AddParam( "accesslevel", "1" );
	$Enom->AddParam( "command", "setpassword" );
	
	$Enom->DoTransaction();

	// Check if there were errors
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		echo "Errors setting password: {$Enom->Values[ "Err1" ]}";
	}
}

function ModifyEmails() {
	global $HTTP_POST_VARS;
	global $username;
	global $password;
	global $tld;
	global $sld;
	
	// Create URL Interface object
	$Enom = new CEnomInterface;
	
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	
	// Get number of emails
	$nEmailCount = $HTTP_POST_VARS[ "EmailCount" ];
	
	// Loop through all hosts
	for ( $i = 1; $i <= $nEmailCount; $i++ ) {
		// Add this email
		$Enom->AddParam( "Address" . $i, $HTTP_POST_VARS[ "Username" . $i ] );
		$Enom->AddParam( "ForwardTo" . $i, $HTTP_POST_VARS[ "ForwardTo" . $i ] );
	}
				
	//Add IP address of end user
 	$Enom->AddParam( "EndUserIP", $enduserip );
	
	// Modify email
	$Enom->AddParam( "command", "forwarding" );
	$Enom->DoTransaction();
	
	// Check if there were errors
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		echo "Errors modifying email forwarding: {$Enom->Values[ "Err1" ]}";
	}
}

function ModifyDNS() {
	global $HTTP_POST_VARS;
	global $username;
	global $password;
	global $tld;
	global $sld;
	
	$Ret = 0;
	
	// Create URL Interface object
	$Enom = new CEnomInterface;
	
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "tld", $tld );
	
	// Do they want to use our (eNom's) nameservers?
	if ( $HTTP_POST_VARS[ "UseNameserver" ] == "default" ) {
		// Set to use eNom DNS
		$Enom->AddParam( "UseDNS", "default" );
	} else {
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
		echo "Errors modifying nameservers: {$Enom->Values[ "Err1" ]}";
	} else {
		// Modifying nameservers in an RRP function, check response from NSI
		if ( $Enom->Values[ "RRPCode" ] != "200" ) {
			echo "Errors modifying nameservers: {$Enom->Values[ "RRPText" ]}";
		} else {
			// Success
			$Ret = 1;
		}
	}
	
	return $Ret;
}
?>