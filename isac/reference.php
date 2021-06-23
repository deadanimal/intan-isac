<?php
require_once('class/Table.php');				//class Table

//===================================== variable =============================================
//table name
if($_GET['reftype'])
	$tableName = 'REF' . strtoupper($_GET['reftype']);
else
	$tableName = 'REFGENERAL';

//referenceid (get from menu link)
if($_GET['referenceid']||$_GET['referencename'])
{
	//set chosen referenceid and show listing
	$_POST['referenceID']=$mySQL->getReferenceID($_GET['referenceid'],$_GET['referencename'],$_SESSION['userID']);
	
	if($_POST['referenceID'])
		$_POST['showList']=true;
	else		
	{
		$eventType='error';
		$message='Rujukan tidak wujud atau tidak aktif!<br>';
	}//eof else
}//eof if

//breadcrumbs
switch(strtoupper($_GET['reftype']))
{
	case 'SYSTEM':	$URLMalay='Sistem';
					$refStartCount=200000000;
					$masterStartCount=20000;
		break;
	default:		$URLMalay='Am';
					$refStartCount=100000000;
					$masterStartCount=10000;
}//eof switch

//user type
switch(strtoupper($_SESSION['userTypeCode']))
{
	default:
	case 'USER': $userType=3;
		break;
	case 'ADMIN': $userType=2;
		break;
	case 'SYSTEM': $userType=1;
		break;
}//eof switch

