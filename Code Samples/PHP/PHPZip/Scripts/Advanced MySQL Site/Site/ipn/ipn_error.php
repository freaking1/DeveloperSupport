<?php
include_once('../include/global_config.inc.php'); 
create_csv_file("logs/ipn_error.txt",$_POST);
?> 