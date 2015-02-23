<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
if (!isset($_SESSION['loggedin_user'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php");
	exit(); // Quit the script.
} 
	//Remember to change this file once you are ready to go live
	include( "include/dbconfig.php" );
	$_SESSION["OrderID"] = $e_order_id;
	$_SESSION["expiration"] = $expiration;
	$_SESSION["sld"] = $sld;
	$_SESSION["tld"] = $tld;
	//Page name - DO NOT CHANGE
	$PageName = "Success";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle .= "Success! Your name has been registered.";
		?>
	
<link rel="stylesheet" href= "css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="149" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
			<td class="content" align="center" valign="top" width="811">
			<table width="101%" height="218" border="0" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Success!!</span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">&nbsp;			          </p>
			        <p align="center" class="BasicText"><strong>Your Domain <?php echo "$sld.$tld";?> 
		            has been successfully registered. </strong></p>
			        <p align="center">  <table width="622" border="0" align="center">
    <tr>
      <td width="145" height="90"><span class="row1"></span></td>
      <td width="369"><span class="row1">Your Domain is : <strong class="red"><?php echo $sld . "." . $tld; ?></strong><br />

Your OrderID is : <strong class="red"><?php echo $e_order_id; ?><br>
Your Expiration date is: <?=$expiration;?></strong></span></td>
      <td width="94">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="center"><span class="row2">To set up your domain now, <a href="mydomains.php">click here</a>!</span></div></td>
    </tr>
  </table>  
			        </p>
<p align="center"><strong><span class="BasicText">Please check your email for your registration confirmation email.</span></strong><br> 
              </p>
		          <tr>
	                <td colspan="3" valign="top" class="content2">                    
		      </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>