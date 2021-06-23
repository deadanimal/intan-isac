<?php 
//function to convert english day to malay
function dayToMalay($str)
{
	//uppercase month name
	$str = strtoupper($str);
	
	switch($str)
	{
		case 'MONDAY':
			return 'Isnin';
			break;
		
		case 'TUESDAY':
			return 'Selasa';
			break;
		
		case 'WEDNESDAY':
			return 'Rabu';
			break;
		
		case 'THURSDAY':
			return 'Khamis';
			break;
		
		case 'FRIDAY':
			return 'Jumaat';
			break;
		
		case 'SATURDAY':
			return 'Sabtu';
			break;
		
		case 'SUNDAY':
			return 'Ahad';
			break;
	}//end switch
}

//function to convert english month to malay
//parameter: month name, type:short/long
function monthToMalay($str,$type)
{
	//uppercase month name
	$str = strtoupper($str);
	
	//if month name is short
	if($type == 'short')
	{
		switch($str)
		{
			case 'JAN':
				return 'Jan';
				break;
			
			case 'FEB':
				return 'Feb';
				break;
			
			case 'MAR':
				return 'Mac';
				break;
			
			case 'APR':
				return 'Apr';
				break;
			
			case 'MAY':
				return 'Mei';
				break;
			
			case 'JUN':
				return 'Jun';
				break;
			
			case 'JUL':
				return 'Jul';
				break;
			
			case 'AUG':
				return 'Ogo';
				break;
			
			case 'SEP':
				return 'Sep';
				break;
			
			case 'OCT':
				return 'Okt';
				break;
			
			case 'NOV':
				return 'Nov';
				break;
			
			case 'DEC':
				return 'Dis';
				break;
		}//end switch
	}//end month name is short
	
	//if month name is long
	else if($type == 'long')
	{
		switch($str)
		{
			case 'JANUARY':
				return 'Januari';
				break;
			
			case 'FEBRUARY':
				return 'Februari';
				break;
			
			case 'MARCH':
				return 'Mac';
				break;
			
			case 'APRIL':
				return 'April';
				break;
			
			case 'MAY':
				return 'Mei';
				break;
			
			case 'JUNE':
				return 'Jun';
				break;
			
			case 'JULY':
				return 'Julai';
				break;
			
			case 'AUGUST':
				return 'Ogos';
				break;
			
			case 'SEPTEMBER':
				return 'September';
				break;
			
			case 'OCTOBER':
				return 'Oktober';
				break;
			
			case 'NOVEMBER':
				return 'November';
				break;
			
			case 'DECEMBER':
				return 'Disember';
				break;
		}//end switch
	}//end month name is long
}
	

//function to trim, strip html tags, php tags
function cleanData($str)
{	
	//characters to remove
	$charToRemove = array("'",'/','"');
	$charToReplace = array('','','');

	//to replace
	$str = str_replace($charToRemove,$charToReplace,$str);

	//remove whitespace, php and html tags
	return trim(strip_tags($str));
}

//to refresh page
function refresh() 
{	
	die('<meta http-equiv="refresh" content="0">'); 
}

//to refresh page
function metaRedirect($time,$url) 
{	//content="5;URL=http://www.indiana.edu/~smithclas/l200/
	die('<meta http-equiv="refresh" content="'.$time.';'.$url.'">'); 
}

//to redirect page
function redirect($url)
{	
    $path = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".$url;
    echo "<script>window.location=\"$path\"</script>";
}

//to logout user from system
function logout($redirectTo)
{
	$_SESSION = array();		//clear session array				
		
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();			//destroy session
	
	redirect($redirectTo);
}

//to add any number by 1 and repad according to original
function addAndRepad($num)
{
	$newNum = sprintf("%0d",$num) + 1;						//unpad number, add by 1
	$length = strlen($num);									//get length
	$newNum = sprintf("%0".$length."d",$newNum);			//repad number using length

	return $newNum;
}

