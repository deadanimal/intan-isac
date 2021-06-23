//to open new popup window
function my_popup(page,varz,resizeable,scrollbar,width2,height2)
{	
	var t_resize = "no";			//default value
	var t_scroll = "no";
	
	if(varz == "pic")
		page = page;
	else
		page = page + ".php?" + varz;
			
	if(resizeable == 1) t_resize = "yes";
	if(scrollbar == 1) t_scroll = "yes";
		
	var paramz = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=" + t_scroll + ", resizable=" + t_resize + ", copyhistory=yes, width=" + width2 + ", height=" + height2;
	window.open(page,'ee',paramz);
}

//to open new popup window
function my_new_window(page,width2,height2)
{	
	var paramz = "toolbar=yes, location=yes, directories=yes, status=yes, menubar=yes, scrollbars=yes, resizable=yes, copyhistory=yes, width=" + width2 + ", height=" + height2;
	window.open(page,'ee',paramz);
}

//function to prototype.js error reporting
function reportError(request) 
{
	$F('locationDiv') = "Error";
}

function addTabularRow(rowToAdd,componentid)
{	
	var url = 'page_wrapper.php';
	//var url = 'class/Table.php';
	var params = 'id=1&row=' + rowToAdd + '&componentid=' + componentid;
	var ajax = new Ajax.Updater({success: 'tableRowSub' + rowToAdd},url,{method: 'get', parameters: params, onFailure: reportError});
}

//function to add new row in table
function addNewRowButton(tableName,newRowSubName,componentid)
{
	//get table row element reference
	var oRows = document.getElementById(tableName).getElementsByTagName('tr');
	
	//count number rows length (number of rows)
	var iRowCount = oRows.length;
	
	//create table reference																
	//var myTable = document.getElementById(tableName);
	
	//tbody reference
	//var tBody = myTable.getElementsByTagName('tbody')[0];
	var tBody = document.getElementById('addRow');
	
	//create new row
	var newTR = document.createElement('tr');
	
	//assign name to newly creaete row
	newTR.id = newRowSubName + '' +  iRowCount;
	
	//append tr to tbody
	tBody.appendChild(newTR);
	
	//call ajax function to add items in the array																
	addTabularRow(iRowCount,componentid);
}

//to access element in table using DOM
//parameter: table ID, row index, column index, control index 
function GetControlObj(tableID,rowIndex,colIndex,ctrlIndex)
{
	var row;
	var cell;
	var controlObj;
	
	//parse index as int
	rowIndex = parseInt(rowIndex);
	
	//declare tablename
	tableID = document.getElementById(tableID);
	
	//declare row
	row = tableID.rows[rowIndex];	

	//get cell
	cell = row.cells[colIndex];	
	
	//get current node and assign as control object
	controlObj = cell.childNodes[ctrlIndex];

	//return control element
	return controlObj;
}

//to access element in table using DOM by INDEX
//parameter: table ID, row index, column index, control index 
function GetControlObjByRef(tableRef,rowIndex,colIndex,ctrlIndex)
{
	var row;
	var cell;
	var controlObj;
	
	//parse index as int
	rowIndex = parseInt(rowIndex);
	
	//declare tablename
	tableID = tableRef;
	
	//declare row
	row = tableID.rows[rowIndex];	

	//get cell
	cell = row.cells[colIndex];	
	
	//get current node and assign as control object
	controlObj = cell.childNodes[ctrlIndex];

	//return control element
	return controlObj;
}

//function to strip unused item from window.location.href
//example: http://192.168.1.1/falcon_v2_server/index.php?page=page_wrapper&id=1&p=412 
//will return index.php?page=page_wrapper&id=1&p=412
function stripHREF(str)
{	
	var newStr = str.split("/");					//the separator
	var newStrLength = newStr.length;				//count the array
	var concatStr = '';								
	
	//for all length of newStr
	for(var x=4; x < newStrLength; x++)
	{	
		//if concatStr is empty string, do not append '/'
		if(concatStr.length == 0)
			concatStr = concatStr + newStr[x];
		
		//else, append '/'
		else
			concatStr = concatStr + '/' + newStr[x];
	}

	return concatStr;				//return stripped href
}

