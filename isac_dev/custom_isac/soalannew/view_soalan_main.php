<?php
//include
include('../../db.php');
include('../func_page.php');
require_once('paginator.class.php');
//define
$usr = $_GET['usr'];
$hantar = $_GET['hantar'];
$app = $_GET['app'];

$mohon = "select id_permohonan,kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='".$usr."')";
$mohonRs = $myQuery->query($mohon,'SELECT');
$id_mohon = $mohonRs[0][0];
$kod_tahap = $mohonRs[0][1];

$queryCountSoalan = "SELECT a.id_peserta
				FROM 
				usr_isac.pro_pemilihan_soalan_perincian a,
				usr_isac.pro_soalan b,
				usr_isac.pro_pengetahuan c
				where 
				a.id_soalan = b.id_soalan and
				b.id_soalan = c.id_soalan and 
				a.id_peserta = '".$usr."' and
				a.id_permohonan = '".$id_mohon."' and a.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')
				ORDER BY a.id_pemilihan_soalan_perincian";

$querySoalan = "SELECT a.id_peserta, a.id_permohonan, b.id_soalan, b.arahan_soalan,b.penyataan_soalan,c.kod_jenis_soalan,
				(SELECT DESCRIPTION2 FROM REFGENERAL WHERE MASTERCODE = 
				(SELECT REFERENCECODE FROM REFGENERAL WHERE DESCRIPTION1 = 'JENIS_SOALAN') and referencecode = c.kod_jenis_soalan) jenis,b.muat_naik_fail
				FROM 
				usr_isac.pro_pemilihan_soalan_perincian a,
				usr_isac.pro_soalan b,
				usr_isac.pro_pengetahuan c
				where 
				a.id_soalan = b.id_soalan and
				b.id_soalan = c.id_soalan and 
				a.id_peserta = '".$usr."' and
				a.id_permohonan = '".$id_mohon."' and a.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')
				ORDER BY a.id_pemilihan_soalan_perincian";

$queryCountSoalanRs = $myQuery->query($queryCountSoalan,'SELECT');
$countSoalan = count($queryCountSoalanRs);

$pages = new Paginator;
$pages->items_total = $countSoalan;
$pages->mid_range = 40;
$pages->paginate();

$querySoalanRs = $myQuery->query($querySoalan.$pages->limit,'SELECT');

$id_peserta = $querySoalanRs[0][0];
$id_permohonan = $querySoalanRs[0][1];
$id_soalan = $querySoalanRs[0][2];
$arahan_soalan = $querySoalanRs[0][3];
$penyataan_soalan = $querySoalanRs[0][4];
$kod_jenis_soalan = $querySoalanRs[0][5];
$jenis = $querySoalanRs[0][6];
$imgs = $querySoalanRs[0][7];

$currpage = 1;

if($_GET['page']!=""){
	$currpage=$_GET['page'];
}

?>

<script language="javascript" type="text/javascript" src="../../js/jquery.js"></script>

<script type="text/javascript">

function clickPaging(){
	var jQ = jQuery.noConflict();
	var url = "proses_jawapan.php";	
	var id_permohonan = document.getElementById('id_permohonan').value;
	var masa = window.parent.parentform.document.getElementById('ParentMasa').value;

	jQ.ajax({
			url: url,
			type: 'POST',
			data: "id_permohonan="+id_permohonan+"&masa="+masa/*,
			success: function(data){
				alert(data);
			}*/
	});
}
</script>


<style type="text/css">
	body{
		font-family:Arial;
		font-size:12px;
	}
	.paginate{
		font-family:Arial;
		font-size:12px;
		border:1px solid #FF6600;
		padding:3px;
		text-decoration:none;
		color:#000000;
		
	}
	.paginate:hover{
		background-color:#FF6600;
		color:white;
	}
	.inactive{
		font-family:Arial;
		font-size:12px;
		border:1px solid #CCCCCC;
		padding:3px;
		text-decoration:none;
		color:#CCCCCC;
	}
	.current{
		font-family:Arial;
		font-size:12px;
		border:1px solid #FF6600;
		padding:3px;
		text-decoration:none;
		background-color:#FF6600;
		color:white;
	}
	.userNotification3
	{
		border:1px #cad7e8 solid;
		padding-top:3px;
		padding-bottom:3px;
		background-color: #fafbf6;
	}
	.mainSoalan{
		border:1px #cad7e8 solid;
	}
	.col_note {color: #FF0000}
	.note {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	}
</style>

<div class="mainSoalan">

<div style="background-image:url(../../img/content/header_bar1.jpg);background-repeat: repeat-x;padding-top: 5px;padding-right: 10px;padding-bottom: 2px;padding-left: 10px;height: 25px;color:white;"><strong>Arahan <em>(Instruction)</em> : <?php echo $arahan_soalan; ?></strong></div>
<br/>
<div>

<table cellpadding="5" cellspacing="5">
	<tr>
    	<td width="5px" valign="top"><strong><?php echo $currpage."."; ?></strong></td>
        <td valign="top"><?php echo $penyataan_soalan; ?></td>
    </tr>
</table>
</div>
<!-- if ada image -->
<?php if($imgs != './upload/'){ ?>
<br/><br/>
<div align="center">
<img src="../<?php echo $imgs; ?>" />
</div>
<?php }else{} ?>
<div style="padding-left:80px">
	<?php
		if($kod_jenis_soalan == '01'){include('jawapan_single.php');}
		elseif($kod_jenis_soalan == '02'){include('jawapan_multiple.php');}
		elseif($kod_jenis_soalan == '03'){include('jawapan_tof.php');}
		elseif($kod_jenis_soalan == '04'){include('../jawapan_fib.php');}
		elseif($kod_jenis_soalan == '05'){include('jawapan_ranking.php');}
		elseif($kod_jenis_soalan == '06'){include('../jawapan_sub.php');}
	?> 
</div>
</div>
<br/>
<div class="userNotification3" style="padding-top:10px;padding-bottom:10px;" id="paging" align="center" onclick="clickPaging()">
<?php echo $pages->display_pages(); ?>
</div>
<br/>
<table width="100%" border="0">
    <tr>
      <td><span class="note"><span class="col_note">* Nota</span>: Klik pada nombor soalan yang tertera di atas ini untuk ke soalan seterusnya atau klik pada perkataan &quot;<strong>Seterusnya</strong>&quot;</span></td>
    </tr>
  </table>
<div  class="userNotification3" align="right">

  <span class="style3">
  <input style="margin-right:3px" onClick="window.location = 'check_answer.php?usr=<?php echo $id_peserta; ?>&app=<?php echo $id_permohonan; ?>'"  type="button" value="Semak Status Soalan" class="inputButton">
</span><span class="style1"></span></div>