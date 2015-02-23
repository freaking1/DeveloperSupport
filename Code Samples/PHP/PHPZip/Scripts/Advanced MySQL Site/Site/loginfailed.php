<?
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if( isset($_COOKIE['loggedin_user'])) {
$LoggedIn = "Yes";
} else {
$LoggedIn = "No";
}
?>
<link rel="stylesheet" href="css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('include/header.php')?>
	    </tr>
</table><?php include('include/topmenu.php');?>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td width="147" height="313" valign="top">
			<table class="tableOO" border="0" cellpadding="0" cellspacing="0" id="table9">
				<tr>
				  <td width="145" height="313"><?php include('include/menu.php');?></td>
			  </tr>
		  </table>		  
		    </td>
			<td class="content" align="center" valign="top" width="815">
			<table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Login Failed </span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">&nbsp;			          </p>
			        <p align="center"><span class="BasicText"><strong>We're sorry, but you must be logged in to access this page. </strong></span><br>
			        </p>
			        <table width="551" border="0" align="center">
                      <tr>
                        <td class="OutlineOne">You have attempted to browse a web page in which you must be logged in to view. Please click on the link below to proceed to the login page. </td>
                      </tr>
                    </table>			        <p align="center">&nbsp;</p>
			        <p align="center"><a href="../login.php">
					<input name="image" type="image" src="images/btn_tryagain_g.gif" border="0">
</a>                     </p>
		      <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>