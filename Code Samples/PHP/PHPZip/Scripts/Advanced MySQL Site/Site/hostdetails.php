<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];
	$HostAccount = strtoupper($_GET['HostAccount']);
	$command = $_GET['command'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=hostdetails&HostAccount=$HostAccount");
	exit(); // Quit the script.
}
require ("include/EnomInterface_inc.php");
require( "include/dbconfig.php" );

if($HostAccount == ''){
	header ("Location:  $site_url/myhosting.php");
	exit(); // Quit the script.
	}

	$sql = "SELECT 	host_id, host_password, email, package_id, package_name, db_type, db_storage, pop_boxes, disk_storage, bandwidth, price, next_renew, status FROM webhosting WHERE host_username = '$HostAccount' AND username = '$username' AND user_id='$user_id'";
	$sql2 = mysql_query($sql);
	$HostDetails = mysql_fetch_row($sql2);

	$host_id = $HostDetails[0];
	$host_password = $HostDetails[1];
	$email = $HostDetails[2];
	$package_id = $HostDetails[3];
	$package_name = $HostDetails[4];
	$db_storage = $HostDetails[6];
	$pop_boxes = $HostDetails[7];
	$disk_storage = $HostDetails[8];
	$bandwidth = $HostDetails[9];
	$price = $HostDetails[10];

		list($year, $month, $day) = split('[-]', $HostDetails[11]);
			if(strlen($day) != 2){
				$day = '0'.$day;
				}
			if(strlen($month) != 2){
				$month = '0'.$month;
				}

			$next_renew = "$month-$day-$year";

		if($HostDetails[12] == 1){
			$status = 'Suspended';
			$cancelheader = 'Re-activate account';
			$cancel_link = "This account is suspended and is unable to be reactivated - please contact support";
		} elseif($HostDetails[12] == 0){
			$status = 'Active';
			$cancelheader = 'Cancel Account';
			$cancel_link = "<a href=\"hostdetails.php?HostAccount=$HostAccount&host_id=$host_id&command=cancel\"><img src=\"images/btn_cancel.gif\" border=\"0\"></a>";
		} elseif($HostDetails[12] == 4){
			$status = 'Scheduled for Deletion';
			$cancelheader = 'Re-enable Account';
			$cancel_link = "<a href=\"hostdetails.php?HostAccount=$HostAccount&host_id=$host_id&command=enable\"><img src=\"images/btn_notcancel.gif\" border=\"0\"></a>";
			}

		if($HostDetails[5] == 0){
			$database = 'Access Database';
		} elseif($HostDetails[5] == 1){
			$database = "$HostDetails[5] MB Sql Database";
			}

	$Enom = new CEnomInterface;
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "site", $sitename );
	$Enom->AddParam( "HostAccount", $HostAccount );
	$Enom->AddParam( "command", "GetHostAccount" );
	$Enom->DoTransaction();
		$DatabaseType= $Enom->Values[ "DatabaseType" ];
		$BandwidthGB = $Enom->Values[ "BandwidthGB" ];
		$BandwidthUsedGB = $Enom->Values[ "BandwidthUsedGB" ];
		$WebStorageMB = $Enom->Values[ "WebStorageMB" ];
		$WebStorageUsedMB = $Enom->Values[ "WebStorageUsedMB" ];
		$DBStorageMB = $Enom->Values[ "DBStorageMB" ];
		$DBStorageUsedMB = $Enom->Values[ "DBStorageUsedMB" ];
		$POPMailBoxes = $Enom->Values[ "POPMailBoxes" ];
		$POPMailBoxCount = $Enom->Values[ "POPMailBoxCount" ];

		$bw = $BandwidthUsedGB / $BandwidthGB;
		$diskspace = $WebStorageUsedMB / $WebStorageMB;
		$popmail = $POPMailBoxes / $POPMailBoxCount;

		if($DatabaseType != 'Access'){
		$dbusage = $DBStorageUsedMB / $DBStorageMB;
		}

