<?php

$query="select keterangan_jawapan from usr_isac.pro_pilihan_jawapan where id_soalan = '$id_soalan'";
$result=mysql_query($query) or die('Error, query failed');

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
background-color: #347ff4;
background-repeat: repeat-x;
}
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #FFFFFF; font-weight: bold; font-style: italic; }
.style25 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<tr><td><table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="23%">&nbsp;</td>
      <td width="77%"><input name="jawapan_subjektif" type="text" id="jawapan_subjektif" size="50" /></td>
    </tr>
  </table></td></tr>
</body>
</html>
