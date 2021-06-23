<?php 
# PHPlot Example:  Flat Pie with options
require_once 'tools\phplot\phplot.php';
include('db.php');

//messy
$query1 = stripslashes(str_replace("from"," from",$_GET['query']));
$query2 = str_replace("order"," order",$query1);

  $ssn = str_replace("|||","+",html_entity_decode(htmlspecialchars(str_replace("''","'",stripslashes($_GET['query'])))));
//echo $ssn = htmlspecialchars($_GET['query']);

//

if($_GET['medan'] != "" and $_GET['namagraf'] != "" and $_GET['jenisgraf'] != "" and $_GET['query'] != ""){
$title = $_GET['namagraf'];
$namagraf =  $_GET['namagraf'];
$jenisgraf = $_GET['jenisgraf'];
$medan = $_GET['medan'];
$labelx = $_GET['labelx'];
$labely  = $_GET['labely'];

//$queryfrom = stripslashes($_GET['query']);

//$query = "select ".$medan.", count(".$medan.") ".$queryfrom." group by ".$medan;
//$query = "select `".$medan."`, count(`".$medan."`) from (".$ssn.") as a group by `".$medan."`";

$query = "select bulan, `kanak-kanak` from (".$ssn.") as x ";

//$query = "select kod_agama, count(*) from pelanggan1.pelanggan group by kod_agama";
$result = $myQuery->query($query,'SELECT','NAME');


$data = $result;


if($jenisgraf == 'pie'){
	include_once('tools\phplot\pie.php');
}
elseif($jenisgraf == 'bars'){
	include_once('tools\phplot\bars.php');
}
}
?>