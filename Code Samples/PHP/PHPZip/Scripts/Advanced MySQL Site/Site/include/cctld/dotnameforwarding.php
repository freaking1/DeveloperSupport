		<table>
		<?php		
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $username );
			$Enom->AddParam( "pw", $password );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "command", "getdotnameforwarding" );
			$Enom->DoTransaction();
			//error handling
			if ( $Enom->Values[ "ErrCount" ] != "0" ) {
				// Yes, get the first one
				$expMsg = $Enom->Values[ "Err1" ];
				$nameError = 1;
			} else {
				$dotNameFor = $Enom->Values[ "address" ];
				if ($dotNameFor == ""){
					$noNameFor = 1;
				}
			}
		?>
		
		<!-- this begins section Four -->
		<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader"> <strong>.Name </strong> Email Forwarding Information</span></td>
		</tr>
		<tr> 
			<td height="5" colspan="4">&nbsp;</td>
		</tr>
		<?php 
		if ($noNameFor = 1) { ?>
		<tr>
		  	<td width="43%" valign="top" class="row1">Email Forwarding Address Not Available<br /><br /></td>
			<td width="57%" valign="top" class="row2">&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<?php
		} else { ?>
		<tr>
		  	<td class="row1" valign="top">Email Forwarding Address<?php if ($nameError == 1){echo "<br />" . $expMsg;} ?><br /><br /><a href="../changeNameEmail.php">Change</a> email forwarding address<br /><br /></td>
			<td valign="top" class="row2">&nbsp;&nbsp;&nbsp;<input name="forwardto" type="text" value="<?php echo $dotNameFor; ?>" size="40" maxlength="40" /></td>
		</tr>
		<?php
		}
		?>
		
		
		</table>
