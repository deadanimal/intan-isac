<?php
//user session
//$usr = $_GET['usr'];
//include ('file_outlook.php');
$usr = $_GET['id'];
$app = $_GET['app'];

echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';
include ('../db.php');

$jaw = "select fail_jawapan_peserta from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta='".$usr."' and id_permohonan = '".$app."' and kod_bahagian_soalan='02'";
$jawapan = mysql_query($jaw) or die('Error, query failed');
$jawapanRs = mysql_fetch_array($jawapan);

$jaw2 = "select fail_jawapan_peserta from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta='".$usr."' and id_permohonan = '".$app."' and kod_bahagian_soalan='03'";
$jawapan2 = mysql_query($jaw2) or die('Error, query failed');
$jawapanRs2 = mysql_fetch_array($jawapan2);

$file = $jawapanRs['fail_jawapan_peserta'];
$file2 = $jawapanRs2['fail_jawapan_peserta'];

if ($file)
{
include ('process_word.php');
}
else if ($file2)
{
include ('process_power_point.php');
}



//path file
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='3'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//server IP
$location = $path_nameRs[0][2];

$set = "select kod_set_soalan from usr_isac.pro_pemilihan_set_kemahiran where id_peserta = '".$usr."' and id_permohonan = '".$app."'";
$set_soalan = mysql_query($set) or die('Error, query failed');
$setRs = mysql_fetch_array($set_soalan);

$arahan = "select distinct a.arahan_umum,
			(SELECT description1 FROM isac.refgeneral 
			WHERE
			mastercode=(SELECT referencecode
			FROM isac.refgeneral where mastercode='XXX' 
			AND description1='BAHAGIAN_SOALAN') 
			AND
			referencestatuscode='00' 
			AND referencecode=a.kod_bahagian_soalan) as 'bahagian_soalan',a.kod_bentuk_soalan
			from usr_isac.pro_kemahiran a,
			usr_isac.pro_pemilihan_set_kemahiran b
			where 
			a.kod_set_soalan = b.kod_set_soalan
			and a.kod_bahagian_soalan = '04'
			and b.id_peserta = '$usr'
			and b.id_permohonan = '$app'";
//$arahanRs = $myQuery->query($arahan,'SELECT');
$arahan_soalan = mysql_query($arahan) or die('Error, query failed');
$arahanRs = mysql_fetch_array($arahan_soalan);
//echo $setRs [0][0];

$soalan = "select distinct c.id_soalan,c.arahan_soalan,c.penyataan_soalan 
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '04' 
					and b.id_peserta = '$usr' and b.id_permohonan = '$app' order by id_soalan asc";
$soalan_a = mysql_query ($soalan) or die ('Error, query failed');
//$soalan_aRs = mysql_fetch_array ($soalan_a);

$a = "select distinct c.arahan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '04'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
$ab = mysql_query ($a) or die ('Error, query failed');
$abc = mysql_fetch_array ($ab);

/*$fileSrc = 'test1.oft';
$path = 'outlook/';
//$location = '192.168.2.7';
//$fileDest = 'Word2007_'.$_GET['id'].'_'.date('Ymd').'.mht';
$newfile = 'test_new.msg';
//copy file and rename
copy($fileSrc,$newfile);*/

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
/*background-color: #347ff4;*/
background-repeat: repeat-x;
}
.style3 {
	color: #FFFFFF;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
.style23 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style31 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style33 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; }
.style34 {font-size: 14px}
.style17 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<script type="text/javascript" src="proses_script.js"></script>
<script type="text/javascript">
function confirmation() 
{
	var answer = confirm("Anda pasti telah selesai menjawab Bahagian C?")
	if (answer)
	{
		
window.parent.location.href = "../index.php?page=page_wrapper&menuID=6268&id=<?php echo $usr;?>&app=<?php echo $app;?>";
		
	}
	
}

