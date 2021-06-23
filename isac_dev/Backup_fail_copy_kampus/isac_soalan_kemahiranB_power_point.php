<?php
//include ('process_internet.php');
//user session
//$usr = $_GET['usr'];
include ('../db.php');
$usr = $_GET['id'];
echo $app = $_GET['app'];
echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';

//include ('../macroppt.html');


$set = "select kod_set_soalan from usr_isac.pro_pemilihan_set_kemahiran where id_peserta = '$usr' and id_permohonan = '$app'";
$set_soalan = mysql_query($set) or die('Error, query failed');
$setRs = mysql_fetch_array($set_soalan);

//bahagian B1
$arahan = "select distinct a.arahan_umum,
			(SELECT description1 FROM isac.refgeneral 
			WHERE
			mastercode=(SELECT referencecode
			FROM isac.refgeneral where mastercode='XXX' 
			AND description1='BAHAGIAN_SOALAN') 
			AND
			referencestatuscode='00'
			AND referencecode=a.kod_bahagian_soalan) as 'bahagian_soalan',a.kod_bentuk_soalan
			from usr_isac.pro_kemahiran a,
			usr_isac.pro_pemilihan_set_kemahiran b
			where 
			a.kod_set_soalan = b.kod_set_soalan
			and a.kod_bahagian_soalan = '02'
			and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
//$arahanRs = $myQuery->query($arahan,'SELECT');
$arahan_soalan = mysql_query($arahan) or die('Error, query failed');
$arahanRs = mysql_fetch_array($arahan_soalan);
//echo $setRs [0][0];

$soalan = "select distinct c.id_soalan,c.arahan_soalan,c.penyataan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '02' 
					and b.id_peserta = '$usr' and b.id_permohonan = '$app' order by id_soalan asc";
$soalan_b = mysql_query ($soalan) or die ('Error, query failed');
//$soalan_aRs = mysql_fetch_array ($soalan_a);

$a = "select distinct c.arahan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '02'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
$ab = mysql_query ($a) or die ('Error, query failed');
$abc = mysql_fetch_array ($ab);

//arahan
$arahan2 = "select distinct a.arahan_umum,
			(SELECT description1 FROM isac.refgeneral 
			WHERE
			mastercode=(SELECT referencecode
			FROM isac.refgeneral where mastercode='XXX' 
			AND description1='BAHAGIAN_SOALAN') 
			AND
			referencestatuscode='00' 
			AND referencecode=a.kod_bahagian_soalan) as 'bahagian_soalan',a.kod_bentuk_soalan
			from usr_isac.pro_kemahiran a,
			usr_isac.pro_pemilihan_set_kemahiran b
			where 
			a.kod_set_soalan = b.kod_set_soalan
			and a.kod_bahagian_soalan = '03'
			and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
//$arahanRs = $myQuery->query($arahan,'SELECT');
$arahan_soalan2 = mysql_query($arahan2) or die('Error, query failed');
$arahanRs2 = mysql_fetch_array($arahan_soalan2);
//echo $setRs [0][0];

$soalan2 = "select distinct c.id_soalan,c.arahan_soalan,c.penyataan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '03'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app' order by id_soalan asc";
$soalan_b2 = mysql_query ($soalan2) or die ('Error, query failed');
//$soalan_aRs = mysql_fetch_array ($soalan_a);

$a2 = "select distinct c.arahan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '03'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
$ab2 = mysql_query ($a2) or die ('Error, query failed');
$abc2 = mysql_fetch_array ($ab2);

?>
<?php
//include ('db.php');

$id_peserta =$_GET['id'];
$app = $_GET['app'];

$ic = "select no_kad_pengenalan from usr_isac.pro_peserta where id_peserta='".$id_peserta."'";
$icRs = $myQuery->query($ic,'SELECT');
$ic_no = $icRs[0][0];

//path file
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='1'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//server IP
$location = $path_nameRs[0][1];

//Powerpoint2007
$file = $path_nameRs[0][3];
//kemahiran
//$folder = $path_nameRs[0][2];


//utk power point,  x blh run macro dlm format file lain accept ".pptm"
$path = 'kemahiran/';
$fileSrc = $file.'.mht';
$fileDest = $file.'_'.$ic_no.'_'.date('Ymd').'.mht';
$ans_file = $path.$fileDest; 
//echo $ans_file;

/*$fileSrc = 'Word2007.mht';
$path = 'kemahiran/';
$location = '192.168.2.7';
$fileDest = 'Word2007_'.$_GET['id'].'_'.date('Ymd').'.mht';
*/
//copy file and rename
copy($path.$fileSrc,$path.$fileDest);

