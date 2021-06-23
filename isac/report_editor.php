<?php
//include class Table
require_once('class/Table.php');				//class Table

if($_POST['insertReport']){

$reportid = $_POST['report_id'];
$reportname = $_POST['report_name'];
$reporttitle = $_POST['report_title'];
$reportdesc = $_POST['report_desc'];
$reportstatus = $_POST['report_status'];
//$reportparent = $_POST[''];
$reportsql = $_POST['report_sql'];
$reportheader = $_POST['report_header'];
$customheader = $_POST['custom_header'];
$reportgroup1 = str_replace(' ','',$_POST['report_group1']);
$reportgroup2 = $_POST['report_group2'];
$reportformula = $_POST['report_formula'];
$reporttotal = $_POST['report_total'];
//$reportlevel = $_POST[''];


	//update report
	if($_POST['report_id']){
		
		 $queryUpdate = "update FLC_REPORT set REPORTNAME = '$reportname' , REPORTDESCRIPTION = '$reportdesc' ,REPORTTITLE = '$reporttitle', REPORTSQL = '$reportsql', REPORTHEADER = '$reportheader',CUSTOMHEADER = '$customheader', REPORTGROUP1 = '$reportgroup1', REPORTGROUP2 = '$reportgroup2', REPORTFORMULA = '$reportformula', REPORTTOTAL = '$reporttotal' WHERE REPORTID = '$reportid' ";
		$resultUpdate = $myQuery->query($queryUpdate,'RUN');
		
		if($resultUpdate){
			$message='Report successfully updated.';
		}
		
	}
	
	//insert report
	else{
	
		$queryInsert= "insert into FLC_REPORT (REPORTNAME,REPORTTITLE,REPORTDESCRIPTION,REPORTSTATUS,REPORTSQL,REPORTHEADER,CUSTOMHEADER,REPORTGROUP1,REPORTGROUP2,REPORTFORMULA,REPORTTOTAL)
		values ('$reportname','$reporttitle','$reportdesc','$reportstatus','$reportsql','$reportheader','$customheader','$reportgroup1','$reportgroup2','$reportformula','$reporttotal')";
		$resultInsert = $myQuery->query($queryInsert,'RUN');
		
		if($resultInsert){
			$message='Report successfully inserted.';
		}
	}
}


//====================================== display =============================================
//if edit
if($_POST['edit'])
{
	
	$queryReport = "select * from FLC_REPORT where reportid = ".$_POST['reportid'];
	$resultReport = $myQuery->query($queryReport,'SELECT','NAME');
	
	$reportid = $resultReport[0]['REPORTID'];
	$reportname = $resultReport[0]['REPORTNAME'];
	$reporttitle = $resultReport[0]['REPORTTITLE'];
	$reportdesc = $resultReport[0]['REPORTDESCRIPTION'];
	$reportstatus = $resultReport[0]['REPORTSTATUS'];
	$reportparent = $resultReport[0]['REPORTPARENT'];
	$reportsql = $resultReport[0]['REPORTSQL'];
	$reportlevel = $resultReport[0]['REPORTLEVEL'];
	$reportheader = $resultReport[0]['REPORTHEADER'];
	$customheader = $resultReport[0]['CUSTOMHEADER'];
	$reportgroup1 = $resultReport[0]['REPORTGROUP1'];
	$reportgroup2 = $resultReport[0]['REPORTGROUP2'];
	$report_formula = $resultReport[0]['REPORTFORMULA'];
	$report_total = $resultReport[0]['REPORTTOTAL'];

}//eof if
//==================================== eof display ===========================================

//==================================== manipulation ==========================================
//if blparameter is sent
if(is_array($_POST['blparameter']))
{
	//count parameter
	$blParameterCount=count($_POST['blparameter']);
	
	//loop on count of blparameter
	for($x=0;$x<$blParameterCount;$x++)
	{
		//if bl parameter not set or bl parametertype not set
		if(!$_POST['blparameter'][$x]||!$_POST['blparametertype'][$x])
		{
			unset($_POST['blparameter'][$x]);
			unset($_POST['blparametertype'][$x]);
		}//eof if
	}//eof for
}//eof if

//insert/update => check if blname exist
if($_POST['insert']||$_POST['update'])
{
	//select same blname where status active
	$chkExist = $dal->select("select blname from FLC_BL where blname='".strtoupper($_POST['blname'])."' and blid!='".$_POST['blid']."' and blstatus='00'");
	$chkExistRs = $chkExist[0][0];
}//eof if

