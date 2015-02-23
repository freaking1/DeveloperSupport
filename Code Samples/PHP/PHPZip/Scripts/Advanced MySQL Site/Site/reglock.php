<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

	require( "include/dbconfig.php" );
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );
	
	$tld = $_GET['tld'];
	$sld = $_GET['sld'];
	
	if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=dmain?sld=$sld&tld=$tld");
	exit(); // Quit the script.
}


$getlockstatus = "SELECT lockable from tld_config WHERE tld='$tld'";
$gotlockstatus = mysql_query($getlockstatus);
$LockStatus = mysql_result($gotlockstatus,0);

	$domain_name = "sld=$sld&tld=$tld";

if ($LockStatus != 1) {
	header ("Location:  $site_url/dmain.php?$domain_name");
	exit(); 
} 

	// Check if we're supposed to modify something
	if ( $HTTP_POST_VARS[ "action" ] == "modify" ) {

		$lockvar = $HTTP_POST_VARS[ "lock" ];

	$query = "UPDATE domains SET reg_lock='$lockvar'  lastupdate=NOW() WHERE sld ='$sld' AND tld ='$tld'";
	$result = mysql_query($query);

		$Enom = new CEnomInterface;
	
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "UnlockRegistrar", $lockvar );
			$Enom->AddParam( "command", "setreglock" );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "User_ID", $_COOKIE['id'] );
			$Enom->DoTransaction();

			// Check if there were errors
			$errors = $Enom->Values[ "ErrCount" ];

			if ( $errors != "0" ) {
				$message = $Enom->Values[ "Err1" ];
			} else {
				$lockchange = 1;
			}
	}
		
			if ($lockchange == 1) {
			header ("Location:  $site_url/dmain.php?$domain_name");
					exit;
				}
	$page = "myaccount";
	$PageTitle = $SiteTitle . " - Update Your .php' Services.";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Set Auto Renew and Registrar Lock Status </span><b>                                 </b></td>
			    </tr>
				<tr>
	                </p>
			      <tr>
	                <td colspan="3" valign="top" class="content2"><p></p>
	                  <p>	
	                  <br>
	                  </p>
	                  <table class="tableOO" cellSpacing="1" cellPadding="5" width="558" border="0" align="center">
		<form method="post" action="<?php echo "reglock.php?sld=$sld&tld=$tld";?>" id=form1 name=form1>
		<input type="hidden" name="action" value="modify">
				<?php
					// Check to see if the .php' is set to locked
					$Enom = new CEnomInterface;
					
						$Enom->NewRequest();
						$Enom->AddParam( "uid", $enom_username );
						$Enom->AddParam( "pw", $enom_password );
						$Enom->AddParam( "tld", $tld );
						$Enom->AddParam( "sld", $sld );
						$Enom->AddParam( "command", "getreglock" );
						$Enom->AddParam( "enduserip", $enduserip );
						$Enom->AddParam( "site", $sitename );
						$Enom->AddParam( "User_ID", $_COOKIE['id'] );
						$Enom->DoTransaction();
						
						$reg_lock = $Enom->Values[ "RegLock" ];
						//error handling
						if ( $Enom->Values[ "ErrCount" ] != "0" ) {
							// Yes, get the first one
							$expMsg = $Enom->Values[ "Err1" ];
							echo $expMsg;
							$lockMSG = "There was an error checking for the lock status; please try again later.";
						} else {
							if ($Enom->Values[ "RegLock" ] == 1){
								$lock1 = "checked";
							} else if ($Enom->Values[ "RegLock" ] == 0){
								$lock2 = "checked";
							} else {
								$lockMSG = "There was an error checking for the lock status; try again later.";
							}
						}
					
				?>
			<tr>
			  <td colspan="4" align="center" valign="middle"class="titlepic"><span class="whiteheader">Change Status</span></td>
			  </tr>
			<tr>
			  <td width="5%" align="center" valign="middle">&nbsp;</td>
				<td>Registrar Lock On or Off<br />(<strong>On</strong> recommended)</td>
				<td valign="middle"><strong>&nbsp;&nbsp;<input type="radio" name="lock" value="0" <?php echo $lock1; ?>>
				&nbsp;&nbsp;On&nbsp;&nbsp;<input type="radio" name="lock" value="1" <?php echo $lock2; ?>>
				&nbsp;&nbsp;Off</strong></td>
				<td width="5%" align="center" valign="middle" noWrap>&nbsp;</td>
			</tr>
			<tr>
			  <td width="5%" align="center" valign="middle">&nbsp;</td> 
				<td width="41%" valign="middle">&nbsp;</td>
				<td width="49%" valign="middle">&nbsp;&nbsp;<input name="" type="image" src="images/btn_submit.gif" width="74" height="22" border="0">				  &nbsp;&nbsp;<?php echo "<a href=\"dmain.php?sld=$sld&tld=$tld\"><img src=\"images/btn_back.gif\" border=\"0\" WIDTH=\"74\" HEIGHT=\"22\"></a>";?></td>
				<td width="5%" align="center" valign="middle" noWrap>&nbsp;</td>
			</tr>
		</form>
	  </table>                
		      </table>
	    </table>
		          <?php include('include/footer.php');?>