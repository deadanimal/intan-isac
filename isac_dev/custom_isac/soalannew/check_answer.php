<?php

include('../../db.php');
//include('func_page.php');

//function nak papar data vertical
function vertHorizLoop($array, $cols=3, $horiz=true)
{
// Define some defaults
$count = count($array);
if(!$horiz)
{
$sect = array();
for($i=0; $i<$cols; $i++)
$sect[$i] = array();

$max = ceil($count/$cols);
$k=0;

for($i=0; $i<$count; $i++)
{
if($i%$max==0 && $i!=0)
$k++;

$sect[$k][] = $array[$i];
}
}

//if($horiz)
//{
//for($i=0; $i<count($array); $i++)
//{
//if($i%$cols==0)
//echo '<br>';
//echo $array[$i].' ';
//}
//}
//
//else
//{
echo '<tr>';
for($i=0; $i<$max; $i++)
{



foreach($sect as $key=>$arr)
{
echo '<td>'.$arr[$i].'</td>';
}

echo '</tr>';
}
//}

}
//eof function


echo '<link rel="stylesheet" href="../custom_css.css" type="text/css" media="screen" />';

$usr = $_GET['usr'];
$page = $_GET['page'];
$app = $_GET['app'];



$mohon = "select id_permohonan,kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='".$usr."')";
$mohonRs = $myQuery->query($mohon,'SELECT');
//$id_mohon = $mohonRs[0][0];
$kod_tahap = $mohonRs[0][1];

//check semua soalan yg diambil
$query = "SELECT b.id_soalan, b.arahan_soalan,b.penyataan_soalan,c.kod_jenis_soalan,
(SELECT DESCRIPTION2 FROM REFGENERAL WHERE MASTERCODE = 
(SELECT REFERENCECODE FROM REFGENERAL WHERE DESCRIPTION1 = 'JENIS_SOALAN') and referencecode = c.kod_jenis_soalan) jenis
FROM 
usr_isac.pro_pemilihan_soalan_perincian a,
usr_isac.pro_soalan b,
usr_isac.pro_pengetahuan c
where 
a.id_soalan = b.id_soalan and
b.id_soalan = c.id_soalan and 
a.id_peserta = '$usr' and
a.id_permohonan = '$app' and a.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')
ORDER BY a.id_pemilihan_soalan_perincian";

$result = mysql_query($query) or die('Error, query failed');

while($data = mysql_fetch_array($result))
{

$id_soalan[] = $data['id_soalan'];
$arahan_soalan[] = $data['jenis'];
$soalan[] = $data['penyataan_soalan'];
$kod[] = $data['kod_jenis_soalan'];

}
/*if($_POST['submit'])
{

$user = $_POST['usr'];

$query_answer = "select * from usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b where a.id_soalan = b.id_soalan and
b.id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)
and a.id_peserta = '$user'";
$result_answer = mysql_query($query_answer) or die('Error, query failed');
$betul=0;
$salah=0;

while($data = mysql_fetch_array($result_answer))
{

	$soalan =  $data[1];
	$jawapan_peserta = $data[3];
	$keterangan = $data[4];
		
	$query_answer1 = "select a.id_pilihan_jawapan, a.skema_jawapan from  usr_isac.pro_jawapan a , usr_isac.pro_pemilihan_soalan_perincian b 
	where a.id_soalan = b.id_soalan and
	b.id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan) and a.id_soalan = '$soalan'";
	$result_answer1 = mysql_query($query_answer1) or die('Error, query failed');
	while($data1 = mysql_fetch_array($result_answer1))
	{
	 	
		$jawapan_betul = $data1[0];
		$skema_jawapan = $data1[1];
		
		if($keterangan != "")
			{
			if($jawapan_peserta == $jawapan_betul && $keterangan == $skema_jawapan ){
				$betul = $betul+1;
				
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '1' where id_peserta = '$user' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}
			else
			{
			$salah = $salah+1;
			
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '0' where id_peserta = '$user' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}
		
	}//eof while
		
		else
		{
			if($jawapan_peserta == $jawapan_betul )
			{
			$betul = $betul+1;
				
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '1' where id_peserta = '$user' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
					
			}
			else
			{
			$salah = $salah+1;
			
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '0' where id_peserta = '$user' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}

		
		}//eof else
			
	}
	
}
//jawapan_betul
$query_final_betul = "select count(distinct a.id_soalan) from  usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b where a.id_soalan = b.id_soalan and
b.id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)
and a.id_peserta = '$user' and markah='1'";
$result_final_betul = mysql_query($query_final_betul) or die('Error, query failed');

while($data2 = mysql_fetch_array($result_final_betul))
{

	$correct_answer = $data2[0];

}
//jawapan_salah
$query_final_salah = "select count(distinct a.id_soalan) from  usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b where a.id_soalan = b.id_soalan and
b.id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)
and a.id_peserta = '$user' and markah='0'";
$result_final_salah = mysql_query($query_final_salah) or die('Error, query failed');

while($data3 = mysql_fetch_array($result_final_salah))
{

	$false_answer = $data3[0];

}
*/?>

