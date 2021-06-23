<?php


$query="select id_pilihan_jawapan,keterangan_jawapan from usr_isac.pro_pilihan_jawapan where id_soalan = '$id_soalan'";
$result=mysql_query($query) or die('Error, query failed');
/*
$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$usr' and id_soalan = '$id_soalan'";
$result_check=mysql_query($query_check) or die('Error, query failed');
*/
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
background-color: #347ff4;
background-repeat: repeat-x;
}
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #FFFFFF; font-weight: bold; font-style: italic; }
-->
</style>
</head>

<body>
 <input type="hidden" name="jenis" id="jenis" value="multiple" />
<table width="100%" border="0">
<?php
while ($row = mysql_fetch_array($result))
{
$jaw= $row['keterangan_jawapan'];
?>
<tr>  
  <td width="3%" valign="top"><p><input type="checkbox" name="jwpn" id="jwpn" onclick="javascript:get(this.parentNode);"
  
   <?php 
   $jwpn = $row['id_pilihan_jawapan'];
   
	$mohon = "select id_permohonan,kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='$id_peserta')";
	$mohonRs = $myQuery->query($mohon,'SELECT');
	$id_mohon = $mohonRs[0][0];
	$kod_tahap = $mohonRs[0][1];
   
   $query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$id_peserta' and id_permohonan='$id_mohon' and id_soalan = '$id_soalan' and id_jawapan = '$jwpn'";
   $result_check=mysql_query($query_check) or die('Error, query failed');
   
   if(mysql_fetch_array($result_check)>0){
   echo "checked";
   }
   
   ?> 
  
  value="<?php echo $row['id_pilihan_jawapan'];?>"/></p></td>
  <td width="97%"><?php echo $row['keterangan_jawapan'];?></td>
  </tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php
}
?>
 </tr></table>
</body>
</html>
