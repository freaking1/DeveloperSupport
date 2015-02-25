<?php
session_name ('API-PHPSESSID');
session_start();
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

//Check the login status and assign variables accordingly
if (!isset($_COOKIE['loggedin_user'])) {
$PackageID  = $_GET[ "PackageID" ];
$PackageName = $_GET[ "PackageName" ];
$BandwidthGB = $_GET[ "BandwidthGB" ];
$WebStorageMB = $_GET[ "WebStorageMB" ];
$DatabaseType = $_GET[ "DatabaseType" ];
$POPMailBoxes = $_GET[ "POPMailBoxes" ];
$DBStorageMB = $_GET[ "DBStorageMB" ];
$SellPrice = $_GET[ "SellPrice" ];
$formoptions = "PackageName=$PackageName&PackageID=$PackageID&BandwidthGB=$BandwidthGB&WebStorageMB=$WebStorageMB&DBStorageMB=$DBStorageMB&POPMailBoxes=$POPMailBoxes&DatabaseType=$DatabaseType&SellPrice=$SellPrice";
	header ("Location:  $secure_site_url/login.php?target=orderhosting&$formoptions");
	exit(); // Quit the script.
}

	include('include/dbconfig.php');
	@include( "include/EnomInterface_inc.php" );
	include( "functions/escape_data.php");

$PackageID  = $_GET[ "PackageID" ];
$PackageName = $_GET[ "PackageName" ];
$BandwidthGB = $_GET[ "BandwidthGB" ];
$WebStorageMB = $_GET[ "WebStorageMB" ];
$DatabaseType = $_GET[ "DatabaseType" ];
$POPMailBoxes = $_GET[ "POPMailBoxes" ];
$DBStorageMB = $_GET[ "DBStorageMB" ];
$SellPrice = $_GET[ "SellPrice" ];
$HostAccount = $HTTP_POST_VARS[ "HostAccount" ];
$email = $HTTP_POST_VARS["HostAccountEmail"];
$FullName = $HTTP_POST_VARS[ "FullName" ];
$HostPassword = $password1;
$formoptions = "type=hosting&HostAccount=$HostAccount&email=$email&fullname=$FullName&password=$HostPassword&PackageName=$PackageName&PackageID=$PackageID&BandwidthGB=$BandwidthGB&WebStorageMB=$WebStorageMB&DBStorageMB=$DBStorageMB&POPMailBoxes=$POPMailBoxes&DatabaseType=$DatabaseType&SellPrice=$SellPrice&shop=webhosting";

	$action = $HTTP_POST_VARS[ "action" ];
	$cPW1 = $HTTP_POST_VARS[ "password1" ];
	$cPW2 = $HTTP_POST_VARS[ "password2" ];

