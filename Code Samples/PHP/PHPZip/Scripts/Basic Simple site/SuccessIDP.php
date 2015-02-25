<?php
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
		$OrderID = $_SESSION['OrderID'];
		$LoggedIn = $_SESSION['LoggedIn'];
		$success = $_SESSION['success'];
		
if($LoggedIn != 1){
	header ("Location: LogIn.php");
	exit;
	}
	
if($success != 1){
	header ("Location: index.php");
	exit;
	}
	//Page name - DO NOT CHANGE
	$PageName = "Success";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = "Welcome to eNomitron - Success! Your order has been processed.";

	//This file must be inluded.
	include('include/header.php'); 
	
	// Begin page content
?>
	<tr> 
		<td class="OutlineOne"><br /> 
      		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
				<tr> 
					<td align="center" valign="middle" class="titlepic"><span class="whiteheader">Congratulations!</span></td>
				</tr>
			
				<tr> 
					<td height="5" class="tdcolorone">&nbsp;</td>
				</tr>
				
				<tr> 
					<td align="center" valign="middle" class="row1">
								<p><img src="images/blank.gif" width="5" height="15" border="0" /><br />
								The ID Protect Order for <strong class="red"><?php echo $sld . "." . $tld; ?></strong> has been successfully completed in order <strong class="red"><?php echo $OrderID; ?></strong>.<br />
								<br>
								Please write this down for your records. It may take as long as 48 hours before the ID Protection masking will take effect - this is completely dependant on the whois site that is being checked. It will however take effect immediately at most whois sites.</p>
								<p>To return to the Domain Management page, <a href="<?php echo "DomainMain.php?sld=$sld&tld=$tld";?>">click here</a>!<img src="images/blank.gif" width="8" height="10" border="0" /></p></td>
				</tr>
	  <!-- end of page content -->
          
		  </table>
		  <br />
		</td>
	</tr>
	  
	<? include('include/footer.php'); ?>