			<tr> 
				<td colspan="4" height="5" class="tdcolorone"><span class="cattitle">&nbsp;Email&nbsp;&nbsp;Forwarding</span></td>
			</tr>
			<tr> 
				<td width="40%" height=50 align="center" valign="middle" class="row1" colspan="2"><?php
				if ( $bEnomDNS == 1 ) {
					// Get email forwarding accounts
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $username );
					$Enom->AddParam( "pw", $password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
			
					$Enom->AddParam( "command", "getforwarding" );
					$Enom->DoTransaction();	
			
					// Make sure it was successful
					if ( $Enom->Values[ "ErrCount" ] == "0" ) {
						// Make enough edit boxes for the existing entries plus 5 more
						$nEmailCount = $Enom->Values[ "EmailCount" ] + 5;
			
						// Make sure the page we link to knows how many edit boxes there are
						echo "<input type=\"hidden\" name=\"EmailCount\" value=\"$nEmailCount\">";
				
						// Display a table for the information
						echo "<table border=\"0\" cellpadding=\"4\" cellspacing=\"0\">";
						echo "<tr><td>&nbsp;</td><td align=\"center\"><b>Username</b></td>";
						echo "<td align=\"center\">Domain</td> <td align=\"center\"><b>Forward To</b></td></tr>";
						
						// Create all the table rows
						for ( $i = 1; $i <= $nEmailCount; $i++ ) {
							// Display edit boxes
							echo "<tr>";
							echo "<td align=\"right\">$i)</td><td align=\"center\"><input size=\"25\" maxlength=\"30\" type=\"text\" id=\"idUsername$i\" name=\"Username$i\" ";
							echo "value=\"{$Enom->Values[ "Username" . $i ]}\"></td>";
							echo "<td>@$sld.$tld</td>";
							echo "<td><input size=\"30\" maxlength=\"120\" type=\"text\" id=\"idForwardTo$i\" name=\"ForwardTo$i\" value=\"{$Enom->Values[ "ForwardTo" . $i ]}\"></td></tr>";
			
							// Insert hidden fields with previous info
							echo "<input type=\"hidden\" name=\"OldUsername$i\" value=\"{$Enom->Values[ "Username" . $i ]}\">";
							echo "<input type=\"hidden\" name=\"OldForwardTo$i\" value=\"{$Enom->Values[ "ForwardTo" . $i ]}\">";
						}
						echo "</table>";
					} else {
						// The eNom server returned an error, print it out
						echo "There were errors getting the email list: {$Enom->Values[ "Err1" ]}<br />";
					}
				} else {
					echo "Not using our nameservers<br />";
				}
			?></td>
			</tr>