if ( $action == "GetHosting" ) {
	$message = NULL  ;

if(empty($_POST['HostAccount'])) {
	$HostAccount = FALSE;
	$message .= '<br>You did not choose a username';
	} else {
	if(strlen($_POST['HostAccount']) < 6){
		$HostAccount = FALSE;
		$message .= '<br>Your username must be 6 characters of more';
	} else {
		if(ereg("^[0-9]{1,}", $_POST['HostAccount'])){
			$HostAccount = FALSE;
			$message .= '<br>Your host account can not start with a number';
		} elseif(!ereg('^[a-zA-Z0-9]{6,14}', $_POST['HostAccount'])){
			$HostAccount = FALSE;
			$message .= '<br>Your Username contains invalid characters.';
			}
	}
}

	if(empty($_POST['password1'])) {
		$HostPassword = FALSE;
		$message .= '<br>You forgot to enter a password';
	} else {
	if($_POST['password1'] == $_POST['password2']) {
		$HostPassword = escape_data($_POST['password1']);
			if(strlen($HostPassword) < 6){
				   $message .= "<br>Your password $HostPassword  must be 6 characters";
				   $HostPassword = FALSE;
				} else {
					if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/", $HostPassword)) {
					  $message .= "<br>Your password does not meet complexity requirements";
					  $HostPassword = FALSE;
					}
				}
	} else {
		$HostPassword = FALSE;
		$message .= '<br>Your passwords do not match';
		}
	}

	if (empty($_POST['HostAccountEmail'])) {
		$email = FALSE;
		$message .= '<br>You Must enter an email address';
	} else {
		if (ereg("[^@]{1,64}@[^@]{1,255}", $_POST['HostAccountEmail'])) {
		$email = $_POST['HostAccountEmail'];
		} else {
		$email = FALSE;
		$message .= '<br>Your email address is not valid';
		}
	}

	if(empty($_POST['FullName'])) {
		$FullName = FALSE;
		$message .= '<br>Please enter your full name';
	} else {
		$FullName = $_POST['FullName'];
		}

	if( $HostAccountEmail && $HostPassword && $FullName && $HostAccount){
			$query = "SELECT * FROM webhosting WHERE host_username='$HostAccount'";
			$result = @mysql_query ($query);
				if(($bError == 0)||(mysql_num_rows($result) == 0)){
					header ("Location:  $site_url/addtocart.php?$formoptions");
					exit(); // Quit the script.
					} else {
					$message .= 'That username is already taken.  Please choose another.';
					}
	}
}
	$page = "webhosting";
	?>
