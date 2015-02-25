<?php
//get global configuration information
include_once('../include/global_config.inc.php'); 

//get pay pal configuration file
include_once('../include/config.inc.php'); 


//decide which post method to use
switch($paypal[post_method]) { 

case "libCurl": //php compiled with libCurl support

$result=libCurlPost($paypal[url],$_POST); 


break;


case "curl": //cURL via command line

$result=curlPost($paypal[url],$_POST); 

break; 


case "fso": //php fsockopen(); 

$result=fsockPost($paypal[url],$_POST); 

break; 


default: //use the fsockopen method as default post method

$result=fsockPost($paypal[url],$_POST);

break;

}


//check the ipn result received back from paypal

if(eregi("VERIFIED",$result)) 
{ include_once('ipn_success.php'); } 

else 
{ include_once('ipn_error.php'); } 


?>

