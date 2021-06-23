<?php 
//include ('../db.php');
$usr = $_GET['id'];
$app = $_GET['app'];
//$usr = $_REQUEST['id'];
//$usr = $_POST['id'];
//echo $usr;

$url = $_REQUEST['url'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-top: 0%;
	margin-left: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
}
-->
</style></head>

<body>
<table width="100%" border="0" align="center" bgcolor="#F3F4F6">
  <tr>
    <td width="6%" height="34"><img src="image/arrow_google.png" width="77" height="31" border="0" usemap="#Map"/></td>
    <td width="71%" bgcolor="#F3F5F5"><form id="form1" name="form1" method="post" action="isac_soalan_kemahiranA_internet2.php?id=<?php echo $_GET['id'];?>&app=<?php echo $_GET['app'];?>">
     <div style="margin-top:-13px; margin-left:-10px; position:absolute;"> <input name="id" type="hidden" id="id" size="" value="<?php echo $_GET['id'];?>"/>
     <input name="app" type="hidden" id="app" size="" value="<?php echo $_GET['app'];?>"/>
      <input name="url" type="text" id="url" value="<?php echo $_GET['url'];?>" size="153" />
      </div>
      
    </form>    </td>
    <td width="23%"><img src="image/intan_web/header4.gif" width="298" height="30" border="0" onclick="document.form1.submit();" /></td>
  </tr>
  
  <tr>
    <td colspan="3"><img src="image/page_cannot_display_webpage.png" width="100%" height="626" /></td>
  </tr>
  <tr>
    <td colspan="3"><img src="image/intan_web/footer.png" width="100%" height="24" /></td>
  </tr>
</table>

<map name="Map" id="Map">
<area shape="rect" coords="1,-3,30,30" href="isac_soalan_kemahiranA_internet1.php?id=<?php echo $_GET['id'];?>&app=<?php echo $_GET['app'];?>" />
</map></body>
</html>
