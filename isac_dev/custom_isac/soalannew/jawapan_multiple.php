<script type="text/javascript">

var jQ = jQuery.noConflict();
var url = "proses_jawapan.php";

jQ(function(){

	jQ('.checkbox').change(function(event){
	
		var id_peserta = document.getElementById('id_peserta').value;
		var id_permohonan = document.getElementById('id_permohonan').value;
		var id_soalan = document.getElementById('id_soalan').value;
		var jenis = document.getElementById('jenis').value;
		var masa = window.parent.parentform.document.getElementById('ParentMasa').value;
		
		checked_value = jQ(this).val();
		if(this.checked)
		{
			jQ.ajax({
				url: url,
				type: 'POST',
				data: 'jwpn='+checked_value+'&check=1&id_peserta='+id_peserta+"&id_permohonan="+id_permohonan+"&id_soalan="+id_soalan+"&jenis="+jenis+"&masa="+masa/*,
				success: function(data){
					alert(data);
				}*/
			});
		}

		if( !this.checked )
		{
			jQ.ajax({
				url: url,
				type: 'POST',
				data: 'jwpn=' + checked_value  + '&check=0&id_peserta='+id_peserta+"&id_permohonan="+id_permohonan+"&id_soalan="+id_soalan+"&jenis="+jenis+"&masa="+masa/*
				success: function(data){
					alert(data);
				}*/
			});
		}
	});
});

</script>
<?php

$query="select id_pilihan_jawapan,keterangan_jawapan from usr_isac.pro_pilihan_jawapan where id_soalan = '$id_soalan'";
$result=mysql_query($query) or die('Error, query failed');

$mohon = "select id_permohonan,kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='$id_peserta')";
$mohonRs = $myQuery->query($mohon,'SELECT');
$id_mohon = $mohonRs[0][0];
$kod_tahap = $mohonRs[0][1];

?>

  <!-- hidden input to pass -->
  <input type="hidden" name="id_peserta" id="id_peserta" value="<?php echo $id_peserta; ?>" />
  <input type="hidden" name="id_permohonan" id="id_permohonan" value="<?php echo $id_permohonan; ?>" />
  <input type="hidden" name="id_soalan" id="id_soalan" value="<?php echo $id_soalan; ?>" />
  <input type="hidden" class="checkbox" name="jenis" id="jenis" value="multiple" />
  <table cellpadding="10px">
    <?php
while ($row = mysql_fetch_array($result))
{
	$jaw= $row['keterangan_jawapan'];
?>
    <tr>
      <td width="3%" valign="top"><p>
          <input type="checkbox" class="checkbox" name="jwpn" id="jwpn" 
  
   <?php 
   $jwpn = $row['id_pilihan_jawapan'];

   $query_check="select id_jawapan from usr_isac.prs_penilaian_peserta_jawapan where id_peserta = '$id_peserta' and id_permohonan='$id_mohon' and id_soalan = '$id_soalan' and id_jawapan = '$jwpn'";
   $result_check=mysql_query($query_check) or die('Error, query failed');
   
   if(mysql_fetch_array($result_check)>0){
   		echo "checked";
   }
   
   ?> 
  
  value="<?php echo $row['id_pilihan_jawapan'];?>"/>
        </p></td>
      <td width="97%"><?php echo $row['keterangan_jawapan'];?></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php
}
?>
    </tr>
    
  </table>

