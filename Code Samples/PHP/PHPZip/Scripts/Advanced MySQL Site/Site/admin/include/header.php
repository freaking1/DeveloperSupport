<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

if (!isset($_COOKIE['AdminUserName'])) {
	header ("Location:  $secure_site_url/login.php");
	exit(); // Quit the script.
}

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];
	$admin_username = strtoupper($_COOKIE['AdminUserName']);
?>

<link rel="stylesheet" href= "../css/styles.css" type="text/css">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr bgcolor="a9b5ca" class="formfield">
        <td colspan="8"><div align="center" class="BasicText"> 
            <strong><?=$sitename;?> Administration Site</strong></div></td>
      </tr>
      <tr>
        <td width="133" height="19" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="userman.php">User Manager</a> </div></td>
        <td width="133" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="domainman.php">Domain Manager</a> </div></td>
        <td width="133" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="transferman.php">Transfer Manger</a> </div></td>
        <td width="170" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="hostingman.php">Hosting Manger</a> </div></td>
        <td width="133" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="<?=$site_url;?>">Back to Main site </a></div></td>
      </tr><tr>
        <td width="133" height="19" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="v_queue.php">View Queue Items</a></div></td>
        <td width="133" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="e_queue.php">Failed Order Logs</a> </div></td>
        <td width="133" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="admintools.php">Admin Tools</a></div></td>
        <td width="170" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="contact.php">Contact Forms</a></div></td>
        <td width="133" bgcolor="#d8e6f5" class="Button"><div align="center"><a href="stats.php">Statistics / Logs </a></div></td>
      </tr>
</table>