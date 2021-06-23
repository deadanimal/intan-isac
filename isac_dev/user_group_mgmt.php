<?php
//debuggin
//if main category edit button clicked
if($_POST["code"] && $_POST["editCategory"])
{
	//show info of selected category
	$showCatInfo = "select * from FLC_USER_GROUP where GROUP_ID = ".$_POST["code"]." ";
	$showCatInfoRsRows = $myQuery->query($showCatInfo,'SELECT','NAME');
}

//if edit screen submitted
if($_POST["saveScreenEdit"])
{
	//update GROUP
	$updateCat = "update FLC_USER_GROUP set 
					GROUP_CODE = '".$_POST['editCode']."',
					DESCRIPTION = '".$_POST["editName"]."'
					where GROUP_ID = ".$_POST["code"];
	$updateCatRs = $myQuery->query($updateCat,'RUN');
}

//if new category added
else if($_POST["saveScreenNew"])
{
	//insert category
	$insertCat = "insert into FLC_USER_GROUP (GROUP_ID,GROUP_CODE,DESCRIPTION,ADDED_BY,ADDED_DATE)
						values (".($mySQL->maxValue('FLC_USER_GROUP','GROUP_ID')+1).",'".$_POST['newCode']."', '".$_POST["newName"]."',
						'".$_SESSION['userID']."',".$mySQL->currentDate().")";
	$insertCatRs = $myQuery->query($insertCat,'RUN');
}

//if category deleted
else if($_POST["deleteCategory"])
{	
	//delete kumpulan
	$deleteCat = "delete from FLC_USER_GROUP where GROUP_ID = ".$_POST["code"];
	$deleteCatRs = $myQuery->query($deleteCat,'RUN');

	//delete users under the group
	$deleteCatChild = "delete from FLC_USER_GROUP_MAPPING where GROUP_ID = ".$_POST["code"];
	$deleteCatChildRs = $myQuery->query($deleteCatChild,'RUN');
	
	//delete permission under this group
	$deletePermission = "delete from FLC_PERMISSION where GROUP_ID = ".$_POST['code'];
	$deletePermissionRs = $myQuery->query($deletePermission,'RUN');
	
	//delete previous permission
	$sql="delete from SYSREFPERMISSION where groupid='".$_POST['code']."'";
	$myQuery->query($sql,'RUN');
}
//=====================================================================================================
//=========================================== USER - GROUP MAPPING ======================================
//if user to group mapping added
else if($_POST["saveScreenRefNew"])
{
	//delete existing user 
	$deleteRef_x = "delete from FLC_USER_GROUP_MAPPING where GROUP_ID = ".$_POST['code'];
	$deleteRef_xRs = $myQuery->query($deleteRef_x,'RUN');
	
	//for all selected users in newSelectedUser, loop
	for($x=0; $x < count($_POST['newSelectedUser']); $x++)
	{
		$insertRef = "insert into FLC_USER_GROUP_MAPPING (GROUP_ID,USER_ID,ADDED_BY,ADDED_DATE) 
						values (".$_POST['code'].",".$_POST['newSelectedUser'][$x].",".$_SESSION['userID'].",".$mySQL->currentDate().")";
		$insertRefRs = $myQuery->query($insertRef,'RUN');
	}
	
	//dummy to trigger 
	$_POST["showScreen"] = "some value";
}

//if new or edit
else if($_POST["newReference"] || $_POST["editReference"])
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
						and b.GROUP_ID = ".$_POST['code']." 
						)
						order by 2,3";
	$getUserListRsRows = $myQuery->query($getUserList,'SELECT','NAME');	
	$countGetUserListRsRows = count($getUserListRsRows);
	
	//get list user yang dah dipilih
	$getUserList_2 = "select a.USERID, a.USERNAME, a.NAME
						from PRUSER a, FLC_USER_GROUP b, FLC_USER_GROUP_MAPPING c
						where a.USERID = c.USER_ID 
						and b.GROUP_ID = c.GROUP_ID 
						and b.GROUP_ID = ".$_POST['code']."
						order by 2,3";
	$getUserList_2RsRows = $myQuery->query($getUserList_2,'SELECT','NAME');	
	$countGetUserList_2RsRows = count($getUserList_2RsRows);
}

