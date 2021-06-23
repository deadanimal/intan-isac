<!--GENERATE TABULAR-->
<?php
//print_r($_POST);
//=====this part for footer
//loop on count of item
for($a=0; $a <$countItem; $a++)
{	
	//if item type hidden, skip
	if($itemsArr[$a]['ITEMTYPE'] == 'hidden')
		continue;

	//if item have aggregation
	if($itemsArr[$a]['ITEMAGGREGATECOLUMN'] || $itemsArr[$a]['ITEMAGGREGATECOLUMNLABEL'])
	{
		//name of aggregation field (in array form)
		$inputFieldName[$a] = 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArr[$a]["ITEMID"].'[]';
		$aggFieldName[$a] = 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArr[$a]["ITEMID"].'_'.$itemsArr[$a]['ITEMAGGREGATECOLUMN'];
		
		//if aggregation have label
		if($itemsArr[$a]['ITEMAGGREGATECOLUMNLABEL'])
			$aggLabel[$a]='<b>'.$itemsArr[$a]['ITEMAGGREGATECOLUMNLABEL'].'</b><br>';
		
		$aggArr[$a]=$aggLabel[$a].
					'<input class="inputInput" name="'.$aggFieldName[$a].'" id="'.$aggFieldName[$a].'" type="text" value="'.$aggArr[$a].'" style="background-color:#F2F2F2; width:93%; text-align:'.$itemsArr[$a]['ITEMTEXTALIGN'].';" />';
		
		//javascript for item (onblur)
		$itemsArr[$a]["ITEMJAVASCRIPTEVENT"]='1';		//event code for 'onblur'
		$itemsArr[$a]["ITEMJAVASCRIPT"]='aggregateColumn(\''.$itemsArr[$a]['ITEMAGGREGATECOLUMN'].'\',this,\''.$aggFieldName[$a].'\');'.$itemsArr[$a]["ITEMJAVASCRIPT"];
		
		$btnDelRowJs.='aggregateColumn(\''.$itemsArr[$a]['ITEMAGGREGATECOLUMN'].'\',\''.$inputFieldName[$a].'\',\''.$aggFieldName[$a].'\');';
		
		$showFooter=true;	//set footer is true
	}//eof if have aggregation
	
	//if item have check all
	else if($itemsArr[$a]['ITEMCHECKALL'])
	{
		//name of checkbox (in array form)
		$chkBoxName = 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArr[$a]["ITEMID"].'[]';
		
		//checkbox to trigger check all (same name but have 'all_' in front)
		$aggArr[$a]='<input name="all_'.$chkBoxName.'" id="all_'.$chkBoxName.'" type="checkbox" value="" onclick="itemCheckAll(\''.$chkBoxName.'\')" />';
		
		?>
		<script language="javascript">
		//to set all checkbox as check or not
		function itemCheckAll(itemname)
		{
			//if have array of items by name
			if(document.getElementsByName(itemname).length>0)
			{
				//get array of items by name
				var itemArr=document.getElementsByName(itemname);
				
				//if triggered as check
				if(document.getElementById('all_'+itemname).checked==true)
					checkFlag=true		//set as check
				else
					checkFlag=false		//set as uncheck
				
				//loop on array of checkbox with same name
				for(x=0;x<itemArr.length;x++)
					itemArr[x].checked=checkFlag
			}
		}//eof function
		</script>
		
		<?php
		$showFooter=true;	//set footer is true
	}//eof if have check all
	
	else
		$aggArr[$a]='';
}//eof for
//=====eof part for footer

//get default row number
if($componentArr[$x]['COMPONENTABULARDEFAULTROWNO']=='')
	$componentArr[$x]['COMPONENTABULARDEFAULTROWNO']=5;		//set  default as 5

//if preprocess is select
if($componentArr[$x]['COMPONENTPREPROCESS'] == 'select')
{
	//count row of data
	$getDataRsCount=count($getDataRs);
	
	//if no data
	if($getDataRsCount==0)
		$componentArr[$x]['COMPONENTABULARDEFAULTROWNO']=0;		//set row as0 if no data
	
	//if data rows is less than default row number
	else if($getDataRsCount>$componentArr[$x]['COMPONENTABULARDEFAULTROWNO'])
		$componentArr[$x]['COMPONENTABULARDEFAULTROWNO']=$getDataRsCount;		//set row number based of query rows
}//eof if preprocess is select

//number of data
$dataCount = $componentArr[$x]['COMPONENTABULARDEFAULTROWNO'];

