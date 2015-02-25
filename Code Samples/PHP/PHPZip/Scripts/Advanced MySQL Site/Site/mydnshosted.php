<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=mydnshosted");
	exit(); 
} 

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];
$display = $_GET["show"];

require( "include/dbconfig.php" );

	if($display == ''){
		$display = 15;
		}
		
		$pagename = "mydnshosted.php";
		$query = "SELECT reset_pass FROM users WHERE username='$username'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
		$reset_pass = $row[0];
		if ($reset_pass == 1) {
		$message = '<font="red"><span class="table00">You have been issued a temporary password.  Please change it by clicking the link above</font></span>';
		} 
	}
	
	$page = "myaccount";
	$PageTitle = $SiteTitle . " - Expired Domains";

	?>
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">My DNS Hosted Domains </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
			        <?php
include('account_top.php');
	$query2 = "SELECT sld, tld, domain_id, dns, reg_lock, auto_renew, exp_date, idprotect, status
				FROM domains
				WHERE user_id = '$user_id' AND status='2'
				ORDER BY sld ASC";
	$result2 = @mysql_query ($query2);
	$row2 = mysql_fetch_array ($result2, MYSQL_NUM);
	if ($row2)
	{ //Then they have domain names
	$has_hosted = 1;
	$message2 = NULL;
	} else {
	//The user has no domain names in their account
	$has_hosted = 0;
	$message2 = '<center>You do not have any DNS Hosted domains in your account!!<br>';
	$message2 .= '<center><a href="dnshosting.php"><b><u>Buy DNS Hosting</b></u></a><br>';
	}
echo '			       <table align="center" width="100%" border="0" class="tableO1">
                      <tr class="tableO1">
                        <td colspan="6"><span class="BasicText"><strong>My Domains:</span></td>
                      </tr>
                      <tr class="tableO1">
                        <td width="230" align="center" class="titlepic"><span class="whiteheader">Domain Name</span></div></td>
                        <td width="51" align="center" class="titlepic"><span class="whiteheader">TLD</span></td>
                        <td width="200" align="center" class="titlepic"><span class="whiteheader">Expiration Date</span></td>
                      </tr>';
//Building the results of the domain search query
if($has_hosted == 1) {
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT *
				FROM domains
				WHERE user_id = '$user_id' AND status='2'
				ORDER BY sld ASC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_records > $display) { // More than 1 page.
			$num_pages = ceil ($num_records/$display);
		} else {
			$num_pages = 1;
		}
	}
$result2 = mysql_query ($query2);
//Start While loop to display the results of the query
$bg = '#eeeeee'; //Set the background color
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT *
				FROM domains
				WHERE user_id = '$user_id' AND status='2'
				ORDER BY sld ASC";
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
				FROM domains
				WHERE user_id = '$user_id' AND status='2'
				ORDER BY sld ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
//Start While loop to display the results of the query
while($row2 = mysql_fetch_array ($result2, MYSQL_ASSOC)){
//Display the results of the array into a table, one row per domain name in the listing
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround

	$exp_date = trim($row2[exp_date]);
	list($year, $month, $date) = split('[-]', $exp_date);
		$exp_date = "$month-$date-$year";

		if ($row2[reg_lock] == 0){
		$reg_lock = "<img src=\"images/manage/unlocked.gif\" border=\"0\">";
		} else if
		($row2[reg_lock] == 1){
		$reg_lock = "<img src=\"images/manage/locked.gif\" border=\"0\">";
		}
		
		if ($row2[auto_renew] == 0){
		$auto_renew = "No";
		} else if($row2[auto_renew] == 1){
		$auto_renew = "Yes";
		}

		if ($row2[dns] == 0){
		$dns = "<img src=\"images/manage/no.gif\" width=\"20\" height=\"16\" border=\"0\">";
		} else if($row2[dns] == 1){
		$dns = "<img src=\"images/manage/yes.gif\" width=\"20\" height=\"16\" border=\"0\">";
		}
		
$ret_sld = strtolower($row2[sld]);
$ret_tld = strtolower($row2[tld]);

echo 
"<tr bgcolor=\"$bg\">
<td align=\"left\">&nbsp;&nbsp;&nbsp;&nbsp;<b><u><span class=\"BasicText\"><a href=\"dmain.php?sld=$row2[sld]&tld=$row2[tld]&domain_id=$row2[domain_id]\">$ret_sld</b></u></td>
<td align=\"center\"><b><span class=\"BasicText\">$ret_tld</b></td>
<td align=\"center\"><b><span class=\"BasicText\">$exp_date</b></td>
</tr>\n";
} 

echo
'</table><center>';
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT *
				FROM domains
				WHERE user_id = '$user_id' AND status='2'
				ORDER BY sld ASC";
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
				FROM domains
				WHERE user_id = '$user_id' AND status='2'
				ORDER BY sld ASC LIMIT $start, $display";
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

                    <br>
					<table align="center" width="98%" border="0">
                        <tr>
					  <td width="87" align="left" class="OutlineOne" >
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
</select></form></td>
					  </table>

</table>                  </div>
                  <br><br> 
                  <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>	