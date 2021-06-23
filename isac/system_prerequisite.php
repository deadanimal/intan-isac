<?php 

error_reporting(0);
//required libs, classes, and files
require_once('class/session.php');				//session mgmt

//create session object
if(!is_object($mySession)&&!isset($_SESSION))
	$mySession = new mySessionMgmt(SESSION_NAME);

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
require_once('class/sql_'.DBMS_NAME.'.php');	//sql class
require_once('class/dal.php');					//bl class
require_once('func_sys.php');					//system function
require_once('func_common.php');				//common function

//create database connection
$myDbConn = new dbConnection;											//create db connection object
$myDbConn->init(DB_USERNAME,DB_PASSWORD,DB_DATABASE,DB_CONNECTION);
$dbc = $myDbConn->getConnString();										//get connection string

//create database query object
$myQuery = new dbQuery($dbc);

//create database sql object
$mySQL = new dbSQL($dbc);
$dal = new DAL($dbc);

//cas server
if(CAS_ENABLED)
{
	require_once('class/cas.php');
	
	//if cas object not instintiated yet
	if(!is_object($cas))
		$cas = new CAS(CAS_VERSION,CAS_HOSTNAME,CAS_PORT,CAS_URI);
}//eof if
?>