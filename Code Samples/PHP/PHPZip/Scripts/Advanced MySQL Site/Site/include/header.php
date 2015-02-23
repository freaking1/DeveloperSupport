
<?php require("dbconfig.php"); ?>
<link rel="stylesheet" href="<?=$fullpath;?>/css/styles.css" type="text/css">
<table cellSpacing="0" cellPadding=10 width="740" border="0" align="center">
<tr> 
  <td > <table class="tableOO" cellSpacing="0" cellPadding=5 width="564" border="2" align="center" bordercolor="#313187">
        <tr> 
        <td width="548"  align="center" class="OutlineOne"> <table width="53%">
			<tr> 
			  <td align="center"><img src="<?=$site_url;?>/images/enomitron_logo.gif" width="368" height="75" border="0"></td>
            </tr>
          </table>          </td>
      </tr>
  </table>
  <?php
$username = $_COOKIE['loggedin_user'];

if (!isset($_COOKIE['AdminUser'])) {
	if($username){
	$findadmin = "SELECT username, isadmin FROM users WHERE username='$username'";
	$gotadmin = mysql_query($findadmin);
	$row_isadmin = mysql_fetch_row($gotadmin);
	
	$AdminUserName = $row_isadmin[0];
	$AdminUser = $row_isadmin[1];
	
	setcookie ("AdminUserName", "$AdminUserName", time()+3600, "/", "$siteurl", 0);
	setcookie ("AdminUser", "$AdminUser", time()+3600, "/", "$siteurl", 0);
	}
} 

?>