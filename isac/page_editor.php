<?php
//--------page to show controller-----------
//if nothing to show
if(!isset($showScreen_1))
	$showScreen_2 = TRUE;

//if tunjuk senarai clicked
if($_POST["showScreen"])
{
	$showScreen_2 = TRUE;
	$showScreen_3 = TRUE;
	$showScreen_1 = TRUE;
}

//if new page clicked
if($_POST["newCategory"])
{
	$showScreen_2 = TRUE;
	$showScreen_4 = TRUE;
}

//if duplicate page clicked
if($_POST["duplicateCategory"])
{
	$showScreen_2 = TRUE;
	$showScreen_4 = TRUE;
}

if($_POST["modifyCategory"])
{
	$showScreen_2 = TRUE;
	$showScreen_5 = TRUE;
}

if($_POST["newComponent"])
{
	$showScreen_2 = TRUE;
	$showScreen_6 = TRUE;
}

if($_POST["editComponent"])
{
	$showScreen_2 = TRUE;
	$showScreen_7 = TRUE;
}

if($_POST["duplicateComponent"])
{
}

if($_POST["newReference"])
{
	$showScreen_2 = TRUE;
	$showScreen_8 = TRUE;
}

if($_POST["editReference"])
{
	$showScreen_2 = TRUE;
	$showScreen_9 = TRUE;
}

//page
//if page NEW,EDIT,DELETE saved
if($_POST["saveScreenEdit"] || $_POST["saveScreenRefNew"] || $_POST["saveScreenRefEdit"] 
	|| $_POST["deleteComponent"] || $_POST["saveScreenItemNew"] 
	|| $_POST["saveScreenItemEdit"] || $_POST["deleteReference"] || $_POST['resetOrderingComponent'] || $_POST['moveUpComponent'] || $_POST['moveDownComponent']
	|| $_POST['resetOrderingItem'] || $_POST['moveUpItem'] || $_POST['moveDownItem'])
{
	$showScreen_2 = TRUE;
	$showScreen_3 = TRUE;
	$showScreen_1 = TRUE;
}

//==================================== PAGE ============================================
//if page is to be modified
else if($_POST["modifyCategory"])
{
	//get page info
	$getPageInfo = "select * from FLC_PAGE where PAGEID = ".$_POST["code"];
	$getPageInfoRs = $myQuery->query($getPageInfo,'SELECT','NAME');
}

//if new page added
if($_POST["saveScreenNew"])
{
	//if duplicate page form list is 
	if(isset($_POST['duplicatePageFrom']))
	{
		//------------- GET COLUMN ---------------------------
		//get list of FLC_PAGE_COMPONENT columns
		$getComponentColumnRs = $mySQL->listTableColumn(DB_DATABASE,DB_USERNAME,'FLC_PAGE_COMPONENT','COMPONENTID,PAGEID');
		$getComponentColumnRsCount = count($getComponentColumnRs);
		
		//loop by component column count
		for($x=0; $x<$getComponentColumnRsCount; $x++)
		{
			//new array of component column
			$theComponentColumn[] = $getComponentColumnRs[$x]['COLUMN_NAME'];
		}//eof for
		
		//get list of FLC_PAGE_COMPONENT_ITEMS columns
		$getItemColumnRs = $mySQL->listTableColumn(DB_DATABASE,DB_USERNAME,'FLC_PAGE_COMPONENT_ITEMS','ITEMID,COMPONENTID');
		$getItemColumnRsCount = count($getItemColumnRs);

		//loop by component column count
		for($x=0; $x<$getItemColumnRsCount; $x++)
		{
			//new array of item column
			$theItemColumn[] = $getItemColumnRs[$x]['COLUMN_NAME'];
		}//eof for
			
		//get list of FLC_PAGE_COMPONENT columns
		$getControlColumnRs = $mySQL->listTableColumn(DB_DATABASE,DB_USERNAME,'FLC_PAGE_CONTROL','CONTROLID,PAGEID');
		$getControlColumnRsCount = count($getControlColumnRs);
		
		//loop by component column count
		for($x=0; $x<$getControlColumnRsCount; $x++)
		{
			//new array of control column
			$theControlColumn[] = $getControlColumnRs[$x]['COLUMN_NAME'];
		}//eof for
		//------------- EOF GET COLUMN ------------------------
		
		//-------------- DUPLICATE PAGE -----------------------
		//get max pageid
		$getMaxPageRs = $mySQL->maxValue('FLC_PAGE','PAGEID');
		
		//insert page
		$insertPage = "insert into FLC_PAGE 
						(PAGEID,PAGENAME,PAGEBREADCRUMBS,PAGEPREPROCESS,PAGEPOSTPROCESS,PAGEPRESCRIPT,PAGEPOSTSCRIPT,PAGENOTES,MENUID, PAGEMEMORY) 
						select ".($getMaxPageRs+1)." as PAGEID,'".$_POST["newPageName"]."' as PAGENAME,
						'".$_POST["newPageBreadcrumbs"]."' as PAGEBREADCRUMBS,
								PAGEPREPROCESS,PAGEPOSTPROCESS,PAGEPRESCRIPT,PAGEPOSTSCRIPT,PAGENOTES,".$_POST["newMenuID"]." as MENUID,
								'".$_POST["newPageMemory"]."' as PAGEMEMORY
								from FLC_PAGE where PAGEID = ".$_POST['duplicatePageFrom'];
		$insertPageRs = $myQuery->query($insertPage,'RUN');
		
		//if page inserted
		if($insertPageRs)
		{
			//select componentid by page
			$componentID = "select COMPONENTID from FLC_PAGE_COMPONENT where PAGEID='".$_POST['duplicatePageFrom']."'";
			$componentIDRs = $myQuery->query($componentID);
			$componentIDRsCount = count($componentIDRs);
			
			//loop by component count
			for($x=0; $x<$componentIDRsCount; $x++)
			{
				//get max componentid
				$getMaxComponentRs = $mySQL->maxValue('FLC_PAGE_COMPONENT','COMPONENTID');
				
				//duplicate component
				$insertComponent = "insert into FLC_PAGE_COMPONENT (COMPONENTID,PAGEID,".implode(',',$theComponentColumn).") 
											select '".($getMaxComponentRs+1)."', ".($getMaxPageRs+1).",".implode(',',$theComponentColumn)." 
												from FLC_PAGE_COMPONENT 
												where PAGEID = '".$_POST['duplicatePageFrom']."' and COMPONENTID='".$componentIDRs[$x][0]."'";
				$insertComponentRs = $myQuery->query($insertComponent,'RUN');
				
				//if component inserted
				if($insertComponentRs)
				{
					//select itemid by component
					$itemID = "select ITEMID from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID='".$componentIDRs[$x][0]."'";
					$itemIDRs = $myQuery->query($itemID);
					$itemIDRsCount = count($itemIDRs);
					
					//loop by item count
					for($y=0; $y<$itemIDRsCount; $y++)
					{
						//get max itemid
						$getMaxItemRs = $mySQL->maxValue('FLC_PAGE_COMPONENT_ITEMS','ITEMID');
						
						//duplicate items				
						$insertItem = "insert into FLC_PAGE_COMPONENT_ITEMS (ITEMID,COMPONENTID,".implode(',',$theItemColumn).")  
											select '".($getMaxItemRs+1)."',".($getMaxComponentRs+1).",".implode(',',$theItemColumn)." 
												from FLC_PAGE_COMPONENT_ITEMS 
												where COMPONENTID = '".$componentIDRs[$x][0]."' and ITEMID='".$itemIDRs[$y][0]."'";
						$insertItemRs = $myQuery->query($insertItem,'RUN');
					}//eof loop
				}//eof if
			}//eof loop
			
			//select controlid by page
			$controlID = "select CONTROLID from FLC_PAGE_CONTROL where PAGEID='".$_POST['duplicatePageFrom']."'";
			$controlIDRs = $myQuery->query($controlID);
			$controlIDRsCount = count($controlIDRs);
			
			//loop by control count
			for($x=0; $x<$controlIDRsCount; $x++)
			{
				//get max controlid
				$getMaxControlRs = $mySQL->maxValue('FLC_PAGE_CONTROL','CONTROLID');
				
				//duplicate control
				$insertControl = "insert into FLC_PAGE_CONTROL (CONTROLID,PAGEID,".implode(',',$theControlColumn).")
									select '".($getMaxControlRs+1)."','".($getMaxPageRs+1)."',".implode(',',$theControlColumn)." 
										from FLC_PAGE_CONTROL 
										where PAGEID = '".$_POST['duplicatePageFrom']."' and CONTROLID='".$controlIDRs[$x][0]."'";
				$insertControlRs = $myQuery->query($insertControl,'RUN');
			}//eof for
		}//eof if
	}//eof if
	
	//if not duplicate page, insert new page
	else
	{
		//insert page
		$insertCat = "insert into FLC_PAGE 
						(PAGEID,PAGENAME,PAGEBREADCRUMBS,PAGEPREPROCESS,PAGEPOSTPROCESS,PAGEPRESCRIPT,PAGEPOSTSCRIPT,PAGENOTES,MENUID, PAGEMEMORY) 
						values ((".$mySQL->maxValue('FLC_PAGE','PAGEID').")+1,'".$_POST["newPageName"]."','".$_POST["newPageBreadcrumbs"]."',
						'".$_POST["newPagePreProcess"]."','".$_POST["newPagePostProcess"]."','".$_POST["newPagePreScript"]."','".$_POST["newPagePostScript"]."',
						'".$_POST["newPageNotes"]."',".$_POST["newMenuID"].",'".$_POST["newPageMemory"]."')";
		$insertCatRs = $myQuery->query($insertCat,'RUN');
	}//eof else
	
	//update versioning
	//xml_version_update($menuid);
}//eof if

//if modify PAGE submitted
if($_POST["saveScreenEdit"])
{
	//update category
	$updateCat = "update FLC_PAGE set 
					PAGENAME = '".$_POST["editPageName"]."',
					PAGEBREADCRUMBS = '".$_POST["editPageBreadcrumbs"]."', 
					PAGEPREPROCESS = '".$_POST["editPagePreProcess"]."',
					PAGEPOSTPROCESS = '".$_POST["editPagePostProcess"]."',
					PAGEPRESCRIPT = '".$_POST["editPagePreScript"]."',
					PAGEPOSTSCRIPT = '".$_POST["editPagePostScript"]."',
					PAGENOTES = '".$_POST["editPageNotes"]."',
					PAGEMEMORY = '".$_POST["editPageMemory"]."',
					MENUID = ".$_POST["editMenuID"]." 
					where PAGEID = ".$_POST["code"];
	$updateCatRs = $myQuery->query($updateCat,'RUN');
	
	//update versioning
	//xml_version_update($menuid);
}//eof if

//if page deleted
else if($_POST['deleteCategory'])
{	
	//delete page
	$deletePage = "delete from FLC_PAGE
					where PAGEID = '".$_POST['code']."'";	
	$deletePageRs = $myQuery->query($deletePage,'RUN');
	
	//if page deleted
	if($deletePageRs)
	{
		//get list of components to be deleted
		$getComponentID = "select COMPONENTID from FLC_PAGE_COMPONENT where PAGEID = '".$_POST["code"]."'";
		$getComponentIDRs = $myQuery->query($getComponentID);
		$getComponentIDRsCount = count($getComponentIDRs);
		
		//fetch list of component to be deleted
		for($x=0; $x<$getComponentIDRsCount; $x++)
		{
			$theComponent[] = $getComponentIDRs[$x][0];
		}//eof for
		
		//delete component
		$deleteComponent = "delete from FLC_PAGE_COMPONENT where PAGEID = '".$_POST["code"]."'";
		$deleteComponentRs = $myQuery->query($deleteComponent,'RUN');
		
		if($theComponent)
		{
			//delete page component items
			$deleteItem = "delete from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID in ('".implode("','",$theComponent)."')";
			$deleteItemRs = $myQuery->query($deleteItem,'RUN');
		}//eof if
		
		//delete control
		$deleteControl = "delete from FLC_PAGE_CONTROL where PAGEID = '".$_POST["code"]."'";
		$deleteControlRs = $myQuery->query($deleteControl,'RUN');
	}//eof if
	
	//update versioning
	//xml_version_update($menuid);
}//eof if
//=================================== //PAGE ===========================================

//================================== COMPONENT =========================================
//if new component button clicked
if($_POST["newComponent"] || $_POST["editComponent"])
{
	//get latest ordering index
	$getOrder = "select max(COMPONENTORDER) as MAXORDER from FLC_PAGE_COMPONENT where PAGEID = ".$_POST["code"];
	$getOrderRs = $myQuery->query($getOrder,'COUNT') + 1;
	
	//get list of table
	$getTableRs = $mySQL->listTable(DB_OTHERS);
	
	//get list of views
	$getViewRs = $mySQL->listView(DB_OTHERS);
	
	//get list of stored procedure
	$getProcedureRs = $mySQL->listProcedure(DB_OTHERS);
	
	//get list of bl
	$getBLRs=$mySQL->listActiveBL();
	
	//get constraint search type
	$getConstraint = "select REFERENCECODE,DESCRIPTION1 from REFSYSTEM 
				where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'COMPONENT_SEARCH_TYPE') 
				order by REFERENCECODE";
	$getConstraintRs = $myQuery->query($getConstraint,'SELECT','NAME');
	
	//get webservice client list
	$getWebservice = "select a.wsvc_name, a.wsvc_id from FLC_WEBSERVICE a, FLC_WEBSERVICE_CLIENT b 
						where a.wsvc_id = b.wsvc_id
						and a.wsvc_webservice_client_flag = 'client'
						order by a.wsvc_name ";
	$getWebserviceRs = $myQuery->query($getWebservice,'SELECT','NAME');
	
	//get calendar list
	/*$getCalendar = "select calendar_id,calendar_name
						from FLC_CALENDAR
						order by calendar_name";
	$getCalendarRs = $myQuery->query($getCalendar,'SELECT','NAME');*/
	
	//get loading list
	$getLoadingRs=$mySQL->listActiveLoading();	
}

//if edit component button clicked
if($_POST["editComponent"])
{
	//get component info
	$getEditComponent = "select * from FLC_PAGE_COMPONENT where COMPONENTID = ".$_POST["hiddenComponentID"];
	$getEditComponentRs = $myQuery->query($getEditComponent,'SELECT','NAME');
	
	//get list of columns to be mapped (database mapping)
	$getColumnsRs = $mySQL->listTableColumn('','',$getEditComponentRs[0]['COMPONENTBINDINGSOURCE']);
	$getColumnsRsCount = count($getColumnsRs);
}

