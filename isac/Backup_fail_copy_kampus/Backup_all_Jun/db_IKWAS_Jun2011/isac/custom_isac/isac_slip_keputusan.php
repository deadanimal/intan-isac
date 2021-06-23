<?php 
$tarikh = $_GET['input_map_6444_8919'];
$nama = $_GET['input_map_6444_8756'];
$no_kad_pengenalan = $_GET['input_map_6444_8758'];
$iac = $_GET['input_map_6444_8920'];
$status = $_GET['input_map_6444_8923'];
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
         <table width="40%" border="1" align="center" cellpadding="0">
           <tr>
             <td height="367"><table width="69%" border="0" align="center">
                 <tr>
                   <td colspan="4"><div align="center" class="style18">SLIP KEPUTUSAN</div></td>
                  </tr>
                 <tr>
                   <td colspan="4">&nbsp;</td>
                  </tr>
                 <tr>
                   <td width="30%"><span class="style4">NAMA</span></td>
                   <td width="4%"><span class="style4">:</span></td>
                   <td colspan="2"><span class="style13"><?php echo $nama; ?></span></td>
                 </tr>
                 <tr>
                   <td><span class="style4">NO. KP </span></td>
                   <td><strong><span class="style4">:</span></strong></td>
                   <td colspan="2"><span class="style 13"><span class="style13"><?php echo $no_kad_pengenalan; ?></span></span></td>
                 </tr>
                 <tr>
                   <td><span class="style4">TARIKH</span></td>
                   <td><strong><span class="style4">:</span></strong></td>
                   <td colspan="2"><span class="style13"><?php echo $tarikh; ?></span></td>
                 </tr>
                 <tr>
                   <td><span class="style4">PUSAT IAC</span></td>
                   <td><strong><span class="style4">:</span></strong></td>
                   <td colspan="2"><span class="style13"><span class="style 13"><?php echo $iac; ?></span></span></td>
                 </tr>
                 <tr>
                   <td><span class="style4">PENGETAHUAN</span></td>
                   <td><strong><span class="style4">:</span></strong></td>
                   <td colspan="2"><span class="style13">Melepasi</span></td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td colspan="2">&nbsp;</td>
                 </tr>
                 <tr>
                   <td><span class="style4">KEMAHIRAN</span></td>
                   <td><strong><span class="style4">:</span></strong></td>
                   <td width="19%">&nbsp;</td>
                   <td width="43%">&nbsp;</td>
                 </tr>
                 <tr>
                   <td><div align="left"><span class="style4">Internet</span></div></td>
                   <td><strong class="style4">:</strong></td>
                   <td><span class="style13">Melepasi</span></td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td><div align="left"><span class="style4">Aplikasi Pejabat</span></div></td>
                   <td class="style4"><strong>:</strong></td>
                   <td><span class="style13">Melepasi</span></td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td><span class="style4">Emel </span></td>
                   <td class="style4"><strong>:</strong></td>
                   <td colspan="2"><span class="style13">Melepasi</span></td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td colspan="2">&nbsp;</td>
                 </tr>
                 <tr>
                   <td><span class="style4">KEPUTUSAN </span></td>
                   <td><span class="style4">:</span></td>
                   <td colspan="2"><span class="style13"><?php echo $status; ?></span></td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td colspan="2">&nbsp;</td>
                 </tr>
             </table>
              </td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="221" border="0">
           <tr>
             <td width="95" class="style17"><a href="javascript:; " onclick="window.print();"><span class="style20 style21 style14"><strong>[ Cetak ]</strong></span></a></td>
             <td width="116" class="style17"><a href="javascript:; " onclick="window.close();"><span class="style20 style21 style14"><strong>[ Kembali ]</strong></span></a></td>
           </tr>
         </table>
       </div>
     </form>     </td>
   </tr>
   <tr>
     <td height="29" bordercolor="#F0F0F0" bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
 </table>
</body>
</html>
