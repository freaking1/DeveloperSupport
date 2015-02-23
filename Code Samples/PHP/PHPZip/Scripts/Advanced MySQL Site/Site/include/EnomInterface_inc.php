<?php
$enduserip = $REMOTE_ADDR;
$sitename = 'eNomiTron PHP';

// URL Interface
class CEnomInterface {
	var $PostString;
	var $RawData;
	var $Values;

	function NewRequest() {
		// Clear out all previous values
		$this->PostString = "";
		$this->RawData = "";
		$this->Values = "";
	}

	function AddError( $error ) {
		// Add an error to the result list
		$this->Values[ "ErrCount" ] = "1";
		$this->Values[ "Err1" ] = $error;
	}

	function ParseResponse( $buffer ) {
		// Parse the string into lines
		$Lines = explode( "\r", $buffer );

		// Get # of lines
		$NumLines = count( $Lines );

		// Skip past header
		$i = 0;
		while ( trim( $Lines[ $i ] ) != "" ) {
			$i = $i + 1;
		}

		$StartLine = $i;

		// Parse lines
		$GotValues = 0;
		for ( $i = $StartLine; $i < $NumLines; $i++ ) {
			// Is this line a comment?
			if ( substr( $Lines[ $i ], 1, 1 ) != ";" ) {
				// It is not, parse it
				$Result = explode( "=", $Lines[ $i ] );

				// Make sure we got 2 strings
				if ( count( $Result ) >= 2 ) {
					// Trim whitespace and add values
					$name = trim( $Result[0] );
					$value = trim( $Result[1] );
					$this->Values[ $name ] = $value;

					// Was it an ErrCount value?
					if ( $name == "ErrCount" ) {
  					// Remember this!
  					$GotValues = 1;
  				}
				}
			}
		}

		// Check if we got values
		if ( $GotValues == 0 ) {
			// We didn't, so add an error message
			$this->AddError( "Could not connect to Server -Please try again Later" );
		}
	}

	function AddParam( $Name, $Value ) {
		// URL encode the value and add to PostString
		$this->PostString = $this->PostString . $Name . "=" . urlencode( $Value ) . "&";
	}


	function DoTransaction() {
		$enduserip = $REMOTE_ADDR;
		$sitename = 'eNomiTron PHP';

		global $string;
	global $testmode;
	global $host;
		// Clear values
		$Values = "";
			if($testmode == "1"){
			$host = 'resellertest.enom.com';
			}
			elseif($testmode == "0"){
			$host = 'reseller.enom.com';
			}

		$port = 443;
		$socket = fsockopen("ssl://".$host,$port);
		
		if ( !$socket ) {
			function strerror()
				{
				global $message;
				$message .= "Could not connect to Server -Please try again Later";
				return $message;
				}
			$this->AddError( "socket() failed: " . strerror( $socket ) );
		} else {
			// Send GET command with our parameters
			$in = "GET /interface.asp?" . $this->PostString . "HTTPS/1.0\r\n\r\n";
			$out = '';
			fputs($socket,$in);
			// Read response
			while ( $out=fread ($socket,2048) ) {
				// Save in rawdata
				$this->RawData .= $out;
			}
			// Close the socket
			fclose( $socket );

			// Parse the output for name=value pairs
			$this->ParseResponse( $this->RawData );
		}
	}
	function DoTransaction2($string,$testmode) {
	$enduserip = $REMOTE_ADDR;
	$sitename = 'eNomiTron PHP';
	global $UseSSL;

	global $host;
	global $testmode;
		if($testmode == "1"){
			$host = 'resellertest.enom.com';
			}
			elseif($testmode == "0"){
			$host = 'reseller.enom.com';
			}

			$port = 443;
		$address = gethostbyname( $host );
		$socket = fsockopen("ssl://".$host,$port);

		if ( !$socket ) {
			$this->AddError( "Could not connect to the server - Please try again");
		} else {
			// Send GET command with our parameters
			$in = "GET /interface.asp?" . $string . "\r\n\r\n";
			$out = '';
			fputs($socket,$in);
			// Read response
			while ( $out=fread ($socket,2048) ) {
				// Save in rawdata
				$this->RawData .= $out;
			}
			// Close the socket
			fclose( $socket );

			// Parse the output for name=value pairs
			$this->ParseResponse( $this->RawData );
		}
	}

}
?>