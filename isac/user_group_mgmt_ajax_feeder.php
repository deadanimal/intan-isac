<?php 
//include stuff needed for session, database connection, and stuff
include('system_prerequisite.php');						

if($_GET['id'] == 'ajaxCheckKodKumpulan')
{
	//check kod kumpulan
	$checkKodKumpulan = "select GROUP_CODE from FLC_USER_GROUP where upper(GROUP_CODE) = upper('".trim($_GET['value'])."')";
	$checkKodKumpulanRsRows = $myQuery->query($checkKodKumpulan,'SELECT','NAME');	
	
	if(count($checkKodKumpulanRsRows) > 0)
	{ ?>

<div id="newCodeDiv" style="color:#FF0000">
  <input name="newCode" type="text" class="inputInput" id="newCode" size="26" maxlength="20" onchange="this.value = this.value.toUpperCase(); ajaxCheckKodKumpulan(this.value);" />
  * Kod kumpulan telah wujud! Sila tukar kod kumpulan.</div>
<?php } 
  else { ?>
<div id="newCodeDiv">
  <input name="newCode" value="<?php echo $_GET['value']?>" type="text" class="inputInput" id="newCode" size="26" maxlength="20" onchange="this.value = this.value.toUpperCase(); ajaxCheckKodKumpulan(this.value);" />
  * </div>
<?php } ?>
<?php }//end if id = ajaxCheckKodKumpulan 

else if($_GET['id'] == 'ajaxCheckKodKumpulanEdit')
{
	//check kod kumpulan
	$checkKodKumpulan = "select GROUP_CODE from FLC_USER_GROUP where upper(GROUP_CODE) = upper('".trim($_GET['value'])."') 
							and upper(GROUP_CODE) <> '".$_GET['originalValue']."'";
	$checkKodKumpulanRsRows = $myQuery->query($checkKodKumpulan,'SELECT','NAME');	
	
	if(count($checkKodKumpulanRsRows) > 0)
	{
	 ?>
<div id="editCodeDiv" style="color:#FF0000">
  <input name="editCode" type="text" class="inputInput" id="editCode" size="26" maxlength="20" onchange="this.value = this.value.toUpperCase(); ajaxCheckKodKumpulanEdit(this.value,$F('hiddenEditCode'));" />
  <input type="hidden" name="hiddenEditCode" id="hiddenEditCode" value="<?php echo $_GET['originalValue']?>" />
  * Kod kumpulan telah wujud! Sila tukar kod kumpulan.</div>
<?php } 
  else { ?>
<div id="editCodeDiv">
  <input name="editCode" value="<?php echo $_GET['value']?>" type="text" class="inputInput" id="editCode" size="26" maxlength="20" onchange="this.value = this.value.toUpperCase(); ajaxCheckKodKumpulanEdit(this.value,$F('hiddenEditCode'));" />
  <input type="hidden" name="hiddenEditCode" id="hiddenEditCode" value="<?php echo $_GET['originalValue']?>" />
  * </div>
<?php } ?>
<?php }//end if id = ajaxCheckKodKumpulanEdit 

else if($_GET['id'] == 'filterNotSelectedUser')
{
	//get list user yang tak dipilih
	//$getUserList = "select USERID, USERNAME, NAME from PRUSER order by USERNAME";
	$getUserList = "select USERID, USERNAME, NAME from PRUSER
						where USERID not in 
						(
						select a.USERID
						from PRUSER a, FLC_USER_GROUP b, FLC_USER_GROUP_MAPPING c
						where a.USERID = c.USER_ID 
						and b.GROUP_ID = c.GROUP_ID 
						and b.GROUP_ID = ".$_GET['code']." 
						
						)
						and (upper(USERNAME) like upper('%".$_GET['filter']."%') 
								or upper(NAME) like upper('%".$_GET['filter']."%'))
						order by 2,3";
	$getUserListRsRows = $myQuery->query($getUserList,'SELECT','NAME');	
	$countGetUserListRsRows = count($getUserListRsRows);

?>
<select style="width:300px;" name="newNonSelectedUser" size="10" multiple class="inputList" id="newNonSelectedUser" onfocus="$('newMoveLTR').disabled = false;" >
  <?php for($x=0; $x < $countGetUserListRsRows; $x++) { ?>
  <option value="<?php echo $getUserListRsRows[$x]["USERID"]?>" ><?php echo $getUserListRsRows[$x]["USERNAME"].' - '.$getUserListRsRows[$x]["NAME"]?></option>
  <?php } ?>
</select>
<?php } 

else if($_GET['id'] == 'filterSelectedUser')
{
	//get list user yang dah dipilih
	$getUserList_2 = "select a.USERID, a.USERNAME, a.NAME
						from PRUSER a, FLC_USER_GROUP b, FLC_USER_GROUP_MAPPING c
						where a.USERID = c.USER_ID 
						and b.GROUP_ID = c.GROUP_ID 
						and b.GROUP_ID = ".$_GET['code']." 
						and (upper(a.USERNAME) like upper('%".$_GET['filter']."%') 
								or upper(a.NAME) like upper('%".$_GET['filter']."%'))
						order by 2,3";
	$getUserList_2RsRows = $myQuery->query($getUserList_2,'SELECT','NAME');	
	$countGetUserList_2RsRows = count($getUserList_2RsRows);

?>
<select style="width:300px;" name="newSelectedUser[]" size="10" multiple class="inputList" id="newSelectedUser" >
  <?php for($x=0; $x < $countGetUserList_2RsRows; $x++) { ?>
  <option value="<?php echo $getUserList_2RsRows[$x]["USERID"]?>" ><?php echo $getUserList_2RsRows[$x]["USERNAME"].' - '.$getUserList_2RsRows[$x]["NAME"]?></option>
  <?php } ?>
</select>
<?php } ?>