if($command == 'changedetails'){

	$WebStorageUnits = $_POST['WebStorageUnits'];
	$BandwidthUnits = $_POST['BandwidthUnits'];
	$DBType = $_POST['DBType'];
	$DBStorageUnits = $_POST['DBStorageUnits'];
	$POPUnits = $_POST['POPUnits'];
	$POPStorageUnits = $_POST['POPStorageUnits'];

	$Enom2 = new CEnomInterface;
	$Enom2->NewRequest();
	$Enom2->AddParam( "uid", $enom_username );
	$Enom2->AddParam( "pw", $enom_password );
	$Enom2->AddParam( "site", $sitename );
	$Enom2->AddParam( "HostAccount", $HostAccount );
	$Enom2->AddParam( "WebStorageUnits", $WebStorageUnits );
	$Enom2->AddParam( "BandwidthUnits", $BandwidthUnits );
	$Enom2->AddParam( "DBType", $DBType );
	$Enom2->AddParam( "DBStorageUnits", $DBStorageUnits );
	$Enom2->AddParam( "POPStorageUnits", $POPStorageUnits );
	$Enom2->AddParam( "POPUnits", $POPUnits );
	$Enom2->AddParam( "command", "WebHostSetCustomPackage" );
	$Enom2->DoTransaction();

	if($Enom2->Values[ "ErrCount" ] == '0'){
			$Enom = new CEnomInterface;
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "HostAccount", $HostAccount );
			$Enom->AddParam( "command", "GetHostAccount" );
			$Enom->DoTransaction();

			$Status = $Enom->Values[ "Status" ];
			$Price = $Enom->Values[ "Price" ];

			if($Status == 'Active'){
				$status_num = '1';
				} else {
				$status_num = '0';
				}
			if($DBType == 'MSSQL'){
				$db_type = '1';
				$db_storage = $DBStorageUnits;
				} else {
				$db_type = '0';
				$db_storage = 'Access';
				}

		list($month, $day, $year) = split('[/]', $Enom2->Values[ "BillingDate" ]);
			if(strlen($day) != 2){
				$day = '0'.$day;
				}
			if(strlen($month) != 2){
				$month = '0'.$month;
				}

			$BillingDate = "$year-$month-$day";

		$sql_update = "
		update webhosting set package_name = 'Custom Package', disk_storage = '$WebStorageUnits', bandwidth ='$BandwidthUnits', next_renew = '$BillingDate',
		status = '$status_num', price = '$Price', pop_boxes = '$POPUnits', db_storage = '$db_storage', db_type = '$db_type'
		WHERE host_username='$HostAccount'";
		$sql_run = mysql_query($sql_update);
		$postVars = "HostAccount=$HostAccount";
			if($sql_run){
			header ("Location:  $site_url/admin/hostingman.php?$postVars");
			exit(); // Quit the script.
			} else {
			$message = "Could not update the db - please try again later<br>$sql_update";
			}
		} else {
		$message = "There was an error getting account information.  Verify the hosting account exists.";
	}
}

if($command == 'cancel'){
$host_id = $_GET['host_id'];
	$Sql = "Update webhosting set status = '4' where host_username='$HostAccount' AND host_id='$host_id'";
	$sql_run = mysql_query($Sql);
		if($sql_run){
		//If the result was ok - then Set the host account deletion flag
		 		$Enom = new CEnomInterface;
				$Enom->AddParam( "uid", $enom_username );
				$Enom->AddParam( "pw", $enom_password );
				$Enom->AddParam( "site", $sitename );
				$Enom->AddParam( "HostAccount", $HostAccount );
				$Enom->AddParam( "Delete", "1" );
				$Enom->AddParam( "Enable", "1" );
				$Enom->AddParam( "command", "CancelHostAccount" );
				$Enom->DoTransaction();
					if($Enom->Values[ "ErrCount" ] == '0'){
						$Enom = new CEnomInterface;
						$Enom->AddParam( "uid", $enom_username );
						$Enom->AddParam( "pw", $enom_password );
						$Enom->AddParam( "site", $sitename );
						$Enom->AddParam( "HostAccount", $HostAccount );
						$Enom->AddParam( "command", "GetHostAccount" );
						$Enom->DoTransaction();

						$TerminateDate = $Enom->Values[ "TerminateDate" ];
						$sql = "update webhosting set cancel_date = '$TerminateDate' WHERE host_username='$HostAccount' AND status = '4' AND host_id='$host_id'";
						$sql_run = mysql_query($sql);
						$postVars = "HostAccount=$HostAccount";
						header ("Location:  $site_url/hostdetails.php?$postVars");
						exit(); // Quit the script.
						} else {
						$message = "There was an error cancelling the account - please try again later";
						}
			} else {
			$message = "Could not update the database - please contact support";
			echo $Sql;
		}
} elseif($command == 'enable'){
$host_id = $_GET['host_id'];
	$Sql = "Update webhosting set status = '0' where host_username='$HostAccount' AND host_id='$host_id'";
	$sql_run = mysql_query($Sql);
		if($sql_run){
		//If the result was ok - then Set the host account deletion flag
				require ("include/EnomInterface_inc.php");
		 		$Enom = new CEnomInterface;
				$Enom->AddParam( "uid", $enom_username );
				$Enom->AddParam( "pw", $enom_password );
				$Enom->AddParam( "site", $sitename );
				$Enom->AddParam( "HostAccount", $HostAccount );
				$Enom->AddParam( "Delete", "0" );
				$Enom->AddParam( "Enable", "1" );
				$Enom->AddParam( "command", "CancelHostAccount" );
				$Enom->DoTransaction();
					if($Enom->Values[ "ErrCount" ] == '0'){
						$sql = "update webhosting set cancel_date = 'NULL' WHERE host_username='$HostAccount' AND status = '0' AND host_id='$host_id'";
						$sql_run = mysql_query($sql);
						$postVars = "HostAccount=$HostAccount";
						header ("Location:  $site_url/hostdetails.php?$postVars");
						exit(); // Quit the script.
						} else {
						$message = "There was an error enabling the account - please try again later";
						}
			} else {
			$message = "Could not update the database - please contact support";
		}
}

