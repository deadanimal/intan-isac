<?php
//-----
//query
//-----
//get list of webservice
function getWebserviceList($myQuery)
{
	$qry = "select * from FLC_WEBSERVICE order by wsvc_id";
	return $qryRs = $myQuery->query($qry,'SELECT','SINGLE');
}

//check existing webservice
function checkExistingWebservice($myQuery,$name)
{
	$qry = "select count(wsvc_id) as counter from FLC_WEBSERVICE where wsvc_name = '".$name."'";
	return $myQuery->query($qry,'COUNT');
}

//insert new webservice
function insertNewWebservice($myQuery,$max)
{
	if($_POST['wsvc_type'] == 'external_url' || $_POST['wsvc_type'] == 'internal_url')
		$client_flag = 'client';
	else
		$client_flag = 'server';

	$qry = "insert into FLC_WEBSERVICE (wsvc_id,wsvc_name,wsvc_desc,wsvc_type,wsvc_svc_url,WSVC_WEBSERVICE_CLIENT_FLAG,wsvc_wsdl) 
			values (".$max.",'".$_POST['wsvc_name']."','".$_POST['wsvc_desc']."','".$_POST['wsvc_type']."','".$_POST['wsvc_url']."',
			'".$client_flag."','".$_POST['wsvc_wsdl']."')";
	return $myQuery->query($qry,'RUN');
}

//insert new webservice
function updateNewWebservice($myQuery,$id)
{
	if($_POST['wsvc_type'] == 'external_url' || $_POST['wsvc_type'] == 'internal_url')
		$client_flag = 'client';
	else
		$client_flag = 'server';
	
	$qry = "update FLC_WEBSERVICE 
			set wsvc_name = '".$_POST['wsvc_name']."',
			wsvc_desc = '".$_POST['wsvc_desc']."',
			wsvc_type = '".$_POST['wsvc_type']."',
			wsvc_svc_url = '".$_POST['wsvc_url']."',
			WSVC_WEBSERVICE_CLIENT_FLAG = '".$client_flag."',
			wsvc_wsdl = '".$_POST['wsvc_wsdl']."' 
			where wsvc_id = ".$id;
	return $myQuery->query($qry,'RUN');
}

//delete webservice
function deleteWebservice($myQuery,$id)
{
	$qry = "delete from FLC_WEBSERVICE where wsvc_id = ".$id;
	$qryRs = $myQuery->query($qry,'RUN');
	
	$qry = "delete from FLC_WEBSERVICE_PARAM_MST where wsvc_id = ".$id;
	$qryRs = $myQuery->query($qry,'RUN');
	
	$qry = "delete from FLC_WEBSERVICE_PARAM_DTL where param_id not in (select param_id from FLC_WEBSERVICE_PARAM_MST)";
	$qryRs = $myQuery->query($qry,'RUN');
	
	$qry = "delete from FLC_WEBSERVICE_CLIENT where wsvc_id = ".$id;
	$qryRs = $myQuery->query($qry,'RUN');
	
	return true;
}

//insert new input parameter
function insertNewInputParameter($myQuery,$maxWebserviceID)
{
	$qry = "insert into FLC_WEBSERVICE_PARAM_MST 
			(PARAM_ID,PARAM_NAME,PARAM_TYPE_CLASS,PARAM_PHP_TYPE,PARAM_COMPOSITOR,PARAM_RESTRICTION_BASE,PARAM_TYPE,WSVC_ID) 
			values (".$maxWebserviceID.",'".$_POST['PARAM_NAME']."',
			'".$_POST['PARAM_TYPE_CLASS']."','".$_POST['PARAM_PHP_TYPE']."',
			'".$_POST['PARAM_COMPOSITOR']."','".$_POST['PARAM_RESTRICTION_BASE']."',
			'input',".$maxWebserviceID.")";
	return $myQuery->query($qry,'RUN');
}

