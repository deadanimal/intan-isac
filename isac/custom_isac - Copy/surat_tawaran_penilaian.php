<?php include ('../db.php');?>
<?php
//user session
//$usr = $_GET['usr'];
//include ('file_outlook.php');
//include ('db.php');
//include ('process_word.php');
$ic = $_GET['keyid'];
$sesi = $_GET['keyid2'];

$mohon = "select a.id_permohonan from usr_isac.prs_permohonan a,usr_isac.pro_peserta b where a.id_peserta=b.id_peserta and (b.no_kad_pengenalan='".$ic."' or b.no_kad_pengenalan_lain='".$ic."') and a.id_sesi='".$sesi."' ";
$mohonRs = $myQuery->query($mohon,'SELECT');
$id_mohon = $mohonRs[0][0];

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
				b.id_permohonan='".$id_mohon."'";

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
				AND referencecode=b.kod_kementerian),b.kod_kementerian,
			b.alamat_1, b.alamat_2, b.alamat_3, b.poskod, b.bandar, b.nama_penyelia,
			(SELECT description1 FROM refgeneral 
			WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='negeri') 
				AND
				referencestatuscode='00' 
				AND referencecode=b.kod_negeri)			
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
$kod_kementerian = $tugas2[0][4];
$alamat1 = $tugas2[0][5];
$alamat2 = $tugas2[0][6];
$alamat3 = $tugas2[0][7];
$poskod = $tugas2[0][8];
$bandar = $tugas2[0][9];
$penyelia = $tugas2[0][10];
$negeri = $tugas2[0][11];
$today = date("j - n - Y");
$rujukan = "INTAN 52/4/25 (4)";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
.style31 {font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; }
.style17 {font-family: Arial, Helvetica, sans-serif; font-size:9px; }


