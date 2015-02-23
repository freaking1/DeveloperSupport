<?php

$sld = $_SESSION['sld'];
$tld =	$_SESSION['tld'];
$RegStatus = $_SESSION['RegStatus'];
	
if($RegStatus != 1){
	$sld = $_SESSION['sld'];
	$tld =	$_SESSION['tld'];
	$postvars = "sld=$sld&tld=$tld";
	header ("Location: DomainMainHosted.php?$postvars");
	exit;
}

$UseCreditCard = '1'; //Change to 0 to not use Enom's CC Processing

	include( "include/LoggedIn.php" );
	include( "include/sessions.php" );
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );
	
	// Check if we're supposed to modify something
if ( $HTTP_POST_VARS[ "action" ] == "buy" ) {

	if (empty($HTTP_POST_VARS['CreditCardNumber'])) {
		$CreditCardNumber = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CreditCardNumber = $HTTP_POST_VARS[ "CreditCardNumber" ];
		}
	if (empty($HTTP_POST_VARS[ "CreditCardExpMonth" ])) {
		$CreditCardExpMonth = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CreditCardExpMonth = $HTTP_POST_VARS[ "CreditCardExpMonth" ] ;
		}
	if (empty($HTTP_POST_VARS['CreditCardExpYear'])) {
		$CreditCardExpYear = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CreditCardExpYear = $HTTP_POST_VARS[ "CreditCardExpYear" ];
		}
	if (empty($HTTP_POST_VARS['CCName'])) {
		$CCName = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CCName = $HTTP_POST_VARS[ "CCName" ];
		}
	if (empty($HTTP_POST_VARS['CardType'])) {
		$CardType = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CardType = $HTTP_POST_VARS[ "CardType" ];
		}
	if (empty($HTTP_POST_VARS['CCAddress'])) {
		$CCAddress = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CCAddress = $HTTP_POST_VARS[ "CCAddress" ];
		}
	if (empty($HTTP_POST_VARS['CCZip'])) {
		$CCZip = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CCZip = $HTTP_POST_VARS[ "CCZip" ];
		}
	if (empty($HTTP_POST_VARS['CVV2'])) {
		$CVV2 = FALSE;
		$message = 'All Required fields are not filled out';
	} else { 
		$CVV2 = $HTTP_POST_VARS[ "CVV2" ];
		}
	if($CreditCardNumber && $CreditCardExpMonth && $CreditCardExpYear && $CCName && $CardType && $CCAddress && $CCZip && $CVV2){
		//Send purchase call to enom
		$Enom = new CEnomInterface;
		$Enom->NewRequest();
		$Enom->AddParam( "tld", $tld );
		$Enom->AddParam( "sld", $sld );
		$Enom->AddParam( "uid", $username );
		$Enom->AddParam( "pw", $password );
  		$Enom->AddParam( "EndUserIP", $enduserip );
		$Enom->AddParam( "command", "getcontacts" );
		$Enom->DoTransaction();
		//echo $Enom->PostString.'<br>';
		if ( $Enom->Values[ "ErrCount" ] != "0" ) {
			// Yes, get the first one
			$message = $Enom->Values[ "Err1" ];
		} else {
			$RegistrantAddress1 = $Enom->Values[ "RegistrantAddress1" ];
			$RegistrantAddress2 = $Enom->Values[ "RegistrantAddress2" ];
			$RegistrantCity = $Enom->Values[ "RegistrantCity" ];
			$RegistrantCountry = $Enom->Values[ "RegistrantCountry" ];
			$RegistrantEmailAddress = $Enom->Values[ "RegistrantEmailAddress" ];
			$RegistrantFirstName = $Enom->Values[ "RegistrantFirstName" ];
			$RegistrantLastName = $Enom->Values[ "RegistrantLastName" ];
			$RegistrantPhone = $Enom->Values[ "RegistrantPhone" ];
			$RegistrantPostalCode = $Enom->Values[ "RegistrantPostalCode" ];
			
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $username );
			$Enom->AddParam( "pw", $password );
			$Enom->AddParam( "tld", $tld );
			$Enom->AddParam( "sld", $sld );
			$Enom->AddParam( "command", "PurchaseServices" );
			$Enom->AddParam( "Service", "IDProtect" );
			$Enom->AddParam( "NumYears", "1" );
			$Enom->AddParam( "RegistrantFirstName", $RegistrantFirstName );
			$Enom->AddParam( "RegistrantLastName", $RegistrantLastName );
			$Enom->AddParam( "RegistrantAddress1", $RegistrantAddress1 );
			$Enom->AddParam( "RegistrantAddress2", $RegistrantAddress2 );
			$Enom->AddParam( "RegistrantCity", $RegistrantCity );
			$Enom->AddParam( "RegistrantCountry", $RegistrantCountry );
			$Enom->AddParam( "RegistrantPostalCode", $RegistrantPostalCode );
			$Enom->AddParam( "RegistrantPhone", $RegistrantPhone );
			$Enom->AddParam( "RegistrantEmailAddress", $RegistrantEmailAddress );
			if ($UseCreditCard == "1") {
				$Enom->AddParam( "UseCreditCard", "yes" );
				$Enom->AddParam( "CreditCardNumber", $CreditCardNumber);
				$Enom->AddParam( "CreditCardExpMonth", $CreditCardExpMonth);
				$Enom->AddParam( "CreditCardExpYear", $CreditCardExpYear);
				$Enom->AddParam( "CCName", $CCName);
				$Enom->AddParam( "CardType", $CardType);
				$Enom->AddParam( "CCAddress", $CCAddress);
				$Enom->AddParam( "CCZip", $CCZip);
				$Enom->AddParam( "CVV2", $CVV2);
				$Enom->AddParam( "ChargeAmount", $idprice);
				}
			$Enom->AddParam( "site", "Enom PHP Script" );
			$Enom->AddParam( "enduserip", $REMOTE_ADDR );
			$Enom->DoTransaction();
			//echo $Enom->PostString;
			
				if ( $Enom->Values[ "ErrCount" ] != "0" ) {
					// Yes, get the first one
					$message .= $Enom->Values[ "Err1" ];
					$bError = 1;
				} else {
					//register OrderID and retrieve it from HTTP VARS
					$_SESSION['OrderID'] = $Enom->Values[ "OrderID" ];
					$_SESSION['LoggedIn'] = 1;
					$_SESSION['tld'] = $tld;
					$_SESSION['sld'] =  $sld;
					$_SESSION['success'] =  1;
					// Redirect to a success page
					header ("Location: SuccessIDP.php");
				  exit;
			}
		}
	}
}
	$PageName = "BuyIdProtect";
	$PageTitle = $SiteTitle . " - By ID Protect.";
	include('include/header.php'); 
?>
<tr> 
	<td class="OutlineOne">
		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
			<tr> 
				<td align="center" valign="middle" class="titlepic"><span class="whiteheader">Buy ID Protect </span></td>
			</tr>
			<tr> 
				<td class="row1">ID Protect is billed at a rate of $<?=$idprice;?> per year. By clicking submit below you are authorizing the charge to your card to provide ID Protection service on <?php echo "$sld.$tld";?> for 1 year.</td>
			</tr>
				<form method="post" action="getidprotect.php" id="form1" name="form1">
				<input type="hidden" name="action" value="buy">
			    <tr> 
				<td align="center" valign="middle" class="row1">
<?  if(isset($message)) {echo '<center><u><b><span class=\"BasicText\">', $message, '</span></b></u></center>';	}	?>

<table class="tableOO"><?php include("include/creditcard.php");?></table></td></tr>
			<tr>
			  <td align="center" valign="middle" class="row1">
			<input name="image1" type="image" id="image1" src="images/btn_submit.gif" border="0">
			<a href="DomainMain.php"><img src="images/btn_cancel.gif" border="0"></td>
			  </tr>
			</form>
	  </table>
	</td>
</tr>
	<? include('include/footer.php'); ?>