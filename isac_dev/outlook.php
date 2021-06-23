<?php
/*include ('db.php');

$id_peserta =$_GET['id'];

//path file
$path_name = "select * from usr_isac.ruj_path_file where id_path_file='01'";
$path_nameRs = $myQuery->query($path_name,'SELECT');

//echo 'hello->' ;

//Word2007
$file = $path_nameRs[0][1];
//kemahiran
$folder = $path_nameRs[0][2];
//server IP
$location = $path_nameRs[0][3];

$path = $folder.'/';
$fileSrc = $file.'.mht';
$fileDest = $file.'_'.$_GET['id'].'_'.date('Ymd').'.mht';
$ans_file = $path.$fileDest; 
*///echo $ans_file;

/*$fileSrc = 'Word2007.mht';
$path = 'kemahiran/';
$location = '192.168.2.7';
$fileDest = 'Word2007_'.$_GET['id'].'_'.date('Ymd').'.mht';
*/
//copy file and rename
/*copy($path.$fileSrc,$path.$fileDest);

//check if file already exist
$sql_check = "select * from usr_isac.prs_penilaian_peserta_kemahiran where id_peserta = '$id_peserta'";
$result_check = $myQuery->query($sql_check,'SELECT');

	if(count($result_check) == 0)
	{
	
	//insert path file jawapan peserta
	$sql = "insert into usr_isac.prs_penilaian_peserta_kemahiran (id_peserta,fail_jawapan_peserta) values ('$id_peserta','$ans_file')";
	$result = $myQuery->query($sql,'RUN');
	}
*/
//process scoring

?>
<HTML>
<HEAD>
<TITLE>ISAC INTAN</TITLE>
</HEAD>
<BODY>
<script>
var w=new ActiveXObject('Outlook.Application'); 
var obj;
if (w != null)
{
w.Visible = true;
//obj=w.Documents.Open("\\\\ho $loc\\xampp\\htdocs\\isac\\kemahiran\\ho $fil"); 
obj=w.Documents.Open("\\\\192.168.2.7\\xampp\\htdocs\\isac\\test1.oft"); 

}
this.close();
//
//var outlookApp = new ActiveXObject("Outlook.Application");
//var mailItem = outlookApp.CreateItem(0);
//var obj;
////mailItem.Recipients.Add("recipient_name@recipient_domain.ext");
////mailItem.Subject = "Form as Word attachment";
////mailItem.Body = "Check out the attachment to this email!";
////mailItem.Attachments.Add("C:\\InfoPath\\InfoPathFormInWordML.xml");
////mailItem.Send(); 
//obj=outlookApp.Documents.Open("\\\\192.168.2.7\\xampp\\htdocs\\isac\\test1.oft"); 


</BODY>
</HTML>