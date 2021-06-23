<?php
//14-10-2009 (Update control permissions)

//===========================================reference==========================================
//if new reference added
if($_POST['saveScreenRefNew'])
{	
	//get max pageid
	$getMax = "select max(CONTROLID) from FLC_PAGE_CONTROL";
	$getMaxRs = $myQuery->query($getMax,'COUNT');
	
	//to prevent error
	if($_POST['newControlOrder'] == '')
		$_POST['newControlOrder'] = 1;
	
	//insert into page control table
	$insertRef = "insert into FLC_PAGE_CONTROL (CONTROLID,CONTROLNAME,CONTROLTYPE,CONTROLNOTES,CONTROLORDER,
					CONTROLREDIRECTURL,CONTROLJAVASCRIPTEVENT,CONTROLJAVASCRIPT,PAGEID, CONTROLIMAGEURL, COMPONENTID) 
					values (".($getMaxRs + 1).",'".$_POST['newControlName']."',".$_POST['newControlType'].",'".$_POST['newControlNotes']."',
					".$_POST['newControlOrder'].",'".$_POST['newRedirectURL']."','".$_POST['newControlJavascriptEvent']."','".($_POST['newControlJavascript'])."',
					".$_POST['code'].",'".$_POST['newImageURL']."','".$_POST['newComponentID']."')";
	$insertRefRs = $myQuery->query($insertRef,'RUN');
	
	/*===insert at specified position===*/
	//get current orders for component by page
	$getOrder = "select CONTROLORDER, CONTROLID from FLC_PAGE_CONTROL
					where PAGEID='".$_POST['code']."' and CONTROLID != '".($getMaxRs+1)."'
					order by CONTROLORDER,CONTROLID";
	$getOrderRs = $myQuery->query($getOrder,'SELECT');
	$getOrderRsCount = count($getOrderRs);
	
	//increment current component order
	$orderIncrement=false;
	for($x=0; $x<$getOrderRsCount; $x++)
	{
		if($getOrderRs[$x][0]==$_POST['newControlOrder'])
		{
			$orderIncrement=true;
		}
		
		if($orderIncrement)
		{
			$orderUpdate = "update FLC_PAGE_CONTROL
							set CONTROLORDER=".(int)++$getOrderRs[$x][0]."
							where CONTROLID='".$getOrderRs[$x][1]."'";
			$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
		}
	}
	
	
	
	//== permission for dashboard (14-10-2009)=====================================================================
		
			
			$selectedGroupCount=count($_POST['selectedGroup']);
		
			//loop on count
			for($x=0;$x<$selectedGroupCount;$x++)
			{
					//insert permission
				$sqlxx="insert into FLC_PAGE_CONTROL_PERMISSIONS (CONTROL_ID,GROUP_ID,ADDED_BY,ADDED_DATE)
						values
						(
							'".$mySQL->maxValue('FLC_PAGE_CONTROL','CONTROLID',0)."', '".$_POST['selectedGroup'][$x]."'
							,'".$_SESSION['userID']."',".$mySQL->currentDate()."
						)";
				$insertxx=$myQuery->query($sqlxx,'RUN');
				
				//if permission insert success
				if($insert)
					$permissionSuccess++;
				else
					$permissionError++;
			}//eof for
			
			//if have error
			if($permissionError)
			{
				$eventType='error';
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
				$message.=$permissionError.$insertErrorSuccessNotification;
			}//eof if
			else
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
			//== eof permission =============================================================
	
	//update versioning
	//xml_version_update($menuid);
}


