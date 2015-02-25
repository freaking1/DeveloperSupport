<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

//Get the post for what page to show
$show = $_GET["show"];
if($show == ''){ $show = 'view';}

// Number of records to show per page:
$display = 25;
	
	
if($action == "modifydomain"){
$domainid = $_GET['domainid'];

$username = $_POST['new_user'];
$tld = $_POST['tld'];
$exp_date = $_POST['exp_date'];
$order_date = $_POST['order_date'];
$dns = $_POST['dns'];
$mail = $_POST['mail'];
$webhosted = $_POST['hosted'];
$status = $_POST['status'];
$pop = $_POST['pop'];
$idprotect = $_POST['idprotect'];
$name_phone = $_POST['phone'];
$name_map = $_POST['map'];

$find_id = "SELECT id FROM users WHERE username='$username'";
$found_id = @mysql_query($find_id);
$row_id = mysql_fetch_array($found_id, MYSQL_NUM);
$user_id = $row_id[0];

			if(empty($_POST['sld'])) {
				$sld = FALSE;
				$message .= '<br>A domain must be entered to continue</br>';
			} else { 
				$sld = $_POST['sld'];
				}
	if($sld){

		$query1 = "UPDATE domains SET user_id='$user_id', sld='$sld', tld='$tld', exp_date='$exp_date', order_date='$order_date', dns='$dns', mail='$mail', webhosted='$webhosted', status='$status', pop='$pop', idprotect='$idprotect', name_phone='$name_phone', name_map='$name_map', lastupdate=NOW() WHERE domain_id='$domainid'";
		$result1 = @mysql_query ($query1); // Run the query.
						if (mysql_affected_rows() == 1) { // If it ran OK.
						
						$message .= "The Update was successfull";
						//Re-Run the select query to get the new information just updated.
						header ("Location:  domainman.php?show=all");
						} else {
						$message .= 'The update FAILED.  Please try again later';
						} //End Mysql affected Rows
			}//If SLD
		}//If action
	
include("include/header.php");?>
<tr>
    <td width="100%" valign="top" height="110"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td valign="top" width="18%" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td width="34%" align="center"><div align="right"> </div>          </td>
        <td width="23%" align="left" class="BasicText"><b>&nbsp;</b>
        <td width="18%" align="center"> <div align="left"></div>
        </td>
      </tr>
      <tr>
        <td colspan="3" rowspan="6" valign="top" align="center">
		<?php
		$add = $_GET['add'];
		if($add == "done"){
		echo "Domain Succesfully added";
		}
if($show == "add"){ 
?>
<input type="hidden" name="action" value="adddomain">
<form method="post" action="<?php echo "domainman.php?show=add&action=adddomain";?>" id="form1" name="form1">
<table width="100%" class="tableO1">                                            <tr>
                                              <td width="47%" align="right" valign="top">Username:&nbsp;&nbsp;</td>
      <td width="53%" class="smallblue">        
	   
	  
	  <select name="new_user">
	  <?php 
	$query = "SELECT username
				FROM users
				ORDER BY id ASC";
	$result = @mysql_query($query);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	$user_list = "$row[username]";
	?><option value="<?=$row[username];?>"><?php echo $row[username];?></option> <? } ?>
                                              </select> </td>
                                            </tr>
                                            <tr>
                                              <td align="right">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td align="right">SLD:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="sld" id="sld" maxlength="60" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">TLD:&nbsp;&nbsp;</td>
                                              <td>
											<?php include ('../include/tldlist/tldListOne.php'); ?> 
                                             </td>
                                            </tr>
                                            <tr>
                                              <td align="right"> Expiration Date :&nbsp;&nbsp;</td>
                                              <td>
                                                <span class="row2">
                                                <select name="ExpMonth" id="ExpMonth" value="<?php if(isset($ExpMonth)) echo $ExpMonth; ?>">
                                                  <option>01</option>
                                                  <option>02</option>
                                                  <option>03</option>
                                                  <option>04</option>
                                                  <option>05</option>
                                                  <option>06</option>
                                                  <option>07</option>
                                                  <option>08</option>
                                                  <option>09</option>
                                                  <option>10</option>
                                                  <option>11</option>
                                                  <option>12</option>
                                                </select>