//if reference deleted
else if($_POST["deleteReference"])
{
	$deleteRef = "delete from FLC_USER_GROUP_MAPPING 
					where GROUP_ID = ".$_POST['code']."
					and USER_ID = ".$_POST['hiddenCode'];
	$deleteRefRs = $myQuery->query($deleteRef,'RUN');
	
	//dummy
	$_POST["showScreen"] = "some value";
}
//=======================================================================================================
//=========================================== GROUP PERMISSION ==========================================
//if edit ke menu akses
else if($_POST["editPermission"])
{
	//get max level of permission
	$editGetMaxLevel = "select MAX(MENULEVEL) MAXMENULEVEL from FLC_MENU
					where MENUSTATUS = 1 
					and MENUROOT = ".$_POST['hiddenCode'];
	$editGetMaxLevelRsRows = $myQuery->query($editGetMaxLevel,'SELECT','NAME');	

	//get second level menus
	/*$secondLevel = "select * from FLC_MENU 
					where  MENUSTATUS = 1
					and MENUROOT = ".$_POST['hiddenCode']."
					and menulevel = 2
					order by MENUORDER"; -fais20090325*/
	$secondLevel = "select * from FLC_MENU 
					where MENUROOT = ".$_POST['hiddenCode']."
					and menulevel = 2
					order by MENUORDER";
	$secondLevelRsRows = $myQuery->query($secondLevel,'SELECT','NAME');	
	$countSecondLevelRsRows = count($secondLevelRsRows);
	
	//get previously configured permission
	$getPreviousPermission = "select PERM_ITEM from FLC_PERMISSION 
								where PERM_TYPE = 'menu' 
								and PERM_VALUE = 1 
								and GROUP_ID = ".$_POST['code'];
	$getPreviousPermissionRsRows = $myQuery->query($getPreviousPermission,'SELECT','INDEX');	
	$countPermission = count($getPreviousPermissionRsRows);
	
	//copy permission array to new array (reduce 1 level)
	for($x=0; $x < $countPermission; $x++)
		$previousPermissionArr[] = $getPreviousPermissionRsRows[$x][0];
}

//if update menu permission screen button is clicked
else if($_POST["saveScreenRefEdit"])
{		
	//count number of POST
	$postCount = count($_POST);
	
	//delete previous permission
	$checkPermission = "delete from FLC_PERMISSION where 
						PERM_TYPE = 'menu'
						and GROUP_ID = ".$_POST['code']."
						and (PERM_ITEM in (select MENUID 
											from FLC_MENU 
											where MENUROOT = ".$_POST['hiddenCode'].")
						or PERM_ITEM = ".$_POST['hiddenCode'].")";
	/*//fais 20090902
	$checkPermission = "delete from FLC_PERMISSION where 
						PERM_TYPE = 'menu'
						and GROUP_ID = ".$_POST['code']."
						and (PERM_ITEM in (select MENUID 
											from FLC_MENU 
											where MENUROOT = ".$_POST['hiddenCode']."  
											and MENUSTATUS = 1 )
						or PERM_ITEM = ".$_POST['hiddenCode'].")";*/
	
	$countValue = $myQuery->query($checkPermission,'RUN');

	//insert into FLC_PERMISSION table
	foreach ($_POST as $key => $value) 
	{	
		//if POST name contains menuPermission
		if(preg_match("/menuPermission/i",$key)) 
		{
			$x = $x + 1;
			
			if($x == 1)
			{
				//insert permission data into FLC_PERMISSION
				$insertParentPermission = "insert into FLC_PERMISSION (PERM_ID,PERM_TYPE,GROUP_ID,PERM_ITEM,PERM_VALUE) 
											values (".($mySQL->maxValue('FLC_PERMISSION','PERM_ID')+1).",'menu',".$_POST['code'].",".$_POST['hiddenCode'].",1)";
				$myQuery->query($insertParentPermission,'RUN');
			}
		
			//replace the 'menuPermission' string to empty string
			$key = trim(str_replace('menuPermission_','',$key));
			
			//explode string to 2 parts, parent and sub
			$keyArr = explode('_',$key);
			
			//if key count is 1, take first key
			if(count($keyArr) == 1)
				$theKey = $keyArr[0];
			
			//if key count is 2, take second key
			else if(count($keyArr) == 2)
				$theKey = $keyArr[1];
			
			//insert permission data into FLC_PERMISSION
			$insertPermission = "insert into FLC_PERMISSION (PERM_ID,PERM_TYPE,GROUP_ID,PERM_ITEM,PERM_VALUE) 
										values (".($mySQL->maxValue('FLC_PERMISSION','PERM_ID')+1).",'menu',".$_POST['code'].",".$theKey.",1)";
			$myQuery->query($insertPermission,'RUN');
		}
	}
	
	//dummy
	$_POST["showScreen"] = "some value";
}

//=========================================== REFERENCE PERMISSION ==========================================
//if refpermission
if($_POST['refPermission'] && $_POST['code'])
{
	//list of all reference
	$refListAll = $mySQL->reference('REFGENERAL', '','');
	$refListAllCount = count($refListAll);
	
	//list of reference by permission
	$refList = $mySQL->reference('REFGENERAL', '',$_POST['code']);
	$refListCount = count($refList);
}//eof if

//if saveRefpermission
else if($_POST['saveRefPermission'] && $_POST['code'])
{
	//delete previous permission
	$sql="delete from SYSREFPERMISSION where groupid='".$_POST['code']."'";
	$myQuery->query($sql,'RUN');
	
	//count reference
	$selectedRefCount=count($_POST['referenceID']);
	
	//loop on count
	for($x=0;$x<$selectedRefCount;$x++)
	{
		//insert new permission
		$sql="insert into SYSREFPERMISSION (referenceid,groupid)
				values
				(
					'".$_POST['referenceID'][$x]."', '".$_POST['code']."'
				)";
		$insertReference = $myQuery->query($sql,'RUN');	
	}//eof for
}//eof if

