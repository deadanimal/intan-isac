<?php
include('class/db_mysql.php');
include('class/sql_mysql.php');
include ('db.php');
include('class/log.php');

$kod_iac = '04';
//$kod_iac = $_GET['iac'];
// Logging class initialization
$log = new Logging();
// write message to the log file

echo $kod_iac;

/*$iac_from = "select server_ip,db_username,db_password from usr_isac.pro_push_iac where kod_iac='01'";
$iac_fromRs = $myQuery->query($iac_from,'SELECT');

$source_ip = $iac_fromRs[0][0];
$source_uname = $iac_fromRs[0][1];
$source_pword = $iac_fromRs[0][2];*/
//$source_pword ='';

$iac_to = "select server_ip,db_username,db_password from usr_isac.pro_push_iac where kod_iac='$kod_iac'";
$iac_toRs = $myQuery->query($iac_to,'SELECT');

$target_ip = $iac_toRs[0][0];
$target_uname = $iac_toRs[0][1];
$target_pword = $iac_toRs[0][2];

//======== Define Source ======//kampus@IAC
$source_username =  'intanbk';//$target_uname;
$source_password = 'isac2009' ;//$target_pword;
$source_database = 'usr_isac2';
$source_server = '10.112.108.13';//$target_ip;

//======== Define Target ======//intanbk
$target_username =  'root';//$target_uname;
$target_password = 'isac2009' ;//$target_pword;
$target_database = 'usr_isac2';
$target_server = 'localhost';//$target_ip;

//=========== Getting Source Data =========================//
$myDbConn = new dbConnection;
$myDbConn->init($source_username,$source_password,$source_database,$source_server);
$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);

//==========pro_sijil===========
$query = "select count(id_sijil) from pro_sijil where status_push_pull = 'I'";
$result = $myQuery->query($query,'SELECT');

$bil = $result[0][0];

echo 'pull!!!';
echo $bil;

echo $query3 = "select NO_SIJIL,KOD_IAC,ID_PESERTA,ID_PERMOHONAN,STATUS_PUSH_PULL,TIMESTAMP from pro_sijil where status_push_pull = 'I' limit 5 ";
$result3 = $myQuery->query($query3,'SELECT','NAME');


echo '<pre>';
print_r($result3);
echo '</pre>';

//exit();

$myDbConn->disconnect();

$i_count = 0;
$u_count = 0;


//====================INSERT PRO_SIJIL================================//
for($e=0;$e<count($result3);$e++){

	$conn = mysql_connect($target_server,$target_username,$target_password ) or die ('Error connecting to mysql');
	$dbname = $target_database;
	mysql_select_db($dbname);
	

	//=========================== if status Insert =================================//
	if($result3[$e][STATUS_PUSH_PULL] == 'I'){

	 
		 $query3 = mysql_query("insert into pro_sijil (NO_SIJIL,KOD_IAC,ID_PESERTA,ID_PERMOHONAN,STATUS_PUSH_PULL,TIMESTAMP) values 
	('".$result3[$e][NO_SIJIL]."','$kod_iac','".$result3[$e][ID_PESERTA]."','".$result3[$e][ID_PERMOHONAN]."','N','".$result3[$e][TIMESTAMP]."')");
		 
		// $log->lwrite("IAC - Table pro_perkhidmatan : '".$result[$e][ID_PERKHIDMATAN]."' inserted.");
		 
	 
		$i_count++;
	}
	
	//========update to N=====
	$queryupdate3 = "update pro_sijil set status_push_pull = 'N' where ID_SIJIL = '".$result3[$e][ID_SIJIL]."'";
	runQuery($queryupdate3,'source');
	
//mysql_close($conn);
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
echo 'Pull from '.$source_server.' OK !!'.'<br>';

echo 'Inserted: '.$i_count.'<br>';
echo 'Updated : '.$u_count.'<br>';
echo 'Total Affected: '.count($result3).'<br>';

echo 'Total Inserted(pro_sijil): '.count($result3).'<br>';
/*echo 'Total Inserted(prs_penilaian_peserta): '.count($result4).'<br>';
echo 'Total Inserted(prs_penilaian_keputusan_bahagian): '.count($result7).'<br>';

echo 'Total Updated(pro_peserta): '.count($result8).'<br>';
echo 'Total Updated(prs_permohonan): '.count($result9).'<br>';
echo 'Total Updated(prs_perkhidmatan): '.count($result10).'<br>';*/

?>
<p> </p>
<input type="submit" name="button" id="button" value="Done" onclick="history.go(-2)"/>