<script src="weekAjax.js"></script>

<FORM id="carian" NAME="URLlist">
<SELECT  NAME="droplist">
<OPTION SELECTED="SELECTED" VALUE=" ">-- Sila Pilih Tempat --</OPTION>
<OPTION VALUE="<?php echo 'index.php?page=weekv3&menuID=3202&start=31-12-2008&end=28-2-2009&room=5'; ?>">Tempat 1</OPTION>
<OPTION VALUE="<?php echo 'index.php?page=weekv3&menuID=3202&start=16-1-2009&end=23-3-2009&room=2'; ?>">Tempat 2</OPTION>
<OPTION VALUE="<?php echo 'index.php?page=weekv3&menuID=3202&start=14-6-2009&end=18-6-2009&room=3'; ?>">Tempat 3</OPTION>
</SELECT><INPUT TYPE="BUTTON" VALUE="Lihat " ONCLICK="GotoURL(this.form)"></div>
<SCRIPT LANGUAGE="JavaScript"> 
<!--
function GotoURL(dl) { 
// FRAMES - To open a selection in a document that uses frames 
// change top.location.href to parent.putyourframenamehere.location.href
top.location.href = dl.droplist.options[dl.droplist.selectedIndex].value;
} 
// -->
</SCRIPT></FORM><br />




<?php

//utk pass url ke weekajax.js

//

/*//------ Parameter ----------//
$myFirstDate = '31-12-2008';
$mySecDate = '28-2-2009';
$bilik = 5;
//---------------------------//*/
//print_r($_GET);
if($_GET['start']){
callCalendar($_GET['start'],$_GET['end'],$_GET['room'],'weekCal1');	
//callCalendar('31-12-2008','28-2-2009','5','weekCal1');
}
$_GET['room'];

//callCalendar('31-12-2008','28-2-2009','5','weekCal1');
//callCalendar('1-12-2008','12-2-2009','3','weekCal2');




function callCalendar($myFirstDate,$mySecDate,$bilik,$bil){

$curUrl = substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1);


//----- Function kira jumlah hari ---//
function DateDiff($startDate,$endDate){
$startTime = strtotime($startDate);
$endTime = strtotime($endDate);
$diff = $endTime - $startTime;
return ($diff>0) ? floor($diff / 86400) + 1 :0;
}
//----- end function ------//

$firstDate = explode("-",$myFirstDate);
$secondDate = explode("-",$mySecDate);

//---- Variable Date ----//
$firstDay = $firstDate[0];
$firstMonth = $firstDate[1];
$firstYear = $firstDate[2];

$secDay = $secondDate[0];
$secMonth = $secondDate[1];
$secYear = $secondDate[2];

//-----------------------//

//------Kira Jumlah Hari--------//
$datediff = dateDiff($myFirstDate,$mySecDate);
//------------------------------//

//--------- Kira beza firstday temporary ngn secondday ------------//
$dayDiffFirst = strtotime(date("d-m-Y",mktime(0,0,0,$firstMonth,$_GET['day'],$firstYear)));
$dayDiffSecond = strtotime(date("d-m-Y",mktime(0,0,0,$secMonth,$secDay,$secYear)));
$rr = date("d-m-Y",mktime(0,0,0,$firstMonth,$_GET['day'],$firstYear));
$ss = date("d-m-Y",mktime(0,0,0,$secMonth,$secDay,$secYear));
//-----------------------------------------------------------------//

if (isset($_GET['bil'])){
$bil = $_GET['bil'];
}
else{
$bil=$bil;
}

$_GET['bil'];

if ($_GET['next']==1){

if ($dayDiffSecond-$dayDiffFirst > 7){
	$firstDay = $_GET['day'] + 7;
}
else{
	$firstDay = $_GET['day'];
}
}
elseif ($_GET['next']==2){

if ($dayDiffSecond-$dayDiffFirst > 7){
	$firstDay = $_GET['day'] - 7;
}
else{
	$firstDay = $_GET['day'];
}
}

