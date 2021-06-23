<?php 
header("Content-type: application/octet-stream");
header("Content-disposition: attachment; filename=exp_".$_GET['file']); 
echo file_get_contents('export_import/exp_'.$_GET['file']);
?>
