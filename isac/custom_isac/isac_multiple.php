<?php
$soalan = "select penyataan_soalan,arahan_soalan from usr_isac.pro_soalan where id_soalan = '455'";
$prosoalan = mysql_query($soalan) or die('Error, query failed');
$prosoalanRs = mysql_fetch_array($prosoalan);

$query="select keterangan_jawapan from usr_isac.pro_pilihan_jawapan where id_soalan = '455'";
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
background-color: #e8a20c;
background-repeat: repeat-x;
}
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #FFFFFF; font-weight: bold; font-style: italic; }
-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   <tr class="style15">
     <td width="12%"><div align="left"><span class="style3">Arahan (<span class="style5">Instruction</span>)</span> <span class="style3">:</span></div></td>
     <td width="88%" height="29"><div align="left"><span class="style3"><?php echo $prosoalanRs['arahan_soalan']; 
	?></span></div></td>
  </tr>
   <tr>
     <td height="29" colspan="2"><table width="100%" border="1" align="center" cellpadding="0">
       <tr>
         <td><table width="98%" align="center" cellpadding="0" cellspacing="0">
             
             <tr>
               <td colspan="3">&lt;bil.soalan&gt;</td>
              </tr>
             <tr>
               <td width="3%">&nbsp;</td>
               <td colspan="2"><?php echo $prosoalanRs['penyataan_soalan']; 
	?>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="3%">&nbsp;</td>
               <td width="94%"><table width="100%" border="0">
<?php
while ($row = mysql_fetch_array($result))
{
$jaw= $row['keterangan_jawapan'];
?>
<tr>  
  <td width="3%" valign="top"><p><input type="checkbox" name="checkbox" id="checkbox" /></p></td>
  <td width="97%"><?php echo $row['keterangan_jawapan'];?></td>
<?php
}
?>
                </table></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td height="27" colspan="3">&nbsp;</td>
             </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
</table>
</body>
</html>
