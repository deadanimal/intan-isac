<?php include ('../db.php');?>
<?php
//user session
//$usr = $_GET['usr'];
//include ('file_outlook.php');
//include ('db.php');
//include ('process_word.php');
$ic = $_GET['keyid'];
//skema jawapan
$mykad = "select a.id_peserta,a.nama_peserta,date_format(c.tarikh_sesi,'%d-%m-%Y'),
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='iac') 
				AND
				referencestatuscode='00' 
				AND referencecode=c.kod_iac),
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='tahap') 
				AND
				referencestatuscode='00' 
				AND referencecode=c.kod_tahap) from 
				usr_isac.pro_peserta a,
				usr_isac.prs_permohonan b,
				usr_isac.pro_sesi c
				
				where 
				a.id_peserta=b.id_peserta
				and
				b.id_sesi=c.id_sesi
				and
				a.no_kad_pengenalan = '".$ic."' or a.no_kad_pengenalan_lain = '".$ic."' ";

$mykadRs = $myQuery->query($mykad,'SELECT');
$usr = $mykadRs[0][0];
$nama = $mykadRs[0][1];
$tarikh = $mykadRs[0][2];
$iac =$mykadRs[0][3];
$tahap = $mykadRs[0][4];


$tugas = "select gelaran_ketua_jabatan, bahagian,
		  	(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='jabatan') 
				AND
				referencestatuscode='00' 
				AND referencecode=b.kod_jabatan),
		  	(SELECT description1 FROM refgeneral 
			WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='kementerian') 
				AND
				referencestatuscode='00' 
				AND referencecode=b.kod_kementerian),
			b.alamat_1, b.alamat_2, b.alamat_3, b.poskod, b.bandar, b.nama_penyelia 
			from
			usr_isac.pro_peserta a, 
			usr_isac.pro_tempat_tugas b
			where 
			a.id_peserta=b.id_peserta
			and
			a.no_kad_pengenalan = '".$ic."' or a.no_kad_pengenalan_lain = '".$ic."' ";  

$tugas2 = $myQuery->query($tugas,'SELECT');
$gelaran = $tugas2[0][0];
$bahagian = $tugas2[0][1];
$jabatan = $tugas2[0][2];
$kementerian = $tugas2[0][3];
$alamat1 = $tugas2[0][4];
$alamat2 = $tugas2[0][5];
$alamat3 = $tugas2[0][6];
$poskod = $tugas2[0][7];
$bandar = $tugas2[0][8];
$penyelia = $tugas2[0][9];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
/*background-color: #347ff4;
*/background-repeat: repeat-x;
background-image: url(img/content/header_bar1.jpg);
}

.style47 {font-size: 14px}
.style17 {font-family: Arial, Helvetica, sans-serif; font-size:9px; }


