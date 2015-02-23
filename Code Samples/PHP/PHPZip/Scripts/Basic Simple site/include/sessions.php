<?php
	session_start();
#############################################################
#		 Register interface username and password vars		#
	$_SESSION['username'] = 'resellerdemo'; //Your Enom Username
	$_SESSION['password'] = 'resellerdemo'; //enter you password
	$_SESSION['SiteTitle'] = 'Name of my Site'; //enter your site title

	$domain = "enomapi.net"; //No trailing slash at the end
	$site_domain = "enomapi.net"; //Just the name of your site with no WWW or trailing slash
	$site_url = "http://enomapi.net"; //No trailing slash at the end
	$secure_site_url = "https://enomapi.net"; //No trailing slash at the end
	$time = date("m-d-y") .' at '. date("H:i", time()); //Set your time format to use
	$CompanyName = 'eNomiTron';
	$SiteTitle = "eNom's Enomitron Sample PHP API Site";

	$UseSSL = 1;  //Set to 1 to use SSL to connect to enom - use 0 for none
	$Server = 1;  // 1 for testing, 0 forlive (case sensative);

	$UseEmail = 1;
	$UseCreditCard = 1; // Set to 0 to disable Enom's CC processing
	$usepaypal = 1; //Set to 0 to disable Paypal

	#############################################################
	#					paypal Specific Info					#
	#############################################################
	$paypal_id="email@email.com";
	$ppmethod = "curl";//fso=fsockopen(); curl=curl command line libCurl - php compiled with libCurl support
	$curl_path = "/usr/local/bin/curl";
	$currency = 'USD'; //USD,GBP,JPY,CAD,EUR
	$paypal_return = '2'; //1=GET 2=POST
	$PaypalAuthKey = 'madeuppassword';//This is a password that you make up that is only used in this script.  PLEASE DO NOT use your paypal password

	#############################################################
	#			Email Confirmation Settings						#
	#############################################################
	$YourEmailAddress = 'email@email.com';//Email address you want the mail to go to
	$Yourname = 'Email'; //Who the email is sent from - this is a name not an email
	$MailUsername = 'email@email.com';//Email address you are using to send the email
	$MailPassword = 'password'; //This is the password of the emali account used to send the emali
	$MailServer = 'mail server ';//Assigned mail server
	$MailType = "HTML"; // Can use HTML or TEXT -case doesnt matter
	$myURL = "www.enomapi.net";

	#############################################################
	#					Product Pricing							#
	#############################################################
	$idprice = '8.00'; // Price to charge for ID Protect - do not put the $
	
	#############################################################	
	#					TLD Pricing								#
	#############################################################	
						$comprice = '19.95';
						$netprice = '19.95';
						$orgprice = '19.95';
						$usprice = '19.95';
						$infoprice = '19.95';
						$bizprice = '19.95';
						$nameprice = '19.95';
						$caprice = '19.95';
						$ukprice = '19.95';
						$tvprice = '19.95';
						$wsprice = '19.95';
						$bzprice = '19.95';
						$nuprice = '19.95';
						$cnprice = '19.95';
						$ccprice = '19.95';
						$uscomprice = '19.95';
						$eucomprice = '19.95';
						$inprice = '19.95';
						$jpprice = '19.95';
						$msprice = '19.95';
						$gsprice = '19.95';
						$tcprice = '19.95';
						$vgprice = '19.95';
						$othertld = '19.95';//Any TLD not listed above will get this price

	#############################################################	
	#				DNS Hosting Pricing							#
	#############################################################	
						$compricedns = '10.95';
						$netpricedns = '10.95';
						$orgpricedns = '10.95';
						$uspricedns = '10.95';
						$infopricedns = '10.95';
						$bizpricedns = '10.95';
						$namepricedns = '10.95';
						$capricedns = '10.95';
						$ukpricedns = '10.95';
						$tvpricedns = '10.95';
						$wspricedns = '10.95';
						$bzpricedns = '10.95';
						$nupricedns = '10.95';
						$cnpricedns = '10.95';
						$ccpricedns = '10.95';
						$uscompricedns = '10.95';
						$eucompricedns = '10.95';
						$inpricedns = '10.95';
						$jppricedns = '10.95';
						$mspricedns = '10.95';
						$gspricedns = '10.95';
						$tcpricedns = '10.95';
						$vgpricedns = '10.95';
						$othertlddns = '10.95'; //Any TLD not listed above will get this price

#####################  DO NOT EDIT BELOW THIS LINE #################
	$_SESSION['enduserip'] = $REMOTE_ADDR; //DO NOT EDIT
	$enduserip = $_SESSION['enduserip'];//DO NOT EDIT
	$username = $_SESSION['username'];//DO NOT EDIT
	$password = $_SESSION['password'];//DO NOT EDIT
	
	if(strtolower($MailType) == 'html'){
		$mailtypetosend = true;
	} else {
		$mailtypetosend = false;
	}

			switch ($tld) {
			
				case "com": 
					$ChargeAmount =  $comprice ;
					$numyears = 1;
					break;
				case "net": 
					$ChargeAmount =  $netprice ;
					$numyears = 1;
					break;
				case "org": 
					$ChargeAmount =  $orgprice ;
					$numyears = 1;
					break;
				case  "biz":
					$ChargeAmount =  $bizprice ;
					$numyears = 1;
					break;
				case  "us":
					$ChargeAmount =  $usprice ;
					$numyears = 1;
					break;
				case  "info":
					$ChargeAmount =  $infoprice ;
					$numyears = 1;
					break;
				case "ca": 
					$ChargeAmount =  $caprice ;
					$numyears = 1;
					break;
				case "cc": 
					$ChargeAmount =  $ccprice ;
					$numyears = 1;
					break;
				case  "bz":
					$ChargeAmount =  $bzprice ;
					$numyears = 1;
					break;
				case  "nu":
					$ChargeAmount =  $nuprice ;
					$numyears = 1;
					break;
				case  "co.uk":
					$ChargeAmount =  $ukprice ;
					$numyears = 2;
					break;
				case  "org.uk":
					$ChargeAmount =  $ukprice ;
					$numyears = 2;
					break;
				case  "tv":
					$ChargeAmount =  $tvprice ;
					$numyears = 1;
					break;
				case  "ws":
					$ChargeAmount =  $wsprice;
					$numyears = 1;
					break;
				case  "in":
					$ChargeAmount =  $inprice ;
					$numyears = 1;
					break;
				case  "jp":
					$ChargeAmount =  $jpprice ;
					$numyears = 1;
					break;
				case  "tc":
					$ChargeAmount =  $tcprice ;
					$numyears = 1;
					break;
				case  "vg":
					$ChargeAmount =  $vgprice ;
					$numyears = 1;
					break;
				case  "ms":
					$ChargeAmount =  $msprice ;
					$numyears = 1;
					break;
				case  "gs":
					$ChargeAmount =  $gsprice ;
					$numyears = 1;
					break;
				case  "name":
					$ChargeAmount =  $nameprice ;
					$numyears = 1;
					break;
				case  "us.com":
					$ChargeAmount =  $uscomprice ;
					$numyears = 2;
					break;
				case  "eu.com":
					$ChargeAmount =  $eucomprice ;
					$numyears = 2;
					break;
				default: 
					$ChargeAmount =  $othertld ;
					$numyears = 1;
					break;
				}
		$price = ($ChargeAmount * $numyears)
?>