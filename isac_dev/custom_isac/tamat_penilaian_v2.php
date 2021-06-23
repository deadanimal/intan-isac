<?php
//user session
include ('db.php');
$app = $_GET['app'];
$usr = $_GET['id'];

$papar_result = "select option_papar_keputusan from usr_isac.pro_kawalan_sistem where id_kawalan_sistem=1";
$papar_resultRs = $myQuery->query($papar_result,'SELECT');
$option_papar = $papar_resultRs[0][0];
//$option_papar = '01';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style14 {
	font-size: 12px
}
.style15 {
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
.style13 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style18 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style19 {
	font-size: 14px
}
.style20 {
	color: #003399;
	font-size: 16px;
}
.style27 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style29 {
	font-size: 15px
}
.style31 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	font-weight: bold;
}
.style32 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.style33 {
	color: #000000;
	font-family: "Old English Text MT";
}
.style35 {
	color: #347FF4
}
.style38 {
	color: #003399;
	font-size: 16px;
	font-family: Chiller;
}
.style40 {
	font-size: 18px;
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #000000;
}
.style42 {
	font-size: 15px;
	color: #FF6600;
}
-->
</style>
</head>
<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr class="style15">
    <td height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Tamat Penilaian </span></span></div></td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0">
        <tr>
          <td><p align="center" class="style32">&nbsp;</p>
            <?php if ($option_papar == '01') { ?>
            <table width="60%" border="0" align="center">
              <tr>
                <td><p class="style32">Penilaian <em>ICT Skills Assessment and Certification</em> (ISAC) Tamat.</p>
                  <p class="style32">&nbsp;</p></td>
              </tr>
              <tr>
                <td><span class="style32">Berikut merupakan keputusan Penilaian <em>ICT Skills Assessment and Certification</em> (ISAC) :-</span></td>
              </tr>
              <tr>
                <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="367"><table width="70%" border="0" align="center">
                          <tr>
                            <td><div align="center"><span class="style18 style19 style20 style33"><span class="style19 style38"><span class="style40">KEPUTUSAN</span></span></span></div></td>
                          </tr>
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
				from usr_isac.prs_penilaian_keputusan_bahagian 
				where id_peserta='".$usr."' and id_permohonan='".$app."' order by kod_bahagian_soalan";
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
                            <td height="30" colspan="2"><div align="center"><span class="style27">&nbsp;<?php echo $tahap_pengetahuan;?> </span><span class="style27"> &nbsp;</span></div></td>
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
                            <td width="42%"><div align="right"><span class="style31">Internet</span> <strong>:</strong></div></td>
                            <td width="58%" height="30"><span class="style27">&nbsp;&nbsp; </span><span class="style27"><?php echo $tahap_internet;?>
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
$all_result = "	select 
					case when count(tahap_status)=4 then 'Lulus'
					else 'Gagal'
					end as 'STATUS'
					from usr_isac.prs_penilaian_keputusan_bahagian
					where id_peserta = '$usr' and id_permohonan='$app' ";
$allRs = $myQuery->query($all_result,'SELECT','NAME');
$status_kelulusan = $allRs[0]["STATUS"];

$nilai = "select max(id_penilaian_peserta) from usr_isac.prs_penilaian_peserta where id_peserta = '".$usr."'";
$nilaiRs = $myQuery->query($nilai,'SELECT');
$id_nilai = $nilaiRs[0][0];

$sql_check = "select id_sijil from usr_isac.pro_sijil where id_peserta='".$usr."' and id_permohonan='".$app."'";
$checkRs = $myQuery->query($sql_check,'SELECT');

$lulus = "select kod_status_kelulusan from usr_isac.prs_penilaian_peserta where id_penilaian_peserta='".$id_nilai."'";
$lulusRs = $myQuery->query($lulus,'SELECT');
$kelulusan = $lulusRs [0][0];
if(count($checkRs)==0)
{
	if($kelulusan == 'Lulus')
	{	
	$checkKodIAC = "select d.kod_iac
					from usr_isac.prs_penilaian_peserta b, usr_isac.prs_penilaian c, usr_isac.pro_sesi d
					where b.id_penilaian = c.id_penilaian and c.id_sesi = d.id_sesi 
					and b.id_penilaian_peserta='".$id_nilai."'";
					
	$resultKodIAC = $myQuery->query($checkKodIAC,'SELECT');
	$kodIAC = $resultKodIAC[0][0];
	
	$checkNoSijil = "select ifnull(max(no_sijil),0)+1 from usr_isac.pro_sijil where kod_iac = '".$kodIAC."'";
	$resultNoSijil = $myQuery->query($checkNoSijil,'SELECT');
	$noSijil = $resultNoSijil[0][0];
	
	/*$tarikh = "select date_format(tarikh_sesi,'%d/%m/%Y')
				from usr_isac.pro_peserta a,usr_isac.pro_sesi b,usr_isac.prs_permohonan c
			   where a.id_peserta = c.id_peserta and b.id_sesi = c.id_sesi and a.no_kad_pengenalan = '".$usr."'";
	$result2 = $myQuery->query($tarikh,'SELECT');
	$tarikh = $result2[0][0];
	$dates = explode('/',$tarikh);*/

	//$newdate = $dates[0];
	//$newyear = $dates[2];
	}
}
/*$status = "select kod_status_kelulusan from usr_isac.prs_penilaian_peserta where id_peserta = '".$usr."'";
$result = $myQuery->query($status,'SELECT');
$kelulusan = $result[0][0];
*/	
	

echo $status_kelulusan;

?>
                                </span></div></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <?php }else{ ?>
           
           <table width="60%" border="0" align="center">
              <tr>
                <td><span class="style32">Penilaian <em>ICT Skills Assessment and Certification</em> (ISAC) Tamat.</span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
           
           
           
           <?php } ?>
           <p>&nbsp;</p></td>
       </tr>
     </table></td>
  </tr>
 </table>
</body>
</html>
