<?php 
include ('../db.php');
$usr = $_REQUEST['id'];
$app = $_REQUEST['app'];
//$usr = $_POST['id'];
//echo $usr;
$url = $_POST['url'];

$carian = $_POST['carian'];

//skema jawapan
$ans = "select distinct a.id_soalan,d.skema_jawapan 
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
//echo '->';
/*while ($row = mysql_fetch_array ($answer))
{*/
$id_soalan = $ansRs[1][0];
//echo '->';
$ans = $ansRs[1][1];
//echo '->'; 
$sql_check = "select markah as 'MARKAH' from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$usr."' and id_permohonan = '".$app."' and id_soalan='".$id_soalan."'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$mark = $checkRs[0][0];
//echo $mark;
	if($url == $ans)
	{
		if($mark =='')
		{
		//echo 'betol';
		$sql = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('1','".$id_soalan."','".$usr."','".$app."','I')";
		$result = $myQuery->query($sql,'RUN');
				
		}
		else
		{
		//echo 'betol_update';
		$sql2 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
		$result2 = $myQuery->query($sql2,'RUN');
		}

	}//eof if
	else
	{ 
		if($mark=='')
		{
		$sql3 = "insert into usr_isac.prs_penilaian_peserta_jawapan (markah,id_soalan,id_peserta,id_permohonan,status_push_pull) values ('0','".$id_soalan."','".$usr."','".$app."','I')";
		$result3 = $myQuery->query($sql3,'RUN');
		echo '<script>window.location = "isac_soalan_kemahiranA_internet_page_cannot_display.php?id='.$usr.'&app='.$app.'&url='.$_POST['url'].'"</script>';
		}
		else if($mark=='1')
		{
		$sql5 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='1' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
		$result5 = $myQuery->query($sql5,'RUN');
		echo '<script>window.location = "isac_soalan_kemahiranA_internet_page_cannot_display.php?id='.$usr.'&app='.$app.'&url='.$_POST['url'].'"</script>';
		}
		else
		{
		$sql4 = "update usr_isac.prs_penilaian_peserta_jawapan set markah='0' where id_soalan='".$id_soalan."' and id_peserta='".$usr."' and id_permohonan = '".$app."'";
		$result4 = $myQuery->query($sql4,'RUN');
		echo '<script>window.location = "isac_soalan_kemahiranA_internet_page_cannot_display.php?id='.$usr.'&app='.$app.'&url='.$_POST['url'].'"</script>';
		}
	}//eof else

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
</style>
<script type="text/javascript">
function TitleCase(objField) 
{
      var objValues = objField.value.split(" ");
      var outText = "";
      for (var i = 0; i < objValues.length; i++) {
      outText = outText + objValues[i].substr(0, 1).toUpperCase() + objValues[i].substr(1).toLowerCase() + ((i < objValues.length - 1) ? " " : "");
      }
      return outText;
} 
</script>
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#F3F4F6">
  <tr>
    <td width="6%"><img src="image/intan_web/header5.png" width="74" height="30" /></td>
    <td width="71%" bgcolor="#F3F5F5"><form id="form1" name="form1" method="post" action="">
      <div style="margin-top:1px; margin-left:1px"><input name="url_google" type="text" id="url_google" value="<?php echo $url;?>" size="96" readonly="true"/>
      </div>
    </form>    </td>
    <td width="22%"><img src="image/intan_web/header4.gif" width="298" height="30" border="0" /></td>
  </tr>
  <tr>
    <td colspan="3"><img src="image/google1.png" width="100%" height="62" /></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">
     <table width="100%" border="0">
      
      <tr>
        <td colspan="2" bgcolor="#FFFFFF"><img src="image/b.png" width="100%" height="171" /></td>
      </tr>
      <tr>
        <td width="67%" bgcolor="#FFFFFF"><div align="right">
            <form id="form2" name="form2" method="post" action="isac_soalan_kemahiranA_internet3.php?id=<?php echo $_GET['id'];?>&app=<?php echo $_REQUEST['app']; ?>">
              <input name="carian" type="text" id="carian" size="70" onkeyup="this.value=TitleCase(this);"/>
              <input name="id" type="hidden" id="id" size="" value="<?php echo $_POST['id'];?>"/>
              <input name="app" type="hidden" id="app" size="" value="<?php echo $_POST['app'];?>"/>
                      
            </div></td>
        <td width="33%" bgcolor="#FFFFFF"><img src="image/c.png" width="100%" height="31" /></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#FFFFFF"><div align="center">
            <input type="submit" name="button" id="button" value="Google Search" onclick=""/>
            <input type="submit" name="button2" id="button2" value="I'm Feeling Lucky" />
        </div></td>  </form>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#FFFFFF"><img src="image/d.png" width="100%" height="325" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><img src="image/intan_web/footer.png" width="100%" height="24" /></td>
  </tr>
</table>

</body>
</html>
