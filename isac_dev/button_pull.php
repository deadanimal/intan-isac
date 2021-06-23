<?php
include('db.php');

$iac = $_POST['iac'];

$keterangan_iac="select description1
from ISAC.REFGENERAL
where mastercode = (select referencecode from ISAC.REFGENERAL
where description1 = 'IAC') and referencestatuscode='00'
and REFERENCECODE = '$iac'"; 
$result = $myQuery->query($keterangan_iac,'SELECT','NAME');

$keterangan_iac = $result[0]['DESCRIPTION1'];

/*// select dropdown iac
$iac = "select referencecode, description1
from ISAC.REFGENERAL
where mastercode = (select referencecode from ISAC.REFGENERAL
where description1 = 'IAC')";
$result = $myQuery->query($iac,'SELECT','NAME');*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
-->
</style>
</head>

<body o>
<table width="50%">
  <tr>
    <td width="15%"><span class="style1"> From IAC :</span></td>
    <td width="85%">
      <span class="style2">
      <input name="iac" type="hidden" id="iac" value="<?php echo $iac; ?>" />
      <?php echo $iac; ?>        
      <label><?php echo $keterangan_iac; ?></label>
    </span></td>
  </tr>
</table>
<p>&nbsp;</p>
<label></label>
<input type="button" name="button" id="button" value="Pull" onclick="window.location='pull_penilaian.php?iac=<?php echo $iac;?>'" />
  <input type="button" name="button" id="button" value="Back" onclick="history.go(-1)" />
</body>
</html>
