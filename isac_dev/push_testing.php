<?php
include('class/db_mysql.php');
include('class/sql_mysql.php');
include ('db.php');
include('class/log.php');

echo $kod_iac = '01';
//$kod_iac = $_GET['iac'];
// Logging class initialization
$log = new Logging();
// write message to the log file



/*$iac_from = "select server_ip,db_username,db_password from usr_isac.pro_push_iac where kod_iac='01'";
$iac_fromRs = $myQuery->query($iac_from,'SELECT');

$source_ip = $iac_fromRs[0][0];
$source_uname = $iac_fromRs[0][1];
$source_pword = $iac_fromRs[0][2];
//$source_pword ='';


$iac_to = "select server_ip,db_username,db_password from usr_isac.pro_push_iac where kod_iac='02'";
$iac_toRs = $myQuery->query($iac_to,'SELECT');

$target_ip = $iac_toRs[0][0];
$target_uname = $iac_toRs[0][1];
$target_pword = $iac_toRs[0][2];
//$target_pword = '';*/
$iac_to = "select server_ip,db_username,db_password from usr_isac.pro_push_iac where kod_iac='$kod_iac'";
$iac_toRs = $myQuery->query($iac_to,'SELECT');

$target_ip = $iac_toRs[0][0];
$target_uname = $iac_toRs[0][1];
$target_pword = $iac_toRs[0][2];


//======== Define Source ======//intura
$source_username = 'intanbk';//$source_uname;
$source_password = 'isac2009';//$source_pword;
$source_database = 'usr_isac2';
$source_server = '10.112.108.13';//$source_ip;

//======== Define Target ======//intengah
$target_username =  'root';//$target_uname;
$target_password = 'isac2009';//$target_pword;
$target_database = 'usr_isac2';
$target_server = 'localhost';//$target_ip;

//=========== Getting Source Data =========================//
$myDbConn = new dbConnection;
$myDbConn->init($source_username,$source_password,$source_database,$source_server);
$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);
//$query = "select * from pro_pengetahuan where status_push_pull = 'I' or status_push_pull = 'U'";
echo $query = "select b.id_penyelaras, a.id_peserta, a.nama_peserta, c.id_sesi,c.kod_iac,a.no_kad_pengenalan, a.no_kad_pengenalan_lain, a.status_push_pull,
b.id_permohonan, b.kod_status_permohonan, b.kod_status_kehadiran, b.kod_tahap, d.id_perkhidmatan, d.kod_klasifikasi_perkhidmatan
from pro_peserta a, prs_permohonan b, pro_sesi c, pro_perkhidmatan d where
a.id_peserta = b.id_peserta and b.id_sesi = c.id_sesi and a.id_peserta = d.id_peserta and c.kod_iac = '$kod_iac' and c.tarikh_sesi >= curdate() and
(a.status_push_pull = 'I' or a.status_push_pull = 'U')";

$result = $myQuery->query($query ,'SELECT','NAME');

$query2 = "select * from pro_sesi a,prs_penilaian b where a.kod_iac = '$kod_iac' and a.id_sesi=b.id_sesi and a.tarikh_sesi >= curdate() and
(a.status_push_pull = 'I' or a.status_push_pull = 'U')";

$result2 = $myQuery->query($query2 ,'SELECT','NAME');

/*$query = "select d.id_perkhidmatan,d.kod_klasifikasi_perkhidmatan, d.kod_gred_jawatan,a.id_peserta,d.status_push_pull
from  pro_peserta a,prs_permohonan b, pro_perkhidmatan d,pro_sesi c where
a.id_peserta=b.id_peserta and b.id_peserta = d.id_peserta and c.id_sesi=b.id_sesi and  b.id_sesi=433 and c.tarikh_sesi >= curdate() and
(d.status_push_pull = 'I' or d.status_push_pull = 'U')";

$result = $myQuery->query($query ,'SELECT','NAME');

$query2 = "select * from pro_sesi a,prs_penilaian b where a.kod_iac = '$kod_iac' and a.id_sesi=b.id_sesi and a.tarikh_sesi >= curdate() and
(a.status_push_pull = 'I' or a.status_push_pull = 'U')";

$result2 = $myQuery->query($query2 ,'SELECT','NAME');*/


echo '<pre>';
print_r($result);
echo '</pre>';

//exit();

$myDbConn->disconnect();

$i_count = 0;
$u_count = 0;


