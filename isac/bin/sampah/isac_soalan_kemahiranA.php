<?php 
include ('../db.php');
//user session
$usr = $_GET['id'];

echo '<link rel="stylesheet" href="custom_css.css" type="text/css" media="screen" />';

$set = "select kod_set_soalan from usr_isac.pro_pemilihan_set_kemahiran where id_peserta = '$usr'";
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
			and b.id_peserta = '$usr'";
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
					and b.id_peserta = '$usr' order by id_soalan asc";
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
					and b.id_peserta = '$usr'";
$ab = mysql_query ($a) or die ('Error, query failed');
$abc = mysql_fetch_array ($ab);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
background-color: #347ff4;
background-repeat: repeat-x;
}
.style3 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 16px;
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
-->
</style>
<script type="text/javascript">
      var baseText = null;
  
      function showPopup(w,h){
	  
	 // window.open ("http://www.javascript-coder.com","left=250px, top=245px, width=700px, height=450px, scrollbars=no, status=no, resizable=no"); 
  
  	window.open('isac_soalan_kemahiranA_internet1.php?id=<?php echo $usr;?>','','menubar=no,directories=no,status=no,toolbar=no,location=no,fullscreen=yes,taskbar=yes,scrollbar=yes');

  
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
</script>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="100%">
   <tr class="style15">
     <td height="29" class="style16"><div align="center"><span class="style3">SOALAN ISAC BAHAGIAN KEMAHIRAN</span></div>
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
               <td><span class="style33">
                 <?php //echo $row['id_soalan'];
			   echo $row['penyataan_soalan'];
			         ?>
               </span></td>
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
                 
          <input style="margin-right:3px" onclick="showPopup(300,200)" type="button" value="Internet Explorer" class="inputButton" />
          
           <input style="margin-right:3px" onclick="window.location='isac_soalan_kemahiranB.php?id=<?php echo $usr;?>'"  type="button" value="Bahagian Kemahiran B" class="inputButton" />
         </div></td>
       </tr>
     </table></td>
   </tr>
</table>
<br />
</body>
</html>
