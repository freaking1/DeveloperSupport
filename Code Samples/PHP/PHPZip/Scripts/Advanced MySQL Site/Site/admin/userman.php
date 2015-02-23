<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

//Get the post for what page to show
$show = $_GET["show"];
if($show == ''){ $show = 'view';}
$action = $_GET["action"];
$user = $_GET["user"];
// Number of records to show per page:
$display = 25;
//create a function to escape the data
	function escape_data($data) {
		global $dbc;
		if (ini_get('magic_quotes_gpc')){
			$data = stripslashes($data);
		}
	return mysql_real_escape_string($data, $dbc);
	}
	
	
		$query = "SELECT username, id
				FROM users
				ORDER BY id ASC";
	$result = @mysql_query($query);

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
          <span class="red"> 
          <?php
				  //Print the error message if there is one
	if(isset($message)) {echo '<span class=\"red\">', $message, '</span>';}
	
if($show == "del"){
$user = $_POST['deluser'];

echo "<center><b>This is irreversable, so do this with caution!<br>";
	if($user !=''){
	$user = $_POST['deluser'];
	$query_del = "DELETE FROM users WHERE username='$user'";
	$result_del = @mysql_query($query_del);
				if(mysql_affected_rows() == 1){
				echo "<span class=\"red\"><br>Successfully Deleted User $user</span>";
				$user = $_POST["user"];
				echo "<form method=\"post\" action=\"userman.php?show=del&user=$deluser\" id=\"form1\" name=\"form1\">";
				echo "<br><br><br><table valign=\"top\" class=\"tableO1\"><tr class=\"titlepic\"><td colspan =\"2\"><span class=\"whiteheader\">Delete User</span></td></tr>
				<tr><td>Username: &nbsp;&nbsp;";
				?>
					  <select name="deluser">
					  <?php 
					while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
					$user_list = "$row[username]";
					$user_id = "$row[id]";
					?><option value="<?=$user_list;?>"><?=$user_list;?></option> <? } ?>
													  </select> 
		        <?php echo "</td>";
				echo "<td><input name=\"image\" type=\"image\" src=\"../images/btn_submit.gif\" WIDTH=\"74\" HEIGHT=\"22\" border=\"0\"></td></tr>";
				echo "</table></form>";
				} else {
				$message .= "<span class=\"red\"><br>Could not delete the User, or the user does not exist</span><br>";
				echo "<form method=\"post\" action=\"userman.php?show=del&user=$deluser\" id=\"form1\" name=\"form1\">";
				echo "<br><br><br><table valign=\"top\" class=\"tableO1\"><tr class=\"titlepic\"><td colspan =\"2\"><span class=\"whiteheader\">Delete User</span></td></tr>
				<tr><td>Username: &nbsp;&nbsp;";
				?>
					  <select name="deluser">
					  <?php 
					while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
					$user_list = "$row[username]";
					$user_id = "$row[id]";
					?><option value="<?=$user_list;?>"><?=$user_list;?></option> <? } ?>
													  </select> 
		        <?php echo "</td>";
				echo "<td><input name=\"image\" type=\"image\" src=\"../images/btn_submit.gif\" WIDTH=\"74\" HEIGHT=\"22\" border=\"0\"></td></tr>";
				echo "</table></form>";}
	} else {
				echo "<form method=\"post\" action=\"userman.php?show=del&user=$deluser\" id=\"form1\" name=\"form1\">";
				echo "<br><br><br><table valign=\"top\" class=\"tableO1\"><tr class=\"titlepic\"><td colspan =\"2\"><span class=\"whiteheader\">Delete User</span></td></tr>
				<tr><td>Username: &nbsp;&nbsp;";
				?>
					  <select name="deluser">
					  <?php 
					while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
					$user_list = "$row[username]";
					$user_id = "$row[id]";
					?><option value="<?=$user_list;?>"><?=$user_list;?></option> <? } ?>
													  </select> 
		        <?php echo "</td>";
				echo "<td><input name=\"image\" type=\"image\" src=\"../images/btn_submit.gif\" WIDTH=\"74\" HEIGHT=\"22\" border=\"0\"></td></tr>";
				echo "</table></form>";
		} //End If user
	
	} //End If Show