//to upload file (move from temp dir to permanent storage folder)
function upload_file($uploaddir,$uploadfilename)
{	
	//to list uploaded file
	if(is_string($uploadfilename['name']))
	{
		$uploadfile = $uploaddir.$uploadfilename['name'];						//filename to be store
		move_uploaded_file($uploadfilename['tmp_name'], $uploadfile);			//move temp file from temp folder to upload folder
	}//eof if
	else if(is_array($uploadfilename['name']))
	{
		//count file upload
		$fileCount = count($uploadfilename['name']);
		
		//loop on file upload count
		for($x=0;$x<$fileCount;$x++)
		{
			$uploadfile[] = $uploaddir.$uploadfilename['name'][$x];						//filename to be store
			move_uploaded_file($uploadfilename['tmp_name'][$x], $uploadfile[$x]);		//move temp file from temp folder to upload folder
		}//eof for
	}//eof else
	
	//return upload path
	return $uploadfile;
}

//notification - send items of email into flc_notification_items
function notification($notificationName)
{
	include('db.php');						//include stuff needed for session, database connection, and stuff
	
	//select statement of default notification
	$notification = "select * from FLC_NOTIFICATION where notification_name='".$notificationName."'";
	$notificationRs = $myQuery->query($notification,'SELECT','NAME');
	
	$tempArray = func_get_args();
	
	if(is_array($tempArray))
	{
		$tempArrayCount=count($tempArray);		//count array
		$fieldCount=0;					//count field
		
		for($x=1;$x<$tempArrayCount;$x++)
		{
			if($tempArray[$x][0]=='?')
			{
				$tempPreProcessSql=explode('?',$tempArray[$x],2);
				$preProcessSql=$tempPreProcessSql[1];
			}//eof if
			else
				$field[$fieldCount++]=$tempArray[$x];
		}//eof for
	}//eof if
	
	//email flag, if false not insert
	$emailFlag=true;
	
	//loop on count field
	for($x=0;$x<$fieldCount;$x++)
	{
		$temp=explode('=',$field[$x],2);
		$tempField[$x]=$temp[0];	//field
		$tempValue[$x]=$temp[1];	//value
		
		//used to check for dbsafe
		$tempStartValue = substr($tempValue[$x],0,1);
		$tempEndValue = substr($tempValue[$x],strlen($tempValue[$x])-1,strlen($tempValue[$x]));
		$tempMiddleValue = substr($tempValue[$x],1,strlen($tempValue[$x])-2);
		
		//convert db safe
		if($tempStartValue=="'"&&$tempEndValue=="'"&&$tempMiddleValue)
			$tempValue[$x]="'".convertToDBSafe($tempMiddleValue)."'";
		
		//checking data
		if($tempField[$x]=='EMAIL_FROM'&&!$tempValue[$x])
			$tempValue[$x]='webmaster@kln.gov.my';
		if($tempField[$x]=='EMAIL_TO'&&$tempValue[$x]=="''")
			$emailFlag=false;
		if($tempField[$x]=='EMAIL_SUBJECT'&&$tempValue[$x]=="''")
			$emailFlag=false;
		if($tempField[$x]=='EMAIL_MESSAGE'&&$tempValue[$x]=="''")
			$emailFlag=false;
	}//eof for
	
	//if field and value
	if(is_array($tempField)&&is_array($tempValue)&&$emailFlag)
	{
		$insert = "insert into FLC_NOTIFICATION_ITEM
					(NOTIFICATION_ITEM_ID,NOTIFICATION_ID,REQUEST_USER_ID,TIME_STAMP,NOTIFICATION_ITEM_STATUS,PRE_PROCESS_SQL,".implode(',',$tempField).")
					values
					('".($mySQL->maxValue('FLC_NOTIFICATION_ITEM','NOTIFICATION_ITEM_ID')+1)."','".$notificationRs[0]['NOTIFICATION_ID']."','".$_SESSION['userID']."',".$mySQL->currentDate().",'Open'
						,'".convertToDBSafe($preProcessSql)."',".implode(",",$tempValue).")";
		$myQuery->query($insert,'RUN');
	}//eof if
}//eof function

//set loading content by loading type
function setLoadingContent($type,$input)
{
	//process data base on type
	switch($type)
	{
		case 'csv':
			$rows = explode("\r",$input);
			$rowsCount = count($rows);
			
			//loop on count of rows
			for($x=0;$x<$rowsCount;$x++)
			{
				//if row have value
				if(trim($rows[$x])!='')
				{
					$columns = explode(',',$rows[$x]);
					$columnsCount = count($columns);
					
					//loop on count of columns
					for($y=0;$y<$columnsCount;$y++)
					{
						$_SESSION['LoadingContent'][$x][$y] = str_replace("\n",'',$columns[$y]);
					}//eof for
				}//eof if
			}//eof for
		break;
	}//eof switch
}//eof function

