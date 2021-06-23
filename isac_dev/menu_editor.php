<?php
//debuggin
//print_r($_POST);

//if ajax is called 
if($_GET['type'] == 'ajax')
{	
	include_once('system_prerequisite.php');
}

//if show disabled parent menu not set
if(!isset($_POST['showDisabled']))
	$_POST['showDisabled'] = 0;

//============================================ parent menu ============================================
//if new screen submitted
if($_POST["newCategory"])
{
	//get parent menu order
	$parentOrder = "select max(MENUORDER) + 1 as MAXPARENTORDER from FLC_MENU where MENULEVEL = 1";
	$parentOrderRsRows = $myQuery->query($parentOrder,'SELECT','NAME');
}

//if main category edit button clicked
if($_POST["code"] && $_POST["editCategory"])
{
	//show info of selected category
	$showCatInfo = "select * from FLC_MENU where MENUID = '".$_POST["code"]."'";
	$showCatInfoRsRows = $myQuery->query($showCatInfo,'SELECT','NAME');
}

//if new category added
if($_POST["saveScreenNew"])
{
	//increment order if option is after
	if($_POST["orderOption"]=='++')
		$_POST["newOrder"]++;
		
	//get max menuid
	$getMaxRs = $mySQL->maxValue('FLC_MENU','MENUID',0)+1;
	
	//insert category
	$insertCat = "insert into FLC_MENU (MENUID,MENUNAME,MENUPARENT,MENULEVEL,MENUORDER,MENUSTATUS)
					values (".$getMaxRs.", '".$_POST["newName"]."','0','1','".$_POST["newOrder"]."',".$_POST["newDisabled"].")";
	$myQuery->query($insertCat,'RUN');

	//if menu is enabled
	if($_POST["newDisabled"]=='1')
	{
		/*===insert at specified position===*/
		//get current orders for component by page
		$getOrder = "select MENUORDER, MENUID from FLC_MENU
						where MENUID != '".$getMaxRs."' and MENUSTATUS = '1'
						order by MENUORDER,MENUID";
		$getOrderRs = $myQuery->query($getOrder,'SELECT');
		$getOrderRsCount = count($getOrderRs);
		
		//increment current component order
		$orderIncrement=false;
		for($x=0; $x<$getOrderRsCount; $x++)
		{
			if($getOrderRs[$x][0]==$_POST['newOrder'])
			{
				$orderIncrement=true;
			}//eof if
			
			if($orderIncrement)
			{
				$orderUpdate = "update FLC_MENU
								set MENUORDER=".(int)++$getOrderRs[$x][0]."
								where MENUID='".$getOrderRs[$x][1]."'";
				$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
			}//eof if
		}//eof for
	}//eof if($_POST["newDisabled"]=='1')
	
	//update versioning
	//xml_version_update($getMaxRs);
}//eof if

//if edit screen submitted
if($_POST["saveScreenEdit"])
{
	//increment order if option is after
	if($_POST["orderOption"]=='++')
		$_POST["editOrder"]++;
		
	//update category
	$updateCat = "update FLC_MENU set 
					MENUNAME = '".$_POST["editName"]."',
					MENUORDER = '".$_POST["editOrder"]."',
					MENUSTATUS = '".$_POST["editDisabled"]."' 
					where MENUID = ".$_POST["code"];
	$myQuery->query($updateCat,'RUN');
	
	//if menu if enabled
	if($_POST["editDisabled"]=='1')
	{
		/*===insert at specified position===*/
		//get current orders for component by page
		$getOrder = "select MENUORDER, MENUID from FLC_MENU
						where MENUID != '".$_POST["code"]."' and MENUSTATUS = '1'
						order by MENUORDER,MENUID";
		$getOrderRs = $myQuery->query($getOrder,'SELECT');
		$getOrderRsCount = count($getOrderRs);
		
		//increment current component order
		$orderIncrement=false;
		for($x=0; $x<$getOrderRsCount; $x++)
		{
			if($getOrderRs[$x][0]==$_POST['editOrder'])
			{
				$orderIncrement=true;
			}//eof if
			
			if($orderIncrement)
			{
				$orderUpdate = "update FLC_MENU
								set MENUORDER=".(int)++$getOrderRs[$x][0]."
								where MENUID='".$getOrderRs[$x][1]."'";
				$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
			}//eof if
		}//eof for
	}//eof if($_POST["editDisabled"]=='1')
	
	//update versioning
	//xml_version_update($_POST['code']);
}//eof id

