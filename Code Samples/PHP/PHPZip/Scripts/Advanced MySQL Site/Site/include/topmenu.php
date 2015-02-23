<table width="960" height="34" border="0" cellpadding="0" cellspacing="0" class="tableOO">
       <td align="left" class="menu2alt"><table width="960" border="0" align="left" cellpadding="2" cellspacing="2">
         <form method="post" action="<?php echo $siteurl."/check.php";?>" id="form1" name="form1">
           <input type="hidden" name="action" value="check">
           <tr>
             <td align="left" valign="left" class="titlepic"><div align="left"><span class="whiteheader">Domain Search 
                 <input type="text" maxlength="60" name="sld" id="sld2">
&nbsp;.&nbsp;
      <?php include ("tldlist/tldListOne.php"); ?>
                </span>
                <input name="Check" type="image" src="<?=$site_url;?>/images/btn_check.gif" align="middle" border="0"/> 
                </div></td>
            
			 <?php if(isset($_COOKIE['loggedin_user'])) {
			 echo "<td align=\"left\" valign=\"left\" class=\"titlepic\"><a href=\"view_cart.php\"><img src=\"$site_url/images/cart.gif\" height=\"29\" border=\"0\"></a></td>";
			 } 
			 ?>
             <td width="351" align="center" valign="left" class="titlepic"> 
			 <?php
						  if (isset($_COOKIE['loggedin_user']) AND (substr($_SERVER['PHP_SELF'], -10) != "$siteurl/logout.php")){
							 echo "<span class=\"whiteheader\"><u>You are logged in as: " . ($_COOKIE['loggedin_user']);
							} else { 
						  	?> <a href="<?php echo $secure_site_url."/login.php"; ?>"><span class="whiteheader">LOG IN</span></a><?php						
							}
							?>
</span></td>
           </tr>
         </form>
       </table>                
</table>