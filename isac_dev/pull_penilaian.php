<?php
include('class/db_mysql.php');
include('class/sql_mysql.php');
include ('db.php');
include('class/log.php');

//$kod_iac = '05';
$kod_iac = $_GET['iac'];
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
$source_username =  $target_uname;//$target_uname;
$source_password = $target_pword ;//$target_pword;
$source_database = 'usr_isac2';
$source_server = $target_ip;//$target_ip;

//======== Define Target ======//intanbk
$target_username =  'root';//$target_uname;
$target_password = 'isac2009' ;//$target_pword;
$target_database = 'usr_isac2';
$target_server = '10.1.3.87';//$target_ip;

///=========== Getting Source Data =========================//
$myDbConn = new dbConnection;
$myDbConn->init($source_username,$source_password,$source_database,$source_server);
$dbc = $myDbConn->getConnString();
$myQuery = new dbQuery($dbc);
$mySQL = new dbSQL($dbc);

//insert (kampus -> intanbk)
/*$query = "select * from pro_pemilihan_set_kemahiran where status_push_pull = 'I'";
$result = $myQuery->query($query ,'SELECT','NAME');

$query2 = "select * from pro_pemilihan_soalan_perincian where status_push_pull = 'I'";
$result2 = $myQuery->query($query2 ,'SELECT','NAME');*/

$query3 = "select * from pro_sijil where status_push_pull = 'I'";
$result3 = $myQuery->query($query3 ,'SELECT','NAME');

$query4 = "select * from prs_penilaian_peserta where status_push_pull = 'I'";
$result4 = $myQuery->query($query4 ,'SELECT','NAME');

/*$query5 = "select * from prs_penilaian_peserta_jawapan where status_push_pull = 'I'";
$result5 = $myQuery->query($query5 ,'SELECT','NAME');

$query6 = "select * from prs_penilaian_peserta_kemahiran where status_push_pull = 'I'";
$result6 = $myQuery->query($query6 ,'SELECT','NAME');
*/
$query7 = "select * from prs_penilaian_keputusan_bahagian where status_push_pull = 'I'";
$result7 = $myQuery->query($query7 ,'SELECT','NAME');

//update (kampus -> intanbk)
$query8 = "select * from pro_peserta where status_push_pull = 'U'";
$result8 = $myQuery->query($query8 ,'SELECT','NAME');

$query9 = "select * from prs_permohonan where status_push_pull = 'U'";
$result9 = $myQuery->query($query9 ,'SELECT','NAME');

$query10 = "select * from pro_perkhidmatan where status_push_pull = 'U'";
$result10 = $myQuery->query($query10 ,'SELECT','NAME');

$myDbConn->disconnect();