//if select && addrow
if($componentArr[$x]['COMPONENTADDROW'] && $componentArr[$x]['COMPONENTPREPROCESS'] == 'select')
	$dataCount++;

//loop on number of default row
for($ff=0; $ff < $dataCount; $ff++)
{
	//loop on number of items
	for($a=0; $a < $countItem; $a++) 
	{		
		//if item default value is not set, check if bind to database columns and pre process is select
		if($itemsArr[$a]["ITEMDEFAULTVALUE"] == '' && $componentArr[$x]['COMPONENTPREPROCESS'] == 'select')
		{
			//for all items
			for($g=0; $g < $countGetMappedItem; $g++)
			{	
				//if input name is in getMappedItem array, get mapping id
				if($getMappedItem[$g]['COMPONENTIDNAME'] == 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArr[$a]["ITEMID"])
				{
					//for column to find, find value in getDataRs
					$columnValueToFind = $getMappedItem[$g]['MAPPINGID'];
					
					//set the value to default variable
					$default = $getDataRs[$ff][$columnValueToFind];
				}//end if
			}//end for g
		}//end if
		
		//else, use the default value
		else
			$default = $itemsArr[$a]["ITEMDEFAULTVALUE"];
		
		//build the input, convert input into array type, then put into array as data for tabular
		$temp=convertInputIntoArray($itemsArr[$a]["ITEMTYPE"],buildInput($myQuery,$dbc,$itemsArr[$a]["ITEMINPUTLENGTH"],
										$itemsArr[$a]["ITEMTYPE"],$default,$itemsArr[$a]["ITEMDEFAULTVALUEQUERY"],$itemsArr[$a]["ITEMLOOKUP"],$itemsArr[$a]["ITEMLOOKUPSECONDARY"],
										$itemsArr[$a]["ITEMID"],$itemsArr[$a]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],$preScript[0][$columnName],
										$itemsArr[$a]["ITEMJAVASCRIPTEVENT"],$itemsArr[$a]["ITEMJAVASCRIPT"],$itemsArr[$a]["ITEMNAME"],
										$itemsArr[$a]["ITEMTABINDEX"],$itemsArr[$a]["ITEMID"],$itemsArr[$a]["ITEMMINCHAR"],$itemsArr[$a]["ITEMMAXCHAR"],
										$itemsArr[$a]["ITEMTEXTAREAROWS"],$itemsArr[$a]["ITEMREQUIRED"],$componentArr[$x]['COMPONENTID'],($ff),
										$itemsArr[$a]['ITEMTEXTALIGN'],$itemsArr[$a]['ITEMUPPERCASE'],$itemsArr[$a]['ITEMDISABLED'],$itemsArr[$a]['ITEMREADONLY']),($ff)); 
		
		//if item type not hidden
		if($itemsArr[$a]['ITEMTYPE'] != 'hidden')
		{
			if(!$itemsArr[$a]["ITEMAPPENDTOBEFORE"])
				$data[$ff][$itemsArr[$a]['ITEMNAME']] = $temp.' '.$itemsArr[$a]['ITEMNOTES'];		//insert temp data into data array
			else
				$data[$ff][$itemsArr[$a-1]['ITEMNAME']] .=  ' '.$itemsArr[$a]['ITEMNAME'].' '.$temp.' '.$itemsArr[$a]['ITEMNOTES'];		//append into data array before
		}//eof if
		else
		{
			//if array for hidden not created yet
			if(!is_array($hiddenData))
				$hiddenData[$ff] = $temp;	//append temp data into previous data array
			else
				$hiddenData[$ff] .= $temp;	//insert temp data into next data array
		}//eof else
	}//eof for loop item
}//eof for loop data row

//loop on count of data
for($ax=0; $ax<$dataCount; $ax++)
{
	//if have hidden data
	if(is_array($hiddenData))
	{
		$tempKeys = array_keys($data[$ax]);
		$data[$ax][$tempKeys[0]] .= $hiddenData[$ax];
	}//eof if
}//eof for

//count data
$colspan=count($data[0]);	//count data column
$tg->setHeaderAttribute('colspan',$colspan);	//set colspan for header

