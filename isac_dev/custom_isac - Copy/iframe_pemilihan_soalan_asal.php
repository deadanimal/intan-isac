<?php

$no_ic =  $_SESSION['publicID'];
$query = "select id_peserta from usr_isac.pro_peserta where (no_kad_pengenalan = '$no_ic' or no_kad_pengenalan_lain = '$no_ic')";
$result = mysql_query($query) or die('Error, query failed');

while($data = mysql_fetch_array($result))
{

$usr = $data['id_peserta'];

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<form method="post">

<iframe src="custom_isac/countDown1.php" frameborder="0" width="100%" height="60px" allowTransparency="true"></iframe>	<br />
<iframe  src="custom_isac/soalan_perincian1.php?usr=<?php echo $usr ;?>" frameborder="0" width="100%" height="850px" allowTransparency="true"></iframe>	
	
</form>

</html>