$action = $_GET['action'];
if($action == 'changepass'){
	include("functions/escape_data.php");
	$HostAccount = $_GET['HostAccount'];
	$cPW1 = $HTTP_POST_VARS[ "password1" ];
	$cPW2 = $HTTP_POST_VARS[ "password2" ];

	if(empty($_POST['password1'])) {
		$HostPassword = FALSE;
		$message2 .= '<br>You forgot to enter a password';
	} else {
	if($_POST['password1'] == $_POST['password2']) {
		$HostPassword = escape_data($_POST['password1']);
			if(strlen($HostPassword) < 6){
				   $message2 .= "<br>Your password $HostPassword  must be 6 characters";
				   $HostPassword = FALSE;
				} else {
					if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/", $HostPassword)) {
					  $message2 .= "<br>Your password does not meet complexity requirements";
					  $HostPassword = FALSE;
					}
				}
	} else {
		$HostPassword = FALSE;
		$message2 .= '<br>Your passwords do not match';
		}

	if($HostPassword){
		$Enom = new CEnomInterface;
		$Enom->NewRequest();
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "HostAccount", $HostAccount );
		$Enom->AddParam( "NewHostPW", $HostPassword );
		$Enom->AddParam( "ConfirmNewHostPW", $cPW2 );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", $_COOKIE['id'] );
		$Enom->AddParam( "command", "WebHostUpdatePassword" );
		$Enom->DoTransaction();

		if ( $Enom->Values[ "ErrCount" ] == "0" ) {
			$message2 .= "Succesfully Updated Host account $HostAccount's password";
			} else {
			$message2 .= $Enom->Values[ "Err1" ];
			}
		}
	}
}

$page = "webhosting";
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
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">Host account Detail
			      </span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">
			        <p>
