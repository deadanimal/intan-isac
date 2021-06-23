<?php
$usr = $_GET['id'];
$app = $_GET['app'];
include ('../db.php');

//skema jawapan
$ans = "select a.id_soalan,d.skema_jawapan,d.markah 
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
			b.kod_bahagian_soalan='03'
			and
			c.id_peserta='$usr'
			and
			c.id_permohonan='$app'";
$answer = mysql_query($ans) or die('Error, query failed');
//$answerRs = mysql_fetch_array($answer);

while ($row = mysql_fetch_array ($answer))
{
$searchwords = $row['skema_jawapan']; 
$id_soalan = $row['id_soalan'];
$markah = $row['markah'];

//file jawapan peserta
$jaw = "select fail_jawapan_peserta from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta='".$usr."' and id_permohonan='".$app."' and kod_bahagian_soalan='03'";
$jawapan = mysql_query($jaw) or die('Error, query failed');
$jawapanRs = mysql_fetch_array($jawapan);

//$file = '../'.$jawapanRs['fail_jawapan_peserta'];
$file = $jawapanRs['fail_jawapan_peserta'];

//get file jawapan peserta
$myWord = file_get_contents($file);
$myWord = str_replace("=\r\n",'',$myWord);
$myWord = str_replace("\r\n",'',$myWord);
str_replace("=\r\n",'',$myWord);

$sql_check = "select markah from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$usr."' and id_permohonan='".$app."' and id_soalan='".$id_soalan."'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$mark = $checkRs[0][0];

	if($searchwords)
	{
		//compare file  jawapan peserta dgn skema jawapan		
		if (eregi($searchwords, $myWord)) 
		{
			if($mark =='')
			{
			//echo "Found!";
			$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('".$markah."','".$id_soalan."','".$usr."','".$app."','I')";
			$result = $myQuery->query($sql,'RUN');
			}
			else
			{
			//echo "Found_update!";
			$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='".$markah."' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan='".$app."'";
			$result2 = $myQuery->query($sql2,'RUN');
			}
		
	   }//eof if
		
		else
		{
			if($mark =='')
			{
			//echo "Not Found!";
			$sql3 = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('0','".$id_soalan."','".$usr."','".$app."','I')";
			$result3 = $myQuery->query($sql3,'RUN');
			}
			else
			{
			//echo "Not Found_update!";
			$sql4 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='0' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan='".$app."'";
			$result4 = $myQuery->query($sql4,'RUN');
			}
		}
	}//eof if searchwords

} //eowhile		



?>