<?php
session_start();
include ('../db.php');

//$ic_peserta ='aaaa';
$ic_peserta = $_REQUEST['usr'];
$app = $_REQUEST['app'];

//get id_permohonan
$get_mohon = "select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta = '$ic_peserta'";
$rs_get_mohon = $myQuery->query($get_mohon,'SELECT');

$id_mohon = $rs_get_mohon[0][0];

//path file
$path_name = "select SERVER_IP from usr_isac.ruj_path_file where id_path_file='1'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//server IP
$location = $path_nameRs[0][0];

$timer = "select TEMPOH_MASA_KESELURUHAN_PENILAIAN,TEMPOH_MASA_PERINGATAN_TAMAT_SOALAN_PENGETAHUAN,TEMPOH_MASA_PERINGATAN_SEBELUM_TAMAT_PENILAIAN from usr_isac.pro_kawalan_sistem where id_kawalan_sistem=1";
$timerRs = $myQuery->query($timer,'SELECT');

$timer_pengetahuan = $timerRs[0][1];
$timer_peringatan = $timerRs[0][2];

$check_masa_user = "select masa from usr_isac.pro_masa where id_permohonan='$id_mohon'";
$rs_check_masa_user = $myQuery->query($check_masa_user,'SELECT');

if(count($rs_check_masa_user) > 0){

$timer_all = $rs_check_masa_user[0][0];

}
else{
$timer_all = $timerRs[0][0];

}


$mytimer = $timer_all - $timer_pengetahuan ;
?>
<!-- ONE STEP TO INSTALL COUNT DOWN:

   1.  Copy the last code into the HEAD of your HTML document  -->
  

<!-- STEP ONE: Add this code into the HEAD of your HTML document  --> 
<HEAD>

<SCRIPT LANGUAGE="JavaScript">

<!-- Begin
var up,down;
var min1,sec1;
var cmin1,csec1,cmin2,csec2;

function setMasa(){

window.parent.parentform.document.getElementById('ParentMasa').value = document.getElementById('disp2').value;

}

function Minutes(data) {
for(var i=0;i<data.length;i++) if(data.substring(i,i+1)==":") break;
return(data.substring(0,i)); }

function Seconds(data) {
for(var i=0;i<data.length;i++) if(data.substring(i,i+1)==":") break;
return(data.substring(i+1,data.length)); }

function Display(min,sec) {
var disp;
if(min<=9) disp=" 0";
else disp=" ";
disp+=min+":";
if(sec<=9) disp+="0"+sec;
else disp+=sec;
return(disp); }
function Up() {
cmin1=0;
csec1=0;
min1=0+Minutes(document.sw.beg1.value);
sec1=0+Seconds(document.sw.beg1.value);
UpRepeat(); 


}
function UpRepeat() {

csec1++;
if(csec1==60) { csec1=0; cmin1++; }
document.sw.disp1.value=Display(cmin1,csec1);
if((cmin1==min1)&&(csec1==sec1)){
alert("Timer-CountUp Stopped");
}
else up=setTimeout("UpRepeat()",1000); }
function Down() {
cmin2=1*Minutes(document.sw.beg2.value);
csec2=0+Seconds(document.sw.beg2.value);
DownRepeat(); 

}
function DownRepeat() {
setMasa();
idpeserta = document.getElementById('idpeserta').value;
idmohon = document.getElementById('idmohon').value;
mytime = document.getElementById('mytime').value;
peringatan = document.getElementById('peringatan').value;
//mytime = 59;
csec2--;
if(csec2==-1) { csec2=60; cmin2--; }
//Cni nk redirect ke page lain
//cth: 20 minit tamat, bukak test lain
if(cmin2 == mytime && csec2 == "00"){
//self.parent.location = '../index.php?page=page_wrapper&menuID=6257&id='+idpeserta;
//parent.location.href = "isac_soalan_kemahiranA.php?id="+idpeserta;
/*alert('Masa menjawab untuk bahagian ini sudah tamat. Sila jawab bahagian berikutnya');
self.parent.location = '../index.php?page=page_wrapper&menuID=89';
*/
window.open('mesej.html','mywindow','width=600,height=100,left=350,top=350');

// window.open('\\\\<?php /*echo $location;*/?>\\htdocs\\isac\\custom_isac\\mesej.php','mywindow','width=600,height=110,left=350,top=350');
//self.parent.location = '../index.php?page=page_wrapper&menuID=6257&finish1=true&id='+idpeserta;
}

if(cmin2 == peringatan && csec2 == "00"){
//window.open('\\\\<?php /*echo $location;*/?>\\htdocs\\isac\\custom_isac\\mesej2.php','mywindow','width=600,height=110,left=350,top=350');
 
window.open('mesej2.html','mywindow','width=600,height=100,left=350,top=350'); 
}


if(cmin2 == "00" && csec2 == "10"){
blinkFont();
}
//end

document.sw.disp2.value=Display(cmin2,csec2);
document.cookie = "javascriptVar="+document.sw.disp2.value;

//Bile tamat mase wat ni
if((cmin2==0)&&(csec2==0)){

alert('Masa menjawab telah tamat');
self.parent.location = '../index.php?page=page_wrapper&menuID=8343&id='+idpeserta+'&app='+idmohon;
}

else down=setTimeout("DownRepeat()",1000); }


