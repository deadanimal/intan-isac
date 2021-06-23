<?php 
if($componentArr[$x]['COMPONENTTYPE'] == 'graph') 
{ 


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2"><?php echo $componentArr[$x]['COMPONENTNAME'];?> </th>
  </tr>
  <?php	
	//for all component items, show the items
	for($a=0; $a < $countItem; $a++) { ?>
  <tr>
    <td width="150" class="inputLabel"><?php echo $itemsArr[$a]["ITEMNAME"]?></td>
    <td class="inputArea"><?php 
	  	// ------ temporarily used to display date picker (only unique html name/id will show)
	  	if($itemsArr[$a]["MAPPINGID"] == "")
	  		$itemsArr[$a]["MAPPINGID"] = rand();
		//-------------------------------------------------------------------------------------
	  	//removed temporarily (for input type to database table mapping)
		//$columnName = getColumnName($itemsArr[$a]["MAPPINGID"],$getColumnList); ?>
      <?php 
			//if item default value is not set, check if bind to database columns and pre process is SELECT
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
					$default = $getDataRs[0][$columnValueToFind];
				}//end if
			}//end for g
		}//end if
		
		//else, use the default value
		else
			$default = $itemsArr[$a]["ITEMDEFAULTVALUE"];
		
		//to build input
		$tempStr = buildInput($myQuery,$dbc,$itemsArr[$a]["ITEMINPUTLENGTH"],$itemsArr[$a]["ITEMTYPE"],$default,$itemsArr[$a]["ITEMDEFAULTVALUEQUERY"],$itemsArr[$a]["ITEMLOOKUP"],
						$itemsArr[$a]["ITEMLOOKUPSECONDARY"],$itemsArr[$a]["ITEMID"],$itemsArr[$a]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],
						$preScript[0][$columnName],$itemsArr[$a]["ITEMJAVASCRIPTEVENT"],$itemsArr[$a]["ITEMJAVASCRIPT"],$itemsArr[$a]["ITEMNAME"],
						$itemsArr[$a]["ITEMTABINDEX"],$itemsArr[$a]["ITEMID"],$itemsArr[$a]["ITEMMINCHAR"],$itemsArr[$a]["ITEMMAXCHAR"],
						$itemsArr[$a]["ITEMTEXTAREAROWS"],$itemsArr[$a]["ITEMREQUIRED"],$componentArr[$x]['COMPONENTID'],$a+1,$itemsArr[$a]['ITEMTEXTALIGN'],
						$itemsArr[$a]['ITEMUPPERCASE'],$itemsArr[$a]['ITEMDISABLED'],$itemsArr[$a]['ITEMREADONLY'])
					/*.
					buildInput2($myQuery,$dbc,$itemsArr[$a]["ITEMINPUTLENGTH"],$itemsArr[$a]["ITEMTYPE"],$default,$itemsArr[$a]["ITEMLOOKUP"],
						$itemsArr[$a]["ITEMLOOKUPSECONDARY"],$itemsArr[$a]["ITEMID"],$itemsArr[$a]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],
						$preScript[0][$columnName],$itemsArr[$a]["ITEMJAVASCRIPTEVENT"],$itemsArr[$a]["ITEMJAVASCRIPT"],$itemsArr[$a]["ITEMNAME"],
						$itemsArr[$a]["ITEMTABINDEX"],$itemsArr[$a]["ITEMID"],$itemsArr[$a]["ITEMMINCHAR"],$itemsArr[$a]["ITEMMAXCHAR"],
						$itemsArr[$a]["ITEMTEXTAREAROWS"],$itemsArr[$a]["ITEMREQUIRED"],$componentArr[$x]['COMPONENTID'],$a+1,$itemsArr[$a]['ITEMTEXTALIGN'],
						$itemsArr[$a]['ITEMUPPERCASE'])*/;
			
		?></td>
  </tr>
  <?php }//end for x ?>
  <?php
	//if theres page control associated with the component
	if($controlArrCount > 0)
	{ 
		for($y=0;$y<$controlArrCount;$y++)
		{$controlid[] = $controlArr[$y][0];}?>
  <tr>
      <td colspan="2" class="contentButtonFooter" align="right"><?php buildControl($myQuery,$controlid,$requiredArr);?></td>
  </tr>
  <?php }?>
</table>
<br />
<?php } ?>
