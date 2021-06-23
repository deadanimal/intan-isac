<?php
$query="select a.id_pilihan_jawapan,a.keterangan_jawapan from usr_isac.pro_pilihan_jawapan a where id_soalan ='$id_soalan'";
$result=mysql_query($query) or die('Error, query failed');


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

<input type="hidden" name="jenis" id="jenis" value="ranking" />
<table width="100%" border="0">





<?php
while ($row = mysql_fetch_array($result))
{
$x=0;
$jaw= $row['keterangan_jawapan'];
?>
<tr>  <td width="4%" valign="top"><p>
<input name="pilihan" type="hidden" id="pilihan" size="5" value="<?php echo $row['id_pilihan_jawapan'];?>"/>
<input name="jwpn" type="text" id="jwpn" size="5" onkeyup="javascript:get(this.parentNode);"

value="<?php

 $jwpn = $row['id_pilihan_jawapan'];
   
   $query_check="select keterangan_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$id_peserta' and id_soalan = '$id_soalan' and id_jawapan = '$jwpn'";
   $result_check=mysql_query($query_check) or die('Error, query failed');
   
	while ($row_check = mysql_fetch_array($result_check))
	{
	
	echo $row_check['keterangan_jawapan'];
	
	
	}

?>"

/></p></td>
<td width="96%"><?php echo $row['keterangan_jawapan'];?></td>
<?php
$x++;
}
?>
                </table>
</body>
</html>
