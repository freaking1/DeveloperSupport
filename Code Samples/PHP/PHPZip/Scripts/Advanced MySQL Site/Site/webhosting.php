<?php
	require("include/dbconfig.php");
	require( "include/EnomInterface_inc.php" );

  		$Enom = new CEnomInterface;
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "command", "WebHostGetResellerPackages" );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", $_COOKIE['id'] );
		$Enom->DoTransaction(); 

$PackageID  = $Enom->Values[ "PackageID"."$i" ];
$PackageName = $Enom->Values[ "PackageName"."$i" ];
$BandwidthGB = $Enom->Values[ "BandwidthGB"."$i" ];
$WebStorageMB = $Enom->Values[ "WebStorageMB"."$i"];
$DatabaseType = $Enom->Values[ "DatabaseType"."$i"];
$POPMailBoxes = $Enom->Values[ "POPMailBoxes"."$i"];
$DBStorageMB = $Enom->Values[ "DBStorageMB"."$i"];

	$cAction = $HTTP_POST_VARS[ "action" ];
	
	$page = "webhosting";
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
				  <td height="19" colspan="5"  class="titlepic"><span class="whiteheader">Web Hosting </span><b>                                 </b></td>
			    </tr>
	                <td valign = "top" width="55%" height="264"> 
	                  <table >
                        <tr>
                          <td class="OutlineOne" > <div align="center"><strong>                          Get the power of Windows Server 2003 with our SHARED HOSTING </strong>
                              </div>
                            <ul>
                              <li><strong>Web Storage </strong><br>
          Be as creative as you would like with our web hosting storage. Put videos, audio, multimedia presentations and more on your web site. Our robust hosting packages allow for huge amounts of storage. <br>
          <br>
                              </li>
                                <li><strong>Bandwidth </strong><br>
          Data Transfer (Bandwidth usage) is the volume of information that can be transmitted to/from the server as people view your site (ie text and images). We provide some of the best Bandwidth value in the industry. 
             Up to 30 GB per month! <br>
             <br>
                                </li>
                                <li><strong>POP EMail Boxes </strong><br>
          Begin showing off your domain name with your very own email addresses. Easily create and manage Email boxes for employees in your company, and separate departments. Each POP3 email box is also accessible online with "WebMail" from anywhere in the world. <br>
          <br>
                                </li>
                                <li><strong>Databases</strong><br>
          All accounts are compatible with Microsoft Access databases which can be easily uploaded to your web sites.  All plans come with mysql database access. <br>
          <br>
          Upgrade to a Microsoft SQL SERVER, as well as MySQL databases upgrades are available at an additional monthly fee. A powerful tool for dynamic web sites. <br>
          <br>
          <br>
                              </li>
                                <li><strong>Multiple Web Sites per account (Up to 50 domains!) </strong></li>
                                <li><strong>Powerful Web Hosting Control Panel </strong></li>
                                <li><strong>Secure Data Centers and 
          24/7 real time system monitoring </strong></li>
                                <li><strong>You can purchase and manage multiple Hosting Accounts </strong></li>
                                <li><strong>Site Statistics <br>
                                  <br>
                                </strong>                                </li>
                              <li><strong>ASP - ASP.NET - XML - HTML - PHP - MySQL - MsSql<br>
                              <br>
                              </strong></li>
                                  <div align="center">
<div align="center"><a onclick="window.open(&quot;popUps/hostingobjects.php&quot;,&quot;&quot;,&quot;width=150,height=150,status=no,scrollbars=0,resizable=0,location=no,menubar=no,toolbar=no,left=360,top=360&quot;);return false;" target="_blank" href="popUps/hostingobjects.php"><b>View installed Com objects</b></a></div>
                            </ul></td>
                        </tr>
                      </table>     
		            <td width="48%" class="OutlineOne" valign="top">
		              <span class="BasicText"><center><strong><u>Web Hosting Plans</u></strong></center></span>
		              <center>            <?php
