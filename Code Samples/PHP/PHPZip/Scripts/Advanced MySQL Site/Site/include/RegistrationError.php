


		<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Error</span></td>
		</tr>
		
		<tr> 
			<td >&nbsp;</td>
			<td width="40%" height="5" >&nbsp;</td>
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
					
		<tr> 
			<td width="5%" height=50 align="center" valign="middle" >&nbsp;</td>
			<td colspan="3" nowrap>
			<br />			  
			<?php
			// Check if there are any messages to display
			if ( $action == "register" ) {
				// The register obviously didn't go well if we got here, so let's
				// print out the error
				if ( $bError == 1 ) {
					// There was some kind of error, print that out
					echo "<B class=\"main\">We're sorry, but there was an error during the registration<br> of your domain name: <br><center><span class=\"basictext\"><b>$sld.$tld</b></span></center><br /><br />";
					echo "<div class=red>The error was \"$cErrorMsg\"</div>";
				} else if ( $bRegistered == 0 ) {
					// The domain name is already registered
					echo "<B class=\"main\">We're sorry, the domain name <b class=red>$cSld.$cTld";
					echo "</b> has already been registered. Please try another.</b><br />";
				} else {
					// Shouldn't get here!!!
					echo "Unknown error occurred<br />Please try again.";
				}
			}
			?>
			<br/></td>
		</tr>
					
		<tr> 
			<td colspan="4" align="center" valign="middle" >&nbsp;</td>
		</tr>
		
		
		
