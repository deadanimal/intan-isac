// JavaScript Document

//ajax usage
var xmlHttp
//var bb

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


//set calendar changes
function setCalendar(url,next,start,end,room,day,bil)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	
	bb = bil
	//var url="weekv3.php?start=31-12-2008&end=28-2-2009&room=5"
	url=url+"?start="+start+"&end="+end+"&room="+room+"&next="+next+"&day="+day+"&bil="+bil
	//document.getElementById('carian').style.visibility = 'hidden';
	document.getElementById('carian').style.display = "none";
	//document.getElementByName('droplist').style.visibility = 'hidden'; 
	xmlHttp.onreadystatechange=calendarChanged
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
	return true
}


//change the calendar in div
function calendarChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById(bb).innerHTML=xmlHttp.responseText
		
	} 
}