//function to call listing filter function
//parameter: filter column, filter value, target id, target url
//example: customerID,82,theSearchResult, index.php?page=xxxxxx
function ajaxUpdateQuery(filterColumn,filterValue,target,theUrl,postStrKey,postStrVal)
{
	//the url to call
	var url = theUrl;
	
	var filterColumn = document.getElementById(filterColumn).value;					//create dom reference
	var filterValue = document.getElementById(filterValue).value;					//create dom reference
	var target = document.getElementById(target);									//create dom reference
	
	window.alert('zzzzzzz');
	window.alert('filtercol:' + filterColumn + 'filtervalue' + filterValue);
	window.alert(target.id);
	
	//process post string key
	var postStrKeyArr = postStrKey.split('|#|#|');
	
	//process post string value 
	var postStrValArr = postStrVal.split('|#|#|');
	var postStrValArrLength = postStrValArr.length;
	
	//var url = 'ajax_menu_wrapper.php';
	//var params = 'id=2&toggle=CFI4&state=' + state;
	var params =  'ajax=1&filterCol=' + filterColumn + '&filterVal=' + filterValue;
	
	//for all item in thePostArray array, append to params string 
	for(var x=0; x < postStrValArrLength; x++)
	{
		//if first iteration, append & 
		if(x == 0)
			params += '&';
		
		//append to params string
		params = params + postStrKeyArr[x] + '=' + postStrValArr[x];
		
		//if last iteration, do not append & to params string
		if(x+1 != postStrValArrLength)
			params += '&';
	}
	
	//var ajax = new Ajax.Updater({success: 'menusub2'},url,{method: 'get', parameters: params, onFailure: reportError});
	var ajax = new Ajax.Updater({success: target},url,{method: 'post', parameters: params, onFailure: reportError});
}

//get list of input list
//requirement: prototype.js
function getInputList(theForm,theUrl)
{		
	var formLength = $(theForm).length;					//get form length
	var theQueryString = new Array(formLength);			//declare new array for querystring
	var lastLocation = 0;								//declare and assign lastlocation 
	
	//for all length of form
	for(var x=0; x < formLength; x++)
	{
		//if type of elems is the following..
		if($(theForm).elements[x].type == 'text' || $(theForm).elements[x].type == 'checkbox' || $(theForm).elements[x].type == 'radio'
			|| $(theForm).elements[x].type == 'hidden' || $(theForm).elements[x].type == 'textarea' || $(theForm).elements[x].type == 'select-one')
		{	
			//if id of element is not empty string
			if($(theForm).elements[x].id != '')
			{
				if($(theForm).elements[x].type == 'radio')
				{	
					//if element is checked
					if($(theForm).elements[x].checked)
						theQueryString[x] = $(theForm).elements[x].id + '=' + $(theForm).elements[x].value;
				}
				//if other than radio button
				else
				{
					//store the id and value as querystring (eg: id1=xxx)
					theQueryString[x] = $(theForm).elements[x].id + '=' + $(theForm).elements[x].value;
				}
			}//end if 
		}//end if
	}//end for

	//check for existance of '?'
	//if \u003f of question mark (?) is found, do nothing
	//if(theUrl.search('/\e/') == -1)
		//theUrl = theUrl + '?';	
	
	var theUrlLength = theUrl.length;					//the url length
	
	//for all length of window href	
	for(var x=0; x < theUrlLength; x++)
	{	
		//find position of last '&'
		if(theUrl.charAt(x) == '&')
			lastLocation = x;
	}
	
	theQueryString = theQueryString.compact();					//remove null, undefined items from array
	var convertToStr = theQueryString.toString();				//convert array to string
	convertToStr = convertToStr.replace(/\,/g,'&');				//replace all commas to &
	
	return theUrl + convertToStr;								//return converted string
}

