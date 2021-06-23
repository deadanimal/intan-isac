<?php
// I'm using the outlook macro output file (txt) as example
//echo "<b>Reading a Local File Line by Line</b><br />";

// this will open the file subject.txt located in local pc C:\Orinet\INTAN folder as read (r)
/*$file = fopen("D:\\try\\test.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
  {
  echo fgets($file). "<br />";
  }
fclose($file);
*/
/*echo "<br><br>";
echo "<b>Reading a Local File Character by Character</b><br />";
$file=fopen("D:\\try\\test.txt","r") or exit("Unable to open file!");
while (!feof($file))
  {
  echo fgetc($file);
  }
fclose($file);

*/
/*echo "<br><br>";
echo "<b>Reading a <u>Server</u> File Character by Character</b><br />";
*/// this will open the file test.txt in server
// assuming that we are running xampp (C:\xampp\htdocs\qusiah) - place the sample file in that folder 
$file=fopen("test1.oft","r") or exit("Unable to open file!");
/*while (!feof($file))
  {
  echo fgetc($file);
  }
fclose($file);

echo "<br><br>";
echo "<b>Creating file at server</b><br />";
echo "This file is created at server using php fopen()";
// this will create a new file fopen.txt in the server ("w") - overeriting the existing by default
$file = fopen("fopen.txt","w");
fwrite($file,"This file is created at server using php fopen()");
fclose($file);

*//*echo "<br><br>";
echo "<b>Creating file at <u>local</u></b><br />";
echo "This file is created locally using php fopen()";
// this will create a new file fopen.txt in local pc C:\Orinet\INTAN folder ("w") - overeriting the existing by default
$file = fopen("D:\\try\\fopen.txt","w");
fwrite($file,"This file is created locally using php fopen()");
fclose($file);

echo "<br><br>";
echo "<b>Transfer local file to server with different filename<br />";*/
/*
$f_local = fopen("D:\\try\\test.txt","r");
$f_server = fopen("server_subject.txt","w"); // you need to use parameter fo filename - the ID
while(!feof($f_local))
  {
  $linevalue = fgets($f_local);
  fwrite($f_server,$linevalue);
  }
fclose($f_local);
fclose($f_server);
*/?>