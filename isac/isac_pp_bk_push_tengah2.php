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
//======== SOURCE ======//
$source_username = 'root';
$source_password = 'isac2009';
$source_database = 'usr_isac';
$source_server = '10.1.3.80';
//======== DESTINATION ======//
$dest_username = 'remote';
$dest_password = 'remote';
$dest_database = 'usr_isac';
$dest_server = '10.1.2.118';


//=========== Geetting Data from Source =========================//
$myDbConn = new dbConnection;
$myDbConn->init($source_username,$source_password,$source_database,$source_server);
$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);
$query = "select * from iac_peserta where status = 'I' or status = 'U' order by id";
$result = $myQuery->query($query ,'SELECT','NAME');
$myDbConn->disconnect();
//====================================================//
$i_count = 0;
$u_count = 0;

// create new connection to destination
$myDbConn = new dbConnection;
$myDbConn->init($dest_username,$dest_password,$dest_database,$dest_server);
for($s=0;$s<count($result);$s++){
	//=========================== if status Insert =================================//
	if($result[$s][STATUS] == 'I'){

		$query_insert = "insert into iac_peserta (id,nama,ic,alamat,status) values
		('".$result[$s][ID]."',
		'".$result[$s][NAMA]."',
		'".$result[$s][IC]."',
		'".$result[$s][ALAMAT]."',
		'N')";
		$return = $myQuery->query($query_insert ,'RUN');
		echo $return;
		$i_count++;
		//runQuery($query,'client');
	}

	//============================ if status Update =================================//
	elseif($result[$s][STATUS] == 'U'){

		$query_update = "update iac_peserta set nama = '".$result[$s][NAMA]."', ic = '".$result[$s][IC]."',
		alamat = '".$result[$s][ALAMAT]."', status = 'N' where ic = '".$result[$s][IC]."'";
		$myQuery->query($query_update ,'RUN');
		//runQuery($query,'client');
		$u_count++;
	}
	
}
$myDbConn->disconnect();
// disconnect current connection (destination)
// reconnection to source
$myDbConn = new dbConnection;
	$myDbConn->init($source_username,$source_password,$source_database,$source_server);


for($s=0;$s<count($result);$s++){

	//============================ Update source to N =================================//
	$query_last = "update iac_peserta set status = 'N' where ic = '".$result[$s][IC]."'";
	runQuery($query,'server');
	$myQuery->query($query_last ,'RUN');
	//===============================================================================//
}

// disconnect current connection (source)
$myDbConn->disconnect();

echo 'OOOOK!!'.'<br>';

echo 'Affected: '.count($result).'<br>';
echo 'Inserted: '.$i_count.'<br>';
echo 'Updated: '.$u_count.'<br>';
?>