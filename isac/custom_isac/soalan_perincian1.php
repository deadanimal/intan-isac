<?php
//include
include('../db.php');
include('func_page.php');
echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';
echo '<script type="text/javascript" src="proses_script.js"></script>'; 
//$_GET['jwpn'];
//set default url
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		} else {
		$pageURL .= $_SERVER["SERVER_NAME"];
		}
//end



//define
$usr = $_GET['usr'];
$hantar = $_GET['hantar'];
$app = $_GET['app'];

$mohon = "select id_permohonan,kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='".$usr."')";
$mohonRs = $myQuery->query($mohon,'SELECT');
$id_mohon = $mohonRs[0][0];
$kod_tahap = $mohonRs[0][1];


$query = "SELECT a.id_peserta, a.id_permohonan, b.id_soalan, b.arahan_soalan,b.penyataan_soalan,b.muat_naik_fail,c.kod_jenis_soalan,
				(SELECT DESCRIPTION2 FROM REFGENERAL WHERE MASTERCODE = 
				(SELECT REFERENCECODE FROM REFGENERAL WHERE DESCRIPTION1 = 'JENIS_SOALAN') and referencecode = c.kod_jenis_soalan) jenis
				FROM 
				usr_isac.pro_pemilihan_soalan_perincian a,
				usr_isac.pro_soalan b,
				usr_isac.pro_pengetahuan c
				where 
				a.id_soalan = b.id_soalan and
				b.id_soalan = c.id_soalan and 
				a.id_peserta = '$usr' and
				a.id_permohonan = '$id_mohon' and a.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')
				ORDER BY a.id_pemilihan_soalan_perincian";


$result = mysql_query($query) or die('Error, query failed');

while($data = mysql_fetch_array($result))
{
$id_peserta = $data['id_peserta'];
$id_permohonan = $data['id_permohonan'];
$id_soalan[] = $data['id_soalan'];
$arahan_soalan[] = $data['jenis'];
$soalan[] = $data['penyataan_soalan'];
$kod[] = $data['kod_jenis_soalan'];
$imgs[] = $data['muat_naik_fail'];
//echo "<pre>";print_r($data);exit;
}

//echo count($id_soalan);
//Getting currect page.
if(!isset($_GET['page'])){
$page = 1;
}
else{
$page = $_GET['page'];
 }
 
$prev_page = $page - 1;
$next_page = $page + 1;
 
//Applying pagination.
$pagination = pagination_array($arahan_soalan, $soalan, $kod, $id_soalan, $imgs,"&usr=".$id_peserta."&app=".$id_permohonan."&submit=true", $page, "?page=");
$last_page = $pagination['last'];
$page_offset = ($page - 1) * 1;

?>
<style type="text/css">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
.style3 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.style4 {
	font-size: 12px;
	font-family: "Times New Roman", Times, serif;
}
.style6 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
.style8 {font-size: 14px}
.style11 {color: #FF0000}
-->
</style>

<form action="javascript:get(document.getElementById('myform'));" method="post" name="myform" id="myform">

<!-- username -->

<input id="usr" name="usr"  type="hidden" value="<?php echo $id_peserta; ?>"/>
<input id="app" name="app"  type="hidden" value="<?php echo $id_permohonan; ?>"/>
<!-- check submit -->
<input id="hantar" name="hantar"  type="hidden"/>
<div style= "margin-top:-10px;">
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">


<?php

for($x=0;$x<sizeof($pagination['arahan_soalan']);$x++){

$arahan_soalan= $pagination['arahan_soalan'][$x+$page_offset];
$soalan= $pagination['soalan'][$x+$page_offset];
$kod= $pagination['kod'][$x+$page_offset]; 
$id_soalan= $pagination['id_soalan'][$x+$page_offset];
$imgs = $pagination['imgs'][$x+$page_offset];
?>

    

<!-- soalan -->


<input id="soalan" name="soalan"  type="hidden" value="<?php echo $id_soalan; ?>"/>
<!--<input id="soalan" name="soalan"  type="text" value="<?php //echo $id_soalan; ?>"/>-->

<tr class="style15">
<td height="29" bgcolor="#FFFFFF"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Arahan <em>(Instruction)</em> : <?php echo $arahan_soalan; ?><?php 

//echo $id_soalan; ?></span></span></div></td>

</tr>
<tr>
<td height="29"><table width="100%" border="0">
<tr>
<td>
<span class="style44">
<table width="100%" border="0" cellspacing="0">
</span>
<tr>
<!--<td width="34" align="center" bgcolor="" class="style44"><span class="style45">No.</span></td>
<td width="1271" align="center" bgcolor="" class="style44"><span class="style45">Soalan (<em>Question</em>)</span></td>-->
</tr>
<tr>
<td width="25px" align="center" valign="top" bgcolor="" class="style44"><span class="style47">
  <p>
	<strong><?php echo '<br>'.$page.'.'; ?></p></td>
 <?php if($imgs != './upload/'){ ?>
<br/><br/>
<div align="center">
<img src="../<?php echo $imgs; ?>" width="200px" height="200px" />
</div>
<?php } ?>
<td bgcolor="" class="style44"><span class="style47"><?php echo '<br>'.$soalan; ?></span></td>
</tr>
<tr>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td width="6%" class="style44">&nbsp;</td>
<td width="94%" class="style44">

<?php
if($kod == '01'){include('jawapan_single.php');}
elseif($kod == '02'){include('jawapan_multiple.php');}
elseif($kod == '03'){include('jawapan_tof.php');}
elseif($kod == '04'){include('jawapan_fib.php');}
elseif($kod == '05'){include('jawapan_ranking.php');}
elseif($kod == '06'){include('jawapan_sub.php');}
echo '</div></tr>';

} 
echo '</table>';
echo '<br>';
echo '<br>';
?></td>
</tr>
</table>
</tr></table>  </div> 
<span class="style3 style1 style4"><span class="style3 style1  style6"><span class="style3 style1 style8">
<?php
echo '<br>';

//Ruangan Paging
echo '<div align="center" id="userNotification3">';

//Kembali
if($page != 1){
echo '<span><a href="'.$pageURL.'/isac/custom_isac/soalan_perincian1.php?page='.$prev_page.'&submit=true&usr='.$id_peserta.'&app='.$id_permohonan.'"><< 

Kembali</a></span>
&nbsp;&nbsp;&nbsp;&nbsp;';
}
//paging
echo $pagination['panel'];
//Seterusnya
if($page != $last_page){
echo '&nbsp;&nbsp;&nbsp;&nbsp;<span><a onclick="saveMasa()" href="'.$pageURL.'/isac/custom_isac/soalan_perincian1.php?page='.$next_page.'&submit=true&usr='.$id_peserta.'&app='.$id_permohonan.'">Seterusnya >></a></span>
&nbsp;&nbsp;';
}
echo '</div>';
?>
</span></span></span>  <table width="100%" border="0">
    <tr>
      <td><span class="style6"><span class="style11">&nbsp;* Nota</span>: Klik pada nombor soalan yang tertera di atas ini untuk ke soalan seterusnya atau klik pada perkataan &quot;<strong>Seterusnya</strong>&quot;</span></td>
    </tr>
  </table>
<div id="userNotification3" align="right">

  <span class="style3">
  <input style="margin-right:3px" onClick="window.location = 'check_answer.php?usr=<?php echo $id_peserta; ?>&app=<?php echo $id_permohonan; ?>'"  type="button" value="Semak Status Soalan" class="inputButton">
</span><span class="style1"></span></div>
