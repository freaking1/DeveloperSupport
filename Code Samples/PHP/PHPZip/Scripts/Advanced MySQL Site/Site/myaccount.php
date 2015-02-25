<?php
require( "include/dbconfig.php" );


if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  $secure_site_url/login.php?target=myaccount");
	exit(); 
} 

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

$action = $HTTP_POST_VARS["action"];
$post_domain = $HTTP_POST_VARS["post_domain"];
$shownews = $_GET["shownews"];
$newsitem = $_GET["newsitem"];

		$query = "SELECT reset_pass FROM users WHERE username='$username'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
		$reset_pass = $row[0];
		if($reset_pass == 1) {
		$message = '<font="red"><span class="table00">You have been issued a temporary password.  Please change it by clicking the link above</font></span>';
		} 
	}
	
		$query = "SELECT last_login, login_IP FROM users WHERE username='$username'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
			$lastlogin = $row[0];
			$loginip = $row[1];

//Write the mysql calls to populate the logged in table
$query4 = "SELECT COUNT( * )
FROM domains
WHERE user_id = '$user_id' AND status='1'";
$result4 = @mysql_query ($query4);
		$row4 = mysql_fetch_array($result4, MYSQL_NUM);
$query1 = "SELECT COUNT( * )
FROM cart
WHERE user_id = '$user_id'";		
$result1 = @mysql_query ($query1);
		$row1 = mysql_fetch_array($result1, MYSQL_NUM);
$query2 = "SELECT COUNT( * )
FROM webhosting
WHERE user_id = '$user_id'";		
$result2 = @mysql_query ($query2);
		$row2 = mysql_fetch_array($result2, MYSQL_NUM);
$query3 = "SELECT COUNT( * )
FROM domains
WHERE user_id = '$user_id' and status = '0'";		
$result3 = @mysql_query ($query3);
		$row3 = mysql_fetch_array($result3, MYSQL_NUM);

$action = $HTTP_POST_VARS[ "action" ];
$post_domain = $HTTP_POST_VARS["post_domain"];
$post_form = $_SERVER['PHP_SELF']."?command=manage&post_domain=$post_domain";
if($action == "manage"){
	include( "include/EnomInterface_inc.php" );
  		$Enom3 = new CEnomInterface;
		$Enom3->AddParam( "uid", $enom_username );
		$Enom3->AddParam( "pw", $enom_password );
  		$Enom3->AddParam( "command", "ParseDomain" );
  		$Enom3->AddParam( "PassedDomain", $post_domain );
  		$Enom3->DoTransaction();
				$err = $Enom3->Values[ "err1" ];
				$sld = $Enom3->Values[ "SLD" ];
				$tld = $Enom3->Values[ "TLD" ];
				$formoptions .= "sld=$sld&tld=$tld";
				
				$query = "SELECT * FROM domains WHERE tld='$tld' AND sld='$sld' AND user_id ='$user_id'";
				$result = @mysql_query($query);
					if(mysql_num_rows($result)== 1){
						header ("Location:  $site_url/dmain.php?$formoptions");
						exit(); // Quit the script.
					} else {
					$message2 = "THE DOMAIN WAS NOT FOUND IN YOUR ACCOUNT";
					}
}
	$page = "myaccount";
	$PageTitle = $SiteTitle . " - My Account";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">My Account</span><b></b></td>
			    </tr>
				<tr>
			      <td colspan="3" valign="top" class="OutlineOne"><p align="center">
			        <?php
include('account_top.php');?>
<table width="100%" border="0">
  <tr>
    <td width="300">
	<table width="100%" border="0" valign= "top">
                      <tr>
                        <td width="41%" height="20" colspan="3" >			<?php		  echo "
<table valign=\"top\"  valign=\"top\" width=\"100%\" border=\"0\" class=\"tableO1\">
  <tr valign=\"top\">
    <td width=\"307\" valign=\"top\" class=\"titlepic\"><span class=\"whiteheader\"><center>
      My Account Overview
    </center></span></td>
  </tr><tr>
  	  <td> <strong>You have <a href=\"$siteurl/mydomains.php\">$row4[0] domain names </a> with </strong><strong>us</strong></td>
  </tr>
  <tr>
    <td> <strong>You have <a href=\"$siteurl/view_cart.php\">$row1[0] items </a> in the shopping cart </strong> </td>
  </tr>
  <tr>
    <td> <strong>You have <a href=\"$siteurl/myhosting.php\">$row2[0] Hosting accounts </a> with </strong><strong>us</strong></td>
  </tr>
  <tr>
    <td> <strong>You have <a href=\"$siteurl/expired.php\">$row3[0] items</a> that have expired </strong> </td>
  </tr>
</table>  ";
	?>
</td>
                      </tr>
                      <tr>
                        <td height="21" colspan="3"><table width="100%" border="0" class="tableO1" valign= "top">
                          <tr>
                            <td class="titlepic" colspan="3"><div align="center"><span class="whiteheader" >View/Pay Invoices</span></div></td>
                          </tr>
                          <tr>
                            <td colspan="1"><a href="myinvoices.php?show=paid"><strong>View Paid Invoices</strong></a></td>
                          </tr>
                          <tr>
                            <td colspan="2"><a href="myinvoices.php?show=open"><strong>View/Pay Open Invoices</strong></a></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="22" colspan="3" nowrap><center> <span class="red"><?=$message2;?></span></center></td>
                      </tr>
                      <tr>
                        <td width="5%">&nbsp;</td>
                        <td height="47" nowrap class="OutlineOne"><form name="form" method="post" action="myaccount.php">
                          <div align="center"><strong>
  <input type="hidden" name="action" value="manage">
  Quickly manage this domain: </strong>
                              <br>
                              <input type="text" name="post_domain">
                              <input class="button" value="GO" name="submit" type="submit"> 
                          </div>
                        </form></td>
                        <td width="5%">&nbsp;</td>
                      </tr>
                </table></td>
    <td width="501" class="OutlineOne"><table width="100%" height="197" border="0" align="center" valign="top">
                      <tr>
                        <td width="95%" rowspan="5" ><?php 
$query_news1 = "SELECT * from news ORDER BY id DESC limit 0, 5";		
$result_news1 = @mysql_query ($query_news1);
echo "<table valign=\"top\" width=\"100%\" border=\"0\" >
  <tr>
    <td class=\"titlepic\"><span class=\"whiteheader\"><center>
      Latest News
    </center></span></td></tr>";
while($news = mysql_fetch_array($result_news1, MYSQL_ASSOC)){
echo "<tr><td><b>$news[date]</b><br>$news[title] <span class=\"windowinside style1\"><a href=\"myaccount.php?shownews=1&newsitem=$news[id]\">- Read More -</a> </span></td></tr>";
}
echo
'</table>';
?>
						</td>
                      </tr>
                      <tr>
                    </tr>
                      <tr>
                    </tr>
                      <tr>
                    </tr>
                    </table></td>
  </tr>
</table>
<p>
<?php
if($shownews == 1){
$query_news_item = "SELECT * from news where id='$newsitem'";		
$result_news_item = @mysql_query ($query_news_item);
$row = mysql_fetch_array($result_news_item, MYSQL_ASSOC);
echo "<table width=\"100%\" class=\"tableOO\" border=\"0\">
  <tr>
    <td width=\"15%\"><span class=\"BasicText\"><b>$row[date]</b></span></td>
    <td width=\"70%\"><span class=\"BasicText\">$row[title]</span></td>
  </tr>
  <tr>
    <td colspan=\"2\">$row[body]</td>
  </tr>
</table>";
}
?>
<br>
  <br>
              </p>
<tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>