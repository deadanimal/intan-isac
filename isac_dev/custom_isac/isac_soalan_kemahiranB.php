<?php
//include ('process_internet.php');
//user session
//$usr = $_GET['usr'];
include ('../db.php');
$usr = $_GET['id'];
$app = $_GET['app'];
echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';

$set = "select kod_set_soalan from usr_isac.pro_pemilihan_set_kemahiran where id_peserta = '$usr' and id_permohonan = '$app'";
$set_soalan = mysql_query($set) or die('Error, query failed');
$setRs = mysql_fetch_array($set_soalan);

//bahagian B1
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
			and a.kod_bahagian_soalan = '02'
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
					and a.kod_bahagian_soalan = '02' 
					and b.id_peserta = '$usr' and b.id_permohonan = '$app' order by id_soalan asc";
$soalan_b = mysql_query ($soalan) or die ('Error, query failed');
//$soalan_aRs = mysql_fetch_array ($soalan_a);

$a = "select distinct c.arahan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '02'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app' ";
$ab = mysql_query ($a) or die ('Error, query failed');
$abc = mysql_fetch_array ($ab);

//arahan
$arahan2 = "select distinct a.arahan_umum,
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
			and a.kod_bahagian_soalan = '03'
			and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
//$arahanRs = $myQuery->query($arahan,'SELECT');
$arahan_soalan2 = mysql_query($arahan2) or die('Error, query failed');
$arahanRs2 = mysql_fetch_array($arahan_soalan2);
//echo $setRs [0][0];

$soalan2 = "select distinct c.id_soalan,c.arahan_soalan,c.penyataan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '03'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app' order by id_soalan asc";
$soalan_b2 = mysql_query ($soalan2) or die ('Error, query failed');
//$soalan_aRs = mysql_fetch_array ($soalan_a);

