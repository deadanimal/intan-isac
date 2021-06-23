<!--17082009
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SYSTEM_FULL_NAME;?></title>
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

<style type="text/css">
<!--
body {
	background-color: #0066CB;
	margin-left: 0%;
	margin-top: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
	background-image: url(qq/isac3.jpg);
	background-repeat: no-repeat;
	background-position: center;
}
                    

.style50 {
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
}
.style51 {color: #000000}
.style56 {font-size: 12px}
.style57 {
	font-size: 13px;
	font-weight: bold;
}
.style58 {
	font-size: 13px;
	font-weight: bold;
	text-align:right;
	color: #FFFFFF;
	border-bottom-color:#FFFFFF;
}
-->
</style>
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<style type="text/css">
<!--
.style61 {color: #FFFF01}
#Layer1 {
	position:absolute;
	left:170px;
	top:313px;
	width:749px;
	height:108px;
	z-index:1;
}
-->
</style>
</head>
<body onLoad="document.form1.userID.focus()" bgcolor="#A1BFFF">
<div id="Layer1">
  <table width="100%" align="center">
    <tr>
      <td height="93">
      	
        <?php if($_GET['mode']=='permohonan'){?>
        <table width="50%" border="0" align="center">
          <tr>
            <td class="style15 style50">KATEGORI PERMOHONAN : </td>
          </tr>
          <tr>
            <td><label><input onclick="showt1(); document.getElementById('lbluserid').innerHTML='No. My Kad';document.getElementById('lbluserid2').innerHTML='No. Passport'"  name="radiobutton" type="radio" value="radiobutton" /><span class="style57 style61">Individu</span></label></td>
          </tr>
          <tr>
            <td><label><input onclick="showt1(); document.getElementById('lbluserid').innerHTML='Id PEnyelaras'; document.getElementById('lbluserid2').innerHTML='Kata Laluan'" name="radiobutton" type="radio" value="radiobutton" /><span class="style57 style61">Kumpulan</span></label></td>
          </tr>
          </table>
        <?php }?>
        <p></p>
        <div align="left" class="style58">
            <table id="t1" style="display: none;" width="50%" border="0" align="center">
              <tr>
                <td><form id="form2" name="form2" method="post" action="">
                   <!--  LOGIN SECTION -->
                    <!-- LOGIN ERROR SECTION -->
                    <?php if($error) { ?>
                    <div id="loginError"><?php echo $error; ?></div>
                  <?php } ?>
                    <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#FFCC00" class="style9">
                      <tr>
                        <td width="200"><label id="lbluserid">No. My Kad</label> : </td>
                        <td><input name="userID" type="text" class="inputInput" id="userID" size="30" maxlength="12"/>
                        </td>
                      </tr>
                      <tr>
                        <td width="200"><label id="lbluserid2">No. Polis/ Askar/ Pasport :</label> </td>
                        <td><input name="userID" type="text" class="inputInput" id="userID2" size="30" maxlength="12"/>
                        </td>
                      </tr>
                      <?php if(!$_GET['mode']){?>
                     <tr>
                        <td width="200"><span class="style1">Katalaluan : </span></td>
                        <td><input name="userPassword" type="password" class="inputInput" id="userPassword" size="30" maxlength="15" /></td>
                      </tr>
                      <?php }?>
                      <tr>
                        <td colspan="2"><input name="login" type="submit" class="inputButton" id="login" value="Log Masuk" 
			onclick="if(form2.userID.value != '' &amp;&amp; form2.userPassword.value != '') {form2.submit();} else {alert('<?php echo LOGIN_ERROR_MSG; ?>'); form2.userID.focus(); return false; }" <?php if(LIMIT_TO_FIREFOX_2 == true) { if(checkBrowser() != 'Mozilla Firefox 2.0 (Gecko/Firefox)') echo 'disabled'; } ?>/>
                            <input name="login2" type="reset" class="inputButton" id="login2" value="Reset"/>
                        </td>
                      </tr>
                    </table>
                  <!-- END LOGIN SECTION -- >
			<!-- FALCON CREDIT -->
                    <div id="loginFalconCredit"><?php echo LOGIN_FALCON_CREDIT; ?>. Best viewed using Mozilla Firefox in 1280 x 1024 resolution.
                      <!-- END FALCON CREDIT -->
                        <?php if(LIMIT_TO_FIREFOX_2 == true) { ?>
                        <strong style="color:#FF0000"><br />
                          LOGIN DISABLED. PLEASE USE ONLY MOZILLA FIREFOX 2.</strong>
                        <?php } ?>
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
                </form></td>
              </tr>
            </table>
          <table id="t2" <?php if($_GET['mode']){?>style="display: none;"<?php }?> width="50%" border="0" align="center">
              <tr>
                <td><form id="form1" name="form1" method="post" action="">
                     <!--  LOGIN SECTION -->
                    <!-- LOGIN ERROR SECTION -->
                    <?php if($error) { ?>
                    <div id="loginError"><?php echo $error; ?></div>
                  <?php } ?>
                    <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#FFCC00" class="style9">
                      <tr>
                        <td width="200"><span class="style1">Id Penyelaras  : </span></td>
                        <td><input name="userID" type="text" class="inputInput" id="userID" size="30" maxlength="10" /></td>
                      </tr>
                      <tr>
                        <td width="200"><span class="style1">Katalaluan : </span></td>
                        <td><input name="userPassword" type="password" class="inputInput" id="userPassword" size="30" maxlength="15" /></td>
                      </tr>
                      <tr>
                        <td colspan="2"><input name="login" type="submit" class="inputButton" id="login" value="Log Masuk" 
			onclick="if(form1.userID.value != '' &amp;&amp; form1.userPassword.value != '') {form1.submit();} else {alert('<?php echo LOGIN_ERROR_MSG; ?>'); form1.userID.focus(); return false; }" <?php if(LIMIT_TO_FIREFOX_2 == true) { if(checkBrowser() != 'Mozilla Firefox 2.0 (Gecko/Firefox)') echo 'disabled'; } ?> />
                            <input name="login2" type="reset" class="inputButton" id="login2" value="Reset" />
                            </label></td>
                      </tr>
                    </table>
                  <!-- END LOGIN SECTION -- >
				  				   
			<!-- FALCON CREDIT -->
                    <div id="loginFalconCredit"><?php echo LOGIN_FALCON_CREDIT; ?>. Best viewed using Mozilla Firefox in 1280 x 1024 resolution.
                      <!-- END FALCON CREDIT -->
                        <?php if(LIMIT_TO_FIREFOX_2 == true) { ?>
                        <strong style="color:#FF0000"><br />
                          LOGIN DISABLED. PLEASE USE ONLY MOZILLA FIREFOX 2.</strong>
                        <?php } ?>
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
                </form></td>
              </tr>
            </table>
        </div>
        <p></p></td>
    </tr>
  </table>
</div>
<p><br>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
  <br />
  <br>
  <br />
  <br>
  <br />
  <br>
  <br />
  <br>
  <br />
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
