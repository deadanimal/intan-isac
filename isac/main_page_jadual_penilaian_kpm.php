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
    <table cellpadding="-3px"><div style="margin-top:-30px; margin-left:5px; position:absolute;"><a href="http://disac.intan.my/isac/main_page.php"><img border="0" src="img/home.png" width="30" height="30" /></a></div>
    <div style="margin-top:-30px; margin-left:580px; position:absolute;"><a href="http://disac.intan.my/isac/login.php?"><img border="0" src="img/login_icon3.png" width="200" height="26" /></a></div>
    <tr>
    <td><a href="http://disac.intan.my/isac/main_page_mengenai_isac.php"><img border="0" src="img/1.png" width="152" height="126" /></a></td>
    <td><a href="http://disac.intan.my/isac/login.php?mode=mohon"><img border="0" src="img/2.png" width="152" height="126" /></a></td>
    <td><a href="http://disac.intan.my/isac/main_page_jadual_penilaian.php"><img border="0" src="img/3.png" width="152" height="126"/></a></td>
    <td><a href="http://disac.intan.my/isac/login.php?mode=semak"><img border="0" src="img/4.png" width="152" height="126" /></a></td>
    <td><a href="http://disac.intan.my/isac/main_page_hubungi_kami.php"><img border="0" src="img/5.png" width="152" height="126" /></a></td>
    </tr>
    </table>
</div>
</td></tr>
<tr><td background="img/mid2.png">
<div align="center">
  <p class="style20"><strong>Jadual Penilaian ISAC Tahun 2017: Kementerian Pendidikan Malaysia</strong><br /></p>
   <p class="style20"><strong> Pilih Pusat Penilaian: </strong> 
   <select name="menu1" id="menu1">
  <option value="#">Sila Pilih</option>
  <option value="http://disac.intan.my/isac/main_page_jadual_penilaian.php">INTAN Bukit Kiara</option>
  <option value="http://disac.intan.my/isac/main_page_jadual_penilaian_jpa.php">Jabatan Perkidmatan Awam</option>
  <option value="http://disac.intan.my/isac/main_page_jadual_penilaian_kpm.php">Kementerian Pendidikan Malaysia</option>
  <option value="http://disac.intan.my/isac/main_page_jadual_penilaian_intura.php">INTURA</option>
  <option value="http://disac.intan.my/isac/main_page_jadual_penilaian_ikwas.php">IKWAS</option>
   <option value="http://disac.intan.my/isac/main_page_jadual_penilaian_intim.php">INTIM</option>
     <option value="http://disac.intan.my/isac/main_page_jadual_penilaian_sabah.php">INTAN Sabah</option>
          <option value="http://disac.intan.my/isac/main_page_jadual_penilaian_sarawak.php">INTAN Sarawak</option>
</select>  

    <script type="text/javascript">
     var urlmenu = document.getElementById( 'menu1' );
     urlmenu.onchange = function() {
          window.open( this.options[ this.selectedIndex ].value, '_self');
     };
    </script>
</p>
  <table class="tg-table-green" width="94%">
            <tr>
              <td width="31" class="style17"><p align="center"><strong>BIL.</strong></p></td>
              <td width="117" class="style17"><p align="center"><strong>TARIKH    <br />
              PENILAIAN</strong></p></td>
              <td width="190" class="style17"><p align="center"><strong>SESI<br />
PENILAIAN</strong></p></td>
              <td width="156" class="style17"><p align="center"><strong>PUSAT    <br />
              PENILAIAN</strong></p></td>
              <td width="115" class="style17"><p align="center"><strong>STATUS    PERMOHONAN</strong></p></td>
              <td width="140" class="style17"><p align="center"><strong>TARIKH  PERMOHONAN DIBUKA</strong></p></td>
            </tr>
            <tr>
              <td><p align="center">1</p></td>
              <td><p align="center">17 Februari 2017<br />
              (Jumaat)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
              Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td valign="middle"><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"><strong>BELUM DIBUKA</strong><br>
                          </p></td>
              <td><p align="center">1 Feb     2017</p></td>
            </tr>
            <tr>
              <td><p align="center">2</p></td>
              <td><p align="center">15 Mac 2017<br />
              (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
              Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td valign="middle"><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"><strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">28 Februari    2017</p></td>
            </tr>
            <tr>
              <td><p align="center">3</p></td>
              <td><p align="center">19 April 2017 <br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"><strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">10 Mac  2017</p></td>
            </tr>
            <tr>
              <td><p align="center">4</p></td>
              <td><p align="center">17 Mei 2017<br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"> <strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">11 April 2017</p></td>
            </tr>
			<tr>
              <td><p align="center">5</p></td>
              <td><p align="center">10 Julai 2017<br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"> <strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">4 Jun 2017</p></td>
            </tr>
			<tr>
              <td><p align="center">6</p></td>
              <td><p align="center">7 Ogos 2017<br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"> <strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">11 Julai 2017</p></td>
            </tr>
			<tr>
              <td><p align="center">7</p></td>
              <td><p align="center">11 September 2017<br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"><strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">8 Ogos 2017</p></td>
            </tr>
            <tr>
              <td><p align="center">8</p></td>
              <td><p align="center">9 Oktober 2017<br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"><strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">12 September 2017</p></td>
            </tr>
			<tr>
              <td><p align="center">9</p></td>
              <td><p align="center">6 November 2017<br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"><strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">10 Oktober  2017</p></td>
            </tr>
			<tr>
              <td><p align="center">10</p></td>
              <td><p align="center">4 Disember 2017<br />
                (Rabu)</p></td>
              <td valign="top"><p align="center">Sesi 1: 9.30 &ndash; 10.30 pagi<br />
                Sesi 2: 3.00 &ndash; 4.00 petang</p></td>
              <td><p align="center">Kementerian Pendidikan Malaysia</p></td>
              <td><p align="center"><strong>BELUM DIBUKA</strong></p></td>
              <td><p align="center">7 November 2017</p></td>
            </tr>
          
          </table>
</div>
<?php
//include('exam_schedule_kumpulan.php');
?>
  <tr><td><div style="margin-top:auto;"><img src="img/footer2.png" width="790" height="44" style="background-repeat:repeat-y" /> </div></td></tr>
</table>
</div>
</body>
</html>