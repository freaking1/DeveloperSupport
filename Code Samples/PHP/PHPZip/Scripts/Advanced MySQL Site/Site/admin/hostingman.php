<?php
require("../include/dbconfig.php");
require("../include/EnomInterface_inc.php");
require("include/version.php");

//Get the post for what page to show
$show = $_GET["show"];
if($show == ''){ $show = 'view';}

$display = 15;
include("include/header.php");
?>
<tr>
    <td width="100%" valign="top" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr valign="top">
        <td valign="top" width="18%" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td width="34%" valign="top" align="center"><div align="right"> </div>          </td>
        <td width="23%" valign="top" align="left" class="BasicText"><b>&nbsp;</b>
        <td width="18%" valign="top"  align="center"> <div align="left"></div>
        </td>
      </tr>
      <tr valign="top">
        <td colspan="3" rowspan="6" valign="top" align="center">
		<?php
/*if($show == "add"){
#--------- FORM ------------#
include("forms/addhosting.php");
#--------- END FORM --------#
 	$action = $_GET[ "action" ];
	$username = $_POST['new_user'];
	$HostAccount = $_GET['HostAccount'];
	if ( $action == "GetHosting" ) {
		
		if(empty($HostAccount)) {
			$HostAccount = FALSE;
			$message .= '<br>You did not choose a username';
			} else { 
			if(strlen($HostAccount) < 6){
				$HostAccount = FALSE;
				$message .= '<br>Your username must be 6 characters of more';
			} else {
				if(ereg("^[0-9]{1,}", $HostAccount)){
					$HostAccount = FALSE;
					$message .= '<br>Your host account can not start with a number';
				} elseif(!ereg('^[a-zA-Z0-9]{6,14}', $HostAccount)){
					$HostAccount = FALSE;
					$message .= '<br>Your Username contains invalid characters.';
					} 
			}
		} else {
			$HostAccount = $_GET['HostAccount'];
			}
		
			if($HostAccount){
			$query = "SELECT * FROM webhosting WHERE host_username='$HostAccount'";
			$result = mysql_query ($query);
				if(mysql_num_rows($result) == 0){
				
						$Enom2 = new CEnomInterface;
						$Enom2->AddParam( "uid", $enom_username );
						$Enom2->AddParam( "pw", $enom_password );
						$Enom2->AddParam( "HostAccount", $HostAccount );
						$Enom2->AddParam( "Command", "GetHostAccount" );
						$Enom2->DoTransaction();
									
						$package_id = $Enom2->Values[ "WebHostID"];
						$status = $Enom2->Values[ "AccountStatusID"];
						$HostAccount = $Enom2->Values[ "HostAccount"];
						$Password = $Enom2->Values[ "Password"];
						$BandwidthGB = $Enom2->Values[ "BandwidthGB"];
						$WebStorageMB = $Enom2->Values[ "WebStorageMB"];
						$POPMailBoxes = $Enom2->Values[ "POPMailBoxes"];
						$BillingDate = $Enom2->Values[ "BillingDate"];
						
						 if($Enom2->Values[ "DatabaseType"] == 'SQL Server'){
						 $dbtype = '1';
						 $db_storage = $Enom2->Values[ "DBStorageMB"];
						 } elseif($Enom2->Values[ "DatabaseType"] == 'Access'){
						 $dbtype = '0';
						 $db_storage = $Enom2->Values[ "DatabaseType"];
						 }
						 
						$getdate = "select curdate()";
						$gotdate = mysql_query($getdate);
						$currentdate = mysql_result($gotdate,0);
								 
						$getdate = 'select date_sub(\''.$currentdate.'\', interval 1 day)';
						$gotdate = mysql_query($getdate);
						$orderdate = mysql_result($gotdate,0);
						
						$getdate2 = 'select date_add(\''.$orderdate.'\', interval 1 month)';
						$gotdate2 = mysql_query($getdate2);
						$duedate = mysql_result($gotdate2,0);

						$Enom4 = new CEnomInterface;
						$Enom4->AddParam( "uid", $enom_username );
						$Enom4->AddParam( "pw", $enom_password );
						$Enom4->AddParam( "HostAccount", $HostAccount );
						$Enom4->AddParam( "Command", "WEBHOSTHELPINFO" );
						$Enom4->DoTransaction();

						$Server = $Enom4->Values[ "HostURI"];
				
					$query = "INSERT INTO webhosting (user_id, username , host_username, host_password, full_name, email, package_name, product_id, package_id, db_type, db_storage, pop_boxes, disk_storage, bandwidth,  next_renew, date, order_id, price, status, IP)
					VALUES ('$user_id', '$username', '$HostAccount', '$Password', '$full_name', '$email', '$PackageName', '11', '$package_id', '$dbtype', '$db_storage', '$POPMailBoxes', '$WebStorageMB', '$BandwidthGB', '$duedate', '$orderdate', '$OrderID', '$charge', '$status', '$Server')";
					$result = mysql_query($query);
					$message .= "Succesfully added hosting account $HostAccount to login $username";
					} else {
					$message .= 'That username is already taken.  Please choose another.';
					}
			} else {
			echo $message;
			}
		}
}
if($show == "del"){

}*/
if($show == "view"){

	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT host_id, username, host_username, package_name, db_type, price, status, next_renew FROM webhosting ORDER BY host_id ASC";
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
	$query_all = "SELECT host_id, username, host_username, package_name, db_type, price, status, next_renew FROM webhosting ORDER BY host_id ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	//Make the linnks to other pages
	if ($num > 0) { // If it ran OK, display the records.
	echo "<br><span class=\"BasicText\"><b>Hosting accounts</b></span>";
		// Make the links to other pages, if necessary.
		if ($num_pages > 1) {
			
			echo '<p>';
			// Determine what page the script is on.	
			$current_page = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page != 1) {
				echo '<a href="hostingman.php?show=all&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
			
			// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="hostingman.php?show=all&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			// If it's not the last page, make a Next button.
			if ($current_page != $num_pages) {
				echo '<a href="hostingman.php?show=all&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
			
			echo '</p><br />';
			
		} // End of links section.
		
		// Table header.
		echo '<table width="100%" align="center" valign="top" class="tableO1">';
			echo '<tr class="titlepic">';
			echo '<td align="center"><b><span class="whiteheader">HostID</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Username</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Host Username</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Package</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Db Type</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Price</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Status</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Renewal Date</span></b></td></tr>';
			$bg='#eeeee';
			while($row = mysql_fetch_array($result_all, MYSQL_ASSOC)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
			
		if ($row[status] == 1){
		$status = "<center><img src=\"../images/manage/redx.gif\">";
		} else if
		($row[status] == 0){
		$status = "<center><img src=\"../images/manage/yes.gif\">";
		}
		else if
		($row[status] == 4){
		$status = "<center><img src=\"../images/manage/cancel_hosting.gif\">";
		}
			if($row[db_type] == 1){
			$dbtype = 'SQL';
			} else {
			$dbtype = 'Access';}


	list($year, $month, $day) = split('[-]', $row[next_renew]);
			if(strlen($day) != 2){
				$day = '0'.$day;
				}
			if(strlen($month) != 2){
				$month = '0'.$month;
				}
				
			$next_renew = "$month-$day-$year";

			
			echo "<tr bgcolor=\"$bg\">";
			echo '<td align="left"><b><center><a href="v_hosting.php?HostAccount='.$row[host_username].'">'.$row[host_id].'</center></a></b></td>';
			echo '<td align="left">'.$row[username].'</td>';
			echo '<td align="left"><b><center><a href="v_hosting.php?HostAccount='.$row[host_username].'">'.strtoupper($row[host_username]).'</center></a></b></td>';
			echo '<td align="left">'.$row[package_name].'</td>';
			echo '<td align="left">'.$dbtype.'</td>';
			echo '<td align="left">'.$row[price].'</td>';
			echo '<td align="left">'.$status.'</td>';
			echo '<td align="left">'.$next_renew.'</td>
			</tr>';
			}
		echo '</table>';

		mysql_free_result ($result_all); // Free up the resources.	
	} 
	mysql_close(); // Close the database connection.

	} else { // If there are no registered users.
		echo '<table width="100%" align="center" valign="top" class="tableO1">';
			echo '<tr class="titlepic">';
			echo '<td align="center"><b><span class="whiteheader">HostID</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Username</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Host Username</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Package</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Db Type</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Price</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Status</span></b></td>';
			echo '<td align="center"><b><span class="whiteheader">Order Date</span></b></td></tr>';
			echo "<tr bgcolor=\"$bg\">";
			echo '<td colspan="8" align="center">There are currently no hosting accounts in the system.</td></tr></table>';
		}
}//End SHOW ALL SECTION
?>		        </td>
      </tr>
<?php include("include/footer.php");?>
    </table>    