//insert new input parameter
function insertNewOutputParameter($myQuery,$maxWebserviceID)
{
	$qry = "insert into FLC_WEBSERVICE_PARAM_MST 
			(PARAM_ID,PARAM_NAME,PARAM_TYPE_CLASS,PARAM_PHP_TYPE,PARAM_COMPOSITOR,PARAM_RESTRICTION_BASE,PARAM_TYPE,WSVC_ID) 
			values (".$maxWebserviceID.",'".$_POST['PARAM_NAME_OUTPUT']."',
			'".$_POST['PARAM_TYPE_CLASS_OUTPUT']."','".$_POST['PARAM_PHP_TYPE_OUTPUT']."',
			'".$_POST['PARAM_COMPOSITOR_OUTPUT']."','".$_POST['PARAM_RESTRICTION_BASE_OUTPUT']."',
			'output',".$maxWebserviceID.")";
	return $myQuery->query($qry,'RUN');
}

//insert new function
function insertNewFunction($myQuery,$maxWebserviceID)
{
	$qry = "insert into FLC_WEBSERVICE_FUNCTION 
			(func_id,func_name,func_code,wsvc_id) 
			values (".$maxWebserviceID.",'".$_POST['function_name']."',
			'".$_POST['function_code']."',".$maxWebserviceID.")";
	return $myQuery->query($qry,'RUN');
}

//update new function
function updateFunction($myQuery,$id)
{
	//check if function exist
	$chkWSFunction = "select * from FLC_WEBSERVICE_FUNCTION where wsvc_id = ".$id;
	$chkWSFunctionRs = $myQuery->query($chkWSFunction);
	
	//if exist
	if($chkWSFunctionRs)
	{	
		$qry = "update FLC_WEBSERVICE_FUNCTION 
				set func_name = '".$_POST['function_name']."',
				func_code = '".$_POST['function_code']."'
				where wsvc_id = ".$id; 
		return $myQuery->query($qry,'RUN');
	}//eof if
	else
		insertNewFunction($myQuery,$id);
}

//insert new webservice client info
function insertNewWebserviceClient($myQuery,$maxWebserviceID,$max)
{
	if($_POST['client_debug_soap_fault'] != '1')
		$_POST['client_debug_soap_fault'] = 0;
	
	if($_POST['client_debug_soap_request_response'] != '1')
		$_POST['client_debug_soap_request_response'] = 0;
		
	if($_POST['client_debug_message'] != '1')
		$_POST['client_debug_message'] = 0;
		
	$qry = "insert into FLC_WEBSERVICE_CLIENT (client_id,client_method_name,client_input_param,client_namespace,client_soap_action,
			client_debug_soap_fault,client_debug_soap_req_resp,client_debug_message,wsvc_id) 
			values (".$max.",'".$_POST['client_method_name']."','".$_POST['client_input_parameter']."','".$_POST['client_namespace']."',
			'".$_POST['client_soap_action']."',".$_POST['client_debug_soap_fault'].",".$_POST['client_debug_soap_request_response'].",".$_POST['client_debug_message'].",".$maxWebserviceID.")";
	return $myQuery->query($qry,'RUN');			
}

//update new webservice client info
function updateWebserviceClient($myQuery,$id)
{
	if($_POST['client_debug_soap_fault'] != '1')
		$_POST['client_debug_soap_fault'] = 0;
	
	if($_POST['client_debug_soap_request_response'] != '1')
		$_POST['client_debug_soap_request_response'] = 0;
		
	if($_POST['client_debug_message'] != '1')
		$_POST['client_debug_message'] = 0;
		
	$qry = "update FLC_WEBSERVICE_CLIENT 
			set client_method_name = '".$_POST['client_method_name']."',
			client_input_param = '".$_POST['client_input_parameter']."',
			client_namespace = '".$_POST['client_namespace']."',
			client_soap_action = '".$_POST['client_soap_action']."',
			client_debug_soap_fault = '".$_POST['client_debug_soap_fault']."',
			client_debug_soap_req_resp = '".$_POST['client_debug_soap_request_response']."',
			client_debug_message = '".$_POST['client_debug_message']."' 
			where wsvc_id = ".$id; 
	return $myQuery->query($qry,'RUN');			
}

//get webservice details
function getWebserviceDetails($myQuery,$webserviceID)
{
	$qry = "select * from FLC_WEBSERVICE where wsvc_id = ".$webserviceID;
	return $myQuery->query($qry,'SELECT','NAME');
}

//get webservice function details
function getWebserviceFunctionDetails($myQuery,$webserviceID)
{
	$qry = "select * from FLC_WEBSERVICE_FUNCTION where wsvc_id = ".$webserviceID;
	return $myQuery->query($qry,'SELECT','NAME');
}

