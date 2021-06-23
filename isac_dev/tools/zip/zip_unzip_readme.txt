//===================TO ZIP======================
//SYNTAX
//addfile(string file contents,string name to store);

$newZip = new zipfile;
$newZip->addFile("backup/","backup/");
$newZip->file();



//===================TO UNZIP=====================
//PEAR.php is required
//SYNTAX

$zipFilename = "zzz.zip";
$hehe = new Archive_Zip($zipFilename);
$hehe->extract();