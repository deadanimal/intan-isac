<style type="text/css">
/*#dynamicTable {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	border-left: 1px solid #CCCCCC;
}
#dynamicTable th {
	text-align:left;
	background-color: #CCCCCC;
	padding: 3px 5px 3px 5px;
}
#dynamicTable td, .tdOff {
	padding: 3px 5px 3px 5px;
	border-right: 1px solid #CCCCCC;
	border-bottom: 1px solid #CCCCCC;
	white-space:nowrap;
	background-color:#E1E1E1;
}
#dynamicTable .tdOff{
	background-color: #FFFFFF;
}
#dynamicTable .tdFloat {
	text-align:right;	
}*/

#tableContent_report {
	font-size: 1.1em;
	border-top: 1px solid #AEC9E3;
	border-bottom: 1px solid #AEC9E3;
	border-left: 1px solid #AEC9E3;
	font-family:"trebuchet MS", Verdana, Arial;
	margin-right: 20px;
}
#tableContent_report  .listingBorder {
	font-size: 0.9em;
	height: 10px;
	padding-left: 10px;
	padding-right: 10px;
	border-right: 1px solid #AEC9E3;
	border-top: 1px solid #AEC9E3;
}
#tableContent_report  .listingHeader {
	background-color:#E6E6E6;
	border-right: 1px solid #AEC9E3;
	padding-left: 10px;
	padding-right: 10px;
	font-size: 0.9em;
	font-weight: bold;
	text-decoration:none;
	text-align:center;
}
#tableContent_report  .listingHeaderRight {
	background-color:#E6E6E6;
	padding-left: 10px;
	font-size: 0.9em;
	font-weight: bold;
	text-decoration:none;
}
</style>

