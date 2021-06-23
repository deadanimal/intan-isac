<?php
//include file for db conn and so on
require_once('system_prerequisite.php');

//=========================== ajax fareeda suggest updater ===============================
//if updater type is filter
if($_GET['updater'] == 'filter')
{
	//switch type
	switch($_GET['type'])
	{
		//type page
		case 'page':
			$generalRs = $mySQL->menu($_GET['value']);
		
			?>
			<select name="code" class="inputList" id="code" onChange="codeDropDown(this); ">
			  <option value="">&lt; Pilih Page &gt;</option>
			  <?php for($x=0; $x < count($generalRs); $x++) { ?>
			  <option value="<?php echo $generalRs[$x]["PAGEID"]?>" <?php if($_POST["code"] == $generalRs[$x]["PAGEID"]) echo "selected";?>><?php echo $generalRs[$x]["MENUNAME"]?></option>
			  <?php } ?>
			</select>
			<input name="showScreen" type="submit" class="inputButton" id="showScreen" value="Show List" <?php if(!$_POST["code"]) { ?>disabled="disabled" <?php } ?> />
			[<?php echo count($generalRs);?> records]
			<?php 
		break;
		
		//type menu
		case 'menu':
			//check for undefine variable and unset if true
			if($_GET['select'] && $_GET['select']=='undefined')	unset($_GET['select']);
			
			//if modify page
			if($_GET['select'])
				$selectedPageId=$_GET['select'];
			
			//get list of page menu
			$getMenuRs = $mySQL->menuExcludePage($selectedPageId,$_GET['value']);
			
			?>
			<select name="<?php if($_GET['select']){?>editMenuID<?php }else{?>newMenuID<?php }?>" class="inputList" id="<?php if($_GET['select']){?>editMenuID<?php }else{?>newMenuID<?php }?>" onchange="document.getElementById('<?php if($_GET['select']){?>editPageBreadcrumbs<?php }else{?>newPageBreadcrumbs<?php }?>').value=this.options[this.selectedIndex].innerHTML">
			  <option value="">&nbsp;</option>
			  <?php for($x=0; $x < count($getMenuRs); $x++) { ?>
			  <option value="<?php echo $getMenuRs[$x]["MENUID"]?>" <?php if($getPageInfoRs[0]["MENUID"] == $getMenuRs[$x]["MENUID"]) echo "selected";?>><?php echo $getMenuRs[$x]["MENUNAME"]?></option>
			  <?php } ?>
			</select>
			[<?php echo count($getMenuRs);?> records]
			<?php
		break;
		
		//type bl 
		case 'bl':			
			//get list of page menu
			$blList=$mySQL->listBL($_GET['value']);
			?>
			<select name="blid" class="inputList" id="blid" onchange="if(this.selectedIndex!=0){swapItemEnabled('edit|delete', '');}else{swapItemEnabled('', 'edit|delete');}">
				<?php echo createDropDown($blList);?>
			</select>
			<?php
		break;
		
		//type loading 
		case 'loading':			
			//get list of page menu
			$loadingList=$mySQL->listLoading($_GET['value']);
			?>
			<select name="loading_id" class="inputList" id="loading_id" onchange="if(this.selectedIndex!=0){swapItemEnabled('edit|delete', '');}else{swapItemEnabled('', 'edit|delete');}">
				<?php echo createDropDown($loadingList,$_POST['loading_id']);?>
			</select>
			<?php
		break;
	}//eof switch
}//eof if updater==filter
//========================= eof ajax fareeda suggest updater =============================

