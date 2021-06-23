<?php
include ('db.php');;
//AccessDenied();

//session_start();
//ob_start();
/*if($_GET['Search']=='Search'){
	$id_officer= $_GET['id_officer'];

	$result = mysql_query("SELECT * FROM `officer` WHERE id_officer='$id_officer'" );

		if(mysql_fetch_array($result)){
			header("Location: edit_officer.php?id_officer=$id_officer");
		}

			else{ 
			echo "<script language=javascript>alert('User ID cannot found!!'); </script>";
 			//header("Location:info.php");
				
			}

}*/
//$result=mysql_query("SELECT * FROM officer ORDER BY id_officer DESC");
?>

<script type="text/javascript">/*NO LOWERCASE CONTROL*/
function upperCase(x)
{
var y=document.getElementById(x).value;
document.getElementById(x).value=y.toUpperCase();
}
</script>
<script type="text/javascript">/*NO EMPTY SPACE CONTROL*/
function noSpace(e)
{
var snum;
var schar;
var scheck;

if(window.event) // IE
	{
	snum = e.keyCode;
	}
else if(e.which) // Netscape/Firefox/Opera
	{
	snum = e.which;
	}
schar = String.fromCharCode(snum);
scheck = /\s/;
return !scheck.test(schar);
}
</script>

<link href="font.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	margin-left: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
}
a:link {
	color: #F29422;
}
a:visited {
	color: #F29422;
}
a:hover {
	color: #FF0000;
}
a:active {
	color: #FF0000;
}
.bttn1 {BORDER-RIGHT: black 1px solid;
BORDER-TOP: black 1px solid;
BORDER-LEFT: black 1px solid;
COLOR: #990000;
font-weight: bold;
BACKGROUND: #999999;
BORDER-BOTTOM: black 1px solid;
                       
   
height: 18px;font-family: verdana;font-size: 9px;
cursor:hand;
}
.style50 {color: #FFFFFF}
.style56 {font-size: 11px}
.style59 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style63 {color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.style64 {font-family: Arial, Helvetica, sans-serif}
.style66 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style67 {font-size: 12px}
.style68 {
	font-size: 10px;
	font-weight: bold;
}
.style76 {	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FF0000;
	font-size: 14px;
}
.style79 {color: #000000}

-->
</style>
<?php
//include "func.php";
//AccessDenied();

//limit row data per page	
$rowsPerPage =10; 
$pageNum = $_REQUEST['page']; 

//$army_no=$_POST["army_no"];
//$rank=$_POST["rank"];
// if they have come from another page then adjust the settings for this page
if(empty($pageNum))
{
$offset = 0;
$pageNum=1;
}
else
{

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
}

$query = "SELECT (SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral WHERE mastercode='XXX' 
				AND description1='TAHAP') 
				AND
				referencestatuscode='00' 
				AND referencecode=kod_tahap) as TAHAP,
				date_format(tarikh_sesi,'%d-%m-%Y') as TARIKH,
				concat(
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='masa_mula') 
				AND
				referencestatuscode='00' 
				AND referencecode=kod_masa_mula),
				'-',
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='masa_tamat') 
				AND
				referencestatuscode='00' 
				AND referencecode=kod_masa_tamat)) AS MASA,
				
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='SESI_PENILAIAN') 
				AND
				referencestatuscode='00' 
				AND referencecode=kod_sesi_penilaian) AS SESI,
			
				(SELECT description1 FROM isac.refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM isac.refgeneral WHERE mastercode='XXX' 
				AND description1='iac') 
				AND
				referencestatuscode='00' 
				AND referencecode=kod_iac) as IAC,
				
				Lokasi as 'LOKASI' 
				
				FROM usr_isac.pro_sesi WHERE kod_kategori_peserta='02'" .
				" ORDER BY tarikh_sesi ASC,kod_sesi_penilaian ASC LIMIT $offset, $rowsPerPage";
$result = mysql_query($query) or die('Error, query failed');
?>
<?php
//include "func.php";
//AccessDenied();

//limit row data per page	
$rowsPerPage2 =10; 
$pageNum2 = $_REQUEST['page']; 

//$army_no=$_POST["army_no"];
//$rank=$_POST["rank"];
// if they have come from another page then adjust the settings for this page
if(empty($pageNum2))
{
$offset2 = 0;
$pageNum2=1;
}
else
{

// counting the offset
$offset2 = ($pageNum2 - 1) * $rowsPerPage2;
}

$query2 = " SELECT date_format(tarikh_sesi,'%d-%m-%Y') as TARIKH,
(SELECT description1 FROM isac.refgeneral 
WHERE
mastercode=(SELECT referencecode
FROM isac.refgeneral WHERE mastercode='XXX' 
AND description1='iac') 
AND
referencestatuscode='00' 
AND referencecode=kod_iac) as IAC FROM usr_isac.pro_sesi WHERE kod_kategori_peserta='02'" .
" ORDER BY tarikh_sesi DESC LIMIT $offset, $rowsPerPage";
$result2 = mysql_query($query2) or die('Error, query failed');

