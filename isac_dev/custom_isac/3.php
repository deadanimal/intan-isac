
<link href="../ims.css" rel="stylesheet" type="text/css" />
<link href="spkb_css.css" rel="stylesheet" type="text/css" />
<div id="breadcrumbs">
  <?php if($_POST["editScreen"]) echo " Edit /"?>
</div>

<?php 
include 'db.php'; 

$query = "SELECT * FROM usr_isac.pro_jawapan ";

$result = mysql_query($query) or die('SQL error');
$row= mysql_fetch_array($result,MYSQL_ASSOC);

$query1 = "SELECT KETERANGAN_JAWAPAN FROM usr_isac.prs_penilaian_peserta_jawapan ";

$result1 = mysql_query($query1) or die('SQL error');
$row1= mysql_fetch_array($result1,MYSQL_ASSOC);


?>

<?php

$file = $row1['KETERANGAN_JAWAPAN'];
$fp = fopen($file, "r") or exit("Unable to open file!");
//fclose($fp);

//while(!feof($fp))
  //{
  //echo fgets($fp). "<br />";
  //}
//$content = file($file);

?>


<br />

<table width="750" height="" border="0" align="" cellspacing="0" cellpadding="0">
  <tr>
    <td width="111" height="23">&nbsp;
	     <span class="style3">
		     ID Pengguna		 
		 </span>	
	</td>
    <td width="150">&nbsp;
	      <span class="style3">
		     Soalan		  
		  </span>	
	</td>
    <td width="132">&nbsp;
	      <span class="style3">
		      Jawapan		  
		  </span>	
	</td>
  </tr>
  
  <tr>
    <td>&nbsp;
	      <font face="Arial, Helvetica, sans-serif" size="2">
		      		  
		  </font>	
	</td>
    <td height="28">&nbsp;
	       
	</td>
    <td valign="top" align="">
	     &nbsp;&nbsp;&nbsp;<?php echo $row['SKEMA_JAWAPAN']; ?>
		 <br /><br />

		 
	</td>
  </tr>
  
  <tr>
      <td colspan="3" bgcolor="#F7F3F7">
	     <div align="right">
             <input name="Compare" type="submit" disabled="disabled" class="inputButton" id="Compare" value="Semak" />
             <input name="cancelScreenNew" type="submit" class="inputButton" value="Batal" />
         </div>
	  </td>
  </tr> 
</table>

