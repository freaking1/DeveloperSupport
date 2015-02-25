<?
			// Set the session vars
				
			//register OrderID and retrieve it from HTTP VARS
			$_SESSION['transferorderid'] = $Enom->Values[ "transferorderid" ];
			$_SESSION['userpassword'] = $cPW1;
			$_SESSION['LoggedIn'] = 1;
?>
		<tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Success!</span></td>
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
			if ( $cAction == "transfer" ) {
				// The transfer obviously worked if we got here, so let's
				// print out the result
				if ( $bError == 0 ) {
					// There no error, print that out
					echo "<B class=\"main\">Your confirmation number for the domain name <b>$sld.$tld  ";
					echo "is: $transferorderid </div></br>";
					echo "<div>Your password is:  $cPW1 </div><br><br>";
					echo "Please check your e-mail for the Transfer approval email<br>If you dont get one soon, please contact us";
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