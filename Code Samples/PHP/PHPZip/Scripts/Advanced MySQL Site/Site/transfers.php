<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

$username = $_COOKIE['loggedin_user'];
$user_id = $_COOKIE['id'];

require( "include/dbconfig.php" );

switch ($ordertype){
case "epp";
header ("Location: epptransfer.php");
break;
case "av";
header ("Location: avtransfer.php");
break;
}

	$PageName = "index";
	$page = "transfer";
	$PageTitle = $SiteTitle . " - eNom's PHP Reseller Sample Site";
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
				  <td height="19" colspan="0"  class="titlepic"><span class="whiteheader"><b>Transfer Your Domain   </b></span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td cellpadding="5" cellspacing="5" colspan="3" valign="top" class="content2"><blockquote>
			        <blockquote>
			          <p align="center"><br>
			            <span class="BasicText"><strong>Please select your transfer Type:</strong></span></p>
	                </blockquote>
			      </blockquote>			    <form name="form1" method="post" action="">
			        <table width="100%" border="0">
                          <tr>
                            <td><table width="100%" border="0" class="tableO1">
                              <tr>
                                <td class="titlepic">
                                  <input name="ordertype" type="radio" value="av">
                                  <span class="whiteheader"><strong><u>Auto Verification</u></strong></span>-</td>
                              </tr>
                              <tr>
                                <td><span class="BasicText">This is our paperless transfer system. We will e-mail the current domain registrant contacts for authorization using the standard Form of Authorization (FOA) required by ICANN.</span><br>
                                    <strong class="BasicText">Use This method ONLY for .com, .net, .cc, .co.uk, and .org.uk domains</strong> </td>
                              </tr>
                            </table>                              <p>&nbsp;</p>
                          <table width="100%" border="0" class="tableO1">
                                <tr>
                                  <td class="titlepic"><input name="ordertype" type="radio" value="epp">
                                      <span class="whiteheader"><strong><u>EPP Transfer</u></strong></span><span class="BasicText">-</span> </td>
                                </tr>
                                <tr>
                                  <td ><span class="BasicText">This is our paperless transfer system. We will e-mail the current domain registrant contacts for authorization using the standard Form of Authorization (FOA) required by ICANN.<br>
                                        <strong>Use This method ONLY for .info, .biz, .us, and .org domains</strong></span></td>
                                </tr>
                              </table>                          </td>
                          </tr>
                        </table>
                        <p>
                          <input name="image2" type="image" src="images/btn_next.gif" border="0">
	                </p>
                    </form>
	                <p align="center">			          
					<br> 
		            </p>
	          <tr>
	              <td colspan="3" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>