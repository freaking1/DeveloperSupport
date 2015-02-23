<?php
require( "include/dbconfig.php" );

session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=expired");
	exit(); // Quit the script.
} 
	
$pagename = "expired.php";

	//Checks to see if the users password is a reset or not
		$query = "SELECT reset_pass FROM users WHERE username='$username'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
		$reset_pass = $row[0];
		if($reset_pass == 0) {
		//Nothing needs to be done
		$message = NULL;
		} else if ($reset_pass == 1) {
		$message = '<font="red"><span class="table00">You have been issued a temporary password.  Please change it by clicking the link above</font></span>';
		} 
	}

$display = $_GET["display"];
	if($display == ''){
		$display = 15;
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">My Expired Domains </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
<?php
include('account_top.php');

	$query2 = "SELECT sld, tld, domain_id, exp_date, status
				FROM domains
				WHERE user_id = '$user_id' AND (status = '0' OR status = '3' OR status = '4')
				ORDER BY sld ASC";
	$result2 = @mysql_query ($query2);
	$row2 = mysql_fetch_array ($result2, MYSQL_NUM);
	if ($row2)
	{ //Then they have domain names
	$has_expired = 1;
	$message2 = NULL;
	} else {
	$has_expired = 0;
	$message2 = '<center>You do not have any '.$ExpDomMsg.' in your account!!<br>';
	}
echo
   '<table align="center" width="800" border="0" class="tableO1">
	  <tr class="tableO1">
		<td colspan="5"><span class="BasicText"><strong>My Domains:</span></td>';
   echo ' </tr>
	  <tr class="tableO1">
		<td width="230" align="center" class="titlepic"><span class="whiteheader">Domain Name</span></div></td>
		<td width="51" align="center" class="titlepic"><span class="whiteheader">TLD</span></td>
		<td width="214" align="center" class="titlepic"><span class="whiteheader">Expiration Date</span></td>
		<td width="107" align="center" class="titlepic"><span class="whiteheader">Status</span></td>
		<td width="107" align="center" class="titlepic"><span class="whiteheader"></span></td>
	  </tr>';
	  
if($has_expired == 1) {
$result2 = mysql_query ($query2);
$bg = '#eeeeee'; //Set the background color
	
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	
	$query_all = "SELECT sld, tld, domain_id, exp_date, status
				FROM domains
				WHERE user_id = '$user_id' AND (status = '0' OR status = '3' OR status = '4')
				ORDER BY sld ASC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_records > $display) { // More than 1 page.
			$num_pages = ceil ($num_records/$display);
		} else {
			$num_pages = 1;
		}
	}

			$bg='#eeeee';

	if (isset($_GET['s'])) { 
		$start = $_GET['s'];
	} else {
		$start = 0;
	}

	$query_all = "SELECT sld, tld, domain_id, exp_date, status
				FROM domains
				WHERE user_id = '$user_id' AND (status = '0' OR status = '3' OR status = '4')
				ORDER BY sld ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
			while($row2 = mysql_fetch_array($result_all, MYSQL_ASSOC)){
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); 
	
	$exp_date = trim($row2[exp_date]);
	list($year, $month, $date) = split('[-]', $exp_date);
		$exp_date = "$month-$date-$year";

$ret_sld = strtolower($row2[sld]);
$ret_tld = strtolower($row2[tld]);

if($row2[status] == 0){
	$status = 'Expired';
	$prodid = 2;
	} elseif($row2[status] == 3){
	$status = 'RGP';
	$prodid = 13;
	} elseif($row2[status] == 4){
	$status = 'ERGP';
	$prodid = 13;
	}
		
echo 
"<tr bgcolor=\"$bg\">
<td align=\"center\"><span class=\"BasicText\">$ret_sld</td>
<td align=\"center\"><span class=\"BasicText\">$ret_tld</td>
<td align=\"center\"><span class=\"BasicText\">$exp_date</td>
<td align=\"center\"><span class=\"BasicText\">$status</td>
<td align=\"center\"><b><u><a href=\"addtocart.php?sld=$row2[sld]&tld=$row2[tld]&domain_id=$row2[domain_id]&prodid=$prodid&command=addtocart&shop=mydomains\">RENEW</b></u></td>
</tr>\n";
} 

echo
'</table><center>';
	
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT sld, tld, domain_id, exp_date, status
				FROM domains
				WHERE user_id = '$user_id' AND (status = '0' OR status = '3' OR status = '4')
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
	$query_all = "SELECT sld, tld, domain_id, exp_date, status
				FROM domains
				WHERE user_id = '$user_id' AND (status = '0' OR status = '3' OR status = '4')
				ORDER BY sld ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	if ($num > 0) { // If it ran OK, display the records.
		if ($num_pages > 1) {
			echo '<p>';
			$current_page = ($start/$display) + 1;
			if ($current_page != 1) {
				echo '<b><a href="expired.php?display='.$display.'&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</b></a> ';
			}
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="expired.php?display='.$display.'&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo '<b>'.$i . '  </b>';
				}
			}
			if ($current_page != $num_pages) {
				echo '<b><a href="expired.php?display='.$display.'&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</b></a>';
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
                    <table width="330" border="0">
                      <tr>
                        <td width="311"><span class="BasicText">
                        </span></td>
                      </tr>
                    </table>
                    <br>
					<table align="center" width="98%" border="0">
                        <tr>
                          <td width="296" align="left">
						  <form name="Name">
<select name="dropdownmenu" size=1 onChange="goToURL(this.form)">
<option selected value="">
Display</option>
<option value="<?php echo "$site_url/$pagename?display=15";?>">
15</option>
<option value="<?php echo "$site_url/$pagename?display=25";?>">
25</option>
<option value="<?php echo "$site_url/$pagename?display=50";?>">
50</option>
<option value="<?php echo "$site_url/$pagename?display=75";?>">
75</option>
<option value="<?php echo "$site_url/$pagename?display=100";?>">
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