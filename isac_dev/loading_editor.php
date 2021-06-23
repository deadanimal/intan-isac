<?php
//====================================== display =============================================
//if edit
if($_POST['edit'])
{
	$loading=$myQuery->query("select * from FLC_LOADING where loading_id='".$_POST['loading_id']."'",'SELECT','NAME');
	
	//variable assignment
	$loading_id=$loading[0]['LOADING_ID'];
	$loading_name=$loading[0]['LOADING_NAME'];
	$loading_description=$loading[0]['LOADING_DESCRIPTION'];
	$loading_type=$loading[0]['LOADING_TYPE'];
	$loading_application=$loading[0]['LOADING_APPLICATION'];
	$loading_header=$loading[0]['LOADING_HEADER'];
	$loading_status=$loading[0]['LOADING_STATUS'];
	$loading_preprocess_bl=$loading[0]['LOADING_PREPROCESS_BL'];
	$loading_failure_bl=$loading[0]['LOADING_FAILURE_BL'];
	$loading_failure_message=$loading[0]['LOADING_FAILURE_MESSAGE'];
	$loading_notes=$loading[0]['LOADING_NOTES'];
	$loading_remarks=$loading[0]['LOADING_REMARKS'];
	$loading_process_type=$loading[0]['LOADING_PROCESS_TYPE'];
	$loading_sp=$loading[0]['LOADING_SP'];
	$loading_bl=$loading[0]['LOADING_BL'];
	$loading_file_location=$loading[0]['LOADING_FILE_LOCATION'];
	$loading_file_name=$loading[0]['LOADING_FILE_NAME'];
	$loading_error_file_name=$loading[0]['LOADING_ERROR_FILE_NAME'];
	$loading_component_height=$loading[0]['LOADING_COMPONENT_HEIGHT'];
	$loading_component_width=$loading[0]['LOADING_COMPONENT_WIDTH'];
	$loading_macro_file_name=$loading[0]['LOADING_MACRO_FILE_NAME'];
	$loading_alternative_file_type=$loading[0]['LOADING_ALTERNATIVE_FILE_TYPE'];
	$loading_alternative_file_name=$loading[0]['LOADING_ALTERNATIVE_FILE_NAME'];
}//eof if
//==================================== eof display ===========================================

//==================================== manipulation ==========================================
//insert/update => check if blname exist
if($_POST['insert']||$_POST['update'])
{
	//select same blname where status active
	$chkExist = $dal->select("select loading_name from FLC_LOADING where loading_name='".strtoupper($_POST['loading_name'])."' and loading_id!='".$_POST['loading_id']."' and loading_status='00'");
	$chkExistRs = $chkExist[0][0];
}//eof if

//if insert
if($_POST['insert'])
{
	//if blname not exist
	if(!$chkExistRs)
	{
		//insert loading
		$insert=$dal->insert("FLC_LOADING","loading_id=(".$mySQL->maxValue('FLC_LOADING','loading_id',0)."+1)", "loading_name='".strtoupper($_POST['loading_name'])."'",
						"loading_description='".$_POST['loading_description']."'", "loading_type='".$_POST['loading_type']."'",
						"loading_application='".$_POST['loading_application']."'", "loading_header='".$_POST['loading_header']."'", 
						"loading_status='".$_POST['loading_status']."'", "loading_preprocess_bl='".$_POST['loading_preprocess_bl']."'", 
						"loading_failure_bl='".$_POST['loading_failure_bl']."'", "loading_failure_message='".$_POST['loading_failure_message']."'", 
						"loading_notes='".$_POST['loading_notes']."'", "loading_remarks='".$_POST['loading_remarks']."'", 
						"loading_process_type='".$_POST['loading_process_type']."'", "loading_sp='".$_POST['loading_sp']."'", "loading_bl='".$_POST['loading_bl']."'",
						"loading_file_location='".$_POST['loading_file_location']."'", "loading_file_name='".$_POST['loading_file_name']."'",
						"loading_error_file_name='".$_POST['loading_error_file_name']."'", "loading_macro_file_name='".$_POST['loading_macro_file_name']."'",
						"loading_alternative_file_type='".$_POST['loading_alternative_file_type']."'", "loading_alternative_file_name='".$_POST['loading_alternative_file_name']."'",
						"createby='".$_SESSION['userID']."'","createdate=".$mySQL->currentDate());
	}//eof if
							
	//if insert
	if($insert)
		$message='Loading successfully inserted.';
	//if same name exist
	else if($chkExistRs)
	{
		$eventType='error';
		$message='Loading with same name already exist. Insert fail!';
	}//eof else
}//eof if

