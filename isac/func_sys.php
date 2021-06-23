<?php 
//------------------- FOR LAYOUT TEMPLATE --------------------

//function to check whether component is tabular or form
function checkTabularOrForm($myQuery,$componentID)
{
	$qry = "select COMPONENTTYPE from FLC_PAGE_COMPONENT where COMPONENTID = ".$componentID;
	$qryRs = $myQuery->query($qry,'SELECT','NAME');
	
	if($qryRs[0]['COMPONENTTYPE'] == 'form_1_col' || $qryRs[0]['COMPONENTTYPE'] == 'form_2_col')
	{	
		return 'form';
	}
	else if($qryRs[0]['COMPONENTTYPE'] == 'report' || $qryRs[0]['COMPONENTTYPE'] == 'tabular')
	{
		return 'tabular';
	} 
}

//to display left menu
function displayLeftMenu($dbc,$myQuery,$mySQL)
{
	//if file exists, include, else echo error and file name
	if(file_exists(LEFT_MENU_FILENAME)) 
		include (LEFT_MENU_FILENAME); 
	else 
		echo LEFT_MENU_FILENAME." - ".FILE_NOT_EXIST_ERR;
}

//to display right menu
function displayRightMenu($dbc,$myQuery,$mySQL)
{
	//if file exists, include, else echo error and file name
	if(file_exists(RIGHT_MENU_FILENAME)) 
		include (RIGHT_MENU_FILENAME); 
	else 
		echo RIGHT_MENU_FILENAME." - ".FILE_NOT_EXIST_ERR;
}

//to display right menu
function displayContent($dbc,$myQuery,$mySQL,$dal)
{	
	//if home file exists, include home
	if(file_exists(SYSTEM_HOME_PAGE) && !$_GET['page']) 
		include (SYSTEM_HOME_PAGE);
	
	//if GET page is set
	else if(trim($_GET["page"]) != "")
	{
		//check file exists, if exist include
		if(file_exists($_GET["page"].".php"))
			include($_GET["page"].".php");
		
		//else show error and file name to include
		else
			echo $_GET["page"].".php"." - ".FILE_NOT_EXIST_ERR;
	}
	
	else if($_SESSION['userID']&&strstr(SYSTEM_HOME_PAGE,'index.php?') != false)
	{
		redirect(SYSTEM_HOME_PAGE);
	}
	
	//else, show error	
	else 
		echo SYSTEM_HOME_PAGE." - ".FILE_NOT_EXIST_ERR;
}
//------------------------------------------------------------

//check if cookie enabled
function cookieEnabled($cookie)
{
	if(count($_COOKIE) == 0)
		return false;
	else
		return true;
}

//function to convert from db safe format query to display friendly
function convertToDBQry($str)
{	
	$temp = str_replace('[QD]','"',$str);
	$temp = str_replace('[QS]',"'",$temp);
	
	return $temp;
}