<?php 
//cikkim 2007
function dynamicReport($qry,$dbc)
{	
	//echo $qry;
	//------------styling configurations--------------------
	$tableStyleID = "tableContent_report";
	$tableHeadingClass = "listingHeader";
	$tableCellClassOff = "listingBorder"; 
	$tableCellClassOn = "listingBorderOff";
	
	//bilangan column
	$adaBilangan = true;
	$bilanganFormat = ".";
	
	//if content is null, replace with character
	$nullChar = "&nbsp;";
	
	//float format align flag and checking
	$formatFloat = true;
	$floatFormat = "/^[0-9]{1,50}[...]{1}[0-9]{1,10}$/";
	
	//grouped thousands formatting
	$groupThousand = true;
	
	//showTotal
	$showTotal = true;
	
	//alternating row colors every # of lines
	//$changeColorFlag = true;
	$changeColor = 1;	
	//------------------------------------------------------
	
	//call query
	$qryRs = mysql_query($qry,$dbc) or die(mysql_error());
	
	//if correct query syntax
	if($qryRs)
	{
		$qryNumRows = mysql_num_rows($qryRs);
		$qryNumFields = mysql_num_fields($qryRs);
		
		//----------------- to store all result rows in a 2D array ---------------------
		//for rows
		for($x=0; $x < $qryNumRows; $x++)
		{	
			$qryRsRows = mysql_fetch_array($qryRs);
			
			//for columns
			for($y=0; $y < $qryNumFields; $y++)
			{	
				//to store header
				if($x == 0)
					$tempArr[0][$y] = mysql_field_name($qryRs,$y);
				
				//------to store contents---------------
				//if fetch array is not null
				if($qryRsRows[$y] != "")
					$tempArr[$x+1][$y] = $qryRsRows[$y]; 
				
				//else if fetched array is null, replace with nullChar
				else
					$tempArr[$x+1][$y] = $nullChar;
				//-----------------------------------
			}
		}
		//------------------------------------------------------------------------------
		//----------------- to build html report structure -----------------------------
		//start creating table structure
		echo "<table cellspacing=\"0\" id=".$tableStyleID.">\n";
		
		//if result rows bigger than 0
		if($qryNumRows > 0) 
		{ 	
			//count number of record in tempArr
			$tempArrCount = count($tempArr);
			
			//start printing out records in array
			for($x=0; $x < $tempArrCount; $x++) 
			{ 
				echo "<tr>";
				for($y=0; $y < $qryNumFields; $y++) 
				{	
					if($x == 0)
					{	
						//if adaBilangan is true and first row and first column, ni HEADING!!
						if($x == 0 && $y == 0 && $adaBilangan == true)
						{	
							echo "<td class=\"".$tableHeadingClass."\">#</td>\n";
							echo "<td class=\"".$tableHeadingClass."\">";
						}
						else 
							echo "<td class=\"".$tableHeadingClass."\">";
					}
					else
					{
						//if adaBilangan is true and first row and first column
						if($y == 0 && $adaBilangan == true)
						{	
							//---------------for alternate colouring-------------------
							if(is_int(($x + $changeColor - 1)/$changeColor) && $lastUsed != ($x + $changeColor - 1))
							{	
								$lastUsed = $x + $changeColor - 1;
							
								if($updateColorFlag == 1)
									$updateColorFlag = 0;
								else
									$updateColorFlag = 1; 
							}
							
							if($updateColorFlag == 1)
							{
								echo "<td class=\"listingBorder\">".$x.$bilanganFormat."</td>\n";
								echo "<td class=\"listingBorder\">";
								
								//============================for url link (first row)!!!
								echo "<a href>";
								
								
							}
							else
							{
								echo "<td class=\"listingBorder\">".$x.$bilanganFormat."</td>\n";	//off
								echo "<td class=\"listingBorder\">";
								
								//=============================for url link (second row onwards)!!!
								echo "<a href>";
								
								
							}
							//--------------------------------------------------------
						}
						else
						{	
							//---------------for alternate colouring-------------------
							if(is_int(($x + $changeColor - 1)/$changeColor) && $lastUsed != ($x + $changeColor - 1))
							{	
								$lastUsed = $x + $changeColor - 1;
							
								if($updateColorFlag == 1)
									$updateColorFlag = 0;
								else
									$updateColorFlag = 1; 
							}
							
							if($updateColorFlag == 1)
								echo "<td class=\"listingBorder\">";
							
							else
								echo "<td class=\"listingBorder\">";			//off
							//------------------------------------------------------
						}
					}
					//---------to right align float or number-------------------
					//if format float flag is true and float format matched
					if($formatFloat == true && preg_match($floatFormat,$tempArr[$x][$y]))
					{	
						//----------------if group thousands == true----------------------
						if($groupThousand == true)
							echo "<div align=\"right\">".number_format($tempArr[$x][$y],2,'.',',')."</div>";
						//----------------------------------------------------------------
						else
							echo "<div align=\"right\">".$tempArr[$x][$y]."</div>";
					}
					else
						echo "".$tempArr[$x][$y];			//test here

					//-----------------------------------------------------------
					
					if($x == 0)
						echo "</td>\n";			//CLOSE HEADING
					else
					{
						//if adaBilangan is true and first row and first column
						if($y == 0 && $adaBilangan == true)
						{	
							//for closing of URL link!!
							echo "</a> <a href=\"\">View".$tempArr[$x][$y]."</a>";
						
						
							echo "</td>\n";
						}
						else
							echo "</td>\n";
					}
				}
				echo "</tr>\n";
			} 
		}//end if result rows bigger than 0
		echo "</table>";
		//-----------------------------------------------------------------------------
	}//end if correct syntax
	//if incorrect query syntax entered
	else
		echo "Incorrect query syntax entered";
}
/*haha = "select a.tableName,b.haha, c.ddd from user a, customer b, shop c 
			where a.tablename = 'haha' ";
$gege = explode("from",$haha);
$gaga = explode(",",ereg_replace("select","",$gege[0]));


for($x=0; $x < count($gaga); $x++)
{
	$haha .= " and ".$gaga[$x]." = ".$post[]aaaa;
}

//echo $gaga.$haha;*/
?>

