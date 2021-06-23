<?php 
//use of class TableGrid
//==================== DECLARATION =======================
$tg=new TableGrid('99%',0,0,0);						//set object for table class (width,border,celspacing,cellpadding)

//set attribute of table
$tg->setAttribute('id','tableContent');					//set id
$tg->setHeader($componentArr[$x]['COMPONENTNAME']);		//set header
$tg->setKeysStatus(true);								//use of keys (column header)
$tg->setKeysAttribute('class','listingHead');			//set class
$tg->setRunningStatus(true);							//set status of running number
$tg->setRunningKeys('No');								//key / label for running number

//set attribute of column in table
$col = new Column();									//set object for column
$col->setAttribute('class','listingContent');			//set attribute for table
$tg->setColumn($col);									//insert/set class column into table

//clear previous data in array
if(isset($data))unset($data);							//unset all data
if(isset($keysLabel))unset($keysLabel);					//unset aggregation
if(isset($aggArr))unset($aggArr);						//unset aggregation
if(isset($hiddenData))unset($hiddenData);				//unset hidden data

//initialize variable
$dataCount=$componentArr[$x]['COMPONENTABULARDEFAULTROWNO'];	//set count of data as 0
//================== END DECLARATION =====================

?>
<!--<script language="javascript">
if (parseInt(navigator.appVersion)>3) {
 if (navigator.appName=="Netscape") {
  winW = window.innerWidth;
 }
 if (navigator.appName.indexOf("Microsoft")!=-1) {
  winW = document.body.offsetWidth;
 }
}
</script>-->

<!--<div style="width: winW+<?php echo $_SESSION['leftMenuSize']-1000;?>px; overflow:auto;">-->
<?php
//====================== PROCESS =========================
//if type is TABULAR based
if($componentArr[$x]['COMPONENTTYPE'] == 'tabular') { ?>
<!-- ============================================================ TABULAR BASED BLOCK ============================================================ -->
<?php include('page_wrapper_tabular.php'); ?>
<!-- ========================================================== END TABULAR BASED BLOCK ========================================================== -->
<?php }//end TABULAR based

//if type is REPORT based
if($componentArr[$x]['COMPONENTTYPE'] == 'report') { ?>
<!-- ============================================================= REPORT BASED BLOCK ============================================================ -->
<?php include('page_wrapper_report.php'); ?>
<!-- =========================================================== END REPORT BASED BLOCK ========================================================== -->
<?php }//end type is REPORT based
//==================== END PROCESS =======================
?>
<br>
<!--</div>-->