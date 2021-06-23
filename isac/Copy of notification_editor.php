<?php
//====================================== display =============================================
//if edit
if($_POST['edit'])
{
	$notification = $myQuery->query("select * from FLC_NOTIFICATION where notification_id='".$_POST['notification_id']."'",'SELECT','NAME');
	
	//variable assignment
	$notification_id = $notification[0]['NOTIFICATION_ID'];
	$notification_title = $notification[0]['NOTIFICATION_TITLE'];
	$notification_name = $notification[0]['NOTIFICATION_NAME'];
	$notification_description = $notification[0]['NOTIFICATION_DESCRIPTION'];
	$notification_status = $notification[0]['NOTIFICATION_STATUS'];
	$create_by = $notification[0]['CREATE_BY'];
	$create_date = $notification[0]['CREATE_DATE'];
	$perform_this = $notification[0]['PERFORM_THIS'];
	$start_time = $notification[0]['START_TIME'];
	$start_date = $notification[0]['START_DATE'];
	$days = $notification[0]['DAYS'];
	$weeks = $notification[0]['WEEKS'];
	$select_day = $notification[0]['SELECT_DAY'];
	$select_month = $notification[0]['SELECT_MONTH'];
	$the_week = $notification[0]['THE_WEEK'];
	$the_day = $notification[0]['THE_DAY'];
	$notification_type = $notification[0]['NOTIFICATION_TYPE'];
	$email_from = $notification[0]['EMAIL_FROM'];
	$email_to = $notification[0]['EMAIL_TO'];
	$email_cc = $notification[0]['EMAIL_CC'];
	$email_bcc = $notification[0]['EMAIL_BCC'];
	$email_subject = $notification[0]['EMAIL_SUBJECT'];
	$email_message = $notification[0]['EMAIL_MESSAGE'];
	$attachment = $notification[0]['ATTACHMENT'];
	$to_userid = $notification[0]['TO_USERID'];
	$web_service = $notification[0]['WEB_SERVICE'];
	$web_service_parameter = $notification[0]['WEB_SERVICE_PARAMETER'];
	$business_logic = $notification[0]['BUSINESS_LOGIC'];
	$business_logic_parameter = $notification[0]['BUSINESS_LOGIC_PARAMETER'];
	$task = $notification[0]['TASK'];
	$url_task = $notification[0]['URL_TASK'];
	$remarks = $notification[0]['REMARKS'];
	$next_notification_id = $notification[0]['NEXT_NOTIFICATION_ID'];
	$system_module = $notification[0]['SYSTEM_MODULE'];
	$module_sub_module = $notification[0]['MODULE_SUB_MODULE'];
	$stored_procedure = $notification[0]['STORED_PROCEDURE'];
	$stored_procedure_parameter = $notification[0]['STORED_PROCEDURE_PARAMETER'];
	$host = $notification[0]['HOST'];
	$pre_process_sql = $notification[0]['PRE_PROCESS_SQL'];
	$on_success = $notification[0]['ON_SUCCESS'];
	$on_failure = $notification[0]['ON_FAILURE'];
	
	//temp read data of select_day and select_month
	$tempSelectDay = explode('|',$select_day);
	$tempSelectMonth = explode('|',$select_month);
	
	unset($select_day);
	unset($select_month);
	
	//loop on day count
	for($x=0;$x<count($tempSelectDay);$x++)
	{
		switch($tempSelectDay[$x])
		{
			case 'monday'	: $select_day[1]=true; break;
			case 'tuesday'	: $select_day[2]=true; break;
			case 'wednesday': $select_day[3]=true; break;
			case 'thursday'	: $select_day[4]=true; break;
			case 'friday'	: $select_day[5]=true; break;
			case 'saturday'	: $select_day[6]=true; break;
			case 'sunday'	: $select_day[7]=true; break;
		}//eof switch
	}//eof for
	
	//loop on month count
	for($x=0;$x<count($tempSelectMonth);$x++)
	{
		switch($tempSelectMonth[$x])
		{
			case 1	: $select_month[1]=true; break;
			case 2	: $select_month[2]=true; break;
			case 3	: $select_month[3]=true; break;
			case 4	: $select_month[4]=true; break;
			case 5	: $select_month[5]=true; break;
			case 6	: $select_month[6]=true; break;
			case 7	: $select_month[7]=true; break;
			case 8	: $select_month[8]=true; break;
			case 9	: $select_month[9]=true; break;
			case 10	: $select_month[10]=true; break;
			case 11	: $select_month[11]=true; break;
			case 12	: $select_month[12]=true; break;
		}//eof switch
	}//eof for
	
	//list of dashboard
	//$dashboardList=$myQuery->query("select blid,blname from FLC_BL order by bltitle");
	
	//list of bl
	$blList=$myQuery->query("select blid,blname from FLC_BL order by bltitle");
	
	//list of ws
	//$wsList=$myQuery->query("select blid,blname from FLC_BL order by bltitle");
	
	//list of sp
	//$spList=$myQuery->query("select blid,blname from FLC_BL order by bltitle");
	
	//list of notification not same id
	$notification_List2=$myQuery->query("select notification_id,notification_name from FLC_NOTIFICATION where notification_id!='".$_POST['notification_id']."' order by notification_title");
}//eof if
//==================================== eof display ===========================================

