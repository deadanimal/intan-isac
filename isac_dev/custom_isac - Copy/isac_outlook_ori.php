<?php 
include ('../db.php');
$usr = $_GET['id'];
//$usr = $_POST['id'];
//echo $usr;

$to = $_POST['to'];
$subject = $_POST['subject'];
$attachment = $_POST['openssme'];
$mesej = $_POST['mesej'];
$id_q = $_POST['post'];

//skema jawapan
$ans = "select a.id_soalan
			from usr_isac.pro_soalan a,
			usr_isac.pro_kemahiran b,
			usr_isac.pro_pemilihan_set_kemahiran c,
			usr_isac.pro_jawapan d
			where
			a.id_soalan=d.id_soalan
			and
			b.kod_set_soalan=c.kod_set_soalan
			and
			a.id_kemahiran=b.id_kemahiran
			and
			b.kod_bahagian_soalan='04'
			and
			c.id_peserta='".$usr."'";
//$answer = mysql_query($ans) or die('Error, query failed');
$ansRs = $myQuery->query($ans,'SELECT');
//$id_q = $ansRs[0][0];

/*for($x=0;$x< count($ansRs);$x++)
{
$qq[] = $to;
$qq[] = $subject;
$qq[] = $attachment;
$qq[] = $mesej;

$jawapan = "insert into usr_isac.prs_penilaian_peserta_jawapan (id_soalan) values ('$ansRs[$x]')";
$jawapanRs = $myQuery->query($jawapan,'RUN');

}*/

?>
<html>
<head>
<title>Outlook</title>

<!-- By: Matt McHugh //-->

<style type="text/css">
body {
	margin-left: 0%;
	margin-top: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
}

input.hide
	{
		position:absolute;
		left:570px;
		top:60px;
		-moz-opacity:0 ;
		filter:alpha(opacity: 0);
		opacity: 0;
		z-index: 2;
		width:42px;
		height:66px;
	}

input.red
	{
		background-color:#cc0000;
		font-weight:bold;
		color:#ffffff;
		z-index:1;
		width:42px;
		height:66px;
		font-size:10px;
	}
</style>

<!--[if IE]>
	<style type="text/css">
	input.hide
		{
			position:absolute;
			left:550px;
            	top:60px;
			-moz-opacity:0;
			filter:alpha(opacity: 0);
			opacity: 0;
			z-index: 2;
			width:42px;
			height:66px;
			
		}
	</style>
<![endif]-->

<script type="text/javascript">

function buttonPush (buttonStatus)
  {
	 if (buttonStatus == "depressed")
		document.getElementById("pseudobutton").style.borderStyle = "inset";

	 else
		document.getElementById("pseudobutton").style.borderStyle = "outset";
  }
  
function callThis(){
	
	document.getElementById('mine').value = document.getElementById('openssme').value
	
}

</script>
</head>
<body>
<div align="center">
<table cellpadding="0px" cellspacing="0px" width="939">
<tr>
<td>
<table width="939" height="157" border="0" background="../img/outlook/top.png">
<tr>
	<td width="519">    </td>
    <td width="47"><div style="margin-left:5px; margin-top:30px; ">
	<input type="image" src="../img/outlook/attach.png" class="red" id="pseudobutton" value="Open File"></div></td>
    
    <td width="351">&nbsp;</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table width="939" border="0" background="../img/outlook/bottom.png"><form id="form1" name="form1" method="post" action="isac_outlook2.php?id=<?php echo $_GET['id']; ?>">
<tr> 
<td width="60"><div style="margin-left:5px; "><img src="../img/outlook/send.png" width="47" height="73" border="0" onClick="document.form1.submit();"/></div></td>
<td width="60"><img src="../img/outlook/mid2.png" /></td>
<td><div align="left" style="margin-top:-1px;"><label>
  <input name="to" type="text" id="to" size="126" />
  <br />
  <input name="cc" type="text" id="cc" size="126" />
  <br />
  <input name="subject" type="text" id="subject" size="126" />
  <br />
   <input type="text" id="mine" name="mine" size="126" readonly="true">
<input type="file" onChange="callThis()" class="hide" id="openssme" name="openssme" onMouseDown="buttonPush('depressed');" onMouseUp="buttonPush('normal');" onMouseOut="buttonPush('phased');">
</label>
    <input type="hidden" name="id_q" id="id_q" value="<?php echo $ansRs;?>">
</div></td>
</tr>
<tr>
  <td colspan="3"><div align="left" style="margin:6px;"><textarea name="mesej" id="mesej" cols="112" rows="15"></textarea>
  </div></td>
  </tr>
 <tr>
 <td colspan="1"></td></tr>
</table></td>
</tr>
</form>
</table>
</div>

</body>
</html>
