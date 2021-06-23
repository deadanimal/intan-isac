<?php
include ('db.php');
//$e = $_POST['input_map_6423_8661'];//count soalan
$kategori = $_POST['input_map_6423_8655'];//kategori_soalan
$j= $_POST['input_map_6423_8656'];//jumlah_soalan
$tahap = $_POST['input_map_6423_8654'];
$id_pemilihan_soalan = $_POST['input_map_6423_8657'];
$id_pemilihan_soalan_kumpulan= $_POST['input_map_6423_8653'];
//echo 'kategori:';
//echo $kategori;
//echo '/';
//check status kategori
/*$chkStatus = "select a.kod_kategori_soalan from
				usr_isac.pro_pemilihan_soalan_kumpulan a,
				usr_isac.pro_pemilihan_soalan_perincian b
				where a.id_pemilihan_soalan_kumpulan=b.id_pemilihan_soalan_kumpulan";
$chkStatusRs = $myQuery->query($chkStatus,'SELECT');*/

$g=mysql_query("QUERY YG DLM NAVICAT KUA 3 ROW TU");
while($row = mysql_fetch_array($g))
 {
$tahap = $row[kod_tahap_soalan];
$kat = $row[kat];
$jum = $row[nilai];

$gRs2 = array();
$g=mysql_query("select id_soalan from usr_isac.pro_soalan where kod_tahap_soalan='$tahap' and kod_kategori_soalan='$kategori'");
while($row = mysql_fetch_array($g))
 {
 $gRs2[] = $row[id_soalan];
 }

$random = array_rand($gRs2,$jum);
foreach($random as $key => $value)
      {
  $gRs2[$value]."<br>";

$sql = "insert into usr_isac.pro_pemilihan_soalan_perincian (ID_PEMILIHAN_SOALAN_KUMPULAN,ID_PEMILIHAN_SOALAN,ID_SOALAN) VALUES
('$id_pemilihan_soalan_kumpulan','$id_pemilihan_soalan','$gRs2[$value]')";
$result = $myQuery->query($sql,'RUN');
     }
}
?>