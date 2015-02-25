<?php

$action = $_POST['action'];
$body2 = $_POST['body2'];

	$SQL = "SELECT * FROM news WHERE id='$id'";
	$RESULT = @mysql_query($SQL);
	$row = mysql_fetch_array($RESULT, MYSQL_ASSOC);
	$body = stripslashes($row[body]);
	$title = stripslashes($row[title]);
	$date = stripslashes($row[date]);

?>
<form name="form1" method="post" action="newsman.php?show=view&action=update&id=<?=$id;?>">
  <p>&nbsp;</p>
  <table width="62%"  class="tableO1" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th colspan="2" class="titlepic" scope="col"><span class="whiteheader">Add News item</span></th>
    </tr>
    <tr>
      <td width="30%"><div align="center">Date: </div></td>
      <td width="70%"><input name="date" type="text" id="date" size="20" maxlength="20" value="<?=$date;?>"></td>
    </tr>
    <tr>
      <td><div align="center">Title:</div></td>
      <td><input name="title" type="text" id="title" size="50" maxlength="120" value="<?=$title;?>"></td>
    </tr>
    <tr>
      <td><div align="center">Body: (current) </div></td>
      <td><?=$body;?></td>
    </tr>
    <tr>
      <td><div align="center">Body (new):</div></td>
      <td><textarea name="body2" cols="50" rows="6" value="<?=$body2;?>"></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="Submit" class="button" value="Submit">
      </div></td>
    </tr>
  </table>
</form>