<script type="text/javascript" src="tools/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<?php
//function to build input
function buildInput($myQuery='',$dbc='',$length='',$type='',$default='',$defaultQuery='',$lookup='',$lookupSecondary='',$id='',$mapping='',$preAction='',$preValue='',
						$javascriptEvent='',$javascript='',$name='',$tabindex='',$sysid='',$minchar='',$maxchar='',$textarearows='',$required='',$componentid='',
						$runningNo='',$textalign='',$case='',$disabled='',$readonly='')
{	
	$cssInputClass = "inputInput";
	
	//unset length if 0
	if($length==0)
		unset($length);
	
	if($type == 'url')
	{
		$default = str_replace('\\','',convertDBSafeToQuery($default));
		$default = str_replace('"',"'",$default);
	}
	
	//replaced by fais (for POST,GET,SESSION)
	$default= convertDBSafeToQuery($default);
	$lookup = convertDBSafeToQuery($lookup);

	//if default in sql mode
	if($defaultQuery&&$default)
	{
		$tempDefault = $myQuery->query($default);
		
		//if default value more than 1 value
		if(count($tempDefault)==1)
			$default = $tempDefault[0][0];
		else
			$default = $tempDefault;
	}//eof if
	
	//current date
	if(eregi("{CONST|CURRENT_DATE}",$lookup))
	{
		$lookup = str_replace("{CONST|CURRENT_DATE}",date('Y-m-d'),$lookup);
	}
	
	//get current running no
	if(eregi("{CONST|RUNNING_NO}",$lookup))
	{
		$lookup = str_replace("{CONST|RUNNING_NO}",$runningNo,$lookup);
	}
	
	//for javascript
	//get current running no
	if(eregi("{CONST|RUNNING_NO}",$javascript))
	{
		$javascript = str_replace("{CONST|RUNNING_NO}",$runningNo,$javascript);
	}
	
	//text alignment
	if($textalign != null || $testalign != '')
		$css .= 'text-align:'.$textalign.';';
		
	//case
	if($case=='1')
		$css .= 'text-transform:uppercase;';
	
	//disabled
	if($disabled)
		$disabled=' disabled ';
	else
		$disabled='';
	
	//readonly
	if($readonly)
		$readonly=' readonly ';
	else
		$readonly='';
	
	if($readonly&&!$disabled)
		$css .= 'background-color:#F2F2F2;';
	
	//for readonly
	$cssReadonlyStyle = 'style="background-color:#F2F2F2;'.$textalign.';'.$case.'"';
	
	if($javascriptEvent != "")
	{	
		//get javascript event
		$getJavascriptEvent = $myQuery->query("select DESCRIPTION1 from REFSYSTEM 
														where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' 
																			and DESCRIPTION1 = 'PAGE_CTRL_ACTION_JS_BUTTON') 
														and REFERENCECODE = '".$javascriptEvent."'",'SELECT','NAME');
		
		if($getJavascriptEvent[0]["DESCRIPTION1"] != "")
			$js .= $getJavascriptEvent[0]["DESCRIPTION1"]." = \"".convertToDBQry($javascript)."\"";
	}
	
	
	//create input here
	
	if($type == "text")
	{	
		//if theres sql lookup
		if($lookup != "")
		{
			$resultArr = $myQuery->query($lookup,'SELECT','INDEX');
			$default = $resultArr[0][0];
		}//eof lookup -fais20080528
		
		//qusiah punye check ic
		//3331_5171 5170 3211
		//6514_9172 9171 6291	
			
		if(($_GET['menuID']=='3211' && ($id == '5171' || $id=='5170')) || ($_GET['menuID']=='6291' && ($id == '9171' || $id=='9172')))	
		{
		
			$checkqus = "onkeydown='onKeyDown()'";
		
		}
		
		
		//
		
		
		$toReturn = "<input name=\"input_map_".$componentid."_".$id."\" ".$checkqus." id=\"input_map_".$componentid."_".$id."\" type=\"".$type."\" tabindex=\"".$tabindex."\" maxlength=\"".$maxchar."\" class=\"".$cssInputClass."\" "; 
		$toReturn .= "value=\"".$default."\" size=\"".$length."\" style=\"".$css." \"";
		
		//for min character
		if($minchar != '' || $minchar != 0)
			$toReturn .= " onchange=\"if(this.value.length < ".$minchar.") alert('Ralat! Sila isikan nilai lebih dari ".$minchar." aksara');\"";
		
		$toReturn .= $js." ".$disabled.$readonly." />";
		
		return $toReturn;
	}
	
	//if type if file upload
	if($type == 'file')
	{
		//$name = 
		return '<input name="input_map_'.$componentid.'_'.$id.'" id="input_map_'.$componentid.'_'.$id.'" type="file" tabindex="'.$tabindex.'"  size="'.$length.'" '.$js.' />';
	}
	
	else if($type == "password" || $type == "password_md5")
	{	
		//if theres sql lookup
		if($lookup != "")
		{
			$resultArr = $myQuery->query($lookup,'SELECT','INDEX');
			$default = $resultArr[0][0];
		}//eof lookup -fais20080528
		
		$toReturn = "<input name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" type=\"password\" tabindex=\"".$tabindex."\" maxlength=\"".$maxchar."\" ";
		$toReturn .= "class=\"".$cssInputClass."\" value=\"".$default."\" size=\"".$length."\" ";
		
		//for min character
		if($minchar != '' || $minchar != 0)
			$toReturn .= " onchange=\"if(this.value.length < ".$minchar.") alert('Ralat! Sila isikan nilai lebih dari ".$minchar." aksara');\"";
		
		$toReturn .= $js." ".$disabled.$readonly." />";
		
		return $toReturn;	
	}
	
	else if($type == "hidden")
	{	
		//if theres sql lookup
		if($lookup != "")
		{	
			$theArr = $myQuery->query($lookup,'SELECT','INDEX');
			$default = $theArr[0][0];
		}
		
		return "<input name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" type=\"".$type."\" value=\"".$default."\" size=\"".$length."\" />";
	}
	
	else if($type == "running_no")
	{	
		if($default=='')
			$default=1;
			
		//if theres sql lookup
		if($lookup != "")
		{	
			$theArr = $myQuery->query($lookup,'SELECT','INDEX');
			$default = $theArr[0][0];
		}
		
		?>
		<script language="javascript">
			function doByTime(itemname,defaultNo)
			{
				var tempObj=document.getElementsByName(itemname)
				for($x=0;$x<tempObj.length;$x++)
					tempObj[$x].value=$x+parseInt(defaultNo)
					
				setTimeout("doByTime('"+itemname+"',"+defaultNo+")", 100)
			}
		</script>
		<script language="javascript">
			setTimeout("doByTime('<?php echo 'input_map_'.$componentid.'_'.$id.'[]'; ?>','<?php echo $default;?>')", 100)
		</script>
		<?php
		return "<input name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" type=\"text\" tabindex=\"".$tabindex."\" class=\"".$cssInputClass."\" value=\"".($default)."\" size=\"".$length."\" ".$js." style=\"".$css."\" ".$disabled.$readonly." />";
	}
	
	else if($type == "input_date")
	{	
		//if theres sql lookup
		if($lookup != "")
		{	
			$theArr = $myQuery->query($lookup,'SELECT','INDEX');
			
			$default=$theArr[0][0];
		}
		
		return '<input name="input_map_'.$componentid.'_'.$id.'" id="input_map_'.$componentid.'_'.$id.'" type="text" tabindex="'.$tabindex.'" class="w8em '.DEFAULT_DATE_FORMAT.' divider-dash highlight-days-67" value="'.$default.'" size="'.$length.'" '.$js.' '.$disabled.$readonly.' style="'.$css.'" />';
	}
	
	//for ajax periodical updater
	else if($type == "ajax_updater")
	{	
	
		//if theres sql lookup
		if($lookup != "")
		{
			$resultArr = $myQuery->query($lookup,'SELECT','INDEX');
			
			$default=$resultArr[0][0];
		}
		?>
		<script language="javascript">
			setTimeout("exec_ajax_updater('<?php echo 'ajax_updater_'.$componentid.'_'.$id;?>','<?php echo $id;?>')", 100)
		</script>
		<?php
		
		return "<div id=\"ajax_updater_".$componentid."_".$id."\"><input name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" type=\"text\" tabindex=\"".$tabindex."\" class=\"".$cssInputClass."\" value=\"".$default."\" size=\"".$length."\" ".$js." readonly=\"readonly\" ".$cssReadonlyStyle." /></div>";
	}
	
	//for ajax periodical updater subsequent calls
	else if($type == "ajax_updater_subsequent")
	{	
	
		//if theres sql lookup
		if($lookup != "")
		{
			$resultArr = $myQuery->query($lookup,'SELECT','INDEX');
			
			$default=$resultArr[0][0];
		}

		return "<input name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" type=\"text\" tabindex=\"".$tabindex."\" class=\"".$cssInputClass."\" value=\"".$default."\" size=\"".$length."\" ".$js." readonly=\"readonly\" ".$cssReadonlyStyle." />";
	}
	
	
	//if type is label
	else if($type == "label_with_hidden")
	{
		//if its a lookup, get description
		if($lookup != "")
		{
			//get label description
			$lookupRs = $myQuery->query($lookup,'SELECT','NAME');
			
			//if hav lookup
			if($lookupRs[0]['FLC_ID'])		//flc_id
				$default=$lookupRs[0]['FLC_ID'];
			
			if($lookupRs[0]['FLC_NAME'])		//flc_name
				$label=$lookupRs[0]['FLC_NAME'];
			else
				$label=$default;
			
			//length of label
			if(!$length)
				$length='95%';
			else
				$length.='px';
			
			return '<label style="display:block; width:'.$length.';'.$css.'" '.$js.'>'.$label.'</label>'.
					"<input name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" tabindex=\"".$tabindex."\" type=\"hidden\" class=\"inputInput\" value=\"".$default."\" size=\"".$length."\" />";
		}
		//else just return the value
		else
			return '<label style="display:block; width:'.$length.';'.$css.'" '.$js.'>'.$default.'</label>'.
					"<input name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" tabindex=\"".$tabindex."\" type=\"hidden\" class=\"inputInput\" value=\"".$default."\" size=\"".$length."\" />";
	}
		
	//if type is label
	else if($type == "label")
	{
		//length of label
		if(!$length)
			$length='95%';
		else
			$length.='px';
		
		//if its a lookup, get description
		if($lookup != "")
		{
			//get label description
			$lookupRs = $myQuery->query($lookup,'SELECT','NAME');
			
			for($x=0; $x < count($lookupRs); $x++) 
			{ 	
				if($lookupRs[$x]["FLC_ID"] == $default)
					$temp .= $lookupRs[$x]["FLC_NAME"];
			}
			return '<label style="display:block; width:'.$length.';'.$css.'" '.$js.'>'.$temp.'</label>';
		}
		//else just return the value
		else
			return '<label style="display:block; width:'.$length.';'.$css.'" '.$js.'>'.$default.'</label>';
			//return $default;
	}
		
	else if($type == "dropdown")
	{	
		$temp = "<select name=\"input_map_".$componentid."_".$id."\" tabindex=\"".$tabindex."\" id=\"input_map_".$componentid."_".$id."\" class=\"inputList\" ".$js." ".$disabled.$readonly." >";	//open select
		if($lookup != "")
		{
			$lookupRs = $myQuery->query($lookup,'SELECT','NAME');
		
			$temp .= "<option> </option>";
			
			for($x=0; $x < count($lookupRs); $x++) 
			{ 	
				$temp .= "<option value=\"".$lookupRs[$x]["FLC_ID"]."\"";

				//to select value
				if($lookupRs[$x]["FLC_ID"] == $default)
					$temp .= " selected >";
				else
					$temp .= " >";
				
				$temp .= $lookupRs[$x]["FLC_NAME"]."</option>";
			}
		}
		$temp .= "</select>";	//close select
		
		return $temp;
  	}
	
	if($type == "lov_popup")
	{	
		//if have lookup
		if($lookup != '')
		{
			//get lookup
			$lookupRs = $myQuery->query($lookup,'SELECT','NAME');
			$lookupRsCount = count($lookupRs);
			
			//loop on count of lookup
			for($x=0;$x<$lookupRsCount;$x++)
			{
				if($lookupRs[$x]['FLC_ID']==$default)
					$label=$lookupRs[$x]['FLC_NAME'];
			}//eof for
		}//eof if
		
		//if no label
		if(!$label)
			$label=$default;
		
		//process post data
		if($_POST)
		{
			$postCount = count($_POST);
			$postKeys = array_keys($_POST);
			$postKeysCount = count($postKeys);
			
			//loop on count of post
			for($x=0;$x<$postCount;$x++)
			{
				if(eregi('input_map_',$postKeys[$x]))
					$postItem .= '&'.$postKeys[$x].'='.$_POST[$postKeys[$x]];
			}//eof for
		}//eof if
		
		//hidden value
		$temp .= '<input name="input_map_'.$componentid.'_'.$id.'" id="input_map_'.$componentid.'_'.$id.'" type="hidden" value="'.$default.'" />';
		
		//text to show
		$temp .= '<input name="lov_text_'.$componentid.'_'.$id.'" id="lov_text_'.$componentid.'_'.$id.'" type="'.$type.'" class="'.$cssInputClass.'" readonly="readonly" '.$cssReadonlyStyle.' value="'.$label.'" size="'.$length.'" '.$js.' />';
		
		//lov button
		$temp .= ' <input name="lov_button_'.$componentid.'_'.$id.'" id="lov_button_'.$componentid.'_'.$id.'" type="button" class="inputButton" value=" ... " onclick="my_popup(\'lov_view\',\'id=\'+this.id+\''.$postItem.'\',1,1,400,470);" '.$disabled.' />';
		
		//return value
		return $temp;
  	}
	
	else if($type == "listbox")
	{	
		if($lookup != "")
		{	
			$dropdownArr = $myQuery->query($lookup,'SELECT','NAME');
		
			$temp = "<select name=\"input_map_".$componentid."_".$id."[]\" tabindex=\"".$tabindex."\" size=\"".$textarearows."\" id=\"input_map_".$componentid."_".$id."[]\" class=\"inputList\" ".$js." multiple=\"mutiple\" ".$disabled.$readonly." style=".$css." >";
			
			for($x=0; $x < count($dropdownArr); $x++) 
			{ 	
				$temp .= "<option value=\"".$dropdownArr[$x]["FLC_ID"]."\"";

				//to select value
				if($dropdownArr[$x]["FLC_ID"] == $default)
					$temp .= " selected >";
				else
					$temp .= " >";
				
				$temp .= $dropdownArr[$x]["FLC_NAME"]."</option>";
			}
			 
			$temp .= "</select>";
		}
		
		return $temp;
  	}
	
	else if($type == "ajax_dropdown")
	{	
		if($lookup != "")
		{
			//build dropdown
			$dropdownArr = $myQuery->query(str_replace('"',"'",$lookup),'SELECT','NAME');

			$temp = "<select name=\"input_map_".$componentid."_".$id."\" tabindex=\"".$tabindex."\" id=\"input_map_".$mapping."\" class=\"inputList\">";
			$temp .= "<option> </option>";
			
			for($x=0; $x < count($dropdownArr); $x++) 
			{ 	
				$temp .= "<option value=\"".$dropdownArr[$x]["id"]."\"";

				//to select value
				if($dropdownArr[$x]["FLC_ID"] == $default)
					$temp .= " selected ".$js." >";
				else
					$temp .= " ".$js." >";
				
				$temp .= $dropdownArr[$x]["FLC_NAME"]."</option>";
			}
			 
			$temp .= "</select>";
		}
		
		return $temp;
  	}
	
	//-------------------------------------------------------
	else if($type == "js_cascade_dropdown")
	{	
		if($lookup != "")
		{
			//build dropdown
			$dropdownArr = $myQuery->query(str_replace('"',"'",$lookup),'SELECT','NAME');
			$temp = "<select name=\"input_map_".$componentid."_".$id."\" tabindex=\"".$tabindex."\" id=\"input_map_".$mapping."\" class=\"inputList\" ".$js." >";
			$temp .= "<option> </option>";
			
			for($x=0; $x < count($dropdownArr); $x++) 
			{ 	
				$temp .= "<option value=\"".$dropdownArr[$x]["FLC_ID"]."\"";

				//to select value
				if($dropdownArr[$x]["FLC_ID"] == $default)
					$temp .= " selected class=\"".$dropdownArr[$x]["parent"]."\" >";
				else
					$temp .= " class=\"".$dropdownArr[$x]["parent"]."\" >";
				
				$temp .= $dropdownArr[$x]["FLC_NAME"]."</option>\n";
			}
			 
			$temp .= "</select>";
		}
		
		return $temp;
  	}
	//-------------------------------------------
			
	else if($type == "radio")
	{	
		if($lookup != "")
		{
			//build radiobutton group
			$radioArr = $myQuery->query($lookup,'SELECT','NAME');

			for($x=0; $x < count($radioArr); $x++) 
			{ 	
				$temp .= "<label><input type=\"radio\" name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" tabindex=\"".$tabindex."\" value=\"".$radioArr[$x]["FLC_ID"]."\" ";
				
				//to select value
				if($radioArr[$x]["FLC_ID"] == $default)
					$temp .= " checked=\"checked\" ".$js." ";
				else
					$temp .= " ".$js." ";
				
				$temp .= " ".$disabled.$readonly." />".$radioArr[$x]["FLC_NAME"]."</label>";
			}
		}
		
		return $temp;
  	}
	
	//if checkbox with lookup
	else if($type == 'checkbox')
	{
		if($lookup != "")
		{
			//build checkbox group
			$checkboxArr = $myQuery->query($lookup,'SELECT','NAME');
			
			for($x=0; $x < count($checkboxArr); $x++) 
			{ 	
				$temp .= '<label><input type="checkbox" name="input_map_'.$componentid.'_'.$id.'[]" id="input_map_'.$componentid.'_'.$id.'" tabindex="'.$tabindex.'" value="'.$checkboxArr[$x]['FLC_ID'].'" ';
				
				//to select value
				if(is_string($default)&&$checkboxArr[$x]['FLC_ID'] && $checkboxArr[$x]['FLC_ID'] == $default)
					$temp .= ' checked="checked" '.$js.' ';
				else if(is_array($default)&&$checkboxArr[$x]['FLC_ID'])
				{
					//loop on count of default
					for($y=0;$y<count($default);$y++)
					{
						if($checkboxArr[$x]['FLC_ID'] == $default[$y][0])
							$temp .= ' checked="checked" ';
					}//eof for
				}//eof else if
				else
					$temp .= ' '.$js.' ';
				
				$temp .= ' '.$disabled.$readonly.' />'.$checkboxArr[$x]['FLC_NAME'].'</label>';
				
				if($x+1 != count($checkboxArr))
					$temp .= '<br>';
			}
		
			return $temp;
		}
	}
	
	else if($type == "textarea")
	{	
		if($lookup != "")
		{
			$theArr = $myQuery->query($lookup,'SELECT','INDEX');
			
			$default = $theArr[0][0];
		}
	
		$toReturn = "<textarea name=\"input_map_".$componentid."_".$id."\" id=\"input_map_".$componentid."_".$id."\" tabindex=\"".$tabindex."\" class=\"".$cssInputClass."\" rows=\"".$textarearows."\" style=\"".$css."\"";
		$toReturn .= "cols=\"".$length."\" ";
		
		//for min character
		if($minchar != '' || $minchar != 0)
			$toReturn .= " onchange=\"	if(this.value.length < ".$minchar.") 
											alert('Ralat! Sila isikan nilai lebih dari ".$minchar." aksara');\"
										onkeydown=\"if(this.value.length >= ".$maxchar.") this.value = this.value.substring(0, ".$maxchar.") \"";
		
		$toReturn .= $js." ".$disabled.$readonly." >".$default."</textarea>";
		
		return $toReturn;
	}
	
	if($type == "text_editor")
	{
		if($lookup != "")
		{
			$theArr = $myQuery->query($lookup,'SELECT','INDEX');
			
			$default = $theArr[0][0];
		}
		
		if($default)
		{
			$default = str_replace("\n",'',$default);		//" sign
			$default = str_replace("\r",'',$default);		//" sign
			$default = str_replace("\n\n",'',$default);		//" sign
		}//eof if
		
		//check whether caller is tabular or form --> form/tabular
		$compType = checkTabularOrForm($myQuery,$componentid);
		
		//ckeditor
		$toReturn = '<textarea name="input_map_'.$componentid.'_'.$id.'" id="input_map_'.$componentid.'_'.$id.'" class="ckeditor">'.$default.'</textarea>';

		return $toReturn;
	}
	
	else if($type == "linkbutton")
	{
		return "<a href=\"javascript:void(0)\" ".$js." onclick=\"form1.action = '".$default."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page']."'; form1.submit();\" >papar</a> ";
	}
	
	//if type is url
	else if($type == "url")
	{	
		//if hav name
		if($name == '')
			$name='Papar';
		
		//if hav lookup
		if($lookup != '')
		{	
			//execute lookup	
			$urlArr = $myQuery->query($lookup,'SELECT','NAME');

			//count row and column
			$urlArrRowCount = count($urlArr);				//row
			$urlArrColumnCount = count($urlArr[0]);			//column
			
			//if this is not null, get keys [ADDED IF cikkim 20080417]
			if($urlArr[0] != '')
				$urlKeys = array_keys($urlArr[0]);		//keys
			
			//loop on lookup row
			for($x=0; $x < $urlArrRowCount; $x++)
			{
				$tempUrl = '';	//initial value
				
				//if lookup hav FLC_NAME
				if($urlArr[$x]['FLC_NAME']!='')
					$urlName = $urlArr[$x]['FLC_NAME'];
				else
					$urlName = $name;
					
				//if lookup hav FLC_ID
				if($urlArr[$x]['FLC_ID']!='')
					$default = $urlArr[$x]['FLC_ID'];
				
				$tempUrl .= "<a href=\"".$default."\" ".$js." >".$urlName."</a> ";
				
				//loop on lookup column
				for($y=0; $y < $urlArrColumnCount; $y++)
				{
					if($urlKeys[$y] != 'FLC_NAME' && $urlKeys[$y] != 'FLC_ID')
					{
						//get parameter
						$keyName = $urlKeys[$y];
						
						$tempUrl = appendUrl($tempUrl,strtolower($keyName).'='.$urlArr[$x][$urlKeys[$y]]);		//append GET element
					}
				}//eof for column
				
				//if lookup return more than 1 result
				if($urlArrRowCount>$x)
					$url .= $tempUrl;
					
				if($urlArrRowCount>1)
					$url .= '<br>';
			}  //eof for row
		}//eof hav lookup
		else
			$url = "<a href=\"".$default."\" ".$js." >".$name."</a> ";
		
		return $url;
	}
	
	else if($type == "icon_submit")
	{
		return '<a href="javascript:void(0)" '.$js.' onclick="form1.action = \''.$default.'&prevID='.$_GET['menuID'].'&prevFormat='.$_GET['page'].'\'; form1.submit();"><img src="img/button-papar.gif" width="25" height="25" alt="Papar Maklumat" border="0" /></a>';
	}
	
	if($type == "image")
	{
		if($lookup != "")
		{
			$theArr = $myQuery->query($lookup,'SELECT','INDEX');
			
			$default = $theArr[0][0];
		}//eof if
		
		//width
		if($length)
			$imageWidth = 'width = "'.$length.'"';
		
		//heigth
		if($textarearows)
			$imageHeight = ' height = "'.$textarearows.'"';
		
		return '<img src="'.$default.'" alt="'.$name.'" '.$imageWidth.' '.$imageHeight.' border="0" '.$js.' />';
	}//eofif
}

