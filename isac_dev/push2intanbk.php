<?php
include('C:/xampp/htdocs/isac/class/db_mysql.php');
include('C:/xampp/htdocs/isac/class/sql_mysql.php');

//======== Define server ======//
$server_username = 'root';
$server_password = 'isac2009';
$server_database = 'usr_isac';
$server_server = 'localhost';
//======== Define client ======//
$client_username =  'intengah';
$client_password = 'intengah';
$client_database = 'usr_isac';
$client_server = '10.1.3.80';

//=========== Setting Server =========================//
$myDbConn = new dbConnection;
$myDbConn->init($server_username,$server_password,$server_database,$server_server);
$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);
$query = "select * from iac_peserta where status = 'I' or status = 'U'";
$result = $myQuery->query($query ,'SELECT','NAME');
$myDbConn->disconnect();
//====================================================//

for($s=0;$s<count($result);$s++){

	$conn = mysql_connect($client_server,$client_username,$client_password ) or die ('Error connecting to mysql');
	$dbname = $client_database;
	mysql_select_db($dbname);	

	//=========================== if status Insert =================================//
	if($result[$s][STATUS] == 'I'){
		
		$query = mysql_query("insert into iac_peserta (id,nama,ic,alamat,status) values
		('".$result[$s][ID]."',
		'".$result[$s][NAMA]."',
		'".$result[$s][IC]."',
		'".$result[$s][ALAMAT]."',
		'N')");
	}
	//===============================================================================//

	//============================ if status Update =================================//
	elseif($result[$s][STATUS] == 'U'){
	
		$query = mysql_query("update iac_peserta set nama = '".$result[$s][NAMA]."', ic = '".$result[$s][IC]."',
		alamat = '".$result[$s][ALAMAT]."', status = 'N' where id = '".$result[$s][ID]."'");

	}
	//===============================================================================//

	//============================ Update server to N =================================//
	$query = "update iac_peserta set status = 'N' where id = '".$result[$s][ID]."'";
	runQuery($query,'server');
	//===============================================================================//
}


function runQuery($q,$type) {

	//======== Define server ======//
	global $server_username;
	global $server_password;
	global $server_database;
	global $server_server;
	//=============================//
	//======== Define client ======//
	global $client_username;
	global $client_password;
	global $client_database;
	global $client_server;
	//=============================//

	$myDbConn = new dbConnection;

	if($type == 'client'){
		 $myDbConn->init($client_username,$client_password,$client_database,$client_server);
	}
	elseif($type == 'server'){
		$myDbConn->init($server_username,$server_password,$server_database,$server_server);
	}

	$dbc = $myDbConn->getConnString();
	$myQuery = new dbQuery($dbc);
	$mySQL = new dbSQL($dbc);
	$query = $q;
	$rs = $myQuery->query($query,'RUN');
	$myDbConn->disconnect();

}
echo 'ooooK push to intanBK !!';

?>