<?php
ini_set("memory_limit","500M");
ini_set("max_execution_time","600");
ini_set("max_input_time","600");

//$phrase  = "You should eat fruits, vegetables, and fiber, fruits, vegetables every day.";
//$healthy = array("fruits", "vegetables", "fiber");
//$yummy   = array("pizza", "beer", "ice cream");

//echo $newphrase = str_replace($healthy, $yummy, $phrase);

//if hidden impexp type = exp
if($_POST['hidden_impexp_type'] == 'exp' && !isset($_POST['impexp_type']))
	$_POST['impexp_type'] = $_POST['hidden_impexp_type'];

//if rollback is selected
if($_POST['impexp_type'] == 'roll')
{
	$rollbackList = getRollbackList();			//get list of rollback data
}

//========= LIST OF FUNCTIONS ==================================================================
//get menu id posted
function getMenuID($postData)
{
	//insert into flc_permission table
	foreach ($_POST as $key => $value) 
	{	
		//if POST name contains menuPermission
		if(preg_match("/moduleSelection/i",$key)) 
		{
			$x = $x + 1;
			
			if($x == 1)
				$postArr[] = $_POST['hiddenCode'];
		
			//replace the 'menuPermission' string to empty string
			$key = trim(str_replace('moduleSelection_','',$key));
			
			//explode string to 2 parts, parent and sub
			$keyArr = explode('_',$key);
			
			//if key count is 1, take first key
			if(count($keyArr) == 1)
				$theKey = $keyArr[0];
			
			//if key count is 2, take second key
			else if(count($keyArr) == 2)
				$theKey = $keyArr[1];
			
			$postArr[] = $theKey;
		}//end if
	}//end foreach
	
	return $postArr;
}

//function to check selected checkbox
function checkSelectedCheckbox($val,$haystack)
{
	//if in array, echo checked
	if(is_array($haystack))
	{
		if(in_array($val,$haystack))
			echo ' checked ';
	}
}

//function to count selected items
function countSelected($parent)
{
	$theCount = count($_SESSION['system_impexp'][$parent]);
	
	if($theCount == 0)
		return 0;
	else
		return $theCount - 1;
	//return count($_SESSION['system_impexp'][$parent]);
}

//function to reset export selection
function resetExportSelection()
{
	unset($_SESSION['system_impexp']);
	unset($_SESSION['system_impexp_full']);
}

//pad values with quote
function padWithQuote($dataTypeArr,$valuesArr)
{
	//reset values arr
	$values = array();	
	
	for($y=0; $y < count($dataTypeArr); $y++)
	{	
		$theValue = replaceDangerousChar($valuesArr[0][$y]);
	
		$dataTypeArr[$y] = strtoupper($dataTypeArr[$y]);
	
		if($dataTypeArr[$y] == 'VARCHAR2' || $dataTypeArr[$y] == 'VARCHAR' || $dataTypeArr[$y] == 'LONG' || $dataTypeArr[$y] == 'TEXT' || $dataTypeArr[$y] == 'LONGTEXT' || $dataTypeArr[$y] == 'BLOB')
			$values[] = "'".$theValue."'";
		else
		{	
			if($valuesArr[0][$y] == '')
				$values[] = 'null';
			else
				$values[] = $theValue;
		}	
	}
	return $values;
}

//pad key column values with string
function padKeyColumnWithStr($values,$location,$str)
{
	$tempValues = array();
	
	for($x=0; $x < count($values); $x++)
	{
		if($x == $location)
			$tempValues[] = $str.$values[$x].$str;
		else
			$tempValues[] = $values[$x];
	}

	return $tempValues;
}

//to pad string column with [GLOBAL.XXXX]
//EG: CONTROLREDIRECTURL = index.php?page=page_wrapper&menuID=222
//result: index.php?page=page_wrapper&menuID=[GLOBAL.MENUID]222[GLOBAL.MENUID]
function padStringColWithStr($values,$location,$str)
{
	$tempValues = array();
	
	for($x=0; $x < count($values); $x++)
	{
		if($x == $location)
		{	
			//get url param value
			$URLParamValue = getURLParamValue(str_replace("'","",str_replace('[AMPERSAND]','&',$values[$x])),$str);
			
			if($URLParamValue != '')
				$tempValues[] = str_replace($str.'='.$URLParamValue,$str.'='.'[GLOBAL.MENUID]'.$URLParamValue.'[GLOBAL.MENUID]',$values[$x]);
			else
				$tempValues[] = $values[$x];
		}
		else
			$tempValues[] = $values[$x];
	}
	return $tempValues;
}

//to pad falcon passing parameter ({POST|input_map_xxx_yyy},{GET|xxxx}) to {POST|input_map_[GLOBAL.COMPONENTID]xxx[GLOBAL.COMPONENTID]_[GLOBAL.ITEMID]yyy[GLOBAL.ITEMID]}
function padParamWithStr($values,$location)
{	
	$tempValues = array();
	$valCount = count($values);
	
	for($x=0; $x < $valCount; $x++)
	{
		$position_1 = array();
		$position_2 = array();
	
		if($x == $location)
		{	
			//if string is not null
			if($values[$x] != '')
			{
				//check query for {
				while($offset = strpos($values[$x], "{", $offset + 1))
					$position_1[] = $offset;
				
				//check query for }
				while($offset = strpos($values[$x], "}", $offset + 1))
					$position_2[] = $offset;
				
				$tempOriginal = array();
				$tempReplacement = array();
				
				$countPos1 = count($position_1);
				
				//for all number of { and }
				for($y=0; $y < $countPos1; $y++)
				{
					//get original sub string
					$original[$y] = substr($values[$x],$position_1[$y],$position_2[$y]-$position_1[$y]+1);
										
					//define things to be replaced
					$str_1 = array('{','}');
					$str_2 = array('','');
					
					//start processing the string
					$replaced = str_replace($str_1,$str_2,$original[$y]);
					
					//split to chunks
					$replacedSplit = explode('|',$replaced);
					
					//split to componentid and itemid
					$splitComponentAndItem = explode('_',$replacedSplit[1]);
					
					//if post
					if($replacedSplit[0] == 'POST')
					{
						$tempOriginal[] = $original[$y];
						$tempReplacement[] = '{POST|input_map_'.'[GLOBAL.COMPONENTID]'.$splitComponentAndItem[2].'[GLOBAL.COMPONENTID]'.'_'.'[GLOBAL.ITEMID]'.$splitComponentAndItem[3].'[GLOBAL.ITEMID]}';
					}
					//else($replacedSplit[0] == 'GET'
					//	$tempReplacement[] = $values[$x];
				}
				
				$tempValues[] = str_replace($tempOriginal,$tempReplacement,$values[$x]);
				
			}//end if values != ''
			else
				$tempValues[] = $values[$x];
		}
		else
			$tempValues[] = $values[$x];
	}
	return $tempValues;
}

//to pad falcon component item ID eg: $('input_map_xxx_yyy') = > $('input_map_[GLOBAL.COMPONENTID]xxx[GLOBAL.COMPONENTID]_[GLOBAL.ITEMID]yyy[GLOBAL.ITEMID]')
function padJSParamWithStr($values,$location)
{
	$tempValues = array();
	$pattern = "/input_map_(\d+)_(\d+)/";									//for input_map_xxx_yyy (javascript)
	$replacement = "input_map_[GLOBAL.COMPONENTID]$1[GLOBAL.COMPONENTID]_[GLOBAL.ITEMID]$2[GLOBAL.ITEMID]";
	
	for($x=0; $x < count($values); $x++)
	{
		if($x == $location)
			$tempValues[] = preg_replace($pattern,$replacement,$values[$x]);
		else
			$tempValues[] = $values[$x];
	}
	return $tempValues;
}

//replace dangerous char
function replaceDangerousChar($str)
{
	//edited 20090518 - 1456 cikkim

	//if database is oracle
	if(strtoupper(DBMS_NAME) == 'ORACLE')
	{
		$dangerous = array("\r\n","'",'"',"&",":");
		$safe = array("[NL]","[QS]","[QD]","[AMPERSAND]","[COLON]");
		//$safe = array("[NL]","''","[AMPERSAND]","[COLON]");
	}
	
	//if database is mysql
	else if(strtoupper(DBMS_NAME) == 'MYSQL')
	{
		$dangerous = array("\r\n","'",'"',"&",":");
		$safe = array("[NL]","[QS]","[QD]","[AMPERSAND]","[COLON]");
	}

	//$variable_with_quotes = "12'5\"";
	//$variable_with_quotes = preg_replace('/"/',"[QS]", $str); ## replace double quote
	//$variable_with_quotes = preg_replace("/'/","[QD]", $str); ## replace single quote
	return str_replace($dangerous, $safe, $str);
}

