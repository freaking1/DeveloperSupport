
		<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Error</span></td>
		</tr>
		
		<tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" class="tdcolorone">&nbsp;</td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		</tr>
					
		<tr> 
			<td width="5%" height=50 align="center" valign="middle" class="row1">&nbsp;</td>
			<td class="row1" colspan="3">
			<br />			  
			<div class="main">
			<?php
			// Check if there are any messages to display
			if ( $cAction == "register" ) {
				// The register obviously didn't go well if we got here, so let's
				// print out the error
				if ( $bError == 1 ) {
					// There was some kind of error, print that out
					echo "<B class=\"main\">We're sorry, there was an error with the domain name <b>$sld.$tld</b><br /><br />";
					echo "<div class=red>The error was \"$cErrorMsg\"</div>";
				} else if ( $bRegistered == 0 ) {
					// The domain name is already registered
					echo "<B class=\"main\">We're sorry, the domain name <b class=red>$sld.$tld";
					echo "</b> has already been registered. Please try another.</b><br />";
				} else {
					// Shouldn't get here!!!
					echo "Unknown error occurred<br />Please try again.";
				}
			}
			?>
			</div>&nbsp;<br /></td>
		</tr>
					
		<tr> 
			<td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
		</tr>