//Set $i equal to hosting package Number
$PackageCount  = $Enom->Values[ "PackageCount" ];
for ( $i = 1; $i <= $PackageCount ; $i++ ){

//Get Enon Variables
$PackageID  = $Enom->Values[ "PackageID"."$i" ];
$PackageName = $Enom->Values[ "PackageName"."$i" ];
$BandwidthGB = $Enom->Values[ "BandwidthGB"."$i" ];
$WebStorageMB = $Enom->Values[ "WebStorageMB"."$i"];
$DatabaseType = $Enom->Values[ "DatabaseType"."$i"];
$POPMailBoxes = $Enom->Values[ "POPMailBoxes"."$i"];
$DBStorageMB = $Enom->Values[ "DBStorageMB"."$i"];
include("include/dbconfig.php");	//Rename to Enom2 Since Looping the Variables
		$Enom2 = new CEnomInterface;
		$Enom2->AddParam( "uid", $enom_username );
		$Enom2->AddParam( "pw", $enom_password );
		$Enom2->AddParam( "command", "CalculateAllHostPackagePricing" );
		$Enom2->AddParam( "PackageName$i", $PackageName );
		$Enom2->AddParam( "enduserip", $enduserip );
		$Enom2->AddParam( "site", $sitename );
		$Enom2->AddParam( "User_ID", $_SESSION['id'] );
		$Enom2->DoTransaction();

$SellPrice = $Enom2->Values[ "SellPrice"."$i"];

//Change the way the Storage shows for Access Databases
if ($DBStorageMB == '0'){
$DBStorageMB = 'Access';
$MB = "";
} else {
$MB = "MB";
}
//Change the way the Database Type shows for Access Databases
if ($DatabaseType == 'Access'){
$DatabaseType = 'Database';
}


//Start Building results table
					   		
					

				  echo 		  "<table width=\"350\" border=\"0\" class=\"tableO1\" align=\"center\"><form method=\"post\" action=\"orderhosting.php?PackageName=$PackageName&PackageID=$PackageID&BandwidthGB=$BandwidthGB&WebStorageMB=$WebStorageMB&DBStorageMB=$DBStorageMB&POPMailBoxes=$POPMailBoxes&DatabaseType=$DatabaseType&SellPrice=$SellPrice\" id=\"form1\" name=\"form1\"><tr>";
                  echo        "<td colspan=\"4\" class=\"titlepic\"><span class=\"whiteheader\">Plan $i:  $PackageName</span></td></tr><tr>";
                  echo        "<td width=\"25%\" class=\"titlepic\"><span class=\"whiteheader\"> Bandwidth </span></td>";
                  echo        "<td width=\"25%\" class=\"titlepic\"><span class=\"whiteheader\"> Storage</span> </td>";
                  echo        "<td width=\"25%\" class=\"titlepic\"><span class=\"whiteheader\"> Database</span> </td>";
                  echo        "<td width=\"35%\" class=\"titlepic\"> <span class=\"whiteheader\">Email Accts </span></td></tr><tr>";
                  echo        "<td width=\"25%\" >$BandwidthGB GB</td>";
                  echo        "<td width=\"25%\" >$WebStorageMB MB</td>";
                  echo        "<td width=\"25%\" >$DBStorageMB $MB</td>";
                  echo        "<td width=\"25%\" >$POPMailBoxes</td>";
                  echo        "<tr><td colspan=\"3\" class=\"titlepic03\"><span class=\"whiteheader\">Monthly Price: \$$SellPrice</span></td>";
				  echo	      "<td colspan=\"1\"><input name=\"Purchase\" type=\"image\" src=\"images/btn_purchase.gif\" align=\"middle\" border=\"0\"/></td></tr>";
				  echo  	  "<tr><td colspan=\"1\" ><input type=\"hidden\" name=\"PackageID\" value=\"$PackageID\"></td>";
				  echo 		  "<td><input type=\"hidden\" name=\"PackageName\" value=\"$PackageName\"></td>";
				  echo 		  "<td><input type=\"hidden\" name=\"BandwidthGB\" value=\"$BandwidthGB\"></td>";
				  echo 		  "<td><input type=\"hidden\" name=\"WebStorageMB\" value=\"$WebStorageMB\"></td></tr>";
				  echo 		  "<tr><td><input type=\"hidden\" name=\"DatabaseType\" value=\"$DatabaseType\"></td>";
				  echo 		  "<td><input type=\"hidden\" name=\"POPMailBoxes\" value=\"$POPMailBoxes\"></td>";
				  echo 		  "<td><input type=\"hidden\" name=\"DBStorageMB\" value=\"$DBStorageMB\"></td>";
				  echo 		  "<td align=\"center\"><input type=\"hidden\" name=\"SellPrice\" value=\"$SellPrice\"></td></tr> <tr><td colspan=\"4\" align=\"center\"></td><br></form></table>";
				}
 ?>
                      </center>
          </table>                    
</table>
</table>
		          <?php include('include/footer.php');?>