//if update
else if($_POST['update'])
{
	//if blname not exist
	if(!$chkExistRs)
	{
		//update bl
		$update=$dal->update("FLC_LOADING","loading_name='".strtoupper($_POST['loading_name'])."'",
						"loading_description='".$_POST['loading_description']."'", "loading_type='".$_POST['loading_type']."'",
						"loading_application='".$_POST['loading_application']."'", "loading_header='".$_POST['loading_header']."'", 
						"loading_status='".$_POST['loading_status']."'", "loading_preprocess_bl='".$_POST['loading_preprocess_bl']."'", 
						"loading_failure_bl='".$_POST['loading_failure_bl']."'", "loading_failure_message='".$_POST['loading_failure_message']."'", 
						"loading_notes='".$_POST['loading_notes']."'", "loading_remarks='".$_POST['loading_remarks']."'", 
						"loading_process_type='".$_POST['loading_process_type']."'", "loading_sp='".$_POST['loading_sp']."'", "loading_bl='".$_POST['loading_bl']."'",
						"loading_file_location='".$_POST['loading_file_location']."'", "loading_file_name='".$_POST['loading_file_name']."'",
						"loading_error_file_name='".$_POST['loading_error_file_name']."'", "loading_macro_file_name='".$_POST['loading_macro_file_name']."'",
						"loading_alternative_file_type='".$_POST['loading_alternative_file_type']."'", "loading_alternative_file_name='".$_POST['loading_alternative_file_name']."'",
						"modifyby='".$_SESSION['userID']."'","modifydate=".$mySQL->currentDate(),"?loading_id='".$_POST['loading_id']."'");
	}//eof if
	
	//if update
	if($update)
		$message='Loading successfully updated.';
	//if same name exist
	else if($chkExistRs)
	{
		$eventType='error';
		$message='Loading with same name already exist. Update fail!';
	}//eof else
}//eof if

//if delete
else if($_POST['delete'])
{
	//delete bl
	$delete=$dal->delete("FLC_LOADING","?loading_id='".$_POST['loading_id']."'");
	
	//if delete
	if($delete)
		$message='Loading successfully deleted.';
}//eof if
//================================== eof manipulation ========================================

//======================================= general ============================================
//list of status
$statusList=$mySQL->status();
$statusListCount=count($statusList);

$blList=$mySQL->listActiveBL();	//list of bl
$loadingList=$mySQL->listLoading($_POST['loading_search']);		//list of loading
//===================================== eof general ==========================================
?>

<link href="css/screen.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/editor.js"></script>
<div id="breadcrumbs">Modul Pentadbir Sistem / Loading Editor / </div>
<h1>Loading Editor</h1> 

<?php if($message)showNotification($eventType,$message);	//notification?>

<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2">Loading List </th>
  </tr>
  <tr>
      <td nowrap="nowrap" class="inputLabel">Loading Search : </td>
      <td><input name="loading_search" type="text" id="loading_search" size="50" class="inputInput" value="<?php echo $_POST['loading_search']?>" onkeyup="ajaxUpdatePageSelector('loading','loadingSelectorDropdown',this.value)" /></td>
   </tr>
<tr>
 <td width="100" class="inputLabel">Loading :</td>
 <td>
	<div id="loadingSelectorDropdown">
	<select name="loading_id" class="inputList" id="loading_id" onchange="if(this.selectedIndex!=0){swapItemEnabled('edit|delete', '');}else{swapItemEnabled('', 'edit|delete');}">
		<?php echo createDropDown($loadingList,$_POST['loading_id']);?>
  	</select>
	</div>
  </td>
</tr>
<tr>
  <td class="contentButtonFooter" colspan="2" align="right">
    <input name="new" type="submit" class="inputButton" id="new" value="Baru" />
    <input name="edit" type="submit" class="inputButton" id="edit" value="Ubah" <?php if(!$_POST['loading_id']) { ?>disabled style="color:#999999"<?php } ?>/>
    <input name="delete" type="submit" class="inputButton" id="delete" value="Buang" <?php if(!$_POST['loading_id']) { ?>disabled style="color:#999999"<?php } ?> onClick="if(window.confirm('Anda pasti untuk MEMBUANG Loading ini?')) {return true} else {return false}"/>
  </td>
</tr>
</table>
</form>
<br />

