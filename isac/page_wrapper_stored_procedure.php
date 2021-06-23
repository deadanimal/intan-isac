<?php
/*=========  CURRENTLY SUPPORT 1 STORED PROCEDURE PER PAGE ONLY ==============*/

//print_r($_POST);
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
	
		//get component items info
		$getItemInfo = "select * from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = ".$key;
		$getItemInfoRs = $myQuery->query($getItemInfo,'SELECT','NAME');
		
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
			
			//convert to uppercase
			if($valItem['ITEMUPPERCASE'])
				$_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]=strtoupper($_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']]);
		}//eof foreach
		
		//if stored_procedure
		if($getComponentInfoRs[0]['COMPONENTBINDINGTYPE']=='stored_procedure')
		{
			//get argument name and position from stored procedure
			$argumentPositionRs = $mySQL->listProcedureParameter($getComponentInfoRs[0]['COMPONENTBINDINGSOURCE'],'IN');
			$argumentPositionRsCount=count($argumentPositionRs);
			//$inParameter=array_fill(0,$argumentPositionRsCount,null);	//set initial values of all index in array size as null
			
			//loop and re-set value to assign into stored_procedure
			foreach($getItemInfoRs as $keyItem => $valItem)
			{
				//---------- check if item returned is FILES or not ----------
				if(is_uploaded_file($_FILES[$elemNamePrefix.$key."_".$valItem['ITEMID']]['tmp_name']))
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
				}//eof if
				
				//loop on size of argument
				for($x=0;$x<$argumentPositionRsCount;$x++)
					if($argumentPositionRs[$x]['COLUMN_NAME']==$valItem['MAPPINGID'])		//check argument mapping
						if($argumentPositionRs[$x]['IN_OUT']=='IN')
							$inParameter[$argumentPositionRs[$x]['POSITION']-1] = $_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']];	//set inParameter by argument's position
						//else
							//$outParameter[$argumentPositionRs[$x]['POSITION']-1] = $_POST[$elemNamePrefix.$key."_".$valItem['ITEMID']];	//set inParameter by argument's position
			}//eof foreach
			
			//get argument name and position from stored procedure
			$argumentOutRs = $mySQL->listProcedureParameter($getComponentInfoRs[0]['COMPONENTBINDINGSOURCE'],'OUT');
			$argumentOutRsCount=count($argumentOutRs);
			
			if($argumentOutRsCount>0)
			{
				for($y=0;$y<$argumentOutRsCount;$y++)
					$outParameter[$y]=$y;
			}//eof if
			
			//stored procedure name
			$spName = $getComponentInfoRs[0]['COMPONENTBINDINGSOURCE'];		
		}//eof if
	}//eof foreach
}//eof if

//test
for($x=0;$x<$argumentPositionRsCount;$x++)
	if(!$inParameter[$argumentPositionRs[$x]['POSITION']-1])
		$inParameter[$argumentPositionRs[$x]['POSITION']-1]='';

//check if parameter in array
if(is_array($inParameter))
	ksort($inParameter);
if(is_array($outParameter))
	ksort($outParameter);

//execute stored procedure
if($spName)
{
	//CHECK BACKGROUND PROCESS
	//get control type
	$postKey = array_keys($_POST);
	$postKeyCount = count($postKey);		//count post item
	
	//loop on count of post
	for($y=0;$y<$postKeyCount;$y++)
	{
		if(eregi('input_map_',$postKey[$y]))									//check input_map_
		{
			$theComponent = eregi_replace('input_map_','',$postKey[$y]);
			$tempComponent = explode('_',$theComponent);						//split component and item id
			$theComponent = $tempComponent[0];									//get component id
		}
		
		else if(eregi('control_',$postKey[$y]))								//check control_
			$theControl = eregi_replace('control_','',$postKey[$y]);			//get control type
	}//eof for
	
	//get bg process
	$spProcess = "select controlspbgprocess
					from FLC_PAGE_CONTROL 
					where controltype = '".$theControl."' and
					pageid in (select pageid 
									from FLC_PAGE_COMPONENT 
									where componentid='".$theComponent."')";
	$spProcessRs = $myQuery->query($spProcess,'SELECT');
	
	//=== START BG PROCESS
	if($spProcessRs[0][0])
	{
		echo $sendSP = $myQuery->stored_procedure_statement(array('inParm' => $inParameter, 'outParm' => $outParameter),$spName);
		
		//temporary SP file (for exec)
		$tempSPFile='tempSPFile.sql';
		
		//create new sql file
		file_put_contents($tempSPFile,$sendSP."\n/\nexit");	//create file
		pclose(popen('start sqlplus '.DB_USERNAME.'/'.DB_PASSWORD.'@'.DB_DATABASE.' @'.$tempSPFile, "r")); 		//execute with external program (sqlplus)
		
	}//=== EOF BG PROCESS
	
	else
	{
		$spRs=$myQuery->stored_procedure(array('inParm'=>$inParameter,'outParm'=>$outParameter),$spName);
		$spRsCount=count($spRs);	//count out parameter
	
		//if count have value
		if($spRsCount>0)
		{
			//loop on count of sp result
			for($y=0;$y<$spRsCount;$y++)
			{
				$tempSP=$spName.'_out_'.($y+1);		//variable name for sp out parameter
				$$tempSP=$spRs[$y];					//value of variable
			}//eof for
		}//eof if sp count
	}//eof else
}//eof if sp
?>