<style type="text/css">
<!--
#userNotification2{
	border: 1px solid #cad7e8;
	font-size: 0.9em;
	padding: 3px 0px 3px 0px;
	width:99%;
	margin-bottom:10px;
	font-weight:bold;
	background-color:#fafbf6;
}

#userNotification3{
	border: 1px solid #cad7e8;
	font-size: 0.9em;
	padding: 3px 0px 3px 0px;
	width:99%;
	margin-bottom:10px;
	margin-left:5px;
	font-weight:bold;
	background-color:#fafbf6;
}


.inputInput, .inputInput, .w8em{
	font-family:"Trebuchet MS", Verdana, Arial;
	padding: 1px;
	border: 1px solid #CCCCCC;
	font-size: 12px;
	margin-right:3px;
}

#tableContent{
	border:1px solid #B3C5D7;
	margin-left: 5px;
	width:99%;						/* addded cikkim 20080707. kalo problem buang jer. */
}

.style14 {font-size: 12px}

.inputButton
{
	font-family:"Trebuchet MS"; 
	font-size:12px; 
	color:#333333; 
	padding: 0px 2px 0px 2px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}

.style15
{
text-align: center;
padding-top: 2px;
padding-right: 0px;
padding-bottom: 2px;
padding-left: 0px;
background-color: #e8a20c;
background-repeat: repeat-x;
}
.style16 {
	font-size: 14px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
.style39 {font-size: small}
.jawapan{
margin-left:50px;

}
.style44 {font-family: Arial, Helvetica, sans-serif}
.style45 {font-weight: bold; font-size: 14px;}
.style46 {vertical-align:top; color: #000000;}
.style47 {color: #000000; vertical-align:top; font-size: small;}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #FF9900;
}
a:active {
	text-decoration: none;
	color: #FF9900;
}


.style49 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style>



<?php
include('../db.php');
include('func_page.php');


$query = "SELECT b.id_soalan, b.arahan_soalan,b.penyataan_soalan,c.kod_jenis_soalan,
(SELECT DESCRIPTION2 FROM REFGENERAL WHERE MASTERCODE = (SELECT REFERENCECODE FROM REFGENERAL WHERE DESCRIPTION1 = 'JENIS_SOALAN') and referencecode = c.kod_jenis_soalan) jenis

FROM 

usr_isac.pro_pemilihan_soalan_perincian a,
usr_isac.pro_soalan b,
usr_isac.pro_pengetahuan c

where 

a.id_soalan = b.id_soalan and
b.id_soalan = c.id_soalan and 
id_peserta = 50 and id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)

ORDER BY id_pemilihan_soalan_perincian";

$result = mysql_query($query) or die('Error, query failed');

while($data = mysql_fetch_array($result))
{

$id_soalan[] = $data['id_soalan'];
$arahan_soalan[] = $data['jenis'];
$soalan[] = $data['penyataan_soalan'];
$kod[] = $data['kod_jenis_soalan'];

}



//Getting currect page.
if(!isset($_GET['page'])){
$page = 1;
}
else{
$page = $_GET['page'];
 }
 
 $prev_page = $page - 1;
 $next_page = $page + 1;
 
//Applying pagination.
$pagination = pagination_array($arahan_soalan, $soalan, $kod, $id_soalan, $page, "?page=");
$last_page = $pagination['last'];
 
//Page link panel.
//echo $pagination['panel'];
 
 
$page_offset = ($page - 1) * 1;
?>

<input id="sesi2"  type="text"/>
<?php
echo '<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">';



for($x=0;$x<sizeof($pagination['arahan_soalan']);$x++){

$arahan_soalan= $pagination['arahan_soalan'][$x+$page_offset];
$soalan= $pagination['soalan'][$x+$page_offset];
$kod= $pagination['kod'][$x+$page_offset]; 
$id_soalan= $pagination['id_soalan'][$x+$page_offset];


?>
<tr class="style15">
     <td height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Arahan <em>(Instruction)</em> : <?php echo $arahan_soalan; ?></span></span></div></td>
   </tr>
   <tr>
     <td height="29"><table width="100%" border="0">
       <tr>
         <td><form id="form1" name="form1" method="post" action="">
           <span class="style44">
           <table width="100%" border="0" cellspacing="0">
           </span>
           <tr>
             <!--<td width="34" align="center" bgcolor="" class="style44"><span class="style45">No.</span></td>
             <td width="1271" align="center" bgcolor="" class="style44"><span class="style45">Soalan (<em>Question</em>)</span></td>-->
             </tr>
<tr>
               <td bgcolor="" class="style44"><p><div align="center" class="style39"><span class="style46"><?php echo $page; ?>&nbsp;</span></div></td>
               <td bgcolor="" class="style44"><span class="style47">&nbsp;<?php echo $soalan; ?></span></td>
		   </tr>

<tr>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="6%" class="style44">&nbsp;</td>
    <td width="94%" class="style44"><?php
if($kod == '01'){include('jawapan_single.php');}
elseif($kod == '02'){include('jawapan_multiple.php');}
elseif($kod == '03'){include('jawapan_tof.php');}
elseif($kod == '04'){include('jawapan_fib.php');}
elseif($kod == '05'){include('jawapan_ranking.php');}
elseif($kod == '06'){include('jawapan_sub.php');}
echo '</div></tr>';

} 
echo '</table>';

 echo '<br>';
  echo '<br>';
//Page link panel.


?></td>
  </tr>
</table>
</tr><tr>
<td colspan="2" bgcolor="#F7F3F7"><div align="right" class="style49">
		<?php
			if($page != 1){
			echo '<span><a href="http://192.168.2.7:8080/isac/custom_isac/soalan_perincian1.php?page='.$prev_page.'"><< Kembali</a></span>
			&nbsp;&nbsp;';
			}
			if($page != $last_page){
			echo '<span><a href="http://192.168.2.7:8080/isac/custom_isac/soalan_perincian1.php?page='.$next_page.'">Seterusnya >></a></span>
			&nbsp;&nbsp;';
			}
			
		?>
          
        
        </div></td>

</tr></table>   
       <?php
 echo '<br>';
echo '   <div align="center" id="userNotification3">'.$pagination['panel'].'</div>';


?>
