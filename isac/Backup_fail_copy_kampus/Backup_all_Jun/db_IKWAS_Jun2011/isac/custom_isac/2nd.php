<html>
<HEAD>
<title>Disable the Refresh Button</title>


<script language='javascript'>

function test()
{
window.onbeforeunload = function() {
window.status = 'Click button is disabled';
return false;
}

}

//disable right-click
document.oncontextmenu = function(){
window.status = 'Right-click is disabled';
return false;
}

//MSIE6 disable F5 && ctrl+r && ctrl+n
document.onkeydown=function(){
//alert('keycode='+event.keyCode + 'event.ctrlKey='+event.ctrlKey );
switch (event.keyCode) {
case 116 : //F5
event.returnValue=false;
event.keyCode=0;
window.status = 'Refresh is disabled';
return false;
case 78: //n
if (event.ctrlKey) {
event.returnValue=false;
event.keyCode=0;
window.status = 'New window is disabled';
return false;
}
case 82 : //r
if (event.ctrlKey) {
event.returnValue=false;
event.keyCode=0;
window.status = 'Refresh is disabled';
return false;
}
}
}

// diasable back button
window.history.forward(1);
</script>
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin
var up,down;
var min1,sec1;
var cmin1,csec1,cmin2,csec2;

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
UpRepeat(); }
function UpRepeat() {
csec1++;
if(csec1==60) { csec1=0; cmin1++; }
document.sw.disp1.value=Display(cmin1,csec1);
if((cmin1==min1)&&(csec1==sec1)) alert("Timer-CountUp Stopped");
else up=setTimeout("UpRepeat()",1000); }
function Down() {
cmin2=1*Minutes(document.sw.beg2.value);
csec2=0+Seconds(document.sw.beg2.value);
DownRepeat(); }
function DownRepeat() {
csec2--;
if(csec2==-1) { csec2=59; cmin2--; }
document.sw.disp2.value=Display(cmin2,csec2);
if((cmin2==0)&&(csec2==0)) alert("Timer-CountDown Stopped");
else down=setTimeout("DownRepeat()",1000); }
// End -->
</SCRIPT>
<SCRIPT type="text/javascript">
window.history.forward();
function noBack() { window.history.forward(); }
</SCRIPT>

<body onload = test()>
<CENTER>
<FORM name="sw">
<TABLE border="3" width="100%">
<TR><TH colspan="2">Timer-CountDown</TH></TR>
<TR align="center"><TD>Start at<BR><input type="text" name="beg2" size="7" value="01:00"></TD>
<TD><input type="button" value="Start" onClick="Down()"></TD></TR>
<TR align="center"><td colspan="2"><input type="text" name="disp2" size="9"></TD>
</TR>
</TABLE>
</FORM>
</CENTER>

</body>
</html> 