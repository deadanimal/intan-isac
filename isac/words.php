<?php
include ('db.php');

$id_peserta =$_GET['id'];

//path file
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='1'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//server IP
$location = $path_nameRs[0][1];

//Word2007
$file = $path_nameRs[0][2];
//kemahiran
//$folder = $path_nameRs[0][2];


$path = 'kemahiran/';
$fileSrc = $file.'.mht';
$fileDest = $file.'_'.$_GET['id'].'_'.date('Ymd').'.mht';
$ans_file = $path.$fileDest; 
//echo $ans_file;

/*$fileSrc = 'Word2007.mht';
$path = 'kemahiran/';
$location = '192.168.2.7';
$fileDest = 'Word2007_'.$_GET['id'].'_'.date('Ymd').'.mht';
*/
//copy file and rename
copy($path.$fileSrc,$path.$fileDest);

//check if file already exist
$sql_check = "select * from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta = '".$id_peserta."' and kod_bahagian_soalan='02'";
$result_check = $myQuery->query($sql_check,'SELECT');

	if(count($result_check) == 0)
	{
	
	//insert path file jawapan peserta
	$sql = "insert into usr_isac.prs_penilaian_peserta_kemahiran (id_peserta,fail_jawapan_peserta,kod_bahagian_soalan) values ('".$id_peserta."','".$ans_file."','02')";
	$result = $myQuery->query($sql,'RUN');
	}

//page process_word.php for word processing n scoring.
?>
<HTML>
<HEAD>
<TITLE>ISAC INTAN</TITLE>
</HEAD>
<BODY>
<script>
var w=new ActiveXObject('Word.Application'); 
var obj;
if (w != null)
{
w.Visible = true;
//obj=w.Documents.Open("\\\\192.168.2.7\\xampp\\htdocs\\isac\\kemahiran\\Word2007.mht"); 
obj=w.Documents.Open("\\\\<?php echo $location;?>\\xampp\\htdocs\\isac\\kemahiran\\<?php echo $fileDest;?>"); 
}
this.close();
</script>

</BODY>
</HTML>