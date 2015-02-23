<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=changepass");
	exit(); // Quit the script.
}
// Set the page title and include the HTML header.
$page_title = 'Change Your Password';

$action = $HTTP_POST_VARS['action'];
if ($action == "submit" ) {

	require_once ('include/dbconfig.php'); // Connect to the db.

	// Create a function for escaping the data.
	function escape_data ($data) {
		global $dbc; // Need the connection.
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string($data, $dbc);
	} // End of function.

	$message = NULL; // Create an empty new variable.

	// Check for an existing password.
	if (empty($_POST['password'])) {
		$p = FALSE;
		$message .= '<br>You forgot to enter your existing password!</br>';
	} else {
		$p = escape_data($_POST['password']);
	}

	// Check for a password and match against the confirmed password.
	if (empty($_POST['password1'])) {
		$np = FALSE;
		$message .= '<br>You forgot to enter your new password!</br>';
	} else {
		if ($_POST['password1'] == $_POST['password2']) {
			$np = escape_data($_POST['password1']);
		} else {
			$np = FALSE;
			$message .= '<br>Your new password did not match the confirmed new password!</br>';
		}
	}

	if ($p && $np) { // If everything's OK.

		$query = "SELECT username FROM users WHERE (username='$username' AND password=PASSWORD('$p') )";
		$result = @mysql_query ($query);
		$num = mysql_num_rows ($result);
		if ($num == 1) {
			$row = mysql_fetch_array($result, MYSQL_NUM);

			// Make the query.
			$query = "UPDATE users SET password=PASSWORD('$np') WHERE username='$row[0]'";
			$result = @mysql_query ($query); // Run the query.
			if (mysql_affected_rows() == 1) { // If it ran OK.

			//Update the Reset Pass parameter
			$query = "UPDATE users SET reset_pass='0' WHERE username='$row[0]'";
			$result = @mysql_query ($query); // Run the query.
				// Send an email, if desired.
			$message = '<p><b>Your password has been changed.</b></br>';
			header ("Location: $site_url/passchanged.php?refer=change" . $SID);

			} else { // If it did not run OK.
				$message = '<p>Your password could not be changed due to a system error. We apologize for any inconvenience.</p><p>' . mysql_error() . '</br>';
			}
		} else {
			$message = '<p>Your username and password do not match our records.</br>';
		}
		mysql_close(); // Close the database connection.
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Change Your Password </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
			        <?php
include('account_top.php');
?><br>
			        <form action="changepass.php" method="post">
			        <input type="hidden" name="action" value="submit">

  <div align="center">
    <span class="red">        </span>
    <table width="290" border="0" class="tableO1" >
        <tr>
          <td colspan="2" class="titlepic"> <span class="whiteheader"><strong><center>Change Your Password:</center></strong></td>
          </tr>
        <tr>
          <td class="BasicText"><div align="right"><span class="BasicText"><b>Current Password:</b></span></div></td>
          <td><div align="left"><span class="red">
              <input  type="password" name="password" size="14" maxlength="14" />
          </span></div></td>
        </tr>
        <tr>
          <td class="BasicText"><div align="right"><span class="BasicText"><b>New Password:</b></span></div></td>
          <td><div align="left"><span class="red">
              <input type="password" name="password1" size="14" maxlength="14" />
          </span></div></td>
        </tr>
        <tr>
          <td class="BasicText"><div align="right"><span class="BasicText"><b>Confirm New Password:</b></span></div></td>
          <td><div align="left"><span class="red">
              <input type="password" name="password2" size="14" maxlength="14" />
          </span></div></td>
        </tr>
        <tr>
          <td>
           <center><input type="image" name="submit" src="images/btn_savechng.gif" value="submit" /></center>
		  </td>
          <td><center>   <a href="mydomains.php" class="main"><img src="images/btn_cancel.gif" width="74" height="22" border="0" align="left"></a> </center>   </td>
</td>
        </tr>
    </table>
  </div>

                    </form>
			        			        <span class="red"></span>   			        </p>

                    <p align="center"><br>
                    </p>
			      <tr>
	              <td colspan="3" valign="top" class="content2">
              </table>
</table>
		          <?php include('include/footer.php');?>