//if save screen edit reference
if($_POST['saveScreenRefEdit'])
{	
	//to prevent error
	if($_POST['editControlOrder'] == '')
		$_POST['editControlOrder'] = 1;
	
	//update reference
	$updateRef = "update FLC_PAGE_CONTROL 
					set CONTROLNAME = '".$_POST['editControlName']."', 
					CONTROLTYPE = '".$_POST['editControlType']."',
					CONTROLORDER = '".$_POST['editControlOrder']."', 
					CONTROLNOTES = '".$_POST['editControlNotes']."',
					CONTROLREDIRECTURL = '".$_POST['editRedirectURL']."',
					CONTROLJAVASCRIPTEVENT = '".$_POST['editControlJavascriptEvent']."',
					CONTROLJAVASCRIPT = '".$_POST['editControlJavascript']."',
					CONTROLIMAGEURL = '".$_POST['editImageURL']."',
					COMPONENTID = '".$_POST['editComponentID']."'
					where CONTROLID = ".$_POST['hiddenCode'];
	$updateRefRs = $myQuery->query($updateRef,'RUN');
	
	/*===insert at specified position===*/
	//get current orders for component by page
	$getOrder = "select CONTROLORDER, CONTROLID from FLC_PAGE_CONTROL
					where PAGEID='".$_POST['code']."' and CONTROLID != '".$_POST['hiddenCode']."'
					order by CONTROLORDER,CONTROLID";
	$getOrderRs = $myQuery->query($getOrder,'SELECT');
	$getOrderRsCount = count($getOrderRs);
	
	//increment current component order
	$orderIncrement=false;
	for($x=0; $x<$getOrderRsCount; $x++)
	{
		if($getOrderRs[$x][0]==$_POST['editControlOrder'])
		{
			$orderIncrement=true;
		}//eof if
		
		if($orderIncrement)
		{
			$orderUpdate = "update FLC_PAGE_CONTROL
							set CONTROLORDER=".(int)++$getOrderRs[$x][0]."
							where CONTROLID='".$getOrderRs[$x][1]."'";
			$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
		}//eof if
	}//eof for
	
	//update versioning
	//xml_version_update($menuid);
	
	
	//==  permission for dashboard (14-10-2009) =====================================================================
			
			$selectedGroupCount=count($_POST['selectedGroupEdit']);
			
				//delete permission
			$sql="delete from FLC_PAGE_CONTROL_PERMISSIONS where CONTROL_ID='".$_POST['hiddenCode']."'";
			$delete=$myQuery->query($sql,'RUN');
			
			//loop on count
			for($x=0;$x<$selectedGroupCount;$x++)
			{
				//insert permission
				$sqlxx="insert into FLC_PAGE_CONTROL_PERMISSIONS (CONTROL_ID,GROUP_ID,ADDED_BY,ADDED_DATE)
						values
						(
							'".$_POST['hiddenCode']."', '".$_POST['selectedGroupEdit'][$x]."'
							,'".$_SESSION['userID']."',".$mySQL->currentDate()."
						)";
				$insertxx=$myQuery->query($sqlxx,'RUN');
				
				//if permission insert success
				if($insert)
					$permissionSuccess++;
				else
					$permissionError++;
			}//eof for
			
			//if have error
			if($permissionError)
			{
				$eventType='error';
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
				$message.=$permissionError.$insertErrorSuccessNotification;
			}//eof if
			else
				$message.=$permissionSuccess.$insertPermissionSuccessNotification;
			//== eof permission =============================================================
}//eof if

//if reference deleted
if($_POST['deleteReference'])
{	
	//delete page control
	$deleteRef = "delete from FLC_PAGE_CONTROL 
					where CONTROLID = ".$_POST['hiddenCode'];
	$deleteRefRs = $myQuery->query($deleteRef,'RUN');
	//update versioning
	//xml_version_update($menuid);
}

//if new reference clicked
if($_POST['newReference'])
{
	//get max pageid
	$getMaxOrder = "select max(CONTROLORDER) from FLC_PAGE_CONTROL where PAGEID='".$_POST['code']."'";
	$getMaxOrderRs = $myQuery->query($getMaxOrder,'COUNT');
}

//if edit reference clicked, show detail
if($_POST['editReference'])
{
	//show reference detail
	$showRef = "select b.CONTROLID, b.CONTROLNAME, b.CONTROLTYPE as CONTROLTYPEID, b.CONTROLORDER, b.CONTROLREDIRECTURL, 
				b.CONTROLJAVASCRIPTEVENT, b.CONTROLJAVASCRIPT, b.CONTROLNOTES, b.PAGEID, c.DESCRIPTION1 as CONTROLTYPE, b.CONTROLIMAGEURL, b.COMPONENTID
				from FLC_PAGE a, FLC_PAGE_CONTROL b, REFSYSTEM c 
					where 
					a.PAGEID = b.PAGEID 
					and ".$mySQL->convertToChar('b.CONTROLTYPE')." = c.REFERENCECODE 
					and c.MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'PAGE_CONTROL_TYPE')
					and b.PAGEID = '".$_POST['code']."' 
					and b.CONTROLID = '".$_POST['hiddenCode']."'
					order by CONTROLID";
	$showRefRs = $myQuery->query($showRef,'SELECT','NAME');
}

