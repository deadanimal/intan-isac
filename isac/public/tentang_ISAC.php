<?php
include ('../db.php');

$query = "select tajuk,keterangan from usr_isac.pro_laman_utama where status='02'";
$result = mysql_query($query) or die('Error, query failed');
//$test = mysql_fetch_array($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::Tentang ISAC::</title>
<style type="text/css">
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
/*background-color: #347ff4;
*/background-repeat: repeat-x;
background-image: url(../img/content/header_bar1.jpg);
}
.style16 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
	color: #FFFFFF;
}
.style18 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.style19 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>
</head>

<body>
<table width="60%" border="0">
<tr class="style15">
     <td height="29"><div align="left" class="style16">Tentang ISAC</div></td>
  </tr>
  <tr>

    <td><table width="100%" border="0">
      <tr>   
<?php
   while ($row = mysql_fetch_array ($result))
   {
   $tajuk    = $row['tajuk'];
   $keterangan = $row['keterangan'];

?>      
      </tr> 
      	<td><span class="style18">&nbsp;<?php echo $row['tajuk'];?></span></td>
      <tr>
        <td width="5%">&nbsp;</td>
        <td width="95%"><span class="style19">&nbsp;<?php echo $row['keterangan'];?> </span></td>
      </tr>
	  <?php }
	  ?>
      </table></td>
  </tr>
</table>
</body>
</html>
