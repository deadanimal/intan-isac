<script type="text/javascript">

		function clickJawapan(){
			
			var masa = window.parent.parentform.document.getElementById('ParentMasa').value;
			document.getElementById('masa').value = masa;
			
			var jQ = jQuery.noConflict();
			var url = "proses_jawapan.php";
			jQ.ajax({
				   type: "POST",
				   url: url,
				   data: jQ("#form_jawapan").serialize()/*,
				   
				   success: function(data)
				   {
					   alert(data); // show response from the php script.
				   }*/
			});
			return false;
		}


</script>

<?php

$mohon = "select id_permohonan,kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='$id_peserta')";
$mohonRs = $myQuery->query($mohon,'SELECT');
$id_mohon = $mohonRs[0][0];
$kod_tahap = $mohonRs[0][1];

$query="select id_pilihan_jawapan,keterangan_jawapan from usr_isac.pro_pilihan_jawapan where id_soalan = '$id_soalan'";
$result=mysql_query($query) or die('Error, query failed');

$query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$id_peserta' and id_permohonan='$id_mohon' and id_soalan = '$id_soalan'";
$result_check=mysql_query($query_check) or die('Error, query failed');

while($data = mysql_fetch_array($result_check))
{
	$jwpn = $data[0];
}

?>
<form id="form_jawapan">
<div id="div_jawapan">
<!-- hidden input to pass -->
<input type="hidden" name="id_peserta" id="id_peserta" value="<?php echo $id_peserta; ?>" />
<input type="hidden" name="id_permohonan" id="id_permohonan" value="<?php echo $id_permohonan; ?>" />
<input type="hidden" name="id_soalan" id="id_soalan" value="<?php echo $id_soalan; ?>" />
<input type="hidden" name="jenis" id="jenis" value="single" />
<input type="hidden" name="masa" id="masa" value="" />

<?php
while ($row = mysql_fetch_array($result))
{
	$id= $row['id_pilihan_jawapan'];
	$jaw= $row['keterangan_jawapan'];
?>

 	<table cellpadding="10px">
        <tr>
            <td valign="top">
                
                
                <!-- radio button -->
                <input type="radio" name="jwpn" id="jwpn" onClick="clickJawapan()"
                <?php if($jwpn == $row['id_pilihan_jawapan']){echo "checked"; } ?> 
                value="<?php echo $row['id_pilihan_jawapan'];?>" />
            </td>
            <td valign="top">
            	<!-- jawapan -->
                <?php echo $row['keterangan_jawapan'];?>
            </td>
        </tr>
       </table>
 
<?php
}
?>

</div>
</form>