//function to toggle ajax side bar menu
function ajaxToggleMenu(target,params)
{	
	//new Effect.Fade('sideMenuLer');
	//new Effect.Appear('sideMenuLer');
	var url = 'side_menu_left.php';
	var ajax = new Ajax.Updater({success: target},url,{method: 'get', parameters: params + '&type=ajax', onFailure: reportError});
	//new Effect.Appear(target); 	
}

//function to update page editor page selector dropdown
function ajaxUpdatePageSelector(type,target,thevalue,theSelected)
{
	var url = 'ajax_editor.php?updater=filter&type=' + type + '&value=' + thevalue + '&select=' + theSelected;
	var params = '';
	var ajax = new Ajax.Updater({success: target},url,{method: 'get', parameters: params, onFailure: reportError});	
}

//function to run stored procedure in bground
function ajaxSpBgProcess(statement)
{
	var target='spStatus';
	var url = 'ajax_sp.php';
	var params = 'statement=' + statement;
	var ajax = new Ajax.Updater({success: target},url,{method: 'post', parameters: params,onLoading: function(request) {Element.show('spProgress'); Element.hide('spStatus');},onLoaded: function(request) {Element.hide('spProgress');Element.show('spStatus');}, onFailure: reportError});	
}

//function to retrieve filename from file upload path
function getFileName(str)
{
	var strlength = str.length;						//get path length
	var lastPos = 0;								//set position to zero
	
	//get last position of slash (\)
	for(var a=0; a < strlength; a++)
	{	
		if(str.charAt(a) == '\\')					//if character at a is = \
			lastPos = a;							//store last position of \
	}
	
	//return filename only
	return str.substring(lastPos+1,strlength);
}




//function to retrieve filename from file upload path
function getFileName2(str)
{
	var strlength = str.length;						//get path length
	var lastPos = 0;								//set position to zero
	
	//get last position of slash (\)
	for(var a=0; a < strlength; a++)
	{	
		if(str.charAt(a) == '\\')					//if character at a is = \
			lastPos = a;							//store last position of \
	}
	
	//return filename only
	return str.substring(lastPos,strlength);
}

//function to update multiple select dropdown from left to right, and vice versa
function ajaxUpdateMultipleLeftRight(source,target,thevalue)
{
	var url = 'ajax_editor.php?updater=filter&type=' + type + '&value=' + thevalue + '&select=' + theSelected;			//data source
	var params = '';
	var ajax = new Ajax.Updater({success: target},url,{method: 'get', parameters: params, onFailure: reportError});	
}

/* ************************* */
//	source: lupa 
//	Copy the code inside head portion of your HTML code
//   Created on : Nov 12,2007 
//   List movement script
//   Moves the items between two HTML Select elements
//   it looks like a movement between two lists.
//
/* ************************* */

//edited by cikkim
function moveoutid(source,target)
{
	var sda = document.getElementById(source);
	var len = sda.length;
	var sda1 = document.getElementById(target);
	
	for(var j=0; j<len; j++)
	{
		//try
		//{
		if(sda[j].selected)
		{
			var tmp = sda.options[j].text;
			var tmp1 = sda.options[j].value;
			sda.remove(j);
			j--;
			var y=document.createElement('option');
			y.text=tmp;
			y.value=tmp1;
			try
			{sda1.add(y,null);
			}
			catch(ex)
			{
			sda1.add(y);
			}
		}
		//}
		//catch(ex)
		//{
		//}

	}
}


