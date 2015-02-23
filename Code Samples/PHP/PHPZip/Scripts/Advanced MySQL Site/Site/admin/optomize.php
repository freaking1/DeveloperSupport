<?php
$sql = mysql_query("OPTIMIZE TABLE cart");
echo " <span class=\"BasicText\">Succesfully optomized table 'cart'<br>";
$sql = mysql_query("OPTIMIZE TABLE invoice_items");
echo " <span class=\"BasicText\">Succesfully optomized table 'invoice_items'<br>";
$sql = mysql_query("OPTIMIZE TABLE check_log");
echo " <span class=\"BasicText\">Succesfully optomized table 'check_log'<br>";
$sql = mysql_query("OPTIMIZE TABLE contact");
echo " <span class=\"BasicText\">Succesfully optomized table 'contact'<br>";
$sql = mysql_query("OPTIMIZE TABLE customer_invoice");
echo " <span class=\"BasicText\">Succesfully optomized table 'customer_invoice'<br>";
$sql = mysql_query("OPTIMIZE TABLE domains");
echo " <span class=\"BasicText\">Succesfully optomized table 'domains'<br>";
$sql = mysql_query("OPTIMIZE TABLE news");
echo " <span class=\"BasicText\">Succesfully optomized table 'news'<br>";
$sql = mysql_query("OPTIMIZE TABLE push_log");
echo " <span class=\"BasicText\">Succesfully optomized table 'push_log'<br>";
$sql = mysql_query("OPTIMIZE TABLE transfers");
echo " <span class=\"BasicText\">Succesfully optomized table 'transfers'<br>";
$sql = mysql_query("OPTIMIZE TABLE webhosting");
echo " <span class=\"BasicText\">Succesfully optomized table 'webhosting'<br>";
$sql = mysql_query("OPTIMIZE TABLE users");
echo " <span class=\"BasicText\">Succesfully optomized table 'users'<br>";
$sql = mysql_query("OPTIMIZE TABLE whois_log");
echo " <span class=\"BasicText\">Succesfully optomized table 'whois_log'<br>";
?>