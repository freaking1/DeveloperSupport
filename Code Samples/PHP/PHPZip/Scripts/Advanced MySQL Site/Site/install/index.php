<?php
session_name ('API-PHPSESSID-INSTALL');
session_start(); // Start the session.

?>
<link rel="stylesheet" href="../css/styles.css" type="text/css">
<table width="964" align="center" valign="center" class="tableOO">
			  <td><?php include('../include/header.php')?>
	    </tr>
</table>
    <table width="964" height="380" border="0" cellpadding="0" cellspacing="0" class="tableOO" id="table8">
		<tr>
			<td height="313" valign="top">		  
			  <table width="100%" height="218" border="0" valign="center" align="center" cellpadding="0" cellspacing="0" class="content" id="table13">
				<tr>
				  <td height="19" colspan="3"  class="titlepic"><div align="center"><span class="whiteheader">Installation Instructions
				  </span></div></td>
			    </tr>
				<tr>
			      <td height="369" colspan="3" valign="top" class="content2">                  
			        <p>&nbsp;</p>
					
			        <table width="745" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th colspan="2" scope="col"><div align="left">System Requirements: </div></th>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">These scripts were developed for and tested on Linux Red Hat 9.x and Fedora, using php 4.3.11 and apache 1.3.x</td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>NOTE:</td>
                        <td>This set of scripts has been thoroughly tested on Linux. Installations on non - Linux OS's is not guaranteed. Using Windows and IIS is not ideal.</td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">These scripts require the following:</td>
                      </tr>
                      <tr>
                        <td width="39"><div align="left"> </div></td>
                        <td width="706">SSL (either mod_ssl or OpenSSL)</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>PHP version 4.3.x or Higher compiled as a mod </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>Apache/1.3.33 or better </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>.htaccess support </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><p>Safe mode needs to be off, and register globals needs to be on as well for the best performance. </p>
                        <p>In addition the following php variables need to be set:<br>
                          session.auto_start On <br>
                          session.bug_compat_42 Off<br>
                          session.bug_compat_warn off</p>
                        <p>error_reporting 81                           </p>
                        <p>If those three listed above are not set correctly then the script will not work and you will get errors. This is already set for you in the .htaccess files included with the script.</p></td>
                      </tr>
                      <tr>
                        <td>NOTE:</td>
                        <td>If your installation of php does not support .htaccess files then you will need to either create a php.ini file for each folder that contains a .htaccess file or delete all .htaccess files and modify the main servers php.ini file directly. </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><div align="center">1 - </div></td>
                        <td>Unpack the files and upload to your server </td>
                      </tr>
                      <tr>
                        <td><div align="center">2 - </div></td>
                        <td>chmod all files to be 755 </td>
                      </tr>
                      <tr>
                        <td><div align="center">3 - </div></td>
                        <td>chmod include/dbconfig.php to be 644 (chmod 644 include/dbconfig.php) <br>
                        chomd include/cron directory and all files to be 644 (chmod -R 644 include/cron *) </td>
                      </tr>
                      <tr>
                        <td><div align="center">4 - </div></td>
                        <td>Create a database, a user and grant access to the database to the user. This is typically done through your hosting account's control panel. if you are unsure of this part, please contact your hosting provider directly. </td>
                      </tr>
                      <tr>
                        <td><div align="center">5 - </div></td>
                        <td>Edit the dbconfig.php file and insert your data into the file </td>
                      </tr>
                      <tr>
                        <td><div align="center">6 - </div></td>
                        <td>Setup your crontab - replace the path with the actual full path to the files on your server </td>
                      </tr>
                      <tr>
                        <td><div align="center"></div></td>
                        <td>Runs the queue processing every 5 minutes <br>
                          <span class="BasicText"><strong>*/5 0 * * * php -q -f /home/USERNAME/public_html/include/cron/queue.php &gt; /dev/null 2&gt;&amp;1</strong></span></td>
                      </tr>
                      <tr>
                        <td><div align="center"></div></td>
                        <td>Runs the Transfer update process at midnight every night: <br>
                          <span class="BasicText"><strong>0 0 * * * php -q -f /home/USERNAME/public_html/include/cron/transfers.php &gt; /dev/null 2&gt;&amp;1</strong></span></td>
                      </tr>
                      <tr>
                        <td><div align="center"></div></td>
                        <td>Runs the invoice processsing queue at Half past midnight every night: <br>
                          <span class="BasicText"><strong>30 0 * * * php -q -f /home/USERNAME/public_html/include/cron/invoice.php &gt; /dev/null 2&gt;&amp;1</strong></span></td>
                      </tr>
                      <tr>
                        <td><div align="center">7 - </div></td>
                        <td>Upload your own logo, and change the header and footer pages located in the include directory. If you like you can change the css file located in the css folder to change the color scheme of the table outlines, text, and more. </td>
                      </tr>
                      <tr>
                        <td><div align="center">8 - </div></td>
                        <td>At this point the Sample Site should be ready. Browse to http://YourURL/install/install.php and begin the isntallation process. If at any point this fails, please go through the isntallation instructions again. The only chance it has at failing is if one of the above steps is not done properly. </td>
                      </tr>
                      <tr>
                        <td><div align="center">9 - </div></td>
                        <td>When you are ready to go live please go into your enom account, and submit a support center ticket and Include your user name, and the IP address of the computer that is sending the requests.  This is typically your servers Main IP address, but you may want to contact your hosting provider to find out for sure.</td>
                      </tr>
                      <tr>
                        <td><div align="center"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><div align="center">
                          <?php $BegInInstall = 1;
						  $_SESSION['BegInInstall'] = $BegInInstall;
						  ?>
						  <a href="install.php">Start Installation</a>
                        </div></td>
                      </tr>
                    </table>
			        <p>&nbsp;</p>
		        <tr>
            </table></td>
</table>
<?php include('../include/footer.php');?>
