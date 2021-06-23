<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2"><?php echo $componentArr[$x]['COMPONENTNAME'];?></th>
  </tr>
  <?php 
	$theQuery = convertDBSafeToQuery(convertToDBQry($componentArr[$x]['COMPONENTTYPEQUERY']));
	
	//run the query from db
	/*$createLabel = $myQuery->query($theQuery,'SELECT','BOTH_INDEX_KEYS');
	
	//count number of rows
	$countCreateLabel = count($createLabel[1]);
	
	//for all number of rows
	for($xx=0; $xx < $countCreateLabel; $xx++)
	{ ?>
  <tr>
    <td width="150" class="inputLabel">&nbsp;<?php echo $createLabel[1][$xx]?></td>
    <td nowrap="nowrap" class="inputArea"><?php echo $createLabel[0][0][$xx];?>&nbsp;</td>
  </tr>
  <?php } ?>*/
  	
	//run the query from db
  	$createLabel = $myQuery->query($theQuery,'SELECT','NAME');
	
	//if have result
	if(is_array($createLabel))	
		$createLabelKeys = array_keys($createLabel[0]);
	
	$createLabelCount = count($createLabel[0]);			//count number of rows
	$createLabelKeysCount = count($createLabelKeys);	//count number of rows
	
	//for all number of rows
	for($xx=0; $xx < $createLabelCount; $xx++)
	{ ?>
  <tr>
    <td width="150" class="inputLabel">&nbsp;<?php echo $createLabelKeys[$xx];?></td>
    <td nowrap="nowrap" class="inputArea"><?php echo $createLabel[0][$createLabelKeys[$xx]];?>&nbsp;</td>
  </tr>
  <?php } ?>
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