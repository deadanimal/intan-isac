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

.style17 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style20 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style18 {font-family: Arial, Helvetica, sans-serif}
.style19 {font-size: 12px}


.tg-table-green { border-collapse: collapse; border-spacing: 0; }
.tg-table-green td, .tg-table-green th { background-color: #fff; border: 1px #bbb solid; color: #594F4F; vertical-align: top;font-family: Arial, Helvetica, sans-serif;font-size: 12px; }
.tg-table-green .tg-even td  { background-color: #EFFAB4; }
.tg-table-green th  { background-color: #9DE0AD; color: #594F4F; font-size: 80%; font-weight: bold; }
 
.tg-table-green tr:hover td, .tg-table-green tr.even:hover td  { color: #333; background-color: #E5FCC2; }
.tg-bf { font-weight: bold; } .tg-it { font-style: italic; }
.tg-left { text-align: left; } .tg-right { text-align: right; } .tg-center { text-align: center; }
 
</style>
</head>

<body>
<div align="center">
<table cellpadding="0px" cellspacing="0px">
<tr><td width="788"><img src="img/mainpage_top.png" width="790" height="233" /></td></tr>
<tr><td background="img/mainpage_mid.png">
<div align="center"  style="padding-left:3px">
    <table cellpadding="-3px"><div style="margin-top:-30px; margin-left:5px; position:absolute;"><a href="http://isac.intan.my/isac/main_page.php"><img border="0" src="img/home.png" width="30" height="30" /></a></div>
    <div style="margin-top:-30px; margin-left:580px; position:absolute;"><a href="http://isac.intan.my/isac/login.php?"><img border="0" src="img/login_icon3.png" width="200" height="26" /></a></div>
    <tr>
<td><a href="http://isac.intan.my/isac/main_page_mengenai_isac.php"><img border="0" src="img/1.png" width="125" height="105" /></a></td>
    <td><a href="http://isac.intan.my/isac/login.php?mode=mohon"><img border="0" src="img/2.png" width="125" height="105"/></a></td>
    <td><a href="http://isac.intan.my/isac/main_page_jadual_penilaian.php"><img border="0" src="img/3.png" width="125" height="105"/></a></td>
    <td><a href="http://isac.intan.my/isac/login.php?mode=semak"><img border="0" src="img/4.png" width="125" height="105"/></a></td>
    <td><a href="http://isac.intan.my/isac/main_page_hubungi_kami.php"><img border="0" src="img/5.png" width="125" height="105" /></a></td>
	<td><a href="http://isac.intan.my/sijil/" target="_blank"><img border="0" src="img/12.png" width="120" height="100"/></a></td>
    </tr>
    </table>
</div>
</td></tr>
<tr><td background="img/mid2.png">
<div align="center">
  
  
</select>  

    <script type="text/javascript">
     var urlmenu = document.getElementById( 'menu1' );
     urlmenu.onchange = function() {
          window.open( this.options[ this.selectedIndex ].value, '_self');
     };
    </script>
</p>
<img src="img/maintenance.png" width="300" height="300" /><br/>
<p class="style20"><strong> *INTAN sedang menaik taraf Sistem ISAC. Oleh itu segala permohonan ISAC yang BELUM DIBUKA <br/> akan ditangguhkan dan akan dibuka pada tarikh  25 MAC 2019 (ISNIN).<br/>Tarikh yang TELAH DIBUKA akan berjalan seperti biasa. <br/> Sila rujuk Portal ISAC dari masa ke semasa. </strong> </p>
  
<?php
//include('exam_schedule_kumpulan.php');
?>
  <tr><td><div style="margin-top:auto;"><img src="img/footer2.png" width="790" height="44" style="background-repeat:repeat-y" /> </div></td></tr>
</table>
</div>
</body>
</html>