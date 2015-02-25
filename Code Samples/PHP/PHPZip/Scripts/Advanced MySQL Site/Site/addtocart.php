<?php # // This page adds prints to the shopping cart.
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

$target = $_GET["target"];
$Domain = $_GET["Domain"];
$sld = $_GET["sld"];
$tld = $_GET["tld"];
$prodid = $_GET["prodid"];
$numyears = $_GET["numyears"];
$command = $_GET["command"];
$referer = $_GET["referer"];
$type = $_GET["type"];

$shop = $_GET['shop'];
			$formoptions = "shop=$shop";

if (!isset($_COOKIE['loggedin_user'])) {
	if($referer == "check"){
		header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=addtocart&command=addtocart&Domain=$Domain&prodid=$prodid&numyears=$numyears&referer=$referer");
		exit(); // Quit the script.
		} else {
		header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=addtocart&sld=$sld&tld=$tld&Domain=$Domain&command=$command&prodid=$prodid&numyears=$numyears");
		exit(); // Quit the script.
		}
}
include('include/dbconfig.php');
include('include/EnomInterface_inc.php');

$sitename = urlencode($sitename);

$qstring = "site=$sitename&enduserip=$enduserip&User_Name=$username&User_Id=$user_id&";

$Domain = $_GET["Domain"];
if($Domain != ''){
$Domain = $_GET["Domain"];
} else {
$Domain = "$sld.$tld";
}
		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "command", "ParseDomain" );
		$Enom->AddParam( "PassedDomain", $Domain );
		$Enom->DoTransaction();
			$sld = $Enom->Values[ "SLD" ];
			$tld = $Enom->Values[ "TLD" ];

