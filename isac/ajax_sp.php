<?php
include('system_prerequisite.php');

if($_POST['statement'])
{
	$dbc=$myDbConn->getConnString();
	
	$theParameter=$_POST['statement'];
	echo $theParameter=stripslashes($theParameter);
	
	//temporary SP file (for exec)
	/*$tempSPFile='tempSPFile.sql';
	
	//create new sql file
	file_put_contents($tempSPFile,$theParameter."\n/");	//create file
	exec('sqlplus '.DB_USERNAME.'/'.DB_PASSWORD.'@'.DB_DATABASE.' @'.$tempSPFile);		//execute with external program (sqlplus)
	unlink($tempSPFile);	//delete file*/
	
	//parse sql statement in stored procedure
	$sqlParsed = oci_parse($dbc,$theParameter) or die('STORED_PROCEDURE ERROR: '.oci_error());
	
	//execute parsed sql statement
	if(oci_execute($sqlParsed) == true)
		echo 'success';
	else
		echo 'error';
}
?>