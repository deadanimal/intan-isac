<?php
ob_start();

class connect
{
 public function connect()
 {
 mysql_connect("10.1.3.91","root","isac2009");
 mysql_select_db("isac");
  
 }
 public function setdata($sql)
 {
  mysql_query($sql);
 }
 public function getdata($sql)
 {
  return mysql_query($sql);
 }
 public function delete($sql)
 {
  mysql_query($sql);
 }
}

$con = new connect();
error_reporting(E_ERROR | E_PARSE);

?>

 <?php 	
 //var_dump($_GET);
var_dump($_GET);
$user = $_GET['keyid'];
$sesi = $_GET['keyid2'];
 		   
 $sqlquery = "SELECT
pro_peserta.ID_PESERTA,
pro_peserta.NAMA_PESERTA,
pro_peserta.KOD_KATEGORI_PESERTA,
pro_peserta.NO_KAD_PENGENALAN,
pro_peserta.NO_KAD_PENGENALAN_LAIN,
pro_sijil.ID_SIJIL,
pro_sijil.NO_SIJIL,
pro_sijil.KOD_IAC,
pro_sijil.TAHUN,
pro_sijil.ID_PESERTA,
pro_sijil.ID_PERMOHONAN,
pro_sijil.STATUS_PUSH_PULL,
pro_sijil.`TIMESTAMP`,
prs_permohonan.ID_SESI
FROM
pro_peserta
INNER JOIN pro_sijil ON pro_sijil.ID_PESERTA = pro_peserta.ID_PESERTA
INNER JOIN prs_permohonan ON prs_permohonan.ID_PESERTA = pro_peserta.ID_PESERTA
WHERE NO_KAD_PENGENALAN = '".$user."' AND ID_SESI = '".$sesi."'"; 	
 $con->getdata($sqlquery) ;	
 echo $sqlquery;
$mathed = mysql_fetch_array($sqlquery); 

var_dump($mathed);

 {  ?> 

<style>
div {
    font-size: 17px;
	font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
	
	
}

</style>
            
 <table width="100%" border="0">
   <tr>
     <td align="right"><div align="right">No. Sijil<strong>: ISAC/<?php //echo $iac; ?>/<?php //echo $newyear; ?>/<?php //echo $sijil; ?></strong><strong> </strong></div></td>
   </tr>
 </table>
 <br />
  <br />
   <br />
<div style="text-align:center; margin-top:-15px"> <h5><img src="img/jata.jpg" alt="" width="119" height="97" align="middle" /></h5>  
 </div>
 <br>
 <div style="text-align:center; margin-top:-15px">
 Institut Tadbiran Awam Negara (INTAN)<br />
Jabatan Perkhidmatan Awam Malaysia
 </div>
 <br>
 <br>
 <div style="text-align:center;font-size:40px">
 <strong>Sijil ISAC</strong><br />
 </div>
 <br>
 <div style="text-align:center">
 Dengan ini disahkan keputusan penilaian
 </div>
 <br>
 <div style="text-align:center">
 <strong>Information Technology Skills Assessment and Certification (ISAC): <br />
 Tahap Asas Pengetahuan dan Kemahiran IT</strong>
 </div>
 <br>
 <br>
 <div style="text-align:center">
 <strong>NAMA</strong>
<p><strong>840902016426</strong></p>
 </div>
 <br>
 <div style="text-align:center">
<strong>LULUS</strong>
 </div>
 <br>
  <div style="text-align:center">
diadakan pada <br />
<strong>23-01-2017</strong>
 </div>
 <br>
 <div style="text-align:center">
di<br />
<strong>INTAN Bukit Kiara, Kuala Lumpur</strong>
 </div>
 <br>
 <br>
 <br>
 <br>
 <div style="text-align:center">
Pengarah<br />
Institut Tadbiran Awam Negara<br />
Jabatan Perkhidmatan Awam<br />
 </div>
 

          
           <br />
		   <br />
		   <br />
		   
           <br />
		   <br />
		    <br />
		  
		  
		   
		   
		   
                  <b> <div style="text-align:center; font-size:12px"> Ini adalah cetakan komputer. Tandatangan tidak diperlukan.<br />
Sebarang pertanyaan, sila hubungi 03-20847700 atau isachelp@intanbk.intan.my
</div> </b>
   
 
 <?php } ?>

<?php 

$html = ob_get_clean();
 require_once(dirname(__FILE__).'/mpdf/mpdf.php');;
 $mpdf=new mPDF('utf-8','A4','','','15','15','15','5'); ;

$mpdf->WriteHTML($html);

$mpdf->Output(); exit;



?>