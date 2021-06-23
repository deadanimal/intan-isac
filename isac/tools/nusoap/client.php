<?php
// include the SOAP classes
require_once('lib/nusoap.php');
// define parameter array (ISBN number)
$param = array('isbn'=>'1');
// define path to server application
//$serverpath ='http://services.xmethods.net:80/soap/servlet/rpcrouter';
$serverpath ='http://192.168.2.33/fareeda/tools/nusoap';
//define method namespace
$namespace="urn:xmethods-BNPriceCheck";
// create client object
$client = new soapclient($serverpath);
// make the call
$price = $client->call('lookup',$param,$namespace);
// if a fault occurred, output error info
if (isset($fault)) {
        print "Error: ". $fault;
        }
else if ($price == -1) {
        print "The book is not in the database.";
} else {
        // otherwise output the result
        print "The price of book number ". $param[isbn] ." is $". $price;
        }
// kill object
unset($client);
?>