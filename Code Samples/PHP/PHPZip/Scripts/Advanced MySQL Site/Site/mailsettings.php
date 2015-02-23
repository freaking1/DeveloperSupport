<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];
$tld = $_GET["tld"];
$sld = $_GET["sld"];
$action = $_GET["action"];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=mailsettings&sld=$sld&tld=$tld&action=$action");
	exit(); // Quit the script.
} 

include('include/dbconfig.php');


if($action == "go"){
	$mailchoice = $_GET["choice"];
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );
	//The table is not needed as they made a choice, so lets start the enom call
	$Enom = new CEnomInterface;
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "NewOptionID", $mailchoice );
	$Enom->AddParam( "Service", "emailset" );
	$Enom->AddParam( "command", "serviceselect" );
	$Enom->DoTransaction();
	if ( $Enom->Values[ "ErrCount" ] != "0" ) {
		// Yes, get the first one
		$message .= $Enom->Values[ "Err1" ];
	} else {
		$query = "UPDATE domains SET mail='$mailchoice' WHERE sld='$sld' and tld='$tld' and user_id='$user_id'";
		$result = @mysql_query($query);
		if($result){
			switch ($mailchoice){
			case '1048':
				header ("Location:  $site_url/dmain.php?sld=$sld&tld=$tld");
			break;
			case '1051':
				header ("Location:  $site_url/emailforwarding.php?sld=$sld&tld=$tld");
			break;
			case '1054':
				header ("Location:  $site_url/hosts.php?sld=$sld&tld=$tld");
			break;
			case '1114':
				header ("Location:  $site_url/mypopmail.php?sld=$sld&tld=$tld");
			break;
			}
		} else {
			$message .= "There was an error updating your mail settings";
		}
	}
}
	$page = "myaccount";

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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Email Server Settings </span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">&nbsp;</p>

		        <form name="form" method="post" action="<?php echo "mailsettings.php?sld=$sld&tld=$tld&choice=".$_POST["choice"]."action=go";?>">
					<input type="hidden" name="action" value="go">	
			          <p align="center">&nbsp;</p>
			          <table width="100%" border="0" align="center">
                        <tr>
                          <td width="17%">&nbsp;</td>
                          <td colspan="5"><table width="100%"  border="0" class="tableO1">
                            <tr class="titlepic">
                              <td colspan="2"><div align="center" class="whiteheader">Email Settings </div></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td width="91%"><a href="<?php echo "mailsettings.php?sld=$sld&tld=$tld&action=go&choice=1048";?>">None (no email will work)</a></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td><a href="<?php echo "mailsettings.php?sld=$sld&tld=$tld&action=go&choice=1051";?>">Email Forwarding (to a POP or WebMail address)</a></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td><a href="<?php echo "mailsettings.php?sld=$sld&tld=$tld&action=go&choice=1054";?>">User Defined Mail Server (mail server name required)</a></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td><a href="<?php echo "mailsettings.php?sld=$sld&tld=$tld&action=go&choice=1114";?>">POP3/WebMail + email forwarding</a> <span class="red">(**requires additional purchase) </span></td>
                            </tr>
                          </table></td>
                          <td width="13%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="5%">&nbsp;</td>
                          <td width="18%">&nbsp;</td>
                          <td width="13%" align="center">
					<input name="Submit" type="image" src="images/btn_submit.gif" align="middle" border="0"/> 
                          <td width="14%" align="center">
                            <a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>"> 
					<input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/> 
						  </a></td>
                          <td width="20%">&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
			          <tr>
	                <td colspan="3" valign="top" class="content2">    </form>		                 
		      </table>
</table>
		          <?php include('include/footer.php');?>