//if reset ordering button clicked
if($_POST['resetControlOrder'])
{
	//get menu ordering level 2
	$getOrder = "select CONTROLID from FLC_PAGE_CONTROL where PAGEID = ".$_POST['code']." 
						order by CONTROLORDER";
	$getOrderRs = $myQuery->query($getOrder,'SELECT','NAME');
	
	//count result rows
	$countControl = count($getOrderRs);
	
	//update control
	for($x=0; $x < $countControl; $x++)
	{
		$updateOrder = "update FLC_PAGE_CONTROL set CONTROLORDER = ".($x+1)." 
								where CONTROLID = ".$getOrderRs[$x]['CONTROLID'];
		$updateOrderComponentFlag = $myQuery->query($updateOrder,'RUN');
	}	//eof for
}

//===========================================//reference==========================================

if($_POST['saveScreenRefNew'] || $_POST['saveScreenRefEdit'] || $_POST['deleteReference'] || $_POST['resetControlOrder'])
	$_POST['showScreen'] = true;

//if showScreen and code not null
if($_POST['showScreen'] && $_POST['code'] != "")
{
	//get reference
	$reference = "select b.*, c.DESCRIPTION1 as CONTROLTYPE 
					from FLC_PAGE a, FLC_PAGE_CONTROL b, REFSYSTEM c 
					where 
					a.PAGEID = b.PAGEID 
					and ".$mySQL->convertToChar('b.CONTROLTYPE')." = c.REFERENCECODE 
					and c.MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'PAGE_CONTROL_TYPE') 
					and b.PAGEID = '".$_POST['code']."' 
					order by CONTROLORDER";
	$referenceRs = $myQuery->query($reference,'SELECT','NAME');
	$countReference = count($referenceRs);
}//eof if

//get list of page menu
$generalRs = $mySQL->menu($_POST['pageSearch']);		//function page (func_sql.php)
$countGeneral = count($generalRs);

//get list of control types
$controlType = "select REFERENCECODE,DESCRIPTION1 from REFSYSTEM 
				where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'PAGE_CONTROL_TYPE') 
				order by description1";
$controlTypeRs = $myQuery->query($controlType,'SELECT','NAME');
$countControl = count($controlTypeRs);

//button javascript event
$event = "select REFERENCECODE,DESCRIPTION1 from REFSYSTEM 
				where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'PAGE_CTRL_ACTION_JS_BUTTON')";
$eventRs = $myQuery->query($event,'SELECT','NAME');
$countEvent = count($eventRs);

//list of component by pageid
$componentList = "select componentid, componentname from FLC_PAGE_COMPONENT where pageid='".$_POST['code']."'";
$componentListRs = $myQuery->query($componentList,'SELECT','NAME');
$componentListRsCount = count($componentListRs);
?>

<script language="javascript">
function codeDropDown(elem)
{	
	if(elem.selectedIndex != 0) 
	{ 
		document.form1.showScreen.disabled = false;
		document.form1.showScreen.style.color = '#000000'; 
	} 
	else 
	{	
		document.form1.showScreen.disabled = true; 
		document.form1.showScreen.style.color = '#999999'; 
	}
}

</script>
<script language="javascript" src="js/editor.js"></script>
<div id="breadcrumbs">Modul Pentadbir Sistem / Page Control /
  <?php if($_POST['editScreen']) echo " Edit /"?>
