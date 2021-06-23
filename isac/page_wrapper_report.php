<?php
$mySQL = new dbSQL($dbc);

//append sql for filtering
if($sqlToAppend)
{
	/*if(!$componentArr[$x]['COMPONENTQUERYUNLIMITED'])
		$sqlToAppend .= $mySQL->limit(DEFAULT_QUERY_LIMIT,' and ');*/
	
	$componentArr[$x]['COMPONENTTYPEQUERY'] = 'select * from ('.$componentArr[$x]['COMPONENTTYPEQUERY'].') a '.$sqlToAppend;
	
	if(!$componentArr[$x]['COMPONENTQUERYUNLIMITED'])
		$componentArr[$x]['COMPONENTTYPEQUERY'] .= $mySQL->limit(DEFAULT_QUERY_LIMIT,' and ');
}//eof if
else
{
	if(!$componentArr[$x]['COMPONENTQUERYUNLIMITED'])
		$componentArr[$x]['COMPONENTTYPEQUERY'] = "select * from (".$componentArr[$x]['COMPONENTTYPEQUERY'].") a  ".$mySQL->limit(DEFAULT_QUERY_LIMIT,' where ');			//limit query result
}//eof else

//if have query
if($componentArr[$x]['COMPONENTTYPEQUERY'])
{
	//convert query into dbsafe
	$theQuery = convertDBSafeToQuery(convertToDBQry($componentArr[$x]['COMPONENTTYPEQUERY']));

	//fetch the query
	$data=$myQuery->query($theQuery,'SELECT','NAME');
	$dataCount=count($data);	//count row of data
	
}//eof if have query
else
	$dataCount=0;

//if data is not null, do this [ADDED IF cikkim 20080417]
if($data[0] != '')
{
	//set keys of array
	$dataKeys = array_keys($data[0]);
	$dataKeysCount = count($dataKeys);		//count the keys
	
	//set keys as label for tablegrid
	$keysLabel=$dataKeys;
}

$useLabel=false;	//temporary

//=====this part for footer
//clear data
unset($tempArr);