/*for($c=0;$c<count($result);$c++){
	
	 
	$queryupdate44 = "insert into pro_pemilihan_set_kemahiran (KOD_SET_SOALAN, ID_PESERTA, STATUS_PUSH_PULL, TIMESTAMP) values 
	('".$result[$c][KOD_SET_SOALAN]."','".$result[$c][ID_PESERTA]."','N','".$result[$c][TIMESTAMP]."')";
	runQuery($queryupdate44,'target');
	 
	$queryupdate4 = "update pro_pemilihan_set_kemahiran set status_push_pull = 'N' where ID_PEMILIHAN_SET_KEMAHIRAN = '".$result[$c][ID_PEMILIHAN_SET_KEMAHIRAN]."'";
	runQuery($queryupdate4,'source');
	
}


for($d=0;$d<count($result2);$d++){
	 
	$queryupdate6 = "insert into pro_pemilihan_soalan_perincian (ID_PEMILIHAN_SOALAN, ID_PEMILIHAN_SOALAN_KUMPULAN, ID_SOALAN, ID_PESERTA,STATUS_PUSH_PULL,TIMESTAMP) values 
	 ('".$result2[$d][ID_PEMILIHAN_SOALAN]."','".$result2[$d][ID_PEMILIHAN_SOALAN_KUMPULAN]."','".$result2[$d][ID_SOALAN]."','".$result2[$d][ID_PESERTA]."','N','".$result2[$d][TIMESTAMP]."')";
	runQuery($queryupdate6,'target');
	 
	$queryupdate5 = "update pro_pemilihan_soalan_perincian set status_push_pull = 'N' where ID_PEMILIHAN_SOALAN_PERINCIAN = '".$result2[$d][ID_PEMILIHAN_SOALAN_PERINCIAN]."'";
	runQuery($queryupdate5,'source');

}


for($g=0;$g<count($result5);$g++){

	 
	 	$queryupdate88 = "insert into prs_penilaian_peserta_jawapan (ID_SOALAN, ID_SOALAN_PERINCIAN, ID_JAWAPAN,KETERANGAN_JAWAPAN,MARKAH,MASA_MULA,MASA_TAMAT,ID_PESERTA,STATUS_PUSH_PULL,TIMESTAMP) values 
	 ('".$result5[$g][ID_SOALAN]."','".$result5[$g][ID_SOALAN_PERINCIAN]."','".$result5[$g][ID_JAWAPAN]."','".$result5[$g][KETERANGAN_JAWAPAN]."','".$result5[$g][MARKAH]."','".$result5[$g][MASA_MULA]."','".$result5[$g][MASA_TAMAT]."','".$result5[$g][ID_PESERTA]."','N','".$result5[$g][TIMESTAMP]."')";
	runQuery($queryupdate88,'target');	
	 
	$queryupdate8 = "update prs_penilaian_peserta_jawapan set status_push_pull = 'N' where ID_PENILAIAN_PESERTA_JAWAPAN = '".$result5[$g][ID_PENILAIAN_PESERTA_JAWAPAN]."'";
	runQuery($queryupdate8,'source');	

}

for($h=0;$h<count($result6);$h++){
	 
	 	 $queryupdate99 = "insert into prs_penilaian_peserta_kemahiran (ID_PESERTA, FAIL_JAWAPAN_PESERTA, KOD_BAHAGIAN_SOALAN,STATUS_PUSH_PULL,TIMESTAMP) values 
	 ('".$result6[$h][ID_PESERTA]."','".$result6[$h][FAIL_JAWAPAN_PESERTA]."','".$result6[$h][KOD_BAHAGIAN_SOALAN]."','N','".$result6[$h][TIMESTAMP]."')";
	runQuery($queryupdate99,'target');
	 
	 $queryupdate9 = "update prs_penilaian_peserta_kemahiran set status_push_pull = 'N' where ID_PENILAIAN_PESERTA_KEMAHIRAN = '".$result6[$h][ID_PENILAIAN_PESERTA_KEMAHIRAN]."'";
	runQuery($queryupdate9,'source');		

}
*/
for($e=0;$e<count($result3);$e++){
	  
	$queryupdate66 = "insert into pro_sijil (NO_SIJIL,KOD_IAC,ID_PESERTA,ID_PERMOHONAN,STATUS_PUSH_PULL,TIMESTAMP) values 
	('".$result3[$e][NO_SIJIL]."','$kod_iac','".$result3[$e][ID_PESERTA]."','".$result3[$e][ID_PERMOHONAN]."','N','".$result3[$e][TIMESTAMP]."')";
	runQuery($queryupdate66,'target');
	 
	$queryupdate6 = "update pro_sijil set status_push_pull = 'N' where ID_SIJIL = '".$result3[$e][ID_SIJIL]."'";
	runQuery($queryupdate6,'source');

}

for($f=0;$f<count($result4);$f++){
	 
	 	$queryupdate77 = "insert into prs_penilaian_peserta (KOD_PENILAIAN_PESERTA, KOD_STATUS_KEHADIRAN, KOD_STATUS_KELULUSAN,ID_PENILAIAN,ID_PESERTA,STATUS_PUSH_PULL,TIMESTAMP) values 
	 ('".$result4[$f][KOD_PENILAIAN_PESERTA]."','".$result4[$f][KOD_STATUS_KEHADIRAN]."','".$result4[$f][KOD_STATUS_KELULUSAN]."','".$result4[$f][ID_PENILAIAN]."','".$result4[$f][ID_PESERTA]."','N','".$result4[$f][TIMESTAMP]."')";
	runQuery($queryupdate77,'target');	
	 
	$queryupdate7 = "update prs_penilaian_peserta set status_push_pull = 'N' where ID_PENILAIAN_PESERTA = '".$result4[$f][ID_PENILAIAN_PESERTA]."'";
	runQuery($queryupdate7,'source');	

}