#-------------------------------------------	
if($show == "view"){
$viewuser = $_POST['viewuser'];

		echo "<form method=\"post\" action=\"userman.php?show=view&user=$viewuser\" id=\"form1\" name=\"form1\">";
		echo "<br><br><br><table valign=\"top\" class=\"tableO1\"><tr class=\"titlepic\"><td colspan =\"2\"><span class=\"whiteheader\">View/Change User Details</span></td></tr>
		<tr><td>Username: &nbsp;&nbsp;";
		?>
	          <select name="viewuser">
	    <?php 
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	$user_list = "$row[username]";
	$user_id = "$row[id]";
	?><option value="<?=$user_list;?>"><?php echo "$user_list" ;?></option> <? } ?>
                                              </select> 
        <?php echo "</td>";
		echo "<td><input name=\"image\" type=\"image\" src=\"../images/btn_submit.gif\" WIDTH=\"74\" HEIGHT=\"22\" border=\"0\"></td></tr>";
		echo "</table></form>";
			$query_view = "SELECT * FROM users WHERE username='$viewuser'";
			$result_view = @mysql_query ($query_view);
			$row = mysql_fetch_array($result_view, MYSQL_ASSOC);
			
if($viewuser){
include('forms/viewuser.php');
}

if ($action == "modify") {
$viewuser = $_GET['user'];
		if (empty($_POST['lpquestion'])) {
				$lpquestion = FALSE;
				$message .= '<br>You must enter a Security question!</br>';
			} else {
				$lpquestion = escape_data($_POST['lpquestion']);
			}
			if (empty($_POST['lpanswer'])) {
				$lpanswer = FALSE;
				$message .= '<br>You must provide an answer for your question!</br>';
			} else {
				$lpanswer = escape_data($_POST['lpanswer']);
			}
			if(empty($_POST['fname'])) {
				$fname = FALSE;
				$message .= '<br>You forgot to enter your First name</br>';
			} else { 
				$fname = escape_data($_POST['fname']);
				}
			
			if(empty($_POST['lname'])) {
				$lname = FALSE;
				$message .= '<br>You forgot enter your last name</br>';
			} else { 
				$lname = escape_data($_POST['lname']);
				}
			
			if(empty($_POST['email1'])) {
				$email = FALSE;
				$message .= '<br>You must enter an email address</br>';
			} else { 
				$email = escape_data($_POST['email1']);
				}
			
			if(isset($_POST['email2'])) {
				$email2 = escape_data($_POST['email2']);
			}
		
			if(empty($_POST['add1'])) {
				$add1 = FALSE;
				$message .= '<br>You did not enter your address</br>';
			} else { 
				$add1 = escape_data($_POST['add1']);
				}
			
			if(isset($_POST['add2'])) {
				$add2 = escape_data($_POST['add2']);
			}
			
			if(empty($_POST['city'])) {
				$city = FALSE;
				$message .= '<br>You forgot to enter a city</br>';
			} else { 
				$city = escape_data($_POST['city']);
				}
			
			if(isset($_POST['state'])) {
				$state = escape_data($_POST['state']);
			}
		
			if(isset($_POST['province'])) {
				$province = escape_data($_POST['province']);
			}
			
			if(isset($_POST['rspchoice'])) {
				$rspchoice = TRUE;
			}
			
			if(empty($_POST['zip'])) {
				$zip = FALSE;
				$message .= '<br>You did not enter a zip code</br>';
			} else { 
				$zip = escape_data($_POST['zip']);
				}
			
			if(empty($_POST['country'])) {
				$country = FALSE;
				$message .= '<br>The country field is required to continue</br>';
			} else { 
				$country = escape_data($_POST['country']);
				}
			
			if(empty($_POST['countrycode'])) {
				$countrycode = FALSE;
				$message .= '<br>The country code field is required to continue</br>';
			} else { 
				$countrycode = escape_data($_POST['countrycode']);
				}
			
			if(empty($_POST['phone'])) {
				$phone = FALSE;
				$message .= '<br>A valid phone number is required</br>';
			} else { 
				$phone = escape_data($_POST['phone']);
				}
			
			if(isset($_POST['fax'])) {
				$fax = escape_data($_POST['fax']);
				}
		if( $lpquestion && $lpanswer && $fname && $lname& $email && $add1 && $city && $zip && $country && $countrycode && $phone)
				{
		$query1 = "UPDATE users SET isadmin='$isadmin', lpquestion='$lpquestion', lpanswer='$lpanswer', fname='$fname', lname='$lname', email='$email1', second_email='$email2', add1='$add1', add2='$add2', city='$city', state='$state', province='$province', rspchoice='$rspchoice', zip='$zip', country='$country', countrycode='$countrycode', phone='$phone', fax='$fax', date=NOW() WHERE username='$viewuser'";
		$result1 = @mysql_query ($query1); // Run the query.
						if (mysql_affected_rows() == 1) { // If it ran OK.
						echo "The Update was successfull";
						//Re-Run the select query to get the new information just updated.
						$query = "SELECT * FROM users WHERE username='$viewuser'";		
						$result = @mysql_query ($query);
						$row = mysql_fetch_array($result, MYSQL_ASSOC);
						} else {
						echo '<br>The update FAILED.  Please try again later<br>';
						} //End Mysql affected Rows
					}
		}  //End if Variables TRUE
	}//End If action = Modify
	else {
	if($user){
	$query_view = "SELECT * FROM users WHERE username='$viewuser'";
	$result_view = @mysql_query ($query_view);
	$row = mysql_fetch_array($result_view, MYSQL_ASSOC);
		$user = $row[username];
	$query_view = "SELECT * FROM users WHERE username='$viewuser'";
	$result_view = @mysql_query ($query_view);
		if(mysql_num_rows($result_view) == 1){
			}
		} 
	} //End If View
	
	
