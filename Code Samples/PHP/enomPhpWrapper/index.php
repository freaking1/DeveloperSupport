<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<body>

<?php include("enom_wrapper.php");?>
<?php include("curl.php");?>

$params = array(
  'uid'           => 'username',
  'pw'            => 'password',
  'command'       => 'check',
  'Display'       => 100,
  'ResponseType'  => 'xml',
);

// Laravel Specific
// $output = Enom::execute( $params );

// Codeigniter Specific
// $this->enom->execute( $params );


</body>
</html>