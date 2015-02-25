<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$sld = $_GET['sld'];
$tld = $_GET['tld'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=mypopmail?sld=$sld&tld=$tld");
	exit(); 
} 

require( "include/dbconfig.php" );
include("include/EnomInterface_inc.php");

$query = "SELECT pop FROM domains WHERE sld='$sld' and tld='$tld' and user_id='$user_id'";
$result = @mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_NUM);
	if($row[0] == 1){
		$haspopmail = 1;
		
		$Enom_mail = new CEnomInterface; 
		$Enom_mail->AddParam( "uid", $enom_username );
		$Enom_mail->AddParam( "pw", $enom_password );
		$Enom_mail->AddParam( "enduserip", $enduserip );
		$Enom_mail->AddParam( "site", $sitename );
		$Enom_mail->AddParam( "User_ID", $_COOKIE['id'] );
		$Enom_mail->AddParam( "sld", $sld );
		$Enom_mail->AddParam( "tld", $tld );
		$Enom_mail->AddParam( "command", "getpop3" );
		$Enom_mail->DoTransaction();

		$bundleid = $Enom_mail->Values[ "PakBundleId1"];

	}
$message = NULL;
$action = $HTTP_POST_VARS[ "action" ];

if($command == "changepass"){
	if($action == "go"){
			if(empty($_POST['newpoppassword'])) {
				$newpoppassword = FALSE;
				$message .= '<br>You must enter a password to change to</br>';
			} else { 
				$newpoppassword = $_POST['newpoppassword'];
				}
				
		if($newpoppassword){
					$Enom = new CEnomInterface; 
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $enom_username );
					$Enom->AddParam( "pw", $enom_password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "EmailCount", "1" );
					$Enom->AddParam( "UserName1", $popusername );
					$Enom->AddParam( "Password1", $newpoppassword );
					$Enom->AddParam( "enduserip", $enduserip );
					$Enom->AddParam( "site", $sitename );
					$Enom->AddParam( "User_ID", $_COOKIE['id'] );
					$Enom->AddParam( "command", "modifypop3" );
					$Enom->DoTransaction();
	
					//Enom Error code parsing
					if ( $Enom->Values[ "ErrCount" ] == "0" ) {
						header ("Location:  $site_url/mypopmail.php?tld=$tld&sld=$sld");
						exit(); // Quit the script.
						} else {
						echo "Error Updating account password: {$Enom->Values[ "Err1" ]}";
						}
					}//End If Variable
				} //end the if action
}//End if command
if($command == "delete"){
$popusername = $_GET["popusername"];
					$Enom = new CEnomInterface; 
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $enom_username );
					$Enom->AddParam( "pw", $enom_password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "PopUser", $popusername );
					$Enom->AddParam( "enduserip", $enduserip );
					$Enom->AddParam( "site", $sitename );
					$Enom->AddParam( "User_ID", $_COOKIE['id'] );
					$Enom->AddParam( "command", "DeletePOP3" );
					$Enom->DoTransaction();
	
					//Enom Error code parsing
					if ( $Enom->Values[ "ErrCount" ] == "0" ) {
						header ("Location:  $site_url/mypopmail.php?tld=$tld&sld=$sld");
						exit(); // Quit the script.
						} else {
						$message .= $Enom->Values[ "Err1" ];
						}
}

if($command == "create"){
	if($action == "go"){
			if(empty($_POST['newuser'])) {
				$newuser = FALSE;
				$message .= '<br>You must choose a username</br>';
			} else { 
				$newuser = $_POST['newuser'];
				}
			if(empty($_POST['newpass'])) {
				$newpass = FALSE;
				$message .= '<br>You must enter a password</br>';
			} else { 
				$newpass = $_POST['newpass'];
				}
			if(empty($_POST['displayname'])) {
				$displayname = FALSE;
				$message .= '<br>You must enter a Display Name</br>';
			} else { 
				$displayname = $_POST['displayname'];
				}
				
		if($newuser && $newuser && $displayname){
					$Enom = new CEnomInterface; 
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $enom_username );
					$Enom->AddParam( "pw", $enom_password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "bundleid", $_GET['bundleid']);
					$Enom->AddParam( "POPFullName", $displayname );
					$Enom->AddParam( "POPUserName", $newuser );
					$Enom->AddParam( "POPPassword", $newpass );
					$Enom->AddParam( "enduserip", $enduserip );
					$Enom->AddParam( "site", $sitename );
					$Enom->AddParam( "User_ID", $_COOKIE['id'] );
					$Enom->AddParam( "command", "SetUpPOP3User" );
					$Enom->DoTransaction();
					Echo $Enom->PostString;
	
					if ( $Enom->Values[ "ErrCount" ] == "0" ) {
						header ("Location:  $site_url/mypopmail.php?tld=$tld&sld=$sld");
						exit(); // Quit the script.
						} else {
						$message .= $Enom->Values[ "Err1" ];
						}
					}//End If Variable
				} //end the if action
  }

	$page = "myaccount";
	$PageTitle = $SiteTitle . " - Expired Domains";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Pop Mail Management </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
