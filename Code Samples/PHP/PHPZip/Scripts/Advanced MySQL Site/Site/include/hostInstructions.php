<tr>
  <td height="5" colspan="4" class="titlepic"><span class="whiteheader">Instructions</span></td>
</tr>
<tr>
  <td width="5%" height=50 align="center" valign="middle" class="row1">&nbsp;</td>
  <td width="40%" height=50 align="center" valign="middle" class="row1" colspan="2">
    <table width="600" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><img src="../images/blank.gif" width="600" height="15" border="0">
		    The form above works just like a switchboard. You can specify where
            third-level names (also called, &quot;hosts&quot;) for your domain
            name &quot;<strong><?php echo "$sld.$tld"; ?></strong>&quot; are
            directed to.
          <p>In the &quot;Host Name&quot; column, enter your third-level domain,
            for example &quot;www&quot; would indicate &quot;www.<?php echo "$sld.$tld"; ?>&quot; and &quot;home&quot; would
            indicate &quot;home.<?php echo "$sld.$tld"; ?>&quot;. You can even
            use &quot;ftp&quot; to indicate &quot;ftp.<?php echo "$sld.$tld"; ?>&quot;.
            Also, if you would like to allow users to access your site with simply &quot;<?php echo "$sld.$tld"; ?>&quot;,
            then either leave the field blank or type an &quot;@&quot;. NOTE:
            If &quot;@&quot; is used for Host Name, then Record Type can not
            be &quot;CNAME&quot;.<br />
            <br />
            The following chart describes acceptable values for each &quot;Record
            Type&quot;: </p>
          <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#999999" bordercolorlight="#999999" bordercolordark="#333333">
            <tr valign="top">
              <td width="23%"><strong>Record Type</strong></td>
              <td width="72%"><b>Valid entries for Address</b></td>
            </tr>
            <tr valign="top">
              <td>A (Address)</td>
              <td><b>Must</b> be the IP address of a web server, for example &quot;209.19.56.15&quot;.</td>
            </tr>
            <tr valign="top">
              <td>MXE (Mail Easy)</td>
              <td><b>Must</b> be the IP address of a mail server, for example &quot;209.19.56.20&quot;.</td>
            </tr>
            <tr valign="top">
              <td>MX (Mail)</td>
              <td>Can be either a host name under this domain name (for example, &quot;mail3&quot;) <b>or</b> the
                name of a mail server (for example, &quot;mail.yahoo.com.&quot;). </td>
            </tr>
            <tr valign="top">
              <td>&nbsp;</td>
              <td>NOTE: When using a mail server name, it should end with a period &quot;.&quot;.
                (If you forget the period and we recognize the TLD, we will automatically
                insert one.) </td>
            </tr>
            <tr valign="top">
              <td>CNAME (Alias) </td>
              <td>Can be either a host name under this domain name (for example, &quot;www&quot;) <b>or</b> another
                domain name (for example, &quot;www.yahoo.com.&quot;). </td>
            </tr>
            <tr valign="top">
              <td>&nbsp;</td>
              <td>NOTE: When using a domain name, it should end with a period &quot;.&quot;.
                (If you forget the period and we recognize the TLD, we will automatically
                insert one.) </td>
            </tr>
            <tr valign="top">
              <td>URL Redirect</td>
              <td rowspan="2">For URL Redirect and URL Frame, this field should
                contain a full URL address, for example &quot;http://dir.yahoo.com/arts/humanities/&quot;. </td>
            </tr>
            <tr valign="top">
              <td>URL Frame</td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </td>
      </tr>
    </table>
  </td>
  <td width="5%" height=50 align="center" valign="middle" noWrap class="row1">&nbsp;</td>
</tr>
<tr>
  <td colspan="4" align="center" valign="middle" class="row1">&nbsp;</td>
</tr>