//loop on count of item
for($a=0; $a < $countItem; $a++)
{	
	//if item type hidden, skip
	if($itemsArr[$a]['ITEMTYPE'] == 'hidden')
		continue;
		
	//if item have aggregation
	if($itemsArr[$a]['ITEMAGGREGATECOLUMN'] || $itemsArr[$a]['ITEMAGGREGATECOLUMNLABEL'])
	{
		//loop on data count
		for($ax=0;$ax<$dataCount;$ax++)
		{
			$tempArr[$a][$ax]=$data[$ax][$dataKeys[$a]];					//get value into temp array
			
			//if item have comma
			if(ereg(',',$tempArr[$a][$ax]))
			{
				$tempArr[$a][$ax]=ereg_replace(',','',$tempArr[$a][$ax]);		//trim comma ','
				$useComma=true;	//set comma value true for thousand
			}//eof if
		}//eof for
		
		//if array
		if(is_array($tempArr))
		{
			//switch by aggregate type
			switch(strtoupper($itemsArr[$a]['ITEMAGGREGATECOLUMN']))
			{
				case 'SUM':	$aggArr[$a]=array_sum($tempArr[$a]);
					break;
				case 'COUNT': //$aggArr[$a]=count($tempArr[$a]);
							$aggArr[$a]=0;	//initial value
							$tempArrCount=count($tempArr[$a]);	//count row
							
							//loop on row
							for($y=0;$y<$tempArrCount;$y++)
								if($tempArr[$a][$y]!='')	//if have value
									$aggArr[$a]++;
							
					break;
				case 'AVG': $aggArr[$a]=array_sum($tempArr[$a])/count($tempArr[$a]);
					break;
				case 'MAX': $aggArr[$a]=max($tempArr[$a]);
					break;
				case 'MIN': $aggArr[$a]=min($tempArr[$a]);
					break;
			}//eof switch
			
			//============================start number format converter
			//if float number and use comma for thousand
			if(is_float($aggArr[$a]) && $useComma)
				$aggArr[$a] = number_format($aggArr[$a], 2, '.', ',');
			
			//if float number
			else if(is_float($aggArr[$a]))
				$aggArr[$a] = sprintf("%.2f",$aggArr[$a]);
				
			//if use comma for thousand
			else if($useComma)
				$aggArr[$a] = number_format($aggArr[$a], '', '', ',');
			//===============================end number format converter			
			
			//if aggregation have label
			if($itemsArr[$a]['ITEMAGGREGATECOLUMNLABEL'])
				$aggLabel[$a]='<b>'.$itemsArr[$a]['ITEMAGGREGATECOLUMNLABEL'].'</b><br>';
			
			//aggregation
			$aggFieldName[$a] = 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArr[$a]["ITEMID"].'_'.$itemsArr[$a]['ITEMAGGREGATECOLUMN'];
			$aggArr[$a]=$aggLabel[$a].
						'<input class="inputInput" name="'.$aggFieldName[$a].'" id="'.$aggFieldName[$a].'" type="text" value="'.$aggArr[$a].'" style="background-color:#F2F2F2; width:93%; text-align:'.$itemsArr[$a]['ITEMTEXTALIGN'].';" />';
			
			//javascript for item (onblur)
			$itemsArr[$a]["ITEMJAVASCRIPTEVENT"]='1';		//event code for 'onblur'
			$itemsArr[$a]["ITEMJAVASCRIPT"]='aggregateColumn(\''.$itemsArr[$a]['ITEMAGGREGATECOLUMN'].'\',this,\''.$aggFieldName[$a].'\');'.$itemsArr[$a]["ITEMJAVASCRIPT"];
			
			$btnDelRowJs.='aggregateColumn(\''.$itemsArr[$a]['ITEMAGGREGATECOLUMN'].'\',\''.$inputFieldName[$a].'\',\''.$aggFieldName[$a].'\');';
							
			$showFooter=true;	//set footer is true
		}//eof if array
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

//if select && addrow
if($componentArr[$x]['COMPONENTADDROW']&&$countItem>0)
	$dataCount++;

//if have data
if($dataCount>0)
{			
	//loop on row of items
	for($a=0; $a < $countItem; $a++) 
	{
		//if item type is not label
		switch($itemsArr[$a]["ITEMTYPE"])
		{
			//for those items
			case 'hidden':
			case 'input_date':
			case 'input_query':
			case 'label':
			case 'label_with_hidden':
			case 'password':
			case 'text':
			case 'textarea':
			case 'text_editor':
			case 'radio':
			case 'dropdown':
			case 'listbox':
			case 'lov_popup':
				
				//if data keys not exist
				if(!isset($dataKeys[$a]))
					$dataKeys[$a]=$itemsArr[$a]['ITEMNAME'];	//set the data keys
		
				//loop on data row
				for($ax=0;$ax<$dataCount;$ax++)
				{
					//if item have default value
					if(!$data[$ax][$dataKeys[$a]])
						$data[$ax][$dataKeys[$a]]=$itemsArr[$a]["ITEMDEFAULTVALUE"];	//set result data as default value
					
					//build input, convert into array and set as temp variable
					$temp=convertInputIntoArray($itemsArr[$a]["ITEMTYPE"],buildInput($myQuery,$dbc,$itemsArr[$a]["ITEMINPUTLENGTH"],
							$itemsArr[$a]["ITEMTYPE"],$data[$ax][$dataKeys[$a]],$itemsArr[$a]["ITEMDEFAULTVALUEQUERY"],$itemsArr[$a]["ITEMLOOKUP"],$itemsArr[$a]["ITEMLOOKUPSECONDARY"],
							$itemsArr[$a]["ITEMID"],$itemsArr[$a]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],$preScript[0][$columnName],
							$itemsArr[$a]["ITEMJAVASCRIPTEVENT"],$itemsArr[$a]["ITEMJAVASCRIPT"],$itemsArr[$a]["ITEMNAME"],$itemsArr[$a]["ITEMTABINDEX"],
							$itemsArr[$a]["ITEMID"],$itemsArr[$a]["ITEMMINCHAR"],$itemsArr[$a]["ITEMMAXCHAR"],$itemsArr[$a]["ITEMTEXTAREAROWS"],
							$itemsArr[$a]["ITEMREQUIRED"],$componentArr[$x]['COMPONENTID'],$a+1,$itemsArr[$a]['ITEMTEXTALIGN'],$itemsArr[$a]['ITEMUPPERCASE'],
							$itemsArr[$a]['ITEMDISABLED'],$itemsArr[$a]['ITEMREADONLY']),$ax);
					
					//if item type not hidden
					if($itemsArr[$a]['ITEMTYPE'] != 'hidden')
					{
						//$data[$ax][$dataKeys[$a]] = $temp;		//insert temp data into data array
						
						if(!$itemsArr[$a]["ITEMAPPENDTOBEFORE"])
							$data[$ax][$dataKeys[$a]] = $temp.' '.$itemsArr[$a]['ITEMNOTES'];		//insert temp data into data array
						else
							$data[$ax][$dataKeys[$a-1]] .=  ' '.$dataKeys[$a].' '.$temp.' '.$itemsArr[$a]['ITEMNOTES'];		//append into data array before
					}//eof if
					else
					{
						//if 1st hidden input
						if(!$hiddenData[$ax])
							$hiddenData[$ax] = $temp;	//append temp data into previous data array
						else
							$hiddenData[$ax] .= $temp;	//insert temp data into next data array
						
						//unset involved array
						unset($data[$ax][$dataKeys[$a]]);		//delete array for current row (hidden)
						unset($keysLabel[$a]);					//delete keys for current item
					}//eof else
				}//eof for
				
				//if item type not hidden
				if($itemsArr[$a]['ITEMTYPE'] != 'hidden')
				{
					//enable label
					$useLabel = true;		//temporary -> set to use given label
					$keysLabel[$a]=$itemsArr[$a]['ITEMNAME'];	//use item name as key
				}//eof if
			break;
			
			//others item
			default:
			
				//added 20080423 cikkim mod 20080402 added itemlookup not null
				if($itemsArr[$a]['ITEMLOOKUP'] != '')
				{
					if(!$sqlToAppend)
					{
						if(!$itemsArr[$a]['ITEMLOOKUPUNLIMITED'])
							$itemsArr[$a]["ITEMLOOKUP"] = 'select * from ('.$itemsArr[$a]["ITEMLOOKUP"].') a '.$mySQL->limit(DEFAULT_QUERY_LIMIT,' where ');
					}//eof if
					else
					{
						if(!$itemsArr[$a]['ITEMLOOKUPUNLIMITED'])
							$itemsArr[$a]["ITEMLOOKUP"] = 'select * from ('.$itemsArr[$a]["ITEMLOOKUP"].') a '.$sqlToAppend.$mySQL->limit(DEFAULT_QUERY_LIMIT,' and ');
						else
							$itemsArr[$a]["ITEMLOOKUP"] = 'select * from ('.$itemsArr[$a]["ITEMLOOKUP"].') a '.$sqlToAppend;
					}//eof if
				}//eof if
				
				//build input
				$temp=convertInputIntoArray($itemsArr[$a]["ITEMTYPE"],buildInput($myQuery,$dbc,$itemsArr[$a]["ITEMINPUTLENGTH"],$itemsArr[$a]["ITEMTYPE"],
							$itemsArr[$a]["ITEMDEFAULTVALUE"],$itemsArr[$a]["ITEMDEFAULTVALUEQUERY"],$itemsArr[$a]["ITEMLOOKUP"],$itemsArr[$a]["ITEMLOOKUPSECONDARY"],$itemsArr[$a]["ITEMID"],
							$itemsArr[$a]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],$preScript[0][$columnName],$itemsArr[$a]["ITEMJAVASCRIPTEVENT"],
							$itemsArr[$a]["ITEMJAVASCRIPT"],$itemsArr[$a]["ITEMNAME"],$itemsArr[$a]["ITEMTABINDEX"],$itemsArr[$a]["ITEMID"],
							$itemsArr[$a]["ITEMMINCHAR"],$itemsArr[$a]["ITEMMAXCHAR"],$itemsArr[$a]["ITEMTEXTAREAROWS"],$itemsArr[$a]["ITEMREQUIRED"],
							$componentArr[$x]['COMPONENTID'],$a+1,$itemsArr[$a]['ITEMTEXTALIGN'],$itemsArr[$a]['ITEMUPPERCASE']),$ax); 
				
				//explode
				$tempInput=explode('<br>',$temp);
				
				//count
				$tempInputCount=count($tempInput);
				
				//loop on data row
				for($ax=0; $ax<$dataCount; $ax++)
				{
					if($tempInputCount>1)
						$data[$ax][$itemsArr[$a]['ITEMNAME']]=$tempInput[$ax];
					else 
						$data[$ax][$itemsArr[$a]['ITEMNAME']]=$tempInput[0];
				}//eof for datacount
				
				//set label
				if($a<$dataKeysCount)
					$keysLabel[++$dataKeysCount]=$itemsArr[$a]['ITEMNAME'];		//add item name as key
				else
					$keysLabel[$a]=$itemsArr[$a]['ITEMNAME'];		//add item name as key
			break;
		}//eof switch
	}//eof loop on row of items

	//loop on count of data
	for($ax=0; $ax<$dataCount; $ax++)
	{
		//if have hidden data
		if(is_array($hiddenData) && is_array($data))
		{
			$tempKeys = array_keys($data[$ax]);
			$data[$ax][$tempKeys[0]] .= $hiddenData[$ax];
		}//eof if
	}//eof for
	
	//temp 20091119 (for add row)
	/*if($componentArr[$x]['COMPONENTADDROW'])
		$data[$dataCount]=$data[$dataCount-1];*/
}//eof if have data

