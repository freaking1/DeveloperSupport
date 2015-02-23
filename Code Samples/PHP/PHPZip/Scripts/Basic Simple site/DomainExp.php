<?php

$RegStatus = $_SESSION['RegStatus'];
	if($RegStatus == 1){
	$Link = 'DomainMain.php';
	} elseif($RegStatus == 0){
	$Link = 'DomainMainHosted.php';
	}
	include( "include/sessions.php" );
	include( "include/DomainFns_inc.php" );
	include( "include/LoggedIn.php" );
	include( "include/EnomInterface_inc.php" );
	
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
		
  	$Enom = new CEnomInterface;
		if ( $HTTP_POST_VARS[ "action" ] == "addyears" ) {
		$Enom->NewRequest();
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
		$Enom->AddParam( "command", "getcontacts" );
		$Enom->DoTransaction();
		
		$nNumErrors = $Enom->Values[ "ErrCount" ];
		
		if ( $nNumErrors > 0 ) {
			echo "There were errors:<br />";

			for ( $i = 1; $i <= $nNumErrors; $i++ ) {
				echo"$i) {$Enom->Values[ "Err" . $i ]}<br />";
			}
		} else {
			$RegistrantOrganizationName		= $Enom->Values[ "RegistrantOrganizationName" ];
			$RegistrantFirstName			= $Enom->Values[ "RegistrantFirstName" ];
			$RegistrantLastName				= $Enom->Values[ "RegistrantLastName" ];
			$RegistrantAddress1				= $Enom->Values[ "RegistrantAddress1" ];
			$RegistrantCity					= $Enom->Values[ "RegistrantCity" ];
			$RegistrantEmailAddress			= $Enom->Values[ "RegistrantEmailAddress" ];
			$RegistrantPostalCode			= $Enom->Values[ "RegistrantPostalCode" ];
		}

		// Get all the contact information
		$Enom->NewRequest();
  		
  		// Set account username and password
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
  		// Set domain name
  		$Enom->AddParam( "tld", $tld );
  		$Enom->AddParam( "sld", $sld );
  		
  		// Set number of years to extend
  		if ( $HTTP_POST_VARS[ "numyears" ] != "" ) {
  			$Enom->AddParam( "NumYears", $HTTP_POST_VARS[ "numyears" ] );
  		}  		
		
		// Fill in registrant contact information
  		$Enom->AddParam( "RegistrantEmailAddress", $RegistrantEmailAddress );
  		$Enom->AddParam( "RegistrantCity", $RegistrantCity );
  		$Enom->AddParam( "RegistrantAddress1", $RegistrantAddress1 );
  		$Enom->AddParam( "RegistrantLastName", $RegistrantLastName );
  		$Enom->AddParam( "RegistrantFirstName", $RegistrantFirstName );
  		$Enom->AddParam( "RegistrantOrganizationName", $RegistrantOrganizationName );
  		$Enom->AddParam( "RegistrantPostalCode", $RegistrantPostalCode );

		$Enom->AddParam( "UseCreditCard", "yes" );
		$Enom->AddParam( "CreditCardNumber", $HTTP_POST_VARS[ "CreditCardNumber" ] );
		$Enom->AddParam( "CreditCardExpMonth", $HTTP_POST_VARS[ "CreditCardExpMonth" ] );
		$Enom->AddParam( "CreditCardExpYear", $HTTP_POST_VARS[ "CreditCardExpYear" ] );
		$Enom->AddParam( "CCName", $HTTP_POST_VARS[ "CCName" ] );
		$Enom->AddParam( "CardType", $HTTP_POST_VARS[ "CardType" ] );
		$Enom->AddParam( "CCAddress", $HTTP_POST_VARS[ "CCAddress" ] ); //Address of the credit card owner
		$Enom->AddParam( "CCZip", $HTTP_POST_VARS[ "CCZip" ] ); //Zip code of the credit card owner
		$Enom->AddParam( "CVV2", $HTTP_POST_VARS[ "CVV2" ] ); //Card verification number// You will need to adjust the pricing		
		
		$Enom->AddParam ("ChargeAmount", $price) ;
  		$Enom->AddParam( "EndUserIP", $enduserip );
  		$Enom->AddParam( "command", "extend" );
  		$Enom->DoTransaction();
  		
  		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
  			$cErrorMsg = $Enom->Values[ "Err1" ];
  			$bError = 1;
  		} else {
			header ("Location: DomainMain.php");
			exit;
		}
	}
	$PageName = "DomainExp";
	$PageTitle = $SiteTitle . " - Update Your NameServers.";
	include('include/header.php'); 
