<?php
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

	echo '</BODY></HTML>';
	
	exit;
}
?>