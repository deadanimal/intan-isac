<html>
<head>
<title>
<?php echo SYSTEM_FULL_NAME;?>
</title>
<link href="css/screen.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="document.form1.userID.focus()">
<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
		<!-- LOGIN ERROR SECTION -->
		<?php if($error) { ?>
			<div id="loginError"><?php echo $error; ?></div>
		<?php } ?>
		<br>
		<br>
		<br>
		<br>
		<br>
		<!--  LOGIN SECTION -->
		<div id="loginHeader"><?php echo SYSTEM_FULL_NAME;?> </div>
		<div id="loginShadow">
		<div id="loginScreen">
		  <?php if($_SESSION["SYSTEM_INFO"]["LOGIN_IMAGE_PATH"]) {?>
		  <div style="background-image:url(<?php echo $_SESSION["SYSTEM_INFO"]["LOGIN_IMAGE_PATH"]?>); background-repeat:no-repeat; background-color:#00CCCC"> </div>
		  <?php } ?>
		  <div class="sideLabel">
			<label>Nama Pengguna :</label>
			<input name="userID" type="text" class="inputInput" id="userID" size="38" />
		  </div>
		  <div class="sideLabel">
			<label>Kata Laluan :</label>
			<input name="userPassword" type="password" class="inputInput" id="userPassword" size="38" />
		  </div>
		  <div>
			<input name="login" type="submit" class="inputButton" id="login" value="Log Masuk" style="margin-top:8px;"
				onclick="if(form1.userID.value != '' && form1.userPassword.value != '') {return true} else {alert('<?php echo LOGIN_ERROR_MSG; ?>'); form1.userID.focus(); return false; }" />
		  </div>
		</div>
		</div>
		<!-- END LOGIN SECTION -- >
		<!-- FALCON CREDIT -->
		<div id="loginFalconCredit"> <?php echo LOGIN_FALCON_CREDIT; ?>
		<!-- END FALCON CREDIT -->
		</div>
		<div id="loginFalconCredit">
		<noscript style="color:#FF0000">
		<?php echo JAVASCRIPT_NOT_ENABLED_ERR; ?>
		</noscript>
		<?php //check if cookie enabled
		if(cookieEnabled($_COOKIE) == false) { ?>
		<div style="color:#FF0000">
		  <?php
		echo COOKIE_NOT_ENABLED_ARR;
		//echo "Optimized for PHP v5. Current ver. PHP v".phpversion();
		?>
		</div>
		<?php } ?>
		<!-- END FALCON CREDIT -->
		</div>
	</td>
  </tr>
</table>
</form>
</body>
</html>