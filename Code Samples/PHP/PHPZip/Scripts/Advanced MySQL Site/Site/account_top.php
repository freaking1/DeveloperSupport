<?php

		$username = $_COOKIE['loggedin_user'];
		$query5 = "SELECT last_login, login_IP FROM users WHERE username='$username'";		
		$result5 = @mysql_query ($query5);
		$row5 = mysql_fetch_array($result5, MYSQL_NUM);
			$lastlogin = $row5[0];
			$loginip = $row5[1];
?>
<table width="100%" border="0" class="table00" valign="center" align="center">
  <tr>
    <td class="tableO1" align="center"><a href="myaccount.php"><b>Overview</b></a> </td>
    <td class="tableO1" align="center"><a href="<?=$secure_site_url;?>/changepass.php"><b>Change Password</b></a> </td>
    <td class="tableO1" align="center"><a href="<?=$secure_site_url;?>/myinfo.php"><b>Update Info</b> </a></td>
    <td class="tableO1" align="center"><a href="mydomains.php"><b>My Domains</b></a></td>
    <td class="tableO1" align="center"><a href="mydnshosted.php"><b>DNS Hosted</b></a></td>
    <td class="tableO1" align="center"><a href="mytransfers.php"><b>My Transfers</b></a></td>
    <td class="tableO1" align="center"><a href="myhosting.php"><b>My Hosting</b></a></td>
    <td class="tableO1" align="center"><a href="expired.php"><b>Expired Domains</b></a></td>
  </tr>
  <tr>
    <td colspan="8" align="center"><span class="BasicText">
      <br>
      <? if(isset($message)) {echo '<center><u><b><span class=\"BasicText\">', $message, '</span></b></u></center>';}?>
    </span></td>
  </tr>
</table>