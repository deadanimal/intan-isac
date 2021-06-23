<?php 
include ('../db.php');
//$usr = $_REQUEST['id'];
//$usr = $_POST['id'];
$usr = $_GET['id'];
$app = $_GET['app'];
//$url = $_REQUEST['url'];
$carian = $_POST['carian'];

$_GET['success']; 
	
?>
<?php 
//skema jawapan 'Back Button'
$ans = "select a.id_soalan,d.skema_jawapan 
			from usr_isac.pro_soalan a,
			usr_isac.pro_kemahiran b,
			usr_isac.pro_pemilihan_set_kemahiran c,
			usr_isac.pro_jawapan d
			where
			a.id_soalan=d.id_soalan
			and
			b.kod_set_soalan=c.kod_set_soalan
			and
			a.id_kemahiran=b.id_kemahiran
			and
			b.kod_bahagian_soalan='01'
			and
			c.id_peserta='".$usr."' and c.id_permohonan = '".$app."' order by id_soalan asc ";
//$answer = mysql_query($ans) or die('Error, query failed');
$ansRs = $myQuery->query($ans,'SELECT');

$id_soalan = $ansRs[4][0];
$ans = $ansRs[4][1];

$sql_check = "select markah as 'MARKAH' from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$usr."' and id_permohonan = '".$app."' and id_soalan='".$id_soalan."'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$mark = $checkRs[0][0];

	if($_GET['back']==1)
	{
		if($mark =='')
		{
		//echo 'betol';
		$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('1','".$id_soalan."','".$usr."','".$app."','I')";
		$result = $myQuery->query($sql,'RUN');
		//$filex= 'Project_Management_Google_Search.php';
		}
	    else
		{
		//echo 'betol_update';
		$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
		$result2 = $myQuery->query($sql2,'RUN');
		//$filex= 'Project_Management_Google_Search.php';
		}
	}//eof if
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-top: 0%;
	margin-left: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
}
-->
</style>
<script type="text/javascript" src="mb.js"></script>
<link rel="stylesheet" href="mb.css" />
<style type="text/css">
<!--
.style1 {
	font-family: Verdana;
	font-size: 12px;
}
-->
</style>
<script type="text/javascript">
<!--

function exit() {
window.close('isac_soalan_kemmahiranA_internet3_sd.php');
}

-->
</script>
</head>

<body onLoad="mbSet('m', 'jsm'); mbSet('mb1', 'mbv'); mbSet('mb2', 'mbh');">

<div style="margin-left:-10px; margin-top:-4px;">
<table width="100%" border="0" align="center" bgcolor="#F3F4F6">
  
  <tr>
    <td width="100%" colspan="3"><img src="internet/system_development/SD_header.png" width="1365" height="91" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" > <?php include ('internet/system_development/System_Development_Google_Search.php'); ?>&nbsp;</td>
  </tr>
</table>
</div>

<div style="margin-top:-15px; position:absolute; height:-17px; top:31px; left:10px;">
<table width="80%" border="0">
  <tr>
    <td>

<div id="c" >
<div id="eg">
<ul id="mb1">
</ul>

<h3>&nbsp;</h3>

<ul class="style1" id="mb2">
<li><a href="#">File</a>
	<ul style="border-right-width:3px; border-bottom-width:3px;">
	<li class="">
    <a href="#">New Tab&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ctrl+T</a>
    <a href="#">New Window&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ctrl+N</a>
    <a href="#">Open...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ctrl+O</a>
    <a href="#">Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspCtrl+S</a>
    <a href="#">Save As...</a>
    </li>
	<li>
    <a href="#">Page Setup...</a>
    <a href="#">Print...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ctrl+P</a>

	<li>
    <a href="javascript:window.close()">Exit</a>
    </li>
	</ul></li>
    

</ul>
</div>

</div>

<ul id="m">

</ul>

<div id="spi"></div>
</td>
  </tr>
</table>
</div>


</body>
</html>
