<?php
include('class/db_mysql.php');
include('class/sql_mysql.php');
//include ('db.php');

$kod_iac_from = $_GET['input_map_8573_11396']; 
$kod_iac_to = $_GET['input_map_8573_11400']; 
$push_info  = $_GET['input_map_8573_11397'];

/*$push_from = "select server_ip,db_username,db_password from usr_isac.pro_push_iac where kod_iac = '".$kod_iac_from."'";
$push_fromkRs = $myQuery->query($push_from ,'SELECT');

$push_from_ip    = $push_fromkRs[0][0];
$push_from_uname = $push_fromkRs[0][1];
$push_from_pword = $push_fromkRs[0][2];

$push_intanbk = 
$push_iac =
*/
//======== Define server ======INTANBK//
$server_username = 'root';
$server_password = 'isac2009';
$server_database = 'usr_isac';
$server_server = '10.1.3.80';
//======== Define client ======OTHER IAC//
$client_username = 'root';
$client_password = 'isac2009';
$client_database = 'usr_isac';
$client_server = 'localhost';


//=========== Setting Server =========================//
$myDbConn = new dbConnection;
//$myDbConn->init($server_username,$server_password,$server_database,$server_server);
$myDbConn->init('tengah','tengah','usr_isac','10.1.3.80');

$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);
$query = "select * from iac_peserta where status = 'I' or status = 'U'";
$result = $myQuery->query($query ,'SELECT','NAME');
$myDbConn->disconnect();
//====================================================//

for($s=0;$s<count($result);$s++){

	//=========================== if status Insert =================================//
	if($result[$s][STATUS] == 'I'){

		$query = "insert into iac_peserta (id,nama,ic,alamat,status) values
		('".$result[$s][ID]."',
		'".$result[$s][NAMA]."',
		'".$result[$s][IC]."',
		'".$result[$s][ALAMAT]."',
		'N')";

		runQuery($query,'client');
	}
	//===============================================================================//

	//============================ if status Update =================================//
	elseif($result[$s][STATUS] == 'U'){

		$query = "update iac_peserta set nama = '".$result[$s][NAMA]."', ic = '".$result[$s][IC]."',
		alamat = '".$result[$s][ALAMAT]."', status = 'N' where id = '".$result[$s][ID]."'";

		runQuery($query,'client');

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
echo 'lalalaa!!';


?>