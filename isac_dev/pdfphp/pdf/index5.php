<?php
function load($url){
	curl_setopt($curld, CURLOPT_URL, $url); 
	curl_setopt($curld, CURLOPT_RETURNTRANSFER, true); 
	$output = curl_exec($curld); 
	curl_close($curld); 
	return $output;
}
ob_start();

echo load("http://localhost/nuker/");
$htmlbuffer=ob_get_contents();
ob_end_clean();

require('../html2fpdf/html2fpdf.php');
$pdf=new HTML2FPDF();
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('doc.pdf','I');
?>