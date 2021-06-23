<?php
//--------------------------------------------------------------------------------------------------
// CLASS NAME: Oracle dbConnection [ COMPLETED ]
// BASE CLASS: -
// DESCRIPTION: To provide connectivity to oracle and other database connectivity related methods
// METHODS: init, connect, disconnect, selectDb, getConnString
// COPYRIGHT: ESRA TECHNOLOGY SDN BHD
// AUTHOR: CIKKIM
// EDITED: FAIS
//--------------------------------------------------------------------------------------------------

//USAGE SYNTAX
//$myDbConnection = new dbConnection;												//create new connection object
//$myDbConnection->init("root","xxx","mpk");										//init connection 
//$myDbConnection->disconnect();													//disconnect
//$dbc = $myDbConnection->getConnString();											//get connection string

//class for Oracle database connectivity
class dbConnection 
{	
	//class member declaration
	private $dbName;				//db name
	private $dbUsername;			//db username
	private $dbPassword;			//db password
	private $dbc;					//db connection string id - visible to child class
	
	//-----------------------------------------
	//[ start class methods declaration block ]
	//-----------------------------------------

	//to initialize connection to db server
	public function init($usr,$pwd,$db)
	{	
		//default values
		$this->dbUsername = $usr;
		$this->dbPassword = $pwd;
		$this->dbName = $db;
		
		//connect to db
		if($this->connect() == true)	
			return true;				
	}
	
	//to connect to db, PRIVATE
	private function connect()
	{	
		//if dbconnection and dbusername not null, try connect
		//if($this->dbConnection != '' && $this->dbUsername != '')
		if( $this->dbUsername != '')
		{	
			//try connect to database
			$this->dbc = oci_connect($this->dbUsername,$this->dbPassword,$this->dbName);
			
			//if not connected, show error msg and return false
			if($this->dbc == FALSE)
			{	
				echo 'ERROR! Database connection error.<br>';
				return false;
			}
			
			//if connected, return true
			else
			{	//echo 'Database is Connect on Oracle Database';
				return true;
			}
		}
		
		//if dbConnection or dbUsername is null
		else
			echo 'ERROR! Database server address or database username must not be null.<br>';
	}
	
	//to disconnect from db
	public function disconnect()
	{	
		//if connection does not exist
		if($this->dbc == FALSE)
		{
			echo 'ERROR! Could not disconnect from database because database is not connected';
			return false;
		}
		else
		{	
			//if database is closed successfully
			if(oci_close($this->dbc) == true)
				return true;
			
			//if database failed to close, return error 
			else
			{
				echo 'ERROR! Database connection could not be disconnected.';
				return false;
			}
		}
	}
	
	//to return connection string - dbc (publicly called)
	public function getConnString()
	{	
		return $this->dbc;
	}
	
	//-----------------------------------------
	//[ end class methods declaration block   ]
	//-----------------------------------------
}

//--------------------------------------------------------------------------------------------------
// CLASS NAME: myDatabase [ COMPLETED ] 
// BASE CLASS: -
// DESCRIPTION: To provide functions for processing common sql queries 
// METHODS: __construct, query, run_sql, bool_sql, count_sql, select_sql
// COPYRIGHT: ESRA TECHNOLOGY SDN BHD
// AUTHOR: CIKKIM
//--------------------------------------------------------------------------------------------------
//class for executing common sql queries
//class myDatabase extends dbConnection
class dbQuery 
{	
	//class member declaration
	private $dbc;
	private $sql;
	private $type;					//RUN, BOOL, COUNT, SELECT
	private $selectReturnType;		//
	
	//-----------------------------------------
	//[ start class methods declaration block ]
	//-----------------------------------------
		
	//to get connection string (php 5 constructor)
	public function __construct($dbc)
	{	
		//assign connection string to private var	
		$this->dbc = $dbc;
	}
	
	//to provide common sql function interface
	//parameter: the sql, type (run/bool/count/select), return type (singlearr/doublearr)
	