function moveinid(source,target)
{
	var sda = document.getElementById(source);
	var sda1 = document.getElementById(target);
	var len = sda1.length;
	
	try
	{
	for(var j=0; j<len; j++)
	{
		if(sda1[j].selected)
		{
			var tmp = sda1.options[j].text;
			var tmp1 = sda1.options[j].value;
			sda1.remove(j);
			j--;
			var y=document.createElement('option');
			y.text=tmp;
			y.value=tmp1;
			try
			{
			sda.add(y,null);}
			catch(ex){
			sda.add(y);	
			}

		}
	}
	}
	catch(ex)
	{
	}
}

//http://www.delphifaq.com/faq/javascript/f1038.shtml 
//function to sort multiple data list box
//2006-08-09, 17:47:04. modified by anonymous poster
function sortListBox(target) 
{
	var lb = document.getElementById(target);
	arrTexts = new Array();
	arrValues = new Array();
	arrOldTexts = new Array();

	for(i=0; i<lb.length; i++)
	{
		arrTexts[i] = lb.options[i].text;
		arrValues[i] = lb.options[i].value;
		
		arrOldTexts[i] = lb.options[i].text;
	}
	
	arrTexts.sort();
	
	for(i=0; i<lb.length; i++)
	{
		lb.options[i].text = arrTexts[i];
		for(j=0; j<lb.length; j++)
		{
			if (arrTexts[i] == arrOldTexts[j])
			{
				lb.options[i].value = arrValues[j];
				j = lb.length;
			}
		}
	}
}

//http://lists.evolt.org/pipermail/javascript/2004-February/006557.html
//edited: cikkim
function listBoxSelectall(target) {
	aOptions = document.getElementById(target).options;
	if(aOptions.length) {
		for(var i=0; i<aOptions.length; i++)
			aOptions[i].selected = 'selected';
	}
}

//swap display of 2 input
function swapItemDisplay(itemEnable, itemDisable)
{
	//split the variable into array
	itemEnable = itemEnable.split('|')
	itemDisable = itemDisable.split('|')
	
	//loop on size of array
	for(x=0; x<itemEnable.length; x++)
	{
		//enable
		if(document.getElementById(itemEnable[x]))
		{
			document.getElementById(itemEnable[x]).disabled=false;			//enable
			document.getElementById(itemEnable[x]).style.display='';		//display
		}
	}
	
	//loop on size of array
	for(x=0; x<itemDisable.length; x++)
	{
		//disable
		if(document.getElementById(itemDisable[x]))
		{
			document.getElementById(itemDisable[x]).disabled=true;			//disable
			document.getElementById(itemDisable[x]).style.display='none';	//hide
		}
	}
}//eof function

//swap enable of 2 input
function swapItemEnabled(itemEnable, itemDisable)
{
	//split the variable into array
	itemEnable = itemEnable.split('|')
	itemDisable = itemDisable.split('|')
	
	//loop on size of array
	for(x=0; x<itemEnable.length; x++)
	{
		//enable
		if(document.getElementById(itemEnable[x]))
		{
			document.getElementById(itemEnable[x]).disabled=false;
			document.getElementById(itemEnable[x]).style.color = '#000000';
		}
	}
	
	//loop on size of array
	for(x=0; x<itemDisable.length; x++)
	{
		//disable
		if(document.getElementById(itemDisable[x]))
		{
			document.getElementById(itemDisable[x]).disabled=true;
			document.getElementById(itemDisable[x]).style.color = '#999999';
		}
	}
}//eof function

//required: prototype.js
//to select ALL checkboxes
function prototype_selectAllCheckbox()
{
	//find all checkbox item
	var checkboxArr = $$('input[type="checkbox"]');

	for(var x=0; x < checkboxArr.size(); x++)
		checkboxArr[x].checked = true;
}

//required: prototype.js
//to unselect ALL checkboxes
function prototype_unselectAllCheckbox()
{
	//find all checkbox item
	var checkboxArr = $$('input[type="checkbox"]');

	for(var x=0; x < checkboxArr.size(); x++)
		checkboxArr[x].checked = false;
}

