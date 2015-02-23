<?php
session_name ('API-PHPSESSID-INSTALL');
session_start(); // Start the session.

$BegInInstall = $_SESSION['BegInInstall'];
if ($BegInInstall != 1){
	header ("Location:  $site_url/index.php");
	exit(); // Quit the script.
}

require("../include/dbconfig.php");
$StepNumber = $_SESSION['StepNumber'];

if(($StepNumber = '') || ($StepNumber = '0') || ($StepNumber = '1')){
	$StepNumber = '1';
	} else {
	$StepNumber = $_SESSION['StepNumber'];
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
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader"> Welcome to the Enom  API Installer script - Installation - Step
				    <?=$StepNumber;?></span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">
			        <p>&nbsp;</p>

<?php
if($StepNumber == 1){
				echo '<table width="820" align="center" border="0">
                      <tr>';

						if($EditedFile != 1){
						echo '<td><center>Please edit the dbconfig.php file that is in the includes directory. This file will contain most variables for your setup, such as your paypal and payment variables, your enom username and password, and some site configuration data. Please edit that file before you start. </td></tr>';
						} else {
						echo '<td><center>Congratulations, the dbconfig.php file has been edited, lets move on to the next step</td></tr>';
						$StepNumber = 2;
						$_SESSION['StepNumber'] = 2;
						}
				echo '</table>';

					if($EditedFile == 1){
						$StepNumber = 2;
						$_SESSION['StepNumber'] = 2;
						echo '<center><a href="install2.php">Continue</a></center>';
						}
 }
?>



			        <p>&nbsp;</p>
			      <tr>
            </table></td>
		</table>