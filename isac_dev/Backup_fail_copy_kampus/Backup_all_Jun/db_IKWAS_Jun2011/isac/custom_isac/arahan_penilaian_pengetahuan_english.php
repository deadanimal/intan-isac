<?php
include ('../db.php');

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
.style26 {font-size: 11px}
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
}-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   
   <tr>
     <td height="29"><table width="100%" border="0">
       <tr>
         <td><div align="right" class="style25 style26"><a href="arahan_penilaian_pengetahuan.php">MALAY  VERSION</a></div></td>
       </tr>
       <tr>
         <td><p class="style17 style18">            <span class="style21"><strong>Overall time </strong>given for ISAC Assessment is <strong><?php echo $timeRs['tempoh_masa_keseluruhan_penilaian'];?> minutes</strong>.  <br />
            Format for ISAC Assessment is divided into 2 categories:</span></p>
           <p class="style21"><strong>CATEGORY  1 </strong>- Objective based knowledge assessment.</p>
          <p class="style21"><strong>Instruction:</strong><br />
            You are given <strong><?php echo $timeRs['tempoh_masa_peringatan_tamat_soalan_pengetahuan'];?> minutes</strong> to answer  <strong><?php echo $jumkRs['jumlah_keseluruhan_soalan'];?> questions </strong> in  Category 1 (Knowledge).<br />
            Answer the questions by clicking the radio button allocated on each side of the given answers.<br />
            You are allowed to change your answer, skip and return back to the previous questions.  <br />
            ‘<strong>Semak Jawapan</strong>’  button is given below each question to enable you to check the status of your questions<br/>('Sudah Dijawab' / 'Belum Diijawab')  </p>
          <p class="style21"><span class="style24"><strong>Reminder: </strong></span>After the first 20 minutes is up, a message box will be displayed as a reminder.</p>
          <p class="style21"><strong>CATEGORY  2</strong> <strong>-</strong> Simulation based skill assessment comprises of 3 partkemahiran merangkumi <strong>3 Bahagian.</strong><br />
            <br />
            PART A,  B AND C ARE COMPULSORY AND MUST BE ANSWERED.</p>
          <p class="style21">Part A  - Internet<br />
            Part B  - MS Word or MS PowerPoint (choose only ONE)<br />
            Part C   - E-Mail</p>
          <p class="style21">You are adviced to utillized the internet explorer browser, Microsoft Word, Microsoft Power Point and E-mail application in order <br/>
            to meet requirements for all the questions in Part A, B and C.
          <p class="style21"><span class="style24">
            <strong>Warning:<br/></strong></span>Once the time is up, your answers will be automatically save and send by the system.<br />
            <strong>DO NOT</strong> press button <strong>[F5], [Enter], [Refresh],  [ X ] dan [Back].</strong>          
          <p class="style21"><span class="style24"><strong>IMPORTANT:<br/>
          </strong></span>DO NOT click on <img src="../img/close_button.png" width="20" height="18" />  <strong>[CLOSE]</strong> button on the top right hand corner of the screen before  completing&nbsp;the assessment. <br />
          <p class="style21"><span class="style23">*Note: </span><strong>Click on buttonn 'Mula Menjawab' to start and your time will start the moment it is clicked.</strong>
          </td>
       </tr>
       
     </table></td>
  </tr>
 </table>
</body>
</html>
