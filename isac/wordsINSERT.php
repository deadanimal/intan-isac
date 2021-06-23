<?php
include ('db.php');

$ic_peserta =$_GET['id'];

//copy file and rename
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='01'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

echo 'hello->' ;

//Word2007
$file = $path_nameRs[0][1];
//kemahiran
$folder = $path_nameRs[0][2];
//192.168.2.7
$location = $path_nameRs[0][3];

$path = $folder.'/';
$fileSrc = $file.'.mht';
$fileDest = $file.'_'.$_GET['id'].'_'.date('Ymd').'.mht';
$ans_file = $path.$fileDest; 
//echo $ans_file;

/*$fileSrc = 'Word2007.mht';
$path = 'kemahiran/';
$location = '192.168.2.7';
$fileDest = 'Word2007_'.$_GET['id'].'_'.date('Ymd').'.mht';
*/

copy($path.$fileSrc,$path.$fileDest);

//check if file already exist
$sql_check = "select * from usr_isac.prs_penilaian_peserta_kemahiran where no_kad_pengenalan_peserta = '$ic_peserta'";
$result_check = $myQuery->query($sql_check,'SELECT');

if(count($result_check) == 0)
{

//insert path file jawapan peserta
$sql = "insert into usr_isac.prs_penilaian_peserta_kemahiran (no_kad_pengenalan_peserta,fail_jawapan_peserta) values ('$ic_peserta','$ans_file')";
$result = $myQuery->query($sql,'RUN');
}

//process scoring

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
//obj=w.Documents.Open("\\\\192.168.2.7\\xampp\\htdocs\\isac\\kemahiran\\word2007.docx"); 
obj=w.Documents.Open("\\\\<?php echo $location;?>\\xampp\\htdocs\\isac\\kemahiran\\<?php echo $fileDest;?>"); 
}
this.close();
</script>

</BODY>
</HTML>