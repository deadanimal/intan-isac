<?php 
//-------------------
//KLN SPECIFIC BLOCK
//-------------------
//get menu root

$getMenuRoot = $myQuery->query('select MENUROOT from FLC_MENU where MENUID = '.$_GET['menuID'],'SELECT','NAME');
$menuRoot = $getMenuRoot[0]['MENUROOT'];

//get menu root name
$getMenuRootName = $myQuery->query('select MENUNAME from FLC_MENU where MENUID = '.$menuRoot,'SELECT','NAME');

if($getMenuRootName)
{
	$menuRootName = $getMenuRootName[0]['MENUNAME'];
	
	$englishFlag = false;
	
	//if parent menu is candidature
	if(ereg($menuRootName,'CIS'))
	{
		$englishFlag = true;
	}
}
//-----------------------
//END KLN SPECIFIC BLOCK
//-----------------------	


/*=========  PAGE POST SCRIPT (CONTROLBUTTON) ==============*/
	$elemNamePrefix = "input_map_";
	convertToDelimiter($myQuery, $elemNamePrefix);		//convert if have delimeter
	
	/*//if page control SEARCH is clicked, do nothing, for the time being lar..
	if(isset($_POST['control_7'])) 
	{
		convertToDelimiter($myQuery, $elemNamePrefix);
	}//eof if*/
	
	/*//if page control REDIRECT is clicked
	if(isset($_POST['control_6'])||isset($_POST['control_24']))
	{
		convertToDelimiter($myQuery, $elemNamePrefix);
	}*/
	
	//if page control SAVE (ctrl 1) or SAVE and REDIRECT (ctrl 15) is clicked
	if(isset($_POST['control_1']) || isset($_POST['control_15']))
	{	
		//convertToDelimiter($myQuery, $elemNamePrefix);
		
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
				//get component info
				$getComponentInfo = "select * from FLC_PAGE_COMPONENT where COMPONENTID = ".$key;
				$getComponentInfoRs = $myQuery->query($getComponentInfo,'SELECT','NAME');
	
				//get component items info
				$getItemInfo = "select * from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = ".$key." order by itemprimarycolumn,itemorder";
				$getItemInfoRs = $myQuery->query($getItemInfo,'SELECT','NAME');
				
				//get column name and component item id
				foreach($getItemInfoRs as $keyItem => $valItem)
				{
					//counter
					$k++;

					//scan for primary key item
					if($valItem['ITEMPRIMARYCOLUMN'] == 1)
						$primaryColumn = $valItem['MAPPINGID'];
				
					//if x is not set, set to zero
					if(!isset($x))
						$x = 0;
					
					//else increment by 1
					else
						$x = $x + 1;
				
					//------------------------- IF COMPONENT POST PROCESS TYPE = INSERT / UPDATE ---------
					if($getComponentInfoRs[0]['COMPONENTPOSTPROCESS'] == 'insert' || $getComponentInfoRs[0]['COMPONENTPOSTPROCESS'] == 'update')
					{	
						//if mapping id is null, do nothing
						if(trim($valItem['MAPPINGID']) != '' && trim($valItem['MAPPINGID']) != 'null')
						{
							//save column name and item id to array
							$itemColumnName[] = $valItem['MAPPINGID'];
							
							//=============== CHECK TYPE OF COMPONENT ==================== 
							//if component type is FORM 1 COL or FORM 2 COL
							if($getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_1_col' || $getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_2_col')
							{	
								//---------- check if item returned is array or not ----------
								if(is_array($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]))
								{	
									//if array, check the corresponding delimiter
									$getDelimeter = "select ITEMDELIMITER from FLC_PAGE_COMPONENT_ITEMS where ITEMID = ".$valItem['ITEMID'];
									$getDelimeterRs = $myQuery->query($getDelimeter,'SELECT','NAME');
									
									//if delimiter is set, format according to delimiter
									if($getDelimeterRs[0]['ITEMDELIMITER'] != '')
									{
										$itemID[] = "'".implode($getDelimeterRs[0]['ITEMDELIMITER'],$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']])."'";
										$itemNameValue[] = $valItem['MAPPINGID']. " = '".implode($getDelimeterRs[0]['ITEMDELIMITER'],$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']])."'";
									}
									
									//else, format to comma separated values (comma)
									else
									{
										$itemID[] = "'".implode(',',$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']])."'";
										$itemNameValue[] = $valItem['MAPPINGID']. " = '".implode(',',$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']])."'";
									}
								}
								
								//---------- check if item returned is FILES or not ----------
								else if(is_uploaded_file($_FILES[$elemNamePrefix.$key."_".$valItem['ITEMID']]['tmp_name']))
								{	
									//get upload parameter from component item
									$getUploadParam = "select ITEMUPLOAD from FLC_PAGE_COMPONENT_ITEMS where ITEMID = ".$valItem['ITEMID'];
									$getUploadParamRs = $myQuery->query($getUploadParam,'SELECT','NAME');
			
									//explode the data in ITEMUPLOAD FIELD
									$uploadParam = explode("|",$getUploadParamRs[0]['ITEMUPLOAD']);
									
									//check upload dir does not exist
									if(!is_dir($uploadParam[1]))
									{	
										//create upload directory
										mkdir($uploadParam[1],0700);
									}
									
									//if directory created and exist
	
									if(is_dir($uploadParam[1]))
									{	
										//start uploading the file
										$theUploadedFile = upload_file("./".$uploadParam[1].'/',$_FILES[$elemNamePrefix.$key."_".$valItem['ITEMID']]);
										
										//save in the array
										$itemID[] = "'".$theUploadedFile."'";
										$itemNameValue[] = $valItem['MAPPINGID']. " = '".$theUploadedFile."'";
									}
								}//end else
								
								//else, just take single value 
								else	
								{	
									//if type is input_date OR containing DATE and NOT = ajax_updater, add TO_DATE
									if(strpos($valItem['ITEMTYPE'],'date') && $valItem['ITEMTYPE'] != 'ajax_updater')
									{	
										$itemID[] = $mySQL->convertToDate($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]);
										$itemNameValue[] = $valItem['MAPPINGID']. " = ".$mySQL->convertToDate($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]);
									}
									
									//if type is password_md5, md5 the data!
									else if($valItem['ITEMTYPE'] == 'password_md5')
									{	
										$itemID[] = "'".md5($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']])."'";
										$itemNameValue[] = $valItem['MAPPINGID']. " = '".md5($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']])."'";
									}
									
									//else, just use the normal one
									else
									{
										//convert to uppercase
										if($valItem['ITEMUPPERCASE'])
											$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]=strtoupper($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]);
										
										$itemID[] = "'".$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]."'";
										$itemNameValue[] = $valItem['MAPPINGID']. " = '".$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]."'";
									}
								}//end else
							}//end if component form 1 col / form 2 col
							
							//if component type is TABULAR
							else if($getComponentInfoRs[0]['COMPONENTTYPE'] == 'tabular' || $getComponentInfoRs[0]['COMPONENTTYPE'] == 'report')
							{
								if(!isset($rowsCount) || !$rowsCount)		//fais 20080612
									$rowsCount = count($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]);	//count number of rows in the tabular input
								
								//if type is input_date OR containing DATE and NOT = ajax_updater, add TO_DATE
								if(strpos($valItem['ITEMTYPE'],'date') && $valItem['ITEMTYPE'] != 'ajax_updater')
								{	
									//for all rows
									for($f=0; $f < $rowsCount; $f++)
									{
										$itemID[$f][] = $mySQL->convertToDate($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']][$f]);
										$itemNameValue[$f][] = $valItem['MAPPINGID']. " = ".$mySQL->convertToDate($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']][$f]);
									}
								}
								
								//---------- check if item returned is FILES or not ----------
								else if(is_array($_FILES[$elemNamePrefix.$key."_".$valItem['ITEMID']]['tmp_name']))
								{	
									//count row of files
									$rowsCount = count($_FILES[$elemNamePrefix.$key."_".$valItem['ITEMID']]['tmp_name']);
										
									//get upload parameter from component item
									$getUploadParam = "select ITEMUPLOAD from FLC_PAGE_COMPONENT_ITEMS where ITEMID = ".$valItem['ITEMID'][$f];
									$getUploadParamRs = $myQuery->query($getUploadParam,'SELECT','NAME');
			
									//explode the data in ITEMUPLOAD FIELD
									$uploadParam = explode("|",$getUploadParamRs[0]['ITEMUPLOAD']);
									
									//check upload dir does not exist
									if(!is_dir($uploadParam[1]))
									{	
										//create upload directory
										mkdir($uploadParam[1],0700);
									}
									
									//if directory created and exist
	
									if(is_dir($uploadParam[1]))
									{	
										//start uploading the file
										$theUploadedFile = upload_file("./".$uploadParam[1].'/',$_FILES[$elemNamePrefix.$key."_".$valItem['ITEMID']]);
										
										//for all rows
										for($f=0; $f < $rowsCount; $f++)
										{
											//save in the array
											$itemID[$f][] = "'".$theUploadedFile[$f]."'";
											$itemNameValue[$f][] = $valItem['MAPPINGID']. " = '".$theUploadedFile[$f]."'";
										}//eof for
									}//eof if
								}//end else
								
								//else, just use the normal one
								else
								{
									//for all rows
									for($f=0; $f < $rowsCount; $f++)
									{	
										//convert to uppercase
										if($valItem['ITEMUPPERCASE'])
											$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']][$f]=strtoupper($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']][$f]);
										
										$itemID[$f][] = "'".$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']][$f]."'";
										$itemNameValue[$f][] = $valItem['MAPPINGID']. " = '".$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']][$f]."'";
									}			//here				
								}
							}//end if component type tabular
						}//end if mapping id is null
					}
					//---------------------- END IF COMPONENT POST PROCESS TYPE = INSERT / UPDATE --------
				}//end foreach item

				//============================== POST PROCESS ===================================
	
				//IF TYPE INSERT-----------------------------------------------------------------
				if($getComponentInfoRs[0]['COMPONENTPOSTPROCESS'] == 'insert')
				{
					//if component type is FORM 1 COL / FORM 2 COL
					if($getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_1_col' || $getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_2_col')
					{
						//create insert statement
						$insertStmt = "insert into ".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']. "
										(".implode(',',$itemColumnName).") 
										values (".implode(',',$itemID).")";
						$insertStmtRs = $myQuery->query($insertStmt,'RUN');
						
						//if insert statement is ok, add +1 to tabular ok count
						if($insertStmtRs)
							$insertRsCount++;
					}
					
					//if component type is TABULAR
					else if($getComponentInfoRs[0]['COMPONENTTYPE'] == 'tabular' || $getComponentInfoRs[0]['COMPONENTTYPE'] == 'report')
					{							
						//for all rows
						for($t=0; $t < $rowsCount; $t++)
						{
							//generate insert statement
							$insertStmt = "insert into ".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']. "
										(".implode(',',$itemColumnName).") 
										values (".implode(',',$itemID[$t]).")";
							$insertStmtRs = $myQuery->query($insertStmt,'RUN');
							
							//if insert statement is ok, add +1 to tabular ok count
							if($insertStmtRs)
								$insertRsCount++;
						}
					}//end else tabular
					
					//if type is SAVE and REDIRECT 
					if(isset($_POST['control_15']))
					{	
						//component is FORM 1 COL or FORM 2 COL, get primary key
						if($primaryColumn&&($getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_1_col' || $getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_2_col'))
						{
							//get primary key
							$getPrimaryKey = "select ".$primaryColumn."
													from ".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']." 
													where ".implode(' and ',$itemNameValue);
							$getPrimaryKeyRs = $myQuery->query($getPrimaryKey,'SELECT','INDEX');
							
							//copy primary key value to post data
							$_POST['PREV_PRIMARY_VALUE'] = $getPrimaryKeyRs[0][0];
						}//end if
					}//end if control id 15
				}//end if insert
				
				//IF TYPE UPDATE ----------------------------------------------------------------
				else if($getComponentInfoRs[0]['COMPONENTPOSTPROCESS'] == 'update')
				{
					//if component type is FORM 1 COL / FORM 2 COL
					if($getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_1_col' || $getComponentInfoRs[0]['COMPONENTTYPE'] == 'form_2_col')
					{
						//get primary keys from component item
						$getPrimaryKeyForm = "select itemid, componentid, mappingid  from FLC_PAGE_COMPONENT_ITEMS 
											where componentID = ".$getComponentInfoRs[0]['COMPONENTID'].
											" and itemprimarycolumn = 1";
						$getPrimaryKeyFormRs = $myQuery->query($getPrimaryKeyForm,'SELECT','NAME');
						$countGetPrimaryKeyFormRs = count($getPrimaryKeyFormRs);
						
						//append constraints to array				
						for($f=0; $f < $countGetPrimaryKeyFormRs; $f++)
							$primaryKeyFormArr[] = $getPrimaryKeyFormRs[$f]['MAPPINGID']." = '".$_POST['input_map_'.$getPrimaryKeyFormRs[$f]['COMPONENTID']."_".$getPrimaryKeyFormRs[$f]['ITEMID']]."' ";
						
						//start creating update statement				
						$updateStmt = "update ".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']. " 
										set  ".implode(',',$itemNameValue)."  
										where ".implode(' and ',$primaryKeyFormArr);
						
						//run update
						$updateStmtRs = $myQuery->query($updateStmt,'RUN');
						
						//if statement updated
						if($updateStmtRs)
							$updateRsCount++;
					}//end if form
					
					//if component type is TABULAR
					else if($getComponentInfoRs[0]['COMPONENTTYPE'] == 'tabular'||$getComponentInfoRs[0]['COMPONENTTYPE'] == 'report')
					{	
						//get primary key of the component
						$tempGetPrimaryKey="select itemid, mappingid from FLC_PAGE_COMPONENT_ITEMS where componentid = '".$getComponentInfoRs[0]['COMPONENTID']."' and itemprimarycolumn='1'";
						$tempGetPrimaryKeyRs = $myQuery->query($tempGetPrimaryKey);
						$tempGetPrimaryKeyRsCount = count($tempGetPrimaryKeyRs);
						
						//loop on number of rows (array of items)
						for($a=0; $a<$rowsCount; $a++)
							//loop om primary key set
							for($b=0; $b<$tempGetPrimaryKeyRsCount; $b++)
								$primaryKey[$a][$b] = $tempGetPrimaryKeyRs[$b][1]."='".$_POST['input_map_'.$getComponentInfoRs[0]['COMPONENTID'].'_'.$tempGetPrimaryKeyRs[$b][0]][$a]."'";
						
						//loop on number of rows (array of items)
						for($a=0; $a<$rowsCount; $a++)
						{
							//prepare update statement
							$updateStmt = "update ".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']. " 
												set  ".implode(',',$itemNameValue[$a])."  
												where ".implode(' and ',$primaryKey[$a]);
							//execute update			
							$updateStmtRs = $myQuery->query($updateStmt,'RUN');
										
							//if statement updated
							if($updateStmtRs)
								$updateRsCount++;
						}//eof for
					}//end else if tabular
				}//end if type update
				//-------------------------------------------------------------------------------
			}//end for each component
			
			//--------------------notification---------------------------------------------------
			//if insert
			if($insertRsCount)
			{	
				//rows not inserted
				$tabularNotInsertCount = $rowsCount - $insertRsCount;
				
				//if have rows can't be inserted
				if($tabularNotInsertCount>0)
				{
					//show notification
					if($englishFlag == false)
						showNotification('',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT'].' ('.$tabularNotInsertCount.' rows NOT inserted.)');
					else
						showNotification('',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT'].' ('.$tabularNotInsertCount.' rows NOT inserted.)','english');
				}//eof if
				else
				{
					//show notification
					if($englishFlag == false)
						showNotification('INSERT',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT']);
					else
						showNotification('INSERT',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT'],'english');
				}//eof else
			}//eof if
			
			//if update tabular
			if($updateRsCount)
			{	
				//rows not inserted
				$tabularNotUpdateCount = $rowsCount - $updateRsCount;
				
				//if have rows can't be updated
				if($tabularNotInsertCount>0)
				{
					//show notification
					if($englishFlag == false)
						showNotification('',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT'].' ('.$tabularNotUpdateCount.' rows NOT updated.)');
					else
						showNotification('',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT'].' ('.$tabularNotUpdateCount.' rows NOT updated.)','english');
				}//eof if
				else
				{
					//show notification
					if($englishFlag == false)
						showNotification('UPDATE',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT']);
					else
						showNotification('UPDATE',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT'],'english');
				}//eof else
			}//eof if
		}//eof if have component
	}
	
	//if page control DELETE (ctrl 8)
	if(isset($_POST['control_8']))
	{
		//sort array using keys
		ksort($_POST);
	
		//get list of items ID grouped in component ID
		$theComponent = postDataSplit($_POST,$elemNamePrefix);
		
		//get component info
		$getComponentInfo = "select * from FLC_PAGE_COMPONENT where COMPONENTID = ".key($theComponent);
		$getComponentInfoRs = $myQuery->query($getComponentInfo,'SELECT','NAME');

		//get component items info
		$getItemInfo = "select * from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = ".key($theComponent);
		$getItemInfoRs = $myQuery->query($getItemInfo,'SELECT','NAME');
		$countGetItemInfo = count($getItemInfoRs);
		
		//for all items, find primary column
		for($a=0; $a < $countGetItemInfo; $a++)
		{
			if($getItemInfoRs[$a]['ITEMPRIMARYCOLUMN'] == 1)
			{	
				$primaryColumnID = $getItemInfoRs[$a]['ITEMID'];				//get primary key item id
				$getPrimaryKeyColumnName = $getItemInfoRs[$a]['MAPPINGID'];		//get db column mapping
				
				//construct the delete constraint
				$deleteArr[] = $getPrimaryKeyColumnName." = '".$_POST['input_map_'.key($theComponent)."_".$primaryColumnID]."' ";
			}
		}
		
		//if primary constraint array count more than 0
		if(count($deleteArr) > 0)
		{
			//create delete statement
			$deleteStmt = "delete from ".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']. "
							where ".implode(' and ',$deleteArr);
			
			$deleteStmtRs = $myQuery->query($deleteStmt,'RUN');
			
			//show notification
			if($deleteStmtRs == true)
			{
				if($englishFlag == false)
					showNotification('DELETE',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT']);
				else
					showNotification('DELETE',$getComponentInfoRs[0]['COMPONENTPOSTSCRIPT'],'english');
			}
		}//end if
	}//end if control 8
	
	//if BL
	if(isset($_POST['control_24']))
	{
		//sort array using keys
		ksort($_POST);
	
		//get list of items ID grouped in component ID
		$theComponent = postDataSplit($_POST,$elemNamePrefix);
		
		//if have component
		if($theComponent)
		{
			//foreach components		
			foreach($theComponent as $key => $val) 
			{
				//get component info
				$getComponentInfo = "select * from FLC_PAGE_COMPONENT where COMPONENTID = ".$key;
				$getComponentInfoRs = $myQuery->query($getComponentInfo,'SELECT','NAME');
				
				//======= BL
				if($getComponentInfoRs[0]['COMPONENTBINDINGTYPE']=='bl' && $getComponentInfoRs[0]['COMPONENTBINDINGSOURCE'])
				{
					/*//get bl info
					$getBL="select blname,blparameter,upper(blparametertype) blparametertype,bldetail 
								from FLC_BL 
								where blstatus='00' and blname='".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']."'";
					$getBLRs=$myQuery->query($getBL,'SELECT','NAME');
					
					$getBLName=$getBLRs[0]['BLNAME'];
					$getBLParameterCount=count($getBLParameter);
					
					//if have parameter
					if($getBLRs[0]['BLPARAMETER'])
					{
						$getBLParameter['NAME']=explode('|',$getBLRs[0]['BLPARAMETER']);			//parameter name
						$getBLParameter['IN_OUT']=explode('|',$getBLRs[0]['BLPARAMETERTYPE']);		//in out
						$getBLParameterCount=count($getBLParameter['NAME']);								//count bl parameter
					}//eof if			
					
					//get component items info
					$getItemInfo = "select itemid,mappingid from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = ".$key;
					$getItemInfoRs = $myQuery->query($getItemInfo,'SELECT','NAME');
					$countGetItemInfo = count($getItemInfoRs);
					
					//unset parameter
					unset($inParameter);
					unset($outParameter);
					unset($inParameterString);
					unset($outParameterString);
					unset($BLParameterString);
					
					//loop on count of bl parameter
					for($x=0;$x<$getBLParameterCount;$x++)
					{
						//bl in parameter
						if($getBLParameter['IN_OUT'][$x]=='IN'||$getBLParameter['IN_OUT'][$x]=='IN_OUT')
						{
							if(!$BLParameterString)
								$BLParameterString='$'.$getBLParameter['NAME'][$x];
							else
								$BLParameterString.=',$'.$getBLParameter['NAME'][$x];
							
							//pre-set parameter
							$inParameter[$x]='';	//temp
						}//eof if

						//loop on count of mapped item
						for($y=0;$y<$countGetItemInfo;$y++)
						{
							//if mapped
							if($getBLParameter['NAME'][$x]==$getItemInfoRs[$y]['MAPPINGID'])
							{
								//in parameter
								if($getBLParameter['IN_OUT'][$x]=='IN'||$getBLParameter['IN_OUT'][$x]=='IN_OUT')
									$inParameter[$x]=$_POST['input_map_'.$key.'_'.$getItemInfoRs[$y]['ITEMID']];
								//out parameter
								if($getBLParameter['IN_OUT'][$x]=='OUT'||$getBLParameter['IN_OUT'][$x]=='IN_OUT')
									$outParameter[$x]='input_map_'.$key.'_'.$getItemInfoRs[$y]['ITEMID'];
							}//eof if
						}//eof for
					}//eof for
					
					//if have in parameter
					if($inParameter)
					{
						$inParameterString="'".implode("','",$inParameter)."'";
					}//eof if
					
					//if have out parameter
					if($outParameter)
					{
						//loop on count of bl parameter
						for($x=0;$x<$getBLParameterCount;$x++)
						{
							//out parameter
							if($getBLParameter['IN_OUT'][$x]=='OUT'||$getBLParameter['IN_OUT'][$x]=='IN_OUT')
								if($outParameter[$x])
									$outParameterString.='$_SESSION[\'BL\'][\''.$outParameter[$x].'\']=$'.$getBLParameter['NAME'][$x].';';
						}//eof for
					}//eof if
				
					//convert post, get, session
					$getBLRs[0]['BLDETAIL'] = convertDBSafeToQuery($getBLRs[0]['BLDETAIL']);
					
					//create bl function
					$tempBL=create_function($BLParameterString,$getBLRs[0]['BLDETAIL'].$outParameterString);
					$$getBLName=$tempBL;	//$getBLName
					
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
					}//eof if*/
					
					//$getBLName = $getComponentInfoRs[0]['COMPONENTBINDINGSOURCE'];
					//$$getBLName = createBL($myQuery,$getBLName);						//create bl
					//$TEST('a','b');
					
					executeBL($getComponentInfoRs[0]['COMPONENTBINDINGSOURCE'],$key);					//execute bl givern the blname n componentid (optional)
				}//eof if
			}//eof foreach
		}//eof if
	}//eof bl
	
	//if page control LOADING
	if(isset($_POST['control_26']))
	{
		//sort array using keys
		ksort($_POST);
	
		//get list of items ID grouped in component ID
		$theComponent = postDataSplit($_POST,'upload_loading_');
		
		//if have component
		if($theComponent)
		{
			//foreach components		
			foreach($theComponent as $key => $val) 
			{
				//get component info
				$getComponentInfo = "select * from FLC_PAGE_COMPONENT where COMPONENTID = ".$key;
				$getComponentInfoRs = $myQuery->query($getComponentInfo,'SELECT','NAME');
				
				//======= LOADING
				if($getComponentInfoRs[0]['COMPONENTBINDINGTYPE']=='loading' && $getComponentInfoRs[0]['COMPONENTBINDINGSOURCE'])
				{
					//get loading info
					$getLoadingInfo = "select * from FLC_LOADING where LOADING_NAME = '".$getComponentInfoRs[0]['COMPONENTBINDINGSOURCE']."' and LOADING_STATUS='00'";
					$getLoadingInfoRs = $myQuery->query($getLoadingInfo,'SELECT','NAME');

					//if file uploaded
					if($_FILES['upload_file_'.$getComponentInfoRs[0]['COMPONENTID']]['tmp_name'])
					{
						//execute pre-process bl
						setLoadingContent('csv',file_get_contents($_FILES['upload_file_'.$getComponentInfoRs[0]['COMPONENTID']]['tmp_name']));
						executeBL($getLoadingInfoRs[0]['LOADING_PREPROCESS_BL']);
					}//eof if
					else if($_POST['upload_loading_'.$getComponentInfoRs[0]['COMPONENTID']])
					{
						//convert loading input
						$_POST['upload_loading_'.$getComponentInfoRs[0]['COMPONENTID']] = getLoadingContent('csv',$_POST['upload_loading_'.$getComponentInfoRs[0]['COMPONENTID']]);
						$_SESSION['loading']['content']=$_POST['upload_loading_'.$getComponentInfoRs[0]['COMPONENTID']];
						executeBL($getLoadingInfoRs[0]['LOADING_BL']);
					}//eof else if
				}//eof if
				//======= LOADING
			}//eof foreach
		}//eof if
	}//eof if
	
	//if page control STORED PROCEDURE (ctrl 10) or SAVE and REDIRECT (ctrl 16) is clicked or SP REFRESH & GET
	if(isset($_POST['control_9']) || isset($_POST['control_16']) || isset($_POST['control_23']))
	{
		include('page_wrapper_stored_procedure.php');
	}	
?>