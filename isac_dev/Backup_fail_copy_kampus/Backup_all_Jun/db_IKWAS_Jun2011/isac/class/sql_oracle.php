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
		$sql = "select USERID,USERNAME,USERGROUPCODE,USERTYPECODE,DEPARTMENTCODE,IMAGEFILE,to_date(USERCHANGEPASSWORDTIMESTAMP,'rrrr-mm-dd') as USERCHANGEPASSWORDTIMESTAMP
						from PRUSER  
						where USERNAME = '".$username."'
						and USERPASSWORD = '".$password."'";
					
		return $this->query($sql,'SELECT','NAME');
	}//eof function
//========================================= eof pruser =============================================

//========================================== database ==============================================
	//list table fr db by schema
	public function listTable($schema)
	{
		$sql="select distinct upper(OWNER||'.'||TABLE_NAME) TABLE_NAME
					from all_TABLES 
					where OWNER in ('".implode("','",explode(',',strtoupper($schema)))."') 
					or TABLE_NAME='PRUSER'
					order by 1";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//list view fr db by schema
	public function listView($schema)
	{
		$sql="select distinct upper(OWNER||'.'||VIEW_NAME) VIEW_NAME
				from dba_views 
				where OWNER in ('".implode("','",explode(',',strtoupper($schema)))."') 
				order by 1";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//list procedure fr db by schema
	public function listProcedure($schema)
	{
		$sql="select distinct upper(OWNER||'.'||OBJECT_NAME) as PROCEDURE_NAME 
				from all_arguments 
				where OWNER in ('".implode("','",explode(',',strtoupper($schema)))."')
				order by 1";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//column name fr db by table
	public function listTableColumn($schema,$user,$table,$columnExclude='')
	{
		//check for tablespace
		$temp=explode('.',$table);
		
		//if have tablespace
		if(count($temp)>1)
		{
			$user = $temp[0];
			$table = $temp[1];
		}//eof if
		
		//column to be excluded
		if($columnExclude)
			$extra = " and upper(COLUMN_NAME) not in ('".implode("','",explode(',',strtoupper($columnExclude)))."') ";
		
		//selected fr owner
		if($user)
			$extra .= " and upper(OWNER) = upper('".$user."') ";
				
		$sql="select upper(COLUMN_NAME) COLUMN_NAME
				from all_tab_columns 
				where upper(TABLE_NAME) = upper('".$table."')
				".$extra."
				order by COLUMN_NAME";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//parameter name fr db by stored procedure / stored function
	public function listProcedureParameter($procedure,$inOut='')
	{
		//check for tablespace
		$temp=explode('.',$procedure);
		
		//if have tablespace
		if(count($temp)>1)
		{
			$user = $temp[0];
			$procedure = $temp[1];
		}//eof if
		
		//if have in out parameter
		if($inOut)
			$extra = " and upper(in_out) = upper('".$inOut."') ";
			
		//selected fr owner
		if($user)
			$extra .= " and upper(OWNER) = upper('".$user."') ";
			
		$sql="select distinct upper(ARGUMENT_NAME) as COLUMN_NAME, upper(POSITION) POSITION, upper(IN_OUT) IN_OUT
				from all_arguments 
				where upper(OBJECT_NAME) = upper('".$procedure."')
				".$extra."
				order by COLUMN_NAME";
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//list primary key fr db by table
	public function listPrimaryKey($table)
	{
		//check for tablespace
		$temp=explode('.',$table);
		
		//if have tablespace
		if(count($temp)>1)
		{
			$user = $temp[0];
			$table = $temp[1];
		}//eof if
		
		//if have table schema
		if($user)
			$extra = " and upper(OWNER) = upper('".$user."')";		//pending
		
		$sql="select upper(a.COLUMN_NAME) COLUMN_NAME
					from ALL_CONS_COLUMNS a  
					join ALL_CONSTRAINTS c on a.CONSTRAINT_NAME = c.CONSTRAINT_NAME  
					where upper(c.TABLE_NAME) = upper('".$table."')
					and c.CONSTRAINT_TYPE = 'P'";
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
				from all_tab_columns 
				where upper(TABLE_NAME) = upper('".$table."')
				and upper(OWNER) in ('".implode("','",explode(',',strtoupper($user)))."')".$extra;
		return $this->query($sql,'SELECT','NAME');
	}//eof function
	
	//execute fr dump file
	public function dbExecute($conn,$database,$user,$password,$sql)
	{
		//$fileStr=str_replace("\r\n","",file_get_contents($file));
		
		return $this->query('BEGIN '.$sql.' END;','RUN');
	}//eof function
//======================================== eof database ============================================

//========================================= basic stuff ============================================
	//max value
	public function maxValue($table,$column,$startValue=0,$where='')
	{
		//if have where clause
		if($where)
			$extra=" where ".$where;

		$result = $this->query("select nvl(max(to_number(".$column.")),".$startValue.") from ".$table.$extra);
		return $result[0][0];
	}//eof function
	
	//sql for if null
	public function isNullSQL($expr1,$expr2)
	{
		return "nvl(".$expr1.",".$expr2.")";
	}//eof function
	
	//sql for limit
	public function limit($rownum,$concatSQL)
	{
		return $concatSQL." rownum<=".$rownum;
	}//eof function
	
	//concat string
	public function concat()
	{
		$vargs = func_get_args();
		$vargsCount = count($vargs);
		
		for($x=0; $x<$vargsCount; $x++)
		{
			if($x==0)
				$result=$vargs[$x];
			else
				$result.="||".$vargs[$x];
		}//eof for
		
		return $result;
	}//eof function
	
	//convert to char
	public function convertToChar($string)
	{
		return "to_char(".$string.")";
	}//eof function
	
	//convert to number
	public function convertToNumber($string)
	{
		return "to_number(".$string.")";
	}//eof function
//======================================= eof basic stuff ==========================================

//======================================= date functions ===========================================
	//current date
	public function currentDate()
	{
		return 'sysdate';
	}//eof function
	
	//date format
	public function date_format()
	{
		//convert to oracle date
		$date_format=str_replace('format-','',DEFAULT_DATE_FORMAT);
		$date_format=str_replace('y','rrrr',$date_format);		//year
		$date_format=str_replace('m','mm',$date_format);		//month
		$date_format=str_replace('d','dd',$date_format);		//day
		
		return $date_format;
	}//eof function
	
	//date format (from)
	public function convertFromDate($date)
	{
		return "to_char(".$date.",'".$this->date_format()."')";
	}//eof function
	
	//date format (to)
	public function convertToDate($date)
	{
		return "to_date('".$date."','".$this->date_format()."')";
	}//eof function
//===================================== eof date functions ===========================================

//============================================ menu ==================================================
	//function to get menu
	public function menu($filter='')
	{
		$sql="select(decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME ||' / ' || a.MENUNAME) as MENUNAME,
							a.MENUID, d.PAGEID
							from FLC_MENU a, FLC_MENU b, FLC_MENU c, FLC_PAGE d 
							where a.MENUPARENT = b.MENUID (+) and b.MENUPARENT = c.MENUID (+)
							and a.MENUID = d.MENUID
							and a.MENUPARENT != 0 
							and upper((decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME ||' / ' || a.MENUNAME)) like upper('%".$filter."%')
							order by upper(MENUNAME)";
		return $this->query($sql,'SELECT','NAME');
	}//eof function page
	
	//function to get menu with page excluded
	public function menuExcludePage($page='',$filter='')
	{
		//if modify page
		if($page){$appendWhere = " where PAGEID != '".$page."'";}		//append where clause
		
		$sql="select (decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME || ' / ' || a.MENUNAME) as MENUNAME, a.MENUID 
					from FLC_MENU a, FLC_MENU b, FLC_MENU c
					where a.MENUPARENT = b.MENUID (+) and b.MENUPARENT = c.MENUID (+)
					and a.MENUID not in (select MENUID from FLC_PAGE ".$appendWhere.")
					and a.MENUID not in (select MENUPARENT from FLC_MENU where MENUPARENT is not null)
					and a.MENUPARENT != 0 
					and a.MENULINK like '%page_wrapper%'
					and upper((decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME ||' / ' || a.MENUNAME)) like upper('%".$filter."%')
					order by upper(MENUNAME)";
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
						decode(a.menuparent,".$menuParent.",'-',b.menuname) menuparent,
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
				decode(P.lookup,null,a.groupcode, nvl((select referencecode from ".$tablename." where to_char(referenceid)=a.groupcode),a.groupcode||'*')) groupcode,
				decode(Q.lookup,null,a.referencecode, nvl((select referencecode from ".$tablename." where to_char(referenceid)=a.referencecode),a.referencecode||'*')) referencecode,
				decode(R.lookup,null,a.description1, nvl((select referencecode from ".$tablename." where to_char(referenceid)=a.description1),a.description1||'*')) description1, 
				decode(S.lookup,null,a.description2, nvl((select referencecode from ".$tablename." where to_char(referenceid)=a.description2),a.description2||'*')) description2, 
				decode(T.lookup,null,a.parentcode, nvl((select referencecode from ".$tablename." where to_char(referenceid)=a.parentcode),a.parentcode||'*')) parentcode, 
				decode(U.lookup,null,a.parentrootcode, nvl((select referencecode from ".$tablename." where to_char(referenceid)=a.parentrootcode),a.parentrootcode||'*')) parentrootcode,
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
			$sql="select * from (".$sql.") where ".$filter;
		
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
					nvl(a.groupcode,b.groupcodedefaultvalue),
					nvl(a.referencecode,b.codedefaultvalue),
					nvl(a.description1,b.description1defaultvalue),
					nvl(a.description2,b.description2defaultvalue),
					nvl(a.parentcode,b.parentcodedefaultvalue),
					nvl(a.parentrootcode,b.parentrootcodedefaultvalue),
					to_char(a.timestamp,'dd-Mon-yyyy'), 
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
			$sql="select referenceid, referencecode||' - '||description1 from ".$tablename." 
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
				decode(b.groupcode,'".$groupcode."',a.groupcodename,null),
				decode(b.referencecode,'".$referencecode."',a.codename,null),
				decode(b.description1,'".$description1."',a.description1name,null),
				decode(b.description2,'".$description2."',a.description2name,null),
				decode(b.parentcode,'".$parentcode."',a.parentcodename,null),
				decode(b.parentrootcode,'".$parentrootcode."',a.parentrootcodename,null)
				from (
					select 
						decode(groupcodeunique,null,null,groupcodename) groupcodename, 
						decode(codeunique,null,null,codename) codename, 
						decode(description1unique,null,null,description1name) description1name, 
						decode(description2unique,null,null,description2name) description2name, 
						decode(parentcodeunique,null,null,parentCodename) parentcodename, 
						decode(parentrootcodeunique,null,null,parentRootCodename) parentrootcodename 
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