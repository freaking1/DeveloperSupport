
		<tr>
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Error</span></td>
		</tr>
		<tr>
			<td width="5%" height=50 align="center" valign="middle" class="row1">&nbsp;</td>
			<td class="row1" colspan="3">
			<br />
			<div class="main">
			<?php
			// Check if there are any messages to display
			if ( $cAction == "transfer" ) {
				// The register obviously didn't go well if we got here, so let's
				// print out the error
				if ( $bError == 1 ) {
					// There was some kind of error, print that out
					echo "<B class=\"main\">We're sorry, there was an error Transfering the domain name <b>$sld.$tld</b><br /><br />";
					echo "<div class=red>The error was \"$cErrorMsg\"</div>";
				} else {
					// Shouldn't get here!!!
					echo "Unknown error occurred<br />Please try again.";
				}
			}
			?>
			</div>&nbsp;<br /></td>
		</tr>

		<tr>
			<td colspan="4" align="center" valign="middle" class="row1"><a href="index.php"><img src="/images/btn_back.gif" width="74" height="22" border="0"></a></td>
		</tr>