&nbsp;
<select name="ExpDate" id="ExpDate" value="<?php if(isset($ExpDate)) echo $ExpDate; ?>">
  <option>01</option>
  <option>02</option>
  <option>03</option>
  <option>04</option>
  <option>05</option>
  <option>06</option>
  <option>07</option>
  <option>08</option>
  <option>09</option>
  <option>10</option>
  <option>11</option>
  <option>12</option>
  <option>13</option>
  <option>14</option>
  <option>15</option>
  <option>16</option>
  <option>17</option>
  <option>18</option>
  <option>19</option>
  <option>20</option>
  <option>21</option>
  <option>22</option>
  <option>23</option>
  <option>24</option>
  <option>25</option>
  <option>26</option>
  <option>27</option>
  <option>28</option>
  <option>29</option>
  <option>30</option>
  <option>31</option>
</select>
&nbsp;
<select name="ExpYear" id="ExpYear" value="<?php if(isset($ExpYear)) echo $ExpYear; ?>">
  <option>2005</option>
  <option>2006</option>
  <option>2007</option>
  <option>2008</option>
  <option>2009</option>
  <option>2010</option>
  <option>2011</option>
  <option>2012</option>
  <option>2013</option>
  <option>2014</option>
  <option>2015</option>
  <option>2016</option>
  <option>2017</option>
  <option>2018</option>
  <option>2019</option>
  <option>2020</option>
</select>
&nbsp;&nbsp;</span>                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right"> Order Date :&nbsp;&nbsp;</td>
                                              <td><span class="row2">
                                                <select name="OrderMonth" id="OrderMonth" value="<?php if(isset($OrderMonth)) echo $OrderMonth; ?>">
                                                  <option>01</option>
                                                  <option>02</option>
                                                  <option>03</option>
                                                  <option>04</option>
                                                  <option>05</option>
                                                  <option>06</option>
                                                  <option>07</option>
                                                  <option>08</option>
                                                  <option>09</option>
                                                  <option>10</option>
                                                  <option>11</option>
                                                  <option>12</option>
                                                </select>
&nbsp;
<select name="OrderDate" id="OrderDate" value="<?php if(isset($OrderDate)) echo $OrderDate; ?>">
  <option>01</option>
  <option>02</option>
  <option>03</option>
  <option>04</option>
  <option>05</option>
  <option>06</option>
  <option>07</option>
  <option>08</option>
  <option>09</option>
  <option>10</option>
  <option>11</option>
  <option>12</option>
  <option>13</option>
  <option>14</option>
  <option>15</option>
  <option>16</option>
  <option>17</option>
  <option>18</option>
  <option>19</option>
  <option>20</option>
  <option>21</option>
  <option>22</option>
  <option>23</option>
  <option>24</option>
  <option>25</option>
  <option>26</option>
  <option>27</option>
  <option>28</option>
  <option>29</option>
  <option>30</option>
  <option>31</option>
</select>
&nbsp;
<select name="OrderYear" id="OrderYear" value="<?php if(isset($OrderYear)) echo $OrderYear; ?>">
  <option>2005</option>
  <option>2006</option>
  <option>2007</option>
  <option>2008</option>
  <option>2009</option>
  <option>2010</option>
  <option>2011</option>
  <option>2012</option>
  <option>2013</option>
  <option>2014</option>
  <option>2015</option>
  <option>2016</option>
  <option>2017</option>
  <option>2018</option>
  <option>2019</option>
  <option>2020</option>
</select>
&nbsp;&nbsp;</span> 
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">DNS:&nbsp;&nbsp;</td>
                                              <td>
                                                <select name="dns">
                                                  <option value="1">eNom DNS</option>
                                                  <option value="0">Custom DNS</option>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">Mail:&nbsp;&nbsp;</td>
                                              <td>
                                                <select name="mail">
                                                  <option value="1048">None</option>
                                                  <option value="1051">Forwarding</option>
                                                  <option value="1054">User</option>
                                                  <option value="1114">Pop</option>
                                                </select>
</td>
                                            </tr>
                                            <tr>
                                              <td align="right">Hosted:&nbsp;&nbsp;</td>
                                              <td>
                                                <select name="hosted">
                                                  <option value="0">None</option>
                                                  <option value="1">DNS Hosted</option>
                                                  <option value="2">Web Hosted</option>
                                                  <option value="3">WSC Hosted</option>
                                                </select>