@media print
{
input#btnPrint {
display: none;
}
}
.style54 {font-family: Arial, sans-serif}
.style55 {font-size: 14px; font-family: Arial, sans-serif; }
.style56 {color: #000000; font-family: Arial, sans-serif; }
.style57 {font-family: Arial, sans-serif; font-size: 15px; font-weight: bold; }
.style67 {
	font-size: 16px;
	color: #FF3300;
}
.style69 {font-family: Arial, sans-serif; color: #003399; }
.style70 {
	font-size: 22px;
	font-weight: bold;
}
.style75 {font-size: 16px}
.style76 {font-family: Arial, sans-serif; font-size: 16px; }
.style77 {font-size: 22px}
.style78 {font-size: 18px}
-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="850">
<tr class="style15">
  <td width="168" height="29"><?php
echo '<img src="../img/g_logo.jpg" width="110" height="100">';

?></td>
<td width="524"><span class="style69"><span class="style70">INSTITUT TADBIRAN AWAM NEGARA (INTAN)</span><br />
    <span class="style77">Jabatan Perkhidmatan Awam Malaysia</span><br />
<span class="style78">Bukit Kiara, Jalan Bukit Kiara, 50480 Kuala Lumpur</span><br />
<span class="style67">Tel:03-20847777 (20 talian),http://www.intanbk.intan.my</span> </span></td>
<td width="164"><?php
echo '<img src="../img/intan.jpg" width="70" height="100">';

?></td>
</tr>
<tr class="style15">
     <td height="29" colspan="3"><p class="style69">&nbsp;</p>
       <p class="style69">&nbsp;</p>
       <table width="856" border="0" align="left">
       <tr>
         <td width="850"><p align="left" class="style54 style75"><?php echo $gelaran; ?><br />
            <?php if ($jabatan!=""){
			echo $jabatan;?><br /><?php } ?>
			<?php if($kod_kementerian!='129' and $kod_kementerian!='372' and $kod_kementerian!='492') {
			  echo $kementerian; ?><br /><?php } ?>
			<?php if($bahagian!="") {
			  echo $bahagian; ?><br /><?php } ?>
              <?php echo $alamat1; ?><br />
              <?php if($alamat2!="") {
			  echo $alamat2; ?><br /><?php }?>
			  <?php if($alamat3!="") {
			  echo $alamat3; ?><br /><?php } ?>
              <?php echo $poskod; ?>,
		      <?php echo $bandar; ?><br />
			  <?php echo $negeri; ?><br />
              (up : <?php echo $penyelia; ?>)</p>
           <p align="left" class="style54">&nbsp;</p>
           <p align="left" class="style54">Tarikh : <?php echo $today ;  ?></p>
           <p align="left" class="style54">Ruj Kami : <?php echo $rujukan ;  ?> 
            <p align="left" class="style54"><br /> 
                
           <p align="left" class="style54">Tuan/Puan,<br />
           </p>
           <p align="left" class="style54"><br/>
            <strong>Tawaran Penilaian ICT Skills Assessment And Certification (ISAC)</strong></p>
           <p align="left" class="style54"><br />
           </p>
           <p align="left" class="style54">Dengan hormatnya merujuk perkara di atas. </p>
          <p align="left"><span class="style54">2. Adalah dimaklumkan bahawa pegawai tuan/puan telah ditawarkan untuk menduduki ujian Penilaian ICT Skills Assessment and Certification (ISAC). Maklumat lengkap ujian adalah seperti berikut :-</span>
            </p>
          </td><br/>
       </tr>
     </table></td>
</tr>
   <tr>
     <td height="29" colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td height="29" colspan="3"><table width="850" border="0" align="center">

       <tr>
         <td width="6%" class="style57">&nbsp;</td>
         <td width="18%" class="style31"><div align="left" class="style76"><span class="style4 style44 ">Nama</span></div></td>
         <td width="1%"><div align="center" class="style76"><strong>:</strong></div></td>
         <td width="75%"><span class="style76"><?php echo $nama; ?></span></td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31"><div align="left" class="style76"><span class="style4 style44 ">No. MyKad</span></div></td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td><span class="style76"><?php echo $ic; ?></span></td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31"><div align="left" class="style76"><span class="style4 style44 ">Tahap Penilaian</span></div></td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td><span class="style76"><?php echo $tahap; ?></span></td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31"><div align="left" class="style76"><span class="style4 style44 ">Tarikh Penilaian</span></div></td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td><span class="style76"><?php echo $tarikh; ?></span></td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31">Masa</td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31">Pusat Penilaian</td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31"><div align="left" class="style76">Lokasi</div></td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td><span class="style76"><?php echo $iac; ?></span></td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31">Alamat</td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td>&nbsp;</td>
       </tr>
     </table>
       <table width="850" border="0" align="center">
       
       <tr>
         <td height="21">&nbsp;</td>
       </tr>
     </table>
       <table width="848" border="0">
         <tr>
           <td colspan="2"><p class="style54">
<br>
3. Sekiranya tuan/puan tidak dapat hadir pada tarikh penilaian, sila beri penjelasan melalui emel berikut : isachelp@intanbk.intan.my sebelum tarikh penilaian. Kegagalan untuk berbuat demikian akan mengakibatkan nama tuan/puan *DISENARAIHITAMKAN* daripada menduduki ujian penilaian di masa akan datang.</p>
             <p class="style54"><br />
Sebarang kemusykilan/masalah, sila hubungi kami melalui emel: isachelp@intanbk.intan.my.<br />
<br />
 Sekian, terima kasih.</p>
             <p class="style54">&nbsp;             </p></td>
         </tr>
         <tr>
           <td width="691" height="112"><h1 class="style55">"JPA Peneraju Perubahan Perkhidmatan Awam"</h1>
             <h1 class="style55">"1 Sentiasa di Hadapan"</h1>             <span class="style55"><strong>MOGHIRATUNNAJAT HJ ZAKARIA</strong><br/>
             Ketua Unit Penilaian, Portal dan Penerbitan<br />
Program Perkhidmatan Aplikasi <br />
Institut Tadbiran Awam Negara (INTAN)<br />
Kampus Utama Bukit Kiara <br />
50480 Kuala Lumpur</span></td>
         <td width="147"><div align="center"></div>           <?php
echo '<img src="../img/cop.jpg" width="150" height="150">';

?></td>
         </tr>
         <tr>
           <td colspan="2"><p align="center" class="style55">&nbsp;</p>
           <p align="center" class="style55"><strong>Ini adalah cetakan komputer. Tandatangan tidak diperlukan. </strong></p></td>
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
</html>