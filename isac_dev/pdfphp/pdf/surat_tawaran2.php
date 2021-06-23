<?php
// activate Output-Buffer:
ob_start();
//Connect to database
//mysql_connect(DB_CONNECTION,DB_USERNAME,DB_PASSWORD);
//mysql_select_db(DB_DATABASE);

include "surat_tawaran_penilaian2.php";
$htmlbuffer=ob_get_contents();
ob_end_clean();
require('../html2fpdf/html2fpdf.php');
$pdf=new HTML2FPDF();
$pdf->AddPage();

//$gif_image = pdf_open_jpg($pdf, "cop.jpg");

//pdf_place_image($pdf, $gif_image, 200, 300, 1.0);
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('doc.pdf','I');
?>