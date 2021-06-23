<?php

$query = "select * from FLC_REPORT order by REPORTNAME asc";
$result = $myQuery->query($query,'SELECT','NAME');

?>
<div id="breadcrumbs">Pentadbir Sistem / Report</div>
<!-- //END BREADCRUMBS SECTION -->
<!-- PAGE TITLE SECTION -->
<h1>Report</h1>
<!-- //END PAGE TITLE SECTION -->
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
<table id="tableContent" border="0" cellpadding="0" cellspacing="0" width="99%">
<tbody>
<tr>
<th colspan="4">Senarai Laporan</th></tr>
<?php

if(count($result) > 0){
echo '<tr><td class="listingHead">No</td><td class="listingHead">Nama Laporan</td></tr>';						
}

?>
</tbody>

<tbody id="tableGridLayer52271">

<?php

if(count($result) > 0){

for($q=0;$q<count($result);$q++){

	echo '<tr><td class="listingContent" width="10">'.($q+1).'</td>';
	echo '<td class="listingContent"><a href="index.php?page=report_viewer&keyid='.$result[$q][REPORTID].'">'.$result[$q][REPORTDESCRIPTION].'</td>';
	echo '</tr>';


}
}
else{

	echo '<tr><td class="listingContent" width="10">Tiada Maklumat</td>';
	echo '</tr>';

}



?>

</tbody>

</table>
</form>
