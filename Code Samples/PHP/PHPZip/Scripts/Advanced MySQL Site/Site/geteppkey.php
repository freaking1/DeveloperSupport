<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=geteppkey");
	exit();
}
	include('include/dbconfig.php');

	$tld = $_GET['tld'];
	$sld = $_GET['sld'];

$geteppstatus = "SELECT EPP from tld_config WHERE tld='$tld'";
$goteppstatus = mysql_query($geteppstatus);
$EppStatus = mysql_result($goteppstatus,0);

	$domain_name = "sld=$sld&tld=$tld";

if ($EppStatus != 1) {
	echo "EppStatus does not equal 1 - it is '$EppStatus'<br>$geteppstatus";
	//header ("Location:  $site_url/dmain.php?$domain_name");
	exit();
}
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );

		$Enom = new CEnomInterface;
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $enom_username );
			$Enom->AddParam( "pw", $enom_password );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "command", "GetContacts" );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "User_ID", $_COOKIE['id'] );
			$Enom->DoTransaction();
			// Check if there were errors
			$errors = $Enom->Values[ "ErrCount" ];

			if ( $errors != "0" ) {
				$message = $Enom->Values[ "Err1" ];
			}  else {
				$EPPKey = $Enom->Values[ "EPPKey" ];
			}

	//Page name - DO NOT CHANGE
	$page = "GetEppKey";

	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Get Your domains GetEppKey.";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Epp Key </span><b>                                 </b></td>
			    </tr>
				<tr>
	                </p>
			      <tr>
	                <td colspan="3" valign="top" class="content2"><p></p>
	                  <p>
	                  <br>
	                  </p>
	                  <table class="tableOO" cellSpacing="1" cellPadding="5" width="409" border="0" align="center">
			<tr>
			  <td width="96%" colspan="4" align="center" valign="middle"class="titlepic"><span class="whiteheader">EPP Key For <?php echo "$sld.$tld";?></span></td>
			  </tr>
		  <td width="4%"><div align="center">
<?php
		  if($errors == 0){
		  	echo $EPPKey;
			} else {
			echo $message;
		  }
		  ?>
</div>		  </table>
		              <div align="center"><a href="<?php echo "dmain.php?$domain_name";?>"><br>
                      <br>
	                  					<input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/>
 </a></div>
	                </table>
	    </table>
		          <?php include('include/footer.php');?>