else
{
	//================================== ajax cascade dropdown ====================================
	//switch between editor's mode
	switch($_GET['editor'])
	{
		//page editor
		case 'component':
			//show dropdown of component item
			if($_GET['page']&&$_GET['component'])
			{
				if($_GET['itemExcepted']>0)
					$extra="and b.ITEMID != '".$_GET['itemExcepted']."'";
				
				//get component item for current page
				$getComponentItem = "select b.ITEMORDER, b.ITEMNAME
								from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
								where a.COMPONENTID = b.COMPONENTID 
								and a.PAGEID = '".$_GET['page']."' and a.COMPONENTID = '".$_GET['component']."' ".$extra."
								order by b.ITEMORDER";
				$getComponentItemRs = $myQuery->query($getComponentItem,'SELECT');
				$getComponentItemRsCount = count($getComponentItemRs);
				
				?>
				<select name="<?php if($_GET['itemExcepted']>0){?>editItemOrder<?php }else {?>newItemOrder<?php }?>" id="<?php if($_GET['itemExcepted']>0){?>editItemOrderCombo<?php }else {?>newItemOrderCombo<?php }?>" class="inputList">
					<option value="0">None</option>
					<?php for($x=0; $x < $getComponentItemRsCount; $x++) { ?>
					<option value="<?php echo $getComponentItemRs[$x][0];?>" ><?php echo $getComponentItemRs[$x][1];?></option>
					<?php } ?>
				</select>
				<?php
			}
			
			//show dropdown of component
			else if($_GET['page'])
			{
				if($_GET['componentExcepted']>0)
					$extra="and COMPONENTID != '".$_GET['componentExcepted']."'";
				
				//get component for current page
				$getComponent = "select COMPONENTORDER,COMPONENTNAME from FLC_PAGE_COMPONENT
									where PAGEID = '".$_GET['page']."' ".$extra."
									order by COMPONENTORDER";
				$getComponentRs = $myQuery->query($getComponent,'SELECT');
				$getComponentRsCount = count($getComponentRs);
				
				?>
				<select name="<?php if($_GET['componentExcepted']>0){?>editComponentOrder<?php }else {?>newComponentOrder<?php }?>" id="<?php if($_GET['componentExcepted']>0){?>editComponentOrderCombo<?php }else {?>newComponentOrderCombo<?php }?>" class="inputList">
					<option value="0">None</option>
					<?php for($x=0; $x < $getComponentRsCount; $x++) { ?>
					<option value="<?php echo $getComponentRs[$x][0];?>" ><?php echo $getComponentRs[$x][1];?></option>
					<?php } ?>
				</select>
				<?php
			}
		break;
		
		//control editor
		case 'control':
			//show dropdown of control
			if($_GET['page'])
			{
				if($_GET['controlExcepted']>0)
					$extra="and b.CONTROLID != '".$_GET['controlExcepted']."'";
				
				//get component for current page
				$getControl = "select b.CONTROLORDER, b.CONTROLNAME 
									from FLC_PAGE a, FLC_PAGE_CONTROL b, REFSYSTEM c 
									where a.PAGEID = b.PAGEID and b.CONTROLTYPE = c.REFERENCECODE 
									and c.MASTERCODE = 
										(select REFERENCECODE from REFSYSTEM 
											where MASTERCODE = 'XXX' and DESCRIPTION1 = 'PAGE_CONTROL_TYPE') 
									and b.PAGEID = '".$_GET['page']."' ".$extra."
									order by CONTROLORDER";
				$getControlRs = $myQuery->query($getControl,'SELECT');
				$getControlRsCount = count($getControlRs);
				
				?>
				<select name="<?php if($_GET['controlExcepted']>0){?>editControlOrder<?php }else {?>newControlOrder<?php }?>" id="<?php if($_GET['controlExcepted']>0){?>editControlOrderCombo<?php }else {?>newControlOrderCombo<?php }?>" class="inputList">
					<option value="0">None</option>
					<?php for($x=0; $x < $getControlRsCount; $x++) { ?>
					<option value="<?php echo $getControlRs[$x][0];?>" ><?php echo $getControlRs[$x][1];?></option>
					<?php } ?>
				</select>
				<?php
			}
		break;
		
		//menu editor
		case 'menu':
			//show dropdown of sub-menu
			if($_GET['menuLevel']&&$_GET['menuRoot']&&$_GET['menuRoot']!='undefined')
			{
				if($_GET['menuLevel']>2)
				{
					if($_GET['menuParent']>0)
						$extra.=" and menuParent = '".$_GET['menuParent']."'";
				}
					
				if($_GET['menuExcepted']>0)
					$extra.=" and MENUID != '".$_GET['menuExcepted']."'";
				
				if($_GET['menuStatus']!=1)	
					$extra.=" and MENUSTATUS = '1'";
				
				//get component for current page
				$getMenu = "select MENUORDER,MENUNAME 
								from FLC_MENU 
								where MENULEVEL = '".$_GET['menuLevel']."' and MENUROOT = '".$_GET['menuRoot']."' ".$extra." 
								order by MENUPARENT,MENULEVEL,MENUORDER";
				$getMenuRs = $myQuery->query($getMenu,'SELECT');
				$getMenuRsCount = count($getMenuRs);
				
				?>
				<select name="<?php if($_GET['menuExcepted']>0){?>editMenuOrder<?php }else {?>newMenuOrder<?php }?>" id="<?php if($_GET['menuExcepted']>0){?>editMenuOrderCombo<?php }else {?>newMenuOrderCombo<?php }?>" class="inputList">
					<option value="0">None</option>
					<?php for($x=0; $x < $getMenuRsCount; $x++) { ?>
					<option value="<?php echo $getMenuRs[$x][0];?>" ><?php echo $getMenuRs[$x][1];?></option>
					<?php } ?>
				</select>
				<?php
			}
			
			//show dropdown of menu
			else if($_GET['menuLevel'])
			{
				if($_GET['menuRoot']>0)
					$extra=" and MENUROOT = '".$_GET['menuRoot']."'";
					
				if($_GET['menuParent']>0)
					$extra.=" and menuParent = '".$_GET['menuParent']."'";
					
				if($_GET['menuExcepted']>0)
					$extra.=" and MENUID != '".$_GET['menuExcepted']."'";
				
				if($_GET['menuStatus']!=1)	
					$extra.=" and MENUSTATUS = '1'";
				
				//get component for current page
				$getMenu = "select MENUORDER,MENUNAME 
								from FLC_MENU 
								where MENULEVEL = '".$_GET['menuLevel']."' ".$extra." 
								order by MENUPARENT,MENULEVEL,MENUORDER";
				$getMenuRs = $myQuery->query($getMenu,'SELECT');
				$getMenuRsCount = count($getMenuRs);
				
				?>
				<select name="<?php if($_GET['menuExcepted']>0){?>editOrder<?php }else {?>newOrder<?php }?>" id="<?php if($_GET['menuExcepted']>0){?>editOrderCombo<?php }else {?>newOrderCombo<?php }?>" class="inputList">
					<option value="0">None</option>
					<?php for($x=0; $x < $getMenuRsCount; $x++) { ?>
					<option value="<?php echo $getMenuRs[$x][0];?>" ><?php echo $getMenuRs[$x][1];?></option>
					<?php } ?>
				</select>
				<?php
			}
		break;
		
		//database mapping
		case 'database' :
			//show dropdown of databse mapping
			if($_GET['component'])
			{	
				//get table / view name to be mapped
				$getMappingTable = "select COMPONENTBINDINGTYPE, COMPONENTBINDINGSOURCE 
									from FLC_PAGE_COMPONENT where COMPONENTID = ".$_GET['component'];
				$getMappingTableRs = $myQuery->query($getMappingTable,'SELECT','NAME');
				
				//if binding type table / view, get list of columns
				if($getMappingTableRs[0]['COMPONENTBINDINGTYPE'] == 'table' || $getMappingTableRs[0]['COMPONENTBINDINGTYPE'] == 'view')
				{	
					//if table / view name is not null
					if($getMappingTableRs[0]['COMPONENTBINDINGSOURCE'] != '')
					{	
						//get list of columns to be mapped (database mapping)
						$getColumnsRs = $mySQL->listTableColumn('','',$getMappingTableRs[0]['COMPONENTBINDINGSOURCE']);
						$getColumnsRsCount = count($getColumnsRs);
					}//end if
				}//end if get mapping table rs
				
				else if($getMappingTableRs[0]['COMPONENTBINDINGTYPE'] == 'stored_procedure')
				{
					//if table / view name is not null
					if($getMappingTableRs[0]['COMPONENTBINDINGSOURCE'] != '')
					{	
						//get list of columns to be mapped (database mapping)
						$getColumnsRs = $mySQL->listProcedureParameter($getMappingTableRs[0]['COMPONENTBINDINGSOURCE']);
						$getColumnsRsCount = count($getColumnsRs);
					}//end if
				}//eof else if
				
				else if($getMappingTableRs[0]['COMPONENTBINDINGTYPE'] == 'bl')
				{
					//if table / view name is not null
					if($getMappingTableRs[0]['COMPONENTBINDINGSOURCE'] != '')
					{	
						//get list of columns to be mapped (database mapping)
						$getColumns = "select blparameter as COLUMN_NAME from FLC_BL 
											where blname='".$getMappingTableRs[0]['COMPONENTBINDINGSOURCE']."' and blstatus='00' 
											order by blparameter";
						$getColumnsRs = $myQuery->query($getColumns,'SELECT','NAME');
						$blParameter = explode('|',$getColumnsRs[0]['COLUMN_NAME']);
						$getColumnsRsCount = count($blParameter);

						//loop on count of parameter
						for($x=0;$x<$getColumnsRsCount;$x++)
							$getColumnsRs[$x]['COLUMN_NAME']=$blParameter[$x];
					}//end if
				}//eof else if
				
				?>
				<select name="<?php if($_GET['mapping']>0){?>editMappingID<?php }else {?>newMappingID<?php }?>" class="inputList" id="<?php if($_GET['mapping']>0){?>editMappingID<?php }else {?>newMappingID<?php }?>" >
				  <option value="">&nbsp;</option>
				  <?php 
					for($x=0; $x < $getColumnsRsCount; $x++) { ?>
				  <option value="<?php echo $getColumnsRs[$x]['COLUMN_NAME']?>" <?php if($_GET['mapping'] == $getColumnsRs[$x]['COLUMN_NAME']) { ?> selected<?php }?> ><?php echo $getColumnsRs[$x]['COLUMN_NAME']?></option>
				  <?php } ?>
	
				</select>
				<?php
			}
			
			//show dropdown of table column
			if($_GET['table'])
			{	
				//get column name by table
				$getColumnsRs = $mySQL->listTableColumn('','',$_GET['table']);
				$getColumnsRsCount = count($getColumnsRs);
				
				?>
				<select name="<?php if($_GET['tableExcepted']>0){?>editUploadColumn<?php }else {?>newUploadColumn<?php }?>" class="inputList" id="<?php if($_GET['tableExcepted']>0){?>editUploadColumn<?php }else {?>newUploadColumn<?php }?>" >
				  <option value="">&nbsp;</option>
				  <?php 
					for($x=0; $x < $getColumnsRsCount; $x++) { ?>
				  <option value="<?php echo $getColumnsRs[$x]['COLUMN_NAME']?>" <?php if($_GET['tableExcepted'] == $getColumnsRs[$x]['COLUMN_NAME']) { ?> selected<?php }?> ><?php echo $getColumnsRs[$x]['COLUMN_NAME']?></option>
				  <?php } ?>
				</select>
				<?php
			}
		break;
	}//eof switch
	//================================ eof cascade dropdown ==================================
}//eof else
?>