<?php if($_POST['new']||$_POST['edit']){?>
<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <th colspan="2">New / Edit Loading </th>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Name : </td>
	  <td><input name="loading_name" id="loading_name" type="text" class="inputInput" value="<?php echo $loading_name;?>" size="50" style="text-transform:uppercase;" onkeydown="trim(this)" onblur="onkeydown(this);"  /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Description : </td>
	  <td><textarea name="loading_description" id="loading_description" cols="50" rows="3" class="inputInput"><?php echo $loading_description;?></textarea></td>
	</tr>
	<tr>
	  <td class="inputLabel">Status :</td>
	  <td>
          <select name="loading_status" class="inputList" id="loading_status">
            <?php 
			//if status not been set
			if(!isset($loading_status))
				$loading_status='00';		//set default
			
			echo createDropDown($statusList, $loading_status)?>
		  </select>	  </td>
	</tr>
	<tr>
	  <td class="inputLabel">Loading Type :</td>
	  <td><label><input name="loading_type" type="radio" value="upload" <?php if($loading_type=='upload'){?> checked="checked"<?php }?> />
	  Upload</label><label><input name="loading_type" type="radio" value="download" <?php if($loading_type=='download'){?> checked="checked"<?php }?> />
	  Download</label></td>
	</tr>
	<tr>
	  <td class="inputLabel">Application Type :</td>
	  <td><label><input name="loading_application" type="radio" value="excel" <?php if($loading_application=='excel'){?> checked="checked"<?php }?> />
	  CSV (comma-delimeted)</label>
	  <label><input name="loading_application" type="radio" value="word" <?php if($loading_application=='word'){?> checked="checked"<?php }?> />
	  TSV (tab-delimeted)</label>
	  <label><input name="loading_application" type="radio" value="xml" <?php if($loading_application=='xml'){?> checked="checked"<?php }?> />
	  File (fixed-length)</label></td>
	</tr>
	<tr>
	  <td class="inputLabel">Application Header : </td>
	  <td><textarea name="loading_header" id="loading_header" cols="100" rows="3" class="inputInput"><?php echo $loading_header;?></textarea>
	  *separated by comma, without space </td>
	</tr>
	<tr>
	  <td class="inputLabel">Pre Process BL  :</td>
	  <td>
          <select name="loading_preprocess_bl" class="inputList" id="loading_preprocess_bl">
            <?php echo createDropDown($blList,$loading_preprocess_bl)?>
		  </select>	  </td>
	</tr>
	<tr>
	  <td class="inputLabel">On Failure Pre Process BL  :</td>
	  <td>
          <select name="loading_failure_bl" class="inputList" id="loading_failure_bl">
            <?php echo createDropDown($blList,$loading_failure_bl)?>
		  </select>	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">On Failure Message : </td>
	  <td><textarea name="loading_failure_message" id="loading_failure_message" cols="50" rows="3" class="inputInput"><?php echo $loading_failure_message;?></textarea></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Note : </td>
	  <td><textarea name="loading_notes" id="loading_notes" cols="50" rows="3" class="inputInput"><?php echo $loading_notes;?></textarea></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Remarks : </td>
	  <td><textarea name="loading_remarks" id="loading_remarks" cols="50" rows="3" class="inputInput"><?php echo $loading_remarks;?></textarea></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Process Type : </td>
	  <td><label><input name="loading_process_type" type="radio" value="sp" <?php if($loading_process_type=='sp'){?> checked="checked"<?php }?> />
	  SP</label><label><input name="loading_process_type" type="radio" value="bl" <?php if($loading_process_type=='bl'){?> checked="checked"<?php }?> />
	  BL</label></td>
	</tr>
	<tr>
	  <td class="inputLabel">SP :</td>
	  <td>
          <select name="loading_sp" class="inputList" id="loading_sp">
            <?php echo createDropDown($spList, $loading_sp)?>
		  </select>	  </td>
	</tr>
	<tr>
	  <td class="inputLabel">BL :</td>
	  <td>
          <select name="loading_bl" class="inputList" id="loading_bl">
            <?php echo createDropDown($blList,$loading_bl)?>
		  </select>	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">File Location  : </td>
	  <td><input name="loading_file_location" id="loading_file_location" type="text" class="inputInput" value="<?php echo $loading_file_location;?>" size="50" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">File Name  : </td>
	  <td><input name="loading_file_name" id="loading_file_name" type="text" class="inputInput" value="<?php echo $loading_file_name;?>" size="50" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Error File Name  : </td>
	  <td><input name="loading_error_file_name" id="loading_error_file_name" type="text" class="inputInput" value="<?php echo $loading_error_file_name;?>" size="50" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Macro File Name  : </td>
	  <td><input name="loading_macro_file_name" id="loading_macro_file_name" type="text" class="inputInput" value="<?php echo $loading_macro_file_name;?>" size="50" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Alternative File Type  : </td>
	  <td><label><input name="loading_alternative_file_type" type="radio" value="csv" <?php if($loading_alternative_file_type=='csv'){?> checked="checked"<?php }?> />
	  CSV</label><label><input name="loading_alternative_file_type" type="radio" value="html" <?php if($loading_alternative_file_type=='html'){?> checked="checked"<?php }?> />
	  HTML</label><label><input name="loading_alternative_file_type" type="radio" value="txt" <?php if($loading_alternative_file_type=='txt'){?> checked="checked"<?php }?> />
	  TXT</label></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Alternative File Name  : </td>
	  <td><input name="loading_alternative_file_name" id="loading_alternative_file_name" type="text" class="inputInput" value="<?php echo $loading_alternative_file_name;?>" size="50" /></td>
	</tr>
	<tr>
      <td class="contentButtonFooter" colspan="2" align="right">
      	<input name="<?php if($_POST['new']){?>insert<?php }else{?>update<?php }?>" id="<?php if($_POST['new']){?>insert<?php }else{?>update<?php }?>" type="submit" class="inputButton" value="Save" />
		<input type="hidden" name="loading_id" id="loading_id" value="<?php echo $loading_id;?>" />	  </td>
  	</tr>
</table>
</form>
<?php }?>