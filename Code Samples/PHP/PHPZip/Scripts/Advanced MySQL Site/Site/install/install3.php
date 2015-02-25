<?php
session_name ('API-PHPSESSID-INSTALL');
session_start(); // Start the session.

require("../include/dbconfig.php");

$StepNumber = $_SESSION['StepNumber'];

if ($StepNumber != 3){
	header ("Location:  $site_url/install/install$StepNumber.php");
	exit(); // Quit the script.
}

?>
<link rel="stylesheet" href="../css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('../include/header.php')?>
	    </tr>
</table>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td height="313" valign="top">
			  <table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">Welcome to the Enom API Installer script - Installation - Step
                        <?=$StepNumber;?>
				  </span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">
			        <p>&nbsp;</p>

<?php
if($StepNumber == 3){
				echo '<table width="820" align="center" border="0">
                      <tr>
                        <td width="810">Creating Database Tables and Importing data.  Please be patient, this could take a minute or two.</td>
                      </tr>
                      <tr>
                        <td width="810">Creating database structure . . . . . ';
$sql =
"CREATE TABLE `cart` (
`user_id` int( 16 ) NOT NULL default '0',
`cart_id` int( 16 ) NOT NULL AUTO_INCREMENT ,
`cartsld` varchar( 255 ) default '0',
`carttld` varchar( 16 ) default '0',
`prodid` int( 16 ) NOT NULL default '0',
`price` float( 10, 2 ) NOT NULL default '0.00',
`qty` int( 2 ) NOT NULL default '0',
`preconfig` smallint( 1 ) default NULL ,
`extra1` varchar( 255 ) default NULL ,
`extra2` longtext,
`extra3` varchar( 255 ) default NULL ,
`extra4` varchar( 255 ) default NULL ,
`dns` int( 1 ) default NULL ,
`full_name` varchar( 255 ) default NULL ,
`email_addy` varchar( 255 ) default NULL ,
`p_name` varchar( 255 ) NOT NULL default '',
`host_pass` varchar( 50 ) default NULL ,
PRIMARY KEY ( `cart_id` ) ,
KEY `cart_id` ( `cart_id` )
) TYPE = MYISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create Cart table Failed  "; }

$sql =
"CREATE TABLE `check_log` (
  `id` int(8) NOT NULL auto_increment,
  `username` varchar(16) NOT NULL default '',
  `date` varchar(25) NOT NULL default '',
  `ip` varchar(25) NOT NULL default '',
  `sld` varchar(255) NOT NULL default '',
  `tld` varchar(8) NOT NULL default '',
  `was_error` int(2) NOT NULL default '0',
  `error_msg` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create Check_log table Failed  "; }
