<?php
/*$word = new COM("word.application") or die("Unable to instantiate Word");
$word->Documents->Open($filename);
$new_filename = substr($filename,0,-4) . ".txt";
// the '2' parameter specifies saving in txt format
$word->Documents[1]->SaveAs($new_filename,2);
$word->Documents[1]->Close(false);
$word->Quit();
$word->Release();
$word = NULL;
unset($word);

$fh = fopen($new_filename, 'r');
// this is where we exit Hell
$contents = fread($fh, filesize($new_filename));
fclose($fh);
unlink($new_filename);
*/
$myFile = "testing.doc";
$fh = fopen($myFile, 'r');


/*$opened_file=file("testing.doc");
$old_array=array('[b]','[u]','[i]');
$new_array=array('<b>','<u>','<i>');
$string=str_replace($old_array,$new_array,$opened_file);*/
?>