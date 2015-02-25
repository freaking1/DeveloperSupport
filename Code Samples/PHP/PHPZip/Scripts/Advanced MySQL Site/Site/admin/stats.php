<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

//Get the post for what page to show
$show = $_GET["show"];
$command = $_GET["command"];
$option = $_GET["option"];
$choice = $_GET["choice"];
// Number of records to show per page:
$display = 15;

//Run SQL Queriest to generate the Stats
//Llive domains
$query0 = "SELECT COUNT( * )
FROM domains
WHERE status='0'";
$result0 = @mysql_query ($query0);
		$row0 = mysql_fetch_array($result0, MYSQL_NUM);
//Expired Domains
$query1 = "SELECT COUNT( * )
FROM domains
WHERE status='1'";
$result1 = @mysql_query ($query1);
		$row1 = mysql_fetch_array($result1, MYSQL_NUM);
		
//DNS Hosted Domains
$query9 = "SELECT COUNT( * )
FROM domains
WHERE status='2'";
$result9 = @mysql_query ($query9);
		$row9 = mysql_fetch_array($result9, MYSQL_NUM);

//Total Domains
$query2 = "SELECT COUNT( * )
FROM domains";
$result2 = @mysql_query ($query2);
		$row2 = mysql_fetch_array($result2, MYSQL_NUM);
//Pending Transfers		
$query3 = "SELECT COUNT( * )
FROM transfers
WHERE statusid='9' OR statusid='12' OR statusid='13' OR statusid='14' OR statusid='4'";
$result3 = @mysql_query ($query3);
		$row3 = mysql_fetch_array($result3, MYSQL_NUM);
//Failed Transfers
$query4 = "SELECT COUNT( * )
FROM transfers
WHERE statusid='10' OR statusid='15' OR statusid='16' OR statusid='17' OR statusid='18' OR statusid='19' OR statusid='20' OR statusid='21' OR statusid='22' OR statusid='23' OR statusid='24' OR statusid='25' OR statusid='26' OR statusid='27' OR statusid='30' OR statusid='31' OR statusid='32' OR statusid='33' OR statusid='34' OR statusid='35' OR statusid='36' OR statusid='37'";
$result4 = @mysql_query ($query4);
		$row4 = mysql_fetch_array($result4, MYSQL_NUM);
//Completed Transfers		
$query5 = "SELECT COUNT( * )
FROM transfers
WHERE statusid='5'";
$result5 = @mysql_query ($query5);
		$row5 = mysql_fetch_array($result5, MYSQL_NUM);
//Active Hosting
$query6 = "SELECT COUNT( * )
FROM webhosting
where status='1'";
$result6 = @mysql_query ($query6);
		$row6 = mysql_fetch_array($result6, MYSQL_NUM);
//Suspended Hosting
$query7 = "SELECT COUNT( * )
FROM webhosting
where status='0'";
$result7 = @mysql_query ($query7);
		$row7 = mysql_fetch_array($result7, MYSQL_NUM);
//Total Hosting
$query8 = "SELECT COUNT( * )
FROM webhosting";
$result8 = @mysql_query ($query8);
		$row8 = mysql_fetch_array($result8, MYSQL_NUM);

$query9 = "SELECT COUNT( * ) FROM users";
$result9 = @mysql_query ($query9);
$row9 = mysql_fetch_array($result9, MYSQL_NUM);
	
if($option == "delete"){
	if($choice == "push"){
		$query_del_push = "TRUNCATE TABLE push_log";
		$result_del_push = @mysql_query($query_del_push);
			if($result_del_push){
				$sql = mysql_query("OPTIMIZE TABLE push_log");
				$message .= "Results Deleted";
				} else {
				$message .= "There was an error deleting the results";
			}//End Result push
		}//End Target push
	if($choice == "whois"){
		$query_del_whois = "TRUNCATE TABLE whois_log";
		$result_del_whois = @mysql_query($query_del_whois);
			if($result_del_whois){
				$sql = mysql_query("OPTIMIZE TABLE whois_log");
				$message .= "Results Deleted";
				} else {
				$message .= "There was an error deleting the results";
			}//End Result push
		}//End Target push
	if($choice == "check"){
		$query_del_check = "TRUNCATE TABLE check_log";
		$result_del_check = @mysql_query($query_del_check);
			if($result_del_check){
				$message .= "Results Deleted";
					$sql = mysql_query("OPTIMIZE TABLE check_log");
				} else {
				$message .= "There was an error deleting the results";
			}//End Result check
		}//End Target Check
	}//End Option conditional?>
