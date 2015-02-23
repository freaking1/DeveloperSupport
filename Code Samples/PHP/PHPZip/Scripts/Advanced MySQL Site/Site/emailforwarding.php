<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=emailforwarding");
	exit(); // Quit the script.
}
require( "include/dbconfig.php" );
include( "include/EnomInterface_inc.php");

$tld = $_GET["tld"];
$sld = $_GET["sld"];

$action = $HTTP_POST_VARS["action"];

if($action == "modify"){
	include( "include/DomainFns_inc.php" );
	if ( WereEmailsModified() == 1 ) {
		ModifyEmails();
	}
		header ("Location:  $site_url/dmain.php?sld=$sld&tld=$tld");
};
$forwarding = 1;
	$page = "myaccount";

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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Email Forwarding </span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">
			        <?php 	if(isset($message)) {echo '<center><u><b><span class=\"BasicText\">', $message, '</span></b></u></center>';
	}
?>
		        </p>
<form name="form" method="post" action="<?php echo "emailforwarding.php?sld=$sld&tld=$tld";?>">
					<input type="hidden" name="action" value="modify">
					<table width="100%" border="0" align="center">
                        <tr>
                          <td width="17%">&nbsp;</td>
                          <td colspan="5"><table width="101%" height="167" border="0" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
                            <tr>
                              <td width="40%" height=50 align="center" valign="middle" class="OutlineOne">
                    <?php
					if ( $forwarding == 1 ) {
					$Enom = new CEnomInterface;
					$Enom->AddParam( "uid", $enom_username );
					$Enom->AddParam( "pw", $enom_password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );

					$Enom->AddParam( "command", "getforwarding" );
					$Enom->DoTransaction();

					// Make sure it was successful
					if ( $Enom->Values[ "ErrCount" ] == "0" ) {
						// Make enough edit boxes for the existing entries plus 5 more
						$nEmailCount = $Enom->Values[ "EmailCount" ] + 5;

						// Make sure the page we link to knows how many edit boxes there are
						echo "<input type=\"hidden\" name=\"EmailCount\" value=\"$nEmailCount\">";

						// Display a table for the information
						echo "<table border=\"0\" cellpadding=\"4\" cellspacing=\"0\">";
						echo "<tr><td>&nbsp;</td><td align=\"center\"><b>Username</b></td>";
						echo "<td align=\"center\">Domain</td> <td align=\"center\"><b>Forward To</b></td></tr>";

						// Create all the table rows
						for ( $i = 1; $i <= $nEmailCount; $i++ ) {
							// Display edit boxes
							echo "<tr>";
							echo "<td align=\"right\">$i)</td><td align=\"center\"><input size=\"12\" maxlength=\"30\" type=\"text\" id=\"idUsername$i\" name=\"Username$i\" ";
							echo "value=\"{$Enom->Values[ "Username" . $i ]}\"></td>";
							echo "<td>@$sld.$tld</td>";
							echo "<td><input size=\"14\" maxlength=\"120\" type=\"text\" id=\"idForwardTo$i\" name=\"ForwardTo$i\" value=\"{$Enom->Values[ "ForwardTo" . $i ]}\"></td></tr>";

							// Insert hidden fields with previous info
							echo "<input type=\"hidden\" name=\"OldUsername$i\" value=\"{$Enom->Values[ "Username" . $i ]}\">";
							echo "<input type=\"hidden\" name=\"OldForwardTo$i\" value=\"{$Enom->Values[ "ForwardTo" . $i ]}\">";
						}

						echo "</table>";
					} else {
						// The eNom server returned an error, print it out
						echo "There were errors getting the email list: {$Enom->Values[ "Err1" ]}<br />";
					}
				} else {
					echo "Not using our nameservers<br />";
				}
?></td>
                            </tr>
                            <br>
                          </table></td>
                          <td width="13%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="5%">&nbsp;</td>
                          <td width="18%">&nbsp;</td>
                          <td width="13%" align="center">
					<input name="Submit" type="image" src="images/btn_submit.gif" align="middle" border="0"/>
                          <td width="14%" align="center">

                            <a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>">
					<input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/>
                          </a></td>
                          <td width="20%">&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
              </table>
	          <div align="center">	            <a href="<?php echo "dmain.php?sld=$sld&tld=$tld";?>">
	            </a> <br>
              </div>
			          <tr>
	                <td colspan="3" valign="top" class="content2">    </form>
		      </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>