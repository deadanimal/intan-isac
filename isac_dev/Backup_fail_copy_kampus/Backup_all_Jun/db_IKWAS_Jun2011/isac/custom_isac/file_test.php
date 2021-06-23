<?php
//include ('db.php');
//$usr =$_GET['id'];
echo "<b>Reading a Server File Line by Line</b><br />";
//echo $usr;

//path file

$hostname = explode(".", gethostbyaddr($_SERVER['REMOTE_ADDR']));
//$ext=".txt";
echo($hostname[0])."<br/>";

$file = fopen("C:\\xampp\\htdocs\\isac\\outlook\\MsOutlook_541_20100209.txt", "r");

//$file = fopen("C:\\Outlook\\QUSIAH.txt", "r") or exit("Unable to open file!");

$f_server = fopen("C:\\xampp\\htdocs\\isac\\outlook\\test3.txt","w") or exit("Unable to copy file!");

//Output a line of the file until the end is reached
while(!feof($file))
{
  	$data = fgets($file);
  	echo $data ."<br/>";
	fwrite($f_server, $data);
	
}//eof while
fclose($file);
fclose($f_server);

//$file = fopen(\\10.1.3.80\htdocs\isac\outlook\MsOutlook_541_20100209.txt)

?> 