//to create dump directory
function createDir($dir)
{
	//file path to save
	if(is_dir($dir) == false)
		mkdir($dir);
}

//write to file
function writeToDump($timestamp,$data)
{
	$filePath = 'export_import/exp_'.$_SESSION['userID'].$timestamp.'.fdmp';
	
    if(!$handle = fopen($filePath, 'a')) 
	{
		echo "Cannot open file ($filename)";
       	exit;
   	}

	//if data is not empty string
	if($data != '')
	{
		//write to file
		if(fwrite($handle,implode('',$data)."commit;\r\n") === FALSE) 
		{
			echo "Cannot write to file ($filename)";
			exit;
		}
	}

   	fclose($handle);
}

//to select max id from table
function selectMax($myQuery,$table,$col)
{
	$qry = "select max(".$col.") from ".$table;
	$qryRs = $myQuery->query($qry,'SELECT','INDEX');
	return $qryRs[0][0];
}

//src: http://www.phpro.org/examples/Find-Position-Of-Nth-Occurrence-Of-String.html
//function to find position of string in a string, given the number of offset
function strposOffset($search, $string, $offset)
{
    /*** explode the string ***/
    $arr = explode($search, $string);
    /*** check the search is not out of bounds ***/
    switch( $offset )
    {
        case $offset == 0:
        return false;
        break;
    
        case $offset > max(array_keys($arr)):
        return false;
        break;

        default:
        return strlen(implode($search, array_slice($arr, 0, $offset)));
    }
}

//function to scan for global id
function scanGlobalID($str,$toFind)
{
	$IDPos_Pre = array();			//get opening of global var
	$IDPos_Post = array();			//get ending of global var
	$IDPos = array();
	
	$x = 1;
	$pos = -1;
	
	while($pos != 0)
	{
		$pos = strposOffset($toFind,$str,$x);
		
		//if opening, store in pre
		if($x%2 == 1)
			$IDPos_Pre[] = $pos;	
			
		//if ending, store in post		
		else if($x%2 == 0)
			$IDPos_Post[] = $pos;
		$x++;
	}
	
	$countIDPos_Pre = count($IDPos_Pre);
	
	//for all item
	for($x=0; $x < $countIDPos_Pre; $x++)
	{
		//combine the string
		if($IDPos_Pre[$x] != '' and $IDPos_Post[$x] != '')
			$IDPos[] = substr($str,$IDPos_Pre[$x],$IDPos_Post[$x]-$IDPos_Pre[$x]+strlen($toFind));
	}
	
	//print_r($menuIDPos_Pre);
	//print_r($menuIDPos_Post);
	//print_r($IDPos);
	
	return $IDPos;	
}

//to update id to new ID based on max ID of selected table
function updateIDToNew($arr,$maxID,$toFind)
{
	$newArr = array();
	
	//add max id by one
	$maxIDPlusOne = $maxID + 1000;
	
	//count the arr
	$arrCount = count($arr);
	
	//default value
	$theVal = 0;
	
	//echo '<br>'.$toFind.'<br>';
	
	for($x=0; $x < $arrCount; $x++)
	{
		
/*		if($x==0)
		{
			reset($arr);
			$theVal = current($arr);
			
		}
		else
			$theVal = next($arr);*/
			
		//strip global char, get running id
		$runID = substr($arr[$x],strlen($toFind),strlen($toFind) - strlen($toFind)*2);
		
	//	var_dump($runID);
		
		//replace running id with new id (max + 1)
		$newArr[] = str_replace($runID,$maxIDPlusOne,$arr[$x]);
	
	
/*		//strip global char, get running id
		$runID = substr($arr[$x],strlen($toFind),strlen($toFind) - strlen($toFind)*2);
		
		//replace running id with new id (max + 1)
		$newArr[] = str_replace($runID,$maxIDPlusOne,$arr[$x]);*/
		
		//add running id by MAX + 1
		$maxIDPlusOne++;
	}
	
	
	//echo '[---------]';
	
	//print_r($newArr);
	
	//echo '[---------]';
	
	return $newArr;
}

//get url parameter value based on given component name
function getURLParamValue($url,$component)
{
	$URLArr = parse_url($url);
	$query = $URLArr['query'];
	$queryArr = explode('&',$query);
	
	for($x=0; $x < count($queryArr); $x++)
	{
		$bitsArr = explode('=',$queryArr[$x]);
		
		//if component selected is matched, return value
		if($bitsArr[0] == $component)
			return $bitsArr[1];
	}
}

//create rollback data to write
function createRollbackData($mySQL,$menuID,$pageID,$componentID,$itemID,$controlID)
{
	$newMenuIDMax = $mySQL->maxValue('FLC_MENU','MENUID');
	$newPageIDMax = $mySQL->maxValue('FLC_PAGE','PAGEID');
	$newComponentIDMax = $mySQL->maxValue('FLC_PAGE_COMPONENT','COMPONENTID');
	$newItemIDMax = $mySQL->maxValue('FLC_PAGE_COMPONENT_ITEMS','ITEMID');
	$newControlIDMax = $mySQL->maxValue('FLC_PAGE_CONTROL','CONTROLID');

	return 'MENU:'.$menuID.'|'.$newMenuIDMax."\r\n".'PAGE:'.$pageID.'|'.$newPageIDMax."\r\n".'COMPONENT:'.$componentID.'|'.$newComponentIDMax."\r\n".'ITEM:'.$itemID.'|'.$newItemIDMax."\r\n".'CONTROL:'.$controlID.'|'.$newControlIDMax;
} 

//to write rollback data to file
function dumpRollbackData($timestamp,$rollbackData)
{
	createDir('export_import/rollback');
	file_put_contents('export_import/rollback/' . 'rollback_'.$_SESSION['userID'].$timestamp,$rollbackData);
}

//get list of files in rollback directory
function getRollbackList()
{
	//get list of files in the rollback directory
	$rollbackList = scandir('export_import/rollback',1);
	array_pop($rollbackList);		//remove .
	array_pop($rollbackList);		//remove ..

	return $rollbackList;
}

//function to rollback changes
function rollbackData($mySQL)
{
	$rollbackData = file_get_contents('export_import/rollback/'.$_POST['rollbackList']);

	if(strlen($rollbackData) > 0)
	{
		$explode = explode("\r\n",$rollbackData);
		
		$rollbackQry = '';
		
		for($x=0; $x < count($explode); $x++)
		{
			$explodeMore = explode(':',$explode[$x]);
			$val = explode('|',$explodeMore[1]);
		
			if($explodeMore[0] == 'MENU')
				$qry .= 'delete from flc_menu where menuid between '.($val[0]+1). ' and '.$val[1].';';
			else if($explodeMore[0] == 'PAGE')
				$qry .= 'delete from flc_page where pageid between '.($val[0]+1). ' and '.$val[1].';';
			else if($explodeMore[0] == 'COMPONENT')
				$qry .= 'delete from flc_page_component where componentid between '.($val[0]+1). ' and '.$val[1].';';
			else if($explodeMore[0] == 'ITEM')
				$qry .= 'delete from flc_page_component_items where itemid between '.($val[0]+1). ' and '.$val[1].';';
			else if($explodeMore[0] == 'CONTROL')
				$qry .= 'delete from flc_page_control where controlid between '.($val[0]+1). ' and '.$val[1].';';
		}
		
		//replace carriage return with empty string to work around oracle script carriage return problem
		//return $rollbackRs = $myQuery->query('BEGIN '.str_replace("\r\n","",$qry).' commit; END; ','RUN');
		return $rollbackRs = $mySQL->dbExecute(DB_CONNECTION,DB_DATABASE,DB_USERNAME,DB_PASSWORD,str_replace("\r\n","",$qry));
	}
}

//==============================================================================================
//=========================================== GROUP PERMISSION =================================
//if edit ke menu akses
if($_POST["editPermission"])
{
	//get max level of permission
	$editGetMaxLevel = "select MAX(MENULEVEL) MAXMENULEVEL from FLC_MENU
					where MENUROOT = ".$_POST['hiddenCode'];
	$editGetMaxLevelRsRows = $myQuery->query($editGetMaxLevel,'SELECT','NAME');	

	//get second level menus
	$secondLevel = "select * from FLC_MENU 
					where 
					MENUROOT = ".$_POST['hiddenCode']."
					and menulevel = 2
					order by MENUSTATUS desc , MENUORDER asc";
	$secondLevelRsRows = $myQuery->query($secondLevel,'SELECT','NAME');	
	$countSecondLevelRsRows = count($secondLevelRsRows);
}

