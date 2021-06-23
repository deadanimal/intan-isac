<?php
include('C:/xampp/htdocs/isac/class/db_mysql.php');
include('C:/xampp/htdocs/isac/class/sql_mysql.php');

//======== Define Source ======//
$source_username = 'root';
$source_password = 'isac2009';
$source_database = 'usr_isac';
$source_server = 'localhost';
//======== Define Target ======//
$target_username =  'intanbk';
$target_password = 'intanbk123';
$target_database = 'usr_isac';
$target_server = '10.1.2.118';

//=========== Getting Source Data =========================//
$myDbConn = new dbConnection;
$myDbConn->init($source_username,$source_password,$source_database,$source_server);
$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);
$query = "select * from iac_peserta where status = 'I' or status = 'U'";
$result = $myQuery->query($query ,'SELECT','NAME');
$myDbConn->disconnect();
$i_count = 0;
$u_count = 0;
//====================================================//
for($s=0;$s<count($result);$s++){

	$conn = mysql_connect($target_server,$target_username,$target_password ) or die ('Error connecting to mysql');
	$dbname = $target_database;
	mysql_select_db($dbname);	

	//=========================== if status Insert =================================//
	if($result[$s][STATUS] == 'I'){
		$query = mysql_query("insert into iac_peserta (id,nama,ic,alamat,status) values
		('".$result[$s][ID]."',
		'".$result[$s][NAMA]."',
		'".$result[$s][IC]."',
		'".$result[$s][ALAMAT]."',
		'N')");
		$i_count++;
	}
	//============================ if status Update =================================//
	elseif($result[$s][STATUS] == 'U'){
		$query = mysql_query("update iac_peserta set nama = '".$result[$s][NAMA]."', ic = '".$result[$s][IC]."',
		alamat = '".$result[$s][ALAMAT]."', status = 'N' where ic = '".$result[$s][IC]."'");
		$u_count++;
	}

	//============================ Update Source to N =================================//
	$query = "update iac_peserta set status = 'N' where ic = '".$result[$s][IC]."'";
	runQuery($query,'source');
	//===============================================================================//
}


function runQuery($q,$type) {

	//======== Define Source ======//
	global $source_username;
	global $source_password;
	global $source_database;
	global $source_server;
	//======== Define Target ======//
	global $target_username;
	global $target_password;
	global $target_database;
	global $target_server;
	//=============================//

	$myDbConn = new dbConnection;

	if($type == 'target'){
		 $myDbConn->init($target_username,$target_password,$target_database,$target_server);
	}
	elseif($type == 'source'){
		$myDbConn->init($source_username,$source_password,$source_database,$source_server);
	}

	$dbc = $myDbConn->getConnString();
	$myQuery = new dbQuery($dbc);
	$mySQL = new dbSQL($dbc);
	$query = $q;
	$rs = $myQuery->query($query,'RUN');
	$myDbConn->disconnect();

}
echo 'Push to '.$target_server.' OK !!'.'<br>';
echo 'Inserted: '.$i_count.'<br>';
echo 'Updated : '.$u_count.'<br>';
echo 'Total Affected: '.count($result).'<br>';

?>