<?php
//debuggin
//print_r($_POST);
require_once('class/sql_batch.php');
//if ajax is called 
if($_GET['type'] == 'ajax')
{	
	include_once('system_prerequisite.php');
}

//if show disabled parent menu not set
if(!isset($_POST['showDisabled']))
	$_POST['showDisabled'] = 0;

//============================================ parent menu ============================================
//if main category edit button clicked
if($_POST["code"] && $_POST["editCategory"])
{
	//show info of selected category
	$showCatInfo = "select * from FLC_DASHBOARD where DASH_ID = ".$_POST["code"]." ";
	$showCatInfoRsRows = $myQuery->query($showCatInfo,'SELECT','NAME');
}

//if new screen submitted
if($_POST["newCategory"])
{
	//get parent menu order
	$parentOrder = "select max(MENUORDER) + 1 as MAXPARENTORDER from FLC_MENU where MENULEVEL = 1";
	$parentOrderRsRows = $myQuery->query($parentOrder,'SELECT','NAME');
}

//if edit screen submitted
if($_POST["saveScreenEdit"])
{
	//update category
	$updateCat = "update FLC_DASHBOARD set 
					DASH_NAME = '".$_POST["editName"]."'
					where DASH_ID = ".$_POST["code"];
	$updateCatRs = $myQuery->query($updateCat,'RUN');
}

//if new category added
else if($_POST["saveScreenNew"])
{
	//insert category
	$insertCat = "insert into FLC_DASHBOARD (DASH_ID,DASH_NAME)
					values ((".$mySQL->maxValue('FLC_DASHBOARD','DASH_ID',0)."+1), '".$_POST["newName"]."')";
	$insertCatRs = $myQuery->query($insertCat,'RUN');
}

