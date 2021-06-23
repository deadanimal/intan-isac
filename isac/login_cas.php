<?php 
//if using cas
if(CAS_ENABLED)
{
	//check from cas server to get username
	if($cas->casIsAuthenticated())
	{
		$username = $cas->casOnlineUser();
		
		//check username
		$getPwd = "select userpassword from PRUSER
						where USERNAME = '".$username."'";
		$getPwdArr = $myQuery->query($getPwd,'SELECT');
		$password = $getPwdArr[0][0];
		
		checklogin($myQuery,$mySQL,$mySession,$username,$password);
		
		//strip ticket parameter in url
		$_SERVER['QUERY_STRING']=str_replace('ticket=','',$_SERVER['QUERY_STRING']);
		$_SERVER['QUERY_STRING']=str_replace($_GET['ticket'],'',$_SERVER['QUERY_STRING']);
		
		redirect('index.php?'.$_SERVER['QUERY_STRING']);	//redirect to system
	}//eof if
	else
		$cas->casLogin();
		//$error=LOGIN_CAS_MSG;
}//eof if
?>

<html>
<body>
<?php echo $error;?>
</body>
</html>