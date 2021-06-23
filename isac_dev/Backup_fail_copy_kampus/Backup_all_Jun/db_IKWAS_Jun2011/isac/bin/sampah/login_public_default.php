<html>
<head>
<title>
<?=SYSTEM_FULL_NAME;?>
</title>
<link href="css/screen.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="document.form1.publicID.focus()">
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
			<label>No Kad Pengenalam Pengguna :</label>
			<input name="publicID" type="text" class="inputInput" id="publicID" size="38" />
		  </div>
		  <div>
			<input name="login_public" type="submit" class="inputButton" id="login_public" value="Log Masuk" style="margin-top:8px;"
				onclick="if(form1.userID.value != '') {return true} else {alert('<?php echo LOGIN_ERROR_MSG; ?>'); form1.publicID.focus(); return false; }" />
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