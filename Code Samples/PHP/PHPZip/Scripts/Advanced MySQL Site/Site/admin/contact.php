<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

//Get the post for what page to show
$status = $_GET["status"];

// Number of records to show per page:
$display = 15;
	
include("include/header.php");?>
<tr>
    <td width="100%" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td width="18%" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td align="center">         <div align="left"></div></td>
      </tr>
      <tr> <span class=\"BasicText\"></span>
        <td rowspan="6" valign="top" align="center"><br>
          <br>
         <?php if($_GET['message'] == '1') { echo "<center><span class=\"BasicText\">Response Succesfully Sent</spann></center><br>";}?>
		 <?php 
		echo '  <table width="80%"  border="0" class="tableO1">
            <tr>
              <td>&nbsp;</td>
              <td width="13%">&nbsp;</td>
              <td width="14%">&nbsp;</td>
              <td> <div align="right"><b><a href="contact.php?status=old">[ View Answered ] </a></b></div></td>
              <td><div align="center"><b><a href="contact.php?status=new">[ View Unanswered ] </a></b></div></td>
              <td><div align="left"><b><a href="contact.php?status=all">[ View All ] </a></b></div></td>
            </tr>
            <tr class="TitlePic">
              <td width="9%" align="center"><span class="WhiteHeader"> [ ID ] </span></td>
              <td colspan="2"><span class="WhiteHeader"> [ Name ] </span></td>
              <td width="22%"><span class="WhiteHeader"> [ Username ] </span></td>
              <td width="24%" align="center"><span class="WhiteHeader">[ Date ] </span></td>
              <td width="18%" align="center"><span class="WhiteHeader">[ Answered ]  </span></td>
			</tr>';

if(($status == '') || ($status == 'all')){
		$SQL = "SELECT * FROM contact ORDER BY date DESC";
	} 
	elseif($status == 'old'){
		$SQL = "SELECT * FROM contact WHERE answered ='1' ORDER BY date DESC";
	}
	elseif($status == 'new'){
		$SQL = "SELECT * FROM contact WHERE answered ='0' ORDER BY date DESC";
	}
	
	$result = mysql_query($SQL);

	$bg = '#eeeeee'; //Set the background color

  while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
  $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround

		$id = $row[id];
		$name = $row[name];
		$username = $row[username];
		$date = $row[date];
		
		if($row[answered] == 1){
			$answered = '<b><a href="contact_view.php?id='.$id.'"> <center>Yes</center></a></b>';
		} elseif($row[answered] == 0){
			$answered = '<b><a href="contact_view.php?id='.$id.'"> <center>No</center></a></b>';
			}
		
$view = '<b><a href="contact_view.php?id='.$id.'"> <center>'.$id.'</center></a></b>';

echo "
            <tr bgcolor=$bg>
              <td align=\"center\"><center>$view</center></td>
              <td colspan=\"2\">$name</td>
              <td>$username</td>
              <td>$date</td>
              <td align=\"center\">$answered</td>
            </tr>
";
}
echo '</table>';
?>
      </tr>
<?php include("include/footer.php");?>
    </table>    