<?php 
include ('../db.php');
$usr = $_GET['id'];
$app = $_GET['app'];
//$usr = $_POST['id'];
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
$id_soalan = $ansRs[3][0];
//echo '->';
$ans = $ansRs[3][1];

$sql_check = "select markah as 'MARKAH' from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$usr."' and id_permohonan = '".$app."' and id_soalan='".$id_soalan."'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$mark = $checkRs[0][0];
//echo $mark;
	
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
		$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."' ";
		$result2 = $myQuery->query($sql2,'RUN');
		//$filex= 'Project_Management_Google_Search.php';
		}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-top: 0.1%;
	margin-left: 0.1%;
	margin-right: 0.1%;
	margin-bottom: 0.1%;
}
-->
</style></head>

<body>
  <tr>
    <td colspan="3"><img src="internet/mobile_application/ma_header2.png" width="1365" height="91" border="0" usemap="#Map" />
<map name="Map" id="Map">
<area shape="rect" coords="3,0,33,34" href="isac_soalan_kemahiranA_internet3_ma.php?id=<?php echo $usr; ?>&app=<?php echo $app; ?>&back=1" />
</map></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">
     <div style="margin-left:5px;">
      <table width="100%" border="0">
        <tr>
          <td><?php include ('internet/mobile_application/mobile_application_development.php');?>&nbsp;</td>
        </tr>
      </table></div></td>
  </tr>
  <tr>
    <td colspan="3"><img src="image/intan_web/footer.png" width="100%" height="24" /></td>
  </tr>
</table>
</body>
</html>