//set loading content by loading type
function getLoadingContent($type,$input)
{
	//process data base on type
	switch($type)
	{
		case 'csv':
			//convert loading input
			$input = str_replace("dbCells = [\r",'',$input);
			$input = str_replace("\n];",'',$input);
			
			//separate by column and row
			$tempInput = explode('],',$input);
			$tempInput = str_replace(']','',$tempInput);
			$tempInput = str_replace('[','',$tempInput);
			$tempInput = str_replace("\r",'',$tempInput);
			$tempInput = str_replace("\n",'',$tempInput);
			$tempInput = str_replace(" ",'',$tempInput);
			$tempInputCount =count($tempInput);
			
			//loop on count of temp input count
			for($x=0;$x<$tempInputCount;$x++)
			{
				//separate input info
				$inputChunks = explode(',',$tempInput[$x]);
				$loading_content[$inputChunks[1]][$inputChunks[0]]=$inputChunks[2];
			}//eof for
		break;
	}//eof switch

	return $loading_content;
}//eof function

//to convert result set in vertical (DB) to horizontal set (array)
//assuming the first column in vertical dataset to be converted to column name in horizontal dataset
//required: no of rows, result set
function rowsToColumn($numRows,$rs)
{	
	//clears and assign array
	$dumpArr = array();
	
	//by assuming the first column of result set to be the column name of to be returned new result set
	for($x=0; $x < $numRows; $x++)
	{	
		$rsRows = mysql_fetch_array($rs);			//fetch result
		$dumpArr[$rsRows[0]] = $rsRows[1];			//create new result set
	}
	
	//return converted result
	return $dumpArr;
}

//to convert result set in vertical (ARRAY) to horizontal set (array)
//assuming the first column in vertical dataset to be converted to column name in horizontal dataset
//required: no of rows, result set
function rowsToColumnV2($arr)
{
	//clears and assign array
	$dumpArr = array();
	
	//count array length
	$arrLength = count($arr);
	
	//by assuming the first column of result set to be the column name of to be returned new result set
	for($x=0; $x < $arrLength; $x++)
	{	
		//store in session array, key from col 0, value from col 1
		$dumpArr[$arr[$x][0]] = $arr[$x][1];	
	}
	return $dumpArr;
}

//function to toggle menu
function toggleMenu($menu,$state)
{	
	if($state == 0)
		$_SESSION["toggleState"][$menu] = 1;
	else if($state == 1)
		$_SESSION["toggleState"][$menu] = 0;
}

//parts to show matrix
//page permission matrix
//define page controls (button) here
//$protocol = "POST";	//GET / POST
//$controls = array("saveScreenNew","saveScreenEdit","deleteCategory");
//$parts = array("showScreen_1","showScreen_2","showScreen_3","showScreen_4","showScreen_5","showScreen_6","showScreen_7","showScreen_8","showScreen_9");
//$mapping = "";

//to evaluate source code stored in string
function getEval($var)
{
	if($var)
	{
		ob_start();
		eval("echo $var;");
		
		//eval("\$var = \$a; echo 'T'.$var;");
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}

}

//create gzip file
function createGzip($filename,$content)
{
	// open file for writing with maximum compression
	$handle = gzopen($filename, "w9");
	
	//if file handle ok
	if($handle)
		gzwrite($zp,$content);			// write string to file
	
	//close file
	gzclose($zp);
}

//create zip file
//dir			-> dir listing	
//content 		-> if array(assumes array of files to be compressed)
//content		-> if not, just some string to be compressed
function createZip($filename,$dir,$content)
{	
	//create new zip class
	$newZip = new zipfile;
	
	//if directory
	if(is_array($dir))
	{
		//count content array length
		$countDir = count($dir);
		
		//read through array
		for($x=0; $x < $countDir; $x++)
			$newZip->addFile($dir[$x],$dir[$x]);				//file to zip contents, file to write in zip
	}
	
	//if files
	if(is_array($content))
	{	
		//count content array length
		$count = count($content);
		
		//read through array
		for($x=0; $x < $count; $x++)
			$newZip->addFile(file_get_contents($content[$x]),$content[$x]);				//file to zip contents, file to write in zip
	}

	else
		$newZip->addFile(file_get_contents($content),$content);					//file to zip contents, file to write in zip
	
	//open file handler
	$handle = fopen($filename,"x");

    //write to file
	if(fwrite($handle,$newZip->file()) === FALSE) 
		echo "Cannot write to file ".$filename;

	//close file handle
	fclose($handle);
}

