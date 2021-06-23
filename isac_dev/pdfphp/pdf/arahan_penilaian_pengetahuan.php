<?php
include ('../../db.php');

$sql_jumk= "select jumlah_keseluruhan_soalan from usr_isac.pro_pemilihan_soalan where id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)";
$result_jumk = mysql_query ($sql_jumk) or die ('Error, query failed');
$jumkRs = mysql_fetch_array ($result_jumk);

$sql_time = "select tempoh_masa_peringatan_tamat_soalan_pengetahuan,tempoh_masa_keseluruhan_penilaian from usr_isac.pro_kawalan_sistem where id_kawalan_sistem=1";
$result_time = mysql_query ($sql_time) or die ('Error,query failed');
$timeRs = mysql_fetch_array ($result_time);
$a = $timeRs[0][0];
$b = $timeRs[1][0];

/*$time_kemahiran = ((($b)*10)-(($a)*10)) ;
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style17 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style18 {font-size: 14px}
.style21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style23 {
	color: #FF0000;
	font-weight: bold;
}
.style24 {color: #FF0000}
.style25 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style26 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
.style27 {
	font-size: 11px
}
a:link {
	color: #EC4700;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #EC4700;
}
a:hover {
	text-decoration: underline;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #FF0000;
}
-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   
   <tr>
     <td height="29"><table width="100%" border="0">
       <tr>
         <td><div align="right" class="style25"><a href="arahan_penilaian_pengetahuan_english.php" class="style27">ENGLISH VERSION</a></div></td>
       </tr>
       <tr>
         <td><p class="style17 style18">            <span class="style21"><strong>Keseluruhan penilaian  ISAC</strong> akan mengambil masa <strong><?php echo $timeRs['tempoh_masa_keseluruhan_penilaian'];?> minit</strong>.  <br />
            Format penilaian ISAC  terbahagi kepada dua kategori:</span></p>
           <p class="style21"><strong>KATEGORI  1 </strong>- Ujian pengetahuan berbentuk objektif.</p>
          <p class="style21"><strong>Arahan: </strong><br />
            Anda diberi masa <strong><?php echo $timeRs['tempoh_masa_peringatan_tamat_soalan_pengetahuan'];?> minit</strong> untuk menjawab  <strong><?php echo $jumkRs['jumlah_keseluruhan_soalan'];?> soalan</strong> di  Bahagian Pengetahuan.<br />
            Jawab soalan dengan klik pada butang bersebelahan dengan jawapan yang dipilih.&nbsp;<br />
            Anda dibenarkan untuk menukar jawapan atau lompat ke  soalan seterusnya jika perlu.  <br />
            Di bawah setiap soalan terdapat butang ‘<strong>Semak Jawapan</strong>’  untuk membolehkan anda menyemak status status jawapan anda<br/>('Sudah Dijawab' / 'Belum Dijawab').  </p>
          <p class="style26">Peringatan : Mesej peringatan akan diberikan oleh sistem selepas 20 minit menjawab.</p>
          <p class="style21"><strong>KATEGORI  2</strong> <strong>-</strong> Ujian kemahiran merangkumi <strong>3 Bahagian.</strong><br />
            </p>
          <p class="style21">ANDA DIKEHENDAKI MENJAWAB KESEMUA BAHAGIAN A, B DAN C.<br />
          </p>
          <p class="style21">BAHAGIAN A - Internet<br />
          BAHAGIAN B - MS Word atau MS PowerPoint (pilih salah SATU)<br />BAHAGIAN C - E-Mail<br />
          </p>
          <p class="style21">Bagi memenuhi kehendak didalam soalan-soalan Bahagian A, B dan C anda dikehendaki menggunakan browser, <br/>perisian MS Word atau MS  Powerpoint dan perisian e-mail.<br />
          </p>
          <p class="style21"><span class="style24"><strong>Amaran: </strong><br />
          </span>Sekiranya masa anda telah tamat, penghantaran secara  automatik akan dilakukan oleh sistem. <br />
<strong>ANDA DILARANG</strong> menekan butang <strong>[F5], [Enter], [Refresh],  [ X ] dan [Back].</strong></p>
          <p class="style21"><span class="style24"><strong>PENTING: </strong><br />
          </span>Pastikan anda TIDAK klik pada butang <img src="../img/close_button.png" width="20" height="18" /> <strong>[<em>CLOSE</em>]</strong> di atas sebelah kanan  paparan  ini sebelum selesai menjawab  soalan penilaian.<br />
          </p>
          <p class="style21"><span class="style23">*Nota: </span><strong>Klik pada butang 'Mula Menjawab' untuk memulakan penilaian dan masa penilaian akan bermula sebaik sahaja ianya diklik.</strong></p>
          </td>
       </tr>
       
     </table></td>
  </tr>
 </table>
</body>
</html>
