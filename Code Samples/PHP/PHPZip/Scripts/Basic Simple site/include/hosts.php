
			<tr> 
				<td colspan="4" height="5" class="tdcolorone"><span class="cattitle">&nbsp;Hosts</span></td>
			</tr>
			<tr> 
				<td width="40%" height=50 align="center" valign="middle" class="row1" colspan="2">
				<?php
					// Create URL Interface class
					$Enom = new CEnomInterface;
				
					// Check nameservers first
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $username );
					$Enom->AddParam( "pw", $password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
					
					$Enom->AddParam( "command", "getdnsstatus" );
					$Enom->DoTransaction();
					
					
					// Make sure it was successful
					$bEnomDNS = 0;
					if ( $Enom->Values[ "ErrCount" ] == "0" ) {
						// Check if they are using eNom's nameservers
						if ( $Enom->Values[ "UseDNS" ] == "default" ) {
							$bEnomDNS = 1;
						}
					} else {
						echo "Error checking nameserver status: {$Enom->Values[ "Err1" ]}";
					}
				
					if ( $bEnomDNS == 1 ) {
						// display instructions
						$displayInsOn = 1;
						
						// Get a list of hosts for this domain
						$Enom->NewRequest();
						$Enom->AddParam( "uid", $username );
						$Enom->AddParam( "pw", $password );
						$Enom->AddParam( "tld", $tld );
						$Enom->AddParam( "sld", $sld );
				
						$Enom->AddParam( "command", "gethosts" );
						$Enom->DoTransaction();	
					
						// Make sure it was successful
						if ( $Enom->Values[ "ErrCount" ] == "0" ) {
							
							// Make enough edit boxes for the existing entries plus 5 more
							$nHostCount = $Enom->Values[ "HostCount" ] + 5;
							
							// Make sure the page we link to knows how many edit boxes there are
							echo "<input type=\"hidden\" name=\"HostCount\" value=\"$nHostCount\">";
				
							// Display a table for the information
							echo "<table border=\"0\" cellpadding=\"4\" cellspacing=\"0\">";
							
							// Check if we're supposed to modify something
							if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
								// Check if any hosts were modified
								if ( WereHostsModified() == 1 ) {
									echo "<tr><td>";
									ModifyHosts();
									echo "<tr><td>";
								}
							}
							
							echo "<tr><td>&nbsp;</td><td align=\"center\"><b>Hostname</b></td> <td align=\"center\"><b>Address</b></td> ";
							echo "<td align=\"center\"><b>Record Type</b></td> <td align=\"center\"><b>MX Pref</b></td></tr>";
								
							// Create all the table rows
							for ( $i = 1; $i <= $nHostCount; $i++ ) {
							
								$RecType = $Enom->Values[ "RecordType$i" ];
								// Display edit boxes
								echo "<tr>";
								echo "<td align=\"right\">$i)</td><td align=\"center\"><input size=\"7\" maxlength=\"60\" type=\"text\" id=\"idHostName$i\" name=\"HostName$i\" value=\"{$Enom->Values[ "HostName" . $i ]}\"></td>";
								echo "<td><input size=\"12\" maxlength=\"130\" type=\"text\" id=\"idAddress$i\" name=\"Address$i\" value=\"{$Enom->Values[ "Address" . $i ]}\"></td>";
																	
								echo "<td><select name=\"RecordType$i\">";
								?>
								<option value="A" <?php if ( $RecType=="A" ) { echo "selected"; } ?>>A (Address)</option>
								<option value="MXE" <?php if ( $RecType=="MXE" ) { echo "selected"; } ?>>MXE (Mail Easy)</option>
								<option value="MX" <?php if ( $RecType=="MX" ) { echo "selected"; } ?>>MX (Mail)</option>
								<option value="CNAME" <?php if ( $RecType=="CNAME" ) { echo "selected"; } ?>>CNAME (Alias)</option>
								<option value="URL" <?php if ( $RecType=="URL" ) { echo "selected"; } ?>>URL Redirect</option>
								<option value="FRAME" <?php if ( $RecType=="FRAME" ) { echo "selected"; } ?>>URL Frame</option>
								</select></td>
								<?php
								
								echo "<td><input maxlength=\"4\" size=\"6\" type=\"text\" id=\"idMXPref$i\" name=\"MXPref$i\" value=\"{$Enom->Values[ "MXPref" . $i ]}\"></td></tr>";
				
								// Insert hidden fields with previous info
								echo "<input type=\"hidden\" name=\"OldHostName$i\" value=\"{$Enom->Values[ "HostName" . $i ]}\">";
								echo "<input type=\"hidden\" name=\"OldAddress$i\" value=\"{$Enom->Values[ "Address" . $i ]}\">";
								echo "<input type=\"hidden\" name=\"OldRecordType$i\" value=\"{$Enom->Values[ "RecordType" . $i ]}\">";
								echo "<input type=\"hidden\" name=\"OldMXPref$i\" value=\"{$Enom->Values[ "MXPref" . $i ]}\">";
							}
							echo "</table>";
						} else {
							// The eNom server returned an error, print it out
							echo "There were errors getting the host list: {$Enom->Values[ "Err1" ]}<br />";
						}
					} else {
						echo "Not using our nameservers<br />";
					}
				?></td>
			</tr>
			<? if ($displayInsOn == 1) {include ('hostInstructions.php');} ?>