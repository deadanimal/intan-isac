<?php
//s/ession_start();
include ('db.php');

//$ic_peserta ='aaaa';
$ic_peserta = $_REQUEST['usr'];

//path file
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='01'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//server IP
$location = $path_nameRs[0][2];

?>
<style type="text/css">
<!--
body {
	background-color: #FE801A;
	margin-left: 0%;
	margin-top: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
	background-repeat: no-repeat;
	background-position: center;
	background-position:top;
}
#apDiv1 {
	position:absolute;
	left:152px;
	top:185px;
	width:139px;
	height:121px;
	z-index:1;
}

-->
</style>

<table width="80%" border="0" align="center">
  <tr>
    <td>
<div style="margin-top:0px; position:absolute;"><img src="img/top.png" width="790" height="178" /></div>

<div style="margin-top:178px; position:absolute;"><img src="img/mainpage_mid.png" width="790" height="120" /></div>

<div style="margin-top:298px; position:absolute;"><img src="img/body_repeat.png" width="790" height="7" style="background-repeat:repeat-y"/></div>

<div id="tentang_isac" style="margin-top:190px; margin-left:60px; position:absolute;"><img src="img/1.png" width="133" height="111" /></a></div>

<div style="margin-top:190px; margin-left:195px; position:absolute;"><a href="http://<?php echo $location;?>/isac/login.php?mode=mohon"><img src="img/2.png" width="133" height="111" /></a></div>

<div style="margin-top:190px; margin-left:330px; position:absolute;"><img src="img/3.png" width="133" height="111" /></div>

<div style="margin-top:190px; margin-left:465px; position:absolute;"><a href="http://<?php echo $location;?>/isac/login.php?mode=semak"><img src="img/4.png" width="133" height="111" /></a></div>

<div style="margin-top:190px; margin-left:600px; position:absolute;"><img src="img/5.png" width="133" height="111" /></div>
<div style="margin-top:295px; position:absolute;"><img src="img/body_repeat.png" width="790" height="7" style="background-repeat:repeat-y" /><table width="780" border="1" cellpadding="0" cellspacing="0" bordercolor="#F29422">
  <tr class="style15">
    <td bgcolor="#0A8EA7"><div align="center" class="style58">Jadual Sesi Penilaian ISAC</div></td>
  </tr>
  <tr>
    <td><table width="770" border="0">
      <tr>
        <td><label>
            </label>
                </form></td>
      </tr>
      <tr>
        <td><form id="form1" name="form1" method="post" action="">
          <p>&nbsp;</p>
          <table width="95%" height="78" align="center" bordercolor="#F29422">
            <tr bgcolor="#086092">
              <td width="22" height="21" bgcolor="#F29422" class="style50"><div align="center" class="style1 style56 style59">Bil.</div></td>
              <td width="322" bordercolor="#0EACC9" bgcolor="#F29422" class="style63">Tarikh Penilaian</td>
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
              <td width="68" height="25" class="style2">&nbsp;</td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>

</div>

<div style="margin-top:300px; position:absolute;"><img src="img/footer.png" width="790" height="44" style="background-repeat:repeat-y" />
</div>

</td>

  </tr>
  
</table>