//if new component added
if($_POST["saveScreenRefNew"])	
{	
	//get max componentid
	$maxComponent = 'select max(COMPONENTID) from FLC_PAGE_COMPONENT';
	$maxComponentRs = $myQuery->query($maxComponent,'COUNT') + 1;
	
	//set minimum order value
	if($_POST["newComponentOrder"]==0||$_POST["newComponentOrder"]=='')
		$_POST["newComponentOrder"]=1;
	
	//increment order if option is after
	if($_POST["orderOption"]=='++')
		$_POST["newComponentOrder"]++;
	
	//prepare insert statement
	//insert statement part 1
	$newComponent_1 = "insert into FLC_PAGE_COMPONENT (COMPONENTID,COMPONENTNAME,COMPONENTORDER,PAGEID,COMPONENTTYPE,
						COMPONENTSTATUS,COMPONENTPATH,COMPONENTPREPROCESS,COMPONENTPOSTPROCESS,COMPONENTPRESCRIPT,COMPONENTPOSTSCRIPT,
						COMPONENTBINDINGTYPE,COMPONENTBINDINGSOURCE,COMPONENTUPLOADCOLUMN";
	
	//insert statement part 2
	$newComponent_2 = "values (".$maxComponentRs.",'".$_POST["newComponentName"]."',".$_POST["newComponentOrder"].",
						".$_POST["code"].",'".$_POST['newComponentType']."',".$_POST['newComponentStatus'].",'".$_POST['newComponentPath']."',
						'".$_POST['newComponentPreProcess']."','".$_POST['newComponentPostProcess']."',
						'".$_POST['newComponentPreScript']."','".$_POST['newComponentPostScript']."','".$_POST['newDataBindingType']."',
						'".strtoupper($_POST['newDataSource'])."','".$_POST['newUploadColumn']."'";
	
	//default row number
	if($_POST['newComponentType'] == 'tabular'||$_POST['newComponentType'] == 'report')
	{
		//trim whitespaces
		$_POST['newTabularDefaultRowNo'] = trim($_POST['newTabularDefaultRowNo']);
		
		//set default value
		if($_POST['newTabularDefaultRowNo'] == '')	
			$_POST['newTabularDefaultRowNo'] = 5;
			
		//default row
		$newComponent_1 .= ",COMPONENTABULARDEFAULTROWNO";
		$newComponent_2 .= ",".$_POST['newTabularDefaultRowNo'];
		
		//add row
		$newComponent_1 .= ",COMPONENTADDROW";
		$newComponent_2 .= ",'".$_POST['newAddRow']."'";
		$newComponent_1 .= ",COMPONENTDELETEROW";
		$newComponent_2 .= ",'".$_POST['newDeleteRow']."'";
		$newComponent_1 .= ",COMPONENTADDROWDISABLED";
		$newComponent_2 .= ",".$_POST['newAddRowDisabled'];
		$newComponent_1 .= ",COMPONENTDELETEROWDISABLED";
		$newComponent_2 .= ",".$_POST['newDeleteRowDisabled'];
		
		//add row javascript
		$newComponent_1 .= ",COMPONENTADDROWJAVASCRIPT";
		$newComponent_2 .= ",'".$_POST['newAddJavascript']."'";
		
		//delete row javascript
		$newComponent_1 .= ",COMPONENTDELETEROWJAVASCRIPT";
		$newComponent_2 .= ",'".$_POST['newDeleteJavascript']."'";
	}
	
	//if form is query or report, append this to sql
	if($_POST['newComponentType'] == 'query' || $_POST['newComponentType'] == 'query_2_col' || $_POST['newComponentType'] == 'report' || $_POST['newComponentType'] == 'search_constraint')
	{
		$newComponent_1 .= ",COMPONENTTYPEQUERY";
		$newComponent_2 .= ",'".$_POST['newTypeQuery']."'";
		
		//if type is search constraint, append this to sql
		if($_POST['newComponentType'] == 'search_constraint')
		{
			$newComponent_1 .= ",COMPONENTMASTERID";
			$newComponent_2 .= ",'".$_POST['newMasterID']."'";
		}
		
		//if query unlimited is set
		if($_POST['newQueryLimit'])
		{
			$newComponent_1 .= ",COMPONENTQUERYUNLIMITED";
			$newComponent_2 .= ",'".$_POST['newQueryLimit']."'";
		}
	}
	
	//if form is query, append this to sql
	else if($_POST['newComponentType'] == 'flatfile_view')
	{
		$newComponent_1 .= ",COMPONENTFLATFILEFIXEDLENGTH";
		$newComponent_2 .= ",'".$_POST['newItemFlatfileFixedLength']."'";
	}
	
	//combine query statement
	$newComponent = $newComponent_1.")".$newComponent_2.")";

	//clean up sql
	$toReplace = array('[qs]','[Qs]','[qS]','[qd]','[Qd]','[qD]');
	$theReplacement = array('[QS]','[QS]','[QS]','[QD]','[QD]','[QD]');
	$newComponent = str_replace($toReplace,$theReplacement,$newComponent);
		
	//run the statement
	$newComponentRs = $myQuery->query($newComponent,'RUN');
	
	/*===insert at specified position===*/
	//get current orders for component by page
	$getOrder = "select COMPONENTORDER, COMPONENTID from FLC_PAGE_COMPONENT
					where pageid='".$_POST["code"]."' and componentid != '".$maxComponentRs."'
					order by COMPONENTORDER,COMPONENTID";
	$getOrderRs = $myQuery->query($getOrder,'SELECT');
	$getOrderRsCount = count($getOrderRs);
	
	//increment current component order
	$orderIncrement=false;
	
	for($x=0; $x<$getOrderRsCount; $x++)
	{
		if($getOrderRs[$x][0]==$_POST['newComponentOrder'])
		{
			$orderIncrement=true;
		}//eof if
		
		if($orderIncrement)
		{
			$orderUpdate = "update FLC_PAGE_COMPONENT
							set COMPONENTORDER=".(int)++$getOrderRs[$x][0]."
							where COMPONENTID='".$getOrderRs[$x][1]."'";
			$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
		}//eof if
	}//eof for
	
	//update versioning
	//xml_version_update($menuid);
}//eof if

//if save screen edit component
else if($_POST["saveScreenRefEdit"])
{	
	//set minimum order value
	if($_POST['editComponentOrder']==0||$_POST['editComponentOrder']=='')
		$_POST['editComponentOrder']=1;
	
	//increment order if option is after
	if($_POST['orderOption']=='++')
		$_POST['editComponentOrder']++;
	
	//prepare update statement
	//update statement part 1
	$updateRef = "update FLC_PAGE_COMPONENT 
						set COMPONENTNAME = '".$_POST['editComponentName']."', 
						COMPONENTORDER = '".$_POST['editComponentOrder']."',
						COMPONENTTYPE = '".$_POST['editComponentType']."',
						COMPONENTSTATUS = ".$_POST['editComponentStatus'].",
						COMPONENTPATH = '".$_POST['editComponentPath']."',
						COMPONENTPREPROCESS = '".$_POST['editComponentPreProcess']."',
						COMPONENTPOSTPROCESS = '".$_POST['editComponentPostProcess']."',
						COMPONENTPRESCRIPT = '".$_POST['editComponentPreScript']."',
						COMPONENTPOSTSCRIPT = '".$_POST['editComponentPostScript']."',
						COMPONENTBINDINGTYPE = '".$_POST['editDataBindingType']."',
						COMPONENTBINDINGSOURCE = '".strtoupper($_POST['editDataSource'])."',
						COMPONENTUPLOADCOLUMN = '".$_POST['editUploadColumn']."'";
	
	//default row number
	if($_POST['editComponentType'] == 'tabular'||$_POST['editComponentType'] == 'report')
	{	
		//trim whitespaces
		$_POST['editTabularDefaultRowNo'] = trim($_POST['editTabularDefaultRowNo']);
		
		//set default value and 
		if($_POST['editTabularDefaultRowNo'] == '')	
			$_POST['editTabularDefaultRowNo'] = 5;
		
		 //2010
  		if($_POST['editAddRowDisabled'] == ''){$_POST['editAddRowDisabled'] = '0';}	
		
		
		//append this to sql
		$updateRef .= ",COMPONENTABULARDEFAULTROWNO = ".$_POST['editTabularDefaultRowNo'];
		$updateRef .= ",COMPONENTADDROW = '".$_POST['editAddRow']."'";
		$updateRef .= ",COMPONENTDELETEROW = '".$_POST['editDeleteRow']."'";
		$updateRef .= ",COMPONENTADDROWDISABLED = ".$_POST['editAddRowDisabled'];
		$updateRef .= ",COMPONENTDELETEROWDISABLED = ".$_POST['editDeleteRowDisabled'];
		$updateRef .= ",COMPONENTADDROWJAVASCRIPT = '".$_POST['editAddJavascript']."'";
		$updateRef .= ",COMPONENTDELETEROWJAVASCRIPT = '".$_POST['editDeleteJavascript']."'";
	}
	
	//if form is form, remove component searchtype -> append this to sql
	if($_POST['editComponentType'] == 'form')
	{
		$updateRef .= ",COMPONENTSEARCHTYPE = null ";
	}
	
	//if form is query or report
	if($_POST['editComponentType'] == 'query' || $_POST['editComponentType'] == 'query_2_col' || $_POST['editComponentType'] == 'report' || $_POST['editComponentType'] == 'search_constraint')
	{
		$updateRef .= ",COMPONENTTYPEQUERY = '".$_POST['editTypeQuery']."'";
		
		if($_POST['editQueryLimit'])
			$updateRef .= ",COMPONENTQUERYUNLIMITED = '".$_POST['editQueryLimit']."'";
			
		//if type is search constraint, append this to sql
		if($_POST['editComponentType'] == 'search_constraint')
			$updateRef .= ",COMPONENTMASTERID = '".$_POST['editMasterID']."'";
	}
	
	//if form is query, append this to sql
	else if($_POST['editComponentType'] == 'flatfile_view')
	{
		$updateRef .= ",COMPONENTFLATFILEFIXEDLENGTH = '".$_POST['editItemFlatfileFixedLength']."'";
	}
	
	//finalize update reference
	$updateRef .= " where COMPONENTID = ".$_POST["hiddenComponentID"];
	
	//clean up sql
	$toReplace = array('[qs]','[Qs]','[qS]','[qd]','[Qd]','[qD]');
	$theReplacement = array('[QS]','[QS]','[QS]','[QD]','[QD]','[QD]');
	$updateRef = str_replace($toReplace,$theReplacement,$updateRef);
	
	//run update statement
	$updateRefRs = $myQuery->query($updateRef,'RUN');
	
	/*===insert at specified position===*/
	//get current orders for component by page
	$getOrder = "select COMPONENTORDER, COMPONENTID from FLC_PAGE_COMPONENT
					where pageid='".$_POST["code"]."' and COMPONENTID != '".$_POST["hiddenComponentID"]."'
					order by COMPONENTORDER,COMPONENTID";
	$getOrderRs = $myQuery->query($getOrder,'SELECT');
	$getOrderRsCount = count($getOrderRs);
	
	//increment current component order
	$orderIncrement=false;
	for($x=0; $x<$getOrderRsCount; $x++)
	{
		if($getOrderRs[$x][0]==$_POST['editComponentOrder'])
		{
			$orderIncrement=true;
		}//eof if
		
		if($orderIncrement)
		{
			$orderUpdate = "update FLC_PAGE_COMPONENT
							set COMPONENTORDER=".(int)++$getOrderRs[$x][0]."
							where COMPONENTID='".$getOrderRs[$x][1]."'";
			$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
		}//eof if
	}//eof for
	
	//update versioning
	//xml_version_update($menuid);
}//eof if

//if duplicate component clicked
else if($_POST['duplicateComponent'])
{	
	//get max componentid
	$maxComponent = "select max(COMPONENTID) from FLC_PAGE_COMPONENT";
	$maxComponentRs = $myQuery->query($maxComponent,'COUNT') + 1;
	
	//---duplicate the component ---
	//prepare insert statement

	//get list of FLC_PAGE_COMPONENT columns
	$getComponentColumnRs = $mySQL->listTableColumn(DB_DATABASE,DB_USERNAME,'FLC_PAGE_COMPONENT','COMPONENTID,COMPONENTNAME');
	$getComponentColumnCount = count($getComponentColumnRs);
	
	//clear the array
	$theComponentColumn = array();

	//generate insert query
	for($a=0; $a < $getComponentColumnCount; $a++)
	{	
		$theComponentColumn[] = $getComponentColumnRs[$a]['COLUMN_NAME'];		//the column name
	}
	
	//insert statement part 1 - to duplicate component
	$duplicateComponent = "insert into FLC_PAGE_COMPONENT (COMPONENTID,COMPONENTNAME,".implode(',',$theComponentColumn).") 
								select ".$maxComponentRs.",".$mySQL->concat("'Duplicate of '","COMPONENTNAME").",".implode(',',$theComponentColumn)." 
									from FLC_PAGE_COMPONENT 
									where COMPONENTID = ".$_POST['hiddenComponentID'];

	//run the statement
	$duplicateComponentRs = $myQuery->query($duplicateComponent,'RUN');	
	
	//update versioning
	//xml_version_update($menuid);
}

//if component deleted
else if($_POST["deleteComponent"])
{	
	//delete component
	$deleteRef = "delete from FLC_PAGE_COMPONENT 
					where COMPONENTID = ".$_POST["hiddenComponentID"];
	$deleteRefRs = $myQuery->query($deleteRef,'RUN');
	
	//delete component items
	$deleteRefItem = "delete from FLC_PAGE_COMPONENT_ITEMS where COMPONENTID = ".$_POST["hiddenComponentID"];
	$deleteRefItemRs = $myQuery->query($deleteRefItem,'RUN');
	
	//update versioning
	//xml_version_update($menuid);
}

//if order - move up clicked
if($_POST["moveUpComponent"])
{	
	//check current ORDER position
	$checkPos = "select COMPONENTORDER from FLC_PAGE_COMPONENT where COMPONENTID = ".$_POST['hiddenComponentID'];
	$checkPosRs = $myQuery->query($checkPos,'SELECT','NAME');

	//if current position is NOT 1, move up
	if($checkPosRs[0]['COMPONENTORDER'] != 1)
	{
		$updatePos = "update FLC_PAGE_COMPONENT set COMPONENTORDER = ".($checkPosRs[0]['COMPONENTORDER'] - 1)." 
						where COMPONENTID = ".$_POST['hiddenComponentID'];
		$updatePosFlag = $myQuery->query($updatePos,'RUN');
	}//eof if
}//eof if

//if order - move down clicked
if($_POST["moveDownComponent"])
{
	//check current ORDER position
	$checkPos = "select COMPONENTORDER from FLC_PAGE_COMPONENT where COMPONENTID = ".$_POST['hiddenComponentID'];
	$checkPosRs = $myQuery->query($checkPos,'SELECT','NAME');
	
	//update the position
	$updatePos = "update FLC_PAGE_COMPONENT set COMPONENTORDER = ".($checkPosRs[0]['COMPONENTORDER'] + 1)." 
					where COMPONENTID = ".$_POST['hiddenComponentID'];
	$updatePosFlag = $myQuery->query($updatePos,'RUN');
}//eof if

//if reset ordering button clicked
if($_POST["resetOrderingComponent"])
{
	//get menu ordering level 2
	$getOrder = "select COMPONENTID from FLC_PAGE_COMPONENT where PAGEID = ".$_POST['code']." 
						order by COMPONENTORDER";
	//print_r($_POST);
	
	$getOrderRs = $myQuery->query($getOrder,'SELECT','NAME');
	
	//count result rows
	$countComponent = count($getOrderRs);
	
	//for all menus level 2, update menu
	for($x=0; $x < $countComponent; $x++)
	{
		$updateOrder = "update FLC_PAGE_COMPONENT set COMPONENTORDER = ".($x+1)." 
								where COMPONENTID = ".$getOrderRs[$x]['COMPONENTID'];
		$updateOrderComponentFlag = $myQuery->query($updateOrder,'RUN');
	}	
}

//================================= //COMPONENT ========================================
//================================= COMPONENT ITEMS ====================================
//if new component item or edit component item clicked
if($_POST["newReference"] || $_POST["editReference"])
{
	//get list of things needed for dropdown
	
	//get item type
	$itemType = "select REFERENCECODE,DESCRIPTION2 from REFSYSTEM 
					where MASTERCODE = (select REFERENCECODE  
									from REFSYSTEM 
									where MASTERCODE =  'XXX' 
									and DESCRIPTION1 = 'SYS_INPUT_TYPE')
					order by DESCRIPTION2,REFERENCECODE";
	$itemTypeRs = $myQuery->query($itemType,'SELECT','NAME');
	
	//predefined lookup
	$predefined = "select DESCRIPTION1 from REFGENERAL where MASTERCODE = 'XXX' 
						and ReferenceStatusCode = '00' 
						and DESCRIPTION1 is not null 
						order by DESCRIPTION1";
	$predefinedRs = $myQuery->query($predefined,'SELECT','NAME');
	
	//get component item for current page
	$getItemName = "select b.ITEMORDER, b.ITEMNAME, a.COMPONENTID
						from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
						where a.COMPONENTID = b.COMPONENTID 
						and a.PAGEID = '".$_POST["code"]."' 
						order by a.COMPONENTORDER, b.ITEMORDER";
	$getItemNameRs = $myQuery->query($getItemName,'SELECT');
	$getItemNameRsCount = count($getItemNameRs);
	
	//get list of javascript library
	$getJsLib = "select * from FLC_JS_LIB order by JS_DESC";
	$getJsLibRs = $myQuery->query($getJsLib,'SELECT','NAME');
	$getJsLibRsCount = count($getJsLibRs);
		
	$x=0;	//initial value for x (index of array)
	$component=$getItemNameRs[0][2];	//initial/temp value of component id
	//looping to re-set value into new array
	for($y=0;$y<$getItemNameRsCount;$y++)
	{
		if($getItemNameRs[$y][2]!=$component)		//new array index if not same
			$x++;	//increment index
		
		//set value into new array
		$ComponentItemArray[$x]['componentid']=$getItemNameRs[$y][2];
		$ComponentItemArray[$x][$y][0]=$getItemNameRs[$y][0];
		$ComponentItemArray[$x][$y][1]=$getItemNameRs[$y][1];
	}
	$ComponentItemArrayCount=count($ComponentItemArray);
	//print_r($ComponentItemArray);
}//eof if

//if edit component item clicked, show detail
if($_POST["editReference"])
{
	//show reference detail
	$showEditComponentItem = "select b.* from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
								where a.COMPONENTID = b.COMPONENTID
								and ITEMID = ".$_POST["hiddenItemID"];
	$showEditComponentItemRs = $myQuery->query($showEditComponentItem,'SELECT','NAME');
	
	//--------------- upload component-----------------
	$uploadTemp=explode('|',$showEditComponentItemRs[0]['ITEMUPLOAD']);
	$uploadExtension=$uploadTemp[0];
	$uploadFolder=$uploadTemp[1];
	$uploadMaxSize=$uploadTemp[2];
	
	//---------------database mapping -----------------
	//if hav value when editting
	if($showEditComponentItemRs[0]['COMPONENTID'])
		$_POST['componentID']=$showEditComponentItemRs[0]['COMPONENTID'];
		
	//if component mapping is set	
	if($_POST['componentID'])
	{	
		//get table / view name to be mapped
		$getMappingTable = "select COMPONENTBINDINGTYPE, COMPONENTBINDINGSOURCE 
							from FLC_PAGE_COMPONENT where COMPONENTID = ".$_POST['componentID'];
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
				$getColumnsRs = $mySQL->listProcedureParameter($getMappingTableRs[0]['COMPONENTBINDINGSOURCE'],'IN');
				$getColumnsRsCount = count($getColumnsRs);
			}//end if
		}
		
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
		}
	}//end if post component id
	//-------------------------------------------------
}

