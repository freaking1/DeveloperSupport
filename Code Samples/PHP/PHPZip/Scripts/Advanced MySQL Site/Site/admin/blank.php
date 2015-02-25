<?php
include("../include/dbconfig.php");
include("../include/EnomInterface_inc.php");
include("include/version.php");

//Get the post for what page to show
$show = $_GET["show"];

// Number of records to show per page:
$display = 15;
	
include("include/header.php");?>
<tr>
    <td width="100%" valign="top" height="110"><table width="100%" border="0" valign="top" align="center" cellpadding="0" cellspacing="1" class="tableO1" id="table9">
      <tr>
        <td width="18%" valign="top" rowspan="2"><div align="left">
        <?php include("include/menu.php");?></div></td>
        <td width="34%" align="center">&nbsp;</td>
        <td width="23%" align="left" class="BasicText">        
        <td width="18%" align="center"> <div align="left"></div>
        </td>
      </tr>
      <tr> <span class=\"BasicText\"></span>
        <td colspan="3" rowspan="6" valign="top" align="center"><br>
          <br>
		  
		  
		  
      </tr>
<?php include("include/footer.php");?>
    </table>    