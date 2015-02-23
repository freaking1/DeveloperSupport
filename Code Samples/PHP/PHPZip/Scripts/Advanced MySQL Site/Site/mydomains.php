<?php 
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=mydomains");
	exit(); 
} 

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

$display = $_GET["display"];
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
	$PageTitle = $SiteTitle . " - Administer your domain names";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">My Domains </span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
			        <?php
include('account_top.php');

	$query3 = "SELECT prodid
				FROM products
				WHERE product_name = 'ID Protect'
				";
	$result3 = @mysql_query ($query3);
	$row3 = mysql_fetch_array ($result3, MYSQL_ASSOC);
		$prodid = $row3[prodid];
	$query2 = "SELECT *
FROM domains, tld_config
WHERE user_id = '$user_id' AND status='1' AND domains.tld = tld_config.tld
ORDER BY sld ASC";
	$result2 = @mysql_query ($query2);
	$row2 = mysql_fetch_array ($result2, MYSQL_NUM);
	if ($row2)
	{ //Then they have domain names
	$has_domains = 1;
	$message2 = NULL;
	} else {
	//The user has no domain names in their account
	$has_domains = 0;
	$message2 = '<br><center>You do not have any domains in your account.<br>';
	$message2 .= "<a href=\"check.php\"><b><u>Buy One Now</u></b></a></center>";
	}
	
echo '			       <table align="center" width="100%" border="0" class="tableO1">
                      <tr class="tableO1">
                        <td colspan="6"><span class="BasicText"><strong>My Domains:</span></td>
                      </tr>
                      <tr class="tableO1">
                        <td width="230" align="center" class="titlepic"><span class="whiteheader">Domain Name</span></div></td>
                        <td width="51" align="center" class="titlepic"><span class="whiteheader">TLD</span></td>
						<td width="32" align="center" class="titlepic"><span class="whiteheader">DNS</span></td>
                        <td width="200" align="center" class="titlepic"><span class="whiteheader">Expiration Date</span></td>
                        <td width="105" align="center" class="titlepic"><span class="whiteheader">ID Protect</span></td>
                      </tr>';
	
if($has_domains == 1) {
$result2 = mysql_query ($query2);
$bg = '#eeeeee'; //Set the background color
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT *
FROM domains, tld_config
WHERE user_id = '$user_id' AND status='1' AND domains.tld = tld_config.tld
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

	$query_all = "SELECT *
FROM domains, tld_config
WHERE user_id = '$user_id' AND status='1' AND domains.tld = tld_config.tld
ORDER BY sld ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
			while($row2 = mysql_fetch_array($result_all, MYSQL_ASSOC)){
$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); 
	$exp_date = trim($row2[exp_date]);
	list($year, $month, $date) = split('[-]', $exp_date);
		$exp_date = "$month-$date-$year";
		
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
		
if($row2[wpps] == '0'){
		$no_id = 1;
	} elseif($row2[wpps] == '1'){
		$no_id = 0;
		}
if($row2[lock] == '0'){
		$no_lock = 1;
	} elseif($row2[lock] == '0'){
		$no_lock = 0;
		}
		
			
if($no_id == 1){
$idprotect = '<span class="BasicText"><b><u>N/A';
	} else {
		if (($row2[idprotect] == 0)&&($no_id != 1)){
				$idprotect = "<a href=\"addtocart.php?sld=$row2[sld]&tld=$row2[tld]&domain_id=$row2[domain_id]&prodid=$prodid&numyears=1&command=addtocart&shop=mydomains\"><img src=\"images/ID_notprotected.gif\" border=\"0\"></a>";
		} else if($row2[idprotect] == 1){
				$idprotect = "<a href=\"wpps_status.php?sld=$row2[sld]&tld=$row2[tld]\"><img src=\"images/ID_protected.gif\" border=\"0\"></a>";
	}
}
		
$ret_sld = strtolower($row2[sld]);
$ret_tld = strtolower($row2[tld]);

echo 
"<tr bgcolor=\"$bg\">
<td align=\"left\" class=\"BasicText\">&nbsp;&nbsp;&nbsp;&nbsp;<b><span class=\"BasicTextMED\"><strong><a href=\"dmain.php?sld=$row2[sld]&tld=$row2[tld]&domain_id=$row2[domain_id]\">$ret_sld</span></strong></b></td>
<td align=\"center\"><b><span class=\"BasicText\">$ret_tld</b></td>
<td align=\"center\"><span class=\"BasicText\">$dns</td>
<td align=\"center\"><b><span class=\"BasicText\">$exp_date</b></td>
<td align=\"center\">$idprotect</td>
</tr>\n";
} 

echo
'</table><center>';
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT *
FROM domains, tld_config
WHERE user_id = '$user_id' AND status='1' AND domains.tld = tld_config.tld
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
FROM domains, tld_config
WHERE user_id = '$user_id' AND status='1' AND domains.tld = tld_config.tld
ORDER BY sld ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	if ($num > 0) { // If it ran OK, display the records.
		if ($num_pages > 1) {
			echo '<p>';
			$current_page = ($start/$display) + 1;
			if ($current_page != 1) {
				echo '<b><a href="mydomains.php?display='.$display.'&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</b></a>   ';
			}
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="mydomains.php?display='.$display.'&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a>  ';
				} else {
					echo '<b>'.$i . '  </b>';
				}
			}
			if ($current_page != $num_pages) {
				echo '<b><a href="mydomains.php?display='.$display.'&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</b></a>';
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
                    <table width="330" border="0">
                      <tr>
                        <td width="311"><span class="BasicText">
                        </span></td>
                      </tr>
                    </table>
                    <div align="center">
</div>
                    <table align="center" width="800" border="0">
					<tr><td class="OutlineOne">
					<table align="center" width="98%" border="0">
                        <tr>
					  <td width="86" align="left">
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
                          <td width="166" align="left" >&nbsp;</td>
                          <td width="61" align="center" >Legend:</td>
                          <td colspan="2" align="right" ><b>Registrar Lock:</b></td>
                          <td width="57" align="center" ><img src="images/manage/locked.gif"> Yes </td>
                          <td width="49" align="left" ><img src="images/manage/unlocked.gif"> No</td>
                          <td width="77" align="right" ><b>DNS:</b></td>
                          <td width="62" align="left" ><img src="images/manage/yes.gif"> Ours</td>
                          <td width="73" align="left" ><img src="images/manage/no.gif"> custom </td>
				  </table></td></tr></table>

</table>             
</table>		          <?php include('include/footer.php');?>
</table>