<!-- <table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="style15">
<td height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Keputusan Penilaian</span></span></div></td>
</tr> -->

<?php

/*echo "<tr><td>";
echo "<br><br><div align='center'>Keputusan anda ialah ";
echo "<strong>".$correct_answer."</strong> jawapan betul dan ";
echo "<strong>".$false_answer."</strong> jawapan salah</div><br><br>";
echo '</td></tr></table>';
*/?>

<!-- <br />
<div id="userNotification3" align="right">

<input style="margin-right:3px" onclick="window.location='isac_soalan_kemahiranA.php?id=<?php /*echo $user;*/?>'"  type="button" value="Bahagian Kemahiran" class="inputButton">

</div> -->


<?php

//}

//Bawah ni kua sebelum klik submit button

//else{

?>
<script type="text/javascript">
	  function confirmation() 
	  {
		var answer = confirm("Anda pasti telah selesai menjawab Bahagian Pengetahuan?")
		if (answer)
		{
			window.location.href = "../isac_soalan_kemahiranA.php?id=<?php echo $usr;?>&app=<?php echo $id_permohonan; ?>";
		}
	
	  }
</script>
<style type="text/css">
<!--
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8;
}
.style5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
}
.style7 {font-size: x-small}
.style8 {color: #FF0000}
.style11 {font-size: 12px}
.style13 {font-size: 10}
-->
</style>

<form action="../isac_soalan_kemahiranA.php?id=<?php echo $usr;?>&app=<?php echo $id_permohonan; ?>" method="post" name="mine" class="style2">
<div style="margin-top:-45px;"><table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="style15">
<td colspan="4" height="29"><div align="left" class="style5"><span class="style16">&nbsp;&nbsp;<span class="style14">Semakan Soalan</span></span></div></td>
</tr>

<?php
echo "<br><br>";

for($x=0;$x<count($id_soalan);$x++)
{
	
	//echo '<tr><td width="49%" align="right"><br>';
	$id_soalan1 = $id_soalan[$x];

	//check dh jawab ke blom
	$query_answer = "select * from  usr_isac.prs_penilaian_peserta_jawapan where id_soalan = '$id_soalan1' and id_peserta = '$usr' and id_permohonan='$app'";
	$result_answer = mysql_query($query_answer) or die('Error, query failed');

	if(mysql_fetch_array($result_answer)>0)
	{
	$answered = "<a href='view_soalan_main.php?page=".($x+1)."&ipp=1&usr=$usr&app=$app'><span style='color:blue;font-size:13px;'><u>Telah Dijawab</u></span></a>";
	$icon = "../green.png";
	}
	
	else
	{
	$answered = "<a href='view_soalan_main.php?page=".($x+1)."&ipp=1&usr=$usr&app=$app'><span style='color:red;font-size:13px;'><u>Belum Dijawab</u></span></a>";
	$icon = "../red.png";
	}
	$jawapan[] = "<img src='".$icon."' />  <span style='font-size:13px;'><strong>Soalan  ".($x+1)."</strong> = </span>".$answered;
	
}

// Nak Papar Check Answer 
echo '<tr><td><br><div align="center"><table cellspacing="5px" cellpadding="5px"><tr><td>';
vertHorizLoop($jawapan, 4, false); // Vertical
echo '</td></tr></table></div><br></td></tr><br>';
//eof

echo '<input type="hidden" id="usr" name="usr" value="'.$usr.'" />';
echo '<input type="hidden" id="app" name="app" value="'.$app.'" />';
?>
<tr><td><span class="style7"></span></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
</table>
<p>
</p>
<p><span class="style11"><span class="style8">&nbsp;&nbsp;* Nota</span> : Klik pada pautan &quot;<span class="style8"><u>Belum Dijawab</u></span>&quot; untuk menjawab soalan tersebut atau klik butang &quot;Hantar&quot; setelah selesai menjawab semua soalan.</span><br />
  <span class="style11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Soalan yang bertanda <img src="../green.png" /> = Telah Dijawab. <br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Soalan yang bertanda <img src="../red.png" /> = Belum Dijawab.</span></p>
<div id="userNotification3" align="right">


<input style="margin-right:3px" id="submit" name="submit" type="submit" value="Hantar" class="inputButton" onclick="confirmation()">
</div>
</form>

<?php // }?>
