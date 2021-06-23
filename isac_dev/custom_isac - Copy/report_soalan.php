<style type="text/css">
<!--
.style2 {font-family: Arial, Helvetica, sans-serif; font-size: 18px;}
.style9 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<span class="style2">Senarai Soalan Dan Pilihan Jawapan</span><br><br>
<span class="style9"><?php 
include('../db.php');
echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';

function find_answer($id_soalan,$jenis_soalan){
	
	//query untuk jawapan yg betul
	$q_jsbnr = "select skema_jawapan,id_pilihan_jawapan from usr_isac.pro_jawapan where id_soalan = '$id_soalan'";
	$r_jsbnr = mysql_query($q_jsbnr) or die('Error, query failed');
	//eof query
	
	//query untuk papar semua jawapan
	$query_jawapan = "select keterangan_jawapan,id_pilihan_jawapan from usr_isac.pro_pilihan_jawapan where id_soalan = '$id_soalan'";
	$result_jawapan = mysql_query($query_jawapan) or die('Error, query failed');
	//eof query
	
	
	if($jenis_soalan == '01'){ /* single choice */
		
		while($data3 = mysql_fetch_array($r_jsbnr))
		{
		   $ans1 = $data3['id_pilihan_jawapan'];
		}	
		
		$input = "<input type='radio' name='jwpn_".$id_soalan."'  id='jwpn_".$id_soalan."'>";
		
	
	}
	else if($jenis_soalan == '02'){ /* multiple choice */
		
		$input = '<input type="checkbox" name="checkbox_$id_soalan" id="checkbox_$id_soalan" />';
	
	}
	else if($jenis_soalan == '05'){ /* ranking*/
		
		$input = '<input name="textfield" type="text_$id_soalan" id="textfield_$id_soalan" size="5" />';
		$input2 = '</input>';
		
	}
	
	
	
	echo '<table class="style9" style="margin-left:30px">';
	while($data2 = mysql_fetch_array($result_jawapan))
	{
		$id_pilihan_jawapan = $data2['id_pilihan_jawapan'];
		
		echo '<tr><td valign="top">'.$input.'</td><td>'.str_replace('<p>','',$data2['keterangan_jawapan']).''.$input2.'</td></tr>';
	}
	
	
	
	
	
	
	if($jenis_soalan == '03'){
		
		while($data3 = mysql_fetch_array($r_jsbnr))
		{
		   $ans = $data3['skema_jawapan'];
		}
		
		echo '<tr><td width="3%"><input name="jwpn_'.$id_soalan.'" id="jwpn_'.$id_soalan.'" type="radio" value="01" ';if($ans == '01'){echo 'checked';}
		echo '/></td>
                   <td width="97%"><strong>Betul</strong></td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td><em>True</em></td>
                 </tr>
                 <tr>
                   <td><input name="jwpn_'.$id_soalan.'" id="jwpn_'.$id_soalan.'" type="radio" value="02" ';if($ans == '02'){echo 'checked';}
				   echo '/></td>
                   <td><strong>Salah</strong></td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td><em>False</em></td></tr>';
	}
	
	
	echo '</table>';
	
}


$query = "SELECT @rownum:=@rownum+1 as 'bil', b.id_soalan,b.penyataan_soalan,c.kod_jenis_soalan
		FROM 	
		usr_isac.pro_soalan b,
		usr_isac.pro_pengetahuan c, (SELECT @rownum:=0) r 
		where b.id_soalan = c.id_soalan";

		$result = mysql_query($query) or die('Error, query failed');
		
		echo "<table class='style9' id='tableContent2' cellspacing='0' cellpadding='5' border='1' width='100%'>";
		echo "<tr><td class='tb_report_h'><strong>Bil</strong></td><td class='tb_report_h'><strong>Soalan & Jawapan</strong></td></tr>";
		
		while($data = mysql_fetch_array($result))
		{
			if($data['penyataan_soalan'] != ""){
				
				echo "<tr><td class='tb_report' valign='top' align='center'>";
				echo '<strong>'.$data['bil'].'</strong>';
				echo "</td><td class='tb_report'>";
				echo $data['penyataan_soalan'];
				find_answer($data['id_soalan'],$data['kod_jenis_soalan']);
				echo "</td></tr>";
			
			}
		}
		
		echo "</table>";


?>
</span><span class="style9"></span>