<?
include('account_top.php');
?>

			        </p>
			        <table width="337" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                      <tr>
                        <th width="163" class="BasicText" scope="col"><div align="right">Host Account Name: </div></th>
                        <th width="164" class="BasicText" scope="col"><?=$HostAccount;?>&nbsp;</th>
                      </tr>
                      <tr>
                        <th class="BasicText" scope="col"> <div align="right">Current monthly fee:</div></th>
                        <th class="BasicText" scope="col">$<?=$price;?></th>
                      </tr>
                      <tr>
                        <th class="BasicText" scope="col"><div align="right">Next Billing Date: </div></th>
                        <th class="BasicText" scope="col"><?=$next_renew;?></th>
                      </tr>
                      <tr>
                        <th class="BasicText" scope="col"><div align="right">Package Name: </div></th>
                        <th class="BasicText" scope="col"><?=$package_name;?>&nbsp;</th>
                      </tr>
                      <tr>
                        <th class="BasicText" scope="col"><div align="right">Status:</div></th>
                        <th class="BasicText" scope="col"><?=$status;?></th>
                      </tr>
                    </table>
			        <br><form name="form1" method="post" action="hostdetails.php?command=changedetails&HostAccount=<?=$HostAccount;?>">
                  <table width="337" valign="top" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                    <tr class="titlepic">
                      <th colspan="2" class="BasicText" scope="col"><span class="whiteheader">Upgrade / Downgrade Account</span></th>                    </tr>
                    <tr>
                      <th width="167" class="BasicText" scope="col"><div align="right">Disk Space:</div></th>
                      <th width="168" class="BasicText" scope="col"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                              <select name="WebStorageUnits" id="WebStorageUnits">
                                <option value="1">50</option>
                                <option value="2">100</option>
                                <option value="3">150</option>
                                <option value="4">200</option>
                                <option value="5">250</option>
                                <option value="6">300</option>
                                <option value="7">350</option>
                                <option value="8">400</option>
                                <option value="9">450</option>
                                <option value="10">500</option>
                              </select>
      MB </div></th>
                    </tr>
                    <tr>
                      <th class="BasicText" scope="col">
                        <div align="right">Bandwidth:</div></th>
                      <th class="BasicText" scope="col">
                        <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="BandwidthUnits">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                              <option value="25">25</option>
                              <option value="26">26</option>
                              <option value="27">27</option>
                              <option value="28">28</option>
                              <option value="29">29</option>
                              <option value="30">30</option>
                            </select>
      GB </div></th>
                    </tr>
                    <tr>
                      <th class="BasicText" scope="col"><div align="right">Database Type:</div></th>
                      <th class="BasicText" scope="col">
                        <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="DBType" id="DBType">
                              <option value="Access">Access</option>
                              <option value="MSSQL">MSSQL</option>
                            </select>
                      </div></th>
                    </tr>
                    <tr>
                      <th class="BasicText" scope="col"><div align="right">Sql Database Size:</div></th>
                      <th class="BasicText" scope="col">
                        <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="DBStorageUnits" id="DBStorageUnits">
                              <option value="1">50</option>
                              <option value="2">100</option>
                              <option value="3">150</option>
                              <option value="4">200</option>
                              <option value="5">250</option>
                              <option value="6">300</option>
                              <option value="7">350</option>
                              <option value="8">400</option>
                              <option value="9">450</option>
                              <option value="10">500</option>
                            </select>
                      </div></th>
                    </tr>
                    <tr>
                      <th class="BasicText" scope="col"><div align="right">POP Accounts:</div></th>
                      <th class="BasicText" scope="col">
                        <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="POPUnits" id="POPUnits">
                              <option value="1">10</option>
                              <option value="2">20</option>
                              <option value="3">30</option>
                              <option value="4">40</option>
                              <option value="5">50</option>
                              <option value="6">60</option>
                              <option value="7">70</option>
                              <option value="8">80</option>
                              <option value="9">90</option>
                              <option value="10">100</option>
                            </select>
                      </div></th>
                    </tr>
                    <tr>
                      <th class="BasicText" scope="col"><div align="right">POP Mailbox Size:</div></th>
                      <th class="BasicText" scope="col">
                        <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="POPStorageUnits" id="select">
                              <option value="1">10 mb</option>
                              <option value="2">20 mb</option>
                              <option value="3">30 mb</option>
                              <option value="4">40 mb</option>
                              <option value="5">50 mb</option>
                              <option value="6">60 mb</option>
                              <option value="7">70 mb</option>
                              <option value="8">80 mb</option>
                              <option value="9">90 mb</option>
                              <option value="10">100 mb</option>
                            </select>
