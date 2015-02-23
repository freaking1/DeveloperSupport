<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=avtransfer");
	exit(); // Quit the script.
}

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

$action = $HTTP_POST_VARS[ "action" ];

	include('include/dbconfig.php');
	include( "include/EnomInterface_inc.php" );

$message = NULL  ;
// Do we need to register a name?
if ( $action == "transfer" ) {
//FOrm Validation
		if (empty($_POST['sld'])) {
			$sld = FALSE;
			$message .= '<br>You must enter a domain name</br>';
		} else {
			$sld = $HTTP_POST_VARS['sld'];
		}
	if($sld){

		$tld = $HTTP_POST_VARS[ "tld" ];
		$sld = $HTTP_POST_VARS[ "sld" ];

		if ($HTTP_POST_VARS[ "lock" ] == "ON"){
			$lock="1";
			} else {
			$lock="0";
		}

		if ($HTTP_POST_VARS[ "setcontacts" ] == "ON") {
			$setcontacts="1";
			} else {
			$setcontacts="0";
		}

	$formoptions = "sld=$sld&tld=$tld&numyears=1&prodid=3&referer=avtransfer&command=addtocart&lock=$lock&contacts=$setcontacts&renew=0&OrderType=Autoverification&shop=transfers";  		// Create URL Interface class
	header ("Location:  $site_url/addtocart.php?$formoptions");
	}
}

	//Page name - DO NOT CHANGE
	$PageName= "transfer";
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Transfer your domain name - Auto Verification";


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
				  <td height="19" class="titlepic"><span class="whiteheader">Transfer My  Domain Name </span>                                </b></td>
			    </tr>
				<tr>
	              <td colspan="3" valign="top">
			  <tr>
	<td height="245">
			     <center><b><?php if(isset($message)) {echo "<span class=\"red\">$message </span>";}?></b></center>   <br>
		<table class="tableO1" cellSpacing="1" cellPadding="5" width="486" border="0" align="center">

		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="form1" name="form1">
		<input type="hidden" name="action" value="transfer">
		  <tr>
                  <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Auto Verification Transfer Method </span></td>
		  </tr>
		  <tr>
			<td width="47%" ><div align="right">Domain&nbsp;name:&nbsp;</div></td>
			<td width="53%" valign="middle" >&nbsp;&nbsp;&nbsp; <input name="sld" type="text" class="formfield" id="sld" value="<?php echo "$sld"; ?>" maxlength="256">
			  &nbsp;.&nbsp;<?php include ('include/tldlist/tldListAVT.php'); ?></td>
		  </tr>
		  <tr>
		<td align="right"  ><div align="right">Turn On Registrar Lock for this domain
		      (recommended)</div></td>
			<td valign="middle" >&nbsp;&nbsp;&nbsp;<input type="checkbox" name="lock" value="ON" checked></td>
		  </tr>
		  <tr>
            <td align="right"  > Use Current domain contacts? </td>
            <td valign="middle" >&nbsp;&nbsp;
                <input type="checkbox" name="setcontacts" value="ON" checked></td>
            </tr>
		  <tr>
			<td colspan="4" align="center" valign="middle" >&nbsp;			  <input type="image" src="images/btn_submit.gif" border="0" WIDTH="74" HEIGHT="22">
	          <a href="index.php" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
			</tr>
		</form>
	</table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br></td>
</tr>
              </table>
</table>
		          <?php
				  include('include/footer.php');?>