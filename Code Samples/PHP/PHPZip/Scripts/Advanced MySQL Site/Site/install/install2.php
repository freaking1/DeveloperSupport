<?php

session_name ('API-PHPSESSID-INSTALL');
session_start(); // Start the session.

require("../include/dbconfig.php");

$StepNumber = $_SESSION['StepNumber'];

if ($StepNumber != 2){
	header ("Location:  $site_url/install/install$StepNumber.php");
	exit(); // Quit the script.
}

?>
<link rel="stylesheet" href="../css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('../include/header.php')?>
	    </tr>
</table>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td height="313" valign="top">
			  <table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">Welcome to the Enom API Installer script - Installation - Step
                        <?=$StepNumber;?>
				  </span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">
			        <p>&nbsp;</p>

<?php
if($StepNumber == 2){
				echo '<table width="820" align="center" border="0">
                      <tr>
                        <td width="810">Testing Database connection with the info in dbconfig.php.</td>
                      </tr>
				';

$dbc = @mysql_connect ($dbhost, $dbusername, $dbpassword);
mysql_select_db ("$dbdatabase", $dbc);


					if(mysql_errno() == 0){
                echo'      <tr>
                        <td width="810">Success!  Next we will Import data.  Any existing data will be lost - so do not do this unless you have an empty database or you are ok with loosing the data if it exists.  Pleaes click Continue to proceed.</td>
                      </tr></table>';
						$StepNumber = 3;
						$_SESSION['StepNumber'] = 3;
						echo '<center><a href="install3.php">Continue</a></center>';
						} elseif(mysql_errno() != 0){
                echo'      <tr>
                        <td width="810">There was a problem connecting to the database specified in dbconfig - please check the file and try again.</td>
                      </tr></table>';
						$StepNumber = 2;
						$_SESSION['StepNumber'] = 2;
						echo '<center><a href="install2.php">Try Again</a></center>';
					  }
 }
?>



			        <p>&nbsp;</p>
			      <tr>
            </table></td>
		</table>