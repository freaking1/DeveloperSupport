<form name="form1" method="post" action="hostingman.php?show=add&action=GetHosting&HostAccount=<?=$HostAccount;?>">
<table width="90%"  border="0" cellspacing="0" valign="top" class="table01" cellpadding="0">
  <tr>
    <th colspan="2" class="titlepic"  align = "center" scope="col"><span class="whiteheader">Add A New Hosting Account</span></th>
  </tr>
  <tr>
    <td width="30%">System Username </td>
    <td width="70%">	  
	<select name="new_user">
	  <?php 
	$query = "SELECT id, username, fname, lname, email
				FROM users
				ORDER BY id ASC";
	$result = @mysql_query($query);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	$user_id = $row[id];
	$user_list = "$row[username]";
	$full_name = "$row[$fname] $row[$lname]";
	$email = $row[email];
	?><option value="<?=$row[username];?>"><?php echo $row[username];?></option> <? } ?>
                                              </select> </td>

  </tr>
  <tr>
    <td>Hosting Account Username </td>
    <td><input name="HostAccount" type="text" id="HostAccount" value="<?=$HostAccount;?>"></td>
  </tr>
  <tr>
    <td colspan="2">
<center>
<input name="image" type="image" src="../images/btn_submit.gif" border="0"></center></td>
    </tr>
</table>
 </form>