<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

$show = $_GET["show"];
$display = 15;
if($show == ''){ $show = 'view';}
include("include/header.php");?>
<tr>
    <td width="100%" valign="top" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td valign="top" width="18%" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td align="center">         <div align="center">
<?php
if($show == 'add'){
	$action = $_GET['action'];
	$title = mysql_escape_string($_POST['title']);
	$body = mysql_escape_string($_POST['body']);
	$date = mysql_escape_string($_POST['date']);
	include("forms/addnews.php");
		if($action == 'go'){
		$sql = "INSERT INTO news (title, body, date) VALUES ('$title', '$body', '$date')";
		$sql2 = mysql_query($sql);
			if($sql2){
			echo  "News Item added Succesfully";
			} else {
			echo "there was an error adding the news item";
			}
		}
}elseif($show == 'del'){

 		
}elseif($show == 'view'){
$detail = $_GET['detail'];
		if($detail == ''){
			$query = "SELECT * FROM news ORDER BY id ASC";
			$result = @mysql_query($query);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			echo '  <table width="100%" valign="top" class="tableO1" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			  <th colspan="6" class="titlepic" scope="col"><span class="whiteheader">View News items</span></th>
			</tr>
			<tr>
			  <td width="6%" class="titlepic" ><div align="center"></div></td>
			  <td width="6%" class="titlepic" ><div align="center"></div></td>
			  <td width="8%" class="titlepic" ><div align="center"><span class="whiteheader">[ ID ]</span></div></td>
			  <td width="15%" class="titlepic" ><div align="center"><span class="whiteheader">[ Date ]</span></div></td>
			  <td width="61%" class="titlepic" ><div align="center"><span class="whiteheader">[ Title]</span></div></td>
			</tr>';
			$bg = '#eeeeee'; //Set the background color
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); 
			$id = $row[id];
			$title = stripslashes($row[title]);
			$date = stripslashes($row[date]);
			
		   echo " <tr bgcolor=\"$bg\">
			  <td><div align=\"left\"><a href=\"newsman.php?show=view&detail=1&id=$id\"><b>View</b></div></td>
			  <td><div align=\"left\"><a href=\"newsman.php?show=view&delete=1&id=$id\"><b>Delete</b></div></div></td>
			  <td><div align=\"center\">$id</div></td>
			  <td><div align=\"center\">$date</div></td>
			  <td colspan=\"2\"><div align=\"left\">$title</div></td>
			</tr>";
			}
			  echo '</table>';
			} else {
				include("forms/updatenews.php");
			}//end	
			
	if($delete == 1){
	$sql = "delete from news where id = '$id'";
	$sql2 = mysql_query($sql);
	if($sql2){
		header ("Location:  newsman.php?show=view&success=1&refer=delete");
		} else { 
		echo "There was an error deleting news Item #$id";
		}
	}
	
if($action == 'update'){

		if($_POST['body2'] != ''){
			$body = mysql_escape_string(nl2br($_POST['body2']));
			} else {
			$body = mysql_escape_string(nl2br($body));
			}
			
	$title2 = mysql_escape_string($_POST['title']);
	$date2 = mysql_escape_string($_POST['date']);
	$sql = "update news set body = '$body', title = '$title2', date = '$date2' where id = '$id'";
	$sql2 = mysql_query($sql);
		if($sql2){
			header ("Location:  newsman.php?show=view&success=1&refer=update");
			} else {
			echo  "ERROR updating article";
			}
	}
	if($_GET['success'] == 1){ 
		if($_GET['refer'] == 'update'){
		echo "<b><span class=\"BasicText\">Succesfully updated News Article";
		} elseif($_GET['refer'] == 'delete'){
		echo "<b><span class=\"BasicText\">Succesfully Deleted Article";
		}
	}

}elseif($show == ''){
$show = 'add';
}
?>	
	</div></td>
      </tr>
      <tr>
        <td rowspan="6" valign="top" align="center">		</p>        </td>

      </tr>
<?php include("include/footer.php");?>
    </table>    