//if category deleted
else if($_POST["deleteCategory"]&&$_POST["code"])
{	
	//--------------------------- page----------------------
	//select pageid
	$pageID = "select PAGEID from FLC_PAGE where MENUID in 
				(select MENUID from FLC_MENU where MENUID = '".$_POST['code']."' or MENUROOT = '".$_POST['code']."')";
	$pageIDRs = $myQuery->query($pageID);
	$pageIDRsCount = count($pageIDRs);
	
	//loop on count of pageid
	for($x=0; $x<$pageIDRsCount; $x++)
	{
		$thePage[] = $pageIDRs[$x][0];
	}//eof for
	
	//if have page
	if($thePage)
	{
		//select componentid
		$componentID = "select COMPONENTID from FLC_PAGE_COMPONENT where PAGEID in ('".implode("','",$thePage)."')";
		$componentIDRs = $myQuery->query($componentID);
		$componentIDRsCount = count($componentIDRs);
		
		//loop on count of pageid
		for($x=0; $x<$componentIDRsCount; $x++)
		{
			$theComponent[] = $componentIDRs[$x][0];
		}//eof for
		
		//select controlid
		$controlID = "select CONTROLID from FLC_PAGE_CONTROL where PAGEID in ('".implode("','",$thePage)."')";
		$controlIDRs = $myQuery->query($controlID);
		$controlIDRsCount = count($controlIDRs);
		
		//loop on count of pageid
		for($x=0; $x<$controlIDRsCount; $x++)
		{
			$theControl[] = $controlIDRs[$x][0];
		}//eof for
	}//eof if
	//------------------------- eof page---------------------
	
	//delete menu
	$deleteMenu = "delete from FLC_MENU where MENUID = '".$_POST["code"]."' or MENUROOT = '".$_POST["code"]."'";
	$deleteMenuRs = $myQuery->query($deleteMenu,'RUN');
	
	//if menu deleted and have page
	if($deleteMenuRs&&$thePage)
	{
		//delete page
		$deletePage = "delete from FLC_PAGE
						where PAGEID in ('".implode("','",$thePage)."')";	
		$deletePageRs = $myQuery->query($deletePage,'RUN');
		
		//if page deleted
		if($deletePageRs)
		{			
			//delete component
			$deleteComponent = "delete from FLC_PAGE_COMPONENT where PAGEID in ('".implode("','",$thePage)."')";
			$deleteComponentRs = $myQuery->query($deleteComponent,'RUN');
			
			//if have component
			if($theComponent)
			{
				//delete items
				$deleteItem = "delete from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID in ('".implode("','",$theComponent)."')";
				$deleteItemRs = $myQuery->query($deleteItem,'RUN');
			}//eof if
			
			//delete control
			$deleteControl = "delete from FLC_PAGE_CONTROL where PAGEID in ('".implode("','",$thePage)."')";
			$deleteControlRs = $myQuery->query($deleteControl,'RUN');
		}//eof if
	}//eof if
}//eof if
//=====================================================================================================

//===========================================reference=================================================
//if new reference added
if($_POST["saveScreenRefNew"])
{
	//if menu parent not selected
	if(!isset($_POST['newMenuParent']))
		$_POST['newMenuParent'] = $_POST["code"];
		
	//set minimum order value
	if($_POST["newMenuOrder"]==0||$_POST["newMenuOrder"]=='')
		$_POST["newMenuOrder"]=1;
	
	//increment order if option is after
	if($_POST["orderOption"]=='++')
		$_POST["newMenuOrder"]++;
		
	//get max menuid
	$getMaxRs = $mySQL->maxValue('FLC_MENU','MENUID',0)+1;

	$insertRef = "insert into FLC_MENU (MENUID,MENUNAME,MENULEVEL,MENUORDER,MENULINK,MENUTARGET,MENUPARENT,MENUROOT,MENUSTATUS,LINKTYPE) 
					values
					('".$getMaxRs."', '".$_POST["newMenuName"]."','".$_POST["newMenuLevel"]."','".$_POST['newMenuOrder']."',
					'".$_POST["newMenuLink"]."','".$_POST["newMenuTarget"]."','".$_POST['newMenuParent']."','".$_POST["code"]."',
					'".$_POST['newMenuDisabled']."','".$_POST['newLinkType']."')";
	$insertRefRs = $myQuery->query($insertRef,'RUN');
	
	//if menu if enabled
	if($_POST["newMenuDisabled"]=='1')
	{
		/*===insert at specified position===*/
		//get current orders for component by page
		$getOrder = "select MENUORDER, MENUID from FLC_MENU
						where MENUID != '".$getMaxRs."' and MENUSTATUS = '1' and MENUROOT = '".$_POST["code"]."' 
						and MENULEVEL = '".$_POST["newMenuLevel"]."' and MENUPARENT = '".$_POST["newMenuParent"]."'
						order by MENUORDER,MENUID";
		$getOrderRs = $myQuery->query($getOrder,'SELECT');
		$getOrderRsCount = count($getOrderRs);
		
		//increment current component order
		$orderIncrement=false;
		for($x=0; $x<$getOrderRsCount; $x++)
		{
			if($getOrderRs[$x][0]==$_POST['newMenuOrder'])
			{
				$orderIncrement=true;
			}//eof if
			
			if($orderIncrement)
			{
				$orderUpdate = "update FLC_MENU
								set MENUORDER=".(int)++$getOrderRs[$x][0]."
								where MENUID='".$getOrderRs[$x][1]."'";
				$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
			}//eof if
		}//eof for
	}//eof if($_POST["newMenuDisabled"]=='1')
	
	//dummy to trigger 
	$_POST["showScreen"] = true;
	
	//update versioning
	//xml_version_update($getMaxRs);
}

