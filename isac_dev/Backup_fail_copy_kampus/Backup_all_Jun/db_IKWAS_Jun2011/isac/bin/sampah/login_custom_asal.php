<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?=SYSTEM_FULL_NAME;?>
</title>
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/common.js"></script>
</head>

<body onLoad="document.form1.userID.focus()" bgcolor="#A1BFFF">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="background-image:url(img/login/kiri.jpg); background-repeat:repeat-x">&nbsp;</td>
    <td width="800"><table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="img/login/1.jpg" width="100" height="100" /></td>
          <td><img src="img/login/2.jpg" width="100" height="100" /></td>
          <td><img src="img/login/3.jpg" width="100" height="100" /></td>
          <td><img src="img/login/4.jpg" width="100" height="100" /></td>
          <td><img src="img/login/5.jpg" width="100" height="100" /></td>
          <td><img src="img/login/6.jpg" width="100" height="100" /></td>
          <td><img src="img/login/7.jpg" width="100" height="100" /></td>
          <td><img src="img/login/8.jpg" width="100" height="100" /></td>
        </tr>
        <tr>
          <td><img src="img/login/9.jpg" width="100" height="100" /></td>
          <td><img src="img/login/10.jpg" width="100" height="100" /></td>
          <td><img src="img/login/11.jpg" width="100" height="100" /></td>
          <td><img src="img/login/12.jpg" width="100" height="100" /></td>
          <td><img src="img/login/13.jpg" width="100" height="100" /></td>
          <td><img src="img/login/14.jpg" width="100" height="100" /></td>
          <td><img src="img/login/15.jpg" width="100" height="100" /></td>
          <td><img src="img/login/16.jpg" width="100" height="100" /></td>
        </tr>
        <tr>
          <td><img src="img/login/17.jpg" width="100" height="100" /></td>
          <td><img src="img/login/18.jpg" width="100" height="100" /></td>
          <td><img src="img/login/19.jpg" width="100" height="100" /></td>
          <td><img src="img/login/20.jpg" width="100" height="100" /></td>
          <td><img src="img/login/21.jpg" width="100" height="100" /></td>
          <td><img src="img/login/22.jpg" width="100" height="100" /></td>
          <td><img src="img/login/23.jpg" width="100" height="100" /></td>
          <td><img src="img/login/24.jpg" width="100" height="100" /></td>
        </tr>
        <tr>
          <td><img src="img/login/25.jpg" width="100" height="100" /></td>
          <td><img src="img/login/26.jpg" width="100" height="100" /></td>
          <td><img src="img/login/27.jpg" width="100" height="100" /></td>
          <td><img src="img/login/28.jpg" width="100" height="100" /></td>
          <td><img src="img/login/29.jpg" width="100" height="100" /></td>
          <td><img src="img/login/30.jpg" width="100" height="100" /></td>
          <td><img src="img/login/31.jpg" width="100" height="100" /></td>
          <td><img src="img/login/32.jpg" width="100" height="100" /></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#A1BFFF"><img src="img/login/33.jpg" width="100" height="100" /></td>
          <td style="background-image:url(img/login/44.jpg); background-repeat:repeat-x; vertical-align:top;" colspan="6" rowspan="2"><form id="form1" name="form1" method="post">
              <!--  LOGIN SECTION -->
              <!-- LOGIN ERROR SECTION -->
              <?php if($error) { ?>
              <div id="loginError"><?php echo $error; ?></div>
              <?php } ?><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><div id="loginScreen">
                <div class="sideLabel">
                  <table border="0" cellspacing="0" cellpadding="4" style="border:1px solid #0099CC; background-color:#FFFFFF">
                    <tr>
                      <td nowrap><div align="right">No Kad Pengenalan </div></td>
                      <td><div align="right">
                        <input name="userID" type="text" class="inputInput" id="userID" size="10" maxlength="10" />
                      </div></td>
                    </tr>
                    <tr>
                      <td><div align="right">Kata Laluan : </div></td>
                      <td><div align="right">
                        <input name="userPassword" type="password" class="inputInput" id="userPassword" size="10" maxlength="15" />
                      </div></td>
                    </tr>
                    <tr>
                      <td colspan="2"><div align="right">
                        <input name="login" type="submit" class="inputButton" id="login" value="Log Masuk" 
			onClick="if(form1.userID.value != '' && form1.userPassword.value != '') {form1.submit();} else {alert('<?php echo LOGIN_ERROR_MSG; ?>'); form1.userID.focus(); return false; }" <?php if(LIMIT_TO_FIREFOX_2 == true) { if(checkBrowser() != 'Mozilla Firefox 2.0 (Gecko/Firefox)') echo 'disabled'; } ?> />
                        <input name="login2" type="reset" class="inputButton" id="login2" value="Reset" />
                      </div></td>
                    </tr>
                  </table>
                </div>
                <div class="sideLabel">
                  <div></div>
                </div>
                <div></div>
              </div></td>
  </tr>


              
			  </table>
              <!-- END LOGIN SECTION -- >
			<!-- FALCON CREDIT -->
              <div id="loginFalconCredit"><?php echo LOGIN_FALCON_CREDIT; ?>. Best viewed using Mozilla Firefox in 1280 x 1024 resolution.
                <!-- END FALCON CREDIT --><?php if(LIMIT_TO_FIREFOX_2 == true) { ?>
              <strong style="color:#FF0000"><br>LOGIN DISABLED. PLEASE USE ONLY MOZILLA FIREFOX 2.</strong><?php } ?></div>
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
            </form>
             </td>
          <td valign="top" bgcolor="#A1BFFF"><img src="img/login/33.jpg" width="100" height="100" /></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#A1BFFF"><img src="img/login/41.jpg" width="100" height="100" /></td>
          <td valign="top" bgcolor="#A1BFFF"><img src="img/login/41.jpg" width="100" height="100" /></td>
        </tr>
      </table></td>
    <td style="background-image:url(img/login/kanan.jpg); background-repeat:repeat-x">&nbsp;</td>
  </tr>
</table>
</body>
</html>