//if update menu permission screen button is clicked
else if($_POST["saveScreenRefEdit"])
{		
	$postCount = count($_POST);									//count number of POST
	$getColumn_FLC_MENU = $mySQL->columnDatatype(DB_DATABASE,DB_USERNAME,'FLC_MENU');	//get FLC_MENU table 
	$theMenuID = getMenuID($_POST);								//get list of menu ids
	$countTheMenuID = count($theMenuID);						//count the menu id
	
	//if not set, set the array
	if(!isset($_SESSION['system_impexp']))
	{	
		$_SESSION['system_impexp'] = array();
		$_SESSION['system_impexp_full'] = array();
	}		
	
	//reset the array
	$_SESSION['system_impexp'][$_POST['hiddenCode']] = array();
	
	//store menu ids in session
	for($x=0; $x < $countTheMenuID; $x++)
	{
		//if not in array, add to array
		if(!in_array($theMenuID[$x],$_SESSION['system_impexp'][$_POST['hiddenCode']]))
		{	
			$_SESSION['system_impexp'][$_POST['hiddenCode']][] =  $theMenuID[$x];
			$_SESSION['system_impexp_full'][] = $theMenuID[$x];
		}
	}
		
	//dummy
	$_POST["showScreen"] = "some value";
}

//if reset export selection button
else if($_POST['resetExportSelection'])
	resetExportSelection();

