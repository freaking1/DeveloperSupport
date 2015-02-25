<?php
include("include/sessions.php");
include("include/EnomInterface_inc.php");

$Enom = new CEnomInterface;
$Enom->AddParam( "uid", "enom username" );
$Enom->AddParam( "pw", "enom password" );
$Enom->AddParam( "command", "GETAGREEMENTPAGE" );
$Enom->DoTransaction();

$content = urldecode($Enom->Values['content']);
echo $content;
?>