//remove dataid in url
$tempAction=explode('&dataid',$_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI']=$tempAction[0];

//remove referenceid in url
$tempAction=explode('&referenceid',$_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI']=$tempAction[0];

//remove referenceid in url
$tempAction=explode('&referencename',$_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI']=$tempAction[0];

//location for forms
$action=$_SERVER['REQUEST_URI'];
//=================================== eof variable ===========================================

//=================================== manipulation ===========================================
//save new category
if($_POST['saveNewCat'])
{
	//notification
	$insertCatSuccessNotification = "Rujukan berjaya disimpan.<br>";
	$insertCatErrorNotification = "Rujukan gagal disimpan.<br>";
	$insertPermissionSuccessNotification = " kumpulan akses berjaya disimpan.<br>";
	$insertPermissionErrorNotification = " kumpulan akses gagal disimpan.<br>";
	
	//append <<REF>>
	if($_POST['groupCodeLookupTable'])
		$_POST['groupCodeLookupTable']='<<REF>> '.$_POST['groupCodeLookupTable'];
	
	if($_POST['codeLookupTable'])
		$_POST['codeLookupTable']='<<REF>> '.$_POST['codeLookupTable'];
	
	if($_POST['description1LookupTable'])
		$_POST['description1LookupTable']='<<REF>> '.$_POST['description1LookupTable'];
	
	if($_POST['description2LookupTable'])
		$_POST['description2LookupTable']='<<REF>> '.$_POST['description2LookupTable'];
	
	if($_POST['parentCodeLookupTable'])
		$_POST['parentCodeLookupTable']='<<REF>> '.$_POST['parentCodeLookupTable'];
	
	if($_POST['parentRootCodeLookupTable'])
		$_POST['parentRootCodeLookupTable']='<<REF>> '.$_POST['parentRootCodeLookupTable'];
	
	//validate referencename (unique)
	$refExist=$mySQL->getReferenceID('',$_POST['referenceName']);
	
	//if reference with same name not exist
	if(!$refExist)
	{
		//get max
		/*$sql="select nvl(max(to_number(referenceid)),".$refStartCount.")+1 from ".$tableName;
		$tempMax=$myQuery->query($sql);*/
		
		//maxreferenceid
		$maxReferenceID=$mySQL->maxValue($tableName,'referenceid',$refStartCount)+1;
		
		/*$maxReferenceID=$tempMax[0][0];*/
		
		//insert into container
		$sql="insert into SYSREFCONTAINER
				(referenceid, referencetitle, referencename,
				groupcodename, groupcodetype, groupcodedefaultvalue, groupcodelookuptable, groupcodequery, groupcodeunique,
				codename, codetype, codedefaultvalue, codelookuptable, codequery, codeunique,
				description1name, description1type, description1defaultvalue, description1lookuptable, description1query, description1unique,
				description2name, description2type, description2defaultvalue, description2lookuptable, description2query, description2unique,
				parentcodename, parentcodetype, parentcodedefaultvalue, parentcodelookuptable, parentcodequery, parentcodeunique,
				parentrootcodename, parentrootcodetype, parentrootcodedefaultvalue, parentrootcodelookuptable, parentrootcodequery, parentrootcodeunique,
				referencestatuscode)
				values
				(
					'".$maxReferenceID."','".$_POST['referenceTitle']."',upper('".$_POST['referenceName']."'),
					'".$_POST['groupCodeName']."','".$_POST['groupCodeType']."','".$_POST['groupCodeDefaultValue']."','".$_POST['groupCodeLookupTable']."','".$_POST['groupCodeQuery']."','".$_POST['groupCodeUnique']."',
					'".$_POST['codeName']."','".$_POST['codeType']."','".$_POST['codeDefaultValue']."','".$_POST['codeLookupTable']."','".$_POST['codeQuery']."','".$_POST['codeUnique']."',
					'".$_POST['description1Name']."','".$_POST['description1Type']."','".$_POST['description1DefaultValue']."','".$_POST['description1LookupTable']."','".$_POST['description1Query']."','".$_POST['description1Unique']."',
					'".$_POST['description2Name']."','".$_POST['description2Type']."','".$_POST['description2DefaultValue']."','".$_POST['description2LookupTable']."','".$_POST['description2Query']."','".$_POST['description2Unique']."',
					'".$_POST['parentCodeName']."','".$_POST['parentCodeType']."','".$_POST['parentCodeDefaultValue']."','".$_POST['parentCodeLookupTable']."','".$_POST['parentCodeQuery']."','".$_POST['parentCodeUnique']."',
					'".$_POST['parentRootCodeName']."','".$_POST['parentRootCodeType']."','".$_POST['parentRootCodeDefaultValue']."','".$_POST['parentRootCodeLookupTable']."','".$_POST['parentRootCodeQuery']."','".$_POST['parentRootCodeUnique']."',
					'".$_POST['statusCode']."'
				)";
		$insert=$myQuery->query($sql,'RUN');
		
		//if container inserted
		if($insert)
		{
			//insert into reference as master
			$sql="insert into ".$tableName."
					(referenceid,mastercode,referencecode,description1,timestamp,referencestatuscode,userid)
					values
					(
						'".$maxReferenceID."','XXX',(".$mySQL->maxValue($tableName,'referencecode',$masterStartCount,"mastercode='XXX'").")+1,
						upper('".$_POST['referenceName']."'),".$mySQL->currentDate().",'".$_POST['statusCode']."','".$_SESSION['userID']."'
					)";
			$insert=$myQuery->query($sql,'RUN');
			
			//if data inserted
			if($insert)
				$message.=$insertCatSuccessNotification;
			else
			{
				$eventType='error';
				$message.=$insertCatErrorNotification;
			}//eof else
				
			//== permission =====================================================================
			$selectedGroupCount=count($_POST['selectedGroup']);
			
			//loop on count
			for($x=0;$x<$selectedGroupCount;$x++)
			{
				//insert permission
				$sql="insert into SYSREFPERMISSION (referenceid,groupid)
						values
						(
							'".$maxReferenceID."', '".$_POST['selectedGroup'][$x]."'
						)";
				$insert=$myQuery->query($sql,'RUN');
				
				//if permission insert success
				if($insert)
					$permissionSuccess++;
				else
					$permissionError++;
			}//eof for
			
			//if have error
			if($permissionError)
			{
				$eventType='error';
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
				$message.=$permissionError.$insertErrorSuccessNotification;
			}//eof if
			else
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
			//== eof permission =============================================================
			
			$_POST['referenceID']=$maxReferenceID;
		}//eof if
		else
		{
			$eventType='error';
			$message.=$insertCatErrorNotification;
		}//eof else
	}//eof if
	//eif same name exist
	else
	{
		$eventType='error';
		$message.='Rujukan <strong>'.$_POST['referenceName'].'</strong> telah wujud dan berstatus aktif di dalam sistem.<br>';
	}//eof else
}//eof if

//save edit category
if($_POST['saveEditCat'])
{
	//notification
	$updateCatSuccessNotification = "Rujukan berjaya dikemaskini.<br>";
	$updateCatErrorNotification = "Rujukan gagal dikemaskini.<br>";
	$insertPermissionSuccessNotification = " kumpulan akses berjaya disimpan.<br>";
	$insertPermissionErrorNotification = " kumpulan akses gagal disimpan.<br>";
	
	$permissionSuccess=0;
	$permissionError=0;
	
	//append <<REF>>
	if($_POST['groupCodeLookupTable'])
		$_POST['groupCodeLookupTable']='<<REF>> '.$_POST['groupCodeLookupTable'];
	
	if($_POST['codeLookupTable'])
		$_POST['codeLookupTable']='<<REF>> '.$_POST['codeLookupTable'];
	
	if($_POST['description1LookupTable'])
		$_POST['description1LookupTable']='<<REF>> '.$_POST['description1LookupTable'];
	
	if($_POST['description2LookupTable'])
		$_POST['description2LookupTable']='<<REF>> '.$_POST['description2LookupTable'];
	
	if($_POST['parentCodeLookupTable'])
		$_POST['parentCodeLookupTable']='<<REF>> '.$_POST['parentCodeLookupTable'];
	
	if($_POST['parentRootCodeLookupTable'])
		$_POST['parentRootCodeLookupTable']='<<REF>> '.$_POST['parentRootCodeLookupTable'];
	
	//validate referencename (unique)
	$refExist=$mySQL->getReferenceID('',$_POST['referenceName']);
	
	//if reference with same name not exist or update is done on same reference
	if(!$refExist || $refExist == $_POST['referenceID'])
	{
		//update container
		$sql="update SYSREFCONTAINER set
					referencetitle='".$_POST['referenceTitle']."',
					referencename=upper('".$_POST['referenceName']."'),
					groupcodename='".$_POST['groupCodeName']."',
					groupcodetype='".$_POST['groupCodeType']."',
					groupcodedefaultvalue='".$_POST['groupCodeDefaultValue']."',
					groupcodelookuptable='".$_POST['groupCodeLookupTable']."',
					groupcodequery='".$_POST['groupCodeQuery']."',
					groupcodeunique='".$_POST['groupCodeUnique']."',
					codename='".$_POST['codeName']."',
					codetype='".$_POST['codeType']."',
					codedefaultvalue='".$_POST['codeDefaultValue']."',
					codelookuptable='".$_POST['codeLookupTable']."',
					codequery='".$_POST['codeQuery']."',
					codeunique='".$_POST['codeUnique']."',
					description1name='".$_POST['description1Name']."',
					description1type='".$_POST['description1Type']."',
					description1defaultvalue='".$_POST['description1DefaultValue']."',
					description1lookuptable='".$_POST['description1LookupTable']."',
					description1query='".$_POST['description1Query']."',
					description1unique='".$_POST['description1Unique']."',
					description2name='".$_POST['description2Name']."',
					description2type='".$_POST['description2Type']."',
					description2defaultvalue='".$_POST['description2DefaultValue']."',
					description2lookuptable='".$_POST['description2LookupTable']."',
					description2query='".$_POST['description2Query']."',
					description2unique='".$_POST['description2Unique']."',
					parentcodename='".$_POST['parentCodeName']."',
					parentcodetype='".$_POST['parentCodeType']."',
					parentcodedefaultvalue='".$_POST['parentCodeDefaultValue']."',
					parentcodelookuptable='".$_POST['parentCodeLookupTable']."',
					parentcodequery='".$_POST['parentCodeQuery']."',
					parentcodeunique='".$_POST['parentCodeUnique']."',
					parentrootcodename='".$_POST['parentRootCodeName']."',
					parentrootcodetype='".$_POST['parentRootCodeType']."',
					parentrootcodedefaultvalue='".$_POST['parentRootCodeDefaultValue']."',
					parentrootcodelookuptable='".$_POST['parentRootCodeLookupTable']."',
					parentrootcodequery='".$_POST['parentRootCodeQuery']."',
					parentrootcodeunique='".$_POST['parentRootCodeUnique']."',
					referencestatuscode='".$_POST['statusCode']."'
				where referenceid='".$_POST['referenceID']."'";
		$update=$myQuery->query($sql,'RUN');
		
		//update reference master
		$sql="update ".$tableName." set description1=upper('".$_POST['referenceName']."') where referenceid='".$_POST['referenceID']."'";
		$update=$myQuery->query($sql,'RUN');
		
		//if success update
		if($update)
		{
			$message.=$updateCatSuccessNotification;			//notification
			
			//== permission =====================================================================
			$selectedGroupCount=count($_POST['selectedGroup']);
			
			//delete permission
			$sql="delete from SYSREFPERMISSION where referenceid='".$_POST['referenceID']."'";
			$delete=$myQuery->query($sql,'RUN');
			
			//loop on count
			for($x=0;$x<$selectedGroupCount;$x++)
			{
				//insert permission
				$sql="insert into SYSREFPERMISSION (referenceid,groupid)
						values
						(
							'".$_POST['referenceID']."', '".$_POST['selectedGroup'][$x]."'
						)";
				$insert=$myQuery->query($sql,'RUN');
				
				//if permission insert success
				if($insert)
					$permissionSuccess++;
				else
					$permissionError++;
			}//eof for
			
			//if have error
			if($permissionError)
			{
				$eventType='error';
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
				$message.=$permissionError.$insertPermissionErrorNotification;
			}//eof if
			else
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
			//== eof permission =================================================================
		}
		else
		{
			$eventType='error';
			$message.=$updateCatErrorNotification;
		}//eof else
	}//eof if
	//ref exist
	else
	{
		$eventType='error';
		$message.='Rujukan <strong>'.$_POST['referenceName'].'</strong> telah wujud. Hanya 1 rujukan yang aktif dibenarkan pada satu masa.<br>';
	}//eof else
}//eof if

//if save new data or update data (validate duplication)
if($_POST['saveNewData'] || $_POST['saveEditData'])
{
	//name unique
	$nameUnique = $mySQL->checkUnique($tableName,$_POST['referenceID'],$_POST['groupCode'],$_POST['referenceCode'],$_POST['description1'],$_POST['description2'],$_POST['parentCode'],$_POST['parentRootCode'],$_POST['statusCode'],$_POST['dataID']);
	$nameUniqueRowCount=count($nameUnique);			//row count
	$nameUniqueColumnCount=count($nameUnique[0]);	//column count
	
	//if have duplicate in unique item
	if(is_array($nameUnique))
	{
		//loop on count unique name row
		for($x=0;$x<$nameUniqueRowCount;$x++)
		{
			//loop on count name column
			for($y=0;$y<$nameUniqueColumnCount;$y++)
			{
				//if have duplication, append column name into message
				if($y!=$columnChecked && $nameUnique[$x][$y])
				{
					//if have column name in string
					if($uniqueColumnName)
						$uniqueColumnName.=', ';
					
					//column name (to be appended into message)
					$uniqueColumnName.=$nameUnique[$x][$y];
					
					//assign column that has been checked to skip later
					$columnChecked=$y;
				}//eof if
			}//eof for
		}//eof for
	}//eof if
}//eof if

//save new data
if($_POST['saveNewData'])
{
	//notification
	$insertDataSuccessNotification = "Data berjaya disimpan.<br>";
	$insertDataErrorNotification = "Data gagal disimpan.<br>";
	
	//if don't have any duplication
	if(!$uniqueColumnName)
	{
		//get referencecode
		$getReferenceCode = $myQuery->query("select referencecode from ".$tableName." where referenceid='".$_POST['referenceID']."'");
		
		//insert into table
		$sql="insert into ".$tableName." 
				(referenceid,mastercode,groupcode,referencecode,description1,
				description2,parentcode,parentrootcode,timestamp,referencestatuscode,userid)
				values
				(
					(".$mySQL->maxValue($tableName,'referenceid',$refStartCount).")+1,
					".$getReferenceCode[0][0].",
					'".$_POST['groupCode']."','".$_POST['referenceCode']."','".$_POST['description1']."',
					'".$_POST['description2']."','".$_POST['parentCode']."','".$_POST['parentRootCode']."',
					".$mySQL->currentDate().",'".$_POST['statusCode']."','".$_SESSION['userID']."'
				)";
		$insert=$myQuery->query($sql,'RUN');
		
		//if success insert
		if($insert)
			$message.=$insertDataSuccessNotification;
		else
		{
			$eventType='error';
			$message.=$insertDataErrorNotification;
		}//eof else
	}//eof if
	//if have duplicate in unique item
	else
	{
		$eventType='error';
		$message.=$uniqueColumnName.' yang diisi telah wujud dan berstatus aktif di dalam sistem.<br>';
		$message.=$insertDataErrorNotification;
	}//eof if
	
	//display listing
	$_POST['showList']=true;
}//eof if

//save edit data
if($_POST['saveEditData'])
{
	//notification
	$updateDataSuccessNotification = "Data berjaya dikemaskini.<br>";
	$updateDataErrorNotification = "Data gagal dikemaskini.<br>";
	
	//if don't have any duplication
	if(!$uniqueColumnName)
	{
		//update table
		$sql="update ".$tableName." set
					groupcode='".$_POST['groupCode']."',
					referencecode='".$_POST['referenceCode']."',
					description1='".$_POST['description1']."',
					description2='".$_POST['description2']."',
					parentcode='".$_POST['parentCode']."',
					parentrootcode='".$_POST['parentRootCode']."',
					timestamp=".$mySQL->currentDate().",
					referencestatuscode='".$_POST['statusCode']."',
					userid='".$_SESSION['userID']."'
				where referenceid='".$_POST['dataID']."'";
		$update=$myQuery->query($sql,'RUN');
		
		//if success update
		if($update)
			$message.=$updateDataSuccessNotification;
		else
		{
			$eventType='error';
			$message.=$updateDataErrorNotification;
		}//eof else
	}//eof if
	//if have duplicate in unique item
	else
	{
		$eventType='error';
		$message.=$uniqueColumnName.' yang diisi telah wujud dan berstatus aktif di dalam sistem.<br>';
		$message.=$insertDataErrorNotification;
	}//eof if
	
	//display listing
	$_POST['showList']=true;
}//eof if

//delete category
if($_POST['deleteCat'])
{
	//notification
	$delCatSuccessNotification = " rujukan telah dibuang. Data yang berkaitan turut dibuang<br>";
	$delCatErrorNotification = " rujukan gagal dibuang.<br>";
	
	$delSuccess=0;
	$delError=0;
	
	//mastercode fr referenceid
	$sql="select referencecode from ".$tableName." where referenceid='".$_POST['referenceID']."'";
	$mastercode=$myQuery->query($sql);
	
	//delete data
	$sql="delete from ".$tableName." where mastercode='".$mastercode[0][0]."'";
	$delete=$myQuery->query($sql,'RUN');
	
	//delete reference
	$sql="delete from ".$tableName." where referenceid='".$_POST['referenceID']."'";
	$delete=$myQuery->query($sql,'RUN');
	
	//delete container
	$sql="delete from SYSREFCONTAINER where referenceid='".$_POST['referenceID']."'";
	$delete=$myQuery->query($sql,'RUN');
	
	//if delete success
	if($delete)
	{
		$delSuccess++;
		
		//== permission =====================================================================
		//delete permission
		$sql="delete from SYSREFPERMISSION where referenceid='".$_POST['referenceID']."'";
		$delete=$myQuery->query($sql,'RUN');
		//== eof permission =================================================================
	}//eof if
	else
		$delError++;
	
	//if have error while delete
	if($delError)
	{
		$eventType='error';
		$message.=$delSuccess.$delCatSuccessNotification;
		$message.=$delError.$delCatErrorNotification;
	}//eof if
	else
		$message.=$delSuccess.$delCatSuccessNotification;
	
	$_POST['referenceID']=false;
}//eof if

//delete data
if($_POST['deleteData'])
{
	//notification
	$delDataSuccessNotification = " data telah dibuang.<br>";
	$delDataErrorNotification = " data gagal dibuang.<br>";
	
	$delSuccess=0;
	$delError=0;
	
	//count data to be deleted
	$deleteIDCount=count($_POST['deleteID']);
	
	//loop on deleteID checked
	for($x=0;$x<$deleteIDCount;$x++)
	{
		$sql="delete from ".$tableName." where referenceid='".$_POST['deleteID'][$x]."'";
		$delete=$myQuery->query($sql,'RUN');
		
		if($delete)
			$delSuccess++;
		else
			$delError++;
	}//eof for
	
	//if have error while delete
	if($delError)
	{
		$eventType='error';
		$message.=$delSuccess.$delDataSuccessNotification;
		$message.=$delError.$delDataErrorNotification;
	}//eof if
	else
		$message.=$delSuccess.$delDataSuccessNotification;
	
	$_POST['showList']=true;
}//eof if
//================================= eof manipulation ========================================

//================================= eof manipulation ========================================
//if filter
if($_POST['filter'] || $_POST['filterName'])
{
	//switch to set the value
	switch($_POST['filterName'])
	{
		case 1: $filterName='groupcode'; break;
		case 2: $filterName='referencecode'; break;
		case 3: $filterName='description1'; break;
		case 4: $filterName='description2'; break;
		case 5: $filterName='parentcode'; break;
		case 6: $filterName='parentrootcode'; break;
		default:
			$_POST['filterValue']='';
	}//eof switch
	
	//if have value in filter
	if($_POST['filterValue'])
		$filter="upper(".$filterName.") like upper('%".$_POST['filterValue']."%')";
	
	//display listing
	$_POST['showList']=true;
}//eof filter
//================================= eof manipulation ========================================

//if cancel and hav referenceid
if($_POST['cancel'] && $_POST['referenceID'])
{
	$_POST['showList']=true;
	//show listing
}//eof if

//if post order
if($_POST['order']!='')
	$_POST['showList']=true;

//================================= tabular display =========================================
//show listing
if($_POST['showList'])
{
	//use of class TableGrid
	//==================== DECLARATION =======================
	$tg=new TableGrid('100%',0,0,0);						//set object for table class (width,border,celspacing,cellpadding)
	
	//set attribute of table
	$tg->setAttribute('id','tableContent');					//set id
	$tg->setHeader('Senarai Data Rujukan');					//set header
	$tg->setKeysStatus(true);								//use of keys (column header)
	$tg->setKeysAttribute('class','listingHead');			//set class
	$tg->setRunningStatus(true);							//set status of running number
	$tg->setRunningKeys('No');								//key / label for running number

	//set attribute of column in table
	$col = new Column();									//set object for column
	$col->setAttribute('class','listingContent');			//set attribute for table
	$tg->setColumn($col);									//insert/set class column into table
	$tg->setLimit(DEFAULT_REFERENCE_PAGING);				//set display limit (paging)
	//================== END DECLARATION =====================

	//reference data
	$refData=$mySQL->referenceData($tableName,$_POST['referenceID'],$userType,$filter);
	
	//set data 
	if(is_array($refData))
		$tg->setTableGridData($refData);
	else 
		$tg->setTableGridData('Tiada Data');
	
	//count data
	$headerCount=count($refData[0]);
	
	//header
	$tg->setHeaderAttribute('colspan',$headerCount);			//set colspan for header
	
	//footer
	$tg->setFooterAttribute('class','contentButtonFooter');		//set footer attribute
	$tg->setFooterAttribute('colspan',$headerCount);			//set footer attribute
	$tg->setFooterAttribute('align','right');					//set footer attribute
	
	//restricted if type user
	if($userType!=3)
	{
		//footer
		$footButton='<input name="referenceID" type="hidden" id="referenceID" value="'.$_POST['referenceID'].'" />
		<input id="newData" name="newData" type="submit" value="Baru" class="inputButton" style="margin:2px" />';
		
		//if have data
		if(is_array($refData))
			$footButton.='<input id="delData" name="deleteData" type="submit" value="Hapus" class="inputButton" style="margin:2px" 
							onClick="if(window.confirm(\'Anda pasti untuk MEMBUANG data ini?\')) {return true} else {return false}" />';
	}//eof if
	
	$tg->setFooter($footButton);								//set the data of footer
	
	//=== filter set section ================================================================
	//get data of reference (container name)
	$data=$mySQL->data($tableName,$_POST['referenceID']);

	$dataCount=count($data);

	for($x=0,$y=0;$x<6;$x++)
	{
		if($data['Name'][$x+1])
		{
			//set value and label for dropdown <option> 
			$filterList[$y][0]=$x+1;
			$filterList[$y][1]=$data['Name'][$x+1];
			$y++;
		}//eof if
	}//eof for
	//=== eof filter set section ============================================================
	
	//=== sorting section ===================================================================
	//if order have value
	if($_POST['order']!='')
	{
		$sortStatus=$tg->sortIndex(true,$_POST['order']);		//sort based on index
	}//eof if
	//=== sorting section ===================================================================
		
	//=== alter keys to allow sorting =======================================================
	//get keys
	$keysLabel=$tg->getKeys();
	
	//check if keys / label is create
	if($keysLabel)
	{
		$keysLabelCount=count($keysLabel);	//count keys/header label
		$tempCountLabel=0;			//set initial as 0 (count index of label)
		
		//do while not reach end of array
		do
		{
			//put label that will submit current form with index to be ordered when submitted
			$keysLabel[key($keysLabel)]='<label style="cursor:pointer; text-decoration:underline" onclick="document.getElementById(\'order\').value=\''.($tempCountLabel++).'\';this.form.submit();">'.current($keysLabel).'</label>';
		}while(next($keysLabel));
		
		$tg->setKeys($keysLabel);		//set keys in tablegrid
	}//eof if label	
	//=== eof alter keys to allow sorting ===================================================
	
	
}//eof if
//=============================== eof tabular display =======================================

//================================ data form display ========================================
//new container
if($_POST['newCat'])
{
	$_POST['referenceID']=false;
}//eof if

//display container
if($_POST['editCat'])
{
	//select container
	$sql="select referenceid, referencetitle, referencename,
			groupcodename, groupcodetype, groupcodedefaultvalue, substr(groupcodelookuptable,8) groupcodelookuptable, groupcodequery, groupcodeunique,
			codename, codetype, codedefaultvalue, codelookuptable, codequery, codeunique,
			description1name, description1type, description1defaultvalue, substr(description1lookuptable,8) description1lookuptable, description1query, description1unique,
			description2name, description2type, description2defaultvalue, substr(description2lookuptable,8) description2lookuptable, description2query, description2unique,
			parentcodename, parentcodetype, parentcodedefaultvalue, substr(parentcodelookuptable,8) parentcodelookuptable, parentcodequery, parentcodeunique,
			parentrootcodename, parentrootcodetype, parentrootcodedefaultvalue, substr(parentrootcodelookuptable,8) parentrootcodelookuptable, parentrootcodequery, parentrootcodeunique,
			referencestatuscode
			from SYSREFCONTAINER
			where referenceid='".$_POST['referenceID']."'";
	$container=$myQuery->query($sql,'SELECT','NAME');
	
	//check either check box is yes or no
	$groupCode=havValue($container[0][strtoupper('groupcodename')]);
	$referenceCode=havValue($container[0][strtoupper('codename')]);
	$description1Code=havValue($container[0][strtoupper('description1name')]);
	$description2Code=havValue($container[0][strtoupper('description2name')]);
	$parentCode=havValue($container[0][strtoupper('parentcodename')]);
	$parentRootCode=havValue($container[0][strtoupper('parentrootcodename')]);
}//eof if

//if new or edit container
if($_POST['newCat'] || $_POST['editCat'])
{
	//lookuptable list
	$lookupTableList=$mySQL->reference($tableName, $_SESSION['userID']);
	
	//list group user non selected
	$groupListNonSelected=$mySQL->getUserGroupNonSelected($_POST['referenceID']);
	$groupListNonSelectedCount=count($groupListNonSelected);
	
	//list group user selected
	$groupListSelected=$mySQL->getUserGroupSelected($_POST['referenceID']);
	$groupListSelectedCount=count($groupListSelected);
}//eof if

//display data (perincian)
if($_GET['dataid'])
{
	//get master referenceid
	$sql="select referenceid from REFGENERAL 
			where referencecode=(select mastercode from REFGENERAL where referenceid='".$_GET['dataid']."')
			and mastercode='XXX'";
	$tempID=$myQuery->query($sql);
	
	$_POST['referenceID']=$tempID[0][0];		//master reference id
}//eof if

//get container & lookup
if($_POST['newData'] || $_GET['dataid'])
{
	//get data of reference
	$data=$mySQL->data($tableName,$_POST['referenceID'],$_GET['dataid']);
	
	$groupCodeList=$mySQL->getLookupItem($tableName,'groupcode',$_POST['referenceID']);
	$codeList=$mySQL->getLookupItem($tableName,'code',$_POST['referenceID']);
	$description1List=$mySQL->getLookupItem($tableName,'description1',$_POST['referenceID']);
	$description2List=$mySQL->getLookupItem($tableName,'description2',$_POST['referenceID']);
	$parentCodeList=$mySQL->getLookupItem($tableName,'parentcode',$_POST['referenceID']);
	$parentRootCodeList=$mySQL->getLookupItem($tableName,'parentrootcode',$_POST['referenceID']);
}//eof if
//============================== eof data form display =======================================

//======================================= general ============================================
//list of status
$statusList=$mySQL->status();
$statusListCount=count($statusList);

//list of reference
$refList = $mySQL->reference($tableName, $_SESSION['userID']);
$refListCount = count($refList);
//===================================== eof general ==========================================
?>
<script language="javascript" type="text/javascript" src="js/reference.js"></script>
<div id="breadcrumbs">Konfigurasi Kod / <?php echo $URLMalay;?> / </div>
<h1>Rujukan <?php echo $URLMalay;?></h1> 

<?php if($message)showNotification($eventType,$message);	//notification?>

<form id="form1" name="form1" method="post" action="<?php echo $action;?>">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2">Senarai Rujukan </th>
  </tr>
<tr>
 <td width="100" class="inputLabel">Rujukan :</td>
 <td>
 <div id="updateSelectorDropdown">
	<select name="referenceID" class="inputList" id="referenceID" onChange="if(this.selectedIndex!=0){swapItemEnabled('showList|editCat|deleteCat', '');}else{swapItemEnabled('', 'showList|editCat|deleteCat');}">
		<option value="">- Pilih Kategori -</option>      
		<?php 
		for($x=0;$x<$refListCount;$x++){?>
		<option value="<?php echo $refList[$x][0];?>" <?php if($_POST['referenceID'] == $refList[$x][0]){ ?>selected<?php }?>><?php echo $refList[$x][1];?></option>
		<?php }?>
  	</select>
	<input name="showList" type="submit" class="inputButton" id="showList" value="Papar" <?php if(!$_POST['referenceID']) { ?>disabled style="color:#999999"<?php }?>/>
  </div>
  </td>
</tr>
<?php if($userType!=3){?>
  <tr>
    <td class="contentButtonFooter" colspan="2" align="right">
      <input name="newCat" type="submit" class="inputButton" id="newCat" value="Baru" />
      <input name="editCat" type="submit" class="inputButton" id="editCat" value="Pinda" <?php if(!$_POST['referenceID']) { ?>disabled style="color:#999999"<?php }?>/>
      <input name="deleteCat" type="submit" class="inputButton" id="deleteCat" value="Hapus" <?php if(!$_POST['referenceID']) { ?>disabled style="color:#999999"<?php }?> onClick="if(window.confirm('Anda pasti untuk MEMBUANG rujukan ini?\nSEMUA data rujukan akan turut dibuang')) {return true} else {return false}"/></td>
  </tr>
<?php }?>
</table>
</form>
<br />

<?php if($_POST['showList']){unset($_GET['dataid']);?>

<form id="form2" name="form2" method="post" action="<?php echo $action;?>">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <th colspan="2">Carian Terperinci</th>
	</tr>
	<tr>
	  <td class="inputLabel" width="100" nowrap="nowrap">Carian : </td>
	  <td> 
	    <select name="filterName" class="inputList">
			<?php echo createDropDown($filterList,$_POST['filterName']);?>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Nilai : </td>
	  <td><input name="filterValue" type="text" class="inputInput" value="<?php echo $_POST['filterValue'];?>" size="50" /></td>
	</tr>
	<tr>
      <td class="contentButtonFooter" colspan="2" align="right">
      	<input name="filter" type="submit" class="inputButton" id="filter" value="Carian" />
	  </td>
  	</tr>
</table>
<br />
<?php $tg->showTableGrid();?>

*denotes unmatched lookup

<!--used for sorting-->
<input id="order" name="order" type="hidden" />
	
</form>
<?php }?>

<?php if($_POST['newCat']||$_POST['editCat']){unset($_GET['dataid']);?>
<!--reference category-->
<form id="form2" name="form2" method="post" action="<?php echo $action;?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
    <tr>
      <th colspan="2">Bina/Ubahsuai Rujukan </th>
    </tr>
    <?php if($_POST['editCat']){?>
	<tr>
      <td class="inputLabel" width="150" nowrap="nowrap">Id : </td>
      <td><input name="referenceID" type="text" class="inputInput" id="referenceID" value="<?php echo $container[0][strtoupper('referenceid')];?>" size="15" readonly="yes" />
      </td>
    </tr>
	<?php }?>
    <tr>
      <td class="inputLabel">Tajuk : </td>
      <td><input name="referenceTitle" type="text" class="inputInput" id="referenceTitle" value="<?php echo $container[0][strtoupper('referencetitle')];?>" size="70" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Nama :</td>
      <td><input name="referenceName" type="text" class="inputInput" id="referenceName" value="<?php echo $container[0][strtoupper('referencename')];?>" size="50" style="text-transform:uppercase;" /></td>
    </tr>
	<tr>
	  <td class="inputLabel">Status :</td>
	  <td>
          <select name="statusCode" class="inputList" id="statusCode">
            <?php 
			//if status not been set
			if(!isset($container[0][strtoupper('referencestatuscode')]))
				$container[0][strtoupper('referencestatuscode')]='00';		//set default
			
			echo createDropDown($statusList, $container[0][strtoupper('referencestatuscode')]);?>
		  </select>
	  </td>
	</tr>
    <tr>
      <td class="inputLabel"><strong>Kod Kumpulan  </strong></td>
      <td>
	  	<label onClick="swapItemDisplay('group|groupCodeUnique|groupCodeName|groupCodeDefaultValue|groupCodeLookupTable|groupCodeQuery','');
		disableLookup('no','groupCodeLookupTable','groupCodeQuery');">
		<input name="groupCode" type="radio" value="yes" <?php if($groupCode){?> checked="checked" <?php }?> />Ya 
		</label>
		<label onClick="swapItemDisplay('','group|groupCodeUnique|groupCodeName|groupCodeDefaultValue|groupCodeLookupTable|groupCodeQuery')">
		<input type="radio" name="groupCode" value="no" <?php if(!$groupCode){?> checked="checked" <?php }?> />Tidak
		</label>
	  </td>
    </tr>
    <!--group-->
    <tbody id="group" <?php if(!$groupCode){?> style="display:none"<?php }?>>
      <tr>
        <td class="inputLabel">Unik : </td>
        <td><label><input type="checkbox" name="groupCodeUnique" id="groupCodeUnique" value="1" <?php if($container[0][strtoupper('groupcodeunique')]){?> checked="checked"<?php }?> />Ya</label></td>
      </tr>
	  <tr >
        <td class="inputLabel">Nama : </td>
        <td><input name="groupCodeName" type="text" class="inputInput" id="groupCodeName" size="50" value="<?php echo $container[0][strtoupper('groupcodename')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Nilai 'Default' : </td>
        <td><input name="groupCodeDefaultValue" id="groupCodeDefaultValue" type="text" class="inputInput" size="30" value="<?php echo $container[0][strtoupper('groupcodedefaultvalue')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Lookup : </td>
        <td><label>
          <input name="groupCodeLookupType" id="groupCodeLookupType" type="radio" value="no" <?php if(!$container[0][strtoupper('groupcodelookuptable')]&&!$container[0][strtoupper('groupcodequery')]){?> checked="checked"<?php }?> onClick="disableLookup('no','groupCodeLookupTable','groupCodeQuery')" />
          Tiada Lookup</label>
            <label>
            <input type="radio" name="groupCodeLookupType" id="groupCodeLookupType" value="predefined" <?php if($container[0][strtoupper('groupcodelookuptable')]){?> checked="checked"<?php }?> onClick="disableLookup('predefined','groupCodeLookupTable','groupCodeQuery')" />
              Predefined</label>
            <label>
            <input type="radio" name="groupCodeLookupType" id="groupCodeLookupType" value="advanced" <?php if($container[0][strtoupper('groupcodequery')]){?> checked="checked"<?php }?> onClick="disableLookup('advanced','groupCodeLookupTable','groupCodeQuery')" />
              Advanced</label>        </td>
      </tr>
      <tr>
        <td class="inputLabel">Predefined Lookup : </td>
        <td><select name="groupCodeLookupTable" class="inputList" id="groupCodeLookupTable" <?php if(!$container[0][strtoupper('groupcodelookuptable')]){?> disabled="disabled"<?php }?>>
          <?php echo createDropDown($lookupTableList, $container[0][strtoupper('groupcodelookuptable')]);?>
        </select></td>
      </tr>
      <tr>
        <td class="inputLabel">Advanced Lookup : </td>
        <td><textarea name="groupCodeQuery" cols="100" rows="5" class="inputInput" id="groupCodeQuery" <?php if(!$container[0][strtoupper('groupcodequery')]){?> disabled="disabled"<?php }?> onFocus="placeQuote(this);" onBlur="replaceQuote(this)"><?php echo $container[0][strtoupper('groupcodequery')];?></textarea></td>
      </tr>
    </tbody>
    <!--eof group-->
    <tr>
      <td class="inputLabel"><strong>Kod : </strong></td>
      <td>
	  	<label onClick="swapItemDisplay('code|codeUnique|codeName|codeDefaultValue|codeLookupTable|codeQuery','');
		disableLookup('no','codeLookupTable','codeQuery');">
		<input name="referenceCode" type="radio" value="yes" <?php if($referenceCode){?> checked="checked" <?php }?> />Ya 
        </label>
        <label onClick="swapItemDisplay('','code|codeUnique|codeName|codeDefaultValue|codeLookupTable|codeQuery')">
		<input type="radio" name="referenceCode" value="no" <?php if(!$referenceCode){?> checked="checked" <?php }?> />Tidak
        </label>
	  </td>
    </tr>
	
	<!--code-->
	<tbody id="code" <?php if(!$referenceCode){?> style="display:none"<?php }?>>
    <tr>
        <td class="inputLabel">Unik : </td>
        <td><label><input type="checkbox" name="codeUnique" id="codeUnique" value="1" <?php if($container[0][strtoupper('codeunique')]){?> checked="checked"<?php }?> />Ya</label></td>
    </tr>
	<tr>
      <td class="inputLabel">Nama :</td>
      <td><input name="codeName" type="text" class="inputInput" id="codeName" size="50" value="<?php echo $container[0][strtoupper('codename')];?>" /></td>
    </tr>
	<tr>
        <td class="inputLabel">Nilai 'Default' : </td>
        <td><input name="codeDefaultValue" type="text" class="inputInput" id="codeDefaultValue" size="30" value="<?php echo $container[0][strtoupper('codedefaultvalue')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Lookup : </td>
        <td><label>
          <input name="codeLookupType" id="codeLookupType" type="radio" value="no" <?php if(!$container[0][strtoupper('codelookuptable')]&&!$container[0][strtoupper('codequery')]){?> checked="checked"<?php }?> onClick="disableLookup('no','codeLookupTable','codeQuery')" />
          Tiada Lookup</label>
		  <label>
		  <input type="radio" name="codeLookupType" id="codeLookupType" value="predefined" <?php if($container[0][strtoupper('codelookuptable')]){?> checked="checked"<?php }?> onClick="disableLookup('predefined','codeLookupTable','codeQuery')" />
		  Predefined</label>
		  <label>
		  <input type="radio" name="codeLookupType" id="codeLookupType" value="advanced" <?php if($container[0][strtoupper('codequery')]){?> checked="checked"<?php }?> onClick="disableLookup('advanced','codeLookupTable','codeQuery')" />
		  Advanced</label>
		</td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Predefined Lookup : </td>
        <td><select name="codeLookupTable" class="inputList" id="codeLookupTable" <?php if(!$container[0][strtoupper('codelookuptable')]){?> disabled="disabled"<?php }?>>
          <?php echo createDropDown($lookupTableList, $container[0][strtoupper('codelookuptable')]);?>
        </select></td>
      </tr>
      <tr>
        <td class="inputLabel">Advanced Lookup : </td>
        <td><textarea name="codeQuery" cols="100" rows="5" class="inputInput" id="codeQuery" <?php if(!$container[0][strtoupper('codequery')]){?> disabled="disabled"<?php }?> onBlur="replaceQuote(this)"><?php echo $container[0][strtoupper('codequery')];?></textarea></td>
      </tr>
	</tbody>
	<!--eof code-->
	
	<tr>
      <td class="inputLabel"><strong>Deskripsi 1 : </strong></td>
      <td>
	  	<label onClick="swapItemDisplay('description1|description1Unique|description1Name|description1DefaultValue|description1LookupTable|description1Query','');
		disableLookup('no','description1LookupTable','description1Query');">
		<input name="description1Code" type="radio" value="yes" <?php if($description1Code){?> checked="checked" <?php }?> />Ya 
        </label>
        <label onClick="swapItemDisplay('','description1|description1Unique|description1Name|description1DefaultValue|description1LookupTable|description1Query')">
		<input type="radio" name="description1Code" value="no" <?php if(!$description1Code){?> checked="checked" <?php }?> />Tidak
        </label>
	  </td>
    </tr>
	<!--description1-->
	<tbody id="description1" <?php if(!$description1Code){?> style="display:none"<?php }?>>
    <tr>
        <td class="inputLabel">Unik : </td>
        <td><label><input type="checkbox" name="description1Unique" id="description1Unique" value="1" <?php if($container[0][strtoupper('description1unique')]){?> checked="checked"<?php }?> />Ya</label></td>
    </tr>
	<tr>
      <td class="inputLabel">Nama :</td>
      <td><input name="description1Name" type="text" class="inputInput" id="description1Name" size="50" value="<?php echo $container[0][strtoupper('description1name')];?>" /></td>
    </tr>
	<tr>
        <td class="inputLabel">Nilai 'Default' : </td>
        <td><input name="description1DefaultValue" type="text" class="inputInput" id="description1DefaultValue" size="30" value="<?php echo $container[0][strtoupper('description1defaultvalue')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Lookup : </td>
        <td><label>
          <input name="description1LookupType" id="description1LookupType" type="radio" value="no" <?php if(!$container[0][strtoupper('description1lookuptable')]&&!$container[0][strtoupper('description1query')]){?> checked="checked"<?php }?> onClick="disableLookup('no','description1LookupTable','description1Query')" />
          Tiada Lookup</label>
		  <label>
		  <input type="radio" name="description1LookupType" id="description1LookupType" value="predefined" <?php if($container[0][strtoupper('description1lookuptable')]){?> checked="checked"<?php }?> onClick="disableLookup('predefined','description1LookupTable','description1Query')" />
		  Predefined</label>
		  <label>
		  <input type="radio" name="description1LookupType" id="description1LookupType" value="advanced" <?php if($container[0][strtoupper('description1query')]){?> checked="checked"<?php }?> onClick="disableLookup('advanced','description1LookupTable','description1Query')" />
		  Advanced</label>
		</td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Predefined Lookup : </td>
        <td><select name="description1LookupTable" class="inputList" id="description1LookupTable" <?php if(!$container[0][strtoupper('description1lookuptable')]){?> disabled="disabled"<?php }?>>
          <?php echo createDropDown($lookupTableList, $container[0][strtoupper('description1lookuptable')]);?>
        </select></td>
      </tr>
      <tr>
        <td class="inputLabel">Advanced Lookup : </td>
        <td><textarea name="description1Query" cols="100" rows="5" class="inputInput" id="description1Query" <?php if(!$container[0][strtoupper('description1query')]){?> disabled="disabled"<?php }?> onBlur="replaceQuote(this)"><?php echo $container[0][strtoupper('description1query')];?></textarea></td>
      </tr>
	</tbody>
	<!--eof description1-->
    <tr>
      <td class="inputLabel"><strong>Deskripsi 2 : </strong></td>
      <td>
	  	<label onClick="swapItemDisplay('description2|description2Unique|description2Name|description2DefaultValue|description2LookupTable|description2Query','');
			disableLookup('no','description2LookupTable','description2Query');">
        <input name="description2Code" type="radio" value="yes" <?php if($description2Code){?> checked="checked" <?php }?> />Ya
        </label>
        <label onClick="swapItemDisplay('','description2|description2Unique|description2Name|description2DefaultValue|description2LookupTable|description2Query')">
        <input type="radio" name="description2Code" value="no" <?php if(!$description2Code){?> checked="checked" <?php }?> />Tidak
		</label>
	  </td>
    </tr>
    <!--description2-->
    <tbody id="description2" <?php if(!$description2Code){?> style="display:none"<?php }?>>
      <tr>
        <td class="inputLabel">Unik : </td>
        <td><label><input type="checkbox" name="description2Unique" id="description2Unique" value="1" <?php if($container[0][strtoupper('description2unique')]){?> checked="checked"<?php }?> />Ya</label></td>
      </tr>
	  <tr>
        <td class="inputLabel"> Nama : </td>
        <td><input name="description2Name" type="text" class="inputInput" id="description2Name" size="50" value="<?php echo $container[0][strtoupper('description2name')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Nilai 'Default' : </td>
        <td><input name="description2DefaultValue" type="text" class="inputInput" id="description2DefaultValue" size="30" value="<?php echo $container[0][strtoupper('description2defaultvalue')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Lookup : </td>
        <td><label>
          <input name="description2LookupType" id="description2LookupType" type="radio" value="no" <?php if(!$container[0][strtoupper('description2lookuptable')]&&!$container[0][strtoupper('description2query')]){?> checked="checked"<?php }?> onClick="disableLookup('no','description2LookupTable','description2Query')" />
          Tiada Lookup</label>
            <label>
            <input type="radio" name="description2LookupType" id="description2LookupType" value="predefined" <?php if($container[0][strtoupper('description2lookuptable')]){?> checked="checked"<?php }?> onClick="disableLookup('predefined','description2LookupTable','description2Query')" />
              Predefined</label>
            <label>
            <input type="radio" name="description2LookupType" id="description2LookupType" value="advanced" <?php if($container[0][strtoupper('description2query')]){?> checked="checked"<?php }?> onClick="disableLookup('advanced','description2LookupTable','description2Query')" />
              Advanced</label>        </td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Predefined Lookup : </td>
        <td><select name="description2LookupTable" class="inputList" id="description2LookupTable" <?php if(!$container[0][strtoupper('description2lookuptable')]){?> disabled="disabled"<?php }?>>
          <?php echo createDropDown($lookupTableList, $container[0][strtoupper('description2lookuptable')]);?>
        </select></td>
      </tr>
      <tr>
        <td class="inputLabel">Advanced Lookup : </td>
        <td><textarea name="description2Query" cols="100" rows="5" class="inputInput" id="description2Query" <?php if(!$container[0][strtoupper('description2query')]){?> disabled="disabled"<?php }?> onBlur="replaceQuote(this)"><?php echo $container[0][strtoupper('description2query')];?></textarea></td>
      </tr>
    </tbody>
    <!--eof description2-->
    <tr>
      <td class="inputLabel"><strong>Kod Parent :</strong></td>
      <td>
	  	<label onClick="swapItemDisplay('parent|parentCodeUnique|parentCodeName|parentCodeDefaultValue|parentCodeLookupTable|parentCodeQuery','');
			disableLookup('no','parentCodeLookupTable','parentCodeQuery');">
        <input name="parentCode" type="radio" value="yes" <?php if($parentCode){?> checked="checked" <?php }?> />Ya 
        </label>
        <label onClick="swapItemDisplay('','parent|parentCodeUnique|parentCodeName|parentCodeDefaultValue|parentCodeLookupTable|parentCodeQuery')">
        <input type="radio" name="parentCode" value="no" <?php if(!$parentCode){?> checked="checked" <?php }?> />Tidak
        </label>
	  </td>
    </tr>
    <!--parent-->
    <tbody id="parent" <?php if(!$parentCode){?> style="display:none"<?php }?>>
      <tr>
        <td class="inputLabel">Unik : </td>
        <td><label><input type="checkbox" name="parentCodeUnique" id="parentCodeUnique" value="1" <?php if($container[0][strtoupper('parentcodeunique')]){?> checked="checked"<?php }?> />Ya</label></td>
      </tr>
	  <tr>
        <td class="inputLabel">Nama :</td>
        <td><input name="parentCodeName" type="text" class="inputInput" id="parentCodeName" size="50" value="<?php echo $container[0][strtoupper('parentcodename')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Nilai 'Default' : </td>
        <td><input name="parentCodeDefaultValue" type="text" class="inputInput" id="parentCodeDefaultValue" size="30" value="<?php echo $container[0][strtoupper('parentcodedefaultvalue')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Lookup : </td>
        <td>
			<label>
			<input name="parentCodeLookupType" id="parentCodeLookupType" type="radio" value="no" <?php if(!$container[0][strtoupper('parentcodelookuptable')]&&!$container[0][strtoupper('parentcodequery')]){?> checked="checked"<?php }?> onClick="disableLookup('no','parentCodeLookupTable','parentCodeQuery')" />
			Tiada Lookup</label>
			<label>
			<input type="radio" name="parentCodeLookupType" id="parentCodeLookupType" value="predefined" <?php if($container[0][strtoupper('parentcodelookuptable')]){?> checked="checked"<?php }?> onClick="disableLookup('predefined','parentCodeLookupTable','parentCodeQuery')" />
			Predefined</label>
			<label>
			<input type="radio" name="parentCodeLookupType" id="parentCodeLookupType" value="advanced" <?php if($container[0][strtoupper('parentcodequery')]){?> checked="checked"<?php }?> onClick="disableLookup('advanced','parentCodeLookupTable','parentCodeQuery')" />
			Advanced</label>
		</td>
      </tr>
      <tr>
        <td class="inputLabel">Predefined Lookup : </td>
        <td><select name="parentCodeLookupTable" class="inputList" id="parentCodeLookupTable" <?php if(!$container[0][strtoupper('parentcodelookuptable')]){?> disabled="disabled"<?php }?>>
          <?php echo createDropDown($lookupTableList, $container[0][strtoupper('parentcodelookuptable')]);?>
        </select></td>
      </tr>
      <tr>
        <td class="inputLabel">Advanced Lookup : </td>
        <td><textarea name="parentCodeQuery" cols="100" rows="5" class="inputInput" id="parentCodeQuery" <?php if(!$container[0][strtoupper('parentcodequery')]){?> disabled="disabled"<?php }?> onBlur="replaceQuote(this)"><?php echo $container[0][strtoupper('parentcodequery')];?></textarea></td>
      </tr>
    </tbody>
    <!--eof perent-->
    <tr>
      <td class="inputLabel"><strong>Kod Parent Root :</strong></td>
      <td>
	  	<label onClick="swapItemDisplay('parentroot|parentRootCodeUnique|parentRootCodeName|parentRootCodeDefaultValue|parentRootCodeLookupTable|parentRootCodeQuery','');
			disableLookup('no','parentRootCodeLookupTable','parentRootCodeQuery');">
        <input name="parentRootCode" type="radio" value="yes" <?php if($parentRootCode){?> checked="checked" <?php }?> />Ya
        </label>
        <label onClick="swapItemDisplay('','parentroot|parentRootCodeUnique|parentRootCodeName|parentRootCodeDefaultValue|parentRootCodeLookupTable|parentRootCodeQuery')">
        <input type="radio" name="parentRootCode" value="no" <?php if(!$parentRootCode){?> checked="checked" <?php }?> />Tidak
        </label>
	  </td>
    </tr>
    <!--parent root-->
    <tbody id="parentroot" <?php if(!$parentRootCode){?> style="display:none"<?php }?>>
      <tr>
        <td class="inputLabel">Unik : </td>
        <td><label><input type="checkbox" name="parentRootCodeUnique" id="parentRootCodeUnique" value="1" <?php if($container[0][strtoupper('parentrootcodeunique')]){?> checked="checked"<?php }?> />Ya</label></td>
      </tr>
	  <tr>
        <td class="inputLabel">Nama : </td>
        <td><input name="parentRootCodeName" type="text" class="inputInput" id="parentRootCodeName" size="50" value="<?php echo $container[0][strtoupper('parentrootcodename')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Default 'Nilai' : </td>
        <td><input name="parentRootCodeDefaultValue" type="text" class="inputInput" id="parentRootCodeDefaultValue" size="30" value="<?php echo $container[0][strtoupper('parentrootcodedefaultvalue')];?>" /></td>
      </tr>
      <tr>
        <td class="inputLabel">Lookup : </td>
        <td><label>
          <input name="parentRootCodeLookupType" id="parentRootCodeLookupType" type="radio" value="no" <?php if(!$container[0][strtoupper('parentrootcodelookuptable')]&&!$container[0][strtoupper('parentrootcodequery')]){?> checked="checked"<?php }?> onClick="disableLookup('no','parentRootCodeLookupTable','parentRootCodeQuery')" />
          Tiada Lookup</label>
            <label>
            <input type="radio" name="parentRootCodeLookupType" id="parentRootCodeLookupType" <?php if($container[0][strtoupper('parentrootcodelookuptable')]){?> checked="checked"<?php }?> value="predefined" onClick="disableLookup('predefined','parentRootCodeLookupTable','parentRootCodeQuery')" />
              Predefined</label>
            <label>
            <input type="radio" name="parentRootCodeLookupType" id="parentRootCodeLookupType" <?php if($container[0][strtoupper('parentrootcodequery')]){?> checked="checked"<?php }?> value="advanced" onClick="disableLookup('advanced','parentRootCodeLookupTable','parentRootCodeQuery')" />
              Advanced</label>        </td>
      </tr>
      <tr>
        <td class="inputLabel">Predefined Lookup : </td>
        <td><select name="parentRootCodeLookupTable" class="inputList" id="parentRootCodeLookupTable" <?php if(!$container[0][strtoupper('parentrootcodelookuptable')]){?> disabled="disabled"<?php }?>>
          <?php echo createDropDown($lookupTableList, $container[0][strtoupper('parentrootcodelookuptable')]);?>
        </select></td>
      </tr>
      <tr>
        <td class="inputLabel">Advanced Lookup : </td>
        <td><textarea name="parentRootCodeQuery" cols="100" rows="5" class="inputInput" id="parentRootCodeQuery" <?php if(!$container[0][strtoupper('parentrootcodequery')]){?> disabled="disabled"<?php }?> onBlur="replaceQuote(this)"><?php echo $container[0][strtoupper('parentrootcodequery')];?></textarea></td>
      </tr>
    </tbody>
    <!--eof parent root-->
	<tr>
      <td class="inputLabel">Senarai Akses : </td>
      <td><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center"><strong>Senarai Kumpulan Yang Tidak Dipilih
            </strong></div></td>
            <td>&nbsp;</td>
            <td><div align="center"><strong>Senarai Kumpulan Yang  Dipilih
            </strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="250"><select style="width:250px;" name="nonSelectedGroup" size="10" multiple class="inputList" id="nonSelectedGroup" >
                <?php for($x=0; $x < $groupListNonSelectedCount; $x++) { ?>
                <option value="<?php echo $groupListNonSelected[$x][0]?>" ><?php echo $groupListNonSelected[$x][1];?></option>
                <?php }?>
              </select></td>
            <td width="35"><div align="center">
                <input name="newMoveLTR" type="button" class="inputButton" id="newMoveLTR" value="&gt;" style="margin-bottom:2px;" onClick="moveoutid('nonSelectedGroup','selectedGroup'); " />
                <input name="newMoveRTL" type="button" class="inputButton" id="newMoveRTL" value="&lt;" style="margin-bottom:2px;"  onClick="moveinid('nonSelectedGroup','selectedGroup'); " />
                <br>
                <input name="newMoveAllLTR" type="button" class="inputButton" id="newMoveAllLTR" value="&gt;&gt;" style="margin-bottom:2px;" onClick="listBoxSelectall('nonSelectedGroup'); moveoutid('nonSelectedGroup','selectedGroup'); " />
                <input name="newMoveAllRTL" type="button" class="inputButton" id="newMoveAllRTL" value="&lt;&lt;" style="margin-bottom:2px;" onClick="listBoxSelectall('selectedGroup'); moveinid('nonSelectedGroup','selectedGroup'); " />
                <input name="newSort" type="button" class="inputButton" id="newSort" value="a-z" style="margin-bottom:2px;" onClick="sortListBox('selectedGroup');sortListBox('nonSelectedGroup')   " />
              </div></td>
            <td><select style="width:250px;" name="selectedGroup[]" size="10" multiple class="inputList" id="selectedGroup" >
                <?php for($x=0; $x < $groupListSelectedCount; $x++) { ?>
                <option value="<?php echo $groupListSelected[$x][0]?>" ><?php echo $groupListSelected[$x][1];?></option>
                <?php }?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
	<tbody style="display:none"> <!--hidden start here-->
    <tr>
      <td class="inputLabel"><strong>Permission Role :</strong></td>
      <td>
		
		<!--appendable field-->
        <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendRole">
		<?php for($x=0; $x<$sizeOfRoleCodeRows || $x==0; $x++){?>
          <tr>
            <td>
				<select name="RoleCode[]" class="inputList" id="RoleCode[]">
					<?php if($_POST['newCat'])$RoleCode[$x]='200000002'; echo createDropDown($RoleList, $RoleCode[$x]);?>
				</select>
					
				Jarak Data Dari
				<input name="DataRangeFrom[]" type="text" class="inputInput" id="DataRangeFrom[]" size="5" value="<?php echo $DataRangeFrom[$x];?>" />
				Hingga
				<input name="DataRangeTo[]" type="text" class="inputInput" id="DataRangeTo[]" size="5" value="<?php echo $DataRangeTo[$x];?>" />
			<?php if($x==0){?>
				<input name="addRole" type="button" class="inputButton" id="addRole" value="Tambah" onClick="addRoleField('appendRole', 'RoleCode[]', roleList)" />
			<?php }?>
			</td>
          </tr>
		<?php }?>
        </table>
        <!--eof appendable field-->
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Baru</td>
      <td><label><input name="ButtonCodeNew" type="radio" value="yes" <?php if($ButtonCodeNew){?> checked="checked"<?php }?> onClick="hideBlock('yes','buttonnew')" />
          Ya</label>
        <label><input type="radio" name="ButtonCodeNew" value="no" <?php if(!$ButtonCodeNew){?> checked="checked"<?php }?> onClick="hideBlock('no','buttonnew')" />
        Tidak</label>
		<!--buttonnew-->
		<div id="buttonnew" <?php if(!$ButtonCodeNew){?>style="display:none"<?php }?>>Nama :
		  <input name="ButtonNameNew" type="text" class="inputInput" id="ButtonNameNew" size="20" value="<?php echo $ButtonNameNew;?>" />
		  Tajuk :
		  <input name="ButtonTitleNew" type="text" class="inputInput" id="ButtonTitleNew" size="20" value="<?php echo $ButtonTitleNew;?>" />
		  
		  <!--appendable field-->
		  <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendNew">
		    <tr>
		      <td>
		        <?php for($x=0; $x<$sizeOfButtonRoleNewRows || $x==0; $x++){?>
		        <select name="ButtonRoleNew[]" class="inputList" id="ButtonRoleNew[]">
		          <?php echo createDropDown($RoleList, $ButtonRoleNew[$x]);?>
	            </select>
		        <?php }?>
		        
		        <input name="addButtonNew" type="button" class="inputButton" id="addButtonNew" value="Tambah" onClick="addDropDown('appendNew', 'ButtonRoleNew[]', roleList)" />			</td>
            </tr>
	      </table>
          <!--eof appendable field-->
	    </div><!--eof buttonnew-->
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Simpan</td>
      <td><label><input name="ButtonCodeSave" type="radio" value="yes" <?php if($ButtonCodeSave){?> checked="checked"<?php }?> onClick="hideBlock('yes','buttonsave')" />
          Ya</label>
        <label><input type="radio" name="ButtonCodeSave" value="no" <?php if(!$ButtonCodeSave){?> checked="checked"<?php }?> onClick="hideBlock('no','buttonsave')" />
        Tidak</label>
		
		<!--buttonsave-->
		<div id="buttonsave" <?php if(!$ButtonCodeSave){?>style="display:none"<?php }?>>Nama :
        <input name="ButtonNameSave" type="text" class="inputInput" id="ButtonNameSave" size="20" value="<?php echo $ButtonNameSave;?>" />
        Tajuk :
        <input name="ButtonTitleSave" type="text" class="inputInput" id="ButtonTitleSave" size="20" value="<?php echo $ButtonTitleSave;?>" />
		
        <!--appendable field-->
        <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendSave">
          <tr>
            <td>
				<?php for($x=0; $x<$sizeOfButtonRoleSaveRows || $x==0; $x++){?>
				<select name="ButtonRoleSave[]" class="inputList" id="ButtonRoleSave[]">
				  <?php echo createDropDown($RoleList, $ButtonRoleSave[$x]);?>
				</select>
				<?php }?>
				
				<input name="addButtonSave" type="button" class="inputButton" id="addButtonSave" value="Tambah" onClick="addDropDown('appendSave', 'ButtonRoleSave[]', roleList)" />			</td>
          </tr>
        </table>
        <!--eof appendable field-->
		</div>
		<!--eof buttonsave-->
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Ubah</td>
      <td><label><input name="ButtonCodeUpdate" type="radio" value="yes" <?php if($ButtonCodeUpdate){?> checked="checked"<?php }?> onClick="hideBlock('yes','buttonupdate')" />
          Ya</label>
        <label><input type="radio" name="ButtonCodeUpdate" value="no" <?php if(!$ButtonCodeUpdate){?> checked="checked"<?php }?> onClick="hideBlock('no','buttonupdate')" />
        Tidak</label>
		
		<!--buttonupdate-->
		<div id="buttonupdate" <?php if(!$ButtonCodeUpdate){?>style="display:none"<?php }?>>Nama :
		  <input name="ButtonNameUpdate" type="text" class="inputInput" id="ButtonNameUpdate" size="20" value="<?php echo $ButtonNameUpdate;?>" />
		  Tajuk :
		  <input name="ButtonTitleUpdate" type="text" class="inputInput" id="ButtonTitleUpdate" size="20" value="<?php echo $ButtonTitleUpdate;?>" />
		  
		  <!--appendable field-->
		  <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendUpdate">
		    <tr>
		      <td>
		        <?php for($x=0; $x<$sizeOfButtonRoleUpdateRows || $x==0; $x++){?>
		        <select name="ButtonRoleUpdate[]" class="inputList" id="ButtonRoleUpdate[]">
		          <?php echo createDropDown($RoleList, $ButtonRoleUpdate[$x]);?>
	            </select>
		        <?php }?>
		        
		        <input name="addButtonUpdate" type="button" class="inputButton" id="addButtonUpdate" value="Tambah" onClick="addDropDown('appendUpdate', 'ButtonRoleUpdate[]', roleList)" />			</td>
            </tr>
	      </table>
          <!--eof appendable field-->
	    </div><!--eof buttonupdate-->
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Padam</td>
      <td><label><input name="ButtonCodeDelete" type="radio" value="yes" <?php if($ButtonCodeDelete){?> checked="checked"<?php }?> onClick="hideBlock('yes','buttondelete')" />
          Ya</label>
        <label><input type="radio" name="ButtonCodeDelete" value="no" <?php if(!$ButtonCodeDelete){?> checked="checked"<?php }?> onClick="hideBlock('no','buttondelete')" />
        Tidak</label>
		
		<!--buttondelete-->
		<div id="buttondelete" <?php if(!$ButtonCodeDelete){?>style="display:none"<?php }?>>Nama :
		  <input name="ButtonNameDelete" type="text" class="inputInput" id="ButtonNameDelete" value="<?php echo $ButtonNameDelete;?>" size="20" />
		  Tajuk :
		  <input name="ButtonTitleDelete" type="text" class="inputInput" id="ButtonTitleDelete" size="20" value="<?php echo $ButtonTitleDelete;?>" />
		  
		  <!--appendable field-->
		  <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendDelete">
		    <tr>
		      <td>
		        <?php for($x=0; $x<$sizeOfButtonRoleDeleteRows || $x==0; $x++){?>
		        <select name="ButtonRoleDelete[]" class="inputList" id="ButtonRoleDelete[]">
		          <?php echo createDropDown($RoleList, $ButtonRoleDelete[$x]);?>
	            </select>
		        <?php }?>
		        
		        <input name="addButtonDelete" type="button" class="inputButton" id="addButtonDelete" value="Tambah" onClick="addDropDown('appendDelete', 'ButtonRoleDelete[]', roleList)" />			</td>
            </tr>
	      </table>
          <!--eof appendable field-->
	    </div><!--eof buttondelete-->
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Batal</td>
      <td><label><input name="ButtonCodeCancel" type="radio" value="yes" <?php if($ButtonCodeCancel){?> checked="checked"<?php }?> onClick="hideBlock('yes','buttoncancel')" />
          Ya</label>
        <label><input type="radio" name="ButtonCodeCancel" value="" <?php if(!$ButtonCodeCancel){?> checked="checked"<?php }?> onClick="hideBlock('no','buttoncancel')" />
        Tidak</label>
		
		<!--buttoncancel-->
		<div id="buttoncancel" <?php if(!$ButtonCodeCancel){?>style="display:none"<?php }?>>Nama :
		  <input name="ButtonNameCancel" type="text" class="inputInput" id="ButtonNameCancel" size="20" value="<?php echo $ButtonNameCancel;?>" />
		  Tajuk :
		  <input name="ButtonTitleCancel" type="text" class="inputInput" id="ButtonTitleCancel" size="20" value="<?php echo $ButtonTitleCancel;?>" />
		  
		  <!--appendable field-->
		  <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendCancel">
		    <tr>
		      <td>
		        <?php for($x=0; $x<$sizeOfButtonRoleCancelRows || $x==0; $x++){?>
		        <select name="ButtonRoleCancel[]" class="inputList" id="ButtonRoleCancel[]">
		          <?php echo createDropDown($RoleList, $ButtonRoleCancel[$x]);?>
	            </select>
		        <?php }?>
		        
		        <input name="addButtonCancel" type="button" class="inputButton" id="addButtonCancel" value="Tambah" onClick="addDropDown('appendCancel', 'ButtonRoleCancel[]', roleList)" />			</td>
            </tr>
	      </table>
          <!--eof appendable field-->
	    </div><!--eof buttoncancel-->
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Cetak</td>
      <td><label><input name="ButtonCodePrint" type="radio" value="<?php echo $ButtonCodePrint;?>" <?php if($ButtonCodePrint){?> checked="checked"<?php }?> onClick="hideBlock('yes','buttonprint')" />
          Ya</label>
        <label><input type="radio" name="ButtonCodePrint" value="no" <?php if(!$ButtonCodePrint){?> checked="checked"<?php }?> onClick="hideBlock('no','buttonprint')" />
        Tidak</label>
		
		<!--buttonprint-->
		<div id="buttonprint" <?php if(!$ButtonCodePrint){?>style="display:none"<?php }?>>
		Nama :
          <input name="ButtonNamePrint" type="text" class="inputInput" id="ButtonNamePrint" size="20" value="<?php echo $ButtonNamePrint;?>" />
        Tajuk : 
        <input name="ButtonTitlePrint" type="text" class="inputInput" id="ButtonTitlePrint" size="20" value="<?php echo $ButtonTitlePrint;?>" />
		
        <!--appendable field-->
        <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendPrint">
          <tr>
            <td>
				<?php for($x=0; $x<$sizeOfButtonRolePrintRows || $x==0; $x++){?>
				<select name="ButtonRolePrint[]" class="inputList" id="ButtonRolePrint[]">
				  <?php echo createDropDown($RoleList, $ButtonRolePrint[$x]);?>
				</select>
				<?php }?>
				
				<input name="addButtonPrint" type="button" class="inputButton" id="addButtonPrint" value="Tambah" onClick="addDropDown('appendPrint', 'ButtonRolePrint[]', roleList)" />			</td>
          </tr>
        </table>
        <!--eof appendable field-->
		</div>
		<!--eof buttonprint-->
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Reset</td>
      <td><label><input name="ButtonCodeReset" type="radio" value="yes" <?php if($ButtonCodeReset){?> checked="checked"<?php }?> onClick="hideBlock('yes','buttonreset')" />
          Ya</label>
        <label><input type="radio" name="ButtonCodeReset" value="no" <?php if(!$ButtonCodeReset){?> checked="checked"<?php }?> onClick="hideBlock('no','buttonreset')" />
        Tidak</label>
		
		<!--buttonreset-->
		<div id="buttonreset" <?php if(!$ButtonCodeReset){?> style="display:none"<?php }?>>
		Nama:
        <input name="ButtonNameReset" type="text" class="inputInput" id="ButtonNameReset" size="20" value="<?php echo $ButtonNameReset;?>" />
        Tajuk
        <input name="ButtonTitleReset" type="text" class="inputInput" id="ButtonTitleReset" size="20" value="<?php echo $ButtonTitleReset;?>" />
				
        <!--appendable field-->
        <table width="100%" border="0" cellspacing="0" cellpadding="2" id="appendReset">
          <tr>
            <td>
				<?php for($x=0; $x<$sizeOfButtonRoleResetRows || $x==0; $x++){?>
				<select name="ButtonRoleReset[]" class="inputList" id="ButtonRoleReset[]">
				  <?php echo createDropDown($RoleList, $ButtonRoleReset[$x]);?>
				</select>
				<?php }?>
				
				<input name="addButtonReset" type="button" class="inputButton" id="addButtonReset" value="Add" onClick="addDropDown('appendReset', 'ButtonRoleReset[]', roleList)" />			</td>
          </tr>
        </table>
        <!--eof appendable field-->
		</div>
		<!--eof buttonreset-->
	  </td>
    </tr>
	</tbody> <!--hidden end here-->
    <tr>
      <td class="contentButtonFooter" align="right" colspan="2">
        <input name="referenceID" type="hidden" id="referenceID" value="<?php echo $container[0][strtoupper('referenceid')];?>" />
        <input name="<?php if($_POST['editCat']) echo 'saveEditCat';else echo 'saveNewCat';?>" type="submit" class="inputButton" id="<?php if($_POST['editCat']) echo 'saveEditCat';else echo 'saveNewCat';?>" value="Simpan" onClick="listBoxSelectall('selectedGroup'); if(havValue(document.getElementById('referenceName').value,document.getElementById('referenceTitle').value))return true; else {alert('Tajuk dan Nama Rujukan adalah wajib');return false}"/>
        <input name="cancel" type="submit" class="inputButton" id="cancel" value="Batal" />
      </td>
    </tr>
  </table>
</form>
<!--eof reference category-->
<?php }//eof manipulation of data?>

<?php if($_POST['newData']||$_GET['dataid']){?>
<!--reference data-->
<form id="form3" name="form3" method="post" action="<?php echo $action;?>">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2">Data Rujukan</th>
  </tr>
  <?php if($_GET['dataid']&&$userType==1) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][0];?></td>
    <td><input name="dataID" type="text" class="inputInput" id="dataID" value="<?php echo $data[0][0];?>" size="15" readonly="yes" /></td>
  </tr>
  <?php }?>
  <?php if($data['Name'][1]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][1]; ?> : </td>
    <td>
    <?php if(is_array($groupCodeList)){?>
		<select name="groupCode" class="inputList" id="groupCode" <?php if($userType==3){?> disabled="disabled" style="color:#000000; background-color: #FFFFFF;" <?php }?> />
		<?php echo createDropDown($groupCodeList,$data[0][1]);?>
		</select>
	<?php }else {?>
		<input name="groupCode" type="text" class="inputList" id="groupCode" value="<?php echo $data[0][1];?>" <?php if($userType==3){?> readonly <?php }?>/>
	<?php }?>
  	</td>
  </tr>
  <?php }?>
  <?php if($data['Name'][2]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][2]; ?> : </td>
	<td>
    <?php if(is_array($codeList)){?>
		<select name="referenceCode" class="inputList" id="referenceCode" <?php if($userType==3){?> disabled="disabled" style="color:#000000; background-color: #FFFFFF;" <?php }?> />
		<?php echo createDropDown($codeList,$data[0][2]);?>
		</select>
	<?php }else {?>
		<input name="referenceCode" type="text" class="inputList" id="referenceCode" value="<?php echo $data[0][2];?>" <?php if($userType==3){?> readonly <?php }?> />
	<?php }?>
  </tr>
  <?php }?>
  <?php if($data['Name'][3]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][3]; ?> :</td>
    <td>
    <?php if(is_array($description1List)){?>
		<select name="description1" class="inputList" id="description1" <?php if($userType==3){?> disabled="disabled" style="color:#000000; background-color: #FFFFFF;" <?php }?> />
		<?php echo createDropDown($description1List,$data[0][3]);?>
		</select>
	<?php }else {?>
		<input name="description1" type="text" size="50" class="inputList" id="description1" value="<?php echo $data[0][3];?>" <?php if($userType==3){?> readonly <?php }?> />
	<?php }?>
  	</td>
  </tr>
  <?php }?>
  <?php if($data['Name'][4]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][4]; ?> : </td>
    <td>
    <?php if(is_array($description2List)){?>
		<select name="description2" class="inputList" id="description2" <?php if($userType==3){?> disabled="disabled" style="color:#000000; background-color: #FFFFFF;" <?php }?> />
		<?php echo createDropDown($description2List,$data[0][4]);?>
		</select>
	<?php }else {?>
		<input name="description2" type="text" size="50" class="inputList" id="description2" value="<?php echo $data[0][4];?>" <?php if($userType==3){?> readonly <?php }?> />
	<?php }?>
  	</td>
  </tr>
  <?php }?>
  <?php if($data['Name'][5]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][5]; ?> : </td>
    <td>
    <?php if(is_array($parentCodeList)){?>
		<select name="parentCode" class="inputList" id="parentCode" <?php if($userType==3){?> disabled="disabled" style="color:#000000; background-color: #FFFFFF;" <?php }?> />
		<?php echo createDropDown($parentCodeList,$data[0][5]);?>
		</select>
	<?php }else {?>
		<input name="parentCode" type="text" class="inputList" id="parentCode" value="<?php echo $data[0][5];?>" <?php if($userType==3){?> readonly <?php }?> />
	<?php }?>
  	</td>
  </tr>
  <?php }?>
  <?php if($data['Name'][6]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][6]; ?> : </td>
    <td>
    <?php if(is_array($parentRootCodeList)){?>
		<select name="parentRootCode" class="inputList" id="parentRootCode" <?php if($userType==3){?> disabled="disabled" style="color:#000000; background-color: #FFFFFF;" <?php }?> />
		<?php echo createDropDown($parentRootCodeList,$data[0][6]);?>
		</select>
	<?php }else {?>
		<input name="parentRootCode" type="text" class="inputList"  id="parentRootCode" value="<?php echo $data[0][6];?>" <?php if($userType==3){?> readonly <?php }?> />
	<?php }?>
  	</td>
  </tr>
  <?php }?>
  <?php if(!$_POST['newData'] && $userType !=3 && $data['Name'][7]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][7]; ?> :</td>
    <td><input name="timestamp" type="text" class="inputInput" id="timestamp" value="<?php echo $data[0][7];?>" size="15" readonly="yes" /></td>
  </tr>
  <?php }?>
  <?php if($userType !=3 && $data['Name'][8]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][8]; ?> :</td>
    <td><select name="statusCode" class="inputList" id="statusCode">
		<?php
		//if status not been set
		if(!isset($data[0][8]))
			$data[0][8]='00';	//set default
			
		echo createDropDown($statusList,$data[0][8]);
		?>
      </select>
	</td>
  </tr>
  <?php }?>
  <?php if(!$_POST['newData'] && $userType !=3 && $data['Name'][9]) {?>
  <tr>
    <td class="inputLabel"><?php echo $data['Name'][9]; ?> :</td>
    <td><input name="userName" type="text" class="inputInput" id="userName" value="<?php echo $data[0][9]; ?>" size="15" readonly="yes" /></td>
  </tr>
  <?php }?>
  <tr>
    <td class="contentButtonFooter" colspan="2" align="right">
	<?php if($userType!=3){?>
        <input name="<?php if($_POST['newData']) echo 'saveNewData';else echo 'saveEditData';?>" type="submit" class="inputButton" id="<?php if($_POST['newData']) echo 'saveNewData';else echo 'saveEditData';?>" value="Simpan" />
	<?php }?>
        <input name="cancel" type="submit" class="inputButton" id="cancel" value="Batal" />
		<input name="referenceID" type="hidden" id="referenceID" value="<?php echo $_POST['referenceID'];?>" />
		<input name="dataID" type="hidden" class="inputInput" id="dataID" value="<?php echo $data[0][0];?>" />
    </td>
  </tr>
</table>
</form>
<!--eof reference data-->
<?php }?>