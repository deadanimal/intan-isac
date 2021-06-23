<div id="breadcrumbs">Utama / My Dashboard / </div>
<h1><?php //echo getDashboardInfo($myQuery,$_GET['dashid'])?></h1>
<?php 

//13-10-2009
//- add permission to dashboard item
//- new table flc_dashboard_permissions (DASHITEM_ID,GROUP_ID,ADDED_BY,ADDED_DATE)
//14-10-2009
//- add $garphid to flc_graph function
//get dashboard info
function getDashboardInfo($myQuery,$dashID)
{
	$sql = "select DASH_NAME from FLC_DASHBOARD
			where DASH_ID = ".$dashID;
	$sqlRs = $myQuery->query($sql,'SELECT','NAME');

	return $sqlRs[0]['DASH_NAME'];
}

//to get list of dashboard items
function getDashboardItems($myQuery,$dashID)
{
	$sql = "select * from FLC_DASHBOARD a, FLC_DASHBOARD_ITEMS b, FLC_DASHBOARD_PERMISSIONS c
			where a.DASH_ID = b.DASH_ID
			and b.DASHITEM_ID = c.DASHITEM_ID
			and a.DASH_ID = ".$dashID." 
			and c.GROUP_ID in (select GROUP_ID FROM FLC_USER_GROUP_MAPPING where USER_ID = '".$_SESSION['userID']."')
			and b.DASHITEM_STATUS = 1
			order by b.DASHITEM_ORDER";
	return $sqlRs = $myQuery->query($sql,'SELECT','NAME');
}

