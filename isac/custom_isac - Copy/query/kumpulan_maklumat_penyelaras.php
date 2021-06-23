<?php 
include('db.php');

$id_penyelaras = $_POST['input_map_5_4628'];
$nama_penyelaras = $_POST['input_map_5_32'];
$emel_penyelaras = $_POST['input_map_5_33'];
$no_telefon_pejabat = $_POST['input_map_5_43'];
$no_fax = $_POST['input_map_5_44'];
$kod_kementerian = $_POST['input_map_5_34'];

$kod_jabatan= $_POST['input_map_5_36'];
$bahagian = $_POST['input_map_5_35'];
$alamat_1 = $_POST['input_map_5_37'];
$alamat_2 = $_POST['input_map_5_843'];
$alamat_3 = $_POST['input_map_5_844'];
$poskod = $_POST['input_map_5_38'];
$bandar = $_POST['input_map_5_40'];
$kod_negeri = $_POST['input_map_5_41'];
$kod_negara = $_POST['input_map_5_42'];

$sql = "insert into usr_isac.pro_penyelaras
(nama_penyelaras,emel_penyelaras,no_telefon_pejabat,no_fax,kod_kementerian)
values 
('$nama_penyelaras','$emel_penyelaras','$no_telefon_pejabat','$no_fax','$kod_kementerian')";

$sql2 = "insert into usr_isac.tempat_tugas
(id_penyelaras,kod_kementerian,kod_jabatan,bahagian,alamat_1,alamat_2,alamat_3,poskod,bandar,kod_negeri,kod_negara) 
values 
('$id_penyelaras','$kod_kementerian','$kod_jabatan','$bahagian','$alamat_1','$alamat_2','$alamat_3','$poskod','$bandar','$kod_negeri','$kod_negara')";


$result = $myQuery->query($sql,'RUN');
$result2 = $myQuery->query($sql2,'RUN');


if($result && $result2)
{
echo "<div width='70%' id='userNotification'>Maklumat Berjaya Disimpan</div>";
}
else
{
echo "<div width='70%' id='userNotification'>Maklumat Gagal Disimpan</div>";
}

?>