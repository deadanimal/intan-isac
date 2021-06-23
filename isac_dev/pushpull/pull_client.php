<?php
// Pull in the NuSOAP code
require_once('../tools/nusoap/nusoap.php');
include('../class/log.php');
include('../class/db_mysql.php');
include('../class/sql_mysql.php');
include ('../db.php');

$kod_iac = $_GET['kod_iac'];

$iac2 = "select
server_ip
from
usr_isac.pro_push_iac
where
kod_iac = '".$kod_iac."'
order by
kod_iac asc";
$result = $myQuery->query($iac2,'SELECT','NAME');

$ip_cawangan =  $result[0]['SERVER_IP'];


//======== Define database intan bk ======//
	//Define database intan bk
	$client_username = 'root';//$source_uname;
	$client_password = 'isac2009';//$source_pword;
	$client_database = 'usr_isac';
	$client_server   = '10.1.3.91';//$source_ip;

	//Define database intan bk (development)
/*	$client_username = 'isactest';//$source_uname;
	$client_password = 'isactest';//$source_pword;
	$client_database = 'usr_isac';
	$client_server   = '10.1.3.87';//$source_ip;*/
	
	
$conn = mysql_connect($client_server,$client_username,$client_password ) or die ('Error connecting to mysql');
$dbname = $client_database;
mysql_select_db($dbname);

//Create log
$log = new Logging();

// Create the client instance test local
//$client = new nusoap_client('http://localhost:8081/isac_caw/pushpull/pull_server.php');

//Create client for intan cawangan
$client = new nusoap_client('http://'.$ip_cawangan.':8080/isac/pushpull/pull_server.php');

// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}

//Get data array
$resultSijil = $client->call('getDataProSijil');
$resultPenilaian = $client->call('getDataPrsPenilaian');
$resultPenilaianKptsnBhg = $client->call('getDataPrsPenilaianKeptsnBhg');
$resultProPeserta = $client->call('getDataUpdProPeserta');
$resultPrsMohon = $client->call('getDataUpdPrsPermohonan');
$resultProKhidmat = $client->call('getDataUpdProKhidmat');

$log->lwrite("================= Start Process PULL to Intan BK ==================");

$countInsertProSijil = 0;
$countInsertPrsPenilaian = 0;
$countInsertPrsPenilaianKptsnBhg = 0;
$countUpdateProPeserta = 0;
$countUpdatePrsPermohonan = 0;
$countUpdateProPerkhidmatan = 0;


