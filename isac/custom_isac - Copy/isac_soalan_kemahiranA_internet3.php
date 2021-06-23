<?php 
include ('../db.php');
//$usr = $_REQUEST['id'];
//$usr = $_POST['id'];
$usr = $_GET['id'];
$app = $_REQUEST['app'];
$url = $_POST['url'];
$carian = $_POST['carian'];


$_GET['success']; 

//skema jawapan 'Project Management'
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
//$row = mysql_fetch_array ($answer);
//echo 'hello';
//echo $usr;
//echo '->';
/*while ($row = mysql_fetch_array ($answer))
{*/
$id_soalan = $ansRs[2][0];
//echo '->';
$ans = $ansRs[2][1];
//echo $ans; 
$sql_check = "select markah as 'MARKAH' from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$usr."' and id_permohonan = '".$app."' and id_soalan='".$id_soalan."'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$mark = $checkRs[0][0];
//echo $mark;
	if($carian == $ans)
	{
		if($mark =='')
		{
			if($ans == 'Project Management')
			{
			//echo 'betol';
			$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('1','".$id_soalan."','".$usr."','".$app."','I')";
			$result = $myQuery->query($sql,'RUN');
			$filex= 'Project_Management_Google_Search.php';
			}
			else if($ans == 'Multimedia Super Corridor')
			{
			//echo 'betol';
			$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('1','".$id_soalan."','".$usr."','".$app."','I')";
			$result = $myQuery->query($sql,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_msc.php?id='.$usr.'&app='.$app.'"</script>';
			}
			else if($ans == 'Social Networking')
			{
			//echo 'betol';
			$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('1','".$id_soalan."','".$usr."','".$app."','I')";
			$result = $myQuery->query($sql,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_sn.php?id='.$usr.'&app='.$app.'"</script>';
			}
			else if($ans == 'Knowledge Economy')
			{
			//echo 'betol';
			$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('1','".$id_soalan."','".$usr."','".$app."','I')";
			$result = $myQuery->query($sql,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_ke.php?id='.$usr.'&app='.$app.'"</script>';
			}
			else if($ans == 'Systems Development')
			{
			//echo 'betol';
			$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('1','".$id_soalan."','".$usr."','".$app."','I')";
			$result = $myQuery->query($sql,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_sd.php?id='.$usr.'&app='.$app.'"</script>';
			}
		}
	    else
		{
			if($ans == 'Project Management')
			{
			//echo 'betol_update';
			$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
			$result2 = $myQuery->query($sql2,'RUN');
			$filex= 'Project_Management_Google_Search.php';
			
			}
			else if($ans == 'Multimedia Super Corridor')
			{
			//echo 'betol';
			$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
			$result2 = $myQuery->query($sql2,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_msc.php?id='.$usr.'&app='.$app.'"</script>';
			}
			else if($ans == 'Social Networking')
			{
			//echo 'betol';
			$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
			$result2 = $myQuery->query($sql2,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_sn.php?id='.$usr.'&app='.$app.'"</script>';
			}
			else if($ans == 'Knowledge Economy')
			{
			//echo 'betol';
			$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
			$result2 = $myQuery->query($sql2,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_ke.php?id='.$usr.'&app='.$app.'"</script>';
			}
			else if($ans == 'Systems Development')
			{
			//echo 'betol';
			$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
			$result2 = $myQuery->query($sql2,'RUN');
			echo '<script>window.location = "isac_soalan_kemahiranA_internet3_sd.php?id='.$usr.'&app='.$app.'"</script>';
			}
		}
	}//eof if
	else
	{
		if($mark=='')
		{
		//echo 'salah';
		$sql3 = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('0','".$id_soalan."','".$usr."','".$app."','I')";
		$result3 = $myQuery->query($sql3,'RUN');
		$filex= 'keyword_not_match.php';
		}
		else if($mark=='1')
		{
		$sql5 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
		$result5 = $myQuery->query($sql5,'RUN');
		$filex= 'keyword_not_match.php';
		}
		else
		{
		$sql4 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='0' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
		$result4 = $myQuery->query($sql4,'RUN');
		$filex= 'keyword_not_match.php';
		}
	}//eof else

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
<script type="text/javascript" src="mb.js"></script>
<link rel="stylesheet" href="mb.css" />
<style type="text/css">
<!--
body {
	margin-top: 0%;
	margin-left: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
}
-->
</style></head>

<body>
<div style="margin-left:-10px; margin-top:-4px;">
<table width="100%" border="0" align="center" bgcolor="#F3F4F6">
  
  <tr>
    <td width="100%" colspan="3"> <img src="image/header_google_search.png" width="1366" height="93" border="0" /></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF"> <?php 
											if ($_GET['back']==1) 
											{
											include ('Project_Management_Google_Search.php');  
											}
											else 
											{ 
											include ($filex);
											}
											?>&nbsp;</td>
  </tr>
</table>
</div>
</td>
  </tr>
</table>


</body>
</html>