//==================================== manipulation ==========================================
//insert/update => check if blname exist
if($_POST['insert']||$_POST['update'])
{
	//select same blname where status active
	$chkExist = $dal->select("select notification_name 
									from FLC_NOTIFICATION 
									where notification_name='".strtoupper($_POST['notification_name'])."' and notification_id!='".$_POST['notification_id']."'");
	$chkExistRs = $chkExist[0][0];
}//eof if

//if array select_day
if(is_array($_POST['select_day']))
	$_POST['select_day']=implode('|',$_POST['select_day']);

//if array select_month
if(is_array($_POST['select_month']))
	$_POST['select_month']=implode('|',$_POST['select_month']);

//if insert
if($_POST['insert'])
{	
	//if name already exist
	if(!$chkExistRs)
	{
		//insert notification_
		$insert=$dal->insert("FLC_NOTIFICATION","notification_id=(".$mySQL->maxValue('FLC_NOTIFICATION','notification_id',0)."+1)",
						"notification_title='".$_POST['notification_title']."'","notification_name='".strtoupper($_POST['notification_name'])."'",
						"notification_description='".$_POST['notification_description']."'","notification_status='".$_POST['notification_status']."'","create_by='".$_SESSION['userID']."'","create_date=".$mySQL->currentDate(),
						"perform_this='".$_POST['perform_this']."'","start_time='".$_POST['start_time']."'","start_date='".$_POST['start_date']."'","days='".$_POST['days']."'",
						"weeks='".$_POST['weeks']."'","select_day='".$_POST['select_day']."'","select_month='".$_POST['select_month']."'","the_week='".$_POST['the_week']."'",
						"the_day='".$_POST['the_day']."'","notification_type='".$_POST['notification_type']."'","email_from='".$_POST['email_from']."'","email_to='".$_POST['email_to']."'","email_cc='".$_POST['email_cc']."'",
						"email_bcc='".$_POST['email_bcc']."'","email_subject='".$_POST['email_subject']."'","email_message='".$_POST['email_message']."'","attachment='".$_POST['attachment']."'",
						"to_userid='".$_POST['to_userid']."'","web_service='".$_POST['web_service']."'","web_service_parameter='".$_POST['web_service_parameter']."'",
						"business_logic='".$_POST['business_logic']."'","business_logic_parameter='".$_POST['business_logic_parameter']."'","task='".$_POST['task']."'",
						"url_task='".$_POST['url_task']."'","remarks='".$_POST['remarks']."'","next_notification_id='".$_POST['next_notification_id']."'",
						"system_module='".$_POST['system_module']."'","module_sub_module='".$_POST['module_sub_module']."'","stored_procedure='".$_POST['stored_procedure']."'",
						"stored_procedure_parameter='".$_POST['stored_procedure_parameter']."'","host='".$_POST['host']."'","pre_process_sql='".$_POST['pre_process_sql']."'",
						"on_success='".$_POST['on_success']."'","on_failure='".$_POST['on_failure']."'");
	}//eof if
					
	//if insert
	if($insert)
		$message='Notification successfully inserted.';
	//if same name exist
	else if($chkExistRs)
	{
		$eventType='error';
		$message='Notification with same name already exist. Insert fail!';
	}//eof else
}//eof if

//if update
else if($_POST['update'])
{
	//if name already exist
	if(!$chkExistRs)
	{
		//update notification_
		$insert=$dal->update("FLC_NOTIFICATION","notification_title='".$_POST['notification_title']."'","notification_name='".strtoupper($_POST['notification_name'])."'",
						"notification_description='".$_POST['notification_description']."'","notification_status='".$_POST['notification_status']."'","create_by='".$_SESSION['userID']."'","create_date=".$mySQL->currentDate(),
						"perform_this='".$_POST['perform_this']."'","start_time='".$_POST['start_time']."'","start_date='".$_POST['start_date']."'","days='".$_POST['days']."'",
						"weeks='".$_POST['weeks']."'","select_day='".$_POST['select_day']."'","select_month='".$_POST['select_month']."'","the_week='".$_POST['the_week']."'",
						"the_day='".$_POST['the_day']."'","notification_type='".$_POST['notification_type']."'","email_from='".$_POST['email_from']."'","email_to='".$_POST['email_to']."'","email_cc='".$_POST['email_cc']."'",
						"email_bcc='".$_POST['email_bcc']."'","email_subject='".$_POST['email_subject']."'","email_message='".$_POST['email_message']."'","attachment='".$_POST['attachment']."'",
						"to_userid='".$_POST['to_userid']."'","web_service='".$_POST['web_service']."'","web_service_parameter='".$_POST['web_service_parameter']."'",
						"business_logic='".$_POST['business_logic']."'","business_logic_parameter='".$_POST['business_logic_parameter']."'","task='".$_POST['task']."'",
						"url_task='".$_POST['url_task']."'","remarks='".$_POST['remarks']."'","next_notification_id='".$_POST['next_notification_id']."'",
						"system_module='".$_POST['system_module']."'","module_sub_module='".$_POST['module_sub_module']."'","stored_procedure='".$_POST['stored_procedure']."'",
						"stored_procedure_parameter='".$_POST['stored_procedure_parameter']."'","host='".$_POST['host']."'","pre_process_sql='".$_POST['pre_process_sql']."'",
						"on_success='".$_POST['on_success']."'","on_failure='".$_POST['on_failure']."'","?notification_id='".$_POST['notification_id']."'");
	}//eof if
					
	//if update
	if($update)
		$message='Notification successfully updated.';
	//if same name exist
	else if($chkExistRs)
	{
		$eventType='error';
		$message='Notification with same name already exist. Update fail!';
	}//eof else
}//eof if

//if delete
else if($_POST['delete'])
{
	//delete notification_
	$delete=$dal->delete("FLC_NOTIFICATION","?notification_id='".$_POST['notification_id']."'");
	
	//if delete
	if($delete)
		$message='notification_ successfully deleted.';
}//eof if
//================================== eof manipulation ========================================

//======================================= general ============================================
//list of notification
$notification_List=$myQuery->query("select notification_id,notification_title from FLC_NOTIFICATION order by notification_title");
//===================================== eof general ==========================================
?>

<script language="javascript" type="text/javascript" src="js/editor.js"></script>
<div id="breadcrumbs">Modul Pentadbir Sistem / Notification Editor / </div>
<h1>Notification Editor</h1> 

<?php if($message)showNotification($eventType,$message);	//notification?>

<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2">Notification List </th>
  </tr>
<tr>
 <td width="100" class="inputLabel">Notification :</td>
 <td>
	<select name="notification_id" class="inputList" id="notification_id" onchange="if(this.selectedIndex!=0){swapItemEnabled('edit|delete', '');}else{swapItemEnabled('', 'edit|delete');}">
		<?php echo createDropDown($notification_List,$_POST['notification_id']);?>
  	</select>
  </td>
</tr>
<tr>
  <td class="contentButtonFooter" colspan="2" align="right">
    <input name="new" type="submit" class="inputButton" id="new" value="Baru" />
    <input name="edit" type="submit" class="inputButton" id="edit" value="Pinda" <?php if(!$_POST['notification_id']) { ?>disabled style="color:#999999"<?php } ?>/>
    <input name="delete" type="submit" class="inputButton" id="delete" value="Padam" <?php if(!$_POST['notification_id']) { ?>disabled style="color:#999999"<?php } ?> onClick="if(window.confirm('Anda pasti untuk MEMBUANG notification_ ini?')) {return true} else {return false}"/>
  </td>
</tr>
</table>
</form>
<br />

<?php if($_POST['new']||$_POST['edit']){?>
<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <th colspan="2">New / Edit Notification </th>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Title : </td>
	  <td><input name="notification_title" id="notification_title" type="text" class="inputInput" value="<?php echo $notification_title;?>" size="50" />
      <input type="hidden" name="notification_id" id="notification_id" value="<?php echo $notification_id;?>" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Name : </td>
	  <td><input name="notification_name" id="notification_name" type="text" class="inputInput" value="<?php echo $notification_name;?>" size="50" style="text-transform:uppercase;" /></td>
	</tr>
	<tr>
	  <td class="inputLabel">Status :</td>
	  <td>
          <select name="notification_status" class="inputList" id="notification_status">
            <option></option>
			<option value="created" <?php if($notification_status=='created'){?> selected="selected"<?php }?>>Created</option>
			<option value="expired" <?php if($notification_status=='expired'){?> selected="expired"<?php }?>>Expired</option>
			<option value="disable" <?php if($notification_status=='disable'){?> selected="disable"<?php }?>>Disable</option>
		  </select>
	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Description : </td>
	  <td><textarea name="notification_description" id="notification_description" cols="50" rows="3" class="inputInput"><?php echo $notification_description;?></textarea></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">System/Module : </td>
	  <td><input name="system_module" id="system_module" type="text" class="inputInput" value="<?php echo $system_module;?>" size="50" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Module/Sub-module : </td>
	  <td><input name="module_sub_module" id="module_sub_module" type="text" class="inputInput" value="<?php echo $module_sub_module;?>" size="50" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Remarks : </td>
	  <td><input name="remarks" id="remarks" type="text" class="inputInput" value="<?php echo $remarks;?>" size="50" /></td>
	</tr>
</table>
<br />

<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Perform This : </td>
	  <td>
	  	<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td colspan="2"><input name="perform_this" type="radio" value="immediately" <?php if($perform_this=='immediately'){?> checked="checked"<?php }?> />As per request by notification item</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="perform_this" type="radio" value="once" <?php if($perform_this=='once'){?> checked="checked"<?php }?>/>Once</td>
				<td>
					<div id="perform_once" style="padding-left:30px">
						Start Time : <input name="start_time" id="start_time" type="text" class="inputInput" value="<?php echo $start_time;?>" />
						Start Date : <input name="start_date" id="start_date" type="text" class="w8em <?php echo DEFAULT_DATE_FORMAT;?> divider-dash no-transparency highlight-days-67" value="<?php echo $start_date;?>" />
						In : <input name="days" id="days" type="text" class="inputInput" value="<?php echo $days;?>" size="5" /> Days
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="perform_this" type="radio" value="daily" <?php if($perform_this=='daily'){?> checked="checked"<?php }?>/>Daily</td>
				<td>
					<div id="perform_daily" style="padding-left:30px">
						Start Time : <input name="start_time" id="start_time" type="text" class="inputInput" value="<?php echo $start_time;?>" />
						Start Date : <input name="start_date" id="start_date" type="text" class="w8em <?php echo DEFAULT_DATE_FORMAT;?> divider-dash no-transparency highlight-days-67" value="<?php echo $start_date;?>" />
						<br />
						Perform This 
						<input name="perform_this" type="radio" value="everyday" <?php if($perform_this=='everyday'){?> checked="checked"<?php }?> />Everyday
						<input name="perform_this" type="radio" value="weekend" <?php if($perform_this=='weekend'){?> checked="checked"<?php }?> />Weekend
						<input name="perform_this" type="radio" value="every" <?php if($perform_this=='every'){?> checked="checked"<?php }?> />Every
						<input name="days" id="days" type="text" class="inputInput" value="<?php echo $days;?>" size="5" /> Days
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="perform_this" type="radio" value="weekly" <?php if($perform_this=='weekly'){?> checked="checked"<?php }?>/>Weekly</td>
				<td>
					<div id="perform_weekly" style="padding-left:30px">
						Start Time : <input name="start_time" id="start_time" type="text" class="inputInput" value="<?php echo $start_time;?>" />
						Every : <input name="weeks" id="weeks" type="text" class="inputInput" value="<?php echo $weeks;?>" size="5" /> Weeks
						<br />
						Select Day: 
							<input name="select_day[]" type="checkbox" value="monday" <?php if($select_day[1]){?> checked="checked"<?php }?> /> Monday
							<input name="select_day[]" type="checkbox" value="tuesday" <?php if($select_day[2]){?> checked="checked"<?php }?> /> Tuesday
							<input name="select_day[]" type="checkbox" value="wednesday" <?php if($select_day[3]){?> checked="checked"<?php }?> /> Wednesday
							<input name="select_day[]" type="checkbox" value="thursday" <?php if($select_day[4]){?> checked="checked"<?php }?> /> Thursday
							<input name="select_day[]" type="checkbox" value="friday" <?php if($select_day[5]){?> checked="checked"<?php }?> /> Friday
							<input name="select_day[]" type="checkbox" value="saturday" <?php if($select_day[6]){?> checked="checked"<?php }?> /> Saturday
							<input name="select_day[]" type="checkbox" value="sunday" <?php if($select_day[7]){?> checked="checked"<?php }?> /> Sunday
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="perform_this" type="radio" value="mothly" <?php if($perform_this=='mothly'){?> checked="checked"<?php }?>/>Monthly</td>
				<td>
					<div id="perform_mothly" style="padding-left:30px">
						Start Time : <input name="start_time" id="start_time" type="text" class="inputInput" value="<?php echo $start_time;?>" />
						<input name="monthly" type="radio" value="days" /> Days <input name="days" id="days" type="text" class="inputInput" value="<?php echo $days;?>" size="5" />
						<input name="monthly" type="radio" value="the" /> The 
							<select name="the_week" class="inputList" id="theWeek">
								<option></option>
								<option value="1">First</option>
								<option value="2">Second</option>
								<option value="3">Third</option>
								<option value="4">Forth</option>
								<option value="5">Fifth</option>
						  	</select>
							<select name="the_day" class="inputList" id="the_day">
								<option></option>
								<option value="monday">Monday</option>
								<option value="tuesday">Tuesday</option>
								<option value="wednesday">Wednesday</option>
								<option value="thursday">Thursday</option>
								<option value="friday">Friday</option>
								<option value="saturday">Saturday</option>
								<option value="sunday">Sunday</option>
						  	</select>
						
						<table width="100%" border="0" cellpadding="3" cellspacing="0">
							<tr>
								<td valign="top" nowrap="nowrap">Select Month :</td>
								<td>
									<input name="select_month[]" type="checkbox" value="1" <?php if($select_month[1]){?> checked="checked"<?php }?> /> January
									<input name="select_month[]" type="checkbox" value="2" <?php if($select_month[2]){?> checked="checked"<?php }?> /> February
									<input name="select_month[]" type="checkbox" value="3" <?php if($select_month[3]){?> checked="checked"<?php }?> /> March
									<input name="select_month[]" type="checkbox" value="4" <?php if($select_month[4]){?> checked="checked"<?php }?> /> April
									<input name="select_month[]" type="checkbox" value="5" <?php if($select_month[5]){?> checked="checked"<?php }?> /> May
									<input name="select_month[]" type="checkbox" value="6" <?php if($select_month[6]){?> checked="checked"<?php }?> /> June
									<input name="select_month[]" type="checkbox" value="7" <?php if($select_month[7]){?> checked="checked"<?php }?> /> July
									<br />
									<input name="select_month[]" type="checkbox" value="8" <?php if($select_month[8]){?> checked="checked"<?php }?> /> August
									<input name="select_month[]" type="checkbox" value="9" <?php if($select_month[9]){?> checked="checked"<?php }?> /> September
									<input name="select_month[]" type="checkbox" value="10" <?php if($select_month[10]){?> checked="checked"<?php }?> /> October
									<input name="select_month[]" type="checkbox" value="11" <?php if($select_month[11]){?> checked="checked"<?php }?> /> November
									<input name="select_month[]" type="checkbox" value="12" <?php if($select_month[12]){?> checked="checked"<?php }?> /> Disember
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Type : </td>
	  <td>
	  	<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td valign="top" nowrap="nowrap" width="150"><input name="notification_type" type="radio" value="email" <?php if($notification_type=='email'){?> checked="checked"<?php }?> />Email</td>
				<td>
					<div id="type_email" style="padding-left:30px">
						<table width="100%" border="0" cellpadding="3" cellspacing="0">
							<tr>
								<td>From: </td>
								<td><input name="email_from" id="email_from" type="text" class="inputInput" value="<?php echo $email_from;?>" size="50" /></td>
							</tr>
							<tr>
								<td>To: </td>
								<td><input name="email_to" id="email_to" type="text" class="inputInput" value="<?php echo $email_to;?>" size="50" /></td>
							</tr>
							<tr>
								<td>CC: </td>
								<td><input name="email_cc" id="email_cc" type="text" class="inputInput" value="<?php echo $email_cc;?>" size="50" /></td>
							</tr>
							<tr>
								<td>BCC: </td>
								<td><input name="email_bcc" id="email_bcc" type="text" class="inputInput" value="<?php echo $email_bcc;?>" size="50" /></td>
							</tr>
							<tr>
								<td>Subject: </td>
								<td><input name="email_subject" id="email_subject" type="text" class="inputInput" value="<?php echo $email_subject;?>" size="50" /></td>
							</tr>
							<tr>
								<td>Attachment: </td>
								<td><input name="attachment" id="attachment" type="text" class="inputInput" value="<?php echo $attachment;?>" size="50" /></td>
							</tr>
							<tr>
								<td>Message: </td>
								<td><input name="email_message" id="email_message" type="text" class="inputInput" value="<?php echo $email_message;?>" size="50" /></td>
							</tr>
						</table>	
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="notification_type" type="radio" value="dashboard" <?php if($notification_type=='dashboard'){?> checked="checked"<?php }?> />Dashboard</td>
				<td>
					<div id="type_dashboard" style="padding-left:30px">
						<select name="dashboard" class="inputList" id="dashboard">
							<?php echo createDropDown($dashboardList,$dashboard);?>
						</select>
						<br />
					  To User: 
						<input name="to_userid" id="to_userid" type="text" class="inputInput" value="<?php echo $to_userid;?>" size="50" />
						<br />
						Task/Title: <input name="task" id="task" type="text" class="inputInput" value="<?php echo $task;?>" size="50" />
						<br />
						URL: <input name="url_task" id="url_task" type="text" class="inputInput" value="<?php echo $url_task;?>" size="50" />
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="notification_type" type="radio" value="web_service" <?php if($notification_type=='web_service'){?> checked="checked"<?php }?> />Web Services</td>
				<td>
					<div id="type_ws" style="padding-left:30px">
						<select name="web_service" class="inputList" id="web_service">
							<?php echo createDropDown($wsList,$web_service);?>
						</select>
						<br />
					  Parameter: 
						<input name="webservice_parameter" id="webservice_parameter" type="text" class="inputInput" value="<?php echo $webservice_parameter;?>" size="50" />
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="notification_type" type="radio" value="business_logic" <?php if($notification_type=='business_logic'){?> checked="checked"<?php }?> />Business Logic</td>
				<td>
					<div id="type_bl" style="padding-left:30px">
						<select name="business_logic" class="inputList" id="business_logic">
							<?php echo createDropDown($blList,$business_logic);?>
						</select>
						<br />
					  Parameter: 
						<input name="business_logic_parameter" id="business_logic_parameter" type="text" class="inputInput" value="<?php echo $business_logic_parameter;?>" size="50" />
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="notification_type" type="radio" value="stored_procedure" <?php if($notification_type=='stored_procedure'){?> checked="checked"<?php }?> />Stored Procedure</td>
				<td>
					<div id="type_sp" style="padding-left:30px">
						<select name="stored_procedure" class="inputList" id="stored_procedure">
							<?php echo createDropDown($spList,$stored_procedure);?>
						</select>
						<br />
					  Parameter: 
						<input name="stored_procedure_parameter" id="stored_procedure_parameter" type="text" class="inputInput" value="<?php echo $stored_procedure_parameter;?>" size="50" />
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" nowrap="nowrap"><input name="notification_type" type="radio" value="host" <?php if($notification_type=='host'){?> checked="checked"<?php }?> />Host</td>
				<td>
					<div id="type_host" style="padding-left:30px">
						<input name="host" id="host" type="text" class="inputInput" value="<?php echo $host;?>" size="50" />
					</div>
				</td>
			</tr>
			<tr>
			  <td valign="top" nowrap="nowrap"><input name="notification_type" type="radio" value="host" <?php if($notification_type=='host'){?> checked="checked"<?php }?> />SAGA API </td>
			  <td><div id="div" style="padding-left:30px">
                <select name="select" class="inputList">
				<OPTION></OPTION>
			    <option>MEDICAL CLAIM - PAYROLL</option>
			    <option>COLLECTION RECEIPT - CB</option>
			    </select>
              </div>			  </td>
			</tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">When Status : </td>
	  <td>
	  	<input name="type" type="radio" value="pending" />Pending 
			<select name="next_notification_status" class="inputList" id="next_notification_status">
				<?php echo createDropDown($notification_List2,$next_notification_status);?>
			</select>
		<br />
		<input name="type" type="radio" value="close" />Close, run another notification 
			<select name="next_notification_status" class="inputList" id="next_notification_status">
				<?php echo createDropDown($notification_List2,$next_notification_status);?>
			</select>
	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Pre process : </td>
	  <td>
	  	<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td>SQL :</td>
				<td><textarea name="pre_process_sql" id="pre_process_sql" cols="100" rows="5" class="inputInput"><?php echo $pre_process_sql;?></textarea></td>
			</tr>
			<tr>
				<td>On Success :</td>
				<td>
					<select name="on_success" class="inputList" id="on_success">
						<option></option>
						<option value="continue" <?php if($on_success=='continue'){?> selected="selected"<?php }?>>Continue</option>
						<option value="stop" <?php if($on_success=='stop'){?> selected="selected"<?php }?>>Stop</option>
						<option value="stop_next" <?php if($on_success=='stop_next'){?> selected="selected"<?php }?>>Stop, next notification</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>On Failure :</td>
				<td>
					<select name="on_failure" class="inputList" id="on_failure">
						<option></option>
						<option value="continue" <?php if($on_failure=='continue'){?> selected="selected"<?php }?>>Continue</option>
						<option value="stop" <?php if($on_failure=='stop'){?> selected="selected"<?php }?>>Stop</option>
						<option value="stop_next" <?php if($on_failure=='stop_next'){?> selected="selected"<?php }?>>Stop, next notification</option>
					</select>
				</td>
			</tr>
		</table>
	  </td>
	</tr>
	<tr>
      <td class="contentButtonFooter" colspan="2" align="right">
      	<input name="<?php if($_POST['new']){?>insert<?php }else{?>update<?php }?>" id="<?php if($_POST['new']){?>insert<?php }else{?>update<?php }?>" type="submit" class="inputButton" value="Save" />
	  </td>
  	</tr>
</table>
</form>
<?php }?>