//if save screen edit reference
if($_POST["saveScreenRefEdit"])
{	
	//set minimum order value
	if($_POST["editMenuOrder"]==0||$_POST["editMenuOrder"]=='')
		$_POST["editMenuOrder"]=1;

	//increment order if option is after
	if($_POST["orderOption"]=='++')
		$_POST["editMenuOrder"]++;

	//update statement
	$updateRef = "update FLC_MENU 
					set MENUNAME = '".$_POST["editMenuName"]."', ";
	
	//if dependecies flag == 1, update menu level and menu parent
	if($_POST['dependenciesFlag'] == 1)
	{
		//do not update menu level and menu parent
	}
	else
	{	
		//if menu level = 2, menu parent is null
		if($_POST['editMenuLevel'] == 2)
			$updateRef .= "MENULEVEL = ".$_POST['editMenuLevel'].", MENUPARENT = ".$_POST['code'].", ";
		
		//else if menu level = 3, menu parent MUST NOT BE NULL
		if($_POST['editMenuLevel'] == 3)
			$updateRef .= "MENULEVEL = ".$_POST['editMenuLevel'].", MENUPARENT = ".$_POST['editMenuParent'].",";
	}
	
	
	//continue preparing update statement
	$updateRef .= "MENUORDER = '".$_POST["editMenuOrder"]."',
				MENULINK = '".$_POST["editMenuLink"]."',
				MENUTARGET = '".$_POST["editMenuTarget"]."',
				MENUSTATUS = '".$_POST['editMenuDisabled']."',
				LINKTYPE = '".$_POST['editLinkType']."'
				where MENUID = ".$_POST["hiddenCode"];
	$updateRefRs =  $myQuery->query($updateRef,'RUN');
	
	//here not finish
	//if menu if enabled
	if($_POST["editMenuDisabled"]=='1')
	{
		if($_POST['editMenuLevel'] == 2)
			$_POST['editMenuParent']=$_POST['code'];
			
		/*===insert at specified position===*/
		//get current orders for component by page
		$getOrder = "select MENUORDER, MENUID from FLC_MENU
						where MENUID != '".$_POST["hiddenCode"]."' and MENUSTATUS = '1' 
						and MENULEVEL = '".$_POST["editMenuLevel"]."' and MENUPARENT = '".$_POST["editMenuParent"]."'
						order by MENUORDER,MENUID";
		$getOrderRs = $myQuery->query($getOrder,'SELECT');
		$getOrderRsCount = count($getOrderRs);
		
		//increment current component order
		$orderIncrement=false;
		for($x=0; $x<$getOrderRsCount; $x++)
		{
			if($getOrderRs[$x][0]==$_POST['editMenuDisabled'])
			{
				$orderIncrement=true;
			}//eof if
			
			if($orderIncrement)
			{
				$orderUpdate = "update FLC_MENU
								set MENUORDER=".(int)++$getOrderRs[$x][0]."
								where MENUID='".$getOrderRs[$x][1]."'";
				$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
			}//eof if
		}//eof for
	}//eof if($_POST["editMenuDisabled"]=='1')
	
	//dummy
	$_POST["showScreen"] = true;
	
	//update versioning
	//xml_version_update($_POST['hiddenCode']);
}

//if reference deleted
if($_POST["deleteReference"]&&$_POST['hiddenCode'])
{
	//--------------------------- page----------------------
	//select pageid
	$pageID = "select PAGEID from FLC_PAGE where MENUID in 
				(select MENUID from FLC_MENU where MENUID = '".$_POST['hiddenCode']."' and MENUPARENT = '".$_POST['code']."')";
	$pageIDRs = $myQuery->query($pageID);
	$pageIDRsCount = count($pageIDRs);
	
	//loop on count of pageid
	for($x=0; $x<$pageIDRsCount; $x++)
	{
		$thePage[] = $pageIDRs[$x][0];
	}//eof for
	
	//if have page
	if($thePage)
	{
		//select componentid
		$componentID = "select COMPONENTID from FLC_PAGE_COMPONENT where PAGEID in ('".implode("','",$thePage)."')";
		$componentIDRs = $myQuery->query($componentID);
		$componentIDRsCount = count($componentIDRs);
		
		//loop on count of pageid
		for($x=0; $x<$componentIDRsCount; $x++)
		{
			$theComponent[] = $componentIDRs[$x][0];
		}//eof for
		
		//select controlid
		$controlID = "select CONTROLID from FLC_PAGE_CONTROL where PAGEID in ('".implode("','",$thePage)."')";
		$controlIDRs = $myQuery->query($controlID);
		$controlIDRsCount = count($controlIDRs);
		
		//loop on count of pageid
		for($x=0; $x<$controlIDRsCount; $x++)
		{
			$theControl[] = $controlIDRs[$x][0];
		}//eof for
	}//eof if
	//------------------------- eof page---------------------
	
	//if have menuid
	if($_POST['hiddenCode'])
	{
		//delete menu
		$deleteMenu = "delete from FLC_MENU where MENUID = '".$_POST['hiddenCode']."' or MENUPARENT = '".$_POST['hiddenCode']."'";
		$deleteMenuRs = $myQuery->query($deleteMenu,'RUN');
	}//eof if
	
	//if menu deleted and have page
	if($deleteMenuRs&&$thePage)
	{
		//delete page
		$deletePage = "delete from FLC_PAGE
						where PAGEID in ('".implode("','",$thePage)."')";	
		$deletePageRs = $myQuery->query($deletePage,'RUN');
		
		//if page deleted
		if($deletePageRs)
		{			
			//delete component
			$deleteComponent = "delete from FLC_PAGE_COMPONENT where PAGEID in ('".implode("','",$thePage)."')";
			$deleteComponentRs = $myQuery->query($deleteComponent,'RUN');
			
			//if have component
			if($theComponent)
			{
				//delete items
				$deleteItem = "delete from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID in ('".implode("','",$theComponent)."')";
				$deleteItemRs = $myQuery->query($deleteItem,'RUN');
			}//eof if
			
			//delete control
			$deleteControl = "delete from FLC_PAGE_CONTROL where PAGEID in ('".implode("','",$thePage)."')";
			$deleteControlRs = $myQuery->query($deleteControl,'RUN');
		}//eof if
	}//eof if
	
	//update versioning
	//xml_version_update($_POST['code']);
}//eof if

