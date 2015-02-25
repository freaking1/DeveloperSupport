<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

//Get the post for what page to show
$show = $_GET["show"];

// Number of records to show per page:
$display = 15;
	
include("include/header.php");?>
<tr>
    <td width="100%" valign="top" height="110"><table width="100%" border="0" valign="top" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td width="18%" valign="top" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td align="center">         <div align="left"></div></td>
      </tr>
      <tr> <span class=\"BasicText\"></span>
        <td rowspan="6" valign="top" align="center"><br>
          <br>          <table width="85%" valign="top" border="0" cellpadding="0" cellspacing="0" class="tableO1">
            <tr>
              <th class="formfield" scope="col">Import Domains </th>
            </tr>
            <tr>
              <td><p align="left">This script will import any domain in your enom account into the admin users account here - the first user you setup during installation. This is done on purpose for security, and to avoid giving the wrong people domains. This method forces you to go to the domain manager and assign to the proper user. </p>
              <p align="left">This may take 30 seconds, up to 5-10 minutes depending on the number of domains being imported. <br>
                <br>
                The link will open a new pop up window. Do not hit refresh, back, or close the page - even if the page appears to be blank. </p>
              <p align="center">             
<a href="domainimport.php" target="_blank" style="font-weight: bold" onclick="window.open(&quot;domainimport.php&quot;,&quot;&quot;,&quot;width=500,height=500,status=no,scrollbars=1,resizable=1&quot;);return false;"> When your ready, click here:</a></p></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
          <br>
          <table width="85%"  border="0" cellpadding="0" cellspacing="0" class="tableO1">
            <tr>
              <th class="formfield" scope="col">Sync Domains </th>
            </tr>
            <tr>
              <td><p>This script will sync all the expired domains in your application database. It will mark domains as expired that are supposed to be expired or are expired at enom, and mark domains in RGP (redemption) status. <br>
                <br>
                This may take 30 seconds, up to 5-10 minutes depending on the number of domains being imported. <br>
                      <br>
  The link will open a new pop up window. Do not hit refresh, back, or close the page - even if the page appears to be blank.</p>
                <p align="center">             
<a href="domainsync.php" target="_blank" style="font-weight: bold" onclick="window.open(&quot;domainsync.php&quot;,&quot;&quot;,&quot;width=500,height=500,status=no,scrollbars=1,resizable=1&quot;);return false;"> When your ready, click here:</a></p></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>   
          <br>
          <table width="85%"  border="0" cellpadding="0" cellspacing="0" class="tableO1">
            <tr>
              <th class="formfield" scope="col">Optomize Database </th>
            </tr>
            <tr>
              <td><p>This will optomize your database tables. This is typically done automatically during the queue processing, but you can run it manually as well. Use this at your own risk. The link will open a new pop up window.</p>
                  <p align="center"> <a href="optomize.php" target="_blank" style="font-weight: bold" onclick="window.open(&quot;optomize.php&quot;,&quot;&quot;,&quot;width=350,height=285,status=no,scrollbars=1,resizable=1&quot;);return false;"> When your ready, click here:</a></p></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>          <p>&nbsp;</p>
        </tr>
<?php include("include/footer.php");?>
    </table>    