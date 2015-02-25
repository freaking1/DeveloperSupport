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
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader"> <strong>dot name</strong> Email Forwarding Information</span></td>
		</tr>
		<tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" class="tdcolorone">&nbsp;</td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		</tr>
		<?php 
		if ($noNameFor = 1) { ?>
		<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
		  	<td class="row1" valign="top">Email Forwarding Address Not Available<br /><br /></td>
			<td valign="top" class="row2">&nbsp;&nbsp;&nbsp;</td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		</tr>
		<?php
		} else { ?>
		<tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
		  	<td class="row1" valign="top">Email Forwarding Address<?php if ($nameError == 1){echo "<br />" . $expMsg;} ?><br /><br /><a href="../changeNameEmail.php">Change</a> email forwarding address<br /><br /></td>
			<td valign="top" class="row2">&nbsp;&nbsp;&nbsp;<input name="forwardto" type="text" value="<?php echo $dotNameFor; ?>" size="40" maxlength="40" /></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		</tr>
		<?php
		}
		?>
		