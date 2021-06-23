<script type="text/javascript">

var jQ = jQuery.noConflict();
var url = "proses_jawapan.php";

jQ(function(){

	jQ('.jwpn').keyup(function(event){
	
		var id_peserta = document.getElementById('id_peserta').value;
		var id_permohonan = document.getElementById('id_permohonan').value;
		var id_soalan = document.getElementById('id_soalan').value;
		var jenis = document.getElementById('jenis').value;
		var jwpn = "";
		var id_pilihan = "";
		var masa = window.parent.parentform.document.getElementById('ParentMasa').value;

		for(var i = 0; i<document.form_jawapan.jwpn.length; i++){
			
			jwpn =document.form_jawapan.jwpn[i].value; 
			id_pilihan =  document.form_jawapan.pilihan[i].value; 		
			jQ.ajax({
				url: url,
				type: 'POST',
				data: 'jwpn='+jwpn+'&id_pilihan='+id_pilihan+'&id_peserta='+id_peserta+"&id_permohonan="+id_permohonan+"&id_soalan="+id_soalan+"&jenis="+jenis+"masa="+masa/*,
				success: function(data){
					alert(data);
				}*/
			});
			
		}
		
		
	
	});
});

</script>

<?php
$query="select a.id_pilihan_jawapan,a.keterangan_jawapan from usr_isac.pro_pilihan_jawapan a where id_soalan ='$id_soalan'";
$result=mysql_query($query) or die('Error, query failed');

?>

<form name="form_jawapan" id="form_jawapan">
<!-- hidden input to pass -->
<input type="hidden" name="id_peserta" id="id_peserta" value="<?php echo $id_peserta; ?>" />
<input type="hidden" name="id_permohonan" id="id_permohonan" value="<?php echo $id_permohonan; ?>" />
<input type="hidden" name="id_soalan" id="id_soalan" value="<?php echo $id_soalan; ?>" />
<input type="hidden" name="jenis" id="jenis" value="ranking" />
<table width="100%" border="0">

<?php
$x=0;
while ($row = mysql_fetch_array($result))
{

$jaw= $row['keterangan_jawapan'];
?>
<tr>  <td width="4%" valign="top"><p>
<input name="pilihan[<?php echo $x; ?>]" type="hidden" id="pilihan" size="5" value="<?php echo $row['id_pilihan_jawapan'];?>"/>
<input class="jwpn" name="jwpn[<?php echo $x; ?>]" type="text" id="jwpn" size="5" 

value="<?php

 $jwpn = $row['id_pilihan_jawapan'];
   
   $query_check="select keterangan_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '".$id_peserta."' and id_soalan = '".$id_soalan."' and id_jawapan = '".$jwpn."'";
   $result_check=mysql_query($query_check) or die('Error, query failed');
   
	while ($row_check = mysql_fetch_array($result_check))
	{
	
	echo $row_check['keterangan_jawapan'];
	
	
	}

?>"

/></p></td>
<td width="96%"><?php echo $row['keterangan_jawapan'];?></td>

<?php
$x++;
}
?>

</table>
</form>