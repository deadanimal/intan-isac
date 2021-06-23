<?php
//user session
include ('../db.php');
$app = $_POST['app'];
$usr = $_POST['id'];

$papar_result = "select option_papar_keputusan from usr_isac.pro_kawalan_sistem where id_kawalan_sistem=1";
$papar_resultRs = $myQuery->query($papar_result,'SELECT');
$option_papar = $papar_resultRs[0][0];

$mohon = "select kod_tahap from usr_isac.prs_permohonan where id_permohonan=(select max(id_permohonan) from usr_isac.prs_permohonan where id_peserta='".$usr."')";
$mohonRs = $myQuery->query($mohon,'SELECT');
$kod_tahap = $mohonRs[0][0];

//-- keputusan pengetahuan -->
//jawapan_betul
$query_final_betul = "select count(distinct a.id_soalan) from  usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b where a.id_soalan = b.id_soalan and b.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')
and a.id_peserta = '$usr' and a.id_permohonan='$app' and markah='1'";
$result_final_betul = mysql_query($query_final_betul) or die('Error, query failed');

while($data2 = mysql_fetch_array($result_final_betul))
{

	$correct_answer = $data2[0];

}
//jawapan_salah
$query_final_salah = "select count(distinct a.id_soalan) from  usr_isac.prs_penilaian_peserta_jawapan a, usr_isac.pro_pemilihan_soalan_perincian b where a.id_soalan = b.id_soalan and
b.id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')
and a.id_peserta = '$usr' and a.id_permohonan='$app' and markah='0'";
$result_final_salah = mysql_query($query_final_salah) or die('Error, query failed');

while($data3 = mysql_fetch_array($result_final_salah))
{

	$false_answer = $data3[0];

}

//jumlah keseluruhan soalan
$sql_jumk= "select jumlah_keseluruhan_soalan,nilai_markah_lulus from usr_isac.pro_pemilihan_soalan where id_pemilihan_soalan = (select id_pemilihan_soalan from usr_isac.pro_pemilihan_soalan where kod_tahap_soalan='".$kod_tahap."')";
$jumRs = $myQuery->query ($sql_jumk,'SELECT');
//$jumkRs = mysql_fetch_array ($result_jumk);

$full_mark = $jumRs[0][0];
$status_pengetahuan = $jumRs[0][1];

//mark internet
$internet = "select count(a.markah) 
					from 
					usr_isac.prs_penilaian_peserta_jawapan a,
					usr_isac.pro_soalan b,
					usr_isac.pro_kemahiran c
					where 
					a.id_soalan=b.id_soalan
					and
					b.id_kemahiran=c.id_kemahiran
					and
					a.id_peserta='$usr'
					and 
					a.id_permohonan='$app'
					and
					c.kod_bahagian_soalan=01
					and a.markah !=0 ";
$internetRs = mysql_query ($internet) or die ('Error, query failed');
while ($data4 = mysql_fetch_array ($internetRs))
{
	$part_internet = $data4[0];
	
}

//markah keseluruhan internet
$all_part_internet = 5;
	

$f_internet = (($all_part_internet)/2);
$status_internet = round ($f_internet);
//echo 'internet-->';
//echo $status_internet;

//mark word
$word = "select count(a.markah) 
					from 
					usr_isac.prs_penilaian_peserta_jawapan a,
					usr_isac.pro_soalan b,
					usr_isac.pro_kemahiran c
					where 
					a.id_soalan=b.id_soalan
					and
					b.id_kemahiran=c.id_kemahiran
					and
					a.id_peserta='$usr'
					and 
					a.id_permohonan='$app'
					and 
					c.kod_bahagian_soalan=02
					and a.markah !=0 ";
$wordRs = mysql_query ($word) or die ('Error, query failed');
while ($data5 = mysql_fetch_array ($wordRs))
{
	$part_word = $data5[0];
	
}

//markah keseluruhan word
$all_word = "select count(b.id_soalan)
					from 
					usr_isac.pro_jawapan a,
					usr_isac.pro_soalan b,
					usr_isac.pro_kemahiran c,
					usr_isac.pro_pemilihan_set_kemahiran d
					where
					a.id_soalan = b.id_soalan
					and
					c.id_kemahiran = b.id_kemahiran
					and
					c.kod_bahagian_soalan=02
					and
					c.kod_set_soalan=d.kod_set_soalan
					and
					d.id_peserta='$usr'
					and 
					d.id_permohonan='$app'
					and
					a.markah !=0";