//convert db safe query to normal query
function convertDBSafeToQuery($str)
{	
	//clean up sql
	$toReplace = array('[QS]','[QS]','[QS]','[QD]','[QD]','[QD]');
	$theReplacement = array("'","'","'",'"','"','"');

	//cleaned up sql
	$str = str_replace($toReplace,$theReplacement,$str);

	//if string is not null
	if($str != '')
	{
		//check query for {POST
		if(eregi('{POST',$str))
		{
			$offset = strpos($str, '{POST');
			
			do{
				$position_1[] = $offset;
				$position_2[] = strpos($str, '}', $offset + 1);
			}while($offset = strpos($str, '{POST', $offset + 1));
		}//eof if
		
		//check query for {GET
		if(eregi('{GET',$str))
		{
			$offset = strpos($str, '{GET');
			
			do{
				$position_1[] = $offset;
				$position_2[] = strpos($str, '}', $offset + 1);
			}while($offset = strpos($str, '{GET', $offset + 1));
		}//eof if
		
		//check query for {SESSION
		if(eregi('{SESSION',$str))
		{
			$offset = strpos($str, '{SESSION');
			
			do{
				$position_1[] = $offset;
				$position_2[] = strpos($str, '}', $offset + 1);
			}while($offset = strpos($str, '{SESSION', $offset + 1));
		}//eof if
		
		//check query for {SESSION
		if(eregi('{FILE',$str))
		{
			$offset = strpos($str, '{FILE');
			
			do{
				$position_1[] = $offset;
				$position_2[] = strpos($str, '}', $offset + 1);
			}while($offset = strpos($str, '{FILE', $offset + 1));
		}//eof if
		
		/*while($offset = strpos($str, "{POST", $offset + 1))
		{
			$position_1[] = $offset;
			$position_2[] = strpos($str, "}", $offset + 1);
		}//eof while
		
		//check query for {GET
		while($offset = strpos($str, "{GET", $offset + 1))
		{
			$position_1[] = $offset;
			$position_2[] = strpos($str, "}", $offset + 1);
		}//eof while
		
		//check query for {SESSION
		while($offset = strpos($str, "{SESSION", $offset + 1))
		{
			$position_1[] = $offset;
			$position_2[] = strpos($str, "}", $offset + 1);
		}//eof while*/

		//for all number of { and }	
		for($x=0; $x < count($position_1); $x++)
		{
			//get original sub string
			$original[$x] = substr($str,$position_1[$x],$position_2[$x]-$position_1[$x]+1);

			//define things to be replaced
			$str_1 = array('{','}');
			$str_2 = array('','');
			
			//start processing the string
			$replaced = str_replace($str_1,$str_2,$original[$x]);
			
			//split to chunks
			$replacedSplit = explode('|',$replaced);
			
			//if post
			if($replacedSplit[0] == 'POST')
				$newValue[] = $_POST[$replacedSplit[1]];
			
			//else if get
			else if($replacedSplit[0] == 'GET')
				$newValue[] = $_GET[$replacedSplit[1]];
			
			//else if session
			else if($replacedSplit[0] == 'SESSION')
				$newValue[] = $_SESSION[$replacedSplit[1]];
			
			//else if file
			else if($replacedSplit[0] == 'FILE')
				$newValue[] = $replacedSplit[1];
			
			//else if eval TESTINGGG!!!
			else if($replacedSplit[0] == 'EVAL')
				$newValue[] = getEval($replacedSplit[1]);
		}
		
		//replace original string with converted string
		for($x=0; $x < count($original); $x++)
			$str = str_replace($original[$x],$newValue[$x],$str);
			
		return $str;
	}
}

//to convert array into oracle's safe expression
function convertToDBSafe($array)
{
	$array=str_replace('\'','\'\'',$array);
	
	//if array
	if(is_array($array))
	{
		$tempkeys=array_keys($array);
		$tempkeysCount=count($tempkeys);
	}//eof if
	else if (is_string($array))
		$tempkeysCount=1;
	
	//loop on count of array
	for($x=0;$x<$tempkeysCount;$x++)
	{
		//if multi dimentional array
		if(is_array($array[$tempkeys[$x]]))
			$array[$tempkeys[$x]]=convertToDBSafe($array[$tempkeys[$x]]);
		else
			$array[$tempkeys[$x]]=stripslashes($array[$tempkeys[$x]]);
	}//eof if

	return $array;
}//eof function

//function to split POST data
function postDataSplit($data,$elemNamePrefix)
{
	//count no of post item
	$postCount = count($data);
	
	//for all post item - INPUT ONLY, NOT CONTROL
	for($x=0; $x < $postCount; $x++)
	{
		//if first iteration, use current pointer
		if($x == 0)
			$theElem = current($data);
		
		//else, move pointer to next element
		else
			$theElem = next($data);
		
		//explode KEY to pieces
		$theKeyExploded = explode("_",key($data));
		
		//filter to input or controls
		//if INPUT name = input_map_ (INPUT TYPE)
		if($theKeyExploded[0]."_".$theKeyExploded[1]."_" == $elemNamePrefix)
			$theComponent[$theKeyExploded[2]][] = $theKeyExploded[3];		//save to array of component with component items sub array
	}
	
	//return the component
	return $theComponent;		
}

