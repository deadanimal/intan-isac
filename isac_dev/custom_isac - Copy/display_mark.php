<?php

include('../db.php');
include('func_page.php');
echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';

$usr = $_GET['usr'];
$page = $_GET['page'];
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
id_peserta = '$usr' and id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)
ORDER BY id_pemilihan_soalan_perincian";

$result = mysql_query($query) or die('Error, query failed');

while($data = mysql_fetch_array($result))
{

$id_soalan[] = $data['id_soalan'];
$arahan_soalan[] = $data['jenis'];
$soalan[] = $data['penyataan_soalan'];
$kod[] = $data['kod_jenis_soalan'];

}
if($_POST['submit'])
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
		
		if($keterangan != ""){
		
			if($jawapan_peserta == $jawapan_betul && $keterangan == $skema_jawapan ){
				$betul = $betul+1;
				
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '1' where id_peserta = '$user' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}
			else{
				$salah = $salah+1;
				
				$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '0' where id_peserta = '$user' and id_soalan = '$soalan'";
				$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}
		
		}
		
		else{
				if($jawapan_peserta == $jawapan_betul ){
				$betul = $betul+1;
				
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '1' where id_peserta = '$user' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
					
			}
			else{
				$salah = $salah+1;
				
				$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '0' where id_peserta = '$user' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}

		
		}
		
		
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
?>

<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="style15">
<td height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Keputusan Penilaian</span></span></div></td>
</tr>

<?php

echo "<tr><td>";
echo "<br><br><div align='center'>Keputusan anda ialah ";
echo "<strong>".$correct_answer."</strong> jawapan betul dan ";
echo "<strong>".$false_answer."</strong> jawapan salah</div><br><br>";
echo '</td></tr></table>';
?>

<br />
<div id="userNotification3" align="right">

<input style="margin-right:3px" onclick="window.location='isac_soalan_kemahiranA.php?id=<?php echo $user;?>'"  type="button" value="Bahagian Kemahiran" class="inputButton">

</div>


<?php

}

//Bawah ni kua sebelum klik submit button

else{

?>
<form action="check_answer.php" method="post" name="mine">
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="style15">
<td colspan="4" height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Semakan Jawapan</span></span></div></td>
</tr>

<?php
echo "<br><br>";

for($x=0;$x<count($id_soalan);$x++){
echo '<tr><td width="49%" align="right"><br>';
$id_soalan1 = $id_soalan[$x];

//check dh jawab ke blom
$query_answer = "select * from  usr_isac.prs_penilaian_peserta_jawapan where id_soalan = '$id_soalan1' and id_peserta = '$usr'";
$result_answer = mysql_query($query_answer) or die('Error, query failed');
if(mysql_fetch_array($result_answer)>0){

$answered = "<a href='soalan_perincian1.php?page=".($x+1)."&submit=true&usr=$usr'><span style='color:blue'>Telah Dijawab</span></a>";
$icon = "green.png";
}
else{
$answered = "<a href='soalan_perincian1.php?page=".($x+1)."&submit=true&usr=$usr'><span style='color:red'>Belum Dijawab</span></a>";
$icon = "red.png";
}

echo "<img src='".$icon."' />&nbsp;";
echo 'Soalan <td><br>&nbsp;'.($x+1).'</td>';
echo "</td><td align='center'><br>";
echo '  =  ';
echo "</td><td width='49%' align='left'><br>&nbsp;";
echo $answered;
//echo '<br>';

echo '</td></tr>';
}
echo '<tr><td><br></td></tr>';

echo '<input type="hidden" id="usr" name="usr" value="'.$usr.'" />';
?>

</table>

<br />
<div id="userNotification3" align="right">

<input style="margin-right:3px" onclick="history.go(-1)"  type="button" value="Kembali" class="inputButton">
<input style="margin-right:3px" id="submit" name="submit" type="submit" value="Hantar" class="inputButton">

</div>
</form>

<?php }?>