//========================================= eof REFERENCE PERMISSION ========================================

//if showScreen and code not null
if($_POST["showScreen"] && $_POST["code"] != "")
{
	//get reference
	$reference = "select a.USERID, a.USERNAME, a.NAME, a.ADDED_DATE, b.USERNAME as ADDED_BY
					from
					(
						select a.USERID, a.USERNAME, a.NAME, c.ADDED_DATE, c.ADDED_BY, b.GROUP_ID, b.DESCRIPTION
						from PRUSER a, FLC_USER_GROUP b, FLC_USER_GROUP_MAPPING c
						where a.USERID = c.USER_ID 
						and b.GROUP_ID = c.GROUP_ID
					) a
					left join (select userid,username from PRUSER) b on b.userid = a.ADDED_BY   
					where a.GROUP_ID = ".$_POST['code']." 
					order by 2";
	$referenceRsArr = $myQuery->query($reference,'SELECT','NAME');
	
	//list of reference by permission
	$refList = $mySQL->reference('REFGENERAL', '',$_POST['code']);
	$refListCount = count($refList);
	
	//get menu permission
	$menuPermission = "select MENUID, MENUNAME from FLC_MENU where MENUROOT ='0' or MENUROOT is null 
						and MENUPARENT = 0 
						order by MENUORDER";
	/* fais 20090902
	$menuPermission = "select MENUID, MENUNAME from FLC_MENU where MENUROOT ='0' or MENUROOT is null 
						and MENUSTATUS = 1
						and MENUPARENT = 0 
						order by MENUORDER";*/
	$menuPermissionRsArr = $myQuery->query($menuPermission,'SELECT','NAME');
	$countMenuPermissionRsArr = count($menuPermissionRsArr);
	
	//get list of total allowed and total denied
	for($x=0; $x < $countMenuPermissionRsArr; $x++)
	{
		//get total allowed
		$getAllowed = "select count(PERM_ID) as PERM_ID_COUNT 
						from FLC_PERMISSION 
						where PERM_TYPE = 'menu'
						and GROUP_ID = ".$_POST['code']."
						and PERM_ITEM in (select MENUID 
						from FLC_MENU 
						where MENUROOT = ".$menuPermissionRsArr[$x]['MENUID'].")";
		/* fais 20090902
		$getAllowed = "select count(PERM_ID) as PERM_ID_COUNT 
						from FLC_PERMISSION 
						where PERM_TYPE = 'menu'
						and GROUP_ID = ".$_POST['code']."
						and PERM_ITEM in (select MENUID 
						from FLC_MENU 
						where MENUROOT = ".$menuPermissionRsArr[$x]['MENUID']."  
						and MENUSTATUS = 1 )";*/
		$getAllowedCount[$x] = $myQuery->query($getAllowed,'COUNT');

		//get total denied
		$getDenied = "select count(MENUID) - ".$getAllowedCount[$x]." from FLC_MENU 
						where MENUROOT = ".$menuPermissionRsArr[$x]['MENUID']."";
		/* fais 20090902
		$getDenied = "select count(MENUID) - ".$getAllowedCount[$x]." from FLC_MENU 
						where MENUROOT = ".$menuPermissionRsArr[$x]['MENUID']."  
						and MENUSTATUS = 1";*/
		$getDeniedCount[$x] = $myQuery->query($getDenied,'COUNT');

	}
}

//get list of groups
$general = "select GROUP_ID, DESCRIPTION, GROUP_CODE 
			from FLC_USER_GROUP 
			order by GROUP_CODE";
$generalRsArr = $myQuery->query($general,'SELECT','NAME');

?>
<script language="javascript">
function codeDropDown(elem)
{	
	if(elem.selectedIndex != 0) 
	{ 
		document.form1.showScreen.disabled = false; 
		document.form1.editCategory.disabled = false; 
		document.form1.deleteCategory.disabled = false;
	} 
	else 
	{	
		document.form1.showScreen.disabled = true; 
		document.form1.editCategory.disabled = true; 
		document.form1.deleteCategory.disabled = true;
	}
}

//prerequisite: prototpye.js
//this function will check only checkboxes with similar names
//eg: check menuPermission_1222
//will check menuPermission_1222_001, menuPermission_1222_002, menuPermission_1222_003
function selectChildCheckbox(elem,toReplace)
{	
	var checkboxArr = $$('input[type="checkbox"]');					//find all checkbox item
	var theParentID = elem.id;										//get parent id

	var theParentIDReplaced = theParentID.replace(toReplace,'');	//replace var toReplace with empty string
	
	if(elem.checked == true)
		var checkValue = true;
	else
		var checkValue = false;
	
	//for all checkboxes
	for(var x=0; x < checkboxArr.size(); x++)
	{
		if(checkboxArr[x].id.match(toReplace+theParentIDReplaced))		//if checkbox id matched with eg: menuPermission_1222
			checkboxArr[x].checked = checkValue;						//check the checkbox to true
	}
}

