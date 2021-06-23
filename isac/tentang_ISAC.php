<?php
include ('db.php');

$query = "select tajuk,keterangan from usr_isac.pro_laman_utama where status='02' order by id ASC";
$result = mysql_query($query) or die('Error, query failed');
//$test = mysql_fetch_array($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::Tentang ISAC::</title>
<style type="text/css">
body {
	margin-top: 0%;
}
.style20 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
}
.style21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>
</head>

<body>


    <td><table width="100%" border="0">
      <tr>   
<?php
   while ($row = mysql_fetch_array ($result))
   {
   $tajuk    = $row['tajuk'];
   $keterangan = $row['keterangan'];

?>      
      </tr> 
      <tr>
      	<td><span class="style20"><br/>
   	    <?php echo $row['tajuk'];?></span></td>
      </tr>
      <tr>
       &nbsp;&nbsp;&nbsp;<td ><span class="style21"><br/>
        <?php echo $row['keterangan'];?></span></td>
     </tr> <?php }
	  ?>  
	
      </table></td>

</body>
</html>
