<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=mytransfers");
	exit(); 
} 

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

$command = $_GET["command"];
$orderid = $_GET["orderid"];
$display = $_GET["show"];
	if($display == ''){
		$display = 15;}
		$pagename = "mytransfers.php";
	//Checks to see if the users password is a reset or not
		$query = "SELECT reset_pass FROM users WHERE id='$user_id'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
			$reset_pass = $row[0];
			if ($reset_pass == 0){
			$message = NULL;
			} else if ($reset_pass == 1) {
			$message = '<font="red"><span class="table00">You have been issued a temporary password.  Please change it by clicking the link above</font></span>';
			} 
		}
	
if($command == "resend"){
	include( "include/EnomInterface_inc.php");
	$message = NULL;
	$query2 = "SELECT * FROM transfers WHERE user_id = '$user_id' AND order_id='$orderid'";
	$result2 = @mysql_query ($query2);
	$row2 = mysql_fetch_array ($result2, MYSQL_ASSOC);
	$sld = $row2[sld];
	$tld = $row2[tld];
		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", $_SESSION['id'] );
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

if($command == "resubmit"){
	include( "include/EnomInterface_inc.php");
	$message = NULL;
		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", $_SESSION['id'] );
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
	$page = "myaccount";
	$PageTitle = $SiteTitle . " - My Transfers";
	?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
	<script language="JavaScript">
<!-- 
function goToURL(form)
  {
    var myindex=form.dropdownmenu.selectedIndex
    if(!myindex=="")
      {
        window.location.href=form.dropdownmenu.options[myindex].value;
      
      }
}
//-->
</script>
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">My Transfers </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"> <p align="center"> 
			        <?php
include('account_top.php');
	$query2 = "SELECT * FROM transfers
				WHERE user_id = '$user_id'";
	$result2 = @mysql_query ($query2);
	$row2 = mysql_fetch_array ($result2, MYSQL_ASSOC);
	if ($row2)
	{ //Then they have Transfers
	$has_transfers = 1;
	$message2 = NULL;
	} else {
	$has_transfers = 0;
	$message2 = '<center>You have not submitted any transfers for your account.<br><center>';
	}
echo
			       '<table align="center" width="100%" border="0" class="tableO1">
                      <tr class="tableO1">
                        <td colspan="2"><span class="BasicText"><strong>My Transfers:</span></td>
                      </tr>
                      <tr class="tableO1">
                        <td width="100" align="center" class="titlepic"><span class="whiteheader">OrderID </span></td>
                        <td width="123" align="center" class="titlepic"><span class="whiteheader">Order Type </span></td>
						<td width="115" align="center" class="titlepic"><span class="whiteheader">Order Status</span><span class="whiteheader"></span></td>
                        <td width="183" align="center" class="titlepic"><span class="whiteheader">Creation Date</span></td>
                        <td width="110" align="center" class="titlepic"><span class="whiteheader">Resend Email </span></td>
                        <td width="125" align="center" class="titlepic"><span class="whiteheader">Resubmit Order</span></td>
                      </tr>
					 ';
if($has_transfers == 1) {
$result2 = mysql_query ($query2);
$bg = '#eeeeee'; //Set the background color
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT *
				FROM transfers
				WHERE user_id = '$user_id'
				ORDER BY order_id ASC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_records > $display) { // More than 1 page.
			$num_pages = ceil ($num_records/$display);
		} else {
			$num_pages = 1;
		}
	}
	if (isset($_GET['s'])) { // Already been determined.
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
	$query_all = "SELECT *
				FROM transfers
				WHERE user_id = '$user_id'
				ORDER BY order_id ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
while($row2 = mysql_fetch_array ($result_all, MYSQL_ASSOC)){
$create_date = trim($row2[create_date]);
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround


			$query4 = "SELECT * FROM transfer_status WHERE status_id = '$row2[statusid]'";
			$result4 = @mysql_query ($query4);
			$row4 = mysql_fetch_array ($result4, MYSQL_ASSOC);

		if($row4[action] != 3){
			if($resend_link == 1){
				$resend_link = "Resent";
				} else {
				$resend_link = "<a href=\"mytransfers.php?command=resend&orderid=$row[order_id]\"><u><b>Resend Auth Email</u></b></a>";}
				
			if($resubmit_link == 1){
				$resubmit_link = "Resubmitted";
				} else {
				$resubmit_link = "<a href=\"mytransfers.php?command=resubmit&orderid=$row[order_id]\"><u><b>Resubmit Failed Order</u></b></a>";}
			} else {
				$resend_link = "Transfer Canceled";
				$resubmit_link = "Transfer Canceled";
		}


		if ($row2[order_type] == 3){
		//reg lock is not on 
		$order_type = "EPP";
		} else if
		($row2[order_type] == 1){
		//reg lock is on
		$order_type = "Auto Verification";
		}
		
		if($row2[init_date] == NULL) {
		$init_date = "Transfer not yet completed";
		} else {
		$init_date = $row2[init_date];
		}
		
		if($row2[statusid] == 5){
		  $statusid = "Completed" ;
		  }
		if(($row2[statusid] == 4) || ($row2[statusid] == 9) || ($row2[statusid] == 10) ||
		 ($row2[statusid] == 11) || ($row2[statusid] == 12) || ($row2[statusid] == 13) ||
		  ($row2[statusid] == 14)) {
		  $statusid = "Processing" ;
		  }
		 if(($row2[statusid] == 15) || ($row2[statusid] == 16) ||
		   ($row2[statusid] == 17) || ($row2[statusid] == 18) || ($row2[statusid] == 19) ||
		    ($row2[statusid] == 20) || ($row2[statusid] == 21) || ($row2[statusid] == 22) ||
			 ($row2[statusid] == 23) || ($row2[statusid] == 24) || ($row2[statusid] == 25) ||
			  ($row2[statusid] == 27) || ($row2[statusid] == 30) || ($row2[statusid] == 35) ||
			   ($row2[statusid] == 31) || ($row2[statusid] == 32) || ($row2[statusid] == 37)){
		$statusid = "Order Cancelled";
		} 

echo 
"<tr bgcolor=\"$bg\">
<td align=\"center\"><span class=\"BasicText\"><a href=\"transferstatus.php?user_id=$user_id&order_id=$row2[order_id]\"><u><b>$row2[order_id]</b></u></td>
<td align=\"center\"><b><span class=\"BasicText\">$order_type</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$statusid</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$create_date</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$resend_link</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$resubmit_link</b></td>
</tr>\n";
} 

echo
'</table><center>';
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT *
				FROM transfers
				WHERE user_id = '$user_id'
				ORDER BY order_id ASC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_records > $display) { // More than 1 page.
			$num_pages = ceil ($num_records/$display);
		} else {
			$num_pages = 1;
		}
	}
	
	if (isset($_GET['s'])) { // Already been determined.
		$start = $_GET['s'];
	} else {
		$start = 0;
	}

	$query_all = "SELECT *
				FROM transfers
				WHERE user_id = '$user_id'
				ORDER BY order_id ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	if ($num > 0) { // If it ran OK, display the records.
		if ($num_pages > 1) {
			echo '<p>';
			$current_page = ($start/$display) + 1;
			if ($current_page != 1) {
				echo '<a href="'.$pagename.'?display='.$display.'&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="'.$pagename.'?display='.$display.'&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			if ($current_page != $num_pages) {
				echo '<a href="'.$pagename.'?display='.$display.'&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
			echo '</p><br />';
		} // End of links section.
	}
		mysql_free_result ($result_all); // Free up the resources.	
	}

} else {
echo "
<table align=\"center\" width=\"663\" border=\"0\">
<tr>
<td width=\"100%\" align=\"center\"><span class=\"BasicText\">$message2</td>
</tr>
</table>";
}
?>
                    <br>
                  <br>			      

                  <div align="center"> 
                    <table width="459" border="0" class="tableO1">
                      <tr> 
					  <td width="161" align="left" >
						  <form name="Name">
<select name="dropdownmenu" size=1 onChange="goToURL(this.form)">
<option selected value="">
Display</option>
<option value="<?php echo "$site_url/$pagename?show=15";?>">
15</option>
<option value="<?php echo "$site_url/$pagename?show=25";?>">
25</option>
<option value="<?php echo "$site_url/$pagename?show=50";?>">
50</option>
<option value="<?php echo "$site_url/$pagename?show=75";?>">
75</option>
<option value="<?php echo "$site_url/$pagename?show=100";?>">
100</option>
</select>
						  </form></td>
                        <td width="191"><span class="BasicText">
						<?php
							echo "<center><a href=\"transfers.php\"><b><u>Submit a New Transfer Now!</b></u></a></center>";?>
                        </span></td>
                        <td width="91">&nbsp;</td>
                      </tr>
                    </table>
                    <br>				
</table>                  
                  <br>
                  <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>