</div>
<h1>Page Control </h1>
<?php //if insert reference successful
  if($insertRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>New control has been added.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($deleteRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Control has been removed. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($updateRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Control has been updated. </td>
  </tr>
</table>
<br />
<?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <?php if(!isset($_POST['editScreen']))  { ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Page List </th>
    </tr>
	<tr>
      <td nowrap="nowrap" class="inputLabel">Page Search : </td>
      <td><input name="pageSearch" type="text" id="pageSearch" size="50" class="inputInput" value="<?php echo $_POST['pageSearch']?>" onkeyup="ajaxUpdatePageSelector('page','updateSelectorDropdown',this.value)" /></td>
    </tr>
    <tr>
      <td width="74" nowrap="nowrap" class="inputLabel">Page : </td>
      <td width="662">
	  <div id="updateSelectorDropdown">
	  <select name="code" class="inputList" id="code" onChange="codeDropDown(this);">
          <option value="">&lt; Pilih Page &gt;</option>
          <?php for($x=0; $x < $countGeneral; $x++) { ?>
          <option value="<?php echo $generalRs[$x]['PAGEID']?>" <?php if($_POST['code'] == $generalRs[$x]['PAGEID']) echo "selected";?>><?php echo $generalRs[$x]['MENUNAME']?></option>
          <?php } ?>
      </select>
        <input name="showScreen" type="submit" class="inputButton" id="showScreen" value="Tunjuk Senarai" <?php if(!$_POST['code']) { ?>disabled="disabled" style="color:#999999"<?php } ?> />
	  </div>
	  </td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST['newReference'] && !isset($_POST['saveScreenRefNew']) && !isset($_POST['showScreen']) && !isset($_POST['cancelScreen'])) {
  
  //list group user non selected (13-10-2009)
	$groupListAll=$mySQL->getUserGroupAllDash();
	$groupListAllCount=count($groupListAll);
  
   ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">New Page Control </th>
    </tr>
    <tr>
       <td class="inputLabel">Nama : </td>
       <td><input name="newControlName" type="text" class="inputInput" id="newControlName" size="50" onkeyup="form1.saveScreenRefNew.disabled = false" /></td>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Type : </td>
      <td width="662"><select name="newControlType" class="inputList" id="newControlType" />
          <?php for($x=0; $x < $countControl; $x++) { ?>
          <option value="<?php echo $controlTypeRs[$x]['REFERENCECODE']?>" <?php if($_POST['newControlType'] == $controlTypeRs[$x]['REFERENCECODE']) { ?>selected<?php }?> ><?php echo $controlTypeRs[$x]['DESCRIPTION1']?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
       <td class="inputLabel">Order : </td>
       <td><label>
         <input name="orderOption" type="radio" checked="checked" onclick="swapItemDisplay('newControlOrderText', 'newControlOrderCombo')" />
         At</label>
           <label>
           <input name="orderOption" type="radio" onclick="swapItemDisplay('newControlOrderCombo', 'newControlOrderText'); showControl('<?php echo $_POST['code'];?>')" />
             Before</label>
           <label>
           <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('newControlOrderCombo', 'newControlOrderText'); showControl('<?php echo $_POST['code'];?>')" />
             After</label>
           <br />
           <input name="newControlOrder" type="text" class="inputInput" id="newControlOrderText" value="<?php echo $getMaxOrderRs+1;?>" size="5" />
           <span id="hideEditorList"> </span> </td>
     </tr>
	<tr>
      <td nowrap="nowrap" class="inputLabel">Redirect URL : </td>
	  <td><input name="newRedirectURL" type="text" class="inputInput" id="newRedirectURL" size="70" /></td>
    </tr>
	<tr>
	  <td nowrap="nowrap" class="inputLabel">Image Path : </td>
	  <td><input name="newImageURL" type="text" class="inputInput" id="newImageURL" size="70" /> 
	    *Leave blank to use default button </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Javascript Event :</td>
      <td>
	  	<select name="newControlJavascriptEvent" class="inputList" id="newControlJavascriptEvent">
			  <option value="">&nbsp;</option>
			  <?php for($x=0; $x < $countEvent; $x++) { ?>
			  <option value="<?php echo $eventRs[$x]['REFERENCECODE']?>" ><?php echo $eventRs[$x]['DESCRIPTION1']?></option>
			  <?php } ?>
		</select>      </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Javascript : </td>
      <td><textarea name="newControlJavascript" cols="100" rows="10" class="inputInput" id="newControlJavascript"></textarea></td>   
    </tr>
    <tr>
      <td class="inputLabel">Notes : </td>
      <td><textarea name="newControlNotes" cols="50" rows="3" class="inputInput" id="newControlNotes"></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Component Binding : </td>
      <td><select name="newComponentID" class="inputList" id="newComponentID">
        <option value="">&nbsp;</option>
        <?php for($x=0; $x < $componentListRsCount; $x++) { ?>
        <option value="<?php echo $componentListRs[$x]['COMPONENTID']?>" ><?php echo $componentListRs[$x]['COMPONENTNAME']?></option>
        <?php } ?>
      </select></td>
    </tr>
    
  </table>
  <BR />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Control Permission</th>
    </tr>
    <tr>
      <td class="inputLabel">Senarai Akses : </td>
      <td><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center"><strong>Senarai Kumpulan Yang Tidak Dipilih
            </strong></div></td>
            <td>&nbsp;</td>
            <td><div align="center"><strong>Senarai Kumpulan Yang  Dipilih
            </strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="250"><select style="width:250px;" name="nonSelectedGroup" size="10" multiple class="inputList" id="nonSelectedGroup" >
                <?php 
				
				
				for($x=0; $x < $groupListAllCount; $x++) { ?>
                <option value="<?php echo $groupListAll[$x][0]?>" ><?php echo $groupListAll[$x][1];?></option>
                <?php } ?>
              </select></td>
            <td width="35"><div align="center">
                <input name="newMoveLTR" type="button" class="inputButton" id="newMoveLTR" value="&gt;" style="margin-bottom:2px;" onClick="moveoutid('nonSelectedGroup','selectedGroup'); " />
                <input name="newMoveRTL" type="button" class="inputButton" id="newMoveRTL" value="&lt;" style="margin-bottom:2px;"  onClick="moveinid('nonSelectedGroup','selectedGroup'); " />
                <br>
                <input name="newMoveAllLTR" type="button" class="inputButton" id="newMoveAllLTR" value="&gt;&gt;" style="margin-bottom:2px;" onClick="listBoxSelectall('nonSelectedGroup'); moveoutid('nonSelectedGroup','selectedGroup'); " />
                <input name="newMoveAllRTL" type="button" class="inputButton" id="newMoveAllRTL" value="&lt;&lt;" style="margin-bottom:2px;" onClick="listBoxSelectall('selectedGroup'); moveinid('nonSelectedGroup','selectedGroupEdit'); " />
                <input name="newSort" type="button" class="inputButton" id="newSort" value="a-z" style="margin-bottom:2px;" onClick="sortListBox('selectedGroup');sortListBox('nonSelectedGroup')   " />
              </div></td>
            <td><select style="width:250px;" name="selectedGroup[]" size="10" multiple class="inputList" id="selectedGroup" >
                <?php for($x=0; $x < $groupListSelectedCount; $x++) { ?>
                <option value="<?php echo $groupListSelected[$x][0]?>" ><?php echo $groupListSelected[$x][1];?></option>
                <?php } ?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="newReference" type="hidden" id="newReference" value="<?php echo $_POST['newReference'];?>" />
          <input name="code" type="hidden" id="code" value="<?php echo $_POST['code'];?>" />
          <input name="saveScreenRefNew" onclick="listBoxSelectall('selectedGroup');" type="submit" disabled="disabled" class="inputButton" id="saveScreenRefNew" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  
  
  
  <?php } ?>
  <?php if($_POST['editReference'] && !isset($_POST['cancelScreen']) && !isset($_POST['showScreen'])) { 
  
  ////list group user non selected (14-10-2009)
	$groupListNonSelected=$mySQL->getUserGroupNonSelectedControl($showRefRs[0]['CONTROLID']);
	$groupListNonSelectedCount=count($groupListNonSelected);
	
	//list group user selected (14-10-2009)
	$groupListSelected=$mySQL->getUserGroupSelectedControl($showRefRs[0]['CONTROLID']);
	$groupListSelectedCount=count($groupListSelected);
  
  ?>
  <br />

<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Modify Page Control </th>
    </tr>
	<tr>
        <td class="inputLabel">Name : </td>
	    <td><input name="editControlName" type="text" class="inputInput" id="editControlName" onkeyup="form1.saveScreenRefEdit.disabled = false" value="<?php echo $showRefRs[0]['CONTROLNAME']?>" size="50" /></td>
    </tr>
	<tr>
      <td width="74" class="inputLabel">Type : </td>
      <td width="662"><select name="editControlType" class="inputList" id="editControlType" />
          <?php for($x=0; $x < $countControl; $x++) { ?>
          <option value="<?php echo $controlTypeRs[$x]['REFERENCECODE']?>" <?php 
		  		if(!isset($_POST['editControlType'])) 
				{ 
					if($showRefRs[0]['CONTROLTYPEID'] == $controlTypeRs[$x]['REFERENCECODE']) 
						echo "selected";
				} 
					else if($_POST['editControlType'] == $controlTypeRs[$x]['REFERENCECODE']) echo "selected";?> ><?php echo $controlTypeRs[$x]['DESCRIPTION1']?></option>
          <?php } ?>
        </select></td>
    </tr>
	<tr>
        <td class="inputLabel">Order : </td>
	    <td><label>
          <input name="orderOption" type="radio" checked="checked" onclick="swapItemDisplay('editControlOrderText', 'editControlOrderCombo')" />
	      At</label>
            <label>
            <input name="orderOption" type="radio" onclick="swapItemDisplay('editControlOrderCombo', 'editControlOrderText'); showControl('<?php echo $_POST['code'];?>', '<?php echo $_POST['hiddenCode'];?>')" />
              Before</label>
            <label>
            <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('editControlOrderCombo', 'editControlOrderText'); showControl('<?php echo $_POST['code'];?>', '<?php echo $_POST['hiddenCode'];?>')" />
              After</label>
            <br />
            <input name="editControlOrder" id="editControlOrderText" type="text" class="inputInput" value="<?php echo $showRefRs[0]['CONTROLORDER']?>" size="5" />
            <span id="hideEditorList"> </span> </td>
    </tr>
	<tr>
      <td nowrap="nowrap" class="inputLabel">Redirect URL : </td>
	  <td><input name="editRedirectURL" type="text" class="inputInput" id="editRedirectURL" value="<?php echo $showRefRs[0]['CONTROLREDIRECTURL']?>" size="70" /></td>
    </tr>
	<tr>
      <td nowrap="nowrap" class="inputLabel">Image Path : </td>
	  <td><input name="editImageURL" type="text" class="inputInput" id="editImageURL" value="<?php echo $showRefRs[0]['CONTROLIMAGEURL']?>" size="70" />
	    *Leave blank to use default button </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Javascript Event : </td>
      <td>
	  	<select name="editControlJavascriptEvent" class="inputList" id="editControlJavascriptEvent">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < $countEvent; $x++) { ?>
          <option value="<?php echo $eventRs[$x]['REFERENCECODE']?>" <?php if($eventRs[$x]['REFERENCECODE'] == $showRefRs[0]['CONTROLJAVASCRIPTEVENT']) echo "selected";?> ><?php echo $eventRs[$x]['DESCRIPTION1']?></option>
          <?php } ?>
        </select>      </td>
    </tr>
    <tr>
      <td class="inputLabel">Javascript : </td>
      <td><textarea name="editControlJavascript" cols="100" rows="10" class="inputInput" id="editControlJavascript"><?php echo $showRefRs[0]['CONTROLJAVASCRIPT']?></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Notes : </td>
      <td><textarea name="editControlNotes" cols="50" rows="3" class="inputInput" id="editControlNotes"><?php echo $showRefRs[0]['CONTROLNOTES']?></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Component Binding : </td>
      <td><select name="editComponentID" class="inputList" id="editComponentID">
			  <option value="" selected="selected">&nbsp;</option>
			  <?php for($x=0; $x < $componentListRsCount; $x++) { ?>
			  <option value="<?php echo $componentListRs[$x]['COMPONENTID']?>" <?php if($componentListRs[$x]['COMPONENTID']==$showRefRs[0]['COMPONENTID']){?> selected="selected"<?php }?> ><?php echo $componentListRs[$x]['COMPONENTNAME']?></option>
			  <?php } ?>
          </select></td>
    </tr>
  </table>
  <BR />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Control Permission</th>
    </tr>
    <tr>
      <td class="inputLabel">Senarai Akses : </td>
      <td><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center"><strong>Senarai Kumpulan Yang Tidak Dipilih
            </strong></div></td>
            <td>&nbsp;</td>
            <td><div align="center"><strong>Senarai Kumpulan Yang  Dipilih
            </strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="250"><select style="width:250px;" name="nonSelectedGroup" size="10" multiple class="inputList" id="nonSelectedGroup" >
                <?php 
				
				
				for($x=0; $x < $groupListNonSelectedCount; $x++) { ?>
                <option value="<?php echo $groupListNonSelected[$x][0]?>" ><?php echo $groupListNonSelected[$x][1];?></option>
                <?php } ?>
              </select></td>
            <td width="35"><div align="center">
                <input name="newMoveLTR" type="button" class="inputButton" id="newMoveLTR" value="&gt;" style="margin-bottom:2px;" onClick="moveoutid('nonSelectedGroup','selectedGroupEdit'); " />
                <input name="newMoveRTL" type="button" class="inputButton" id="newMoveRTL" value="&lt;" style="margin-bottom:2px;"  onClick="moveinid('nonSelectedGroup','selectedGroupEdit'); " />
                <br>
                <input name="newMoveAllLTR" type="button" class="inputButton" id="newMoveAllLTR" value="&gt;&gt;" style="margin-bottom:2px;" onClick="listBoxSelectall('nonSelectedGroup'); moveoutid('nonSelectedGroup','selectedGroupEdit'); " />
                <input name="newMoveAllRTL" type="button" class="inputButton" id="newMoveAllRTL" value="&lt;&lt;" style="margin-bottom:2px;" onClick="listBoxSelectall('selectedGroupEdit'); moveinid('nonSelectedGroup','selectedGroupEdit'); " />
                <input name="newSort" type="button" class="inputButton" id="newSort" value="a-z" style="margin-bottom:2px;" onClick="sortListBox('selectedGroupEdit');sortListBox('nonSelectedGroup')   " />
              </div></td>
            <td><select style="width:250px;" name="selectedGroupEdit[]" size="10" multiple class="inputList" id="selectedGroupEdit" >
                <?php for($x=0; $x < $groupListSelectedCount; $x++) { ?>
                <option value="<?php echo $groupListSelected[$x][0]?>" ><?php echo $groupListSelected[$x][1];?></option>
                <?php } ?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
   <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="editReference" type="hidden" id="editReference" value="<?php echo $_POST['editReference'];?>" />
          <input name="code" type="hidden" id="code" value="<?php echo $_POST['code'];?>" />
          <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $_POST['hiddenCode'];?>" />
          <input name="saveScreenRefEdit" onclick="listBoxSelectall('selectedGroupEdit');" type="submit" class="inputButton" id="saveScreenRefEdit" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  
  
  <?php } ?>
</form>
<?php if($_POST['showScreen'] && $_POST['code'] != "") { ?>
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="8">Page Control List </th>
  </tr>
  <?php if($countReference > 0) { ?>
  <tr>
    <td width="32" class="listingHead">#</td>
    <td class="listingHead">Name</td>
    <td class="listingHead">Type</td>
    <td width="40" class="listingHead">Order</td>
    <td width="40" class="listingHead">Image</td>
    <td width="40" class="listingHead">Component</td>
    <td class="listingHead">Notes</td>
    <td width="82" class="listingHeadRight">Aksi</td>
  </tr>
  <?php for($x=0; $x < $countReference; $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo $referenceRs[$x]['CONTROLNAME'];?></td>
    <td class="listingContent"><?php echo $referenceRs[$x]['CONTROLTYPE'];?></td>
    <td class="listingContent"><?php echo $referenceRs[$x]['CONTROLORDER'];?></td>
    <td nowrap="nowrap" class="listingContent"><?php echo $referenceRs[$x]['CONTROLIMAGEURL'];?></td>
    <td class="listingContent"><?php if($referenceRs[$x]['COMPONENTID']){echo $referenceRs[$x]['COMPONENTID'];}else {echo '-';}?></td>
    <td class="listingContent"><?php echo $referenceRs[$x]['CONTROLNOTES'];?>&nbsp;</td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $referenceRs[$x]['code'];?>" name="formReference<?php echo $referenceRs[$x]['code'];?>" method="post" action="">
        <input name="editReference" type="submit" class="inputButton" id="editReference" value="ubah" />
        <input name="deleteReference" type="submit" class="inputButton" id="deleteReference" value="buang" onClick="if(window.confirm('Are you sure you want to DELETE this control?')) {return true} else {return false}"/>
        <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $referenceRs[$x]['CONTROLID'];?>" />
        <input name="code" type="hidden" id="code" value="<?php echo $_POST['code'];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="8" class="myContentInput">&nbsp;&nbsp;No control(s) found.. </td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="8" bgcolor="#F7F3F7"><div align="right">
        <form id="form2" name="form2" method="post" action="">
          <input name="code" type="hidden" id="code" value="<?php echo $_POST['code'];?>" />
		  <input name="resetControlOrder" type="submit" class="inputButton" id="resetControlOrder" value="Reset Order" onclick="if(window.confirm('Are you sure you want to reset the control order?')) {return true} else {return false}" />
          <input name="newReference" type="submit" class="inputButton" id="newReference" value="New Page Control" />
          <input name="saveScreen2" type="submit" class="inputButton" value="Tutup" />
        </form>
      </div></td>
  </tr>
</table>
<br />
<em>&nbsp;&nbsp;&nbsp;Note: For search page, use redirect button. </em><br />
<?php } ?>
