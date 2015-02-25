<?php
session_name ('API-PHPSESSID-INSTALL');
session_start(); // Start the session.

require("../include/dbconfig.php");

$install = "update extra set installed = '1'";
$doinstall = mysql_query($install);

?>
<link rel="stylesheet" href="../css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('../include/header.php')?>
      </tr>
</table>
    <table width="964" height="200" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td height="196" valign="top">
			  <table width="100%" height="100" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader"> Enom API Installer has completed</span></div></td>
			    </tr>
				<tr>
			      <td height="100" colspan="3" valign="top" class="content2">
			        <p>&nbsp;</p>
			        <table width="501" height="86" border="0" align="center" cellpadding="0" cellspacing="0" class="tableOO">
                      <tr>
                        <th width="497" scope="col">Congratulations! Your all done. </th>
                      </tr>
                      <tr>
                        <td><p>Please go back and edit the dbconfig.php file located in the include directory for all your default settings and payment information. </p>
                        <p>For your protection, please delete the entire install directory. Failure to do so could allow another user to erase your database.</p></td>
                      </tr>
                    </table>
			        <p align="center"><strong><a href="<?=$site_url;?>">Click  Here</a> to go to your new site </strong></p>
			      <tr>
          </table></td>
</table>