//if insert
if($_POST['insert'])
{
	//if blname not exist
	if(!$chkExistRs)
	{
		//insert bl
		$insert=$dal->insert("FLC_BL","blid=(".$mySQL->maxValue('FLC_BL','blid',0)."+1)","blname='".strtoupper($_POST['blname'])."'","bltitle='".$_POST['bltitle']."'","bldescription='".$_POST['bldescription']."'",
						"bldetail='".$_POST['bldetail']."'","blparameter='".implode('|',$_POST['blparameter'])."'","blparametertype='".implode('|',$_POST['blparametertype'])."'",
						"blstatus='".$_POST['blstatus']."'","createby='".$_SESSION['userID']."'","createdate=".$mySQL->currentDate());
	}//eof if
							
	//if insert
	if($insert)
		$message='BL successfully inserted.';
	//if same name exist
	else if($chkExistRs)
	{
		$eventType='error';
		$message='BL with same name already exist. Insert fail!';
	}//eof else
}//eof if

//if update
else if($_POST['update'])
{
	//if blname not exist
	if(!$chkExistRs)
	{
		//update bl
		$update=$dal->update("FLC_BL","blname='".strtoupper($_POST['blname'])."'","bltitle='".$_POST['bltitle']."'","bldescription='".$_POST['bldescription']."'",
						"bldetail='".$_POST['bldetail']."'","blparameter='".implode('|',$_POST['blparameter'])."'","blparametertype='".implode('|',$_POST['blparametertype'])."'",
						"blstatus='".$_POST['blstatus']."'","modifyby='".$_SESSION['userID']."'","modifydate=".$mySQL->currentDate(),"?blid='".$_POST['blid']."'");
	}//eof if
	
	//if update
	if($update)
		$message='BL successfully updated.';
	//if same name exist
	else if($chkExistRs)
	{
		$eventType='error';
		$message='BL with same name already exist. Update fail!';
	}//eof else
}//eof if

//if delete
else if($_POST['delete'])
{
	//delete bl
	echo $_POST['reportid'];
	$delete=$dal->delete("FLC_REPORT","?REPORTID='".$_POST['reportid']."'");
	
	//if delete
	if($delete)
		$message='Report successfully deleted.';
}//eof if
//================================== eof manipulation ========================================

//======================================= general ============================================
//list of status
$statusList=$mySQL->status();
$statusListCount=count($statusList);

//list of bl paramter
$blparameterList=$mySQL->bl_parameter();
$blparameterListCount=count($blparameterList);

//list of bl
$blList=$mySQL->listBL($_POST['blSearch']);

//list of report
$reportList=$mySQL->listReport();


/*if($_POST['blSearch'])
	$blListExtraSql = " where upper(blname) like upper('".$_POST['blSearch']."') ";
	
$blList=$myQuery->query("select blid,bltitle from FLC_BL ".$blListExtraSql." order by bltitle");*/
//===================================== eof general ==========================================
?>
<script type="text/javascript" src="tools/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="js/editor.js"></script>
<div id="breadcrumbs">Modul Pentadbir Sistem / Report Editor/ </div>
<h1>Report Editor</h1> 

<?php if($message)showNotification($eventType,$message);	//notification?>

<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2">Report List </th>
  </tr>
  <tr>
      <td nowrap="nowrap" class="inputLabel">Report Search : </td>
      <td><input name="reportSearch" type="text" id="reportSearch" size="50" class="inputInput" value="<?php echo $_POST['reportSearch']?>" onKeyUp="ajaxUpdatePageSelector('bl','blSelectorDropdown',this.value)" /></td>
   </tr>
<tr>
 <td width="100" class="inputLabel">Report :</td>
 <td>
	<div id="reportSelectorDropdown">
	<select name="reportid" class="inputList" id="reportid" onChange="if(this.selectedIndex!=0){swapItemEnabled('edit|delete', '');}else{swapItemEnabled('', 'edit|delete');}">
		<?php echo createDropDown($reportList,$_POST['reportid']);?>
  	</select>
	</div>
  </td>
</tr>
<tr>
  <td class="contentButtonFooter" colspan="2" align="right">
    <input name="new" type="submit" class="inputButton" id="new" value="Baru" />
    <input name="edit" type="submit" class="inputButton" id="edit" value="Ubah" <?php if(!$_POST['reportid']) { ?>disabled style="color:#999999"<?php } ?>/>
    <input name="delete" type="submit" class="inputButton" id="delete" value="Buang" <?php if(!$_POST['reportid']) { ?>disabled style="color:#999999"<?php } ?> onClick="if(window.confirm('Anda pasti untuk MEMBUANG bl ini?')) {return true} else {return false}"/>
  </td>
</tr>
</table>
</form>
<br />

