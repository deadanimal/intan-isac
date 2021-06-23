<?php 
include ('../db.php');
$usr = $_GET['id'];
$app = $_GET['app'];
//$usr = $_POST['id'];
//echo $usr;

$to = $_POST['to'];
$subject = $_POST['subject'];
$attachment = $_POST['openssme'];
$mesej = $_POST['mesej'];


//skema jawapan
$ans = "select a.id_soalan,d.markah
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
			b.kod_bahagian_soalan='04'
			and
			c.id_peserta='".$usr."'
			and
			c.id_permohonan='".$app."'";
//$answer = mysql_query($ans) or die('Error, query failed');
$ansRs = $myQuery->query($ans,'SELECT');
//$id_soalan = $ansRs[0][0];
$send = $ansRs[4][0];
$markah = $ansRs[0][1];

//$mark = $checkRs[0][0];/echo $ansRs[0][0];

$qq[] = $to;
$qq[] = $subject;
$qq[] = $attachment;
$qq[] = $mesej;

for($x=0;$x< count($ansRs);$x++)
{
$a= $ansRs[$x][0];

$sql_check = "select markah from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$usr."' and id_permohonan='".$app."' and id_soalan='$a'";
$checkRs = $myQuery->query($sql_check,'SELECT');

if($checkRs=='')
{

		if($qq[$x] != '')
		{
		$jawapan = "insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,keterangan_jawapan,markah,id_peserta,id_permohonan,status_push_pull) values ('$a','$qq[$x]','$markah','".$usr."','".$app."','I')";
		$jawapanRs = $myQuery->query($jawapan,'RUN');
			
		}
		else
		{
		$jawapan = "insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan,keterangan_jawapan,markah,id_peserta,id_permohonan,status_push_pull) values ('$a','$qq[$x]','0','".$usr."','".$app."','I')";
		$jawapanRs = $myQuery->query($jawapan,'RUN');
		
		$jawapan2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='$markah' where id_peserta='".$usr."' and id_permohonan='".$app."' and id_soalan='$send'";
		$jawapanRs2 = $myQuery->query($jawapan2,'RUN');
		}
}
else
{	
		if($qq[$x] != '')
		{
		$jawapan = "update usr_isac.prs_penilaian_peserta_jawapan set keterangan_jawapan='$qq[$x]',markah='$markah' where id_peserta='".$usr."' and id_permohonan='".$app."' and id_soalan='$a'";
		$jawapanRs = $myQuery->query($jawapan,'RUN');
		
		$jawapan2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='$markah' where id_peserta='".$usr."' and id_permohonan='".$app."' and id_soalan='$send'";
		$jawapanRs2 = $myQuery->query($jawapan2,'RUN');
		}
		else
		{
		$jawapan = "update usr_isac.prs_penilaian_peserta_jawapan set keterangan_jawapan='$qq[$x]',markah='0' where id_peserta='".$usr."' and id_permohonan='".$app."' and id_soalan='$a'";
		$jawapanRs = $myQuery->query($jawapan,'RUN');
		
		$jawapan2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='$markah' where id_peserta='".$usr."' and id_permohonan='".$app."' and id_soalan='$send'";
		$jawapanRs2 = $myQuery->query($jawapan2,'RUN');
	
		}
}
	
	
	}//eof for ans


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body onload="window.close();">
</body>
</html>
