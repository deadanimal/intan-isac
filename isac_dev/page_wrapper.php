<?php 
//if ajax is called 
if($_GET['type'] == 'ajax')
	include_once('system_prerequisite.php');

//functions needed
require_once('engine_elem_builder.php');
require_once('engine_control_builder.php');
require_once('class/Table.php');				//class Table
require_once('class/Field.php');				//class Field

//if menuID is set
if($_GET["menuID"])
{
	//query to get page info
	$pageArr = $myQuery->query("select a.* 
									from FLC_PAGE a, FLC_MENU b 
									where a.MENUID = b.MENUID 
									and a.MENUID = ".$_GET["menuID"],'SELECT','NAME');						  
	
	//if menu have page
	if(is_array($pageArr))
	{
		//get component		
		$componentArr = $myQuery->query("select b.*
											from FLC_PAGE a, FLC_PAGE_COMPONENT b 
											where a.PAGEID = b.PAGEID 
											and a.MENUID = ".$_GET["menuID"]." 
											and b.COMPONENTSTATUS = 1 
											order by b.COMPONENTORDER",'SELECT','NAME');
	
		//count no of component in page
		$componentCount = count($componentArr);
		
		//===========RUN POST SCRIPT================
		include('page_wrapper_post_script.php');
		//=========EOF RUN POST SCRIPT==============
		
		//=========== ELEMENT POST BACK ================
		//if pagememory true
		if($pageArr[0]['PAGEMEMORY'])
		{
			getElemPostBack($_GET['menuID']);			//get postBack
			setElemPostBack($_GET['menuID'],$_POST,$_GET, 'input_map_','','',array('page','menuid'));	//set postBack
		}//eof if
		//========= EOF ELEMENT POST BACK ==============
		
	}//eof if
	else
		showNotification('','Please create page!!');		//show error message
}
?>
<!-- BREADCRUMBS SECTION -->
<div id="breadcrumbs"><?php echo $pageArr[0]['PAGEBREADCRUMBS'];?></div>
<!-- //END BREADCRUMBS SECTION -->
<!-- PAGE TITLE SECTION -->
<h1><?php echo $pageArr[0]['PAGENAME'];?></h1>
<!-- //END PAGE TITLE SECTION -->
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
  <?php 
//for all component in this page, show the component!
for($x=0; $x < $componentCount; $x++)
{	
	//============================== COMPONENT PRE PROCESS ==============================
  
  	//if type of pre process is SELECT
	if($componentArr[$x]['COMPONENTPREPROCESS'] == 'select')
	{
		//unset previous list
		unset($listOfColumn);
	
		//get list of mapped items
		$getMappedItem = "select a.COMPONENTID, b.ITEMID, b.MAPPINGID 
							from FLC_PAGE_COMPONENT a, FLC_PAGE_COMPONENT_ITEMS b 
							where a.COMPONENTID = b.COMPONENTID 
							and a.COMPONENTID = ".$componentArr[$x]['COMPONENTID']."
							and b.MAPPINGID is not null
							and b.MAPPINGID != 'null' 
							order by ITEMORDER";
		$getMappedItem = $myQuery->query($getMappedItem,'SELECT','NAME');
		$countGetMappedItem = count($getMappedItem);
		
		//get list of columns from list of mapped items
		for($a=0; $a < $countGetMappedItem; $a++)
		{
			$listOfColumn[] = $getMappedItem[$a]['MAPPINGID'];
			$getMappedItem[$a]['COMPONENTIDNAME'] = 'input_map_'.$getMappedItem[$a]['COMPONENTID'].'_'.$getMappedItem[$a]['ITEMID'];
		}//eof for
			
		//check datatype for column
		for($a=0; $a < count($listOfColumn); $a++)
		{
			//get datatype
			$chkColumnTypeRs = $mySQL->columnDatatype(DB_OTHERS,DB_OTHERS,$componentArr[$x]['COMPONENTBINDINGSOURCE'], $listOfColumn[$a]);
			
			//if type date, use date format
			if($chkColumnTypeRs[0]['DATA_TYPE']=='DATE')
				$listOfColumn[$a] = $mySQL->convertFromDate($listOfColumn[$a])." as ".$listOfColumn[$a];
			//echo $listOfColumn[$a];
		}//eof for
		
		//----- get data from database table -----
		//if type is FORM 1 COL / FORM 2 COL
		if($componentArr[$x]['COMPONENTTYPE'] == 'form_1_col' || $componentArr[$x]['COMPONENTTYPE'] == 'form_2_col')
		{
			//if binding type is VIEW
			if($componentArr[$x]['COMPONENTBINDINGTYPE'] == 'view')
			{
				//get PRIMARY KEY from component
				$getPrimaryKeyFromComponentItem = "select MAPPINGID from FLC_PAGE_COMPONENT_ITEMS 
													where ITEMPRIMARYCOLUMN = 1 
													and COMPONENTID = ".$componentArr[$x]['COMPONENTID'];
				$getPrimaryKeyFromComponentItemRs = $myQuery->query($getPrimaryKeyFromComponentItem,'SELECT','NAME');
				$getPrimaryKeyFromComponentItemRsCount = count($getPrimaryKeyFromComponentItemRs);
				
				//loop on number of primary key
				for($f=0; $f < $getPrimaryKeyFromComponentItemRsCount; $f++)
				{
					//if not 1st count
					if($f>0)
						$tempKey=$f+1;	
					
					//if keyid is set
					if(isset($_GET['keyid'.$tempKey]))
					{
						//list of primary key in array
						$listOfPrimaryKey[$f] = $getPrimaryKeyFromComponentItemRs[$f]['MAPPINGID']." = '".$_GET['keyid'.$tempKey]."'";
					}//eof if
				}//eof for				
				
				//construct the sql -fais
				$getData = "select ".implode(', ',$listOfColumn)." 
							from ".$componentArr[$x]['COMPONENTBINDINGSOURCE']."
							where ".implode(' and ',$listOfPrimaryKey);
			}
			
			//else, use standard primary key
			else
			{	
				$getPrimaryKeyRs = $mySQL->listPrimaryKey($componentArr[$x]['COMPONENTBINDINGSOURCE']);
				$getPrimaryKeyRsCount = count($getPrimaryKeyRs); 

				//loop on number of primary key
				for($f=0; $f < $getPrimaryKeyRsCount; $f++)
				{
					//if not 1st count
					if($f>0)
						$tempKey=$f+1;	//to be appended on keyid
					
					//if keyid is set
					if(isset($_GET['keyid'.$tempKey]))
					{
						//list of primary key in array
						$listOfPrimaryKey[$f] = $getPrimaryKeyRs[$f]['COLUMN_NAME']." = '".$_GET['keyid'.$tempKey]."'";
					}//eof if
				}//eof for
				
				//if listofcolumn and listofprimarykey area arrays
				if(is_array($listOfColumn)&&is_array($listOfPrimaryKey))
				{
					//construct the sql -fais
					$getData = "select ".implode(', ',$listOfColumn)." 
								from ".$componentArr[$x]['COMPONENTBINDINGSOURCE']."
								where ".implode(' and ', $listOfPrimaryKey);
				}//eof if
			}
		}//end if componetn form 1 col / form 2 col
		
		//if type is TABULAR
		else if($componentArr[$x]['COMPONENTTYPE'] == 'tabular')
		{
			//construct the sql
			$getData = "select ".implode(', ',$listOfColumn)." 
						from ".$componentArr[$x]['COMPONENTBINDINGSOURCE'];

			//if get KEYID is set		
			if(isset($_GET['keyid']) || isset($_GET['keyid2']) || isset($_GET['keyid3'])) 
			{
				//get tabular primary key
				$tabularPrimaryKey = $mySQL->listPrimaryKey($componentArr[$x]['COMPONENTBINDINGSOURCE']);
				
				//append where clause
				$getData .= " where ";
				
				//if tabularPrimaryKey is array - means multiple primary key
				if(is_array($tabularPrimaryKey))
				{
					//for all rows in tabular primary key, append to where statement
					for($f=0; $f < count($tabularPrimaryKey); $f++)
					{	
						//if first iteration
						if($f == 0)
							$keyID = '';		//append empty string to keyid name
						else
							$keyID = $f+1;		//else, append current loop iteration number
						
						//if keyid is set
						if(isset($_GET['keyid'.$keyID]))
							$tempGetData[] = $tabularPrimaryKey[$f]['COLUMN_NAME']." = '".$_GET['keyid'.$keyID]."'";
					}
					
					//append tempgetdata to getData string
					$getData .= implode(' and ',$tempGetData);
				}//end if is_array
				
				//if string is returned
				else if(is_string($tabularPrimaryKey))
				{	
					//if keyid is set
					if(isset($_GET['keyid']))
						$getData .= $tabularPrimaryKey." = '".$_GET['keyid']."'";
				}//end if is string
			}//end if isset keyid(s)
			//if no keyid set
			else
			{
				//get tabular primary key
				$tabularPrimaryKey = $mySQL->listPrimaryKey($componentArr[$x]['COMPONENTBINDINGSOURCE']);
				
				//get position of primary key in column name
				$tabularPrimaryKeyPos = array_search($tabularPrimaryKey,$listOfColumn);
				
				//append ordering on number of column of primary key
				$getData .= " order by ".($tabularPrimaryKeyPos+1);
				
			}//eof else
		}//end if tabular
		
		//get the data using constructed sql
		if($getData)
			$getDataRs = $myQuery->query($getData,'SELECT','NAME');
		
		/*$test=$myQuery->query("select tarikh from dwaris");
		print_r($test);
		echo '<br>';
		echo oracleDateToYMD($test[1][0]);*/
		
	}//end if pre process SELECT
	
	//============== SHARED ITEMS ================
	unset($itemsArr);
	if($componentArr[$x]['COMPONENTTYPE'] == 'form_1_col' || 
		$componentArr[$x]['COMPONENTTYPE'] == 'form_2_col' || 
		$componentArr[$x]['COMPONENTTYPE'] == 'flatfile_view' ||
		$componentArr[$x]['COMPONENTTYPE'] == 'tabular' || 
		$componentArr[$x]['COMPONENTTYPE'] == 'report') 
	{ 
		//if page wrapper 1 column / page wrapper 2 column
		if($componentArr[$x]['COMPONENTTYPE'] == 'form_1_col' || $componentArr[$x]['COMPONENTTYPE'] == 'form_2_col')
		{	
			//get hidden item
			$itemsArrHidden = $myQuery->query("select c.*
												from FLC_PAGE a, FLC_PAGE_COMPONENT b, FLC_PAGE_COMPONENT_ITEMS c 
												where a.PAGEID = b.PAGEID 
												and b.COMPONENTID = c.COMPONENTID 
												and a.MENUID = ".$_GET['menuID']." 
												and c.COMPONENTID = ".$componentArr[$x]['COMPONENTID']." 
												and c.ITEMSTATUS = 1 
												and c.ITEMTYPE = 'hidden' 
												order by c.ITEMORDER",'SELECT','NAME');
			
			//get other than hidden item									
			$itemsArr = $myQuery->query("select c.*
												from FLC_PAGE a, FLC_PAGE_COMPONENT b, FLC_PAGE_COMPONENT_ITEMS c 
												where a.PAGEID = b.PAGEID 
												and b.COMPONENTID = c.COMPONENTID 
												and a.MENUID = ".$_GET['menuID']." 
												and c.COMPONENTID = ".$componentArr[$x]['COMPONENTID']." 
												and c.ITEMSTATUS = 1 
												and c.ITEMTYPE != 'hidden' 
												order by c.ITEMORDER",'SELECT','NAME');
		}
		else if($componentArr[$x]['COMPONENTTYPE'] == 'tabular' || $componentArr[$x]['COMPONENTTYPE'] == 'report')
		{
			//get component items
			$itemsArr = $myQuery->query("select c.*
									from FLC_PAGE a, FLC_PAGE_COMPONENT b, FLC_PAGE_COMPONENT_ITEMS c 
									where a.PAGEID = b.PAGEID 
									and b.COMPONENTID = c.COMPONENTID 
									and a.MENUID = ".$_GET['menuID']." 
									and c.ITEMSTATUS = 1 
									and c.COMPONENTID = ".$componentArr[$x]['COMPONENTID']." 
									order by c.ITEMORDER",'SELECT','NAME');
		}
		else
		{	
			//get component items
			$itemsArr = $myQuery->query("select c.*
												from FLC_PAGE a, FLC_PAGE_COMPONENT b, FLC_PAGE_COMPONENT_ITEMS c 
												where a.PAGEID = b.PAGEID 
												and b.COMPONENTID = c.COMPONENTID 
												and a.MENUID = ".$_GET['menuID']." 
												and c.COMPONENTID = ".$componentArr[$x]['COMPONENTID']." 
												and c.ITEMSTATUS = 1 
												order by c.ITEMORDER",'SELECT','NAME');
		}

		//count no of component items
		$countItem = count($itemsArr);
		
	}//========= END SHARED ITEMS ================
  	
	//============ CONTROL FIELD =================
	//component control
		/* $control = "select CONTROLID from FLC_PAGE_CONTROL
										where PAGEID = ".$pageArr[0]['PAGEID']." and COMPONENTID = ".$componentArr[$x]['COMPONENTID']."
										order by CONTROLORDER"; */
		
		//20091021
		//for public user
		if($_SESSION['public'])
			$controlExtSQL = " or b.GROUP_ID='0'";
		
		//14-10-2009 
		//update control permissions
		$control = "select a.CONTROLID 
						from FLC_PAGE_CONTROL a, FLC_PAGE_CONTROL_PERMISSIONS b
						where a.CONTROLID = b.CONTROL_ID 
						and (b.GROUP_ID in (select GROUP_ID FROM FLC_USER_GROUP_MAPPING where USER_ID = '".$_SESSION['userID']."')".$controlExtSQL.")
						and	a.PAGEID = ".$pageArr[0]['PAGEID']." and a.COMPONENTID = '".$componentArr[$x]['COMPONENTID']."'
						order by a.CONTROLORDER";								
										
		$controlArr = $myQuery->query($control);
		$controlArrCount = count($controlArr);
		
		//reset controlid for footer
		unset($controlid);
	//============ CONTROL FIELD =================
	
	//============ REQUIRED FIELD ================
	//loop on item count
	for($y=0; $y<$countItem; $y++)
	{
		//if item required true
		if($itemsArr[$y]['ITEMREQUIRED'])
		{
			$requiredItem = 'input_map_'.$componentArr[$x]['COMPONENTID'].'_'.$itemsArr[$y]['ITEMID'];	//id of item
			
			if(strtoupper($componentArr[$x]['COMPONENTTYPE'])=='TABULAR')
				$requiredItem.='[]';
			
			//if array for required item true
			if(!is_array($requiredArr))
			{
				$requiredArr[0]['item'] = $requiredItem;				//set 1st item in array
				$requiredArr[0]['name'] = $itemsArr[$y]['ITEMNAME'];	//set 1st name in array
			}
			else
			{
				$requiredArrCount=count($requiredArr);		//count array required item
				
				$requiredArr[$requiredArrCount]['item'] = $requiredItem;				//set item at last array
				$requiredArr[$requiredArrCount]['name'] = $itemsArr[$y]['ITEMNAME'];	//set name at last array
			}
		}//eof if	
	}//eof for
	//========= END REQUIRED FIELD ===============
	
	//if type is custom, include the page
	if($componentArr[$x]['COMPONENTTYPE'] == 'custom')
		if(is_file($componentArr[$x]['COMPONENTPATH']))
			include($componentArr[$x]['COMPONENTPATH']);
		else
			echo 'File: '.$componentArr[$x]['COMPONENTPATH'].' for '.$componentArr[$x]['COMPONENTNAME'].' (Custom Component) not exist';
	
  	//include page wrapper 1 column
	include('page_wrapper_1_col.php');
  	
  	//include page wrapper 1 column
  	include('page_wrapper_2_col.php');
	
	//if type is FLATFILE VIEWER based
	 if($componentArr[$x]['COMPONENTTYPE'] == 'flatfile_view') { ?>
  <!-- ============================================================ FLATFILE VIEWER BASED BLOCK ============================================================ -->
  <?php 
  	//primary key
	$getPrimaryKeyRs = $mySQL->listPrimaryKey($componentArr[$x]['COMPONENTBINDINGSOURCE']);
	
	//get upload path
	$getUploadPath = "select ".$componentArr[$x]['COMPONENTUPLOADCOLUMN']." 
						from ".$componentArr[$x]['COMPONENTBINDINGSOURCE']." 
						where ".$getPrimaryKeyRs[0]['COLUMN_NAME']." = '".$_POST['PREV_PRIMARY_VALUE']."'";
	$getUploadPathRs = $myQuery->query($getUploadPath,'SELECT','NAME');

	//start reading uploaded file 	
	$theStringArr = readFixedLength($getUploadPathRs[0][$componentArr[$x]['COMPONENTUPLOADCOLUMN']],$componentArr[$x]['COMPONENTFLATFILEFIXEDLENGTH']);
	
	$countTheStringArr = count($theStringArr);				//count the number of records
	$countTheStringArrColumn = count($theStringArr[1]);		//count the number of columns

?>
  <table width="100%" border="0" cellspacing="0" cellpadding="3" id="tableContent">
    <tr>
      <th colspan="<?php echo $countItem; ?>"><?php echo $componentArr[$x]['COMPONENTNAME']?></th>
    </tr>
    <tr>
      <?php for($a=0; $a < $countItem; $a++) {?>
      <td class="listingHead"><?php echo $itemsArr[$a]["ITEMNAME"]?></td>
      <?php } ?>
    </tr>
    <?php for($b=1; $b <= $countTheStringArr; $b++) { ?>
    <tr>
      <?php for($c=0; $c < $countTheStringArrColumn; $c++) { ?>
      <td class="listingContent"><?php echo $theStringArr[$b][$c]?>&nbsp;</td>
      <?php }//end c ?>
    </tr>
    <?php }//end b?>
  </table>
  <!-- ========================================================== END FLATFILE VIEWER BASED BLOCK ========================================================== -->
  <?php }//end FLATFILE VIEWER based
	
	//if type is SEARCH CONSTRAINT based
	 if($componentArr[$x]['COMPONENTTYPE'] == 'search_constraint') { 
	 
		//get list of constraints
		$getConstraint = convertDBSafeToQuery(convertToDBQry($componentArr[$x]['COMPONENTTYPEQUERY']));
		$getConstraintRs = $myQuery->query($getConstraint,'SELECT','NAME');
		$countGetConstraint = count($getConstraintRs);
		
		//if filtering button is clicked
		if($_POST['filterButton'])
		{
			//check if column contains space, wrap with quotes " "
			if(trim(stripos($_POST['constraintColumn'],' ')))
				$_POST['constraintColumn'] = '[QD]'.$_POST['constraintColumn'].'[QD]';
			
			//create sql to append to master component
			$sqlToAppend = " where upper(".$_POST['constraintColumn'].") like upper('%".$_POST['constraintValue']."%')";
		}
		
		//-------------------
		//KLN SPECIFIC BLOCK
		//-------------------
		//get menu root
		$getMenuRoot = $myQuery->query('select MENUROOT from FLC_MENU where MENUID = '.$_GET['menuID'],'SELECT','NAME');
		$menuRoot = $getMenuRoot[0]['MENUROOT'];
		
		//get menu root name
		$getMenuRootName = $myQuery->query('select MENUNAME from FLC_MENU where MENUID = '.$menuRoot,'SELECT','NAME');
		$menuRootName = $getMenuRootName[0]['MENUNAME'];
		
		//if parent menu is candidature
		if(ereg($menuRootName,'CIS'))
		{
			$carianStr = "Search";
			$batalStr = "Cancel";
		}
		else
		{
			$carianStr = "Carian";
			$batalStr = "Batal";
		}	
		//-----------------------
		//END KLN SPECIFIC BLOCK
		//-----------------------	
		
	 ?>


  <!-- =============================================================== SEARCH CONSTRAINT BASED BLOCK =============================================================== -->
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
    <tr>
      <th colspan="2"><?php echo $componentArr[$x]['COMPONENTNAME'];//here ?><?php echo convertPostToHidden($_POST,'input_map',$_GET['menuID'],$myQuery)?></th>
    </tr>
    <tr>
      <td width="150" class="inputLabel">Jenis Carian : </td>
      <td class="inputArea"><select name="constraintColumn" class="inputList" id="constraintColumn">
          <?php for($y=0; $y < $countGetConstraint; $y++) { ?>
          <option value="<?php echo $getConstraintRs[$y]["FLC_ID"]?>" <?php if(str_replace('[QS]','',str_replace('[QD]','',$_POST['constraintColumn'])) == $getConstraintRs[$y]["FLC_ID"]) echo 'selected';?>><?php echo $getConstraintRs[$y]["FLC_NAME"]?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td width="150" class="inputLabel">Carian : </td>
      <td class="inputArea"><input name="constraintValue" type="text" class="inputInput" id="constraintValue" size="30"  value="<?php echo $_POST['constraintValue']?>" /></td>
    </tr>
    <tr>
      <td colspan="2" class="contentButtonFooter" align="right">
        <input name="filterButton" type="submit" class="inputButton" id="filterButton" value="<?php echo $carianStr?>" />
        <input name="cancelFilterButton" type="reset" class="inputButton" value="<?php echo $batalStr?>" /></td>
    </tr>
  </table>
  <br />
  <!-- ============================================================= END SEARCH CONSTRAINT BASED BLOCK ============================================================= -->
  <?php }//end type is QUERY based
	
	//if type is QUERY based
	 if($componentArr[$x]['COMPONENTTYPE'] == 'query') { ?>
  <!-- =============================================================== QUERY 1 COLUMN BASED BLOCK =============================================================== -->
  <?php include('page_wrapper_query.php');?>
  <!-- ============================================================= END QUERY 1 COLUMN BASED BLOCK ============================================================= -->
  <?php }//end type is QUERY based

	//if type is QUERY based
	 if($componentArr[$x]['COMPONENTTYPE'] == 'query_2_col') { ?>
  <!-- =============================================================== QUERY 2 COLUMN BASED BLOCK =============================================================== -->
  <?php include('page_wrapper_query_2_col.php');?>
  <!-- ============================================================= END QUERY 2 COLUMN BASED BLOCK ============================================================= -->
  <?php }//end type is QUERY based

	//if type is TABULAR or REPORT based
	if($componentArr[$x]['COMPONENTTYPE'] == 'tabular' || $componentArr[$x]['COMPONENTTYPE'] == 'report') { ?>
  <!-- ============================================================ TABULAR/REPORT BASED BLOCK ============================================================ -->
  <?php include('page_wrapper_table_based.php');?>
  <!-- ========================================================== END TABULAR/REPORT BASED BLOCK ========================================================== -->
  <?php }//end TABULAR based
  
  //if type is WEBSERVICE based
	if($componentArr[$x]['COMPONENTTYPE'] == 'webservice') { ?>
  <!-- ============================================================ WEBSERVICE BLOCK ============================================================ -->
  <?php include('page_wrapper_webservice.php');?>
  <!-- ========================================================== END WEBSERVICE BLOCK ========================================================== -->
  <?php }//end WEBSERVICE based
  
    //if type is GRAPH based
	if($componentArr[$x]['COMPONENTTYPE'] == 'graph') { ?>
  <!-- ============================================================ GRAPH BLOCK ============================================================ -->
  <?php include('page_wrapper_graph.php');?>
  <!-- ========================================================== END GRAPH BLOCK ========================================================== -->
  <?php }//end GRAPH based
	//if type is CALENDAR based
	if($componentArr[$x]['COMPONENTTYPE'] == 'calendar') { ?>
  <!-- ============================================================ CALENDAR BLOCK ============================================================ -->
  <?php include('page_wrapper_calendar.php');?>
  <!-- ========================================================== END CALENDAR BLOCK ========================================================== -->
  <?php }//end CALENDAR based
  
  	//if type is spreadsheet based
	if($componentArr[$x]['COMPONENTTYPE'] == 'loading') { ?>
  <!-- ============================================================ CALENDAR BLOCK ============================================================ -->
  <?php include('page_wrapper_loading.php');?>
  <!-- ========================================================== END CALENDAR BLOCK ========================================================== -->
  <?php }//end spreadsheet based
  
}//end for x
?>
  <!-- =============================================================== PAGE CONTROL =============================================================== -->
<?php
//if have apge
if($pageArr)
{
	//check if page control is configured for the selected page
   /* $controlCheck = "select CONTROLID 
							from FLC_PAGE_CONTROL
							where PAGEID = ".$pageArr[0]['PAGEID']." and (COMPONENTID is null or COMPONENTID = '0')
							order by CONTROLORDER"; */
							
	//20091021 - fais
	//if public
	if($_SESSION['public'])
			$controlCheckExtSQL = " or b.GROUP_ID='0'";
		
	//14-10-2009 
	//check if page control is configured for the selected page and user group
	$controlCheck = "select a.CONTROLID 
							from FLC_PAGE_CONTROL a, FLC_PAGE_CONTROL_PERMISSIONS b
							where a.CONTROLID = b.CONTROL_ID 
							and (b.GROUP_ID in (select GROUP_ID FROM FLC_USER_GROUP_MAPPING where USER_ID = '".$_SESSION['userID']."')".$controlCheckExtSQL.")
							and a.PAGEID = ".$pageArr[0]['PAGEID']." and (a.COMPONENTID is null or a.COMPONENTID = '0')
							order by a.CONTROLORDER";
							
	$controlCheckRs = $myQuery->query($controlCheck);
	$controlCheckRsCount = count($controlCheckRs);

	unset($controlid);
	//if theres page control associated with the page
	if($controlCheckRsCount > 0)
	{ 
		for($y=0;$y<$controlCheckRsCount;$y++)
		{$controlid[] = $controlCheckRs[$y][0];}
	?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
    <tr>
      <td colspan="2" class="footer"><?php buildControl($myQuery,$controlid,$requiredArr);?></td>
    </tr>
  </table>
  <?php 
  }//eof if 
}//eof if?>
  <!-- =============================================================== END PAGE CONTROL =============================================================== -->
</form>
