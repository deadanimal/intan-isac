<?php include('system_prerequisite.php');?>
<!--this allow firefox to close browser using javascript
open C:\Program Files\Mozilla Firefox\greprefs\all.js
set dom.allow_scripts_to_close_windows from false to true
-->

<!--open browser, resize, and hide if have other browser-->
<script>
window.resizeTo('0','0');
window.blur();
</script>
<?php
//select db
$email = "select * from FLC_NOTIFICATION_ITEM where notification_item_status = 'Open' and execution_date <= now()";
$emailRs = $myQuery->query($email,'SELECT','NAME');
$emailRsCount = count($emailRs);

//loop on count of notification
for($x=0;$x<$emailRsCount;$x++)
{
	//mailt to, subject, message
	$to			= $emailRs[$x]['EMAIL_TO'];
	$subject	= $emailRs[$x]['EMAIL_SUBJECT'];
	$message	= $emailRs[$x]['EMAIL_MESSAGE'];

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";

	// Additional headers
	if($emailRs[$x]['EMAIL_FROM']){$headers .= 'From: '.$emailRs[$x]['EMAIL_FROM']."\n";}
	if($emailRs[$x]['EMAIL_CC']){$headers .= 'Cc: '.$emailRs[$x]['EMAIL_CC']. "\n";}
	if($emailRs[$x]['EMAIL_BCC']){$headers .= 'Bcc: '.$emailRs[$x]['EMAIL_BCC']. "\n";}

	// Mail it
	if(mail($to, $subject, $message, $headers))
	{
		$updateNotificationItem = "update FLC_NOTIFICATION_ITEM set NOTIFICATION_ITEM_STATUS='Closed', time_stamp = now() where NOTIFICATION_ITEM_ID='".$emailRs[$x]['NOTIFICATION_ITEM_ID']."'";
		$myQuery->query($updateNotificationItem,'RUN');
	}//eof if
}//eof for
?>
<!--close the browser when process complete-->
<script>
window.close();
</script>