function blinkFont()
{
  document.getElementById("masa").style.color="red"
  setTimeout("setblinkFont()",500)
}

function setblinkFont()
{
  document.getElementById("masa").style.color=""
  setTimeout("blinkFont()",500)
}


// End -->
</SCRIPT>
<style type="text/css">

#userNotification2{
	border: 1px solid #cad7e8;
	border-right-width: 2px;
	border-bottom-width: 2px;
	font-size: 0.9em;
	padding: 3px 0px 3px 0px;
	width:99%;
	margin-bottom:3px;
	font-weight:bold;
	background-color:#fafbf6;
}

.inputInput, .inputInput, .w8em{
	font-family:"Trebuchet MS", Verdana, Arial;
	padding: 1px;
	border: 1px solid #CCCCCC;
	font-size: 12px;
	text-align:center;
	margin-right:3px;
}

.style1 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
}
.style3 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
</style>
<BODY onLoad="Down();">
<CENTER>
<FORM name="sw">
<?php

if($_COOKIE['javascriptVar'] == "00:00"){
	$time = $timer_all;
}
else{
if(!isset($_COOKIE['javascriptVar'])){
$time = $timer_all;
}
else{
$time = $_COOKIE['javascriptVar'];
}
}

?>
<!--/*<TABLE border="3" width="100%">
<TR><TH colspan="2">Timer-CountDown</TH></TR>
<TR align="center"><TD>Start at<BR><input type="text" name="beg2" size="7" value="01:00"></TD>
<TD><input type="button" value="Start" ></TD></TR>
<TR align="center"><td colspan="2"><input type="text" name="disp23" size="9"></TD></TR>
</TABLE>*/-->
<input type="hidden" name="idpeserta" size="7" value="<?php echo $ic_peserta; ?>">
<input type="hidden" name="idmohon" size="7" value="<?php echo $id_mohon; ?>">
<input type="hidden" name="beg2" size="7" value="<?php echo $time; ?>">
<input type="hidden" name="mytime" size="7" value="<?php echo $mytimer; ?>">
<input type="hidden" name="pengetahuan" size="7" value="<?php echo $timer_pengetahuan; ?>">
<input type="hidden" name="peringatan" size="7" value="<?php echo $timer_peringatan; ?>">

<div align="right" id="userNotification2"><span class="style3" id="masa">Masa :</span><span class="style1">&nbsp;</span>
  <input class="inputInput" type="text" name="disp2" id="disp2" value="33" onClick="setMasa()" size="9"></div>

</FORM>
</CENTER>

