<?php 
		
		for($a=0; $a < count($itemsArrHidden); $a++) 
		{
			//ni TEMPORARY UNTUK SHOW HIDDEN ITEMS FIRST
		
			// ------ temporarily used to display date picker (only unique html name/id will show)
			if($itemsArrHidden[$a]["MAPPINGID"] == "")
				$itemsArrHidden[$a]["MAPPINGID"] = rand();
			//-------------------------------------------------------------------------------------
			//removed temporarily (for input type to database table mapping)
			//$columnName = getColumnName($itemsArr[$a]["MAPPINGID"],$getColumnList); ?>
		  <?php 
				//if item default value is not set, check if bind to database columns and pre process is SELECT
			if($itemsArrHidden[$a]["ITEMDEFAULTVALUE"] == '' && $componentArr[$x]['COMPONENTPREPROCESS'] == 'select')
			{
				//for all items
				for($g=0; $g < $countGetMappedItem; $g++)
				{
					//if input name is in getMappedItem array, get mapping id
					if($getMappedItem[$g]['COMPONENTIDNAME'] == 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArrHidden[$a]["ITEMID"])
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
				$default = $itemsArrHidden[$a]["ITEMDEFAULTVALUE"];
			
			//to build input
			echo buildInput($myQuery,$dbc,$itemsArrHidden[$a]["ITEMINPUTLENGTH"],$itemsArrHidden[$a]["ITEMTYPE"],$default,$itemsArrHidden[$a]["ITEMDEFAULTVALUEQUERY"],$itemsArrHidden[$a]["ITEMLOOKUP"],
							$itemsArrHidden[$a]["ITEMLOOKUPSECONDARY"],$itemsArrHidden[$a]["ITEMID"],$itemsArrHidden[$a]["MAPPINGID"],$pageArr[0]["PAGEPREPROCESS"],
							$preScript[0][$columnName],$itemsArrHidden[$a]["ITEMJAVASCRIPTEVENT"],$itemsArrHidden[$a]["ITEMJAVASCRIPT"],$itemsArrHidden[$a]["ITEMNAME"],
							$itemsArrHidden[$a]["ITEMTABINDEX"],$itemsArrHidden[$a]["ITEMID"],$itemsArrHidden[$a]["ITEMMINCHAR"],$itemsArrHidden[$a]["ITEMMAXCHAR"],
							$itemsArrHidden[$a]["ITEMTEXTAREAROWS"],$itemsArrHidden[$a]["ITEMREQUIRED"],$componentArr[$x]['COMPONENTID'],$a+1,$itemsArrHidden[$a]['ITEMTEXTALIGN'])?>
  <?php }//end for x 
  		//END NI TEMPORARY UNTUK SHOW HIDDEN ITEMS FIRST
  ?>