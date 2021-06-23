<?php 
//required libs, classes, and files
require_once('class/session.php');				//session mgmt

//create session object
$mySession = new mySessionMgmt(SESSION_NAME);
$mySession->getSessionName(300);

//for side menu
if($_GET['menuMinimized'] == 1)
	$_SESSION['menuMinimized'] = true;

else if($_GET['menuMinimized'] == 0)
	$_SESSION['menuMinimized'] = false;

//for side menu
if($_SESSION['menuMinimized'] == true)
	$_SESSION['leftMenuSize'] = 1;
else
	$_SESSION['leftMenuSize'] = 230;

//required files
require_once('conf.php');						//falcon configuration file
require_once('class/db_'.DBMS_NAME.'.php');		//database class
require_once('func_sys.php');					//system function
require_once('func_common.php');				//common function
require_once('sql.php');						//system sql statement

//create database connection
$myDbConn = new dbConnection;											//create db connection object
$myDbConn->init(DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$dbc = $myDbConn->getConnString();										//get connection string

//create database query object
$myQuery = new dbQuery($dbc);