</td>
                                            </tr>
                                            <tr>
                                              <td align="right"> status&nbsp;&nbsp;
                                              </td>
                                              <td><select name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Expired</option>
                                                <option value="2">DNS Hosted</option>
                                                <option value="3">RGP (Redemption)</option>
                                                <option value="4">ERGP (Redemption)</option>
                                              </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">Pop&nbsp;&nbsp;                                                  </td>
                                              <td>                                                <select name="pop">
                                                  <option value="0">No</option>
                                                  <option value="1">1</option>
                                                  <option value="2">2</option>
                                                  <option value="3">3</option>
                                                  <option value="4">4</option>
                                                  <option value="5">5</option>
                                                  <option value="6">6</option>
                                                  <option value="7">7</option>
                                                  <option value="8">8</option>
                                                  <option value="9">9</option>
                                                  <option value="10">10</option>
                                                </select></td>
                                            </tr>
                                            <tr>
                                              <td align="right">ID Protect:&nbsp;&nbsp;</td>
                                              <td><select name="idprotect">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                              </select></td>
                                            </tr>
                                            <tr>
                                              <td align="right"><strong>Enable Name My Phone</strong>:&nbsp;&nbsp;</td>
                                              <td><select name="phone">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                              </select></td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="top"><strong>Enable Name my Map </strong>:&nbsp;&nbsp;</td>
                                              <td><select name="map">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                              </select></td>
                                            </tr>
                                            <tr>
                                              <td colspan="2" align="right" valign="top"><div align="center">
  <input name="image" type="image" src="../images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">
&nbsp;<a href="index.php" class="main"><img src="../images/btn_cancel.gif" width="74" height="22" border="0"></a></div></td>
                                            </tr>
                                    </table>
</form>
<?php 

if($action == "adddomain"){

	$p_username = $_POST['new_user'];
	$p_tld = $_POST['tld'];
	$p_dns = $_POST['dns'];
	$p_mail = $_POST['mail'];
	$p_hosted = $_POST['hosted'];
	$p_status = $_POST['status'];
	$p_pop = $_POST['pop'];
	$p_idprotect = $_POST['idprotect'];
	$p_phone = $_POST['phone'];
	$p_map = $_POST['map'];

	if(empty($_POST['sld'])) {
		$p_sld = FALSE;
		$message .= '<br><span class="red">You must enter a domain name</span></br>';
	} else { 
		$p_sld = $_POST['sld'];
		}
	$p_exp_date = $_POST['ExpMonth'].'/'.$_POST['ExpDate'].'/'.$_POST['ExpYear'];
	$p_order_date = $_POST['OrderMonth'].'/'.$_POST['OrderDate'].'/'.$_POST['OrderYear'];
}

	if($p_sld){

	$query = "SELECT sld, tld FROM domains WHERE sld='$p_sld' AND tld='$p_tld'";
		//Runs the qyery
		$result = @mysql_query ($query);
				if(mysql_num_rows($result) == 0){

	$idcheck = "SELECT id FROM users WHERE username='$p_username'";
	$id_query = @mysql_query($idcheck);
	$row = mysql_fetch_array($id_query, MYSQL_NUM);
	$user_id = $row[0];
	
	$SQL = "INSERT INTO domains (user_id, e_domain_id, sld, tld, exp_date, order_date, dns,  mail, webhosted, status, pop, idprotect, auto_renew, reg_lock, tv, parking, name_phone, name_map, lastupdate)
			VALUES ('$user_id', '0', '$p_sld', '$p_tld', '$p_exp_date', '$p_order_date', '$p_dns', '$p_mail', '$p_hosted', '$p_status', '$p_pop', '$p_idprotect', '1', '1', '0', '0', '$p_phone', '$p_map', NOW())";
	$RUN = @mysql_query($SQL);
		if(!$RUN){
		$message .= "There was an error adding<br>$SQL<br>";
		} else {
		$message .= "Domain was succesfully added";
			} 
		} else {
		$message .= "That domain is already in the database";
		}
	}
}

