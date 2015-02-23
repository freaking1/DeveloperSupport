<?php
session_name ('API-PHPSESSID');
session_start();
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$sld = $_GET['sld'];
$tld = $_GET['tld'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=parking?sld=$sld&tld=$tld");
	exit();
}

require( "include/dbconfig.php" );
include("include/EnomInterface_inc.php");

$command = $_GET["command"];
$action = $HTTP_POST_VARS["action"];
$parktext = $HTTP_POST_VARS["parktext"];
if(($action == "go")||($command == "go")){
$optionID == $_GET["status"];
if($status == "on"){
$optionID = "1033"; //ON
}
if($status == "off"){
$optionID = "1030";//OFF
}
				if($optionID == "1033"){
					$Enom = new CEnomInterface;
					$Enom->AddParam( "uid", $enom_username );
					$Enom->AddParam( "pw", $enom_password );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "command", "ServiceSelect" );
					$Enom->AddParam( "site", $sitename );
					$Enom->AddParam( "enduserip", $enduserip );
					$Enom->AddParam( "Service", "parking" );
					$Enom->AddParam( "NewOptionID", $optionID );
					$Enom->AddParam( "Update", "True" );
					$Enom->DoTransaction();

					//Now Go through and set the Parking Text
					$Enom2 = new CEnomInterface;
					$Enom2->AddParam( "uid", $enom_username );
					$Enom2->AddParam( "pw", $enom_password );
					$Enom2->AddParam( "sld", $sld );
					$Enom2->AddParam( "tld", $tld );
					$Enom2->AddParam( "command", "SetParkingText" );
					$Enom2->AddParam( "site", $sitename );
					$Enom2->AddParam( "enduserip", $enduserip );
					$Enom2->AddParam( "ParkText", $parktext );
					$Enom2->DoTransaction();

				if ( $Enom2->Values[ "ErrCount" ] != "0" ) {
					$message .= $Enom2->Values[ "Err1" ];
					} else {
					//Turns it ON
						$query = "UPDATE domains SET parking='1' WHERE sld='$sld' AND tld='$tld' AND user_id = '$user_id'";
						$result = @mysql_query($query);
							if($result){
							header ("Location:  $site_url/dmain.php?sld=$sld&tld=$tld&success=0");
							exit(); // Quit the script.<br>
							} //End IF Result
					}//End Error If
				} //End IF OptionID
				if($optionID == "1030"){
					$Enom = new CEnomInterface;
					$Enom->AddParam( "uid", $enom_username );
					$Enom->AddParam( "pw", $enom_password );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "command", "ServiceSelect" );
					$Enom->AddParam( "site", $sitename );
					$Enom->AddParam( "enduserip", $enduserip );
					$Enom->AddParam( "Service", "parking" );
					$Enom->AddParam( "NewOptionID", $optionID );
					$Enom->AddParam( "Update", "True" );
					$Enom->DoTransaction();
					//Now Go through and set the Parking Text
					$Enom2 = new CEnomInterface;
					$Enom2->AddParam( "uid", $enom_username );
					$Enom2->AddParam( "pw", $enom_password );
					$Enom2->AddParam( "sld", $sld );
					$Enom2->AddParam( "tld", $tld );
					$Enom2->AddParam( "command", "SetParkingText" );
					$Enom2->AddParam( "site", $sitename );
					$Enom2->AddParam( "enduserip", $enduserip );
					$Enom2->AddParam( "ParkText", $parktext );
					$Enom2->DoTransaction();

				if ( $Enom2->Values[ "ErrCount" ] != "0" ) {
					$message .= $Enom2->Values[ "Err1" ];
					} else {
						//Turns it OFF
						$query1 = "UPDATE domains SET parking='0' WHERE sld='$sld' AND tld='$tld' AND user_id = '$user_id'";
						$result1 = @mysql_query($query1);
							if($result1){
							header ("Location:  $site_url/dmain.php?sld=$sld&tld=$tld&success=1");
							exit(); // Quit the script.<br>
							} //End IF Result
					}//End If OptionID
				}//End If Error
		}  //End If Action
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Set Your domains Parking Text </span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center"><?php 	if(isset($message)) {echo '<center><u><b><span class="red">', $message, '</span></b></u></center><br>';
	} else { echo '<br><br><br>';}
?>

							    <input type="hidden" name="action" value="go">
                    <form name="form" method="post" action="<?php echo "parking.php?sld=$sld&tld=$tld&status=$status&command=go";?>">
                                  <table width="55%" border="0" align="center" >
                        <tr>
                          <td><div align="center" class="BasicText"><strong>Parking Text </strong></div></td>
                      </tr>
                        <tr class="OutlineOne">
                          <td> <div align="center"> <strong>User Defined Message (limit 255 characters) </strong> </div></td>
                        </tr>
                        <tr>
                          <td align="center"><textarea name="parktext" cols="85" rows="10" id="parktext">This site is under construction and comming soon!</textarea>
                          <br></td>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                          <td class="OutlineOne"> For each <strong>Address </strong> entry in the Third Level Domain Information table above that points to "parking.<?=$site_domain;?>", the Host Name and Domain Name combination will display <?=$sitename;?>'s default "parking" page (also called, "under construction" or "welcome" page). For example, if you have "www" in the Host Name column and "parking.<?=$site_domain;?>" in the Address column, then a user typing in "www.<?=$sld;?>.<?=$tld;?>" will be shown <a href="http://parking.<?=$site_domain;?>" target="_blank"><strong>this page </strong></a>. Use the above text box to add a custom message to your "parking" page for this domain only. NOTE: Although the link from "www.<?=$sld;?>.<?=$tld;?>" to "parking.<?=$site_domain;?>" may take some time to get updated in our system, changing this text will update your custom "parked" page immediately. </td>
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