<?php
$usr = $_GET['id'];
include ('../db.php');

//skema jawapan
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
			b.kod_bahagian_soalan='04'
			and
			c.id_peserta='$usr'";
$answer = mysql_query($ans) or die('Error, query failed');
//$answerRs = mysql_fetch_array($answer);


while ($row = mysql_fetch_array ($answer))
{
$searchwords = $row['skema_jawapan']; 
$id_soalan = $row['id_soalan'];

//file jawapan peserta
$jaw = "select fail_jawapan_peserta from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta='$usr'";
$jawapan = mysql_query($jaw) or die('Error, query failed');
$jawapanRs = mysql_fetch_array($jawapan);

$file = '../'.$jawapanRs['fail_jawapan_peserta'];

//get file jawapan peserta
$myWord = file_get_contents($file);
$myWord = str_replace("=\r\n",'',$myWord);
$myWord = str_replace("\r\n",'',$myWord);
str_replace("=\r\n",'',$myWord);

		if($searchwords)
		{
		//compare file  jawapan peserta dgn skema jawapan		
		if (eregi($searchwords, $myWord)) 
		{
		  echo "Found!";
	//	  $sql = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='$id_soalan' and id_peserta='50' ";
		 $sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta) values ('1','$id_soalan','$usr')";
		  $result = $myQuery->query($sql,'RUN');
		}
		
		else
		{
		  echo "Not Found!";
		  $sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta) values ('0','$id_soalan','$usr')";
	//	  $sql = "update usr_isac.prs_penilaian_peserta_jawapan set markah='0' where id_soalan='$id_soalan' and id_peserta='50' ";
		  $result = $myQuery->query($sql,'RUN');
		} 
		}
} //eowhile		
?>