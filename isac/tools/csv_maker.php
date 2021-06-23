<?php 
include("dbconn.php");

//header data
$header = "select * from general_reference";
$headerRs = mysql_query($header,$dbc) or die(mysql_error());
$headerNumRows = mysql_num_rows($headerRs);

//detail data
$detail = "select * from general_reference";
$detailRs = mysql_query($detail,$dbc) or die(mysql_error());
$detailNumRows = mysql_num_rows($detailRs);

//to makeCSV
function makeCSV($numRows,$rs)
{
	//fetch 
	for($x=0; $x < $numRows; $x++)
	{	
		//fetch
		$rsRows = mysql_fetch_array($rs);
		
		//to read individual row record
		for($y=0; $y < mysql_num_fields($rs); $y++)
		{
			$toWrite .= $rsRows[$y];
			
			//if end of line, put semicolon
			if($y+1 != mysql_num_fields($rs))
				$toWrite .= ",";
		}

		$toWrite .= ";\n";
	}
	
	//return csv
	return $toWrite;
}

//data to be written to csv file
$toWrite_1 = makeCSV($headerNumRows,$headerRs);
$toWrite_2 = makeCSV($detailNumRows,$detailRs);

//set filename
$filename = "exp_".date("Ymd_His_").rand();					

//open file handle
$handle = fopen($filename,"w+");

//if filename writeable, start writing!
if(is_writable($filename)) 
{
	fwrite($handle,$toWrite_1);
	fwrite($handle,$toWrite_1);
	fclose($handle);
}

?>
