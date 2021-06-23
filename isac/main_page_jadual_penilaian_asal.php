<?php
//s/ession_start();
/*include ('db.php');

//$ic_peserta ='aaaa';
$ic_peserta = $_REQUEST['usr'];

//path file
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='01'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//server IP
$location = $path_nameRs[0][2];*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::JADUAL PENILAIAN::</title>

<style type="text/css">
<!--
body {
	background-color: #FE801A;
	margin-left: 0%;
	margin-top: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
	background-repeat: no-repeat;
	background-position: center;
	background-position:top;
}
</style>

</head>

<body>
<div align="center">
<table cellpadding="0px" cellspacing="0px">
<tr><td><img src="img/mainpage_top.png" width="790" height="233" /></td></tr>
<tr><td background="img/mainpage_mid.png">
<div align="center"  style="padding-left:3px">
    <table cellpadding="-3px"><div style="margin-top:-30px; margin-left:5px; position:absolute;"><a href="http://d10.1.3.83/isac/main_page.php"><img border="0" src="img/home.png" width="30" height="30" /></a></div>
    <div style="margin-top:-30px; margin-left:580px; position:absolute;"><a href="http://d10.1.3.83/isac/login.php?"><img border="0" src="img/login_icon3.png" width="200" height="26" /></a></div>
    <tr>
    <td><a href="http://d10.1.3.83/isac/main_page_mengenai_isac.php"><img border="0" src="img/1.png" width="152" height="126" /></a></td>
    <td><a href="http://d10.1.3.83/isac/login.php?mode=mohon"><img border="0" src="img/2.png" width="152" height="126" /></a></td>
    <td><a href="http://d10.1.3.83/isac/main_page_jadual_penilaian.php"><img border="0" src="img/3.png" width="152" height="126"/></a></td>
    <td><a href="http://d10.1.3.83/isac/login.php?mode=semak"><img border="0" src="img/4.png" width="152" height="126" /></a></td>
    <td><a href="http://d10.1.3.83/isac/main_page_hubungi_kami.php"><img border="0" src="img/5.png" width="152" height="126" /></a></td>
    </tr>
    </table>
</div>
</td></tr>
<tr><td background="img/mid2.png">
<div align="center">
<iframe src="jadual_individu_kumpulan.php" height="250px"  width="700px" frameborder="0" ></iframe>
</div>
<?php
//include('exam_schedule_kumpulan.php');
?>
  <tr><td><div style="margin-top:auto;"><img src="img/footer2.png" width="790" height="44" style="background-repeat:repeat-y" /> </div></td></tr>
</table>
</div>
</body>
</html>