//ajax function to check whether keyed in kod kumpulan is already exist - NEW KUMPULAN
function ajaxCheckKodKumpulan(value)
{
	var url = 'user_group_mgmt_ajax_feeder.php';
	var params = 'id=ajaxCheckKodKumpulan&value=' + value;
	var ajax = new Ajax.Updater({success: 'newCodeDiv'},url,{method: 'get', parameters: params, onFailure: reportError});
}

//ajax function to check whether keyed in kod kumpulan is already exist - EDIT KUMPULAN
function ajaxCheckKodKumpulanEdit(value,originalValue)
{
	var url = 'user_group_mgmt_ajax_feeder.php';
	var params = 'id=ajaxCheckKodKumpulanEdit&value=' + value + '&originalValue=' + originalValue;
	var ajax = new Ajax.Updater({success: 'editCodeDiv'},url,{method: 'get', parameters: params, onFailure: reportError});
}

//function to filter not selected user
function ajaxFilterNotSelectedUser(filter,code)
{
	var url = 'user_group_mgmt_ajax_feeder.php';
	var params = 'id=filterNotSelectedUser&filter=' + filter +'&code=' + code;
	var ajax = new Ajax.Updater({success: 'newNonSelectedUserDiv'},url,{method: 'get', parameters: params, onFailure: reportError});

}

//function to filter selected user
function ajaxFilterSelectedUser(filter,code)
{
	var url = 'user_group_mgmt_ajax_feeder.php';
	var params = 'id=filterSelectedUser&filter=' + filter +'&code=' + code;
	var ajax = new Ajax.Updater({success: 'newSelectedUserDiv'},url,{method: 'get', parameters: params, onFailure: reportError});

}
</script>
<script language="javascript" src="js/editor.js"></script>

<div id="breadcrumbs">Modul Pentadbir Sistem / Kebenaran Kumpulan Pengguna /
  <?php if($_POST["editScreen"]) echo " Edit /"?>
