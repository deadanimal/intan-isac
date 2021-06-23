// JavaScript Document for editors

//swap menu link options
function swapMenuLinkOption(linkType, targetID, linkID)
{
	if(linkType==1)
	{
		//enable
		if(document.getElementById(targetID)&&document.getElementById(linkID))
		{
			//document.getElementById(targetID).disabled=false;		//enable
			document.getElementById(targetID).selectedIndex=0;		//set initial index
		}
		
		if(document.getElementById(linkID))
		{
			document.getElementById(linkID).value='index.php?page=';	//initial link
		}
	}
	else
	{
		//disable
		if(document.getElementById(targetID))
		{
			//document.getElementById(targetID).disabled=true;		//enable
			document.getElementById(targetID).selectedIndex=1;		//set initial index
		}
		
		if(document.getElementById(linkID))
		{
			document.getElementById(linkID).value='';	//initial link
		}
	}
}

//ajax usage
var xmlHttp

//show selected component drop down
function showComponent(page, componentExcepted)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	
	var url="ajax_editor.php"
	url=url+"?editor=component&page="+page+"&componentExcepted="+componentExcepted
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

//show selected component item drop down
function showComponentItem(page, component, itemExcepted)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
	
	var url="ajax_editor.php"
	url=url+"?editor=component&page="+page+"&component="+component+"&itemExcepted="+itemExcepted
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

//show selected control drop down
function showControl(page, controlExcepted)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	
	var url="ajax_editor.php"
	url=url+"?editor=control&page="+page+"&controlExcepted="+controlExcepted
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

//show selected menu drop down
function showMenu(menuLevel, menuRoot, menuParent, menuExcepted, menuStatus)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	
	var url="ajax_editor.php"
	url=url+"?editor=menu&menuLevel="+menuLevel+"&menuRoot="+menuRoot+"&menuParent="+menuParent+"&menuExcepted="+menuExcepted+"&menuStatus="+menuStatus
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

//show selected database drop down
function showDatabase(component, mapping)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	
	var url="ajax_editor.php"
	url=url+"?editor=database&component="+component
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged2 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

//show selected database drop down
function showDatabaseColumn(table, tableExcepted)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	
	var url="ajax_editor.php"
	url=url+"?editor=database&table="+table+"&tableExcepted="+tableExcepted
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged2 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

//show Max Update subMenu order
function showMax(menuLevel, menuParent)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}

	var url="ajax_editor.php"
	url=url+"?editor=menu&levelMenu="+menuLevel+"&menuParent="+menuParent
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged3
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

//show Max New subMenu order
function showNewMax(menuLevel, menuParent)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}

	var url="ajax_editor.php"
	url=url+"?editor=menu&levelMenu="+menuLevel+"&menuParent="+menuParent
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged4
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}


function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("hideEditorList").innerHTML=xmlHttp.responseText 
	} 
}

function stateChanged2() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("hideDatabaseList").innerHTML=xmlHttp.responseText 
	} 
}

function stateChanged3() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("editMenuOrderText").value=xmlHttp.responseText 
	} 
}

function stateChanged4() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("newMenuOrderText").value=xmlHttp.responseText 
	} 
}


function GetXmlHttpObject()
{
var xmlHttp=null;
try
{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e)
{
//Internet Explorer
try
{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
}
return xmlHttp;
}

/**
TO REPLACE QUOTE
-element: element ID
*/
function replaceQuote(elem)
{
	var a = elem.value;
	a = a.replace (/\'/g, '[QS]');
	a = a.replace (/\"/g, '[QD]');
	elem.value = a;
}

/**
TO PLACE QUOTE
-element: element ID
*/
function placeQuote(elem)
{
	var a = elem.value;
	a = a.replace (/\[QS\]/g, '\'');
	a = a.replace (/\[QD\]/g, '"');
	elem.value = a;
}


