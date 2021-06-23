<script language="<strong class="highlight">JavaScript</strong>">
<!-- 
var legalExit=0;
var lpx=10;
 function leave() {
if(legalExit==0) {
var dl=confirm('WARNING: Closing this <strong class="highlight">window</strong> means bla bla bla.\n\nClick OK <strong class="highlight">to</strong> remain.'); 
if(dl) {
if(<strong class="highlight">window</strong>.screen){ 
lpx=screen.width;lpx=lpx-225;
} 
var op=window.open('www.google.com','','width=170,height=185,location=no,status=no,directories=no,toolbar=no,menubar=no,scrollbars=yes,resizable=no,top=10,left=' + lpx);
}
}
}
 function openWin(u,t,x,y,s) { 
var op=window.open(u,t,'width='+x+',height='+y+',location=no,status=yes,toolbar=no,directories=no,menubar=no,scrollbars='+s+',resizable=no'); 
op.focus();
}
// -->
</script>

<input style="margin-right:3px" onclick="leave()" type="button" value="Internet Explorer" class="inputButton" />