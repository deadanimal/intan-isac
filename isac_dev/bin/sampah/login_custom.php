<?php
//if login permohonan individu
if($_POST['login_permohonan_individu'])
{
	//check status
	$chkStatus = "select b.kod_status_kehadiran
					from usr_isac.pro_peserta a, usr_isac.prs_penilaian_peserta b
					where (a.no_kad_pengenalan='".$_POST['publicID']."' or a.no_kad_pengenalan_lain='".$_POST['publicID']."')
					and a.id_peserta=b.id_peserta";
	$chkStatusRs = $myQuery->query($chkStatus,'SELECT');

	//if status =02
	if($chkStatusRs[0][0]=='02')
	{	
		//$error='Anda telah disenarai hitamkan.';
		echo "<script language=javascript>alert('Anda telah disenaraihitamkan'); </script>";
	}
	else
	{	
		//check kumpulan
		$daftar="select a.id_peserta
				from usr_isac.prs_permohonan a, usr_isac.pro_peserta b
				where (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."') and
				b.kod_kategori_peserta=02 and a.kod_status_permohonan='active' 
				and a.id_peserta=b.id_peserta";
		$daftarRs=$myQuery->query($daftar,'SELECT');
		
		//if kumpulan exist
		if(!$daftarRs)
		{
			//set session
			$_SESSION['loginFlag']=true;
			$_SESSION['userID']=35;
			$_SESSION['publicID']=$_POST['publicID'];
			$_SESSION['myKod']=$_POST['myKod'];
			
			//redirect to public page (mohon individu)
			redirect('index.php?page=page_wrapper&menuID=171');
		}//eof if
		else
		{
			echo "<script language=javascript>alert('Anda telah didaftarkan dalam kategori kumpulan'); </script>";
		}//eof else
	}//eof else
}//eof if

//else if login permohonan kumpulan
else if($_POST['login_permohonan_kumpulan'])
{	
	//check penyelaras
	$chkPenyelaras = "select username,userpassword
						from usr_isac.pro_penyelaras
						where username='".$_POST['coordinatorID']."' and userpassword='".$_POST['coordinatorPassword']."'";
	$chkPenyelarasRs = $myQuery->query($chkPenyelaras,'SELECT');
	
	//if status =02
	if($chkPenyelarasRs)
	{
		//set session
		$_SESSION['loginFlag']=true;
		$_SESSION['userID']=36;
		$_SESSION['publicID']=$_POST['coordinatorID'];
	
		//redirect to public page (mohon kumpulan)
		redirect('index.php?page=page_wrapper&menuID=172');
	}//eof if
	else
	{			
		$error='Anda tidak wujud.';
	}//eof else
}//eof if

//else if login penilaian
else if($_POST['login_penilaian'])
{
	//set session
	$_SESSION['loginFlag']=true;
	$_SESSION['userID']=37;
	$_SESSION['publicID']=$_POST['publicID'];
	$_SESSION['myKod']=$_POST['myKod'];
	
	//redirect to public page (penilaian)
	redirect('index.php?page=page_wrapper&menuID=92');
}//eof if

//else if login semakan
else if($_POST['login_semakan'])
{
	//set session
	$_SESSION['loginFlag']=true;
	$_SESSION['userID']=38;
	$_SESSION['publicID']=$_POST['publicID'];
	$_SESSION['myKod']=$_POST['myKod'];
	
	//redirect to public page (semakan)
	redirect('index.php?page=page_wrapper&menuID=25');
}//eof if
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?=SYSTEM_FULL_NAME;?>
</title>

<style type="text/css">
<!--
body {
	background-color: #E8A20C;
	margin-left: 0%;
	margin-top: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
	background-repeat: no-repeat;
	background-position: center;
	background-position:top;
}

.permohonanTitle
{ color:#FFFFFF; font-weight:bold; text-transform:uppercase;}

.permohonanOption
{ color:#FFFF01; font-weight:bold;}

.tableLabel
{ color:#FFFFFF; text-align:right; width:200px; font-weight:bold; font-size:14px;}

.tableInput
{ text-align:right;}

.tableFooter
{ text-align:right; padding:0px;}
-->
</style>

<script>
//switch permohonan
function switchPermohonan(type)
{
	switch(type)
	{
		case 'individu':
			document.getElementById('permohonan_individu').style.display='';
			document.getElementById('permohonan_kumpulan').style.display='none';
			break;
		case 'kumpulan':
			document.getElementById('permohonan_individu').style.display='none';
			document.getElementById('permohonan_kumpulan').style.display='';
			break;
	}//eof switch
}//eof function

//switch id type
function switchIdentification(enable,disable)
{
	a=document.getElementById(enable);
	b=document.getElementById(disable);
	
	//if have value
	if(a.value)
	{
		b.value='';
		b.disabled=true;
	}//eof if
	else
		b.disabled=false;
}//eof function

//validate credentials
function validateCredentials(type)
{	
	//switch type of screen
	switch(type)
	{
		//mohon individu
		case 'individu':
			if(!document.getElementById('myKad').value&&!document.getElementById('myOther').value)
			{
				alert('Sila isi samada No.MyKad atau No.Polis/Askar/Pasport');
				return false;
			}//eof if
			
			break;
		
		//mohon kumpulan
		case 'kumpulan':
			if(!document.getElementById('coordinatorID').value)
			{
				alert('Sila isi ID Penyelaras');
				return false;
			}//eof if
			else if(!document.getElementById('coordinatorPassword').value)
			{
				alert('Sila isi Kata Laluan');
				return false;
			}//eof else if
			break;
			
		//nilai
		case 'nilai':
			if(!document.getElementById('myKad').value&&!document.getElementById('myOther').value)
			{
				alert('Sila isi samada No.MyKad atau No.Polis/Askar/Pasport');
				return false;
			}//eof if
			else if(!document.getElementById('idPenilaian').value)
			{
				alert('Sila isi ID Penilaian');
				return false;
			}//eof else if
			
			break;
	}//eof switch
	
	return true;
}//eof function
</script>

<link href="css/screen.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="document.getElementById('myKad').focus()" bgcolor="#A1BFFF">
<form id="form1" name="form1" method="post">

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
      <td align="center"><img src="custom_isac/isac3a.gif" align="top" /></td>
  </tr>
  <tr>
    <td align="center">
		<!-- LOGIN ERROR SECTION -->
		<?php if($error) { ?>
			<div id="loginError"><?php echo $error; ?></div>
		<?php } ?>

		<!--  LOGIN SECTION -->
		
		<?php if(!$_GET['mode']){?>
		<!--default / admin-->
		<table id="admin" width="50%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td class="tableLabel">Nama Pengguna :</td>
            <td class="tableInput"><input name="userID" type="text" class="inputInput" id="userID" size="38" /></td>
          </tr>
          <tr>
            <td class="tableLabel">Kata Laluan : </td>
            <td class="tableInput"><input name="userPassword" type="password" class="inputInput" id="userPassword" size="38" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input name="login" type="submit" class="inputButton" id="login" value="Log Masuk" style="margin-top:8px;"
				onclick="if(form1.userID.value != '' && form1.userPassword.value != '') {return true} else {alert('<?php echo LOGIN_ERROR_MSG; ?>'); form1.userID.focus(); return false; }" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
			</td>
          </tr>
        </table>
		<!--eof default / admin-->
		<?php }?>
			
		<?php if($_GET['mode']=='mohon'){?>
		<!--permohonan-->
		<table width="50%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="permohonanTitle">Kategori Permohonan</td>
          </tr>
		  <tr>
            <td class="permohonanOption"><label><input id="permohonanType" name="permohonanType" type="radio" value="individu" onClick="switchPermohonan(this.value)" checked="checked" />Individu</label></td>
          </tr>
		  <tr>
            <td class="permohonanOption"><label><input id="permohonanType" name="permohonanType" type="radio" value="kumpulan" onClick="switchPermohonan(this.value)" />Kumpulan</label></td>
          </tr>
        </table>
		
		<!--permohonan (individu)-->
		<table id="permohonan_individu" width="50%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td class="tableLabel">No.MyKad : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myKad" size="30" maxlength="12" onKeyUp="switchIdentification('myKad', 'myOther'); if(this.value){document.getElementById('myKod').value='1';}" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td class="tableLabel">No.Polis/Askar/Pasport : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myOther" size="30" onKeyUp="switchIdentification('myOther', 'myKad'); if(this.value){document.getElementById('myKod').value='2';}" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input name="myKod" type="hidden" id="myKod">
            <input id="login_permohonan_individu" name="login_permohonan_individu" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('individu')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
			</td>
          </tr>
        </table>
		<!--eof permohonan (individu)-->
		
		<!--permohonan (kumpulan)-->
		<table id="permohonan_kumpulan" width="50%" border="0" align="center" cellpadding="2" cellspacing="2" style="display:none">
          <tr>
            <td class="tableLabel">Id Penyelaras  : </td>
            <td class="tableInput"><input name="coordinatorID" type="text" class="inputInput" id="coordinatorID" size="30" maxlength="10" /></td>
          </tr>
          <tr>
            <td class="tableLabel">Katalaluan : </td>
            <td class="tableInput"><input name="coordinatorPassword" type="password" class="inputInput" id="coordinatorPassword" size="30" maxlength="15" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input id="login_permohonan_kumpulan" name="login_permohonan_kumpulan" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('kumpulan')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
            </td>
          </tr>
        </table>
		<!--eof permohonan (kumpulan)-->
		<!--eof permohonan-->
		<?php }?>
		
		<?php if($_GET['mode']=='nilai'){?>
		<!--penilaian-->
		<table id="penilaian" width="50%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td class="tableLabel">No.MyKad : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myKad" size="30" maxlength="12" onKeyUp="switchIdentification('myKad', 'myOther');" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td class="tableLabel">No.Polis/Askar/Pasport : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myOther" size="30" onKeyUp="switchIdentification('myOther', 'myKad');" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td class="tableLabel">ID Penilaian : </td>
            <td class="tableInput"><input name="idPenilaian" type="password" class="inputInput" id="idPenilaian" size="30" maxlength="15" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input id="login_penilaian" name="login_penilaian" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('nilai')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
			</td>
          </tr>
        </table>
		<!--eof penilaian-->
		<?php }?>
		
		<?php if($_GET['mode']=='semak'){?>
		<!--semakan-->
		<table id="semakan" width="50%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td class="tableLabel">No.MyKad : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myKad" size="30" maxlength="12" onKeyUp="switchIdentification('myKad', 'myOther'); if(this.value){document.getElementById('myKod').value='1';}" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td class="tableLabel">No.Polis/Askar/Pasport : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myOther" size="30" onKeyUp="switchIdentification('myOther', 'myKad'); if(this.value){document.getElementById('myKod').value='2';}" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input name="myKod" type="hidden" id="myKod">
            <input id="login_semakan" name="login_semakan" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('individu')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
			</td>
          </tr>
        </table>
		<!--eof semakan-->
		<?php }?>
		
		<!-- END LOGIN SECTION -->
		<!-- FALCON CREDIT -->
		<div id="loginFalconCredit" style="font-weight:bold;"> <?php echo LOGIN_FALCON_CREDIT; ?>. <br>Best viewed using Mozilla Firefox in 1280 x 1024 resolution.
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
	</td>
  </tr>
</table>
</form>
</body>
</html>