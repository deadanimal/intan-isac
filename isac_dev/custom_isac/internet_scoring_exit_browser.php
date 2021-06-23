<?php 
include ('../db.php');
$usr = $_GET['id'];

//skema jawapan 'Exit Button'
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
			c.id_peserta='".$usr."' order by id_soalan asc ";
//$answer = mysql_query($ans) or die('Error, query failed');
$ansRs = $myQuery->query($ans,'SELECT');

$id_soalan = $ansRs[4][0];
$ans = $ansRs[4][1];

$sql_check = "select markah as 'MARKAH' from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$usr."' and id_soalan='".$id_soalan."'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$mark = $checkRs[0][0];

	if($_GET['back']==1)
	{
		if($mark =='')
		{
		echo 'betol';
		$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta) values ('1','".$id_soalan."','".$usr."')";
		$result = $myQuery->query($sql,'RUN');
		$filex= 'Project_Management_Google_Search.php';
		}
	    else
		{
		echo 'betol_update';
		$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."'";
		$result2 = $myQuery->query($sql2,'RUN');
		$filex= 'Project_Management_Google_Search.php';
		}
	}//eof if
	
?>
