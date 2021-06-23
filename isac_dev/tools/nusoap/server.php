<?php
// function to get price from database
function lookup($ISBN) {
    $query = "select price from books where isbn = ". $ISBN;
    mysql_connect("localhost", "root", "");
	mysql_select_db("books");
	$result = mysql_query($query);
	/*if (mysql_connect("localhost", "root", ""))
    else { $error = "Database connection error";
        return $error; }*/
     /*if (mysql_select_db("books"))
    else { $error = "Database not found";
        return $error; }*/
      /*if ($result = mysql_query($query))
    else { $error = "mysql_error()";
        return $error; }*/
    $price = mysql_result($result, 0, 0);
    return $price;
    }
// include the SOAP classes
require_once('lib/nusoap.php');
// create the server object
$server = new soap_server;
// register the lookup service
$server->register('lookup');
// if the lookup fails, return an error
if ($price == 0) {
    $error = "Price lookup error";
    }
if (isset($error)) {
    $fault = $server->fault('soap:Server','http://localhost/fareeda/tools/nusoap/server.php',$error);
    }
// send the result as a SOAP response over HTTP
$server->service($HTTP_RAW_POST_DATA);
?>