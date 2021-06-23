//target - text, label, div, span
function countColumnTotal(formName,target,targetType,columnNo,decimalPlaces)
{	
	var theForm = document.getElementById(formName);		//assign form reference to var
	var total = 0;											//declare total var
	var formLength = theForm.length							//declare total length of form
	var theTarget = document.getElementById(target);		//assign target reference to var
	
	//for whole length of form 
	for(var i=0; i < formLength; ++i) 
	{	
		//if element = input text
		if(theForm.elements[i].type == 'text')
		{	
			//if id of element = XXX
			if((theForm.elements[i].id).match(columnNo))
			{	
				if(isNaN(parseFloat(theForm.elements[i].value)))
					total = total + 0;
				
				else
					total = total + parseFloat(theForm.elements[i].value)
			}//end if
		}//end if theform
	}//end for
	
	//if total is a number, add decimal places
	if(!isNaN(total))
		total = total.toFixed(decimalPlaces);				//set total to decimal places
	
	//if target is self, return the total value
	if(target == 'self')
		return total;
	
	//else assign total to target (use ID)
	else 
	{
		//if target = input text, assign total to target
		if(theTarget.type == 'text')
			theTarget.value = total;
		
		//if target is label,div, span -> set value to innerhtml property of target
		else if(targetType == 'label' || targetType == 'div' || targetType == 'span')
			theTarget.innerHTML = total;
	}
}//end function

//function to aggregate data in table columns IN ARRAY (amount[], amount[])
function aggregateColumnApek(aggType,theElem,target,format,targetIndex)
{
	var total = 0;													//define total var
	var returnValue = 0;											//define return value
	var theMin;														//define minimum value
	var theMax;														//define maximum value
	
	if(document.getElementsByName(theElem).length>0)
		theElemByName = document.getElementsByName(theElem);			//create element reference
	
	else
		theElemByName = document.getElementsByName(theElem.name);		//create element reference
	
	//if target index is null, use id
	if(targetIndex == null)
		theTarget = document.getElementById(target);					//create target reference
	
	//else, assume its an array
	else
		theTarget = document.getElementsByName(target)[targetIndex];					//create target reference

	totalElems = theElemByName.length;								//count total number of elements by the name of theElem
	
	//if aggregate type is count, return number of elems as COUNT
	/*if(aggType == 'count')
		returnValue = totalElems	-fais20080530*/
		
	if(aggType == 'count')
	{
		returnValue = totalElems
		
		for(var x=0; x < totalElems; x++)
		{
			theValue = theElemByName[x].value;	
			if(theValue==null)
				returnValue--
		}
	}
		
	
	//else if aggregate type is sum, min, max
	else if(aggType == 'sum' || aggType == 'min' || aggType == 'max')
	{
		//for all element by the name of theElem, total up
		for(var x=0; x < totalElems; x++)
		{
			//check thousand
			if(new RegExp(",").test(theElemByName[x].value))
			{	
				//strip ',' sign
				theValue = removeChar(',','',theElemByName[x].value)
				
				//if format not set
				if(!format)
					format = 'thousand'		//set as thousand format
			}//eof if
			else
				theValue = theElemByName[x].value;				//parse the value to float
			
			if(format != 'currency')
			{
				//check for decimal places			
				if(new RegExp("\\.").test(theValue))
					theValue=parseFloat(theValue).toFixed(2)	//set as float
				else
					theValue=parseInt(theValue)
			}
			
			//if the current element is not NOT a number
			if(!isNaN(theValue))
			{	
				//if aggregate type = min
				if(aggType == 'min')
				{
					//if first iteration, thevalue is the minimum
					if(x == 0)
						returnValue = theValue;
					else
						returnValue = Math.min(returnValue,theValue);					//else, compare
				}//eof if
				
				//if aggregate type = max
				else if(aggType == 'max')
				{
					//if first iteration, thevalue is the maximum
					if(x == 0)
						returnValue = theValue;
					else
						returnValue = Math.max(returnValue,theValue);					//else compare
				}//eof else if
				
				//if aggregate type = sum
				else if(aggType == 'sum')
				{
					if(format != 'currency' && (new RegExp("\\.").test(theValue) || new RegExp("\\.").test(returnValue)))
					{
						returnValue = parseFloat(returnValue) + parseFloat(theValue);					//total up
						returnValue=parseFloat(returnValue).toFixed(2)									//set as 2 decimal
					}
					else
						returnValue = parseFloat(returnValue) + parseFloat(theValue);					//total up
				}
			}//end if not is nan
		}//end for
	}//end else if
	
	/*//choose stuff to return
	if(aggType == 'sum')
		returnValue = total;			//return total
	
	else if(aggType == 'min')
		returnValue = theMin;			//return min
	
	else if(aggType == 'max')
		returnValue = theMax;			//return max
	
	else if(aggType == 'count')
		returnValue = returnValue;		//return number of elems*/
	
	if(format != 'currency')
	{
		//if number
		if(!isNaN(returnValue))
		{
			//check for decimal places			
			if(new RegExp("\\.").test(returnValue))
				returnValue=parseFloat(returnValue).toFixed(2)	//set as float
			else
				returnValue=parseInt(returnValue)
		}//eof if
	}//eof if
	
	//if format is currency
	if(format == 'thousand')
		theTarget.value = formatThousand(returnValue);					//set target with return value
	else if(format == 'currency')
		theTarget.value = formatCurrency(returnValue);					//set target with return value
	else
		theTarget.value = returnValue;									//set target with return value
}