//function to read fixed length text file
function readFixedLength($filename,$size)
{
	$sizeArr = explode(',',$size);
	
	$handle = @fopen($filename, "r");
	if ($handle) 
	{
		while (!feof($handle)) 
		{	
			$totalPrev = 0;
			$a++;
			
			$buffer = fgets($handle, 10000);
			
			for($x=0; $x < count($sizeArr); $x++)
			{	
				if($x == 0)
				{	
					$theArr[$a][$x] = trim(substr($buffer,0,$sizeArr[$x]));
				}
				else
				{	
					$theArr[$a][$x] = trim(substr($buffer,$totalPrev,$sizeArr[$x]));
				}
				
				$totalPrev += $sizeArr[$x];
			}
		}
		fclose($handle);
	}
	
	return $theArr;
}

//function to convert post data to hidden input
//filter: if filter: nofilter, do not filter
function convertPostToHidden($post,$filter,$menuID,$myQuery)
{
	//if session is not set, set session data
		//set session data
	
	//if menu id is different from postStore-menuID
		//clear session
		//clear hidden post data
	
	//else if session is set && menu id = postStore-menuID
		//create hidden input based on post data







	//if session is not set, set session data
	if(!isset($_SESSION['postStore'.$menuID]))
	{
		//for all post data, convert to hidden input
		foreach($post as $key => $value) 
		{	
			//if no filter
			if($filter == 'nofilter')
				$_SESSION['postStore'.$menuID][$key] = $value; 
			
			//if filter is input map
			else if($filter == 'input_map')
			{
				//if filter is found in key, store as concatenated string
				if(eregi($filter,$key)) 
					$_SESSION['postStore'.$menuID][$key] = $value; 			
			}
		}
	}
	
	//if session is set
	if(isset($_SESSION['postStore'.$menuID]))
	{
		//to get the component id for current menu
		$getComponent="select componentid 
							from FLC_PAGE_COMPONENT 
							where pageid=
								(select pageid from FLC_PAGE where menuid='".$menuID."')";
		$getComponentRs = $myQuery->query($getComponent,'SELECT');
		$getComponentRsCount = count($getComponentRs);		//count of component
		
		//for all post data, convert to hidden input
		foreach($post as $key => $value) 
		{	
			//if no filter
			if($filter == 'nofilter')
				$str .= '<input name="'.$key.'" id="'.$key.'" type="hidden" value="'.$value.'" />';
			
			//if filter is input map
			else if($filter == 'input_map')
			{
				//flag to display hidden
				$strFlag = true;
				
				//get componentid of item
				$temp = explode('_',eregi_replace($filter.'_','',$key));
				
				//search items for current menuid
				for($x=0;$x<$getComponentRsCount;$x++)
					if($temp[0] == $getComponentRs[$x][0])
						$strFlag = false;	//if found items for current page, set flag false
				
				//if filter is found in key, store as concatenated string
				if(eregi($filter,$key) && $strFlag) 
					$str .= '<input name="'.$key.'" id="'.$key.'" type="hidden" value="'.$value.'" />';
			}
		}
	}
	
	//return concatenated string
	return $str;
}