//if new component item button save clicked
if($_POST["saveScreenItemNew"])
{	
	//set minimum order value
	if($_POST['newItemOrder']==0||$_POST['newItemOrder']=='')
		$_POST['newItemOrder']=1;
	
	//increment order if option is after
	if($_POST['orderOption']=='++')
		$_POST['newItemOrder']++;
		
	//if item lookup type = predefined
	if($_POST["newLookupType"] == "predefined")
	{
		//make query template for item lookup
		$itemLookup = "select REFERENCECODE as flc_id, DESCRIPTION1 as flc_name 
						from REFGENERAL 
						where MASTERCODE = (select REFERENCECODE from REFGENERAL 
											where MASTERCODE = ''XXX''
											and DESCRIPTION1 = ''".strtoupper($_POST["newPredefinedLookup"])."'') 
						and ReferenceStatusCode = ''00''
						order by DESCRIPTION1";
	}
	else if($_POST["newLookupType"] == "advanced")
	{
		$itemLookup = $_POST["newAdvancedLookup"];
	}
	
	//to prevent error
	if($_POST["newMappingID"] == "")
		$_POST["newMappingID"] = "null";
	
	if(trim($_POST["newItemJavascriptEvent"]) == "")
		$_POST["newItemJavascriptEvent"] = "null";
		
	if(trim($_POST['newTabIndex']) == '')
		$_POST['newTabIndex'] = "null";
	
	if(trim($_POST['newItemMinChar']) == '')
		$_POST['newItemMinChar'] = "null";
	
	if(trim($_POST['newItemMaxChar']) == '')
		$_POST['newItemMaxChar'] = "null";
		
	//concat all inputs for upload separated by '|'
	$_POST['newUpload']=$_POST['newFileExtension'].'|'.$_POST['newUploadFolder'].'|'.$_POST['newMaxSize'];
	
	//get max item id
	$maxID = 'select max(ITEMID) from FLC_PAGE_COMPONENT_ITEMS';
	$maxIDRs = $myQuery->query($maxID,'COUNT') + 1;
		
	//save new component
	$newItem = "insert into FLC_PAGE_COMPONENT_ITEMS 
				(ITEMID,ITEMNAME,ITEMTYPE,ITEMORDER,ITEMNOTES,ITEMINPUTLENGTH,ITEMDEFAULTVALUE,ITEMDEFAULTVALUEQUERY,ITEMLOOKUPTYPE,ITEMLOOKUP,ITEMJAVASCRIPTEVENT,ITEMJAVASCRIPT,
					COMPONENTID,SEARCHFLAG,ITEMAGGREGATECOLUMN,ITEMAGGREGATECOLUMNLABEL,ITEMCHECKALL,ITEMTABINDEX,ITEMSTATUS,ITEMMINCHAR,ITEMMAXCHAR,
					ITEMREQUIRED,ITEMUNIQUE,MAPPINGID,ITEMPRIMARYCOLUMN,ITEMUPLOAD,ITEMDELIMITER,URLFLAG,ITEMTEXTALIGN,ITEMLOOKUPUNLIMITED,ITEMUPPERCASE,
					ITEMDISABLED,ITEMREADONLY,ITEMAPPENDTOBEFORE)  
				values (".$maxIDRs.",'".$_POST["newItemName"]."','".$_POST["newItemType"]."',".$_POST["newItemOrder"].",'".$_POST["newItemNotes"]."',
				'".$_POST["newItemInputLength"]."','".$_POST["newItemDefaultValue"]."','".$_POST["newDefaultValueQuery"]."','".$_POST["newLookupType"]."','".$itemLookup."',
				".$_POST["newItemJavascriptEvent"].",'".$_POST["newItemJavascript"]."',".$_POST["componentID"].",
				".$_POST['newSearchFlag'].",'".$_POST['newAggregateColumn']."','".$_POST['newAggregateColumnLabel']."',".$_POST['newCheckAll'].",
				".$_POST['newTabIndex'].",".$_POST['newItemStatus'].",".$_POST['newItemMinChar'].",".$_POST['newItemMaxChar'].",
				'".$_POST['newItemRequired']."','".$_POST['newItemUnique']."','".$_POST['newMappingID']."','".$_POST['newItemPrimaryColumn']."',
				'".$_POST['newUpload']."','".$_POST['newItemDelimiter']."','".$_POST['newURLFlag']."','".$_POST['newItemTextAlign']."',
				'".$_POST['newAdvQueryLimit']."','".$_POST['newItemUppercase']."','".$_POST['newItemDisabled']."','".$_POST['newItemReadonly']."',".$_POST['newItemAppend'].")";
	
	$newItemRs = $myQuery->query($newItem,'RUN');
	
	/*===insert component item at specified position===*/
	//get current orders for component by page
	$getOrder = "select b.ITEMORDER, b.ITEMID, a.COMPONENTID
					from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
					where a.COMPONENTID = b.COMPONENTID 
					and a.PAGEID = '".$_POST["code"]."' and a.COMPONENTID = '".$_POST["componentID"]."' and b.ITEMID != '".$maxIDRs."'
					order by a.COMPONENTORDER, b.ITEMORDER";
	$getOrderRs = $myQuery->query($getOrder,'SELECT');
	$getOrderRsCount = count($getOrderRs);
	
	//increment current component order
	$orderIncrement=false;
	for($x=0; $x<$getOrderRsCount; $x++)
	{
		if($getOrderRs[$x][0]==$_POST['newItemOrder'])
		{
			$orderIncrement=true;
		}//eof if
		
		if($orderIncrement)
		{
			$orderUpdate = "update FLC_PAGE_COMPONENT_ITEMS
							set ITEMORDER=".(int)++$getOrderRs[$x][0]."
							where ITEMID='".$getOrderRs[$x][1]."' and COMPONENTID='".$getOrderRs[$x][2]."'";
			$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
		}//eof if
	}//eof for
	
	//update versioning
	//xml_version_update($menuid);
}//eof if

//if component item edit, save screen clicked, save ler
if($_POST["saveScreenItemEdit"])
{	
	//set minimum order value
	if($_POST['editItemOrder']==0||$_POST['editItemOrder']=='')
		$_POST['editItemOrder']=1;
	
	//increment order if option is after
	if($_POST['orderOption']=='++')
		$_POST['editItemOrder']++;
		
	//if item lookup type = predefined
	if($_POST["editLookupType"] == "predefined")
	{
		//make query template for item lookup
		$itemLookup = "select REFERENCECODE as flc_id, DESCRIPTION1 as flc_name 
						from REFGENERAL 
						where MASTERCODE = (select REFERENCECODE from REFGENERAL 
											where MASTERCODE = ''XXX''
											and DESCRIPTION1 = ''".strtoupper($_POST["editPredefinedLookup"])."'') 
						and ReferenceStatusCode = ''00''
						order by DESCRIPTION1";
	}
	else if($_POST["editLookupType"] == "advanced")
	{
		$itemLookup = $_POST["editAdvancedLookup"];
	}
	
	if($_POST["editMappingID"] == "")
		$_POST["editMappingID"] = "null";
	
	if($_POST["editItemJavascriptEvent"] == "")
		$_POST["editItemJavascriptEvent"] = "null";

	if($_POST["editTabIndex"] == "")
		$_POST["editTabIndex"] = "null";
		
	if(trim($_POST['editItemMinChar']) == '')
		$_POST['editItemMinChar'] = "null";
	
	if(trim($_POST['editItemMaxChar']) == '')
		$_POST['editItemMaxChar'] = "null";
		
	//concat all inputs for upload separated by '|'
	$_POST['editUpload']=$_POST['editFileExtension'].'|'.$_POST['editUploadFolder'].'|'.$_POST['editMaxSize'];
	
	//update component edit changes
	$updateComponentItem = "update FLC_PAGE_COMPONENT_ITEMS 
							set ITEMNAME = '".$_POST["editItemName"]."',
							ITEMTYPE = '".$_POST["editItemType"]."',
							ITEMORDER = '".$_POST["editItemOrder"]."',
							ITEMNOTES = '".$_POST["editItemNotes"]."',
							ITEMINPUTLENGTH = '".$_POST["editItemInputLength"]."',
							ITEMTEXTAREAROWS = '".$_POST["editTextareaRows"]."',
							ITEMDEFAULTVALUE = '".$_POST["editItemDefaultValue"]."',
							ITEMDEFAULTVALUEQUERY = '".$_POST["editItemDefaultValueQuery"]."',
							ITEMLOOKUPTYPE = '".$_POST["editLookupType"]."',
							ITEMLOOKUP = '".$itemLookup."',
							ITEMJAVASCRIPTEVENT = ".$_POST["editItemJavascriptEvent"].",
							ITEMJAVASCRIPT = '".$_POST["editItemJavascript"]."',
							COMPONENTID = '".$_POST["componentID"]."',
							SEARCHFLAG = ".$_POST['editSearchFlag'].",
							ITEMTABINDEX = ".$_POST["editTabIndex"].",
							ITEMAGGREGATECOLUMN = '".$_POST['editAggregateColumn']."',
							ITEMAGGREGATECOLUMNLABEL = '".$_POST['editAggregateColumnLabel']."',
							ITEMCHECKALL = ".$_POST['editCheckAll'].",
							ITEMSTATUS = ".$_POST['editItemStatus'].",
							ITEMMINCHAR = ".$_POST['editItemMinChar'].",
							ITEMMAXCHAR = ".$_POST['editItemMaxChar'].",
							ITEMREQUIRED = ".$_POST['editItemRequired'].",
							ITEMUNIQUE = ".$_POST['editItemUnique'].",
							MAPPINGID = '".$_POST['editMappingID']."',
							ITEMPRIMARYCOLUMN = '".$_POST['editItemPrimaryColumn']."',
							ITEMUPLOAD = '".$_POST['editUpload']."',
							ITEMDELIMITER = '".$_POST['editItemDelimiter']."',
							URLFLAG = '".$_POST['editURLFlag']."',
							ITEMTEXTALIGN = '".$_POST['editItemTextAlign']."',
							ITEMLOOKUPUNLIMITED = '".$_POST['editAdvQueryLimit']."',
							ITEMUPPERCASE = '".$_POST['editItemUppercase']."',
							ITEMDISABLED = '".$_POST['editItemDisabled']."',
							ITEMREADONLY = '".$_POST['editItemReadonly']."',
							ITEMAPPENDTOBEFORE = '".$_POST['editItemAppend']."'
							where ITEMID = ".$_POST["hiddenItemID"];
	$updateComponentItemRs = $myQuery->query($updateComponentItem,'RUN');
	
	/*===insert component item at specified position===*/
	//get current orders for component by page
	$getOrder = "select b.ITEMORDER, b.ITEMID, a.COMPONENTID
					from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
					where a.COMPONENTID = b.COMPONENTID 
					and a.PAGEID = '".$_POST["code"]."' and a.COMPONENTID = '".$_POST["componentID"]."' and b.ITEMID != '".$_POST["hiddenItemID"]."'
					order by a.COMPONENTORDER, b.ITEMORDER";
	$getOrderRs = $myQuery->query($getOrder,'SELECT');
	$getOrderRsCount = count($getOrderRs);
	
	//increment current component order
	$orderIncrement=false;
	for($x=0; $x<$getOrderRsCount; $x++)
	{
		if($getOrderRs[$x][0]==$_POST['editItemOrder'])
		{
			$orderIncrement=true;
		}//eof if
		
		if($orderIncrement)
		{
			$orderUpdate = "update FLC_PAGE_COMPONENT_ITEMS
							set ITEMORDER=".(int)++$getOrderRs[$x][0]."
							where ITEMID='".$getOrderRs[$x][1]."' and COMPONENTID='".$getOrderRs[$x][2]."'";
			$orderUpdateRs = $myQuery->query($orderUpdate,'RUN');
		}//eof if
	}//eof for
	
	//update versioning
	//xml_version_update($menuid);
}

//if duplicate component items
if($_POST['duplicateReference'])
{
	//get list of FLC_PAGE_COMPONENT_ITEMS columns
	$getItemColumnRs = $mySQL->listTableColumn(DB_DATABASE,DB_USERNAME,'FLC_PAGE_COMPONENT_ITEMS','ITEMID,ITEMNAME');
	$getItemColumnCount = count($getItemColumnRs);
	
	//clear the array
	$theItemColumn = array();
	$theItemValue = array();
	
	//generate insert query
	for($b=0; $b < $getItemColumnCount; $b++)
	{	
		$theItemColumn[] = $getItemColumnRs[$b]['COLUMN_NAME'];		//the column name
		
		//if the value is null, do not use quote
		if($getComponentItemListRs[$y][$getItemColumnRs[$b]['COLUMN_NAME']] == 'null')
			$theItemValue[] = $getComponentItemListRs[$y][$getItemColumnRs[$b]['COLUMN_NAME']];
		else
			$theItemValue[] = "'".$getComponentItemListRs[$y][$getItemColumnRs[$b]['COLUMN_NAME']]."'";
	}
	
	//get max item id
	$maxID = "select max(ITEMID) from FLC_PAGE_COMPONENT_ITEMS";
	$maxIDRs = $myQuery->query($maxID,'COUNT') + 1;
	
	$duplicateItem = "insert into FLC_PAGE_COMPONENT_ITEMS (ITEMID,ITEMNAME,".implode(',',$theItemColumn)." ) 
						select ".$maxIDRs.", ".$mySQL->concat("'Duplicate of '","ITEMNAME").", ".implode(',',$theItemColumn)." 
						from FLC_PAGE_COMPONENT_ITEMS 
						where ITEMID = ".$_POST['hiddenItemID'];
	$duplicateItemRs = $myQuery->query($duplicateItem,'RUN');
	
	//update versioning
	//xml_version_update($menuid);
}//eof if

//if component item deleted
if($_POST["deleteReference"])
{
	$deleteComponentItem = "delete from FLC_PAGE_COMPONENT_ITEMS 
							where ITEMID = ".$_POST["hiddenItemID"];
	$deleteComponentItemRs = $myQuery->query($deleteComponentItem,'RUN');
	
	//update versioning
	//xml_version_update($menuid);
}

//if order - move up clicked
if($_POST["moveUpItem"])
{	
	//check current ORDER position
	$checkPos = "select ITEMORDER from FLC_PAGE_COMPONENT_ITEMS where ITEMID = ".$_POST['hiddenItemID'];
	$checkPosRs = $myQuery->query($checkPos,'SELECT','NAME');

	//if current position is NOT 1, move up
	if($checkPosRs[0]['ITEMORDER'] != 1)
	{
		$updatePos = "update FLC_PAGE_COMPONENT_ITEMS set ITEMORDER = ".($checkPosRs[0]['ITEMORDER'] - 1)." 
						where ITEMID = ".$_POST['hiddenItemID'];
		$updatePosFlag = $myQuery->query($updatePos,'RUN');
	}
}

//if order - move down clicked
if($_POST["moveDownItem"])
{
	//check current ORDER position
	$checkPos = "select ITEMORDER from FLC_PAGE_COMPONENT_ITEMS where ITEMID = ".$_POST['hiddenItemID'];
	$checkPosRs = $myQuery->query($checkPos,'SELECT','NAME');

	//update position
	$updatePos = "update FLC_PAGE_COMPONENT_ITEMS set ITEMORDER = ".($checkPosRs[0]['ITEMORDER'] + 1)." 
					where ITEMID = ".$_POST['hiddenItemID'];
	$updatePosFlag = $myQuery->query($updatePos,'RUN');
}

//if reset ordering button clicked
if($_POST["resetOrderingItem"])
{
	$getOrder = "select a.COMPONENTID, b.ITEMID, b.ITEMORDER
					from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
					where a.COMPONENTID = b.COMPONENTID and a.PAGEID = '".$_POST["code"]."'
					order by a.COMPONENTORDER, b.ITEMORDER";
	//print_r($getOrder);
	
	$getOrderRs = $myQuery->query($getOrder,'SELECT');
	$countComponentItem = count($getOrderRs);		//count result rows
	
	$compTemp=$getOrderRs[0][0];	//temporary component id
	for($x=0,$y=1; $x < $countComponentItem; $x++,$y++)
	{	
		if($getOrderRs[$x][0]!=$compTemp)	//new component id
		{
			$y=1;	//initiate order
			$compTemp=$getOrderRs[$x][0];	//new temporary component id
		}
			
		//update item by component
		$updateOrder = "update FLC_PAGE_COMPONENT_ITEMS set ITEMORDER = ".($y)." 
								where COMPONENTID = ".$getOrderRs[$x][0]." and ITEMID=".$getOrderRs[$x][1];
		$updateOrderComponentFlag = $myQuery->query($updateOrder,'RUN');
	}	
}

//============================== // COMPONENT ITEMS ====================================

//if showScreen and code not null, show component and component items
if(($_POST["showScreen"] && $_POST["code"] != "") || ($_POST["saveScreenEdit"] || $_POST["saveScreenRefNew"] 
	|| $_POST["saveScreenRefEdit"] || $_POST["deleteComponent"] || $_POST["saveScreenItemNew"] 
	|| $_POST["saveScreenItemEdit"] || $_POST["deleteReference"] 
	|| $_POST['resetOrderingComponent'] || $_POST['moveUpComponent'] || $_POST['moveDownComponent']
	|| $_POST['resetOrderingItem'] || $_POST['moveUpItem'] || $_POST['moveDownItem']))
{
	//get component
	$reference = "select * from FLC_PAGE_COMPONENT 
					where PAGEID = ".$_POST["code"]. " 
					order by COMPONENTORDER";
	$referenceRs = $myQuery->query($reference,'SELECT','NAME');

	//get component items
	$reference_2 = "select a.COMPONENTNAME, b.* 
					from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
					where a.COMPONENTID = b.COMPONENTID 
					and a.PAGEID = ".$_POST["code"]. " 
					order by a.COMPONENTORDER, b.ITEMORDER";
	$reference_2Rs = $myQuery->query($reference_2,'SELECT','NAME');
}

//get list of page menu
$generalRs = $mySQL->menu($_POST['pageSearch']);		//function page (func_sql.php)

