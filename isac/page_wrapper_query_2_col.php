<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="4"><?php echo $componentArr[$x]['COMPONENTNAME'];?></th>
  </tr>
  <?php 
	//prepare sql statement
	$theQuery = convertDBSafeToQuery(convertToDBQry($componentArr[$x]['COMPONENTTYPEQUERY']));
   
   //run the query from db
	$createLabel = $myQuery->query($theQuery,'SELECT','NAME');

	//if have result
	if(is_array($createLabel))	
		$createLabelKeys = array_keys($createLabel[0]);
	
	$createLabelCount = count($createLabel[0]);			//count number of rows
	$createLabelKeysCount = count($createLabelKeys);	//count number of rows
	
	//for all number of rows
	for($xx=0; $xx < $createLabelCount; $xx++)
	{ 
		//================for 2 columns thingy===============
		// if even number, open new row
		if($xx%2 == 0)
			echo "<tr>";
	?>
  <td width="150" class="inputLabel">&nbsp;<?php echo $createLabelKeys[$xx];?></td>
    <td nowrap="nowrap" class="inputArea"><?php echo $createLabel[0][$createLabelKeys[$xx]];?>&nbsp;</td>
    <?php if($xx+1 == $createLabelCount && $xx%2 == 0) { ?>
    <td width="10%">&nbsp;</td>
    <td width="40%">&nbsp;</td>
    <?php 	}//end if 
	//if odd number, close existing row
		if($xx%2 == 1)
			echo "</tr>";
   } ?>
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