//FUNCTION: TO RETRIEVE DIRECTORY LISTING
//Author: Nicolas Merlet - admin(at)merletn.org
//Taken from: www.php.net/dir
// $path : path to browse
// $maxdepth : how deep to browse (-1=unlimited)
// $mode : "FULL"|"DIRS"|"FILES"
// $d : must not be defined
function searchdir ( $path , $maxdepth = -1 , $mode = "FULL" , $d = 0 )
{
   if ( substr ( $path , strlen ( $path ) - 1 ) != '/' ) { $path .= '/' ; }     
   $dirlist = array () ;
   if ( $mode != "FILES" ) { $dirlist[] = $path ; }
   if ( $handle = opendir ( $path ) )
   {
       while ( false !== ( $file = readdir ( $handle ) ) )
       {
           if ( $file != '.' && $file != '..' )
           {
               $file = $path . $file ;
               if ( ! is_dir ( $file ) ) { if ( $mode != "DIRS" ) { $dirlist[] = $file ; } }
               elseif ( $d >=0 && ($d < $maxdepth || $maxdepth < 0) )
               {
                   $result = searchdir ( $file . '/' , $maxdepth , $mode , $d + 1 ) ;
                   $dirlist = array_merge ( $dirlist , $result ) ;
               }
       }
       }
       closedir ( $handle ) ;
   }
   if ( $d == 0 ) { natcasesort ( $dirlist ) ; }
   return ( $dirlist ) ;
}

//calculate page generation time
function utime ()
{
	$time = explode( " ", microtime());
	$usec = (double)$time[0];
	$sec = (double)$time[1];
	return $sec + $usec;
}

function pageGenerationTime($start,$secsName)
{
	$end = utime(); 
	$run = $end - $start; 
	return substr($run,0,5).$secsName;
}

function my_trimmer($beard,$type)
{	
	//array of replacement chars
	$db_char = array("[R]","[P]","[BR]");
	$txt_char = array("\r","\n\n","\n");
	$txt_char2 = array(" ","<br><br>","<br>");
	
	if($type == 1) 
		$beard = str_replace($txt_char, $db_char, $beard);			//convert textarea text to safe version for DB
	
	else if($type == 2)
		$beard = str_replace($db_char, $txt_char, $beard);			//DB text -> string (PHP SAFE)

	else if($type == 3)
		$beard = str_replace($db_char, $txt_char2, $beard);			//DB text -> string (ORIGINAL)
	
	else if($type == 4)
		$beard = str_replace($db_char, " ", $beard);				//DB text -> string (HTML SAFE)

	return $beard;
}

function getAjaxDropdown($arg,$target,$itemID)
{	
	//db connection
	include("dbconn.php");
	
	//setup ajax response
	$objResponse = new xajaxResponse();

	//get itemLookupSecondary sql
	$getSecondarySQL = "select itemLookupSecondary from page_component_items where itemID = ".$itemID;
	$getSecondarySQLRs = mysql_query($getSecondarySQL,$dbc) or die(mysql_error());
	$getSecondarySQLRsRows = mysql_fetch_array($getSecondarySQLRs);
	
	//get data from db
	$getData = $getSecondarySQLRsRows["itemLookupSecondary"]." '".$arg."'";
	//echo $getData;
	$getDataRs = mysql_query($getData,$dbc) or die(mysql_error());
	$getDataNumRows = mysql_num_rows($getDataRs);

	//----------------build dropdown--------------
	//if daerah hutan > 0
	if($getDataNumRows > 0)
	{
		//reset dropdown
		$objResponse->addScript("document.getElementById('".$target."').length=1;");
		
		for($x=0; $x < $getDataNumRows; $x++) 
		{ 
			$getDataRsRows = mysql_fetch_array($getDataRs);
			
			//append new item to dropdown
			$objResponse->addScript("addOption('".$target."','".$getDataRsRows["id"]."','".$getDataRsRows["name"]."');");	
		}
	}
	else
	{	
		//reset dropdown
		$objResponse->addScript("document.getElementById('".$target."').length=1;");
		
		//append new item to dropdown
		$objResponse->addScript("addOption('".$target."','".""."','"."-tiada-"."');");	
    }
	//--------------------------------------------

	return $objResponse;
}

