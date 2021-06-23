/* 
	edited 20070709 
	added sending vars to applyCascadingDropdowns function
*/

function applyCascadingDropdown(sourceId, targetId) 
{
	var source = document.getElementById(sourceId);
	var target = document.getElementById(targetId);
	
	if (source && target) 
	{
		source.onchange = function() 
		{
			displayOptionItemsByClass(target, source.value);
		}
		
		displayOptionItemsByClass(target, source.value);
	}
}

function displayOptionItemsByClass(selectElement, className) 
{
	if (!selectElement.backup) 
	{
		selectElement.backup = selectElement.cloneNode(true);
	}
	
	var options = selectElement.getElementsByTagName("option");
	
	for(var i=0, length=options.length; i<length; i++) 
	{
		selectElement.removeChild(options[0]);
	}
	
	var options = selectElement.backup.getElementsByTagName("option");
	
	for(var i=0, length=options.length; i<length; i++) 
	{
		if (options[i].className==className)
			selectElement.appendChild(options[i].cloneNode(true));
	}
}

function applyCascadingDropdowns() 
{
	applyCascadingDropdown("categories","items");
	applyCascadingDropdown("items","foo");
	applyCascadingDropdown("foo","goo");
}

window.onload = applyCascadingDropdowns;