if($show == "all"){
	if (isset($_GET['np'])) { // Already been determined.
		$num_pages = $_GET['np'];
	} else {
	$query_all = "SELECT CONCAT(lname, ', ', fname) as Name, username, id, email, signup_date FROM users ORDER BY signup_date ASC";
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
	$query_all = "SELECT CONCAT(lname, ', ', fname) as Name, username, id, email, signup_date FROM users ORDER BY id ASC LIMIT $start, $display";
	$result_all = @mysql_query($query_all);
	$num = mysql_num_rows($result_all);
	if($num > 0){ //There were results, so lets display them
	//Make the linnks to other pages
	if ($num > 0) { // If it ran OK, display the records.
	echo "<br><h2>Registered Users</h2>";
		// Make the links to other pages, if necessary.
		if ($num_pages > 1) {
			
			echo '<p>';
			// Determine what page the script is on.	
			$current_page = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page != 1) {
				echo '<a href="userman.php?show=all&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			}
			
			// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="userman.php?show=all&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			
			// If it's not the last page, make a Next button.
			if ($current_page != $num_pages) {
				echo '<a href="userman.php?show=all&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
			
			echo '</p><br />';
			
		} // End of links section.
		
		// Table header.
			echo '<table width="100%" valign="top" class="tableO1">';
			echo "<tr>";
			echo '<td><b>View</b></td>';
			echo '<td><b>Delete</b></td>';
			echo '<td><b>Username</b></td>';
			echo '<td><b>Name</b></td>';
			echo '<td><b>Email</b></td>';
			echo '<td><b>Reg Date</b></td></tr>';
			$bg='#eeeee';
			while($row = mysql_fetch_array($result_all, MYSQL_NUM)){
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
			echo "<tr bgcolor=\"$bg\">";
			echo "<td align=\"left\"><a href=\"userman.php?show=view&user=$row[1]\">View</td>";
			echo "<td align=\"left\"><a href=\"userman.php?show=del&user=$row[1]\">Delete</td>";
			echo '<td align="left">'.$row[1].'</td>';
			echo '<td align="left">'.stripslashes($row[0]).'</td>';
			echo '<td align="left">'.$row[3].'</td>';
			echo '<td align="left">'.$row[4].'</td></tr>';
			}
		echo '</table>';

		mysql_free_result ($result_all); // Free up the resources.	
	
	} else { // If there are no registered users.
		echo '<h3>There are currently no registered users.</h3>'; 
	}
	
	mysql_close(); // Close the database connection.
	}
}//
#----------------------End SHOW ALL SECTION -----------------------------------#



#----------------------Start ADD SECTION -----------------------------------#
if($show == "add"){
	if($action == "add"){
//create a function to escape the data
	function escapte_data($data) {
		global $dbc;
		if (ini_get('magic_quotes_gpc')){
			$data = stripslashes($data);
		}
	return mysql_real_escape_string($data, $dbc);
	}
	//End of function
	
//Message variable is empty on creation
	$message = NULL  ;
	$isadmin = $_POST['isadmin'];	
//Checks for the form fields
	if (empty($_POST['reguName'])) {
		$reguName = FALSE;
		$message .= '<br>You forgot to choose a User Name</br>';
	} else { 
		$reguName = escapte_data($_POST['reguName']);
		}
	
	if(empty($_POST['password1'])) {
		$password = FALSE;
		$message .= '<br>You forgot to enter a password</br>';
	} else { 
	if($_POST['password1'] == $_POST['password2']) {
		$password = escapte_data($_POST['password1']);
	} else { 
		$password = FALSE;
		$message .= '<br>Your passwords do not match</br>';
		}
	}
	
	if(empty($_POST['lpquestion'])) {
		$lpquestion = FALSE;
		$message .= '<br>You forgot to enter a secret question</br>';
	} else { 
		$lpquestion = escapte_data($_POST['lpquestion']);
		}
	
	if(empty($_POST['lpanswer'])) {
		$lpanswer = FALSE;
		$message .= '<br>You Did not enter an answer for your secret question</br>';
	} else { 
		$lpanswer = escapte_data($_POST['lpanswer']);
		}
	
	if(empty($_POST['fname'])) {
		$fname = FALSE;
		$message .= '<br>You forgot to enter your First name</br>';
	} else { 
		$fname = escapte_data($_POST['fname']);
		}
	
	if(empty($_POST['lname'])) {
		$lname = FALSE;
		$message .= '<br>You forgot enter your last name</br>';
	} else { 
		$lname = escapte_data($_POST['lname']);
		}
	
	if(empty($_POST['email'])) {
		$email = FALSE;
		$message .= '<br>You must enter an email address</br>';
	} else { 
		$email = escapte_data($_POST['email']);
		}
	
	if(isset($_POST['second_email'])) {
		$email2 = escapte_data($_POST['second_email']);
	}

	if(empty($_POST['add1'])) {
		$add1 = FALSE;
		$message .= '<br>You did not enter your address</br>';
	} else { 
		$add1 = escapte_data($_POST['add1']);
		}
	
	if(isset($_POST['add2'])) {
		$add2 = escapte_data($_POST['add2']);
	}
	
	if(empty($_POST['city'])) {
		$city = FALSE;
		$message .= '<br>You forgot to enter a city</br>';
	} else { 
		$city = escapte_data($_POST['city']);
		}
	
	if(isset($_POST['strStateValue'])) {
		$state = escapte_data($_POST['strStateValue']);
	}

	if(isset($_POST['province'])) {
		$province = escapte_data($_POST['province']);
	}
	
	if(isset($_POST['rspchoice'])) {
		$rspchoice = TRUE;
	}
	
	if(empty($_POST['zip'])) {
		$zip = FALSE;
		$message .= '<br>You did not enter a zip code</br>';
	} else { 
		$zip = escapte_data($_POST['zip']);
		}
	
	if(empty($_POST['country'])) {
		$country = FALSE;
		$message .= '<br>The country field is required to continue</br>';
	} else { 
		$country = escapte_data($_POST['country']);
		}
	
	if(empty($_POST['countrycode'])) {
		$countrycode = FALSE;
		$message .= '<br>The country code field is required to continue</br>';
	} else { 
		$countrycode = escapte_data($_POST['countrycode']);
		}
	
	if(empty($_POST['phone'])) {
		$phone = FALSE;
		$message .= '<br>A valid phone number is required</br>';
	} else { 
		$phone = escapte_data($_POST['phone']);
		}
	
	if(isset($_POST['fax'])) {
		$fax = escapte_data($_POST['fax']);
		}

//Last line of checking to make sure everything is set to TRUE and not FALSE
if( $reguName && $password && $lpquestion && $lpanswer && $fname && $lname& $email && $add1 && $city && $zip && $country && $countrycode && $phone)
	//If everything is ok above, then proceed:<br>
{

//Need to check to see if the Username selected already exists or not
	//Build the query
	$query = "SELECT username FROM users WHERE username='$reguName'";
		//Runs the qyery
		$result = @mysql_query ($query);
				if(mysql_num_rows($result) == 0){
		
		//Register the User in the database
			
			//Make the query
			$query = "INSERT INTO users (username, password, isadmin, lpquestion, lpanswer, fname, lname, email,  second_email, add1, add2, city, state, province, rspchoice, zip, country, countrycode, phone, fax, date, signup_date)
				VALUES ('$reguName', PASSWORD('$password'), '$isadmin', '$lpquestion', '$lpanswer', '$fname', '$lname', '$email', '$second_email', '$add1', '$add2', '$city', '$state', '$province', '$rspchoice', '$zip', '$country', '$countrycode', '$phone', '$fax', NOW(), NOW() )";
			//Run the query
			$result = @mysql_query ($query);
			
			//Show Success
			echo "The account $reguName has been setup.";
				} //If Row
				else {
			echo '<br>That username is already Taken.  Please choose another.</br>';
			} //End the If row for Username Mysql Num Rows
		}//End for If variables
	} //If the action=add 
	else {
include("forms/adduser.php"); 
	}//End else action
}//End if show add
?>        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
<?php include("include/footer.php");?>
    </table>    