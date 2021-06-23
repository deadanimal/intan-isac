<?php 
//if type is FORM based 1 column
	if($componentArr[$x]['COMPONENTTYPE'] == 'webservice') { 
	
	//get client input parameter
	$getClientParam = "select b.CLIENT_INPUT_PARAM from FLC_WEBSERVICE a, FLC_WEBSERVICE_CLIENT b 
						where 
						a.wsvc_id = ".$componentArr[$x]['COMPONENTBINDINGSOURCE']." 
						and a.wsvc_id = b.wsvc_id 
						and a.wsvc_webservice_client_flag = 'client'";
	$getClientParamRs = $myQuery->query($getClientParam,'SELECT','NAME');

	$paramExplode = explode(';',$getClientParamRs[0]['CLIENT_INPUT_PARAM']);
	
	for($a=1; $a < count($paramExplode); $a++)
	{
		$explodeAgain = explode('-',$paramExplode[$a]);
		
		if(count($explodeAgain) == 2)
			$param .= trim($explodeAgain[0]).'='.trim(convertDBSafeToQuery($explodeAgain[1]));
		
		if($a + 2 < count($paramExplode))
			$param .= '&';
	}
	?>
<!-- ============================================================ WEBSERVICE COLUMN BLOCK ============================================================ -->

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2"><?php echo $componentArr[$x]['COMPONENTNAME'];?>
      </th>
  </tr>
  <tr><td><iframe src="webservice_generator_client.php?id=<?php echo $componentArr[$x]['COMPONENTBINDINGSOURCE'] ?>&<?php echo $param;?>" frameborder="0"></iframe></td>
  </tr>
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
<!-- ========================================================== END FORM BASED 1 COLUMN BLOCK ========================================================== -->
<?php }//end WEBSERVICE 
  ?>
