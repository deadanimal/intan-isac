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
.style63 {color: #FFFFFF; font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.style64 {font-family: Arial, Helvetica, sans-serif}
.style66 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style67 {font-size: 12px}
.style75 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FF0000;
	font-size: 14px;
}
.style76 {
	font-size: 10px;
	font-weight: bold;
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
AND referencecode=kod_iac) as IAC FROM usr_isac.pro_sesi WHERE kod_kategori_peserta='01' and id_sesi !='351'" .
" ORDER BY tarikh_sesi ASC LIMIT $offset, $rowsPerPage";
$result = mysql_query($query) or die('Error, query failed');

?>
<table width="664px" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td><table width="664" border="0">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="17"><label>
            </label></td>
        <td width="637"><span class="style75">JADUAL SESI PENILAIAN ISAC (INDIVIDU)</span></td>
<?php

if(mysql_num_rows($result)>0)
{

?>
      </tr>
      <tr>
        <td colspan="2"><form id="form1" name="form1" method="post" action="">
          <table width="95%" height="78" align="center" bordercolor="#F29422">
            <tr bgcolor="#086092">
              <td width="22" height="21" background="img/content/header_bar1.jpg" bgcolor="#086092" class="style50"><div align="center" class="style1 style56 style59">Bil.</div></td>
              <td width="110" background="img/content/header_bar1.jpg" bgcolor="#086092" class="style63">Tarikh Penilaian</td>
              <td colspan="2" background="img/content/header_bar1.jpg" class="style63">Pusat Penilaian</td>
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
              <td height="25" colspan="3" class="style16 style64  style76"><?php

$query = "SELECT COUNT(id_sesi) AS numrows FROM usr_isac.pro_sesi where kod_kategori_peserta='01' and id_sesi !='351'";
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