//if export module button 
else if($_POST['exportModule'])
{
	//------------------------------------------------------------------------------------------------------------------------------
	//EXPORTING THE MENU
	//------------------------------------------------------------------------------------------------------------------------------
	//get FLC_MENU table 
	$getColumn_FLC_MENU = $mySQL->columnDatatype(DB_DATABASE,DB_USERNAME,'FLC_MENU');		
	
	//for location of key column
	$keyColumnLocation = 0;
	
	//for location of foreign key column
	$foreignKeyColumnLocation = 0;
	
	//for location of foreign key 2 column
	$foreignKey2ColumnLocation = 0;
	
	//get columnName
	for($x=0; $x < count($getColumn_FLC_MENU); $x++)
	{
		//if column is MENUID, store the location
		if($getColumn_FLC_MENU[$x]['COLUMN_NAME'] == 'MENUID')
			$keyColumnLocation = $x;
			
		//if column is MENUPARENT, store the location
		if($getColumn_FLC_MENU[$x]['COLUMN_NAME'] == 'MENUPARENT')
			$foreignKeyColumnLocation = $x;
	
		//if column is MENUROOT, store the location
		if($getColumn_FLC_MENU[$x]['COLUMN_NAME'] == 'MENUROOT')
			$foreignKey2ColumnLocation = $x;
	
		$columnName[] = $getColumn_FLC_MENU[$x]['COLUMN_NAME'];
		$dataType[] = $getColumn_FLC_MENU[$x]['DATA_TYPE'];
	}
	
	//count all menu ids
	$countTheMenuID = count($_SESSION['system_impexp_full']);
	
	//for all menu ids
	for($x=0; $x < $countTheMenuID; $x++)
	{
		//get the item
		$theItem = "select ".implode(',',$columnName)." from FLC_MENU where MENUID = ".$_SESSION['system_impexp_full'][$x];
		$theItemRs = $myQuery->query($theItem,'SELECT','INDEX');

		//get prepared values
		$values = padWithQuote($dataType,$theItemRs);
		$values = padKeyColumnWithStr($values,$keyColumnLocation,'[GLOBAL.MENUID]');

		$values = padKeyColumnWithStr($values,$foreignKeyColumnLocation,'[GLOBAL.MENUID]');
		$values = padKeyColumnWithStr($values,$foreignKey2ColumnLocation,'[GLOBAL.MENUID]');

		//prepare the insert statement		
		 $getQry_FLC_MENU[] = "insert into FLC_MENU (".implode(',',$columnName).") values (".implode(',',$values).");\r\n";		//append insert stmt to arr
	}
		
	createDir('export_import');
	$timestamp = date('YmdHis');
	writeToDump($timestamp,$getQry_FLC_MENU);				//write to file

	//---------------------------------------------------------------------------------------------------------------------
	//EXPORTING THE PAGE
	//---------------------------------------------------------------------------------------------------------------------
	//get FLC_PAGE table 
	$getColumn_FLC_PAGE = $mySQL->columnDatatype(DB_DATABASE,DB_USERNAME,'FLC_PAGE');		
	
	//for location of key column
	$keyColumnLocation = 0;
	
	//for location of foreign key column
	$foreignKeyColumnLocation = 0;
		
	//reset
	$columnName = array();
	$dataType = array();
	
	//var
	$pageIDList = array();
	
	//get columnName
	for($x=0; $x < count($getColumn_FLC_PAGE); $x++)
	{
		//if column is PAGEID, store the location
		if($getColumn_FLC_PAGE[$x]['COLUMN_NAME'] == 'PAGEID')
			$keyColumnLocation = $x;
			
		//if column is MENUID, store the location
		if($getColumn_FLC_PAGE[$x]['COLUMN_NAME'] == 'MENUID')
			$foreignKeyColumnLocation = $x;
		
		$columnName[] = $getColumn_FLC_PAGE[$x]['COLUMN_NAME'];
		$dataType[] = $getColumn_FLC_PAGE[$x]['DATA_TYPE'];
	}
	
	//for all menu ids
	for($x=0; $x < $countTheMenuID; $x++)
	{
		//get the item
		$theItem = "select ".implode(',',$columnName)." from FLC_PAGE where MENUID = ".$_SESSION['system_impexp_full'][$x];
		$theItemRs = $myQuery->query($theItem,'SELECT','INDEX');
		
		//get pageid
		$getPageID = "select PAGEID from FLC_PAGE where MENUID = ".$_SESSION['system_impexp_full'][$x];
		$getPageIDRs = $myQuery->query($getPageID,'SELECT','INDEX');
		
		//if page id is exist
		if($getPageIDRs[0][0] != '')
			$pageIDList[] = $getPageIDRs[0][0];
				
		//if theres result, create insert statement
		if(count($theItemRs) > 0)
		{
			//get prepared values
			$values = padWithQuote($dataType,$theItemRs);
			$values = padKeyColumnWithStr($values,$keyColumnLocation,'[GLOBAL.PAGEID]');
			$values = padKeyColumnWithStr($values,$foreignKeyColumnLocation,'[GLOBAL.MENUID]');
	
			//prepare the insert statement		
			$getQry_FLC_PAGE[] = "insert into FLC_PAGE (".implode(',',$columnName).") values (".implode(',',$values).");\r\n";		//append insert stmt to arr
		}
	}
	
	writeToDump($timestamp,$getQry_FLC_PAGE);				//write to file

	//---------------------------------------------------------------------------------------------------------------------
	//EXPORTING THE PAGE COMPONENT
	//---------------------------------------------------------------------------------------------------------------------
	//get FLC_PAGE_COMPONENT table 
	$getColumn_FLC_PAGE_COMPONENT = $mySQL->columnDatatype(DB_DATABASE,DB_USERNAME,'FLC_PAGE_COMPONENT');
	
	//for location of key column
	$keyColumnLocation = 0;
	
	//for location of foreign key column
	$foreignKeyColumnLocation = 0;
	
	//for location of COMPONENTTYPEQUERY 
	$queryLocation = 0;
	
	//for location of COMPONENTADDROWJAVASCRIPT
	$addRowJavascriptLocation = 0;
	
	//for location of COMPONENTDELETEROWJAVASCRIPT
	$deleteRowJavascriptLocation = 0;
		
	//reset
	$columnName = array();
	$dataType = array();
	
	//var
	$componentIDList = array();
	
	//get columnName
	for($x=0; $x < count($getColumn_FLC_PAGE_COMPONENT); $x++)
	{
		//if column is COMPONENTID, store the location
		if($getColumn_FLC_PAGE_COMPONENT[$x]['COLUMN_NAME'] == 'COMPONENTID')
			$keyColumnLocation = $x;
			
		//if column is PAGEID, store the location
		else if($getColumn_FLC_PAGE_COMPONENT[$x]['COLUMN_NAME'] == 'PAGEID')
			$foreignKeyColumnLocation = $x;
	
		//if column is PAGEID, store the location
		else if($getColumn_FLC_PAGE_COMPONENT[$x]['COLUMN_NAME'] == 'COMPONENTTYPEQUERY')
			$queryLocation = $x;
	
			//if column is PAGEID, store the location
		else if($getColumn_FLC_PAGE_COMPONENT[$x]['COLUMN_NAME'] == 'COMPONENTADDROWJAVASCRIPT')
			$addRowJavascriptLocation = $x;

		//if column is PAGEID, store the location
		else if($getColumn_FLC_PAGE_COMPONENT[$x]['COLUMN_NAME'] == 'COMPONENTDELETEROWJAVASCRIPT')
			$deleteRowJavascriptLocation = $x;

		$columnName[] = $getColumn_FLC_PAGE_COMPONENT[$x]['COLUMN_NAME'];
		$dataType[] = $getColumn_FLC_PAGE_COMPONENT[$x]['DATA_TYPE'];
	}
	
	//for all page ids
	for($x=0; $x < count($pageIDList); $x++)
	{
		//get the page component associated with the pageid
		$theItem = "select ".implode(',',$columnName)." from FLC_PAGE_COMPONENT where PAGEID = ".$pageIDList[$x];
		$theItemRs = $myQuery->query($theItem,'SELECT','INDEX');
		
		//get component id
		$getComponentID = "select COMPONENTID from FLC_PAGE_COMPONENT where PAGEID = ".$pageIDList[$x];
		$getComponentIDRs = $myQuery->query($getComponentID,'SELECT','INDEX');
		
		for($y=0; $y < count($getComponentIDRs); $y++)
		{
			//if component id is exist
			if($getComponentIDRs[$y][0] != '')
				$componentIDList[] = $getComponentIDRs[$y][0];
		}
		
		//if theres result, create insert statement
		if(count($theItemRs) > 0)
		{
			for($y=0; $y < count($theItemRs); $y++)
			{
				$tempItem[0] = $theItemRs[$y];
			
				//get prepared values
				$values = padWithQuote($dataType,$tempItem);
				$values = padKeyColumnWithStr($values,$keyColumnLocation,'[GLOBAL.COMPONENTID]');
				$values = padKeyColumnWithStr($values,$foreignKeyColumnLocation,'[GLOBAL.PAGEID]');
				$values = padParamWithStr($values,$queryLocation);
				
				//for javascript
				$values = padJSParamWithStr($values,$addRowJavascriptLocation);
				$values = padJSParamWithStr($values,$deleteRowJavascriptLocation);

				//prepare the insert statement		
				$getQry_FLC_PAGE_COMPONENT[] = "insert into FLC_PAGE_COMPONENT (".implode(',',$columnName).") values (".implode(',',$values).");\r\n";		//append insert stmt to arr
			}
		}
	}
		
	writeToDump($timestamp,$getQry_FLC_PAGE_COMPONENT);				//write to file	

	//---------------------------------------------------------------------------------------------------------------------
	//EXPORTING THE PAGE COMPONENT ITEMS
	//---------------------------------------------------------------------------------------------------------------------
	//get FLC_PAGE_COMPONENT_ITEMS table 
	$getColumn_FLC_PAGE_COMPONENT_ITEMS = $mySQL->columnDatatype(DB_DATABASE,DB_USERNAME,'FLC_PAGE_COMPONENT_ITEMS');	
	
	//for location of key column
	$keyColumnLocation = 0;
	
	//for location of foreign key column
	$foreignKeyColumnLocation = 0;
	
	//for location of string column to be processed
	$stringColumnLocation = 0;
	
	//for location of ITEMLOOKUP 
	$itemLookupLocation = 0;
	
	//for location of ITEMJAVASCRIPT
	$itemJavascriptLocation = 0;
	
	//reset
	$columnName = array();
	$dataType = array();
	
	//get columnName
	for($x=0; $x < count($getColumn_FLC_PAGE_COMPONENT_ITEMS); $x++)
	{
		//if column is ITEMID, store the location
		if($getColumn_FLC_PAGE_COMPONENT_ITEMS[$x]['COLUMN_NAME'] == 'ITEMID')
			$keyColumnLocation = $x;
			
		//if column is PAGEID, store the location
		else if($getColumn_FLC_PAGE_COMPONENT_ITEMS[$x]['COLUMN_NAME'] == 'COMPONENTID')
			$foreignKeyColumnLocation = $x;
			
		//if column is ITEMDEFAULTVALUE, store the location
		else if($getColumn_FLC_PAGE_COMPONENT_ITEMS[$x]['COLUMN_NAME'] == 'ITEMDEFAULTVALUE')
			$stringColumnLocation = $x;

		//if column is ITEMLOOKUP, store the location
		else if($getColumn_FLC_PAGE_COMPONENT_ITEMS[$x]['COLUMN_NAME'] == 'ITEMLOOKUP')
			$itemLookupLocation = $x;
			
		//if column is ITEMJAVASCRIPT, store the location
		else if($getColumn_FLC_PAGE_COMPONENT_ITEMS[$x]['COLUMN_NAME'] == 'ITEMJAVASCRIPT')
			$itemJavascriptLocation = $x;

		$columnName[] = $getColumn_FLC_PAGE_COMPONENT_ITEMS[$x]['COLUMN_NAME'];
		$dataType[] = $getColumn_FLC_PAGE_COMPONENT_ITEMS[$x]['DATA_TYPE'];
	}
	
	//for all page ids
	for($x=0; $x < count($componentIDList); $x++)
	{
		//get the item
		$theItem = "select ".implode(',',$columnName)." from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = ".$componentIDList[$x];
		$theItemRs = $myQuery->query($theItem,'SELECT','INDEX');
		
		//if theres result, create insert statement
		if(count($theItemRs) > 0)
		{
			for($y=0; $y < count($theItemRs); $y++)
			{
				$tempItem[0] = $theItemRs[$y];
			
				//get prepared values
				$values = padWithQuote($dataType,$tempItem);
				$values = padKeyColumnWithStr($values,$keyColumnLocation,'[GLOBAL.ITEMID]');
				$values = padKeyColumnWithStr($values,$foreignKeyColumnLocation,'[GLOBAL.COMPONENTID]');
				
				//default value
				$values = padStringColWithStr($values,$stringColumnLocation,'menuID');						//for url in default value 
				$values = padParamWithStr($values,$stringColumnLocation);									//for parameter in default value
				
				//for lookup in itemlookup
				$values = padParamWithStr($values,$itemLookupLocation);
				
				//for itemjavascript
				$values = padJSParamWithStr($values,$itemJavascriptLocation);
				
				//prepare the insert statement		
				$getQry_FLC_PAGE_COMPONENT_ITEMS[] = "insert into FLC_PAGE_COMPONENT_ITEMS (".implode(',',$columnName).") values (".implode(',',$values).");\r\n";		//append insert stmt to arr
			}
		}
	}
		
	writeToDump($timestamp,$getQry_FLC_PAGE_COMPONENT_ITEMS);				//write to file

	//---------------------------------------------------------------------------------------------------------------------
	//EXPORTING PAGE CONTROL
	//---------------------------------------------------------------------------------------------------------------------
	//get FLC_PAGE_CONTROL table 
	$getColumn_FLC_PAGE_CONTROL = $mySQL->columnDatatype(DB_DATABASE,DB_USERNAME,'FLC_PAGE_CONTROL');
	
	//for location of key column
	$keyColumnLocation = 0;
	
	//for location of foreign key column
	$foreignKeyColumnLocation = 0;
	
	//for location of string column to be processed
	$stringColumnLocation = 0;

	//reset
	$columnName = array();
	$dataType = array();
	
	//get columnName
	for($x=0; $x < count($getColumn_FLC_PAGE_CONTROL); $x++)
	{
		//if column is COMPONENTID, store the location
		if($getColumn_FLC_PAGE_CONTROL[$x]['COLUMN_NAME'] == 'CONTROLID')
			$keyColumnLocation = $x;
			
		//if column is PAGEID, store the location
		if($getColumn_FLC_PAGE_CONTROL[$x]['COLUMN_NAME'] == 'PAGEID')
			$foreignKeyColumnLocation = $x;
			
		//if column is CONTROLREDIRECTURL, store the location
		if($getColumn_FLC_PAGE_CONTROL[$x]['COLUMN_NAME'] == 'CONTROLREDIRECTURL')
			$stringColumnLocation = $x;
		
		$columnName[] = $getColumn_FLC_PAGE_CONTROL[$x]['COLUMN_NAME'];
		$dataType[] = $getColumn_FLC_PAGE_CONTROL[$x]['DATA_TYPE'];
	}
	
	//for all page ids
	for($x=0; $x < count($pageIDList); $x++)
	{
		//get the item
		$theItem = "select ".implode(',',$columnName)." from FLC_PAGE_CONTROL where PAGEID = ".$pageIDList[$x];
		$theItemRs = $myQuery->query($theItem,'SELECT','INDEX');
		
		//if theres result, create insert statement
		if(count($theItemRs) > 0)
		{
			for($y=0; $y < count($theItemRs); $y++)
			{
				$tempItem[0] = $theItemRs[$y];
			
				//get prepared values
				$values = padWithQuote($dataType,$tempItem);
				$values = padKeyColumnWithStr($values,$keyColumnLocation,'[GLOBAL.CONTROLID]');
				$values = padKeyColumnWithStr($values,$foreignKeyColumnLocation,'[GLOBAL.PAGEID]');
				$values = padStringColWithStr($values,$stringColumnLocation,'menuID');
				
				//prepare the insert statement		
				$getQry_FLC_PAGE_CONTROL[] = "insert into FLC_PAGE_CONTROL (".implode(',',$columnName).") values (".implode(',',$values).");\r\n";		//append insert stmt to arr
			}
		}
	}
	
	writeToDump($timestamp,$getQry_FLC_PAGE_CONTROL);				//write to file
		
	/*//---------------------------------------------------------------------------------------------------------------------
	//EXPORTING BUSINESS LOGIC
	//---------------------------------------------------------------------------------------------------------------------
	//get FLC_PAGE_CONTROL table 
	$getColumn_FLC_BL = $mySQL->columnDatatype(DB_DATABASE,DB_USERNAME,'FLC_BL');
	
	//for location of key column
	$keyColumnLocation = 0;
	
	//for location of foreign key column
	$foreignKeyColumnLocation = 0;
	
	//for location of string column to be processed
	$stringColumnLocation = 0;

	//reset
	$columnName = array();
	$dataType = array();
	
	//get columnName
	for($x=0; $x < count($getColumn_FLC_BL); $x++)
	{
		//if column is COMPONENTID, store the location
		if($getColumn_FLC_BL[$x]['COLUMN_NAME'] == 'CONTROLID')
			$keyColumnLocation = $x;
			
		//if column is PAGEID, store the location
		if($getColumn_FLC_BL[$x]['COLUMN_NAME'] == 'PAGEID')
			$foreignKeyColumnLocation = $x;
			
		//if column is CONTROLREDIRECTURL, store the location
		if($getColumn_FLC_BL[$x]['COLUMN_NAME'] == 'CONTROLREDIRECTURL')
			$stringColumnLocation = $x;
		
		$columnName[] = $getColumn_FLC_BL[$x]['COLUMN_NAME'];
		$dataType[] = $getColumn_FLC_BL[$x]['DATA_TYPE'];
	}
	
	//for all page ids
	for($x=0; $x < count($pageIDList); $x++)
	{
		//get the item
		$theItem = "select ".implode(',',$columnName)." from FLC_BL where PAGEID = ".$pageIDList[$x];
		$theItemRs = $myQuery->query($theItem,'SELECT','INDEX');
		
		//if theres result, create insert statement
		if(count($theItemRs) > 0)
		{
			for($y=0; $y < count($theItemRs); $y++)
			{
				$tempItem[0] = $theItemRs[$y];
			
				//get prepared values
				$values = padWithQuote($dataType,$tempItem);
				$values = padKeyColumnWithStr($values,$keyColumnLocation,'[GLOBAL.CONTROLID]');
				$values = padKeyColumnWithStr($values,$foreignKeyColumnLocation,'[GLOBAL.PAGEID]');
				$values = padStringColWithStr($values,$stringColumnLocation,'menuID');
				
				//prepare the insert statement		
				$getQry_FLC_PAGE_CONTROL[] = "insert into FLC_PAGE_CONTROL (".implode(',',$columnName).") values (".implode(',',$values).");\r\n";		//append insert stmt to arr
			}
		}
	}
	
	//writeToDump($timestamp,$getQry_FLC_PAGE_CONTROL);				//write to file*/
		
	//post export thingy
	resetExportSelection();							//reset selection
	$exportSuccessFlag = true;						//show export msg
	$dumpLink = $_SESSION['userID'].$timestamp;		//for data dump download link
}

