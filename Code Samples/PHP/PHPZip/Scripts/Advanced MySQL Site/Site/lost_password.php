<?php 
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$refer = $_GET["refer"];
	$email = $_SESSION['email_row1']; 

	if($refer != "lostpass"){
	header ("Location:  $secure_site_url/lostpassword.php");
	exit(); // Quit the script.
	}

	$PageName= "PasswordRecovery";
	$PageTitle = $SiteTitle . " - Your password has been sent";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Reset your password </span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><br>			        			      
		          <br>
		          <table width="625" align="center" cellpadding="0" cellspacing="0" class="tableOO">
                    <tr>
                      <td width="621" class="titlepic"><div align="center"><span class="whiteheader"> Reset your Password </span> </div></td>
                    </tr>
                    <tr>
                      <td align="center"><div align="center">
                          <center>
                            <span class="BasicText">Your new password has been generated, and your account has been updated. <br>
          The new password for your account has been emailed to the email address that we have on file for your account, which is <b><u>
		          <?=$email;?>
		          </u></b>.<br>
		          <br>
          Please retrieve your password, and login to your account and immediately change your password to something more familiar by clicking on the <b>"Change Password"</b> link after login. </span>
                          </center>
                          <table cellpadding="2" cellspacing="2">
                            <tr>
                              <td colspan="2" align="center"></td>
                            </tr>
                          </table>
                      </div></td>
                    </tr>
                  </table>		          <p>&nbsp;</p>
                  <p align="center" class="BasicText style1"><a href="<?=$secure_site_url;?>/login.php">Login
				  					
</a></p>
			      <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>
