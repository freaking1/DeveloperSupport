		  <tr> 
			<td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">&nbsp;Billing&nbsp;&nbsp;Information</span></td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Credit&nbsp;Card&nbsp;type:&nbsp;&nbsp;&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<select name="CardType">
				<option value="VISA">VISA</option>
				<option value="AMERICAN EXPRESS">American Express</option>
				<option value="MASTERCARD">Mastercard</option>
				<option value="DISCOVER">Discover</option>
				</select></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Cardholder's&nbsp;Name<br />&nbsp;&nbsp;<font size=2>(as it appears on the card)</font>&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" size="20" maxlength="60" name="CCName" id="idnameoncard" value="<?php echo $HTTP_POST_VARS[ "CCName" ]; ?>"></td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Cardholder's Address:&nbsp;&nbsp;&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="CCAddress" id="idCCAddress" maxlength="60" value="<?php echo $HTTP_POST_VARS[ "CCAddress" ]; ?>"> </td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Cardholder's Zip:&nbsp;&nbsp;&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" name="CCZip" id="idCCZip" value="<?php echo $HTTP_POST_VARS[ "CCZip" ]; ?>" size="15" maxlength="20"> </td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Credit&nbsp;Card&nbsp;number:&nbsp;&nbsp;</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input type="text" maxlength="16" name="CreditCardNumber" value="<?php echo $HTTP_POST_VARS[ "CreditCardNumber" ]; ?>"> </td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>CVV Number<br />(located on back of card):</td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<input name="CVV2" type="text" id="idCVV2" value="<?php echo $HTTP_POST_VARS[ "CVV2" ]; ?>" size="5" maxlength="3"> </td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="row1">&nbsp;</td>
			<td  class="row1"><b class="red">*</b>Expiration&nbsp;Date:&nbsp;&nbsp;<br /></td>
			<td valign="middle" class="row2">&nbsp;&nbsp;<select name="CreditCardExpMonth">
				<option>01</option>
				<option>02</option>
				<option>03</option>
				<option>04</option>
				<option>05</option>
				<option>06</option>
				<option>07</option>
				<option>08</option>
				<option>09</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
				</select> &nbsp;&nbsp; <select name="CreditCardExpYear">
				<option>2005</option>
				<option>2006</option>
				<option>2007</option>
				<option>2008</option>
				<option>2009</option>
				<option>2010</option>
				<option>2011</option>
				<option>2012</option>
				<option>2013</option>
				<option>2014</option>
				<option>2015</option>
				<option>2016</option>
				<option>2017</option>
				<option>2018</option>
				<option>2019</option>
				<option>2020</option>
				<option>2021</option>
				<option>2022</option>
				<option>2023</option>
				</select> &nbsp;&nbsp;</td>
			<td align="center" valign="middle" noWrap class="row2">&nbsp;</td>
		  </tr>