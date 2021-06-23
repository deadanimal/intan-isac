<?php
  $client = new SoapClient("stockquote2.wsdl");
  try {
    echo "<pre>n";
    print($client->getQuote("ibm"));
    echo "n";
    print($client->getQuote("microsoft"));  
    echo "n</pre>n";
  } catch (SoapFault $exception) {
    echo $exception;   
  }
?>