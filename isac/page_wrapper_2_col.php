<?php 
//if type is FORM based 2 column
	if($componentArr[$x]['COMPONENTTYPE'] == 'form_2_col') { ?>
<!-- ============================================================ FORM BASED 2 COLUMN BLOCK ============================================================ -->

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="4"><?php echo $componentArr[$x]['COMPONENTNAME'];?>
      <?php include('show_hidden_inputs.php');?></th>
  </tr>
  <?php	

  	//set append true flag to false, init.
  	$appendTrueFlag = false;
	
	//append to item number index, set default to zero
	$appendToItemNo = 0;
  
  	//to find appended item
  	for($b=0; $b < $countItem; $b++)
	{
	  	// ------ temporarily used to display date picker (only unique html name/id will show)
	  	if($itemsArr[$b]["MAPPINGID"] == "")
	  		$itemsArr[$b]["MAPPINGID"] = rand();
			
		//temporary sb gile
		unset($default);
		
		//if item default value is not set, check if bind to database columns and pre process is SELECT
		if($itemsArr[$b]["ITEMDEFAULTVALUE"] == '' && $componentArr[$x]['COMPONENTPREPROCESS'] == 'select')
		{
			//for all items
			for($g=0; $g < $countGetMappedItem; $g++)
			{
				//if input name is in getMappedItem array, get mapping id
				if($getMappedItem[$g]['COMPONENTIDNAME'] == 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArr[$b]["ITEMID"])
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
			$default = $itemsArr[$b]["ITEMDEFAULTVALUE"];
	
		//if first iteration	
		if($b == 0)
		{
			//if item append to before = 1, reset to zero
			if($itemsArr[$b]["ITEMAPPENDTOBEFORE"] == 1)
			{
				$itemsArr[$b]["ITEMAPPENDTOBEFORE"] = 0;
				$appendTrueFlag == false;
			}
			
			$newItemsArr[$b] = $itemsArr[$b];
		}
		//if not in first iteration
		else
		{
			//if item append to before is true, and this is the first appendment
			if($itemsArr[$b]["ITEMAPPENDTOBEFORE"] == 1 && $appendTrueFlag == false)
			{
				$appendTrueFlag = true;			//set append true flag to true
				$appendToItemNo = count($newItemsArr)-1;			//store index to append item to (previous item)
				
				$tempStr = buildInput($myQuery,$dbc,$itemsArr[$b]["ITEMINPUTLENGTH"],$itemsArr[$b]["ITEMTYPE"],$default,$itemsArr[$b]["ITEMDEFAULTVALUEQUERY"],$itemsArr[$b]["ITEMLOOKUP"],
						$itemsArr[$b]["ITEMLOOKUPSECONDARY"],$itemsArr[$b]["ITEMID"],$itemsArr[$b]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],
						$preScript[0][$columnName],$itemsArr[$b]["ITEMJAVASCRIPTEVENT"],$itemsArr[$b]["ITEMJAVASCRIPT"],$itemsArr[$b]["ITEMNAME"],
						$itemsArr[$b]["ITEMTABINDEX"],$itemsArr[$b]["ITEMID"],$itemsArr[$b]["ITEMMINCHAR"],$itemsArr[$b]["ITEMMAXCHAR"],
						$itemsArr[$b]["ITEMTEXTAREAROWS"],$itemsArr[$b]["ITEMREQUIRED"],$componentArr[$x]['COMPONENTID'],$b+1,$itemsArr[$b]['ITEMTEXTALIGN'],
						$itemsArr[$b]['ITEMUPPERCASE'],$itemsArr[$b]['ITEMDISABLED'],$itemsArr[$b]['ITEMREADONLY']);
				
				$newItemsArr[$appendToItemNo]["ITEMNOTES"] .= $itemsArr[$b]["ITEMNAME"].$tempStr.$itemsArr[$b]["ITEMNOTES"];
			}
			
			//if item append to before is true, and this is NOT the first appendment
			else if($itemsArr[$b]["ITEMAPPENDTOBEFORE"] == 1 && $appendTrueFlag == true)
			{
				//append item to appendtoitemno
				$tempStr = buildInput($myQuery,$dbc,$itemsArr[$b]["ITEMINPUTLENGTH"],$itemsArr[$b]["ITEMTYPE"],$default,$itemsArr[$b]["ITEMDEFAULTVALUEQUERY"],$itemsArr[$b]["ITEMLOOKUP"],
						$itemsArr[$b]["ITEMLOOKUPSECONDARY"],$itemsArr[$b]["ITEMID"],$itemsArr[$b]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],
						$preScript[0][$columnName],$itemsArr[$b]["ITEMJAVASCRIPTEVENT"],$itemsArr[$b]["ITEMJAVASCRIPT"],$itemsArr[$b]["ITEMNAME"],
						$itemsArr[$b]["ITEMTABINDEX"],$itemsArr[$b]["ITEMID"],$itemsArr[$b]["ITEMMINCHAR"],$itemsArr[$b]["ITEMMAXCHAR"],
						$itemsArr[$b]["ITEMTEXTAREAROWS"],$itemsArr[$b]["ITEMREQUIRED"],$componentArr[$x]['COMPONENTID'],$b+1,$itemsArr[$b]['ITEMTEXTALIGN'],
						$itemsArr[$b]['ITEMUPPERCASE'],$itemsArr[$b]['ITEMDISABLED'],$itemsArr[$b]['ITEMREADONLY']);
				
				$newItemsArr[$appendToItemNo]["ITEMNOTES"] .= $itemsArr[$b]["ITEMNAME"].$tempStr.$itemsArr[$b]["ITEMNOTES"];
			}
			
			//if item append to before is FALSE
			else
			{
				$appendTrueFlag = false;			//set append true flag to false
				$appendToItemNo = 0;	
				
				//copy array content to new array
				$newItemsArr[] = $itemsArr[$b];
			}
		}
	}
	
	//copy appended array to existing array
	$itemsArr = $newItemsArr;
  	$newItemsArr = array();
   	$countItem = count($itemsArr);
	
  	//END APPEND TO ITEM BEFORE BLOCK
	//--------------------------------
	
	//for all component items, show the items
	for($a=0; $a < $countItem; $a++)  
	{ 	
		//================for 2 columns thingy===============
		// if even number, open new row
		if($a%2 == 0)
			echo "<tr>";
	?>
  <td width="150" class="inputLabel"><?php echo $itemsArr[$a]["ITEMNAME"]?></td>
    <td class="inputArea"><?php 
		//removed temporarily 
		//$columnName = getColumnName($itemsArr[$a]["mappingID"],$getColumnList);  	
		
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
						$itemsArr[$a]['ITEMUPPERCASE'],$itemsArr[$a]['ITEMDISABLED'],$itemsArr[$a]['ITEMREADONLY']);
		if(strlen($tempStr) > 0)
			echo $tempStr.' '.$itemsArr[$a]["ITEMNOTES"];
		else
			echo '&nbsp;';?></td>
    <?php if($a+1 == $countItem && $a%2 == 0) { ?>
    <td width="10%">&nbsp;</td>
    <td width="40%">&nbsp;</td>
    <?php 	}//end if 
				
		//if odd number, close existing row
		if($a%2 == 1)
			echo "</tr>";
	}//end for
	?>
	<?php
	//if theres page control associated with the component
	if($controlArrCount > 0)
	{ 
		for($y=0;$y<$controlArrCount;$y++)
		{$controlid[] = $controlArr[$y][0];}?>
  <tr>
      <td colspan="4" class="contentButtonFooter" align="right"><?php buildControl($myQuery,$controlid,$requiredArr);?></td>
  </tr>
  <?php }?>
</table>
<br />
<!-- ========================================================== END FORM BASED 2 COLUMN BLOCK ========================================================== -->
<?php }//end FORM based 2 column
?>
