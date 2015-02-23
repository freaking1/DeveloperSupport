<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("version.php");

//Get the post for what page to show
$show = $_GET["show"];

// Number of records to show per page:
$display = 15;
	
	

?>
<?php include("include/header.php");?>
	<tr>
    <td width="100%" valign="top" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td valign="top" width="18%" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
	  </tr>
			  <tr>
				<td rowspan="6" valign="top" align="center">
	 <table width="100%"  border="0" valign="top">
					<tr>
					  <td><div align="center"><span class="BasicTextMED" style="font-weight: bold"><u>Non Processed Queue Items</u></span></div></td>
	    </tr>
					<tr>
					  <td><?php
		echo '
			  
			  <table width="100%" valign="top" border="0" class="TableOO">
			  <tr class="Titlepic">
				<td width="8%"><div align="center"><span class="whiteheader">[ ID ] </span></div></td>
				<td width="13%"><div align="center"><span class="whiteheader">[ Invoice ] </span></div></td>
				<td width="34%"><div align="center"><span class="whiteheader">[ Domain ] </span></div></td>
				<td width="25%"><div align="center"><span class="whiteheader">[ Command ] </span></div></td>
				<td width="10%"><div align="center"><span class="whiteheader">[ Price ] </span></div></td>
				<td width="10%"><div align="center"><span class="whiteheader">[ Qty ] </span></div></td>
			  </tr>';
			  
				$bg = '#eeeeee'; //Set the background color
			  //View the queue
			  $View_queue1 = "SELECT * FROM invoice_items WHERE status = '0' ORDER BY table_id";
			  $View_queue2 = mysql_query($View_queue1);
			  while ($View_queue3 = mysql_fetch_array ($View_queue2, MYSQL_ASSOC)) {

$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //switch the bg colors arround

	if($View_queue3[command] == "CreateHostAccount"){
		$sld = $View_queue3[host_package];
		$tld = $View_queue3[host_username];
		$Insert_Here = "Hosting Account: $sld - $tld";
		$command = "Create Web Hosting";
		} else {
		$sld = $View_queue3[sld];
		$tld = $View_queue3[tld];
		$Insert_Here = "$sld.$tld";
		$command = $View_queue3[command];
		}
		
		if($View_queue3[paid] == '0'){
		$paid = "<span class = \"red\"><b>Unpaid</b></span>";
		} elseif($View_queue3[paid] == '1'){
		$paid = "<span class = \"basictext\"><b>Paid</b></span>";
		}
					  
 echo " <tr bgcolor=\"$bg\">
    <td> <div align=\"center\">$View_queue3[table_id] </div></td>
    <td> <div align=\"center\">$View_queue3[invoice_id] </div></td>
    <td>$Insert_Here<br>$paid</td>
    <td>$command</td>
    <td> <div align=\"center\">$View_queue3[price] </div></td>
    <td> <div align=\"center\">$View_queue3[qty] </div></td>
  </tr>";
  }

echo '</table>';
			  
			  ?></td>
	    </tr>
        </table>          
	 </p>        </td>

      </tr>
<?php include("include/footer.php");?>
    </table>    