$a2 = "select distinct c.arahan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '03'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
$ab2 = mysql_query ($a2) or die ('Error, query failed');
$abc2 = mysql_fetch_array ($ab2);

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
.style16 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.style17 {font-family: Arial, Helvetica, sans-serif}
.style24 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style31 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style33 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; }
.style34 {font-size: 14px}
.style35 {color: #FF0000}
.style36 {font-size: 12px}
.style37 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; color: #FF0000; }
-->
</style>
<script type="text/javascript" src="proses_script.js"></script>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">

//soalan_word & soalan_power_point
var newwindow;
function pop(url)
{newwindow=window.open(url,'name','height=250,width=1440,left=0,top=640, scrollbars=1, resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0');
if (window.focus) {newwindow.focus()}
}


</SCRIPT>
<script type="text/javascript">
function confirmation() 
{
	var answer = confirm("Anda pasti telah selesai menjawab Bahagian B?")
	if (answer)
	{
		window.location.href = "isac_soalan_kemahiranC1.php?id=<?php echo $usr;?>&app=<?php echo $app;?>";
	}
	
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
            <tr>
              <td colspan="2"><div align="center" class="style31"><strong>SET </strong><?php echo $setRs['kod_set_soalan'];?></div></td>
            </tr>
            <tr>
              <td height="19" colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td height="26" colspan="2" class="style31"><u>Bahagian B (Desktop Produktiviti)</u></td>
            </tr>
            <tr>
              <td height="30" colspan="2"><p class="style24"><span class="style16"><?php echo $arahanRs['arahan_umum'];?></span><br />
              </p></td>
            </tr>
            
            
            <tr>
              <td height="20" colspan="2"><hr align="center" width="100%" size="2" /></td>
            </tr>
            
            <tr>
              <td height="27" colspan="2"><strong class="style31"><u>B1) Soalan &nbsp;<?php echo $arahanRs['kod_bentuk_soalan'];?></u></strong></td>
            </tr>
            <tr>
              <td height="27" colspan="2"><p class="style24"><span class="style33"><?php echo $abc['arahan_soalan'];?></span><br />
              </p></td>
            </tr>
            <tr>
              <td height="19" colspan="2">&nbsp;</td>
            </tr>
              <?php
		   while ($row = mysql_fetch_array ($soalan_b))
		   {
		   $id_soalan     = $row['id_soalan'];
		   $arahan_soalan = $row['penyataan_soalan']; 
		   ?>
              <tr>
                <td height="27">&nbsp;</td>
                <td height="27"><span class="style33">
           <?php //echo $row['id_soalan'];
			echo $row['penyataan_soalan'];
			      
			$perincian = "select penyataan_soalan_perincian from usr_isac.pro_soalan_perincian where id_soalan = '$id_soalan'";
			$perincian_b = mysql_query ($perincian) or die ('Error, query failed');
			while ($data = mysql_fetch_array ($perincian_b))
			{
			echo $data['penyataan_soalan_perincian'];
			?>
               
			  <?php } ?> <p></p>
              <?php } ?>
              <tr>
              <td width="3%" height="27">&nbsp;</td>
              <td width="97%" height="27">&nbsp;</td>
            </tr>
            <tr>
              <td height="27" colspan="2"><hr align="center" width="100%" size="2" /></td>
            </tr>
            <tr>
              <td height="27" colspan="2"><p class="style24"><strong class="style31"><u>B2) Soalan &nbsp;<?php echo $arahanRs2['kod_bentuk_soalan'];?></u></strong></p></td>
            </tr>
            <tr>
              <td height="27" colspan="2"><p class="style24"><span class="style33"><?php echo $abc2['arahan_soalan'];?></span></p></td>
            </tr>
            <tr>
              <td height="19" colspan="2"><p class="style24">&nbsp;</p></td>
              </tr>
            <?php
		   while ($row2 = mysql_fetch_array ($soalan_b2))
		{
		   $id_soalan     = $row2['id_soalan'];
		   $arahan_soalan = $row2['penyataan_soalan']; 
		   ?>
            <tr>
              <td height="27">&nbsp;</td>
              <td height="27"><span class="style33">
            <?php //echo $row['id_soalan'];
			echo $row2['penyataan_soalan'];
			   
			$perincian2 = "select penyataan_soalan_perincian from usr_isac.pro_soalan_perincian where id_soalan = '$id_soalan'";
			$perincian_b2 = mysql_query ($perincian2) or die ('Error, query failed');
			while ($data2 = mysql_fetch_array ($perincian_b2))
			{
			echo $data2['penyataan_soalan_perincian'];
			?>
               
			  <?php } ?> <p></p>
			  <?php } ?>
            <tr>
              <td height="27">&nbsp;</td>
              <td height="27">&nbsp;</td>
            </tr>
            <tr>
              <td height="27" colspan="2"><hr size="2" width="100%" align="center" /></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><div align="right" class="style34 style17 style35" id="userNotification3"><strong><span class="style36">* Sila pilih samada menjawab soalan </span>&nbsp;&nbsp;
         <!--   <input style="margin-right:3px" onclick="window.location='isac_soalan_kemahiranB_word.php?id=<?php echo $usr;?>'"  type="button" value="Microsoft Word" class="inputButton" /> -->
         <strong>
         <input style="margin-right:3px" onclick="javascript:pop('isac_soalan_kemahiranB_word.php?id=<?php echo $usr;?>&app=<?php echo $app;?>');saveMasa2(<?php echo $app;?>);" type="button" value="Microsoft Word" class="inputButton" />
         </strong>&nbsp;<span class="style36">&nbsp;atau&nbsp;</span>&nbsp; 
       <!--   <input style="margin-right:3px" onclick="window.location='isac_soalan_kemahiranB_power_point.php?id=<?php /*echo $usr;*/?>'"  type="button" value="Microsoft PowerPoint" class="inputButton" /> -->
       </strong>
       <input style="margin-right:3px" onclick="javascript:pop('isac_soalan_kemahiranB_power_point.php?id=<?php echo $usr;?>&app=<?php echo $app;?>');saveMasa2(<?php echo $app;?>);" type="button" value="Microsoft PowerPoint" class="inputButton" /></div>
        <p></p>
        <div id="userNotification3" align="right"><span class="style37">* Nota : Anda hanya boleh menjawab Bahagian C setelah selesai Bahagian  B (Word).</span>
          <input style="margin-right:3px" onclick="confirmation();saveMasa2(<?php echo $app;?>);" type="button" value="Bahagian C" class="inputButton" />
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>

<br />
</body>
</html>
