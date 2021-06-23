<?php
/*SQL FUNCTION*/
//function to get page menu
/*function page($conn,$filter='')
{
	$sql="select(decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME ||' / ' || a.MENUNAME) as MENUNAME,
						a.MENUID, d.PAGEID
						from FLC_MENU a, FLC_MENU b, FLC_MENU c, FLC_PAGE d 
						where a.MENUPARENT = b.MENUID (+) and b.MENUPARENT = c.MENUID (+)
						and a.MENUID = d.MENUID
						and a.MENUPARENT != 0 
						and upper((decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME ||' / ' || a.MENUNAME)) like upper('%".$filter."%')
						order by upper(MENUNAME)";
	return $conn->query($sql,'SELECT','NAME');
}//eof function page

//function to get menu by page
function menu($conn,$page='',$filter='')
{
	//if modify page
	if($page){$appendWhere = " where PAGEID != '".$page."'";}		//append where clause
	
	$sql="select (decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME || ' / ' || a.MENUNAME) as MENUNAME, a.MENUID 
				from FLC_MENU a, FLC_MENU b, FLC_MENU c
				where a.MENUPARENT = b.MENUID (+) and b.MENUPARENT = c.MENUID (+)
				and a.MENUID not in (select MENUID from FLC_PAGE ".$appendWhere.")
				and a.MENUID not in (select MENUPARENT from FLC_MENU where MENUPARENT is not null)
				and a.MENUPARENT != 0 
				and upper((decode(c.MENUNAME,null,'',c.MENUNAME ||' / ')|| b.MENUNAME ||' / ' || a.MENUNAME)) like upper('%".$filter."%')
				order by upper(MENUNAME)";
	return $conn->query($sql,'SELECT','NAME');
}//eof function menu*/
?>