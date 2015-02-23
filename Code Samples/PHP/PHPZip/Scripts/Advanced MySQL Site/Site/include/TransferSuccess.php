<?php
	$PageName = "Success";
	$PageTitle = "Success! Your name has been Transfered.";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Success!</span></td>
			    </tr>
				<tr>
	                </p>
		      <tr>
<td colspan="3" valign="top" class="content2"><p align="center" class="BasicText style2">&nbsp;</p>
  <p align="center" class="BasicText style3"><strong>Your Transfer has been initiated. </strong></p>
  <p align="center" class="style1 BasicText">&nbsp;</p>
  <table width="721" border="0" align="center" class="tableOO">
    <tr>
      <td width="127" class="titlepic"> <span class="whiteheader">Domain Name: </span></td>
      <td width="95" class="titlepic"><span class="whiteheader">Order ID</span></td>
      <td width="106" class="titlepic"><span class="whiteheader">Order Type </span></td>
      <td width="106" class="titlepic"><span class="whiteheader">Auto Renew </span></td>
      <td width="118" class="titlepic"><span class="whiteheader">Registrar Lock </span></td>
      <td width="81" class="titlepic"><span class="whiteheader"> Contacts</span> </td>
    </tr>
    <tr>
      <td height="20"><div align="center"><?php echo $sld.".".$tld;?></div></td>
      <td><div align="center"><?php echo $transferorderid;?></div></td>
      <td><div align="center"><?php echo $ordertypedesc;?></div></td>
      <td><div align="center"><?php echo $renew;?></div></td>
      <td><div align="center"><?php echo $lock;?></div></td>
      <td><div align="center"><?php echo $setcontacts;?></div></td>
    </tr>
  </table>  
  <p align="center"><strong><a href="transfers.php"><u>Submit Another</u></a></strong></p>
  <p align="center"><strong><a href="mytransfers.php"><u>My Transfers</u></a> </strong></p>
</table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>