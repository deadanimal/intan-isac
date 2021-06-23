<?php 
include ('../db.php');
//user session
$usr = $_GET['id'];
//echo $app = $_GET['app'];
$app = $_REQUEST['app'];

echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';

$set = "select kod_set_soalan from usr_isac.pro_pemilihan_set_kemahiran where id_peserta = '$usr' and id_permohonan = '$app'";
$set_soalan = mysql_query($set) or die('Error, query failed');
$setRs = mysql_fetch_array($set_soalan);

//bahagian A
$arahan = "select distinct a.arahan_umum,
			(SELECT description1 FROM isac.refgeneral 
			WHERE
			mastercode=(SELECT referencecode
			FROM isac.refgeneral where mastercode='XXX' 
			AND description1='BAHAGIAN_SOALAN') 
			AND
			referencestatuscode='00' 
			AND referencecode=a.kod_bahagian_soalan) as 'bahagian_soalan',a.kod_bentuk_soalan
			from usr_isac.pro_kemahiran a,
			usr_isac.pro_pemilihan_set_kemahiran b
			where 
			a.kod_set_soalan = b.kod_set_soalan
			and a.kod_bahagian_soalan = '01'
			and b.id_peserta = '$usr'
			and b.id_permohonan = '$app'";
//$arahanRs = $myQuery->query($arahan,'SELECT');
$arahan_soalan = mysql_query($arahan) or die('Error, query failed');
$arahanRs = mysql_fetch_array($arahan_soalan);
//echo $setRs [0][0];

$soalan = "select distinct c.id_soalan,c.arahan_soalan,c.penyataan_soalan 
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '01' 
					and b.id_peserta = '$usr' and b.id_permohonan = '$app' order by id_soalan asc";
$soalan_a = mysql_query ($soalan) or die ('Error, query failed');
//$soalan_aRs = mysql_fetch_array ($soalan_a);

$a = "select distinct c.arahan_soalan
					from usr_isac.pro_kemahiran a,
					usr_isac.pro_pemilihan_set_kemahiran b,
					usr_isac.pro_soalan c
					where 
					a.kod_set_soalan = b.kod_set_soalan
					and a.id_kemahiran = c.id_kemahiran 
					and a.kod_bahagian_soalan = '01'
					and b.id_peserta = '$usr' and b.id_permohonan = '$app'";
$ab = mysql_query ($a) or die ('Error, query failed');
$abc = mysql_fetch_array ($ab);

