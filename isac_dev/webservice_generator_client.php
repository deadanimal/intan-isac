<?php 
include('system_prerequisite.php');

if($_GET['id'])
{
	$id = addslashes(strip_tags(trim($_GET['id'])));
	
	//get the webservice detail
	$webserviceDetail = "select a.*, b.* from FLC_WEBSERVICE a, FLC_WEBSERVICE_CLIENT b 
						where a.wsvc_id = b.wsvc_id 
						and a.wsvc_id = ".$id;
	$webserviceDetailRs = $myQuery->query($webserviceDetail,'SELECT','NAME');
	$countWebserviceRs = count($webserviceDetailRs);

	if($countWebserviceRs > 0)
	{
		$nusoap_lib_path = 'tools/nusoap/nusoap.php';
		
		if($webserviceDetailRs[0]['CLIENT_DEBUG_SOAP_FAULT'] == 1)
			$flag_showSoapFault = true;	
		else
			$flag_showSoapFault = false;
		
		if($webserviceDetailRs[0]['CLIENT_DEBUG_SOAP_REQ_RESP'] == 1)
			$flag_displayRequestAndResponse = true;	
		else
			$flag_displayRequestAndResponse = false;
			
		if($webserviceDetailRs[0]['CLIENT_DEBUG_MESSAGET'] == 1) 
			$flag_displayDebugMsg = true;	
		else
			$flag_displayDebugMsg = false;
		
		$flag_showError = false;							//true / false

		//------ end param

		require_once($nusoap_lib_path);														//include lib
		$client = new nusoap_client($webserviceDetailRs[0]['WSVC_SVC_URL']);				//create client instance - MINUS THE TRUE!!
		
		//show error
		if($client->getError() && $showErrorFlag == true) 
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		
	 	$webserviceDetailRs[0]['CLIENT_INPUT_PARAM'] =  trim(str_replace(";","||",convertDBSafeToQuery($webserviceDetailRs[0]['CLIENT_INPUT_PARAM'])));
	
		$paramArr = explode('||',$webserviceDetailRs[0]['CLIENT_INPUT_PARAM']);
		
		for($x=0; $x < count($paramArr); $x++)
		{
			$paramArrSplit = explode('-',$paramArr[$x]);
			$newStr .= trim($paramArrSplit[1]);
			
			if($x+2 < count($paramArr))
				$newStr .= '||';
		}
		
		$result = $client->call($webserviceDetailRs[0]['CLIENT_METHOD_NAME'],
								array('param' => $newStr),
								$webserviceDetailRs[0]['CLIENT_NAMESPACE'],
								$webserviceDetailRs[0]['CLIENT_SOAP_ACTION']
								);
								
		//check for fault message from proxy
		if($client->fault && $flag_showSoapFault == true) 
		{
			echo '<pre>';
			echo $result['faultstring'];
			echo '</pre>';
		} 
		else
		{	// Display the result
			//print_r($result);
			eval($result);
		}
		
		//if this flag is true
		if($flag_displayRequestAndResponse == true)
		{
			//display request and response
			echo '<h2>Request</h2>';
			echo '<pre>' . htmlspecialchars($proxy->request, ENT_QUOTES) . '</pre>';
			echo '<h2>Response</h2>';
			echo '<pre>' . htmlspecialchars($proxy->response, ENT_QUOTES) . '</pre>';
		}
		
		//if this flag is true
		if($flag_displayDebugMsg == true)
		{
			//display debug messaged
			echo '<h2>Debug</h2>';
			echo '<pre>' . htmlspecialchars($proxy->debug_str, ENT_QUOTES) . '</pre>';
		}						
	}
	else
		echo 'Please provide valid Webservice ID';
}
else
{
	echo 'Please provide Webservice ID';
}
?>
