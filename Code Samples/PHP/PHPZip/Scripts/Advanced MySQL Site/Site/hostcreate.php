<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=hostcreate");
	exit(); // Quit the script.
} else {

	include('include/dbconfig.php');

$PackageID  = $_GET[ "PackageID" ];
$PackageName = $_GET[ "PackageName" ];
$BandwidthGB = $_GET[ "BandwidthGB" ];
$WebStorageMB = $_GET[ "WebStorageMB" ];
$DatabaseType = $_GET[ "DatabaseType" ];
$POPMailBoxes = $_GET[ "POPMailBoxes" ];
$DBStorageMB = $_GET[ "DBStorageMB" ];
$SellPrice = $_GET[ "SellPrice" ];
$HostAccount = $_GET[ "HostAccount" ];
$HostPassword = $_GET[ "HostPassword" ];
$email = $_GET["email"];
$FullName = $_GET[ "FullName" ];
$SLD = $_GET[ "SLD" ];
$TLD = $_GET[ "TLD" ];
$orderid = $_GET["orderid"];
$password = $_GET["$cPW1"];
if ($sld == ''){
$sld = 'No Domain chosen';
$tld = '';
}

if ($DatabaseType == 'Database'){
$DbType = '0';
}
if ($DatabaseType == 'SQL Server'){
$DbType = '1';
}

$query = "SELECT * FROM webhosting WHERE host_username='$HostAccount'";
		$result = @mysql_query ($query);
		if(mysql_num_rows($result) == 0){

$query = "SELECT prodid from products where product_name='Web Hosting'";
$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
		$product_id = $row[0];
		}
//Update the database with the hosting information
$query = "INSERT INTO webhosting (user_id, username , host_username, host_password, full_name, email, package_name, package_id,  product_id, db_type, db_storage, pop_boxes, disk_storage, bandwidth, date, order_id, price, status)
		VALUES ('$user_id', '$username', '$HostAccount', '$HostPassword', '$FullName', '$email', '$PackageName', '$PackageID', '$product_id', '$DbType', '$DBStorageMB', '$POPMailBoxes', '$WebStorageMB', '$BandwidthGB', NOW(), '$orderid', '$SellPrice', '1')";
	//Run the query
	$result = @mysql_query ($query);
	} else {
	mysql_close();
	}
	//Close the database connection as its no longer needed at this point
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Congratulations!</span><b>                                 </b></td>
			    </tr>
				<tr>
	                </p>
		      <tr>
<td colspan="3" valign="top" class="content2"><table width="709" border="0">
                      <tr>
                        <td><br>
                          <span class="BasicText"><strong>Your Hosting account has been successfully Created with the following information: </strong></span></td>
              </tr>
                    </table>			        
<p align="center"><table width="513" border="0" style="table00" align="center">
                      <tr>
                        <td height="20" colspan="5"><br>
                            <span class="BasicText"><strong>Order Details:</strong></span> <br></td>
                      </tr>
                      <tr>
                        <td width="167" height="20" class="titlepic"><div align="right"><span class="whiteheader">Package Name:</span></div></td>
                        <td width="122" height="20"><?=$PackageName; ?></td>
                        <td width="134" height="20" class="titlepic"><div align="right"><span class="whiteheader">Disk Storage: </span></div></td>
                        <td width="93" height="20"><?=$WebStorageMB;?>
      (MB)</td>
                      </tr>
                      <tr>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Package ID:</span></div></td>
                        <td height="20"><?=$PackageID;?></td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Bandwidth:</span></div></td>
                        <td height="20"><?=$BandwidthGB;?>
      (GB)</td>
                      </tr>
                      <tr>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Database Storage:</span></div></td>
                        <td height="20"><?=$DBStorageMB;?></td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Pop Boxes: </span></div></td>
                        <td height="20"><?=$POPMailBoxes;?></td>
                      </tr>
                      <tr>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Database Type : </span></div></td>
                        <td height="20">                        <?=$DatabaseType;?></td>
                        <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Monthly Cost: </span></div></td>
                        <td height="20" color="red"><?=$SellPrice;?></td>
                      </tr>
                    </table>
<br>
<table width="728" style="table00" align="center">
  <tr>
    <td height="20" colspan="5"><br>
        <span class="BasicText"><strong>Account Details:</strong></span> <br></td>
  </tr>
  <tr>
    <td width="174" height="20" class="titlepic"><div align="right"><span class="whiteheader">Full Name:</span></div></td>
    <td width="220" height="20"><?=$FullName; ?></td>
    <td width="140" height="20" class="titlepic"><div align="right"><span class="whiteheader">Domain Name: </span></div></td>
    <td width="174" height="20"><?="$sld.$tld";?>      </td>
  </tr>
  <tr>
    <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Account Username :</span></div></td>
    <td height="20"><?=$HostAccount;?></td>
    <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Order ID # : </span></div></td>
    <td height="20" color="red"><?=$OrderID;?></td>
  </tr>
  <tr>
    <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Account Password:</span></div></td>
    <td height="20"><?=$HostPassword;?></td>
    <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Date: </span></div></td>
    <td height="20"><?php echo date("l dS of F Y h:i:s A");?></td>
  </tr>
  <tr>
    <td height="20" class="titlepic"><div align="right"><span class="whiteheader">Email Address : </span></div></td>
    <td height="20"><?=$email;?></td>
  </tr>
</table>
<tr>

            </table>
            <p><span class="BasicText"><em><strong>Please save and or print this page for your records</strong></em></span>                       <br>
                </p>
            <p><a href="myhosting.php" class="BasicText"><strong>Mange My Hosting accounts</strong></a> </p>
		  </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>