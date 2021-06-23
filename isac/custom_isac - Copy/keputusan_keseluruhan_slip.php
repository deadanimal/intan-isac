<?php
//user session
//$usr = $_GET['usr'];
//include ('file_outlook.php');
include ('../db.php');
//include ('process_word.php');
//$ic = $_SESSION['publicID'];
//skema jawapan
$usr = $_GET['keyid'];

/*$mykad = "select id_peserta from usr_isac.pro_peserta where no_kad_pengenalan='".$ic."' or no_kad_pengenalan_lain='".$ic."'";
$mykadRs = $myQuery->query($mykad,'SELECT');
$usr = $mykadRs[0][0];
*/

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
.style17 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style13 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style27 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
.style29 {font-size: 15px}
.style31 {font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; }
.style35 {color: #347FF4}
.style42 {	font-size: 15px;
	color: #FF6600;
}
.style44 {font-family: Arial, Helvetica, sans-serif}
.style47 {font-size: 14px}
.style48 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }

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
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="style15">
     <td height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Keputusan </span></span></div></td>
   </tr>
   <tr>
     <td height="29"><table width="70%" border="0" align="center">
       
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
       <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0">
       <tr>
         <td height="30" colspan="2" bgcolor="#E4E4E4"><div align="right" class="style35">
             <div align="center"><span class="style17"><span class="style42">PENGETAHUAN</span></span></div>
         </div></td>
       </tr>
       <tr>
         <?php /*echo $correct_answer;*/?>
         <?php /*echo $full_mark;*/?>
         <td height="30" colspan="2"><div align="center"><span class="style27">&nbsp;<?php echo $tahap_pengetahuan;?> <?php echo $ic;?></span><span class="style27"> &nbsp;</span></div></td>
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
         <td width="44%"><div align="right"><span class="style31">Internet</span> <strong>:</strong></div></td>
         <td width="56%" height="30"><span class="style27">&nbsp;&nbsp; </span><span class="style27"><?php echo $tahap_internet;?>
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
	
	if (($tahap_word == 'Tidak Melepasi') && ($tahap_power_point == 'Tidak Melepasi'))
	{
	echo 'Tidak Melepasi';
	}
	else 
	{
	echo 'Melepasi';
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
         <td height="30"><span class="style27">&nbsp;&nbsp; <?php echo $tahap_outlook; ?> </span><span class="style27">
           <?php  /*echo $part_outlook;*/?>
           <?php /*echo $all_part_outlook;*/?>
         </span></td>
       </tr>
       <tr>
         <td height="30" colspan="2" bgcolor="#E4E4E4"><div align="right" class="style35">
             <div align="center"><span class="style17"><span class="style42">KEPUTUSAN KESELURUHAN</span></span></div>
         </div></td>
       </tr>
       <tr>
         <td height="30" colspan="2"><div align="center"><span class="style13">&nbsp;</span><span class="style27">&nbsp;
                   <?php 
$all_result = "select 
					kod_status_kelulusan
					from usr_isac.prs_penilaian_peserta a,usr_isac.pro_peserta b
					where 
					a.id_peserta=b.id_peserta
					and
					a.id_peserta = '$usr'";
$allRs = $myQuery->query($all_result,'SELECT');
$status_kelulusan = $allRs[0][0];

echo $status_kelulusan;

?>
         </span></div></td>
       </tr>
     </table>
     <p><table width="221" border="0" align="center">
  <tr>
    <td width="95" class="style17">&nbsp;</td>
    <td width="116" class="style17">&nbsp;</td>
    <input type="button" id="btnPrint" onclick="window.print();" value="Cetak" />
	<input type="button" id="btnPrint" onclick="window.close();" value="Kembali" />
  </tr>
</table>&nbsp;</p></td>
   </tr>
 </table>
</body>
</html>
