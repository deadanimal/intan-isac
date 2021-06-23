<?php
include ('conf.php');

$mohon = "select max(a.id_permohonan) from usr_isac.prs_permohonan a,usr_isac.pro_peserta b where a.id_peserta=b.id_peserta and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."') ";
$mohonRs = $myQuery->query($mohon,'SELECT');
$id_mohon = $mohonRs[0][0];

$session = "select b.tarikh_sesi,b.id_sesi from usr_isac.prs_permohonan a,usr_isac.pro_sesi b where a.id_sesi=b.id_sesi and a.id_permohonan='".$id_mohon."' ";
$sessionRs = $myQuery->query($session,'SELECT');
$date_session = $sessionRs[0][0];
//$id_session = $sessionRs[0][1];



//if login permohonan individu
if($_POST['login_permohonan_individu'])
{
	//check status
/*	$chkStatus = "select b.kod_status_kehadiran
					from usr_isac.pro_peserta a, usr_isac.prs_penilaian_peserta b, usr_isac.prs_permohonan_peserta c
					where (a.no_kad_pengenalan='".$_POST['publicID']."' or a.no_kad_pengenalan_lain='".$_POST['publicID']."')
					and a.id_peserta=b.id_peserta and a.id_peserta=c.id_peserta
					and c.kod_status != 1";
	$chkStatusRs = $myQuery->query($chkStatus,'SELECT');
*/
	$failed = "select TEMPOH_KEBENARAN_PERMOHONAN_PESERTA_GAGAL from usr_isac.pro_kawalan_sistem where id_kawalan_sistem=1";
	$failedRs =$myQuery->query($failed,'SELECT');
	$active_failed = $failedRs[0][0];

	//search gagal -->peserta gagal, utk mohon semula perlu melepasi tempoh sebulan(kawalan sistem) dari tarikh penilaian
	$gagal="select d.kod_status_kelulusan
				from
				usr_isac.pro_peserta a,
				usr_isac.prs_permohonan b,
				usr_isac.pro_sesi c,
				usr_isac.prs_penilaian_peserta d
				where
				a.id_peserta=b.id_peserta
				and b.id_sesi=c.id_sesi
				and b.id_peserta=d.id_peserta
				and b.id_permohonan = '".$id_mohon."'
				and curdate() >= '".$date_session."'
				and (curdate() <=(adddate('".$date_session."','".$active_failed."')))
				and d.id_penilaian=(select max(d.id_penilaian) from usr_isac.pro_peserta a,usr_isac.prs_penilaian_peserta b where a.id_peserta=b.id_peserta and (a.no_kad_pengenalan='".$_POST['publicID']."' or a.no_kad_pengenalan_lain='".$_POST['publicID']."') )";

	$gagalRs=$myQuery->query($gagal,'SELECT');
	
	$gagalRs[0][0];

	$active = "select TEMPOH_KEBENARAN_PERMOHONAN_PESERTA_BLACKLIST 
                      from usr_isac.pro_kawalan_sistem 
                      where id_kawalan_sistem=1";
	$activeRs =$myQuery->query($active,'SELECT');
	$active_blacklist = $activeRs[0][0];
	
	
//	$chkStatus = "SELECT b.kod_status_kehadiran,d.kod_status
//						FROM 
//						usr_isac.pro_sesi a,
//						usr_isac.prs_permohonan b,
//						usr_isac.pro_peserta c,
//						usr_isac.prs_permohonan_peserta d
//						WHERE
//						a.id_sesi = b.id_sesi
//						and b.id_peserta = c.id_peserta
//						and c.id_peserta = d.id_peserta
//						and d.id_permohonan = '".$id_mohon."'
//						and curdate() >= '".$date_session."' and (curdate() <= (adddate('".$date_session."','".$active_blacklist."')))
//						and (c.no_kad_pengenalan='".$_POST['publicID']."' or c.no_kad_pengenalan_lain='".$_POST['publicID']."')";
//	$chkStatusRs = $myQuery->query($chkStatus,'SELECT');
        #update 20120602
        $chkStatus = "SELECT b.kod_status_kehadiran,
                             d.kod_status
                        FROM      usr_isac.pro_sesi                 a
                        LEFT JOIN usr_isac.prs_permohonan           b ON (a.id_sesi    = b.id_sesi)
                        LEFT JOIN usr_isac.pro_peserta              c ON (b.id_peserta = c.id_peserta)
                        LEFT JOIN usr_isac.prs_permohonan_peserta   d ON (d.id_permohonan = b.id_permohonan)
                        WHERE b.id_permohonan = '".$id_mohon."'
                        AND   curdate()      >= '".$date_session."' 
                        AND   (curdate()     <= (adddate('".$date_session."','".$active_blacklist."')))
                        AND   (c.no_kad_pengenalan='".$_POST['publicID']."' or c.no_kad_pengenalan_lain='".$_POST['publicID']."')";
	$chkStatusRs = $myQuery->query($chkStatus,'SELECT');
        
        $kehadiran = $chkStatusRs[0][0];
        $rayuan    = $chkStatusRs[0][1];

//if status =02 (tidak hadir penilaian), $chkStatusRs[0][1]!='01' (belum dpt rayuan keluar dr senarai blacklist)
if(($kehadiran == '02' && $rayuan == '') || ($kehadiran == '02' && $rayuan != '01'))
//if(count($chkStatusRs) > 0)
{		//echo  "<pre>";print_r($kehadiran);
//echo  "<pre>";print_r($rayuan);exit;
//$error='Anda telah disenarai hitamkan.';
echo "<script language=javascript>alert('Anda telah disenaraihitamkan'); </script>";
}
	
elseif($gagalRs[0][0]=='Gagal')
{
echo "<script language=javascript>alert('Harap maaf, anda tidak dibenarkan memohon semula dalam tempoh kurang daripada satu bulan daripada tarikh menduduki penilaian yang terakhir.'); </script>";

}
else{

$mohon = "select max(a.id_permohonan) from usr_isac.prs_permohonan a,usr_isac.pro_peserta b where a.id_peserta=b.id_peserta and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."') ";
$mohonRs = $myQuery->query($mohon,'SELECT'); 
$id_mohon = $mohonRs[0][0];
	
		//check kumpulan
		$daftar="select a.id_peserta
				from usr_isac.prs_permohonan a, usr_isac.pro_peserta b
				where 
				a.id_peserta=b.id_peserta
				and b.kod_kategori_peserta='02' and a.kod_status_permohonan='01' 
				and a.id_permohonan = '".$id_mohon."'
                                and curdate()      <= '".$date_session."' 
				and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."')";
		$daftarRs=$myQuery->query($daftar,'SELECT');
//		echo "<pre>";print_r($daftar);exit;
		//if kumpulan exist
		if(!$daftarRs)
		{
			//set session
			$_SESSION['loginFlag']=true;
			$_SESSION['loginMode']='mohon';
			$_SESSION['userID']=35;
			$_SESSION['publicID']=$_POST['publicID'];
			$_SESSION['myKod']=$_POST['myKod'];
			
			//redirect to public page (mohon individu)
			redirect('index.php?page=page_wrapper&menuID=171');
		}//eof if
		else
		{
			echo "<script language=javascript>alert('Harap maaf, nama anda telah dicalonkan dalam jadual bagi peserta kategori kumpulan.'); </script>";
		}//eof else
	}//eof else
}//eof if