//function to convert input into array items
function convertInputIntoArray($type,$input,$row)
{
	//switch the input type
	switch($type)
	{
		//collection of array able type
		case 'radio':
			$nameRow=$row;
		case 'input_date':
		case 'text_editor':
		case 'ajax_dropdown':
		case 'checkbox':
		case 'dropdown':
		case 'listbox':
		case 'lov_popup':
		case 'file':
		case 'hidden':
		case 'js_cascade_dropdown':
		case 'label_with_hidden':
		case 'password':
		case 'running_no':
		case 'text':
		case 'textarea':
			$idRow=$row;
			
			//get the name of input
			if(eregi('name',$input))
			{
				$begin=explode('name="',$input);
				
				//loop on number of id exist
				for($x=1; $x<count($begin); $x++)
				{
					$end=explode('" ',$begin[$x]);
					$tempInput=$end[0];		//name of input
					
					//if not array
					if(!eregi("\[\]",$tempInput))
						$input=str_replace('name="'.$tempInput.'"','name="'.$tempInput.'['.$nameRow.']"',$input);	//append [] into input name to make it array
					//$input=str_replace('name="'.$tempInput.'"','name="'.$tempInput.'[]"',$input);
				}//eof for
			}//eof if
			
			//id
			if(eregi('id',$input))
			{
				$begin=explode('id="',$input);
				
				//loop on number of id exist
				for($x=1; $x<count($begin); $x++)
				{
					$end=explode('" ',$begin[$x]);
					$tempInput=$end[0];		//name of input
					//append [] into input name to make it array
					$input=str_replace('id="'.$tempInput.'"','id="'.$tempInput.'_'.$idRow.'"',$input);
				}//eof for
			}//eof if
		break;
	}
	
	return $input;
}

//to append parameter into href
function appendUrl($input,$parameter)
{
	//get the name of input
	$begin=explode('href="',$input);
	$end=explode('" ',$begin[1]);
	$tempInput=$end[0];		//value of href
	
	//append parameter into URL
	$result=str_replace($tempInput,$tempInput.'&'.$parameter,$input);
	
	return $result;
}
?>