function getAjaxDropdown2($arg,$target,$itemID)
{	
	//db connection
	//include("dbconn.php");
	
	//setup ajax response
	$objResponse = new xajaxResponse();
	//$objResponse2->addScript("addOption('input_map_70','dddddd','zzzzzzzz');");	
	$objResponse->addScript("alert('dddd');");	
	
/*	//get itemLookupSecondary sql
	$getSecondarySQL = "select itemLookupSecondary from page_component_items where itemID = ".$itemID;
	$getSecondarySQLRs = mysql_query($getSecondarySQL,$dbc) or die(mysql_error());
	$getSecondarySQLRsRows = mysql_fetch_array($getSecondarySQLRs);
	
	//get data from db
	$getData = $getSecondarySQLRsRows["itemLookupSecondary"]." '".$arg."'";
	//echo $getData;
	$getDataRs = mysql_query($getData,$dbc) or die(mysql_error());
	$getDataNumRows = mysql_num_rows($getDataRs);
	
	//----------------build dropdown--------------
	//if daerah hutan > 0
	if($getDataNumRows > 0)
	{
		//reset dropdown
		$objResponse2->addScript("document.getElementById('".$target."').length=1");
		$objResponse2->addScript("addOption('".$target."','dddddd','zzzzzzzz');");	
		for($x=0; $x < $getDataNumRows; $x++) 
		{ 	
			$getDataRsRows = mysql_fetch_array($getDataRs);
			
			//append new item to dropdown
			$objResponse2->addScript("addOption('".$target."','".$getDataRsRows["id"]."','".$getDataRsRows["name"]."');");	
		}
	}
	else
	{	jap
		//reset dropdown
		$objResponse2->addScript("document.getElementById('".$target."').length=1");
		
		//append new item to dropdown
		$objResponse2->addScript("addOption('".$target."','".""."','"."-tiada-"."');");	
    }
	//--------------------------------------------*/
	
	return $objResponse;
}

//function to convert oracle date to Y-m-d
function oracleDateToYMD($date)
{
	//check if date is not null
	if($date != '')
	{
		//explode the date string
		$dateStr = explode('-',$date);
		
		//if date can be divided into 3, if DD between 0 and 31, and length of string in MMM is 3, length of string in YY is 2
		if(count($dateStr) == 3 && ((int) $dateStr[0] > 0 || (int) $dateStr[0] < 31) && strlen($dateStr[1]) == 3 && strlen($dateStr[2]) == 2)
		{
			//month name selector
			switch ($dateStr[1]) 
			{
				case 'JAN':
					$dateStr[1] = '01';
					break;
				case 'FEB':
					$dateStr[1] = '02';
					break;
				case 'MAR':
					$dateStr[1] = '03';
					break;
				case 'APR':
					$dateStr[1] = '04';
					break;
				case 'MAY':
					$dateStr[1] = '05';
					break;
				case 'JUN':
					$dateStr[1] = '06';
					break;
				case 'JUL':
					$dateStr[1] = '07';
					break;
				case 'AUG':
					$dateStr[1] = '08';
					break;
				case 'SEP':
					$dateStr[1] = '09';
					break;
				case 'OCT':
					$dateStr[1] = '10';
					break;
				case 'NOV':
					$dateStr[1] = '11';
					break;
				case 'DEC':
					$dateStr[1] = '12';
					break;
			}//end switch
			
			//check the year
			//if first digit is 9
			if($dateStr[2][0] == '9')
				$dateStr[2] = '19'.$dateStr[2];
			else 
				$dateStr[2] = '20'.$dateStr[2];
				
			//return formatted date
			return $dateStr[2].'-'.$dateStr[1].'-'.$dateStr[0];
		}//end if panjang
	}//end if
}

//function to re index array according to keys
function reIndexArray($arr)
{
	foreach ($arr as $key => $val)
	{
		$x++;
		$newArr[$x-1] = $val;
	} 
	return $newArr;
}

