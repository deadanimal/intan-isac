<?php
//include stuff needed for session, database connection, and stuff
include('system_prerequisite.php');

//if public login
if(PUBLIC_SCREEN_ENABLED&&$_POST['login_public'])
{
	$_SESSION['loginFlag']=true;
	$_SESSION['public']=1;
	$_SESSION['publicID']=$_POST['publicID'];
	
	//redirect to public page
	redirect(PUBLIC_HOME_PAGE);
}//eof if

//if session publicID
if($_SESSION['publicID'])
{redirect('index.php?page='.$_GET['page'].'&menuid='.$_GET['menuid']);}	//redirect to system
else
{include(PUBLIC_LOGIN_PAGE);}			//include the public login page
?>