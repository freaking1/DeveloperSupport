<?php
session_name ('API-PHPSESSID');
session_start(); 
ob_start();

include('include/dbconfig.php');

if($_COOKIE['loggedin_user'] == '') {
	//The user is not logged in, so logg that
	$username = "Unregistered User";
	} else {
		$username = $_COOKIE['loggedin_user'];
		$user_id = $_COOKIE['id'];
	}

//Set the Logging Variables
	$sld = $HTTP_POST_VARS["ddomain"];
	$tld = $HTTP_POST_VARS["type"];
	$newtld = $_POST['tld'];

$page = "whois";
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Check Whois</span></td>
			    </tr>
				<tr>
	                </p>
		      <tr>
<td height="133" colspan="3" valign="top" class="content2"><p align="center" class="BasicText style2">&nbsp;</p>
  <p align="center" class="BasicText style3"><?php
  	if ($_POST['type']!="") define('TYPE', $_POST['type']); else define('TYPE', '');
	if ($_POST['ddomain']!="") define('DDOMAIN', $_POST['ddomain']); else define('DDOMAIN', '');

	// This function displays an available domain
	function dispav($what)
	{
		echo '<tr><td nowrap align="center">';
		if ($register_link == 1)
		{
			echo "<a href=\"$siteurl/check.php\"><span class=\"basictext\"><b>Register</a>";
		}
		else
			echo "<a href=\"$siteurl/check.php\"><span class=\"basictext\"><b>Register</a>";
		echo '</td>
		<td nowrap align="center" class="basictext"><b>'.$what.'</b></td><td colspan=3>&nbsp;</td></tr>';
   }

   // Function to display an unavailable domain with additional links
   function dispun($what,$where)
   {
      echo '<tr>
	  			<td colspan="2">&nbsp;</td>
	            <td align="center" nowrap class="notavailable"><b>'.$what.'</b></td>
            <td nowrap align="center">
			<a href="whois_detail.php?action=details&ddomain='.$what.'&server='.$where.'" onMouseOver="window.status=\Whois of '.$what.'\';return true" onMouseOut="window.status=\'\';return true" onClick="NewWindow(this.href,\'details\',\'620\',\'400\',\'yes\');return false;">
			View Whois</a></td>
            <td nowrap align="center"><a href="http://www.'.$what.'" target="_blank">Go To Site</a></td>
            </tr>';
   }

   function disperror($text)
   {
      echo '<table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
            <tr><td width="100%" class="windowborder">
            <table width="600" border="0" cellspacing="1" cellpadding="2">
            <tr><td class="windowinside">';
      echo '<center><b class="errors">'.$text.'</b></center>';
      echo '</td></tr></table></td></tr></table>';
   }

   function main()
   {
   	  $tld = $_POST['tld'];

      echo '<br>';
      echo '
<link rel="stylesheet" href="css/styles.css" type="text/css">
<table class="tableO1" width="500" align="center">
      <tr>
      <td colspan="10" class="titlepic"><span class="whiteheader"><center>Whois Lookup</td>
      </tr>
	    <tr>
        <td colspan="6" height="10">&nbsp;</td>
		</tr>
        <td colspan="6" align="center">
		 <form method="POST" action="whois.php">
         <input type="hidden" name="action" value="checkdom">
         <input type="hidden" name="sld">
        WWW.<input type="text" name="ddomain" size="30" maxlength="63" value="'.DDOMAIN.'">&nbsp;.&nbsp;'; 
		include("include/tldlist/tldListOne.php");
		
		echo '<td colspan="4"><td >		  </td>
	      <tr>
		 <td colspan="6"><center>
		   <div align="center">
		<input name="image" type="image" src="images/btn_whoislookup_g.gif" border="0">	        </div></td>	
<tr>
        <td height="19" colspan="6" align="center"><br>
</td>
	</tr>
      <tr><td colspan="7" align="center" class="footer">Please wait for the answer - due to whois servers overload it may take a while to lookup all names.  If it takes too long, please refresh the page and try again.<br><br>
	  <a href="whois.php" target="_self"><input name="image" type="image" src="images/btn_refresh.gif" border="0"></a><br>
</form>
		 </tr>
</table> <br><br>';   }

if ($_GET['action'] == "details")
{
	$server = $_GET['server'];
	$ddomain = $_GET['ddomain'];
			echo '
			<script type=text/javascript>
			var win= null;
			function NewWindow(mypage,myname,w,h,scroll)
			{
				var winl = (screen.width-w)/2;
			  	var wint = (screen.height-h)/2;
				var settings  ="height="+h+",";
				settings +="width="+w+",";
				settings +="top="+wint+",";
				settings +="left="+winl+",";
				settings +="scrollbars="+scroll+",";
				settings +="resizable=yes";
				win=window.open(mypage,myname,settings);
				if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
			}
			</script>
		</head>
		<BODY>';
;
	echo '<pre>';
	$fp = fsockopen($server,43);
	fputs($fp, "$ddomain\r\n");
	while(!feof($fp))
	{
		echo fgets($fp,128);
	}
	fclose($fp);
	echo '</pre>';
	echo '<p align="center"><form><input type="button" value="Close Window" onclick="window.close()"></form>';
	echo '</BODY></HTML>';;
	exit;
}

elseif ($_POST['action']=='checkdom')
{
$getInfo = "SELECT whois_server, match_string FROM tld_config WHERE tld = '$newtld'";
$gotInfo = mysql_query($getInfo);
$array = mysql_fetch_row($gotInfo);

$whoisserver = $array[0];
$matchstring = $array[1]; 

	// Check the name for bad characters
	if(strlen(DDOMAIN) < 3)
	{
				echo '
			<script type=text/javascript>
			var win= null;
			function NewWindow(mypage,myname,w,h,scroll)
			{
				var winl = (screen.width-w)/2;
			  	var wint = (screen.height-h)/2;
				var settings  ="height="+h+",";
				settings +="width="+w+",";
				settings +="top="+wint+",";
				settings +="left="+winl+",";
				settings +="scrollbars="+scroll+",";
				settings +="resizable=yes";
				win=window.open(mypage,myname,settings);
				if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
			}
			</script>
		</head>
		<BODY>';
;
		echo 'The domain name you typed is to short - it must contain minimum 3 characters';
		main();
		echo '</BODY></HTML>';;
		exit;
	}
	if(strlen(DDOMAIN) > 63)
	{
				echo '
			<script type=text/javascript>
			var win= null;
			function NewWindow(mypage,myname,w,h,scroll)
			{
				var winl = (screen.width-w)/2;
			  	var wint = (screen.height-h)/2;
				var settings  ="height="+h+",";
				settings +="width="+w+",";
				settings +="top="+wint+",";
				settings +="left="+winl+",";
				settings +="scrollbars="+scroll+",";
				settings +="resizable=yes";
				win=window.open(mypage,myname,settings);
				if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
			}
			</script>
		</head>
		<BODY>';
;
		echo 'The domain name you typed is to long - it may contain maximum 63 characters';
		main();
		echo '</BODY></HTML>';;
		exit;
	}
	if(ereg("^-|-$",DDOMAIN))
	{
				echo '
			<script type=text/javascript>
			var win= null;
			function NewWindow(mypage,myname,w,h,scroll)
			{
				var winl = (screen.width-w)/2;
			  	var wint = (screen.height-h)/2;
				var settings  ="height="+h+",";
				settings +="width="+w+",";
				settings +="top="+wint+",";
				settings +="left="+winl+",";
				settings +="scrollbars="+scroll+",";
				settings +="resizable=yes";
				win=window.open(mypage,myname,settings);
				if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
			}
			</script>
		</head>
		<BODY>';
;
		echo 'Domain names cannot begin or end with a hyphen or contain double hyphens';
		main();
		echo '</BODY></HTML>';;
		exit;
	}
	if(!ereg("([a-z]|[A-Z]|[0-9]|-|.){".strlen(DDOMAIN)."}",DDOMAIN))
	{
				echo '
			<script type=text/javascript>
			var win= null;
			function NewWindow(mypage,myname,w,h,scroll)
			{
				var winl = (screen.width-w)/2;
			  	var wint = (screen.height-h)/2;
				var settings  ="height="+h+",";
				settings +="width="+w+",";
				settings +="top="+wint+",";
				settings +="left="+winl+",";
				settings +="scrollbars="+scroll+",";
				settings +="resizable=yes";
				win=window.open(mypage,myname,settings);
				if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
			}
			</script>
		</head>
		<BODY>';
;
		echo 'Domain names can only contain alphanumerical characters and hyphens';
		main();
		echo '</BODY></HTML>';;
		exit;
	}
			echo '
			<script type=text/javascript>
			var win= null;
			function NewWindow(mypage,myname,w,h,scroll)
			{
				var winl = (screen.width-w)/2;
			  	var wint = (screen.height-h)/2;
				var settings  ="height="+h+",";
				settings +="width="+w+",";
				settings +="top="+wint+",";
				settings +="left="+winl+",";
				settings +="scrollbars="+scroll+",";
				settings +="resizable=yes";
				win=window.open(mypage,myname,settings);
				if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
			}
			</script>
		</head>
		<BODY>';
;
	echo '<table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
            <tr><td width="100%" class="windowborder">
            <table width="600" border="0" cellspacing="1" cellpadding="2">
            <tr><td class="windowinside">';


   echo '
      <table width="100%" align="center" cellspacing="0" cellpadding="1">
         <tr>
            <td nowrap align="center" class="separator"><b>&nbsp;</b></td>
            <td nowrap align="center" class="separator"><span class="basictext"><b><u>Available<u></b></td>
            <td nowrap align="center" class="separator"><div font color=\"red\"><b><u>Taken</u></b></td>
            <td nowrap align="center" class="separator"><b>&nbsp;</b></td>
            <td nowrap align="center" class="separator"><b>&nbsp;</b></td>
         </tr>';

$whoisserver = $array[0];
$matchstring = $array[1]; 


		$array = array(DDOMAIN.".$newtld");
		$count = count($array);
		$i=0;
		for ($i=0;$i<$count;$i++)
		{
			$domname = $array[$i];
			$ns = fsockopen($whoisserver,43); fputs($ns,"$domname\r\n");
			$result = '';
			while(!feof($ns)) $result .= fgets($ns,128); fclose($ns);
			if (eregi($matchstring,$result)) { dispav($domname); } else { dispun($domname,$whoisserver); }
		}
		echo '<tr><td colspan="5" class="separator">&nbsp;</td></tr></table>';
		echo "<center> These results are taken directly from the registry for the TLD selected.  We take no responsibility in the accuracy or availability of the data.<br>";

	$today = date("m-d-y H:i", time());

	$logtld = $_POST['type'];
	$query = "INSERT INTO whois_log (username, date, ip, sld, tld)
				VALUES ('$username', '$today', '$enduserip', '$sld', '$newtld')";
	$result = @mysql_query ($query);
		if(!$result) {
			echo "Logging Failed - Please contact support at $support_email"; 
		}
	$tld = '';

	echo '</td></tr></table></td></tr></table>';
	main();
	echo '</BODY></HTML>';;
}

else

{
			echo '
			<script type=text/javascript>
			var win= null;
			function NewWindow(mypage,myname,w,h,scroll)
			{
				var winl = (screen.width-w)/2;
			  	var wint = (screen.height-h)/2;
				var settings  ="height="+h+",";
				settings +="width="+w+",";
				settings +="top="+wint+",";
				settings +="left="+winl+",";
				settings +="scrollbars="+scroll+",";
				settings +="resizable=yes";
				win=window.open(mypage,myname,settings);
				if(parseInt(navigator.appVersion) >= 4){win.window.focus();}
			}
			</script>
		</head>
		<BODY>';
;
	main();
	echo '</BODY></HTML>';;
}
?>
  </table>
</table>
		          <?php include('include/footer.php');?>