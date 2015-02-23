<?php
include("version.php");
if($testmode == 1){
$enom_server = 'Test Mode';
} else {
$enom_server = 'Live';
}

$Command = $_GET['Command'];

$script = $_SERVER['SCRIPT_NAME'];

//Get the account balance info
	$Enom = new CEnomInterface;
	$Enom->AddParam( "uid", $enom_username );
	$Enom->AddParam( "pw", $enom_password );
	$Enom->AddParam( "command", "GetBalance" );
	$Enom->AddParam( "enduserip", $enduserip );
	$Enom->AddParam( "site", $sitename );
	$Enom->AddParam( "User_ID", $_SESSION['id'] );
	$Enom->DoTransaction();
		$enom_Balance = $Enom->Values[ "Balance" ];
		$enom_AvailableBalance = $Enom->Values[ "AvailableBalance" ];

?>

<link rel="stylesheet" href= "../css/styles.css" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<table valign="top" width="100%" height="156"  border="0">
            <tr class="tableO1">
              <td rowspan="2"><div align="left">
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10">
                    <tr>
                      <td width="133" height="17" valign="top" align="center" class="formfield"><div align="left" class="BasicText">
                        <div valign="top" align="center"><strong> <u>eNom Account Info</u> </strong></div>
                      </div></td>
                    </tr>
                    <tr>
                      <td valign="top" align="center" class="formfield">
                        <div align="left"><span class="BasicText">Balance:  $</span><font color="#313187">
                              <?=$enom_Balance;?>
                                                  </font> <br>
                      </div></td>
                    </tr>
                    <tr>
                      <td valign="top" align="center" class="formfield"><div align="left"><span class="BasicText">Av. Balance: $</span><font color="#313187">                      
                      <?=$enom_AvailableBalance;?>
                      </font></div></td>
                    </tr>
                    <tr>
                      <td valign="top" align="center" class="formfield"><div align="left"><span class="BasicText">Server:</span>                        <?=$enom_server;?>
                      </div></td>
                    </tr>
                </table>
              </div></td>
            </tr>
            <tr class="tableO1"> </tr>
            <tr class="tableO1">
              <td>
                <div align="left">
                        <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10">
                            <tr>
                              <td class="formfield" valign="top" align="center" height="17" width="133">
                                <div align="left" class="BasicText">
                                  <div valign="top" align="center"><b><u>User Manager</u> </b></div>
                              </div></td>
                            </tr>
                            <tr>
                              <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "userman.php?show=add";?>">Add User</a> </div></td>
                            </tr>
                            <tr>
                              <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "userman.php?show=del";?>">Delete User</a> </div></td>
                            </tr>
                            <tr>
                              <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "userman.php?show=view";?>">View User</a> </div></td>
                            </tr>
                            <tr>
                              <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "userman.php?show=all";?>">View all Users</a> </div></td>
                            </tr>
                  </table>
              </div></td>
            </tr>
            <tr class="tableO1">
              <td><div align="left">
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="tableO1" id="table10">
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17" width="133">
                        <div align="left" class="BasicText">
                          <div valign="top" align="center"><b><u>Domain Manager</u> </b></div>
                      </div></td>
                    </tr>
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "domainman.php?show=add";?>">Add Domain </a> </div></td>
                    </tr>
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "domainman.php?show=view";?>">View Domain </a> </div></td>
                    </tr>
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "domainman.php?show=all";?>">View all Domains </a> </div></td>
                    </tr>
                </table>
              </div></td>
            </tr>
            <tr class="tableO1">
              <td><div align="left">
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10">
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17" width="133">
                        <div align="left" class="BasicText">
                          <div valign="top" align="center"><b><u>News Manager</u> </b></div>
                      </div></td>
                    </tr>
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "newsman.php?show=add";?>">Add News Item</a> </div></td>
                    </tr>
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "newsman.php?show=view";?>">View/Update  Items</a> </div></td>
                    </tr>
                  </table>
              </div></td>
            </tr>
            <tr class="tableO1">
              <td><div align="left">
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10">
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17" width="133">
                        <div align="left" class="BasicText">
                          <div valign="top" align="center"><b><u>Hosting Manager</u> </b></div>
                      </div></td>
                    </tr>
  <!--                  <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "hostingman.php?show=add";?>">Add Hosting Acct</a> </div></td>
                    </tr>
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "hostingman.php?show=del";?>">Delete hosting Acct</a> </div></td>
                    </tr> !-->
                    <tr>
                      <td class="formfield" valign="top" align="center" height="17"><div align="left"><a href="<?php echo "hostingman.php?show=view";?>">View / Update Hosting Accounts</a></div></td>
                    </tr>
                  </table>
              </div></td>
            </tr>
            <tr class="tableO1">
              <td><div align="left">
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10">
                    <tr>
                      <td width="133" height="17" valign="top" align="center" class="formfield">
                      <div valign="top" align="center"><span class="BasicText style1"><b><u><a href="stats.php">Statistics</a></u> </b></span></div></td>
                    </tr>
                  </table>
              </div></td>
            </tr>
</table>