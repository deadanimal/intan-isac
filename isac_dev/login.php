<?php 
//include stuff needed for session, database connection, and stuff
include('system_prerequisite.php');

//if button submit posted
if($_POST['login'])
	$error = checklogin($myQuery,$mySQL,$mySession,$_POST['userID'],md5($_POST['userPassword']));

//if session userID
if($_SESSION['userID'])
{redirect('index.php?'.$_SERVER['QUERY_STRING']);}	//redirect to system
else
{include(SYSTEM_LOGIN_PAGE);}			//include the login page	

//redirect('index.php?page='.$_GET['page'].'&menuID='.$_GET['menuID']);
?>