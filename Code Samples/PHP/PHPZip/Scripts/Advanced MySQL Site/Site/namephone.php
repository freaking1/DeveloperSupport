<?php
session_name ('API-PHPSESSID');
session_start();
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$sld = $_GET['sld'];
$tld = $_GET['tld'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=namephone?sld=$sld&tld=$tld");
	exit();
}

require( "include/dbconfig.php" );
include("include/EnomInterface_inc.php");

$getDNS = "SELECT dns FROM domains WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
$gotDNS = mysql_query($getDNS);
$DNS = mysql_result($gotDNS,0);

$getPHONE = "SELECT name_phone FROM domains WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
$gotPHONE = mysql_query($getPHONE);
$PhoneOn = mysql_result($gotPHONE,0);

	if($PhoneOn == 1){
		$PhoneText = 'Enabled (Turned On)';
		} elseif($PhoneOn == 0){
		$PhoneText = 'Disabled (Turned Off)';
		}

$domain = "sld=$sld&tld=$tld";

if ($DNS != 1){
	header ("Location:  $site_url/dmain.php?$domain");
	exit(); // Quit the script.
}


  		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "command", "GetDomainPhone" );
  		$Enom->AddParam( "site", $sitename );
  		$Enom->AddParam( "enduserip", $enduserip );
  		$Enom->DoTransaction();

		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$message .= $Enom->Values[ "Err1" ];
				} else {
				$phonenumber  = $Enom->Values[ "phone-number"];
				$servicetype = $Enom->Values[ "service-type"];
					switch($servicetype)
					{
					case "Nextel":
						$Provider = 1;
					break;
					case "Sprint PCS":
						$Provider = 2;
					break;
					case "Verizon ":
						$Provider = 4;
					break;
					case "AT&T Wireless":
						$Provider = 5;
					break;
					case "VoiceStream":
						$Provider = 8;
					break;
					case "Qwest ":
						$Provider = 11;
					break;
					case "Cingular ":
						$Provider = 12;
					break;
					case "T-Mobile":
						$Provider = 13;
					break;
				}
				$hostname = $Enom->Values[ "host-name"];
				}

$action = $_GET["action"];

if($action == "change"){

	if($_GET[status] == 0){
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "Service", "Messaging" );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "NewOptionID", "1090" );
			$Enom->AddParam( "Update", "true" );
			$Enom->AddParam( "command", "ServiceSelect" );
			$Enom->DoTransaction();

	$update1 = "Update domains SET name_phone = '1' WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
	$update2 = mysql_query($update1);
		if($update2){
			header ("Location:  $site_url/namephone.php?$domain");
			exit(); // Quit the script.
		}
	} else {
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "Service", "Messaging" );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "NewOptionID", "1087" );
			$Enom->AddParam( "Update", "true" );
			$Enom->AddParam( "command", "ServiceSelect" );
			$Enom->DoTransaction();

			$update1 = "Update domains SET name_phone = '0' WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
			$update2 = mysql_query($update1);
		if($update2){
			header ("Location:  $site_url/dmain.php?$domain");
			exit(); // Quit the script.
			}
		}
	}

if($action == "modify"){

	if (empty($_POST['Phone'])) {
		$Phone = FALSE;
		$message .= '<br>You must enter a Phone Number.</br>';
	} else {
		$Phone = $_POST['Phone'];
		}

		if($Phone){
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "HostName", "phone" );
			$Enom->AddParam( "OldHostName", "phone" );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "Phone", $Phone );
			$Enom->AddParam( "ServiceID", $ServiceID );
			$Enom->AddParam( "EmailAlias", "On");
			$Enom->AddParam( "TemplateID", "6");
			$Enom->AddParam( "command", "SetDomainPhone" );
			$Enom->DoTransaction();

		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$message .= $Enom->Values[ "Err1" ];
				} else {

			//Update the db
			$update1 = "Update domains SET name_phone = '1' WHERE sld='$sld' AND tld='$tld' AND user_id='$user_id'";
			$update2 = mysql_query($update1);
				if($update2){
					header ("Location:  $site_url/dmain.php?$domain");
					exit(); // Quit the script.
				}
		}
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Name My Phone </span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center"><br>
			        <?php 	if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center><br>';
	} else { echo '<br><br><br>';}
?>
			<?php
			# ---------------------------------------------------------
		if($PhoneOn == 1){
		?>
              <form name="form" method="post" action="<?php echo "namephone.php?sld=$sld&tld=$tld&action=modify";?>">
                <table width="450" border="0" align="center" class="tableOO">
                  <tr class="titlepic">
                    <td colspan="2"><div align="center" class="whiteheader"> <strong>phone.<?php echo "$sld.$tld";?></strong></div></td>
                  </tr>
                  <tr>
                    <td width="57%" align="center">
                      <div align="left"><strong>10 digit Phone Number </strong><br>
                          <strong>ex. 1112223333 (only numbers) </strong> </div></td>
                    <td width="43%" align="center"><div align="left">
                        <input name="Phone" type="text" id="Phone2" size="15" maxlength="10" value="<?php if(isset($phonenumber)){ echo $phonenumber;}?>">
                    </div></td>
                  </tr>
                  <tr>
                    <td align="center">
                      <div align="left"><strong>Service Type </strong> </div></td>
                    <td align="center"><div align="left">
                        <select name="ServiceID" id="select">
                          <option value="<?php if(isset($Provider)){ echo $Provider;}?>" selected >
                          <?=$servicetype;?>
                          </option>
                          <option value="5">AT&amp;T Wireless</option>
                          <option value="12">Cingular</option>
                          <option value="11">Qwest</option>
                          <option value="1">Nextell</option>
                          <option value="2">Sprint</option>
                          <option value="13">T-mobile</option>
                          <option value="1">Nextell</option>
                          <option value="2">Sprint</option>
                          <option value="8">T-mobile</option>
                          <option value="4">Verizon</option>
                          <option value="8">VoiceStream</option>
                        </select>
                    </div></td>
                  </tr>
                  <tr>
                    <td height="54" colspan="2"><div align="center">
					<input name="Submit" type="image" src="images/btn_submit.gif" align="middle" border="0"/>
                        <a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>">
					<input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/>
						</form>
                    </a></div></td>
                  </tr>
                </table>
			<? } ?>


                <br>
                <table width="450" border="0" align="center" class="tableOO">

					<?php
					$status = $_POST['status'];
					?>
<form name="form2" method="post" action="<?php echo "namephone.php?sld=$sld&tld=$tld&action=change&status=$PhoneOn";?>">
<table width="450" border="0" align="center" class="tableOO">
	  <tr>
		<td width="43%" height="20">Currently <?=$PhoneText;?></td>
		<td width="43%" height="20">
		<?php
		if($PhoneOn == 1){
		echo '<input name="Disable" type="image" src="images/btn_disable_g.gif" align="middle" border="0" />';
			} else {
		echo '<input name="Enable" type="image" src="images/btn_enable_g.gif" align="middle" border="0"/>';
		}
		?>
</table>
</form>
                <p>&nbsp;</p>
		              <p>&nbsp;</p>
			        </form>			        <p align="center" class="BasicText"><br>
                    </p>
	          <tr>
	                <td colspan="3" valign="top" class="content2">
		      </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>