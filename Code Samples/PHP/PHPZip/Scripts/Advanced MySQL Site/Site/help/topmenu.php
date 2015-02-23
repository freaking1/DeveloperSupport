<?php
$loggedin_user = $_SESSION['loggedin_user'];
?>

<table width="860" height="34" border="0" cellpadding="0" cellspacing="0" class="tableOO">
       <td align="left" class="menu2alt"><table width="887" border="0" align="left" cellpadding="2" cellspacing="2">
         <form method="post" action="<?php echo "$workdir/check.php";?>" id="form1" name="form1">
           <input type="hidden" name="action" value="check">
           <tr>
             <td width="521" align="left" valign="left" class="titlepic"><span class="whiteheader">Domain Search 
               <input type="text" maxlength="60" name="sld" id="sld2">
&nbsp;.&nbsp;<?php include ("../include/tldlist/tldListOne.php"); ?>
<input class="button" value="GO" name="submit" type="submit"></td>
             <td width="352" align="left" valign="left" class="titlepic">
			 <?php
						  if (isset($_SESSION['loggedin_user']) AND (substr($_SERVER['PHP_SELF'], -10) != "$siteurl/logout.php")){
							 echo "<span class=\"whiteheader\"><u>You are logged in as: " . ($_SESSION['loggedin_user']);
							} else { 
						  	?> <a href="<?php echo $site_url."/login.php"; ?>">LOG IN</a><?php						
							}
							?>
</td>
           </tr>
         </form>
       </table>                
         </table>
