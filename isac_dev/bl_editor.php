<?php
//include class Table
require_once('class/Table.php');				//class Table

//====================================== display =============================================
//if edit
if($_POST['edit'])
{
	$bl=$myQuery->query("select * from FLC_BL where blid='".$_POST['blid']."'",'SELECT','NAME');
	
	//variable assignment
	$blid=$bl[0]['BLID'];
	$blname=$bl[0]['BLNAME'];
	$bltitle=$bl[0]['BLTITLE'];
	$bldescription=$bl[0]['BLDESCRIPTION'];
	$bldetail=$bl[0]['BLDETAIL'];
	if($bl[0]['BLPARAMETER'])		{$blparameter=explode('|',$bl[0]['BLPARAMETER']);}			//parameter split by '|'
	if($bl[0]['BLPARAMETERTYPE'])	{$blparametertype=explode('|',$bl[0]['BLPARAMETERTYPE']);}	//parametertype split by '|'
	$blstatus=$bl[0]['BLSTATUS'];
	$createby=$bl[0]['CREATEBY'];
	$createdate=$bl[0]['CREATEDATE'];
	$modifyby=$bl[0]['MODIFYBY'];
	$modifydate=$bl[0]['MODIFYDATE'];

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
	$delete=$dal->delete("FLC_BL","?blid='".$_POST['blid']."'");
	
	//if delete
	if($delete)
		$message='BL successfully deleted.';
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
/*if($_POST['blSearch'])
	$blListExtraSql = " where upper(blname) like upper('".$_POST['blSearch']."') ";
	
$blList=$myQuery->query("select blid,bltitle from FLC_BL ".$blListExtraSql." order by bltitle");*/
//===================================== eof general ==========================================
?>

<script language="javascript" type="text/javascript" src="js/editor.js"></script>
<div id="breadcrumbs">Modul Pentadbir Sistem / BL Editor / </div>
<h1>BL Editor</h1> 

<?php if($message)showNotification($eventType,$message);	//notification?>

<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2">BL List </th>
  </tr>
  <tr>
      <td nowrap="nowrap" class="inputLabel">BL Search : </td>
      <td><input name="blSearch" type="text" id="blSearch" size="50" class="inputInput" value="<?php echo $_POST['blSearch']?>" onkeyup="ajaxUpdatePageSelector('bl','blSelectorDropdown',this.value)" /></td>
   </tr>
<tr>
 <td width="100" class="inputLabel">BL :</td>
 <td>
	<div id="blSelectorDropdown">
	<select name="blid" class="inputList" id="blid" onchange="if(this.selectedIndex!=0){swapItemEnabled('edit|delete', '');}else{swapItemEnabled('', 'edit|delete');}">
		<?php echo createDropDown($blList,$_POST['blid']);?>
  	</select>
	</div>
  </td>
</tr>
<tr>
  <td class="contentButtonFooter" colspan="2" align="right">
    <input name="new" type="submit" class="inputButton" id="new" value="Baru" />
    <input name="edit" type="submit" class="inputButton" id="edit" value="Ubah" <?php if(!$_POST['blid']) { ?>disabled style="color:#999999"<?php } ?>/>
    <input name="delete" type="submit" class="inputButton" id="delete" value="Buang" <?php if(!$_POST['blid']) { ?>disabled style="color:#999999"<?php } ?> onClick="if(window.confirm('Anda pasti untuk MEMBUANG bl ini?')) {return true} else {return false}"/>
  </td>
</tr>
</table>
</form>
<br />

<?php if($_POST['new']||$_POST['edit']){?>
<form id="form1" name="form1" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <th colspan="2">New / Edit BL</th>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Title : </td>
	  <td><input name="bltitle" id="bltitle" type="text" class="inputInput" value="<?php echo $bltitle;?>" size="50" />
      <input type="hidden" name="blid" id="blid" value="<?php echo $blid;?>" /></td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Name : </td>
	  <td><input name="blname" id="blname" type="text" class="inputInput" value="<?php echo $blname;?>" size="50" style="text-transform:uppercase;" onkeydown="trim(this)" onblur="onkeydown(this);" /></td>
	</tr>
	<tr>
	  <td class="inputLabel">Status :</td>
	  <td>
          <select name="blstatus" class="inputList" id="blstatus">
            <?php 
			//if status not been set
			if(!isset($blstatus))
				$blstatus='00';		//set default
			
			echo createDropDown($statusList, $blstatus)?>
		  </select>
	  </td>
	</tr>
	<tr>
	  <td class="inputLabel" nowrap="nowrap">Description : </td>
	  <td><textarea name="bldescription" id="bldescription" cols="50" rows="3" class="inputInput"><?php echo $bldescription;?></textarea></td>
	</tr>
</table>
<br />

<?php
//use of class TableGrid
//==================== DECLARATION =======================
$tg=new TableGrid('100%',0,0,0);						//set object for table class (width,border,celspacing,cellpadding)

//set attribute of table
$tg->setAttribute('id','tableContent');					//set id
$tg->setHeader('Parameter');							//set header
$tg->setKeysStatus(true);								//use of keys (column header)
$tg->setKeysAttribute('class','listingHead');			//set class
$tg->setRunningStatus(true);							//set status of running number
$tg->setRunningKeys('No');								//key / label for running number

//set attribute of column in table
$col = new Column();									//set object for column
$col->setAttribute('class','listingContent');			//set attribute for table
$tg->setColumn($col);									//insert/set class column into table
//================== END DECLARATION =====================

//set column
for($x=0;$x<count($blparameter)+1||$x<count($blparametertype)+1;$x++)
{
	$param[$x]['Name']='<input name="blparameter[]" id="blparameter[]" type="text" class="inputInput" value="'.$blparameter[$x].'" size="50" />';
	$param[$x]['Type']='<select name="blparametertype[]" class="inputList" id="blparametertype[]">'.createDropDown($blparameterList, $blparametertype[$x]).'</select>';
	$param[$x]['Delete']='<input name="deleteparameter[]" type="checkbox" value="1" onchange="var parameterCount=(document.getElementsByName(\'deleteparameter[]\')).length;for(x=0;x<parameterCount;x++){if((document.getElementsByName(\'deleteparameter[]\'))[x].checked){(document.getElementsByName(\'blparameter[]\'))[x].disabled=true;(document.getElementsByName(\'blparametertype[]\'))[x].disabled=true;}else{(document.getElementsByName(\'blparameter[]\'))[x].disabled=false;(document.getElementsByName(\'blparametertype[]\'))[x].disabled=false;}}" />';
}//eof for

//put data into tablegrid
$tg->setTableGridData($param);

//count data
$headerCount=count($param[0]);

//status add/delete row
$tg->setAddRowStatus(true);
$tg->setDelRowStatus(true);
$tg->setAddRowType('ajax');

//value add/delete row
$tg->setAddRowValue(ADD_ROW);
$tg->setDelRowValue(DELETE_ROW);

//class
$tg->setAddRowClass('inputButton');
$tg->setDelRowClass('inputButton');

//header
$tg->setHeaderAttribute('colspan',$headerCount);			//set colspan for header
$tg->showTableGrid();
?>
<br />

<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent">
	<tr>
	  <th colspan="2">Detail</th>
	</tr>
	<tr>
	  <td colspan="2"><textarea name="bldetail" id="bldetail" rows="35" class="inputInput" style="width:99.5%; font-size:11px; color:#333333; border:1px solid #00CCCC"><?php echo $bldetail;?></textarea></td>
	</tr>
	<tr>
      <td class="contentButtonFooter" colspan="2" align="right">
      	<input name="<?php if($_POST['new']){?>insert<?php }else{?>update<?php }?>" id="<?php if($_POST['new']){?>insert<?php }else{?>update<?php }?>" type="submit" class="inputButton" value="Save" />
	  </td>
  	</tr>
</table>
</form>
<?php }?>