//function to show notification section
function showNotification($eventType,$message,$lang='default')
{	
	$eventType = trim($eventType);
	
	//if event type is null, there must be an error 
	if(strtoupper($eventType) == 'ERROR')			//fais20080708
		$eventType = 'error';
	
	//if message is null, use default message in conf.php
	if(trim($message) == '')
	{	
		if($lang == 'default')
		{
			//if insert
			if(strtoupper($eventType) == 'INSERT') 
				$message = DB_INSERT_SUCCESS;
			
			//if update
			else if(strtoupper($eventType) == 'UPDATE')
				$message = DB_UPDATE_SUCCESS;
			
			//if delete
			else if(strtoupper($eventType) == 'DELETE')
				$message = DB_DELETE_SUCCESS;
		}
		else if($lang == 'english')
		{
			//if insert
			if(strtoupper($eventType) == 'INSERT') 
				$message = DB_INSERT_SUCCESS_ENGLISH;
			
			//if update
			else if(strtoupper($eventType) == 'UPDATE')
				$message = DB_UPDATE_SUCCESS_ENGLISH;
			
			//if delete
			else if(strtoupper($eventType) == 'DELETE')
				$message = DB_DELETE_SUCCESS_ENGLISH;
		}
	}
	
	//include the notification view
	include('views/notification.php');
}

//original source :http://drupal.org/node/65903
//modified: 20080626

/*
Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FDM; .NET CLR 2.0.50727; .NET CLR 1.1.4322)
Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9) Gecko/2008052906 Firefox/3.0
Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14
*/

function checkBrowser()
{
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Gecko') )
	{
	   if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape') )
	   {
		 $browser = 'Netscape (Gecko/Netscape)';
	   }
	   
	   else if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/2.0') )
	   {
		 $browser = 'Mozilla Firefox 2.0 (Gecko/Firefox)';
	   }
	   
	   else if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/3.0') )
	   {
		 $browser = 'Mozilla Firefox 3.0 (Gecko/Firefox)';
	   }
	   else
	   {
		 $browser = 'Mozilla (Gecko/Mozilla)';
	   }
	}
	else if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') )
	{
	   if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') )
	   {
		 $browser = 'Opera (MSIE/Opera/Compatible)';
	   }
	   else
	   {
		 $browser = 'Internet Explorer (MSIE/Compatible)';
	   }
	}
	else
	{
	   $browser = 'Others browsers';
	}
	
	return $browser;
}

//--------------------------------------------------------------------------------------------
/**
TO CREATE/RETURN OPTION TAG FOR DROP DOWN BUTTON
-$arrayList: array of values to be inserted into dropdown
-$post: post value (default is null)
*/
function createDropDown($arrayList, $selectedValue='')
{
	$option='<option value=""></option>';		//string for display of option tag (appendable)
	$arrayListSize=count($arrayList);		//size of $arrayList
	
	//option tag: appendable based on rows in array
	for($x=0;$x<$arrayListSize;$x++){
		$option.='<option value="' . $arrayList[$x][0]. '"';
		
		if($selectedValue==$arrayList[$x][0])
			$option.=' selected="selected"';
		
		$option.='>' . $arrayList[$x][1] . '</option>';
	}//eof for
	return $option;		//return the option tag
}//eof function

/**
TO CHECK IF VARIABLE(S) NULL OR NOT
-var args: can have as many variable passed
*/
function havValue()
{
	$result=false;	//initial value is false
	
    $varTotal = func_num_args();	//get number of variable passed
    $valList = func_get_args();		//get list of variable passed
	
    for ($x = 0; $x < $varTotal; $x++)
        if($valList[$x])
			$result=true;	//if 1 variable have value return true
	
	return $result;
}//eof function

/**
TO CONVERT A NUMBER TO CURRENCY
-NUMBER: number to be converted
*/
function to_currency($number)
{
	return number_format($number, 2, '.', ',');
}//eof function

/**
TO CONVERT A NUMBER TO ACCOUNT STYLE
-NUMBER: number to be converted
*/
function to_account($str)
{
	if(ereg('-',$str))
	{
		$str='('.ereg_replace('-','',$str).')';
	}//eof if
	
	return $str;
}//eof function

//--------------------------------------------------------------------------------------------
?>