?>

<table width="664px" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td><table width="664" border="0">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="17"><label>
            </label>          </td>
        <td width="637"><span class="style76">JADUAL PENILAIAN ISAC (KUMPULAN)</span></td>
<?php

if(mysql_num_rows($result)>0)
{

?>
      </tr>
      <tr>
        <td colspan="2"><form id="form1" name="form1" method="post" action="">
          <table width="95%" height="78" align="center" bordercolor="#F29422">
            <tr bgcolor="#086092">
              <td width="20" height="21" background="img/content/header_bar1.jpg" bgcolor="#086092" class="style50"><div align="center" class="style1 style56 style59">
                <div align="center" class="style79">Bil.</div>
              </div></td>
              <td width="75" background="img/content/header_bar1.jpg" bgcolor="#086092" class="style63"><div align="center">Tahap</div></td>
              <td width="90" background="img/content/header_bar1.jpg" bgcolor="#086092" class="style63"><div align="center">Tarikh</div></td>
              <td width="43" background="img/content/header_bar1.jpg" bgcolor="#086092" class="style63"><div align="center">Sesi</div></td>
              <td width="122" background="img/content/header_bar1.jpg" bgcolor="#086092" class="style63"><div align="center">Masa</div></td>
             <td width="247" colspan="2" background="img/content/header_bar1.jpg" class="style63"><div align="center">Pusat Penilaian</div></td> 
			                <td width="247" colspan="2" background="img/content/header_bar1.jpg" class="style63"><div align="center">Lokasi Penilaian</div></td>
 </tr>
            <?php 
		//  $num=1;
		  $i = $offset ; 
		  while($data = mysql_fetch_array($result))
		  {
		 
		  if ($i%2==1)
		  $color="#FAD6A9";
		  else
		  $color="";
		  
		 	$tahap = $data['TAHAP'];
			$tarikh_sesi = $data['TARIKH'];
			$masa = $data['MASA'];
			$sesi = $data['SESI'];
			$iac = $data['IAC'];
			$lokasi=$data['LOKASI'];
			$i++;
	   ?>
            <tr bgcolor="<?php echo $color; ?>" >
              <td width="20" height="22" class="style2"><span class="style66"><?php echo $i; ?></span></td>
              <td height="22" class="style2 style64 style67"><div align="center"><?php echo $data['TAHAP']; ?>&nbsp;</div></td>
              <td height="22" class="style2 style64 style67"><div align="center"><?php echo $data['TARIKH']; ?>&nbsp;</div></td>
              <td height="22" class="style2 style64 style67"><div align="center"><?php echo $data['SESI']; ?>&nbsp;
              </div>
                <div align="center"></div></td>
              <td height="22" class="style2 style64 style67"><?php echo $data['MASA']; ?>&nbsp;</td>
              <td height="22" colspan="2" class="style2"><span class="style66"><?php echo $data['IAC']; ?></span></td>
			  <td height="22" colspan="2" class="style2"><span class="style66"><?php echo $data['LOKASI']; ?></span></td>
        <?php 
		} 
		?>
            </tr>
            <tr >
              <td height="25" colspan="6" class="style16 style64 style68"><?php

$query = "SELECT COUNT(id_sesi) AS numrows FROM usr_isac.pro_sesi where kod_kategori_peserta='02'";
$result = mysql_query($query) or die('Error, query failed');
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];

// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);

// print the link to access each page
$self = $_SERVER['PHP_SELF'];
$nav = '';

for($page = 1; $page <= $maxPage; $page++)
{
if ($page == $pageNum)
{
$nav .= " $page ";
}

else
{
$nav .= " <a href=\"$self?page=$page\">$page</a> ";
}
}
// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1)
{
$page = $pageNum - 1;
$prev = " <a href=\"$self?page=$page\">[Prev]</a> ";

$first = " <a href=\"$self?page=1\">[First]</a> ";
}
else
{
$prev = ' ';
$first = ' ';
}

if ($pageNum < $maxPage)
{
$page = $pageNum + 1;
$next = " <a href=\"$self?page=$page\">[Next]</a> ";

$last = " <a href=\"$self?page=$maxPage\">[Last]</a> ";
}
else
{
$next = ' ';
$last = ' ';
}

// print the navigation link(s)
echo $first . $prev . $nav . $next . $last;

?>
                &nbsp;</td>
              </tr>
          </table>
<?php	
}
else
{
?>
              <table width="95%" border="0" align="center">
            <tr>
              <td background="img/content/header_bar1.jpg"><div align="center"><span class="style63">--------------------------------------Maaf tiada jadual disenaraikan buat masa ini--------------------------------------</span></div></td>
            </tr>
<?php
 }
?>
          </table>
          </form></td>
      </tr>
    </table></td>
  </tr>
</table>