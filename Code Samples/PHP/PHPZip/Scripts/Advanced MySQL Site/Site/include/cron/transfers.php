<?php 
require ("../dbconfig.php");
include ("../EnomInterface_inc.php");

if(isset($_GET['Z-debug-mode'])){
	$debug = $_GET['Z-debug-mode'];
} elseif(isset($showscreen)){
	$debug = $showscreen;
	}

#--- Code for Transfer Status Update --- #

		$query4 = "
		SELECT COUNT( * )
		FROM transfers 
		WHERE statusid='9' OR statusid='12' OR statusid='13' OR statusid='14' OR statusid='4' OR statusid='NULL'
		ORDER BY order_id ASC
		";
		$result4 = @mysql_query ($query4);
		$row4 = mysql_fetch_array($result4, MYSQL_NUM);
		$num = $row4[0];

$body = "Resluts of the 'Update Transfer Status' Cron job\r\n\r\n";

if($num == 0){
$body .= "There are no Transfers to update at this time\r\n";
	if($debug == 1){
		echo "There are no Transfers to update at this time<br>";
	}

	$subject = "Transfer Status Cron Job Results"; 
	$body .= "------------------------------------\r\n";
	$headers .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
	$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
	mail($support_email, $subject, $body, $headers);

exit;
}

$body .= "------------------------------------\r\n";

$Sql1 = "
SELECT * 
	FROM transfers 
		WHERE (
		statusid = '2' OR statusid = '3' OR statusid = '4' OR statusid = '9' OR statusid = '11' OR 
		statusid = '12' OR statusid = '13' OR statusid = '14' OR statusid = '' OR statusid = NULL )
			ORDER BY order_id ASC";

$Result1 = mysql_query($Sql1);

while ($Row1 = mysql_fetch_array ($Result1, MYSQL_ASSOC)) {
$row_statusid = $Row1[statusid];
$transferorderid = $Row1[order_id];
$sld = $Row1[sld];
$tld = $Row1[tld];

  		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "transferorderid", $transferorderid );
		$Enom->AddParam( "command", "TP_GetOrder" );
		$Enom->AddParam( "Job", "Transfer.Cron.Job" );
		$Enom->AddParam( "site", $sitename );
		$Enom->DoTransaction(); 

$orderdate  = $Enom->Values[ "orderdate" ];
$statusid = $Enom->Values[ "statusid1" ];
$statusdesc = $Enom->Values[ "statusdesc1" ];

if($row_statusid != $statusid){
$SqlUpdate = "UPDATE transfers SET statusid = '$statusid' WHERE order_id='$transferorderid'";
$SqlUpdate2 = mysql_query($SqlUpdate);
	if($SqlUpdate2){
		$body .= " ** Successfully updated Transfer Order Id $transferorderid\r\n";
		$body .= " ** Domain: $sld.$tld  \r\n";
		$body .= " ** New Status: $statusdesc\r\n\r\n";
			if($debug == 1){
			echo " ** Successfully updated Transfer Order Id $transferorderid<br>";
			echo " ** Domain: $sld.$tld  <br>";
			echo " ** New Status: $statusdesc<br><br>";
			}//if debug
		} //if sql update
	} else { 
		$body .= " -- No Change to Transfer Order Id $transferorderid\r\n";
		$body .= " -- Domain: $sld.$tld  \r\n";
		$body .= " -- Status: $statusdesc\r\n\r\n";
			if($debug == 1){
			echo " -- No Change to Transfer Order Id $transferorderid<br>";
			echo " -- Domain: $sld.$tld  <br>";
			echo " -- Status: $statusdesc<br><br>";
			}//if debug
		} //End else
} //End while
# --- Sending a copy to the admin --------#
	$subject = "Transfer Status Cron Job Results"; 
	$body .= "------------------------------------\r\n";
	$headers .= "From: " . $email_fromsupport." <" . $support_email . ">\r\n";
	$headers .= "Reply-To: " . $email_fromsupport. " <" . $support_email . ">\r\n";
	mail($support_email, $subject, $body, $headers);
#-----End the email section ---------#