//function to check if user can login
function checklogin($myQuery,$mySQL,$mySession,$username='',$password='')
{
	//check if both username and password is entered
	if(cleanData($username != '') && cleanData($password != ''))
	{	
		/*//to clear admin flag, if password is 'clearmystatus'
		if($_POST['userPassword'] == 'cms')
		{	
			//set loginstatuscode to X
			$clear = "update PRUSER set USERLOGINSTATUSCODE = 'X' 
						where USERNAME = '".$username."'";
			$myQuery->query($clear,'RUN');
		}*/
	
		//check username
		$usernameArr = $mySQL->getUserInfo($username,$password);
		
		//if there exists user with username and password given, login
		//count no of element in array
		if($usernameArr)
		{
			$usernameArr[0]['USERLOGINSTATUSCODE']=0;
			
			//check if userloginstatus code not 1 (online)
			//if, update userlogintimestamp to sysdate, update flag to login (1)
			if($usernameArr[0]['USERLOGINSTATUSCODE'] != 1)
			{
				//check expiry
				if(PASSWORD_EXPIRY&&$usernameArr[0]['USERCHANGEPASSWORDTIMESTAMP'])
				{
					$currentDate = date('Y-m-d');
					$expiryDate = $usernameArr[0]['USERCHANGEPASSWORDTIMESTAMP'];
					
					$tempCurrentDate = explode('-',$currentDate);
					$tempExpiryDate = explode('-',$expiryDate);
					
					$currentTimestamp = mktime(0, 0, 0, $tempCurrentDate[1], $tempCurrentDate[2], $tempCurrentDate[0]);
					$expiryTimestamp = mktime(0, 0, 0, $tempExpiryDate[1], $tempExpiryDate[2], $tempExpiryDate[0]);
					
					//number of expiry days
					$chkExpired = floor(($currentTimestamp-$expiryTimestamp)/(60*60*24));

				}//eof if
				
				//if expired
				if($chkExpired>0)
				{
					$error = LOGIN_PASSWORD_EXPIRED;
				}
				else
				{
					//update table PRUSER
					$sql="update PRUSER set USERLOGINSTATUSCODE = '1',
									USERLOGINTIMESTAMP = ".$mySQL->currentDate()."
									where USERNAME = '".$username."'";
					$updateOk = $myQuery->query($sql,'RUN');
					
					//if table PRUSER update successfully
					if($updateOk == true)
					{	
						//store important user data in session 
						$_SESSION['userID'] = $usernameArr[0]['USERID'];
						$_SESSION['userName'] = $usernameArr[0]['USERNAME'];
						$_SESSION['userGroupCode'] = $usernameArr[0]['USERGROUPCODE'];
						$_SESSION['userTypeCode'] = $usernameArr[0]['USERTYPECODE'];
						$_SESSION['departmentCode'] = $usernameArr[0]['DEPARTMENTCODE'];
						$_SESSION['userImage'] = $usernameArr[0]['IMAGEFILE'];
					
						//set login flag to true
						$_SESSION['loginFlag'] = true;
						
						//log in table PRUSER_LOG
						$login_log = "insert into PRUSER_LOG (log_id,user_id,log_type,log_timestamp)
										values (".$mySQL->maxValue('PRUSER_LOG','log_id',0)."+1,'".$_SESSION['userID']."','login',".$mySQL->currentDate().")";
						$login_logRs = $myQuery->query($login_log,'RUN');
						
						//if almost expired
						if(PASSWORD_EXPIRY&&abs($chkExpired)<=PASSWORD_EXPIRY_REMINDER_DAYS)
						{?><script>if(window.confirm('<?php echo LOGIN_PASSWORD_ALMOST_EXPIRED;?>')) {window.location="<?php echo CHANGE_PASSWORD_URL;?>";}</script><?php }
					}//eof if
				}//eof else
			}
			//else if online, reject, show error
			else 
				 $error = LOGIN_ACCOUNT_USED_MSG;
		}
		//show error
		else
			$error = LOGIN_INVALID_MSG;
	}
	
	//if either username or password not entered, load error msg
	else
		$error = LOGIN_ERROR_MSG;
		
	return $error;
}//eof function

