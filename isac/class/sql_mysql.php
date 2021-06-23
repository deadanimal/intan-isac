<?php
//include file that store standard sql
include('sql_batch.php');

/*SQL function for oracle*/
class dbSQL extends dbSQLBatch
{
//=========================================== pruser ===============================================
	//get user info
	public function getUserInfo($username,$password)
	{
		$sql = "select USERID,USERNAME,USERGROUPCODE,USERTYPECODE,DEPARTMENTCODE,IMAGEFILE,date_format(USERCHANGEPASSWORDTIMESTAMP,'%Y-%m-%d') as USERCHANGEPASSWORDTIMESTAMP
						from PRUSER  
						where USERNAME = '".$username."'
						and USERPASSWORD = '".$password."'";
					
		return $this->query($sql,'SELECT','NAME');
	}//eof function
//========================================= eof pruser =============================================

//========================================= datatabase =============================================
	//list table fr db by schema
	public function listTable($schema)
	{
		$sql = "select upper(concat(TABLE_SCHEMA,'.',TABLE_NAME)) TABLE_NAME
					from information_schema.tables
					where TABLE_SCHEMA in ('".implode("','",explode(',',strtoupper($schema)))."')
					order by 1";
					
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//list view fr db by schema
	public function listView($schema)
	{
		$sql = "select upper(concat(TABLE_SCHEMA,'.',TABLE_NAME)) VIEW_NAME
					from information_schema.views
					where TABLE_SCHEMA in ('".implode("','",explode(',',strtoupper($schema)))."')
					order by 1";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//list procedure fr db by schema
	public function listProcedure($schema)
	{
		/*$sql = "select upper(concat(TABLE_SCHEMA,'.',NAME)) as PROCEDURE_NAME
					from mysql.proc
					where DB in ('".implode("','",explode(',',strtoupper($schema)))."')
					order by 1";
		return $this->query($sql,'SELECT','NAME');*/
	}//eof function
	
	//column name fr db by table
	public function listTableColumn($schema,$user,$table,$columnExclude='')
	{
		//check for tablespace
		$temp=explode('.',$table);
		
		//if have tablespace
		if(count($temp)>1)
		{
			$schema = $temp[0];
			$table = $temp[1];
		}//eof if
		
		//column to be excluded
		if($columnExclude)
			$extra = " and upper(COLUMN_NAME) not in ('".implode("','",explode(',',strtoupper($columnExclude)))."') ";
		
		//selected fr owner
		if($user)
			$extra .= " and upper(TABLE_SCHEMA) = upper('".$schema."') ";
		
		$sql = "select upper(COLUMN_NAME) COLUMN_NAME
					from information_schema.columns 
					where upper(TABLE_NAME) = upper('".$table."')
					".$extra."
					group by COLUMN_NAME
					order by COLUMN_NAME;";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//parameter name fr db by stored procedure / stored function
	public function listProcedureParameter($procedure,$inOut='')
	{
		//start position
		$position=0;
		
		//check for tablespace
		$temp=explode('.',$procedure);
		
		//if have tablespace
		if(count($temp)>1)
		{
			$user = $temp[0];
			$procedure = $temp[1];
		}//eof if
		
		//if have table schema
		if($schema)
			$extra = " and upper(TABLE_SCHEMA) = upper('".$schema."')";
		
		$sql="select upper(PARAM_LIST) as COLUMN_NAME
				from mysql.proc
				where upper(NAME) = upper('".$procedure."')".$extra;
		$temp = $this->query($sql,'SELECT','NAME');
		
		//explode batch parameter to one by one
		$tempResult = explode(',',$temp[0]['PARAM_LIST']);
		$tempResultCount = count($tempResult);
		
		//loop on count of parameter
		for($x=0; $x<$tempResultCount; $x++)
		{
			//explode in_out and parameter name
			$tempParameter = explode(' ',$tempResult[$x]);
			
			//if parameter = in
			if($inOut='IN')
			{
				$result[$x]['IN_OUT'] = $tempParameter[0];
				$result[$x]['COLUMN_NAME'] = $tempParameter[1];
				$result[$x]['POSITION'] = $position++;
			}//eof if
			
			//if parameter = out
			else if($inOut='OUT')
			{
				$result[$x]['IN_OUT'] = $tempParameter[0];
				$result[$x]['COLUMN_NAME'] = $tempParameter[1];
				$result[$x]['POSITION'] = $position++;
			}//eof if
			
			//if parameter = in
			else if($inOut='IN_OUT')
			{
				$result[$x]['IN_OUT'] = $tempParameter[0];
				$result[$x]['COLUMN_NAME'] = $tempParameter[1];
				$result[$x]['POSITION'] = $position++;
			}//eof if
		}//eof for
		
		return $result;
	}//eof function
	
	//list primary key fr db by table
	public function listPrimaryKey($table)
	{
		//check for tablespace
		$temp=explode('.',$table);
		
		//if have tablespace
		if(count($temp)>1)
		{
			$schema = $temp[0];
			$table = $temp[1];
		}//eof if
		
		//if have table schema
		if($schema)
			$extra = " and upper(TABLE_SCHEMA) = upper('".$schema."')";
		
		$sql="select upper(COLUMN_NAME) COLUMN_NAME
				from information_schema.columns  
				where upper(TABLE_NAME) = upper('".$table."')
				".$extra."
				and COLUMN_KEY='PRI'";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//datatype fr db by column
	public function columnDatatype($schema,$user,$table,$column='')
	{
		//check for tablespace
		$temp=explode('.',$table);
		
		//if have tablespace
		if(count($temp)>1)
		{
			$schema = $temp[0];
			$table = $temp[1];
		}//eof if
		
		if($column)
			$extra=" and upper(COLUMN_NAME) = upper('".$column."')";
		
		$sql="select upper(COLUMN_NAME) COLUMN_NAME, upper(DATA_TYPE) DATA_TYPE
				from information_schema.columns 
				where upper(TABLE_NAME) = upper('".$table."')
				and upper(TABLE_SCHEMA) in ('".implode("','",explode(',',strtoupper($schema)))."')".$extra;
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//execute fr dump file
	public function dbExecute($conn,$database,$user,$password,$sql)
	{
		$mysqli = new mysqli($conn, $user, $password, $database);

		return $mysqli->multi_query($sql);
	}//eof function
//======================================= eof datatabase ===========================================

//========================================= basic stuff ============================================
	//max value
	public function maxValue($table,$column,$startValue=0,$where='')
	{
		//if have where clause
		if($where)
			$extra=" where ".$where;

		$result = $this->query("select ifnull(max(".$column."),".$startValue.") from ".$table.$extra);
		return $result[0][0];
	}//eof function
	
	//sql for if null
	public function isNullSQL($expr1,$expr2)
	{
		return "ifnull(".$expr1.",".$expr2.")";
	}//eof function
	
	//sql for limit
	public function limit($rownum)
	{
		return " limit ".$rownum;
	}//eof function
	
	//concat string
	public function concat()
	{
		$vargs = func_get_args();
		$vargsCount = count($vargs);
		
		for($x=0; $x<$vargsCount; $x++)
		{
			if($x==0)
				$result="concat(".$vargs[$x];
			else
				$result.=",".$vargs[$x];
		}//eof for
		
		//if result have value
		if($result)
			$result.=")";
		
		return $result;
	}//eof function
	
	//convert to char
	public function convertToChar($string)
	{
		return $string;
	}//eof function
	
	//convert to number
	public function convertToNumber($string)
	{
		return $string;
	}//eof function
//======================================= eof basic stuff ==========================================

//======================================= date functions ===========================================
	//current date
	public function currentDate()
	{
		return 'now()';
	}//eof function
	
	//date format
	public function date_format()
	{
		//convert to mysql date
		$date_format=str_replace('format-','',DEFAULT_DATE_FORMAT);
		$date_format=str_replace('y','%Y',$date_format);		//year
		$date_format=str_replace('m','%m',$date_format);		//month
		$date_format=str_replace('d','%d',$date_format);		//day
		
		return $date_format;
	}//eof function
	
	//date format (from)
	public function convertFromDate($date)
	{
		return "date_format(".$date.",'".$this->date_format()."')";
	}//eof function
	
	//date format (to)
	public function convertToDate($date)
	{
		/*//compare date
		$tempDate1 = explode('-',$this->date_format());
		$tempDate2 = explode('-',$date);

		for($x=0;$x<3;$x++)
		{
			if($tempDate1[$x]=='%Y')	$resultDate[0]=$tempDate2[$x];	//year
			if($tempDate1[$x]=='%m')	$resultDate[1]=$tempDate2[$x];	//month
			if($tempDate1[$x]=='%d')	$resultDate[2]=$tempDate2[$x];	//day
		}//eof for
		
		return "'".$resultDate[0].'-'.$resultDate[1].'-'.$resultDate[2]."'";*/
		return "str_to_date('".$date."','".$this->date_format()."')";
	}//eof function
//===================================== eof date functions =========================================

//============================================ menu ==================================================
	//function to get menu
	public function menu($filter='')
	{
		$sql = "select concat(if(isnull(c.MENUNAME),'',concat(c.MENUNAME ,' / ')),b.MENUNAME ,' / ' , a.MENUNAME) as MENUNAME, a.MENUID, d.PAGEID
					from FLC_PAGE d, FLC_MENU a
							left outer join FLC_MENU b on a.MENUPARENT = b.MENUID 
							left outer join FLC_MENU c on b.MENUPARENT = c.MENUID
					where a.MENUID = d.MENUID and a.MENUPARENT != 0 
						and upper(concat(if(isnull(c.MENUNAME),'',concat(c.MENUNAME ,' / ')), b.MENUNAME ,' / ' , a.MENUNAME)) like upper('%".$filter."%')
					order by upper(concat(if(isnull(c.MENUNAME),'',concat(c.MENUNAME ,' / ')),b.MENUNAME ,' / ' , a.MENUNAME))";
		return $this->query($sql,'SELECT','NAME');
	}//eof function page
	
	//function to get menu with page excluded
	public function menuExcludePage($page='',$filter='')
	{
		//if modify page
		if($page){$appendWhere = " where PAGEID != '".$page."'";}		//append where clause
		
		$sql = "select concat(if(isnull(c.MENUNAME),'',concat(c.MENUNAME,' / ')), b.MENUNAME,' / ',a.MENUNAME) as MENUNAME, a.MENUID 
					from FLC_MENU a
						left outer join FLC_MENU b on a.MENUPARENT = b.MENUID 
						left outer join FLC_MENU c on b.MENUPARENT = c.MENUID
					where a.MENUID not in (select MENUID from FLC_PAGE ".$appendWhere.")
						and a.MENUID not in (select MENUPARENT from FLC_MENU where MENUPARENT is not null)
						and a.MENUPARENT != 0
						and a.MENULINK like '%page_wrapper%' 
						and upper(concat(if(isnull(c.MENUNAME),'',concat(c.MENUNAME,' / ')),b.MENUNAME,' / ',a.MENUNAME)) like upper('%".$filter."%')
					order by upper(concat(if(isnull(c.MENUNAME),'',concat(c.MENUNAME,' / ')), b.MENUNAME,' / ',a.MENUNAME))";
		return $this->query($sql,'SELECT','NAME');
	}//eof function menu
	
	//function to get menu
	public function menuData($menuParent,$filterName='',$filterValue='')
	{
		//if have filter
		if($filterName&&$filterValue)
		{
			//menu
			if($filterName=='menu')
				$extraMenu=" and upper(a.menuname) like upper('%".$filterValue."%')";
			//parent
			else if($filterName=='parent')
				$extraParent=" and upper(b.menuname) like upper('%".$filterValue."%')";
		}//eof if
		
		$sql = "select a.menuid,a.menuname,
						if(a.menuparent='".$menuParent."','-',b.menuname) menuparent,
						a.menulevel, a.menuorder, a.menutarget, a.menulink, a.menustatus, a.menuroot
					from FLC_MENU a, FLC_MENU b
					where a.menuroot = '".$menuParent."'
					and b.menuid=a.menuparent
					".$extraMenu.$extraParent."
					order by a.menuparent, a.menulevel, a.menuorder";
		return $this->query($sql,'SELECT','NAME');
	}//eof function page
//========================================== eof menu ================================================

//========================================= reference ================================================
	//get reference data
	public function referenceData($tablename,$referenceid,$usertype=3,$filter='')
	{
		//extra field for admin and system
		if($usertype!=3)
			$extra=", 'Tarikh' as tarikh, 'Status' as status, 'Oleh' as oleh";
			
		//container
		$sql="select groupcodename, codename, description1name, description2name, 
					parentcodename, parentrootcodename ".$extra."
				from SYSREFCONTAINER
				where referenceid='".$referenceid."'";
		$refContainer=$this->query($sql);
		$refContainerCount=count($refContainer[0]);
		
		//restricted view admin and user type
		if($usertype==1)
			$extra='';
		else
			$extra=" and referencestatuscode='00'";
		
		//reference data
		$sql="select a.referenceid, 
				if(!P.lookup,a.groupcode, ifnull((select referencecode from ".$tablename." where referenceid=a.groupcode),concat(a.groupcode,'*'))) groupcode,
				if(!Q.lookup,a.referencecode, ifnull((select referencecode from ".$tablename." where referenceid=a.referencecode),concat(a.referencecode,'*'))) referencecode,
				if(!R.lookup,a.description1, ifnull((select referencecode from ".$tablename." where referenceid=a.description1),concat(a.description1,'*'))) description1, 
				if(!S.lookup,a.description2, ifnull((select referencecode from ".$tablename." where referenceid=a.description2),concat(a.description2,'*'))) description2, 
				if(!T.lookup,a.parentcode, ifnull((select referencecode from ".$tablename." where referenceid=a.parentcode),concat(a.parentcode,'*'))) parentcode, 
				if(!U.lookup,a.parentrootcode, ifnull((select referencecode from ".$tablename." where referenceid=a.parentrootcode),concat(a.parentrootcode,'*'))) parentrootcode,
				".$this->convertFromDate('a.timestamp').", 
				(select description1 from REFSYSTEM where referencecode=a.referencestatuscode
					and mastercode=(select referencecode from REFSYSTEM where description1='REFERENCE_STATUS')) referencestatuscode,
				(select username from PRUSER where userid=a.userid) userid
				from ".$tablename." a,
				(".$this->getLookupTableString('groupcodelookuptable', $referenceid).") P,
				(".$this->getLookupTableString('codelookuptable', $referenceid).") Q,
				(".$this->getLookupTableString('description1lookuptable', $referenceid).") R,
				(".$this->getLookupTableString('description2lookuptable', $referenceid).") S,
				(".$this->getLookupTableString('parentcodelookuptable', $referenceid).") T,
				(".$this->getLookupTableString('parentrootcodelookuptable', $referenceid).") U
				where mastercode=(select referencecode from ".$tablename." where referenceid='".$referenceid."') 
				".$extra."
				order by 2,3,4,5,6,7";
		
		//if have filter
		if($filter)
			$sql="select * from (".$sql.")a where ".$filter;
		
		//execute select statement
		$refData=$this->query($sql);
		$refDataCount=count($refData);	//count data
		
		//loop on count
		for($x=0;$x<$refDataCount;$x++)
		{
			for($y=0;$y<$refContainerCount;$y++)
				if($refContainer[0][$y]!='')
					$refArray[$x][$refContainer[0][$y]]=$refData[$x][$y+1];
			
			$refArray[$x]['Perincian']='<a href="'.$_SERVER['REQUEST_URI'].'&dataid='.$refData[$x][0].'">Perincian</a>';
			
			if($usertype!=3)
				$refArray[$x]['Padam']='<input name="deleteID[]" type="checkbox" value="'.$refData[$x][0].'" />';
		}//eof for
		
		return $refArray;
	}//eof function
	
	//get data
	public function data($tablename,$referenceid, $dataid='')
	{
		//return in array (index form) - $data['Name'][<index>],$data[0][<index>]
		//index = 	0 - referenceid
		//			1 - groupcode
		//			2 - referencecode
		//			3 - description1
		//			4 - description2
		//			5 - parentcode
		//			6 - parentrootcode
		//			7 - timestamp
		//			8 - referencestatuscode,
		//			9 - userid
		
		//if receive referenceid
		if($referenceid)
		{
			//data name
			$sql="select 'Internal Key', groupcodename,codename,description1name, description2name,parentcodename,parentrootcodename,
					'Tarikh', 'Status', 'Oleh'
					from SYSREFCONTAINER 
					where referenceid='".$referenceid."'";
			$dataName=$this->query($sql);
			$dataNameCount=count($dataName[0]);
		}//eof if
		//else use dataid
		else
			//data name
			$sql="select 'Internal Key', groupcodename,codename,description1name, description2name,parentcodename,parentrootcodename,
					'Tarikh', 'Status', 'Oleh'
					from SYSREFCONTAINER 
					where referenceid=(select referenceid 
											from ".$tablename." 
											where referencecode=(select mastercode from ".$tablename." where referenceid='".$dataid."'))";
			$dataName=$this->query($sql);
			$dataNameCount=count($dataName[0]);

		//if receive dataid, fetch data
		if($dataid)
		{
			//data
			$sql="select a.referenceid, 
					ifnull(a.groupcode,b.groupcodedefaultvalue),
					ifnull(a.referencecode,b.codedefaultvalue),
					ifnull(a.description1,b.description1defaultvalue),
					ifnull(a.description2,b.description2defaultvalue),
					ifnull(a.parentcode,b.parentcodedefaultvalue),
					ifnull(a.parentrootcode,b.parentrootcodedefaultvalue),
					".$this->convertFromDate('a.timestamp').", 
					a.referencestatuscode, (select username from PRUSER where userid=a.userid) userid 
					from ".$tablename." a, 
						(select groupcodedefaultvalue,codedefaultvalue, description1defaultvalue, 
							description2defaultvalue, parentcodedefaultvalue, parentrootcodedefaultvalue
						from SYSREFCONTAINER where referenceid = 
							(select referenceid from ".$tablename." where referencecode= 
								(select mastercode from ".$tablename." where referenceid='".$dataid."')
							and referencestatuscode='00'
        					and mastercode='XXX')) b
					where a.referenceid='".$dataid."'";
			$data=$this->query($sql);
		}//eof if

		//loop on dataname
		for($x=0;$x<$dataNameCount;$x++)
			$data['Name'][$x]=$dataName[0][$x];
		
		return $data;
	}//eof function
	
	//get lookup item
	public function getLookupItem($tablename,$type,$referenceid)
	{
		//search for lookup table (predefined)
		$sql=$this->getLookupTableString($type.'lookuptable', $referenceid);
		$tempLookup=$this->query($sql);
		
		//value for predefined
		$lookupTable=$tempLookup[0][0];
		
		//if predefined
		if($lookupTable)
		{
			$sql="select referenceid, referencecode.' - '.description1 from ".$tablename." 
					where mastercode=(select referencecode from ".$tablename." where referenceid='".$lookupTable."')
					and referencestatuscode='00'
					order by referencecode||' - '||description1";
			$lookupArray=$this->query($sql);
		}//eof if
		else
		{
			$sql="select ".$type."query from SYSREFCONTAINER where referenceid='".$referenceid."'";
			$tempQuery=$this->query($sql);
			
			//query
			$lookupQuery=$tempQuery[0][0];
			
			//if hav query
			if($lookupQuery)
				$lookupArray=$this->query(convertToDBQry($lookupQuery));
		}//eof else
		
		return $lookupArray;
	}//eof function
	
	//check uniqueness
	public function checkUnique($table,$referenceid,$groupcode,$referencecode,$description1,$description2,$parentcode,$parentrootcode,$statuscode,$dataid='')
	{
		//if dataID is sent (for update only)
		if($dataid)
			$extra=" and b.referenceid != '".$dataid."'";
			
		//check uniqueness (get container name if have duplicate in unique field)
		$sql="select distinct
				if(b.groupcode='".$groupcode."',a.groupcodename,null),
				if(b.referencecode='".$referencecode."',a.codename,null),
				if(b.description1='".$description1."',a.description1name,null),
				if(b.description2='".$description2."',a.description2name,null),
				if(b.parentcode='".$parentcode."',a.parentcodename,null),
				if(b.parentrootcode='".$parentrootcode."',a.parentrootcodename,null)
				from (
					select 
						if(groupcodeunique,null,groupcodename) groupcodename, 
						if(codeunique,null,codename) codename, 
						if(description1unique,null,description1name) description1name, 
						if(description2unique,null,description2name) description2name, 
						if(parentcodeunique,null,parentCodename) parentcodename, 
						if(parentrootcodeunique,null,parentRootCodename) parentrootcodename 
						from SYSREFCONTAINER
						where referenceid='".$referenceid."'
					) a, ".$table." b
				where b.mastercode=(select referencecode from ".$table." where referenceid='".$referenceid."')
				and b.referencestatuscode='00'
				and (b.groupcode='".$groupcode."'
				or b.referencecode='".$referencecode."'
				or b.description1='".$description1."'
				or b.description2='".$description2."'
				or b.parentcode='".$parentcode."'
				or b.parentrootcode='".$parentrootcode."')
				and '".$statuscode."' = '00'
				".$extra;
		
		return $this->query($sql,'SELECT','NAME');
	}//eof function
//======================================= eof reference ==============================================
}//eof class
?>