//get function details
function getFunctionDetails($myQuery,$webserviceID)
{
	$qry = "select * from FLC_WEBSERVICE_CLIENT where wsvc_id = ".$webserviceID;
	return $myQuery->query($qry,'SELECT','NAME');
}

//init
$webserviceListingPanelVisible = false;
$newWebservicePanelVisible = false;
$webserviceRs = array();
$webserviceRsCount = 0;

if($_POST['addNewWebserviceButton'] || $_GET['lastSvcID'])
{
	$newWebservicePanelVisible = true;
}

else if($_POST['saveNewWebserviceButton'])
{	
	//if the webservice with entered name is already exist
	if(checkExistingWebservice($myQuery,$_POST['wsvc_name']) > 0)
	{
		$newWebservicePanelVisible = true;					//show the page again
		$_POST['addNewWebserviceButton'] = 'dummy';			//show the simpan button
		
		//show error msg
		$notificationPanel = true;
		$notificationMsg = "Error! This webservice is already exist. Please change webservice name.";	
	}
	else
	{
		$maxWebserviceID = ($mySQL->maxValue('FLC_WEBSERVICE','wsvc_id')+1);					//get running number for webservice id
			
		//if webservice successfully inserted
		if(insertNewWebservice($myQuery,$maxWebserviceID))
		{
			//insert input parameter
			if($_POST['datatype_input_check'] == '1')
				insertNewInputParameter($myQuery,$maxWebserviceID);
			
			//insert output parameter
			if($_POST['datatype_output_check'] == '1')
				insertNewOutputParameter($myQuery,$maxWebserviceID);
		
			//insert function
			if($_POST['create_function_check'] == '1')
				insertNewFunction($myQuery,$maxWebserviceID);
		
			//insert webservice client info
			if($_POST['wsvc_type'] == 'external_url' || $_POST['wsvc_type'] == 'internal_url')
			{
				insertNewWebserviceClient($myQuery,$maxWebserviceID,($mySQL->maxValue('FLC_WEBSERVICE_PARAM_DTL','param_dtl_id')+1));
			}
			
			$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&lastSvcID=".$maxWebserviceID;
			
			//show notification msg
			$notificationPanel = true;
			$notificationMsg = "Webservice has been successfully saved. ";	
			//$notificationMsg .= "<a href=\"javascript:void(0)\" onclick=\"form1.action = '".$url."'; $('addNewWebserviceButton').click();\">Create the client?</a>";
		
			$webserviceListingPanelVisible = true;					//visible the panel
			$webserviceRs = getWebserviceList($myQuery);			//get lisf of webservice
			$webserviceRsCount = count($webserviceRs);
		}
	}

//echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."&lastSvcID=".$maxWebserviceID;
//echo $_SERVER['REMOTE_ADDR'];
//echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

else if($_POST['updateWebserviceButton'])
{
	//if webservice successfully inserted
	if(updateNewWebservice($myQuery,$_POST['hiddenWebserviceID']))
	{
		//insert function
		if($_POST['create_function_check'] == '1')
			updateFunction($myQuery,$_POST['hiddenWebserviceID']);
		
		//insert webservice client info
		if($_POST['wsvc_type'] == 'external_url' || $_POST['wsvc_type'] == 'internal_url')
		{
			updateWebserviceClient($myQuery,$_POST['hiddenWebserviceID']);
		}
		
		//show notification msg
		$notificationPanel = true;
		$notificationMsg = "Webservice has been successfully saved. ";	
	
		$webserviceListingPanelVisible = true;					//visible the panel
		$webserviceRs = getWebserviceList($myQuery);			//get lisf of webservice
		$webserviceRsCount = count($webserviceRs);
	}
}

else if($_POST['deleteWebserviceButton'])
{
	//delete the webservice
	deleteWebservice($myQuery,$_POST['hiddenWebserviceID']);
	
	$webserviceListingPanelVisible = true;					//visible the panel
	$webserviceRs = getWebserviceList($myQuery);			//get lisf of webservice
	$webserviceRsCount = count($webserviceRs);
	
	//show msg
	$notificationPanel = true;
	$notificationMsg = "Webservice has been successfully removed.";	
}

else if($_POST['editWebservice'])
{
	$newWebservicePanelVisible = true;
	$dtl = getWebserviceDetails($myQuery,$_POST['hiddenWebserviceID']);
	$funcDtl = getWebserviceFunctionDetails($myQuery,$_POST['hiddenWebserviceID']);
	
	
	$_POST['wsvc_name'] = $dtl[0]['WSVC_NAME'];
	$_POST['wsvc_desc'] = $dtl[0]['WSVC_DESC'];
	$_POST['wsvc_url'] = $dtl[0]['WSVC_SVC_URL'];
	$_POST['wsvc_type'] = $dtl[0]['WSVC_TYPE'];
	
	if(count($funcDtl) > 0)
	{
		$_POST['function_code'] = $funcDtl[0]['FUNC_CODE'];
	}
	
	
	$func = getFunctionDetails($myQuery,$_POST['hiddenWebserviceID']);
	$_POST['client_method_name'] = $func[0]['CLIENT_METHOD_NAME'];
	$_POST['client_input_parameter'] = $func[0]['CLIENT_INPUT_PARAM'];
	$_POST['client_namespace'] = $func[0]['CLIENT_NAMESPACE'];
	$_POST['client_soap_action'] = $func[0]['CLIENT_SOAP_ACTION'];
	
}

//on page load
else
{
	$webserviceListingPanelVisible = true;					//visible the panel
	$webserviceRs = getWebserviceList($myQuery);			//get lisf of webservice
	$webserviceRsCount = count($webserviceRs);
}
?>
<script language="javascript" type="text/javascript" src="prototype.js"></script>
<script language="javascript">
//run on page load
function webservice_onload()
{
	$('panel_inputParameter').hide();
	$('panel_outputParameter').hide();
	$('panel_function').hide();
	$('panel_client').hide();

	$('wsvc_url').up(1).hide();

	//temporary 
	$('PARAM_RESTRICTION_BASE').disabled = true;
	$('PARAM_RESTRICTION_BASE_OUTPUT').disabled = true;

	<?php if(isset($_GET['lastSvcID'])) { ?>
	
	$('wsvc_type').value = 'external_url';
	$('wsvc_type').onchange();
	
	$('wsvc_name').value = 'Client for ..';
	$('wsvc_desc').value = 'Client for ..';
	$('wsvc_url').value = 'http://ipofserver/folder/webservice_generator.php';
	$('wsvc_url').disabled = false;
	
	
	$('client_method_name').value = 'InitWebserviceInstance';
	$('client_input_parameter').value = 'id - <?php echo $_GET['lastSvcID']?>\n';
	$('client_namespace').value = 'uri:webservice_generator';
	$('client_soap_action').value = 'uri:webservice_generator/InitWebserviceInstance';
	
	$('client_method_name').up(1).hide();
	$('client_namespace').up(1).hide();
	$('client_soap_action').up(1).hide();
	
	<?php } ?>
	<?php if(count($funcDtl) > 0)
	{?>
		$('create_function_check').click();
	<?php 
	}
	?>
	<?php if($_POST['editWebservice']) {?>
	$('wsvc_type').onchange();

	<?php } ?>
	
	$('wsvc_name').focus();

}

//for webservice type selector dropdown
function webserviceTypeSelector(typeSelect)
{
	if($(typeSelect).value == 'local_config') 
	{
		//$('datatype_input_check').disabled = false;
		//$('datatype_output_check').disabled = false;
		$('create_function_check').disabled = false;
		
		$('wsvc_url').up(1).hide();
		
		$('panel_client').hide();
	}
	else if($(typeSelect).value == 'local_file') 
	{
		//$('datatype_input_check').checked = false;
		//$('datatype_output_check').checked = false;
		$('create_function_check').checked = false;
		
		//$('datatype_input_check').disabled = true;
		//$('datatype_output_check').disabled = true;
		$('create_function_check').disabled = true;
		
		$('panel_inputParameter').hide();
		$('panel_outputParameter').hide();
		$('panel_function').hide();
		$('panel_client').hide();
	}
	else	
	{
		//$('datatype_input_check').checked = false;
		//$('datatype_output_check').checked = false;
		$('create_function_check').checked = false;
		
		$('wsvc_url').up(1).show();
		
//		$('datatype_input_check').disabled = true;
	//	$('datatype_output_check').disabled = true;
		$('create_function_check').disabled = true;
		
		$('panel_inputParameter').hide();
		$('panel_outputParameter').hide();
		$('panel_function').hide();
		$('panel_client').show();
	}
}

//to append code snippet to function code textarea
function webserviceFunctionCodeHelper(code)
{
	var target = $('function_code');
	
	if($F(code) == 'generate_table_query')
	{
		target.value = $F(target) + "$generateTableFlag = true;\n$qry = \"<query goes here>\";\n\n";
	}
	else if($F(code) == 'generate_csv_query')
	{
		target.value = $F(target) + "$generateCSV = true;\n$qry = \"<query goes here>\";\n\n";
	}
	else if($F(code) == 'return_single_value')
	{
		target.value = $F(target) + "return $theVal;\n\n";
	}
	else if($F(code) == 'if')
	{
		target.value = $F(target) + "if($var1 == '<value>')\n{\n\n}\n\n";
	}
	else if($F(code) == 'for_while')
	{
		target.value = $F(target) + "for($a=0; $a < 100; $a++) {\n{\n\n}\n\n";
	}
	else if($F(code) == 'exec_query')
	{
		target.value = $F(target) + "$qry = \"<query goes here>\";\n$status = $myQuery->query($qry,'RUN');\n\n";
	}	
	else if($F(code) == 'select_query')
	{
		target.value = $F(target) + "$qry = \"<query goes here>\";\n$result = $myQuery->query($qry,'SELECT','NAME');\n\nif($result[0]['<COLUMN_NAME>'] == ...) \n{\n}\n\n";
	}	
	else if($F(code) == 'return_soap_error')
	{
		target.value = $F(target) + "if(...)\n{\nreturn new soap_fault('Client','<error msg here>','');\n}\n\n";
	}	
	else if($F(code) == 'use_client_param')
	{
		target.value = $F(target) + "$id = $param[0];\n$name = $param[1];\n$address = $param[2];\n\n";
	}	
	
		
}
function replaceQuote(elem)
{
	var a = elem.value;
	a = a.replace (/\'/g, '[QS]');
	a = a.replace (/\"/g, '[QD]');
	elem.value = a;
}

/**
TO PLACE QUOTE
-element: element ID
*/
function placeQuote(elem)
{
	var a = elem.value;
	a = a.replace (/\[QS\]/g, '\'');
	a = a.replace (/\[QD\]/g, '"');
	elem.value = a;
}
</script>
<link href="screen.css" rel="stylesheet" type="text/css">
<div id="breadcrumbs">Modul Pentadbir Sistem / Webservice Editor / </div>
<h1>Webservice Editor </h1>
<?php //if update successful
  if($notificationPanel) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td><?php echo $notificationMsg;?></td>
  </tr>
</table>
<br />
<?php } ?>
<form action="" method="post" name="form1">
  <?php if($newWebservicePanelVisible == true)  { ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" >
    <tr>
      <th colspan="2">New Webservice Registration </th>
    </tr>
    <tr>
      <td width="150" nowrap="NOWRAP" class="inputLabel">Webservice Name : </td>
      <td><input name="wsvc_name" type="text" class="inputInput" id="wsvc_name" size="50" maxlength="50" value="<?php echo $_POST['wsvc_name']?>">
        *</td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Description : </td>
      <td><input name="wsvc_desc" type="text" class="inputInput" id="wsvc_desc" size="50" maxlength="100" value="<?php echo $_POST['wsvc_desc']?>"></td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Type : </td>
      <td><select name="wsvc_type" class="inputList" id="wsvc_type" onChange="webserviceTypeSelector(this)">
          <option value="local_config" <?php if($_POST['wsvc_type'] == 'local_config') echo 'selected';?>>Local - Configurable Webservice</option>
          <!--<option value="local_file" >Local - Webservice File Registration (pending)</option>-->
          <option value="external_url" <?php if($_POST['wsvc_type'] == 'external_url') echo 'selected';?>>Client for External Webservice</option>
        </select></td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Webservice URL : </td>
      <td>
        <input name="wsvc_url" type="text" class="inputInput" id="wsvc_url" size="70" maxlength="100" value="<?php echo $_POST['wsvc_url']?>" />
        <br />
        Eg: http://10.100.19.92.23:8080/websvc/fubar.php<br />
        Client for Configurable Webservice: http://ipofserver/folder/webservice_generator.php </td>
    </tr>
  <!--  <tr>
      <td nowrap="nowrap" class="inputLabel">WSDL :</td>
      <td><select name="wsvc_wsdl" class="inputList" id="wsvc_wsdl">
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select>
      </td>
    </tr>-->
   <!-- <tr>
      <td nowrap="nowrap" class="inputLabel">Datatypes and Struct, for :</td>
      <td><label>
        <input name="datatype_input_check" type="checkbox" id="datatype_input_check" onchange="if(this.checked == true) $('panel_inputParameter').show(); else $('panel_inputParameter').hide()" value="1" />
        Input</label>
        <label>
        <input name="datatype_output_check" type="checkbox" id="datatype_output_check" onchange="if(this.checked == true) $('panel_outputParameter').show(); else $('panel_outputParameter').hide()" value="1" />
        Output</label></td>
    </tr>-->
    <tr>
      <td nowrap="nowrap" class="inputLabel">Create Function : </td>
      <td><label>
        <input name="create_function_check" type="checkbox" id="create_function_check" onchange="if(this.checked == true) $('panel_function').show(); else $('panel_function').hide()" value="1" />
        Yes, please. </label></td>
    </tr>
    <tr>
      <td colspan="2" class="contentButtonFooter"><div align="right">
          <input name="exitNewWebserviceButton" type="submit" class="inputButton" id="exitNewWebserviceButton" value="&lt;&lt; Kembali" />
          <?php if($_POST['addNewWebserviceButton']) {?>
          <input name="saveNewWebserviceButton" type="submit" class="inputButton" id="saveNewWebserviceButton" value="Simpan Maklumat Webservice" onClick="if($F('wsvc_name') == '' || $F('wsvc_desc') == '') {window.alert('Sila isi nama dan deskripsi!'); $('wsvc_name').focus(); return false;} else return true;" />
          <?php } else {?>
          <input name="updateWebserviceButton" type="submit" class="inputButton" id="updateWebserviceButton" value="Kemaskini"  />
          <?php } ?>
        </div></td>
    </tr>
  </table>
  <br />
  <div id="panel_inputParameter" style="display:block">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" >
      <tr>
        <th colspan="2">Data Type  for INPUT Parameter </th>
      </tr>
      <tr>
        <td width="120" nowrap="nowrap" class="inputLabel">Parameter Name : </td>
        <td><input name="PARAM_NAME" type="text" class="inputInput" id="PARAM_NAME" size="30" maxlength="50" value="<?php echo $_POST['PARAM_NAME']?>" />
          *</td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Type Class :</td>
        <td><select name="PARAM_TYPE_CLASS" class="inputList" id="PARAM_TYPE_CLASS" >
            <option value="attribute">Attribute</option>
            <option value="complex">Complex</option>
            <option value="simple">Simple</option>
          </select></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">PHP Type :</td>
        <td><select name="PARAM_PHP_TYPE" class="inputList" id="PARAM_PHP_TYPE" >
            <option value="array">Array</option>
            <option value="struct">Struct</option>
          </select></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Compositor : </td>
        <td><select name="PARAM_COMPOSITOR" class="inputList" id="PARAM_COMPOSITOR" >
            <option value="all">All</option>
            <option value="choice">Choice</option>
            <option value="sequence">Sequence</option>
          </select></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Restriction Base : </td>
        <td><input name="PARAM_RESTRICTION_BASE" type="text" class="inputInput" id="PARAM_RESTRICTION_BASE" size="53" maxlength="50" value="<?php echo $_POST['PARAM_RESTRICTION_BASE']?>" /></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">List of Elements : </td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="280" ><textarea name="PARAM_ELEMENT" cols="50" rows="5" class="inputInput" id="PARAM_ELEMENT" ></textarea></td>
              <td valign="top" style="padding-left:10px;">Syntax:<br />
                [element name] - [xsd type]
                <p>Example:<br />
                  username - string </p></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <br />
  </div>
  <div id="panel_outputParameter" style="display:block">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
      <tr>
        <th colspan="2">Data Type for  OUTPUT Parameter </th>
      </tr>
      <tr>
        <td width="120" nowrap="nowrap" class="inputLabel">Parameter Name : </td>
        <td><input name="PARAM_NAME_OUTPUT" type="text" class="inputInput" id="PARAM_NAME_OUTPUT" size="30" maxlength="50" value="<?php echo $_POST['PARAM_NAME_OUTPUT']?>" />
          *</td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Type Class :</td>
        <td><select name="PARAM_TYPE_CLASS_OUTPUT" class="inputList" id="PARAM_TYPE_CLASS_OUTPUT" >
            <option value="attribute">Attribute</option>
            <option value="complex">Complex</option>
            <option value="simple">Simple</option>
          </select></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">PHP Type :</td>
        <td><select name="PARAM_PHP_TYPE_OUTPUT" class="inputList" id="PARAM_PHP_TYPE_OUTPUT" >
            <option value="array">Array</option>
            <option value="struct">Struct</option>
          </select></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Compositor : </td>
        <td><select name="PARAM_COMPOSITOR_OUTPUT" class="inputList" id="PARAM_COMPOSITOR_OUTPUT" >
            <option value="all">All</option>
            <option value="choice">Choice</option>
            <option value="sequence">Sequence</option>
          </select></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Restriction Base : </td>
        <td><input name="PARAM_RESTRICTION_BASE_OUTPUT" type="text" class="inputInput" id="PARAM_RESTRICTION_BASE_OUTPUT" size="53" maxlength="50" value="<?php echo $_POST['PARAM_RESTRICTION_BASE_OUTPUT']?>" /></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">List of Elements : </td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="280"><textarea name="PARAM_ELEMENT_OUTPUT" cols="50" rows="5" class="inputInput" id="PARAM_ELEMENT_OUTPUT" ></textarea></td>
              <td valign="top" style="padding-left:10px;">Syntax:<br />
                [element name] - [xsd type]
                <p>Example:<br />
                  username - string </p></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <br />
  </div>
  <div id="panel_function" style="display:block">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
      <tr>
        <th colspan="2">Webservice Function<input name="hiddenWebserviceID" type="hidden" id="hiddenWebserviceID" value="<?php echo $_POST['hiddenWebserviceID'];?>" />
</th>
      </tr>
      <tr>
        <td width="140" nowrap="nowrap" class="inputLabel">Function Name  : </td>
        <td><input name="function_name" type="text" class="inputInput" id="function_name" size="53" maxlength="50" value="<?php echo $_POST['wsvc_name']?>" />
          <em> * </em></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Function Code Helper : </td>
        <td><select name="function_code_helper" class="inputList" id="function_code_helper" onchange="webserviceFunctionCodeHelper(this)" >
			<option>&nbsp;</option>
            <option value="exec_query">Execute Query - INSERT/UPDATE/DELETE</option>
            <option value="select_query">Execute Query - SELECT</option>
        <!--    <option value="generate_csv_query">Generate CSV based on query</option>
            <option value="generate_table_query">Generate table based on query</option>-->
            <option value="if">If statement</option>
            <option value="for_while">Loop - For</option>
            <option value="return_single_value">Return single value - string</option>
            <option value="return_soap_error">Return SOAP error</option>
            <option value="use_client_param">Use client parameter value</option>
          </select>
          <input name="resetCode" type="button" class="inputButton" id="resetCode" value="Reset Code" onclick="$('function_code').value = ''" /></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Function Code :</td>
        <td><textarea name="function_code" style="font-family:monospace" cols="110" rows="25" class="inputInput" id="function_code" ><?php echo $_POST['function_code']?></textarea></td>
      </tr>
    </table>
    <br />
  </div>
  <div id="panel_client" style="display:block">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
      <tr>
        <th colspan="2">Webservice Client Configuration </th>
      </tr>
      <tr>
        <td width="140" nowrap="nowrap" class="inputLabel">Method Name  : </td>
        <td><input name="client_method_name" type="text" class="inputInput" id="client_method_name" value="<?php echo $_POST['client_method_name']?>" size="30" maxlength="30" />
          <em> * For Configurable Webservice, set this to 'InitWebserviceInstance'</em></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Input Parameters <br />
          (optional) : </td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="35%"><textarea name="client_input_parameter" cols="70" rows="7" class="inputInput" id="client_input_parameter" onfocus="placeQuote(this)" onblur="replaceQuote(this)" ><?php echo $_POST['client_input_parameter']?></textarea></td>
              <td width="65%" valign="top" style="padding-left:10px;">syntax:<br />
                [input param name] - [input param source];
                  <p>example:<br />
                  country - {GET|keyid};<br />
                  <br />
                For Configurable Webservice, set first input parameter to Webservice ID.<br />
              Example: id - 12;</p></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Namespace : </td>
        <td><input name="client_namespace" type="text" onchange="$('client_soap_action').value = this.value + '/'" class="inputInput" id="client_namespace" value="<?php echo $_POST['client_namespace']?>" size="30" maxlength="30" />
        <em>For Configurable Webservice, set this to 'uri:webservice_generator' </em></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">SOAP Action : </td>
        <td><input name="client_soap_action" type="text" class="inputInput" id="client_soap_action" value="<?php echo $_POST['client_soap_action']?>" size="60" maxlength="100" />
        <em>For Configurable Webservice, set this to 'uri:webservice_generator/InitWebserviceInstance'</em></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="inputLabel">Debug :</td>
        <td><label>
          <input name="client_debug_soap_fault" type="checkbox" id="client_debug_soap_fault" value="1" />
          SOAP fault </label>
          <label>
          <input name="client_debug_soap_request_response" type="checkbox" id="client_debug_soap_request_response" value="1" />
          SOAP request and response </label>
          <label>
          <input name="client_debug_message" type="checkbox" id="client_debug_message" value="1" />
          Debug messages</label></td>
      </tr>
    </table>
    <br />
  </div>
                &nbsp;&nbsp;* Allowed character for webservice name, parameter name, and function name is A-Z and underscore only.
  <?php } ?>
</form>
<?php if($webserviceListingPanelVisible == true) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="7">Registered Webservice List - [<?php echo $webserviceRsCount?>]</th>
  </tr>
  <?php if($webserviceRsCount > 0) { ?>
  <tr>
    <td width="15" class="listingHead">#</td>
    <td width="20" class="listingHead">Svc. ID</td>
    <td class="listingHead">Name </td>
    <td class="listingHead">Description</td>
    <td width="40" class="listingHead">Type</td>
    <td width="80" class="listingHead"> Config Type</td>
    <td width="85" class="listingHeadRight">&nbsp;</td>
  </tr>
  <?php for($x=0; $x < $webserviceRsCount; $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo $webserviceRs[$x]["WSVC_ID"];?></td>
    <td class="listingContent"><?php echo $webserviceRs[$x]["WSVC_NAME"];?></td>
    <td class="listingContent"><?php echo $webserviceRs[$x]["WSVC_DESC"];?></td>
    <td class="listingContent"><?php echo ucwords($webserviceRs[$x]["WSVC_WEBSERVICE_CLIENT_FLAG"]);?></td>
    <td class="listingContent"><?php echo $webserviceRs[$x]["WSVC_TYPE"];?></td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" name="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" method="post" action="">
        <input name="editWebservice" type="submit" class="inputButton" id="editWebservice" value="ubah" />
        <input name="deleteWebserviceButton" type="submit" class="inputButton" id="deleteWebserviceButton" value="buang" onClick="if(window.confirm('Are you sure you want to REMOVE the webservice?')) {return true} else {return false}"/>
        <input name="hiddenWebserviceID" type="hidden" id="hiddenWebserviceID" value="<?php echo $webserviceRs[$x]["WSVC_ID"];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="7" class="myContentInput">&nbsp;&nbsp;<em>No webservices found..</em></td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="7" bgcolor="#F7F3F7"><div align="right">
        <form id="form2" name="form2" method="post" action="">
          <input name="addNewWebserviceButton" type="submit" class="inputButton" id="addNewWebserviceButton" value="Register New Webservice" />
        </form>
      </div></td>
  </tr>
</table>
<?php } ?>

<?php if($_POST['addNewWebserviceButton']  || $_POST['editWebservice']) {?>
<script language="javascript">
webservice_onload();
</script>
<?php } ?>