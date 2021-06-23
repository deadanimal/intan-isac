<?php 
//if button save clicked
if($_POST['saveButton'])
{	
	//backup current config file to cfg_bak folder
	if(!is_dir('conf_bak'))
		mkdir('conf_bak',0777);
	
	//if copy / backup success
	if(copy('conf.php','conf_bak/conf_'.date(YmdHis).'.php'))
	{
		//
		$_POST['configText']=ereg_replace('\'\'','\\\'',$_POST['configText']);
	
		//create new config file
		$bytesWritten = file_put_contents('conf.php',stripcslashes($_POST['configText']));
	}
}
?>

<div id="breadcrumbs">Modul Pentadbir Sistem / Konfigurasi Sistem / </div>
<h1>Konfigurasi Sistem
  <?php if($_POST['editConfig']) echo ' - Edit Mode'?>
</h1>
<?php 
//if button save clicked
if($_POST['saveButton']) { ?>
<table border="0" cellspacing="0" cellpadding="0" id="userNotification">
  <tr>
    <td>Configuration file has been updated. <?php echo $bytesWritten.' bytes written.';?></td>
  </tr>
</table>
<?php } ?>
<form name="form1" method="post" action="">
  <?php if($_POST['editConfig']) { ?>
  <textarea name="configText" rows="35" wrap="off" id="configText" style="width:100%; font-size:11px; color:#333333; margin-bottom:10px; border:1px solid #00CCCC"><?php echo file_get_contents('conf.php'); ?></textarea>
  <?php } else { ?>
  <div style="overflow:scroll; margin-bottom:10px;" >
    <?php highlight_string(file_get_contents('conf.php')); ?>
  </div>
  <?php } ?>
  <div align="right">
    <?php if($_POST['editConfig']) { ?>
    <input name="cancel" type="submit" class="inputButton" id="cancel" value="Cancel" />
    <input name="saveButton" type="submit" class="inputButton" id="saveButton" value="Save Changes" onClick="if(window.confirm('Are you sure you want to SAVE changes?')) {return true} else {return false}" />
    <?php } ?>
    <?php if(!isset($_POST['editConfig'])) { ?>
    <input name="editConfig" type="submit" class="inputButton" id="editConfig" value="Edit Configuration" />
    <?php } ?>
  </div>
</form>