	//INDEX / NAME / BOTH (return either single array (index), single array (name), or double array (index and name) in select_sql)
	public function query($sql,$type = 'SELECT',$selectReturnType = 'INDEX')			
	{			
		//if type of sql is of SELECT
		if($type == 'SELECT')
		{	
			//choose type of return values			
			//if to return index
			if($selectReturnType == 'INDEX')
				$this->selectReturnType = 'INDEX';
			
			//if to return name
			else if($selectReturnType == 'NAME')
				$this->selectReturnType = 'NAME';
			
			//if to return both index and name in single array
			else if($selectReturnType == 'BOTH_SINGLE')
				$this->selectReturnType = 'BOTH_SINGLE';
			
			//if to return both index and name in separate array
			else if($selectReturnType == 'BOTH_DOUBLE')
				$this->selectReturnType = 'BOTH_DOUBLE';
			
			//if to return both index and keys in separate array
			else if($selectReturnType == 'BOTH_INDEX_KEYS')
				$this->selectReturnType = 'BOTH_INDEX_KEYS';
			
			//else, default to name
			else
				$this->selectReturnType = 'NAME';
		}
		
		//query function type switcher
		switch($type)
		{	
			//switch to related class method
			
			//run type query (insert/update/delete/etc..)
			case 'RUN':
				return $this->run_sql($sql);
				break;
			
			//boolean type query (true/false)
			case 'BOOL':
				return $this->boolean_sql($sql);
				break;
			
			//count type query (return integer. eg: count)
			case 'COUNT':
				return $this->count_sql($sql);
				break;
			
			//select type query (select stmt.)	
			case 'SELECT':	
				return $this->select_sql($sql);
				break;
		}
	}
	
	//FN NAME: run_sql
	//DESC: to run insert, delete, update query
	//RETURN: boolean (true, false)
	private function run_sql($sql)
	{	
		/* -------------------- added 20080327 -------------------- */
		//check for primary key uniqueness
		/* -------------------------------------------------------- */
	//pending
	/*
	
		//trim the sql
		$sql = trim($sql);

		//find position of first whitespace
		$firstPos = stripos($sql,' ');
		
		//check type of query, substring from sql
		$queryType = substr($sql,0,$firstPos);  
		
		//if query type is insert
		if($queryType == 'insert')
		{	
			//---- get table name ----
			$toReplace = 'insert into ';
			$theReplacement = '';
			
			//replace FIRST occurence of the string (pattern, replacement, string, limit)
			$sqlCut = preg_replace('/'.$toReplace.'/', $theReplacement, $sql, 1);
			
			//get position of first (
			$paranthesesPos = stripos($sqlCut,'(');
			
			//extract table name
			$theTableName = trim(substr($sqlCut,0,$paranthesesPos));
			
			//----- check for uniqueness
			//get primary column
			 $checkPrimary = "select COLUMN_NAME from ALL_CONS_COLUMNS A 
									join ALL_CONSTRAINTS c on A.CONSTRAINT_NAME = c.CONSTRAINT_NAME 
									where c.TABLE_NAME = '".$theTableName."' 
									and C.CONSTRAINT_TYPE = 'P' ";
			
		}
		
		*/
		
		//if query type is update
		if($queryType == 'update')
		{	
		}
		
		//if query type is delete
		if($queryType == 'delete')
		{
		}
	
		//parse sql statement
		$sqlParsed = oci_parse($this->dbc,$sql) or die('DATABASE INSERT, UPDATE, DELETE QUERY ERROR: '.oci_error());	
		
		//execute parsed sql statement
		$successFlag = @oci_execute($sqlParsed,OCI_DEFAULT);
		//$successFlag = @oci_execute($sqlParsed,OCI_DEFAULT);
		
		//---- get error msg ----
		$errorMsg = oci_error($sqlParsed);								//fetch error msg 
		
		//if theres error msg, get parse error msg
		if(count($errorMsg) > 0)
		{	
			$errorCode = explode(':',$errorMsg['message']);				//parse error msg
			//echo $sql."<br><br>";
		}
		//if query success
		if($successFlag == TRUE)
		{
			//echo '<div id="userNotification">Maklumat telah berjaya disimpan.</div>';
			return oci_commit($this->dbc);								//commit transaction and return boolean 
		}	
		
		//if query fail, show sql
		else
		{
			//error code selection
			if($errorCode[0] == 'ORA-00001')
			{	//echo $sql;
				echo '<strong>Maklumat yang diisi telah wujud di dalam sistem. Sila cuba sekali lagi.</strong>';
			}
			
			else
				echo '<code>'.$sql.'</code>';
		}
	}
	
