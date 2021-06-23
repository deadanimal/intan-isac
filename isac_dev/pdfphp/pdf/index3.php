<?
require("../html2fpdf/html2fpdf.php");
$htmlFile = "test1.html";
$file = fopen($htmlFile,"r");
$size_of_file = filesize($htmlFile);
$buffer = fread($file, $size_of_file);
fclose($file);
$pdf=new HTML2FPDF();
$pdf->AddPage();
$pdf->WriteHTML($buffer);
$pdf->Output('doc.pdf','I');
?>