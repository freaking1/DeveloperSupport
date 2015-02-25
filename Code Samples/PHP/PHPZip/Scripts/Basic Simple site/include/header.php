<?
	
	//####################################################
	//
	// This file MUST be included
	// To have No logo, replace "<img src="../images/enomitron_logo.gif" width="368" height="75" border="0">" 
	// line below with the commented text below.
	//
	//####################################################
	
	//enter in the root directory or full URL
	$root = "/";
?>

<HTML>
<HEAD>
<title><?= $PageTitle ?></title>
<?php if ($PageName == "TLDSetup" or $PageName == "StyleSetup") { ?>
<link rel="stylesheet" href="../css/styles.css" type="text/css">

<? } else { ?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
<? } ?>
<?
	switch ($PageName) {
		case 'DomainMain':
		case 'DomainNs':
		case 'RegisterName':
			echo "<script language=\"JavaScript\" src=\"js/" . $PageName . ".js\" type=\"text/javascript\"></script>\n";
			break;
		case 'DomainContacts':
			echo "<script language=\"JavaScript\" src=\"js/Page_Validation_Fns.js\"></script>\n";
			echo "<script language=\"JavaScript\" src=\"js/register.js\"></script>\n";
			echo "<script language=\"JavaScript\" src=\"js/" . $PageName . ".js\" type=\"text/javascript\"></script>";
			break;
	}
?>
</HEAD>
<BODY>

<table cellSpacing="0" cellPadding=10 width="740" border="0" align="center">
<tr> 
  <td class="OutlineOne"> <table class="tableOO" cellSpacing="0" cellPadding=5 width="720" border="2" align="center" bordercolor="#313187">
        <tr> 
        <td class="OutlineOne"> <table width="100%">
			<tr> 
				
				<?php if ($PageName == "TLDSetup" or $PageName == "StyleSetup") { ?>
				<td align="center">	
					<a href="StyleSetup.php">Style Sheet Setup</a>&nbsp;|&nbsp;<a href="TLDSetup.php">TLD Sheet Setup</a>&nbsp;|&nbsp;<a href="<?= $root ?>">Home Page</a>
				</td>
				<? } else { ?>
				<td align="center">
				
					<!--- REPLACE LOGO HERE, IF YOU WANT TEXT
					<img src="images/blank.gif" width="368" height="5" border="0">
					<h2>eNomitron - PHP Sample Scripts</h2>
					<img src="images/blank.gif" width="368" height="5" border="0">
					END REPLACE LOGO --->
				
					<img src="images/enomitron_logo.gif" width="368" height="75" border="0" /></td>
				<? } ?>
				
            </tr>
          </table></td>
      </tr>
    </table></td>
</tr>
<tr>
    <td><img src="images/blank.gif" width="740" height="5" border="0"></td>
</tr>