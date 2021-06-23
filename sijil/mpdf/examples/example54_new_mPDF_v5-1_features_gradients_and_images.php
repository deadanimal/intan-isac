<?php
ob_start();
include_once 'include/connection.php';
$con = new connect();
$nokp = 890420075779 ; 
?>

<div style="background: url(../../assets/img/back.png) background: transparent url(bg.jpg) repeat center center fixed; height:100%">
 <page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" style="font-size:13.5px;">
             
          
                          
 <table width="100%" border="0">
   <tr>
     <td><img src="assets/img/BANNER.png" width="673" height="99" /></td>
   </tr>
 </table>
<?php 	
						   
 $sqlquery = $con->getdata("SELECT
program.NamaProgram,
pelajar.KodProgram,
pelajar.KodSidang,
pelajar.NoMetriks,
pelajar.Nama,
pelajar.NoKPPelajar,
pelajar.IdPelajar
FROM
pelajar
INNER JOIN program ON pelajar.KodProgram = program.KodProgram
WHERE NoKPPelajar = '".$nokp."'"); 	
 

$mathed = mysql_fetch_array($sqlquery); 
 {  ?> 
<div style="background: url(../../assets/img/back.png) background: transparent url(bg.jpg) repeat center center fixed; height:100%"> 
 <div align="center"><h1>SLIP KEPUTUSAN</h1></div>
 <p></p> <p></p>
                   <table width="100%">
                                    <tbody>
                                       
                                        <tr>
                                            <td width="50%"><strong>Nama</strong></td>
                                            <td width="1%">:</td>
                                            <td width="79%"><?php echo $mathed['Nama'];?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>No.Kad Pengenalan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                            <td>:</td>
                                            <td><?php echo $mathed['NoKPPelajar'];?> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>No.Matriks</strong></td>
                                            <td>:</td>
                                            <td><?php echo $mathed['NoMetriks'];?></td>
                                        </tr>
                                        <tr>
                                          <td><strong>Program</strong></td>
                                          <td>:</td>
                                          <td><?php echo $mathed['NamaProgram'];?></td>
                                        </tr>
                                        <tr>
                                          <td><strong>Kod Program</strong></td>
                                          <td>:</td>
                                          <td><?php echo $mathed['KodProgram'];?></td>
                                        </tr>
                                    </tbody>
                                    
                                    
                                </table> 
                                <?php } ?> 
                                
                           <table border="0" cellpadding="0" cellspacing="2" class="table table-striped table-bordered table-hover">
                             <tbody>
                               <tr>
                                 <th style="text-align:center">&nbsp;</th>
                                 <th align="left" style="text-align:center">&nbsp;</th>
                                 <th style="text-align:center">&nbsp;</th>
                               </tr>
                               <tr>
                                 <th style="text-align:center">&nbsp;</th>
                                 <th align="left" style="text-align:center">&nbsp;</th>
                                 <th style="text-align:center">&nbsp;</th>
                               </tr>
                               <tr>
                                 <th width="23%"><div style=" height:30px; text-align:left">KOD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
                                 <th width="56%"><div style=" height:30px">MODUL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
                                 <th width="18%" style="text-align:center"><div style=" height:30px">&nbsp;&nbsp;&nbsp;&nbsp;GRED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
                               </tr>
                               <?php
$sqlquery2 = $con->getdata("SELECT
keputusan.NoKPPelajar,
keputusan.IdKeputusan,
keputusan.KodModul,
keputusan.Markah,
modul.NamaModul,
modul.IdKompenan,
modul.JamKredit
FROM
modul
INNER JOIN keputusan ON keputusan.KodModul = modul.KodModul
WHERE NoKPPelajar = '".$mathed['NoKPPelajar']."'"); 
$i = 0;
$jam = 0;
while ($mathed2 = mysql_fetch_array($sqlquery2) ){ 
 ++$i;
 ?>
                               <tr>
                                 <td><strong><?php echo $mathed2['KodModul'];?></strong></td>
                                 <td><strong><?php echo $mathed2['NamaModul'];?></strong></td>
                                 <td align="center"><strong>
                                 <?php 
	if($mathed2['Markah']){		  
	switch ($mathed2['Markah']) {
    case $mathed2['Markah'] >=80 && $mathed2['Markah'] <=100:
        $gred = "A";
		$pointer = "4.00";
		break;
    case $mathed2['Markah'] >=75 && $mathed2['Markah'] <=79:
        $gred =  "A-";
		$pointer = "3.67";
        break;
    case $mathed2['Markah'] >=70 && $mathed2['Markah'] <=74:
        $gred =  "B+";
		$pointer = "3.33";
        break;
	case $mathed2['Markah'] >=65 && $mathed2['Markah'] <=69:
        $gred =  "B";
		$pointer = "3.00";
	    break;
	case $mathed2['Markah'] >=60 && $mathed2['Markah'] <=64:
		$gred =  "B-";
		$pointer = "2.67";
		break;
	case $mathed2['Markah'] >=55 && $mathed2['Markah'] <=59:
		$gred =  "C+";
		$pointer = "2.33";
		break;
	case $mathed2['Markah'] >=50 && $mathed2['Markah'] <=54:
		$gred =  "C";
		$pointer = "2.00";
		break;
	case $mathed2['Markah'] >=45 && $mathed2['Markah'] <=49:
		$gred = "C-";
		$pointer = "1.67";
		break;
	case $mathed2['Markah'] >=40 && $mathed2['Markah'] <=44:
		$gred =  "D+";
		$pointer = "1.33";
		break;
	case $mathed2['Markah'] >=35 && $mathed2['Markah'] <=39:
		$gred =  "D";
		$pointer = "1.00";
		break;
	case $mathed2['Markah'] >=30 && $mathed2['Markah'] <=34:
		$gred =  "E";
		$pointer = "0.67";
        break;
    default:
        $gred =  "F";
		$pointer = "0.00";
	
} }

echo $gred;
echo "<br/>";
//echo $pointer;
//echo $mathed2['JamKredit']; 
$jam += $mathed2['JamKredit'];

$jam_pointer = $jam * $pointer;
$jum_nilai_gred = $jam_pointer/$i;

$purata_nilai_gred = $jam_pointer/$jam;
?> 
                                 </strong></td>
                              </tr>
                               <?php } ?>
                               
                             </tbody>
                           </table>
                           <p>&nbsp;</p>
                           <table width="100%" align="right" cellspacing="0" style="text-align:right">
  <tr>
    <td width="95%"><strong>JUMLAH JAM KREDIT</strong></td>
    <td width="5%" align="center"><strong><?php echo $jam += $mathed2['JamKredit']; ?></strong></td>
  </tr>
  <tr>
    <td height="23"><strong>JUMLAH NILAI GRED</strong></td>
    <td align="center"><strong><?php echo $jum_nilai_gred; ?></strong></td>
  </tr>
  <tr>
    <td><strong>PURATA NILAI GRED</strong></td>
    <td align="center"><strong><?php echo number_format($purata_nilai_gred, 2, '.', '');; ?></strong></td>

  </tr>
</table>
 </div>
                     
             <page_footer>
          <b> <div style="font-size:15px; text-align:right; margin-bottom:200px; margin-right:50px"> <strong>Abdul Halim bin Hamzah<br />Pendaftar INTAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div> </b>
                           
                  <b> <div style="font-size:13px; text-align:center"> INSTITUT TADBIRAN AWAM NEGARA (INTAN)<br/>KAMPUS UTAMA BUKIT KIARA, JALAN BUKIT KIARA, 50480 KUALA LUMPUR. TEL : 03-2084 7777 FAKS : 03-2084 7808 <br/> http://www.intanbk.intan.my</div> </b>
            </page_footer>
        </page>
      
</div>
 
 


<?php 

$html = ob_get_clean();
include("../mpdf.php");

$mpdf=new mPDF(''); 
$mpdf->WriteHTML($html);

$mpdf->Output(); exit;



?>