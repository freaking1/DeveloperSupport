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

require( "include/dbconfig.php" );
include( "include/EnomInterface_inc.php");

  		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "command", "GetSPFHosts" );
  		$Enom->AddParam( "site", $sitename );
  		$Enom->AddParam( "enduserip", $enduserip );
  		$Enom->DoTransaction();
		
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$message .= $Enom->Values[ "Err1" ];
				} else {
				$HostName  = $Enom->Values[ "HostName1"];
				$hostid = $Enom->Values[ "hostid1"];
				}


$action = $HTTP_POST_VARS["action"];

if($action == "modify"){
			if (empty($_POST['record'])) {
				$record = FALSE;
				$message .= '<br>You must enter a record to set it to.</br>';
			} else { 
				$record = $_POST['record'];}
		if($record){ 
		$Enom->NewRequest();
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
  		$Enom->AddParam( "site", $sitename );
  		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "recordtype", "txt" );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "HostID", $hostid );
		$Enom->AddParam( "hostname", "@" );
		$Enom->AddParam( "address", $record );
  		$Enom->AddParam( "command", "SETSPFHOSTS" );
  		$Enom->DoTransaction();
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$message .= $Enom->Values[ "Err1" ];
				} else {
			$message .= "The SPF was successfully added to $sld.$tld";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">SPF Record Management </span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center"><br>
			        <?php 	if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center><br>';
	} else { echo '<br><br><br>';}
?>
              <form name="form" method="post" action="<?php echo "spf.php?sld=$sld&tld=$tld";?>">
                <input type="hidden" name="action" value="modify">
                <table width="55%" border="0" align="center" class="tableOO">
                        <tr class="titlepic">
                          <td><div align="center" class="whiteheader"><strong>SPF Text records (Sender Policy Framework) </strong></div></td>
                      </tr>
                        <tr class="OutlineOne">
                          <td> <div align="center">Enter your SPF text string below. You can also use the form located <a href="http://spf.pobox.com/wizard.html" target="_blank"><strong>here </strong></a> to generate a string. Then copy it, and save it here (no quotes). </div></td>
                        </tr>
                        <tr>
                          <td align="center"><textarea name="record" cols="50" rows="5" id="record"></textarea></td>
                        </tr>
                        <tr>
                          <td><center>
					<input name="Submit" type="image" src="images/btn_submit.gif" align="middle" border="0"/> 

                            <a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>"> 
					<input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/> 
                            </a>
                            </center>                            </td>
                        </tr>
              </table>
                <table align="center" width="82%" border="0">
                  <tr>
                    <td class="OutlineOne"><div align="center">The pupose of SPF is to allow a mail server to validate that the sending mail server is authorized to send mail on behalf of a domain. Having an SPF record can reduce email fraud and forged email. </div></td>
                  </tr>
                </table>
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