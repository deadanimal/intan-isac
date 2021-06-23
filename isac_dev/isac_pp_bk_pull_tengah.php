<?php
include('class/db_mysql.php');
include('class/sql_mysql.php');
//include ('db.php');

$kod_iac_from = $_GET['input_map_8573_11396']; 
$kod_iac_to = $_GET['input_map_8573_11400']; 
$push_info  = $_GET['input_map_8573_11397'];

/*$push_from = "select server_ip,db_username,db_password from usr_isac.pro_push_iac where 

kod_iac = '".$kod_iac_from."'";
$push_fromkRs = $myQuery->query($push_from ,'SELECT');

$push_from_ip    = $push_fromkRs[0][0];
$push_from_uname = $push_fromkRs[0][1];
$push_from_pword = $push_fromkRs[0][2];


$push_intanbk = 
$push_iac =
*/
//======== Define server ======xxx//
$server_username = 'remote';
$server_password = 'remote';
$server_database = 'usr_isac';
$server_server = '10.1.2.118';
//======== Define client ======yyy//
$client_username = 'root';
$client_password = 'isac2009';
$client_database = 'usr_isac';
$client_server = '10.1.3.80';


//=========== Setting Server =========================//
$myDbConn = new dbConnection;
$myDbConn->init($server_username,$server_password,$server_database,$server_server);
//$myDbConn->init('remote','remote','','10.1.2.118');
$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);
$query = "select * from iac_peserta where status = 'I' or status = 'U'";
$result = $myQuery->query($query ,'SELECT','NAME');
$myDbConn->disconnect();
//====================================================//
$i_count = 0;
$u_count = 0;
for($s=0;$s<count($result);$s++){

	//=========================== if status Insert =================================//
	if($result[$s][STATUS] == 'I'){

		$query = "insert into iac_peserta (id,nama,ic,alamat,status) values
		('".$result[$s][ID]."',
		'".$result[$s][NAMA]."',
		'".$result[$s][IC]."',
		'".$result[$s][ALAMAT]."',
		'N')";
		$i_count++;
		runQuery($query,'client');
	}
	//===============================================================================//

	//============================ if status Update =================================//
	elseif($result[$s][STATUS] == 'U'){

		$query = "update iac_peserta set nama = '".$result[$s][NAMA]."', ic = 

'".$result[$s][IC]."',
		alamat = '".$result[$s][ALAMAT]."', status = 'N' where ic = '".$result[$s]

[IC]."'";

		runQuery($query,'client');
		$u_count++;

	}
	//===============================================================================//

	//============================ Update server to N =================================//
	$query = "update iac_peserta set status = 'N' where ic = '".$result[$s][IC]."'";
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
		$myDbConn->init

($client_username,$client_password,$client_database,$client_server);
	}
	elseif($type == 'server'){
		$myDbConn->init

($server_username,$server_password,$server_database,$server_server);
	}

	$dbc = $myDbConn->getConnString();
	$myQuery = new dbQuery($dbc);
	$mySQL = new dbSQL($dbc);
	$query = $q;
	$rs = $myQuery->query($query,'RUN');
	$myDbConn->disconnect();

}
echo 'OOOOK!!'.'<br>';

echo 'Affected: '.count($result).'<br>';
echo 'Inserted: '.$i_count.'<br>';
echo 'Updated: '.$u_count.'<br>';
?>