if ($qty =='') { $qty = 1; }



	if($prodid == "1"){
		$item = "register_price";
		$action = "Purchase";
			if(($tld == "us") || ($tld == "co.uk") || ($tld == "org.uk") || ($tld == "ca")){
				$preconfig = 0;
				} else {
				$preconfig = 2;
				}

			$getyears = "SELECT min_years from tld_config WHERE tld='$tld'";
			$qty2 = mysql_query($getyears);
			$qty = mysql_result($qty2,0);

		//Enter the Qstring values for the registrant data -> Account holder
			$get_data = "SELECT * FROM users WHERE id='$user_id'";
			$data = @mysql_query($get_data);
			$row = mysql_fetch_array($data, MYSQL_ASSOC);

			$fname = urlencode($row[fname]);
			$lname = urlencode($row[lname]);
			$email = urlencode($row[email]);
			$add1 = urlencode($row[add1]);
			$add2 = urlencode($row[add2]);
			$city = urlencode($row[city]);
			$country = urlencode($row[country]);
			$zip = urlencode($row[zip]);
			$fax = urlencode($row[fax]);
			$phone = urlencode($row[phone]);
			$rspchoice = urlencode($row[rspchoice]);
			$countrycode = urlencode($row[countrycode]);
				$reg_phone = urlencode('+'.$countrycode.'.'.$phone);
				$reg_fax = urlencode('+'.$countrycode.'.'.$fax);
					if($rspchoice == 'S'){
					$state = urlencode($row[state]);
					}
					elseif($rspchoice == 'P'){
					$state = urlencode($row[province]);
					}
			$state = trim($state);
			$dns = '1';
		$qstring .=  "sld=$sld&tld=$tld&command=Purchase&numyears=$qty&usedns=default&RegistrantEmailAddress=$email&RegistrantPhone=$reg_phone&RegistrantCountry=$country&RegistrantPostalCode=$zip&RegistrantStateProvinceChoice=$rspchoice&RegistrantStateProvince=$state&RegistrantCity=$city&RegistrantAddress2=$add2&RegistrantAddress1=$add1&RegistrantLastName=$lname&RegistrantFirstName=$fname";
		$extra3 = NULL;
		$dns = 1;
		}
	if($prodid == "2"){
		$item = "renew_price";
		$action = "Extend";
		$getyears = "SELECT min_years from tld_config WHERE tld='$tld'";
		$gotyears = mysql_query($getyears);
		$qty = mysql_result($gotyears,0);
		$qstring .= "sld=$sld&tld=$tld&command=Extend&numyears=$qty&OverrideOrder=1";
		$preconfig = 2;
		$extra3 = NULL;
		}
	if($prodid == "3"){
		$item = "transfer_price";
		$action = "TP_CreateOrder";
		$lock = $_GET["lock"];
		$contacts = $_GET["contacts"];
		$renew  = $_GET["renew"];
		$authkey = $_GET["authkey"];
		$preconfig = 2;
		$extra3 = $_GET["OrderType"];
		$DomainCount = 1; //Update to multiple in future releases
		$qstring .=  "OrderType=$extra3&DomainCount=$DomainCount&sld1=$sld&tld1=$tld&command=TP_CreateOrder&contacts=$contacts&renew=$renew&lock=$lock&AuthInfo1=$authkey";
	}
	if($prodid == "4"){
		$action = "PurchaseServices";
		$qstring .=  "sld=$sld&tld=$tld&command=$action&Service=IDProtect";
		$preconfig = 2;
		$extra3 = NULL;
		$qty = 1;
		}
	if($prodid == "5"){
		$action = "PurchasePOPBundle";
		$qstring .=  "sld=$sld&tld=$tld&command=$action&quantity=1";
		$preconfig = 2;
		$extra3 = NULL;
		$qty = 1;
		}
	if($prodid == "6"){
		$action = "PurchaseServices";
		$qstring .=  "sld=$sld&tld=$tld&command=$action&Service=URLForwarding";
		$preconfig = 2;
		$extra3 = NULL;
		$qty = 1;
		}
	if($prodid == "8"){
		$action = "PurchaseServices";
		$qstring .=  "sld=$sld&tld=$tld&command=$action&Service=EmailForwarding";
		$preconfig = 2;
		$extra3 = NULL;
		$qty = 1;
		}
	if(($prodid == "11")||($type == "hosting")){
		$preconfig = 2;
		$PackageID  = $_GET[ "PackageID" ];
		$PackageName = $_GET[ "PackageName" ];
		$BandwidthGB = $_GET[ "BandwidthGB" ];
		$WebStorageMB = $_GET[ "WebStorageMB" ];
		$DatabaseType = $_GET[ "DatabaseType" ];
		$POPMailBoxes = $_GET[ "POPMailBoxes" ];
		$DBStorageMB = $_GET[ "DBStorageMB" ];
		$SellPrice = $_GET[ "SellPrice" ];
		$HostAccount = $_GET[ "HostAccount" ];
		$email = $_GET["email"];
		$FullName = $_GET[ "fullname" ];
		$HostPassword = $_GET["password"];
		$SLD = $_GET[ "sld" ];
		$TLD = $_GET[ "tld" ];
		$command = "CreateHostAccount";
		$Qemail = urlencode($email);
		$QFullName = urlencode($FullName);
		$QDatabaseType = urlencode($DatabaseType);
		$QSellPrice = urlencode($SellPrice);
		$qstring .= "command=$command&HostAccount=$HostAccount&HostAccountEmail=$Qemail&FullName=$QFullName&sld=$SLD&tld=$TLD&HostPassword=$HostPassword&Package=$PackageName&PackageID=$PackageID&BandwidthGB=$BandwidthGB&WebStorageMB=$WebStorageMB&DBStorageMB=$DBStorageMB&POPMailBoxes=$POPMailBoxes&DatabaseType=$QDatabaseType&SellPrice=$QSellPrice&OverageOption=1&EmailNotify=1";
				$query = "INSERT INTO cart (user_id,  cartsld,  carttld, prodid, price, qty, extra1, extra2, extra3, extra4, full_name, email_addy, p_name, host_pass)
				VALUES ('$user_id', 'NULL', 'NULL', '11', '$SellPrice', '1', '$command', '$qstring', '$PackageID', '$HostAccount', '$FullName', '$email', '$PackageName', '$HostPassword')";
			$result = @mysql_query ($query);
			if($result){
			header ("Location:  $site_url/view_cart.php?$formoptions");
			}
		}
	if($prodid == "12"){
		$action = "PurchaseHosting";
		$preconfig = 2;
		$extra3 = NULL;
		$qty = 1;
		$dns = 1;
		$qstring .=  "sld=$sld&tld=$tld&command=$action&numyears=$qty";
		}
	if($prodid == "13"){
		$action = "Extend_RGP";
		$preconfig = 2;
		$extra3 = NULL;
		$qty = 1;
		$dns = 1;
		$qstring .=  "sld=$sld&tld=$tld&command=$action&numyears=$qty";
		}
	if($prodid == "14"){
		$action = "PurchaseHosting";
		$preconfig = 2;
		$extra3 = NULL;
		$qty = 1;
		$dns = 1;
		$qstring .=  "sld=$sld&tld=$tld&command=$action&numyears=$qty";
		}




if($command == "addtocart"){
$query = "SELECT * FROM products where prodid='$prodid'";
$result = @mysql_query ($query);
$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$prodid = $row[prodid];
	$product_name = $row[product_name];
if(($prodid == 1) or ($prodid == 2) or ($prodid == 3) ){
			$query1 = "SELECT $item FROM tld_config where tld='$tld'";
			$result1 = @mysql_query ($query1);
			$row1 = mysql_fetch_array($result1, MYSQL_ASSOC);
			$price = $row1[$item];
	} else {
			$query2 = "SELECT price FROM product_pricing where prodid='$prodid'";
			$result2 = @mysql_query ($query2);
			$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
			$price = ($row2[price] * $qty);
	}
$query = "SELECT * FROM cart WHERE cartsld='$sld' AND carttld='$tld' AND prodid='$prodid' AND user_id='$user_id'";
$result = @mysql_query ($query);
if(mysql_num_rows($result) == 0){
			$query1 = "INSERT INTO cart (user_id,  cartsld,  carttld, prodid, price, qty, preconfig, extra1, extra2, extra3, dns)
			VALUES ('$user_id', '$sld', '$tld', '$prodid', '$price', '$qty', '$preconfig', '$action', '$qstring', '$extra3', '$dns')";
			$result1 = @mysql_query ($query1);
				if($result1){
			header ("Location:  $site_url/view_cart.php?$formoptions");
				exit;
				}
		} else {
			header ("Location:  $site_url/view_cart.php?$formoptions");
				exit;
		}
}
	$page_title = 'Add to Cart';
?>