//create listing based on component id
function createListing($myQuery,$srcText,$type,$title='',$width='',$height='')
{
	require_once('class/Table.php');				//class Table
	require_once('class/Field.php');				//class Field
	
	
	if($type == 'componentid')
	{
		//get component		
		$componentArr = $myQuery->query("select COMPONENTNAME, b.COMPONENTID, b.COMPONENTTYPE, b.COMPONENTABULARDEFAULTROWNO, b.COMPONENTTYPEQUERY, 
													b.COMPONENTBINDINGSOURCE, b.COMPONENTUPLOADCOLUMN, b.COMPONENTFLATFILEFIXEDLENGTH, 
													b.COMPONENTPREPROCESS, b.COMPONENTPOSTPROCESS, b.COMPONENTBINDINGTYPE, b.COMPONENTADDROW, 
													b.COMPONENTQUERYUNLIMITED, b.COMPONENTADDROWJAVASCRIPT, b.COMPONENTDELETEROWJAVASCRIPT
													from FLC_PAGE_COMPONENT b 
													where b.componentid = ".$srcText." 
													and b.COMPONENTSTATUS = 1 
													order by b.COMPONENTORDER",'SELECT','NAME');
		$componentCount = count($componentArr);
	
		if($componentCount > 0)
		{
			//echo '<div style="width:'.$width.'px; float:left; margin-left:10px; margin-right:10px; margin-bottom:10px; ">';
			echo '<div style="width:'.$width.'px; float:left; margin-left:10px; padding-right:10px; padding-bottom:10px; overflow:auto; ">';
	
			$x = 0;
			include('page_wrapper_table_based.php');
			
			echo '</div>';
		}
	}
	
	else if($type == 'sql')
	{
		$componentArr[0]['COMPONENTNAME'] = $title;
		$componentArr[0]['COMPONENTTYPE'] = 'report';
		$componentArr[0]['COMPONENTTYPEQUERY'] = $srcText;
		$componentCount = count($componentArr);
		
		if($componentCount > 0)
		{
			//echo '<div style="width:'.$width.'px; float:left; margin-left:10px; margin-right:10px; margin-bottom:10px; ">';
			echo '<div style="width:'.$width.'px; float:left; border:1px solid #cccccc; margin-left:5px; padding-right:10px; padding-bottom:3px; overflow:auto; ">';
						
			$x = 0;
			include('page_wrapper_table_based.php');
		
			echo '</div>';
		}
	}
	
	
}

//FUNCTION NAME: FLC_GRAPH
//AUTHOR: CIKKIM
//DESCRIPTION: to create graph based on PEAR Image_Graph library
function flc_graph($myQuery,$propArr,$graphid)
{
	//**************
	//INCLUDE FILES
	//**************
	//check for required files
	$checkFilesOk = true;						//initial value
	
	//if(include('Image/Grsaph.php'))
		//$checkFilesOk = true;
	
	//echo $checkFilesOk;
	
	include_once 'Image/Graph.php';						//main class
	include_once 'Image/Graph/Legend.php';				//legend class
	include_once 'Image/Graph/Layout/Vertical.php';
	include_once 'Image/Graph/Plotarea.php';
	
	if($checkFilesOk == true)
	{
		//*****************
		//CHART PROPERTIES
		//*****************
		$chartWidth = $propArr['width'];
		$chartHeight = $propArr['height'];
		$chartType = $propArr['type'];							//line/area/bar/pie/radar/step/impulse/dot/scatter/smooth_line/smooth_area
		$legendType = 'top-right';								//top-right, bottom 
		$showLegend = $propArr['showLegend'];
		$showAxis = $propArr['showAxis'];
		$backgroundColor = $propArr['bgcolor'];
		$outputFormat = $propArr['outputFormat'];					//gd/jpg/png/svg
		$outputTo = 'url';
		
		//GRAPH TITLE
		$graphTitle = $propArr['name'];	
		$graphTitleColor = $propArr['titleColor'];
		$graphTitleSize = $propArr['titleSize'];				//in pixel
		$graphTitleAngle = $propArr['titleAngle'];				//in degree
		
		//GRAPH DATA
		$dataArr = explode('[GRAPH_LABEL]',$propArr['data']);
		$valueArr = $myQuery->query(str_replace('[GRAPH_VALUE]','',$dataArr[0]),'SELECT','INDEX');
		$labelArr = $myQuery->query(str_replace('[GRAPH_LABEL]','',$dataArr[1]),'SELECT','INDEX');

		$valueArr = $valueArr[0];
		$labelArr = $labelArr[0];
		
		$Graph =& Image_Graph::factory('graph', array(
													array('width' => $chartWidth,
															'height' => $chartHeight, 
															'canvas' => $outputFormat
														)));
		$Plotarea =& $Graph->addNew('plotarea');
		
		//$Axis =& Image_Graph::factory('axis');
		//$axis =& $Graph->addNew('axis');
		//$axis->showArrow(true);
		//$Plotarea->showArrow(true);
		
		
		//********************
		//GRAPH TITLE OPTIONS
		//********************
		
		//create font object for title
		$titleFont =& Image_Graph::factory('font', array('c:\windows\fonts\verdana.ttf'));
		$titleFont->setColor($graphTitleColor);
		$titleFont->setSize($graphTitleSize);					//in pixels
		$titleFont->setAngle($graphTitleAngle);					//the angle in degress to slope the text
		
		//add the title to graph
		$Graph->addNew('title',array($graphTitle,$titleFont));
		
		
		
		//$Legend->setAlignment(IMAGE_GRAPH_ALIGN_BOTTOM + ALIGN_LEFT);
		
		//$Legend->setShowMarker(false);
		
		
		
		//-----------
		//for legend
		//-----------
		if($showLegend == true)
		{
			if($legendType == 'top-right')
			{
				$Legend =& $Plotarea->addNew('legend');
			}
			else if($legendType == 'bottom')
			{
				$Graph->add(
						 new Image_Graph_Layout_Vertical(
							 $PlotArea = new Image_Graph_Plotarea(),
							 new Image_Graph_Layout_Horizontal(
								 new Image_Graph_Plotarea(),
								 new Image_Graph_Layout_Vertical(
									 new Image_Graph_Plotarea(),
									 $Legend = new Image_Graph_Legend()
								)
							)
						)            
				);
				$Legend->setPlotArea($Plotarea);
			}
		}
		
	 
		
		
		
		//the dataset
		$Dataset =& Image_Graph::factory('dataset');
		
		//the data
		for($x=0; $x < count($labelArr); $x++)
		{
			$Dataset->addPoint($labelArr[$x],$valueArr[$x]);
		}
		
		
		// create the plot as pie chart using the dataset
		
		
		//show axis or not
		if($showAxis == false)
			$Plotarea->hideAxis();
		
		
		
		
		
		//bar, pie, line
		$Plot =& $Plotarea->addNew($chartType, &$Dataset);
		
		$Plot->setLineColor('#000000');
		$Plot->setBackgroundColor($backgroundColor.'@0.1');
		//$Plot->setBackgroundColor('green@0.1');			//with opacity
		
		//*******************
		//GRAPH FILL OPTIONS
		//*******************
		
		//fill type
		$fillType = 'array';			//array,gradient,image
		
		
		//if fill with array
		if($fillType == 'array')
		{
			//load the class
			$fill =& Image_Graph::factory('Image_Graph_Fill_Array');
			
			//list of available colors
			$colorList = array('J' => '#e0e0e0', 
								'F' => '#cccccc', 
								'M' => '#999999',
								'H' => '#666666'
								);
			
			//load the color
			foreach ($colorList as $x => $val) 
			{	
				//add the color
				$fill->addColor($val, $x);				//color,id
			}
		}
		
		else if($fillType == 'gradient')
		{
			//DIRECTION
			//Vertically (IMAGE_GRAPH_GRAD_VERTICAL)
			//Horizontally (IMAGE_GRAPH_GRAD_HORIZONTAL)
			//Mirrored vertically (the color grades from a- b-a vertically) (IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED)
			//Mirrored horizontally (the color grades from a-b-a horizontally) IMAGE_GRAPH_GRAD_HORIZONTAL_MIRRORED
			//Diagonally from top-left to right-bottom (IMAGE_GRAPH_GRAD_DIAGONALLY_TL_BR)
			//Diagonally from bottom-left to top-right (IMAGE_GRAPH_GRAD_DIAGONALLY_BL_TR)
			//Radially (concentric circles in the center) (IMAGE_GRAPH_GRAD_RADIAL)
		
			//direction, startcolor, endcolor
			$fill =& Image_Graph::factory('Image_Graph_Fill_Gradient',array(IMAGE_GRAPH_GRAD_HORIZONTAL,'#e0e0e0','#cccccc'));
		}
		else if($fillType == 'image')
		{
			$fill =& Image_Graph::factory('Image_Graph_Fill_Image',('img/header_login.jpg'));
		
		}
		
		$Plot->setFillStyle($fill);
		
		
		
		//*********************
		//GRAPH OUTPUT OPTIONS
		//*********************
		
		//return directly to canvas
		if($outputTo == 'direct')
			$Graph->done();
		
		//save graph as image
		if($outputTo == 'image')
			$Graph->done(array('filename' => 'graph/gfgfgf.png'));
		
		//save graph as image, return the url
		if($outputTo == 'url')
			
			echo $Graph->done(array('tohtml' => true,'filename' => $_SESSION['userID'].'-'.$graphid.'-'.'graphla.png','filepath' => 'graph/','urlpath' => 'graph/'));
	}
}

//if dashid is set
if($_GET['dashid'])
{
	//get list of dashboard items
	$dashItemRs = getDashboardItems($myQuery,$_GET['dashid']);
	
	//for all dashboard items, create!
	for($a=0; $a < count($dashItemRs); $a++)
	{
		//if listing
		if($dashItemRs[$a]['DASHITEM_TYPE'] == 'listing')
		{
			//check data source type
			if($dashItemRs[$a]['DASHITEM_DATA_SOURCE_TYPE'] == 'componentid')
				createListing($myQuery,$dashItemRs[$a]['DASHITEM_DATA_SOURCE_TEXT'],'componentid',$dashItemRs[$a]['DASHITEM_WIDTH'],$dashItemRs[$a]['DASHITEM_HEIGHT']);
			
			else if($dashItemRs[$a]['DASHITEM_DATA_SOURCE_TYPE'] == 'sql')
				createListing($myQuery,convertDBSafeToQuery(convertToDBQry($dashItemRs[$a]['DASHITEM_DATA_SOURCE_TEXT'])),'sql',$dashItemRs[$a]['DASHITEM_ITEM_NAME'],$dashItemRs[$a]['DASHITEM_WIDTH'],$dashItemRs[$a]['DASHITEM_HEIGHT']);
		
			//echo '<br>';
		}
		
		//if graph
		else if($dashItemRs[$a]['DASHITEM_TYPE'] == 'graph')
		{
			//graph properties
			$graf_id = $dashItemRs[$a]['DASHITEM_ID'];
			$propertiesArr = array(	'name' => $dashItemRs[$a]['DASHITEM_ITEM_NAME'],
									'width' => $dashItemRs[$a]['DASHITEM_WIDTH'],
									'height' => $dashItemRs[$a]['DASHITEM_HEIGHT'],
									'type' => $dashItemRs[$a]['DASHITEM_GRAPH_TYPE'],
									'showLegend' => $dashItemRs[$a]['DASHITEM_SHOW_LEGEND'],
									'showAxis' => $dashItemRs[$a]['DASHITEM_SHOW_AXIS'],
									'bgcolor' => $dashItemRs[$a]['DASHITEM_BACKGROUND_COLOR'],
									'outputFormat' => $dashItemRs[$a]['DASHITEM_OUTPUT_FORMAT'],
									'titleColor' => $dashItemRs[$a]['DASHITEM_GRAPH_TITLE_COLOR'],
									'titleSize' => $dashItemRs[$a]['DASHITEM_GRAPH_TITLE_SIZE'],
									'titleAngle' => $dashItemRs[$a]['DASHITEM_GRAPH_TITLE_ANGLE'],
									'data' => convertDBSafeToQuery(convertToDBQry($dashItemRs[$a]['DASHITEM_DATA_SOURCE_TEXT']))
									);	
			//generate graph
			echo '<div style="width:'.$width.'px; float:left; padding:10px; border:1px solid #000000; margin:5px;">';
			flc_graph($myQuery,$propertiesArr,$graf_id);
			echo '</div>';
		}
	} 
}


?>
