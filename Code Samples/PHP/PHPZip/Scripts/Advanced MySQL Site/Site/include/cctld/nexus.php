		  <tr> 
			<td height="5" colspan="5" align="center" class="titlepic"> <span class="whiteheader">Nexus Information</span></td></tr>
			<tr><td colspan="5" >
			<table width="511"  border="0">
              <tr>
                <td colspan="3" align="center">&nbsp;</td>
              <tr>
                <td colspan="3" align="center"><b class="red">*</b>Nexus Category 
(Only applies to and is required 
for .US domain names) </td>
              <tr>
                <td width="33" align="center"><div align="center">
                  <input type="radio" name="NexusCategory" value="C11" <?php if ( $NexusCategory == "C11" ) { echo "checked"; } ?>>
                </div></td>
                <td width="33" align="center"><div align="center"><b>C11</b></div></td>
                <td width="431"> &nbsp;&nbsp;A natural person who is a US Citizen
              <tr>
                              <td align="center"><div align="center">
                                <input type="radio" name="NexusCategory" value="C12" <?php if ( $NexusCategory == "C12" ) { echo "checked"; } ?>>
                </div></td>
                              <td align="center"><div align="center"><b>C12</b></div></td>
                              <td>&nbsp;&nbsp;A natural person who is a Permanent Resident                            
              <tr>
                <td align="center"><div align="center">
                  <input type="radio" name="NexusCategory" value="C21" <?php if ( $NexusCategory == "C21" ) { echo "checked"; } ?>>
                </div></td>
                <td align="center"><div align="center"><b>C21</b></div></td>
                <td>&nbsp;&nbsp;An entity or organization that is (i) incorporated within one of the fifty US states, the District of Columbia, or any of the US possessions or territories, or (ii) organized or otherwise constituted under the laws of a state of the US, the District of Columbia or any of its possessions and territories (including federal, state, or local government of the US, or a political subdivision thereof, and non-commercial organizations based in the US.)                            
              <tr>
                <td align="center"><div align="center">
                  <input type="radio" name="NexusCategory" value="C31" <?php if ( $NexusCategory == "C31" ) { echo "checked"; } ?>>
                </div></td>
                <td align="center"><div align="center"><b>C31/CC</b></div></td>
                <td>&nbsp;&nbsp;A foreign organization that regularly engages in lawful activities (sales of goods or services or other business, commercial, or non-commercial, including not for profit relations) in the United States. The CC equals to the country code of the organization, as defined in ISO 3166 [10].                            
                <tr>
                  <td align="center"><div align="center">
                    <input type="radio" name="NexusCategory" value="C32" <?php if ( $NexusCategory == "C32" ) { echo "checked"; } ?>>
                  </div></td>
                  <td align="center"><div align="center"><b>C32/CC</b></div></td>
                  <td align="center">&nbsp;&nbsp;An organization has an office or other facility in the U.S., where CC equals to the county code of the organization, as defined in ISO 3166 [10].</td>
                <tr>
                  <td colspan="3" align="center">&nbsp;</td>
                <tr>
                  <td colspan="3" align="center">&nbsp;</td>
                <tr>
                  <td colspan="3" align="center"><b class="red">*</b>Nexus Country&nbsp;&nbsp;&nbsp;&nbsp; <span class="nexus">(Required if either C31 or C32 is selected above.)</span> </td>
                              <tr>
                              <td colspan="3" align="center"><select name="NexusCountry">
              &nbsp;&nbsp;
              <?php include ('include/country.php'); ?>
            </select>                           </td>
                              <tr>
                                <td colspan="3" align="center">&nbsp;                              </td>
              <tr>
                <td colspan="3" align="center">&nbsp;                </td>
                <tr>
                  <td colspan="3" align="center"> <span class="red">*</span>Application Purpose   
(The intended usage for this domain name.) </td>
                            <tr>
                              <td align="center"><input type="radio" name="AppPurpose" value="P1" <?php if ( $AppPurpose == "P1" ) { echo "checked"; } ?>></td>
                              <td align="center"><b>P1</b></td>
                              <td>Business use for profit                            
                            <tr>
                              <td align="center"><input type="radio" name="AppPurpose" value="P2" <?php if ( $AppPurpose == "P2" ) { echo "checked"; } ?>></td>
                              <td align="center"><b>P2</b></td>
                              <td>Non-profit business, club, association, religious organization, etc.                            
              <tr>
                              <td align="center"><input type="radio" name="AppPurpose" value="P3" <?php if ( $AppPurpose == "P3" ) { echo "checked"; } ?>></td>
                <td align="center"><b>P3</b></td>
                              <td>Personal use                            
                            <tr>
                              <td align="center"><input type="radio" name="AppPurpose" value="P4" <?php if ( $AppPurpose == "P4" ) { echo "checked"; } ?>></td>
                              <td align="center"><b>P4</b></td>
                              <td>Educational purposes                            
                            <tr>
                              <td align="center"><input type="radio" name="AppPurpose" value="P5" <?php if ( $AppPurpose == "P5" ) { echo "checked"; } ?>></td>
                              <td align="center"><b>P5</b></td>
                              <td>Government purposes                            
                            <tr>
                              <td align="center">&nbsp;</td>
                              <td align="center">&nbsp;</td>
                              <td>                            
              </table>			  
		  </tr>
<tr>
			<td width="40%"><b class="red"></span></td>
  <td colspan="3" valign="middle">&nbsp;</td>
</tr>
<tr>
  <td align="center" valign="left" >&nbsp;</td>
		  </tr>