<?php if($_POST['new']||$_POST['edit']){?>
<form id="form1" name="form1" method="post" >
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <th colspan="2">New / Edit Report </th>
	</tr>
    
      <tr>
	  <td class="inputLabel">Report Id  : </td>
	  <td> <?php echo $reportid;?></td>
	</tr>
    
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Report Name : </td>
	  <td>
	  <input name="report_id" id="report_id" type="hidden" class="inputInput" value="<?php echo $reportid;?>" />
	  <input name="report_name" id="report_name" type="text" class="inputInput" value="<?php echo $reportname;?>" size="50" style="text-transform:uppercase;" onkeydown="trim(this)" onblur="onkeydown(this);"  /></td>
	</tr>
	<!--<tr>
	  <td class="inputLabel" nowrap="nowrap">Report Title : </td>
	  <td><input name="report_title" id="report_title" type="text" class="inputInput" value="<?php echo $reporttitle;?>" size="50" onblur="onkeydown(this);"  /></td>
	</tr>-->
      <tr>
	  <td class="inputLabel">Report Title : </td>
	  <td><textarea name="report_title" id="report_title" cols="100" rows="10" class="inputInput"><?php echo $reporttitle;?></textarea>      </td>
	</tr>
    
    
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Report Description : </td>
	  <td><textarea name="report_desc" id="report_desc" cols="50" rows="3" class="inputInput"><?php echo $reportdesc;?></textarea></td>
	</tr>
	<tr>
	  <td class="inputLabel">Status :</td>
	  <td>
          <select name="report_status" class="inputList" id="report_status">
            <?php 
			//if status not been set
			if(!isset($loading_status))
				$loading_status='00';		//set default
			
			echo createDropDown($statusList, $loading_status)?>
		  </select>	  </td>
	</tr>
	
	<tr>
	  <td class="inputLabel">SQL  : </td>
	  <td><textarea name="report_sql" id="report_sql" cols="100" rows="10" class="inputInput"><?php echo $reportsql;?></textarea></td>
	</tr>
    
    <tr>
	  <td class="inputLabel">Formula  : </td>
	  <td><input name="report_formula" id="report_formula" type="text" class="inputInput" value="<?php echo $report_formula;?>" size="50" onblur="onkeydown(this);"  /></td>
	</tr>
    
    <tr>
	  <td class="inputLabel">Total Sum :</td>
	  <td>
          <select name="report_total" class="inputList" id="report_total">
         	<option></option>
           <option <?php if($report_total == 'enable'){echo 'selected';} ?> value="enable">Enable</option>
           <option  <?php if($report_total == 'disable'){echo 'selected';} ?> value="disable">Disable</option>
         </select>  </td>
	</tr>
    
    
      <tr>
	  <td class="inputLabel">Grouping 1  : </td>
	  <td><input name="report_group1" id="report_group1" type="text" class="inputInput" value="<?php echo $reportgroup1;?>" size="50" onblur="onkeydown(this);"  /></td>
	</tr>
    
      <tr>
	  <td class="inputLabel">Grouping 2  : </td>
	  <td><input name="report_group2" id="report_group2" type="text" class="inputInput" value="<?php echo $reportgroup2;?>" size="50" onblur="onkeydown(this);"  /></td>
	</tr>
    
     <tr>
	  <td class="inputLabel">Table Header  : </td>
	  <td>
         <select class="inputList" name="custom_header" id="custom_header">
         	<option></option>
           <option <?php if($customheader == 'default'){echo 'selected';} ?> value="default">Default</option>
           <option  <?php if($customheader == 'custom'){echo 'selected';} ?> value="custom">Custom</option>
         </select>
       </td>
	</tr>
    
   
    
    <tr>
	  <td class="inputLabel">Report Header : </td>
	  <td><textarea name="report_header" id="report_header" cols="100" rows="10" class="inputInput"><?php echo $reportheader;?></textarea>      </td>
	</tr>
	 <tr>
	  <td class="inputLabel">Report Footer : </td>
	  <td><textarea name="report_footer" id="report_footer" cols="100" rows="10" class="inputInput"><?php echo $reportfooter;?></textarea>      </td>
	</tr>
</table>

<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'report_title' );
		CKEDITOR.replace( 'report_header' );
		CKEDITOR.replace( 'report_footer' );
	};
</script>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" summary="">
    <tr>
      <th colspan="2">Report Permission</th>
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
				//================   dummy
					////list group user non selected (13-10-2009)
	$groupListAll=$mySQL->getUserGroupNonSelectedDash(1);
	$groupListAllCount=count($groupListNonSelected);
	
	//list group user selected (13-10-2009)
	$groupListSelected=$mySQL->getUserGroupSelectedDash(1);
	$groupListSelectedCount=count($groupListSelected);
				
				
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
              <option value="Admin">Admin</option>
              <option value="User">User</option>
                <?php for($x=0; $x < $groupListSelectedCount; $x++) { ?>
                <?php } ?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="insertReport" onclick="listBoxSelectall('selectedGroup');" type="submit" class="inputButton" id="insertReport" value="Simpan" />
          <input name="cancelScreen" type="submit" class="inputButton" id="cancelScreen" value="Batal" />
        </div></td>
    </tr>
  </table>


</form>
<?php }?>