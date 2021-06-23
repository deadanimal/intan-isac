<?php include('../system_prerequisite.php');?>
<?php
//user session
//$usr = $_GET['usr'];
//include ('file_outlook.php');
//include ('db.php');
//include ('process_word.php');
$ic = $_SESSION['publicID'];
$sesi = $_GET['id_sesi'];
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
				b.id_permohonan='".$id_mohon."'
				";

$mykadRs = $myQuery->query($mykad,'SELECT');
$usr = $mykadRs[0][0];
$nama = $mykadRs[0][1];
$tarikh = $mykadRs[0][2];
$iac =$mykadRs[0][3];
$tahap = $mykadRs[0][4];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style14 {font-size: 12px}
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
.style16 {
	font-size: 14px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
.style13 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	
}

.style27 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
.style29 {font-size: 15px}
.style31 {font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; }
.style35 {color: #347FF4}
.style42 {	font-size: 15px;
	color: #FF6600;
}

.style47 {font-size: 14px}
.style48 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
.style17 {font-family: Arial, Helvetica, sans-serif; font-size:9px; }

@media print
{
input#btnPrint {
display: none;
}
}
-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="850">

   <tr>
     <td height="29"><table width="850" border="0" align="center">
       <tr>
         <td class="style31">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td width="21%" class="style31"><div align="left"><span class="style4 style44 style47">NAMA</span></div></td>
         <td width="2%"><div align="center"><strong>:</strong></div></td>
         <td width="77%"><span class="style13"><?php echo $nama; ?></span></td>
       </tr>
       <tr>
         <td class="style31"><div align="left"><span class="style4 style44 style47">NO. ID</span></div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style13"><?php echo $ic; ?></span></td>
       </tr>
       <tr>
         <td class="style31"><div align="left"><span class="style4 style44 style47">TARIKH</span></div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style13"><?php echo $tarikh; ?></span></td>
       </tr>
       <tr>
         <td class="style31"><div align="left"><span class="style4 style44 style47">PUSAT IAC</span></div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style27"><?php echo $iac; ?></span></td>
       </tr>
       <tr>
         <td class="style31"><div align="left">TAHAP PENILAIAN</div></td>
         <td><div align="center"><strong>:</strong></div></td>
         <td><span class="style27"><?php echo $tahap; ?></span></td>
       </tr>
     </table>
       <table width="850" border="0" align="center">
       
       <tr>
         <td height="21"><?php
//-----tahap keseluruhan bahagian---->
$overall = "select 
				a.tahap_status
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
$tahap_word_ppoint = $overallRs[1][0];
//$tahap_power_point = $overallRs[2][0];
$tahap_outlook = $overallRs[3][0];
$tahap_pengetahuan = $overallRs[4][0];

?>
           &nbsp;</td>
       </tr>
     </table>
       <table width="850" border="1" align="center" cellpadding="0" cellspacing="0">
       <tr>
         <td height="30" colspan="2" bgcolor="#E4E4E4"><div align="right" class="style35">
             <div align="center"><span class="style17"><span class="style42">PENGETAHUAN</span></span></div>
         </div></td>
       </tr>
       <tr>
         <?php /*echo $correct_answer;*/?>
         <?php /*echo $full_mark;*/?>
         <td height="30" colspan="2"><div align="center"><span class="style27">&nbsp;<?php if($tahap_pengetahuan=='01')
		 {
		 echo 'Melepasi';
		 }
		 else
		 {
		 echo 'Tidak Melepasi';
		 }
		 ?>  </span><span class="style27"> &nbsp;</span></div></td>
       </tr>
       <tr>
         <td colspan="2"></td>
       </tr>
       <tr>
         <td height="30" colspan="2" bgcolor="#E4E4E4"><div align="right" class="style35">
             <div align="center"><span class="style17"><span class="style42">KEMAHIRAN</span></span></div>
         </div></td>
       </tr>
       <tr>
         <td width="46%"><div align="right"><span class="style31">Internet</span> <strong>:</strong></div></td>
      <td width="54%" height="30"><span class="style27">&nbsp;&nbsp; </span><span class="style27"><?php if($tahap_internet=='01')
	 	{
		 echo 'Melepasi';
		 }
		 else
		 {
		 echo 'Tidak Melepasi';
		 }
		 ?>
               <?php /*echo $part_internet;*/?>
           <?php /*echo $all_part_internet;*/?>
         </span></td>
       </tr>
       <tr>
         <td><div align="right"><span class="style31">Aplikasi Pejabat</span><strong> :</strong></div></td>
         <td height="30"><span class="style27">&nbsp;&nbsp;
               <?php /*echo $tahap_word;*/ ?>
           <?php /*echo $tahap_power_point;*/?>
                <?php
	
if($tahap_word_ppoint=='01')
	 	{
		 echo 'Melepasi';
		 }
		 else
		 {
		 echo 'Tidak Melepasi';
		 }
		 ?>
           </span><span class="style27">
             <?php /*echo $part_word;*/?>
             <?php /*echo $all_part_word;*/?>
             <?php /*echo $part_ppoint;*/?>
             <?php /*echo $all_part_ppoint;*/?>
         </span></td>
       </tr>
       <tr>
         <td><div align="right"><span class="style31">Emel </span><span class="style29"><strong>:</strong></span></div></td>
         <td height="30"><span class="style27">&nbsp;&nbsp; <?php if($tahap_outlook=='01')
	 	 {
		 echo 'Melepasi';
		 }
		 else
		 {
		 echo 'Tidak Melepasi';
		 }
		 ?> </span><span class="style27">
           <?php  /*echo $part_outlook;*/?>
           <?php /*echo $all_part_outlook;*/?>
         </span></td>
       </tr>
              <tr>
         <td colspan="2"></td>
       </tr>
       <tr>
         <td height="30" colspan="2" bgcolor="#E4E4E4"><div align="right" class="style35">
             <div align="center"><span class="style17"><span class="style42">KEPUTUSAN KESELURUHAN</span></span></div>
         </div></td>
       </tr>
       <tr>
         <td height="30" colspan="2"><div align="center"><span class="style13">&nbsp;</span><span class="style27">&nbsp;
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

if($status_kelulusan=='')
	 	 {
		 echo 'Gagal';
		 }
		 else
		 {
		 echo $status_kelulusan;
		 }
?>      </span></div></td>
       </tr>
     </table>
     <p>&nbsp;</p></td>
   </tr>
   <tr>
     <td height="29"><table width="221" border="0" align="center">
  <tr>
    <td width="95" class="style17">&nbsp;</td>
    <td width="116" class="style17">&nbsp;</td>
    <input type="button" id="btnPrint" onclick="window.print();" value="Cetak" />
	<input type="button" id="btnPrint" onclick="window.close();" value="Tutup" />
  </tr>
</table>&nbsp;</td>
   </tr>
 </table>
</body>
</html>
