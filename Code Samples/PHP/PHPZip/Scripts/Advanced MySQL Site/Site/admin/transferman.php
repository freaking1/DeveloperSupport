<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

//Get the post for what page to show
$show = $_GET["show"];
$command = $_GET["command"];
$orderid = $_GET["orderid"];
$display = $_GET["show"];
// Number of records to show per page:
	if($display == ''){
		$display = 15;
		}

if($command == "resend"){
	$message = NULL;

	$query2 = "SELECT * FROM transfers WHERE order_id='$orderid'";
	$result2 = @mysql_query ($query2);
	$row2 = mysql_fetch_array ($result2, MYSQL_ASSOC);
	$sld = $row2[sld];
	$tld = $row2[tld];
		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", "Admin User" );
  		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "command", "TP_ResendEmail" );
		$Enom->DoTransaction();
		//Error Checking
			$errors = $Enom->Values[ "ErrCount" ];
			$err = $Enom->Values[ "Err1" ];
				if ( $errors != 0 ) {
				$resend_link = 0;
				$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><span class=\"red\"><b>$err</b></span></td></tr></table>";
				} else {
				$resend_link = 1;
				$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><span class=\"red\"><b>Successfully Resent Email for order $orderid</b></span></td></tr></table>";
						}
}
#------------------
if($command == "cancel"){
$orderid = $_GET['orderid'];
	$message = NULL;
		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", "Admin User" );
		$Enom->AddParam( "TransferOrderID", $orderid );
		$Enom->AddParam( "command", "TP_CancelOrder" );
		$Enom->DoTransaction();
		//Error Checking
			$errors = $Enom->Values[ "ErrCount" ];
			$err = $Enom->Values[ "Err1" ];
				if ( $errors != 0 ) {
				$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><span class=\"red\"><b>$err</b></span></td></tr></table>";
				} else {
				//update the db to status 27
				$sql = "update transfers set statusid='27' where order_id='$orderid'";
				$run = mysql_query($sql);
					if($run){
						$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><span class=\"red\"><b>Successfully Canceled order $orderid</b></span></td></tr></table>";
						} else {
						$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><span class=\"red\"><b>Order $orderid was successfully canceled, but could not update the datbase becauase of an error.<br>$sql</b></span></td></tr></table>";
						}
			}
}
#---------------------------
if($command == "resubmit"){
	$message = NULL;
		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", "Admin User" );
		$Enom->AddParam( "TransferOrderDetailID", $orderid );
		$Enom->AddParam( "command", "TP_ResubmitLocked" );
		$Enom->DoTransaction();
			$errors = $Enom->Values[ "ErrCount" ];
			$err = $Enom->Values[ "Err1" ];
				if ( $errors != 0 ) {
				$resubmit_link = 0;
				$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><span class=\"red\"><b>$err</b></span></td></tr></table>";
			} else {
				$resubmit_link = 1;
				$message = "<table align=\"center\" width=\"100\" class=\"table00\"><tr><td nowrap><span class=\"red\"><b>Successfully Resubmitted order $orderid</b></span></td></tr></table>";
						}
						
}
include("include/header.php");?>
<link rel="stylesheet" href= "../css/styles.css" type="text/css">
<tr>
    <td width="100%" valign="top" height="110">
	<table width="100%" border="0" valign="top" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr valign="top">
        <td width="18%" valign="top" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td width="34%" valign="top" align="center"></td>
        <td width="23%" valign="top" align="left" class="BasicText">
        <td width="18%" valign="top"  align="center">
        </td>
      </tr>
      <tr valign="top">
        <td colspan="3" rowspan="6" valign="top" align="center">
		<?php
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT * from transfers ORDER BY tran_id ASC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_records > $display) { // More than 1 page.
			$num_pages = ceil ($num_records/$display);
		} else {
			$num_pages = 1;
		}
	}
	
	// Determine where in the database to start returning results.
	if (isset($_GET['s'])) { // Already been determined.
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
			
	//Make the query now
	$query_all = "SELECT * from transfers ORDER BY tran_id ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	//Make the linnks to other pages
	if ($num > 0) { // If it ran OK, display the records.
	echo "<span class=\"BasicText\"><b>$message</b></span><br>";
	echo "<br><span class=\"BasicText\"><b>Transfers</b></span>";
		// Make the links to other pages, if necessary.
		if ($num_pages > 1) {
			// Determine what page the script is on.	
			$current_page = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page != 1) {
				echo '<a href="transferman.php?show=all&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
			
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="transferman.php?show=all&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			if ($current_page != $num_pages) {
				echo '<a href="transferman.php?show=all&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
		} // End of links section.
		
			echo '<table width="100%" align="center" valign="top" class="tableO1">';
			echo '<tr class="titlepic">';
			echo '<td align="center"><b><span class="whiteheader"></span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">OrderID</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Domain Name</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Date</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Status</span></b></td>';
            echo '<td align="center"><b><span class="whiteheader">Resend Email </span></b></td>';
            echo '<td align="center"><b><span class="whiteheader">Resubmit Order</span></b></td></tr>';

			$bg='#eeeee';
			while($row = mysql_fetch_array($result_all, MYSQL_ASSOC)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');

			$query = "SELECT * FROM transfer_status WHERE status_id = '$row[statusid]'";
			$result = @mysql_query ($query);
			$row4 = mysql_fetch_array ($result, MYSQL_ASSOC);
		
				if($row4[action] == 0) {
				$action = "<img src=\"../images/transfer_ok2.gif\">";
				} else if ($row4[action] == 1) {
				$action = "<img src=\"../images/transfer_progress.gif\">";
				} else if ($row4[action] == 2) {
				$action = "<img src=\"../images/transfer_look.gif\">";
				} else if ($row4[action] == 3) {
				$action = "<img src=\"../images/transfer_canceled.gif\">";
				}
		if($row4[action] != 3){
			if($resend_link == 1){
				$resend_link = "Resent";
				} else {
				$resend_link = "<a href=\"transferman.php?command=resend&orderid=$row[order_id]\"><u><b>Resend Auth Email</u></b></a>";}
				
			if($resubmit_link == 1){
				$resubmit_link = "Resubmitted";
				} else {
				$resubmit_link = "<a href=\"transferman.php?command=resubmit&orderid=$row[order_id]\"><u><b>Resubmit Failed Order</u></b></a>";}
			} else {
				$resend_link = "Transfer Canceled";
				$resubmit_link = "Transfer Canceled";
		}
			echo "<tr bgcolor=\"$bg\">";
			echo '<td align="left"><b><a href="v_transfer.php?orderid='.$row[order_id].'">Details</a></b></td>';
			echo '<td align="left">'.$row[order_id].'</td>';
			echo '<td align="left">'.$row[sld].'.'.$row[tld].'</td>';
			echo '<td align="center">'.$row[create_date].'</td>';
			echo '<td align="center">'.$action.'</td>';
			echo '<td align="center">'.$resend_link.'</td>';
			echo '<td align="center">'.$resubmit_link.'</td>
			</tr>';
			}
		echo '</table>';
echo '<br>		      <p><center><a href="transferman.php"><img src="../images/btn_refresh.gif" border="0"></a></center></p>';     
		mysql_free_result ($result_all); // Free up the resources.	
	} 
	mysql_close(); // Close the database connection.

	} else { // If there are no registered users.
		echo '<table width="100%" align="center" valign="top" class="tableO1">';
			echo '<tr class="titlepic">';
			echo '<td align="center"><b><span class="whiteheader"></span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">OrderID</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Domain Name</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Create Date</span></b></td>';
            echo '<td align="center"><b><span class="whiteheader">Resend Email </span></b></td>';
            echo '<td align="center"><b><span class="whiteheader">Resubmit Order</span></b></td></tr>';
			echo "<tr bgcolor=\"$bg\">";
			echo '<td colspan="8" align="center">There are currently no Transfers in the system.</td></tr></table>';
		}
echo '</td></tr>';
 include("include/footer.php");
echo '</table>';
?>