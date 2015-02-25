<?php
#----------------------------DO NOT DELETE ANYTHING ONLY EDIT!!!!----------------------------#
$EditedFile = 0; //Change to 1 to signify you have edited this file
$testmode = 1;  //Set to 0 to go live

#DB And sever config
$dbhost=""; //database location
$dbusername=""; //database username
$dbpassword=""; //database password
$dbdatabase=""; //database name
$workdir="/home/enomapi/www/"; //full path to the script, WITH trailing slash
$dictionarylocation = '/usr/share/dict/words'; //Location of the dictionary on your system

# Random Other stuff
$register_link = 1; //Gives you the option of placing a "register now" link next to names that dont have a whios record
$Log = 1; // 1 = logging enabled, 0 is disabled
$displayInsOn = 1; // Display instructions on the HOSTS page - 1 for yes, 0 for no

#payent section
$invoice_start = 500;
$currency = 'USD'; //USD,GBP,JPY,CAD,EUR 

	#Paypal section
	$UsePaypal = 1; //Set this to 0 to disable paypal payments
	$paypal_id="";
	$ppmethod = "curl";
	$curl_path = "/usr/local/bin/curl";
	$PaypalAuthKey = 'FromPayPal';  # Enter a Password to use only for your site so you 
									# know your payment came from paypal and not a spoofer
									# YOU MUST CHANGE THIS VALUE IF YOU WANT TO USE PAYPAL

	#Credit card info
	$UseCreditCard = 1;// Set to 0 to disable Credit Card payments
	$CCMerchantChoice = 1; // SET TO 1 FOR AUTH.NET OR 2 FOR WORLDPAY
		#Uncomment the section for your processor and change the variables
			#1 - Authorize.Net
				$authnetlogin = ''; //
				$transactionkey = ''; //
				$md5hash = '';//
			#2 - # WorldPay #THIS REQUIRES YOU TO HAVE AN INVISIBLE WORLD PAY INSTALL FOR THIS TO WORK
				 # SEE WORLDPAY SUPPORT FOR INFO ON HOW TO GET AN INVISIBLE INSTALLATION
				 $instId = ''; //Worldpay ID for this installation  
				 $companyid = ''; //Worldpay ID for this installation 
				 $authPW = ''; //Invisible Password : Set this to the same thing as in your world pay account

#Enom Specicif Info here:
$enom_username = "username";
$enom_password = "password";

#Set the basic site info here:
$domain = "yoursite.com"; //No trailing slash at the end
$site_domain = "yoursite.com"; //Just the name of your site with no WWW or trailing slash
$site_url = "http://yoursite.com"; //No trailing slash at the end
$secure_site_url = "http://yoursite.com"; //No trailing slash at the end
$time = date("m-d-y") .' at '. date("H:i", time()); //Set your time format to use
$CompanyName = 'eNomiTron';
$SiteTitle = "eNom's Enomitron Sample PHP API Site";
$support_phone = '425-274-4500 x3'; //Enter in the support phone number - leave blank for none.
$sales_phone = '425-274-4500 x2'; //Enter in the support phone number - leave blank for none.
$general_phone = '425-274-4500 x1'; //Enter in the support phone number - leave blank for none.

//EMAIL Options
$info_email = "email@email.com"; //Info box email
$support_email = "email@email.com"; //Email address of support
$admin_email = "email@email.com" ;//Email address of the admin contact for the site
$sales_email = "email@email.com";//Email address of Sales
$email_sent_from = "email@email.com";//Email address used to send the emails from
$email_frominfo = "$CompanyName Info";  //
$email_fromadmin="$CompanyName Administrator"; //do not use an email address here, this is FROM NAME
$email_fromsales="$CompanyName Sales"; //do not use an email address here, this is FROM NAME
$email_fromsupport="$CompanyName Support"; //do not use an email address here, this is FROM NAME
$mail_charset="charset=iso-8859-1"; //email character set

#----------------------------DO NOT EDIT BELOW THIS LINE----------------------------#
$dbc = @mysql_connect ($dbhost, $dbusername, $dbpassword) or die('Counld not connect to Mysql Server:' . mysql_error());
mysql_select_db ($dbdatabase) or die('Could not connect to the database:' . mysql_error());
$enduserip = $REMOTE_ADDR;
$sitename = 'eNomiTron';
?>