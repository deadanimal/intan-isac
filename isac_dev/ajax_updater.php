<?php 	
/*if($_GET['menuID']) 
{ 	
	//check for ajax periodical updater component items
	$checkAjaxPeriodical = "select COMPONENTNAME, b.COMPONENTID, b.COMPONENTTYPE, 
											b.COMPONENTBINDINGSOURCE, b.COMPONENTBINDINGTYPE, c.*
											from FLC_PAGE a, FLC_PAGE_COMPONENT b, FLC_PAGE_COMPONENT_ITEMS c
											where a.PAGEID = b.PAGEID 
											and b.COMPONENTID = c.COMPONENTID
											and a.MENUID = ".$_GET["menuID"]." 
											and b.COMPONENTSTATUS = 1 
											and c.ITEMTYPE = 'ajax_updater'
											order by b.COMPONENTORDER";
	
	$checkAjaxPeriodicalRs = $myQuery->query($checkAjaxPeriodical,'SELECT','NAME');
	$countCheckAjaxPeriodical = count($checkAjaxPeriodicalRs);
	
	if($countCheckAjaxPeriodical > 0)
	{ //echo 'aaaaaaaaa';
		for($x=0; $x < $countCheckAjaxPeriodical; $x++)
		{	$updaterName = 'ajax_updater_'.$checkAjaxPeriodicalRs[$x]['COMPONENTID'].'_'.$checkAjaxPeriodicalRs[$x]['ITEMID'];
		?>
		<script language="javascript">
		function hehe(updaterName,itemid)
		{
			new Ajax.Updater(updaterName, 'ajax_updater_wrapper.php?itemid='+itemid);
		}
		//new Ajax.PeriodicalUpdater('<?php //echo $updaterName;?>', 'ajax_updater_wrapper.php?itemid=<?php //echo $checkAjaxPeriodicalRs[$x]['ITEMID'];?>', {asynchronous:true, frequency:3, decay:2 });
		//window.setInterval('window.alert("zzzzz")',2000);
		window.setInterval('hehe("<?php echo $updaterName;?>",<?php echo $checkAjaxPeriodicalRs[$x]['ITEMID'];?>)',1000);
		
		//new Ajax.Updater('<?php //echo $updaterName;?>', 'ajax_updater_wrapper.php?itemid=<?php //echo $checkAjaxPeriodicalRs[$x]['ITEMID'];?>');
		</script>
		<?php
		}
	}//end if
}
*/
if($_GET['type'] == 'toggleBanner')
{	
	include('system_prerequisite.php');						//include stuff needed for session, database connection, and stuff
	
	if($_SESSION['bannerShow'] == true)
		$_SESSION['bannerShow'] = false;
	else if($_SESSION['bannerShow'] == false)
		$_SESSION['bannerShow'] = true;
		
	include('views/index_header.php');
}
?>
