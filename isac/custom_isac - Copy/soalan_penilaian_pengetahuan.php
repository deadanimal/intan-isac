<?php
/*echo $result=mysql_query("SELECT id_soalan FROM usr_isac.pro_pemilihan_soalan_perincian ORDER BY id_pemilihan_soalan_perincian DESC");
while ($row=mysql_fetch_array ($result))
{
$a= $row[id_soalan];

}*/
//$result=mysql_query("SELECT * FROM usr_isac.pro_pemilihan_soalan_perincian ORDER BY id_pemilihan_soalan_perincian DESC");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style14 {font-size: 12px}
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
background-color: #e8a20c;
background-repeat: repeat-x;
}
.style16 {
	font-size: 14px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
.style20 {font-size: 14px; font-weight: bold; font-family: Georgia, "Times New Roman", Times, serif;}
.style25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
.style29 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; color: #000000; }
.style30 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: x-small;
}
.style32 {
	font-size: x-small;
	color: #000000;
}
.style39 {font-size: small}
.style40 {color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;}
.style43 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   <tr class="style15">
     <td height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Arahan Soalan</span></span></div></td>
   </tr>
   <tr>
     <td height="29"><table width="100%" border="0">
       <tr>
         <td><form id="form1" name="form1" method="post" action="">
           <table width="100%" border="0" cellspacing="0">
             <tr>
               <td width="34" align="center" bgcolor=""><span class="style20">No.</span></td>
               <td width="1271" align="center" bgcolor=""><span class="style20">Soalan (<em>Question</em>)</span></td>
             </tr>
<?php 
//limit row data per page	
$rowsPerPage =1; 
$pageNum = $_REQUEST['page']; 

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

if($offset<0)
	$offset = 0;

$query = " SELECT * FROM usr_isac.pro_pemilihan_soalan_perincian " .
"ORDER BY id_pemilihan_soalan_perincian DESC LIMIT $offset, $rowsPerPage";
$result = mysql_query($query) or die('Error, query failed');
//$queryRs = $myQuery->query($query,'SELECT');

$i = $offset ; 
while($data = mysql_fetch_array($result))
{

$id_soalan = $data['ID_SOALAN'];
$i++;
?>
             <tr>
               <td bgcolor=""><div align="center" class="style39"><span class="style40"><?php echo $i; ?>&nbsp;</span></div></td>
               <td bgcolor=""><span class="style29">&nbsp;<?php echo $data['ID_SOALAN']; ?></span></td>
               <?php 
//$i++;
}//eof while
?>
             </tr>
             <tr>
               <td height="26" colspan="2" bgcolor="#FFFFFF"><span class="style16 style25 style30"><span class="style16 style25  style32"><span class="style43"> &nbsp;
<?php
$query2 = "SELECT COUNT(id_pemilihan_soalan_perincian) AS numrows FROM usr_isac.pro_pemilihan_soalan_perincian ";
$result = mysql_query($query) or die('Error, query failed');
//$queryRs2 = $myQuery->query($query2,'SELECT');

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
               </span></span></span></td>
             </tr>
           </table>
           </form>
          </td>
       </tr>
     </table></td>
  </tr>
 </table>
</body>
</html>
