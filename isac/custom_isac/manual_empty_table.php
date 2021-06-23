<?php 
include ('db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
<?php
if (isset($_POST['btnEmpty']))
{
$sql1 = "DELETE FROM usr_isac.pro_pemilihan_soalan_perincian";
$result1 = $myQuery->query($sql1,'RUN');

$sql2 = "DELETE FROM usr_isac.prs_penilaian_peserta_jawapan";
$result2 = $myQuery->query($sql2,'RUN');

$sql3 = "DELETE FROM usr_isac.prs_penilaian_peserta_kemahiran";
$result3 = $myQuery->query($sql3,'RUN');

$sql4 = "DELETE FROM usr_isac.pro_pemilihan_set_kemahiran";
$result4 = $myQuery->query($sql4,'RUN');

if($result1 && $result2 && $result3 && $result4)
{
echo "<div width='50%' id='userNotification'>Data berjaya dihapuskan</div>";
}
else
{
echo "<div width='50%' id='userNotification'>Data gagal dihapuskan</div>";

}

}

 ?>
 <table cellspacing="0" cellpadding="0">
  <col width="64" />
  <tr height="20">
    <td height="20" width="326">1) prs_penilaian_peserta_jawapan</td>
  </tr>
  <tr height="20">
    <td height="20">2) prs_penilaian_peserta_kemahiran</td>
  </tr>
  <tr height="20">
    <td height="20">3) pro_pemilihan_soalan_perincian</td>
  </tr>
  <tr height="20">
    <td height="20">4) pro_pemilihan_set_kemahiran</td>
  </tr>
</table>
<br/>
<br/>
<input type="submit" name="btnEmpty" id="btnEmpty" value="Empty" />
</form>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
