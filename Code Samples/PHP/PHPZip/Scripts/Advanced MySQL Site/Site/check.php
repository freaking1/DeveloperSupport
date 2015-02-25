<?php
session_name ('API-PHPSESSID');
session_start(); // Start the session.
ob_start();

	$username = $_COOKIE['loggedin_user'];
	$user_id = $_COOKIE['id'];


	include('include/dbconfig.php');
	include( "include/EnomInterface_inc.php" );
	// Get vars
	$cAction = $HTTP_POST_VARS[ "action" ];
	$tld = $HTTP_POST_VARS[ "tld" ];
	$sld = $HTTP_POST_VARS[ "sld" ];
	$bError = 0;
	$bAvailable = 0;
	
	// Do we need to check a name?
	if ( $cAction == "check" ) {
		// Create an instance of the url interface class
 		$Enom = new CEnomInterface; 
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", $_SESSION['id'] );
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "command", "check" );
		$Enom->DoTransaction();
	
			$today = date("m-d-y H:i", time());
			$error_count = $Enom->Values[ "ErrCount" ];
				if($error_count == '0'){
					$was_error = "0";
					$error_msg = "No Error";
				} else {
					$was_error = "1";
					$error_msg = $Enom->Values[ "Err1" ];
					}
			$query = "INSERT INTO check_log (username, date, ip, sld, tld, was_error, error_msg)
					VALUES ('$username', '$today', '$enduserip', '$sld', '$tld', '$was_error', '$error_msg')";
			$result = @mysql_query ($query);
				if(!$result) {
					echo "Logging Failed - Please contact support at $support_email"; 
					}
	
		// Were there errors?
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			// Yes, get the first one
			$cErrorMsg = $Enom->Values[ "Err1" ];
			$bError = 1;
		} else {
			// No interface errors
			$bError = 0;
			
			// Check code from NSI (210 = name available)
			switch ( $Enom->Values[ "RRPCode" ] ) {
			case "210":
				// The name is available
				$bAvailable = 1;
				break;
				
			case "211":
				// The name is not available
				$bAvailable = 0;
				break;
				
			default:
				// There was an error from NSI
				$bError = 1;
				$cErrorMsg = $Enom->Values[ "RRPText" ];
				break;
			}
		}
	}
	//Page name - DO NOT CHANGE
	$PageName = "Check";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Check for a domain name";
	
	
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
				  <td height="19" colspan="3"  class="titlepic"><span class="whiteheader">Register Domain Name</span><b>                                 </b></td>
			    </tr>
				<tr>
			      <td height="18" colspan="3" valign="top" >&nbsp;</td>
			</tr>
			
			<tr> 
				<td width="1%" height=50 align="center" valign="middle">&nbsp;</td>
			  <td width="99%" colspan="3">
			      </p>
			        <table width="352" border="0" align="center" cellpadding="2" cellspacing="2" class="tableO1">
                      <form method="post" action="check.php" id="form1" name="form1">
                        <input type="hidden" name="action" value="check">
                        <tr><br>
                            <td colspan="2" valign="left" class="titlepic"><span class="whiteheader"> DOMAIN NAME SEARCH </span></td>
                        </tr>
                        <tr>
                          <td valign="middle" align="center" width="3">&nbsp;</td>
                          <td width="295" align="center" valign="middle">www.
                            <input type="text" maxlength="272" name="sld"value="<?php echo $HTTP_POST_VARS[ "sld" ]; ?>" id="sld">
