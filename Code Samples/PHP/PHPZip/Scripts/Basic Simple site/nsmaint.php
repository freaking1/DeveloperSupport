<?php
$RegStatus = $_SESSION['RegStatus'];
	if($RegStatus != 1){
		$sld = $_SESSION['sld'];
		$tld =	$_SESSION['tld'];
		$postvars = "sld=$sld&tld=$tld";
		header ("Location: DomainMainHosted.php?$postvars");
		exit;
	}

	require( "include/sessions.php" );
	include( "include/DomainFns_inc.php" );
	include( "include/EnomInterface_inc.php" );

	//Set the Session variables
	$tld = $_SESSION['tld'];
	$sld = $_SESSION['sld'];

	$_SESSION['Err1'] = $Enom->Values[ "Err1" ];
	$_SESSION['NS'] = $Enom->Values[ "NS" ];
	$_SESSION['IP'] = $Enom->Values[ "IP" ];
	$_SESSION['RRPText'] = $Enom->Values[ "RRPText" ];
	$_SESSION['RRPCode'] = $Enom->Values[ "RRPCode" ];

	//Set Form Variables
	$action = $HTTP_POST_VARS[ "action" ];
	$IP = $HTTP_POST_VARS[ "IP" ];
	$nsname = "$host.$sld.$tld";     
	$host = $HTTP_POST_VARS[ "host" ];
	$checknsname = $HTTP_POST_VARS[ "checknsname" ];
	$ns = $HTTP_POST_VARS[ "ns" ];
	$oldip = $HTTP_POST_VARS[ "oldip" ];
	$newip = $HTTP_POST_VARS[ "newip" ];
	
	//Page name - DO NOT CHANGE
	$PageName = "nsmaint";
	
	//Set Page Title - SiteTitle is set in the header.php file
	$PageTitle = $SiteTitle . " - Manage Name Servers";

	//This file must be inluded.
	include('include/header.php'); 
	?>
			      <td colspan="3" valign="top" class="content2"><p>&nbsp;</p>
<form name="form" method="post" action="nsmaint.php">
  <table width="580" border="0" align="center" class="tableOO">
                <tr>
                  <td colspan="4" align="center" valign="middle" class="titlepic"><span class="whiteheader">Register a Name Server</span></td>
                </tr>
                <tr>
                  <td width="203" ><div align="right">Choose a Host Name <br>                  
                  </div></td>
                  <td width="367"><input name="host" type="text" maxlength="40" > 
                  . 
                  <input disabled type="text" name="sldtld" value="<?php echo "$sld.$tld";?>" ></td>
                </tr><input type="hidden" name="action" value="registerns">
                <tr>
                  <td><div align="right">IP address </div></td>
                  <td><input name="IP" type="text" maxlength="40"></td>
                </tr>                <tr>
                  <td></td>
                  <td><input name="image1" type="image" id="image1" src="images/btn_continue.gif" >
		  		  </td>
               </tr>
    </table>
</form>                    <br>
			        <form name="form2" method="post" action="nsmaint.php">
                      <table width="583" border="0" align="center" class="tableOO">
                        <tr>
                          <td colspan="4" align="center" valign="middle" class="titlepic"><div align="center"><span class="whiteheader">Update a Name Server</span></div></td>
                        </tr>
                        <input type="hidden" name="action" value="updatens">
                        <tr>
                          <td width="187"><div align="right">Name Server Host Name</div></td>
                          <td width="402"><input name="host" type="text" maxlength="40" >
        .
          <input disabled type="text" name="sldtld" value="<?php echo "$sld.$tld";?>" ></td>
                        </tr>
                        <tr>
                          <td><div align="right">Old IP address </div></td>
                          <td><input name="oldip" type="text" maxlength="40" ></td>
                        </tr>
                        <tr>
                          <td><div align="right">New IP address </div></td>
                          <td><input name="newip" type="text" maxlength="40" ></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input name="image1" type="image" id="image1" src="images/btn_continue.gif" >
                          </td>
                        </tr>
                      </table>
		            </form>			        <p align="center" class="BasicText"><br> 
                    
<?php
				  
  		if( $action == "registerns") {
			$Enom = new CEnomInterface;
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $username );
			$Enom->AddParam( "pw", $password );
			$Enom->AddParam( "nsname", $nsname );
			$Enom->AddParam( "add", "true" );
			$Enom->AddParam( "IP", $IP );
			$Enom->AddParam( "command", "RegisterNameServer" );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "User_ID", $_SESSION['id'] );
			$Enom->DoTransaction();
					 //Checks the Error Flag
  				switch ( $Enom->Values[ "ErrCount" ] ) {
  				case "1":
				// There was an Error
				include('include/nsregerror.php');
				break;
	
  				case "0":
				// There was no error
				include('include/nsreg.php');
				break;
				} 
			}

		
			if( $action == "updatens"){
			$Enom = new CEnomInterface;
			$Enom->NewRequest();
			$Enom->AddParam( "uid", $username );
			$Enom->AddParam( "pw", $password );
			$Enom->AddParam( "ns", $nsname );
			$Enom->AddParam( "oldip", $oldip );
			$Enom->AddParam( "newip", $newip );
			$Enom->AddParam( "command", "UpdateNameServer" );
			$Enom->AddParam( "enduserip", $enduserip );
			$Enom->AddParam( "site", $sitename );
			$Enom->AddParam( "User_ID", $_SESSION['id'] );
			$Enom->DoTransaction();			
					 //Checks the Error Flag
  				switch ( $Enom->Values[ "ErrCount" ] ) {
  				case "1":
				// There was an Error
				include('include/nsuperror.php');
				break;
	
  				case "0":
				// There was no error
				include('include/nsupdate.php');
				break;
				} 

		}
?>
              <p align="center"><a href="DomainMain.php"><img src="images/btn_back.gif" border="0" WIDTH="74" HEIGHT="22"></a></p></td>
	          <tr>
	                <td colspan="3" valign="top" class="content2">                    
		      </table>
</table>
		          <?php include('include/footer.php');?>
</body>

</html>