// Check for a fault
if (!$client->fault) {
    	
		$queryInsertProSijil = "insert into pro_sijil (NO_SIJIL,KOD_IAC,ID_PESERTA,ID_PERMOHONAN,TAHUN,STATUS_PUSH_PULL,TIMESTAMP) values ";
		$queryInsertPenilaian = "insert into prs_penilaian_peserta (KOD_PENILAIAN_PESERTA, KOD_STATUS_KEHADIRAN, KOD_STATUS_KELULUSAN,ID_PENILAIAN,ID_PESERTA,STATUS_PUSH_PULL,TIMESTAMP) values ";
		$queryInsertPenilaianKptsnBhg = "insert into prs_penilaian_keputusan_bahagian (ID_PESERTA,ID_PERMOHONAN,KOD_BAHAGIAN_SOALAN,KOD_STATUS_PENILAIAN_BAHAGIAN,TAHAP_STATUS,STATUS_PUSH_PULL,TIMESTAMP) values ";
		
		
		if($resultSijil != 0){
			
			for($e=0;$e<count($resultSijil);$e++){
				echo $resultSijil[$e][KOD_IAC];
				
				
				$queryInsertProSijil .= "('".$resultSijil[$e]['NO_SIJIL']."','".$resultSijil[$e]['KOD_IAC']."','".$resultSijil[$e]['ID_PESERTA']."','".$resultSijil[$e]['ID_PERMOHONAN']."','".$resultSijil[$e]['TAHUN']."','N','".$resultSijil[$e]['TIMESTAMP']."')";
				
				//Update data to iac
				$updateProSijil = $client->call('updateProSijil', array('id_sijil' => $resultSijil[$e]['ID_SIJIL']));
				
				if ($e !== sizeof($resultSijil)-1 ){$queryInsertProSijil .= ',';}
				
				//Logging
				$log->lwrite("Intan BK - Table pro_sijil : '".$resultSijil[$e]['NO_SIJIL']."' inserted.");
				
				$countInsertProSijil++;
			}
			
			//echo $queryInsertProSijil;
			//Run batch insert
			mysql_query($queryInsertProSijil);

		}
		
		
		if($resultPenilaian != 0){
			
			for($f=0;$f<count($resultPenilaian);$f++){
			
				$queryInsertPenilaian .= "('".$resultPenilaian[$f]['KOD_PENILAIAN_PESERTA']."','".$resultPenilaian[$f]['KOD_STATUS_KEHADIRAN']."','".$resultPenilaian[$f]['KOD_STATUS_KELULUSAN']."','".$resultPenilaian[$f]['ID_PENILAIAN']."','".$resultPenilaian[$f]['ID_PESERTA']."','N','".$resultPenilaian[$f]['TIMESTAMP']."')";
				
				//Update data to iac
				$updatePrsPenilaianPeserta = $client->call('updatePrsPenilaian', array('id_penilaian_peserta' => $resultPenilaian[$f]['ID_PENILAIAN_PESERTA']));
				
				if ($f !== sizeof($resultPenilaian)-1 ){$queryInsertPenilaian .= ',';}
				
				//Logging
				$log->lwrite("Intan BK - Table prs_penilaian : '".$resultPenilaian[$f]['ID_PENILAIAN_PESERTA']."' inserted.");
				
				$countInsertPrsPenilaian++;
				
			}
			
			//echo $queryInsertPenilaian;
			//Run batch insert
			mysql_query($queryInsertPenilaian);
			
		}
		
		
		if($resultPenilaianKptsnBhg != 0){
			
			for($i=0;$i<count($resultPenilaianKptsnBhg);$i++){
			
				$queryInsertPenilaianKptsnBhg .= "('".$resultPenilaianKptsnBhg[$i]['ID_PESERTA']."','".$resultPenilaianKptsnBhg[$i]['ID_PERMOHONAN']."','".$resultPenilaianKptsnBhg[$i]['KOD_BAHAGIAN_SOALAN']."','".$resultPenilaianKptsnBhg[$i]['KOD_STATUS_PENILAIAN_BAHAGIAN']."','".$resultPenilaianKptsnBhg[$i]['TAHAP_STATUS']."','N','".$resultPenilaianKptsnBhg[$i]['TIMESTAMP']."')";
				
				//Update data to iac
				$updatePenilaianKptsnBhg = $client->call('updatePrsNilaiKeptsnBhg', array('id_nilai_kbhg' => $resultPenilaianKptsnBhg[$i]['ID_PENILAIAN_KEPUTUSAN_BAHAGIAN']));
				
				if ($i !== sizeof($resultPenilaianKptsnBhg)-1 ){$queryInsertPenilaianKptsnBhg .= ',';}
				
				//Logging
				$log->lwrite("Intan BK - Table prs_penilaian_keputusan_bahagian : '".$resultPenilaianKptsnBhg[$i]['ID_PENILAIAN_KEPUTUSAN_BAHAGIAN']."' inserted.");
				
				$countInsertPrsPenilaianKptsnBhg++;
				
			}
			
			//echo $queryInsertPenilaianKptsnBhg;
			//Run batch insert
			mysql_query($queryInsertPenilaianKptsnBhg);
			
		}
		
		
		if($resultProPeserta != 0){
			
			for($j=0;$j<count($resultProPeserta);$j++){
				
				$nama = $resultProPeserta[$j]['NAMA_PESERTA'];
				$nama_peserta = str_replace("'",'&#039;',$nama);
				
				$queryUpdateP = mysql_query("update pro_peserta set id_penyelaras = '".$resultProPeserta[$j]['ID_PENYELARAS']."', nama_peserta = '".$nama_peserta."',no_kad_pengenalan = '".$resultProPeserta[$j]['NO_KAD_PENGENALAN']."',no_kad_pengenalan_lain = '".$resultProPeserta[$j]['NO_KAD_PENGENALAN_LAIN']."', status_push_pull = 'N' where id_peserta = '".$resultProPeserta[$j]['ID_PESERTA']."'");
				
				//Update data to iac
				$updateProPeserta = $client->call('updateProPeserta', array('id_peserta' => $resultProPeserta[$j]['ID_PESERTA']));
				
				//Logging
				$log->lwrite("IAC - Table pro_peserta : '".$resultProPeserta[$j]['ID_PESERTA']."' updated.");
				
				$countUpdateProPeserta++;
			}
		}
		
		if($resultPrsMohon != 0){
			
			for($k=0;$k<count($resultPrsMohon);$k++){
				
				$queryUpdateM = mysql_query("update prs_permohonan set id_peserta = '".$resultPrsMohon[$k]['ID_PESERTA']."', id_penyelaras = '".$resultPrsMohon[$k]['ID_PENYELARAS']."', kod_status_permohonan = '".$resultPrsMohon[$k]['KOD_STATUS_PERMOHONAN']."', kod_status_kehadiran = '".$resultPrsMohon[$k]['KOD_STATUS_KEHADIRAN']."',id_sesi = '".$resultPrsMohon[$k]['ID_SESI']."', kod_tahap = '".$resultPrsMohon[$k]['KOD_TAHAP']."', status_push_pull = 'N' where id_permohonan = '".$resultPrsMohon[$k]['ID_PERMOHONAN']."'");
				
				//Update data to iac
				$updatePrsMohon = $client->call('updatePrsPermohonan', array('id_permohonan' => $resultPrsMohon[$k]['ID_PERMOHONAN']));
				
				//Logging
				$log->lwrite("IAC - Table prs_permohonan : '".$resultPrsMohon[$k]['ID_PERMOHONAN']."' updated.");
				
				$countUpdatePrsPermohonan++;
				
			}
			
		}
		
		
		if($resultProKhidmat != 0){
			
			for($l=0;$l<count($resultProKhidmat);$l++){
				
				$queryUpdatePK = mysql_query("update pro_perkhidmatan set kod_klasifikasi_perkhidmatan = '".$resultProKhidmat[$l]['KOD_KLASIFIKASI_PERKHIDMATAN']."', kod_gred_jawatan = '".$resultProKhidmat[$l]['KOD_GRED_JAWATAN']."',id_peserta = '".$resultProKhidmat[$l]['ID_PESERTA']."', status_push_pull = 'N' where id_perkhidmatan = '".$resultProKhidmat[$l]['ID_PERKHIDMATAN']."'");
				
				//Update data to iac
				$updateProKhidmat = $client->call('updateProKhidmat', array('id_perkhidmatan' => $resultProKhidmat[$l]['ID_PERKHIDMATAN']));
				
				//Logging
				$log->lwrite("IAC - Table pro_perkhidmatan : '".$resultProKhidmat[$l]['ID_PERKHIDMATAN']."' updated.");
				
				$countUpdateProPerkhidmatan++;
				
			}
			
		}
		
		/*kalau nak display array
        // Display the result
        echo '<h2>Result Sijil</h2><pre>';
        print_r($resultSijil);
    	echo '</pre>';
		
		// Display the result
        echo '<h2>Result Penilaian</h2><pre>';
        print_r($resultPenilaian);
    	echo '</pre>';
		
		// Display the result
        echo '<h2>Result Penilaian Keputusan Bhg</h2><pre>';
        print_r($resultPenilaianKptsnBhg);
    	echo '</pre>';
		
		// Display the result
        echo '<h2>Result Peserta</h2><pre>';
        print_r($resultProPeserta);
    	echo '</pre>';
		
		// Display the result
        echo '<h2>Result Mohon</h2><pre>';
        print_r($resultPrsMohon);
    	echo '</pre>';
		
		// Display the result
        echo '<h2>Result Khidmat</h2><pre>';
        print_r($resultProKhidmat);
    	echo '</pre>';
		*/
		
		if($countInsertProSijil!=0 || $countInsertPrsPenilaian != 0 || $countInsertPrsPenilaianKptsnBhg != 0 || $countUpdateProPeserta != 0 || $countUpdatePrsPermohonan != 0 || $countUpdateProPerkhidmatan != 0){
			echo '<br/>Pull data success!!'.'<br>';
			echo "======= Pro_sijil =======<br/>";
			echo 'Inserted: '.$countInsertProSijil.'<br>';
			if($resultSijil==0){
				echo 'Total Affected: '.$resultSijil.'<br>';
			}else{
				echo 'Total Affected: '.count($resultSijil).'<br>';
			}
			echo "======= Prs_penilaian_peserta =======<br/>";
			echo 'Inserted: '.$countInsertPrsPenilaian.'<br>';
			
			if($resultPenilaian==0){
				echo 'Total Affected: '.$resultPenilaian.'<br>';
			}else{
				echo 'Total Affected: '.count($resultPenilaian).'<br>';
			}
			echo "======= Prs_penilaian_keputusan_bahagian =======<br/>";
			echo 'Inserted: '.$countInsertPrsPenilaianKptsnBhg.'<br>';
			
			if($resultPenilaianKptsnBhg==0){
				echo 'Total Affected: '.$resultPenilaianKptsnBhg.'<br>';
			}else{
				echo 'Total Affected: '.count($resultPenilaianKptsnBhg).'<br>';
			}
			echo "======= Pro_peserta =======<br/>";
			echo 'Updated: '.$countUpdateProPeserta.'<br>';
			
			if($resultProPeserta==0){
				echo 'Total Affected: '.$resultProPeserta.'<br>';
			}else{
				echo 'Total Affected: '.count($resultProPeserta).'<br>';
			}
			echo "======= Prs_permohonan =======<br/>";
			echo 'Updated: '.$countUpdatePrsPermohonan.'<br>';
			
			if($resultPrsMohon==0){
				echo 'Total Affected: '.$resultPrsMohon.'<br>';
			}else{
				echo 'Total Affected: '.count($resultPrsMohon).'<br>';
			}
			echo "======= Prs_perkhidmatan =======<br/>";
			echo 'Updated: '.$countUpdateProPerkhidmatan.'<br>';
			
			if($resultProKhidmat==0){
				echo 'Total Affected: '.$resultProKhidmat.'<br>';
			}else{
				echo 'Total Affected: '.count($resultProKhidmat).'<br>';
			}
			
		}else{
			echo "All data have been updated.";
		}
				
}

else {
	echo '<h2>Fault</h2><pre>';
    print_r($resultSijil);
    echo '</pre>';
} 

$log->lwrite("================= End Process PULL to Intan BK ==================");
?>

<?php
/*
// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
*/
?>