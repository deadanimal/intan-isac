<?
function slotnumber()
{
  srand(time());
    for ($i=0; $i < 3; $i++)
    {
      $random = (rand()%3);
      $slot[] = $random;
    }
  print("<td width=\"33%\"><center>$slot[0]</td>");
  print("<td width=\"33%\"><center>$slot[1]</td>");
  print("<td width=\"33%\"><center>$slot[2]</td>");
    if($slot[0] == $slot[1] && $slot[0] == $slot[2])
    {
      print("</td></tr>Winner! -- Hit refresh on your browser to play again");
      exit;
    }
}
?>

<div align="center"><center>
<table border="1" width="50%">
<tr>

<?
slotnumber();
?>

</td></tr><tr>
<td width="100%" colspan="3" bgcolor="#008080">
<form method="POST" action="">
<div align="center"><center><p><input type="submit" value="Spin!">
</p></center></div>
</form>
</td></tr>
</table></center></div>