?>

<tr> 
	<td class="OutlineOne">  <table class="tableOO" cellspacing="1" cellpadding="5" width="720" border="0" align="center">
      <form method="post" action="DomainExp.php" id="form1" name="form1">
        <input type="hidden" name="action" value="modify">
        <!-- begin page content -->
        <tr> 
          <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Expiration 
            Date Extension</span></td>
        </tr>
        <tr>
          <td align="center" valign="middle" class="row1" colspan="3"><span class="main">
            <?php
					// Create URL Interface class
					$Enom = new CEnomInterface;
				
					$Enom->NewRequest();
					$Enom->AddParam( "uid", $username );
					$Enom->AddParam( "pw", $password );
					$Enom->AddParam( "tld", $tld );
					$Enom->AddParam( "sld", $sld );
					$Enom->AddParam( "command", "getwhoiscontact" );
					$Enom->DoTransaction();
					if ($Enom->Values[ "Whoisregistration-expiration-date" ] != ""){
						$fooba = $Enom->Values[ "Whoisregistration-expiration-date" ]; 
						$expdate = substr($fooba,0,10);
						list ($year, $day, $month) = explode("-", $expdate);
					} else {
						$fooba = $Enom->Values[ "Whoisexdate" ];
						$expdate = substr($fooba,0,10);
						list ($year, $day, $month) = explode("-", $expdate);
					}
					$timestamp = time();
					$curYear = strftime("%Y", $timestamp);
					$yearsAvail = 9 - ($year - $curYear);
					
					if ($yearsAvail <= 0) {
						$noMoreYears = 1;
						echo "<br />";
						echo "Your Domain Name already has 9 years of registration, <br />plus the remainder of this year. This is the maximum allowed.";
						echo "<br /><br />";
						echo "<a href=\"javascript:history.back();\"><img src=\"images/btn_back.gif\" border=\"0\" width=\"74\" height=\"22\"></a>";
						echo "<br />";
						echo "<br />";
					} else {
						// Make sure it was successful
						if ( $Enom->Values[ "ErrCount" ] == "0" ) {
							//pront out the expiration date
							echo "<br />";
							if ($bError == 1) {
								echo "ERROR&nbsp;:&nbsp;";
								echo "<b class=red>" . $cErrorMsg . "</b>";
							}
							echo "<br />";
							echo "<br />";
							echo "<span class=\"main\">Expiration Date:</span>";
							echo "&nbsp;<strong class=red>";
							echo $day . "/" . $month . "/" . $year;
							echo "</strong><br /><br />";
							echo "Number of years to renew : ";
							echo "<select name=\"numyears\" id=\"numyears\">";
							for ($i=1;$i<=$yearsAvail;$i++){
								if ($i < 0) {
									echo "<option>--</option>";
								} else {
									echo "<option value=\"" . $i . "\">" . $i . "</option>";
								}
							}
							echo "</select>";
							echo "<br /><br />";
						} else {
							// The eNom server returned an error, print it out
							echo "<br /><br /><span class=\"red\" align=\"center\" colspan=\"3\">There were errors getting the Expiration Date: ";
							echo $Enom->Values[ "Err1" ] . "<br /><br /></span>";
						}
					}
				?>
            </span></td>
          <td align="center" valign="middle" nowrap class="row1">&nbsp;</td>
        </tr>
        <tr> 
          <td width="40%" align="center" valign="middle" class="row1" colspan="3"><span class="main">Price 
            per year: <?=$price;?> </span></td>
          <td width="5%" align="center" valign="middle" nowrap class="row1"><img src="images/blank.gif" width="8" height="10" border="0"></td>
        </tr>
        <?php 
			if ($noMoreYears != 1) {
			?>
        <? include ('include/creditcard.php'); ?>
        <? // Apply changes section ?>
        <tr> 
          <td colspan="2" valign="middle" align="right" class="row1"> <input type="image" name="image" src="images/btn_submit.gif" width="79" height="25" border="0"> </span>
          </td>
          <td colspan="2" valign="middle" class="row1">&nbsp;&nbsp; <a href="<?=$Link;?>"><img src="images/btn_cancel.gif" border="0" width="74" height="22"></a> 
          </td>
        </tr>
        <?php } ?>
      </form>
      <!-- end of page content -->
    </table></td>
</tr>
		  
	<? include('include/footer.php'); ?>