//to run ajax for ajax_updater (component item)
function exec_ajax_updater(target,itemid)
{
	var url = 'ajax_updater_wrapper.php';
	var params = 'itemid=' + itemid;
	var ajax = new Ajax.Updater({success: target},url,{method: 'get', parameters: params, onFailure: reportError});	
	
	setTimeout("exec_ajax_updater('"+target+"','"+itemid+"')", 1000);
}

//popup window
function winconfirm(){
	question = confirm("CONFIRM DELETE")
	if (question != "0"){
		window.open("LINK LOCATION", "NewWin", "toolbar=yes,location=yes,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=no,copyhistory=yes,width=635,height=260")
	}
}

//function for cascading dropdown ajax in tabular mode
//function ajaxCascadeTabular(elem,targetName,where,cascadeFamily)
function ajaxCascadeTabular(elem,targetName,where)
{
	if($F(elem).strip().length > 0)
	{
		//for reuslt target id
		var garbageRow = 2;
		var resultTargetID = 0;
		
		if(isNaN(elem.up(1).rowIndex - garbageRow))
			resultTargetID = 'result_' + targetName + '_' + (elem.up(2).rowIndex - garbageRow);
		else
			resultTargetID = 'result_' + targetName + '_' + (elem.up(1).rowIndex - garbageRow);
		
		var elemName = elem.name;
		var targetRow = elem.up(1).rowIndex;
		var target = document.getElementsByName(targetName + '[]');	
		
		if(targetRow == undefined)
		{
			targetRow = elem.up(2).rowIndex;
		}
		
		//if target is in same row index as elem, append div
		for(var x=0; x < target.length; x++)
		{		
		
			//window.alert('gggg');
			if(target[x].up(1).rowIndex == targetRow || target[x].up(2).rowIndex == targetRow)
			{
				//window.alert('ssss');
				
				//create the container div
				var newDiv = document.createElement('div');
				newDiv.id = resultTargetID;
				
				target[x].up().appendChild(newDiv);
				
				//get result
				var url = 'ajax_cascade_feeder.php';
				var params = '?item=' + target[x].name + '&where=' + where;
				var ajax = new Ajax.Updater({success: resultTargetID},url,{method: 'get', parameters: params});
				
				target[x].up().removeChild(target[x]);
			}
		}
	}
}

//function for cascading dropdown ajax in tabular mode
//function ajaxCascadeTabular(elem,targetName,where,cascadeFamily)
function ajaxCascadeForm(elem,targetName,where)
{
	if($F(elem).strip().length > 0)
	{
		//for reuslt target id
		var resultTargetID = 'result_' + targetName;
		
		var elemName = elem.name;
		var target = $(targetName);	
		
		//create the container div
		var newDiv = document.createElement('div');
		newDiv.id = resultTargetID;
		
		target.up().appendChild(newDiv);
		
		//get result
		var url = 'ajax_cascade_feeder_form.php';
		var params = '?item=' + target.name + '&where=' + where;
		var ajax = new Ajax.Updater({success: resultTargetID},url,{method: 'get', parameters: params});
		
		target.up().removeChild(target);
	}
}

