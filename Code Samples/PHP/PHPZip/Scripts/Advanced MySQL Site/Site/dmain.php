<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];

if (!isset($_COOKIE['loggedin_user'])) {
	header ("Location:  https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php?target=dmain");
	exit(); // Quit the script.
} 
	include('include/dbconfig.php');
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );
	
	$tld = $_GET['tld'];
	$sld = $_GET['sld'];

		$query = "SELECT dns, idprotect, status FROM domains WHERE sld='$sld' AND tld='$tld'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		if ($row)
		{
		$dns = $row[0];
		$idprotect = $row[1];
		$status = $row[2];
		}
		
		$query2 = "SELECT prodid FROM products WHERE product_name='ID Protect'";		
		$result2 = @mysql_query ($query2);
		$row2= mysql_fetch_array($result2, MYSQL_NUM);
		if ($row2)
		{
		$prodid = $row2[0];
		}
		
		$query3 = "SELECT domain_id, e_domain_id, exp_date, parking, mail, status, name_phone, name_map FROM domains WHERE tld = '$tld' AND sld = '$sld'";
		$result3 = @mysql_query ($query3);
		$row3 = mysql_fetch_array($result3, MYSQL_ASSOC);
			$domain_id = $row3[domain_id];
			$e_domain_id = $row3[e_domain_id];
			
		$exp_date = trim($row3[exp_date]);
		list($year, $month, $date) = split('[-]', $exp_date);
			$exp_date = "$month-$date-$year";

			$parking = $row3[parking];
				if($parking == 1){
					$park = "ON";}
				if($parking == 0){
				$park = "OFF";}
			$status = $row3[status];
			$NamePhoneVar = $row3[name_phone];
				if($NamePhoneVar == 1){
					$Phone = "ON";
					$NamePhoneText = 'Change / Turn Off Name My Phone Settings';
					}
				if($NamePhoneVar == 0){
					$Phone = "OFF";
					$NamePhoneText = 'Turn On Name My Phone Settings';
					}
			$NameMapVar	= $row3[name_map];
				if($NameMapVar == 1){
					$Map = "ON";
					$NameMapText = 'Change / Turn Off Name My Map Settings';
					}
				if($NameMapVar == 0){
					$Map = "OFF";
					$NameMapText = 'Turn On Name My Map Settings';
					}
			$mailsetting = $row3[mail];
			
				if(($mailsetting == "1048")||($mailsetting == '')||($mailsetting == '0')){
					$mail_choice = "no email";
					$mail_link = "<span class=\"basictext\">No Email Set (Email will not work)";
					$do_spf = 0;
					}
				if($mailsetting == "1051"){
					$mail_choice = "<span class=\"basictext\">email forwarding";
					$mail_link = "<a href=\"emailforwarding.php?sld=$sld&tld=$tld\" >Manage Forwarding</a>";
					$do_spf = 0;
					}
				if($mailsetting == "1054"){
					$mail_choice = "<span class=\"basictext\">Mail server by name (MX)";
					$mail_link = "<a href=\"hosts.php?sld=$sld&tld=$tld\" >Add / Edit MX Record</a>";
					$do_spf = 1;
					}
				if($mailsetting == "1105"){
					$mail_choice = "<span class=\"basictext\">Mail server by IP (MXE)";
					$mail_link = "<a href=\"hosts.php?sld=$sld&tld=$tld\" >$mail_choice</a>";
					$do_spf = 1;
					}
				if($mailsetting == "1114"){
					$mail_choice = "<span class=\"basictext\">POP3/WebMail";
					$mail_link = "<a href=\"mypopmail.php?sld=$sld&tld=$tld\" >Manage Pop Accounts</a>";
					$do_spf = 0;
					}
					
					
$GetWpps = "SELECT lockable, wpps, epp FROM tld_config WHERE tld='$tld'";
$GotWpps = @mysql_query($GetWpps);
$show = mysql_fetch_row($GotWpps);
$lockvar = $show[0];
$wppsvar = $show[1];
$HasEppKey = $show[2];

	if ($HTTP_POST_VARS[ "LockName" ] == "ON") {
		$Enom->NewRequest();
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "command", "setreglock" );
		$Enom->DoTransaction();
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$expMsg = $Enom->Values[ "Err1" ];
			echo $expMsg;
		} else {
			if ($Enom->Values[ "reg-lock" ] == 1){
				$lockCheck = 1;
			} 
		}
	}
	
	if ($HTTP_POST_VARS[ "RenewName" ] == "ON") {
		$Enom->NewRequest();
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "command", "setrenew" );
		$Enom->DoTransaction();
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			$expMsg = $Enom->Values[ "Err1" ];
			echo $expMsg;
		} else {
			if ($Enom->Values[ "auto-renew" ] == 1){
				$renewCheck = 1;
			} 
		}
	}
	mysql_close();
	$PageName = "dmain";
	
	$PageTitle = $SiteTitle . " - Administer your domain name";
