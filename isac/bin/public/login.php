<!--17082009
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login_ISAC</title>
<script type="text/JavaScript">
function showt1()
{
            document.getElementById('t1').style.display = 'block';
			document.getElementById('t2').style.display = 'none';
      
	  
}
function showt2()
{
       		document.getElementById('t1').style.display = 'none';
			document.getElementById('t2').style.display = 'block';
}
</script>

<link href="font.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	margin-left: 0%;
	margin-top: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	color: #000000;
	text-decoration: none;
}
a:hover {
	color: #23DFE9;
	text-decoration: underline;
}
a:active {
	color: #23DFE9;
	text-decoration: none;
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
.style59 {color: #FFCC00}
-->
</style></head>

</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="50%" border="0" align="center">
  <tr>
    <td colspan="2" class="style15 style59">KATEGORI PERMOHONAN : </td>
  </tr>
  <tr>
    <td width="8%"><div align="center">
      <input onclick="showt1();"  name="radiobutton" type="radio" value="radiobutton" />
    </div></td>
    <td width="92%" class="style9">Individu (Jawatan) </td>
  </tr>
  <tr>
    <td><div align="center">
      <label>
        <input onclick="showt2();" name="radiobutton" type="radio" value="radiobutton" />
        </label>
    </div></td>
    <td class="style9">Kumpulan (Agensi/Kursus) </td>
  </tr>
</table>
<br></br>

<table id="t1" style="display:none" width="50%" border="0" align="center">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="400" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#FFCC00" class="style9">
        <tr>
          <td width="200"><div align="right">No.MyKad : </div></td>
          <td><input name="ic" type="text" id="ic" maxlength="12" /></td>
        </tr>
        <tr>
          <td width="200"><div align="right">No.Polis/Askar/Pasport: </div></td>
          <td><input name="ic_lain" type="text" id="ic_lain" /></td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="Submit2" class="style13" value="Log Masuk"/>
            <input name="Submit4" type="reset" class="style13" value="Reset" />
          </td>
          </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<table id="t2" style="display:none" width="50%" border="0" align="center">
  <tr>
    <td><form id="form2" name="form1" method="post" action="">
      <table width="400" border="1" align="left" cellpadding="1" cellspacing="0" bordercolor="#FFCC00" class="style9">
        <tr>
          <td width="200"><div align="right">Id Penyelaras  : </div></td>
          <td><input name="id_penyelaras" type="text" id="id_penyelaras" /></td>
        </tr>
        <tr>
          <td width="200"><div align="right">Katalaluan : </div></td>
          <td><input name="katalaluan" type="password" id="katalaluan" /></td>
        </tr>
        <tr>
          <td colspan="2"><div align="right">
              <input name="Submit3" type="submit" class="style13" value="Log Masuk" />
              <input name="Submit5" type="reset" class="style13" value="Reset"/>
             </div>
          </label></td>
          </tr>
      </table>
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