//get list of menus to link pages to 
$menu = "select (b.MENUNAME || ' / ' || a.MENUNAME) as MENUNAME, a.MENUID
			from FLC_MENU a, FLC_MENU b, FLC_PAGE c 
			where a.MENUPARENT = b.MENUID 
			and a.MENUID = c.MENUID  
			and a.MENUPARENT != 0 
			order by b.MENUNAME, a.MENUNAME";
$menuRs = $myQuery->query($menu,'SELECT','NAME');

//----------------------queries-----------------------
if($_POST["code"])
{
	//get component list
	$getComponent = "select * from FLC_PAGE_COMPONENT where PAGEID = ".$_POST["code"];
	$getComponentRs = $myQuery->query($getComponent,'SELECT','NAME');
	
	//get latest order for component items
	$getLatestOrder = "select max(ITEMORDER) +1 as MAXORDER, componentID from FLC_PAGE_COMPONENT_ITEMS  
							where COMPONENTID in (select COMPONENTID from FLC_PAGE_COMPONENT where PAGEID = ".$_POST["code"].") 
							group by COMPONENTID 
							order by COMPONENTID";
	$getLatestOrderRs = $myQuery->query($getLatestOrder,'SELECT','NAME');
}

//if modify page
if($_POST['modifyCategory'])
	$selectedPageId=$_POST['code'];

//get list of page menu
$getMenuRs = $mySQL->menuExcludePage($selectedPageId);		//function page (func_sql.php)

//get page pre post process
$pageProcess = "select REFERENCECODE,DESCRIPTION1 from REFSYSTEM 
					where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'PAGE_PRE_POST_PROCESS') 
					order by DESCRIPTION1";
$pageProcessRs = $myQuery->query($pageProcess,'SELECT','NAME');

// javascript event
$event = "select REFERENCECODE,DESCRIPTION1 from REFSYSTEM 
				where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' and DESCRIPTION1 = 'PAGE_CTRL_ACTION_JS_BUTTON') 
				order by DESCRIPTION1";
$eventRs = $myQuery->query($event,'SELECT','NAME');
?>
<script language="javascript">
function codeDropDown(elem)
{	
	if(elem.selectedIndex != 0) 
	{ 
		document.form1.showScreen.disabled = false; 
		document.form1.modifyCategory.disabled = false; 
		document.form1.deleteCategory.disabled = false;
		document.form1.duplicateCategory.disabled = false;
	} 
	else 
	{	
		document.form1.showScreen.disabled = true; 
		document.form1.modifyCategory.disabled = true; 
		document.form1.deleteCategory.disabled = true;
		document.form1.duplicateCategory.disabled = true;
	}
}
</script>
<script language="javascript" src="js/editor.js"></script>
<link href="../ims.css" rel="stylesheet" type="text/css" />
<link href="spkb_css.css" rel="stylesheet" type="text/css" />
<div id="breadcrumbs">Modul Pentadbir Sistem  / Page Editor /
  <?php if($_POST["editScreen"]) echo " Edit /"?>
