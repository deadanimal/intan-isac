<?php 
include('system_prerequisite.php');
require_once('engine_elem_builder.php');

if($_GET['itemid'])
{
	$itemsArr = $myQuery->query("select * from FLC_PAGE_COMPONENT_ITEMS where itemid='".$_GET['itemid']."'",'SELECT','NAME');
	
	echo buildInput($myQuery,$dbc,$itemsArr[0]["ITEMINPUTLENGTH"],
											'ajax_updater_subsequent',$itemsArr[0]["ITEMDEFAULTVALUE"],$itemsArr[0]["ITEMDEFAULTVALUEQUERY"],
											$itemsArr[0]["ITEMLOOKUP"],$itemsArr[0]["ITEMLOOKUPSECONDARY"],$itemsArr[0]["ITEMID"],$itemsArr[0]["MAPPINGID"],'','',
											$itemsArr[0]["ITEMJAVASCRIPTEVENT"],$itemsArr[0]["ITEMJAVASCRIPT"],$itemsArr[0]["ITEMNAME"],
											$itemsArr[0]["ITEMTABINDEX"],$itemsArr[0]["ITEMID"],$itemsArr[0]["ITEMMINCHAR"],$itemsArr[0]["ITEMMAXCHAR"],
											$itemsArr[0]["ITEMTEXTAREAROWS"],$itemsArr[0]["ITEMREQUIRED"],$itemsArr[0]['COMPONENTID'],0,
											$itemsArr[0]['ITEMTEXTALIGN']);
}//eof if
?>