$all_wordRs = mysql_query ($all_word) or die ('Error, query failed');
while ($all_data5 = mysql_fetch_array ($all_wordRs))
{
	$all_part_word = $all_data5[0];
	
}

$f_word = (($all_part_word)/2);
$status_word = round ($f_word);
//echo 'word-->';
//echo $status_word;


//mark power_point
$ppoint = "select count(a.markah) 
					from 
					usr_isac.prs_penilaian_peserta_jawapan a,
					usr_isac.pro_soalan b,
					usr_isac.pro_kemahiran c
					where 
					a.id_soalan=b.id_soalan
					and
					b.id_kemahiran=c.id_kemahiran
					and
					a.id_peserta='$usr'
					and 
					a.id_permohonan='$app'
					and 
					c.kod_bahagian_soalan=03
					and a.markah !=0 ";
$ppointRs = mysql_query ($ppoint) or die ('Error, query failed');
while ($data6 = mysql_fetch_array ($ppointRs))
{
	$part_ppoint = $data6[0];
	
}

//markah keseluruhan power point
$all_ppoint = "select count(b.id_soalan)
					from 
					usr_isac.pro_jawapan a,
					usr_isac.pro_soalan b,
					usr_isac.pro_kemahiran c,
					usr_isac.pro_pemilihan_set_kemahiran d
					where
					a.id_soalan = b.id_soalan
					and
					c.id_kemahiran = b.id_kemahiran
					and
					c.kod_bahagian_soalan=03
					and
					c.kod_set_soalan=d.kod_set_soalan
					and
					d.id_peserta='$usr'
					and 
					d.id_permohonan='$app'
					and
					a.markah != 0";
$all_ppointRs = mysql_query ($all_ppoint) or die ('Error, query failed');
while ($all_data6 = mysql_fetch_array ($all_ppointRs))
{
	$all_part_ppoint = $all_data6[0];
	
}

$f_ppoint = (($all_part_ppoint)/2);
$status_ppoint = round ($f_ppoint);
//echo 'ppoint-->';
//echo $status_ppoint;

//----tahap kelulusan pengetahuan---->
$sql_check = "select id_penilaian_keputusan_bahagian,
				   (SELECT description1 FROM isac.refgeneral 
					WHERE
					mastercode=(SELECT referencecode
					FROM isac.refgeneral where mastercode='XXX' 
					AND description1='STATUS_PENILAIAN_BAHAGIAN') 
					AND
					referencestatuscode='00' 
					AND referencecode=kod_status_penilaian_bahagian) 
					from usr_isac.prs_penilaian_keputusan_bahagian where id_peserta = '".$usr."' and id_permohonan='".$app."' and kod_bahagian_soalan='05'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$status = $checkRs[0][1];