//function to check if user has logged out
function checkLogout($myQuery,$mySQL,$mySession,$flag,$cas='')
{
	//if user logout, call function logout
	if($flag == 'true')
	{	
		//update user status code
		if($myQuery->query("update PRUSER set USERLOGINSTATUSCODE = 'X',
									USERLOGINTIMESTAMP = ".$mySQL->currentDate()."
									where USERNAME = '".$_SESSION['userName']."'",'RUN') == true)
		{		
			//log in table PRUSER_LOG
			$logout_log = "insert into PRUSER_LOG (log_id,user_id,log_type,log_timestamp)
								values (".$mySQL->maxValue('PRUSER_LOG','log_id',0)."+1,'".$_SESSION['userID']."','logout',".$mySQL->currentDate().")";
			$logout_logRs = $myQuery->query($logout_log,'RUN');
			
			//log out and clear session
			$mySession->logout();					
			
			//if cas enabled
			if(CAS_ENABLED)
				$cas->casLogout();
			
			$mySession->redirect(LOGOUT_URL);		//redirect to index
		}//eof if
	}//eof if
	
	//if cas enable, check from cas
	//else if(CAS_ENABLED&&$_SESSION)
	//{//echo $cas->casOnlineUser();
		//if(!$cas->casIsAuthenticated()||$_SESSION['userName']!=$cas->casOnlineUser())
			//checkLogout($myQuery,$mySQL,$mySession,true,$cas);
	//}//eof else if
}//eof function

//function to get menuID from referer query string
function getRefererMenuID($str)
{
	//set the needle
	$needle = '&menuID=';						
	
	//find position of &menuID= in the $str
	$thePos = strripos($str,$needle);
	
	//substr the $str
	$tempStr = trim(substr($str,$thePos+1,strlen($str)));
	
	//from the tempStr, find next &
	$nextAmpersand = strpos($tempStr,'&');
	
	//return the menuID in menuID=xxxx format
	return substr($tempStr,0,$nextAmpersand);
}

//set menu to be linked (for back button)
function setLinkedMenu($url)
{
	$menuExist=false;		//set initiall as not exist
	$linkedMenuCount = count($_SESSION['linkedMenu']);	//count linkedMenu
	
	//loop on count of array linkedMenu
	for($x=0; $x<$linkedMenuCount; $x++)
	{
		//check if url in linkedMenu list
		if($url==$_SESSION['linkedMenu'][$x])
			$menuExist=true;
			
		//if menu already exist
		if($menuExist && $x!=0)
		{
			$_SESSION['linkedMenu'][$x-1]=$_SESSION['linkedMenu'][$x];		//move to previous array
			unset($_SESSION['linkedMenu'][$x]);
		}
	}//eof for
	
	//if menu not exist
	if(!$menuExist)
	{
		//loop three times (limited to 3 link)
		for($x=1; $x>=0; $x--)
		{
			//if linkedMenu have value
			if($_SESSION['linkedMenu'][$x])
				$_SESSION['linkedMenu'][$x+1]=$_SESSION['linkedMenu'][$x];		//move to next array
			
			//if $x=0
			if($x==0)
				$_SESSION['linkedMenu'][$x]=$url;		//set as 1st value in arry
		}//eof for
	}//eof if
}//eof function

//get value of linked menu
function getLinkedMenu()
{
	$linkedMenuCount = count($_SESSION['linkedMenu']);	//count linkedMenu
	
	//return 1 url in backward of total in linkedMenu
	return $_SESSION['linkedMenu'][$linkedMenuCount-2];
}//eof function

//function to set data in memory based on menuid
function setElemPostBack($menu='', $post='', $get='', $postInclude='', $getInclude='', $postExclude='', $getExclude='')
{
	//if have post
	if(is_array($post))
	{
		$postCount=count($post);		//count array of post
		$postKeys=array_keys($post);	//keys of array post
	}//eof if
	
	//if have get
	if(is_array($get))
	{
		$getCount=count($get);		//count array of get
		$getKeys=array_keys($get);	//keys of array get
	}//eof if
	
	//if menu have value and post or get have value
	if($menu && ($post||$get))
	{
		//if already have postBack
		if($_SESSION['postBack'])
			unset($_SESSION['postBack']);	//clear postback memory for 1st row array
		
		//set new postback memory
		$_SESSION['postBack']['menuid'] = $menu;
		
		//loop on count of post
		for($x=0,$a=0;$x<$postCount;$x++)
		{
			//if post[x] is string
			if(is_string($post[$postKeys[$x]]))
			{
				//compare item included and excluded (if true set the postback)
				if(compareIncludeExclude($postKeys[$x], $postInclude, $postExclude))
				{
					$_SESSION['postBack']['post'][$a]['name']=$postKeys[$x];
					$_SESSION['postBack']['post'][$a++]['value']=$post[$postKeys[$x]];
				}//eof if
			}//eof if
			//else if post[x] is array
			else if(is_array($post[$postKeys[$x]]))
			{
				//compare item included and excluded (if true set the postback)
				if(compareIncludeExclude($postKeys[$x], $postInclude, $postExclude))
				{
					$postItemCount = count($post[$postKeys[$x]]);		//count item of post
					
					//loop on count of array post item
					for($y=0;$y<$postItemCount;$y++)
					{
						$_SESSION['postBack']['post'][$a]['name'][$y]=$postKeys[$x];
						$_SESSION['postBack']['post'][$a++]['value'][$y]=$post[$postKeys[$x]][$y];
					}//eof for
				}//eof if
			}//eof if
		}//eof for
		
		//loop on count of get
		for($x=0,$a=0;$x<$getCount;$x++)
		{
			//compare item included and excluded (if true set the postback)
			if(compareIncludeExclude($getKeys[$x], $getInclude, $getExclude))
			{
				$_SESSION['postBack']['get'][$a]['name']=$getKeys[$x];
				$_SESSION['postBack']['get'][$a++]['value']=$get[$getKeys[$x]];
			}//eof if
		}//eof for
	}//eof if
}//eof function

//function to get data in memory based on menuid
function getElemPostBack($menu)
{
	//if have array postBack
	if(is_array($_SESSION['postBack']))
	{
		//if same menu
		if($menu==$_SESSION['postBack']['menuid'])
		{
			$postBackPostCount=count($_SESSION['postBack']['post']);	//count array postBack for post
			$postBackGetCount=count($_SESSION['postBack']['get']);	//count array postBack for get
			
			//loop on count of array postBack for post
			for($x=0;$x<$postBackPostCount;$x++)
			{
				//if postBackPost is string
				if(is_string($_SESSION['postBack']['post'][$x]['name']))
					//if same post input not sent
					if(!$_POST[$_SESSION['postBack']['post'][$x]['name']])
						$_POST[$_SESSION['postBack']['post'][$x]['name']] = $_SESSION['postBack']['post'][$x]['value'];		//send post item for postBack
				//else if postBackPost is array
				else if(is_array($_SESSION['postBack']['post'][$x]['name']))
				{
					//if same post input not sent
					if(!$_POST[$_SESSION['postBack']['post'][$x]['name']])
					{
						$postBackPostArrayCount=count($_SESSION['postBack']['post'][$x]['value']);		//count array post for postBack
						
						//loop on count of array post for postBack
						for($y=0;$y<$postBackPostArrayCount;$y++)
						{
							//send post items for postBack
							$_POST[$_SESSION['postBack']['post'][$x]['name']][$y] = $_SESSION['postBack']['post'][$x]['value'][$y];
						}//eof for
					}//eof if
				}//eof else
			}//eof for
			
			//loop on count of array postBack for get
			for($x=0;$x<$postBackGetCount;$x++)
			{
				//if same get item not sent
				if(!$_GET[$_SESSION['postBack']['get'][$x]['name']])
					$_GET[$_SESSION['postBack']['get'][$x]['name']] = $_SESSION['postBack']['get'][$x]['value'];	//send get item for postBack
			}//eof for
		}//eof if
	}//eof if
}//eof function

//to compare if item is included or excluded
function compareIncludeExclude($item, $include, $exclude)
{
	$compareStatus=false;
	
	//if have $include
	if($include)
	{
		//if include is string
		if(is_string($include))
		{
			if(eregi($include,$item))
				$compareStatus=true;
		}//eof if
		else if(is_array($include))
		{
			$includeCount=count($include);
			
			//loop on count of $include
			for($x=0;$x<$includeCount;$x++)
			{
				if(eregi($include[$x],$item))
					$compareStatus=true;
			}//eof for
		}//eof if
	}//eof if
	else
		$compareStatus=true;
	
	//if have $exclude
	if($exclude)
	{
		//if include is string
		if(is_string($exclude))
		{
			if(eregi($exclude,$item))
				$compareStatus=false;
		}//eof if
		else if(is_array($exclude))
		{
			$excludeCount=count($exclude);
			
			//loop on count of $exclude
			for($x=0;$x<$excludeCount;$x++)
			{
				if(eregi($exclude[$x],$item))
					$compareStatus=false;
			}//eof for
		}//eof if
	}//eof if
	
	return $compareStatus;
}//eof function

//function to convert items from array to a batch with delimiter
function convertToDelimiter($myQuery, $elemNamePrefix)
{
	//sort array using keys
	ksort($_POST);
	
	//get list of items ID grouped in component ID
	$theComponent = postDataSplit($_POST,$elemNamePrefix);
	
	//if have component
	if($theComponent)
	{
		//for all components		
		foreach($theComponent as $key => $val) 
		{
			//get component items info
			$getItemInfo = "select * from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = ".$key;
			$getItemInfoRs = $myQuery->query($getItemInfo,'SELECT','NAME');
			
			//if have item
			if($getItemInfoRs)
			{
				//loop on items
				foreach($getItemInfoRs as $keyItem => $valItem)
				{
					//if have delimiter
					if($valItem['ITEMDELIMITER']!='')
					{
						//if multiple selection type
						if(is_array($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]))
						{
							$tempItem='';	//temporary
							$valItemCount=count($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]);	//count the input array
							
							//loop based on count input array
							for($x=0;$x<$valItemCount;$x++)
							{
								$tempItem.=$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']][$x];		//append temporary and set from input
								
								//before end of array
								if($x<$valItemCount-1)
									$tempItem.=$valItem['ITEMDELIMITER'];	//concat with delimiter
							}//eof for
						
							//re-set the post value by temporary item value
							$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']] = $tempItem;
						}//eof if
					}//eof if
				}//eof foreach
			}//eof if
		}//eof foreach
	}//eof if
}//eof function

