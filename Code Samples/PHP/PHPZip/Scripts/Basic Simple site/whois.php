<?
require( "include/EnomInterface_inc.php" );
require( "include/sessions.php" );

$sld = $_POST[ "sld" ];
$tld = $_POST[ "tld" ];

if($sld == ''){
	$bAvailable = 1;
	}
	
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	$action = $_POST[ "action" ];
	
if ( $action  == "check" ) {
	$Enom = new CEnomInterface;
	$Enom->NewRequest();
	$Enom->AddParam( "uid", $username );
	$Enom->AddParam( "pw", $password );
	// Set domain name
	$Enom->AddParam( "tld", $tld );
	$Enom->AddParam( "sld", $sld );
	$Enom->AddParam( "command", "getwhoiscontact" );
	$Enom->DoTransaction();
	
	
//Checks the Error Flag
	if($Enom->Values[ "ErrCount" ] == 0) {
	// The name is registered
	$bAvailable = 0;
	
	$RegistrantOrganization 		= $Enom->Values[ "RegistrantOrganization" ];
	$RegistrantFName 				= $Enom->Values[ "RegistrantFName" ];
	$RegistrantLName			    = $Enom->Values[ "RegistrantLName" ];
	$RegistrantAddress1			    = $Enom->Values[ "RegistrantAddress1" ];
	$RegistrantAddress2 			= $Enom->Values[ "RegistrantAddress2" ];
	$RegistrantCity 				= $Enom->Values[ "RegistrantCity" ];
	$RegistrantStateProvince 		= $Enom->Values[ "RegistrantStateProvince" ];
	$RegistrantPostalCode 			= $Enom->Values[ "RegistrantPostalCode" ];
	$RegistrantCountry 				= $Enom->Values[ "RegistrantCountry" ];
	$RegistrantPhone 				= $Enom->Values[ "RegistrantPhone" ];
	$RegistrantPhoneExt 			= $Enom->Values[ "RegistrantPhoneExt" ];
	$RegistrantFax 					= $Enom->Values[ "RegistrantFax" ];
	$RegistrantEmailAddress 		= $Enom->Values[ "RegistrantEmailAddress" ];
	
	$AdministrativeOrganization 			= $Enom->Values[ "AdministrativeOrganization" ];
	$AdministrativeFName					= $Enom->Values[ "AdministrativeFName" ];
	$AdministrativeLName					= $Enom->Values[ "AdministrativeLName" ];
	$AdministrativeAddress1					= $Enom->Values[ "AdministrativeAddress1" ];
	$AdministrativeAddress2					= $Enom->Values[ "AdministrativeAddress2" ];
	$AdministrativeCity						= $Enom->Values[ "AdministrativeCity" ];
	$AdministrativeStateProvince			= $Enom->Values[ "AdministrativeStateProvince" ];
	$AdministrativePostalCode				= $Enom->Values[ "AdministrativePostalCode" ];
	$AdministrativeCountry					= $Enom->Values[ "AdministrativeCountry" ];
	$AdministrativePhone					= $Enom->Values[ "AdministrativePhone" ];
	$AdministrativePhoneExt					= $Enom->Values[ "AdministrativePhoneExt" ];
	$AdministrativeFax						= $Enom->Values[ "AdministrativeFax" ];
	$AdministrativeEmailAddress				= $Enom->Values[ "AdministrativeEmailAddress" ];

	// TECHNICAL CONTACT INFORMATION
	$TechnicalOrganization				= $Enom->Values[ "TechnicalOrganization" ];
	$TechnicalFName						= $Enom->Values[ "TechnicalFName" ];
	$TechnicalLName						= $Enom->Values[ "TechnicalLName" ];
	$TechnicalAddress1					= $Enom->Values[ "TechnicalAddress1" ];
	$TechnicalAddress2					= $Enom->Values[ "TechnicalAddress2" ];
	$TechnicalCity						= $Enom->Values[ "TechnicalCity" ];
	$TechnicalStateProvince				= $Enom->Values[ "TechnicalStateProvince" ];
	$TechnicalPostalCode				= $Enom->Values[ "TechnicalPostalCode" ];
	$TechnicalCountry					= $Enom->Values[ "TechnicalCountry" ];
	$TechnicalPhone						= $Enom->Values[ "TechnicalPhone" ];
	$TechnicalPhoneExt					= $Enom->Values[ "TechnicalPhoneExt" ];
	$TechnicalFax						= $Enom->Values[ "TechnicalFax" ];
	$TechnicalEmailAddress				= $Enom->Values[ "TechnicalEmailAddress" ];
	} elseif($Enom->Values[ "ErrCount" ] != 0){
	// The name may not be registered
	$bAvailable = 1;
	$cErrorMsg = "The name $sld.$tld may be available to register. <a href = Check.php>Check it now </a>";
	}
}
	//Page name - DO NOT CHANGE
	$PageName= "Whois Lookup";
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Lookup a domain name";
	//This file must be inluded.
	include('include/header.php'); 
