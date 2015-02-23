<?php
	include( "include/sessions.php" );
	ini_set('session_cookies','1');
		$sld = $_GET['sld'];
		$tld =	$_GET['tld'];

		if($sld == ""){
			header ("Location: Check.php");
			exit;
		}
		
		$action = $_GET['action'];
		$method = $_GET['method'];
		
		$_SESSION["enomprice"] = $price;
		$_SESSION["enommethod"] = $method;
		
	$PageName = "Success";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = "Pay for your domain name.";

		setcookie ("enomsld", $_GET['sld']);
		setcookie ("enomtld", $_GET['tld']);
		setcookie ("enomprice", $price);
		setcookie ("enommethod", $_SESSION["enommethod"]);
		setcookie ("enomordertype", $action);

	//This file must be inluded.
	include('include/header.php'); 
	
	$process = $_GET['process'];
	
if($process == "yes"){
	$showprocessing = 1;
	
	$PaypalAuthKey2 = $_POST["PaypalAuthKey2"];
	
		if($PaypalAuthKey2 != $PaypalAuthKey){
				header ("Location: Check.php");
				exit;
		}
	
		require('include/config.inc.php'); 
		require('include/global_config.inc.php');
		echo "<body onLoad=\"document.paypal_form.submit()\">";
		echo "	<form method=\"post\" name=\"paypal_form\" action=\"$paypal[url]\">";
		showVariables(); 
		echo '</form>';
	}
	
$cancel = $_GET['cancel'];	
	if($cancel == 'yes'){
		// Unset all of the session variables.
		$_SESSION = array();
		
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (isset($_COOKIE[session_name()])) {
		   setcookie(session_name(), '', time()-42000, '/');
		}
		
		// Finally, destroy the session.
		session_destroy();
		
		setcookie ("enomsld", '', 0);
		setcookie ("enomtld", '', 0);
		setcookie ("enomprice", '', 0);
		setcookie ("enommethod", '', 0);
		setcookie ("enomordertype", '', 0);
		session_start;
		header ("location: $site_url/index.php");
		exit;
	}

?>
	<tr> 
		<td class="OutlineOne"><br /> 
      		<table class="tableOO" cellSpacing="1" cellPadding="5" width="720" border="0" align="center">
      <tr> 
        <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Choose 
          Payment method:</span></td>
      </tr>
      <tr> 
        <td width="5%" align="center" valign="middle" class="row1">&nbsp;</td>
        <td colspan="2" align="center" valign="middle" class="row1">
<table width="58%" border="0" bgcolor="#CCCCCC">
            <tr> 
              <td colspan="2" align="center">Order Details</td>
            </tr>
            <tr> 
              <td width="33%"><div align="left">Domain name:</div></td>
              <td width="67%"><?php echo "$sld.$tld";?> <div align="left"></div></td>
            </tr>
            <tr> 
              <td >Number of Years:</td>
              <td ><?php echo $numyears;?></td>
            </tr>
            <tr> 
              <td>Total cost:</td>
              <td><?php echo $price;?></td>
            </tr>
          </table>
          <p>Please select a payment method below:</p>
          <table width="36%" border="0">
          <?php
		  if($UseCreditCard == 1){
		  ?>  <tr>
              <td width="59%"><div align="center">
			  		<form method="post" action="<?php echo "RegisterName.php"?>">
					<input type="hidden" name="price" value="<?php echo $price;?>">
					<input type="hidden" name="tld" value="<?php echo $tld;?>">
					<input type="hidden" name="sld" value="<?php echo $sld;?>">
					<input type="hidden" name="method" value="creditcard">
                  <input name="Submit" type="image" value="Submit" src="images/creditcard.JPG">
                </form>
				</div></td>
              <td width="41%"><div align="center">Credit Card</div></td>
            </tr> <? } 
          if($usepaypal == 1 ){ ?><tr>
              <td><div align="center">
			  		<form method="post" action="<?php echo "payforname.php?sld=$sld&tld=$tld&method=paypal&process=yes"?>">
					<input type="hidden" name="amount" value="<?php echo $price;?>">
					<input type="hidden" name="custom" value="<?php echo $PaypalAuthKey;?>">
					<input type="hidden" name="PaypalAuthKey2" value="<?php echo $PaypalAuthKey;?>">
					<input type="hidden" name="item_name" value="<?php echo "$CompanyName - $sld.$tld";?>">
                  <input name="Submit" type="image" value="Submit" src="images/paypal_logo.gif">
                </form>
              <td> <div align="center">Paypal </div></td>
            </tr><? } ?>
          </table>
		  <?php
		  if($showprocessing == 1){
		  		echo "Processing. . . .   This can take up to 30 seconds.<br />";
			}
		?>
          <img src="images/blank.gif" width="5" height="15" border="0" /><br>
          <a href="payforname.php?cancel=yes">CANCEL</a> <br /> 
        </td>
        <td width="5%" align="center" valign="middle" class="row1">
		<img src="images/blank.gif" width="8" height="10" border="0" /></td>
      </tr>
    </table>
		  <br />
		</td>
	</tr>	
	<? include('include/footer.php'); ?>