//if new or edit
if($_POST["newReference"] || $_POST["editReference"])
{
	//get component items running no
	$getMaxOrderItem = "select max(MENUORDER) + 1 as MAXORDERITEM 
						from FLC_MENU where MENULEVEL != 1 
						and MENUPARENT = '".$_POST["code"]. "'
						group by MENULEVEL 
						order by MENULEVEL";
	$getMaxOrderItemRsRows = $myQuery->query($getMaxOrderItem,'SELECT','NAME');
	
	//if running no level 2 not set, set to 1
	if(!isset($getMaxOrderItemRsRows[0]['MAXORDERITEM'])) 
		$getMaxOrderItemRsRows[0]['MAXORDERITEM'] = 1;
	
	//if running no level 3 not set, set to 1
	if(!isset($getMaxOrderItemRsRows[1]['MAXORDERITEM'])) 
		$getMaxOrderItemRsRows[1]['MAXORDERITEM'] = 1;

	//show target dropdown
	$target = "select REFERENCECODE, DESCRIPTION1 from REFSYSTEM 
				where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'MENU_TARGET')";
	$targetRsRows = $myQuery->query($target,'SELECT','NAME');
	
	//show menu parent
	$parent = "select MENUID, MENUNAME from FLC_MENU where MENUPARENT = '".$_POST["code"]."' order by MENUNAME";
	$parentRsRows = $myQuery->query($parent,'SELECT','NAME');	
	
	//get menu level
	$level = "select REFERENCECODE, DESCRIPTION1 from REFSYSTEM 
				where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'MENU_LEVEL')";
	$levelRsRows = $myQuery->query($level,'SELECT','NAME');	
}

//if edit
if($_POST["editReference"])
{
	//show menu parent
	$parent = "select MENUID, MENUNAME from FLC_MENU where MENUPARENT = ".$_POST["code"]. " and MENUID not in (".$_POST['hiddenCode'].") order by MENUNAME";
	$parentRsRows = $myQuery->query($parent,'SELECT','NAME');	
}

//if edit reference clicked, show detail
if($_POST["editReference"])
{
	//show reference detail
	$showRef = "select *
				from FLC_MENU  
				where MENUID = ".$_POST["hiddenCode"];
	$showRefRsRows = $myQuery->query($showRef,'SELECT','NAME');
	
	//get child dependencies
	$dependent = "select count(MENUID) from FLC_MENU where MENUPARENT = ".$_POST["hiddenCode"];
	$dependentCount = $myQuery->query($dependent,'COUNT');
}
//===========================================//reference===============================================

//=========================================== page ordering ===========================================
//if order - move up clicked
if($_POST["moveUp"])
{	
	//check current ORDER position
	$checkPos = "select MENUORDER from FLC_MENU where MENUID = ".$_POST['hiddenCode'];
	$checkPosRs = $myQuery->query($checkPos,'SELECT','NAME');

	//if current position is NOT 1, move up
	if($checkPosRs[0]['MENUORDER'] != 1)
	{
		$updatePos = "update FLC_MENU set MENUORDER = ".($checkPosRs[0]['MENUORDER'] - 1)." 
						where MENUID = ".$_POST['hiddenCode'];
		$updatePosFlag = $myQuery->query($updatePos,'RUN');
	}
	
	//dummy
	$_POST["showScreen"] = true;
}

//if order - move down clicked
if($_POST["moveDown"])
{
	//check current ORDER position
	$checkPos = "select MENUORDER from FLC_MENU where MENUID = ".$_POST['hiddenCode'];
	$checkPosRs = $myQuery->query($checkPos,'SELECT','NAME');

	//if current position is NOT 1, move down
	$updatePos = "update FLC_MENU set MENUORDER = ".($checkPosRs[0]['MENUORDER'] + 1)." 
					where MENUID = ".$_POST['hiddenCode'];
	$updatePosFlag = $myQuery->query($updatePos,'RUN');
	
	//dummy
	$_POST["showScreen"] = true;
}

