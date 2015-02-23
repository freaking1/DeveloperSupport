<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");
include("include/header.php");?>

<tr>
    <td width="100%" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td width="18%" valign="top" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td width="34%" align="center">&nbsp;</td>
        <td width="23%" align="left" class="BasicText" valign="top" >        
        <td width="18%" align="center" valign="top"> <div align="left"></div>
        </td>
      </tr>
      <tr valign="top">
        <td colspan="3" rowspan="6" valign="top" align="center"><br>
          <br>
        <table valign="top" width="85%" border="0" cellpadding="0" cellspacing="0" class="tableO1" valign="top">
            <tr valign="top">
              <th class="formfield" valign="top" scope="col">Welcome to the <?=$CompanyName;?> administration section </th>
            </tr>
            <tr valign="top">
              <td><p align="left">Here you will find a few tools to help administer your users and your domains. Some of the tools:<br>
                <br>
                <strong>User Manager:</strong><br>
                Allows you to View, Add, and Delete users to the system.</p>
                <p align="left"><strong>Domain Manager:</strong><br>
                  Allows you to view, delete and add domains to the system. You can also use this to update domains status manually, manually mark domains as expired, give domains access to name my map/phone, etc. <br>
                Note:  This only adds to the database here, this makes no changes at enom.</p>
                <p align="left"><strong>News manager:</strong><br>
                You use this utility to view and edit the news that appears on the users &quot;Overview&quot; page. This is the landing page all users go to once they succesfully login. You can delete, add, and update news items. Only the first 6 are displayed on the page.</p>
                <p align="left"><strong>Hosting Manger:</strong><br> 
                  Allows you to view, delete and add and upgrade/downgrade hosting accounts in the system. You can also use this to upgrade/downgrade plans to custom packages. <br>
Note: Adding hosting plans here only adds to the database, and does not create the account at enom. <br> 
All other functions (like password changes, upgrade/downgrade, cancellation, etc.) take effect at enom. Use these tools with caution.</p>
                <p align="left"><strong>Statistics:</strong><br>
                Basic site statistics and logs.</p>
                <p align="left"><strong>Queue Items:</strong><br>
                View Items that are in the queue and have not yet been paid for or processed.</p>
                <p align="left"><strong>Failed order Logs:</strong><br>
                This is where all failed orders go.  Use this to look up the Qstring and Raw response directly from the enom api. This is REQUIRED when sending support requests to enom. Enom generally can not assist with out this.</p>
                <p align="left"><strong>Admin Tools</strong>:<br>
                This section offers a few rarely needed but helpfull tools such as a domain importer script, domain syncronization, and database table optomizer.</p>
                <p align="left"><strong>Contact Forms:</strong><br>
                  Users can submit contact forms from the website. These forms are tracked in the database along with your response. Go to this section to view submitted, answered, and unanswered contact form submitals. <br> 
                  <br>
                </p></td>
            </tr>
          </table><br><br>
      </tr>
<?php include("include/footer.php");?>
    </table>    