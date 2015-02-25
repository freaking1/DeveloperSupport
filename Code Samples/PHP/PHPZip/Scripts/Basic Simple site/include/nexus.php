
		  <!-- this begins section Four -->
		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"></td>
		  </tr>
		  <tr> 
			<td class="tdcolorone" height="5">&nbsp;</td>
			<td width="40%" height="5" class="tdcolorone"><span class="cattitle">&nbsp;Nexus&nbsp;&nbsp;Information</span></td>
			<td class="rowpic" align="right" colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Nexus Category<br />
       			(Only applies to and is required for .US domain names)</span></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="radio" name="NexusCategory" value="C11" <?php if ( $NexusCategory == "C11" ) { echo "checked"; } ?>>
			<b>C11</b>: A natural person who is a US Citizen<br />
			<br />
			&nbsp;&nbsp;<input type="radio" name="NexusCategory" value="C12" <?php if ( $NexusCategory == "C12" ) { echo "checked"; } ?>>
			<b>C12</b>: A natural person who is a Permanent Resident<br />
			<br />
			&nbsp;&nbsp;<input type="radio" name="NexusCategory" value="C21" <?php if ( $NexusCategory == "C21" ) { echo "checked"; } ?>>
			<b>C21</b>: An entity or organization that is (i) incorporated within 
			one of the fifty US states, the District of Columbia, or any of the 
			US possessions or territories, or (ii) organized or otherwise constituted 
			under the laws of a state of the US, the District of Columbia or any 
			of its possessions and territories (including federal, state, or local 
			government of the US, or a political subdivision thereof, and non-commercial 
			organizations based in the US.)<br />
			<br />
			&nbsp;&nbsp;<input type="radio" name="NexusCategory" value="C31" <?php if ( $NexusCategory == "C31" ) { echo "checked"; } ?>>
			<b>C31/CC</b>: A foreign organization that regularly engages in lawful activities 
			(sales of goods or services or other business, commercial, or non-commercial, 
			including not for profit relations) in the United States. The CC equals 
			to the country code of the organization, as defined in ISO 3166 [10].<br />
			<br />
			&nbsp;&nbsp;<input type="radio" name="NexusCategory" value="C32" <?php if ( $NexusCategory == "C32" ) { echo "checked"; } ?>>
			<b>C32/CC</b>: An organization has an office or other facility in the U.S., 
			where CC equals to the county code of the organization, as defined in ISO 
			3166 [10].</td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Nexus Country<br />
				<span class="nexus">(Required if either C31 or C32 is selected above.)</span></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<select name="NexusCountry">
				&nbsp;&nbsp;<?php include ('country.php'); ?>
				</select></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Application Purpose<br />
				<span class="nexus">(The intended usage for this domain name.)</span></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="radio" name="AppPurpose" value="P1" <?php if ( $AppPurpose == "P1" ) { echo "checked"; } ?>>
				<b>P1</b>: Business use for profit<br />
				<br />
				&nbsp;&nbsp;<input type="radio" name="AppPurpose" value="P2" <?php if ( $AppPurpose == "P2" ) { echo "checked"; } ?>>
				<b>P2</b>: Non-profit business, club, association, religious organization, 
				etc.<br />
				<br />
				&nbsp;&nbsp;<input type="radio" name="AppPurpose" value="P3" <?php if ( $AppPurpose == "P3" ) { echo "checked"; } ?>>
				<b>P3</b>: Personal use<br />
				<br />
				&nbsp;&nbsp;<input type="radio" name="AppPurpose" value="P4" <?php if ( $AppPurpose == "P4" ) { echo "checked"; } ?>>
				<b>P4</b>: Educational purposes<br />
				<br />
				&nbsp;&nbsp;<input type="radio" name="AppPurpose" value="P5" <?php if ( $AppPurpose == "P5" ) { echo "checked"; } ?>>
				<b>P5</b>: Government purposes
				</td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>