$sql =
"CREATE TABLE `contact` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `message` mediumtext NOT NULL,
  `answered` int(1) NOT NULL default '0',
  `date` varchar(50) NOT NULL default '',
  `response` mediumtext,
  `response_date` varchar(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create Contact table Failed  "; }

$sql = "
CREATE TABLE `customer_invoice` (
  `id` int(16) unsigned NOT NULL auto_increment,
  `user_id` int(16) NOT NULL default '0',
  `username` varchar(16) NOT NULL default '',
  `invoice_id` int(10) NOT NULL default '0',
  `paid` int(2) NOT NULL default '0',
  `paid_by` int(1) NOT NULL default '0',
  `cc_transId` varchar(40) default NULL,
  `status` varchar(50) NOT NULL default '',
  `amount_due` decimal(10,2) NOT NULL default '0.00',
  `date` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create Customer invoice table Failed  "; }
$sql = "
CREATE TABLE `domain_addons` (
  `id` int(64) unsigned NOT NULL auto_increment,
  `user_id` int(16) NOT NULL default '0',
  `e_domain_id` int(16) NOT NULL default '0',
  `prodid` int(3) NOT NULL default '0',
  `order_date` date NOT NULL default '0000-00-00',
  `renew_date` date NOT NULL default '0000-00-00',
  `last_renew` date NOT NULL default '0000-00-00',
  `bundleid` int(12) default NULL,
  `num_bundle` int(2) default '0',
  `extra` varchar(255) default NULL,
  `orderid` int(16) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create Domain_addons table Failed  "; }

$sql = "
CREATE TABLE `domains` (
  `user_id` int(8) NOT NULL default '0',
  `domain_id` int(15) NOT NULL auto_increment,
  `e_domain_id` varchar(55) NOT NULL default '',
  `sld` varchar(80) NOT NULL default '',
  `tld` varchar(8) NOT NULL default '',
  `exp_date` date NOT NULL default '0000-00-00',
  `order_date` date NOT NULL default '0000-00-00',
  `dns` int(2) NOT NULL default '0',
  `mail` int(4) NOT NULL default '0',
  `webhosted` int(2) NOT NULL default '0',
  `status` int(2) NOT NULL default '0',
  `pop` int(2) NOT NULL default '0',
  `idprotect` int(1) NOT NULL default '0',
  `auto_renew` int(1) NOT NULL default '0',
  `reg_lock` int(1) NOT NULL default '0',
  `tv` int(1) NOT NULL default '0',
  `parking` int(1) NOT NULL default '0',
  `name_phone` int(1) NOT NULL default '0',
  `name_map` int(1) NOT NULL default '0',
  `password` varchar(18) default NULL,
  `lastupdate` varchar(25) NOT NULL default '',
  `e_order_id` varchar(20) default NULL,
  `name_forwarding` int(1) default NULL,
  `name_exp` date default NULL,

  PRIMARY KEY  (`domain_id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create domains table Failed  "; }

$sql = "
CREATE TABLE `extra` (
  `id` char(3) NOT NULL default '',
  `invoice_count` int(16) NOT NULL default '0',
  `installed` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create Extra table Failed  "; }

$sql = "
CREATE TABLE `invoice_items` (
  `table_id` mediumint(50) unsigned NOT NULL auto_increment,
  `user_id` int(16) NOT NULL default '0',
  `invoice_id` int(16) NOT NULL default '0',
  `sld` varchar(101) default NULL,
  `tld` varchar(12) default NULL,
  `prodid` int(2) NOT NULL default '0',
  `status` int(2) NOT NULL default '0',
  `qty` int(2) NOT NULL default '0',
  `price` float(10,2) NOT NULL default '0.00',
  `extra` text,
  `command` varchar(45) NOT NULL default '',
  `host_package` varchar(16) default NULL,
  `host_username` varchar(16) default NULL,
  `host_password` varchar(50) default NULL,
  `full_name` varchar(255) default NULL,
  `email_addy` varchar(255) default NULL,
  `p_name` varchar(255) default NULL,
  `dns` int(1) default NULL,
  `string` longtext,
  `response` longtext NOT NULL,
  PRIMARY KEY  (`table_id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create invoice_items Failed  "; }

$sql = "
CREATE TABLE `news` (
  `id` int(2) NOT NULL auto_increment,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `date` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `body` (`body`),
  FULLTEXT KEY `title` (`title`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create News table Failed  "; }

$sql = "
CREATE TABLE `product_pricing` (
  `prodid` int(3) NOT NULL default '0',
  `price` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`prodid`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create product pricing Failed  "; }

$sql = "
CREATE TABLE `products` (
  `prodid` int(10) unsigned NOT NULL auto_increment,
  `product_name` char(40) NOT NULL default '',
  PRIMARY KEY  (`prodid`),
  KEY `product_name` (`product_name`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create products table Failed  "; }
$sql = "
CREATE TABLE `push_log` (
  `sld` varchar(255) NOT NULL default '',
  `tld` varchar(16) NOT NULL default '',
  `date` varchar(24) NOT NULL default '',
  `IP` varchar(24) NOT NULL default '',
  `from_user` varchar(24) NOT NULL default '',
  `to_user` varchar(24) NOT NULL default '',
  `push_id` int(8) NOT NULL auto_increment,
  `status` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`push_id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create push_log table Failed  "; }

$sql = "
CREATE TABLE `tld_config` (
  `id` int(10) NOT NULL auto_increment,
  `tld` varchar(20) default NULL,
  `register_price` decimal(10,2) NOT NULL default '0.00',
  `transfer_price` decimal(10,2) NOT NULL default '0.00',
  `renew_price` decimal(10,2) NOT NULL default '0.00',
  `min_years` varchar(5) default NULL,
  `max_years` varchar(5) default NULL,
  `whois_server` varchar(255) NOT NULL default '',
  `match_string` varchar(255) NOT NULL default '',
  `lockable` tinyint(1) NOT NULL default '0',
  `wpps` tinyint(1) NOT NULL default '0',
  `epp` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=64";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create tld_config Failed  "; }

$sql = "
CREATE TABLE `transfer_status` (
  `status_id` int(2) NOT NULL default '0',
  `desc` varchar(255) NOT NULL default '',
  `action` int(1) NOT NULL default '0',
  PRIMARY KEY  (`status_id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create transfer_status table  Failed  "; }

$sql = "
CREATE TABLE `transfers` (
  `user_id` int(25) NOT NULL default '0',
  `tran_id` int(15) unsigned NOT NULL auto_increment,
  `order_id` int(16) NOT NULL default '0',
  `order_type` int(16) NOT NULL default '0',
  `order_status` varchar(235) NOT NULL default '',
  `ordertypedesc` varchar(255) NOT NULL default '',
  `statusid` varchar(255) NOT NULL default '',
  `sld` varchar(255) NOT NULL default '',
  `tld` varchar(255) NOT NULL default '',
  `create_date` varchar(255) NOT NULL default '',
  `init_date` varchar(255) default NULL,
  PRIMARY KEY  (`tran_id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create transfers table  Failed  "; }

$sql = "
CREATE TABLE `users` (
  `id` int(8) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(150) default NULL,
  `isadmin` int(1) NOT NULL default '0',
  `fname` varchar(75) default NULL,
  `lname` varchar(75) default NULL,
  `email` varchar(255) default NULL,
  `second_email` varchar(255) default NULL,
  `add1` varchar(100) default NULL,
  `add2` varchar(100) default NULL,
  `city` varchar(50) default NULL,
  `state` varchar(50) default NULL,
  `zip` varchar(15) default NULL,
  `country` varchar(50) default NULL,
  `fax` varchar(15) default NULL,
  `phone` varchar(15) default NULL,
  `date` varchar(25) default NULL,
  `province` varchar(50) default NULL,
  `rspchoice` varchar(5) default NULL,
  `countrycode` varchar(100) default NULL,
  `signup_date` varchar(25) default NULL,
  `last_login` varchar(50) NOT NULL default '',
  `login_IP` varchar(50) NOT NULL default '',
  `lpquestion` varchar(255) default NULL,
  `lpanswer` varchar(255) default NULL,
  `reset_pass` int(1) NOT NULL default '0',
  `billing_cardtype` varchar(20) default NULL,
  `billing_name` varchar(255) default NULL,
  `billing_address` varchar(255) default NULL,
  `billing_stateprovince` varchar(255) default NULL,
  `billing_country` varchar(255) default NULL,
  `billing_zip` varchar(16) default NULL,
  `billing_cc_num` int(16) default NULL,
  `billing_cvv2` int(4) default NULL,
  `billing_exp_month` int(2) default NULL,
  `billing_exp_year` int(4) default NULL,
  `billing_city` varchar(255) default NULL,
  `billing_countrycode` varchar(5) default NULL,
  `billing_phone` varchar(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create users table  Failed  "; }

$sql = "
CREATE TABLE `webhosting` (
  `host_id` int(16) unsigned NOT NULL auto_increment,
  `user_id` int(16) NOT NULL default '0',
  `username` varchar(16) NOT NULL default '0',
  `host_username` varchar(255) NOT NULL default '',
  `host_password` varchar(255) NOT NULL default '',
  `full_name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `package_name` varchar(255) NOT NULL default '',
  `product_id` int(16) NOT NULL default '0',
  `package_id` int(16) NOT NULL default '0',
  `db_type` int(1) NOT NULL default '0',
  `db_storage` varchar(8) NOT NULL default '0',
  `pop_boxes` int(5) NOT NULL default '0',
  `disk_storage` int(8) NOT NULL default '0',
  `bandwidth` int(8) NOT NULL default '0',
  `wsc` int(1) default '0',
  `wsc_option` int(5) default '0',
  `date` varchar(255) NOT NULL default '',
  `order_id` int(16) NOT NULL default '0',
  `price` decimal(10,2) NOT NULL default '0.00',
  `status` int(1) NOT NULL default '0',
  `IP` varchar(40) NOT NULL default '',
  `next_renew` varchar(255) default NULL,
  `last_renew` varchar(255) default NULL,
  `paid_date` varchar(255) default NULL,
  PRIMARY KEY  (`host_id`),
  KEY `order_id` (`order_id`),
  KEY `package_id` (`package_id`),
  KEY `product_id` (`product_id`)
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create webhosting table  Failed  "; }

$sql = "
CREATE TABLE `whois_log` (
  `username` varchar(25) default NULL,
  `date` varchar(25) NOT NULL default '',
  `ip` varchar(25) NOT NULL default '',
  `sld` varchar(255) NOT NULL default '',
  `tld` varchar(255) NOT NULL default ''
) TYPE=MyISAM";
$docart = mysql_query($sql);
if($docart){ echo " . "; } else { echo "  Create whois_log table  Failed  "; }
if($docart){
echo "Done.";
echo '	</td>
                      </tr>

	<tr>
		<td> Importing Data. . .   ';

$ImportData = "INSERT INTO `extra` VALUES ('1', 500, '0')";
$imported = mysql_query($ImportData);
if($imported){ echo " . "; } else { echo "  Could not import data into Extra table  "; }


$ImportData = "
INSERT INTO `news` VALUES (1, 'eNom, Inc., the #1 Reseller Registrar, Launches ClubDrop.com to extend it''s leadership in the domain name registration aftermarket.', 'ClubDrop.com (www.clubdrop.com), from eNom, Inc. (www.enom.com), is a website dedicated to Club Drop, an aftermarket auction system that registers expiring domain names as soon as they become available again. Every day thousands of domains expire and become available for purchase because the prior registrant did not renew the registration. A small and energetic market exists around registering these domains as soon as they become available. There is no cost to participate in the Club Drop service. Customers only pay if the domain name is successfully registered.', 'Nov 20th, 2004')
, (2, 'eNom, Inc., the #1 Reseller Registrar, Announces that it now manages over 4 million domains on it''s Domain Name Services Platform.', 'eNom, Inc. (www.enom.com) has announced that it now has over 4,000,000 domain names managed by its domain name services platform. eNom has built its business by becoming the most popular destination for domain name resellers, and has been named the #1 reseller registrar by Name Intelligence the last two years in a row..', 'Sep 09, 2004')
, (3, 'eNom, Inc., the #1 Reseller Registrar, Announces the Launch of Traffic Vista, a Website Traffic Analysis Tool.', 'Traffic Vista from eNom, Inc. (www.enom.com) is a comprehensive website statistics service which enables users to monitor and analyze their website traffic. The service allows users to know exactly where their visitors are coming from and what search terms their visitors used to reach the users'' website.\r\n', 'Aug 31, 2004')
, (4, 'eNom, Inc., the #1 Reseller Registrar, Announces that it now manages over 3 million domains in it''s Domain Name Management System.', 'eNom, Inc. (www.enom.com) has announced that it now has over 3,000,000 domain names in its domain name registration system. eNom has built its business by becoming the most popular destination for domain name resellers, and has been named the #1 reseller registrar by Name Intelligence the last two years in a row.', 'Sep 28, 2004')
, (5, 'eNom, Inc., the #1 Reseller Registrar, Announces the Launch of Web Hosting, a Website Hosting Platform', 'Web Hosting from eNom, Inc. (www.enom.com) is a comprehensive website hosting platform that allows registrants of domain names to host a website on eNom''s platform.', 'Dec 31, 2003')
, (6, 'This is a test title', 'test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test ', 'test')
";
$imported = mysql_query($ImportData);
if($imported){ echo " . "; } else { echo "  Could not import data into news table  "; }

$ImportData = "
INSERT INTO `product_pricing` VALUES (4, 8.00), (5, 9.95), (6, 0.00), (7, 0.00), (8, 0.00), (10, 9.95), (12, 6.00), (13, 200.00), (14, 19.99)";
$imported = mysql_query($ImportData);
if($imported){ echo " . "; } else { echo "  Could not import data into product_pricing table  "; }

$ImportData = "
INSERT INTO `products` VALUES (1, 'Domain name registration'), (2, 'Domain name Renewal'), (3, 'Domain name Transfer'), (4, 'ID Protect'),(5, 'Pop Email Boxes'), (6, 'URL Forwarding'), (7, 'URL Frame'), (8, 'Email Forwarding'), (9, 'Web site Builder'), (10, 'Website Creator'), (11, 'Web Hosting'), (12, 'DNS only Hosting'), (13, 'Redemption Recovery'), (14, '.Name Forwarding'), (15, 'Renew Hosting')";
$imported = mysql_query($ImportData);
if($imported){ echo " . "; } else { echo "  Could not import data into products table  "; }

$ImportData = "
INSERT INTO `tld_config` VALUES (1, 'com', 7.95, 7.95, 8.95, '1', '10', 'whois.crsnic.net', 'No match for', 1, 1, 0)
,(2, 'net', 7.95, 7.95, 8.95, '1', '10', 'whois.crsnic.net', 'No match for', 1, 1, 0)
,(12, 'org', 7.95, 7.95, 8.95, '1', '10', 'whois.publicinterestregistry.net', 'NOT FOUND', 1, 1, 1)
,(4, 'name', 7.95, 0.00, 8.95, '1', '10', 'whois.nic.name', 'No match', 0, 0, 0)
,(10, 'biz', 7.95, 0.00, 8.95, '1', '10', 'whois.neulevel.biz', 'Not found', 1, 1, 1)
,(13, 'info', 6.95, 7.95, 8.95, '1', '10', 'whois.afilias.info', 'NOT FOUND', 0, 1, 1)
, (14, 'us', 7.95, 7.95, 8.95, '1', '10', 'whois.nic.us', 'Not found', 1, 0, 1)
, (15, 'ws', 27.00, 0.00, 27.00, '1', '10', 'whois.website.ws', 'No match', 0, 0, 0)
, (21, 'cc', 24.95, 24.95, 24.95, '1', '10', 'whois.nic.cc', 'No match', 1, 0, 0)
, (22, 'ca', 16.00, 0.00, 16.00, '1', '10', 'whois.cira.ca', 'AVAIL', 0, 0, 0)
, (25, 'co.uk', 7.95, 7.95, 7.95, '2', '10', 'whois.nic.uk', 'No match', 0, 0, 0)
, (26, 'org.uk', 7.95, 7.95, 7.95, '2', '10', 'whois.nic.uk', 'No match', 0, 0, 0)
, (27, 'us.com', 29.95, 29.95, 29.95, '2', '10', 'whois.centralnic.com', 'No match', 0, 0, 0)
, (28, 'eu.com', 29.95, 29.95, 29.95, '2', '10', 'whois.centralnic.com', 'No match', 0, 0, 0)
, (44, 'de', 19.95, 0.00, 0.00, '1', '10', 'whois.denic.de', 'status:      free', 0, 0, 0)
, (54, 'tv', 34.95, 34.95, 34.95, '1', '10', 'whois.internic.net', 'No match for', 1, 0, 0)
, (55, 'in', 20.00, 20.00, 20.00, '1', '10', 'whois.inregistry.in', 'NOT FOUND', 0, 0, 1)
, (56, 'tc', 60.00, 60.00, 60.00, '1', '10', 'whois.tc', 'is not registered', 0, 0, 0)
, (57, 'vg', 60.00, 60.00, 60.00, '1', '10', 'whois.vg', 'is not registered', 0, 0, 0)
, (58, 'ms', 60.00, 60.00, 60.00, '1', '10', 'whois.ms', 'is not registered', 0, 0, 0)
, (59, 'gs', 60.00, 60.00, 60.00, '1', '10', 'whois.gs', 'is not registered', 0, 0, 0)
, (60, 'jp', 90.00, 90.00, 90.00, '1', '10', 'whois.jprs.jp', 'No match!!', 0, 0, 0)
, (61, 'nu', 39.99, 0.00, 39.99, '1', '10', '', '', 0, 0, 0)
, (62, 'bz', 39.99, 0.00, 39.99, '1', '10', 'whois.belizenic.bz', 'NOMATCH', 0, 0, 0)
, (63, 'cn', 49.95, 49.95, 49.95, '1', '10', 'whois.cnnic.net.cn', 'no matching record', 0, 0, 1)
";
$imported = mysql_query($ImportData);
if($imported){ echo " . "; } else { echo "  Could not import data into tld_config table  "; }
$ImportData = "
INSERT INTO `transfer_status` VALUES (0, 'Transfer Request Initiated - awaiting Fax', 2)
, (5, 'Transfer Completed successfully', 0)
, (9, 'Awaiting response to verification email', 2)
, (10, 'Cancelled - Unable to Retrieve contacts from Uwhois', 3)
, (11, 'Email authorization recieved - Processing request', 1)
, (12, 'Awaiting for auto transfer string validation', 1)
, (13, 'Domain awaiting Transfer initiation - In queue', 1)
, (14, 'Transfer initiated and awaiting approval from loosing registrar', 1)
, (15, 'Cancelled - Can not retrieve contacts from UWHOIS', 3)
, (16, 'Cancelled - Recieved no response to authorization email', 3)
, (17, 'Cancelled - Domain contacts did not approve the transfer', 3)
, (18, 'Cancelled - Domain Validation string is invalid', 3)
, (19, 'Cancelled - Whois information does not match provided information', 3)
, (20, 'Cancelled - Domain is not registered and thus can not be transfered', 3)
, (21, 'Cancelled - Domain is already in this account', 3)
, (22, 'Cancelled - Domain is locked, or not yet 60 days old', 3)
, (23, 'Cancelled - There is already an open transfer for this domain', 3)
, (24, 'Cancelled - Unknown error.  Please contact support', 3)
, (25, 'Cancelled - The current registrar rejected the transfer.  Please contact them for details.', 3)
, (26, 'Cancelled - Authorization Fax Not recieved or missing FOA', 3)
, (27, 'Cancelled by the customer', 3)
, (28, 'Fax Recieved - awaiting Registrant confirmation', 1)
, (29, 'Awaiting Manual Fax Verification', 1)
, (30, 'Cancelled - Domain is not available to trasnfer', 3)
, (31, 'Cancelled - The domain is already in Pending transfer to another registrar.', 3)
, (32, 'Cancelled - The EPP Key code (auth key) was invalid (incorrect).', 3)
, (33, 'Cancelled - can not transfer a name from a name only account.', 3)
, (34, 'Unable to complete transfer - transfers must include a change of registration.', 3)
, (36, 'Cancelled - Account is not authorized to perform transfers.  Please contact support.', 3)
, (37, 'Cancelled - Domain was not retagged in time by the loosing registrar.', 3)
, (4, 'NEW - Request In queue to process', 1)
";
$imported = mysql_query($ImportData);
if($imported){ echo " . "; } else { echo "  Could not import data into transfer_status table  "; }

		echo 'Done.</td></tr>';


					if(mysql_errno() == 0){
                echo'      <tr>
                        <td width="810">Success!  Lets move on to Step 4</td>
                      </tr></table>';
						$StepNumber = 4;
						$_SESSION['StepNumber'] = 4;
						echo '<center><a href="install4.php">Continue</a></center>';
						}

	 }
 }
?>
			        <p>&nbsp;</p>
			      <tr>
            </table></td>
		</table>