function displaymessage()
{
//outlook
windowOne=window.open('isac_outlook.php?id=<?php echo $usr;?>&app=<?php echo $app;?>','answer','height=550,width=1440,top=0, scrollbars=1, resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0');
//outlook_question
windowTwo=window.open('isac_soalan_kemahiranC2.php?id=<?php echo $usr;?>&app=<?php echo $app;?>','question','height=250,width=1440,left=0,top=640, scrollbars=1,resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0');
}
</script>
</head>

<body onLoad="window.parent.scroll(0,0);">
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   <tr class="style15">
     <td height="29"><div align="center"><span class="style3">SOALAN ISAC BAHAGIAN KEMAHIRAN</span></div>
     <div align="left"></div></td>
  </tr>
   <tr>
     <td height="29"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
       <tr>
         <td><table width="98%" align="center" cellpadding="0" cellspacing="0">
               <tr> <td height="27" colspan="2"><p align="center" class="style23"><strong class="style31">SET <?php echo $setRs['kod_set_soalan'];?></strong><br />
                 </p></td>
                 </tr>
               <tr>
                 <td height="27" colspan="2"><p class="style23"><strong class="style31"><u><?php echo $arahanRs['bahagian_soalan'];?></u></strong><br />
                 </p></td>
              </tr>
               <tr>
                 <td height="27" colspan="2"><strong class="style31"><u>C) Soalan &nbsp;<?php echo $arahanRs['kod_bentuk_soalan'];?></u></strong></td>
              </tr>
               
               <tr>
                 <td height="19" colspan="2">&nbsp;</td>
               </tr>
               <?php
			   while ($row = mysql_fetch_array ($soalan_a))
			   {
			   $penyataan_soalan = $row ['penyataan_soalan'];
			   ?>
               <tr>
                 <td width="3%" height="29">&nbsp;</td>
                 <td width="97%"><span class="style33">
                   <?php //echo $row['id_soalan'];
			   echo $row['penyataan_soalan'];
			         ?>
                 </span></td>
               </tr> <?php } ?>
               <tr>
                 <td height="19">&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td height="19">&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
              
               <tr>
                 <td height="19" colspan="2"><hr align="center" width="100%" size="2" /></td>
              </tr>
               <tr>
                 <td height="19" colspan="2"><div align="center" class="style33 style34"><strong>TAMAT BAHAGIAN KEMAHIRAN </strong></div></td>
              </tr>
               <tr>
                 <td height="18" colspan="2"><hr align="center" width="100%" size="2" /></td>
              </tr>
          </table></td>
       </tr>
       <tr>
         <td><div id="userNotification3" align="right">
 <input style="margin-right:3px" onclick="displaymessage();saveMasa2(<?php echo $app;?>);" type="button" value="Microsoft Outlook" class="inputButton" />          
<!-- <input style="margin-right:3px" onclick="window.open('\\\\<?php /*echo $location;*/?>\\xampp\\htdocs\\isac\\outlook\\outlook.oft','')"  type="button" value="Microsoft Outlook" class="inputButton" /> -->

<!--   <input style="margin-right:3px" onclick="parent.location.href='../index.php?page=page_wrapper&menuID=6268'"  type="button" value="Hantar" class="inputButton" /> -->
<!-- <input style="margin-right:3px" onclick="window.location='isac_soalan_kemahiranEnd.php?id=<?php /*echo $usr*/;?>'" type="button" value="Tamat" class="inputButton" /> -->
        </div>
        <p>
        </p>
        <div id="userNotification3" align="right"><span class="style17">* Nota : Anda hanya boleh 'Hantar' setelah selesai manjawab Bahagian C (Outlook).</span>
          <input style="margin-right:3px" onclick="confirmation();saveMasa2(<?php echo $app;?>);"  type="button" value="Hantar" class="inputButton" />
        </div></td>
       </tr>
     </table></td>
  </tr>
</table>
</body>
</html>