for($i=0;$i<count($result7);$i++){
	 
	   $queryupdate101 = "insert into prs_penilaian_keputusan_bahagian (ID_PESERTA,ID_PERMOHONAN,KOD_BAHAGIAN_SOALAN,KOD_STATUS_PENILAIAN_BAHAGIAN,TAHAP_STATUS,STATUS_PUSH_PULL,TIMESTAMP) values 
	 ('".$result7[$i][ID_PESERTA]."','".$result7[$i][ID_PERMOHONAN]."','".$result7[$i][KOD_BAHAGIAN_SOALAN]."','".$result7[$i][KOD_STATUS_PENILAIAN_BAHAGIAN]."','".$result7[$i][TAHAP_STATUS]."','N','".$result7[$i][TIMESTAMP]."')";
	runQuery($queryupdate101,'target');
	 
	  $queryupdate10 = "update prs_penilaian_keputusan_bahagian set status_push_pull = 'N' where ID_PENILAIAN_KEPUTUSAN_BAHAGIAN = '".$result7[$i][ID_PENILAIAN_KEPUTUSAN_BAHAGIAN]."'";
	runQuery($queryupdate10,'source');		


}


for($j=0;$j<count($result8);$j++){
		$nama = $result8[$j][NAMA_PESERTA];
		$nama_peserta = str_replace("'",'&#039;',$nama);
		
		$queryupdate11 = "update pro_peserta set id_penyelaras = '".$result8[$j][ID_PENYELARAS]."', nama_peserta = '$nama_peserta',
		no_kad_pengenalan = '".$result8[$j][NO_KAD_PENGENALAN]."',no_kad_pengenalan_lain = '".$result8[$j][NO_KAD_PENGENALAN_LAIN]."', status_push_pull = 'N' where 						id_peserta = '".$result8[$j][ID_PESERTA]."'";
	runQuery($queryupdate11,'target');
	
	$queryupdate1 = "update pro_peserta set status_push_pull = 'N' where id_peserta = '".$result8[$j][ID_PESERTA]."'";
	runQuery($queryupdate1,'source');
}

for($k=0;$k<count($result9);$k++){
		
	$queryupdate33 = "update prs_permohonan set id_peserta = '".$result9[$k][ID_PESERTA]."', id_penyelaras = '".$result9[$k][ID_PENYELARAS]."', kod_status_permohonan = '".$result9[$k][KOD_STATUS_PERMOHONAN]."', kod_status_kehadiran = '".$result9[$k][KOD_STATUS_KEHADIRAN]."',
		id_sesi = '".$result9[$k][ID_SESI]."', kod_tahap = '".$result9[$k][KOD_TAHAP]."', status_push_pull = 'N' where id_permohonan = '".$result9[$k][ID_PERMOHONAN]."'";
	runQuery($queryupdate33,'target');

	$queryupdate3 = "update prs_permohonan set status_push_pull = 'N' where id_permohonan = '".$result9[$k][ID_PERMOHONAN]."'";
	runQuery($queryupdate3,'source');


}


for($l=0;$l<count($result10);$l++){
	
	$queryupdate22 = "update pro_perkhidmatan set kod_klasifikasi_perkhidmatan = '".$result10[$l][KOD_KLASIFIKASI_PERKHIDMATAN]."', kod_gred_jawatan = '".$result10[$l][KOD_GRED_JAWATAN]."',id_peserta = '".$result10[$l][ID_PESERTA]."', status_push_pull = 'N' where id_perkhidmatan = '".$result10[$l][ID_PERKHIDMATAN]."'";
	runQuery($queryupdate22,'target');
	
	$queryupdate2 = "update pro_perkhidmatan set status_push_pull = 'N' where id_perkhidmatan = '".$result10[$l][ID_PERKHIDMATAN]."'";
	runQuery($queryupdate2,'source');
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

echo 'Total Inserted(pro_sijil): '.count($result3).'<br>';
echo 'Total Inserted(prs_penilaian_peserta): '.count($result4).'<br>';
echo 'Total Inserted(prs_penilaian_keputusan_bahagian): '.count($result7).'<br>';

echo 'Total Updated(pro_peserta): '.count($result8).'<br>';
echo 'Total Updated(prs_permohonan): '.count($result9).'<br>';
echo 'Total Updated(prs_perkhidmatan): '.count($result10).'<br>';

?>
<p> </p>
<input type="submit" name="button" id="button" value="Done" onclick="history.go(-2)"/>