if($_POST['submit'])
{

$user = $_POST['usr'];
$usr = $_GET['id'];
$app = $_POST['app'];

$mohon = "select id_permohonan,kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='".$user."')";
$mohonRs = $myQuery->query($mohon,'SELECT');
//$id_mohon = $mohonRs[0][0];
$kod_tahap = $mohonRs[0][1];

$query_answer = "select * from usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b 
						where a.id_soalan = b.id_soalan and a.id_peserta = b.id_peserta
						and b.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')
						and a.id_peserta = '$user' and a.id_permohonan = '$app'";
$result_answer = mysql_query($query_answer) or die('Error, query failed');
$betul=0;
$salah=0;

while($data = mysql_fetch_array($result_answer))
{

	$soalan =  $data[1];
	$jawapan_peserta = $data[3];
	$keterangan = $data[4];
		
	$query_answer1 = "select a.id_pilihan_jawapan, a.skema_jawapan from  usr_isac.pro_jawapan a , usr_isac.pro_pemilihan_soalan_perincian b 
	where a.id_soalan = b.id_soalan and b.id_peserta = '$user' and b.id_permohonan = '$app' and a.id_soalan = '$soalan' and
	b.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')";
	$result_answer1 = mysql_query($query_answer1) or die('Error, query failed');
	while($data1 = mysql_fetch_array($result_answer1))
	{
	 	
		$jawapan_betul = $data1[0];
		$skema_jawapan = $data1[1];
		
		if($keterangan != "")
			{
			if($jawapan_peserta == $jawapan_betul && $keterangan == $skema_jawapan ){
				$betul = $betul+1;
				
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '1' where id_peserta = '$user' and id_permohonan = '$app' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}
			else
			{
			$salah = $salah+1;
			
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '0' where id_peserta = '$user' and id_permohonan = '$app' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}
		
	}//eof while
		
		else
		{
			if($jawapan_peserta == $jawapan_betul )
			{
			$betul = $betul+1;
				
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '1' where id_peserta = '$user' and id_permohonan = '$app' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
					
			}
			else
			{
			$salah = $salah+1;
			
			$query_update = "update usr_isac.prs_penilaian_peserta_jawapan set markah = '0' where id_peserta = '$user' and id_permohonan = '$app' and id_soalan = '$soalan'";
			$result_update = mysql_query($query_update) or die('Error, query failed');
			
			}

		
		}//eof else
			
	}
	
}


/*//jawapan_betul
$query_final_betul = "select count(distinct a.id_soalan) from  usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b where a.id_soalan = b.id_soalan and
b.id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)
and a.id_peserta = '$user' and markah='1'";
$result_final_betul = mysql_query($query_final_betul) or die('Error, query failed');

while($data2 = mysql_fetch_array($result_final_betul))
{

	 $correct_answer = $data2[0];

}
//jawapan_salah
$query_final_salah = "select count(distinct a.id_soalan) from  usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b where a.id_soalan = b.id_soalan and
b.id_pemilihan_soalan = (select max(id_pemilihan_soalan) from usr_isac.pro_pemilihan_soalan)
and a.id_peserta = '$user' and markah='0'";
$result_final_salah = mysql_query($query_final_salah) or die('Error, query failed');

while($data3 = mysql_fetch_array($result_final_salah))
{

	 $false_answer = $data3[0];

}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="proses_script.js"></script>
<style type="text/css">
<!--
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
/*background-color: #347ff4;*/
background-repeat: repeat-x;
}
.style16 {font-family: Arial, Helvetica, sans-serif}
.style25 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.style26 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style30 {font-size: 12px}
.style31 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style32 {
	font-size: 16px
}
.style33 {font-family: Arial, Helvetica, sans-serif; font-size: 16px; }
.style35 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript">
      var baseText = null;
  
      function showPopup(w,h){
	  
	 // window.open ("http://www.javascript-coder.com","left=250px, top=245px, width=700px, height=450px, scrollbars=no, status=no, resizable=no"); 
  
  	window.open('isac_soalan_kemahiranA_internet1.php?id=<?php echo $usr;?>&app=<?php echo $app;?>','','menubar=no,directories=no,status=no,toolbar=no,location=no,fullscreen=yes,taskbar=yes,scrollbar=yes');
 function openWin(u,t,x,y,s) { 
var op=window.open(u,t,'width='+x+',height='+y+',location=no,status=yes,toolbar=no,directories=no,menubar=no,scrollbars='+s+',resizable=no'); 
op.focus();
}
  
      var popUp = document.getElementById("popupcontent");
 
      popUp.style.top = "200px";
  
      popUp.style.left = "200px";
   
      popUp.style.width = w + "px";
  
      popUp.style.height = h + "px";
  
  
      if (baseText == null) baseText = popUp.innerHTML;
  
      popUp.innerHTML = baseText + "<div id=\"statusbar\"><button onclick=\"hidePopup();\">Close window<button></div>";

      var sbar = document.getElementById("statusbar");
  
      sbar.style.marginTop = (parseInt(h)-40) + "px";
 
      popUp.style.visibility = "visible";
 
      }

      function hidePopup(){

      var popUp = document.getElementById("popupcontent");

      popUp.style.visibility = "hidden";

      }
	  
	  function confirmation() 
	  {
		var answer = confirm("Anda pasti telah selesai menjawab Bahagian A?")
		if (answer)
		{
			window.location.href = "isac_soalan_kemahiranB.php?id=<?php echo $usr;?>&app=<?php echo $app;?>";
		}
	
	  }

</script>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
/*var newwindow;
function pop(url)
{newwindow=window.open(url,'name','height=700,width=1400, scrollbars=1, resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0');
if (window.focus) {newwindow.focus()}
}*/

var newwindow;
function pop(url)
{newwindow=window.open(url,'name','height=180,width=1400,left=0,top=640, scrollbars=1, resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0');
if (window.focus) {newwindow.focus()}
}

function displaymessage()

{
//internet
windowOne=window.open('isac_soalan_kemahiranA_internet1.php?id=<?php echo $usr;?>&app=<?php echo $app;?>','answer','height=550,width=1440,top=0, scrollbars=1, resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0');
//internet_question
windowTwo=window.open('isac_soalan_kemahiranA_internet.php?id=<?php echo $usr;?>&app=<?php echo $app;?>','question','height=250,width=1440,left=0,top=640, scrollbars=1, resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0');
}

