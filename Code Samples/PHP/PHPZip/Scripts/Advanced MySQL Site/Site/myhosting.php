<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=myhosting");
	exit(); 
} 

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$display = $_GET["show"];

require( "include/dbconfig.php" );

	if($display == ''){
		$display = 15;
		}
		
		$pagename = "mydnshosted.php";
		$query = "SELECT reset_pass FROM users WHERE username='$username'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
		$reset_pass = $row[0];
		if ($reset_pass == 1) {
		$message = '<font="red"><span class="table00">You have been issued a temporary password.  Please change it by clicking the link above</font></span>';
		} 
	}
$command = $_GET["command"];
$HostAccount = $_GET["HostAccount"];

if($command == "access"){
include( "include/EnomInterface_inc.php");
		$Enom2 = new CEnomInterface;
		$Enom2->AddParam( "uid", $enom_username );
		$Enom2->AddParam( "pw", $enom_password );
		$Enom2->AddParam( "command", "WEBHOSTGETAUTOLOGIN" );
		$Enom2->AddParam( "HostAccount", $HostAccount );
		$Enom2->AddParam( "enduserip", $enduserip );
		$Enom2->AddParam( "site", $sitename );
		$Enom2->AddParam( "User_ID", $_COOKIE['id'] );
		$Enom2->DoTransaction();
				$accountstatus = $Enom2->Values[ "AccountStatusID" ];
				$weburl = $Enom2->Values[ "WebhostURL" ];
				$EUID = $Enom2->Values[ "Redir" ];
				$redirect .= "$weburl/Login.asp?EUID=$EUID";
	header ("Location:  http://$redirect");
}

	$page = "webhosting";
	$PageTitle = $SiteTitle . " - Administer your domain names";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">My Hosting</span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
			        <?php
					include('account_top.php');
	$query = "SELECT host_username, host_id, host_password, package_name, product_id, package_id, db_type,  db_storage, pop_boxes, disk_storage, bandwidth, status
				FROM webhosting
				WHERE user_id = '$user_id' AND (status='0' OR status='1' OR status='4')";
	$result = @mysql_query ($query);
	$row = mysql_fetch_array ($result, MYSQL_ASSOC);
	if ($row)
	{ //Then they have Hosting
	$has_hosting = 1;
	$message2 = NULL;
	} else {
	$has_hosting = 0;
	$message2 = '<center>You do not have any Hosting accounts at this time.
	<br><a href="webhosting.php"><b>Get Hosting Now!</a></center>';
	}
echo
			       '<table align="center" width="815" border="0" class="tableO1">
                      <tr class="tableO1">
                        <td colspan="4"><span class="BasicText"><strong>My Hosting: </span></td>
						<td colspan="1" align="right" class="BasicText" nowrap><b>STATUS: &nbsp;&nbsp;</b><img src="images/manage/yes.gif"> Hosting Active
						<td colspan="1" align="left" class="BasicText" nowrap>&nbsp;&nbsp;<img src="images/manage/redx.gif"> Hosting Disabled
						<td colspan="1" align="left" class="BasicText" nowrap>&nbsp;&nbsp;<img src="images/manage/no.gif"> Cancelled
                      </tr>
                      <tr class="tableO1">
                        <td width="100" align="center" class="titlepic" nowrap><span class="whiteheader">User Name</span></div></td>
                        <td width="85" align="center" class="titlepic" nowrap><span class="whiteheader">Storage</span></td>
                        <td width="85" align="center" class="titlepic" nowrap><span class="whiteheader">Bandwidth</span></td>
                        <td width="100" align="center" class="titlepic" nowrap><span class="whiteheader">Email Accts</span></td>
                        <td width="130" align="center" class="titlepic" nowrap><span class="whiteheader">Database</span></td>
						<td width="30" align="center" class="titlepic" nowrap><span class="whiteheader">Status</span></td>
                        <td width="1" align="center" class="titlepic" nowrap><span class="whiteheader">Manage</span></td>
                      </tr>
';
if($has_hosting == 1) {
$result = @mysql_query ($query);
$bg = '#eeeeee'; //Set the background color
while($row = mysql_fetch_array ($result, MYSQL_ASSOC)){
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround
$host_username = $row[host_username];

		if ($row[status] == 1){
		$status = "<img src=\"images/manage/redx.gif\">";
		} else if
		($row[status] == 0){
		$status = "<img src=\"images/manage/yes.gif\">";
		}
		else if
		($row[status] == 4){
		$status = "<img src=\"images/manage/cancel_hosting.gif\">";
		}

if ($row[db_type] == '0'){
$db_type = 'Database';
$mb = '';
} 

if ($row[db_type] == '1'){
$db_type = 'SQL Server';
$mb = 'MB';
}

$host_username = strtoupper($row[host_username]);
$DetailsLink = "<a href=\"hostdetails.php?HostAccount=$row[host_username]\">$host_username</a>";

echo 
"<tr bgcolor=\"$bg\">
<td align=\"center\"><b><span class=\"BasicText\"><u>$DetailsLink</u></b></td>
<td align=\"center\"><b><span class=\"BasicText\">$row[disk_storage] MB</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$row[bandwidth] GB</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$row[pop_boxes]</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$row[db_storage]$mb $db_type </b></td>
<td align=\"center\"><b><span class=\"BasicText\">$status</b></td>
<td align=\"center\"><b><u><span class=\"BasicTextMED\"><a href=\"myhosting.php?HostAccount=$row[host_username]&command=access\" target=\"_blank\">Access</a></b></u></td>
</tr>\n";
} 
//End the While loop
echo '</table><br>';
echo '<center><a href="webhosting.php"><b>Get a new Hosting Account...</b></a></center>';
//Close the database connection for now . . .
} else {
//The user has no Hosting accounts - so let them know they dont
echo "
<table align=\"center\" width=\"663\" border=\"0\">
<tr>
<td width=\"100%\" align=\"center\"><span class=\"BasicText\">$message2</td>

</tr>
</table>";
}
?>
                    <br>

                    <div align="center">
                        <table cellpadding="3" cellspacing="1" class="OutlineOne">
                      <tr>
                        <td><table class="OutlineOne" cellpadding="0" cellspacing="0">
                            <tr>
                              <td class="OutlineOne" align="center"><span class="BasicText"><strong>Description of fields above</strong></span><strong>: </strong></td>
                            </tr>
                            <tr>
                              <td class="OutlineOne"><span class="BasicText"><strong>Account Name: </strong> Click the account name to change your account preferences, including password and bandwidth overage handling options. <br>
                              <br>
                              <strong>Storage/BW/DB/Email: </strong> Displays your Storage Size, Bandwidth Size, Database Settings and Total number of Email accounts. <br>
                              <br>
                              <strong>Bandwidth Overage: </strong> Displays your bandwidth overage handling setting. <br>
                              <br>
                              <strong>Billing Date: </strong> Displays your next scheduled billing date. <br>
                              <br>
                              <strong>Status: </strong> The green check means your account is active, a big red x by iteself means your account is disabled (Usually either from payment problems or Bandwidth overage), a smaller red x means the account is scheduled for deletion.<br>
                              <br>
                              <strong>Domains: </strong> Click on "modify" to edit your domain associations. <br>
                              <br>
                              <strong>Control Panel: </strong> Click on "access" to enter the Web Hosting Control Panel, and manage your host headers and database. </span></td>
                            </tr>
                        </table></td>
                      </tr>
                      </table>
                    <br>
<br> 
                  </div>
              <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>