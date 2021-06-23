<?php
echo "<b>Reading a Server File Line by Line</b><br />";

$hostname = explode(".", gethostbyaddr($_SERVER['REMOTE_ADDR']));
$ext=".txt";
echo($hostname[0])."<br/>";

$file = fopen("E:\\Outlook\\".$hostname[0].$ext, "r") or exit("Unable to open file!");
//$file = fopen("E:\\Outlook\\SAFA.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached

$f_server = fopen("\\\\192.168.2.7\\xampp\\htdocs\\isac\\outlook\\fileoutput_99.txt","w"); // you need to use parameter fo filename - the ID

while(!feof($file))
  {
  	$data = fgets($file);
  	echo $data ."<br/>";
	fwrite($f_server, $data);
  }
fclose($file);
fclose($f_server);
?> 