<link rel="stylesheet" href="css/styles.css" type="text/css">

	<table width="964" align="center" valign="center" class="tableO1">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableO1" id="table8">
		<tr>
			<td width="147" height="313" valign="top">
			<table class="tableO1" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>
		    </td>
			<td class="content" align="center" valign="top" width="815">
			<table width="101%" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
			        <table width="526" align="center" height="162" border="0" class="tableO1">
                      <tr>
                        <td height="20" colspan="5"><br>
                            <span class="BasicText">Order Details:</span> <br></td>
                      </tr>
                      <tr>
                        <td width="2" height="20">&nbsp;</td>
                        <td width="149" height="20" class="titlepic"><div align="right"><span class="whiteheader">Package Name: </span></div></td>
                        <td width="137" height="20"><?=$PackageName; ?></td>
                        <td width="119" height="20" class="titlepic"><div align="right"><span class="whiteheader">Disk Storage: </span></div></td>
                        <td width="93" height="20"><?=$WebStorageMB;?>
      (MB)</td>
                      </tr>
                      <tr>
                        <td height="20">&nbsp;</td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Package ID:</span></div></td>
                        <td height="20"><?=$PackageID;?></td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Bandwidth:</span></div></td>
                        <td height="20"><?=$BandwidthGB;?>
      (GB)</td>
                      </tr>
                      <tr>
                        <td height="20">&nbsp;</td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Database Type:</span></div></td>
                        <td height="20"><?=$DatabaseType;?></td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Pop Boxes: </span></div></td>
                        <td height="20"><?=$POPMailBoxes;?></td>
                      </tr>
                      <tr>
                        <td height="20">&nbsp;</td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Database Storage: </span></div></td>
                        <td height="20"><?=$DBStorageMB;?></td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Monthly Cost: </span></div></td>
                        <td height="20" color="red"><?=$SellPrice;?></td>
                      </tr>
                      <tr>
                        <td height="20" colspan="5">&nbsp;</td>
                      </tr>
                    </table>			        <p align="center"><br><tr>
                      <td class="table00" width="403" align="center">
						<?php
							if(isset($message)) {echo "<center><strong class=\"blue\"> $message </strong></center>";}
					?><br></td>
                      </tr>
					   <form name="form2" method="post" action="<?php echo "orderhosting.php?PackageName=$PackageName&PackageID=$PackageID&BandwidthGB=$BandwidthGB&WebStorageMB=$WebStorageMB&DBStorageMB=$DBStorageMB&POPMailBoxes=$POPMailBoxes&DatabaseType=$DatabaseType&SellPrice=$SellPrice&email=$email&HostAccount=$HostAccount&fullname=$fullname&HostPassword=$HostPassword&orderid=$orderid&pw=$cPW1";?>">
                            <input type="hidden" name="action" value="GetHosting">
 <tr><br>

                      <table width="648" height="130" border="0" align="center" class="tableO1" id="table14">
                          <tr>
                            <td colspan="3" align="center"><div align="left" class="BasicText">Step 1: Create a name and password for this web hosting account: </div></td>
                          </tr>
                          <tr>
                            <td width="13" rowspan="2" align="center">&nbsp;</td>
                            <td rowspan="3" align="center"><strong>You will use this to login to your Hosting Control Panel. </strong> This will also be the name of your root directory and SQL database (if applicable) <strong>6-14 alphanumeric characters for name and password - No spaces or symbols. The first character of the Host Account Name cannot be a number.  <br>Password must contain at least 1 uppercase letter and 1 number.</strong></td>
                            <td width="232" height="38" align="center"><strong>Hosting Account Name </strong>
                                    <input name="HostAccount" type="text" maxlength="13"  value="<?php if(isset($_POST['HostAccount'])) echo $_POST['HostAccount']; ?>" >
                                    <strong><br>
                                </strong> </td>
                          </tr>
                          <tr>
                            <td height="38" align="center"><strong>Password</strong> <br>
                                <input name="password1" type="password" maxlength="13"></td>
                          </tr>
                          <tr>
                            <td align="center">&nbsp;</td>
                            <td align="center"><strong>Confirm Password</strong>
                                <br>
                                <input name="password2" type="password" maxlength="14"></td>
                          </tr>
                        </table>

                      <br>
			<table width="648" height="55" border="0" align="center" class="tableO1" id="table15">
                          <tr>
                            <td colspan="2" align="center"><div align="left" class="BasicText">Step
								2: Personal Information: <br>This is the in
							  formation that we will use to attempt to contact you with in regards to this hosting account.</div></td>
                          </tr>
                          <tr>
                            <td height="24" align="center" width="223">
							<p align="right"><strong>Your Full Name</strong> :</td>
                            <td height="24" align="center" width="411">
                                <input name="FullName" maxlength="35" style="float: left" size="35" value="<?php if(isset($_POST['FullName'])) echo $_POST['FullName']; ?>" ></td>
                          </tr>
                          <tr>
                            <td align="center" width="223">
							<p align="right"><strong>Email address:</strong> </td>
                            <td align="center" width="411">
                                <input name="HostAccountEmail" maxlength="35" style="float: left" size="35"value="<?php if(isset($_POST['HostAccountEmail'])) echo $_POST['HostAccountEmail']; ?>" ></td>
                          </tr>
                        </table>

 <br> <table width="648" border="0" align="center" id="table16" class="tableO1">
                          <tr>
                            <td colspan="2"> <div align="center">By Clicking submit you are stating that you have read the terms and agreements and acceptable use policy found here:
<a href="help/hosting_agreement.php" target="_blank" style="font-weight: bold" onclick="window.open(&quot;help/hosting_agreement.php&quot;,&quot;&quot;,&quot;width=500,height=500,status=no,scrollbars=1,resizable=1&quot;);return false;"><b>"Web Site Hosting Agreement"</b></a></p></td>and that even if you have not read them, you still agree to abide by its terms. Failure to abide or comply with the terms and conditions or acceptable use policy will result in cancellation of your hosting account with no refund.</div></td>
                          </tr>
                          <tr class="OutlineOne">
                            <td  width="50%" align="right">
                                <input name="image" type="image" src="images/btn_submit.gif" border="0">
                              </div></td>
                            <td width="50%" align="left"><a href="index.php"><img src="images/btn_cancel.gif" border="0"></a></td>
                            </form>
			</table>                    </p>
			      <tr>
	              <td colspan="3" valign="top" class="content2">
              </table>
</table>

		          <?php include('include/footer.php');?>