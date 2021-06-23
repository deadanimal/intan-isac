<?php 
include('system_prerequisite.php');

//define constant
define(NUSOAP_LIB_PATH,'tools/nusoap/nusoap.php');
define(WEBSERVICE_NAMESPACE,'FLC_WEBSERVICE');

//set namespace and wsdl object
require_once(NUSOAP_LIB_PATH);
$server = new soap_server();														//create new server instance
//$server->configureWSDL(WEBSERVICE_NAMESPACE, 'urn:'.WEBSERVICE_NAMESPACE); 		//init WSDL support

//register the function 
$server->register('InitWebserviceInstance');

//function to generate CSV
function generateCSV($qryRs)
{
	$count = count($qryRs);
	$totalColumn = count($qryRs[0]);
	
	$theCSVStr = "";
		
	for($x=0; $x < $count; $x++)
	{
		for($y=0; $y < $totalColumn; $y++)
		{
			if(!is_numeric($qryRs[$x][$y]))
			{	
				$temp = '"'.$qryRs[$x][$y].'"';
				$theCSVStr .= $temp; 
			}
			else
				$theCSVStr .= $qryRs[$x][$y];
			
			if($y < $totalColumn - 1)
				$theCSVStr .= ',';
				
			if($y +1 == $totalColumn)
			{
				$theCSVStr .= "\n";
			}
		}
	}
	
	return $theCSVStr;
}

//function to generate CSV
function generateTable($qryRs)
{
	$count = count($qryRs);
	$totalColumn = count($qryRs[0]);
	
	$theTable = '<table width="500" border="1" cellspacing="0" cellpadding="0">';
	
	for($x=0; $x < $count; $x++)
	{
		$theTable .= '<tr>';
		
		for($y=0; $y < $totalColumn; $y++)
		{
			$theTable .= '<td>';
			$theTable .= $qryRs[$x][$y];
			$theTable .= '</td>';
		}
		
		$theTable .= '</tr>';
	}
	
	return $theTable;
}	

//define function
function InitWebserviceInstance($param)
{
	include('system_prerequisite.php');
	
	//explode the parameter string
	$param = explode('||',$param);

	//get the webservice id
	$wsvc_id = trim($param[0]);
	
	//if webservice is not null
	if($wsvc_id != '')
	{
		//get the webservice detail
		$webserviceDetail = "select * from FLC_WEBSERVICE where wsvc_id = ".$wsvc_id;
	 	$webserviceDetailRs = $myQuery->query($webserviceDetail,'SELECT','NAME');
	 	$countWebserviceRs = count($webserviceDetailRs);
	
		//if webservice id exist
		if($countWebserviceRs)
		{
			if($webserviceDetailRs[0]['WSVC_WEBSERVICE_CLIENT_FLAG'] == 'server')
			{
				//get function
				$getFunction = "select * from FLC_WEBSERVICE_FUNCTION 
								where wsvc_id = ".$wsvc_id;
				$getFunctionRs = $myQuery->query($getFunction,'SELECT','NAME');
				$countGetFunctionRs = count($getFunctionRs);
				
				//if function is set
				if($countGetFunctionRs > 0)
				{	
					//return eval($getFunctionRs[0]['FUNC_CODE']);
					return $getFunctionRs[0]['FUNC_CODE'];
				}
				else
					return 'No data.';
			}
			else if($webserviceDetailRs[0]['WSVC_WEBSERVICE_CLIENT_FLAG'] == 'client')
				return new soap_fault('Client', '','Webservice ID is not of type \'server\'', '');
		}
		else
			return new soap_fault('Client', '','Please provide valid Webservice ID.', '');
	}
	else
		return new soap_fault('Client', '','Please provide Webservice ID.', '');
}

// ## Finally, we pass whatever data the php page receives into the soap processor and see what happens:
// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
exit();

?>
