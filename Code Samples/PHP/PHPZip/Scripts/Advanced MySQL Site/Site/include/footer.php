	<tr>
		<td>
			
			<table cellSpacing=0 cellPadding=0 width="837" border="0" align="center">
				<tr> 
				  <td align="center"><a href="<?php echo $site_url."/index.php"; ?>">HOME </a>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo $site_url."/pricing.php"; ?>">PRICING </a>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo $site_url."/check.php"; ?>">DOMAINS </a>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo  $site_url."/transfers.php"; ?>">TRANSFERS</a>&nbsp;&nbsp;|&nbsp;&nbsp; &nbsp; 
					<?php
						  if (!isset($_COOKIE['loggedin_user'])){?>
						  	<a href="<?php echo $secure_site_url."/login.php"; ?>">LOG IN</a>
							&nbsp;&nbsp;|&nbsp;&nbsp;
							<a href="<?php echo $secure_site_url."/createacct.php"; ?>">CREATE AN ACCOUNT</a>
							<?php } else { ?>
						  	<a href="<?php echo $site_url."/logout.php"; ?>">LOG OUT</a>
<?php } ?>
							&nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo $site_url."/contactus.php"; ?>">CONTACT US </a>
<?php

if($AdminUser == 1){
echo '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.$secure_site_url.'/admin/index.php">ADMIN SECTION</a><br>';
}
?>
					<br>
			      Powered by <A href="<?=$site_url;?>"><?=$site_url;?></A>&nbsp;&nbsp;1997-2005 <?php echo $CompanyName;?>, Inc.</td>
				</tr>
	  </table></td>
	</tr>
</table>