//if hav data
if($dataCount>0)
{
	//if component add row is true or component preprocess is not select
	if($componentArr[$x]['COMPONENTADDROW']/* && $componentArr[$x]['COMPONENTPREPROCESS'] != 'select'*/)
	{
		
		//-------------------
		//KLN SPECIFIC BLOCK
		//-------------------
		//get menu root
		$getMenuRoot = $myQuery->query('select MENUROOT from FLC_MENU where MENUID = '.$_GET['menuID'],'SELECT','NAME');
		$menuRoot = $getMenuRoot[0]['MENUROOT'];
		
		//get menu root name
		$getMenuRootName = $myQuery->query('select MENUNAME from FLC_MENU where MENUID = '.$menuRoot,'SELECT','NAME');
		$menuRootName = $getMenuRootName[0]['MENUNAME'];
		
		//if parent menu is candidature
		if(ereg($menuRootName,'CIS'))
		{
			$tg->setAddRowValue(ADD_ROW_ENGLISH);
			$tg->setDelRowValue(DELETE_ROW_ENGLISH);
		}
		else
		{
			$tg->setAddRowValue(ADD_ROW);
			$tg->setDelRowValue(DELETE_ROW);
		}	
		//----------------------
		//END KLN SPECIFIC BLOCK
		//-----------------------	
		
		//status and type
		if($componentArr[$x]['COMPONENTADDROW'])
			{$tg->setAddRowStatus(true);$tg->setAddRowType('js');}
		if($componentArr[$x]['COMPONENTDELETEROW'])
			{$tg->setDelRowStatus(true);}
		
		//id
		$tg->setAddRowId('addrow_'.$componentArr[$x]['COMPONENTID']);
		$tg->setDelRowId('deleterow_'.$componentArr[$x]['COMPONENTID']);
		
		//enable/disable
		$tg->setAddRowDisabled($componentArr[$x]['COMPONENTADDROWDISABLED']);
		$tg->setDelRowDisabled($componentArr[$x]['COMPONENTDELETEROWDISABLED']);
		
		$tg->addDelRowJs('onclick', $btnDelRowJs);
		
		//add javascript for add row
		if($componentArr[$x]['COMPONENTADDROWJAVASCRIPT'])
			$tg->addAddRowJs('onclick', convertDBSafeToQuery(convertToDBQry($componentArr[$x]['COMPONENTADDROWJAVASCRIPT'])));
		
		//add javascipt for delete row
		if($componentArr[$x]['COMPONENTDELETEROWJAVASCRIPT'])
			$tg->addDelRowJs('onclick', convertDBSafeToQuery(convertToDBQry($componentArr[$x]['COMPONENTDELETEROWJAVASCRIPT'])));
	}
	
	//if footer true
	if($showFooter)
	{
		$tg->setFooterAttribute('class','listingContent');		//set footer attribute
		$tg->setFooter($aggArr);								//set the data of footer
	}//eof if
	
	$tg->setAddRowCount(ADD_ROW_COUNT);
	$tg->setAddRowClass('inputButton');
	$tg->setDelRowClass('inputButton');
	$tg->setTableGridData($data);		//show tabular with the input
}//eof if
else
{
	//-------------------
	//KLN SPECIFIC BLOCK
	//-------------------
	//get menu root
	$getMenuRoot = $myQuery->query('select MENUROOT from FLC_MENU where MENUID = '.$_GET['menuID'],'SELECT','NAME');
	$menuRoot = $getMenuRoot[0]['MENUROOT'];
	
	//get menu root name
	$getMenuRootName = $myQuery->query('select MENUNAME from FLC_MENU where MENUID = '.$menuRoot,'SELECT','NAME');
	$menuRootName = $getMenuRootName[0]['MENUNAME'];
	
	//if parent menu is candidature
	if(!ereg($menuRootName,'CIS'))
	{
		$tg->setTableGridData('No Data');
	}
	else
	{
		$tg->setTableGridData('Tiada Rekod');
	}	
	//-----------------------
	//END KLN SPECIFIC BLOCK
	//-----------------------	
}//eof else

$tg->showTableGrid();
?>
<?php
//if theres page control associated with the component
if($controlArrCount > 0)
{ 
	for($y=0;$y<$controlArrCount;$y++)
	{$controlid[] = $controlArr[$y][0];}?>
<table id="tableContent" width="100%" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td class="contentButtonFooter" align="right"><?php buildControl($myQuery,$controlid,$requiredArr);?></td>
</tr>
</table>
<?php }?>


<?php //loop on count of item
for($a=0; $a <$countItem; $a++){
if($inputFieldName[$a] && $aggFieldName[$a]){?>
<script language="javascript">
aggregateColumn('<?php echo $itemsArr[$a]['ITEMAGGREGATECOLUMN'];?>','<?php echo $inputFieldName[$a];?>','<?php echo $aggFieldName[$a];?>')
</script>
<?php }}?>
  <!--EOF GENERATE TABULAR-->