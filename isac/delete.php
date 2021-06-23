<?php

include('db.php');

$delete=$_GET['delete'];
$keyid = $_GET['keyid'];
$keyid2 = $_GET['keyid2'];
$set = $_GET['set'];



echo "<script type='text/javascript'>

if (confirm('Pasti untuk buang data?')){
		window.location = 'index.php?page=confirm_delete&delete=$delete&keyid=$keyid&keyid2=$keyid2&set=$set';
	}
	else{
	window.location = 'index.php?page=page_wrapper&menuID=6290&set=$set&keyid=$keyid&keyid2=$keyid2';
	}
	
</script>";


?>