?>
</p>
<table width="560" border="0" align="center" cellpadding="5" cellspacing="5" class="tableOO">
  <tr>
    <th scope="col"><table border="0" cellpadding="2" cellspacing="2" align="center">
  <form method="post" action="whois.php" id="form1" name="form1">
    <input type="hidden" name="action" value="check">
   <tr>
      <td valign="middle" align="center" width="90" class="main">Domain:</td>
      <td valign="middle" align="center"><input type="text" maxlength="272" name="sld" id="idsld">
&nbsp;.&nbsp;
        <?php include ('include/tldListOne2.php'); ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="image2" type="image" src="images/btn_checkavail_g.gif" WIDTH="144" HEIGHT="22" border="0"> <a href="index.php"><input name="image2" type="image" src="images/btn_cancel.gif" border="0"></a></td>
    </tr> 
  </form>
</table></p>
<?php 	
if ($bAvailable == 0)  { 
?>    
<table width="550"  border="0" class="tableOO">
      <tr>
        <th colspan="3" scope="col">Registrant</th>
      </tr>
      <tr>
        <td width="28%">Organization:</td>
        <td colspan="2"><?=$RegistrantOrganization;?></td>
      </tr>
      <tr>
        <td>First Name </td>
        <td colspan="2"><?=$RegistrantFName;?></td>
      </tr>
      <tr>
        <td>Last Name: </td>
        <td colspan="2"><?=$RegistrantLName;?></td>
      </tr>
      <tr>
        <td>Address</td>
        <td colspan="2"><?=$RegistrantAddress1;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><?=$RegistrantAddress2;?></td>
      </tr>
      <tr>
        <td>City:</td>
        <td colspan="2"><?=$RegistrantCity;?></td>
      </tr>
      <tr>
        <td>State/Province:</td>
        <td colspan="2"><?=$TechnicalStateProvince;?></td>
      </tr>
      <tr>
        <td>Zip Code: </td>
        <td colspan="2"><?=$RegistrantPostalCode;?></td>
      </tr>
      <tr>
        <td>Country:</td>
        <td colspan="2"><?=$RegistrantCountry;?></td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td width="41%"><?=$RegistrantPhone;?></td>
        <td width="31%">&nbsp;
            <?php
	if(isset($RegistrantPhoneExt)){
	echo "Ext: $RegistrantPhoneExt";
	}
	?></td>
      </tr>
      <tr>
        <td>Fax:</td>
        <td colspan="2"><?=$RegistrantFax;?></td>
      </tr>
      <tr>
        <td>Email Address: </td>
        <td><?=$RegistrantEmailAddress;?></td>
        <td><div align="center"><a href="mailto:<?=$RegistrantEmailAddress;?>?subject=<?php echo "$sld.$tld";?>">Contact</a></div></td>
      </tr>
    </table>
      <br>
      <table width="550"  border="0" class="tableOO">
        <tr>
          <th colspan="3" scope="col">Administrative</th>
        </tr>
        <tr>
          <td width="28%">Organization:</td>
          <td colspan="2"><?=$AdministrativeOrganization;?></td>
        </tr>
        <tr>
          <td>First Name </td>
          <td colspan="2"><?=$AdministrativeFName;?></td>
        </tr>
        <tr>
          <td>Last Name: </td>
          <td colspan="2"><?=$AdministrativeLName;?></td>
        </tr>
        <tr>
          <td>Address</td>
          <td colspan="2"><?=$AdministrativeAddress1;?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><?=$AdministrativeAddress2;?></td>
        </tr>
        <tr>
          <td>City:</td>
          <td colspan="2"><?=$AdministrativeCity;?></td>
        </tr>
        <tr>
          <td>State/Province:</td>
          <td colspan="2"><?=$AdministrativeStateProvince;?></td>
        </tr>
        <tr>
          <td>Zip Code: </td>
          <td colspan="2"><?=$AdministrativePostalCode;?></td>
        </tr>
        <tr>
          <td>Country:</td>
          <td colspan="2"><?=$AdministrativeCountry;?></td>
        </tr>
        <tr>
          <td>Phone:</td>
          <td width="41%"><?=$AdministrativePhone;?></td>
          <td width="31%">&nbsp;
              <?php
	if(isset($AdministrativePhoneExt)){
	echo "Ext: $AdministrativePhoneExt";
	}
	?></td>
        </tr>
        <tr>
          <td>Fax:</td>
          <td colspan="2"><?=$AdministrativeFax;?></td>
        </tr>
        <tr>
        <td>Email Address: </td>
        <td><?=$AdministrativeEmailAddress;?></td>
        <td><div align="center"><a href="mailto:<?=$AdministrativeEmailAddress;?>?subject=<?php echo "$sld.$tld";?>">Contact</a></div></td>
        </tr>
      </table>
      <br>
      <table width="550"  border="0" class="tableOO">
        <tr>
          <th colspan="3" scope="col">Technical</th>
        </tr>
        <tr>
          <td width="28%">Organization:</td>
          <td colspan="2"><?=$TechnicalOrganization;?></td>
        </tr>
        <tr>
          <td>First Name </td>
          <td colspan="2"><?=$TechnicalFName;?></td>
        </tr>
        <tr>
          <td>Last Name: </td>
          <td colspan="2"><?=$TechnicalLName;?></td>
        </tr>
        <tr>
          <td>Address</td>
          <td colspan="2"><?=$TechnicalAddress1;?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><?=$TechnicalAddress2;?></td>
        </tr>
        <tr>
          <td>City:</td>
          <td colspan="2"><?=$TechnicalCity;?></td>
        </tr>
        <tr>
          <td>State/Province:</td>
          <td colspan="2"><?=$TechnicalStateProvince;?></td>
        </tr>
        <tr>
          <td>Zip Code: </td>
          <td colspan="2"><?=$TechnicalPostalCode;?></td>
        </tr>
        <tr>
          <td>Country:</td>
          <td colspan="2"><?=$TechnicalCountry;?></td>
        </tr>
        <tr>
          <td>Phone:</td>
          <td width="41%"><?=$TechnicalPhone;?></td>
          <td width="31%">&nbsp;
              <?php
	if(isset($TechnicalPhoneExt)){
	echo "Ext: $TechnicalPhoneExt";
	}
	?></td>
        </tr>
        <tr>
          <td>Fax:</td>
          <td colspan="2"><?=$TechnicalFax;?></td>
        </tr>
        <tr>
        <td>Email Address: </td>
        <td><?=$TechnicalEmailAddress;?></td>
        <td><div align="center"><a href="mailto:<?=$TechnicalEmailAddress;?>?subject=<?php echo "$sld.$tld";?>">Contact</a></div></td>
        </tr>
      </table>
      <br>      <?php

/*
# - - - - This section is for future use

switch($tld)
{

	case "net":
	case "com":
	for ( $i = 1; $i <= $Enom->Values[ "WhoisnameserverCount "]; $i++ ){
	$dnsserver .= 	$Enom->Values[ "Whoisnameserver.$i"];
	}
	$Created = $Enom->Values[ "Whoiscreated-date"];
	$Expires = $Enom->Values[ "Whoisregistration-expiration-date "];
	$Updated = $Enom->Values[ "Whoisupdated-date"];
	$Expired = $Enom->Values[ "DomainExpired"];
	$Status	 = $Enom->Values[ "Whoisstatus"];
	break;
	#-----------------
	case "co.uk":
	case "org.uk":
	case "org":
	case "us":
	case "biz":
	case "name":
	case "info":
	for ( $i = 1; $i <= $Enom->Values[ "WhoisnsCount"]; $i++ ){
	$dnsserver.$i = $Enom->Values[ "Whoisns.$i"];
	}
	$Created = $Enom->Values[ "Whoiscrdate"];
	$Expires = $Enom->Values[ "Whoisexdate"];
	$Updated = $Enom->Values[ "Whoisupdate"];
	$Expired = $Enom->Values[ "DomainExpired"];
	$Status	 = $Enom->Values[ "Whoisstatus"];
	break;
	#-----------------
	case "ca":
	for ( $i = 1; $i <= $Enom->Values[ "WhoisnsCount"]; $i++ ){
	$dnsserver.$i = 	$Enom->Values[ "Whoisns.$i"];
	}
	$Created = $Enom->Values[ "WhoisattribrcDate"];
	$Expires = $Enom->Values[ "WhoisattribexDate"];
	$Updated = $Enom->Values[ "WhoisattribapDate"];
	$Expired = $Enom->Values[ "DomainExpired"];
	$Status	 = $Enom->Values[ "Whoisstatus"];
	break;
	#-----------------
	case "nu":
	for ( $i = 1; $i <= $Enom->Values[ "WhoisnameserverCount"]; $i++ ){
	$dnsserver.$i = 	$Enom->Values[ "Whoisnameserver.$i"];
	}
	$Created = $Enom->Values[ "Whoiscreated-date"];
	$Expires = $Enom->Values[ "Whoisregistration-expiration-date"];
	$Updated = $Enom->Values[ "Whoisupdated-date"];
	$Expired = $Enom->Values[ "DomainExpired"];
	$Status	 = $Enom->Values[ "Whoisstatus"];
	break;
	#-----------------
	case "jp":
	case "in":
	for ( $i = 1; $i <= $Enom->Values[ "WhoisnsCount"]; $i++ ){
	$dnsserver.$i = 	$Enom->Values[ "Whoisns.$i"];
	}
	$Created = $Enom->Values[ "Whoiscrdate"];
	$Expires = $Enom->Values[ "Whoisexdate"];
	$Updated = $Enom->Values[ "Whoisupdate"];
	$Expired = $Enom->Values[ "DomainExpired"];
	$Status	 = $Enom->Values[ "Whoisstatus"];
	break;
	#-----------------
	case "ms":
	case "gs":
	case "tc":
	case "vg":
	for ( $i = 1; $i <= $Enom->Values[ "WhoisnsCount"]; $i++ ){
	$dnsserver.$i = 	$Enom->Values[ "Whoisns.$i"];
	}
	$Created = $Enom->Values[ "Whoiscrdate"];
	break;
	
	case "cc":
	break;
	case "ws":
	break;
	case "cn":
	break;
	case "bz":
	break;
	default:
	break;
	}
	
//echo  the name servers and the domain info
      <table width="550" border="0" align="center" class="tableOO">
        <tr>
          <td width="146"></td>
          <td width="390"><?=$dnsserver;?></td>
    </tr>
        <tr>
          <td>Created</td>
          <td><?=$Created;?></td>
        </tr>
        <tr>
          <td>Expires</td>
          <td><?=$Expires;?></td>
        </tr>
        <tr>
          <td>Last Updated</td>
          <td><?=$Updated;?></td>
        </tr>
        <tr>
          <td>Expired</td>
          <td><?=$Expired;?></td>
        </tr>
      </table>
      <? 	
*/
} else {
	echo $cErrorMsg;
}?>
</th>
  </tr>
</table></td> 
    </tr> 
  </form>
</table>
 		  <?
		  	if ( $cAction == "whois" ) {
				if ($bError == 1 )
				{
					echo $cErrorMsg;
				} 
			}
			?>
<br>
<? include('include/footer.php'); ?>