//get bl parameter
function getBLParameter($myQuery,$blName)
{
	//get bl info
	$getBL="select blname,blparameter,upper(blparametertype) blparametertype
				from FLC_BL 
				where blstatus='00' and blname='".$blName."'";
	$getBLRs=$myQuery->query($getBL,'SELECT','NAME');
	
	//if have parameter
	if($getBLRs[0]['BLPARAMETER'])
	{
		$getBLParameter['NAME']=explode('|',$getBLRs[0]['BLPARAMETER']);			//parameter name
		$getBLParameter['IN_OUT']=explode('|',$getBLRs[0]['BLPARAMETERTYPE']);		//in out
	}//eof if
	
	return $getBLParameter;
}//eof function

//get bl in parameter
function getBLInParameter($myQuery,$blName)
{
	//get parameter
	$getBLParameter = getBLParameter($myQuery,$blName);
	$getBLParameterCount = count($getBLParameter['NAME']);
	
	//loop on count of bl parameter
	for($x=0;$x<$getBLParameterCount;$x++)
	{
		//bl in parameter
		if($getBLParameter['IN_OUT'][$x]=='IN'||$getBLParameter['IN_OUT'][$x]=='IN_OUT')
		{
			$inParameter[]=$getBLParameter['NAME'][$x];
		}//eof if
	}//eof for

	return $inParameter;
}//eof function

