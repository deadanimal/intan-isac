<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2"><?php echo $componentArr[$x]['COMPONENTNAME'];?></th>
  </tr>
  <tr>
  	<td colspan="2">
	<iframe id="upload_frame_<?php echo $componentArr[$x]['COMPONENTID'];?>" name="upload_frame_<?php echo $componentArr[$x]['COMPONENTID'];?>" src="tools/spreadsheet/spreadsheet.php?id=<?php echo $componentArr[$x]['COMPONENTBINDINGSOURCE'];?>" width="100%" height="350" frameborder="0"></iframe>
	</td>
  </tr>
  <tr>
  	<td width="150" class="inputLabel">Paksa Muatnaik :</td>
	<td class="inputArea">
		<input name="upload_force_<?php echo $componentArr[$x]['COMPONENTID'];?>" id="upload_force_<?php echo $componentArr[$x]['COMPONENTID'];?>" type="checkbox" value="1" />
	</td>
  </tr>
  <tr>
  	<td width="150" class="inputLabel">Muatnaik :</td>
	<td class="inputArea">
		<input name="upload_loading_<?php echo $componentArr[$x]['COMPONENTID'];?>" id="upload_loading_<?php echo $componentArr[$x]['COMPONENTID'];?>" type="hidden" value="" />
	  	<input name="upload_file_<?php echo $componentArr[$x]['COMPONENTID'];?>" id="upload_file_<?php echo $componentArr[$x]['COMPONENTID'];?>" type="file" size="30" />
	</td>
  </tr>
</table>
<br />