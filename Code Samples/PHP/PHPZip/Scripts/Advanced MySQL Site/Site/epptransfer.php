<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=epptransfer");
	exit(); // Quit the script.
}
include('include/dbconfig.php');

$action = $HTTP_POST_VARS[ "action" ];
$tld = $HTTP_POST_VARS[ "tld" ];

$message = NULL  ;

if ( $action == "transfer" ) {

	if (empty($_POST['sld'])) {
		$sld = FALSE;
		$message .= '<br>You must enter a domain name</br>';
	} else {
		$sld = $_POST['sld'];
		}

	if (empty($_POST['authinfo'])) {
		$authinfo = FALSE;
		$message .= '<br>You must enter an EPP Key to continue<br> Warning: Entering the wrong code will cause the transfer to fail!</br>';
	} else {
		$authinfo = $_POST['authinfo'];
		}

if($sld && $authinfo){
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

	$formoptions = "sld=$sld&tld=$tld&numyears=1&prodid=3&referer=avtransfer&command=addtocart&lock=$lock&contacts=$setcontacts&renew=0&authkey=$authinfo&OrderType=EPP&shop=transfers";  		// Create URL Interface class
	header ("Location:  $site_url/addtocart.php?$formoptions");
	}
}
	$PageName= "transfer";
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
          <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Transfer My Domain Name </span><b> </b></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" class="OutlineOne">
            <br>
<center><b><?php if(isset($message)) {echo "<span class=\"red\">$message</span>";}?></b></center>

            <br>
            <table class="tableOO" cellspacing="1" cellpadding="5" width="589" border="0" align="center">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="form1" name="form1">
                <input type="hidden" name="action" value="transfer">
                <tr>
                  <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">EPP Transfer Method </span></td>
                </tr>
                <tr>
                  <td width="51%" ><div align="right">Domain&nbsp;name:&nbsp;</div></td>
                  <td width="49%" valign="middle" >&nbsp;&nbsp;&nbsp;
                      <input type="text" name="sld" id="sld" maxlength="256" value="<?php echo "$sld"; ?>">
&nbsp;.&nbsp;
                    <?php include ('include/tldlist/tldListEPP.php'); ?></td>
                </tr>
                <tr>
                  <td  ><div align="right"><b class="red">*</b>Authorization Key (EPP) (<b class="red">REQUIRED</b>):&nbsp;</div></td>
                  <td valign="middle" ><b class="red">&nbsp;&nbsp;&nbsp;
                        <input type="text" name="authinfo" id="authinfo" maxlength="25" value="<?php echo $HTTP_POST_VARS[ "authinfo" ]?>">
                  </b></td>
                </tr>
                <tr>
                  <td align="right"  >Do not allow this name to be transferred to another registrar (recommended)</td>
                  <td valign="middle" >&nbsp;&nbsp;&nbsp;
                      <input type="checkbox" name="lock" value="ON" checked></td>
                </tr>
                <tr>
                  <td align="right"  > Use Current domain contacts? </td>
                  <td valign="middle" >&nbsp;&nbsp;&nbsp;
                      <input type="checkbox" name="setcontacts" value="ON" checked></td>
                </tr>
                <tr>
                  <td colspan="4" align="center" valign="middle" >&nbsp;</td>
                </tr>
                <tr>
                  <td   colspan="2" align="center">&nbsp;
                      <input name="image" type="image" src="images/btn_submit.gif" width="74" height="22" border="0">
                      <a href="index.php" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
                </tr>
              </form>
          </table>
        <tr>
          <td colspan="3" valign="top" class="content2">
      </table>
</table>
    <?php include('include/footer.php');?>
</body>

</html>