if ($bil != ""){

?>


<div id="<?php echo $bil; ?>">






<table border=1><tr>
<th class="calPointer">&nbsp;</th>
<th colspan='7'>

<?php

//----------- For next day icon -----------//
if($_GET['day']){
$tempBezaNext = (strtotime(date("d-m-Y",mktime(0,0,0,$secMonth,$secDay,$secYear))) - strtotime(date("d-m-Y",mktime(0,0,0,$firstMonth,$_GET['day']+7,$firstYear)))) / 86400;
}
else{
//$tempBezaNext=99999;
$tempBezaNext = (strtotime(date("d-m-Y",mktime(0,0,0,$secMonth,$secDay,$secYear))) - strtotime(date("d-m-Y",mktime(0,0,0,$firstMonth,$firstDay+7,$firstYear)))) / 86400;
}
//------------------------------------------//
//----------- For back day icon ------------//
$tempBezaBack = (strtotime(date("d-m-Y",mktime(0,0,0,$secMonth,$secDay,$secYear))) - strtotime(date("d-m-Y",mktime(0,0,0,$firstMonth,$firstDay,$firstYear)))) / 86400;
//------------------------------------------//



if (isset($_GET['day'])==true && $tempBezaBack != $datediff-1){?>
<div style="float:left; padding-left:30px; cursor:pointer;"><span onClick="setCalendar('weekv3.php','2','<?php echo $_GET['start']; ?>','<?php echo $_GET['end']; ?>','<?php echo $_GET['room']; ?>','<?php echo $firstDay;?>','<?php echo $bil; ?>')">&lt;</span></div>
<?php } ?>
Jadual
<?php

if ($tempBezaNext > 7){
?>
<div style="float:right; padding-right:30px; cursor:pointer;"><span onClick="setCalendar('weekv3.php','1','<?php echo $_GET['start']; ?>','<?php echo $_GET['end']; ?>','<?php echo $_GET['room']; ?>','<?php echo $firstDay;?>','<?php echo $bil; ?>')">&gt;</span></div>
<?php } ?>
</th>
</tr><tr>


<?php
//---------Papar Tarikh n Hari------------//




for ($x=$firstDay-1;$x<7+$firstDay;$x++){

	//$tempDate = strtotime($x."-".$firstMonth."-".$firstYear);

	$tempDate = strtotime(date("d-m-Y",mktime(0,0,0,$firstMonth,$x,$firstYear)));
	$tempDate2 = strtotime($secDay."-".$secMonth."-".$secYear);


	/*echo $tempDate-$tempDate2;
	echo "<br>";*/


	echo "<td width='100px'>";
	if($x==$firstDay-1){
	echo "&nbsp;";
	}
	else{


	if($tempDate<=$tempDate2){ //kalau firstday kecil daripada secondday

	echo "<div align='center'>";
	echo $date = date("d-m-y",mktime(0,0,0,$firstMonth,$x,$firstYear));
	echo "<br>";

	//----View Hari----//
	$caldate = explode("-",$date);
	$secDayName = cal_to_jd(CAL_GREGORIAN,$caldate[1],$caldate[0],$caldate[2]);
	echo(jddayofweek($secDayName,1));
	//-----------------//

	echo "</div>";
	}
	else{  //secondday > firstday
		echo "&nbsp;";
	}

	}
	echo "</td>";

}
//----------End Papar Tarikh n Hari-------------//

//-----------Content Jadual-----------------//
echo "</tr>";
for ($y=0;$y<$bilik;$y++){
echo "<tr>";
for ($x=$firstDay-1;$x<7+$firstDay;$x++){
if($x==$firstDay-1){

$R = $y+1;
echo "<td align='center' height='60px'>Bilik $R</td>";
}
else{
echo "<td height='60px'>&nbsp;</td>";
}
}
echo "</tr>";
//------------End Content Jadual------------//



}

echo "</tr></table></div><br>";




}

}

?>


