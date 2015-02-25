<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];


require( "include/dbconfig.php" );
$message = NULL;
	$query = "SELECT *
				FROM product_pricing
				WHERE prodid = '12'";
	$result = @mysql_query ($query);
	$row = mysql_fetch_array ($result, MYSQL_ASSOC);


$action = $HTTP_POST_VARS["action"];
$command = $_GET["command"];
$username = $_SESSION['loggedin_user'];
$user_id = $_SESSION['id'];
$post_domain = $HTTP_POST_VARS["post_domain"];

if(($command == "addtocart")||($action == "addtocart")){
		include( "include/EnomInterface_inc.php" );
			if(isset($_GET["Domain"])){
			$post_domain = $_GET["Domain"];
			} else {
			$post_domain = $HTTP_POST_VARS["post_domain"];
			}

	if (empty($_POST['post_domain'])) {
		$post_domain = FALSE;
		$message .= '<span class="red">You Must enter a domain name!</span>';}

		if($post_domain) {
		  		$Enom = new CEnomInterface;
				$Enom->AddParam( "uid", $enom_username );
				$Enom->AddParam( "pw", $enom_password );
				$Enom->AddParam( "command", "ParseDomain" );
				$Enom->AddParam( "PassedDomain", $post_domain );
				$Enom->DoTransaction();
					$sld = $Enom->Values[ "SLD" ];
					$tld = $Enom->Values[ "TLD" ];
			if(($sld == '') || ($tld == '')){
				$message .= "<b class=\"red\">Invalid Domain Name.  Please try again.<b>";
				} else {
				$formoptions .= "sld=$sld&tld=$tld&command=addtocart&prodid=12&shop=dnshosting";
				//echo "$formoptions";
				header ("Location:  $site_url/addtocart.php?$formoptions");
				exit(); }// Quit the script.
		}
	}
	$page = "dnshost";
	$PageName = "dnshosting";
	$PageTitle = $SiteTitle . " - DNS Only Hosting";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">DNS Hosting</span></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="content2"><p align="center">&nbsp;			          </p>
			        <table width="90%" border="0" align="center" class="OutlineOne">
                      <tr>
                        <td class="OutlineOne"> <strong>Do not use this form to register a new domain name. </strong> This form is to host a name in our name servers that has already been registered at another registrar (not eNom). For example, if you already registered the name "myname.com" and you would like to use our DNS name servers to host the name, then type the name in the field below. The "myname" part of the domain name is the SLD (second-level-name) and the "com" part of the name is the TLD (top-level-name). Do not forget to modify your name record at wherever you registered your name to point to eNom's name servers. The current price for hosting a domain name is
						<strong>$<?=$row[price];?>/yr </strong>. </td>
                      </tr>
                    </table>			        <form name="form" method="post" action="dnshosting.php">
			          <div align="center"><br>
			            <?php if(isset($message)) {echo '<span class=\"BasicText\">', $message, '</span><br>';}?><br>
			            <table width="60%" border="0">
                          <tr>
                            <td class="OutlineOne"><div align="center" class="windowinside"><strong><span class="BasicText">Domain Name to be Hosted: </span><br>
                            <input type="text" name="post_domain" value="<?php if (isset($_POST['post_domain'])) echo $_POST['post_domain']; ?>">
                            <input type="hidden" name="action" value="addtocart">
                            <br>
                            <span class="BasicText">(Once Submitted this can not be changed) </span></strong></div></td>
                          </tr>
                        </table>
							<input name="Add to cart" type="image" src="images/btn_add2cart.gif" border="0"/>
			          </div>
			        </form>
			      <tr>
	                <td colspan="3" valign="top" class="content2">
	        </table>
            <br>
            <table width="90%" border="0" class="OutlineOne">
              <tr>
                <td class="OutlineOne"><table cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="3"><strong>Note </strong>: a "name server" is the computer that matches your name up with where you want the name to go. It hosts your <strong>domain name </strong>. A "web server" is the computer where your website resides. It hosts your <strong>website </strong>. </td>
                  </tr>
                  <tr>
                    <td colspan="3"><strong>In order for this name to function correctly, you must add all 5 of our DNS servers to your domain name's configuration. </strong><strong>  Upon making that change, it will take aprox 12-48 hours to propogate and become effective world wide.</strong></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <p>&nbsp;</p>
		  </table>
		          <?php include('include/footer.php');?>
</body>

</html>