&nbsp;&nbsp; </div></th>
                    </tr>
                    <tr>
                      <th colspan="2" class="BasicText" scope="col"><input type="image" border="0" name="image" src="../images/btn_modify_xsml_trns.gif"></th>
                    </tr>
                  </table>                  <br>
			        <table width="337" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                      <tr class="titlepic">
                        <th colspan="4" scope="col"> <strong class="whiteheader">HOSTING ACCOUNT USAGE </strong> </th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th width="17" scope="col">&nbsp;</th>
                        <th colspan="2" scope="col"> <div align="left" class="BasicText">
                          <div align="center"><strong>Hosting Storage: </strong> </div>
                        </div></th>
                        <th width="20" scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="functions/image.php?rating=<?=$diskspace;?>&width=200&height=20" border="0"></div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th width="149" class="windowinside" scope="col"><div class="BasicText">
                          <div align="center"><span class="BasicText">Allowed:</span>                              <?=$WebStorageMB;?>
                              <span class="BasicText">MB</span> </div></th>
                        <th width="149" class="windowinside" scope="col"><div align="center"><span class="BasicText">Using:
                              <?=$WebStorageUsedMB;?> MB
                        </span></div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col"> <div align="left"><div class="BasicText">
                          <div align="center"><strong>Bandwidth per month: </strong> </div>
                        </div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="functions/image.php?rating=<?=$bw;?>&width=200&height=20" border="0"></div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th class="windowinside" scope="col"><div class="BasicText">
                            <div align="center"><span class="BasicText">Allowed:</span>
                              <?=$BandwidthGB;?>
                              <span class="BasicText">GB</span> </div>
                        </div></th>
                        <th class="windowinside" scope="col"><div align="center"><span class="BasicText">Using:
                              <?=$BandwidthUsedGB;?>
GB                        </span></div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col"> <div align="left"><div class="BasicText">
                          <div align="center"><strong>Email Accounts (POP3): </strong> </div>
                        </div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
					  <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="functions/image.php?rating=<?=$popmail;?>&width=200&height=20" border="0"></div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th class="windowinside" scope="col"><div class="BasicText">
                            <div align="center"><span class="BasicText">Allowed:</span>
                              <?=$POPMailBoxes;?></div>
                        </div></th>
                        <th class="windowinside" scope="col"><div align="center"><span class="BasicText">Using:
                              <?=$POPMailBoxCount;?>
                        </span></div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col"> <div align="left"><div class="BasicText">
                          <div align="center"><strong>Database: </strong> </div>
                        </div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
<?php
if($DatabaseType != 'Access'){ ?>
					  <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="functions/image.php?rating=<?=$dbusage;?>&width=200&height=20" border="0"></div></th>
                        <th scope="col">&nbsp;</th>
                      </tr>

             <tr>
               <th scope="col">&nbsp;</th>
               <th class="windowinside" scope="col"><div class="BasicText">
                   <div align="center"><span class="BasicText">Allowed:</span>
                         <?=$DBStorageMB;?>
                         <span class="BasicText">MB</span> </div>
               </div></th>
               <th class="windowinside" scope="col"><div align="center" class="BasicText"><span class="BasicText">Using:</span>
                         <?=$DBStorageUsedMB;?>
               </div></th>
               <th scope="col">&nbsp;</th>
             </tr><? } ?>
             <tr>
                        <th scope="col">&nbsp;</th>
                      <th colspan="2" class="windowinside" scope="col"><div class="BasicText"><?=$database;?></th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th colspan="2" scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </table>
			        <br>
			        <table width="337" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                      <tr>
                        <th width="349" class="titlepic" scope="col"><div class="whiteheader"><?php echo "$cancelheader";?> </div></th>
                      </tr>
                      <tr>
                        <td align="center"><?=$cancel_link;?>
                          <div align="center"></div></td>
                      </tr>
                    </table>
			        <br>
<?
	if(isset($message2)) {echo "<center><u><b><span class=\"BasicText\">$message2</span></b></u></center><br>";
	} else {
	echo '<br>';
	}
?>
			        <form name="form2" method="post" action="hostdetails.php?action=changepass&HostAccount=<?=$HostAccount;?>">
			        <table width="337" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                      <tr>
                        <th colspan="2" class="titlepic" scope="col"><div class="whiteheader">Change Password </div></th>
                      </tr>
                      <tr>
                        <td width="152" align="center" class="BasicText">New Password </td>
                        <td width="153" align="center"><input name="password1" type="password" id="password1" size="16" maxlength="16"></td>
                      </tr>
                      <tr>
                        <td align="center" class="BasicText">Confirm Password </td>
                        <td align="center"><input name="password2" type="password" id="password2" size="16" maxlength="16"></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center">                        <input name="" type="image" src="images/btn_submit.gif" align="middle" border="0"></td>
                      </tr>
                    </table>
		            </form>
		        <p>&nbsp;</p>
			        <p align="center"><a href="myhosting.php"><input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/>
			        </p>
			      <tr>
	          </table>
</table>
<?php include('include/footer.php');?>
