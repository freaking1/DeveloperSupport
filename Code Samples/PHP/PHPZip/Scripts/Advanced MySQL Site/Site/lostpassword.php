<?php 
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$PageName= "lostpassword";
	$PageTitle = $SiteTitle . " - Lost Password";

$get_email_var = $_GET['email'];
$caction = $HTTP_POST_VARS['actionnow'];

if ($caction == 'go') { // Handle the form.
	include( "include/dbconfig.php" );
	include("functions/escape_data.php");
	
	$message = NULL;
	
	if (empty($_POST['username'])) {
		$username = FALSE;
		$message .= '<span class="red">You forgot to enter your username!</span><br>';
	} else {
		$username = escape_data($_POST['username']);
		$query = "SELECT username, email FROM users WHERE username='$username'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
		$username = $row[0];
		$email = $row[1];
		$_SESSION['email_row1'] = $email;
		} 
		else 
		{
		$message .= 'The submitted username does not exist in our database<br>';
		$username = FALSE;
		} 
	}
	if($username) 
	{
	$new_password = substr(md5(uniqid(rand(),1)),3, 10);
	$query2 = "UPDATE users SET password=PASSWORD('$new_password') WHERE username ='$row[0]'";
	$result = @mysql_query($query2);
	if(mysql_affected_rows() == 1)
	{
		include("include/emails/temp_pass.php");
		
	$reset_pass = 1;
	$query = "UPDATE users SET reset_pass='1' WHERE username ='$row[0]'";
	$result = @mysql_query($query);
	header ("Location:  $site_url/lost_password.php?refer=lostpass");
	} else {
	$message .= 'Your password could not be changed at this time due to an unspecified error.
	We appologize for any inconvenience.';
	}
mysql_close();
} else {
$message .= '<span class="red">Please try again</span><br>';
	}
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
			
			<table width="100%" height="220" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Reset your password </span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><br>			        			      
				  <table width="592" border="0" align="center" class="table00">
                    <tr>
                        <td width="586">
<?php
	if(isset($message)) {echo "<center><span class=\"BasicText\">$message</span><br>";
	} else {
	echo $new_password;
	}
?>
                        <div align="center"></div></td>
                    </tr>
                    </table>
			<?php
if($get_email_var == ''){ ?>					
			        <table align="center" cellpadding="0" cellspacing="0" class="tableOO">
                      <tr>
                        <td width="527" class="titlepic"><div align="center"><span class="whiteheader"> Reset your Password </span>                              </div>
                          </div></td>
                      </tr>
                      <tr>
                        <td height="90" align="center" class="OutlineOne"><div align="center">
                          <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <p>&nbsp;</p>
                            <table width="464" border="0" class="OutlineOne" >
                              <tr>
                                <td width="104" align="right" class="BasicText"><div align="right"><b>User Name:</b></div></td>
                                <td width="145" align="left" ><div align="left">
                                  <input type="text" name="username" size="20" maxlength="16" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" />
                                  <input type="hidden" name="actionnow" value="go">
</div></td>
                                <td width="167" align="left" >
                              <input name="imageField" type="image" src="images/btn_go.gif" border="0"> &nbsp;&nbsp;&nbsp;
                            <a href="login.php">  <input name="imageField2" type="image" src="images/btn_back.gif" width="74" height="22" border="0"></a>
								</td>
                              </tr>
                            </table>
                          </form>
                          <table cellpadding="2" cellspacing="2">
            <tr>
              <td colspan="2" align="center"></td>
            </tr>
        </table>
                        </div></td>
                      </tr>
                  </table>
				    <center>
				    <br>
				      <br>
			      <tr>
	              <td height="2" colspan="3" valign="top" class="content2">                
            </table>
		    <a href="createacct.php">		    </a>
		  <tr>
	              <td colspan="3" valign="top" class="content2">                
            </table>
			<? } ?>
			</p>
		  </table>
		          <?php include('include/footer.php');?>