//addition : 16-11-2009
function noSpace(e)
{
var snum;
var schar;
var scheck;

if(window.event) // IE
	{
	snum = e.keyCode;
	}
else if(e.which) // Netscape/Firefox/Opera
	{
	snum = e.which;
	}
schar = String.fromCharCode(snum);
scheck = /^[0-9]+$/;
return !scheck.test(schar);
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function extractNumber(obj, decimalPlaces, allowNegative)
{
	var temp = obj.value;
	
	// avoid changing things if already formatted correctly
	var reg0Str = '[0-9]*';
	if (decimalPlaces > 0) {
		reg0Str += '\\.?[0-9]{0,' + decimalPlaces + '}';
	} else if (decimalPlaces < 0) {
		reg0Str += '\\.?[0-9]*';
	}
	reg0Str = allowNegative ? '^-?' + reg0Str : '^' + reg0Str;
	reg0Str = reg0Str + '$';
	var reg0 = new RegExp(reg0Str);
	if (reg0.test(temp)) return true;

	// first replace all non numbers
	var reg1Str = '[^0-9' + (decimalPlaces != 0 ? '.' : '') + (allowNegative ? '-' : '') + ']';
	var reg1 = new RegExp(reg1Str, 'g');
	temp = temp.replace(reg1, '');

	if (allowNegative) {
		// replace extra negative
		var hasNegative = temp.length > 0 && temp.charAt(0) == '-';
		var reg2 = /-/g;
		temp = temp.replace(reg2, '');
		if (hasNegative) temp = '-' + temp;
	}
	
	if (decimalPlaces != 0) {
		var reg3 = /\./g;
		var reg3Array = reg3.exec(temp);
		if (reg3Array != null) {
			// keep only first occurrence of .
			//  and the number of places specified by decimalPlaces or the entire string if decimalPlaces < 0
			var reg3Right = temp.substring(reg3Array.index + reg3Array[0].length);
			reg3Right = reg3Right.replace(reg3, '');
			reg3Right = decimalPlaces > 0 ? reg3Right.substring(0, decimalPlaces) : reg3Right;
			temp = temp.substring(0,reg3Array.index) + '.' + reg3Right;
		}
	}
	
	obj.value = temp;
}
function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{
	var key;
	var isCtrl = false;
	var keychar;
	var reg;
		
	if(window.event) {
		key = e.keyCode;
		isCtrl = window.event.ctrlKey
	}
	else if(e.which) {
		key = e.which;
		isCtrl = e.ctrlKey;
	}
	
	if (isNaN(key)) return true;
	
	keychar = String.fromCharCode(key);
	
	// check for backspace or delete, or if Ctrl was pressed
	if (key == 8 || isCtrl)
	{
		return true;
	}

	reg = /\d/;
	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
	
	return isFirstN || isFirstD || reg.test(keychar);
}

//addition : 20-11-2009
//titlecase
function TitleCase(objField) 
{
      var objValues = objField.value.split(" ");
      var outText = "";
      for (var i = 0; i < objValues.length; i++) {
      outText = outText + objValues[i].substr(0, 1).toUpperCase() + objValues[i].substr(1).toLowerCase() + ((i < objValues.length - 1) ? " " : "");
      }
      return outText;
} 

//email validation
function isEmail(elem) {
emailRegex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
var emailid = elem.value;
if( !emailid.match( emailRegex ) )
{
alert( 'Sila masukkan Emel yang sah.' );
elem.focus();
return false;
}
return true;
}

//disable control key
function onKeyDown() 
{
// current pressed key
var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

if (event.ctrlKey && (pressedKey == "c" || pressedKey == "v")) 
{
// disable key press porcessing
event.returnValue = false;
}
} // onKeyDown


function noCTRL(e)
{
var code = (document.all) ? event.keyCode:e.which;

var msg = "Control Function disabled.";
if (parseInt(code)==17) //CTRL
{
alert(msg);
window.event.returnValue = false;
}
}


//disable right click
function whichButton(event)
{
if (event.button==2)//RIGHT CLICK
{
alert("Not Allow Right Click!");
}

}

//disable right-click
//var mykad = document.getElementById('ic');
this.document.oncontextmenu = function(){
window.status = 'Right-click is disabled';
return false;
}

//disable select + Copy + Paste
//form tags to omit in NS6+:
/*var omitformtags=["input", "textarea", "select"]

omitformtags=omitformtags.join("|")

function disableselect(e){
if (omitformtags.indexOf(e.target.tagName.toLowerCase ())==-1)
return false
}

function reEnable(){
return true
}

if (typeof document.onselectstart!="undefined")
document.onselectstart=new Function ("return false")
else{
document.onmousedown=disableselect
document.onmouseup=reEnable
}*/