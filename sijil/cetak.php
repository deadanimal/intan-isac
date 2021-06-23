<?php
ob_start();
 error_reporting(E_ERROR | E_PARSE);
 include "connection.php";
 $con = new connect();
 include_once 'log_user.php';
?>

 <?php 	
 //var_dump($_REQUEST);
 
$res=$con->getdata("SELECT
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
pro_sijil.`TIMESTAMP`,
prs_penilaian_peserta.KOD_STATUS_KELULUSAN,
prs_permohonan.ID_SESI,
pro_sesi.ID_SESI,
pro_sesi.TARIKH_SESI
FROM
pro_peserta
INNER JOIN pro_sijil ON pro_sijil.ID_PESERTA = pro_peserta.ID_PESERTA
INNER JOIN prs_penilaian_peserta ON pro_peserta.ID_PESERTA = prs_penilaian_peserta.ID_PESERTA
INNER JOIN prs_permohonan ON prs_permohonan.ID_PERMOHONAN = pro_sijil.ID_PERMOHONAN
INNER JOIN pro_sesi ON prs_permohonan.ID_SESI = pro_sesi.ID_SESI
WHERE NO_KAD_PENGENALAN = '".$_REQUEST['mykad']."' AND prs_penilaian_peserta.KOD_STATUS_KELULUSAN ='Lulus'");
$matched=mysql_fetch_array($res);

$user_ip = getUserIP();
$datelog = datelog();
$sqllog="INSERT INTO sijil_log(Ip,Ic,DateLog,Activity) VALUES('".$user_ip."','".$_REQUEST['mykad']."','".$datelog."','Cetak')";
$con->setdata($sqllog);
	 {
//var_dump($matched);
	   ?> 

<style>
div {
    font-size: 17px;
	font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
	
	
}

</style>
  <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>          
 <table width="100%" border="0">
   <tr>
     <td align="right"><div align="right">No. Sijil<strong>: ISAC/<?php  echo $matched['KOD_IAC']; ?>/<?php echo substr($matched['TARIKH_SESI'], 0, 4);?>/<?php echo $no_sijil = str_pad($matched['NO_SIJIL'], 5, '0', STR_PAD_LEFT); ?></strong><strong> </strong></div></td>
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
 
 <div style="text-align:center; font-size:20px"><strong><?php  echo strtoupper($matched['NAMA_PESERTA']); ?></strong></div>
<div style="text-align:center; margin-top:5px; font-size:20px"><strong><?php  echo $matched['NO_KAD_PENGENALAN']; ?></strong></div>
 
 <br>
 <div style="text-align:center; font-size:20px">
<strong><?php  echo strtoupper($matched['KOD_STATUS_KELULUSAN']); ?></strong>
 </div>
 <br>
  <div style="text-align:center; font-size:20px">
diadakan pada <br />
<strong><?php  echo date_format (new DateTime($matched['TIMESTAMP']), 'd-m-Y');  ?></strong>
 </div>
 <br>
 <div style="text-align:center; font-size:20px">
di<br />
<strong><?php  
 
 switch ($matched['KOD_IAC']) {
    case "01":
        echo "INTAN Bukit Kiara, Kuala Lumpur";
        break;
    case "05":
        echo "INTAN Wilayah Timur (INTIM)";
        break;
    case "04":
        echo "INTAN Wilayah Utara (INTURA)";
        break;
case "03":
        echo "INTAN Wilayah Selatan (IKWAS)";
        break;
		   case "06":
        echo "INTAN Sabah";
        break;
		   case "07":
        echo "INTAN Sarawak";
        break;
    default:
        echo "Jabatan Perkhidmatan Awam, Putrajaya";
}
 ?></strong>
 </div>
 <p></p>
  <p></p>   
 <div style="text-align:center">
Pengarah<br />
Institut Tadbiran Awam Negara<br />
Jabatan Perkhidmatan Awam<br />
 </div>
 
<div style="text-align:right"><img src="img/cop.jpg" width="134" height="136" /></div>
 
 <b> <div style="text-align:center; font-size:12px"> Ini adalah cetakan komputer. Tandatangan tidak diperlukan.<br />
Sebarang pertanyaan, sila hubungi 03-20847777 atau isachelp@intanbk.intan.my
</div> </b>
 

<?php 
	 }
$html = ob_get_clean();
 require_once(dirname(__FILE__).'/mpdf/mpdf.php');;
 $mpdf=new mPDF('utf-8','A4','','','15','15','15','5'); ;

$mpdf->WriteHTML($html);

$mpdf->Output(); exit;



?>