if ($correct_answer >= $status_pengetahuan)
		{
			if(count($checkRs)== 0)
			{
			//echo 'Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,tahap_status,status_push_pull) values ('".$usr."','".$app."','05','01','01','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
		else
		{
			if(count($checkRs) == 0)
			{
			//echo 'Tidak Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','05','02','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
//echo $status;


//----tahap kelulusan internet---->
$sql_check = "select id_penilaian_keputusan_bahagian,
					(SELECT description1 FROM isac.refgeneral 
					WHERE
					mastercode=(SELECT referencecode
					FROM isac.refgeneral where mastercode='XXX' 
					AND description1='STATUS_PENILAIAN_BAHAGIAN') 
					AND
					referencestatuscode='00' 
					AND referencecode=kod_status_penilaian_bahagian) 
					from usr_isac.prs_penilaian_keputusan_bahagian where id_peserta = '".$usr."' and id_permohonan='".$app."' and kod_bahagian_soalan='01'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$status = $checkRs[0][1];
if ($part_internet >= $status_internet)
		{
			if(count($checkRs)== 0)
			{
			//echo 'Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,tahap_status,status_push_pull) values ('".$usr."','".$app."','01','01','01','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
		else
		{
			if(count($checkRs) == 0)
			{
			//echo 'Tidak Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','01','02','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
		
		
		//----tahap kelulusan word dan power point---->
$sql_check = "select id_penilaian_keputusan_bahagian,
					(SELECT description1 FROM isac.refgeneral 
					WHERE
					mastercode=(SELECT referencecode
					FROM isac.refgeneral where mastercode='XXX' 
					AND description1='STATUS_PENILAIAN_BAHAGIAN') 
					AND
					referencestatuscode='00' 
					AND referencecode=kod_status_penilaian_bahagian),kod_status_penilaian_bahagian
					from usr_isac.prs_penilaian_keputusan_bahagian where id_peserta = '".$usr."' and id_permohonan='".$app."' and kod_bahagian_soalan='02'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$status = $checkRs[0][2];
		if ($part_word >= $status_word)
		{
			if(count($checkRs)== 0)
			{
			//echo 'Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','02','01','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
		else
		{
			if(count($checkRs)== 0)
			{
			//echo 'Tidak Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','02','02','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
//echo $status;

$sql_check2 = "select id_penilaian_keputusan_bahagian,
					(SELECT description1 FROM isac.refgeneral 
					WHERE
					mastercode=(SELECT referencecode
					FROM isac.refgeneral where mastercode='XXX' 
					AND description1='STATUS_PENILAIAN_BAHAGIAN') 
					AND
					referencestatuscode='00' 
					AND referencecode=kod_status_penilaian_bahagian),kod_status_penilaian_bahagian
					from usr_isac.prs_penilaian_keputusan_bahagian where id_peserta = '".$usr."' and id_permohonan='".$app."' and kod_bahagian_soalan='03'";
$checkRs2 = $myQuery->query($sql_check2,'SELECT');
$status2 = $checkRs2[0][2];
		if ($part_ppoint >= $status_ppoint)
		{
			if(count($checkRs2)== 0)
			{
			//echo 'Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','03','01','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
		else
		{
			if(count($checkRs2)== 0)
			{
			//echo 'Tidak Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','03','02','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}

//----tahap kelulusan outlook---->
$sql_check = "select id_penilaian_keputusan_bahagian, 
					(SELECT description1 FROM isac.refgeneral 
					WHERE
					mastercode=(SELECT referencecode
					FROM isac.refgeneral where mastercode='XXX' 
					AND description1='STATUS_PENILAIAN_BAHAGIAN') 
					AND
					referencestatuscode='00' 
					AND referencecode=kod_status_penilaian_bahagian) 
					from usr_isac.prs_penilaian_keputusan_bahagian where id_peserta = '".$usr."' and id_permohonan='".$app."' and kod_bahagian_soalan='04'";
$checkRs = $myQuery->query($sql_check,'SELECT');
$status = $checkRs[0][1];

//skema jawapan
$ans = "select a.markah
			from 
			usr_isac.prs_penilaian_peserta_jawapan a,
			usr_isac.pro_soalan b,
			usr_isac.pro_kemahiran c
			where 
			a.id_soalan=b.id_soalan
			and
			b.id_kemahiran=c.id_kemahiran
			and
			a.id_peserta='".$usr."'
			and 
			a.id_permohonan='".$app."'
			and 
			c.kod_bahagian_soalan=04";
			
$ansRs = $myQuery->query($ans,'SELECT');
$to     = $ansRs[0][0];
$attach = $ansRs[2][0];
//$send   = $ansRs[4][0];

if(count($ansRs)!=0)
{

		if (($to !='0')&&($attach !='0'))
		{
			if(count($checkRs)== 0)
			{
			//echo 'Melepasi';
			$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian(id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,tahap_status,status_push_pull) values ('".$usr."','".$app."','04','01','01','I')";
			$result = $myQuery->query($sql,'RUN');
			}
		}
		else
		{
				if(count($checkRs)== 0)
				{
				//echo 'Tidak Melepasi';
				$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','04','02','I')";
				$result = $myQuery->query($sql,'RUN');
				}
		}
}
else
{

				if(count($checkRs)== 0)
				{
				//echo 'Tidak Melepasi';
				$sql = "insert into usr_isac.prs_penilaian_keputusan_bahagian (id_peserta,id_permohonan,kod_bahagian_soalan,kod_status_penilaian_bahagian,status_push_pull) values ('".$usr."','".$app."','04','02','I')";
				$result = $myQuery->query($sql,'RUN');
				}
				else
				{
				$sql = "update usr_isac.prs_penilaian_keputusan_bahagian set kod_bahagian_soalan='04',kod_status_penilaian_bahagian='02' where id_peserta='".$usr."' and id_permohonan='".$app."' ";
				$result = $myQuery->query($sql,'RUN');
				
				}


}

//-----tahap keseluruhan bahagian---->
$overall = "select 
				(SELECT description1 FROM isac.refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM isac.refgeneral where mastercode='XXX' 
				AND description1='STATUS_PENILAIAN_BAHAGIAN') 
				AND
				referencestatuscode='00' 
				AND referencecode=kod_status_penilaian_bahagian) 
				from usr_isac.prs_penilaian_keputusan_bahagian 
				where id_peserta='".$usr."' and id_permohonan='".$app."' order by kod_bahagian_soalan";
$overallRs = $myQuery->query($overall,'SELECT');

$tahap_internet = $overallRs[0][0];
$tahap_word = $overallRs[1][0];
$tahap_power_point = $overallRs[2][0];
$tahap_outlook = $overallRs[3][0];
$tahap_pengetahuan = $overallRs[4][0];

if (($tahap_word == 'Tidak Melepasi') && ($tahap_power_point == 'Tidak Melepasi'))
	{
	//echo 'Tidak Melepasi';
	}
	else 
	{
	//echo 'Melepasi';
	$sql_tahap = "update usr_isac.prs_penilaian_keputusan_bahagian set tahap_status='01' where id_peserta='".$usr."' and id_permohonan='".$app."' and kod_bahagian_soalan='02'";
    $result_tahap = $myQuery->query($sql_tahap,'RUN');
	}
	
	$all_result = "	select 
					case when count(tahap_status)=4 then 'Lulus'
					else 'Gagal'
					end as 'STATUS'
					from usr_isac.prs_penilaian_keputusan_bahagian
					where id_peserta = '$usr' and id_permohonan='$app' ";
$allRs = $myQuery->query($all_result,'SELECT','NAME');
$status_kelulusan = $allRs[0]["STATUS"];

$nilai = "select max(id_penilaian_peserta) from usr_isac.prs_penilaian_peserta where id_peserta = '".$usr."'";
$nilaiRs = $myQuery->query($nilai,'SELECT');
$id_nilai = $nilaiRs[0][0];

$sql = "update usr_isac.prs_penilaian_peserta set kod_status_kelulusan='".$status_kelulusan."' where id_penilaian_peserta='".$id_nilai."'";
$result = $myQuery->query($sql,'RUN');

$sql_check = "select id_sijil from usr_isac.pro_sijil where id_peserta='".$usr."' and id_permohonan='".$app."'";
$checkRs = $myQuery->query($sql_check,'SELECT');

$lulus = "select kod_status_kelulusan from usr_isac.prs_penilaian_peserta where id_penilaian_peserta='".$id_nilai."'";
$lulusRs = $myQuery->query($lulus,'SELECT');
$kelulusan = $lulusRs [0][0];
if(count($checkRs)==0)
{
	if($kelulusan == 'Lulus')
	{	
	$checkKodIAC = "select d.kod_iac
					from usr_isac.prs_penilaian_peserta b, usr_isac.prs_penilaian c, usr_isac.pro_sesi d
					where b.id_penilaian = c.id_penilaian and c.id_sesi = d.id_sesi 
					and b.id_penilaian_peserta='".$id_nilai."'";
					
	$resultKodIAC = $myQuery->query($checkKodIAC,'SELECT');
	$kodIAC = $resultKodIAC[0][0];
	
	$checkNoSijil = "select ifnull(max(no_sijil),0)+1 from usr_isac.pro_sijil where kod_iac = '".$kodIAC."'";
	$resultNoSijil = $myQuery->query($checkNoSijil,'SELECT');
	$noSijil = $resultNoSijil[0][0];
	
	/*$tarikh = "select date_format(tarikh_sesi,'%d/%m/%Y')
				from usr_isac.pro_peserta a,usr_isac.pro_sesi b,usr_isac.prs_permohonan c
			   where a.id_peserta = c.id_peserta and b.id_sesi = c.id_sesi and a.no_kad_pengenalan = '".$usr."'";
	$result2 = $myQuery->query($tarikh,'SELECT');
	$tarikh = $result2[0][0];
	$dates = explode('/',$tarikh);*/

	//$newdate = $dates[0];
	//$newyear = $dates[2];
	
	$sql = "insert into usr_isac.pro_sijil(id_peserta,id_permohonan,no_sijil,kod_iac,status_push_pull) values ('".$usr."','".$app."','".$noSijil."','".$kodIAC."','I')";
	$result2 = $myQuery->query($sql,'RUN');
	}
}



?>