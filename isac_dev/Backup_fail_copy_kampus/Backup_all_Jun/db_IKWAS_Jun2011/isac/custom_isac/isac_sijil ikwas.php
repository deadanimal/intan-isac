<?php
$user = $_GET['keyid'];

include ('../db.php');

$nama = "select nama_peserta from usr_isac.pro_peserta where no_kad_pengenalan = '$user' or no_kad_pengenalan_lain = '$user'";
$result = $myQuery->query($nama,'SELECT');
$nama = $result[0][0];


$no_kad_pengenalan = "select no_kad_pengenalan from usr_isac.pro_peserta where no_kad_pengenalan = '$user'";
$result1 = $myQuery->query($no_kad_pengenalan,'SELECT');
$no_kad_pengenalan = $result1[0][0];


$iac = "select (select referencecode from refgeneral where mastercode=(select referencecode from refgeneral where mastercode='XXX' and description1='IAC') and 		                referencestatuscode='00'  and referencecode=b.KOD_IAC)
        from usr_isac.pro_peserta a, usr_isac.pro_sesi b, usr_isac.prs_permohonan c
        where a.id_peserta = c.id_peserta and b.id_sesi = c.id_sesi and a.no_kad_pengenalan = '$user' or a.no_kad_pengenalan_lain = '$user'";
$result3 = $myQuery->query($iac,'SELECT');
$iac = $result3[0][0];	

$sijil = "select a.no_sijil from usr_isac.pro_sijil a,usr_isac.pro_peserta b where a.id_peserta = b.id_peserta and b.no_kad_pengenalan = '$user' or b.no_kad_pengenalan_lain = '$user'";
$result4 = $myQuery->query($sijil,'SELECT');
$sijil = '0000'.$result4[0][0];	
$sijil = substr($sijil, -5);

$tarikh = "select date_format(tarikh_sesi,'%d/%m/%Y')
			from usr_isac.pro_peserta a,usr_isac.pro_sesi b,usr_isac.prs_permohonan c
			where a.id_peserta = c.id_peserta and b.id_sesi = c.id_sesi and a.no_kad_pengenalan = '$user' or a.no_kad_pengenalan_lain = '$user'";
$result2 = $myQuery->query($tarikh,'SELECT');
$tarikh = $result2[0][0];
$dates = explode('/',$tarikh);

$newdate = $dates[0];
$newyear = $dates[2];

	if($dates[1] == '01'){
	$newmonth = "Januari";
	}
	
	elseif($dates[1] == '02'){
	$newmonth = "Februari";
	}

	elseif($dates[1] == '03'){
	$newmonth = "Mac";
	}
	
	elseif($dates[1] == '04'){
	$newmonth = "April";
	}
	
	elseif($dates[1] == '05'){
	$newmonth = "Mei";
	}
	
	elseif($dates[1] == '06'){
	$newmonth = "Jun";
	}
	
	elseif($dates[1] == '07'){
	$newmonth = "Julai";
	}
	
	elseif($dates[1] == '08'){
	$newmonth = "Ogos";
	}
	
	elseif($dates[1] == '09'){
	$newmonth = "September";
	}
	
	elseif($dates[1] == '10'){
	$newmonth = "Oktober";
	}
	
	elseif($dates[1] == '11'){
	$newmonth = "November";
	}
	
	elseif($dates[1] == '12'){
	$newmonth = "Disember";
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style3 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: x-large;
	color: #0033FF;
}
body {
	margin-top: 11px;
}
.style28 {font-weight: bold; font-size: 25px; color: #000000; }

@media print
{
input#btnPrint {
display: none;
}
}
.style36 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
}
.style37 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.style38 {
	color: #000000;
	font-size: 12px;
	font-weight: bold;
}
.style39 {font-size: 14px}
.style41 {font-weight: bold; font-size: 16px; color: #000000; }
-->
</style>
</head>

<body>
<table width="100%" border="0">
  
  <tr>
    <td colspan="6"><div align="right">
      <p class="style3"><span class="style41">ISAC/<?php echo $iac; ?>/<?php echo $newyear; ?>/<?php echo $sijil; ?></span>&nbsp; </p>
    </div></td>
  </tr>
  <tr>
    <td height="297" colspan="6">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="6" class="style3"><div align="center"><span class="style28"><?php echo $nama;?></span></div></td>
  </tr>
  <tr>
    <td colspan="6" class="style3"><div align="center"><span class="style28"><?php $a = substr($no_kad_pengenalan, 0, -6);  $b = substr($no_kad_pengenalan, 6, -4); $c = substr($no_kad_pengenalan, 8);// returns "abcde"?><?php echo $a; ?>-<?php echo $b; ?>-<?php echo $c;?></span></div></td>
  </tr>
  <tr>
    <td height="260" colspan="6" class="style3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class=""><div align="center" class="style36"><?php echo $newdate.' '.$newmonth.' '.$newyear; ?> </div></td>
  </tr>
  <tr>
    <td height="85" colspan="6" class="style3">&nbsp;</td>
  </tr>
  <tr>
    <td width="4%" class="style3">&nbsp;</td>
    <td width="5%" class="style3">&nbsp;</td>
    <td width="41%" class="style3"><div align="left"></div></td>
    <td width="37%" class="style3"><div align="right"><br />
    </div></td>
    <td width="7%" class="style3">&nbsp;</td>
    <td width="6%" class="style36">&nbsp;</td>
  </tr>
  <tr>
    <td height="29" class="style3">&nbsp;</td>
    <td colspan="2" class="style3"><div align="right" class="style38">
      <div align="left" class="style39">DR. AMINUDDIN HASSIM</div>
    </div></td>
    <td colspan="2" class="style37"><div align="right" class="style39"><strong>DR. MAZLAN BIN HARUN</strong></div></td>
    <td class="style3">&nbsp;</td>
  </tr>
</table>
<div align="center"></div><table width="100%" border="0">
</table>
<table width="221" border="0" align="center">
  <tr>
    <td width="95" class="style17">&nbsp;</td>
    <td width="116" class="style17">&nbsp;</td>
    <input type="button" id="btnPrint" onclick="window.print();" value="Cetak" />
	<input type="button" id="btnPrint" onclick="window.close();" value="Tutup" />
  </tr>
</table>
</body>
</html>