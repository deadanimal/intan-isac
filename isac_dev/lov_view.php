<?php 
//include stuff needed for session, database connection, and stuff
include('system_prerequisite.php');						

//process get input_map data and convert to post
if($_GET)
{
	$getCount = count($_GET);
	$getKeys = array_keys($_GET);
	$getKeysCount = count($getKeys);
	
	//loop on count of get
	for($x=0;$x<$getCount;$x++)
	{
		if(eregi('input_map_',$getKeys[$x]))
			$_POST[$getKeys[$x]] = $_GET[$getKeys[$x]];
	}//eof for
}//eof if

if($_GET['id'])
{
	$tempInput = explode('_',$_GET['id']);
	$component = $tempInput[2];				//componentID
	$item = $tempInput[3];					//itemID
	$index = $tempInput[4];					//rowIndex
}//eof if

//if component id is set
if($_GET['id']&&$item)
{	
	//get query
	$get = "select ITEMLOOKUP, COMPONENTID from FLC_PAGE_COMPONENT_ITEMS where ITEMID = '".$item."'";
	$getRs = $myQuery->query($get,'SELECT','NAME');

	//get the lookup and prepare sql statement
	$lookup = str_replace('\\','',$getRs[0]['ITEMLOOKUP']);
	$lookup = str_replace('"',"'",$getRs[0]['ITEMLOOKUP']);
	
	if($_POST['filter'])
		$lookup = "select * from ( ".$lookup." ) a where flc_name like '%".$_POST['value']."%'";
	else
		$lookup = $lookup;
	
	//get list of values using the lookup query
	$lovArr = $myQuery->query(convertDBSafeToQuery($lookup),'SELECT','NAME');
	
	//count number of lov rows
	$countLov = count($lovArr);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php echo SYSTEM_FULL_NAME;?>
</title>
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/common.js"></script>
</head>
<body style="margin:0px; padding:0px;">
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" style="margin-left:0px;" >
    <tr>
      <th colspan="2">Carian</th>
    </tr>
    <tr>
      <td width="159" class="inputLabel">Nama : </td>
      <td width="816"><input name="value" type="text" id="value" size="30" /></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F7F3F7"><div align="right">
          <input name="filter" type="submit" class="inputButton" id="filter" value="Cari" />
        </div></td>
    </tr>
  </table>
  <br />
  <div style="height:350px; overflow:auto">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" id="tableContent" style="margin-left:0px;" >
      <tr>
        <th colspan="2">Senarai Carian </th>
      </tr>
      <?php if($countLov > 0) { ?>
      <tr>
        <td width="12" class="listingHead">Bil</td>
        <td class="listingHeadRight">Nama</td>
      </tr>
      <?php for($x=0; $x < $countLov; $x++) { ?>
      <tr>
        <td class="listingContent"><?php echo ($x+1).".";?>&nbsp;</td>
        <td class="listingContentRight"><a href="javascript:void(0)" onclick="window.opener.document.getElementById('lov_text_<?php echo $component.'_'.$item;if($index!=''){echo '_'.$index;}?>').value = document.getElementById('hiddenText_<?php echo $x; ?>').value; 
																				window.opener.document.getElementById('input_map_<?php echo $component.'_'.$item;if($index!=''){echo '_'.$index;}?>').value = document.getElementById('hiddenValue_<?php echo $x; ?>').value; 
																				window.close();"><?php echo $lovArr[$x]["FLC_NAME"];?>
          <input name="hiddenText_<?php echo $x; ?>" type="hidden" id="hiddenText_<?php echo $x; ?>" value="<?php echo $lovArr[$x]["FLC_NAME"];?>" />
          <input name="hiddenValue_<?php echo $x; ?>" type="hidden" id="hiddenValue_<?php echo $x; ?>" value="<?php echo $lovArr[$x]["FLC_ID"];?>" />
          </a></td>
      </tr>
      <?php 		} //end for ?>
      <?php 	}//end if 
	else 	{ ?>
      <tr>
        <td colspan="2" class="myContentInput">&nbsp;&nbsp;Tiada Rekod </td>
      </tr>
      <?php 	} //end else?>
      <tr>
        <td colspan="2" bgcolor="#F7F3F7"><div align="right">
            <input name="saveScreen22" type="button" class="inputButton" value="Tutup" onclick="window.close()" />
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