//get bl out parameter
function getBLOutParameter($myQuery,$blName)
{
	//get parameter
	$getBLParameter = getBLParameter($myQuery,$blName);
	$getBLParameterCount = count($getBLParameter['NAME']);
	
	//loop on count of bl parameter
	for($x=0;$x<$getBLParameterCount;$x++)
	{
		//bl in parameter
		if($getBLParameter['IN_OUT'][$x]=='OUT'||$getBLParameter['IN_OUT'][$x]=='IN_OUT')
		{
			$outParameter[]=$getBLParameter['NAME'][$x];
		}//eof if
	}//eof for

	return $outParameter;
}//eof function

//create bl
function createBL($myQuery, $blName, $componentID='')
{
	//get bl info
	$getBL="select blname,bldetail 
				from FLC_BL 
				where blstatus='00' and blname='".$blName."'";
	$getBLRs=$myQuery->query($getBL,'SELECT','NAME');
	
	//bl name
	$getBLName=$getBLRs[0]['BLNAME'];

	//if have component id
	if($componentID)
	{
		//get component items info
		$getItemInfo = "select itemid,mappingid from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = '".$componentID."'";
		$getItemInfoRs = $myQuery->query($getItemInfo,'SELECT','NAME');
		$countGetItemInfo = count($getItemInfoRs);
		
		//out parameter
		$outParameter = getBLOutParameter($myQuery,$blName);
		$outParameterCount = count($outParameter);
		
		//loop on count of out parameter
		for($x=0;$x<$outParameterCount;$x++)
		{
			//loop on count of item
			for($y=0;$y<$countGetItemInfo;$y++)
			{
				//if mapped
				if($outParameter[$x]==$getItemInfoRs[$y]['MAPPINGID'])
				{
					if($outParameter[$x])
						$outParameterString.='$_SESSION[\'BL\'][\'input_map_'.$componentID.'_'.$getItemInfoRs[$y]['ITEMID'].'\']=$'.$outParameter[$x].';';	//here
				}//eof if
			}//eof for
		}//eof for
	}//eof if
	
	//in parameter
	$inParameter = getBLInParameter($myQuery,$getBLName);
	
	//if have in parameter
	if(is_array($inParameter))
		$inParameterString = '$'.implode(',$',$inParameter);

	//create bl function
	return create_function($inParameterString,convertDBSafeToQuery($getBLRs[0]['BLDETAIL'])."\r".$outParameterString);
}//eof function

