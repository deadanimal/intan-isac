<?php
/*standard SQL function*/
class dbSQLBatch extends dbQuery
{
//============================================ menu =================================================
	//get menu permission SQL
	public function menuPermission()
	{
		//if admin
		if($_SESSION['userName']=='admin'&&$_SESSION['userID']==1)
		{
			$sql = "select menuid from FLC_MENU";
		}//eof if
		else
		{
			$sql = "select distinct perm_item from FLC_PERMISSION 
						where perm_type = 'menu' 
						and group_id in (
							select group_id from FLC_USER_GROUP_MAPPING 
							where group_id in
							(
								select c.group_id 
								from PRUSER a, FLC_USER_GROUP_MAPPING b, FLC_USER_GROUP c 
								where a.userid = b.USER_ID 
								and b.group_id = c.GROUP_ID 
								and userid = '".$_SESSION['userID']."'
							) 
							and user_id = '".$_SESSION['userID']."'
						)";
		}//eof else
		
		return $sql;
	}//eof function
	
	//get list of menu that have permission
	public function getMenuArr($menuRoot='')
	{
		//if have menuroot
		if($menuRoot)
			$extraSQL="and menuID='".$menuRoot."'";
		
		//if admin
		if($_SESSION['userName']=='admin'&&$_SESSION['userID']==1)
		{
			$sql = "select MENUNAME, MENUID
						from FLC_MENU 
						where menuParent = '0' and MENUSTATUS = '1' ".$extraSQL."
						order by menuOrder";
		}//eof if
		else
		{
			$sql = "select MENUNAME, MENUID
						from FLC_MENU
						where menuParent = '0' and MENUSTATUS = '1' and menuID in (".$this->menuPermission().") ".$extraSQL."
						order by menuOrder";
		}//eof else
		
		return $this->query($sql,'SELECT','NAME');
	}//eof function
//========================================== eof menu ===============================================

//====================================== reference system ===========================================
	//get bl parameter reference
	public function bl_parameter()
	{
		$sql="select referencecode,description1 from REFSYSTEM where mastercode=
				(select referencecode from REFSYSTEM where description1='BL_PARAMETER_TYPE' and referencestatuscode='00')";
		return $this->query($sql);
	}//eof function
//==================================== eof reference system =========================================

//====================================== reference general ===========================================
	//get reference status
	public function status()
	{
		$sql="select referencecode, description1
				from REFSYSTEM
				where mastercode=
					(select referencecode from REFSYSTEM where description1='REFERENCE_STATUS')";
		return $this->query($sql);
	}//eof function
	
	//get referenceid by referenceid or referencename filtered (permission) by userid
	public function getReferenceID($referenceid='', $referencename='', $userid='')
	{
		//if not admin (super-admin)		
		if($userid!='1')
		{
			//select reference by permission
			$extra=" and a.referenceid in (select referenceid from SYSREFPERMISSION where groupid in
						(select group_id from FLC_USER_GROUP where group_id in
							(select group_id from FLC_USER_GROUP_MAPPING where user_id='".$userid."')))";
		}//eof if
		
		//select container
		$sql="select a.referenceid from SYSREFCONTAINER a
				where (upper(a.referencename) = upper('".$referencename."') or a.referenceid = '".$referenceid."')
				and a.referencestatuscode='00' ".$extra;
		$tempResult=$this->query($sql);
		
