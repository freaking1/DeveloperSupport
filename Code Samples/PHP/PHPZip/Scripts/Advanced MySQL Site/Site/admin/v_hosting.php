<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

$HostAccount = $_GET['HostAccount'];
$command = $_GET['command'];

if($HostAccount == ''){
	header ("Location:  $site_url/admin/hostingman.php");
	exit(); // Quit the script.
	}
	
	$sql = "SELECT 	host_id, host_password, email, package_id, package_name, db_type, db_storage, pop_boxes, disk_storage, bandwidth, price, next_renew, status FROM webhosting WHERE host_username = '$HostAccount'";
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
			$cancel_link = "<a href=\"v_hosting.php?HostAccount=$HostAccount&host_id=$host_id&command=cancel\"><img src=\"../images/btn_cancel.gif\" border=\"0\"></a>";
		} elseif($HostDetails[12] == 4){
			$status = 'Scheduled for Deletion';
			$cancelheader = 'Re-enable Account';
			$cancel_link = "<a href=\"v_hosting.php?HostAccount=$HostAccount&host_id=$host_id&command=enable\"><img src=\"../images/btn_notcancel.gif\" border=\"0\"></a>";
			}
		
		if($HostDetails[5] == 0){
			$database = 'Access Database';
		} elseif($HostDetails[5] == 1){
			$database = "$HostDetails[5] MB Sql Database";
			}

	$Enom1 = new CEnomInterface; 
	$Enom1->NewRequest();
	$Enom1->AddParam( "uid", $enom_username );
	$Enom1->AddParam( "pw", $enom_password );
	$Enom1->AddParam( "site", $sitename );
	$Enom1->AddParam( "HostAccount", $HostAccount );
	$Enom1->AddParam( "command", "GetHostAccount" );
	$Enom1->DoTransaction();
		$DatabaseType_current = $Enom1->Values[ "DatabaseType" ];
		$BandwidthGB_current = $Enom1->Values[ "BandwidthGB" ];
		$BandwidthUsedGB_current = $Enom1->Values[ "BandwidthUsedGB" ];
		$WebStorageMB_current = $Enom1->Values[ "WebStorageMB" ];
		$WebStorageUsedMB_current = $Enom1->Values[ "WebStorageUsedMB" ];
		$DBStorageMB_current = $Enom1->Values[ "DBStorageMB" ];
		$DBStorageUsedMB_current = $Enom1->Values[ "DBStorageUsedMB" ];
		$POPMailBoxes_current = $Enom1->Values[ "POPMailBoxes" ];
		$POPMailBoxCount_current = $Enom1->Values[ "POPMailBoxCount" ];
		
		$bw_current = $BandwidthUsedGB_current / $BandwidthGB_current;
		$diskspace_current = $WebStorageUsedMB_current / $WebStorageMB_current;
		$popmail_current = $POPMailBoxes_current / $POPMailBoxCount_current;
		
		if($DatabaseType_current != 'Access'){
		$dbusage_current = $DBStorageUsedMB_current / $DBStorageMB_current;
		}

if($command == 'changedetails'){
	
	$WebStorageUnits = urlencode($_POST['WebStorageUnits']);
	$BandwidthUnits = urlencode($_POST['BandwidthUnits']);
	$DBType = urlencode($_POST['DBType']);
	$DBStorageUnits = urlencode($_POST['DBStorageUnits']);
	$POPUnits = urlencode($_POST['POPUnits']);
	$POPStorageUnits = urlencode($_POST['POPStorageUnits']);
	
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
	echo $Enom2->PostString;
	
	if($Enom2->Values[ "ErrCount" ] == '0'){
			$Enom3 = new CEnomInterface; 
			$Enom3->NewRequest();
			$Enom3->AddParam( "uid", $enom_username );
			$Enom3->AddParam( "pw", $enom_password );
			$Enom3->AddParam( "site", $sitename );
			$Enom3->AddParam( "HostAccount", $HostAccount );
			$Enom3->AddParam( "command", "GetHostAccount" );
			$Enom3->DoTransaction();
			
			$Status = $Enom3->Values[ "Status" ];
			$Price = $Enom3->Values[ "Price" ];
			
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
		$message = $Enom2->Values[ "Err1" ];
	}
}	

