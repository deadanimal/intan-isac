<?php
// Pull in the NuSOAP code
require_once('../tools/nusoap/nusoap.php');
include('../class/db_mysql.php');
include('../class/sql_mysql.php');
include ('../db.php');
include('../class/log.php');

// Create the server instance
$server = new soap_server;
// Register the method to expose
$server->register('getDataPeserta');
$server->register('getDataSesi');
$server->register('getDataTempatTugas');
$server->register('updateAfterPushSesi');
$server->register('updateAfterPushPeserta');
$server->register('updateAfterPushTempatTugas');
// Define the method as a PHP function


function runQuery($query,$type) {

	//Define database intan bk (development)
/*	$source_username = 'isactest';//$source_uname;
	$source_password = 'isactest';//$source_pword;
	$source_database = 'usr_isac';
	$source_server   = '10.1.3.87';//$source_ip;*/
	
	//Define database intan bk
	$source_username = 'root';//$source_uname;
	$source_password = 'isac2009';//$source_pword;
	$source_database = 'usr_isac';
	$source_server   = '10.1.3.91';//$source_ip; 
	
	//Define database intan bk
/*	$source_username = 'root';//$source_uname;
	$source_password = 'isac2009';//$source_pword;
	$source_database = 'usr_isac';
	$source_server   = '10.1.3.91';//$source_ip; */
/*	$source_username = 'root';//$source_uname;
	$source_password = 'password';//$source_pword;
	$source_database = 'usr_isac';
	$source_server = 'localhost';//$source_ip;*/

	$myDbConn = new dbConnection;
	$myDbConn->init($source_username,$source_password,$source_database,$source_server);
	$dbc = $myDbConn->getConnString();
	$myQuery = new dbQuery($dbc);
	$mySQL = new dbSQL($dbc);
	
	if($type=='SELECT'){
		$rs = $myQuery->query($query ,'SELECT','NAME');
	}else{
		$rs = $myQuery->query($query,'RUN');
	}
	
	return $rs;
	
}

function getDataPeserta($kod_iac) {
	
	/*$query = "select b.id_penyelaras, a.id_peserta, a.nama_peserta, c.id_sesi,c.kod_iac,a.no_kad_pengenalan, a.no_kad_pengenalan_lain, a.status_push_pull,
	b.id_permohonan, b.kod_status_permohonan, b.kod_status_kehadiran, b.kod_tahap, d.id_perkhidmatan, d.kod_klasifikasi_perkhidmatan,d.kod_gred_jawatan
	from pro_peserta a, prs_permohonan b, pro_sesi c, pro_perkhidmatan d where
	a.id_peserta = b.id_peserta and b.id_sesi = c.id_sesi and a.id_peserta = d.id_peserta and c.kod_iac = '".$kod_iac."' and c.tarikh_sesi >= curdate() and
	(a.status_push_pull = 'I' or a.status_push_pull = 'U')";*/
	
	$query = "select b.id_penyelaras, a.id_peserta, a.nama_peserta, c.id_sesi,c.kod_iac,a.no_kad_pengenalan, a.no_kad_pengenalan_lain, a.status_push_pull,
	b.id_permohonan, b.kod_status_permohonan, b.kod_status_kehadiran, b.kod_tahap, d.id_perkhidmatan, d.kod_klasifikasi_perkhidmatan,d.kod_gred_jawatan,e.ID_TEMPAT_TUGAS,
	 e.GELARAN_KETUA_JABATAN, e.KOD_KEMENTERIAN, e.KOD_JABATAN, e.BAHAGIAN,e.ALAMAT_1,e.ALAMAT_2,e.ALAMAT_3,e.POSKOD,e.BANDAR,e.KOD_NEGERI,e.KOD_NEGARA,e.NAMA_PENYELIA,e.EMEL_PENYELIA,
	e.NO_TELEFON_PENYELIA, e.NO_FAX_PENYELIA
	from pro_peserta a, prs_permohonan b, pro_sesi c, pro_perkhidmatan d, pro_tempat_tugas e where
	a.id_peserta = b.id_peserta and b.id_sesi = c.id_sesi and a.id_peserta = d.id_peserta and a.id_peserta = e.id_peserta and c.kod_iac = '".$kod_iac."' and c.tarikh_sesi >= curdate() and
	(a.status_push_pull = 'I' or a.status_push_pull = 'U')";
	
	//run query
	$resultPeserta = runQuery($query,'SELECT');
	
	if(count($resultPeserta)==0){
		$resultPeserta = count($resultPeserta);
	}else{
		$resultPeserta = $resultPeserta;
	}
	
    return $resultPeserta;
	

}


function getDataSesi($kod_iac) {

	$query = "select a.id_sesi as id_sesi, a.kod_sesi_penilaian, a.tarikh_sesi, a.kod_masa_mula, a.kod_masa_tamat, a.bilangan_peserta, a.kod_kementerian, a.lokasi, a.kod_iac, a.kod_status, a.id_penghantaran, a.kod_jenis_sesi, a.kod_tahap, a.kod_kategori_peserta, a.kod_pengesahan_penilaian, a.jumlah_keseluruhan, a.tarikh_cipta, a.tarikh_kemaskini, a.id_pengguna, a.status_push_pull, a.timestamp, b.id_penilaian, b.tarikh_penilaian, b.id_sesi as 'id_sesi_p', b.status_push_pull as 'status_push_pull_p', b.timestamp as 'timestamp_p'
from pro_sesi a,prs_penilaian b where a.kod_iac = '".$kod_iac."' and a.id_sesi=b.id_sesi and a.tarikh_sesi >= curdate() and
(a.status_push_pull = 'I' or a.status_push_pull = 'U')";
	
	//run query
	$resultSesi = runQuery($query,'SELECT');
	
	if(count($resultSesi)==0){
		$resultSesi = count($resultSesi);
	}else{
		$resultSesi = $resultSesi;
	}
	
    return $resultSesi;
	

}

function updateAfterPushSesi($id_sesi,$id_penilaian){
	
	//Update pro_sesi
	$query = "update pro_sesi set status_push_pull = 'N' where id_sesi = '".$id_sesi."'";
	$resultSesi = runQuery($query,'RUN');
	
	//Update prs_penilaian
	$queryPenilaian = "update prs_penilaian set status_push_pull = 'N' where id_penilaian = '".$id_penilaian."'";
	$resultPenilaian = runQuery($queryPenilaian,'RUN');
	
    //return $query;
	
}

function updateAfterPushPeserta($id_peserta,$id_perkhidmatan,$id_permohonan){
	
	//Update pro_peserta
	$queryPeserta = "update pro_peserta set status_push_pull = 'N' where id_peserta = '".$id_peserta."'";
	$resultPeserta = runQuery($queryPeserta,'RUN');
	
	//Update pro_perkhidmatan
	$queryPerkhidmatan = "update pro_perkhidmatan set status_push_pull = 'N' where id_perkhidmatan =  '".$id_perkhidmatan."'";
	$resultPerkhidmatan = runQuery($queryPerkhidmatan,'RUN');
	
	//Update prs_permohonan
	$queryPermohonan = "update prs_permohonan set status_push_pull = 'N' where id_permohonan = '".$id_permohonan."'";
	$resultPermohonan = runQuery($queryPermohonan,'RUN');
	
	//Update prs_tempat_tugas
	$queryTempatTugas = "update pro_tempat_tugas set status_push_pull = 'N' where id_peserta = '".$id_peserta."'";
	$resultTempatTugas = runQuery($queryTempatTugas,'RUN');
    //return $queryPeserta;
	
}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
