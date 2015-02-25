<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/changepass.php");
	exit(); 
} 

$refer = $_GET["refer"];

if($refer != "change"){
	header ("Location:  $secure_site_url/changepass.php");
	exit(); // Quit the script.
} else {
$PageTitle .= 'Change Your Password';
$page = "myaccount";
?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="147" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td width="145" height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
			<td class="content" align="center" valign="top" width="815">
			<table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Change Your Password</span></td>
			    </tr>
				<tr>
	                </p>
		      <tr>
<td colspan="3" valign="top" class="content2"><p align="center" class="BasicText style2">&nbsp;</p>
  <p align="center" class="BasicText style3"><strong>Your password has been changed. </strong></p>
  <p align="center" class="style1 BasicText">&nbsp;</p>
  <table width="622" border="0" align="center">
    <tr>
      <td height="90" class="OutlineOne"><span class="BasicText style6">Please do not forget your password as it has been encrypted in our database and we cannot retrieve it for you. However, should you forget your password you can request a new one which will be activated in the same way as this account</span><span class="style6">.</span></td>
    </tr>
  </table>  <p align="center">&nbsp;</p>
  <p align="center"><strong><a href="mydomains.php">
    BACK
  </a></strong></p>
  </table>
</table><? } ?>
		          <?php  include('include/footer.php');?>
</body>

</html>