@media print
{
input#btnPrint {
display: none;
}
}
.style53 {color: #000000}
.style54 {font-family: Arial, sans-serif}
.style55 {font-weight: bold; font-size: 15px;}
.style56 {font-size: 13px}
-->
</style>
</head>

<body>

<span class="style54">
<?php if ($bahagian!=NULL) {
	echo $gelaran;?> 
<br />
	<?php echo $bahagian;}?> <br />
<?php if ($jabatan!=NULL) {
	echo $jabatan; ?>
<br />
<?php echo $kementerian?>;<br />
<?php echo $alamat1;}?><br />
<?php if ($alamat2!=NULL) {
	echo $alamat2;}?>
<br />
<?php if ($alamat3!=NULL) {
	echo $alamat3;?>
<br />
<?php echo $poskod;?> <?php echo $bandar; ?><br />
(up : <?php echo $penyelia; ?>)



</span>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="850">
<tr class="style15">
     <td width="850" height="29" class="style54"><table width="736" border="0" align="left">
       <tr>
         <td width="730"><p align="left"></p>
           <p align="left">Tuan/Puan,<br><br />
               <strong>Keputusan  ICT Skills Assessment And Certification (ISAC)</strong><br />
            </p>
           <p align="left">Dengan hormatnya merujuk perkara di atas. </p>
          <p align="left">2. Sukacita disertakan keputusan penilaian ISAC yang telah diduduki oleh pegawai dari jabatan tuan seperti berikut :-</p></td>
       </tr>
       
     </table></td>
</tr>
   <tr>
     <td height="29" class="style54"><table width="681" border="0" align="center">
       <tr>
         <td class="style55">&nbsp;</td>
         <td class="style55">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td width="6%" class="style55">&nbsp;</td>
         <td width="18%" class="style55"><div align="left"><span class="style4 style44  style47">Nama</span></div></td>
         <td width="1%"><div align="center"><strong>:</strong></div></td>
         <td width="75%"><span class="style56"><?php echo $nama; ?></span></td>
       </tr>
       <tr>
         <td class="style55">&nbsp;</td>
         <td class="style55"><div align="left"><span class="style4 style44  style47">No. MyKad</span></div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style56"><?php echo $ic; ?></span></td>
       </tr>
       <tr>
         <td class="style55">&nbsp;</td>
         <td class="style55"><div align="left"><span class="style4 style44  style47">Tarikh Penilaian</span></div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style56"><?php echo $tarikh; ?></span></td>
       </tr>
       <tr>
         <td class="style55">&nbsp;</td>
         <td class="style55"><div align="left"><span class="style4 style44  style47">Tahap Penilaian</span></div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style47"><?php echo $tahap; ?></span></td>
       </tr>
       <tr>
         <td class="style55">&nbsp;</td>
         <td class="style55"><div align="left">Lokasi</div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style47"><?php echo $iac; ?></span></td>
       </tr>
     </table>
       <table width="850" border="0" align="center">
       
       <tr>
         <td height="21"><?php
//-----tahap keseluruhan bahagian---->
$overall = "select 
				(SELECT description1 FROM isac.refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM isac.refgeneral where mastercode='XXX' 
				AND description1='STATUS_PENILAIAN_BAHAGIAN') 
				AND
				referencestatuscode='00' 
				AND referencecode=kod_status_penilaian_bahagian) 
				from 
				usr_isac.prs_penilaian_keputusan_bahagian				 
				where id_peserta='".$usr."' order by kod_bahagian_soalan";
$overallRs = $myQuery->query($overall,'SELECT');

$tahap_internet = $overallRs[0][0];
$tahap_word = $overallRs[1][0];
$tahap_power_point = $overallRs[2][0];
$tahap_outlook = $overallRs[3][0];
$tahap_pengetahuan = $overallRs[4][0];

?>
           &nbsp;</td>
       </tr>
     </table>
       <table width="540" border="1" bordercolor="#999999">
         <tr>
           <td width="174" bgcolor="#E4E4E4"><div align="center"><strong>BAHAGIAN</strong></div></td>
           <td width="350" bgcolor="#E4E4E4"><div align="center"><strong>KEPUTUSAN</strong></div></td>
         </tr>
         <tr>
           <td><div align="center" class="style53">Pengetahuan</div></td>
           <td><div align="center"><span class="style47"><?php echo $tahap_pengetahuan;?></span></div></td>
         </tr>
         <tr>
           <td height="70"><p align="center" class="style53">Kemahiran</p>           </td>
           <td><table width="300" border="0">
             <tr>
               <td width="126"><div align="right"><strong>Internet</strong></div></td>
               <td width="10"><strong>:</strong></td>
               <td width="150"><span class="style47"><?php echo $tahap_internet;?></span></td>
             </tr>
             <tr>
               <td><div align="right"><strong>Aplikasi Pejabat</strong></div></td>
               <td><strong>:</strong></td>
               <td><span class="style47">
                 <?php
	
	if (($tahap_word == 'Tidak Melepasi') && ($tahap_power_point == 'Tidak Melepasi'))
	{
	echo 'Tidak Melepasi';
	}
	else 
	{
	echo 'Melepasi';
	}

?>
               </span></td>
             </tr>
             <tr>
               <td height="23"><div align="right"><strong>Emel</strong></div></td>
               <td><strong>:</strong></td>
               <td><span class="style47"><?php echo $tahap_outlook; ?></span></td>
             </tr>
           </table></td>
         </tr>
         <tr>
           <td bgcolor="#E4E4E4"><div align="center" class="style53">Keseluruhan</div></td>
           <td bgcolor="#E4E4E4"><div align="center"><span class="style47">
             <?php 
$all_result = "select 
					kod_status_kelulusan
					from usr_isac.prs_penilaian_peserta a,usr_isac.pro_peserta b
					where 
					a.id_peserta=b.id_peserta
					and
					a.id_peserta = '".$usr."'";
$allRs = $myQuery->query($all_result,'SELECT');
$status_kelulusan = $allRs[0][0];

echo $status_kelulusan;

?>
           </span></div></td>
         </tr>
         <tr>
           <td height="23" bgcolor="#E4E4E4"><div align="center" class="style53">
             <p>No. Siri Sijil<br />
             </p>
           </div></td>
           <td bgcolor="#E4E4E4">
             <div align="center" class="style47"><?php if ($status_kelulusan== 'Lulus') { ?>
               <?php
$iac = "select (select referencecode from refgeneral where mastercode=(select referencecode from refgeneral where mastercode='XXX' and description1='IAC') and 		                referencestatuscode='00'  and referencecode=b.KOD_IAC)
        from usr_isac.pro_peserta a, usr_isac.pro_sesi b, usr_isac.prs_permohonan c
        where a.id_peserta = c.id_peserta and b.id_sesi = c.id_sesi and a.id_peserta = '".$usr."'";
$result3 = $myQuery->query($iac,'SELECT');
$iac = $result3[0][0];	
			   		   
$tarikh = "select date_format(tarikh_sesi,'%d/%m/%Y')
			from usr_isac.pro_peserta a,usr_isac.pro_sesi b,usr_isac.prs_permohonan c
			where a.id_peserta = c.id_peserta and b.id_sesi = c.id_sesi and a.id_peserta = '".$usr."'";
$result2 = $myQuery->query($tarikh,'SELECT');
$tarikh = $result2[0][0];
$dates = explode('/',$tarikh);

$newdate = $dates[0];
$newyear = $dates[2];			   
			   
$sijil_sql = "select a.no_sijil 
				from usr_isac.pro_sijil a,usr_isac.pro_peserta b
				where 
				a.id_peserta=b.id_peserta
				and
				a.id_peserta = '".$usr."'";
$sijilRs = $myQuery->query($sijil_sql,'SELECT');
$sijil = $sijilRs[0][0];
$sijil = '0000'.$sijilRs[0][0];	
$sijil = substr($sijil, -5);
//echo $no_sijil;

?>ISAC/<?php echo $iac; ?>/<?php echo $newyear; ?>/<?php echo $sijil; ?>
<?php
}
else
{
echo 'Tiada';

}
?>
           &nbsp;</div></td>
         </tr>
       </table>
       <table width="747" border="0">
         <tr>
           <td width="737"><p>&nbsp;</p>
             <p>3. Bersama-sama  ini disertakan sijil pegawai yang telah lulus penilaian  tersebut.<br clear="all" />
             </p>
             <p>4. Pihak kami merakamkan ucapan ribuan terima kasih  ke atas kerjasama pihak tuan dalam menjayakan program ISAC ini.<br />
             </p>
             <p>&nbsp;</p>
             <p>Sekian. <br />
               &nbsp; </p>
             <h1 class="style47">"JPA Peneraju  Perubahan Perkhidmatan Awam"</h1>
             <h1 class="style47">"1 Sentiasa di  Hadapan"</h1>
             <h1 class="style47">&nbsp;</h1>
             <p><strong>MOGHIRATUNNAJAT  HJ ZAKARIA</strong><br>
			  Ketua Unit Penilaian, Portal dan Penerbitan<br>
              Program Perkhidmatan Aplikasi <br>
 			  Institut Tadbiran  Awam Negara (INTAN)<br>
 			  Kampus Utama Bukit Kiara <br>
		    50480 Kuala Lumpur</p>
            <p>&nbsp;</p>             <p align="center">Ini adalah cetakan komputer. Tandatangan tidak diperlukan.</p></td>
         </tr>
       </table>       <p>&nbsp;</p>
     </td>
   </tr>
</table>
<table width="221" border="0" align="center">

   

  <tr>
    <td width="95" class="style17">&nbsp;</td>
    <td width="116" class="style17">&nbsp;</td>
    <input type="button" id="btnPrint" onclick="window.print();" value="Cetak" />
	<input type="button" id="btnPrint" onclick="window.close();" value="Tutup" />
  </tr> 
</table>
<p>&nbsp;</p>
</body>