if($show == "del"){

$domainid = $_GET['domainid'];
	if($domainid !=''){

	$SQL = "SELECT sld, tld FROM domains WHERE domain_id='$domainid'";
	$RESULT = @mysql_query($SQL);
	$ROW = mysql_fetch_array($RESULT, MYSQL_NUM);
	$sld = $ROW[0];
	$tld = $ROW[1];
	$query_del = "DELETE FROM domains WHERE domain_id='$domainid'";
	$result_del = @mysql_query($query_del);
				if(mysql_affected_rows() == 1){
				$message .= "<span class=\"red\"><br>Successfully Deleted the domain $sld.$tld</span>";
				$message .= "<span class=\"basictext\"><br><br><b><u><a href=\"domainman.php?show=all\">Back</a></b></u>";
				} else {
				$message .= "<span class=\"red\"><br>Could not delete - Database problem or the domain does not exist</span><br>";
				$message .= "<span class=\"basictext\"><br><br><b><u><a href=\"domainman.php?show=all\">Back</a></b></u>";
				} 
		}
}//End Show Del
#------------------------------------------------------
if($show == "view"){
	$query = "SELECT * FROM domains ORDER BY sld ASC";
	$result = @mysql_query($query);
	if($domainid == ''){
	$viewdom = $_POST['viewdom'];
		echo "<form method=\"post\" action=\"domainman.php?show=view&domainid=$viewdom\">";
		echo "<br><br><br><table class=\"tableO1\"><tr class=\"titlepic\"><td colspan =\"2\"><span class=\"whiteheader\">View/Change Domain Details</span></td></tr>
		<tr><td>Domain: &nbsp;&nbsp;";
		?>
			  <select name="viewdom">
	  <?php 
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	$domain_name = "$row[sld].$row[tld]";
	$domain_id = "$row[domain_id]";
	?><option value="<?=$domain_id;?>"><?=$domain_name;?></option> <? } ?>
                                              </select> 
		<?php echo "</td>";
		echo "<td><input name=\"image\" type=\"image\" src=\"../images/btn_submit.gif\" WIDTH=\"74\" HEIGHT=\"22\" border=\"0\"></td></tr>";
		echo "</table></form>";
	}

	elseif($domainid !=''){
	$SQL = "SELECT * FROM domains WHERE domain_id='$domainid'";
	$RESULT = @mysql_query($SQL);
	$row = mysql_fetch_array($RESULT, MYSQL_ASSOC);

	//Set Friendly variable names
	if($row[dns] == '1'){
	$dns = 'eNom DNS';
	}elseif($row[dns] == '0'){
	$dns = 'Custom DNS';
	}
	if($row[mail] == ''){
	$mail = 'None';
	}elseif($row[mail] == '1048'){
	$mail = 'None';
	}elseif($row[mail] == '1051'){
	$mail = 'Forwarding';
	}elseif($row[mail] == '1054'){
	$mail = 'User';
	}elseif($row[mail] == '1114'){
	$mail = 'Pop';
	}
	if($row[webhosted] == '0'){
	$webhosted = 'None';
	}elseif($row[webhosted] == '1'){
	$webhosted = 'DNS Hosted';
	}elseif($row[webhosted] == '2'){
	$webhosted = 'Web Hosted';
	}elseif($row[webhosted] == '3'){
	$webhosted = 'WSC Hosted';
	}
	if($row[status] == '1'){
	$status = 'Active';
	}elseif($row[status] == '2'){
	$status = 'DNS Hosted';
	}elseif($row[status] == '0'){
	$status = 'Expired';
	}elseif($row[status] == '3'){
	$status = 'RGP';
	}elseif($row[status] == '4'){
	$status = 'ERGP';
	}
	if($row[name_map] == '1'){
	$name_map = 'Yes';
	}elseif($row[name_map] == '0'){
	$name_map = 'No';
	}
	if($row[name_phone] == '1'){
	$name_phone = 'Yes';
	}elseif($row[name_phone] == '0'){
	$name_phone = 'No';
	}
	if($row[idprotect] == '1'){
	$idprotect = 'Yes';
	}elseif($row[idprotect] == '0'){
	$idprotect = 'No';
	}
	// End Friendly Variable Name section
?>
<form method="post" action="<?php echo "domainman.php?show=view&action=modifydomain&domainid=$domainid";?>" id="form1" name="form1"> 
	<input type="hidden" name="show" value="view">
	<input type="hidden" name="action" value="modifydomain">
	<input type="hidden" name="domainid" value="<?=$domainid;?>">
<table width="100%" class="tableO1"> 
	   <tr>
		  <td width="47%" align="right" valign="top">Username:&nbsp;&nbsp;</td>
      <td width="53%" class="smallblue">        
	  <?php 
	  $UID = "SELECT user_id FROM domains WHERE domain_id = '$domainid'";
	  $UID2 = @mysql_query($UID);
	 $UID3 = mysql_fetch_array($UID2, MYSQL_NUM);
	 $user_id = $UID3[0];
	 $num1 = "SELECT username FROM users WHERE id = '$user_id'";
	 $result_num1 = @mysql_query($num1);
	 $row_num1 = mysql_fetch_array($result_num1, MYSQL_NUM);
	 $old_user = $row_num1[0];
	$query = "SELECT username, id
				FROM users
				ORDER BY id ASC";
	$result = @mysql_query($query);
	while($row2 = mysql_fetch_array($result, MYSQL_ASSOC)){
	$user_list = "$row2[username]";
	?>
	 <select name="new_user">
	<option value="<?php echo $user_list; ?>"><?php echo $user_list; ?></option>
	<? } ?>	<option selected value="<?=$old_user;?>"><?=$old_user;?></option>

                                              </select> </td>
                                            </tr>
                                            <tr>
                                              <td align="right">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td align="right">SLD:&nbsp;&nbsp;</td>
                                              <td>
                                                <input class="formfield" name="sld" id="sld" maxlength="60" value="<?=$row[sld];?>" type="text">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">TLD:&nbsp;&nbsp;</td>
                                              <td>
											<?php include ('../include/tldlist/tldListOne.php'); ?> 
                                             </td>
                                            </tr>
                                            <tr>
                                              <td align="right"> Expiration Date :&nbsp;&nbsp;</td>
                                              <td>
                                                <span class="row2"> <input type="text" name="exp_date" value="<?=$row[exp_date];?>">
                                        </td>
                                            </tr>
                                            <tr>
                                              <td align="right"> Order Date :&nbsp;&nbsp;</td>
                                              <td><span class="row2">
											  <input type="text" name="order_date" value="<?=$row[order_date];?>">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">DNS:&nbsp;&nbsp;</td>
                                              <td>
                                                <select name="dns" >
												  <option selected value="<?php echo $row[dns]; ?>"><?php echo $dns; ?></option>
                                                  <option value="1">eNom DNS</option>
                                                  <option value="0">Custom DNS</option>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">Mail:&nbsp;&nbsp;</td>
                                              <td>
                                                <select name="mail">
												  <option selected value="<?php echo $row[mail]; ?>"><?php echo $mail ?></option>
                                                  <option value="1048">None</option>
                                                  <option value="1051">Forwarding</option>
                                                  <option value="1054">User</option>
                                                  <option value="1114">Pop</option>
                                                </select>
</td>
                                            </tr>
                                            <tr>
                                              <td align="right">Hosted:&nbsp;&nbsp;</td>
                                              <td>
                                                <select name="hosted">
												  <option selected value="<?php echo $row[webhosted]; ?>"><?php echo $webhosted; ?></option>
                                                  <option value="0">None</option>
                                                  <option value="1">DNS Hosted</option>
                                                  <option value="2">Web Hosted</option>
                                                  <option value="3">WSC Hosted</option>
                                                </select>
</td>
                                            </tr>
                                            <tr>
                                              <td align="right"> status&nbsp;&nbsp;
                                              </td>
                                              <td><select name="status">
												  <option selected value="<?php echo $row[status]; ?>"><?php echo $status; ?></option>
                                                <option value="1">Active</option>
                                                <option value="0">Expired</option>
                                                <option value="2">DNS Hosted</option>
                                                <option value="3">RGP</option>
                                                <option value="4">ERGP</option>
                                              </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="right">Pop&nbsp;&nbsp;                                                  </td>
                                              <td><select name="pop">
												  <option selected value="<?php echo $row[pop]; ?>"><?php echo $row[pop]; ?></option>
                                                  <option value="0">No</option>
                                                  <option value="1">1</option>
                                                  <option value="2">2</option>
                                                  <option value="3">3</option>
                                                  <option value="4">4</option>
                                                  <option value="5">5</option>
                                                  <option value="6">6</option>
                                                  <option value="7">7</option>
                                                  <option value="8">8</option>
                                                  <option value="9">9</option>
                                                  <option value="10">10</option>
                                                </select></td>
                                            </tr>
                                            <tr>
                                              <td align="right">ID Protect:&nbsp;&nbsp;</td>
                                              <td><select name="idprotect">
												  <option selected value="<?php echo $row[idprotect]; ?>"><?php echo $idprotect; ?></option>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                              </select></td>
                                            </tr>
                                            <tr>
                                              <td align="right"><strong>Enable Name My Phone</strong>:&nbsp;&nbsp;</td>
                                              <td><select name="phone">
												 <option selected value="<?php echo $row[name_phone]; ?>"><?php echo $name_phone; ?></option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                              </select></td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="top"><strong>Enable Name my Map </strong>:&nbsp;&nbsp;</td>
                                              <td><select name="map">
												  <option selected value="<?php echo $row[name_map]; ?>"><?php echo $name_phone; ?></option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                              </select></td>
                                            </tr>
                                            <tr>
                                              <td colspan="2" align="right" valign="top"><div align="center">
  <input name="image" type="image" src="../images/btn_submit.gif" WIDTH="74" HEIGHT="22" border="0">
&nbsp;<a href="index.php" class="main"><img src="../images/btn_cancel.gif" width="74" height="22" border="0"></a></div></td>
                                            </tr>
                                    </table>
<?php
}
}//End Show View
#------------------------------------------------------
if($show == "all"){

	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT user_id, domain_id, e_domain_id, sld, tld, order_date, exp_date, lastupdate FROM domains ORDER BY sld ASC";
	$result_all = @mysql_query($query_all);
	$num_records = mysql_num_rows($result_all);
		
		if ($num_records > $display) { // More than 1 page.
			$num_pages = ceil ($num_records/$display);
		} else {
			$num_pages = 1;
		}
	}
	
	// Determine where in the database to start returning results.
	if (isset($_GET['s'])) { // Already been determined.
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
			
	//Make the query now
	$query_all = "SELECT user_id, domain_id, e_domain_id, sld, tld, order_date, exp_date, lastupdate FROM domains ORDER BY sld ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	//Make the linnks to other pages
	if ($num > 0) { // If it ran OK, display the records.
	echo "<br><span class=\"BasicTextMED\"><b>Registered Domains</b></span>";
		// Make the links to other pages, if necessary.
		if ($num_pages > 1) {
			
			echo '<p>';
			// Determine what page the script is on.	
			$current_page = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page != 1) {
				echo '<a href="domainman.php?show=all&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
			
			// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="domainman.php?show=all&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			// If it's not the last page, make a Next button.
			if ($current_page != $num_pages) {
				echo '<a href="domainman.php?show=all&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
			
			echo '</p><br />';
			
		} // End of links section.
		// Table header.
			echo '<table width="100%" class="tableO1">';
			echo '<tr class="BasicText">';
			echo '<td class="BasicText"></td>';
			echo '<td class="BasicText"></td>';
			echo '<td class="BasicText"><b>UID</b></td>';
			echo '<td class="BasicText"><b>SLD</b></td>';
			echo '<td class="BasicText"><b>TLD</b></td>';
			echo '<td class="BasicText"><b>Reg Date</b></td>';
			echo '<td class="BasicText"><b>Exp Date</b></td>';
			echo '<td class="BasicText"><b>Last Update</b></td></tr>';
			$bg='#eeeee';
			while($row = mysql_fetch_array($result_all, MYSQL_NUM)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
			echo "<tr bgcolor=\"$bg\">";
			echo "<td align=\"left\"><a href=\"domainman.php?show=view&domainid=$row[1]\">View</td>";
			echo "<td align=\"left\"><a href=\"domainman.php?show=del&domainid=$row[1]\">Delete</td>";
			echo '<td align="left">'.$row[0].'</td>';
			echo '<td align="left">'.$row[3].'</td>';
			echo '<td align="left">'.$row[4].'</td>';
			echo '<td align="left">'.$row[5].'</td>';
			echo '<td align="left">'.$row[6].'</td>';
			echo '<td align="left">'.$row[7].'</td>
			</tr>';
			}
		echo '</table>';
		if ($num_pages > 1) {
			
			echo '<p>';
			// Determine what page the script is on.	
			$current_page = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page != 1) {
				echo '<a href="domainman.php?show=all&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
			
			// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="domainman.php?show=all&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			// If it's not the last page, make a Next button.
			if ($current_page != $num_pages) {
				echo '<a href="domainman.php?show=all&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
			
			echo '</p><br />';
			
		} // End of links section.
		mysql_free_result ($result_all); // Free up the resources.	
	
	} else { // If there are no registered users.
		echo '<h3>There are no registered Domains.</h3>'; 
	}
	
	mysql_close(); // Close the database connection.
	}
}//End SHOW ALL SECTION

		?>
		<br>
		<? if(isset($message)) {echo "<span class=\"red\">$message</span>";} ?>
	
		</p>        </td>
      </tr>
<?php include("include/footer.php");?>
    </table>    