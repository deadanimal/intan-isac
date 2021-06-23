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
.style63 {color: #FFFFFF; font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.style64 {font-family: Arial, Helvetica, sans-serif}
.style66 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style67 {font-size: 12px}
.style68 {
	font-size: 10px;
	font-weight: bold;
}
.style70 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.style75 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FF0000;
	font-size: 14px;
}

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

$query = " SELECT date_format(tarikh_sesi,'%d-%m-%Y') as TARIKH,
(SELECT description1 FROM isac.refgeneral 
WHERE
mastercode=(SELECT referencecode
FROM isac.refgeneral WHERE mastercode='XXX' 
AND description1='iac') 
AND
referencestatuscode='00' 
AND referencecode=kod_iac) as IAC FROM usr_isac.pro_sesi WHERE kod_kategori_peserta='01'" .
" ORDER BY tarikh_sesi DESC LIMIT $offset, $rowsPerPage";
$result = mysql_query($query) or die('Error, query failed');

?>
<p>&nbsp;</p>
<table width="664" border="0">
  <tr>
    <td width="137" height="92"><div align="right"><img src="img/individu.jpg" width="80" height="90" /></div></td>
    <td width="185"><span class="style70"><a href="http://disac.intan.my/isac/main_page_jadual_individu.php" target="_parent">Jadual Individu</a></span></td>
    <td width="110"><img src="img/group.jpg" width="100" height="90" /></td>
    <td width="214" class="style70"><a href="http://disac.intan.my/isac/main_page_jadual_kumpulan.php" target="_parent">Jadual Kumpulan</a></td>
  </tr>
</table>
