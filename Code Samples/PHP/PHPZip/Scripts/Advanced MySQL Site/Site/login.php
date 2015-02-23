<?php
if(isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $site_url/myaccount.php");
	exit(); // Quit the script.
}

//Pull the Variables in the string to pass to the form and use for redirection
$target = $_GET["target"];
$Domain = $_GET["Domain"];
$sld = $_GET["sld"];
$tld = $_GET["tld"];
$action = $_GET["action"];
$prodid = $_GET["prodid"];
$numyears = $_GET["numyears"];
$command = $_GET["command"];
$HostAccount = $_GET["HostAccount"];
$PackageName = $_GET["PackageName"];
$PackageID = $_GET["PackageID"];
$BandwidthGB = $_GET["BandwidthGB"];
$WebStorageMB = $_GET["WebStorageMB"];
$DBStorageMB = $_GET["DBStorageMB"];
$POPMailBoxes = $_GET["POPMailBoxes"];
$DatabaseType = $_GET["DatabaseType"];
$SellPrice = $_GET["SellPrice"];
$invoice = $_GET["invoice"];
//-----------------------
//  Set the form post and Get Options to set Refferring pages and their options
$formoptions = '?';

if($target != ''){
$formoptions .= "target=$target&";}

if($Domain != ''){
$formoptions .= "Domain=$Domain&";}

if($sld != ''){
$formoptions .= "sld=$sld&tld=$tld&";}

if($command != '' ){
$formoptions .=  "command=$command&";}

if($target == 'viewinvoice'){
$formoptions .= "invoice=$invoice&refer=myinvoices&target=viewinvoice";}

if($target == "orderhosting"){
$formoptions .= "PackageName=$PackageName&PackageID=$PackageID&BandwidthGB=$BandwidthGB&WebStorageMB=$WebStorageMB&DBStorageMB=$DBStorageMB&POPMailBoxes=$POPMailBoxes&DatabaseType=$DatabaseType&SellPrice=$SellPrice";}

if($target == 'hostdetails'){
$formoptions .= "HostAccount=$HostAccount";}

if($target == 'hosts'){
$formoptions .= "tld=$tld&sld=$sld";}

if($target == 'mailsettings'){
$formoptions .= "tld=$tld&sld=$sld&action=$action";}

if($target == 'mypopmail'){
$formoptions .= "tld=$tld&sld=$sld";}

if($target == 'namephone'){
$formoptions .= "tld=$tld&sld=$sld";}

if($target == 'namemap'){
$formoptions .= "tld=$tld&sld=$sld";}

if($target == 'nsmaint'){
$formoptions .= "tld=$tld&sld=$sld";}

if($target == 'parking'){
$formoptions .= "tld=$tld&sld=$sld";}

if($target == "addtocart"){
$formoptions .= "sld=$sld&tld=$tld&command=addtocart&prodid=$prodid&numyears=$numyears&user_id=$row[0]";}

if($target == "view_cart"){
$formoptions .= '';}

$postform = $_SERVER['PHP_SELF']."$formoptions";
$action = $HTTP_POST_VARS['action'];

if ($action == 'login') { // Handle the form.

	require_once ('include/dbconfig.php'); // Connect to the db.
	include("functions/escape_data.php");

	$message = NULL;

	if (empty($_POST['username'])) {
		$u = FALSE;
		$message .= 'You forgot to enter your username!<br>';
	} else {
		$u = escape_data($_POST['username']);
	}
	if (empty($_POST['password'])) {
		$p = FALSE;
		$message .= 'You forgot to enter your password!<br>';
	} else {
		$p = escape_data($_POST['password']);
	}

	if ($u && $p) { // If everything's OK.
		$query = "SELECT id, username, isadmin FROM users WHERE username='$u' AND password=PASSWORD('$p')";
		$result = @mysql_query ($query);
		$row = mysql_fetch_array ($result, MYSQL_NUM);
		if ($row) {

				$query2 = "UPDATE users SET last_login=NOW(), login_IP='$enduserip' WHERE username='$u' AND password=PASSWORD('$p')";
				$result2 = @mysql_query ($query2);

				session_name ('API-PHPSESSID');
				session_start();
				ob_start();
				ini_set ('session.use_cookies', 1);

				setcookie("loggedin", "TRUE", 0);
				
				setcookie ("loggedin_user", "$row[1]", time()+3600, "/", "$siteurl", 0);
				setcookie ("id", "$row[0]", time()+3600, "/", "$siteurl", 0);

				if($row[2] == 1){
					setcookie("AdminUserName", "$row[1]", time()+3600, "/", "$siteurl", 0);
					setcookie("AdminUser", "1", time()+3600, "/", "$siteurl", 0);
				} else {
					setcookie("AdminUserName", "");
					setcookie("AdminUser", "0");
				}
					
				
					if($target != ''){
						header ("Location:  $site_url/$target.php$formoptions");exit();
						} else {
						header ("Location:  $site_url/myaccount.php");exit();}

		} else {
			$message .= 'Invalid UserID or Password.<br>';
		}
		mysql_close();
	} else {
		$message .= '<p>Please check to make sure you typed the login information correctly and try again.<br>';
	}
}
	$PageName= "Login";
	$PageTitle = $SiteTitle . " - Login";
?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
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
			      <td colspan="3" valign="top" class="content2"><p align="center"><br>
		<?php echo "<center><span class=\"BasicText\">$message</span>";?>
</p>
			        <table align="center" cellpadding="0" cellspacing="0" class="tableO1">
                      <tr>
                        <td width="506" class="titlepic"><div align="center"><span class="whiteheader"> Members Login Here!</span>                              </div>
                        </div></td>
                      </tr>
                      <tr class="OutlineOne">
                        <td align="center" class="OutlineOne"><p><br>
                            <strong>Welcome back. <br>
Please enter your login and password below. </strong> <br>
<strong>&raquo; New users: <a href="<?php echo "$secure_site_url/createacct.php";?>">Click here </a> to sign up for your free account. </strong> <br>
                          <div align="center">        <br>
        <table width="314" border="0" class="tableO1">
          <tr>
            <td width="308">
			 <form method="post" action="<?php echo "login.php$formoptions";?>" id="login" name="login">
			 <input type="hidden" name="action" value="login">
              <div align="center">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                      <td><table width="304" cellpadding="5" cellspacing="0">
                          <tr>
                            <td width="75" align="right">Username: </td>
                            <td width="211"><input name="username" type="text" class="formlogin" id="username" value="<?php if(isset($_POST['reguName'])) echo $_POST['reguName']; ?>" maxlength="16"></td>
                          </tr>
                          <tr>
                            <td align="right">Password:&nbsp;</td>
                            <td><input name="password" type="password" class="formlogin" id="password" maxlength="16"></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right"> <div align="center">
                              <input name="imageField" type="image" src="images/btn_login_g.gif" border="0">
                            </tr> </form>
                          <tr>
                            <td colspan="2" align="center"></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center">Note: This site uses cookies, and won't function properly without them.
If you have them turned off, please turn them on to continue.</td>
                          </tr>
                      </table></td>
                    </tr>
                              </table>
           </td>
          </tr>
        </table>
                <center>
                    <br>
                  If you have lost your password,<a href="lostpassword.php"> <b> Click Here </b></a>
                  </center>
        <br>
</div></td>
                      </tr>
                    </table>
			        <p align="center"><br>
                    </p>
		      <tr>
	              <td colspan="3" valign="top" class="content2">
              </table>
</table>
		          <?php include('include/footer.php');?>