<?php include("include/header.php");?>
<tr>
    <td width="100%" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td width="19%" rowspan="2"><div align="left">
            <?php include("include/menu.php");?>
        </div></td>
        <td width="30%" align="center">&nbsp;</td>
        <td width="32%" align="left" class="BasicText">&nbsp;</td>
        <td width="19%" rowspan="7" valign="top" align="center">
          <div align="left"></div>         <br>		  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="tableO1" id="table10" valign="top">
            <tr class="formfield">
              <td colspan="2" align="center"><span style="font-weight: bold; color: #313187;"><u>Site Statistics</u> </span></td>
            </tr>
            <tr class="formfield">
              <td width="85%" align="center">
                <div align="left" class="BasicText"><strong>Expired Domains </strong></div></td>
              <td width="15%" align="center"><strong>
                <?=$row0[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center"><div align="left" class="BasicText"><strong>Active Domains </strong></div></td>
              <td align="center"><strong>
                <?=$row1[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center"><div align="left"><strong class="BasicText">DNS Hosted Domains </strong></div></td>
              <td align="center"><strong><?=$row9[0];?></strong></td>
            </tr>
            <tr class="formlogin">
              <td align="center">
                <div align="left"><strong>Total Domains </strong></div></td>
              <td align="center"><strong>
                <?=$row2[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr class="formfield">
              <td align="center"><div align="left" class="BasicText"><strong>Pending Transfers</strong></div></td>
              <td align="center"><strong>
                <?=$row3[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center"><div align="left" class="BasicText"><strong>Failed Transfers</strong></div></td>
              <td align="center"><strong>
                <?=$row4[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center"><div align="left" class="BasicText"><strong>Completed Transfers</strong></div></td>
              <td align="center"><strong>
                <?=$row5[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr class="formfield">
              <td align="center">
                <div align="left" class="BasicText"><strong>Active Hosting </strong></div></td>
              <td align="center"><strong>
                <?=$row6[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center">
                <div align="left" class="BasicText"><strong>Suspended Hosting </strong></div></td>
              <td align="center"><strong>
                <?=$row7[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center">
                <div align="left"><strong>Total Hosting</strong></div></td>
              <td align="center"><strong>
                <?=$row8[0];?>
              </strong></td>
            </tr>
            <tr class="formfield">
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr class="formfield">
              <td align="center"><div align="left">Total Users </div></td>
              <td align="center"><?=$row9[0];?></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2" rowspan="6" valign="top" align="center">            <table width="80%" border="0" cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10">
              <tr class="formfield">
                <td height="18" colspan="2" align="center" style="font-weight: bold"><span class="BasicText"><u>Site Logs</u></span></td>
            </tr>
              <tr class="formfield">
                <td width="50%" height="17" align="center" class="boxtitle"><div align="center"><a href="<?php echo "stats.php?command=whois";?>">View recent Whois Checks </a></div></td>
                <td width="50%" align="center" class="boxtitle"><a href="stats.php?option=delete&choice=whois">Delete Records</a> </td>
            </tr>
              <tr class="formfield">
                <td height="17" align="center" class="boxtitle"><div align="center"><a href="<?php echo "stats.php?command=check";?>">View recent Domain Checks </a> </div></td>
                <td height="17" align="center" class="boxtitle"><a href="stats.php?option=delete&choice=check">Delete Records</a></td>
            </tr>
              <tr class="formfield">
                <td height="17" align="center" class="boxtitle"><a href="<?php echo "stats.php?command=push";?>">View recent Domain Pushes </a></td>
                <td height="17" align="center" class="boxtitle"><a href="stats.php?option=delete&choice=push">Delete Records</a></td>
            </tr>
            </table>
            <?php
				  //Print the error message if there is one
	if(isset($message)) {echo '<span class=\"red\">', $message, '</span>';}?>
            <br>
            <?php
					if($command == "whois"){
	if (isset($_GET['np_whois'])) { // Already been determined.
		$num_pages_whois = $_GET['np_whois'];
	} else {
	$query_whois = "SELECT sld, tld, date, ip FROM whois_log ORDER BY date ASC";
	$result_whois = @mysql_query($query_whois);
	$num_records_whois = mysql_num_rows($result_whois);
		
		if ($num_records_whois > $display) { // More than 1 page.
			$num_pages_whois = ceil ($num_records_whois/$display);
		} else {
			$num_pages_whois = 1;
		}
	}
					
	if (isset($_GET['s_whois'])) { // Already been determined.
		$start = $_GET['s_whois'];
	} else {
		$start = 0;
	}					//Create Nex/Previous Links
						//Make the query now
	$query_whois = "SELECT sld, tld, date, ip FROM whois_log ORDER BY date ASC LIMIT $start, $display";
	$result_whois = @mysql_query($query_whois);
	$num_whois = mysql_num_rows($result_whois);
	if($num_whois > 0){ //There were results, so lets display them
	//Make the linnks to other pages
		if ($num_pages_whois > 1) {
			echo '<p>';
			
}

	//Display the table
echo '<table width="95%" border="0" c cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10" valign="top">
  <tr class="boxtop2">
    <td width="52%" align="center" class="BasicText">
      <div align="center" class="BasicText"><b><u>Domain</b></u></td>
    <td width="48%" align="center" class="BasicText"><b><u>Date</b></u></td>
    <td width="48%" align="center" class="BasicText"><b><u>Users IP</b></u></td></tr>';
            $bg='#eeeee';
			while($row_whois = mysql_fetch_array($result_whois, MYSQL_NUM)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
			echo "<tr bgcolor=\"$bg\">";
			echo "<td align=\"center\">$row_whois[0].$row_whois[1]</td>";
			echo "<td align=\"center\">$row_whois[2]</td>";
			echo "<td align=\"center\">$row_whois[3]</td></tr>";
			}
		echo '</table><p><center>';
		mysql_free_result($result_whois);
		
								// Determine what page the script is on.	
			$current_page_whois = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page_whois != 1) {
				echo '<a href="stats.php?command=whois&s_whois=' . ($start - $display) . '&np_whois=' . $num_pages_whois . '">Previous</a> ';
			}
// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages_whois; $i++) {
				if ($i != $current_page_whois) {
					echo '<a href="stats.php?command=whois&s_whois=' . (($display * ($i - 1))) . '&np_whois=' . $num_pages_whois . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			// If it's not the last page, make a Next button.
			if ($current_page_whois != $num_pages_whois) {
				echo '<a href="stats.php?command=whois&s_whois=' . ($start + $display) . '&np_whois=' . $num_pages_whois . '">Next</a>';
			}
			
			echo '</p><br />';
	} else { echo "There are no results";}// End of links section.
	}			
#------------END WHOIS

#------------Start PUSH
if($command == "push"){
	if (isset($_GET['np_push'])) { // Already been determined.
		$num_pages_whois = $_GET['np_push'];
	} else {
	$query_push = "SELECT sld, tld, date, IP, from_user, to_user, status FROM push_log ORDER BY date ASC";
	$result_push = @mysql_query($query_push);
	$num_records_push = mysql_num_rows($result_push);
		if ($num_records_push > $display) { // More than 1 page.
			$num_pages_push = ceil ($num_records_push/$display);
		} else {
			$num_pages_push = 1;
		}
	}
					
	if (isset($_GET['s_push'])) { // Already been determined.
		$start = $_GET['s_push'];
	} else {
		$start = 0;
	}					//Create Nex/Previous Links
						//Make the query now
	$query_push = "SELECT sld, tld, date, IP, from_user, to_user, status FROM push_log ORDER BY date ASC LIMIT $start, $display";
	$result_push = @mysql_query($query_push);
	$num_push = mysql_num_rows($result_push);
	if($num_push > 0){ //There were results, so lets display them
	//Make the linnks to other pages
		if ($num_pages_push > 1) {
			echo '<p>';
			
}

	//Display the table
echo '<table width="95%" border="0" c cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10" valign="top">
  <tr class="boxtop2">
    <td width="20%" align="center" class="BasicText"><b><u>Domain</b></u></td>
    <td width="20%" align="center" class="BasicText"><b><u>Date</b></u></td>
    <td width="20%" align="center" class="BasicText"><b><u>Users IP</b></u></td>
    <td width="20%" align="center" class="BasicText"><b><u>From</b></u></td>
    <td width="20%" align="center" class="BasicText"><b><u>To</b></u></td>
    <td width="20%" align="center" class="BasicText"><b><u>Status</b></u></td></tr>
';
            $bg='#eeeee';
			while($row_push = mysql_fetch_array($result_push, MYSQL_NUM)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
			echo "<tr bgcolor=\"$bg\">";
			echo "<td align=\"center\">$row_push[0].$row_push[1]</td>";
			echo "<td align=\"center\">$row_push[2]</td>";
			echo "<td align=\"center\">$row_push[3]</td>";
			echo "<td align=\"center\">$row_push[4]</td>";
			echo "<td align=\"center\">$row_push[5]</td>";
			echo "<td align=\"center\">$row_push[6]</td></tr>";
			}
		echo '</table><p><center>';
		mysql_free_result($result_push);
		
								// Determine what page the script is on.	
			$current_page_push = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page_push != 1) {
				echo '<a href="stats.php?command=push&s_push=' . ($start - $display) . '&np_push=' . $num_pages_push . '">Previous</a> ';
			}
// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages_push; $i++) {
				if ($i != $current_page_push) {
					echo '<a href="stats.php?command=push&s_push=' . (($display * ($i - 1))) . '&np_push=' . $num_pages_push . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			// If it's not the last page, make a Next button.
			if ($current_page_push != $num_pages_push) {
				echo '<a href="stats.php?command=push&s_push=' . ($start + $display) . '&np_push=' . $num_pages_push . '">Next</a>';
			}
			
			echo '</p><br />';
	} else { echo "There are no results";}// End of links section.
	}			

#------------END PUSH


#------------Start CHECK	
if($command == "check"){
					///THIS IS FOR THE PREVIOUS/NEXT LINKS
	if (isset($_GET['np_check'])) { // Already been determined.
		$num_pages_check = $_GET['np_check'];
	} else {
	$query_check = "SELECT sld, tld, date, ip  FROM check_log ORDER BY date ASC";
	$result_check = @mysql_query($query_check);
	$num_records_check = mysql_num_rows($result_check);
		
		if ($num_records_check > $display) { // More than 1 page.
			$num_pages_check = ceil ($num_records_check/$display);
		} else {
			$num_pages_check = 1;
		}
	}
					
					
	if (isset($_GET['s_check'])) { // Already been determined.
		$start_check = $_GET['s_check'];
	} else {
		$start_check = 0;
	}
					//Create Nex/Previous Links
						//Make the query now
	$query_check = "SELECT sld, tld, date, ip FROM check_log ORDER BY date ASC LIMIT $start_check, $display";
	$result_check = @mysql_query($query_check);
	$num_check = mysql_num_rows($result_check);
	
	if ($num_check > 0) { // If it ran OK, display the records.
		// Make the links to other pages, if necessary.
		if ($num_pages_check > 1) {
			
			echo '<p>';
}

	//Display the table
echo '<table width="95%" border="0" c cellpadding="2" cellspacing="0" bgcolor="#d8e6f5" class="tableO1" id="table10" valign="top">
  <tr class="boxtop2">
    <td width="52%" align="center" class="BasicText">
      <div align="center" class="BasicText"><b><u>Domain</b></u></td>
    <td width="48%" align="center" class="BasicText"><b><u>Date</b></u></td>
    <td width="48%" align="center" class="BasicText"><b><u>Users IP</b></u></td></tr>';
			$bg='#eeeee';
			while($row_check = mysql_fetch_array($result_check, MYSQL_NUM)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
			echo "<tr bgcolor=\"$bg\">";
			echo "<td align=\"center\">$row_check[0].$row_check[1]</td>";
			echo "<td align=\"center\">$row_check[2]</td>";
			echo "<td align=\"center\">$row_check[3]</td></tr>";
			}
		echo '</table><p><center>';
		mysql_free_result($result_check);
		
								// Determine what page the script is on.	
			$current_page_check = ($start_check/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page_check != 1) {
				echo '<a href="stats.php?command=check&s_check=' . ($start_check - $display) . '&np_check=' . $num_pages_check . '">Previous</a> ';
			}
// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages_check; $i++) {
				if ($i != $current_page_check) {
					echo '<a href="stats.php?command=check&s_check=' . (($display * ($i - 1))) . '&np_check=' . $num_pages_check . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			// If it's not the last page, make a Next button.
			if ($current_page_check != $num_pages_check) {
				echo '<a href="stats.php?command=check&s_check=' . ($start_check + $display) . '&np_check=' . $num_pages_check . '">Next</a>';
			}
			
			echo '</p><br />';
	} else { echo "There are no results";}// End of links section.
}			
			  ?>
        </td>
      </tr>
<?php include("include/footer.php");?>
    </table>    
