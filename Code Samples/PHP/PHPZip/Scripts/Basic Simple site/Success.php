<?php
		include( "include/sessions.php" );
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
		$userpassword = $_SESSION['userpassword'];
		$OrderID = $_SESSION['OrderID'];
	//Page name - DO NOT CHANGE
	$PageName = "Success";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = "Welcome to eNomitron - Success! Your name has been registered.";

	//This file must be inluded.
	include('include/header.php'); 
	
	// Begin page content
?>
	<tr> 
		<td class="OutlineOne"><br /> 
      		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
      <!-- beginning of page content -->
      <tr> 
        <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Congratulations!</span></td>
      </tr>
      <tr> 
        <td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
        <td colspan="2" align="center" valign="middle" class="row1"> <p><img src="images/blank.gif" width="5" height="15" border="0" /><br />
            Your domain name has been registered.<br />
          </p>
          <table width="77%" border="0">
            <tr> 
              <td colspan="2"><div align="center">Order Details:</div></td>
            </tr>
            <tr> 
              <td width="37%"><div align="right">Domain :</div></td>
              <td width="63%"><strong class="red"><?php echo $sld . "." . $tld; ?></strong></td>
            </tr>
            <tr> 
              <td><div align="right">Password :</div></td>
              <td><strong class="red"><?php echo $userpassword; ?></strong></td>
            </tr>
            <tr> 
              <td><div align="right">Order Confirmation #:</div></td>
              <td><strong class="red"><?php echo $OrderID; ?></strong></td>
            </tr>
            <tr> 
              <td><div align="center"></div></td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <p> An email configmation has been sent to the email address you <br>
            used during purchase with your domain name login and password.<br />
            <br />
            Please <a href="LogIn.php">click here</a> to login and begin 
            setting up your domain!</p>
          </td>
        <td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
      </tr>
      <!-- end of page content -->
    </table>
		  <br />
		</td>
	</tr>
	  
	<? include('include/footer.php'); ?>