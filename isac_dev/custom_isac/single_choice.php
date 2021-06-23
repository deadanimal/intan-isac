<?php 
$no = $_GET['number'];
//echo $no;
if ($no != "0"){

$numbers = $no + 1;

}
else{
$numbers = 1;
}

//for ( $counter = 1; $counter <= 40; $counter ++) { 
//$no = echo $counter;
//}
//random soalan
		//srand((double)microtime()*1000000);
         $data = "0123456789";
                
        for($i = 0; $i <= 1; $i++)
		//echo $i;
        {$random .= substr($data, (rand()%(strlen($data))), 1);}
		$t = 0;
		$slot=$t.$random;

//get kursus data
$soalan = "select PENYATAAN_SOALAN from usr_isac.pro_soalan where ID_SOALAN = '$slot'";
$prosoalan = mysql_query($soalan ,$dbc) or die(mysql_error());
$prosoalan1 = mysql_fetch_array($prosoalan);

$soalanper = "select PENYATAAN_SOALAN_PERINCIAN from usr_isac.pro_soalan_perician where ID_SOALAN = '$slot'";
$prosoalanper = mysql_query($soalanper ,$dbc) or die(mysql_error());
//include 'db.php';
/*$soalan ="select penyataan_soalan from usr_isac.pro_soalan where id_soalan='397'";
$query = mysql_query($soalan ,$dbc) or die(mysql_error());
$soalanRs = mysql_fetch_array($query);
*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #FFFFFF; font-weight: bold; font-style: italic; }
-->
</style>
</head>

<body>
<table width="98%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#698CB2"><span class="style3">Arahan (<span class="style5">Instruction</span>)</span></td>
    <td colspan="2" bgcolor="#698CB2"><span class="style3">Sila pilih satu jawapan yang tepat. (<em>Choose only one answer</em>)</span></td>
  </tr>
  
  <tr>
    <td width="8%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Soalan </strong><em>Question </em></td>
    <td colspan="2">
<?php echo $prosoalan1['PENYATAAN_SOALAN']; 
	?>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="90%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox" value="checkbox" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox2" value="checkbox" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox3" value="checkbox" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox4" value="checkbox" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