//if reset ordering button clicked
if($_POST["resetOrdering"])
{
	//get menu ordering level 2
	$getMenuLevel_1 = "select MENUID from FLC_MENU where MENUROOT = ".$_POST['code']." 
				and MENULEVEL = 2 order by MENUORDER";
	$getMenuLevel_1Rs = $myQuery->query($getMenuLevel_1,'SELECT','NAME');
	
	//get menu ordering level 3
	$getMenuLevel_2 = "select MENUID from FLC_MENU where MENUROOT = ".$_POST['code']." 
				and MENULEVEL = 3 order by MENUORDER";
	$getMenuLevel_2Rs = $myQuery->query($getMenuLevel_2,'SELECT','NAME');
	
	//count result rows
	$countMenu_1 = count($getMenuLevel_1Rs);
	
	//count result rows
	$countMenu_2 = count($getMenuLevel_2Rs);
	
	//for all menus level 2, update menu
	for($x=0; $x < $countMenu_1; $x++)
	{
		$updateOrder = "update FLC_MENU set MENUORDER = ".($x+1)." 
								where MENUROOT = ".$_POST['code']." 
								and MENULEVEL = 2 
								and MENUID = ".$getMenuLevel_1Rs[$x]['MENUID'];
		$updateFlag = $myQuery->query($updateOrder,'RUN');
	}
	
	//for all menus level 3, update menu
	for($x=0; $x < $countMenu_2; $x++)
	{
		$updateOrder = "update FLC_MENU set MENUORDER = ".($x+1)." 
								where MENUROOT = ".$_POST['code']." 
								and MENULEVEL = 3 
								and MENUID = ".$getMenuLevel_2Rs[$x]['MENUID'];
		$updateFlag = $myQuery->query($updateOrder,'RUN');
	}
	
	//dummy
	$_POST["showScreen"] = true;
}
//========================================== //end page ordering ======================================

//if filter
if($_POST['filter'])
{
	$_POST["showScreen"]=true;
}//eof if

//if showScreen and code not null
if($_POST["showScreen"] && $_POST["code"] != "")
{
	//menu data by filter
	$referenceRsArr = $mySQL->menuData($_POST['code'],$_POST['filterName'],$_POST['filterValue']);
	
	//for filter
	$filterList=array(array('parent','Sub Parent'),array('menu','Nama'));
}

//get general reference list----------------------------------
$general = "select * from FLC_MENU where MENUPARENT = '0' ";

//if show disabled = 1, append query
if($_POST['showDisabled'] != '1')
	$general .= " and MENUSTATUS = 1";
	
//continue appending query	
$general .= " order by MENUORDER";

//run query
$generalRsArr = $myQuery->query($general,'SELECT','NAME');
//------------------------------------------------------------

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
<div id="breadcrumbs">Modul Pentadbir Sistem / Menu Editor /
  <?php if($_POST["editScreen"]) echo " Edit /"?>
