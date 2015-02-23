<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$sld = $_GET['sld'];
$tld = $_GET['tld'];


if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=dmain&sld=$sld&tld=$tld");
	exit(); // Quit the script.
}

$action = $HTTP_POST_VARS["action"];
	require( "include/dbconfig.php" );
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );


					$Enom = new CEnomInterface;
					
					if ($tld != "us")  {
						$Enom->NewRequest();
						$Enom->AddParam( "uid", $enom_username );
						$Enom->AddParam( "pw", $enom_password );
						$Enom->AddParam( "tld", $tld );
						$Enom->AddParam( "sld", $sld );
						$Enom->AddParam( "command", "GetIDProtectInfo" );
						$Enom->AddParam( "enduserip", $enduserip );
						$Enom->AddParam( "site", $sitename );
						$Enom->AddParam( "User_ID", $_COOKIE['id'] );
						$Enom->DoTransaction();
						
						$WPPSEnabled = $Enom->Values[ "WPPSEnabled" ];
						$WPPSExpDate = $Enom->Values[ "WPPSExpDate" ];
						//error handling
						if ( $Enom->Values[ "ErrCount" ] != "0" ) {
							// Yes, get the first one
							$message .= $Enom->Values[ "Err1" ];
							$message .= "There was an error checking for the lock status; please try again later.";
						} else {
							if ($Enom->Values[ "WPPSEnabled" ] == 1){
								$WPPSEnabled1 = "checked";
							} else if ($Enom->Values[ "WPPSEnabled" ] == 0){
								$WPPSEnabled2 = "checked";
							} else {
								$message = "There was an error checking for the lock status; try again later.";
							}
						}
					}

	if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {
					$Enom = new CEnomInterface;
		$wppsvar = $HTTP_POST_VARS[ "wppsvar" ];
			if($wppsvar == 0){
				$wpps = 1120;
				} 
			elseif($wppsvar == 1){
				$wpps = 1123;
				}
	$Enom = new CEnomInterface;
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "NewOptionID", $wpps );
	$Enom->AddParam( "Service", "wpps" );
	$Enom->AddParam( "Update", "true" );
	$Enom->AddParam( "command", "serviceselect" );
	$Enom->DoTransaction();
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		// Yes, get the first one
		$message .= $Enom->Values[ "Err1" ];
			} else {
				header ("Location: dmain.php?sld=$sld&tld=$tld");
				exit;
			}
}
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
				  <td height="19" colspan="3"  class="titlepic"><div align="left" class="whiteheader">Turn ID Protect On/ Off </div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">                  
			        <p>&nbsp;</p>
			        <p>&nbsp;</p>
			        <p align="center">			        
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="558" border="0" align="center">
		<form method="post" action="<?php echo "wpps_status.php?sld=$sld&tld=$tld";?>" id="form1" name="form1">
		<input type="hidden" name="action" value="modify">
			<tr>
			  <td colspan="4" align="center" valign="middle"class="titlepic"><span class="whiteheader">Change Status</span></td>
			  </tr>
			<tr>
				<td>Id Protect </td>
				<td valign="middle"><strong>&nbsp;&nbsp;<input type="radio" name="wppsvar" value="0" <?php echo $WPPSEnabled1; ?>>
				&nbsp;&nbsp;On&nbsp;&nbsp;<input type="radio" name="wppsvar" value="1" <?php echo $WPPSEnabled2; ?>>
				&nbsp;&nbsp;Off</strong></td>
			</tr>
			<tr>
				<td colspan="4" align="center">&nbsp;&nbsp;<input name="" type="image" src="images/btn_submit.gif" width="74" height="22" border="0">				  &nbsp;&nbsp;<?php echo "<a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_back.gif\" border=\"0\" WIDTH=\"74\" HEIGHT=\"22\"></a>";?></td>
			</tr>
		</form>
                    </table>			        <p>&nbsp;</p>
</p>
			      <tr>
	          </table>
</table>
<?php include('include/footer.php');?>