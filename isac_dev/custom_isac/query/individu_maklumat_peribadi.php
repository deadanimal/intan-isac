<?php 
include('db.php');

$id_peribadi = $_POST['input_map_1_1227'];
$nama_peribadi = $_POST['input_map_1_4'];
$no_kad_pengenalan = $_POST['input_map_1_1'];
$kod_no_kad_pengenalan = $_POST['input_map_1_1230'];
$kod_gelaran = $_POST['input_map_1_3'];
$tarikh_lahir_hari = $_POST['input_map_1_275'];
$tarikh_lahir_bulan = $_POST['input_map_1_276'];
$tarikh_lahir_tahun = $_POST['input_map_1_277'];
$kod_jantina = $_POST['input_map_1_6'];
$id_peserta = $_POST['input_map_1_1228'];
$emel_peserta = $_POST['input_map_ 1_632'];
$no_telefon_pejabat = $_POST['input_map_1_15'];
$no_telefon_bimbit = $_POST['input_map_1_16'];
$kod_kategori_peserta = $_POST['input_map_1_1298'];
$id_perkhidmatan = $_POST['input_map_1_1229'];
$kod_gelaran_jawatan = $_POST['input_map_1_7'];
$kod_peringkat = $_POST['input_map_1_8'];
$kod_klasifikasi_perkhidmatan = $_POST['input_map_1_9'];
$kod_gred_jawatan = $_POST['input_map_1_10'];
$kod_taraf_perjawatan = $_POST['input_map_1_11'];
$kod_jenis_perkhidmatan = $_POST['input_map_1_12'];
$tarikh_lantikan = $_POST['input_map_1_13'];

$sql = "insert into usr_isac.pro_peribadi
(id_peribadi,nama_peribadi,no_kad_pengenalan,kod_no_kad_pengenalan,kod_gelaran,tarikh_lahir_hari,tarikh_lahir_bulan,tarikh_lahir_tahun,kod_jantina)
values 
('$id_peribadi','$nama_peribadi','$no_kad_pengenalan','$kod_no_kad_pengenalan','$kod_gelaran','$tarikh_lahir_hari','$tarikh_lahir_bulan','$tarikh_lahir_tahun','$kod_jantina')";

$sql2 = "insert into usr_isac.pro_perkhidmatan (id_perkhidmatan,kod_gelaran_jawatan,kod_peringkat,kod_klasifikasi_perkhidmatan,kod_gred_jawatan,kod_taraf_perjawatan,kod_jenis_perkhidmatan,tarikh_lantikan,id_peserta) 
values 
('$id_perkhidmatan','$kod_gelaran_jawatan','$kod_peringkat','$kod_klasifikasi_perkhidmatan','$kod_gred_jawatan','$kod_taraf_perjawatan','$kod_jenis_perkhidmatan','$tarikh_lantikan','$id_peserta')";

$sql3 = "insert into usr_isac.pro_peserta
(id_peserta,id_peribadi,emel_peserta,no_telefon_pejabat,no_telefon_bimbit,kod_kategori_peserta) 
values 
('$id_peserta','$id_peribadi','$emel_peserta','$no_telefon_pejabat','$no_telefon_bimbit','$kod_kategori_peserta')";


$result = $myQuery->query($sql,'RUN');
$result2 = $myQuery->query($sql2,'RUN');
$result3 = $myQuery->query($sql3,'RUN');


if($result && $result2 && $result3){

echo "<div width='70%' id='userNotification'>Maklumat Berjaya Disimpan</div>";

}
else{

echo "<div width='70%' id='userNotification'>Maklumat Gagal Disimpan</div>";

}

?>