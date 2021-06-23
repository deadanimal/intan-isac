<?php //required libs, classes, and files
error_reporting(0);
require_once('class/session.php');				//session mgmt

//create session object
$mySession = new mySessionMgmt(SESSION_NAME);
$mySession->getSessionName(300);

//required files
require_once('conf.php');						//falcon configuration file
require_once('class/db_'.DBMS_NAME.'.php');		//database class
require_once('func_sys.php');					//system function
require_once('func_common.php');				//common function
/*require_once('sql.php');						//system sql statement*/

$myDbConn = new dbConnection;											//create db connection object
$myDbConn->init(DB_USERNAME,DB_PASSWORD,DB_DATABASE,DB_CONNECTION);
$dbc = $myDbConn->getConnString();										//get connection string

//create database query object
$myQuery = new dbQuery($dbc);

if($_GET['item'])
{
	//get item id
	$id = explode('_',str_replace(array('input_map_'),array(''),$_GET['item']));
	$id = $id[1];	
	
	//get item id query
	$sql = "select ITEMLOOKUP, ITEMJAVASCRIPT, ITEMJAVASCRIPTEVENT 
			from FLC_PAGE_COMPONENT_ITEMS where ITEMID = ".$id;
	$sqlRs = $myQuery->query($sql,'SELECT','NAME');
	
	$sql = $sqlRs[0]['ITEMLOOKUP'];
	
	//and val=".$_GET['val'];
	$sql = str_replace('\\','',convertDBSafeToQuery($sql));
	$sql = str_replace('"',"'",$sql);
	$sql = str_replace('&quot;',"'",$sql);
	
	//run the itemlookup query
	$run = "select * from (".$sql.") a ".str_replace("\\",'',$_GET['where']);
	$runRs = $myQuery->query($run,'SELECT','NAME');
	$countRunRs = count($runRs);
	
	//generate javascript
	if($sqlRs[0]['ITEMJAVASCRIPTEVENT'] != '')
	{
		//get javascript event
		$getJavascriptEvent = $myQuery->query("select DESCRIPTION1 from REFSYSTEM 
														where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' 
																			and DESCRIPTION1 = 'PAGE_CTRL_ACTION_JS_BUTTON') 
														and REFERENCECODE = '".$sqlRs[0]['ITEMJAVASCRIPTEVENT']."'",'SELECT','NAME');
		
		if($getJavascriptEvent[0]["DESCRIPTION1"] != "")
			$js .= $getJavascriptEvent[0]["DESCRIPTION1"]." = \"".convertDBSafeToQuery($sqlRs[0]['ITEMJAVASCRIPT'])."\"";
	}
}

?>
<select name="<?php echo $_GET['item']?>" id="<?php echo $_GET['item']; ?>" <?php echo $js;?> class="inputList">
<option >&nbsp;</option>
<?php for($x=0; $x < count($runRs); $x++) { ?>
<option value="<?php echo $runRs[$x]['FLC_ID']?>"><?php echo $runRs[$x]['FLC_NAME']?></option>
<?php }?>
</select>







