<?php 
//if edit screen submitted
if($_POST['saveChanges'])
{	
	//if new password is equal
	if($_POST['userNewPassword_1'] == $_POST['userNewPassword_2'])
	{
		//check user password, correct or not
		$check = "select USERID,USERNAME,USERPASSWORD 
					from PRUSER where USERID = ".$_SESSION['userID']." 
					and USERPASSWORD = '".md5($_POST["userPassword"])."'";
		$checkRs = $myQuery->query($check,'SELECT','NAME');
	
		//if password is correct
		if(count($checkRs) > 0)
		{	
			//check length of password, if less than min length:ref
			if(strlen($_POST['userNewPassword_1']) < CPWD_MIN_LENGTH)
			{	
				$error_3 = true;				//show error
			}
			
			//if length > than min, update user password
			else
			{
				//update password
				$update = "update PRUSER 
							set USERPASSWORD = '".md5($_POST['userNewPassword_1'])."' 
							where USERID = ".$_SESSION['userID'];
				$updateSuccess = $myQuery->query($update,'RUN');
			}
		}
		else
			$error_1 = true;		//show error
	}
	else
		$error_2 = true;			//show error
}
else if($_POST['cancelScreenNew'])
	redirect('index.php');
?>
<link href="../ims.css" rel="stylesheet" type="text/css" />
<link href="spkb_css.css" rel="stylesheet" type="text/css" />
<div id="breadcrumbs">Profil / Tukar Kata Laluan  /
  <?php if($_POST["editScreen"]) echo " Edit /"?>
</div>
<h1>Tukar Kata Laluan </h1>
<?php //if error
  if($error_1) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotificationError">
  <tr>
    <td><?php echo CPWD_MSG_ERR_1;?></td>
  </tr>
</table>
<?php } ?>
<?php //if existing name exist
  if($update) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td><?php echo CPWD_MSG_SUCCESS;?></td>
  </tr>
</table>
<?php } ?>
<?php //if password does not match
  if($error_2) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotificationError">
  <tr>
    <td><?php echo CPWD_MSG_ERR_2;?></td>
  </tr>
</table>
<?php } ?>
<?php //if password length < from min length:ref
  if($error_3) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotificationError">
  <tr>
    <td><?php echo CPWD_MSG_ERR_3;?></td>
  </tr>
</table>
<?php } ?>
<form action="" method="post" name="form1">
  <table width="750" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Tukar Kata Laluan </th>
    </tr>
    <tr>
      <td nowrap class="inputLabel">Kata Laluan Semasa : </td>
      <td width="662"><input name="userPassword" type="password" class="inputInput" id="userPassword" size="40" onkeyup="form1.saveChanges.disabled = false" value="<?php echo $_POST["newTableName"]?>" /></td>
    </tr>
    <tr>
      <td nowrap class="inputLabel">Kata Laluan Baru : </td>
      <td><input name="userNewPassword_1" type="password" class="inputInput" id="userNewPassword_1" size="40" onkeyup="form1.saveChanges.disabled = false" value="<?php echo $_POST["newTableName"]?>" /></td>
    </tr>
    <tr>
      <td nowrap class="inputLabel">Kata Laluan Baru (taip semula) : </td>
      <td><input name="userNewPassword_2" type="password" class="inputInput" id="userNewPassword_2" size="40" onkeyup="form1.saveChanges.disabled = false; if(this.value == document.getElementById('userNewPassword_1').value) document.getElementById('passwordCheck').innerHTML = '* Kata laluan sama!'; else document.getElementById('passwordCheck').innerHTML = '* Kata laluan tidak sama!'" value="<?php echo $_POST["newTableName"]?>" />
        <label id="passwordCheck" style=""></label></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveChanges" type="submit" disabled="disabled" class="inputButton" id="saveChanges" value="Simpan" />
          <input name="cancelScreenNew" type="submit" class="inputButton" value="Batal" />
        </div></td>
    </tr>
  </table>
</form>