if($dns == 1){
$dns_servers = "Ours";
} else {
$dns_servers = "Custom";}
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
				  <td height="19" width="101%" colspan="2"  class="titlepic"><span class="whiteheader">Domain Name Maintenance for <?PHP echo "$sld.$tld";?></span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td colspan="2" valign="top" ><br>
			        <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableOO">
                        <td colspan="2" class="titlepic"><span class="whiteheader">Renew</span>
                            <div align="center"></div></td>
                      </tr>
                      <tr class="tableOO">
                        <td><img src="images/g_yellow_on.gif" width="12" height="12"></td>
                        <td class="BasicText"><strong>Expiration Date:</strong>                          <?=$exp_date;?></td>
                      </tr>
                      <tr class="tableOO">
                        <td width="14"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td width="302" class="BasicText"><b><a href="<?php echo "addtocart.php?sld=$sld&tld=$tld&numyears=1&prodid=2&command=addtocart&shop=mydomains";?>">Renew your Domain name's registration length</a></td>
                      </tr>
                    </table>
			        <br>
			      <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableOO">
                        <td colspan="2" class="titlepic"><span class="whiteheader">Name Servers                         <div align="center"></div></td>
                      </tr>
                      <tr class="tableOO">
                        <td width="15"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                      <?php
					  if($status != '2'){ ?>  <td width="300" class="BasicText"><b><?php echo "<a href=\"DomainNs.php?sld=$sld&tld=$tld\"> Change Name servers (currently using $dns_servers)</a>";?></td>
					</tr>
                      <tr>
                        <td><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td class="BasicText"><b><?php echo "<a href=\"nsmaint.php?sld=$sld&tld=$tld\"> Register, Create or Update Name Servers For this domain</a>";?></td>
                      </tr>					 
					   <? } else { ?>
					  <td width="300" class="BasicText"><b>Cant Change Name servers on DNS Hosted domains</td> </tr><? } ?>
                      
                    </table>			        
			        <?php 
						if ($dns == 1)
						{ ?>
			       <br> <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableO1">
                        <td colspan="2" class="titlepic"><span class="whiteheader">Host Records
                              <div align="center"></div>
                        </span></td>
                      </tr>
                      <tr class="tableO1">
                        <td width="12"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td width="304" class="BasicText">
						<?php
						//Domain Is using our name servers
						echo "<b><a href=\"hosts.php?sld=$sld&tld=$tld\"> Modify Host Records </a></td>";
						 
						?>
                      </tr>
                    </table><?php } ?><?php if ($dns == 1)
						{ ?>
					<br><table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableO1">
                        <td colspan="2" class="titlepic"><span class="whiteheader">Park Your Domain (Currently <b></b><?=$park;?></b>)
                            <div align="center"></div>
                        </span></td>
                      </tr>
                      <tr class="tableO1">
                        <td width="12"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td width="304" class="BasicText">
                          <?php
						//Domain Is using our name servers
						//If parking is Turned off
						if($parking == 0){
						echo "<a href=\"parking.php?sld=$sld&tld=$tld&status=on\"><b>Turn ON and Set Domain Parking Text </a></td>";
						 } else {
						echo "<a href=\"parking.php?sld=$sld&tld=$tld&status=off&command=go\"><b>Turn Domain Parking OFF </a></td>";
						}
						?>
                      </tr>
                    </table><? } 
			         if ($dns == 1) {  ?><br>
			        <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableO1">
                        <td colspan="3" class="titlepic"><span class="whiteheader">Mail Settings
                              <div align="center"></div>
                        </span></td>
                      </tr>
					   
					<tr class=\"tableO1\">
						  <td></td>
						  <td class="BasicText" align="center"><b>Current Service:<?=$mail_choice;?></b></span></td>
					  </tr>
					<tr class=\"tableO1\">
                        <td width=\"11\"><img src=images/g_yellow_on.gif width=12 height=12></td>
                        <td width=\"304\" class=\"BasicText\"><b><a href="<?php echo "mailsettings.php?sld=$sld&tld=$tld";?>"> Change Email Setting </a></td>
                      </tr>
						  <?php if(($mailsetting == 1051) || ($mailsetting == 1114) || ($mailsetting == 1054)){?>
					<tr class=\"tableO1\">
						  <td><img src=images/g_yellow_on.gif width=12 height=12></td>
						  <td class="BasicText"><b>
						  <?=$mail_link;?></span></td>
					  </tr><? } ?>
						<?php if($do_spf == 1){ ?><tr class=\"tableO1\">
                        <td width=\"11\"><img src=images/g_yellow_on.gif width=12 height=12></td>
                        <td width=\"304\" class=\"BasicText\"><b><a href="<?php echo "spf.php?sld=$sld&tld=$tld";?>"> Add a SPF record for your domain </a></td>
                      </tr><? } ?>
                    </table>
					<? ; } //Domain Is using our name servers}?>
			        <br>
			        <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableOO">
                        <td colspan="2" class="titlepic"><span class="whiteheader">Whois</span>
                            <div align="center"></div></td>
                      </tr>
                      <tr class="tableOO">
                        <td width="11"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td width="304" class="BasicText"><b><?php echo "<a href=\"change_whois.php?sld=$sld&tld=$tld\">Change/Update Whois Information </a>";?></td>
                      </tr>
                    </table>
			        					  <br>			        					  <? if($status != '2'){?>
			        <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableOO">
                        <td colspan="2" class="titlepic"><span class="whiteheader">ID Proctect </span>
                          <div align="center"></div></td>
                      </tr>
                      <tr class="tableOO">
                        <td width="11"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
					    <td width="304" class="BasicText"><?php 

if($wppsvar == '1'){ 				 
						if ($idprotect == 1)
						{
						echo "<b><a href=\"wpps_status.php?sld=$sld&tld=$tld\"> Turn Id Proctect On/Off </a></td>";
						} else {
						echo "<b><a href=\"addtocart.php?sld=$sld&tld=$tld&prodid=$prodid&numyears=1&command=addtocart&shop=mydomains\">Purcase ID Protect for this domain</td>";
						}
				} else {
	echo "<b> ID Protect Not available for .$tld domains</b></td>";
	}
						?>
                      </tr>
                    </table>			        
						<br>						<? } ?>
						
						<?php
						if ($dns == 1){
                        echo '<table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableOO">
                        <td colspan="2" class="titlepic"><span class="whiteheader">Name My Phone </span>
                            <div align="center"></div></td>
                      </tr>
                      <tr class="tableOO">
                        <td width="11"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td width="304" class="BasicText"><b><a href="namephone.php?sld='.$sld.'&tld='.$tld.'">'.$NamePhoneText.'</a>
                      </tr>
                    </table>			
					
					        
			        <br>
			        <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableOO">
                        <td colspan="2" class="titlepic"><span class="whiteheader">Name My Map </span>
                            <div align="center"></div></td>
                      </tr>
                      <tr class="tableOO">
                        <td width="11"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td width="304" class="BasicText"><b><a href="namemap.php?sld='.$sld.'&tld='.$tld.'">'.$NameMapText.'</a>
                      </tr>
                    </table>';}?>
								        <br>
			        <table align="center" width="382" border="0" class="tableOO">
                      <tr class="tableO1">
                        <td colspan="2" class="titlepic"><span class="whiteheader"><span class="whiteheader">Domain settings and Utilities </span>                          <div align="center"></div></td>
                      </tr>
                      <tr class="tableO1">
                        <td width="9"><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                        <td width="305" class="BasicText"><b><?php echo "<a href=\"domain_password.php?sld=$sld&tld=$tld\">Change/Set Domain Access Password</a>";?></td>
                      </tr>
					  
					  
                      <tr class="tableO1">
                        <td><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
                    <?php
					if($lockvar == '1'){
					 ?>   <td class="BasicText">
					 <?php echo "<a href=\"reglock.php?sld=$sld&tld=$tld\"><b>Turn Registrar Lock On/Off</a>";?></td>
					 <? } elseif($lockvar == '0'){ ?>
					 <td class="BasicText"><?php echo "<b>$tld Domains can not be locked</b>";?></td>
					 <? } ?>
                      </tr>
				<?php
				if($HasEppKey == 1){ echo '			  
                      <tr class="tableO1">
                        <td><div align="center"><img src="images/g_yellow_on.gif" width="12" height="12"></div></td>
					 <td class="BasicText"><a href="geteppkey.php?sld='.$sld.'&tld='.$tld.'"><b>EPP Key</a></td>

                      </tr>';
					}
					  ?>
                    </table>
			        			<blockquote>
			        			  <p>
			        			    <center>
			        			       <a href="mydomains.php"><input name="Back" type="image" src="images/btn_back.gif" align="middle" border="0"/> 
</a><br>
		        			          <br>
			        			    </center>
		        			      </p>
       			    </blockquote>
			      <td width="5%"></form>
<br>
			        <p align="center"><br> 
                    </p>
		      <tr>
	              <td colspan="2" valign="top" class="content2">                
              </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>