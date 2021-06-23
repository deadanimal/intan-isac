<?php
require_once('../lib/nusoap.php'); 
$wsdl="http://localhost/fareeda/tools/nusoap/new/server.php?wsdl";
$client=new soapclient($wsdl);
$param=array('int1'=>'15.00', 'int2'=>'10'); 
echo $client->call('add', $param);
?>