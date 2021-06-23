<?php
include('../../db.php');

$id_peserta = $_POST['id_peserta'];
$id_permohonan = $_POST['id_permohonan'];
$jwpn = $_POST['jwpn'];
$id_soalan = $_POST['id_soalan'];
$jenis = $_POST['jenis'];
$masa = $_POST['masa'];

//Simpan masa
			
if($masa != "" and $id_permohonan != ""){
	
$check_masa="select id_permohonan from usr_isac.pro_masa where id_permohonan = '".$id_permohonan."'";
$result_cm = mysql_query($check_masa);
$num_row = mysql_num_rows($result_cm);

		
		if($num_row==1){
			
			$update_masa="update usr_isac.pro_masa set masa = '".$masa."' where id_permohonan = '".$id_permohonan."'";
			$result_up=mysql_query($update_masa) or die('Error, query failed');
		
		}
		else{
		
		$insert_masa="insert into usr_isac.pro_masa (id_permohonan,masa) values ('".$id_permohonan."','".$masa."')";
		$result_masa=mysql_query($insert_masa) or die('Error, query failed');
		
		}
		

}


//for type=single
if($jenis == "single"){
	
	$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$id_peserta."' and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."'";
	$result_check=mysql_query($query_check) or die('Error, query failed');
	
	//kalau dah ade jawapan, update
	if(mysql_fetch_array($result_check)>0){
	
		$update_record="update usr_isac.prs_penilaian_peserta_jawapan set id_jawapan = '".$jwpn."' where id_peserta = '".$id_peserta."' and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."' ";
		$run_update=mysql_query($update_record) or die('Error, query failed');
		
	}
	//kalau xde, insert
	else{
	
	$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,id_jawapan,id_peserta,id_permohonan,status_push_pull) values ('".$id_soalan."','".$jwpn."','".$id_peserta."','".$id_permohonan."','I')";
	$run_insert=mysql_query($insert_record) or die('Error, query failed');
	
	}
	
}

//for type=multiple
if($jenis == "multiple"){
	
	$ischeck = $_POST['check'];
	
	$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$id_peserta."'  and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."' and id_jawapan = '".$jwpn."' ";
	$result_check=mysql_query($query_check) or die('Error, query failed');
	
	if(mysql_fetch_array($result_check)>0){
		
		if($ischeck == '0'){
			$delete_record="delete from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$id_peserta."' and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."' and id_jawapan = '".$jwpn."'";
			$run_delete=mysql_query($delete_record) or die('Error, query failed');
		}
		
	}else{
	
		if($ischeck == '1'){
			
			$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,id_jawapan,id_peserta,id_permohonan,status_push_pull) values ('".$id_soalan."','".$jwpn."','".$id_peserta."','".$id_permohonan."','I')";
			$run_insert=mysql_query($insert_record) or die('Error, query failed');
			
		}
	
	}
		
}


//for type=true or false
if($jenis == "truefalse"){

	$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$id_peserta."'  and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."'";
			$result_check=mysql_query($query_check) or die('Error, query failed');
			
			
	//kalau dah ade jawapan, update
	if(mysql_fetch_array($result_check)>0){
	
	$update_record="update usr_isac.prs_penilaian_peserta_jawapan set keterangan_jawapan = '".$jwpn."' where id_peserta = '".$id_peserta."' and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."' ";
	$run_update=mysql_query($update_record) or die('Error, query failed');
	
	}
	//kalau xde, insert
	else{
	
	$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,keterangan_jawapan,id_peserta,id_permohonan,status_push_pull) values ('".$id_soalan."','".$jwpn."','".$id_peserta."','".$id_permohonan."','I')";
	$run_insert=mysql_query($insert_record) or die('Error, query failed');
	
	}

}

//for type=ranking
if($jenis == "ranking"){

	$id_jawapan = $_POST['id_pilihan'];
			
	$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$id_peserta."' and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."' and id_jawapan = '".$id_jawapan."'";
	$result_check=mysql_query($query_check) or die('Error, query failed');
	
	
	//kalau dah ade jawapan, update
	if(mysql_fetch_array($result_check)>0){
	
	$update_record="update usr_isac.prs_penilaian_peserta_jawapan set keterangan_jawapan = '".$jwpn."' where id_peserta = '".$id_peserta."' and id_permohonan = '".$id_permohonan."' and id_soalan = '".$id_soalan."' and id_jawapan = '".$id_jawapan."'";
	$run_update=mysql_query($update_record) or die('Error, query failed');
	
	}
	//kalau xde, insert
	else{
	
	$insert_record="insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,id_jawapan,keterangan_jawapan,id_peserta,id_permohonan,status_push_pull) values ('".$id_soalan."','".$id_jawapan."','".$jwpn."','".$id_peserta."','".$id_permohonan."','I')";
	$run_insert=mysql_query($insert_record) or die('Error, query failed');
	
	}
	
}


?>