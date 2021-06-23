<?php 
if($eventType == 'error')
	$notificationCss = 'userNotificationError';
else
	$notificationCss = 'userNotification';
?>
<table width="750" border="0" cellspacing="0" cellpadding="0" id="<?php echo $notificationCss; ?>">
  <tr>
    <td style="font-weight:bold"><?php echo $message;?></td>
  </tr>
</table>