//THE ORIGINAL
//function to aggregate data in table columns IN ARRAY (amount[], amount[])
function aggregateColumn(aggType,theElem,target,format)
{
	var total = 0;													//define total var
	var returnValue = 0;											//define return value
	var theMin;														//define minimum value
	var theMax;														//define maximum value
	
	if(document.getElementsByName(theElem).length>0)
		theElemByName = document.getElementsByName(theElem);			//create element reference
	
	else
		theElemByName = document.getElementsByName(theElem.name);		//create element reference
	
	//if target index is null, use id
	//if(targetIndex == null)
		theTarget = document.getElementById(target);					//create target reference
	
	//else, assume its an array
	//else
		//theTarget = document.getElementsByName(target)[targetIndex];					//create target reference

	totalElems = theElemByName.length;								//count total number of elements by the name of theElem
	
	//if aggregate type is count, return number of elems as COUNT
	/*if(aggType == 'count')
		returnValue = totalElems	-fais20080530*/
		
	if(aggType == 'count')
	{
		returnValue = totalElems
		
		for(var x=0; x < totalElems; x++)
		{
			theValue = theElemByName[x].value;	
			if(theValue==null)
				returnValue--
		}
	}
		
	
	//else if aggregate type is sum, min, max
	else if(aggType == 'sum' || aggType == 'min' || aggType == 'max')
	{
		//for all element by the name of theElem, total up
		for(var x=0; x < totalElems; x++)
		{
			//check thousand
			if(new RegExp(",").test(theElemByName[x].value))
			{	
				//strip ',' sign
				theValue = removeChar(',','',theElemByName[x].value)
				
				//if format not set
				if(!format)
					format = 'thousand'		//set as thousand format
			}//eof if
			else
				theValue = theElemByName[x].value;				//parse the value to float
			
			if(format != 'currency')
			{
				//check for decimal places			
				if(new RegExp("\\.").test(theValue))
					theValue=parseFloat(theValue).toFixed(2)	//set as float
				else
					theValue=parseInt(theValue)
			}
			
			//if the current element is not NOT a number
			if(!isNaN(theValue))
			{	
				//if aggregate type = min
				if(aggType == 'min')
				{
					//if first iteration, thevalue is the minimum
					if(x == 0)
						returnValue = theValue;
					else
						returnValue = Math.min(returnValue,theValue);					//else, compare
				}//eof if
				
				//if aggregate type = max
				else if(aggType == 'max')
				{
					//if first iteration, thevalue is the maximum
					if(x == 0)
						returnValue = theValue;
					else
						returnValue = Math.max(returnValue,theValue);					//else compare
				}//eof else if
				
				//if aggregate type = sum
				else if(aggType == 'sum')
				{
					if(format != 'currency' && (new RegExp("\\.").test(theValue) || new RegExp("\\.").test(returnValue)))
					{
						returnValue = parseFloat(returnValue) + parseFloat(theValue);					//total up
						returnValue=parseFloat(returnValue).toFixed(2)									//set as 2 decimal
					}
					else
						returnValue = parseFloat(returnValue) + parseFloat(theValue);					//total up
				}
			}//end if not is nan
		}//end for
	}//end else if
	
	/*//choose stuff to return
	if(aggType == 'sum')
		returnValue = total;			//return total
	
	else if(aggType == 'min')
		returnValue = theMin;			//return min
	
	else if(aggType == 'max')
		returnValue = theMax;			//return max
	
	else if(aggType == 'count')
		returnValue = returnValue;		//return number of elems*/
	
	if(format != 'currency')
	{
		//if number
		if(!isNaN(returnValue))
		{
			//check for decimal places			
			if(new RegExp("\\.").test(returnValue))
				returnValue=parseFloat(returnValue).toFixed(2)	//set as float
			else
				returnValue=parseInt(returnValue)
		}//eof if
	}//eof if
	
	//if format is currency
	if(format == 'thousand')
		theTarget.value = formatThousand(returnValue);					//set target with return value
	else if(format == 'currency')
		theTarget.value = formatCurrency(returnValue);					//set target with return value
	else
		theTarget.value = returnValue;									//set target with return value
}