</div>
<h1>Kebenaran Kumpulan Pengguna </h1>
<?php //if update successful
  if($insertCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Maklumat kumpulan telah berjaya disimpan.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete user successful
  if($deleteRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Pengguna yang dipilih telah dikeluarkan daripada kumpulan.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($updateCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Maklumat kumpulan telah berjaya dikemaskini.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if insert reference successful
  if($insertRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Senarai pengguna telah berjaya dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($deleteCatRs && deleteCatChildRs && deletePermissionRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Maklumat kumpulan, senarai pengguna kumpulan, dan akses kumpulan dan rujukan telah berjaya dihapuskan.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($insertPermission) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Akses kebenaran telah berjaya dikemaskini.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if insert reference successful
  if($insertReference) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Akses kebenaran rujukan telah berjaya dikemaskini.</td>
  </tr>
</table>
<br />
<?php } ?>
<form action="" method="post" name="form1">
  <?php if(!isset($_POST["editScreen"]))  { ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Senarai Kumpulan </th>
    </tr>
    <tr>
      <td width="74" nowrap="nowrap" class="inputLabel">Kumpulan : </td>
      <td width="662"><select name="code" class="inputList" id="code" onChange="codeDropDown(this); form1.hiddenName.value = this.options[this.selectedIndex].label">
          <option value="">&lt; Pilih Kumpulan &gt;</option>
          <?php for($x=0; $x < count($generalRsArr); $x++) { ?>
          <option value="<?php echo $generalRsArr[$x]["GROUP_ID"]?>" label="<?php echo $generalRsArr[$x]["DESCRIPTION"]?>" <?php if($_POST["code"] == $generalRsArr[$x]["GROUP_ID"]) echo "selected";?>><?php echo $generalRsArr[$x]["GROUP_CODE"].' - '.$generalRsArr[$x]["DESCRIPTION"]?></option>
          <?php } ?>
        </select>
        <input name="showScreen" type="submit" class="inputButton" id="showScreen" value="Tunjuk Senarai" <?php if(!$_POST["code"]) { ?>disabled="disabled" <?php } ?> />
        <input name="hiddenName" type="hidden" id="hiddenName" value=""></td>
    </tr>
    <tr>
      <td colspan="2" class="contentButtonFooter"><div align="right">
          <input name="newCategory" type="submit" class="inputButton" value="Baru" />
		  <input name="editCategory" type="submit" class="inputButton" value="Ubah" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> />
          <input name="deleteCategory" type="submit" class="inputButton" value="Buang" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> onClick="if(window.confirm('Buang kumpulan ini?')) {return true} else {return false}" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["newCategory"]) { ?>
  <br>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Kumpulan Baru </th>
    </tr>
    <tr>
      <td class="inputLabel">Kod Kumpulan : </td>
      <td><div id="newCodeDiv">
          <input name="newCode" type="text" class="inputInput" id="newCode" size="26" maxlength="20" onchange="this.value = this.value.toUpperCase(); ajaxCheckKodKumpulan(this.value);" />
          * (Sila pastikan kod kumpulan yang diisi belum wujud di dalam sistem)</div></td>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Nama :</td>
      <td width="662"><input name="newName" type="text" class="inputInput" id="newName" size="53" maxlength="100">
        * </td>
    </tr>
    <tr>
      <td class="inputLabel">Parent(s) Hierarchy  : </td>
      <td><textarea name="textarea" cols="50" class="inputInput" disabled="disabled" id="textarea" onDblClick="this.value = this.value + 'zzz'" onKeyUp="form1.saveScreenNew.disabled = false"></textarea>
        (pending)</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenNew" type="submit" class="inputButton" value="Simpan" onclick="if($F('newCode') == '' || $F('newName') == '') { window.alert('Sila isikan maklumat yang wajib diisi!'); return false;} else return true;"  />
          <input name="cancelScreenNew" type="submit" class="inputButton" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["editCategory"]) { ?>
  <br>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Kemaskini Kumpulan </th>
    </tr>
    <tr>
      <td class="inputLabel">Kod Kumpulan : </td>
      <td><div id="editCodeDiv">
          <input name="editCode" type="text" class="inputInput" id="editCode" value="<?php echo $showCatInfoRsRows[0]["GROUP_CODE"]?>" size="26" maxlength="20" onchange="this.value = this.value.toUpperCase(); ajaxCheckKodKumpulanEdit(this.value,$F('hiddenEditCode'));"  />
          <input type="hidden" name="hiddenEditCode" id="hiddenEditCode" value="<?php echo $showCatInfoRsRows[0]["GROUP_CODE"]?>" />
          * (Sila pastikan kod kumpulan yang diisi belum wujud di dalam sistem)</div></td>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Nama :</td>
      <td width="662"><input name="editName" type="text" class="inputInput" id="editName" value="<?php echo $showCatInfoRsRows[0]["DESCRIPTION"]?>" size="53" maxlength="100">
        * </td>
    </tr>
    <tr>
      <td class="inputLabel">Parent(s) Hierarchy  : </td>
      <td><textarea name="textarea" cols="50" class="inputInput" disabled="disabled" id="textarea" onDblClick="this.value = this.value + 'zzz'" onKeyUp="form1.saveScreenNew.disabled = false"></textarea>
        (pending)</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenEdit" type="submit" class="inputButton" id="saveScreenEdit" value="Simpan" onclick="if($F('editCode') == '' || $F('editName') == '') { window.alert('Sila isikan maklumat yang wajib diisi!'); return false;} else return true;" />
          <input name="cancelScreenEdit" type="submit" class="inputButton" id="cancelScreenEdit" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["newReference"]) { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Penugasan Pengguna </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Senarai Pengguna : </td>
      <td width="662"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center"><strong>Senarai Pengguna Yang Tidak Dipilih
                <!-- (<span id="countNewNonSelectedUser"><?php echo $countGetUserListRsRows;?></span>)-->
                </strong></div></td>
            <td>&nbsp;</td>
            <td width="300"><div align="center"><strong>Senarai Pengguna Yang  Dipilih
                <!-- (<span id="countNewSelectedUser"><?php if($countGetSelectedUserListRsRows != '') echo $countGetSelectedUserListRsRows; else echo 0?></span>)-->
                </strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="300"><div id="newNonSelectedUserDiv"><select style="width:300px;" name="newNonSelectedUser" size="10" multiple class="inputList" id="newNonSelectedUser" onfocus="$('newMoveLTR').disabled = false;" >
                <?php for($x=0; $x < $countGetUserListRsRows; $x++) { ?>
                <option value="<?php echo $getUserListRsRows[$x]["USERID"]?>" ><?php echo $getUserListRsRows[$x]["USERNAME"].' - '.$getUserListRsRows[$x]["NAME"]?></option>
                <?php } ?>
              </select></div></td>
            <td width="35"><div align="center">
                <input name="newMoveLTR" type="button" class="inputButton" disabled id="newMoveLTR" value="&gt;" style="margin-bottom:2px; width:26px;" onClick="$('removeFilter').disabled = true; $('removeFilter').style.color = '#CCCCCC'; $('filterNotSelected').disabled = true; $('filterNotSelected').style.background = '#EEEEEE'; $('filterSelected').disabled = true; $('filterSelected').style.background = '#EEEEEE'; moveoutid('newNonSelectedUser','newSelectedUser'); window.alert($(this).length)" />
                <input name="newMoveRTL" type="button" class="inputButton" id="newMoveRTL" value="&lt;" style="margin-bottom:2px; width:26px;"  onClick="$('filterNotSelected').disabled = true; $('filterNotSelected').style.background = '#EEEEEE'; $('filterSelected').disabled = true; $('filterSelected').style.background = '#EEEEEE'; moveinid('newNonSelectedUser','newSelectedUser'); " />
                <br>
                <input name="newMoveAllLTR" type="button" class="inputButton" id="newMoveAllLTR" value="&gt;&gt;" style="margin-bottom:2px; width:26px;" onClick="$('filterNotSelected').disabled = true; $('filterNotSelected').style.background = '#EEEEEE'; $('filterSelected').disabled = true; $('filterSelected').style.background = '#EEEEEE'; listBoxSelectall('newNonSelectedUser'); moveoutid('newNonSelectedUser','newSelectedUser'); " />
                <input name="newMoveAllRTL" type="button" class="inputButton" id="newMoveAllRTL" value="&lt;&lt;" style="margin-bottom:2px; width:26px;" onClick=" $('filterNotSelected').disabled = true; $('filterNotSelected').style.background = '#EEEEEE'; $('filterSelected').disabled = true; $('filterSelected').style.background = '#EEEEEE';listBoxSelectall('newSelectedUser'); moveinid('newNonSelectedUser','newSelectedUser'); " />
                <input name="newSort" type="button" class="inputButton" id="newSort" value="a-z" style="margin-bottom:2px;" onClick="sortListBox('newSelectedUser');sortListBox('newNonSelectedUser')   " />
              </div></td>
            <td><div id="newSelectedUserDiv"><select style="width:300px;" name="newSelectedUser[]" size="10" multiple class="inputList" id="newSelectedUser" >
                <?php for($x=0; $x < $countGetUserList_2RsRows; $x++) { ?>
                <option value="<?php echo $getUserList_2RsRows[$x]["USERID"]?>" ><?php echo $getUserList_2RsRows[$x]["USERNAME"].' - '.$getUserList_2RsRows[$x]["NAME"]?></option>
                <?php } ?>
              </select></div></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td class="inputLabel">Filter User : </td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="300"><input name="filterNotSelected" type="text" class="inputInput" id="filterNotSelected" value="<?php echo $showRefRsRows[0]["MENUNAME"]?>" size="56" onkeyup="if($F(this).length > 0) { $(this).style.background = '#EEEEEE'; } else {$(this).style.background = '#FFFFFF'} ajaxFilterNotSelectedUser(this.value,<?php echo $_POST['code']?>)" /></td>
            <td width="35"><br>            </td>
            <td width="300"><input name="filterSelected" type="text" class="inputInput" id="filterSelected" value="<?php echo $showRefRsRows[0]["MENUNAME"]?>" size="56" onkeyup="if($F(this).length > 0) { $(this).style.background = '#EEEEEE'; } else {$(this).style.background = '#FFFFFF'} ajaxFilterSelectedUser(this.value,<?php echo $_POST['code']?>)" /></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td class="inputLabel">Note : </td>
      <td> Please remove filter before submitting form. Filter cannot be used after after transferring user from one window to another.</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
        <input name="removeFilter" type="button" class="inputButton" id="removeFilter" value="Remove Filter" onclick="$('filterNotSelected').value = ''; $('filterNotSelected').onkeyup(); $('filterSelected').value = ''; $('filterSelected').onkeyup();" />
          <input name="saveScreenRefNew" type="submit" class="inputButton" id="saveScreenRefNew" value="Simpan" onClick="listBoxSelectall('newSelectedUser');" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["editPermission"]) { 
  ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th width="662">Kebenaran Akses Ke Menu : <?php echo strtoupper($_POST['hiddenMenuName']); ?></th>
    </tr>
    <?php for($x=0; $x < $countSecondLevelRsRows; $x++) {
  
		   /*$thirdLevel = "select * from FLC_MENU 
							where  MENUSTATUS = 1
							and MENUROOT = ".$_POST['hiddenCode']." 
							and MENUPARENT = ".$secondLevelRsRows[$x]['MENUID']."
							and menulevel = 3
							order by MENUORDER"; -fais20090325*/
			$thirdLevel = "select * from FLC_MENU 
							where MENUROOT = ".$_POST['hiddenCode']." 
							and MENUPARENT = ".$secondLevelRsRows[$x]['MENUID']."
							and menulevel = 3
							order by MENUORDER";
			$thirdLevelRsRows = $myQuery->query($thirdLevel,'SELECT','NAME');	
			$countThirdLevelRsRows = count($thirdLevelRsRows);
			
			//set level 2 hover style
			$level2HoverStyle = "style=\"";
			
			if($editGetMaxLevelRsRows[0]['MAXMENULEVEL'] == 3) 
				$level2HoverStyle .= "background-color:#E1F0FF;\" onmouseover=\"this.style.background = '#FFFFCC'\" onmouseout=\"this.style.background = '#E1F0FF'\"";
			
			if($editGetMaxLevelRsRows[0]['MAXMENULEVEL'] == 2) 
				$level2HoverStyle .= "background-color:#FFFFFF;\" onmouseover=\"this.style.background = '#FFFFCC'\" onmouseout=\"this.style.background = '#FFFFFF'\"";
				
			//for 2nd level checking
			if(count($previousPermissionArr) > 0)
			{	
				if(in_array($secondLevelRsRows[$x]['MENUID'],$previousPermissionArr))
					$level2Checked = " checked";
				else
					$level2Checked = '';
			}
   ?>
    <tr>
      <td class="listingContent" <?php echo $level2HoverStyle;?>><label style="display:block; cursor:pointer">
        <input type="checkbox" name="menuPermission_<?php echo $secondLevelRsRows[$x]['MENUID']?>" id="menuPermission_<?php echo $secondLevelRsRows[$x]['MENUID']?>" value="1" <?php echo $level2Checked; ?> onclick="selectChildCheckbox(this,'menuPermission_')" />
        <?php echo $secondLevelRsRows[$x]['MENUNAME'];?></label></td>
    </tr>
    <?php 	for($y=0; $y < $countThirdLevelRsRows; $y++) 
			{
				if(count($previousPermissionArr) > 0)
				{
					//for 3rd level checking	
					if(in_array($thirdLevelRsRows[$y]['MENUID'],$previousPermissionArr)) 
						$level3Checked = " checked";
					else
						$level3Checked = '';
				}
	?>
    <tr>
      <td class="listingContent" onmouseover="this.style.background = '#FFFFCC'" onmouseout="this.style.background = '#FFFFFF'"><label style="display:block; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="menuPermission_<?php echo $secondLevelRsRows[$x]['MENUID']?>_<?php echo $thirdLevelRsRows[$y]['MENUID']?>" id="menuPermission_<?php echo $secondLevelRsRows[$x]['MENUID']?>_<?php echo $thirdLevelRsRows[$y]['MENUID']?>" value="1" <?php echo $level3Checked; ?>  />
        <?php echo $thirdLevelRsRows[$y]['MENUNAME'];?></label></td>
    </tr>
    <?php } ?>
    <?php } ?>
    <tr>
      <td bgcolor="#F7F3F7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;&nbsp;</td>
            <td><div align="right">
                <input name="selectAll" type="button" class="inputButton" id="selectAll" value="Select All" onclick="prototype_selectAllCheckbox()" />
                <input name="unselectAll" type="button" class="inputButton" id="unselectAll" value="Unselect All" onclick="prototype_unselectAllCheckbox()" />
                |
                <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $_POST["hiddenCode"];?>" />
                <input name="saveScreenRefEdit" type="submit" class="inputButton" id="saveScreenRefEdit" value="Simpan" />
                <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?php } ?>
 
<?php if($_POST["refPermission"]) { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th width="662">Penugasan Kebenaran Akses Rujukan</th>
    </tr>
    <?php for($x=0; $x < $refListAllCount; $x++){?>
    <tr>
      <td class="listingContent" style="background-color:#FFFFFF;" onmouseover="this.style.background = '#FFFFCC'" onmouseout="this.style.background = '#FFFFFF'">
      <label style="display:block; cursor:pointer">
        <input type="checkbox" name="referenceID[]" id="referenceID[]" value="<?php echo $refListAll[$x][0];?>" <?php for($y=0;$y<$refListCount;$y++){if($refList[$y][0]==$refListAll[$x][0]){?>  checked="checked"<?php }}?> />
        <?php echo $refListAll[$x][1];?></label></td>
    </tr>
    <?php } ?>
    <tr>
      <td bgcolor="#F7F3F7">
      	<div align="right">
            <input name="selectAll" type="button" class="inputButton" id="selectAll" value="Select All" onclick="prototype_selectAllCheckbox()" />
            <input name="unselectAll" type="button" class="inputButton" id="unselectAll" value="Unselect All" onclick="prototype_unselectAllCheckbox()" />
            |
            <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $_POST["code"];?>" />
            <input name="saveRefPermission" type="submit" class="inputButton" id="saveRefPermission" value="Simpan" />
            <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div>
      </td>
    </tr>
  </table>
  <?php } ?>
</form>

<?php if(count($referenceRsArr) > 10) { ?>
</div>
<?php } ?>

<!--user list-->
<?php if($_POST["showScreen"] && $_POST["code"] != "") { ?>
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="7"><label style="cursor:pointer" onclick="if($F('senaraiPenggunaToggler') == 0) {up(3).next().hide(); $('senaraiPenggunaToggler').value = 1; $(this).innerHTML = '[ + ]'} else {up(3).next().show(); $('senaraiPenggunaToggler').value = 0;$(this).innerHTML = '[ - ]'}">[ - ]</label>
      Senarai Pengguna - <?php echo '('.count($referenceRsArr).')'; ?>
      <input name="senaraiPenggunaToggler" id="senaraiPenggunaToggler"  type="hidden" value="0" />
    </th>
  </tr>
</table>
<?php if(count($referenceRsArr) > 10) { ?>
<div style="overflow:auto; height:300px;">
<?php } ?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <?php if(count($referenceRsArr) > 0) { ?>
  <tr>
    <td width="15" class="listingHead">#</td>
    <td width="100" class="listingHead">Nama Pengguna </td>
    <td class="listingHead">Nama Penuh </td>
    <td width="80" class="listingHead">Tarikh Tambah </td>
    <td width="80" class="listingHead">Oleh</td>
    <td width="40" class="listingHeadRight">&nbsp;</td>
  </tr>
  <?php for($x=0; $x < count($referenceRsArr); $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["USERNAME"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["NAME"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["ADDED_DATE"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["ADDED_BY"];?></td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" name="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" method="post" action="">
        <input name="deleteReference" type="submit" class="inputButton" id="deleteReference" value="buang" onClick="if(window.confirm('Anda pasti untuk mengeluarkan pengguna <?php echo strtoupper($referenceRsArr[$x]["USERNAME"]);?> ini dari kumpulan ini?')) {return true} else {return false}"/>
        <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $referenceRsArr[$x]["USERID"];?>" />
        <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="6" class="myContentInput">&nbsp;Tiada pengguna ditemui.. </td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="6" bgcolor="#F7F3F7"><div align="right">
        <form id="form2" name="form2" method="post" action="">
          <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
          <input name="newReference" type="submit" class="inputButton" id="newReference" value="Penugasan Pengguna" />
          <input name="saveScreen2" type="submit" class="inputButton" value="Tutup" />
        </form>
      </div></td>
  </tr>
</table>
</div>
<?php } ?>
<!--eof user list-->

<?php if($_POST["showScreen"] && $_POST["code"] != "") { ?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="7"><label style="cursor:pointer" onclick="if($F('senaraiPermissionMenuToggler') == 0) {up(3).next().hide(); $('senaraiPermissionMenuToggler').value = 1; $(this).innerHTML = '[ + ]'} else {up(3).next().show(); $('senaraiPermissionMenuToggler').value = 0;$(this).innerHTML = '[ - ]'}">[ - ]</label>
      Senarai Ringkasan  Akses Ke Menu / Page - <?php echo '('.$countMenuPermissionRsArr.')'; ?>
      <input name="senaraiPermissionMenuToggler" id="senaraiPermissionMenuToggler"  type="hidden" value="0" /></th>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <?php if($countMenuPermissionRsArr > 0) { ?>
  <tr>
    <td width="15" class="listingHead">#</td>
    <td class="listingHead">Menu Utama</td>
    <td width="50" class="listingHead">Dibenarkan</td>
    <td width="45" class="listingHead">Tidak Dibenarkan</td>
    <td width="60" class="listingHeadRight">&nbsp;</td>
  </tr>
  <?php for($x=0; $x < $countMenuPermissionRsArr; $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo ucwords(strtolower($menuPermissionRsArr[$x]['MENUNAME']));?></td>
    <td class="listingContent"><div align="right" <?php if($getAllowedCount[$x] == 0) { ?>style="color:#FF0000"<?php }?> ><?php echo $getAllowedCount[$x];?>&nbsp;</div></td>
    <td class="listingContent"><div align="right"><?php echo $getDeniedCount[$x];?>&nbsp;</div></td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" name="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" method="post" action="">
        <input name="editPermission" type="submit" class="inputButton" id="editPermission" value="Kemaskini" />
        <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $menuPermissionRsArr[$x]['MENUID'];?>" />
        <input name="hiddenMenuName" type="hidden" id="hiddenMenuName" value="<?php echo $menuPermissionRsArr[$x]['MENUNAME'];?>" />
        <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="5" class="myContentInput">&nbsp;Tiada kebenaran ditemui.. </td>
  </tr>
  <?php 	} //end else?>
</table>
<?php }?>

<!--start reference-->
<?php if($_POST["showScreen"] && $_POST["code"] != "") { ?>
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="7"><label style="cursor:pointer" onclick="if($F('senaraiPenggunaToggler') == 0) {up(3).next().hide(); $('senaraiPenggunaToggler').value = 1; $(this).innerHTML = '[ + ]'} else {up(3).next().show(); $('senaraiPenggunaToggler').value = 0;$(this).innerHTML = '[ - ]'}">[ - ]</label>
      Senarai Akses Rujukan - <?php echo '('.$refListCount.')'; ?>
      <input name="senaraiPenggunaToggler" id="senaraiPenggunaToggler"  type="hidden" value="0" />
    </th>
  </tr>
</table>
<?php if($refListCount > 10) { ?>
<div style="overflow:auto; height:300px;">
<?php } ?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <?php if($refListCount > 0) { ?>
  <tr>
    <td width="15" class="listingHead">#</td>
    <td width="150" class="listingHead">Nama Rujukan </td>
    <td class="listingHead">Tajuk Rujukan </td>
    </tr>
  <?php for($x=0; $x < $refListCount; $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo $refList[$x][2];?></td>
    <td class="listingContent"><?php echo $refList[$x][1];?></td>
    </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="3" class="myContentInput">Tiada rujukan ditemui.. </td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="3" bgcolor="#F7F3F7"><div align="right">
        <form id="form2" name="form2" method="post" action="">
          <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
          <input name="refPermission" type="submit" class="inputButton" id="refPermission" value="Kemaskini" />
          <input name="close" type="submit" class="inputButton" value="Tutup" />
        </form>
      </div></td>
  </tr>
</table>
</div>
  <?php } ?>
<!--eof reference-->