//if category deleted
else if($_POST["deleteCategory"])
{	
	//delete parent
	$deleteCat = "delete from FLC_DASHBOARD where DASH_ID = ".$_POST["code"];
	$myQuery->query($deleteCat,'RUN');

	//delete child
	//$deleteCatChild = "delete from FLC_MENU where MENUROOT = ".$_POST["code"];
	//$myQuery->query($deleteCatChild,'RUN');
}
//=====================================================================================================
//===========================================reference=================================================
//if new reference added
if($_POST["saveScreenRefNew"])
{
	if($_POST["ds_order"] == '')
		$_POST["ds_order"] = 1;

	if($_POST['ds_source_type'] == 'sql')
		$toStore = $_POST['ds_sql'];
	else if($_POST['ds_source_type'] == 'componentid')
		$toStore = $_POST['ds_componentid'];

	if($_POST['ds_width'] == '')
		$_POST['ds_width'] = 300;

	if($_POST['ds_height'] == '')
		$_POST['ds_height'] = 300;

	if($_POST['ds_title_size'] == '')
		$_POST['ds_title_size'] = 12;

	if($_POST['ds_title_angle'] == '')
		$_POST['ds_title_angle'] = 0;
		
	if($_POST['ds_type'] == 'listing')
	{	
		$_POST['ds_graph_type'] = '';
		$_POST["ds_output_format"] = '';
		$_POST['ds_show_legend'] = 'null';
		$_POST["ds_show_axis"] = 'null';
		$_POST['ds_bgcolor'] = '';
		$_POST['ds_title_color'] = '';
		$_POST['ds_title_size'] = 'null';
		$_POST['ds_title_angle'] = 'null';
	}//get max menuid
	
	$insertRef = "insert into FLC_DASHBOARD_ITEMS 
						(DASHITEM_ID,DASHITEM_ITEM_NAME,DASHITEM_ORDER,DASHITEM_TYPE,DASHITEM_GRAPH_TYPE,DASHITEM_OUTPUT_FORMAT,
						DASHITEM_SHOW_LEGEND,DASHITEM_SHOW_AXIS,DASHITEM_STATUS,DASHITEM_WIDTH,DASHITEM_HEIGHT,DASHITEM_BACKGROUND_COLOR,
						DASHITEM_GRAPH_TITLE_COLOR,DASHITEM_GRAPH_TITLE_SIZE,DASHITEM_GRAPH_TITLE_ANGLE,DASHITEM_DATA_SOURCE_TYPE,
						DASHITEM_DATA_SOURCE_TEXT,DASH_ID) values
						((".$mySQL->maxValue('FLC_DASHBOARD_ITEMS','DASHITEM_ID',0)."+1), '".trim($_POST["ds_name"])."',".settype(trim($_POST["ds_order"]),'integer').",'".$_POST['ds_type']."',
						'".$_POST["ds_graph_type"]."','".$_POST["ds_output_format"]."'
						,".settype($_POST['ds_show_legend'],'integer').",".settype($_POST["ds_show_axis"],'integer').",".$_POST['ds_status'].",
						".trim($_POST['ds_width']).",".trim($_POST['ds_height']).",
						'".$_POST['ds_bgcolor']."','".$_POST['ds_title_color']."',".$_POST['ds_title_size'].",".$_POST['ds_title_angle'].",
						'".$_POST['ds_source_type']."','".$toStore."',".$_POST['code'].")";
	$insertRefRs = $myQuery->query($insertRef,'RUN');
	
	
	
	//== permission for dashboard (13-10-2009)=====================================================================
		
			
			$selectedGroupCount=count($_POST['selectedGroup']);
		
			//loop on count
			for($x=0;$x<$selectedGroupCount;$x++)
			{
					//insert permission
				$sqlxx="insert into FLC_DASHBOARD_PERMISSIONS (DASHITEM_ID,GROUP_ID,ADDED_BY,ADDED_DATE)
						values
						(
							'".$mySQL->maxValue('FLC_DASHBOARD_ITEMS','DASHITEM_ID',0)."', '".$_POST['selectedGroup'][$x]."'
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

	//dummy to trigger 
	$_POST["showScreen"] = "some value";
}

//if edit
if($_POST["editReference"])
{
	//show menu parent
	 $edit = "select * from FLC_DASHBOARD_ITEMS where DASHITEM_ID = ".$_POST['hiddenCode'];
	$editRs = $myQuery->query($edit,'SELECT','NAME');	
}

//if reference deleted
if($_POST["deleteReference"])
{
	//delete reference
	$deleteRef = "delete from FLC_DASHBOARD_ITEMS 
					where DASHITEM_ID  = ".$_POST['hiddenCode'];
	$myQuery->query($deleteRef,'RUN');
	
	//dummy
	$_POST["showScreen"] = "some value";
}

//if save screen edit reference
if($_POST["saveScreenRefEdit"])
{	
	//echo $_POST["ds_order"];

	if($_POST["ds_order"] == '')
		$_POST["ds_order"] = 1;

	if($_POST['ds_source_type'] == 'sql')
		$toStore = $_POST['ds_sql'];
	else if($_POST['ds_source_type'] == 'componentid')
		$toStore = $_POST['ds_componentid'];

	if($_POST['ds_width'] == '')
		$_POST['ds_width'] = 300;

	if($_POST['ds_height'] == '')
		$_POST['ds_height'] = 300;

	if($_POST['ds_title_size'] == '')
		$_POST['ds_title_size'] = 12;

	if($_POST['ds_title_angle'] == '')
		$_POST['ds_title_angle'] = 0;
		
	if($_POST['ds_type'] == 'listing')
	{	
		$_POST['ds_graph_type'] = '';
		$_POST["ds_output_format"] = '';
		$_POST['ds_show_legend'] = 'null';
		$_POST["ds_show_axis"] = 'null';
		$_POST['ds_bgcolor'] = '';
		$_POST['ds_title_color'] = '';
		$_POST['ds_title_size'] = 'null';
		$_POST['ds_title_angle'] = 'null';
	}
	
	if($_POST['ds_show_legend'] == '')
		$_POST['ds_show_legend'] = 0;
	
	if($_POST['ds_show_axis'] == '')
		$_POST['ds_show_axis'] = 0;
	
	$updateRef = "update FLC_DASHBOARD_ITEMS 
					set 
					DASHITEM_ITEM_NAME = '".trim($_POST["ds_name"])."',
					DASHITEM_ORDER = ".trim($_POST["ds_order"]).",
					DASHITEM_TYPE = '".$_POST['ds_type']."',
					DASHITEM_GRAPH_TYPE = '".$_POST["ds_graph_type"]."',
					DASHITEM_OUTPUT_FORMAT = '".$_POST["ds_output_format"]."',
					DASHITEM_SHOW_LEGEND = ".$_POST['ds_show_legend'].",
					DASHITEM_SHOW_AXIS = ".$_POST["ds_show_axis"].",
					DASHITEM_STATUS = ".$_POST['ds_status'].",
					DASHITEM_WIDTH = ".trim($_POST['ds_width']).",
					DASHITEM_HEIGHT = ".trim($_POST['ds_height']).",
					DASHITEM_BACKGROUND_COLOR = '".$_POST['ds_bgcolor']."',
					DASHITEM_GRAPH_TITLE_COLOR = '".$_POST['ds_title_color']."',
					DASHITEM_GRAPH_TITLE_SIZE = ".trim($_POST['ds_title_size']).",
					DASHITEM_GRAPH_TITLE_ANGLE = ".trim($_POST['ds_title_angle']).",
					DASHITEM_DATA_SOURCE_TYPE = '".$_POST['ds_source_type']."',
					DASHITEM_DATA_SOURCE_TEXT = '".$toStore."'
					where DASHITEM_ID = ".$_POST['hiddenCode'];
	$updateRefRs = $myQuery->query($updateRef,'RUN');

	//==  permission for dashboard (13-10-2009) =====================================================================
			
			$selectedGroupCount=count($_POST['selectedGroupEdit']);
			
				//delete permission
			$sql="delete from FLC_DASHBOARD_PERMISSIONS where DASHITEM_ID='".$_POST['ds_id']."'";
			$delete=$myQuery->query($sql,'RUN');
			
			//loop on count
			for($x=0;$x<$selectedGroupCount;$x++)
			{
				//insert permission
				$sqlxx="insert into FLC_DASHBOARD_PERMISSIONS (DASHITEM_ID,GROUP_ID,ADDED_BY,ADDED_DATE)
						values
						(
							'".$_POST['ds_id']."', '".$_POST['selectedGroupEdit'][$x]."'
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
			
	//dummy
	$_POST["showScreen"] = "some value";
}

//===========================================//reference===============================================
//if showScreen and code not null
if($_POST["showScreen"] && $_POST["code"] != "")
{
	//get list of dashboard items
	$reference = "select * from FLC_DASHBOARD_ITEMS 
					where DASH_ID = ".$_POST['code']."
					order by DASHITEM_ITEM_NAME";
	$referenceRsArr = $myQuery->query($reference,'SELECT','NAME');
}

$general = "select * from FLC_DASHBOARD order by DASH_NAME";
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
</script>
<script language="javascript" src="js/editor.js"></script>

<div id="breadcrumbs">Modul Pentadbir Sistem / Dashboard Editor /
  <?php if($_POST["editScreen"]) echo " Edit /"?>
</div>
<h1>Dashboard Editor </h1>
<?php //if update successful
  if($insertCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Dashboard baru telah ditambah. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($deleteCatRs && $deleteCatChildRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Dashboard telah dibuang.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($updateCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Dashboard telah dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if insert reference successful
  if($insertRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Dashboard item baru telah ditambah. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($deleteRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Dashboard item telah dibuang. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($updateRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Dashboard item telah dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<form action="" method="post" name="form1" style="margin-bottom:0px;">
  <?php if(!isset($_POST["editScreen"]))  { ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Dashboard List dd </th>
    </tr>
    <tr>
      <td width="74" nowrap="nowrap" class="inputLabel">Dashboard  : </td>
      <td width="662"><select name="code" class="inputList" id="code" onChange="codeDropDown(this); form1.hiddenName.value = this.options[this.selectedIndex].label">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($generalRsArr); $x++) { ?>
          <option value="<?php echo $generalRsArr[$x]["DASH_ID"]?>" <?php if($_POST["code"] == $generalRsArr[$x]["DASH_ID"]) echo "selected";?>><?php echo $generalRsArr[$x]["DASH_ID"].' - '.$generalRsArr[$x]["DASH_NAME"]?></option>
          <?php } ?>
        </select>
        <input name="showScreen" type="submit" class="inputButton" id="showScreen" value="Show Details" <?php if(!$_POST["code"]) { ?>disabled="disabled" <?php } ?> />
        <input name="hiddenName" type="hidden" id="hiddenName" value=""></td>
    </tr>
    <tr>
      <td colspan="2" class="contentButtonFooter"><div align="right">
          <input name="editCategory" type="submit" class="inputButton" value="Edit" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> />
          <input name="deleteCategory" type="submit" class="inputButton" value="Delete" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> onClick="if(window.confirm('Are you sure you want to DELETE this menu?\nThis will also delete ALL sub-menu under this menu')) {return true} else {return false}" />
          <input name="newCategory" type="submit" class="inputButton" value="New Dashboard" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["newCategory"]) { ?>
  <br>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">New Dashboard </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Dashboard Name :</td>
      <td><input name="newName" type="text" class="inputInput" id="newName" size="50" onKeyUp="form1.saveScreenNew.disabled = false"></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenNew" type="submit" class="inputButton" value="Simpan" disabled="disabled" />
          <input name="cancelScreenNew" type="submit" class="inputButton" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["editCategory"]) { ?>
  <br>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Edit Dashboard </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Nama :</td>
      <td width="662"><input name="editName" type="text" class="inputInput" id="editName" size="50" onKeyUp="form1.saveScreenEdit.disabled = false" value="<?php echo $showCatInfoRsRows[0]["DASH_NAME"]?>"></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenEdit" type="submit" class="inputButton" id="saveScreenEdit" value="Simpan" />
          <input name="cancelScreenEdit" type="submit" class="inputButton" id="cancelScreenEdit" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["newReference"]) { 
  
    //list group user non selected (13-10-2009)
	$groupListAll=$mySQL->getUserGroupAllDash();
	$groupListAllCount=count($groupListAll);
  
  
  ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">New Dashboard Item </th>
    </tr>
    <tr>
      <td width="168" class="inputLabel">Name / Title : </td>
      <td width="780"><input name="ds_name" type="text" class="inputInput" id="ds_name" size="70" onKeyUp="form1.saveScreenRefNew.disabled = false" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><input name="ds_order" type="text" class="inputInput" id="ds_order" onKeyUp="form1.saveScreenRefNew.disabled = false" size="3" maxlength="2" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="ds_status" class="inputList" id="ds_status">
          <option value="1">No</option>
          <option value="0">Yes</option>
      </select></td>
    </tr>
    
    <tr>
      <td class="inputLabel">Type : </td>
      <td><label>
        <input name="ds_type" type="radio" id="radio" onClick="$(this).up(2).next().show();
																(this).up(2).next(1).show();
																(this).up(2).next(2).show();
																(this).up(2).next(3).show();
																(this).up(2).next(4).show();
																(this).up(2).next(5).show();
																(this).up(2).next(6).show();
																(this).up(2).next(7).show();
																
																" value="graph" checked="checked" />
        Graph</label>
        <label>
        <input name="ds_type" type="radio" id="radio" onClick="$(this).up(2).next().hide();$(this).up(2).next(1).hide();$(this).up(2).next(2).hide();
																
																$(this).up(2).next(3).hide();
																$(this).up(2).next(4).hide();
																$(this).up(2).next(5).hide();
																$(this).up(2).next(6).hide();
																$(this).up(2).next(7).hide();
																
																" value="listing" />
        Listing</label></td>
    </tr>
    
    <tr>
      <td class="subHead">GRAPH OPTIONS </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Graph Type : </td>
      <td><select name="ds_graph_type" class="inputList" id="ds_graph_type" >
          <option value="line">line</option>
          <option value="area">area</option>
          <option value="bar">bar</option>
          <option value="pie">pie</option>
          <option value="radar">radar</option>
          <option value="step">step</option>
          <option value="impulse">impulse</option>
          <option value="dot">dot</option>
          <option value="scatter">scatter</option>
          <option value="smooth_line">smooth_line</option>
          <option value="smooth_area">smooth_area</option>
          <?php for($x=0; $x < count($targetRsRows); $x++) { ?>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Graph Output Format : </td>
      <td><select name="ds_output_format" class="inputList" id="ds_output_format" >
          <option value="png">png</option>
          <option value="jpg">jpg</option>
          <option value="gd">gd</option>
          <option value="svg">svg</option>
          <?php for($x=0; $x < count($targetRsRows); $x++) { ?>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Options : </td>
      <td><label>
        <input name="ds_show_legend" type="checkbox" id="ds_show_legend" value="1">
        Show legend </label>
        <label>
        <input name="ds_show_axis" type="checkbox" id="ds_show_axis" value="1">
        Show axis </label></td>
    </tr>
    
    
    <tr>
      <td class="subHead">GRAPH STYLE </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Dimension : </td>
      <td><input name="ds_width" type="text" class="inputInput" id="ds_width" onKeyUp="form1.saveScreenRefNew.disabled = false" size="2" maxlength="3" />
        <input name="ds_height" type="text" class="inputInput" id="ds_height" onKeyUp="form1.saveScreenRefNew.disabled = false" size="2" maxlength="3" />
        width / height </td>
    </tr>
    <tr>
      <td class="inputLabel">Background Color : </td>
      <td><input name="ds_bgcolor" type="text" class="inputInput" id="ds_bgcolor" onKeyUp="form1.saveScreenRefNew.disabled = false" size="7" maxlength="7" />
        #XXXXXX </td>
    </tr>
    <tr>
      <td class="inputLabel">Graph Title Style : </td>
      <td><input name="ds_title_color" type="text" class="inputInput" id="ds_title_color" onKeyUp="form1.saveScreenRefNew.disabled = false" size="7" maxlength="7" />
        <input name="ds_title_size" type="text" class="inputInput" id="ds_title_size" onKeyUp="form1.saveScreenRefNew.disabled = false" size="2" maxlength="3" />
        <input name="ds_title_angle" type="text" class="inputInput" id="ds_title_angle" onKeyUp="form1.saveScreenRefNew.disabled = false" size="2" maxlength="3" />
        color / size / angle </td>
    </tr>
    <tr>
      <td class="subHead">DATA SOURCE </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Source : </td>
      <td><label>
        <input name="ds_source_type" type="radio" id="radio" onClick="$(this).up(2).next().show(); $(this).up(2).next(1).hide()" value="sql" checked />
        SQL </label>
        <label>
        <input name="ds_source_type" type="radio" id="radio" onClick="$(this).up(2).next().hide(); $(this).up(2).next(1).show()" value="componentid" />
        Component ID </label>      </td>
    </tr>
    <tr>
      <td class="inputLabel">SQL Statement : </td>
      <td><textarea name="ds_sql" cols="70" rows="10" class="inputInput" id="ds_sql"></textarea></td>
    </tr>
    <tr style="display:none">
      <td class="inputLabel">Component ID : </td>
      <td><input name="ds_componentid" type="text" class="inputInput" id="ds_componentid" size="4" maxlength="5" /></td>
    </tr>
    
    
   
  </table><br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Dashboard Permission</th>
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
                <input name="newMoveAllRTL" type="button" class="inputButton" id="newMoveAllRTL" value="&lt;&lt;" style="margin-bottom:2px;" onClick="listBoxSelectall('selectedGroup'); moveinid('nonSelectedGroup','selectedGroup'); " />
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
          <input name="saveScreenRefNew" onclick="listBoxSelectall('selectedGroup');" type="submit" disabled="disabled" class="inputButton" id="saveScreenRefNew" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["editReference"]) {
  
	////list group user non selected (13-10-2009)
	$groupListNonSelected=$mySQL->getUserGroupNonSelectedDash($editRs[0]['DASHITEM_ID']);
	$groupListNonSelectedCount=count($groupListNonSelected);
	
	//list group user selected (13-10-2009)
	$groupListSelected=$mySQL->getUserGroupSelectedDash($editRs[0]['DASHITEM_ID']);
	$groupListSelectedCount=count($groupListSelected);

   ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Edit Dashboard Item</th>
    </tr>
	 <tr>
      <td width="74" class="inputLabel">ID : </td>
      <td width="662"><input name="ds_id" type="text" class="inputInput" id="ds_id" size="70" onKeyUp="form1.saveScreenRefNew.disabled = false" value="<?php echo $editRs[0]['DASHITEM_ID']?>" /></td>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Name / Title : </td>
      <td width="662"><input name="ds_name" type="text" class="inputInput" id="ds_name" size="70" onKeyUp="form1.saveScreenRefNew.disabled = false" value="<?php echo $editRs[0]['DASHITEM_ITEM_NAME']?>" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><input name="ds_order" type="text" class="inputInput" id="ds_order" size="3" maxlength="2" value="<?php echo $editRs[0]['DASHITEM_ORDER']?>" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="ds_status" class="inputList" id="ds_status">
          <option value="1" <?php if($editRs[0]['DASHITEM_STATUS'] == '1') echo 'selected'; ?>>No</option>
          <option value="0" <?php if($editRs[0]['DASHITEM_STATUS'] == '0') echo 'selected'; ?>>Yes</option>
      </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td><label>
        <input name="ds_type" type="radio" id="ds_type" onClick="$(this).up(2).next().show();
																(this).up(2).next(1).show();
																(this).up(2).next(2).show();
																(this).up(2).next(3).show();
																(this).up(2).next(4).show();
																(this).up(2).next(5).show();
																(this).up(2).next(6).show();
																(this).up(2).next(7).show();
																
																" value="graph" <?php if($editRs[0]['DASHITEM_TYPE'] == 'graph') echo 'checked'; ?> />
        Graph</label>
          <label>
          <input name="ds_type" type="radio" id="ds_type" onClick="$(this).up(2).next().hide();$(this).up(2).next(1).hide();$(this).up(2).next(2).hide();
																
																$(this).up(2).next(3).hide();
																$(this).up(2).next(4).hide();
																$(this).up(2).next(5).hide();
																$(this).up(2).next(6).hide();
																$(this).up(2).next(7).hide();
																
																" value="listing" <?php if($editRs[0]['DASHITEM_TYPE'] == 'listing') echo 'checked'; ?> />
            Listing</label></td>
    </tr>
    <tr>
      <td class="subHead">GRAPH OPTIONS </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Graph Type : </td>
      <td><select name="ds_graph_type" class="inputList" id="ds_graph_type" >
          <option value="line" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'line') echo 'selected' ?>>line</option>
          <option value="area" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'area') echo 'selected' ?>>area</option>
          <option value="bar" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'bar') echo 'selected' ?>>bar</option>
          <option value="pie" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'pie') echo 'selected' ?>>pie</option>
          <option value="radar" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'radar') echo 'selected' ?>>radar</option>
          <option value="step" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'step') echo 'selected' ?>>step</option>
          <option value="impulse" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'impulse') echo 'selected' ?>>impulse</option>
          <option value="dot" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'dot') echo 'selected' ?>>dot</option>
          <option value="scatter" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'scatter') echo 'selected' ?>>scatter</option>
          <option value="smooth_line" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'smooth_line') echo 'selected' ?>>smooth_line</option>
          <option value="smooth_area" <?php if($editRs[0]['DASHITEM_GRAPH_TYPE'] == 'smooth_area') echo 'selected' ?>>smooth_area</option>
          <?php for($x=0; $x < count($targetRsRows); $x++) { ?>
          <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Graph Output Format : </td>
      <td><select name="ds_output_format" class="inputList" id="ds_output_format" >
          <option value="png" <?php if($editRs[0]['DASHITEM_OUTPUT_FORMAT'] == 'png') echo 'selected' ?>>png</option>
          <option value="jpg" <?php if($editRs[0]['DASHITEM_OUTPUT_FORMAT'] == 'jpg') echo 'selected' ?>>jpg</option>
          <option value="gd" <?php if($editRs[0]['DASHITEM_OUTPUT_FORMAT'] == 'gd') echo 'selected' ?>>gd</option>
          <option value="svg" <?php if($editRs[0]['DASHITEM_OUTPUT_FORMAT'] == 'svg') echo 'selected' ?>>svg</option>
          <?php for($x=0; $x < count($targetRsRows); $x++) { ?>
          <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Options : </td>
      <td><label>
        <input name="ds_show_legend" type="checkbox" id="ds_show_legend" value="1" <?php if($editRs[0]['DASHITEM_SHOW_LEGEND'] == '1') echo 'checked' ?>>
        Show legend </label>
          <label>
          <input name="ds_show_axis" type="checkbox" id="ds_show_axis" value="1" <?php if($editRs[0]['DASHITEM_SHOW_AXIS'] == '1') echo 'checked' ?>>
            Show axis </label></td>
    </tr>
    <tr>
      <td class="subHead">GRAPH STYLE </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Dimension : </td>
      <td><input name="ds_width" type="text" class="inputInput" id="ds_width"  size="2" maxlength="3" value="<?php echo $editRs[0]['DASHITEM_WIDTH']?>" />
          <input name="ds_height" type="text" class="inputInput" id="ds_height"  size="2" maxlength="3" value="<?php echo $editRs[0]['DASHITEM_HEIGHT']?>" />
        width / height </td>
    </tr>
    <tr>
      <td class="inputLabel">Background Color : </td>
      <td><input name="ds_bgcolor" type="text" class="inputInput" id="ds_bgcolor" value="<?php echo $editRs[0]['DASHITEM_BACKGROUND_COLOR']?>" size="7" maxlength="7" />
        #XXXXXX </td>
    </tr>
    <tr>
      <td class="inputLabel">Graph Title Style : </td>
      <td><input name="ds_title_color" type="text" class="inputInput" id="ds_title_color" value="<?php echo $editRs[0]['DASHITEM_GRAPH_TITLE_COLOR']?>" size="7" maxlength="7" />
          <input name="ds_title_size" type="text" class="inputInput" id="ds_title_size" value="<?php echo $editRs[0]['DASHITEM_GRAPH_TITLE_SIZE']?>" size="2" maxlength="3" />
          <input name="ds_title_angle" type="text" class="inputInput" id="ds_title_angle" value="<?php echo $editRs[0]['DASHITEM_GRAPH_TITLE_ANGLE']?>" size="2" maxlength="3" />
        color / size / angle </td>
    </tr>
    <tr>
      <td class="subHead">DATA SOURCE </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Source : </td>
      <td><label>
        <input name="ds_source_type" type="radio" id="radio" onClick="$(this).up(2).next().show(); $(this).up(2).next(1).hide()" value="sql" <?php if($editRs[0]['DASHITEM_DATA_SOURCE_TYPE'] == 'sql') echo 'checked'; ?> />
        SQL </label>
          <label>
          <input name="ds_source_type" type="radio" id="radio" onClick="$(this).up(2).next().hide(); $(this).up(2).next(1).show()" value="componentid" <?php if($editRs[0]['DASHITEM_DATA_SOURCE_TYPE'] == 'componentid') echo 'checked'; ?> />
            Component ID </label>      </td>
    </tr>
    <tr>
      <td class="inputLabel">SQL Statement : </td>
      <td><textarea name="ds_sql" cols="70" rows="10" class="inputInput" id="ds_sql" ><?php echo $editRs[0]['DASHITEM_DATA_SOURCE_TEXT']?></textarea></td>
    </tr>
    <tr style="display:none">
      <td class="inputLabel">Component ID : </td>
      <td><input name="ds_componentid" type="text" class="inputInput" id="ds_componentid" size="4" maxlength="5" value="<?php echo $editRs[0]['DASHITEM_DATA_SOURCE_TEXT']?>" /></td>
    </tr>
   
  </table><br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Dashboard Permission</th>
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
          <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $_POST["hiddenCode"];?>" />
          <input name="saveScreenRefEdit" onclick="listBoxSelectall('selectedGroupEdit');" type="submit" class="inputButton" id="saveScreenRefEdit" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  <script>
  var a = document.getElementsByName('ds_type');
 <?php if($editRs[0]['DASHITEM_TYPE'] == 'graph') { ?>
  a[0].click();
  <?php } ?>
  <?php if($editRs[0]['DASHITEM_TYPE'] == 'listing') { ?>
  a[1].click();
  <?php } ?>
  
   var b = document.getElementsByName('ds_source_type');
 <?php if($editRs[0]['DASHITEM_DATA_SOURCE_TYPE'] == 'sql') { ?>
  b[0].click();
  <?php } ?>
  <?php if($editRs[0]['DASHITEM_DATA_SOURCE_TYPE'] == 'componentid') { ?>
  b[1].click();
  <?php } ?>
  
  </script>
  <?php } ?>
</form>
<?php if($_POST["showScreen"] && $_POST["code"] != "") { ?>
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="8">Dashboard Items </th>
  </tr>
  <?php if(count($referenceRsArr) > 0) { ?>
  <tr>
    <td width="15" class="listingHead">#</td>
    <td class="listingHead">Name</td>
    <td width="95" class="listingHead">Dashboard Type</td>
    <td width="75" class="listingHead">Graph Type </td>
    <td width="72" class="listingHead">Data Source </td>
    <td width="35" class="listingHead">Order</td>
    <td width="50" class="listingHead">Enabled</td>
    <td width="73" class="listingHeadRight">Action</td>
  </tr>
  <?php for($x=0; $x < count($referenceRsArr); $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["DASHITEM_ITEM_NAME"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["DASHITEM_TYPE"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["DASHITEM_GRAPH_TYPE"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["DASHITEM_DATA_SOURCE_TYPE"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["DASHITEM_ORDER"];?></td>
    <td class="listingContent"><?php if($referenceRsArr[$x]["DASHITEM_STATUS"] == '1') echo "Yes"; else echo "-";?></td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" name="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" method="post" action="" style="margin-bottom:0px;">
        <input name="editReference" type="submit" class="inputButton" id="editReference" value="ubah" />
        <input name="deleteReference" type="submit" class="inputButton" id="deleteReference" value="buang" onClick="if(window.confirm('Are you sure you want to DELETE this dashboard item?')) {return true} else {return false}"/>
        <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $referenceRsArr[$x]["DASHITEM_ID"];?>" />
        <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="8" class="myContentInput">No dashboard item(s) found.. </td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="8" bgcolor="#F7F3F7"><div align="right">
        <form id="form2" name="form2" method="post" action="" style="margin-bottom:0px;">
          <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
          <input name="newReference" type="submit" class="inputButton" id="newReference" value="New Dashboard Item" />
          <input name="saveScreen2" type="submit" class="inputButton" value="Close" />
        </form>
      </div></td>
  </tr>
</table>
<?php } ?>