//function to aggregate data in table columns UNIQUE NAME ( amount_1, amount_2, amount_3)
function aggregateColumnUnique(aggType,theElem,target)
{
	var total = 0;													//define total var
	var returnValue;												//define return value
	var theMin;														//define minimum value
	var theMax;														//define maximum value
	
	if(document.getElementsByName(theElem).length > 0)
		theElemByName = document.getElementsByName(theElem);			//create element reference
	
	else
		theElemByName = document.getElementsByName(theElem.name);		//create element reference
		
	theTarget = document.getElementById(target);					//create target reference
	totalElems = theElemByName.length;								//count total number of elements by the name of theElem
	
	//if aggregate type is count, return number of elems as COUNT
	if(aggType == 'count')
		returnValue = totalElems
	
	//else if aggregate type is sum, min, max
	else if(aggType == 'sum' || aggType == 'min' || aggType == 'max')
	{	
		//for all element by the name of theElem, total up
		for(var x=1; x < 15; x++)
		{	
			//if((theForm.elements[i].id).match(columnNo))
		
			//if(document.getElementsByName(xxMinus)[0].value == null)
			//	document.getElementsByName(xxMinus)[0].value = 0;
		
			var xx = theElem.name;
			var xxMinus = xx.substring(0,xx.length-1) + x.toString();
			
			window.alert(document.getElementsByName(xxMinus)[0].value);
			theValue = parseFloat(document.getElementsByName(xxMinus)[0].value);				//parse the value to float
			
			//if the current element is not NOT a number
			if(!isNaN(theValue))
			{	
				//if aggregate type = min
				if(aggType == 'min')
				{
					//if first iteration, thevalue is the minimum
					if(x == 0)
						theMin = theValue;
					else
						theMin = Math.min(theMin,theValue);					//else, compare
				}
				
				//if aggregate type = max
				else if(aggType == 'max')
				{
					//if first iteration, thevalue is the maximum
					if(x == 0)
						theMax = theValue;
					else
						theMax = Math.max(theMax,theValue);					//else compare
				}
				
				//if aggregate type = sum
				else if(aggType == 'sum')
					total = total + theValue;								//total up
			}//end if not is nan
		}//end for
	}//end else if
	
	//choose stuff to return
	if(aggType == 'sum')
		returnValue = total;			//return total
	
	else if(aggType == 'min')
		returnValue = theMin;			//return min
	
	else if(aggType == 'max')
		returnValue = theMax;			//return max
	
	else if(aggType == 'count')
		returnValue = returnValue;		//return number of elems
	
	//set target with return value
	theTarget.value = returnValue;
}