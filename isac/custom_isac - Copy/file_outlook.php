<?php
include ('db.php');
$usr =$_GET['id'];
//echo "<b>Reading a Server File Line by Line</b><br />";
//echo $usr;

//path file
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='3'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//MsOutlook
$file_outlook = $path_nameRs[0][1];
//Outlook
//$folder = $path_nameRs[0][2];
//server IP
$location = $path_nameRs[0][2];
//path mapping
$path_map = $path_nameRs[0][3];

$hostname = explode(".", gethostbyaddr($_SERVER['REMOTE_ADDR']));
$ext=".txt";
//echo($hostname[0])."<br/>";

$file = fopen($path_map."\\Outlook\\".$hostname[0].$ext, "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached

//file outlook peserta mengikut id_peserta
$fileDest = $file_outlook.'_'.$_GET['id'].'_'.date('Ymd');

$path = 'outlook/';
$ans_file = $path.$fileDest.$ext; 
//echo $ans_file;

//used at ORI
//$f_server = fopen("\\\\".$location."\\xampp\\htdocs\\isac\\outlook\\".$fileDest.$ext,"w"); // you need to use parameter for filename - the ID

//used at INTAN
$f_server = fopen($path_map."\\xampp\\htdocs\\isac\\outlook\\".$fileDest.$ext,"w"); // you need to use parameter for filename - the ID

$sql_check = "select id_penilaian_peserta_kemahiran from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta = '".$usr."' and kod_bahagian_soalan='04'";
$result_check = $myQuery->query($sql_check,'SELECT');


	if(count($result_check)==0)
	{
			//insert path file jawapan peserta
			$sql = "insert into usr_isac.prs_penilaian_peserta_kemahiran (id_peserta,fail_jawapan_peserta,kod_bahagian_soalan) values ('".$usr."','".$ans_file."','04')";
			$result = $myQuery->query($sql,'RUN');
	}

while(!feof($file))
{
  	$data = fgets($file);
  	$data ."<br/>";
	fwrite($f_server, $data);
	

	
}//eof while

$fp = fopen($path_map."\\Outlook\\".$hostname[0].$ext, "w" );
/*if ($data != '')
{
*/fwrite( $fp, "" );
fclose( $fp );
//print "End";
/*}*/
	
//echo $ans_file;
//print "File cleared";
/*$fp = fopen($path_map."\\Outlook\\".$hostname[0].$ext, "w" );
if ($file == '')
{
fwrite( $fp, "" );
fclose( $fp );
//print "End";
}

*/?> 