	//FN NAME: boolean_sql
	//DESC: to run boolean result query
	//RETURN: boolean (true, false)
	private function boolean_sql($sql)
	{   
		//parse sql statement
		$sqlParsed = oci_parse($this->dbc,$sql) or die('DATABASE BOOLEAN QUERY ERROR: '.oci_error());	
		
		//execute parsed sql statement
		$successFlag = oci_execute($sqlParsed);
		
		//if query success
		if($successFlag == TRUE)
		{	
			//fetch all rows into array
			$sqlNumRows = oci_fetch_all($sqlParsed,$sqlRsArr);					

			//if theres record, return true
			if($sqlNumRows > 0)
				return TRUE;
			   
			//else return false
			else
				return FALSE;
		}
		
		//if query fail, show sql
		else
		{
			echo '<code>'.$sql.'</code>';
		}
	}
	
	//FN NAME: count_sql
	//DESC: to return count result of query
	//RETURN: integer
	private function count_sql($sql)
	{
		//parse sql statement
		$sqlParsed = oci_parse($this->dbc,$sql) or die('DATABASE COUNT QUERY ERROR: '.oci_error());	
		
		//execute parsed sql statement
		$successFlag = oci_execute($sqlParsed);
		
		//if query success		
		if($successFlag != FALSE)
		{
			//fetch all array into array
			$sqlRsRows = oci_fetch_array($sqlParsed,OCI_NUM);																	
			
			//return 
			return (int) $sqlRsRows[0];
		}
		
		//if query fail, show sql
		else 
		{	
			echo '<code>'.$sql.'</code>';
		}
	}
	
	//FN NAME: select_sql
	//DESC: to return result of SELECT query
	//RETURN: array
	private function select_sql($sql)
	{	  
		//parse sql statement
		 $sqlParsed = oci_parse($this->dbc,$sql) or die('DATABASE SELECT QUERY ERROR: '.oci_error());	
		 
		 //execute parsed sql statement
		 $successFlag = oci_execute($sqlParsed);
		
		//if query success
		 if($successFlag != FALSE)
		{	
			//fetch all rows into array
			$sqlNumRows = oci_fetch_all($sqlParsed,$sqlRsArr);		
			
			//free result memory
			oci_free_statement($sqlParsed);		
				
			//get list of keys in sqlRsArr
			$keysList = array_keys($sqlRsArr);
		
			//if num rows more than zero
			//if($sqlNumRows != FALSE)				//original
			if($sqlNumRows > 0)
			{
				//change format from column based to row based
				//count no of db column
				$dbNoOfColumn = count($sqlRsArr);
				
				//count no of db result rows
				$dbNumRows = count(current($sqlRsArr));
				
				//convert from column based to row based
				for($x=0; $x < $dbNoOfColumn; $x++)
				{
					//if first row, use current
					if($x == 0)
						$tempo = current($sqlRsArr);
					
					//else, move array pointer to next
					else
						$tempo = next($sqlRsArr);
					
					//count no of items in tempo
					$tempoCount = count($tempo);
					
					//for all records in tempo, copy to temp array
					for($y=0; $y < $tempoCount; $y++)
					{
						//if type is both_single						
						if($this->selectReturnType == 'BOTH_SINGLE')
						{
							//store as index in temparr
							$tempArr[$y][(int)$x] = ($tempo[$y]);
							
							//store as column name in temparr
							$tempArr[$y][$keysList[$x]] = ($tempo[$y]);
						}
						
						//else, store in index array and name array
						else
						{
							//copy to temp array, use field name as key
							$indexArr[$y][(int)$x] = ($tempo[$y]);
						
							//copy to temp array, use field name as key
							$nameArr[$y][$keysList[$x]] = ($tempo[$y]);
						}
					}//end for y
				}//end for x

				//return value
				//if type index, return index array				
				if($this->selectReturnType == 'INDEX')
					return $indexArr;

				//if type name, return name array
				else if($this->selectReturnType == 'NAME')
					return $nameArr;
				
				//if type both_single, return temp array
				else if($this->selectReturnType == 'BOTH_SINGLE')
					return $tempArr;

				//if type both_double, return combined array of index and name
				else if($this->selectReturnType == 'BOTH_DOUBLE')
				{
					$returnArr = array($indexArr,$nameArr);
					return $returnArr;
				}
				
				//if type both_name_keys, return combined array of name and keys
				else if($this->selectReturnType == 'BOTH_INDEX_KEYS')
				{
					$returnArr = array($indexArr,$keysList);
					return $returnArr;
				}
			}
			
			//return temp array
			else
				return $tempArr;
		}
		
		//if query fail, show sql
		else
		{
			echo '<code>'.$sql.'</code>';
		}
	}	
   