</SCRIPT>
</head>

<body onLoad="window.parent.scroll(0,0);">
<!-- <table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="style15">
<td height="29"><div align="left"><span class="style16">&nbsp;&nbsp;<span class="style14">Keputusan Penilaian</span></span></div></td>
</tr> -->

<?php

/*echo "<tr><td>";
echo "<br><br><div align='center'>Keputusan anda ialah ";
echo "<strong>".$correct_answer."</strong> jawapan betul dan ";
echo "<strong>".$false_answer."</strong> jawapan salah</div><br><br>";
echo '</td></tr></table>';
*/?>
<?php
}
?>
<p>
</p>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   <tr class="style15">
     <td height="29" class="style16"><div align="center"><span class="style33 style32">SOALAN ISAC BAHAGIAN KEMAHIRAN</span></div>
     <div align="left"></div></td>
  </tr>
   <tr>
     <td height="29"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
       <tr>
         <td><table width="98%" align="center" cellpadding="0" cellspacing="0">
             
             <tr>
               <td colspan="2"><div align="center" class="style25 style30"><span class="style31">SET</span><span class="style31"> <?php echo $setRs['kod_set_soalan'];?></span></div></td>
              </tr>
             
             <tr>
               <td height="21" colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td height="21" colspan="2"><span class="style31"><?php echo $arahanRs['arahan_umum'];?></span></td>
             </tr>
             <tr>
               <td height="19" colspan="2"><span class="style30"></span></td>
              </tr>
             <tr>
               <td height="14" colspan="2"><hr align="center" width="100%" size="2" /></td>
              </tr>
             <tr>
               <td height="23" colspan="2"><p class="style26"><strong class="style31"><u><?php echo $arahanRs['bahagian_soalan'];?></u></strong><br />
               </p></td>
             </tr>
             <tr>
               <td height="24" colspan="2"><span class="style31"><strong><u> A) Soalan &nbsp;<?php echo $arahanRs['kod_bentuk_soalan'];?></u></strong></span></td>
             </tr>
             
             <tr>
               <td height="22" colspan="2"><p class="style33"><?php echo $abc['arahan_soalan'];?></p></td>
             </tr>
             <tr>	
               <td height="19" colspan="2"><p class="style26 style32">&nbsp;</p></td>
             </tr>
           <?php
		   while ($row = mysql_fetch_array ($soalan_a))
		{
		   $id_soalan     = $row['id_soalan'];
		   $arahan_soalan = $row['penyataan_soalan']; 
		   ?>
             <tr>
               <td height="27">&nbsp;</td>
               <td><div align="justify"><span class="style33">
                 <?php //echo $row['id_soalan'];
			   echo $row['penyataan_soalan'];
			         ?>
               </span></div></td>
             </tr><?php } ?>
             <tr>
               <td width="3%" height="27"><p>&nbsp;</p></td>
               <td width="97%">&nbsp;</td>
             </tr> 
             <tr>
               <td height="27" colspan="2"><hr size="2" width="100%" align="center" /></td>
             </tr>
             
         </table></td>
       </tr>
       <tr>
         <td><div id="userNotification3" align="right">
         
   <!--     <input style="margin-right:3px" onclick="window.open('isac_soalan_kemahiranA_internet1.php?id=<?php /*echo $usr; */?>','name','height=700,width=1400, scrollbars=1, resizable=0,menubar=0,toolbar=0,location=0,status=0,statusbar=0')" type="button" value="Internet Explorer" class="inputButton" /> -->
   <input style="margin-right:3px" onclick="displaymessage();saveMasa2(<?php echo $app;?>);" type="button" value="Internet Explorer" class="inputButton" />
         </div>
         <p>
         </p>
         <div id="userNotification3" align="right"><span class="style35 style30">* Nota : Anda hanya boleh menjawab Bahagian  B setelah selesai Bahagian A (Internet).</span>
                          
           <input style="margin-right:3px" onclick='var answer = confirm("Anda pasti telah selesai menjawab Bahagian A?")
		if (answer)
		{
			window.location.href = "isac_soalan_kemahiranB.php?id=<?php echo $usr;?>&app=<?php echo $app;?>";saveMasa2(<?php echo $app;?>);
		}'  type="button" value="Bahagian B" class="inputButton" />
         </div></td>
       </tr>
     </table></td>
   </tr>
</table>
<br />
</body>
</html>