//execute bl
function executeBL($blName, $componentID='')
{	
	//db connection
	include('db.php');
	
	$getBLName = $blName;
	$$getBLName = createBL($myQuery, $blName, $componentID);						//create bl

	//if have component id
	if($componentID)
	{
		//get component items info
		$getItemInfo = "select itemid,mappingid from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = '".$componentID."'";
		$getItemInfoRs = $myQuery->query($getItemInfo,'SELECT','NAME');
		$countGetItemInfo = count($getItemInfoRs);
		
		//in parameter
		$inParameter = getBLInParameter($myQuery,$blName);
		$inParameterCount = count($inParameter);
		
		//loop on count of in parameter
		for($x=0;$x<$inParameterCount;$x++)
		{
			//default flag, in case dont have input
			$inParameterFlag[$x] = false;
				
			//loop on count of item
			for($y=0;$y<$countGetItemInfo;$y++)
			{
				//if mapped
				if($inParameter[$x]==$getItemInfoRs[$y]['MAPPINGID'])
				{
					$inParameter[$x]=$_POST['input_map_'.$componentID.'_'.$getItemInfoRs[$y]['ITEMID']];
					$inParameterFlag[$x] = true;	//flag have input
				}//eof if
			}//eof for
			
			//if flag false (no input)
			if(!$inParameterFlag[$x])
				$inParameter[$x] = '';		//empty input
		}//eof for
	}//eof if
	
	//if have in parameter
	if(is_array($inParameter))
		$inParameterString = "'".implode("','",$inParameter)."'";

	//run bl and assign return value (if have return value)
	eval('$tempBLReturn=$$getBLName('.$inParameterString.');');
	
	//if have bl session
	if($_SESSION['BL'])
	{
		$countSessionBL=count($_SESSION['BL']);		//count bl session for out
		$keySessionBL=array_keys($_SESSION['BL']);
		
		//loop on count of bl out paramter
		for($x=0;$x<$countSessionBL;$x++)
		{
			$_POST[$keySessionBL[$x]]=$_SESSION['BL'][$keySessionBL[$x]];
		}//eof for
		
		//unset session bl
		unset($_SESSION['BL']);
	}//eof if
	
	return $tempBLReturn;
}//eof function

//temp
function xml_version_update()
{
}
?>