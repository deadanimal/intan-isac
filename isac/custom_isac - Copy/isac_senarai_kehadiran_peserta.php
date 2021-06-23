<?php 
$id_sesi = $_GET['id_sesi'];
include ('../db.php');

$query = "select *
         from usr_isac.pro_peserta a,usr_isac.pro_sesi b,usr_isac.prs_permohonan c

         where a.id_peserta = c.id_peserta and c.id_sesi = b.id_sesi and b.id_sesi ='$id_sesi'";

$result = mysql_query($query) or die('Error, query failed');


$no_ic = "select a.no_kad_pengenalan
          from usr_isac.pro_peserta a,usr_isac.pro_sesi b,usr_isac.prs_permohonan c

          where a.id_peserta = c.id_peserta and c.id_sesi = b.id_sesi and b.id_sesi ='$id_sesi'";

$no_kad_pengenalan = mysql_query($no_ic) or die('Error, query failed');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style13 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style14 {font-size: 12px}
.style18 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style19 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
.style20 {color: #000000}
.style21 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   

   <tr>
     <td height="29" bordercolor="#F0F0F0" bgcolor="#FFFFFF"><form id="Cetak" name="Cetak" method="post" action="">
       <div align="center">
         <p>&nbsp;</p>
         <table width="91%" border="0" align="center" cellpadding="0">
           <tr>
             <td height="220"><table width="97%" border="1" align="center">
                 <tr>
                   <td height="23" colspan="3"><div align="center" class="style18">
                     <p>SENARAI KEHADIRAN PESERTA</p>
                     </div></td>
                  </tr>
                 
                 <tr>
                   <td class="style4"><div align="center">NAMA</div></td>
                   <td class="style4"><div align="center">NO. My KAD/POLIS/TENTERA/PASPORT</div></td>
                   <td class="style4"><div align="center">TANDATANGAN</div></td>
                 </tr>
               
               
               <?php
			   while ($namaRs = mysql_fetch_array($result))
			   {
			   
			   
			   ?>
                
                 <tr>
                   <td width="35%" height="90" class="style4"><div align="center"><?php echo $namaRs['NAMA_PESERTA']; ?></div></td>
                   <td width="46%" class="style4"><p align="center">&nbsp;</p>
                     <p align="center"><?php echo $namaRs['NO_KAD_PENGENALAN']; ?>&nbsp;</p>
                    <p align="center">&nbsp;</p></td>
                   <td width="19%" class="style4">&nbsp;</td>
                 </tr>
               <?php 
		       }
		       ?>
            
             </table>
               <p>&nbsp;</p>
              <p>&nbsp;</p></td>
           </tr>
         </table>
         <table width="221" border="0">
           <tr>
             <td width="95" class="style17"><a href="javascript:; " onclick="window.print();"><span class="style20 style21 style14"><strong>[ Cetak ]</strong></span></a></td>
             <td width="116" class="style17"><a href="javascript:; " onclick="window.close();"><span class="style20 style21 style14"><strong>[ Kembali ]</strong></span></a></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
       </div>
     </form>     </td>
   </tr>
   <tr>
     <td height="29" bordercolor="#F0F0F0" bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
 </table>
</body>
</html>