<br><br><br>
<?php
if($haspopmail == 1) {

			echo '        <table class="tableO1" align="center" valign="center" width="65%" border="0" class="tableO1">
                      <tr bgcolor="#eeeeee">
                      <td><b><u><span class="BasicText">Username</b></u></span></td>
                      <td><b><u><span class="BasicText">Password</b></u></span></td>
					  <td><b><u><span class="BasicText">Quota</b></u></span></td>
					  <td><b><u><span class="BasicText">Quota Used</b></u></span></td>
					  <td></td>
					  <td></td>
                      </tr>';

 		$Enom_mail = new CEnomInterface; 
		$Enom_mail->AddParam( "uid", $enom_username );
		$Enom_mail->AddParam( "pw", $enom_password );
		$Enom_mail->AddParam( "enduserip", $enduserip );
		$Enom_mail->AddParam( "site", $sitename );
		$Enom_mail->AddParam( "User_ID", $_COOKIE['id'] );
		$Enom_mail->AddParam( "sld", $sld );
		$Enom_mail->AddParam( "tld", $tld );
		$Enom_mail->AddParam( "command", "getpop3" );
		$Enom_mail->DoTransaction();

		$bundleid = $Enom_mail->Values[ "PakBundleId1"];
		
$bg = '#eeeeee'; //Set the background color
$EmailCount = $Enom_mail->Values[ "EmailCount" ];
for ( $i = 1; $i <= $EmailCount  ; $i++ ){
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround
$popusername  = $Enom_mail->Values[ "Username"."$i" ];
$poppassword = $Enom_mail->Values[ "Password"."$i" ];
$popquota = $Enom_mail->Values[ "Quota"."$i" ];
$popexpire = $Enom_mail->Values[ "ExpDate"."$i"];
$autorenew = $Enom_mail->Values[ "AutoRenew"."$i"];
$quotaused = $Enom_mail->Values[ "quotaused"."$i"];
$available = $Enom_mail->Values[ "QtyAvailable1"];

echo "
                      <tr bgcolor=\"$bg\">
                      <td>$popusername</td>
                      <td>$poppassword</td>
					  <td>$popquota</td>
					  <td>$quotaused MB</td>
					  <td><a href=\"mypopmail.php?sld=$sld&tld=$tld&command=delete&popusername=$popusername\">Delete</a><input disabled type=\"hidden\" name=\"bundleid\" value=\"$bundleid\"></td>
					  <td><a href=\"mypopmail.php?sld=$sld&tld=$tld&command=changepass&popusername=$popusername\">Change Pass</a></td>
                      </tr>";
					} //End For Loop
					echo '</table>';
					
					if($available == 1){ $av_num = "Account"; $tk_num = "Accounts"; } else { $av_num= "Accounts";  $tk_num = "Account"; }
					echo '<table class="tableO1" align="center" valign="center" width="65%" border="0" class="tableO1">';
					echo '<tr><td colspan="4" align="center"> You are Using '.$DomainCount.' email '.$tk_num.'.  You still have '.$available.' '.$av_num.' left</td></tr>';
					echo "<tr><td colspan=\"4\" align=\"center\"> <a href=\"mypopmail.php?command=create&sld=$sld&tld=$tld&bundleid=$bundleid\">Click Here to setup a New account</a></td></tr>";
					echo '</table>';
}//End IF has pop mail
else {
?> 
					<br><table class="tableO1" align="center"><tr>
    <td colspan="4"><div align="center">You do not have any pop packs for this domain </div></td>
  </tr>
  <tr>
    <td colspan="4"><div align="center"><a href="<? echo "addtocart.php?prodid=5&sld=$sld&tld=$tld&qty=1&command=addtocart&shop=mydomains"?>"><b>Purchase an Email Pack</b></a> </div></td>
  </tr>
</table>
<? } 
if(isset($message)) {echo '<span class=\"red\">', $message, '</span>';} 

if($command == "changepass"){
$popusername = $_GET["popusername"];
?>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']."?sld=$sld&tld=$tld&command=changepass&popusername=$popusername";?>">
						<input type="hidden" name="action" value="go"><tr>
  <table width="65%"  border="0" class="tableO1" align="center">
    <tr>
      <td width="43%"><div align="center">New Password for account <?=$popusername;?>@<?=$sld.'.'.$tld;?></div></td>
      <td width="57%"><input name="newpoppassword" type="text" id="newpoppassword" size="25" maxlength="16"></td>
    </tr>
<tr>
  <td colspan="2" align="center" valign="middle">
  <input name="image" type="image" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">
&nbsp;<a href="<?php echo "mypopmail.php?sld=$sld&tld=$tld";?>" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
              </tr>
  </table>
</form>
<? } 

if($command == "create"){
	$bundleid = $_GET["bundleid"];
?>
<form name="form1" method="post" action="<?php echo "mypopmail.php?sld=$sld&tld=$tld&command=create&bundleid=$bundleid";?>">
						<input type="hidden" name="action" value="go"><tr>
  <table width="86%"  border="0" class="tableO1" align="center">
    <tr>
      <td width="12%"><div align="center">Username</div></td>
      <td width="18%"><input name="newuser" type="text" id="newuser" size="16" maxlength="25"></td>
      <td width="12%">Password</td>
      <td width="19%"><input name="newpass" type="text" id="newpass" size="16" maxlength="25"></td>
      <td width="16%">Display Name </td>
      <td width="23%"><input name="displayname" type="text" id="displayname" size="25" maxlength="30">      </td>
      </tr>
<tr>
  <td colspan="6" align="center" valign="middle">
  <input name="image" type="image" src="images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">
&nbsp;<a href="<?php echo "mypopmail.php?sld=$sld&tld=$tld";?>" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0"></a></td>
              </tr>
  </table></form><? } ?>
                    <br>
                  <br><center>
&nbsp;<a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>" class="main"><img src="images/btn_back.gif" width="74" height="22" border="0"></a></center><br>                  
	      </table>                  </div>
                  <br><br> 
                  <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>