for($c=0;$c<count($result2);$c++){
//echo $result2[$c][STATUS_PUSH_PULL];
	$conn = mysql_connect($target_server,$target_username,$target_password ) or die ('Error connecting to mysql');
	$dbname = $target_database;
	mysql_select_db($dbname);	
	
	
//CHECK BALIK
			echo $query = mysql_query("insert into pro_sesi values
		 ('".$result2[$c][ID_SESI]."','".$result2[$c][KOD_SESI_PENILAIAN]."','".$result2[$c][TARIKH_SESI]."','".$result2[$c][KOD_MASA_MULA]."',
		 '".$result2[$c][KOD_MASA_TAMAT]."','".$result2[$c][BILANGAN_PESERTA]."','".$result2[$c][KOD_KEMENTERIAN]."','".$result2[$c][LOKASI]."',
		 '$kod_iac','".$result2[$c][KOD_STATUS]."','".$result2[$c][ID_PENGHANTARAN]."','".$result2[$c][KOD_JENIS_SESI]."',
		 '".$result2[$c][KOD_TAHAP]."','".$result2[$c][KOD_KATEGORI_PESERTA]."','".$result2[$c][KOD_PENGESAHAN_PENILAIAN]."','".$result2[$c][JUMLAH_KESELURUHAN]."',
		 '".$result2[$c][TARIKH_CIPTA]."','".$result2[$c][TARIKH_KEMASKINI]."','".$result2[$c][ID_PENGGUNA]."','N','')");
		 
		 $log->lwrite("IAC - Table pro_sesi : '".$result2[$c][ID_SESI]."' inserted.");
		 

		 
		 $query2 = mysql_query("insert into prs_penilaian (id_penilaian, tarikh_penilaian, id_sesi, status_push_pull) values 
		 ('".$result2[$c][ID_PENILAIAN]."','".$result2[$c][TARIKH_PENILAIAN]."','".$result2[$c][ID_SESI]."','N')");	
		 
		 $log->lwrite("IAC - Table prs_penilaian : '".$result2[$c][ID_PENILAIAN]."' inserted.");
	

		
	//=========================== if status Insert =================================//
	if($result2[$c][STATUS_PUSH_PULL] == 'I'){

		/*echo "insert into pro_sesi values
		 ('".$result2[$c][ID_SESI]."','".$result2[$c][KOD_SESI_PENILAIAN]."','".$result2[$c][TARIKH_SESI]."','".$result2[$c][KOD_MASA_MULA]."',
		 '".$result2[$c][KOD_MASA_TAMAT]."','".$result2[$c][BILANGAN_PESERTA]."','".$result2[$c][KOD_KEMENTERIAN]."','".$result2[$c][LOKASI]."',
		 '".$result2[$c][KOD_IAC]."','".$result2[$c][KOD_STATUS]."','".$result2[$c][ID_PENGHANTARAN]."','".$result2[$c][KOD_JENIS_SESI]."',
		 '".$result2[$c][KOD_TAHAP]."','".$result2[$c][KOD_KATEGORI_PESERTA]."','".$result2[$c][KOD_PENGESAHAN_PENILAIAN]."','".$result2[$c][JUMLAH_KESELURUHAN]."',
		 '".$result2[$c][TARIKH_CIPTA]."','".$result2[$c][TARIKH_KEMASKINI]."','".$result2[$c][ID_PENGGUNA]."','N','')"; 
	
		 $query = mysql_query("insert into pro_sesi values
		 ('".$result2[$c][ID_SESI]."','".$result2[$c][KOD_SESI_PENILAIAN]."','".$result2[$c][TARIKH_SESI]."','".$result2[$c][KOD_MASA_MULA]."',
		 '".$result2[$c][KOD_MASA_TAMAT]."','".$result2[$c][BILANGAN_PESERTA]."','".$result2[$c][KOD_KEMENTERIAN]."','".$result2[$c][LOKASI]."',
		 '".$result2[$c][KOD_IAC]."','".$result2[$c][KOD_STATUS]."','".$result2[$c][ID_PENGHANTARAN]."','".$result2[$c][KOD_JENIS_SESI]."',
		 '".$result2[$c][KOD_TAHAP]."','".$result2[$c][KOD_KATEGORI_PESERTA]."','".$result2[$c][KOD_PENGESAHAN_PENILAIAN]."','".$result2[$c][JUMLAH_KESELURUHAN]."',
		 '".$result2[$c][TARIKH_CIPTA]."','".$result2[$c][TARIKH_KEMASKINI]."','".$result2[$c][ID_PENGGUNA]."','N','')");
		 
		 $log->lwrite("IAC - Table pro_sesi : '".$result2[$c][ID_SESI]."' inserted.");
		 
		 $query2 = mysql_query("insert into prs_penilaian id_penilaian, tarikh_penilaian, id_sesi, status_push_pull values 
		 ('".$result2[$c][ID_PENILAIAN]."','".$result2[$c][TARIKH_PENILAIAN]."','".$result2[$c][ID_SESI]."','N')");	
		 
		 $log->lwrite("IAC - Table prs_penilaian : '".$result2[$c][ID_PENILAIAN]."' inserted.");
		 */
	}
	
		//============================ if status Update =================================//
	elseif($result2[$c][STATUS_PUSH_PULL] == 'U'){
	
		$query = mysql_query("update pro_sesi set id_sesi='".$result2[$c][ID_SESI]."',kod_sesi_penilaian='".$result2[$c][KOD_SESI_PENILAIAN]."',tarikh_sesi='".$result2[$c][TARIKH_SESI]."',kod_masa_mula='".$result2[$c][KOD_MASA_MULA]."',kod_masa_tamat='".$result2[$c][KOD_MASA_TAMAT]."',bilangan_peserta'".$result2[$c][BILANGAN_PESERTA]."',kod_kementerian='".$result2[$c][KOD_KEMENTERIAN]."',lokasi='".$result2[$c][LOKASI]."',kod_iac='$kod_iac',kod_status='".$result2[$c][KOD_STATUS]."',id_ppenghantaran='".$result2[$c][ID_PENGHANTARAN]."',kod_jenis_sesi='".$result2[$c][KOD_JENIS_SESI]."',kod_tahap='".$result2[$c][KOD_TAHAP]."',kod_kategori_peserta='".$result2[$c][KOD_KATEGORI_PESERTA]."',kod_pengesahan_penilaian='".$result2[$c][KOD_PENGESAHAN_PENILAIAN]."',jumlah_keseluruhan='".$result2[$c][JUMLAH_KESELURUHAN]."',tarikh_cipta='".$result2[$c][TARIKH_CIPTA]."',tarikh_kemaskini='".$result2[$c][TARIKH_KEMASKINI]."',id_pengguna='".$result2[$c][ID_PENGGUNA]."',status_push_pull='N' ");
		
		$log->lwrite("IAC - Table pro_sesi : '".$result2[$c][ID_SESI]."' updated.");	
		
		$query2 = mysql_query("update prs_penilaian set id_penilaian = '".$result2[$c][ID_PENILAIAN]."', tarikh_penilaian = '".$result2[$c][TARIKH_PENILAIAN]."', id_sesi = '".$result2[$c][ID_SESI]."', status_push_pull = 'N' ");
		
		$log->lwrite("IAC - Table prs_penilaian : '".$result2[$c][ID_PENILAIAN]."' updated.");
	
	}
	
	$queryupdate2 = "update pro_sesi set status_push_pull = 'N' where id_sesi = '".$result2[$c][ID_SESI]."'";
	runQuery($queryupdate2,'source');
	
	$log->lwrite("INTAN BK - Table pro_sesi : '".$result2[$c][ID_SESI]."' updated.");
	
	$queryupdate3 = "update prs_penilaian set status_push_pull = 'N' where id_penilaian = '".$result2[$c][ID_PENILAIAN]."'";
	runQuery($queryupdate3,'source');
	
	$log->lwrite("INTAN BK - Table prs_penilaian : '".$result2[$c][ID_PENILAIAN]."' updated.");
}


//====================================================//
for($s=0;$s<count($result);$s++){

	$conn = mysql_connect($target_server,$target_username,$target_password ) or die ('Error connecting to mysql');
	$dbname = $target_database;
	mysql_select_db($dbname);	

	//=========================== if status Insert =================================//
	if($result[$s][STATUS_PUSH_PULL] == 'I'){
		$nama = $result[$s][NAMA_PESERTA];
		$nama_peserta = str_replace("'",'&#039;',$nama);
		
		 $query = mysql_query("insert into pro_peserta (id_penyelaras,id_peserta,nama_peserta,no_kad_pengenalan,no_kad_pengenalan_lain,status_push_pull) values
		 ('".$result[$s][ID_PENYELARAS]."','".$result[$s][ID_PESERTA]."','$nama_peserta','".$result[$s][NO_KAD_PENGENALAN]."',
		 '".$result[$s][NO_KAD_PENGENALAN_LAIN]."','N')");
		 
		 $log->lwrite("IAC - Table pro_peserta : '".$result[$s][ID_PESERTA]."' inserted.");
		 
		 $query2 = mysql_query("insert into prs_permohonan (id_permohonan,id_peserta,id_penyelaras,kod_status_permohonan,kod_status_kehadiran,id_sesi,kod_tahap,status_push_pull) values
		 ('".$result[$s][ID_PERMOHONAN]."','".$result[$s][ID_PESERTA]."','".$result[$s][ID_PENYELARAS]."','".$result[$s][KOD_STATUS_PERMOHONAN]."',
		 '".$result[$s][KOD_STATUS_KEHADIRAN]."','".$result[$s][ID_SESI]."','".$result[$s][KOD_TAHAP]."','N')");
		 
		 $log->lwrite("IAC - Table prs_permohonan : '".$result[$s][ID_PERMOHONAN]."' inserted.");
		 
		 $query3 = mysql_query("insert into pro_perkhidmatan (id_perkhidmatan,kod_klasifikasi_perkhidmatan,kod_gred_jawatan,id_peserta,status_push_pull) values
		 ('".$result[$s][ID_PERKHIDMATAN]."','".$result[$s][KOD_KLASIFIKASI_PERKHIDMATAN]."','".$result[$s][KOD_GRED_JAWATAN]."','".$result[$s][ID_PESERTA]."','N')");
		 
		 $log->lwrite("IAC - Table pro_perkhidmatan : '".$result[$s][ID_PERKHIDMATAN]."' inserted.");
		 
	 
		$i_count++;
	}
	//============================ if status Update =================================//
	elseif($result[$s][STATUS_PUSH_PULL] == 'U'){
		$query4 = mysql_query("update pro_peserta set id_penyelaras = '".$result[$s][ID_PENYELARAS]."', nama_peserta = '".$result[$s][NAMA_PESERTA]."',
		no_kad_pengenalan = '".$result[$s][NO_KAD_PENGENALAN]."',no_kad_pengenalan_lain = '".$result[$s][NO_KAD_PENGENALAN_LAIN]."', status_push_pull = 'N' where 						id_peserta = '".$result[$s][ID_PESERTA]."'");
		
		$log->lwrite("IAC - Table pro_peserta : '".$result[$s][ID_PESERTA]."' updated.");
		
		$query5 = mysql_query("update prs_permohonan set id_peserta = '".$result[$s][ID_PESERTA]."', id_penyelaras = '".$result[$s][ID_PENYELARAS]."', kod_status_permohonan = '".$result[$s][KOD_STATUS_PERMOHONAN]."', kod_status_kehadiran = '".$result[$s][KOD_STATUS_KEHADIRAN]."',
		id_sesi = '".$result[$s][ID_SESI]."', kod_tahap = '".$result[$s][KOD_TAHAP]."', status_push_pull = 'N' where id_permohonan = '".$result[$s][ID_PERMOHONAN]."'");
		
		$log->lwrite("IAC - Table prs_permohonan : '".$result[$s][ID_PERMOHONAN]."' updated.");
		
		$query6 = mysql_query("update pro_perkhidmatan set kod_klasifikasi_perkhidmatan = '".$result[$s][KOD_KLASIFIKASI_PERKHIDMATAN]."', kod_gred_jawatan = '".$result[$s][KOD_GRED_JAWATAN]."', id_peserta = '".$result[$s][ID_PESERTA]."', status_push_pull = 'N'");
		
		$log->lwrite("IAC - Table pro_perkhidmatan : '".$result[$s][ID_PERKHIDMATAN]."' updated.");
		
		$u_count++;
	}

	//============================ Update Source to N =================================//
	$queryupdate1 = "update pro_peserta set status_push_pull = 'N' where id_peserta = '".$result[$s][ID_PESERTA]."'";
	runQuery($queryupdate1,'source');
	
	$log->lwrite("INTAN BK - Table pro_peserta : '".$result[$s][ID_PESERTA]."' updated.");
	
	$queryupdate2 = "update pro_perkhidmatan set status_push_pull = 'N' where id_perkhidmatan = '".$result[$s][ID_PERKHIDMATAN]."'";
	runQuery($queryupdate2,'source');
	
	$log->lwrite("INTAN BK - Table pro_perkhidmatan : '".$result[$s][ID_PERKHIDMATAN]."' updated.");
	
	$queryupdate3 = "update prs_permohonan set status_push_pull = 'N' where id_permohonan = '".$result[$s][ID_PERMOHONAN]."'";
	runQuery($queryupdate3,'source');
	
	$log->lwrite("INTAN BK - Table prs_permohonan : '".$result[$s][ID_PERMOHONAN]."' updated.");
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
<p> </p>
<input type="submit" name="button" id="button" value="Done" onclick="history.go(-2)"/>