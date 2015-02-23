<?php
//-----------------------------------------------------------------------------
//	EditFns_Inc.php	11/1/2000
//	Desc: FIELD EDIT FUNCTIONS
//-----------------------------------------------------------------------------


function isBlank( $strInput ) {
	// Returns 1 if the strInput is empty or null or just space(s)
	// expects a string as input
	
	// First trim the string
	$strTemp = trim( $strInput );
	
	// Check if there are any characters
	if ( strlen( $strTemp ) == 0 ) {
		// There aren't, the string is blank
		$Ret = 1;
	} else {
		// There are some characters in there
		$Ret = 0;
	}
	
	return ( $Ret );
}

function fnStripTLD( $strInput ) {
	// returns the tld by stripping off the dot sld
	// expects a non blank/empty string as input
	
	// Check if the string is blank
	if ( isBlank( $strInput )) {
		$Tld = "";
	} else {
		// Get everything from the last "." on
		$Tld = strrchr( $strInput, "." );
		
		// Check if a "." was found
		if ( $Tld == false ) {
			// No ".", return blank TLD
			$Tld = "";
		} else {
			// Strip leading "."
			$Tld = substr( $Tld, 1 );
		}
	}
	
	return ( $Tld );
}

function fnStripSLD( $strInput ) {
	// returns the sld by stripping off the tld and the dot
	// expects a non blank/empty string as input
	if ( isBlank( $strInput )) {
		$Sld = "";
	} else {
		$Tld = strrchr( $strInput, "." );
		
		if ( $Tld == false ) {
			$Sld = $strInput;
		} else {
			$Sld = substr( $strInput, 0, strlen( $strInput ) - strlen( $Tld ));
		}
	}
	
	return ( $Sld );
}
?>