<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$order_id = $_GET['order_id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=mytransfers");
	exit(); // Quit the script.
}

require( "include/dbconfig.php" );

	$query2 = "SELECT * FROM transfers WHERE user_id = '$user_id' AND order_id='$order_id'";
	$result2 = @mysql_query ($query2);
	$row2 = mysql_fetch_array ($result2, MYSQL_ASSOC);

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
		
	$query = "SELECT * FROM transfer_status WHERE status_id = '$row2[statusid]'";
	$result = @mysql_query ($query);
	$row = mysql_fetch_array ($result, MYSQL_ASSOC);

		if($row[action] == 0) {
		$action = "<img src=\"images/transfer_ok2.gif\">";
		} else if ($row[action] == 1) {
		$action = "<img src=\"images/transfer_progress.gif\">";
		} else if ($row[action] == 2) {
		$action = "<img src=\"images/transfer_look.gif\">";
		} else if ($row[action] == 3) {
		$action = "<img src=\"images/transfer_canceled.gif\">";
		}

$ret_sld = strtolower($row2[sld]);
$ret_tld = strtolower($row2[tld]);

	//Page name - DO NOT CHANGE
	$PageName = "transferstatus";
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - My Transfers Status";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Transfer status for Order ID # </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"> <p align="center"> 
			        <?php
include('account_top.php');
?>
<p align="center"><span class="BasicText"><strong>Transfer Order Detail </strong><br>
              <br>
              <strong>This page provides detailed tracking information for the domain name transfer associated with the order number below.</strong></span><strong> </strong></p>
			       <table align="center" width="583" border="0" class="tableOO">
                     <tr class="tableOO">
                       <td width="618" colspan="2" class="titlepic"><div align="center"><span class="whiteheader">Status for order #:
                       <?=$row2[order_id];?>
                       </span></div></td>
                     </tr>
                     <tr class="tableOO">
                       <td align="center" class="BasicText"><strong>Date Created:</strong><?=$row2[create_date];?></td>
                     </tr>
  <tr>
    <td align=\"center\" class="BasicText"><div align="center"><b><u></u></b> <strong>Overall Order Status: <?=$statusid;?></strong> </div></td>
    </tr>
                   </table>
			       <br>
			       <br>
			       <table align="center" width="750" border="0" class="tableOO">	
                     <tr class="tableOO">
                       <td width="166" align="center" class="titlepic"><span class="whiteheader">Domain Name </span></td>
                       <td width="24" align="center" class="titlepic"><span class="whiteheader"></span></td>
                       <td width="415" align="center" class="titlepic"><span class="whiteheader">Current Status</span><span class="whiteheader"></span></td>
                     </tr>
  <tr>
    <td align="center"><b><span class="BasicText"><?php echo $ret_sld.".".$ret_tld;?></b></a></td>
    <td align="center"><b><span class="BasicText"><?php echo $action;?></span></b></td>
    <td align="center"><b><span class="BasicText"><?php echo $row[desc];?></span></b></td>
  </tr>
                   </table>
			       <div align="center">
			       <div align="center"><br>
                      <a href="mytransfers.php"><span class="BasicText"><strong>Back to My Transfers</strong></span></a> <br>
<table width="330" border="0">
                      <tr>
                        <td width="311"><span class="BasicText">
						<?php
							echo "<center><a href=\"transfers.php\">Submit a New Transfer Now!</a></center>";?>

                        </span></td>
                      </tr>
                    </table>                    </div>

                    <br>
</table>                  
                  <br><br> 
      <tr>
	              <td colspan="3" valign="top" class="content2">                
    </table>
</table>
		          <?php include('include/footer.php');?>