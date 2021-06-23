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
           <p align="left" class="style54">Tarikh : <?php echo $today ;  ?></p>
           <p align="left" class="style54">Ruj Kami : <?php echo $rujukan ;  ?> 
              <br /> 
            
           <p align="left" class="style54">Tuan/Puan,<br /><br/>
               <strong>Keputusan  ICT Skills Assessment And Certification (ISAC)</strong><br />
            </p>
           <p align="left" class="style54">Dengan hormatnya merujuk perkara di atas. </p>
          <p align="justify"><span class="style54">2. Berikut adalah  keputusan penilaian ISAC yang telah diduduki oleh pegawai dari jabatan tuan seperti berikut :-</span><br/>
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
         <td class="style31"><div align="left" class="style76"><span class="style4 style44 ">Tarikh Penilaian</span></div></td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td><span class="style76"><?php echo $tarikh; ?></span></td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31"><div align="left" class="style76"><span class="style4 style44 ">Tahap Penilaian</span></div></td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td><span class="style76"><?php echo $tahap; ?></span></td>
       </tr>
       <tr>
         <td class="style57">&nbsp;</td>
         <td class="style31"><div align="left" class="style76">Lokasi</div></td>
         <td><div align="center" class="style76"><strong>:</strong></div></td>
         <td><span class="style76"><?php echo $iac; ?></span></td>
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
				AND referencecode=a.kod_status_penilaian_bahagian) 
				from 
				usr_isac.prs_penilaian_keputusan_bahagian a,
				usr_isac.prs_permohonan b				 
				where 
				a.id_permohonan=b.id_permohonan
				and
				b.id_permohonan='".$id_mohon."'
				order by kod_bahagian_soalan";
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
           <td width="191" bgcolor="#E4E4E4"><div align="center" class="style54 style75"><strong>BAHAGIAN</strong></div></td>
           <td width="333" bgcolor="#E4E4E4"><div align="center" class="style54 style75"><strong>KEPUTUSAN</strong></div></td>
         </tr>
         <tr>
           <td><div align="center" class="style56 style54 style75">Pengetahuan</div></td>
           <td><div align="center" class="style54 style75"><?php echo $tahap_pengetahuan;?></div></td>
         </tr>
         <tr>
           <td height="70"><p align="center" class="style56 style54 style75">Kemahiran</p>           </td>
           <td><table width="300" border="0">
             <tr>
               <td width="126" class="style54 style75"><div align="right"><strong>Internet</strong></div></td>
               <td width="10" class="style54 style75"><strong>:</strong></td>
               <td width="150" class="style54 style75"><?php echo $tahap_internet;?></td>
             </tr>
             <tr>
               <td class="style54 style75"><div align="right"><strong>Aplikasi Pejabat</strong></div></td>
               <td class="style54 style75"><strong>:</strong></td>
               <td class="style54 style75">                 <?php
	
	if (($tahap_word == 'Tidak Melepasi') && ($tahap_power_point == 'Tidak Melepasi'))
	{
	echo 'Tidak Melepasi';
	}
	else 
	{
	echo 'Melepasi';
	}

?>               </td>
             </tr>
             <tr>
               <td height="23" class="style54 style75"><div align="right"><strong>Emel</strong></div></td>
               <td class="style54 style75"><strong>:</strong></td>
               <td class="style54 style75"><?php echo $tahap_outlook; ?></td>
             </tr>
           </table></td>
         </tr>
         <tr>
           <td bgcolor="#E4E4E4"><div align="center" class="style56 style54 style75">Keseluruhan</div></td>
           <td bgcolor="#E4E4E4"><div align="center" class="style54 style75">
             <?php 
$all_result = "select a.kod_status_kelulusan
						from usr_isac.prs_penilaian_peserta a,usr_isac.pro_peserta b,usr_isac.prs_permohonan c,usr_isac.prs_penilaian d
						where 
						a.id_peserta=b.id_peserta
						and a.id_peserta=c.id_peserta
						and a.id_penilaian=d.id_penilaian
						and c.id_sesi=d.id_sesi
						and c.id_permohonan = '".$id_mohon."' ";
$allRs = $myQuery->query($all_result,'SELECT');
$status_kelulusan = $allRs[0][0];

echo $status_kelulusan;


?>
           </div></td>
         </tr>
         <tr>
           <td height="23" bgcolor="#E4E4E4"><div align="center" class="style56 style54 style75">
             <p>No. Siri Sijil<br />
             </p>
           </div></td>
           <td bgcolor="#E4E4E4">
             <div align="center" class="style55 style54 style75"><?php if ($status_kelulusan== 'Lulus') { ?>
 <?php
$iac = "select (select referencecode from refgeneral where mastercode=(select referencecode from refgeneral where mastercode='XXX' and description1='IAC') and 		                referencestatuscode='00' and referencecode=a.KOD_IAC),date_format(tarikh_sesi,'%d/%m/%Y')
			from usr_isac.pro_sesi a
			where a.id_sesi = '$sesi' ";
$result3 = $myQuery->query($iac,'SELECT');
$iac = $result3[0][0];	
$tarikh = $result3[0][1];
$dates = explode('/',$tarikh);		   		   
/*$tarikh = "select date_format(tarikh_sesi,'%d/%m/%Y')
			from usr_isac.pro_sesi a, usr_isac.prs_permohonan b
        	where a.id_sesi = b.id_sesi and b.id_permohonan = '".$id_mohon."'";
$result2 = $myQuery->query($tarikh,'SELECT');*/


$newdate = $dates[0];
$newyear = $dates[2];			   
			   
$sijil_sql = "select a.no_sijil 
				from usr_isac.pro_sijil a,usr_isac.pro_peserta b
				where 
				a.id_peserta=b.id_peserta
				and
				a.id_permohonan = '".$id_mohon."'";
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
       <table width="848" border="0">
         <tr>
           <td colspan="2"><p align="justify" class="style54">
<br>
3. Bersama-sama ini disertakan sijil bagi pegawai yang telah lulus penilaian tersebut. Salinan slip keputusan ini boleh diambil kira dalam hal-hal berkaitan perkhidmatan. Bagi tujuan pengesahan ketulenan keputusan, Ketua Jabatan hendaklah menyemak keputusan dari laman web INTAN di http://www.intanbk.intan.my . <br clear="all" />
             </p>
             <p class="style54">4. Pihak kami merakamkan ribuan terima kasih ke atas kerjasama pihak tuan dalam menjayakan program ISAC ini.<br />
             </p>
             <p class="style54">Sekian. <br />
&nbsp; </p>
           </td>
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