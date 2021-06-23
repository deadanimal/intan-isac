<?php
include ('../db.php');
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="font.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
a:link {
	color: #0000FF;
}
a:visited {
	color: #0000FF;
}
a:hover {
	color: #CC00CC;
}
a:active {
	color: #CC00CC;
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
.style58 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
/*background-color: #347ff4;*/
background-repeat: repeat-x;
background-image: url(../img/content/header_bar1.jpg);
}
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
	font-size: 16px;
	font-weight: bold;
}
.style73 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #000000; }

-->
</style></head>
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
<body>
<table width="780" border="0" cellpadding="0" cellspacing="0">
  <tr class="style15">
    <td height="29"><div align="center" class="style58">
      <div align="left">Jadual Sesi Penilaian ISAC (Individu)</div>
    </div></td>
  </tr>
  <tr>
    <td><table width="770" border="0">
      <tr>
        <td><label>
            </label>
          </td>
      </tr>
      <tr>
        <td><form id="form1" name="form1" method="post" action="">
          <p>&nbsp;</p>
          <table width="95%" height="78" align="center" bordercolor="#F29422">
            <tr bgcolor="#086092">
              <td width="22" height="21" bgcolor="#F29422" class="style50"><div align="center" class="style1 style56 style59">Bil.</div></td>
              <td width="151" bordercolor="#0EACC9" bgcolor="#F29422" class="style63">Tarikh Penilaian</td>
              <td colspan="2" bordercolor="#0EACC9" bgcolor="#F29422" class="style63">Pusat Penilaian</td>
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
		  
		 	$tarikh_sesi = $data['TARIKH'];
			$iac = $data['IAC'];
		//	$user_id = $data['user_id'];
		//	$status = $data['status'];
			$i++;
	   ?>
            <tr bgcolor="<?php echo $color; ?>" >
              <td width="22" height="22" class="style2"><span class="style66"><?php echo $i; ?></span></td>
              <td height="22" class="style2 style64 style67"><?php echo $data['TARIKH']; ?>&nbsp;</td>
              <td height="22" colspan="2" class="style2"><span class="style66"><?php echo $data['IAC']; ?></span></td>
              <?php 
		   //  $num ++;
			} 
		?>
            </tr>
            <tr >
              <td height="25" colspan="3" class="style16 style64 style68"><?php

$query = "SELECT COUNT(id_sesi) AS numrows FROM usr_isac.pro_sesi where kod_kategori_peserta='01'";
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
              <td width="83" height="25" class="style2">&nbsp;</td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>