		return $tempResult[0][0];
	}//eof function
	
	//get reference container
	public function reference($tablename,$userid='',$groupid='')
	{
		//if not admin (super-admin)		
		if($userid&&$userid!='1')
		{
			//select reference by permission using userid
			$extra=" and a.referenceid in (select referenceid from SYSREFPERMISSION where groupid in
						(select group_id from FLC_USER_GROUP where group_id in
							(select group_id from FLC_USER_GROUP_MAPPING where user_id='".$userid."')))";
		}//eof if
		else if($groupid)
		{
			//select reference by permission using group id
			$extra=" and a.referenceid in (select referenceid from SYSREFPERMISSION where groupid ='".$groupid."')";
		}//eof else if
		
		//get container / reference name
		$sql="select a.referenceid, a.referencetitle, a.referencename
				From SYSREFCONTAINER a, ".$tablename." b
				where a.referenceid = b.referenceid
                and a.referencestatuscode ='00' ".$extra."
				order by upper(a.referencetitle)";
		return $this->query($sql);
	}//eof function
	
	//get lookup table given field name and referenceid
	public function getLookupTableString($fieldname, $referenceid)
	{return "select substr(".$fieldname.",8) as lookup from SYSREFCONTAINER where referenceid='".$referenceid."'";}//eof function
	
	//get group user non-selected
	public function getUserGroupNonSelected($referenceid='',$filter='')
	{
		//if receive referenceid
		if($referenceid)
			$extra.="where group_id not in (select groupid from SYSREFPERMISSION where referenceid='".$referenceid."')";
		
		//non-selected user group
		$sql="select group_id, description from FLC_USER_GROUP 
				".$extra."
				order by description";
		return $this->query($sql);
	}//eof function
	
	//get group user selected
	public function getUserGroupSelected($referenceid='',$filter='')
	{
		//selected user group
		$sql="select group_id, description from FLC_USER_GROUP 
				where group_id in (select groupid from SYSREFPERMISSION where referenceid='".$referenceid."')
				order by description";
		return $this->query($sql);
	}//eof function
	
	
	//13-10-09 done by Farhan Esa : Han2
	//start dash get group user non-selected
	public function getUserGroupNonSelectedDash($referenceid='',$filter='')
	{
		//if receive referenceid
		if($referenceid)
			$extra.="where group_id not in (select group_id from FLC_DASHBOARD_PERMISSIONS where DASHITEM_ID='".$referenceid."')";
		
		//non-selected user group
		$sql="select group_id, description from FLC_USER_GROUP 
				".$extra."
				order by description";
		return $this->query($sql);
	}//eof function
	
	//13-10-09 done by Farhan Esa : Han2
	//get group user selected
	public function getUserGroupSelectedDash($referenceid='',$filter='')
	{
		//selected user group
		$sql="select group_id, description from FLC_USER_GROUP 
				where group_id in (select group_id from FLC_DASHBOARD_PERMISSIONS where DASHITEM_ID='".$referenceid."')
				order by description";
		return $this->query($sql);
	}//eof function
	
	//13-10-09 done by Farhan Esa : Han2
		//get group user selected
	public function getUserGroupAllDash()
	{
		//selected user group
		$sql="select group_id, description from FLC_USER_GROUP 
				order by description";
		return $this->query($sql);
	}//eof function end dash
	
	//14-10-09 done by Farhan Esa : Han2
	//start dash get group user non-selected
	public function getUserGroupNonSelectedControl($referenceid='',$filter='')
	{
		//if receive referenceid
		if($referenceid)
			$extra.="where group_id not in (select group_id from FLC_PAGE_CONTROL_PERMISSIONS where CONTROL_ID='".$referenceid."')";
		
		//non-selected user group
		$sql="select group_id, description from FLC_USER_GROUP 
				".$extra."
				order by description";
		return $this->query($sql);
	}//eof function
	
	//14-10-09 done by Farhan Esa : Han2
	//get group user selected
	public function getUserGroupSelectedControl($referenceid='',$filter='')
	{
		//selected user group
		$sql="select group_id, description from FLC_USER_GROUP 
				where group_id in (select group_id from FLC_PAGE_CONTROL_PERMISSIONS where CONTROL_ID='".$referenceid."')
				order by description";
		return $this->query($sql);
	}//eof function
//==================================== eof reference general =========================================

//============================================= get list ===================================================
	//get list of bl
	public function listBL($filter='')
	{
		//list of bl
		$sql="select blid, upper(blname) blname from FLC_BL where upper(blname) like upper('%".$filter."%')  order by blname";
		return $this->query($sql);
	}//eof function
	
	//get list of active bl
	public function listActiveBL($filter='')
	{
		//list of bl
		$sql="select blname, upper(blname) from FLC_BL where upper(blname) like upper('%".$filter."%') and blstatus='00' order by blname";
		return $this->query($sql);
	}//eof function
	
	//get list of loading
	public function listLoading($filter='')
	{
		//list of bl
		$sql="select loading_id, upper(loading_name) loading_name from FLC_LOADING where upper(loading_name) like upper('%".$filter."%') order by loading_name";
		return $this->query($sql);
	}//eof function
	
	//get list of avtive loading
	public function listActiveLoading($filter='')
	{
		//list of bl
		$sql="select loading_name, upper(loading_name) from FLC_LOADING where upper(loading_name) like upper('%".$filter."%') and loading_status='00' order by loading_name";
		return $this->query($sql);
	}//eof function
//=========================================== eof get list =================================================
}//eof class
?>