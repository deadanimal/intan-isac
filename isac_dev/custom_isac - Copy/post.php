<?php
include('../db.php');

$usr = $_POST['usr'];
$app = $_POST['app'];
$jwpn = $_POST['jwpn'];
$soalan = $_POST['soalan'];
$jenis = $_POST['jenis'];

			$masa = $_REQUEST['masa'];
			$idmohon = $_REQUEST['idmohon'];
			
			if($masa != "" and $idmohon != ""){
				
			$check_masa="select id_permohonan from usr_isac.pro_masa where id_permohonan = '$idmohon'";
			$result_cm = mysql_query($check_masa);
			$num_row = mysql_num_rows($result_cm);
			
					
					if($num_row==1){
						
						$update_masa="update usr_isac.pro_masa set masa = '$masa' where id_permohonan = '$idmohon'";
						$result_up=mysql_query($update_masa) or die('Error, query failed');
					
					}
					else{
					
					$insert_masa="insert into usr_isac.pro_masa (id_permohonan,masa) values ('$idmohon','$masa')";
					$result_masa=mysql_query($insert_masa) or die('Error, query failed');
					
					}
					
			
			}
			
	if($jenis == "single"){
	
			$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$usr' and id_permohonan = '$app' and id_soalan = '$soalan'";
			$result_check=mysql_query($query_check) or die('Error, query failed');
			
			
			//kalau dah ade jawapan, update
			if(mysql_fetch_array($result_check)>0){
			
			$update_record="update usr_isac.prs_penilaian_peserta_jawapan set id_jawapan = '$jwpn' where id_peserta = '$usr' and id_permohonan = '$app' and id_soalan = '$soalan' ";
			$run_update=mysql_query($update_record) or die('Error, query failed');
			
			}
			//kalau xde, insert
			else{
			
			$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,id_jawapan,id_peserta,id_permohonan,status_push_pull) values ('$soalan','$jwpn','$usr','$app','I')";
			$run_insert=mysql_query($insert_record) or die('Error, query failed');
			
			}
	
	}

	elseif($jenis == "multiple"){
	
			$ischeck = $_POST['ischeck']; 
			
			$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$usr'  and id_permohonan = '$app' and id_soalan = '$soalan' and id_jawapan = '$jwpn' ";
			$result_check=mysql_query($query_check) or die('Error, query failed');
			
			if(mysql_fetch_array($result_check)>0){
			
			
				if($ischeck == 'false'){
				$delete_record="delete from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$usr' and id_permohonan = '$app' and id_soalan = '$soalan' and id_jawapan = '$jwpn'";
				$run_delete=mysql_query($delete_record) or die('Error, query failed');
				}
			}
			else{
			
				if($ischeck == 'true'){
			
				$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,id_jawapan,id_peserta,id_permohonan,status_push_pull) values ('$soalan','$jwpn','$usr','$app','I')";
				$run_insert=mysql_query($insert_record) or die('Error, query failed');
			
				}
			
			}
			
	
	}


	elseif($jenis == "truefalse"){
	
			$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$usr'  and id_permohonan = '$app' and id_soalan = '$soalan'";
			$result_check=mysql_query($query_check) or die('Error, query failed');
			
			
			//kalau dah ade jawapan, update
			if(mysql_fetch_array($result_check)>0){
			
			$update_record="update usr_isac.prs_penilaian_peserta_jawapan set keterangan_jawapan = '$jwpn' where id_peserta = '$usr' and id_permohonan = '$app' and id_soalan = '$soalan' ";
			$run_update=mysql_query($update_record) or die('Error, query failed');
			
			}
			//kalau xde, insert
			else{
			
			$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,keterangan_jawapan,id_peserta,id_permohonan,status_push_pull) values ('$soalan','$jwpn','$usr','$app','I')";
			$run_insert=mysql_query($insert_record) or die('Error, query failed');
			
			}
	
	}
	
	elseif($jenis == "ranking"){
			
			$id_jawapan = $_POST['id_pilihan'];
			
			$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$usr' and id_permohonan = '$app' and id_soalan = '$soalan' and id_jawapan = '$id_jawapan'";
			$result_check=mysql_query($query_check) or die('Error, query failed');
			
			
			//kalau dah ade jawapan, update
			if(mysql_fetch_array($result_check)>0){
			
			$update_record="update usr_isac.prs_penilaian_peserta_jawapan set keterangan_jawapan = '$jwpn' where id_peserta = '$usr' and id_permohonan = '$app' and id_soalan = '$soalan' and id_jawapan = '$id_jawapan'";
			$run_update=mysql_query($update_record) or die('Error, query failed');
			
			}
			//kalau xde, insert
			else{
			
			$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,id_jawapan,keterangan_jawapan,id_peserta,id_permohonan,status_push_pull) values ('$soalan','$id_jawapan','$jwpn','$usr','$app','I')";
			$run_insert=mysql_query($insert_record) or die('Error, query failed');
			
			}
	
	}

?>