//if import module button
else if($_POST['importModule'])
{
	$timestamp = date('YmdHis');

	$uploaddir = 'export_import/';
	$uploadfile = $uploaddir . 'imp_'.$_SESSION['userID'].$timestamp.'.fdmp';

	if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) 
	{
		//echo "File was successfully uploaded.";
	} 
	else 
	{
		//echo "Possible file upload attack!\n";
	}
	
	//get max running number for all tables
	$menuIDMax = $mySQL->maxValue('FLC_MENU','MENUID');
	$pageIDMax = $mySQL->maxValue('FLC_PAGE','PAGEID');
	$componentIDMax = $mySQL->maxValue('FLC_PAGE_COMPONENT','COMPONENTID');
	$itemIDMax = $mySQL->maxValue('FLC_PAGE_COMPONENT_ITEMS','ITEMID');
	$controlIDMax = $mySQL->maxValue('FLC_PAGE_CONTROL','CONTROLID');
	
	//get uploaded file content
	$uploadedFileStr = file_get_contents($uploaddir . 'imp_'.$_SESSION['userID'].$timestamp.'.fdmp');
	
	//replace menuparent = 0, menuroot = null to normal character, do not update ID!
	$uploadedFileStr = str_replace('[GLOBAL.MENUID]0[GLOBAL.MENUID]','0',$uploadedFileStr);
	$uploadedFileStr = str_replace('[GLOBAL.MENUID]null[GLOBAL.MENUID]','null',$uploadedFileStr);	
	
	//scan for all GLOBAL ID(MENUID, PAGEID, COMPONENTID, ITEMID,CONTROLID)
	//echo substr_count($text, 'is'); 
	
	$menuIDGlobalArr = scanGlobalID($uploadedFileStr,'[GLOBAL.MENUID]');
	$pageIDGlobalArr = scanGlobalID($uploadedFileStr,'[GLOBAL.PAGEID]');
	$componentIDGlobalArr = scanGlobalID($uploadedFileStr,'[GLOBAL.COMPONENTID]');
	$itemIDGlobalArr = scanGlobalID($uploadedFileStr,'[GLOBAL.ITEMID]');
	$controlIDGlobalArr = scanGlobalID($uploadedFileStr,'[GLOBAL.CONTROLID]');
	
	//remove duplicates
	$menuIDGlobalArr = array_unique($menuIDGlobalArr);
	$pageIDGlobalArr = array_unique($pageIDGlobalArr);
	$componentIDGlobalArr = array_unique($componentIDGlobalArr);		
	$itemIDGlobalArr = array_unique($itemIDGlobalArr);	
	$controlIDGlobalArr = array_unique($controlIDGlobalArr);	
	
	//sort the array
	natsort($menuIDGlobalArr);
	natsort($pageIDGlobalArr);
	natsort($componentIDGlobalArr);
	natsort($itemIDGlobalArr);
	natsort($controlIDGlobalArr);
	
	//to reset keys
	$menuIDGlobalArr = array_values($menuIDGlobalArr);
	$pageIDGlobalArr = array_values($pageIDGlobalArr);
	$componentIDGlobalArr = array_values($componentIDGlobalArr);
	$itemIDGlobalArr = array_values($itemIDGlobalArr);
	$controlIDGlobalArr = array_values($controlIDGlobalArr);
	
	
	//sort($menuIDGlobalArr);
	//sort($pageIDGlobalArr);
	//sort($componentIDGlobalArr);
	//sort($itemIDGlobalArr);
	//sort($controlIDGlobalArr);
	
	//create new array to store updated IDS
	$new_menuIDGlobalArr = updateIDToNew($menuIDGlobalArr,$menuIDMax,'[GLOBAL.MENUID]');
	$new_pageIDGlobalArr = updateIDToNew($pageIDGlobalArr,$pageIDMax,'[GLOBAL.PAGEID]');
	$new_componentIDGlobalArr = updateIDToNew($componentIDGlobalArr,$componentIDMax,'[GLOBAL.COMPONENTID]');
	$new_itemIDGlobalArr = updateIDToNew($itemIDGlobalArr,$itemIDMax,'[GLOBAL.ITEMID]');
	$new_controlIDGlobalArr = updateIDToNew($controlIDGlobalArr,$controlIDMax,'[GLOBAL.CONTROLID]');
	
	//debug	
	//echo '<pre><div style="height:300px;overflow:auto;">';
	//echo '<table style="width:90%"><tr><td>';
	
	//print_r($menuIDGlobalArr);
	//print_r($pageIDGlobalArr);
	//print_r($componentIDGlobalArr);
	//print_r($itemIDGlobalArr);
	//print_r($controlIDGlobalArr);
	
	//echo '</td>';
	//echo'<td>';
	
	//print_r($new_menuIDGlobalArr);
	//print_r($new_pageIDGlobalArr);
	//print_r($new_componentIDGlobalArr);
	//print_r($new_itemIDGlobalArr);
	//print_r($new_controlIDGlobalArr);
	
	//echo '</td></tr></table>';
	//echo '</div></pre>';
	
	//print_r($pageIDGlobalArr);
	//print_r($componentIDGlobalArr);
	//print_r($itemIDGlobalArr);
	//print_r($controlIDGlobalArr);
	
	//replace all occurence with the string
	
	/*for($x=0; $x < count($menuIDGlobalArr); $x++)
	{
		if($x == 0)
			$id = current($menuIDGlobalArr);
		else
			$id = next($menuIDGlobalArr);
	
		$uploadedFileStr = str_replace($id,$new_menuIDGlobalArr[$x],$uploadedFileStr);
	}
	
	for($x=0; $x < count($pageIDGlobalArr); $x++)
	{
		if($x == 0)
			$id = current($pageIDGlobalArr);
		else
			$id = next($pageIDGlobalArr);
	
		$uploadedFileStr = str_replace($id,$new_pageIDGlobalArr[$x],$uploadedFileStr);
	}
	
	for($x=0; $x < count($componentIDGlobalArr); $x++)
	{
		if($x == 0)
			$id = current($componentIDGlobalArr);
		else
			$id = next($componentIDGlobalArr);
	
		$uploadedFileStr = str_replace($id,$new_componentIDGlobalArr[$x],$uploadedFileStr);
	}
	
	for($x=0; $x < count($itemIDGlobalArr); $x++)
	{
		if($x == 0)
			$id = current($itemIDGlobalArr);
		else
			$id = next($itemIDGlobalArr);
	
		$uploadedFileStr = str_replace($id,$new_itemIDGlobalArr[$x],$uploadedFileStr);
	}
	
	for($x=0; $x < count($controlIDGlobalArr); $x++)
	{
		if($x == 0)
			$id = current($controlIDGlobalArr);
		else
			$id = next($controlIDGlobalArr);
	
		$uploadedFileStr = str_replace($id,$new_controlIDGlobalArr[$x],$uploadedFileStr);
	}*/
	
	
	$uploadedFileStr = str_replace($menuIDGlobalArr,$new_menuIDGlobalArr,$uploadedFileStr);
	$uploadedFileStr = str_replace($pageIDGlobalArr,$new_pageIDGlobalArr,$uploadedFileStr);
	$uploadedFileStr = str_replace($componentIDGlobalArr,$new_componentIDGlobalArr,$uploadedFileStr);
	$uploadedFileStr = str_replace($itemIDGlobalArr,$new_itemIDGlobalArr,$uploadedFileStr);
	$uploadedFileStr = str_replace($controlIDGlobalArr,$new_controlIDGlobalArr,$uploadedFileStr);

	//remove global IDS string
	$globalStrOld = array('[GLOBAL.MENUID]','[GLOBAL.PAGEID]','[GLOBAL.COMPONENTID]','[GLOBAL.ITEMID]','[GLOBAL.CONTROLID]');
	$globalStrNew = array('','','','','');
	$uploadedFileStr = str_ireplace($globalStrOld,$globalStrNew,$uploadedFileStr);


	//echo '<pre>'.$uploadedFileStr.'</pre>';

	//save converted
	file_put_contents($uploaddir . 'imp_'.$_SESSION['userID'].$timestamp.'_conv',$uploadedFileStr);
	
	//use BEGIN and END; to run multiple statements
	//replace carriage return with empty string to work around oracle script carriage return problem
	//$insertCatRs = $myQuery->query('BEGIN '.str_replace("\r\n","",$uploadedFileStr).' END;','RUN');
	
	//echo ''.str_replace("\r\n","<br>",$uploadedFileStr).'';
	
	if(strtoupper(DBMS_NAME) == 'ORACLE')
	{
		$insertCatRs = $mySQL->dbExecute(DB_CONNECTION,DB_DATABASE,DB_USERNAME,DB_PASSWORD,str_replace("\r\n","",$uploadedFileStr));
	}
	
	else if(strtoupper(DBMS_NAME) == 'MYSQL')
	{
		$tempArr = explode(";\r\ninsert into ",$uploadedFileStr);
		$tempArrCount = count($tempArr);
		
		for($x=0; $x < $tempArrCount; $x++)
		{
			if($x == 0)
				$qry = str_replace(";\r\ncommit",'',$tempArr[$x]);
			else
				$qry = "insert into ".str_replace(";\r\ncommit",'',$tempArr[$x]);
			
			$insertCatRs = $myQuery->query($qry,'RUN');
			
			//$insertCatRs = $mySQL->dbExecute(DB_CONNECTION,DB_DATABASE,DB_USERNAME,DB_PASSWORD,str_replace("\r\n","",$qry));
	
			//$qry = "insert into ".str_replace(";\r\ncommit"$tempArr[$x];
			//$updateMenuContentRs = $myQuery->query($qry,'RUN');
		}
		
		$insertCatRs = true;
	}
	//print_r($tempArr);

	
	//post export cleansing
	//remove [NL] and all special character
	//update menu content
	$updateMenuContent = "update FLC_MENU 
						set menuname = replace(replace(replace(menuname,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'), 
						menulink = replace(replace(replace(menulink,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':')
						where menuid > ".$menuIDMax;
	$updateMenuContentRs = $myQuery->query($updateMenuContent,'RUN');
	
	//update page content
	$updatePageContent = "update FLC_PAGE 
						set PAGENAME = replace(replace(replace(PAGENAME,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'), 
						PAGEBREADCRUMBS = replace(replace(replace(PAGEBREADCRUMBS,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
						PAGEDESC = replace(replace(replace(PAGEDESC,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
						PAGEPRESCRIPT = replace(replace(replace(PAGEPRESCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
						PAGEPOSTSCRIPT = replace(replace(replace(PAGEPOSTSCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
						PAGENOTES = replace(replace(replace(PAGENOTES,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':')
						where pageid > ".$pageIDMax;
	$updatePageContentRs = $myQuery->query($updatePageContent,'RUN');
	
	//update COMPONENT content
	if(strtoupper(DBMS_NAME) == 'ORACLE')
	{
		$updateComponentContent = "update FLC_PAGE_COMPONENT
							set COMPONENTNAME = replace(replace(replace(COMPONENTNAME,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'), 
							COMPONENTTYPEQUERY = replace(replace(replace(COMPONENTTYPEQUERY,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTPRESCRIPT = replace(replace(replace(COMPONENTPRESCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTPOSTSCRIPT = replace(replace(replace(COMPONENTPOSTSCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTUPLOADCOLUMN = replace(replace(replace(COMPONENTUPLOADCOLUMN,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTADDROWJAVASCRIPT = replace(replace(replace(COMPONENTADDROWJAVASCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTDELETEROWJAVASCRIPT = replace(replace(replace(COMPONENTDELETEROWJAVASCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':')
							where componentid > ".$componentIDMax;
		$updateComponentContentRs = $myQuery->query($updateComponentContent,'RUN');
	}
	else if(strtoupper(DBMS_NAME) == 'MYSQL')
	{
		$updateComponentContent = "update FLC_PAGE_COMPONENT
							set COMPONENTNAME = replace(replace(replace(COMPONENTNAME,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'), 
							COMPONENTTYPEQUERY = replace(replace(replace(COMPONENTTYPEQUERY,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTPRESCRIPT = replace(replace(replace(COMPONENTPRESCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTPOSTSCRIPT = replace(replace(replace(COMPONENTPOSTSCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTUPLOADCOLUMN = replace(replace(replace(COMPONENTUPLOADCOLUMN,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTADDROWJAVASCRIPT = replace(replace(replace(COMPONENTADDROWJAVASCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							COMPONENTDELETEROWJAVASCRIPT = replace(replace(replace(COMPONENTDELETEROWJAVASCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':')
							where componentid > ".$componentIDMax;
		$updateComponentContentRs = $myQuery->query($updateComponentContent,'RUN');
	}

	if(strtoupper(DBMS_NAME) == 'ORACLE')
	{
		//update ITEM content
		$updateItemContent = "update FLC_PAGE_COMPONENT_ITEMS
							set ITEMDEFAULTVALUE = replace(replace(replace(ITEMDEFAULTVALUE,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'), 
							ITEMLOOKUP = replace(replace(replace(ITEMLOOKUP,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMLOOKUPSECONDARY = replace(replace(replace(ITEMLOOKUPSECONDARY,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMJAVASCRIPT = replace(replace(replace(ITEMJAVASCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMAGGREGATECOLUMNLABEL = replace(replace(replace(ITEMAGGREGATECOLUMNLABEL,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMUPLOAD = replace(replace(replace(ITEMUPLOAD,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMDELIMITER = replace(replace(replace(ITEMDELIMITER,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMLOOKUPUNLIMITED = replace(replace(replace(ITEMLOOKUPUNLIMITED,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMUPPERCASE = replace(replace(replace(ITEMUPPERCASE,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMNAME = replace(replace(replace(ITEMNAME,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMNOTES = replace(replace(replace(ITEMNOTES,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':')
							where itemid > ".$itemIDMax;
		$updateItemContentRs = $myQuery->query($updateItemContent,'RUN');
	}
	else if(strtoupper(DBMS_NAME) == 'MYSQL')
	{
		//update ITEM content
		$updateItemContent = "update FLC_PAGE_COMPONENT_ITEMS
							set ITEMDEFAULTVALUE = replace(replace(replace(ITEMDEFAULTVALUE,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'), 
							ITEMLOOKUP = replace(replace(replace(ITEMLOOKUP,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMLOOKUPSECONDARY = replace(replace(replace(ITEMLOOKUPSECONDARY,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMJAVASCRIPT = replace(replace(replace(ITEMJAVASCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMAGGREGATECOLUMNLABEL = replace(replace(replace(ITEMAGGREGATECOLUMNLABEL,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMUPLOAD = replace(replace(replace(ITEMUPLOAD,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMDELIMITER = replace(replace(replace(ITEMDELIMITER,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMLOOKUPUNLIMITED = replace(replace(replace(ITEMLOOKUPUNLIMITED,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMUPPERCASE = replace(replace(replace(ITEMUPPERCASE,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMNAME = replace(replace(replace(ITEMNAME,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
							ITEMNOTES = replace(replace(replace(ITEMNOTES,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':')
							where itemid > ".$itemIDMax;
		$updateItemContentRs = $myQuery->query($updateItemContent,'RUN');
	}
	
	//update CONTROL content
	$updateControlContent = "update FLC_PAGE_CONTROL
						set CONTROLNAME = replace(replace(replace(CONTROLNAME,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'), 
						CONTROLREDIRECTURL = replace(replace(replace(CONTROLREDIRECTURL,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
						CONTROLJAVASCRIPT = replace(replace(replace(CONTROLJAVASCRIPT,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':'),
						CONTROLNOTES = replace(replace(replace(CONTROLNOTES,'[AMPERSAND]','&'),'[NL]','\r\n'),'[COLON]',':')
						where controlid > ".$controlIDMax;
	$updateControlContentRs = $myQuery->query($updateControlContent,'RUN');
	
	//create rollback data
	$rollbackData = createRollbackData($mySQL,$menuIDMax,$pageIDMax,$componentIDMax,$itemIDMax,$controlIDMax);
	dumpRollbackData($timestamp,$rollbackData);
	
	//refresh side menu
	$_POST['menuForceRefresh'] ="Refresh Side Menu" ;
}

//if rollback module is selected
else if($_POST['rollbackModule'])
{
	//rollback the data
	$rollbackRs = rollbackData($mySQL);
	
	//remove the rollback data file
	@unlink('export_import/rollback/'.$_POST['rollbackList']);

	//get updated rollback list	
	$rollbackList = getRollbackList();			//get list of rollback data

}

//get menu permission
$menuPermission = "select MENUID, MENUNAME, MENUSTATUS from FLC_MENU where MENUROOT is null 
						and MENUPARENT = 0 
						order by MENUSTATUS desc, MENUNAME asc";
$menuPermissionRsArr = $myQuery->query($menuPermission,'SELECT','NAME');
$countMenuPermissionRsArr = count($menuPermissionRsArr);

?>
<script language="javascript">

//prerequisite: prototpye.js
//this function will check only checkboxes with similar names
//eg: check menuPermission_1222
//will check menuPermission_1222_001, menuPermission_1222_002, menuPermission_1222_003
function selectChildCheckbox(elem,toReplace)
{	
	var checkboxArr = $$('input[type="checkbox"]');					//find all checkbox item
	var theParentID = elem.id;										//get parent id

	var theParentIDReplaced = theParentID.replace(toReplace,'');	//replace var toReplace with empty string
	
	if(elem.checked == true)
		var checkValue = true;
	else
		var checkValue = false;
	
	//for all checkboxes
	for(var x=0; x < checkboxArr.size(); x++)
	{
		if(checkboxArr[x].id.match(toReplace+theParentIDReplaced))		//if checkbox id matched with eg: menuPermission_1222
			checkboxArr[x].checked = checkValue;						//check the checkbox to true
	}
}

//to check master checkbox
function selectMasterCheckbox(elem)
{
	var elemIDSplit = elem.id.split('_');
	var elemIDSplitCount = elemIDSplit.length;
	
	//if menu level 3 (eg: moduleSelection_16_17), check level 2 (eg:moduleSelection_16)
	if(elemIDSplitCount == 3)
	{
		$(elemIDSplit[0] + '_' + elemIDSplit[1]).checked = true;
	}
}


function ajaxCascadeTabularOnSuccess(target)
{
	//window.alert(target);

	//$('textfield').value = 'aaa';
	//window.alert('sss');
}


</script>
<script language="javascript" src="js/editor.js"></script>
<style type="text/css">

<!--
.style1 {
	font-size: 10px;
	font-style: italic;
}
-->
</style>
<div id="breadcrumbs">Modul Pentadbir Sistem / System Import and Export /
  <?php if($_POST["editScreen"]) echo " Edit /"?>
</div>
<h1>System Import and Export</h1>
<?php //if update successful
  if($insertCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>System import has been successfully performed on <?php echo date('Y-m-d H:i:s')?> by <?php echo $_SESSION['userName']?>. Please <strong>check</strong> the imported module(s) for consistency. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if export success
  if($exportSuccessFlag) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>The selected module(s) has been successfully exported. Please download the data file <a href="system_impexp_downloader.php?file=<?php echo $dumpLink?>.fdmp" target="_blank"><strong>HERE</strong></a>.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if rollback successfull
  if($rollbackRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>A ROLLBACK using rollback data <strong><?php echo $_POST['rollbackList']?></strong> has been performed.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php if(!isset($_POST["editScreen"]))  { ?>
<form action="" method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">What Do You Want To Do? </th>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Important Note : </td>
      <td><strong>Please use the latest EDF database structure before importing or exporting data. </strong></td>
    </tr>
    <tr>
      <td width="74" nowrap="nowrap" class="inputLabel">Type : </td>
      <td width="662"><label>
        <input name="impexp_type" type="radio" onChange="form1.submit()" value="imp" <?php if($_POST['impexp_type'] == 'imp') { ?> checked<?php } else if($_POST['impexp_type'] != 'imp' && $_POST['impexp_type'] != 'exp') { ?>checked<?php } ?>>
        IMPORT Module</label>
        <br />
        <label>
        <input name="impexp_type" type="radio" value="exp" onChange="form1.submit()" <?php if($_POST['impexp_type'] == 'exp') { ?> checked<?php }?>>
        EXPORT  Module</label>
        <br />
        <label>
        <input name="impexp_type" type="radio" value="roll" onChange="form1.submit()" <?php if($_POST['impexp_type'] == 'roll') { ?> checked<?php }?>>
        ROLLBACK  Module</label>
        <br />
        <label style="color:#666666">
        <input disabled="disabled" name="impexp_type" type="radio" value="reference" >
        User System Reference</label>
        <br />
		<label style="color:#666666">
        <input disabled="disabled" name="impexp_type" type="radio" value="structure_sync" >
        System
        DB Structure Sync</label></td>
    </tr>
    <?php if($_POST['impexp_type'] == 'imp' || !isset($_POST['impexp_type'])) {  ?>
    <tr id="importRow">
      <td nowrap="nowrap" class="inputLabel">Import File : </td>
      <td><input name="importFile" type="file" id="importFile" size="40">      </td>
    </tr>
    <?php } ?>
    <?php if($_POST['impexp_type'] == 'roll') {  ?>
    <tr id="rollbackRow">
      <td nowrap="nowrap" class="inputLabel">Rollback Data : </td>
      <td><?php if(count($rollbackList) > 0)  {?>
        <select name="rollbackList" id="rollbackList" class="inputList">
          <?php for($x=0; $x < count($rollbackList); $x++) { ?>
          <option value="<?php echo $rollbackList[$x]?>"><?php echo $rollbackList[$x]?></option>
          <?php } ?>
        </select>
        <?php }else { ?>
        &nbsp;<em>No rollback data available..</em>
        <?php }?>      </td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2" class="contentButtonFooter"><div align="right">
          <input name="back" type="submit" class="inputButton" id="back" value="Cancel"  />
          <?php if($_POST['impexp_type'] == 'exp') { ?>
          <input name="resetExportSelection" type="submit" class="inputButton" id="resetExportSelection" value="Reset Selection" onclick="if(window.confirm('Are you sure you want to reset the selection?')) return true; else return false;"  />
          <input name="exportModule" type="submit" class="inputButton" id="exportModule" value="Export Module &gt;&gt;" <?php if(count($_SESSION['system_impexp_full']) == 0 ){ ?> onclick="window.alert('Please select module(s) to export!'); return false;"<?php } ?> />
          <?php } ?>
          <?php if($_POST['impexp_type'] != 'roll' and $_POST['impexp_type'] != 'exp') { ?>
          <input name="importModule" type="submit" class="inputButton" id="importModule" value="Import Module &gt;&gt;" onClick="if($F('importFile') == '') {window.alert('Please choose your import file! Thank you.'); return false; } else return true;" />
          <?php } ?>
          <?php if($_POST['impexp_type'] == 'roll' && count($rollbackList) > 0) { ?>
          <input name="rollbackModule" type="submit" class="inputButton" id="rollbackModule" value="Rollback Module &gt;&gt;" onclick="if($F('rollbackList') == '') { window.alert('Please choose rollback data.'); return false;} else {if(window.confirm('Are you SURE to ROLLBACK using this data? This action is irreversible!')) return true; else return false; }" />
          <?php } ?>
        </div></td>
    </tr>
  </table>
  <span class="style1">&nbsp;&nbsp;&nbsp;&nbsp;Pending:
  BL, Reference, Webservice<br />
  </span>
  <?php } ?>
  <?php if($_POST['impexp_type'] == 'exp') { ?>
  <?php if($_POST['editPermission']) {?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Senarai Sub-Modul Di Dalam Modul  : <?php echo strtoupper($_POST['hiddenMenuName']); ?>
        <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $_POST['hiddenCode']?>" /></th>
    </tr>
    <tr>
      <td class="listingHead" >Module Name </td>
      <td width="50" class="listingHeadRight" >Status</td>
    </tr>
    <?php for($x=0; $x < $countSecondLevelRsRows; $x++) {
  
		   $thirdLevel = "select * from FLC_MENU 
							where MENUROOT = ".$_POST['hiddenCode']." 
							and MENUPARENT = ".$secondLevelRsRows[$x]['MENUID']."
							and menulevel = 3
							order by MENUSTATUS desc, MENUORDER asc";
			$thirdLevelRsRows = $myQuery->query($thirdLevel,'SELECT','NAME');	
			$countThirdLevelRsRows = count($thirdLevelRsRows);
			
			//set level 2 hover style
			$level2HoverStyle = "style=\"";
			
			if($editGetMaxLevelRsRows[0]['MAXMENULEVEL'] == 3) 
				$level2HoverStyle .= "background-color:#E1F0FF;\" onmouseover=\"this.style.background = '#FFFFCC'; $(this).next().style.background = '#FFFFCC'\" onmouseout=\"this.style.background = '#E1F0FF'; $(this).next().style.background = '#FFFFFF'\"";
			
			if($editGetMaxLevelRsRows[0]['MAXMENULEVEL'] == 2) 
				$level2HoverStyle .= "background-color:#FFFFFF;\" onmouseover=\"this.style.background = '#FFFFCC'; $(this).next().style.background = '#FFFFCC'\" onmouseout=\"this.style.background = '#FFFFFF';$(this).next().style.background = '#FFFFFF'\"";
				
			//for 2nd level checking
			if(count($previousPermissionArr) > 0)
			{	
				if(in_array($secondLevelRsRows[$x]['MENUID'],$previousPermissionArr))
					$level2Checked = " checked";
				else
					$level2Checked = '';
			}//end if
   ?>
    <tr>
      <td class="listingContent" <?php echo $level2HoverStyle;?>><label style="display:block; cursor:pointer">
        <input type="checkbox" name="moduleSelection_<?php echo $secondLevelRsRows[$x]['MENUID']?>" id="moduleSelection_<?php echo $secondLevelRsRows[$x]['MENUID']?>" value="1" <?php echo $level2Checked; ?> onClick="selectChildCheckbox(this,'moduleSelection_')" <?php checkSelectedCheckbox($secondLevelRsRows[$x]['MENUID'],$_SESSION['system_impexp'][$_POST['hiddenCode']]) ?> />
        <?php echo $secondLevelRsRows[$x]['MENUNAME'];?></label></td>
      <td class="listingContentRight" <?php if($secondLevelRsRows[$x]['MENUSTATUS'] == 0) { ?>style="color:#FF0000"<?php } ?> ><?php if($secondLevelRsRows[$x]['MENUSTATUS'] == 0) echo 'Disabled'; else echo 'Enabled';?></td>
    </tr>
    <?php 	for($y=0; $y < $countThirdLevelRsRows; $y++) 
			{
				if(count($previousPermissionArr) > 0)
				{
					//for 3rd level checking	
					if(in_array($thirdLevelRsRows[$y]['MENUID'],$previousPermissionArr)) 
						$level3Checked = " checked";
					else
						$level3Checked = '';
				}//end if
	?>
    <tr>
      <td class="listingContent" onMouseOver="this.style.background = '#FFFFCC'; $(this).next().style.background = '#FFFFCC'; " onMouseOut="this.style.background = '#FFFFFF'; $(this).next().style.background = '#FFFFFF'; "><label style="display:block; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="moduleSelection_<?php echo $secondLevelRsRows[$x]['MENUID']?>_<?php echo $thirdLevelRsRows[$y]['MENUID']?>" id="moduleSelection_<?php echo $secondLevelRsRows[$x]['MENUID']?>_<?php echo $thirdLevelRsRows[$y]['MENUID']?>" onclick="selectMasterCheckbox(this)" value="1" <?php checkSelectedCheckbox($thirdLevelRsRows[$y]['MENUID'],$_SESSION['system_impexp'][$_POST['hiddenCode']]) ?>  />
        <?php echo $thirdLevelRsRows[$y]['MENUNAME'];?></label></td>
      <td class="listingContentRight" <?php  if($thirdLevelRsRows[$y]['MENUSTATUS'] == 0) { ?>style="color:#FF0000"<?php } ?>><?php if($thirdLevelRsRows[$y]['MENUSTATUS'] == 0) echo 'Disabled'; else echo 'Enabled';?></td>
    </tr>
    <?php }//end for y ?>
    <?php }//end for x ?>
    <?php if($countSecondLevelRsRows == 0) { ?>
    <tr>
      <td class="myContentInput">&nbsp;Tiada sub-modul ditemui.. </td>
      <td class="myContentInput">&nbsp;</td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;&nbsp;</td>
            <td><div align="right">
                <input name="selectAll" type="button" class="inputButton" id="selectAll" value="Select All" onClick="prototype_selectAllCheckbox()" />
                <input name="unselectAll" type="button" class="inputButton" id="unselectAll" value="Unselect All" onClick="prototype_unselectAllCheckbox()" />
                |
                <input name="saveScreenRefEdit" type="submit" class="inputButton" id="saveScreenRefEdit" value="Simpan" />
                <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<br>
<?php } else { ?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="7"><label style="cursor:pointer" onclick="if($F('senaraiPermissionMenuToggler') == 0) {up(3).next().hide(); $('senaraiPermissionMenuToggler').value = 1; $(this).innerHTML = '[ + ]'} else {up(3).next().show(); $('senaraiPermissionMenuToggler').value = 0;$(this).innerHTML = '[ - ]'}"></label>
      Senarai Modul - <?php echo '('.$countMenuPermissionRsArr.')'; ?></th>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <?php if($countMenuPermissionRsArr > 0) { ?>
  <tr>
    <td width="15" class="listingHead">#</td>
    <td class="listingHead">Modul</td>
    <td width="50" class="listingHead">Status</td>
    <td width="54" class="listingHead">Selected</td>
    <td width="60" class="listingHeadRight">&nbsp;</td>
  </tr>
  <?php for($x=0; $x < $countMenuPermissionRsArr; $x++) { ?>
  <tr <?php if(countSelected($menuPermissionRsArr[$x]['MENUID']) != '') { ?>style="background-color: #FFFFCC" <?php } ?>>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo ucwords(strtolower($menuPermissionRsArr[$x]['MENUNAME']));?></td>
    <td class="listingContent"  <?php if($menuPermissionRsArr[$x]['MENUSTATUS'] == 0) { ?>style="color:#FF0000" <?php } ?>><?php if($menuPermissionRsArr[$x]['MENUSTATUS'] == 0) echo 'Disabled'; else echo 'Enabled'?></td>
    <td class="listingContent"><?php echo countSelected($menuPermissionRsArr[$x]['MENUID'])?>&nbsp;</td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $x;?>" name="formReference<?php echo $x;?>" method="post" action="" style="padding-bottom:0px; margin-bottom:0px">
        <input name="editPermission" type="submit" class="inputButton" id="editPermission" value="Perincian" />
        <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $menuPermissionRsArr[$x]['MENUID'];?>" />
        <input name="hiddenMenuName" type="hidden" id="hiddenMenuName" value="<?php echo $menuPermissionRsArr[$x]['MENUNAME'];?>" />
        <input name="hidden_impexp_type" type="hidden" id="hidden_impexp_type" value="<?php echo $_POST['impexp_type'];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="5" class="myContentInput">&nbsp;Tiada modul ditemui.. </td>
  </tr>
  <?php 	} //end else ?>
</table>
<?php } ?>
<?php }//end if exp ?>
