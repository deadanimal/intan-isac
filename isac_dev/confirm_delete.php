<?php

$delete = $_GET['delete'];
$keyid = $_GET['keyid'];
$keyid2 = $_GET['keyid2'];
$set = $_GET['set'];

$sql = "delete from usr_isac.pro_soalan_perincian  WHERE id_soalan_perincian = ".$delete."";

$result = $myQuery->query($sql,'RUN');

$sql2 = "delete from usr_isac.pro_jawapan  WHERE id_soalan_perincian = ".$delete."";

$result2 = $myQuery->query($sql2,'RUN');

redirect('index.php?page=page_wrapper&menuID=6290&set='.$set.'&keyid='.$keyid.'&keyid2='.$keyid2);



?>