    //FN NAME: stored_procedure
	//DESC: to return result of stored_procedure
	//RETURN: boolean (true, false) 
	public function stored_procedure($sql,$funcName)
	{   
		/*//create plsql statement
		
		//prepare in parameter
		//if count of in parameter is not zeros
		if(count($sql['inParm']) != 0)
		{	
			for($x=0; $x < count($sql['inParm']); $x++)
				 $sql['inParm'][$x] = "'".$sql['inParm'][$x]."'";			//prepend : in front on parameter name

			$inParameter = implode(", ",$sql['inParm']);					//implode to string, pad with comma
		}
		
		//prepare out parameter
		//if count of out parameter is not zeros
		if(count($sql['outParm']) != 0)
		{
			for($x=0; $x < count($sql['outParm']); $x++)
				 $sql['outParm'][$x] = ':'.$sql['outParm'][$x];				//prepend : in front on parameter name

			$outParameter .= implode(', ',$sql['outParm']);					//implode to string, pad with comma,
		}
	 	 
		 //combine in and out parameter
		 if(strlen($inParameter) != 0 && strlen($outParameter) != 0)
		 	$theParameter = $inParameter.', '.$outParameter;
		
		//if in, and NO out
		else if(strlen($inParameter) != 0 && strlen($outParameter) == 0)
		 	$theParameter = $inParameter;
		 
		 //if out, and NO in
		else if(strlen($inParameter) == 0 && strlen($outParameter) != 0)
			$theParameter = $outParameter;
	  
	  	//prepend with begin, append with end
		echo $theParameter = 'begin '.$funcName.'('.$theParameter.'); end;';*/
		
		echo $theParameter = $this->stored_procedure_statement($sql,$funcName);
		
		//parse sql statement in stored procedure
		$sqlParsed = oci_parse($this->dbc,$theParameter) or die('STORED_PROCEDURE ERROR: '.oci_error());
		
		$testArr = array();
		
	    //Bind the output parameter for OUT parameter
		for($x=0; $x < count($sql['outParm']); $x++)
		{
	  	   oci_bind_by_name($sqlParsed,$sql['outParm'][$x], $testArr[$x], 50) ;
		}
		//echo $sqlParsed;
		
	   //execute parsed sql statement
	   if(oci_execute($sqlParsed) == true)
	   		//print_r ($testArr);
			return $testArr;
		/*else
			return 'No data found';*/
		//if query fail, show sql
		else
		{
			//error code selection
			if($errorCode[0] == 'ORA-00001')
			{
				echo '<strong>Maklumat yang diisi telah wujud di dalam sistem. Sila cuba sekali lagi.</strong>';
			}
			
			else
				echo '<code>'.$theParameter.'</code>';
		}
	}
	
	//FN NAME: stored_procedure_statement
	//DESC: to return result of stored_procedure_statement
	//RETURN: string (statement) 
	public function stored_procedure_statement($sql,$funcName)
	{   
		//prepare in parameter
		//if count of in parameter is not zeros
		if(count($sql['inParm']) != 0)
		{	
			for($x=0; $x < count($sql['inParm']); $x++)
				 $sql['inParm'][$x] = "'".$sql['inParm'][$x]."'";			//prepend : in front on parameter name

			$inParameter = implode(", ",$sql['inParm']);					//implode to string, pad with comma
		}
		
		//prepare out parameter
		//if count of out parameter is not zeros
		if(count($sql['outParm']) != 0)
		{
			for($x=0; $x < count($sql['outParm']); $x++)
				 $sql['outParm'][$x] = ':'.$sql['outParm'][$x];				//prepend : in front on parameter name

			$outParameter .= implode(', ',$sql['outParm']);					//implode to string, pad with comma,
		}
	 	 
		 //combine in and out parameter
		 if(strlen($inParameter) != 0 && strlen($outParameter) != 0)
		 	$theParameter = $inParameter.', '.$outParameter;
		
		//if in, and NO out
		else if(strlen($inParameter) != 0 && strlen($outParameter) == 0)
		 	$theParameter = $inParameter;
		 
		 //if out, and NO in
		else if(strlen($inParameter) == 0 && strlen($outParameter) != 0)
			$theParameter = $outParameter;
	  
	  	//prepend with begin, append with end
		return $theParameter = 'begin '.$funcName.'('.$theParameter.'); end;';
	}//eof function stored_procedure_statement
	
	//-----------------------------------------
	//[ end class methods declaration block ]
	//-----------------------------------------
}
?>