<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

$id = $_GET['id'];

$query2 = "SELECT name, username, phone, email, message, answered, date, response FROM contact WHERE id = '$id'";
$result2 = @mysql_query($query2);
$show = mysql_fetch_row($result2);

$name = $show[0];
$username = $show[1];
$phone = $show[2];
$email = $show[3];
$message = stripslashes($show[4]);
$ansered = $show[5];
$date =  $show[6];
$response =  stripslashes($show[7]);
$action = $HTTP_POST_VARS['action'];

if($action == 'respond'){
$id = $_GET['id'];
$myresponse = addslashes($HTTP_POST_VARS['newresponse']);
$sql = "UPDATE contact SET response = '$myresponse', answered='1', response_date = '$time' WHERE id='$id'";
$result = mysql_query($sql);
	if($result){
		$query2 = "SELECT name, username, phone, email, message, answered, date, response FROM contact WHERE id = '$id'";
		$result2 = @mysql_query($query2);
		$show = mysql_fetch_row($result2);
		$myresponse2 =  stripslashes($show[7]);
	
		require("../include/emails/contact_response.php");
	} 
	header ("Location: contact.php?message=1");
	exit(); // Quit the script.
}//Action
	
include("include/header.php");
?>
<tr>
    <td width="100%" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td width="18%" rowspan="2" valign="top"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td align="center">         <div align="left"></div></td>
      </tr>
      <tr> <span class=\"BasicText\"></span>
        <td rowspan="6" valign="top" align="center"><br>
<br>
          <table width="424" border="0" align="center" class="button">
  <form name="form1" method="post" action="<?php echo "contact_view.php?id=$id";?>">
    <input type="hidden" name="action" value="respond">
    <tr class="OutlineOne">
      <td colspan="3" class="titlepic"><div align="center"><span class="whiteheader">Contact Form</span> </div></td>
    </tr>
    <tr>
      <td>Name</td>
      <td>
       <?php echo $name;?>
      </td>
    </tr>
    <tr>
      <td>Email Address </td>
      <td><?php echo $email;?></td>
    </tr>
    <tr>
      <td>Phone Number </td>
      <td><?php echo $phone;?></td>
    </tr>
    <tr>
      <td height="20">Username</td>
      <td><?= $username;?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Message:</td>
    </tr>
    <tr>
      <td colspan="3"><br><span class="BasicText"><?=nl2br($message);?></span> </td>
    </tr>
	<?php
	if($ansered == '1'){ ?>
    <tr>
      <td colspan="3">Response:</td>
    </tr>
    <tr>
      <td colspan="3" cellspacing="5" cellpadding="5"><br><span class="BasicText"><?=nl2br($response);?></span> </td>
    </tr>
	<? } ?>
    <tr>
      <td height="20" colspan="3"><center>
        <p>&nbsp;</p>
          </center></td>
    </tr>
    <tr>
      <td height="20" colspan="3">Your Response: </td>
    </tr>
    <tr>
      <td height="20" colspan="3"><textarea name="newresponse" cols="45" rows="8" id="response" value="<?php echo $response;?>"></textarea></td>
    </tr>
    <tr>
      <td align="center" height="20" colspan="3"><center>&nbsp;&nbsp;&nbsp;&nbsp;<input name="image2" type="image" src="../images/btn_submit.gif" align="middle">&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.php"><input name="image2" type="image" src="../images/btn_back.gif" align="middle"></a></center></td>
    </tr>
  </form>
</table>
      </tr>
<?php include("include/footer.php");?>
    </table>    