&nbsp;.&nbsp;
        <?php include ('include/tldlist/tldListOne.php'); ?></td>
                        </tr>
                        <tr class="tableO1">
                          <td valign="middle" align="center" colspan="2">
                            <input name="image2" type="image" src="images/btn_check.gif" border="0">
                            <br />
                            <br>                            </td>
                        </tr>
                      </form>
		            </table>		<br>
		            <table width="352" border="0" align="center">
                      <tr>
                        <td><?php if ( $cAction == "check" ) {
						 if ( $bError == 1 ) {
							// There was some kind of error, print that out
							echo "<strong class=\"BasicText\">Error</strong>";
						} else if ( $bAvailable == 0 ) {
							// The domain name is already registered
							echo "<strong class=\"BasicText\">Already registered</strong>";
						} else if ( $bAvailable == 1 ) {
							// The domain name is available, display a link to go register it
							echo "<strong class=\"BasicText\">Congratulations!</strong>";
						} else {
							// If we get here the page didn't work right
							echo "<strong class=\"BasicText\">Unknown error</strong>";
						}
					}?></td>
                      </tr>
                    </td>
  </tr>
  <tr>
    <td nowrap><?php if ( $cAction == "check" ) {
						if ( $bError == 1 ) {
							// There was some kind of error, print that out
							echo "We're sorry, there was an error checking the availability of the domain name <span class=\"basictext\"><b>$sld.$tld</b></span>. <br />";
							echo "The error was <strong class=red>\"$cErrorMsg\"</strong>";
							if ($tld == "name") {
								echo "<br /><br />";
								echo ".name SLD formatting must be like this: <span class=\"basictext\"><strong>firstname.lastname.name</strong>";
								echo "<br />";
								echo "Example:&nbsp;<strong>john.doe.name</strong>";
							}
						} else if ( $bAvailable == 0 ) {
							// The domain name is already registered
							echo "<strong>We're sorry, the domain name <span class=\"basictext\"><b>$sld.$tld";
							echo "</b><br /> has already been registered.</strong><br /><br />";
						} else if ( $bAvailable == 1 ) {
						$Domain = "$sld.$tld";
							// The domain name is available, display a link to go register it
							echo "<strong>The domain name <span class=\"basictext\"><b>$sld.$tld</span>";
							echo "</b> is available!<br /> <a href=\"addtocart.php?Domain=$Domain&prodid=1&referer=check&command=addtocart";
							echo "\">Register it now by clicking ";
							echo "here!</a></strong><br /><br /><b>Or Register one of the domains below:</b>";
						} else {
							// If we get here the page didn't work right
							echo "Unknown error. Please try again!";
						}
					}
					?>
					</td>
  </tr>
</table>
              <?php
	if ( $cAction == "check" ) {
	
 		$Enom = new CEnomInterface; 
		$Enom->AddParam( "uid", $enom_username );
		$Enom->AddParam( "pw", $enom_password );
		$Enom->AddParam( "enduserip", $enduserip );
		$Enom->AddParam( "site", $sitename );
		$Enom->AddParam( "User_ID", $_SESSION['id'] );
		$Enom->AddParam( "tldlist", "com,net,org,us,biz,info,name,co.uk,org.uk" );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "command", "check" );
		$Enom->DoTransaction();
		
			echo '        <table class="tableO1" align="center" valign="center" width="335" border="0">
                      <tr>
                        <td width="308"></td>
                      </tr>';

$DomainCount = $Enom->Values[ "DomainCount" ];
for ( $i = 1; $i <= $DomainCount  ; $i++ ){
$Domain  = $Enom->Values[ "Domain"."$i" ];
$RRPCode = $Enom->Values[ "RRPCode"."$i" ];
$RRPText = $Enom->Values[ "RRPText"."$i" ];
$AuctionID = $Enom->Values[ "AuctionID"."$i"];
$AuctionDate = $Enom->Values[ "AuctionDate"."$i"];

switch($RRPCode) {
			case "210":
				// The name is available
				$RRPText = "<a href=\"addtocart.php?Domain=$Domain&numyears=1&prodid=1&referer=check&command=addtocart\">Add to cart</a>";
				break;
			case "211":
				if($AuctionID){
				//it is in auction, so lets take them to the auction page
				$RRPText = "<a href=\"auctions.php?Domain=$Domain&date=$date&auction_id=$auction_id\">Currently in Auction!</a>";
				} else {
				//The domain is not in auction, so dont do anything
				$RRPText = "Taken</a>";
				}
				break;
			case "0":
				$RRPText = "Results are Unknown at this time";
				break;
			default:
				$bError = 1;
				$RRPText = $Enom->Values[ "RRPText"."$i" ];
			break;		
				}
				      echo "
                      <tr>
                      <td align=\"left\" NoWrap >$Domain</td>
                      <td class=\"BasicText\" align=\"center\" NoWrap ><b>$RRPText</b></td>
					  <td><input type=\"hidden\" name=\"Domain\" value=\"$Domain\"></td>
					  <td><input type=\"hidden\" name=\"auction_id\" value=\"$AuctionID\"></td>
				  	  <td><input type=\"hidden\" name=\"date\" value=\"$AuctionDate\"></td>
                      </tr>";
					}
				}
				
?></table>
	      </td>
              </tr>
                      <tr>
                        <td><p>&nbsp;</p>
                        <p>&nbsp;</p></td>
                      </tr>
                      <tr>
                        <td height="2"></td>
                      </tr>
              </table>
	      <tr>
	              <td height="2" colspan="3" valign="top" class="content2">     </td>  
				</table>  <?php include('include/footer.php');?>         
</table>
					  </table>