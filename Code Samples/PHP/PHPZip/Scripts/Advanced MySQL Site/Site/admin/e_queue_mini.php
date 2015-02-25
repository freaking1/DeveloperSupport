<link rel="stylesheet" href= "../css/styles.css" type="text/css">
<?php 
include("../include/dbconfig.php");
$table_id = $_GET['id'];

$query2 = "SELECT invoice_id, command, sld, tld, string, response FROM invoice_items WHERE table_id = '$table_id'";
$result2 = @mysql_query($query2);
$show = mysql_fetch_row($result2);

$ID = $table_id;
$invoice = $show[0];
$command = $show[1];
$sld = $show[2];
$tld = $show[3];
$string = $show[4];
$response = $show[5];

echo "
<table width=\"60%\"  border=\"0\" class=\"TableOO\">
  <tr>
    <td> [ ID ] $ID</td>
  </tr>
  <tr>
    <td>[ Invoice ]: $invoice</td>
  </tr>
  <tr>
    <td>[ Domain ] $sld.$tld </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>$string</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>$response</td>
  </tr>
</table>
";
?>