</div>
<h1>Page Editor </h1>
<?php //if update successful
  if($insertCatRs||$insertPageRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>New page has been added.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($deletePageRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Page telah dibuang.</td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($updateCatRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Page telah dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if insert reference successful
  if($newComponentRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component baru telah ditambah. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if duplicate component successful
  if($duplicateComponentRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component telah berjaya disalin. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($deleteRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component telah dibuang. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($updateRefRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component telah dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($updateOrderComponentFlag) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Susunan component telah berjaya di'reset'. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if insert reference successful
  if($newItemRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component item baru telah ditambah. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if delete successful
  if($deleteComponentItemRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component item telah dibuang. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($duplicateItemRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component item telah berjaya disalin. </td>
  </tr>
</table>
<br />
<?php } ?>
<?php //if update successful
  if($updateComponentItemRs) { ?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Component item telah dikemaskini. </td>
  </tr>
</table>
<br />
<?php } ?>
<form action="" method="post" name="form1">
  <?php if($showScreen_2)  { ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Page List </th>
    </tr>
	<tr>
      <td nowrap="nowrap" class="inputLabel">Page Search : </td>
      <td><input name="pageSearch" type="text" id="pageSearch" size="50" class="inputInput" value="<?php echo $_POST['pageSearch']?>" onkeyup="ajaxUpdatePageSelector('page','pageSelectorDropdown',this.value)" /></td>
    </tr>
    <tr>
      <td width="74" nowrap="nowrap" class="inputLabel">Page : </td>
      <td width="662"><div id="pageSelectorDropdown">
          <select name="code" class="inputList" id="code" onChange="codeDropDown(this); ">
            <option value="">&lt; Pilih Page &gt;</option>
            <?php for($x=0; $x < count($generalRs); $x++) { ?>
            <option value="<?php echo $generalRs[$x]["PAGEID"]?>" <?php if($_POST["code"] == $generalRs[$x]["PAGEID"]) echo "selected";?>><?php echo $generalRs[$x]["MENUNAME"]?></option>
            <?php } ?>
          </select>
          <input name="showScreen" type="submit" class="inputButton" id="showScreen" value="Tunjuk Senarai" <?php if(!$_POST["code"]) { ?>disabled="disabled" <?php } ?> />
        </div></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="duplicateCategory" type="submit" class="inputButton" id="duplicateCategory" value="Duplicate Page" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> />
          <input name="newCategory" type="submit" class="inputButton" value="Baru" />
		  <input name="modifyCategory" type="submit" class="inputButton" id="modifyCategory" value="Ubah" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> />
          <input name="deleteCategory" type="submit" class="inputButton" value="Buang" <?php if($_POST["code"] == "" || isset($_POST["deleteCategory"])) { ?>disabled="disabled" <?php } ?> onClick="if(window.confirm('Are you sure you want to DELETE this page?\nThis will also delete ALL settings under this page')) {return true} else {return false}" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($showScreen_4)  { ?>
  <br>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2"><?php if($_POST['duplicateCategory']) echo 'Duplicate'; else echo 'New'?>
        Page </th>
    </tr>
	<tr>
      <td class="inputLabel">Menu Search : </td>
      <td><input name="menuSearch" type="text" id="menuSearch" size="50" class="inputInput" value="<?php echo $_POST['menuSearch']?>" onkeyup="ajaxUpdatePageSelector('menu','menuSelectorDropdown',this.value)" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Link to Menu : </td>
      <td>
	  <div id="menuSelectorDropdown">
	  <select name="newMenuID" class="inputList" id="newMenuID" onchange="document.getElementById('newPageBreadcrumbs').value=this.options[this.selectedIndex].innerHTML">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($getMenuRs); $x++) { ?>
          <option value="<?php echo $getMenuRs[$x]["MENUID"]?>"><?php echo $getMenuRs[$x]["MENUNAME"]?></option>
          <?php } ?>
      </select>
	  </div></td>
    </tr>
	<tr>
      <td width="74" nowrap class="inputLabel">Page Name : </td>
      <td width="662"><input name="newPageName" type="text" class="inputInput" id="newPageName" size="50" onkeyup="if(this.value){form1.saveScreenNew.disabled = false}"></td>
    </tr>
    <tr>
      <td class="inputLabel">Breadcrumbs : </td>
      <td><input name="newPageBreadcrumbs" type="text" class="inputInput" id="newPageBreadcrumbs" size="100"></td>
    </tr>
    <?php if($_POST['newCategory']) { ?>
    <tr>
      <td class="inputLabel">Page Notes : </td>
      <td><textarea name="newPageNotes" cols="50" rows="3" class="inputInput" id="newPageNotes" ></textarea></td>
    </tr>
    <?php }//end post new category ?>
    <?php if($_POST['duplicateCategory']) {?>
    <tr>
      <td class="inputLabel">Duplicate Page From :</td>
      <td><select name="duplicatePageFrom" class="inputList" id="duplicatePageFrom" onchange="codeDropDown(this); ">
          <?php for($x=0; $x < count($generalRs); $x++) { ?>
          <option value="<?php echo $generalRs[$x]["PAGEID"]?>" <?php if($_POST["code"] == $generalRs[$x]["PAGEID"]) echo "selected";?> ><?php echo $generalRs[$x]["MENUNAME"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <?php }//end post duplicate category ?>
    <tr>
      <td class="inputLabel">Allow Post-Back  :</td>
      <td><input name="newPageMemory" type="checkbox" id="newPageMemory" value="1" />
      Yes<br />
      Note: Limited to 1 page in memory at a time.</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenNew" type="submit" class="inputButton" value="Simpan" disabled="disabled" />
          <input name="cancelScreenNew" type="submit" class="inputButton" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($showScreen_5)  { ?>
  <br>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Modify Page </th>
    </tr>
	<tr>
      <td class="inputLabel">Menu Search : </td>
      <td><input name="menuSearch" type="text" id="menuSearch" size="50" class="inputInput" value="<?php echo $_POST['menuSearch']?>" onkeyup="ajaxUpdatePageSelector('menu','menuSelectorDropdown',this.value,'<?php echo $_POST['code'];?>')" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Link to Menu : </td>
      <td>
	  <div id="menuSelectorDropdown">
	  <select name="editMenuID" class="inputList" id="editMenuID" onchange="document.getElementById('editPageBreadcrumbs').value=this.options[this.selectedIndex].innerHTML">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($getMenuRs); $x++) { ?>
          <option value="<?php echo $getMenuRs[$x]["MENUID"]?>" <?php if($getPageInfoRs[0]["MENUID"] == $getMenuRs[$x]["MENUID"]) echo "selected";?>><?php echo $getMenuRs[$x]["MENUNAME"]?></option>
          <?php } ?>
      </select>
	  </div></td>
    </tr>
	<tr>
      <td width="74" nowrap="nowrap" class="inputLabel">Page Name : </td>
      <td width="662"><input name="editPageName" type="text" class="inputInput" id="editPageName" size="50" value="<?php echo $getPageInfoRs[0]["PAGENAME"]?>" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Breadcrumbs : </td>
      <td><input name="editPageBreadcrumbs" type="text" class="inputInput" id="editPageBreadcrumbs" value="<?php echo $getPageInfoRs[0]["PAGEBREADCRUMBS"]?>" size="100" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Page Notes : </td>
      <td><textarea name="editPageNotes" cols="50" rows="3" class="inputInput" id="editPageNotes" ><?php echo $getPageInfoRs[0]["PAGENOTES"]?></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Allow Post-Back :</td>
      <td><input name="editPageMemory" type="checkbox" id="editPageMemory" value="1" <?php if($getPageInfoRs[0]["PAGEMEMORY"]){?> checked="checked"<?php }?> />
        Yes <br />
        Note: Limited to 1 page in memory at a time.</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenEdit" type="submit" class="inputButton" id="saveScreenEdit" value="Simpan" />
          <input name="cancelScreenEdit" type="submit" class="inputButton" id="cancelScreenEdit" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($showScreen_6)  { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">New Component </th>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Name : </td>
      <td><input name="newComponentName" type="text" class="inputInput" id="newComponentName" onkeyup="form1.saveScreenRefNew.disabled = false" size="50" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td><select name="newComponentType" id="newComponentType" class="inputList" onchange="
	  if(this.selectedIndex == 1)
	  {
			document.getElementById('newTabularDefaultRowNo').disabled = true;
			document.getElementById('newAddRow').disabled = true;
			document.getElementById('newDeleteRow').disabled = true;
			document.getElementById('newTypeQuery').disabled = true;
			document.getElementById('newQueryLimit').disabled = true;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	 else if(this.selectedIndex == 2)
	  {
			document.getElementById('newTabularDefaultRowNo').disabled = true;
			document.getElementById('newAddRow').disabled = true;
			document.getElementById('newDeleteRow').disabled = true;
			document.getElementById('newTypeQuery').disabled = true;
			document.getElementById('newQueryLimit').disabled = true;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	  else if(this.selectedIndex == 3) 
	  {
			document.getElementById('newTabularDefaultRowNo').disabled = false;
			document.getElementById('newAddRow').disabled = false;
			document.getElementById('newDeleteRow').disabled = false;
		  	document.getElementById('newTypeQuery').disabled = true;
			document.getElementById('newQueryLimit').disabled = true;
			swapItemDisplay('addRow|addJavascript|deleteJavascript', '');
			
			if(document.getElementById('newAddRow').value=='0') swapItemDisplay('', 'addJavascript|deleteJavascript');
	  }
	  else if(this.selectedIndex == 4)
	  {
			document.getElementById('newTabularDefaultRowNo').disabled = true;
			document.getElementById('newAddRow').disabled = true;
			document.getElementById('newDeleteRow').disabled = true;
	  	  	document.getElementById('newTypeQuery').disabled = false;
			document.getElementById('newQueryLimit').disabled = false;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	  	  else if(this.selectedIndex == 5)
	  {
			document.getElementById('newTabularDefaultRowNo').disabled = false;
			document.getElementById('newAddRow').disabled = false;
			document.getElementById('newDeleteRow').disabled = false;
	  	  	document.getElementById('newTypeQuery').disabled = false;
			document.getElementById('newQueryLimit').disabled = false;
			swapItemDisplay('addRow|addJavascript|deleteJavascript', '');
	  }
	  else if(this.selectedIndex == 7)
	  {
			document.getElementById('newTabularDefaultRowNo').disabled = true;
			document.getElementById('newAddRow').disabled = true;
			document.getElementById('newDeleteRow').disabled = true;
	  	  	document.getElementById('newTypeQuery').disabled = false;
			document.getElementById('newQueryLimit').disabled = false;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	  else if(this.selectedIndex == 8)
	  {
			document.getElementById('newTabularDefaultRowNo').disabled = true;
			document.getElementById('newAddRow').disabled = true;
			document.getElementById('newDeleteRow').disabled = true;
	  	  	document.getElementById('newTypeQuery').disabled = false;
			document.getElementById('newQueryLimit').disabled = false;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	 ">
          <option value="custom">Custom</option>
		  <option value="form_1_col" selected>Form 1 Column</option>
          <option value="form_2_col">Form 2 Column</option>
          <option value="tabular">Tabular</option>
          <option value="query">Query</option>
          <option value="report">Report</option>
          <option value="flatfile_view">Flatfile Viewer</option>
          <option value="query_2_col">Query 2 Column</option>
          <option value="search_constraint">Search Constraint</option>
		  <option value="webservice">Webservice</option>
		  <option value="loading">Loading</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td width="662"><label>
        <input name="orderOption" type="radio" checked="checked" onclick="swapItemDisplay('newComponentOrderText', 'newComponentOrderCombo')" />
        At</label>
        <label>
        <input name="orderOption" type="radio" onclick="swapItemDisplay('newComponentOrderCombo', 'newComponentOrderText'); showComponent('<?php echo $_POST['code'];?>')" />
        Before</label>
        <label>
        <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('newComponentOrderCombo', 'newComponentOrderText'); showComponent('<?php echo $_POST['code'];?>')" />
        After</label>
        <br />
        <input name="newComponentOrder" type="text" class="inputInput" id="newComponentOrderText" size="5"  value="<?php echo $getOrderRs;?>" />
        <span id="hideEditorList"></span></td>
    </tr>
    <tr>
      <td class="inputLabel">Status : </td>
      <td><select name="newComponentStatus" id="newComponentStatus" class="inputList" >
          <option value="1" selected="selected">Enabled</option>
          <option value="0">Disabled</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Path : </td>
      <td><input name="newComponentPath" type="text" class="inputInput" id="newComponentPath" onkeyup="form1.saveScreenRefNew.disabled = false" size="50" /> 
      * for custom component only </td>
    </tr>
    <tr>
      <td class="subHead">DATA BINDING </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td><select name="newDataBindingType" id="newDataBindingType" class="inputList" onchange="
	  switch(document.getElementById('newDataBindingType').value)
	  {
		  case 'table'				: swapItemDisplay('newDataSourceTable','newDataSourceNone|newDataSourceView|newDataSourceProcedure|newDataSourceBL|newDataSourceWebservice|newDataSourceCalendar|newDataSourceLoading')
			break;
		  
		  case 'view'				: swapItemDisplay('newDataSourceView','newDataSourceNone|newDataSourceTable|newDataSourceProcedure|newDataSourceBL|newDataSourceWebservice|newDataSourceCalendar|newDataSourceLoading')
			break;
		 
		  case 'query'				: swapItemDisplay('','newDataSourceNone|newDataSourceView|newDataSourceTable|newDataSourceProcedure|newDataSourceBL|newDataSourceWebservice|newDataSourceCalendar|newDataSourceLoading')
			break;
		  
		  case 'stored_procedure'	: swapItemDisplay('newDataSourceProcedure','newDataSourceNone|newDataSourceView|newDataSourceTable|newDataSourceBL|newDataSourceWebservice|newDataSourceCalendar|newDataSourceLoading')
			break;
		
		  case 'bl'					: swapItemDisplay('newDataSourceBL','newDataSourceNone|newDataSourceView|newDataSourceTable|newDataSourceProcedure|newDataSourceWebservice|newDataSourceCalendar|newDataSourceLoading')
			break;
		  
		  case 'webservice'			: swapItemDisplay('newDataSourceWebservice','newDataSourceNone|newDataSourceView|newDataSourceTable|newDataSourceProcedure|newDataSourceBL|newDataSourceCalendar|newDataSourceLoading')
			break;

		  case 'calendar'			: swapItemDisplay('newDataSourceCalendar','newDataSourceNone|newDataSourceView|newDataSourceTable|newDataSourceProcedure|newDataSourceBL|newDataSourceWebservice|newDataSourceLoading')
			break;
		  
		  case 'loading'			: swapItemDisplay('newDataSourceLoading','newDataSourceNone|newDataSourceView|newDataSourceTable|newDataSourceProcedure|newDataSourceBL|newDataSourceWebservice|newDataSourceCalendar')
			break;
		  
		  default					: swapItemDisplay('newDataSourceNone','newDataSourceView|newDataSourceTable|newDataSourceProcedure|newDataSourceBL|newDataSourceWebservice|newDataSourceCalendar|newDataSourceLoading')
		  	break;
	  }
	  ;showDatabaseColumn('&nbsp;')">
          <option>&nbsp;</option>
          <option value="table">Table</option>
          <option value="view">View</option>
          <option value="query">Query</option>
          <option value="stored_procedure">Stored Procedure</option>
		  <option value="bl">Business Logic</option>
		  <option value="webservice">Webservice</option>
		  <option value="calendar">Calendar</option>
		  <option value="loading">Loading</option>
        </select>        </td>
    </tr>
    <tr>
      <td class="inputLabel">Source : </td>
      <td><select name="newDataSource" id="newDataSourceNone" class="inputList" >
          <option>&nbsp;</option>
        </select>
        <select name="newDataSource" id="newDataSourceTable" class="inputList" style="display:none" onchange="showDatabaseColumn(document.getElementById('newDataSourceTable').value)">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getTableRs); $x++) { ?>
          <option value="<?php echo $getTableRs[$x]['TABLE_NAME']?>"><?php echo $getTableRs[$x]['TABLE_NAME']?></option>
          <?php } ?>
        </select>
        <select name="newDataSource" id="newDataSourceView" class="inputList"  style="display:none">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getViewRs); $x++) { ?>
          <option value="<?php echo $getViewRs[$x]['VIEW_NAME']?>"><?php echo $getViewRs[$x]['VIEW_NAME']?></option>
          <?php } ?>
        </select>
        <select name="newDataSource" id="newDataSourceProcedure" class="inputList"  style="display:none">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getProcedureRs); $x++) { ?>
          <option value="<?php echo $getProcedureRs[$x]['PROCEDURE_NAME']?>"><?php echo $getProcedureRs[$x]['PROCEDURE_NAME']?></option>
          <?php } ?>
        </select>
		<select name="newDataSource" id="newDataSourceBL" class="inputList"  style="display:none">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getBLRs); $x++) { ?>
          <option value="<?php echo $getBLRs[$x][0]?>"><?php echo $getBLRs[$x][1]?></option>
          <?php } ?>
        </select>
		<select name="newDataSource" id="newDataSourceWebservice" class="inputList"  style="display:none">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getWebserviceRs); $x++) { ?>
          <option value="<?php echo $getWebserviceRs[$x]['WSVC_ID']?>"><?php echo $getWebserviceRs[$x]['WSVC_NAME']?></option>
          <?php } ?>
        </select>
		<select name="newDataSource" id="newDataSourceCalendar" class="inputList"  style="display:none">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getCalendarRs); $x++) { ?>
          <option value="<?php echo $getCalendarRs[$x]['CALENDAR_ID']?>"><?php echo $getCalendarRs[$x]['CALENDAR_NAME']?></option>
          <?php } ?>
        </select>
		<select name="newDataSource" id="newDataSourceLoading" class="inputList"  style="display:none">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getLoadingRs); $x++) { ?>
          <option value="<?php echo $getLoadingRs[$x][0]?>"><?php echo $getLoadingRs[$x][1]?></option>
          <?php } ?>
        </select>      </td>
    </tr>
    <tr>
      <td class="subHead">COMPONENT PRE/POST PROCESS </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Component Pre-process : </td>
      <td><select name="newComponentPreProcess" class="inputList" id="newComponentPreProcess" onchange="if(this.selectedIndex > 0) document.getElementById('newComponentPreScript').disabled = false; else document.getElementById('newComponentPreScript').disabled = true;" >
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($pageProcessRs); $x++) { ?>
          <option value="<?php echo $pageProcessRs[$x]["REFERENCECODE"]?>"><?php echo $pageProcessRs[$x]["DESCRIPTION1"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Component Post-process : </td>
      <td><select name="newComponentPostProcess" class="inputList" id="newComponentPostProcess" onchange="if(this.selectedIndex > 0) document.getElementById('newComponentPostScript').disabled = false; else document.getElementById('newComponentPostScript').disabled = true;">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($pageProcessRs); $x++) { ?>
          <option value="<?php echo $pageProcessRs[$x]["REFERENCECODE"]?>"><?php echo $pageProcessRs[$x]["DESCRIPTION1"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Pre-Process Notification : </td>
      <td><textarea name="newComponentPreScript" cols="85" rows="3" class="inputInput" id="newComponentPreScript" ></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Post-Process Notification : </td>
      <td><textarea name="newComponentPostScript" cols="85" rows="3" class="inputInput" id="newComponentPostScript" ></textarea></td>
    </tr>
  </table>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2" >Component Type Details </th>
    </tr>
    <tr>
      <td class="subHead">TABULAR ONLY </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Number of Rows:</td>
      <td><input name="newTabularDefaultRowNo" type="text" disabled="disabled" class="inputInput" id="newTabularDefaultRowNo" value="" size="2" maxlength="3" /></td>
    </tr>
	<tbody id="addRow" style="display:none">
	<tr>
      <td class="inputLabel">Add Row  : </td>
      <td><select name="newAddRow" class="inputList" id="newAddRow" disabled="disabled" onchange="if(this.value=='1') swapItemDisplay('addJavascript', '');else swapItemDisplay('', 'addJavascript');" >
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select></td>
    </tr>
	<tr>
      <td class="inputLabel">Delete Row  : </td>
      <td><select name="newDeleteRow" class="inputList" id="newDeleteRow" disabled="disabled" onchange="if(this.value=='1') swapItemDisplay('deleteJavascript', '');else swapItemDisplay('', 'deleteJavascript');" >
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select></td>
    </tr>
	</tbody>
    <tbody id="addJavascript" style="display:none">
	<tr>
      <td class="inputLabel">Add Row Disabled  : </td>
	  <td>
	  	<select name="newAddRowDisabled" class="inputList" id="newAddRowDisabled" >
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select>      </td>
    </tr>
	<tr>
      <td class="inputLabel">Add Row Javascript  : </td>
	  <td><textarea name="newAddJavascript" cols="100" rows="5" class="inputInput" id="newAddJavascript" ><?php echo convertToDBQry($getEditComponentRs[0]["COMPONENTADDROWJAVASCRIPT"]);?></textarea>      </td>
    </tr>
	</tbody>
	<tbody id="deleteJavascript" style="display:none">
	<tr>
      <td class="inputLabel">Delete Row Disabled  : </td>
	  <td>
	  	<select name="newDeleteRowDisabled" class="inputList" id="newDeleteRowDisabled" >
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select>      </td>
    </tr>
	<tr>
      <td class="inputLabel">Delete Row Javascript  : </td>
	  <td><textarea name="newDeleteJavascript" cols="100" rows="5" class="inputInput" id="newDeleteJavascript" ><?php echo convertToDBQry($getEditComponentRs[0]["COMPONENTDELETEROWJAVASCRIPT"]);?></textarea>      </td>
    </tr>
	</tbody>
    <tr>
      <td class="subHead">QUERY ONLY </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Query : </td>
      <td><textarea name="newTypeQuery" cols="100" rows="10" class="inputInput" id="newTypeQuery" disabled="disabled" ></textarea>
        <br />
        <label><input name="newQueryLimit" type="checkbox" id="newQueryLimit" value="1" disabled="disabled" />Unlimited</label></td>
    </tr>
    <tr>
      <td class="subHead">MASTER DETAIL ONLY </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Master Component : </td>
      <td><select name="newMasterID" class="inputList" id="newMasterID" >
          <option value="0">&nbsp;</option>
          <?php for($x=0; $x < count($getComponentRs); $x++) { ?>
          <option value="<?php echo $getComponentRs[$x]["COMPONENTID"]?>"><?php echo $getComponentRs[$x]["COMPONENTNAME"]?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="subHead">FLATFILE VIEWER </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Upload Column : </td>
      <td>
        <select name="newUploadColumn" class="inputList" id="newUploadColumn">
        </select>
        (for flatfile viewer only) </td>
    </tr>
    <tr>
      <td class="inputLabel">Fixed Length : </td>
      <td><input name="newItemFlatfileFixedLength" type="text" class="inputInput" id="newItemFlatfileFixedLength" size="50" />
        Eg: 20,10,45 (list of fixed lengths) </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
        <input name="saveScreenRefNew" type="submit" disabled="disabled" class="inputButton" id="saveScreenRefNew" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($showScreen_7)  { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Modify Component </th>
    </tr>
    <tr>
      <td class="inputLabel">Name : </td>
      <td><input name="editComponentName" type="text" class="inputInput" id="editComponentName" value="<?php echo $getEditComponentRs[0]["COMPONENTNAME"] ?>" size="50" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td><select name="editComponentType" id="editComponentType" class="inputList" onchange="
	  if(this.selectedIndex == 1)
	  {
			document.getElementById('editTabularDefaultRowNo').disabled = true;
			document.getElementById('editAddRow').disabled = true;
			document.getElementById('editDeleteRow').disabled = true;
			document.getElementById('editTypeQuery').disabled = true;
			document.getElementById('editQueryLimit').disabled = true;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	 else if(this.selectedIndex == 2)
	  {
			document.getElementById('editTabularDefaultRowNo').disabled = true;
			document.getElementById('editAddRow').disabled = true;
			document.getElementById('editDeleteRow').disabled = true;
			document.getElementById('editTypeQuery').disabled = true;
			document.getElementById('editQueryLimit').disabled = true;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	  else if(this.selectedIndex == 3) 
	  {
			document.getElementById('editTabularDefaultRowNo').disabled = false;
			document.getElementById('editAddRow').disabled = false;
			document.getElementById('editDeleteRow').disabled = false;
		  	document.getElementById('editTypeQuery').disabled = true;
			document.getElementById('editQueryLimit').disabled = true;
			swapItemDisplay('addRow|addJavascript|deleteJavascript', '');
			
			<?php if(!$getEditComponentRs[0]["COMPONENTADDROW"]){?> swapItemDisplay('', 'addJavascript|deleteJavascript');<?php }?>
	  }
	  else if(this.selectedIndex == 4)
	  {
			document.getElementById('editTabularDefaultRowNo').disabled = true;
			document.getElementById('editAddRow').disabled = true;
			document.getElementById('editDeleteRow').disabled = true;
	  	  	document.getElementById('editTypeQuery').disabled = false;
			document.getElementById('editQueryLimit').disabled = false;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	  else if(this.selectedIndex == 5)
	  {
			document.getElementById('editTabularDefaultRowNo').disabled = false;
			document.getElementById('editAddRow').disabled = false;
			document.getElementById('editDeleteRow').disabled = false;
	  	  	document.getElementById('editTypeQuery').disabled = false;
			document.getElementById('editQueryLimit').disabled = false;
			swapItemDisplay('addRow|addJavascript|deleteJavascript', '');
	  }
	  else if(this.selectedIndex == 7)
	  {
			document.getElementById('editTabularDefaultRowNo').disabled = true;
			document.getElementById('editAddRow').disabled = true;
			document.getElementById('editDeleteRow').disabled = true;
	  	  	document.getElementById('editTypeQuery').disabled = false;
			document.getElementById('editQueryLimit').disabled = false;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	  else if(this.selectedIndex == 8)
	  {
			document.getElementById('editTabularDefaultRowNo').disabled = true;
			document.getElementById('editAddRow').disabled = true;
			document.getElementById('editDeleteRow').disabled = true;
	  	  	document.getElementById('editTypeQuery').disabled = false;
			document.getElementById('editQueryLimit').disabled = false;
			swapItemDisplay('', 'addRow|addJavascript|deleteJavascript');
	  }
	  
		 ">
          <option value="custom" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'custom') { ?>selected<?php }?>>Custom</option>
		  <option value="form_1_col" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'form_1_col') { ?>selected<?php }?>>Form 1 Column</option>
          <option value="form_2_col" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'form_2_col') { ?>selected<?php }?>>Form 2 Column</option>
          <option value="tabular" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'tabular') { ?>selected<?php }?>>Tabular</option>
          <option value="query" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'query') { ?>selected<?php }?>>Query</option>
          <option value="report" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'report') { ?>selected<?php }?>>Report</option>
          <option value="flatfile_view" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'flatfile_view') { ?>selected<?php }?>>Flatview Viewer</option>
          <option value="query_2_col" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'query_2_col') { ?>selected<?php }?>>Query 2 Column</option>
          <option value="search_constraint" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'search_constraint') { ?>selected<?php }?>>Search Constraint</option>
		  <option value="webservice" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'webservice') { ?>selected<?php }?>>Webservice</option>
		  <option value="loading" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'loading') { ?>selected<?php }?>>Loading</option>
        </select></td>
    </tr>
    <tr>
      <td width="74" class="inputLabel">Order :</td>
      <td width="662"><label>
        <input name="orderOption" type="radio" checked="checked" onclick="swapItemDisplay('editComponentOrderText', 'editComponentOrderCombo')" />
        At</label>
        <label>
        <input name="orderOption" type="radio" onclick="swapItemDisplay('editComponentOrderCombo', 'editComponentOrderText'); showComponent('<?php echo $_POST['code'];?>', '<?php echo $_POST['hiddenComponentID'];?>')" />
        Before</label>
        <label>
        <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('editComponentOrderCombo', 'editComponentOrderText'); showComponent('<?php echo $_POST['code'];?>', '<?php echo $_POST['hiddenComponentID'];?>')" />
        After</label>
        <br />
        <input name="editComponentOrder" type="text" class="inputInput" id="editComponentOrderText" size="5" value="<?php echo $getEditComponentRs[0]["COMPONENTORDER"] ?>" />
        <!--<select name="editComponentOrder" id="editComponentCombo" class="inputList" disabled="disabled" style="display:none;">
          <option value="0">None</option>
          <?php for($x=0; $x < $getComponentNameRsCount; $x++) { ?>
          <option value="<?php echo $getComponentNameRs[$x][0];?>" ><?php echo $getComponentNameRs[$x][1];?></option>
          <?php } ?>
        </select>-->
        <span id="hideEditorList"> </span> </td>
    </tr>
    <tr>
      <td class="inputLabel">Status : </td>
      <td><select name="editComponentStatus" id="editComponentStatus" class="inputList">
          <option value="1" <?php if($getEditComponentRs[0]["COMPONENTSTATUS"] == 1) { ?> selected<?php }?> >Enabled</option>
          <option value="0" <?php if($getEditComponentRs[0]["COMPONENTSTATUS"] == 0) { ?> selected<?php }?>>Disabled</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Path : </td>
      <td><input name="editComponentPath" type="text" class="inputInput" id="editComponentPath" onkeyup="form1.saveScreenRefNew.disabled = false" value="<?php echo $getEditComponentRs[0]["COMPONENTPATH"] ?>" size="50" />
        * for custom component only </td>
    </tr>
    <tr>
      <td class="subHead">DATA BINDING </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td><select name="editDataBindingType" id="editDataBindingType" class="inputList" onchange="
	  switch(document.getElementById('editDataBindingType').value)
	  {
		  case 'table'				: swapItemDisplay('editDataSourceTable','editDataSourceNone|editDataSourceView|editDataSourceProcedure|editDataSourceBL|editDataSourceWebservice|editDataSourceCalendar|editDataSourceLoading')
			break;
		  
		  case 'view'				: swapItemDisplay('editDataSourceView','editDataSourceNone|editDataSourceTable|editDataSourceProcedure|editDataSourceBL|editDataSourceWebservice|editDataSourceCalendar|editDataSourceLoading')
			break;
		 
		  case 'query'				: swapItemDisplay('','editDataSourceNone|editDataSourceView|editDataSourceTable|editDataSourceProcedure|editDataSourceBL|editDataSourceWebservice|editDataSourceCalendar|editDataSourceLoading')
			break;
		  
		  case 'stored_procedure'	: swapItemDisplay('editDataSourceProcedure','editDataSourceNone|editDataSourceView|editDataSourceTable|editDataSourceBL|editDataSourceWebservice|editDataSourceCalendar|editDataSourceLoading')
			break;
		
		  case 'bl'					: swapItemDisplay('editDataSourceBL','editDataSourceNone|editDataSourceView|editDataSourceTable|editDataSourceProcedure|editDataSourceWebservice|editDataSourceCalendar|editDataSourceLoading')
			break;
		  
		  case 'webservice'			: swapItemDisplay('editDataSourceWebservice','editDataSourceNone|editDataSourceView|editDataSourceTable|editDataSourceProcedure|editDataSourceBL|editDataSourceCalendar|editDataSourceLoading')
			break;
			
		  case 'calendar'			: swapItemDisplay('editDataSourceCalendar','editDataSourceNone|editDataSourceView|editDataSourceTable|editDataSourceProcedure|editDataSourceBL|editDataSourceWebservice|editDataSourceLoading')
			break;
			
		  case 'loading'			: swapItemDisplay('editDataSourceLoading','editDataSourceNone|editDataSourceView|editDataSourceTable|editDataSourceProcedure|editDataSourceBL|editDataSourceWebservice|editDataSourceCalendar')
			break;
		 
		  default					: swapItemDisplay('editDataSourceNone','editDataSourceView|editDataSourceTable|editDataSourceProcedure|editDataSourceBL|editDataSourceWebservice|editDataSourceCalendar|editDataSourceLoading')
		  	break;
	  };
	  showDatabaseColumn('&nbsp;')">
          <option>&nbsp;</option>
          <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'table') { ?>selected<?php }?> value="table">Table</option>
          <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'view') { ?>selected<?php }?> value="view">View</option>
          <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'query') { ?>selected<?php }?> value="query">Query</option>
          <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'stored_procedure') { ?>selected<?php }?> value="stored_procedure">Stored Procedure</option>
		  <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'bl') { ?>selected<?php }?> value="bl">Business Logic</option>
		  <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'webservice') { ?>selected<?php }?> value="webservice">Webservice</option>
		  <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'calendar') { ?>selected<?php }?> value="calendar">Calendar</option>
		  <option <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] == 'loading') { ?>selected<?php }?> value="loading">Loading</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Source : </td>
      <td><select name="editDataSource" id="editDataSourceNone" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != '') { ?> style="display:none" disabled="disabled"<?php }?>>
          <option>&nbsp;</option>
        </select>
        <select name="editDataSource" id="editDataSourceTable" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != 'table') { ?> style="display:none" disabled="disabled"<?php }?>  onchange="showDatabaseColumn(document.getElementById('editDataSourceTable').value,'<?php echo $getEditComponentRs[0]["COMPONENTUPLOADCOLUMN"]?>')">
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getTableRs); $x++) { ?>
          <option value="<?php echo $getTableRs[$x]['TABLE_NAME']?>" <?php if($getEditComponentRs[0]['COMPONENTBINDINGSOURCE'] == $getTableRs[$x]['TABLE_NAME']){ ?>selected<?php }?>><?php echo $getTableRs[$x]['TABLE_NAME']?></option>
          <?php } ?>
        </select>
        <select name="editDataSource" id="editDataSourceView" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != 'query') { ?> style="display:none" disabled="disabled"<?php }?>>
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getViewRs); $x++) { ?>
          <option value="<?php echo $getViewRs[$x]['VIEW_NAME']?>" <?php if($getEditComponentRs[0]['COMPONENTBINDINGSOURCE'] == $getTableRs[$x]['VIEW_NAME']){ ?>selected<?php }?>><?php echo $getViewRs[$x]['VIEW_NAME']?></option>
          <?php } ?>
        </select>
        <select name="editDataSource" id="editDataSourceProcedure" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != 'stored_procedure') { ?> style="display:none" disabled="disabled"<?php }?>>
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getProcedureRs); $x++) { ?>
          <option value="<?php echo $getProcedureRs[$x]['PROCEDURE_NAME']?>" <?php if($getEditComponentRs[0]['COMPONENTBINDINGSOURCE'] == $getProcedureRs[$x]['PROCEDURE_NAME']){ ?>selected<?php }?>><?php echo $getProcedureRs[$x]['PROCEDURE_NAME']?></option>
          <?php } ?>
        </select>
		<select name="editDataSource" id="editDataSourceBL" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != 'bl') { ?> style="display:none" disabled="disabled"<?php }?>>
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getBLRs); $x++) { ?>
          <option value="<?php echo $getBLRs[$x][0]?>" <?php if($getEditComponentRs[0]['COMPONENTBINDINGSOURCE'] == $getBLRs[$x][0]){ ?>selected<?php }?>><?php echo $getBLRs[$x][1]?></option>
          <?php } ?>
        </select>
		<select name="editDataSource" id="editDataSourceWebservice" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != 'webservice') { ?> style="display:none" disabled="disabled"<?php }?>>
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getWebserviceRs); $x++) { ?>
          <option value="<?php echo $getWebserviceRs[$x]['WSVC_ID']?>" <?php if($getEditComponentRs[0]['COMPONENTBINDINGSOURCE'] == $getWebserviceRs[$x]['WSVC_ID']){ ?>selected<?php }?>><?php echo $getWebserviceRs[$x]['WSVC_NAME']?></option>
          <?php } ?>
        </select>
		<select name="editDataSource" id="editDataSourceCalendar" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != 'calendar') { ?> style="display:none" disabled="disabled"<?php }?>>
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getCalendarRs); $x++) { ?>
          <option value="<?php echo $getCalendarRs[$x]['CALENDAR_ID']?>" <?php if($getEditComponentRs[0]['COMPONENTBINDINGSOURCE'] == $getCalendarRs[$x]['CALENDAR_ID']){ ?>selected<?php }?>><?php echo $getCalendarRs[$x]['CALENDAR_NAME']?></option>
          <?php } ?>
        </select>
		<select name="editDataSource" id="editDataSourceLoading" class="inputList" <?php if($getEditComponentRs[0]['COMPONENTBINDINGTYPE'] != 'loading') { ?> style="display:none" disabled="disabled"<?php }?>>
          <option>&nbsp;</option>
          <?php for($x=0; $x < count($getLoadingRs); $x++) { ?>
          <option value="<?php echo $getLoadingRs[$x][0]?>" <?php if($getEditComponentRs[0]['COMPONENTBINDINGSOURCE'] == $getLoadingRs[$x][0]){ ?>selected<?php }?>><?php echo $getLoadingRs[$x][1]?></option>
          <?php } ?>
        </select>       </td>
    </tr>
    <tr>
      <td class="subHead">COMPONENT PRE/POST PROCESS </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Component Pre-process : </td>
      <td><select name="editComponentPreProcess" class="inputList" id="editComponentPreProcess" onchange="if(this.selectedIndex > 0) document.getElementById('editComponentPreScript').disabled = false; else document.getElementById('editComponentPreScript').disabled = true;" >
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($pageProcessRs); $x++) { ?>
          <option value="<?php echo $pageProcessRs[$x]["REFERENCECODE"]?>" <?php if($getEditComponentRs[0]["COMPONENTPREPROCESS"] == $pageProcessRs[$x]["REFERENCECODE"]) { ?> selected<?php }?>><?php echo $pageProcessRs[$x]["DESCRIPTION1"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Component Post-process : </td>
      <td><select name="editComponentPostProcess" class="inputList" id="editComponentPostProcess" onchange="if(this.selectedIndex &gt; 0) document.getElementById('editComponentPostScript').disabled = false; else document.getElementById('editComponentPostScript').disabled = true;">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($pageProcessRs); $x++) { ?>
          <option value="<?php echo $pageProcessRs[$x]["REFERENCECODE"]?>" <?php if($getEditComponentRs[0]["COMPONENTPOSTPROCESS"] == $pageProcessRs[$x]["REFERENCECODE"]) { ?> selected<?php }?>><?php echo $pageProcessRs[$x]["DESCRIPTION1"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Pre-Process Notification : </td>
      <td><textarea name="editComponentPreScript" cols="85" rows="3" class="inputInput" id="editComponentPreScript" ><?php echo $getEditComponentRs[0]["COMPONENTPRESCRIPT"]?></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Post-Process Notification : </td>
      <td><textarea name="editComponentPostScript" cols="85" rows="3" class="inputInput" id="editComponentPostScript" ><?php echo $getEditComponentRs[0]["COMPONENTPOSTSCRIPT"]?></textarea></td>
    </tr>
  </table>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2" >Component Type Details </th>
    </tr>
    <tr>
      <td class="subHead">TABULAR ONLY </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Number of Rows:</td>
      <td><input name="editTabularDefaultRowNo" type="text" class="inputInput" id="editTabularDefaultRowNo" value="<?php echo $getEditComponentRs[0]["COMPONENTABULARDEFAULTROWNO"] ?>" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'form_1_col' || $getEditComponentRs[0]["COMPONENTTYPE"] == 'form_2_col' || $getEditComponentRs[0]["COMPONENTTYPE"] == 'query') { ?>disabled<?php }?> size="2" maxlength="3" /></td>
    </tr>
	<tbody id="addRow" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] != 'tabular'&&$getEditComponentRs[0]["COMPONENTTYPE"] != 'report'){?> style="display:none" <?php }?>>
	<tr>
      <td class="inputLabel">Add Row  : </td>
      <td>
	  	<select name="editAddRow" class="inputList" id="editAddRow" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] != 'tabular'&&$getEditComponentRs[0]["COMPONENTTYPE"] != 'report') { ?>disabled<?php }?> 
			onchange="if(this.value=='1') swapItemDisplay('addJavascript', '');else swapItemDisplay('', 'addJavascript');">
          <option value="1" <?php if($getEditComponentRs[0]["COMPONENTADDROW"]=='1'){?>selected <?PHP }?>>Yes</option>
          <option value="0" <?php if($getEditComponentRs[0]["COMPONENTADDROW"]!='1'){?>selected <?PHP }?>>No</option>
        </select>	  </td>
    </tr>
	<tr>
      <td class="inputLabel">Delete Row  : </td>
      <td>
	  	<select name="editDeleteRow" class="inputList" id="editDeleteRow" <?php if($getEditComponentRs[0]["COMPONENTTYPE"] != 'tabular'&&$getEditComponentRs[0]["COMPONENTTYPE"] != 'report') { ?>disabled<?php }?> 
			onchange="if(this.value=='1') swapItemDisplay('deleteJavascript', '');else swapItemDisplay('', 'deleteJavascript');">
          <option value="1" <?php if($getEditComponentRs[0]["COMPONENTDELETEROW"]=='1'){?>selected <?PHP }?>>Yes</option>
          <option value="0" <?php if($getEditComponentRs[0]["COMPONENTDELETEROW"]!='1'){?>selected <?PHP }?>>No</option>
        </select>	  </td>
    </tr>
	</tbody>
	<tbody id="addJavascript" <?php if(!$getEditComponentRs[0]["COMPONENTADDROW"]){?> style="display:none" <?php }?>>
	<tr>
      <td class="inputLabel">Add Row Disabled  : </td>
	  <td>
	  	<select name="editAddRowDisabled" class="inputList" id="editAddRowDisabled" >
          <option value="1" <?php if($getEditComponentRs[0]["COMPONENTADDROWDISABLED"]=='1'){?> selected="selected"<?php }?>>Yes</option>
          <option value="0" <?php if($getEditComponentRs[0]["COMPONENTADDROWDISABLED"]!='1'){?> selected="selected"<?php }?>>No</option>
        </select>      </td>
    </tr>
	<tr>
      <td class="inputLabel">Add Row Javascript  : </td>
	  <td><textarea name="editAddJavascript" cols="100" rows="5" class="inputInput" id="editAddJavascript" ><?php echo convertToDBQry($getEditComponentRs[0]["COMPONENTADDROWJAVASCRIPT"]);?></textarea>      </td>
    </tr>
	</tbody>
	<tbody id="deleteJavascript" <?php if(!$getEditComponentRs[0]["COMPONENTDELETEROW"]){?> style="display:none" <?php }?>>
	<tr>
      <td class="inputLabel">Delete Row Disabled  : </td>
	  <td>
	  	<select name="editDeleteRowDisabled" class="inputList" id="editDeleteRowDisabled" >
          <option value="1" <?php if($getEditComponentRs[0]["COMPONENTDELETEROWDISABLED"]=='1'){?> selected="selected"<?php }?>>Yes</option>
          <option value="0" <?php if($getEditComponentRs[0]["COMPONENTDELETEROWDISABLED"]!='1'){?> selected="selected"<?php }?>>No</option>
        </select>      </td>
    </tr>
	<tr>
      <td class="inputLabel">Delete Row Javascript  : </td>
	  <td><textarea name="editDeleteJavascript" cols="100" rows="5" class="inputInput" id="editDeleteJavascript" ><?php echo convertToDBQry($getEditComponentRs[0]["COMPONENTDELETEROWJAVASCRIPT"]);?></textarea>      </td>
    </tr>
	</tbody>
    <tr>
      <td class="subHead">QUERY ONLY </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Query : </td>
      <td><textarea name="editTypeQuery" cols="100" rows="10" class="inputInput" id="editTypeQuery" <?php 
		
		if($getEditComponentRs[0]["COMPONENTTYPE"] == 'form_1_col' || $getEditComponentRs[0]["COMPONENTTYPE"] == 'form_2_col' || $getEditComponentRs[0]["COMPONENTTYPE"] == 'tabular') { ?>disabled<?php }?>><?php echo convertToDBQry($getEditComponentRs[0]["COMPONENTTYPEQUERY"]);   ?></textarea>
        <br />
        <label><input name="editQueryLimit" type="checkbox" id="editQueryLimit" value="1" <?php if($getEditComponentRs[0]['COMPONENTQUERYUNLIMITED']){?> checked="checked"<?php }?> <?php if($getEditComponentRs[0]["COMPONENTTYPE"] == 'form_1_col' || $getEditComponentRs[0]["COMPONENTTYPE"] == 'form_2_col' || $getEditComponentRs[0]["COMPONENTTYPE"] == 'tabular') { ?>disabled<?php }?> />Unlimited</label></td>
    </tr>
    <tr>
      <td class="subHead">MASTER DETAIL ONLY </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Master Component : </td>
      <td><select name="editMasterID" class="inputList" id="editMasterID" >
          <option value="0">&nbsp;</option>
          <?php for($x=0; $x < count($getComponentRs); $x++) { ?>
          <option value="<?php echo $getComponentRs[$x]["COMPONENTID"]?>" <?php if($getEditComponentRs[0]["COMPONENTMASTERID"] == $getComponentRs[$x]["COMPONENTID"]) echo 'selected';?>><?php echo $getComponentRs[$x]["COMPONENTNAME"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="subHead">FLATFILE VIEWER </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Upload Column : </td>
      <td>
        <select name="editUploadColumn" class="inputList" id="editUploadColumn" >
          <option value="">&nbsp;</option>
          <?php 
			for($x=0; $x < $getColumnsRsCount; $x++) { ?>
          <option value="<?php echo $getColumnsRs[$x]['COLUMN_NAME']?>" <?php if($getEditComponentRs[0]['COMPONENTUPLOADCOLUMN'] == $getColumnsRs[$x]['COLUMN_NAME']) { ?> selected<?php }?> ><?php echo $getColumnsRs[$x]['COLUMN_NAME']?></option>
          <?php } ?>
        </select>
		(for flatfile viewer only) </td>
    </tr>
    <tr>
      <td class="inputLabel">Fixed Length : </td>
      <td><input name="editItemFlatfileFixedLength" type="text" class="inputInput" id="editItemFlatfileFixedLength" size="50" value="<?php echo $getEditComponentRs[0]["COMPONENTFLATFILEFIXEDLENGTH"] ?>"/>
        Eg: 20,10,45 (list of fixed lengths) </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="hiddenComponentID" type="hidden" id="hiddenComponentID" value="<?php echo $_POST["hiddenComponentID"];?>" />
          <input name="saveScreenRefEdit" type="submit" class="inputButton" id="saveScreenRefEdit" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($showScreen_8)  { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">New Component Item </th>
    </tr>
    <tr>
      <td width="161" class="inputLabel">Component : </td>
      <td><select name="componentID" class="inputList" id="componentID" onchange="document.getElementById('newItemOrderText').value = this.options[this.selectedIndex].label; swapItemDisplay('newItemOrderText', 'newItemOrderCombo'); document.getElementById('orderOptionStart').checked=true; showDatabase(document.getElementById('componentID').value)">
          <option value="0">&nbsp;</option>
          <?php for($x=0; $x < count($getComponentRs); $x++) { ?>
          <option value="<?php echo $getComponentRs[$x]["COMPONENTID"]?>" label="<?php if($getLatestOrderRs[$x]["MAXORDER"])echo $getLatestOrderRs[$x]["MAXORDER"];else echo '1';?>"><?php echo $getComponentRs[$x]["COMPONENTNAME"]?></option>
          <?php } ?>
        </select>
        *</td>
    </tr>
    <tr>
      <td class="inputLabel">Name : </td>
      <td><input name="newItemName" type="text" class="inputInput" id="newItemName" size="50" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td width="1041"><select name="newItemType" class="inputList" id="newItemType" onchange="if(this.options[this.selectedIndex].value == 'textarea'||this.options[this.selectedIndex].value == 'image') form1.newTextareaRows.disabled = false; else form1.newTextareaRows.disabled = true;">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($itemTypeRs); $x++) { ?>
          <option value="<?php echo $itemTypeRs[$x]["REFERENCECODE"]?>" ><?php echo $itemTypeRs[$x]["DESCRIPTION2"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Type Notes : </td>
      <td>* For URL, please fill up Default Value field with the URL.<br />
        * For label, please fill up Default Value field with the label.</td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><label>
        <input name="orderOption" id="orderOptionStart" type="radio" checked="checked" onclick="swapItemDisplay('newItemOrderText', 'newItemOrderCombo')" />
        At</label>
        <label>
        <input name="orderOption" type="radio" onclick="if(form1.componentID.value>0){swapItemDisplay('newItemOrderCombo', 'newItemOrderText');  showComponentItem('<?php echo $_POST['code'];?>', form1.componentID.value)}" />
        Before</label>
        <label>
        <input name="orderOption" type="radio" value="++" onclick="if(form1.componentID.value>0){swapItemDisplay('newItemOrderCombo', 'newItemOrderText'); showComponentItem('<?php echo $_POST['code'];?>', form1.componentID.value)}" />
        After</label>
        <br />
        <input name="newItemOrder" id="newItemOrderText" type="text" class="inputInput" size="5" />
        <span id="hideEditorList"> </span> </td>
    </tr>
    <tr>
      <td class="inputLabel">Input Length : </td>
      <td><input name="newItemInputLength" type="text" class="inputInput" id="newItemInputLength" size="5" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Min / Max  Character : </td>
      <td><input name="newItemMinChar" type="text" class="inputInput" id="newItemMinChar" size="5" />
        <input name="newItemMaxChar" type="text" class="inputInput" id="newItemMaxChar" size="5" />
        *leave these values blank for default system min max character values </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Textarea Input Rows : </td>
      <td><input name="newTextareaRows" type="text" class="inputInput" id="newTextareaRows" size="5" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Default Value : </td>
      <td>
	  	<input name="newItemDefaultValue" type="text" class="inputInput" id="newItemDefaultValueText" size="100"  />
		<textarea name="newItemDefaultValue" cols="100" rows="10" class="inputInput" id="newItemDefaultValueQuery" disabled="disabled" style="display:none" ></textarea>
		<br />
		<input name="newItemDefaultValueQuery" type="checkbox" value="1" onchange="if(this.checked==true){swapItemDisplay('newItemDefaultValueQuery','newItemDefaultValueText')}else{swapItemDisplay('newItemDefaultValueText','newItemDefaultValueQuery')}" />
		<label>Use SQL</label>
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Delimiter : </td>
      <td><input name="newItemDelimiter" type="text" class="inputInput" id="newItemDelimiter" size="5" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Text Alignment  : </td>
      <td><select name="newItemTextAlign" class="inputList" id="newItemTextAlign">
          <option value="left">Left</option>
          <option value="right">Right</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Uppercase : </td>
      <td><select name="newItemUppercase" class="inputList" id="newItemUppercase">
        <option value="" selected="selected">No</option>
        <option value="1">Yes</option>
      </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Lookup : </td>
      <td><label>
        <input name="newLookupType" type="radio" value="no" checked="checked" onclick="if(this.checked == true) { form1.newPredefinedLookup.disabled = true; form1.newAdvQueryLimit.disabled = true; form1.newAdvancedLookup.disabled = true}" />
        No Lookup</label>
        <label>
        <input type="radio" name="newLookupType" value="predefined" onclick="if(this.checked == true) { form1.newPredefinedLookup.disabled = false; form1.newAdvQueryLimit.disabled = false; form1.newAdvancedLookup.disabled = true }" />
        Predefined</label>
        <label>
        <input type="radio" name="newLookupType" value="advanced" onclick="if(this.checked == true) { form1.newAdvancedLookup.disabled = false; form1.newAdvQueryLimit.disabled = false; form1.newPredefinedLookup.disabled = true }" />
        Advanced</label>      </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Predefined Lookup : </td>
      <td><select name="newPredefinedLookup" class="inputList" id="newPredefinedLookup" disabled="disabled">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($predefinedRs); $x++) { ?>
          <option value="<?php echo $predefinedRs[$x]["DESCRIPTION1"]?>" ><?php echo $predefinedRs[$x]["DESCRIPTION1"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Advanced Lookup : </td>
      <td><textarea name="newAdvancedLookup" cols="100" rows="10" class="inputInput" id="newAdvancedLookup" disabled="disabled" ></textarea>
      <br />
      <label><input name="newAdvQueryLimit" type="checkbox" id="newAdvQueryLimit" value="1" disabled="disabled" />Unlimited</label></td>
    </tr>
    <tr>
      <td class="inputLabel">Lookup Notes : </td>
      <td>* For advanced lookup, rename column as &quot;flc_id&quot; for value and &quot;flc_name&quot; for displayed name <br />
        * For LOV Popup input type, check the 'Predefined Lookup' option and select from the <br />
        Predefined Lookup list, 
        or use the Advanced lookup and create your own custom lookup query <br />
        for the LOV <br />
        * For stored procedure, pending :P </td>
    </tr>
    <tr>
      <td class="inputLabel">Notes : </td>
      <td><textarea name="newItemNotes" cols="100" rows="3" class="inputInput" id="newItemNotes" onkeyup="form1.saveScreenRefNew.disabled = false"></textarea></td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Javascript Event : </td>
      <td><select name="newItemJavascriptEvent" class="inputList" id="newItemJavascriptEvent">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($eventRs); $x++) { ?>
          <option value="<?php echo $eventRs[$x]["REFERENCECODE"]?>" ><?php echo $eventRs[$x]["DESCRIPTION1"]?></option>
          <?php } ?>
        </select>
        Note : Min / max character won't work when javascript event 'onchange' is configured here. </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Javascript : </td>
      <td><textarea name="newItemJavascript" cols="100" rows="10" class="inputInput" id="newItemJavascript"></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Database Mapping : </td>
      <td><span id="hideDatabaseList">
        <select name="newMappingID" class="inputList" id="newMappingID" >
          <option value="">&nbsp;</option>
          <?php 
			for($x=0; $x < $getColumnRsCount; $x++) { ?>
          <option value="<?php echo $getColumnRs[$x]['COLUMN_NAME']?>" ><?php echo $getColumnRs[$x]['COLUMN_NAME']?></option>
          <?php } ?>
        </select>
        </span> </td>
    </tr>
	<tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="newItemDisabled" id="newItemDisabled" class="inputList" >
          <option value="0" >No</option>
          <option value="1">Yes</option>
        </select></td>
    </tr>
	<tr>
      <td class="inputLabel">Readonly : </td>
      <td><select name="newItemReadonly" id="newItemReadonly" class="inputList" >
          <option value="0" >No</option>
          <option value="1">Yes</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Status : </td>
      <td><select name="newItemStatus" id="newItemStatus" class="inputList" >
          <option value="1" selected="selected">Active</option>
          <option value="0">Not Active</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Primary Column : </td>
      <td><select name="newItemPrimaryColumn" id="newItemPrimaryColumn" class="inputList" >
          <option value="0" >No</option>
          <option value="1">Yes</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Required : </td>
      <td><select name="newItemRequired" id="newItemRequired" class="inputList" >
          <option value="0" >No</option>
          <option value="1">Yes</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Unique : </td>
      <td><select name="newItemUnique" id="newItemUnique" class="inputList" >
          <option value="0" selected="selected" >No</option>
          <option value="1">Yes</option>
        </select>
        *for primary key column, please set to Yes </td>
    </tr>
    <tr>
      <td class="inputLabel">Append Item To Item Before : </td>
      <td><select name="newItemAppend" id="newItemAppend" class="inputList" >
          <option value="0">No</option>
          <option value="1">Yes</option>
            </select></td>
    </tr>
    <tr>
      <td class="subHead">FORM COMPONENT </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Tab Index : </td>
      <td><input name="newTabIndex" type="text" class="inputInput" id="newTabIndex" size="2" maxlength="3" /></td>
    </tr>
    <tr>
      <td class="subHead">TABULAR COMPONENT </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Aggregate Column : </td>
      <td><select name="newAggregateColumn" class="inputList" id="newAggregateColumn" onchange="if(this.selectedIndex > 0) document.getElementById('newAggregateColumnLabel').disabled = false; else document.getElementById('newAggregateColumnLabel').disabled = true;">
          <option value="">&nbsp;</option>
          <option value="sum">Sum</option>
          <option value="max">Max</option>
          <option value="min">Min</option>
          <option value="count">Count</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Aggregate Col. Label : </td>
      <td><input name="newAggregateColumnLabel" type="text" class="inputInput" id="newAggregateColumnLabel" size="30" disabled /></td>
    </tr>
    <tr>
      <td class="inputLabel">Check All :</td>
      <td><select name="newCheckAll" class="inputList" id="newCheckAll">
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select>
        (type: checkbox only) </td>
    </tr>
    <tr>
      <td class="inputLabel">Include in Search : </td>
      <td><select name="newSearchFlag" class="inputList" id="newSearchFlag">
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Include in URL : </td>
      <td><select name="newURLFlag" class="inputList" id="newURLFlag">
          <option value="1">Yes</option>
          <option value="0" selected="selected">No</option>
        </select></td>
    </tr>
    <tr>
      <td class="subHead">FILE UPLOAD ITEM </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Filter Extension : </td>
      <td><input name="newFileExtension" type="text" class="inputInput" id="newFileExtension" size="30" />
        Note : Separate extension with ';' sign. Leave blank for none.</td>
    </tr>
    <tr>
      <td class="inputLabel">Upload Folder : </td>
      <td><input name="newUploadFolder" type="text" class="inputInput" id="newUploadFolder" size="30" value="upload" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Maximum File Size: </td>
      <td><input name="newMaxSize" type="text" class="inputInput" id="newMaxSize" size="5" />
        kb</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="saveScreenItemNew" type="submit" class="inputButton" id="saveScreenItemNew" value="Simpan" />
          <input name="cancelScreen2" type="submit" class="inputButton" id="cancelScreen2" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
  <?php if($showScreen_9)  { ?>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Modify Component Item </th>
    </tr>
    <tr>
      <td width="146" nowrap="nowrap" class="inputLabel">Component : </td>
      <td width="1056"><select name="componentID" class="inputList" id="componentID" onchange="swapItemDisplay('editItemOrderText', 'editItemOrderCombo'); document.getElementById('orderOptionStart').checked=true; showDatabase(document.getElementById('componentID').value, '<?php echo $showEditComponentItemRs[0]["MAPPINGID"];?>')">
          <?php for($x=0; $x < count($getComponentRs); $x++) { ?>
          <option value="<?php echo $getComponentRs[$x]["COMPONENTID"]?>" <?php if($showEditComponentItemRs[0]["COMPONENTID"] == $getComponentRs[$x]["COMPONENTID"]) echo "selected";?> ><?php echo $getComponentRs[$x]["COMPONENTNAME"]?></option>
          <?php } ?>
        </select>
        *</td>
    </tr>
    <tr>
      <td class="inputLabel">Name : </td>
      <td><input name="editItemName" type="text" class="inputInput" id="editItemName" size="50" value="<?php echo $showEditComponentItemRs[0]["ITEMNAME"]?>" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Type : </td>
      <td><select name="editItemType" class="inputList" id="editItemType" onchange="if(this.options[this.selectedIndex].value == 'textarea'||this.options[this.selectedIndex].value == 'image') form1.editTextareaRows.disabled = false; else form1.editTextareaRows.disabled = true;">
          <?php for($x=0; $x < count($itemTypeRs); $x++) { ?>
          <option value="<?php echo $itemTypeRs[$x]["REFERENCECODE"]?>" <?php if($showEditComponentItemRs[0]["ITEMTYPE"] == $itemTypeRs[$x]["REFERENCECODE"]) echo "selected";?>><?php echo $itemTypeRs[$x]["DESCRIPTION2"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Type Notes : </td>
      <td>* For URL, please fill up Default Value field with the URL.<br />
        * For label, please fill up Default Value field with the label.</td>
    </tr>
    <tr>
      <td class="inputLabel">Order : </td>
      <td><label>
        <input name="orderOption" id="orderOptionStart" type="radio" checked="checked" onclick="swapItemDisplay('editItemOrderText', 'editItemOrderCombo')" />
        At</label>
        <label>
        <input name="orderOption" type="radio" onclick="swapItemDisplay('editItemOrderCombo', 'editItemOrderText'); showComponentItem('<?php echo $_POST['code'];?>', form1.componentID.value, '<?php echo $_POST['hiddenItemID'];?>')" />
        Before</label>
        <label>
        <input name="orderOption" type="radio" value="++" onclick="swapItemDisplay('editItemOrderCombo', 'editItemOrderText'); showComponentItem('<?php echo $_POST['code'];?>', form1.componentID.value, '<?php echo $_POST['hiddenItemID'];?>')" />
        After</label>
        <br />
        <input name="editItemOrder" id="editItemOrderText" type="text" class="inputInput" size="5" value="<?php echo $showEditComponentItemRs[0]["ITEMORDER"]?>" />
        <span id="hideEditorList"> </span></td>
    </tr>
    <tr>
      <td class="inputLabel">Input Length : </td>
      <td><input name="editItemInputLength" type="text" class="inputInput" id="editItemInputLength" size="5" value="<?php echo $showEditComponentItemRs[0]["ITEMINPUTLENGTH"]?>" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Min / Max  Character : </td>
      <td><input name="editItemMinChar" type="text" class="inputInput" id="editItemMinChar" value="<?php echo $showEditComponentItemRs[0]["ITEMMINCHAR"]?>" size="5" />
        <input name="editItemMaxChar" type="text" class="inputInput" id="editItemMaxChar" value="<?php echo $showEditComponentItemRs[0]["ITEMMAXCHAR"]?>" size="5" />
        *leave these values blank for default system min max character values </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Textarea Input Rows : </td>
      <td><input name="editTextareaRows" type="text" class="inputInput" id="editTextareaRows" size="5" <?php if($showEditComponentItemRs[0]["ITEMTYPE"] != 'textarea'&&$showEditComponentItemRs[0]["ITEMTYPE"] != 'image') { ?> <?php } ?> value="<?php echo $showEditComponentItemRs[0]["ITEMTEXTAREAROWS"]?>" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Default Value : </td>
      <td>
	  	<input name="editItemDefaultValue" type="text" class="inputInput" id="editItemDefaultValueText" size="100" value="<?php echo $showEditComponentItemRs[0]["ITEMDEFAULTVALUE"]?>" <?php if($showEditComponentItemRs[0]["ITEMDEFAULTVALUEQUERY"]){?>disabled="disabled" style="display:none"<?php }?> />
		<textarea name="editItemDefaultValue" cols="100" rows="10" class="inputInput" id="editItemDefaultValueQuery" <?php if(!$showEditComponentItemRs[0]["ITEMDEFAULTVALUEQUERY"]){?>disabled="disabled" style="display:none"<?php }?> ><?php echo $showEditComponentItemRs[0]["ITEMDEFAULTVALUE"]?></textarea>
		<br />
		<input name="editItemDefaultValueQuery" type="checkbox" value="1" <?php if($showEditComponentItemRs[0]["ITEMDEFAULTVALUEQUERY"]){?> checked="checked"<?php }?> onchange="if(this.checked==true){swapItemDisplay('editItemDefaultValueQuery','editItemDefaultValueText')}else{swapItemDisplay('editItemDefaultValueText','editItemDefaultValueQuery')}" />
		<label>Use SQL</label>
	  </td>
    </tr>
    <tr>
      <td class="inputLabel">Delimiter : </td>
      <td><input name="editItemDelimiter" type="text" class="inputInput" id="editItemDelimiter" value="<?php echo $showEditComponentItemRs[0]["ITEMDELIMITER"]?>" size="5" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Text Alignment  : </td>
      <td><select name="editItemTextAlign" class="inputList" id="editItemTextAlign">
          <option value="left" <?php if($showEditComponentItemRs[0]["ITEMTEXTALIGN"] == 'left') { ?> selected<?php } ?>>Left</option>
          <option value="right"<?php if($showEditComponentItemRs[0]["ITEMTEXTALIGN"] == 'right') { ?> selected<?php } ?>>Right</option>
        </select></td>
    </tr>
	<tr>
      <td class="inputLabel">Uppercase : </td>
      <td><select name="editItemUppercase" class="inputList" id="editItemUppercase">
        <option value="" <?php if($showEditComponentItemRs[0]["ITEMUPPERCASE"] != '1') { ?> selected<?php } ?>>No</option>
        <option value="1" <?php if($showEditComponentItemRs[0]["ITEMUPPERCASE"] == '1') { ?> selected<?php } ?>>Yes</option>
      </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Lookup : </td>
      <td><label>
        <input name="editLookupType" type="radio" value="no" <?php if($showEditComponentItemRs[0]["ITEMLOOKUPTYPE"] == "no") { ?> checked="checked"<?php } ?> onclick="if(this.checked == true) { form1.editPredefinedLookup.disabled = true; form1.editAdvQueryLimit.disabled = true; form1.editAdvancedLookup.disabled = true}" />
        No Lookup</label>
        <label>
        <input type="radio" name="editLookupType" value="predefined" <?php if($showEditComponentItemRs[0]["ITEMLOOKUPTYPE"] == "predefined") { ?> checked="checked"<?php } ?> onclick="if(this.checked == true) { form1.editPredefinedLookup.disabled = false; form1.editAdvQueryLimit.disabled = false; form1.editAdvancedLookup.disabled = true }" />
        Predefined</label>
        <label>
        <input type="radio" name="editLookupType" value="advanced" <?php if($showEditComponentItemRs[0]["ITEMLOOKUPTYPE"] == "advanced") { ?> checked="checked"<?php } ?> onclick="if(this.checked == true) { form1.editAdvancedLookup.disabled = false; form1.editAdvQueryLimit.disabled = false; form1.editPredefinedLookup.disabled = true }" />
        Advanced</label>      </td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Predefined Lookup : </td>
      <td><select name="editPredefinedLookup" class="inputList" id="editPredefinedLookup" <?php if($showEditComponentItemRs[0]["ITEMLOOKUPTYPE"] != "predefined") { ?>disabled="disabled"<?php } ?> >
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($predefinedRs); $x++) { ?> 
          <option value="<?php echo $predefinedRs[$x]["DESCRIPTION1"]?>" <?php if(eregi("DESCRIPTION1 = '".$predefinedRs[$x]["DESCRIPTION1"]."'",$showEditComponentItemRs[0]["ITEMLOOKUP"])) echo "selected"?>><?php echo $predefinedRs[$x]["DESCRIPTION1"];?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Advanced Lookup : </td>
      <?php $showEditComponentItemRs[0]["ITEMLOOKUP"] = str_replace('\\','',$showEditComponentItemRs[0]["ITEMLOOKUP"]);
			?>
      <td><textarea name="editAdvancedLookup" cols="100" rows="10" class="inputInput" id="editAdvancedLookup" <?php if($showEditComponentItemRs[0]["ITEMLOOKUPTYPE"] != "advanced") { ?>disabled="disabled"<?php } ?>><?php if($showEditComponentItemRs[0]["ITEMLOOKUPTYPE"] == "advanced") echo $showEditComponentItemRs[0]["ITEMLOOKUP"]?>
</textarea>
  <br />
  <label><input name="editAdvQueryLimit" type="checkbox" id="editAdvQueryLimit" value="1" <?php if($showEditComponentItemRs[0]['ITEMLOOKUPUNLIMITED']){?> checked="checked"<?php }?> <?php if($showEditComponentItemRs[0]['ITEMLOOKUPTYPE'] != "advanced") { ?>disabled="disabled"<?php } ?> />Unlimited</label></td>
    </tr>
    <tr>
      <td class="inputLabel">Lookup Notes : </td>
      <td>* For advanced lookup, rename column as &quot;flc_id&quot; for value and &quot;flc_name&quot; for displayed name <br />
        * For LOV Popup input type, check the 'Predefined Lookup' option and select from the <br />
        Predefined Lookup list, 
        or use the Advanced lookup and create your own custom lookup query <br />
        for the LOV </td>
    </tr>
    <tr>
      <td class="inputLabel">Notes : </td>
      <td><textarea name="editItemNotes" cols="100" rows="3" class="inputInput" id="editItemNotes" ><?php echo $showEditComponentItemRs[0]["ITEMNOTES"]?></textarea></td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="inputLabel">Javascript Event : </td>
      <td><select name="editItemJavascriptEvent" class="inputList" id="editItemJavascriptEvent">
          <option value="">&nbsp;</option>
          <?php for($x=0; $x < count($eventRs); $x++) { ?>
          <option value="<?php echo $eventRs[$x]["REFERENCECODE"]?>" <?php if($eventRs[$x]["REFERENCECODE"] == $showEditComponentItemRs[0]["ITEMJAVASCRIPTEVENT"]) echo "selected";?> ><?php echo $eventRs[$x]["DESCRIPTION1"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Javascript : </td>
      <td><textarea name="editItemJavascript" cols="100" rows="10" class="inputInput" id="editItemJavascript"><?php echo $showEditComponentItemRs[0]["ITEMJAVASCRIPT"]?></textarea></td>
    </tr>
    <tr>
      <td class="inputLabel">Database Mapping : </td>
      <td><span id="hideDatabaseList">
        <select name="editMappingID" class="inputList" id="editMappingID" >
          <option value="">&nbsp;</option>
          <?php 
			for($x=0; $x < $getColumnsRsCount; $x++) { ?>
          <option value="<?php echo $getColumnsRs[$x]['COLUMN_NAME']?>" <?php if($showEditComponentItemRs[0]["MAPPINGID"] == $getColumnsRs[$x]['COLUMN_NAME']) { ?> selected<?php }?>><?php echo $getColumnsRs[$x]['COLUMN_NAME']?></option>
          <?php } ?>
        </select>
        </span></td>
    </tr>
	<tr>
      <td class="inputLabel">Disabled : </td>
      <td><select name="editItemDisabled" id="editItemDisabled" class="inputList">
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMDISABLED"] == 0) { ?> selected<?php }?>>No</option>
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMDISABLED"] == 1) { ?> selected<?php }?>>Yes</option>
        </select></td>
    </tr>
	<tr>
      <td class="inputLabel">Readonly : </td>
      <td><select name="editItemReadonly" id="editItemReadonly" class="inputList">
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMREADONLY"] == 0) { ?> selected<?php }?>>No</option>
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMREADONLY"] == 1) { ?> selected<?php }?>>Yes</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Status : </td>
      <td><select name="editItemStatus" id="editItemStatus" class="inputList">
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMSTATUS"] == 1) { ?> selected<?php }?> >Active</option>
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMSTATUS"] == 0) { ?> selected<?php }?> >Not Active</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Primary Column : </td>
      <td><select name="editItemPrimaryColumn" id="editItemPrimaryColumn" class="inputList" >
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMPRIMARYCOLUMN"] == 0) { ?> selected<?php }?>>No</option>
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMPRIMARYCOLUMN"] == 1) { ?> selected<?php }?>>Yes</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Required : </td>
      <td><select name="editItemRequired" id="editItemRequired" class="inputList" >
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMREQUIRED"] == 0) { ?> selected<?php }?>>No</option>
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMREQUIRED"] == 1) { ?> selected<?php }?>>Yes</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Unique : </td>
      <td><select name="editItemUnique" id="editItemUnique" class="inputList" >
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMUNIQUE"] == 0) { ?> selected<?php } else if($showEditComponentItemRs[0]["ITEMUNIQUE"] != '0' && $showEditComponentItemRs[0]["ITEMUNIQUE"] != '1') {?>selected<?php }?> >No</option>
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMUNIQUE"] == 1) { ?> selected<?php }?>>Yes</option>
        </select>
        *for primary key column, please set to Yes </td>
    </tr>
    <tr>
      <td class="inputLabel">Append Item To Item Before : </td>
      <td><select name="editItemAppend" id="editItemAppend" class="inputList" >
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMAPPENDTOBEFORE"] == 0) { ?> selected<?php }?>>No</option>
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMAPPENDTOBEFORE"] == 1) { ?> selected<?php }?>>Yes</option>
      </select></td>
    </tr>
    
    <tr>
      <td class="subHead">FORM COMPONENT </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Tab Index : </td>
      <td><input name="editTabIndex" type="text" class="inputInput" id="editTabIndex" value="<?php echo $showEditComponentItemRs[0]["ITEMTABINDEX"]?>" size="2" maxlength="3" /></td>
    </tr>
    <tr>
      <td class="subHead">TABULAR ONLY </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Aggregate Column : </td>
      <td><select name="editAggregateColumn" class="inputList" id="editAggregateColumn" onchange="if(this.selectedIndex &gt; 0) document.getElementById('editAggregateColumnLabel').disabled = false; else document.getElementById('editAggregateColumnLabel').disabled = true;">
          <option value="">&nbsp;</option>
          <option value="sum" <?php if($showEditComponentItemRs[0]["ITEMAGGREGATECOLUMN"] == 'sum') echo "selected"?>>Sum</option>
          <option value="max" <?php if($showEditComponentItemRs[0]["ITEMAGGREGATECOLUMN"] == 'max') echo "selected"?>>Max</option>
          <option value="min" <?php if($showEditComponentItemRs[0]["ITEMAGGREGATECOLUMN"] == 'min') echo "selected"?>>Min</option>
          <option value="count" <?php if($showEditComponentItemRs[0]["ITEMAGGREGATECOLUMN"] == 'count') echo "selected"?>>Count</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Aggregate Col. Label : </td>
      <td><input name="editAggregateColumnLabel" type="text" class="inputInput" id="editAggregateColumnLabel" size="30" value="<?php echo $showEditComponentItemRs[0]["ITEMAGGREGATECOLUMNLABEL"]?>" <?php if($showEditComponentItemRs[0]["ITEMAGGREGATECOLUMN"] == '') { ?>disabled<?php } ?> /></td>
    </tr>
    <tr>
      <td class="inputLabel">Check All :</td>
      <td><select name="editCheckAll" class="inputList" id="editCheckAll">
          <option value="1" <?php if($showEditComponentItemRs[0]["ITEMCHECKALL"] == '1') echo "selected"?>>Yes</option>
          <option value="0" <?php if($showEditComponentItemRs[0]["ITEMCHECKALL"] == '0') echo "selected"?>>No</option>
        </select>
        (type: checkbox only) </td>
    </tr>
    <tr>
      <td class="inputLabel">Include in Search : </td>
      <td><select name="editSearchFlag" class="inputList" id="editSearchFlag">
          <option value="1" <?php if($showEditComponentItemRs[0]["SEARCHFLAG"] == 1) { ?>selected<?php }?>>Yes</option>
          <option value="0" <?php if($showEditComponentItemRs[0]["SEARCHFLAG"] == 0) { ?>selected<?php }?>>No</option>
        </select></td>
    </tr>
    <tr>
      <td class="inputLabel">Include in URL : </td>
      <td><select name="editURLFlag" class="inputList" id="editURLFlag">
          <option value="1" <?php if($showEditComponentItemRs[0]["URLFLAG"] == 1) { ?>selected<?php }?>>Yes</option>
          <option value="0" <?php if($showEditComponentItemRs[0]["URLFLAG"] == 0) { ?>selected<?php }?>>No</option>
        </select></td>
    </tr>
	<tr>
      <td class="subHead">FILE UPLOAD ITEM </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="inputLabel">Filter Extension : </td>
      <td><input name="editFileExtension" type="text" class="inputInput" id="editFileExtension" value="<?php echo $uploadExtension;?>" size="30" />
        Note : Separate extension with ';' sign. Leave blank for none.</td>
    </tr>
    <tr>
      <td class="inputLabel">Upload Folder : </td>
      <td><input name="editUploadFolder" type="text" class="inputInput" id="editUploadFolder" size="30" value="<?php echo $uploadFolder;?>" /></td>
    </tr>
    <tr>
      <td class="inputLabel">Maximum File Size: </td>
      <td><input name="editMaxSize" type="text" class="inputInput" id="editMaxSize" value="<?php echo $uploadMaxSize;?>" size="5" />
        kb</td>
    </tr>
    <tr>
      <td colspan="2" class="contentButtonFooter"><div align="right">
          <input name="hiddenItemID" type="hidden" id="hiddenItemID" value="<?php echo $_POST["hiddenItemID"];?>" />
          <input name="saveScreenItemEdit" type="submit" class="inputButton" id="saveScreenItemEdit" value="Simpan" />
          <input name="cancelScreen2" type="submit" class="inputButton" id="cancelScreen2" value="Batal" />
        </div></td>
    </tr>
  </table>
  <?php } ?>
</form>
<?php if($showScreen_3)  { ?>
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="7">Page Component </th>
  </tr>
  <?php if(count($referenceRs) > 0) { ?>
  <tr>
    <td width="12" class="listingHead">#</td>
    <td width="12" class="listingHead">ID</td>
    <td class="listingHead">Name</td>
    <td width="50" class="listingHead">Type</td>
    <td width="45" class="listingHead">Status</td>
    <td width="35" class="listingHead">Order</td>
    <td width="80" class="listingHeadRight">Action</td>
  </tr>
  <?php for($x=0; $x < count($referenceRs); $x++) { ?>
  <tr>
    <td class="listingContent"><?php echo ($x+1).".";?>&nbsp;</td>
    <td class="listingContent"><?php echo $referenceRs[$x]["COMPONENTID"];?></td>
    <td class="listingContent"><?php echo $referenceRs[$x]["COMPONENTNAME"];?></td>
    <td class="listingContent"><?php echo $referenceRs[$x]["COMPONENTTYPE"];?></td>
    <td class="listingContent"><?php if($referenceRs[$x]["COMPONENTSTATUS"] == 1) echo 'Enabled'; else if($referenceRs[$x]["COMPONENTSTATUS"] == 0) echo 'Disabled'?></td>
    <td class="listingContent"><?php echo $referenceRs[$x]["COMPONENTORDER"];?></td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formComponent<?php echo $referenceRs[$x]["COMPONENTID"];?>" name="formComponent<?php echo $referenceRs[$x]["COMPONENTID"];?>" method="post" action="">
        <input name="moveUpComponent" type="submit" class="inputButton" id="moveUpComponent" value="up" />
        <input name="moveDownComponent" type="submit" class="inputButton" id="moveDownComponent" value="down" />
        <input name="duplicateComponent" type="submit" class="inputButton" id="duplicateComponent" value="duplicate" onClick="if(window.confirm('Duplicate this item?')) {return true} else {return false}" />
        <input name="editComponent" type="submit" class="inputButton" id="editComponent" value="ubah" />
        <input name="deleteComponent" type="submit" class="inputButton" id="deleteComponent" value="buang" onClick="if(window.confirm('Are you sure you want to DELETE this component?\nThis will also delete ALL component items under this component')) {return true} else {return false}" />
        <input name="hiddenComponentID" type="hidden" id="hiddenComponentID" value="<?php echo $referenceRs[$x]["COMPONENTID"];?>" />
        <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="7" class="myContentInput">&nbsp;&nbsp;No component(s) found.. </td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="7" bgcolor="#F7F3F7"><div align="right">
        <form id="form3" name="form3" method="post" action="">
          <input name="resetOrderingComponent" type="submit" class="inputButton" id="resetOrderingComponent" value="Reset Order" onclick="if(window.confirm('Are you sure you want to reset the menu order?')) {return true} else {return false}" />
          <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
          <input name="hiddenComponentID" type="hidden" id="hiddenComponentID" value="<?php echo $_POST["hiddenComponentID"];?>" />
          <input name="newComponent" type="submit" class="inputButton" id="newComponent" value="New Component" />
          <input name="saveScreen22" type="submit" class="inputButton" value="Tutup" />
        </form>
      </div></td>
  </tr>
</table>
<?php } ?>
<?php if($showScreen_1) { ?>
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
  <tr>
    <th colspan="12">Component Items </th>
  </tr>
  <?php if(count($reference_2Rs) > 0) { ?>
  <tr>
    <td width="10" class="listingHead">#</td>
    <td width="30" class="listingHead">ID</td>
    <td class="listingHead">Component</td>
    <td class="listingHead">Name</td>
    <td class="listingHead">Type</td>
    <td width="25" class="listingHead">Ord.</td>
    <td width="23" class="listingHead">Def.</td>
    <td width="30" class="listingHead">Look.</td>
    <td width="23" class="listingHead">Map.</td>
    <td width="23" class="listingHead">Req.</td>
    <td width="40" class="listingHead">Status</td>
    <td width="82" class="listingHeadRight">Action</td>
  </tr>
  <?php for($x=0; $x < count($reference_2Rs); $x++) { ?>
  <tr <?php if($reference_2Rs[$x]["ITEMPRIMARYCOLUMN"] == '1') { ?>style="background-color:#EEDDFF"<?php } ?>>
    <td class="listingContent"><?php echo ($x+1).".";?></td>
    <td class="listingContent"><?php echo $reference_2Rs[$x]["COMPONENTID"]."_".$reference_2Rs[$x]["ITEMID"];?></td>
    <td class="listingContent"><?php echo $reference_2Rs[$x]["COMPONENTNAME"];?></td>
    <td class="listingContent"><?php echo $reference_2Rs[$x]["ITEMNAME"];?></td>
    <td class="listingContent"><?php echo $reference_2Rs[$x]["ITEMTYPE"];?></td>
    <td class="listingContent"><?php echo $reference_2Rs[$x]["ITEMORDER"];?></td>
    <td class="listingContent"><?php if(strlen($reference_2Rs[$x]["ITEMDEFAULTVALUE"]) > 1) echo "Yes"; else echo "No"; ?></td>
    <td class="listingContent"><?php if(strlen($reference_2Rs[$x]["ITEMLOOKUP"]) > 1) echo "Yes"; else echo "No";?></td>
    <td class="listingContent"><?php if(trim($reference_2Rs[$x]["MAPPINGID"]) == "" || $reference_2Rs[$x]["MAPPINGID"] == "null") echo "No"; else echo "Yes";?></td>
    <td class="listingContent"><?php if($reference_2Rs[$x]["ITEMREQUIRED"] == 1) echo "Yes"; else echo "No";?></td>
    <td class="listingContent"><?php if($reference_2Rs[$x]["ITEMSTATUS"] == 1) echo 'Active'; else if($reference_2Rs[$x]["ITEMSTATUS"] == 0) echo 'Inactive'?></td>
    <td nowrap="nowrap" class="listingContentRight"><form id="formReference<?php echo $reference_2Rs[$x]["code"];?>" name="formReference<?php echo $reference_2Rs[$x]["code"];?>" method="post" action="">
        <input name="moveUpItem" type="submit" class="inputButton" id="moveUpItem" value="up" />
        <input name="moveDownItem" type="submit" class="inputButton" id="moveDownItem" value="down" />
        <input name="duplicateReference" type="submit" class="inputButton" id="duplicateReference" value="duplicate" onClick="if(window.confirm('Duplicate this item?')) {return true} else {return false}" />
        <input name="editReference" type="submit" class="inputButton" id="editReference" value="ubah" />
        <input name="deleteReference" type="submit" class="inputButton" id="deleteReference" value="buang" onClick="if(window.confirm('Are you sure you want to DELETE this component item?')) {return true} else {return false}" />
        <input name="hiddenItemID" type="hidden" id="hiddenItemID" value="<?php echo $reference_2Rs[$x]["ITEMID"];?>" />
        <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
      </form></td>
  </tr>
  <?php 		} //end for ?>
  <?php 	}//end if 
	else 	{ ?>
  <tr>
    <td colspan="12" class="myContentInput">&nbsp;&nbsp;No component item(s) found.. </td>
  </tr>
  <?php 	} //end else?>
  <tr>
    <td colspan="12" bgcolor="#F7F3F7"><div align="right">
        <form id="form2" name="form2" method="post" action="">
          <input name="resetOrderingItem" type="submit" class="inputButton" id="resetOrderingItem" value="Reset Order" onclick="if(window.confirm('Are you sure you want to reset the menu order?')) {return true} else {return false}" />
          <input name="hiddenComponentID" type="hidden" id="hiddenComponentID" value="<?php echo $_POST["hiddenComponentID"];?>" />
          <input name="code" type="hidden" id="code" value="<?php echo $_POST["code"];?>" />
			<input name="newReference" type="submit" class="inputButton" id="newReference" value="New Component Item"  <?php if(count($referenceRs) == 0) { ?>disabled="disabled" style="color:#999999" <?php } ?>  />
          <input name="saveScreen2" type="submit" class="inputButton" value="Tutup" />
        </form>
      </div></td>
  </tr>
</table>
<br />
&nbsp;&nbsp;&nbsp;Note:<ul><li><em>Append component item ID with input_map. Eg: input_map_881_1231 </em></li>
</ul>
<?php } ?>