</div>
<h1>Menu Editor </h1>
<?php //if update successful
  if($insertCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Menu parent baru telah ditambah.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($deleteCatRs && $deleteCatChildRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Menu parent telah dibuang.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($updateCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Menu parent  telah dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if insert reference successful
  if($insertRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Sub menu  baru telah ditambah.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($deleteRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Sub menu telah dibuang. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($updateRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Sub menu telah dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($updateFlag) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Susunan menu telah berjaya di'reset'.</td>
  </tr>
</table>
<br />
<?php } ?>
<form action="" method="post" name="form1">
  <?php if(!isset($_POST["editScreen"]))  { ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Senarai Menu </th>
    </tr>
    <tr>
      <td width="74" nowrap="nowrap" class="inputLabel">Parent Menu : </td>
      <td width="662"><select name="code" class="inputList" id="code" onChange="codeDropDown(this);">
          <option value="">&lt; Pilih Parent &gt;</option>
          <?php for($x=0; $x < count($generalRsArr); $x++) { ?>
          <option value="<?php echo $generalRsArr[$x]["MENUID"]?>" label="<?php echo $generalRsArr[$x]["MENUNAME"]?>" <?php if($_POST["code"] == $generalRsArr[$x]["MENUID"]) echo "selected";?>><?php echo $generalRsArr[$x]["MENUORDER"]." - ".$generalRsArr[$x]["MENUNAME"]?></option>
          <?php } ?>
        </select>
        <input name="showScreen" type="submit" class="inputButton" id="showScreen" value="Tunjuk Senarai" <?php if(!$_POST["code"]) { ?>disabled="disabled" <?php } ?> />
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">&nbsp;</td>
      <td><label>
        <input name="showDisabled" type="checkbox" id="showDisabled" onclick="form1.submit()" value="1" <?php if($_POST['showDisabled'] == '1' || !isset($_POST['showDisabled'])) { ?>checked="checked"<?php }?> />
        Show disabled menu(s)</label></td>
    </tr>
    <tr>
      <td colspan="2" class="contentButtonFooter"><div align="right">
          <input name="menuForceRefresh" type="submit" class="inputButton" id="menuForceRefresh" value="Refresh Side Menu" />
          <input name="newCategory" type="submit" class="inputButton" value="Baru" />
		  <input name="editCategory" type="submit" class="inputButton" value="Ubah" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> />
          <input name="deleteCategory" type="submit" class="inputButton" value="Buang" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> onClick="if(window.confirm('Are you sure you want to DELETE this menu?\nThis will also delete ALL sub-menu under this menu')) {return true} else {return false}" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["newCategory"]) { ?>
  <br>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Parent Menu Baru </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Nama :</td>
      <td width="662"><input name="newName" type="text" class="inputInput" id="newName" size="50" onKeyUp="form1.saveScreenNew.disabled = false"></td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><label>
	  <input name="orderOption" type="radio" checked="checked" onclick="swapItemDisplay('newOrderText', 'newOrderCombo')" />
      At</label>
      <label>
      <input name="orderOption" type="radio" onclick="swapItemDisplay('newOrderCombo', 'newOrderText'); showMenu('1','','','','<?php echo $_POST['showDisabled'];?>')" />
      Before</label>
      <label>
      <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('newOrderCombo', 'newOrderText'); showMenu('1','','','','<?php echo $_POST['showDisabled'];?>')" />
      After</label>
      <br />
	  <input name="newOrder" type="text" class="inputInput" id="newOrderText" size="3" onkeyup="form1.saveScreenNew.disabled = false" value="<?php echo $parentOrderRsRows[0]["MAXPARENTORDER"];?>" />
	  <span id="hideEditorList">
	  </span>
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="newDisabled" class="inputList" id="newDisabled">
          <option value="1">No</option>
          <option value="0">Yes</option>
        </select></td>
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
      <th colspan="2">Kemaskini Parent Menu </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Nama :</td>
      <td width="662"><input name="editName" type="text" class="inputInput" id="editName" size="50" onKeyUp="form1.saveScreenEdit.disabled = false" value="<?php echo $showCatInfoRsRows[0]["MENUNAME"]?>"></td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><label>
	  <input name="orderOption" type="radio" checked="checked" onclick="swapItemDisplay('editOrderText', 'editOrderCombo')" />
      At</label>
      <label>
      <input name="orderOption" type="radio" onclick="swapItemDisplay('editOrderCombo', 'editOrderText'); showMenu('1','','','<?php echo $_POST['code'];?>','<?php echo $_POST['showDisabled'];?>')" />
      Before</label>
      <label>
      <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('editOrderCombo', 'editOrderText'); showMenu('1','','','<?php echo $_POST['code'];?>','<?php echo $_POST['showDisabled'];?>')" />
      After</label>
      <br />
	  <input name="editOrder" type="text" class="inputInput" id="editOrderText" onkeyup="form1.saveScreenNew.disabled = false" value="<?php echo $showCatInfoRsRows[0]["MENUORDER"]?>" size="3" />
	  <span id="hideEditorList">
	  </span>
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="editDisabled" class="inputList" id="editDisabled">
          <option value="1" <?php if($showCatInfoRsRows[0]["MENUSTATUS"] == 1){?>selected<?php } ?>>No</option>
          <option value="0" <?php if($showCatInfoRsRows[0]["MENUSTATUS"] == 0){ ?>selected<?php }?>>Yes</option>
        </select></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenEdit" type="submit" class="inputButton" id="saveScreenEdit" value="Simpan" />
          <input name="cancelScreenEdit" type="submit" class="inputButton" id="cancelScreenEdit" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["newReference"]) { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Sub Menu Baru </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Nama : </td>
      <td width="662"><input name="newMenuName" type="text" class="inputInput" id="newMenuName" size="50" onkeyup="form1.saveScreenRefNew.disabled = false" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Menu Level : </td>
      <td><select name="newMenuLevel" class="inputList" id="newMenuLevel" onchange="if(this.options[this.selectedIndex].value == '3') { document.getElementById('newMenuParent').disabled = false; document.getElementById('newMenuOrderText').value = '<?php echo $getMaxOrderItemRsRows[1]["MAXORDERITEM"];?>' } else { document.getElementById('newMenuParent').disabled = true; document.getElementById('newMenuOrderText').value = '<?php echo $getMaxOrderItemRsRows[0]["MAXORDERITEM"];?>'}; document.getElementById('orderOptionStart').checked=true; swapItemDisplay('newMenuOrderText', 'newMenuOrderCombo')">
          <?php for($x=0; $x < count($levelRsRows); $x++) { ?>
          <option value="<?php echo $levelRsRows[$x]["REFERENCECODE"]?>" ><?php echo $levelRsRows[$x]["REFERENCECODE"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Menu Parent : </td>
      <td><select name="newMenuParent" class="inputList" id="newMenuParent" disabled="disabled" onchange="document.getElementById('orderOptionStart').checked=true; swapItemDisplay('newMenuOrderText', 'newMenuOrderCombo'); showNewMax(document.getElementById('newMenuLevel').value,document.getElementById('newMenuParent').value)
      ">
          <?php for($x=0; $x < count($parentRsRows); $x++) {?>
          <option value="<?php echo $parentRsRows[$x]["MENUID"]?>" ><?php echo $parentRsRows[$x]["MENUNAME"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><label>
	  <input name="orderOption" id="orderOptionStart" type="radio" checked="checked" onclick="swapItemDisplay('newMenuOrderText', 'newMenuOrderCombo')" />
      At</label>
      <label>
      <input name="orderOption" type="radio" onclick="swapItemDisplay('newMenuOrderCombo', 'newMenuOrderText'); showMenu(document.getElementById('newMenuLevel').value,<?php echo $_POST['code'];?>,document.getElementById('newMenuParent').value,'','<?php echo $_POST['showDisabled'];?>')" />
      Before</label>
      <label>
      <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('newMenuOrderCombo', 'newMenuOrderText'); showMenu(document.getElementById('newMenuLevel').value,<?php echo $_POST['code'];?>,document.getElementById('newMenuParent').value,'','<?php echo $_POST['showDisabled'];?>')" />
      After</label>
      <br />
      <input name="newMenuOrder" id="newMenuOrderText" type="text" class="inputInput" size="5" value="<?php echo $getMaxOrderItemRsRows[0]["MAXORDERITEM"];?>" />
      <span id="hideEditorList">	  </span>	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td>
	  <label><input name="newLinkType" type="radio" id="radio" onclick="swapMenuLinkOption(1, 'newMenuTarget', 'newMenuLink')" value="1" checked="checked" />
	  Inner</label>
	  <label><input name="newLinkType" type="radio" id="radio" onclick="swapMenuLinkOption(2, 'newMenuTarget', 'newMenuLink')" value="2" />
	  Integrate</label>	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Target : </td>
      <td><select name="newMenuTarget" class="inputList" id="newMenuTarget" onchange="codeDropDown(this); form1.hiddenName.value = this.options[this.selectedIndex].label">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($targetRsRows); $x++) { ?>
          <option value="<?php echo $targetRsRows[$x]["REFERENCECODE"]?>" ><?php echo $targetRsRows[$x]["REFERENCECODE"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Link : </td>
      <td><input name="newMenuLink" type="text" class="inputInput" id="newMenuLink" value="index.php?page=page_wrapper" size="70" />
      *for others, replace 'page_wrapper' with the file name </td>
    </tr>
    <tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="newMenuDisabled" class="inputList" id="newMenuDisabled">
        <option value="1">No</option>
        <option value="0">Yes</option>
      </select></td>
    </tr>
    
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenRefNew" type="submit" disabled="disabled" class="inputButton" id="saveScreenRefNew" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($_POST["editReference"]) { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Kemaskini Sub Menu </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Nama : </td>
      <td width="662"><input name="editMenuName" type="text" class="inputInput" id="editMenuName" onkeyup="form1.saveScreenRefEdit.disabled = false" value="<?php echo $showRefRsRows[0]["MENUNAME"]?>" size="50" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Menu Level : </td>
      <td><select name="editMenuLevel" class="inputList" id="editMenuLevel" <?php if($dependentCount > 0) {?>disabled<?php } ?> onchange="if(this.options[this.selectedIndex].value == '3') 
      { 
      		document.getElementById('editMenuParent').disabled = false; 
            document.getElementById('editMenuOrder').value = '<?php echo $getMaxOrderItemRsRows[1]["MAXORDERITEM"];?>'
            showMax(document.getElementById('editMenuLevel').value,document.getElementById('editMenuParent').value,document.getElementById('editMenuName').value) 
      } 
   else 
   	{ 
    		document.getElementById('editMenuParent').disabled = true; 
            document.getElementById('editMenuOrderText').value = '<?php echo $getMaxOrderItemRsRows[0]["MAXORDERITEM"];?>'
    };  
    
    document.getElementById('orderOptionStart').checked=true; 
    swapItemDisplay('editMenuOrderText', 'editMenuOrderCombo')
    
    ">
        <?php for($x=0; $x < count($levelRsRows); $x++) { ?>
        <option value="<?php echo $levelRsRows[$x]["REFERENCECODE"]?>" <?php if($showRefRsRows[0]["MENULEVEL"] == $levelRsRows[$x]["REFERENCECODE"]){ ?>selected<?php } ?>><?php echo $levelRsRows[$x]["REFERENCECODE"]?></option>
        <?php } ?>
      </select>
        <?php if($dependentCount > 0) {?>
        <em>Menu level is disabled because of dependencies.</em>
        <?php } ?>
        <?php if($dependentCount > 0) {?>
        <input name="dependenciesFlag" type="hidden" id="dependenciesFlag" value="1" />
        <?php } ?></td>
    </tr>
    <tr>
      <td class="inputLabel">Menu Parent : </td>
      <td><select name="editMenuParent" class="inputList" id="editMenuParent" <?php if($showRefRsRows[0]["MENULEVEL"] == 2){?>disabled<?php }?> onchange="document.getElementById('orderOptionStart').checked=true; swapItemDisplay('editMenuOrderText', 'editMenuOrderCombo');
     showMax(document.getElementById('editMenuLevel').value,document.getElementById('editMenuParent').value) 
      ">
          <?php for($x=0; $x < count($parentRsRows); $x++) {?>
          <option value="<?php echo $parentRsRows[$x]["MENUID"]?>" <?php if($showRefRsRows[0]["MENUPARENT"] == $parentRsRows[$x]["MENUID"]){ ?>selected<?php } ?> ><?php echo $parentRsRows[$x]["MENUNAME"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><label>
	  <input name="orderOption" id="orderOptionStart" type="radio" checked="checked" onclick="swapItemDisplay('editMenuOrderText', 'editMenuOrderCombo'); 
      if (document.getElementById('editMenuLevel').value == '3')
      document.getElementById('editMenuOrderText').value = '<?php echo $showRefRsRows[0]["MENUORDER"];?>'
      " />
      At</label>
      <label>
      <input name="orderOption" type="radio" onclick="swapItemDisplay('editMenuOrderCombo', 'editMenuOrderText'); showMenu(document.getElementById('editMenuLevel').value,'<?php echo $_POST['code'];?>',document.getElementById('editMenuParent').value, '<?php echo $_POST['hiddenCode'];?>','<?php echo $_POST['showDisabled'];?>')" />
      Before</label>
      <label>
      <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('editMenuOrderCombo', 'editMenuOrderText'); showMenu(document.getElementById('editMenuLevel').value,'<?php echo $_POST['code'];?>',document.getElementById('editMenuParent').value, '<?php echo $_POST['hiddenCode'];?>','<?php echo $_POST['showDisabled'];?>')" />
      After</label>
      <br />
	  <input name="editMenuOrder" id="editMenuOrderText" type="text" class="inputInput" value="<?php echo $showRefRsRows[0]["MENUORDER"]?>" size="5" onfocus="" />
	  <span id="hideEditorList">	  </span>	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td><label>
        <input name="editLinkType" type="radio" id="radio" onclick="swapMenuLinkOption(1, 'editMenuTarget')" value="1" <?php if($showRefRsRows[0]['LINKTYPE']!='2'){?>checked <?php }?>/>
        Inner</label>
        <label><input name="editLinkType" type="radio" id="radio" onclick="swapMenuLinkOption(2, 'editMenuTarget')" value="2" <?php if($showRefRsRows[0]['LINKTYPE']=='2'){?>checked <?php }?>/>
        Integrate</label>      </td>
    </tr>
    <tr>
      <td class="inputLabel">Target : </td>
      <td><select name="editMenuTarget" class="inputList" id="editMenuTarget" onchange="codeDropDown(this); form1.hiddenName.value = this.options[this.selectedIndex].label">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($targetRsRows); $x++) { ?>
          <option value="<?php echo $targetRsRows[$x]["REFERENCECODE"]?>" <?php if($showRefRsRows[0]["MENUTARGET"] == $targetRsRows[$x]["REFERENCECODE"]){ ?>selected<?php } ?> ><?php echo $targetRsRows[$x]["REFERENCECODE"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Link : </td>
      <td><input name="editMenuLink" type="text" class="inputInput" id="editMenuLink" value="<?php echo $showRefRsRows[0]["MENULINK"]?>" size="70" />
      *page_wrapper </td>
    </tr>
    <tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="editMenuDisabled" class="inputList" id="editMenuDisabled">
          <option value="1" <?php if($showRefRsRows[0]["MENUSTATUS"] == 1){?>selected<?php } ?>>No</option>
          <option value="0" <?php if($showRefRsRows[0]["MENUSTATUS"] == 0){ ?>selected<?php }?>>Yes</option>
      </select></td>
    </tr>
    
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $_POST["hiddenCode"];?>" />
          <input name="saveScreenRefEdit" type="submit" class="inputButton" id="saveScreenRefEdit" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
</form>
<?php if($_POST["showScreen"] && $_POST["code"] != "") { ?>
<br />
<form id="form3" name="form3" method="post" action="">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <th colspan="2">Carian Terperinci</th>
	</tr>
	<tr>
	  <td class="inputLabel" width="100" nowrap="nowrap">Carian : </td>
	  <td> 
	    <select name="filterName" class="inputList">
			<?php echo createDropDown($filterList,$_POST['filterName']);?>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Nilai : </td>
	  <td><input name="filterValue" type="text" class="inputInput" value="<?php echo $_POST['filterValue'];?>" size="50" /></td>
	</tr>
	<tr>
      <td class="contentButtonFooter" colspan="2" align="right">
      	<input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" /><input name="filter" type="submit" class="inputButton" id="filter" value="Carian" />
	  </td>
  	</tr>
</table>
</form>

<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="9">Senarai Sub-Menu </th>
  </tr>
  <?php if(count($referenceRsArr) > 0) { ?>
  <tr>
    <td width="15" class="listingHead">#</td>
    <td width="30" class="listingHead">ID</td>
    <td class="listingHead">Sub Parent</td>
    <td class="listingHead">Nama</td>
    <td width="52" class="listingHead">Enabled</td>
    <td width="25" class="listingHead">Lvl.</td>
    <td width="25" class="listingHead">Ord.</td>
    <td width="63" class="listingHead">Link</td>
    <td width="85" class="listingHeadRight">Aksi</td>
  </tr>
  <?php for($x=0; $x < count($referenceRsArr); $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo $x+1;?>.</td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["MENUID"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["MENUPARENT"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["MENUNAME"];?></td>
    <td class="listingContent"><?php if($referenceRsArr[$x]["MENUSTATUS"] == '1') echo "Yes"; else echo "-";?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["MENULEVEL"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["MENUORDER"];?></td>
    <td class="listingContent"><?php echo $referenceRsArr[$x]["MENULINK"];?></td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" name="formReference<?php echo $referenceRsArr[$x]["MENUID"];?>" method="post" action="">
        <input name="moveUp" type="submit" class="inputButton" id="moveUp" value="up" />
         <input name="moveDown" type="submit" class="inputButton" id="moveDown" value="down" />
         <input name="editReference" type="submit" class="inputButton" id="editReference" value="ubah" />
        <input name="deleteReference" type="submit" class="inputButton" id="deleteReference" value="buang" onClick="if(window.confirm('Are you sure you want to DELETE sub-menu?')) {return true} else {return false}"/>
        <input name="hiddenCode" type="hidden" id="hiddenCode" value="<?php echo $referenceRsArr[$x]["MENUID"];?>" />
        <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="9" class="myContentInput">Tiada rujukan ditemui.. </td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="9" bgcolor="#F7F3F7"><div align="right">
        <form id="form2" name="form2" method="post" action="">
          <input name="resetOrdering" type="submit" class="inputButton" id="resetOrdering" value="Reset Order" onClick="if(window.confirm('Are you sure you want to reset the menu order?')) {return true} else {return false}" />
          <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
          <input name="newReference" type="submit" class="inputButton" id="newReference" value="Sub Menu Baru" />
          <input name="saveScreen2" type="submit" class="inputButton" value="Tutup" />
        </form>
      </div></td>
  </tr>
</table>
<?php } ?>