//check if keys / label is create
if($useLabel)
{
	$keysLabelCount=count($keysLabel);	//count keys/header label
	$tempCountLabel=0;			//set initial as 0 (count index of label)
	
	//do while not reach end of array
	do
	{
		//put label that will submit current form with index to be ordered when submitted
		$keysLabel[key($keysLabel)]='<label style="cursor:pointer; text-decoration:underline" onclick="document.getElementById(\''.$componentArr[$x]['COMPONENTID'].'_order\').value=\''.($tempCountLabel++).'\';this.form.submit();">'.current($keysLabel).'</label>';
	}while(next($keysLabel));
	
	$tg->setKeys($keysLabel);		//set keys in tablegrid
}//eof if label	

//count data
$headerCount=count($data[0]);	//header
$tg->setHeaderAttribute('colspan',$headerCount);	//set colspan for header

//if have data
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
		//-----------------------
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
	
	if(!$componentArr[$x]['COMPONENTADDROW'])
		$tg->setLimit($componentArr[$x]['COMPONENTABULARDEFAULTROWNO']);			//set limit
	
	//if footer true
	if($showFooter)
	{
		//countfooter
		$footerCount = count($aggArr);
		
		//check if number of footer not same as number of header
		if($footerCount<$headerCount)
			for($y=$footerCount; $y<$headerCount; $y++)
				$aggArr[$y]='';	//put empty spaces for addition
		
		$tg->setFooterAttribute('class','listingContent');		//set footer attribute
		$tg->setFooter($aggArr);								//set the data of footer
		
		$showFooter=false;		//re-set as false
	}//eof if
	
	//sorting
	if($_POST[$componentArr[$x]['COMPONENTID'].'_order']!='')
	{
		$sortStatus=$tg->sortIndex(true,$_POST[$componentArr[$x]['COMPONENTID'].'_order']);
	}//eof if
	
	//for add row
	
	$tg->setAddRowCount(ADD_ROW_COUNT);
	$tg->setAddRowClass('inputButton');
	$tg->setDelRowClass('inputButton');
	$tg->setTableGridData($data);
	
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
	if(ereg($menuRootName,'CIS'))
	{
		$tg->setTableGridData('No Data');
	}
	else

	
	{
	 	//Asal - nk tahu tnya safwan
		//$tg->setTableGridData('Tiada Rekod');
		$tg->setTableGridData('Permohonan Belum Dibuka. Sila Semak Tarikh Permohonan Dibuka di dalam Jadual Penilaian');
 
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

<!--used for sorting-->
<input id="<?php echo $componentArr[$x]['COMPONENTID'];?>_order" name="<?php echo $componentArr[$x]['COMPONENTID'];?>_order" type="hidden" />