if($command == 'cancel'){
$host_id = $_GET['host_id'];
	$Sql = "Update webhosting set status = '4' where host_username='$HostAccount' AND host_id='$host_id'";
	$sql_run = mysql_query($Sql);
		if($sql_run){
		//If the result was ok - then Set the host account deletion flag
		 		$Enom4 = new CEnomInterface; 
				$Enom4->AddParam( "uid", $enom_username );
				$Enom4->AddParam( "pw", $enom_password );
				$Enom4->AddParam( "site", $sitename );
				$Enom4->AddParam( "HostAccount", $HostAccount );
				$Enom4->AddParam( "Delete", "1" );
				$Enom4->AddParam( "Enable", "1" );
				$Enom4->AddParam( "command", "CancelHostAccount" );
				$Enom4->DoTransaction();
					if($Enom4->Values[ "ErrCount" ] == '0'){
						$Enom5 = new CEnomInterface; 
						$Enom5->AddParam( "uid", $enom_username );
						$Enom5->AddParam( "pw", $enom_password );
						$Enom5->AddParam( "site", $sitename );
						$Enom5->AddParam( "HostAccount", $HostAccount );
						$Enom5->AddParam( "command", "GetHostAccount" );
						$Enom5->DoTransaction();
							
						$TerminateDate = $Enom5->Values[ "TerminateDate" ];
						$sql = "update webhosting set cancel_date = '$TerminateDate' WHERE host_username='$HostAccount' AND status = '4' AND host_id='$host_id'";
						$sql_run = mysql_query($sql);
						$postVars = "HostAccount=$HostAccount";
						header ("Location:  $site_url/admin/hostingman.php?$postVars");
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
		 		$Enom6 = new CEnomInterface; 
				$Enom6->AddParam( "uid", $enom_username );
				$Enom6->AddParam( "pw", $enom_password );
				$Enom6->AddParam( "site", $sitename );
				$Enom6->AddParam( "HostAccount", $HostAccount );
				$Enom6->AddParam( "Delete", "0" );
				$Enom6->AddParam( "Enable", "1" );
				$Enom6->AddParam( "command", "CancelHostAccount" );
				$Enom6->DoTransaction();
					if($Enom6->Values[ "ErrCount" ] == '0'){
						$sql = "update webhosting set cancel_date = 'NULL' WHERE host_username='$HostAccount' AND status = '0' AND host_id='$host_id'";
						$sql_run = mysql_query($sql);
						$postVars = "HostAccount=$HostAccount";
						header ("Location:  $site_url/admin/hostingman.php?$postVars");
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
	include("../functions/escape_data.php");
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
		$Enom7 = new CEnomInterface; 
		$Enom7->NewRequest();
		$Enom7->AddParam( "uid", $enom_username );
		$Enom7->AddParam( "pw", $enom_password );
		$Enom7->AddParam( "HostAccount", $HostAccount );
		$Enom7->AddParam( "NewHostPW", $HostPassword );
		$Enom7->AddParam( "ConfirmNewHostPW", $cPW2 );
		$Enom7->AddParam( "enduserip", $enduserip );
		$Enom7->AddParam( "site", $sitename );
		$Enom7->AddParam( "User_ID", $_COOKIE['id'] );
		$Enom7->AddParam( "command", "WebHostUpdatePassword" );
		$Enom7->DoTransaction();	
		
		if ( $Enom7->Values[ "ErrCount" ] == "0" ) {
			$message2 .= "Succesfully Updated Host account $HostAccount's password";
			} else {
			$message2 .= $Enom7->Values[ "Err1" ];
			}
		}
	}
}

include("include/header.php");?>
<tr>
    <td width="100%" valign="top" height="110"><table width="100%" border="0" valign="top" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td width="18%" valign="top" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td width="34%" align="center">&nbsp;</td>
        <td width="23%" align="left" class="BasicText">        
        <td width="18%" align="center"> <div align="left"></div>
        </td>
      </tr>
      <tr> <span class=\"BasicText\"></span>
        <td colspan="3" rowspan="6" valign="top" align="center">
		<br>
            		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th colspan="2" scope="col"><?=$message;?></th>
            </tr>
          <tr>
            <th valign="top" scope="col">                <table valign="top" width="325" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                  <tr>
                    <th width="163" class="BasicText" scope="col"><div align="right">Host Account Name: </div></th>
                    <th width="164" class="BasicText" scope="col"><?=$HostAccount;?>
&nbsp;</th>
                  </tr>
                  <tr>
                    <th class="BasicText" scope="col">
                      <div align="right">Current monthly fee:</div></th>
                    <th class="BasicText" scope="col">$
                        <?=$price;?></th>
                  </tr>
                  <tr>
                    <th class="BasicText" scope="col"><div align="right">Next Billing Date: </div></th>
                    <th class="BasicText" scope="col"><?=$next_renew;?></th>
                  </tr>
                  <tr>
                    <th class="BasicText" scope="col"><div align="right">Package Name: </div></th>
                    <th class="BasicText" scope="col"><?=$package_name;?>
&nbsp;</th>
                  </tr>
                  <tr>
                    <th class="BasicText" scope="col"><div align="right">Status:</div></th>
                    <th class="BasicText" scope="col"><?=$status;?></th>
                  </tr>
                </table>                </th>
            <th rowspan="3" valign="top" scope="col">    <form name="form1" method="post" action="v_hosting.php?command=changedetails&HostAccount=<?=$HostAccount;?>">
                  <table width="337" valign="top" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
<tr class="titlepic">
                      <th colspan="2" class="BasicText" scope="col"><span class="whiteheader">Upgrade / Downgrade Account</span></th>                    </tr>                    <tr>
                      <th width="148" class="BasicText" scope="col"><div align="right">Disk Space:</div></th>
                      <th width="189" class="BasicText" scope="col"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
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
                  MB </th>
                    </tr>
                    <tr>
                      <th class="BasicText" scope="col">
                        <div align="right">Bandwidth:</div></th>
                      <th class="BasicText" scope="col">
                        <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="BandwidthUnits">
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
                        <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="DBType" id="DBType">
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
                        &nbsp;&nbsp;                      </div></th>
                    </tr>
                    <tr>
                      <th colspan="2" class="BasicText" scope="col"><input type="image" border="0" name="image" src="../images/btn_modify_xsml_trns.gif"></th>
                    </tr>
                  </table>
                  <?  
	if(isset($message2)) {echo "<center><u><b><span class=\"BasicText\">$message2</span></b></u></center><br>";
	} else {
	echo '<br>';
	}
?>
                </form>
<table width="337" valign="top" border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                  <tr>
                    <th width="349" valign="top"  class="titlepic" scope="col"><div class="whiteheader"><?php echo "$cancelheader";?> </div></th>
                  </tr>
                  <tr valign="top" >
                    <td valign="top"  align="center"><?=$cancel_link;?>
                        <div align="center"></div></td>
                  </tr>
                </table>
<br>
<form name="form2" method="post" action="v_hosting.php?action=changepass&HostAccount=<?=$HostAccount;?>">
<table width="337" valign="top"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableO1">
                    <tr>
                      <th colspan="2" class="titlepic" scope="col"><div class="whiteheader">Change Password </div></th>
                    </tr>
                    <tr>
                      <td width="152" align="center" class="BasicText">New Password </td>
                      <td width="153" align="center"><input name="password1" type="password" id="password12" size="16" maxlength="16"></td>
                    </tr>
                    <tr>
                      <td align="center" class="BasicText">Confirm Password </td>
                      <td align="center"><input name="password2" type="password" id="password2" size="16" maxlength="16"></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center">
                        <input name="Input" type="image" src="../images/btn_submit.gif" align="middle" border="0"></td>
                    </tr>
                  </table>
              </form></th>
          </tr>
          <tr>
            <th valign="top" scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th rowspan="2" valign="top" scope="col"><table width="337" border="0" valign="top" align="center" cellpadding="0" cellspacing="0" class="tableO1">
              <tr class="titlepic" valign="top">
                <th colspan="4" scope="col" valign="top"> <strong class="whiteheader">HOSTING ACCOUNT USAGE </strong> </th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th width="17" scope="col">&nbsp;</th>
                <th colspan="2" scope="col">
                  <div align="left" class="BasicText">
                    <div align="center"><strong>Hosting Storage: </strong> </div>
                </div></th>
                <th width="20" scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="../functions/image.php?rating=<?=$diskspace;?>&width=200&height=20" border="0"></div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th width="149" class="windowinside" scope="col"><div class="BasicText">
                    <div align="center">Allowed:
                        <?=$WebStorageMB_current;?>
          MB </div>
                </div></th>
                <th width="149" class="windowinside" scope="col"><div align="center"><span class="BasicText">Using:
                          <?=$WebStorageUsedMB_current;?>
        MB </span></div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" scope="col">
                  <div align="left">
                    <div class="BasicText">
                      <div align="center"><strong>Bandwidth per month: </strong> </div>
                    </div>
                </div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="../functions/image.php?rating=<?=$bw;?>&width=200&height=20" border="0"></div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th class="windowinside" scope="col"><div class="BasicText">
                    <div align="center">Allowed:
                        <?=$BandwidthGB_current;?>
          GB </div>
                </div></th>
                <th class="windowinside" scope="col"><div align="center"><span class="BasicText">Using:
                          <?=$BandwidthUsedGB_current;?>
        GB </span></div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" scope="col">
                  <div align="left">
                    <div class="BasicText">
                      <div align="center"><strong>Email Accounts (POP3): </strong> </div>
                    </div>
                </div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="../functions/image.php?rating=<?=$popmail;?>&width=200&height=20" border="0"></div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th class="windowinside" scope="col"><div class="BasicText">
                    <div align="center">Allowed:
                        <?=$POPMailBoxes_current;?>
                    </div>
                </div></th>
                <th class="windowinside" scope="col"><div align="center"><span class="BasicText">Using:
                          <?=$POPMailBoxCount_current;?>
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
                <th colspan="2" scope="col">
                  <div align="left">
                    <div class="BasicText">
                      <div align="center"><strong>Database: </strong> </div>
                    </div>
                </div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <?php
if($DatabaseType != 'Access'){ ?>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" class="windowinside" scope="col"><div align="center"><IMG SRC="../functions/image.php?rating=<?=$dbusage;?>&width=200&height=20" border="0"></div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th class="windowinside" scope="col"><div class="BasicText">
                    <div align="center">Allowed:
                        <?=$DBStorageMB_current;?>
          MB </div>
                </div></th>
                <th class="windowinside" scope="col"><div align="center" class="BasicText">Using:
                        <?=$DBStorageUsedMB_current;?>
                </div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <? } ?>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" class="windowinside" scope="col"><div class="BasicText">
                    <?=$database;?>
                </div></th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </table>
</th>
          </tr>
          <tr>
            <th colspan="2" scope="col">&nbsp;</th>
          </tr>
        </table>
            		<br>   		  </th>
        <a href="hostingman.php">
        <input name="Back" type="image" src="../images/btn_back.gif" align="middle" border="0"/>
        </a>          </tr>
<tr>
    </table>
</tr>
<tr></tr>
<?php include("include/footer.php");?>