//check if file already exist
$sql_check = "select * from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta = '".$id_peserta."' and id_permohonan = '".$app."' and kod_bahagian_soalan='03'";
$result_check = $myQuery->query($sql_check,'SELECT');

	if(count($result_check) == 0)
	{
	
	//insert path file jawapan peserta
	$sql = "insert into usr_isac.prs_penilaian_peserta_kemahiran (id_peserta,id_permohonan,fail_jawapan_peserta,kod_bahagian_soalan,status_push_pull) values ('".$id_peserta."','".$app."','".$ans_file."','03','I')";
	$result = $myQuery->query($sql,'RUN');
	}

//page process_power_point.php for power point processing n scoring.

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
/*background-color: #347ff4;*/
background-repeat: repeat-x;
}
.style3 {
	color: #FFFFFF;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
.style17 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #FF0000;
}
.style24 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style31 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style33 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; }
-->
</style>

<script type="text/javascript">
function confirmation() 
{
	var answer = confirm("Anda pasti telah selesai menjawab Bahagian B?")
	if (answer)
	{
		window.location.href = "isac_soalan_kemahiranC2.php?id=<?php echo $usr;?>&app=<?php echo $app;?>";
	}
	
}
</script>
<script>
var myApp = new ActiveXObject("PowerPoint.Application");
var obj;
if (myApp != null)
{
myApp.Visible = true;
obj=myApp.Presentations.Open("\\\\<?php echo $location;?>\\htdocs\\isac\\custom_isac\\kemahiran\\<?php echo $fileDest;?>");
obj=myApp.Run ("\\\\<?php echo $location;?>\\htdocs\\isac\\Macro_PowerPoint.ppt!Module1.ResizeWindow");
}
//this.close();

/*//resizing power point
      MsgBox "ppt window will be resized after clicking OK button"
      Dim PPT
      Set PPT = CreateObject("PowerPoint.Application")

      PPT.Presentations.Open "\\\\192.168.2.7\\xampp\\htdocs\\isac\\TestMacro.ppt", , , False
      PPT.Run "TestMacro.ppt!Module1.ResizeWindow"
*/
</script>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr class="style15">
    <td height="29"><div align="center"><span class="style3">SOALAN ISAC BAHAGIAN KEMAHIRAN</span></div>
        <div align="left"></div></td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
      <tr>
        <td><table width="98%" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2"><div align="center" class="style31"><strong>SET </strong><?php echo $setRs['kod_set_soalan'];?></div></td>
            </tr>
            <tr>
              <td height="19" colspan="2">&nbsp;</td>
            </tr>
   
            <tr>
              <td height="27" colspan="2"><p class="style24"><strong class="style31"><u>B2) Soalan &nbsp;<?php echo $arahanRs2['kod_bentuk_soalan'];?></u></strong></p></td>
            </tr>
            <tr>
              <td height="27" colspan="2"><p class="style24"><span class="style33"><?php echo $abc2['arahan_soalan'];?></span></p></td>
            </tr>
            <tr>
              <td height="19" colspan="2"><p class="style24">&nbsp;</p></td>
            </tr>
            <?php
		   while ($row2 = mysql_fetch_array ($soalan_b2))
		{
		   $id_soalan     = $row2['id_soalan'];
		   $arahan_soalan = $row2['penyataan_soalan']; 
		   ?>
            <tr>
              <td width="3%" height="27">&nbsp;</td>
              <td width="97%" height="27"><span class="style33">
                <?php //echo $row['id_soalan'];
			echo $row2['penyataan_soalan'];
			   
			$perincian2 = "select penyataan_soalan_perincian from usr_isac.pro_soalan_perincian where id_soalan = '$id_soalan'";
			$perincian_b2 = mysql_query ($perincian2) or die ('Error, query failed');
			while ($data2 = mysql_fetch_array ($perincian_b2))
			{
			echo $data2['penyataan_soalan_perincian'];
			?>
                <?php } ?>
                <p></p>
                <?php } ?>
              </span></td>
            </tr>
          <tr>
              <td height="27">&nbsp;</td>
            <td height="27">&nbsp;</td>
          </tr>
            <tr>
              <td height="27" colspan="2"><hr size="2" width="100%" align="center" /></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>
         <!-- <input style="margin-right:3px" onclick="window.open('../powerpoint.php?id=<?php /*echo $usr;*/ ?>','')"  type="button" value="Microsoft Power Point" class="inputButton" /> -->
   
        <div id="userNotification3" align="right"><span class="style17">*  Nota : Sila tekan butang 'Tutup' setelah selesai menjawab bahagian ini.</span>
           <input style="margin-right:3px" onclick="window.close()" type="button" value="Tutup" class="inputButton" />
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>

<br />
</body>
</html>


