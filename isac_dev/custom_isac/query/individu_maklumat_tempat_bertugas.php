<?php 
include('db.php');

$id_tempat_tugas = $_POST['input_map_15_1296'];
$id_peserta = $_POST['input_map_15_1297'];
$kod_gelaran_ketua_jabatan = $_POST['input_map_15_127'];
$kod_kementerian = $_POST['input_map_15_128'];
$kod_jabatan = $_POST['input_map_15_1026'];
$bahagian = $_POST['input_map_15_1027'];
$alamat_1 = $_POST['input_map_15_837'];
$alamat_2 = $_POST['input_map_15_129'];
$alamat_3 = $_POST['input_map_15_838'];
$poskod = $_POST['input_map_15_126'];
$bandar = $_POST['input_map_15_130'];
$kod_negeri = $_POST['input_map_15_131'];
$kod_negara = $_POST['input_map_15_132'];
$nama_penyelia = $_POST['input_map_15_133'];
$emel_penyelia = $_POST['input_map_15_134'];
$no_telefon_penyelia = $_POST['input_map_15_135'];
$no_fax_penyelia = $_POST['input_map_15_136'];

$sql = "insert into usr_isac.pro_tempat_tugas
(id_tempat_tugas,id_peserta,kod_gelaran_ketua_jabatan,kod_kementerian,kod_jabatan,bahagian,alamat_1,alamat_2,alamat_3,poskod,bandar,kod_negeri,kod_negara,nama_penyelia,emel_penyelia,no_telefon_penyelia,no_fax_penyelia)
values 
('$id_tempat_tugas','$id_peserta','$kod_gelaran_ketua_jabatan','$kod_kementerian','$kod_jabatan','$bahagian','$alamat_1','$alamat_2','$alamat_3','$poskod','$bandar','$kod_negeri','$kod_negara','$nama_penyelia','$emel_penyelia','$no_telefon_penyelia','$no_fax_penyelia')";

$result = $myQuery->query($sql,'RUN');

if($result && $result2 && $result3){

echo "<div width='70%' id='userNotification'>Maklumat Berjaya Disimpan</div>";

}
else{

echo "<div width='70%' id='userNotification'>Maklumat Gagal Disimpan</div>";
}

?>