//else if login permohonan kumpulan
else if($_POST['login_permohonan_kumpulan'])
{	

	//check penyelaras
	$chkPenyelaras = "select log_id_pengguna,katalaluan
						from usr_isac.pro_penyelaras
						where log_id_pengguna='".$_POST['coordinatorID']."' and katalaluan='".$_POST['coordinatorPassword']."'";
	$chkPenyelarasRs = $myQuery->query($chkPenyelaras,'SELECT');
	
	//if status =02
	if($chkPenyelarasRs)
	{
		//set session
		$_SESSION['loginFlag']=true;
		$_SESSION['loginMode']='mohon';
		$_SESSION['userID']=36;
		$_SESSION['publicID']=$_POST['coordinatorID'];
	
		//redirect to public page (mohon kumpulan)
		redirect('index.php?page=page_wrapper&menuID=27');
	}//eof if
	else
	{			
		//$error='Anda tidak wujud.';
		echo "<script language=javascript>alert('Anda tidak didaftarkan dalam kategori kumpulan'); </script>";
	}//eof else
}//eof if

//else if login penilaian
else if($_POST['login_penilaian'])
{
	$chkID = "select c.kod_pengesahan_penilaian
				from usr_isac.prs_permohonan a, 
				usr_isac.pro_peserta b,
				usr_isac.pro_sesi c
				where 
				a.id_sesi= c.id_sesi
				and a.id_peserta=b.id_peserta
				and a.id_permohonan = '".$id_mohon."'
				and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."')" ;
	$chkIDRs = $myQuery->query($chkID,'SELECT');
	$id_penilaian= $chkIDRs[0][0];

	//check penilaian
	$nilai="select a.id_peserta,a.id_sesi
				from usr_isac.prs_permohonan a, 
				usr_isac.pro_peserta b,
				usr_isac.pro_sesi c

				where 
				a.id_peserta=b.id_peserta
				and a.id_sesi=c.id_sesi

				and c.kod_status='01'
				and c.kod_pengesahan_penilaian='$id_penilaian'
				and a.id_permohonan = '".$id_mohon."'
				and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."')
				and c.kod_pengesahan_penilaian = '".$_POST['idPenilaian']."'
				and '".$date_session."' = curdate()";
	$nilaiRs=$myQuery->query($nilai,'SELECT');
	$id_sesi=$nilaiRs[0][1];

	//check kod status kelulusan
	$nilai2="select e.kod_status_kelulusan
				from usr_isac.prs_permohonan a, 
				usr_isac.pro_peserta b,
				usr_isac.pro_sesi c,
				usr_isac.prs_penilaian d,
				usr_isac.prs_penilaian_peserta e
				where 
				a.id_peserta=b.id_peserta
				and a.id_sesi=d.id_sesi
				and  a.id_sesi=c.id_sesi
				and a.id_sesi=(select id_sesi from usr_isac.prs_permohonan where id_permohonan='".$id_mohon."')
				and a.id_peserta=e.id_peserta
				and d.id_penilaian=e.id_penilaian
				and c.kod_status='01'
				and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."')
				and c.kod_pengesahan_penilaian = '".$_POST['idPenilaian']."'
				and '".$date_session."' = curdate()";
				
				$nilaiRs2=$myQuery->query($nilai2,'SELECT');
				$kod_status_lulus=$nilaiRs2[0][0];

if (($kod_status_lulus != ''))
{
echo "<script language=javascript>alert('Maaf, peserta telah menduduki penilaian.'); </script>";
}
	else if ($nilaiRs)
	{
	//set session
	$_SESSION['loginFlag']=true;
	$_SESSION['loginMode']='nilai';
	$_SESSION['userID']=37;
	$_SESSION['publicID']=$_POST['publicID'];
	$_SESSION['myKod']=$_POST['myKod'];
	$_SESSION['idPenilaian']=$_POST['idPenilaian'];
	
		//redirect to public page (penilaian)
		$nilai="select a.id_peserta,a.id_sesi,d.id_penilaian
					from usr_isac.prs_permohonan a, 
					usr_isac.pro_peserta b,
					usr_isac.pro_sesi c,
					usr_isac.prs_penilaian d
					where 
					a.id_peserta=b.id_peserta
					and a.id_sesi=c.id_sesi
					and c.id_sesi = d.id_sesi
					and a.id_permohonan = '".$id_mohon."'
					and c.kod_status='01'
					and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."')
					and c.kod_pengesahan_penilaian = '".$_POST['idPenilaian']."'
					and '".$date_session."' = curdate() ";
		$nilaiRs=$myQuery->query($nilai,'SELECT');
		$id_peserta=$nilaiRs[0][0];
		$id_sesi=$nilaiRs[0][1];
		$id_nilai=$nilaiRs[0][2];
		
		$kod_iac=KOD_IAC;

		//check if already exist
		$sql_check = "select e.id_penilaian_peserta
							from usr_isac.prs_permohonan a, 
							usr_isac.pro_peserta b,
							usr_isac.pro_sesi c,
							usr_isac.prs_penilaian d,
							usr_isac.prs_penilaian_peserta e
							where 
							a.id_peserta=b.id_peserta
							and a.id_sesi=d.id_sesi
							and  a.id_sesi=c.id_sesi
							and a.id_sesi=(select id_sesi from usr_isac.prs_permohonan where id_permohonan='".$id_mohon."')
							and a.id_peserta=e.id_peserta
							and d.id_penilaian=e.id_penilaian
							and (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."')";
		$checkRs = $myQuery->query($sql_check,'SELECT');
		//$id_peserta = $checkRs[0][1];
		//$id_nilai_peserta =$checkRs[0][0];
	
		if(count($checkRs)==0)
		{
		
		$sql = "insert into usr_isac.prs_penilaian_peserta (kod_status_kehadiran,id_penilaian,id_peserta,status_push_pull) values ('01','".$id_nilai."','".$id_peserta."','I')";
		$result = $myQuery->query($sql,'RUN');
		
		$combine_kod = "select concat('".$kod_iac."',(select max(id_penilaian_peserta) from usr_isac.prs_penilaian_peserta))";
		$combineRs = $myQuery->query($combine_kod,'SELECT');
		$combine_iac = $combineRs[0][0];
		
		$exam = "select max(id_penilaian_peserta) from usr_isac.prs_penilaian_peserta where id_peserta='".$id_peserta."'";
		$examRs = $myQuery->query($exam,'SELECT');
		$exam_id = $examRs[0][0];
		
		$sql2 = "update usr_isac.prs_penilaian_peserta set kod_penilaian_peserta='".$combine_iac."' where id_penilaian_peserta='".$exam_id."'";
		$result2 = $myQuery->query($sql2,'RUN');
		//update status permohonan, kod_status = 02(telah menduduki penilaian,permohonan=inactive)
		$sql3 = "update usr_isac.prs_permohonan set kod_status_permohonan = '02',kod_status_kehadiran='01',status_push_pull='U' where id_peserta='".$id_peserta."' and id_permohonan='".$id_mohon."'";
		$result3 = $myQuery->query($sql3,'RUN');
	
		redirect('index.php?page=page_wrapper&menuID=126');
		}
		else
		{
		
		$sql = "update usr_isac.prs_penilaian_peserta set kod_status_kehadiran='01' where id_penilaian='".$id_nilai."' and id_peserta='".$id_peserta."'";
		$result = $myQuery->query($sql,'RUN');
		
		//update status permohonan, kod_status = 02(telah menduduki penilaian,permohonan=inactive)
		$sql3 = "update usr_isac.prs_permohonan set kod_status_permohonan = '02',kod_status_kehadiran='01',status_push_pull='U' where id_peserta='".$id_peserta."' and id_permohonan='".$id_mohon."'";
		$result3 = $myQuery->query($sql3,'RUN');
		
		redirect('index.php?page=page_wrapper&menuID=126');
		}
		
	}//eof else if
/*	else if ($kod_status_lulus != '')
	{
	echo "<script language=javascript>alert('Maaf, peserta telah menduduki penilaian.'); </script>";
	}
*/	else
	{	
	//$error='sesi penilaian belum disahkan.';
	echo "<script language=javascript>alert('Maaf, sesi penilaian belum disahkan oleh pengawas bertugas.'); </script>";
	}//eof else
}//eof else if


//else if login semakan
else if($_POST['login_semakan'])
{

	//check peserta
	$check="select a.id_peserta
			from usr_isac.prs_permohonan a, usr_isac.pro_peserta b
			where (b.no_kad_pengenalan='".$_POST['publicID']."' or b.no_kad_pengenalan_lain='".$_POST['publicID']."')
			and a.id_peserta=b.id_peserta";
	$checkRs=$myQuery->query($check,'SELECT');
	$user = $checkRs[0][0];
	
	if ($user)
	{ 
	//set session
	$_SESSION['loginFlag']=true;
	$_SESSION['loginMode']='semak';
	$_SESSION['userID']=38;
	$_SESSION['publicID']=$_POST['publicID'];
	$_SESSION['myKod']=$_POST['myKod'];

	//redirect to public page (semakan)
	redirect('index.php?page=page_wrapper&menuID=6273');
	}
	else
	{
	echo "<script language=javascript>alert('Harap maaf, anda belum berdaftar.'); </script>";
	}
}//eof if
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php echo SYSTEM_FULL_NAME;?>
</title>

<style type="text/css">
<!--
body {
	background-color: #FF6600;
	margin-left: 0%;
	margin-top: 0%;
	margin-right: 0%;
	margin-bottom: 0%;
	background-repeat: no-repeat;
	background-position: center;
	background-position:top;
}

.permohonanTitle
{ color:#FFFFFF; font-weight:bold; text-transform:uppercase; text-align:left;}

.permohonanOption
{ color:#FFFF01; font-weight:bold; text-align:left;}

.tableLabel
{ color:#FFFFFF; text-align:right; width:200px; font-weight:bold; font-size:14px;}
.tableLabel2
{ color:#FFFFFF; text-align:left; width:200px; font-weight:bold; font-size:12px;}
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
			
			//button
			document.getElementById('login_permohonan_individu').type='submit';
			document.getElementById('login_permohonan_kumpulan').type='button';
			
			//focus
			document.getElementById('myKad').focus();
			break;
		case 'kumpulan':
			document.getElementById('permohonan_individu').style.display='none';
			document.getElementById('permohonan_kumpulan').style.display='';
			
			//button
			document.getElementById('login_permohonan_individu').type='button';
			document.getElementById('login_permohonan_kumpulan').type='submit';
			
			//focus
			document.getElementById('coordinatorID').focus();
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
				alert('Sila isi samada No.MyKad atau No.Polis/Tentera/Pasport');
				return false;
			}//eof if
			else if(document.getElementById('myKad').value&&document.getElementById('myKad').value.length!=12)
			{
				alert('Maaf No.MyKad anda tidak sah, sila masukkan semula.');
				return false;
			}
			
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
				alert('Sila isi samada No.MyKad atau No.Polis/Tentera/Pasport');
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

function noSpace(e)
{
var snum;
var schar;
var scheck;

if(window.event) // IE
	{
	snum = e.keyCode;
	}
else if(e.which) // Netscape/Firefox/Opera
	{
	snum = e.which;
	}
schar = String.fromCharCode(snum);
scheck = /^[0-9]+$/;
return !scheck.test(schar);
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function extractNumber(obj, decimalPlaces, allowNegative)
{
	var temp = obj.value;
	
	// avoid changing things if already formatted correctly
	var reg0Str = '[0-9]*';
	if (decimalPlaces > 0) {
		reg0Str += '\\.?[0-9]{0,' + decimalPlaces + '}';
	} else if (decimalPlaces < 0) {
		reg0Str += '\\.?[0-9]*';
	}
	reg0Str = allowNegative ? '^-?' + reg0Str : '^' + reg0Str;
	reg0Str = reg0Str + '$';
	var reg0 = new RegExp(reg0Str);
	if (reg0.test(temp)) return true;

	// first replace all non numbers
	var reg1Str = '[^0-9' + (decimalPlaces != 0 ? '.' : '') + (allowNegative ? '-' : '') + ']';
	var reg1 = new RegExp(reg1Str, 'g');
	temp = temp.replace(reg1, '');

	if (allowNegative) {
		// replace extra negative
		var hasNegative = temp.length > 0 && temp.charAt(0) == '-';
		var reg2 = /-/g;
		temp = temp.replace(reg2, '');
		if (hasNegative) temp = '-' + temp;
	}
	
	if (decimalPlaces != 0) {
		var reg3 = /\./g;
		var reg3Array = reg3.exec(temp);
		if (reg3Array != null) {
			// keep only first occurrence of .
			//  and the number of places specified by decimalPlaces or the entire string if decimalPlaces < 0
			var reg3Right = temp.substring(reg3Array.index + reg3Array[0].length);
			reg3Right = reg3Right.replace(reg3, '');
			reg3Right = decimalPlaces > 0 ? reg3Right.substring(0, decimalPlaces) : reg3Right;
			temp = temp.substring(0,reg3Array.index) + '.' + reg3Right;
		}
	}
	
	obj.value = temp;
}
function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{
	var key;
	var isCtrl = false;
	var keychar;
	var reg;
		
	if(window.event) {
		key = e.keyCode;
		isCtrl = window.event.ctrlKey
	}
	else if(e.which) {
		key = e.which;
		isCtrl = e.ctrlKey;
	}
	
	if (isNaN(key)) return true;
	
	keychar = String.fromCharCode(key);
	
	// check for backspace or delete, or if Ctrl was pressed
	if (key == 8 || isCtrl)
	{
		return true;
	}

	reg = /\d/;
	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
	
	return isFirstN || isFirstD || reg.test(keychar);
}

function validate_ic(txtbx,warn)
{
with (txtbx)
{
leng=value.length;
if (leng!=12) 
  {alert(warn);return false;}
else {return true;}
}
}
/*function validate_form(thisform)
{
with (thisform)
{
 if (validate_ic(myKad,"Maaf No.MyKad anda tidak sah, sila masukkan semula")==false)
  {myKad.focus();return false;}
}
}
*/
//disable control key
function onKeyDown() 
{
// current pressed key
var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

if (event.ctrlKey && (pressedKey == "c" || pressedKey == "v")) 
{
// disable key press porcessing
event.returnValue = false;
}
} // onKeyDown
//disable right click
function whichButton(event)
{
if (event.button==2)//RIGHT CLICK
{
alert("Not Allow Right Click!");
}

}


</script>
<script language='javascript'>
//disable right-click
//var mykad = document.getElementById('ic');
this.document.oncontextmenu = function(){
window.status = 'Right-click is disabled';
return false;
}

//form tags to omit in NS6+:
var omitformtags=["input", "textarea", "select"]

omitformtags=omitformtags.join("|")

function disableselect(e){
if (omitformtags.indexOf(e.target.tagName.toLowerCase ())==-1)
return false
}

function reEnable(){
return true
}

if (typeof document.onselectstart!="undefined")
document.onselectstart=new Function ("return false")
else{
document.onmousedown=disableselect
document.onmouseup=reEnable
}

/*function do_err()
    {
        return true
    }
onerror=do_err;

function no_cp()
    {
        clipboardData.clearData();setTimeout("no_cp()",100)
    }
no_cp();*/
</script> 


<link href="css/screen.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {font-size: 14px}
.style4 {font-size: 16px}
.style5 {color: #CCCCCC; font-size:10px}
.style6 {color: #FFFFFF}
-->
</style>
</head>

<?php
//switch onload
switch($_GET['mode'])
{
	case 'mohon':
	case 'nilai':
	case 'semak':	$focusText = 'myKad';
		break;
	default:		$focusText = 'userID';
		break;
}//eof switch
?>

<body onLoad="document.getElementById('<?php echo $focusText;?>').focus()">
<form id="form1" name="form1" method="post" >
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
      <td align="center"><img src="img/loginpage.jpg" align="top" /></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FF6600">
		<!-- LOGIN ERROR SECTION -->
		<?php if($error) { ?>
	  <div class="style6" id="loginError">
			<?php /*echo $error;*/ 
			echo "<script language=javascript>alert('Ralat! Nama Pengguna atau Kata Laluan yang diberi tidak tepat.'); </script>"; ?></div>
		<?php } ?>

		<!--  LOGIN SECTION -->
		
		<?php if(!$_GET['mode']){?>
		<!--default / admin-->
		<table id="admin" width="39%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td class="tableLabel">Nama Pengguna :</td>
            <td class="tableInput"><input name="userID" type="text" class="inputInput" id="userID" size="38" /></td>
          </tr>
          <tr>
            <td class="tableLabel">Kata Laluan : </td>
            <td class="tableInput"><input name="userPassword" type="password" class="inputInput" id="userPassword" size="38" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><span class="tableInput">
            	<input name="login" type="submit" class="inputButton" id="login" value="Log Masuk"
				onclick="if(form1.userID.value != '' && form1.userPassword.value != '') {return true} else {alert('<?php echo LOGIN_ERROR_MSG; ?>'); form1.userID.focus(); return false; }" />
            </span>
            <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
			</td>
          </tr>
        </table>
		<!--eof default / admin-->
		<?php }?>
			
		<?php if($_GET['mode']=='mohon'){?>
		<!--permohonan-->
		<table width="64%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="permohonanTitle style4">Kategori Permohonan</td>
          </tr>
		  <tr>
            <td class="permohonanOption"><label><input id="permohonanType" name="permohonanType" type="radio" value="individu" onClick="switchPermohonan(this.value)" checked="checked" />
            <span class="style3">Individu</span></label></td>
          </tr>
		  <tr>
            <td class="permohonanOption"><label><input id="permohonanType" name="permohonanType" type="radio" value="kumpulan" onClick="switchPermohonan(this.value)" />
            <span class="style3">Kumpulan</span></label></td>
          </tr>
          <tr>
              <td colspan="2">
              <!--permohonan (individu)-->
		<table id="permohonan_individu" width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
          
          <tr>
            <td width="200" class="tableLabel">No.MyKad : </td>
            <td width="194" class="tableInput"><input name="publicID" type="text" class="inputInput" id="myKad" size="38" maxlength="12" onKeyUp="switchIdentification('myKad', 'myOther'); if(this.value){document.getElementById('myKod').value='1';}" onBlur="this.onkeyup()" onkeypress="return blockNonNumbers(this, event, false, false);extractNumber(this,0,false);" onkeydown= "onKeyDown()" /></td>
            <td width="221"><span class="tableLabel2">*Contoh : 860909331234 (Tanpa '-')</span></td>
          </tr>
            <tr>
            <td nowrap="nowrap" class="tableLabel"> </td>
            <td class="tableLabel2"><div align="center">Atau</div></td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="tableLabel">No.Polis/Tentera/Pasport : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myOther" size="38" onKeyUp="switchIdentification('myOther', 'myKad'); if(this.value){document.getElementById('myKod').value='2';}" onBlur="this.onkeyup()" onkeydown = "onKeyDown()"/></td>
          </tr>
          <tr>
            <td height="40" colspan="2" class="tableFooter"><input name="myKod" type="hidden" id="myKod">
            	<input id="login_permohonan_individu" name="login_permohonan_individu" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('individu')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />			</td>
          </tr>
        </table>
		<!--eof permohonan (individu)-->
		
		<!--permohonan (kumpulan)-->
		<table id="permohonan_kumpulan" width="39%" border="0" align="center" cellpadding="2" cellspacing="2" style="display:none">
          <tr>
            <td  nowrap="nowrap" class="tableLabel">ID Penyelaras  : </td>
            <td class="tableInput"><input name="coordinatorID" type="text" class="inputInput" id="coordinatorID" size="38" maxlength="10" onkeypress="if(event.keyCode==13){document.getElementById('login_permohonan_kumpulan').onclick();}" /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          </tr>
          <tr>
            <td class="tableLabel">Katalaluan : </td>
            <td class="tableInput"><input name="coordinatorPassword" type="password" class="inputInput" id="coordinatorPassword" size="38" maxlength="15" onkeypress="if(event.keyCode==13){document.getElementById('login_permohonan_kumpulan').onclick();}" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input id="login_permohonan_kumpulan" name="login_permohonan_kumpulan" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('kumpulan')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
            </td>
          </tr>
        </table>
		<!--eof permohonan (kumpulan)-->
              </td>
          </tr>
        </table>
		
		<!--eof permohonan-->
		<?php }?>
		
		<?php if($_GET['mode']=='nilai'){?>
		<!--penilaian-->
		<table id="penilaian" width="64%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td class="tableLabel">No.MyKad : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myKad" size="38" maxlength="12" onKeyUp="switchIdentification('myKad', 'myOther'); if(this.value){document.getElementById('myKod').value='1';}" onBlur="this.onkeyup()" onkeypress="return blockNonNumbers(this, event, false, false);extractNumber(this,0,false);"/></td>
            <td width="221"><span class="tableLabel2">*Contoh : 860909331234 (Tanpa '-')</span></td>
          </tr>
           <tr>
            <td nowrap="nowrap" class="tableLabel"> </td>
            <td class="tableLabel2"><div align="center">Atau</div></td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="tableLabel">No.Polis/Tentera/Pasport : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myOther" size="38" onKeyUp="switchIdentification('myOther', 'myKad'); if(this.value){document.getElementById('myKod').value='2';}" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td class="tableLabel">ID Penilaian : </td>
            <td class="tableInput"><input name="idPenilaian" type="password" class="inputInput" id="idPenilaian" size="38" maxlength="15" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input name="myKod" type="hidden" id="myKod">
				<input id="login_penilaian" name="login_penilaian" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('nilai')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />
			</td>
          </tr>
        </table>
		<!--eof penilaian-->
		<?php }?>
		
		<?php if($_GET['mode']=='semak'){?>
		<!--semakan-->
		<table id="semakan" width="64%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td colspan="2" nowrap="nowrap" class="tableLabel"></td>
          </tr>
          <tr>
            <td class="tableLabel">No.MyKad : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myKad" size="38" maxlength="12" onKeyUp="switchIdentification('myKad', 'myOther'); if(this.value){document.getElementById('myKod').value='1';}" onBlur="this.onkeyup()" onkeypress="return blockNonNumbers(this, event, false, false);extractNumber(this,0,false);"/></td>
            <td width="221"><span class="tableLabel2">*Contoh : 860909331234 (Tanpa '-')</span></td>
          </tr>
           <tr>
            <td nowrap="nowrap" class="tableLabel"> </td>
            <td class="tableLabel2"><div align="center">Atau</div></td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="tableLabel">No.Polis/Tentera/Pasport : </td>
            <td class="tableInput"><input name="publicID" type="text" class="inputInput" id="myOther" size="38" onKeyUp="switchIdentification('myOther', 'myKad'); if(this.value){document.getElementById('myKod').value='2';}" onBlur="this.onkeyup()" /></td>
          </tr>
          <tr>
            <td colspan="2" class="tableFooter"><input name="myKod" type="hidden" id="myKod">
            <input id="login_semakan" name="login_semakan" type="submit" class="inputButton" value="Log Masuk" onClick="if(!validateCredentials('individu')){return false}" />
                <input name="reset" type="reset" class="inputButton" id="reset" value="Reset" />			</td>
          </tr>
        </table>
		<!--eof semakan-->
		<?php }?>
		
		<!-- END LOGIN SECTION -->
		<!-- FALCON CREDIT -->
		<div id="loginFalconCredit" style="font-weight:bold;">
		  <p class="style5">� Hakcipta Terpelihara ISAC, INTAN 2010</p>
		</div>
		<div id="loginFalconCredit">
		<noscript style="color:#FF0000">
		<?php echo JAVASCRIPT_NOT_ENABLED_ERR; ?>
		</noscript>
		<?php //check if cookie enabled
		if(cookieEnabled($_COOKIE) == false) { ?>
		<div style="color:#FF0000">
		  <?php
		/*echo COOKIE_NOT_ENABLED_ARR;*/
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