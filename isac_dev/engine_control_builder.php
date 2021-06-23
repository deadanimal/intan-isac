<?php 
//function to display control button
function buildControl($myQuery,$controlID,$requiredArr='')
{	
	//==============REQUIRED CHECK===========================
	//check for required items
	if(is_array($requiredArr))
	{
		$requiredChk = "var msg='';";								//instintiate variable
		$requiredArrCount = count($requiredArr);		//count required item
		
		//loop on count required item
		for($x=0; $x<$requiredArrCount; $x++)
		{
			$requiredChk .= "if(document.getElementsByName('".$requiredArr[$x]['item']."'))
			{
				var a=document.getElementsByName('".$requiredArr[$x]['item']."');
				var b=false;
				
				for(x=0;x<a.length;x++)
				{
					if(a[x].value=='')
						b=true;
				}
				
				if(b)
					msg+='".$requiredArr[$x]['name']." wajib diisi.\\n';
			}";
		}//eof for
		
		//$requiredChk.='if(msg){alert(msg); return false;}else ';
		$requiredChk.='if(msg){alert(msg); return false;}';
	}//eof if
	
	//$requiredChk.='form1.submit();';
	//==============END REQUIRED CHECK========================
	
	//if have controlid
	if($controlID)
	{
		//get control attributes
		$controlArr = $myQuery->query("select *
											from FLC_PAGE_CONTROL
											where CONTROLID in (".implode(',',$controlID).") 
											order by controlOrder",'SELECT','NAME');
		$countControlArr = count($controlArr);
	}//eof if
	
	//for all controls, create control
	for($x=0; $x < $countControlArr; $x++)
	{	
		//get control javascript event
		$getJavascriptEvent = $myQuery->query("select DESCRIPTION1 from REFSYSTEM 
													where MASTERCODE = (select REFERENCECODE from REFSYSTEM where MASTERCODE = 'XXX' 
																		and DESCRIPTION1 = 'PAGE_CTRL_ACTION_JS_BUTTON') 
													and REFERENCECODE = '".$controlArr[$x]["CONTROLJAVASCRIPTEVENT"]."'",'SELECT','NAME');
			
		//added cikkim 20080707
		//kalo problem sila buang
		//-----------------------------------------------
		//===============================================
		$controlArr[$x]["CONTROLREDIRECTURL"] = convertDBSafeToQuery($controlArr[$x]["CONTROLREDIRECTURL"]);
		
		if(eregi("POST",$controlArr[$x]["CONTROLREDIRECTURL"]))
		{	
			//remove unnecessary chars
			$controlArr[$x]["CONTROLREDIRECTURL"] = str_replace('{','',$controlArr[$x]["CONTROLREDIRECTURL"]);
			$controlArr[$x]["CONTROLREDIRECTURL"] = str_replace('}','',$controlArr[$x]["CONTROLREDIRECTURL"]);	
		
			$tempArr = explode('|',$controlArr[$x]["CONTROLREDIRECTURL"]);
			$controlArr[$x]["CONTROLREDIRECTURL"] = $_POST[$tempArr[1]];
		}
		
		if(eregi("GET",$controlArr[$x]["CONTROLREDIRECTURL"]))
		{	
			//remove unnecessary chars
			$controlArr[$x]["CONTROLREDIRECTURL"] = str_replace('{','',$controlArr[$x]["CONTROLREDIRECTURL"]);
			$controlArr[$x]["CONTROLREDIRECTURL"] = str_replace('}','',$controlArr[$x]["CONTROLREDIRECTURL"]);	
		
			$tempArr = explode('|',$controlArr[$x]["CONTROLREDIRECTURL"]);
			$controlArr[$x]["CONTROLREDIRECTURL"] = $_GET[$tempArr[1]];
		}
		
		if(eregi("SESSION",$controlArr[$x]["CONTROLREDIRECTURL"]))
		{	
			//remove unnecessary chars
			$controlArr[$x]["CONTROLREDIRECTURL"] = str_replace('{','',$controlArr[$x]["CONTROLREDIRECTURL"]);
			$controlArr[$x]["CONTROLREDIRECTURL"] = str_replace('}','',$controlArr[$x]["CONTROLREDIRECTURL"]);	
		
			$tempArr = explode('|',$controlArr[$x]["CONTROLREDIRECTURL"]);
			$controlArr[$x]["CONTROLREDIRECTURL"] = $_SESSION[$tempArr[1]];
		}
		//-----------------------------------------------
		//===============================================
		
		//save, reset, back, cancel
		$temp = "&nbsp;<input name=\"control_".$controlArr[$x]['CONTROLTYPE']."\" id=\"control_".$controlArr[$x]['CONTROLTYPE']."\" ";
		
		//if save
		if($controlArr[$x]['CONTROLTYPE'] == 1)
			$temp .= "type=\"submit\" onclick=\"form1.action = '';".$requiredChk."\" ";
		
		//if reset
		else if($controlArr[$x]['CONTROLTYPE'] == 2)
			$temp .= 'type="reset" ';

		//if back
		else if($controlArr[$x]['CONTROLTYPE'] == 3)
			$temp .= "type=\"submit\" onclick=\"form1.action = 'index.php?page=".$_GET['prevFormat']."&menuID=".$_GET['prevID']."'; form1.submit();\" ";

		//if cancel
		else if($controlArr[$x]['CONTROLTYPE'] == 4)
			$temp .= 'type="submit" ';
		
		//if print
		else if($controlArr[$x]['CONTROLTYPE'] == 5)
			$temp .= 'type="button" onclick="window.print();"';
		
		//if redirect
		else if($controlArr[$x]['CONTROLTYPE'] == 6)
			$temp .= "type=\"submit\" onclick=\"form1.action = '".$controlArr[$x]["CONTROLREDIRECTURL"]."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page']."';\" ";
			
		//if search
		else if($controlArr[$x]['CONTROLTYPE'] == 7)
			$temp .= "type=\"submit\" onclick=\"form1.action = '".$controlArr[$x]["CONTROLREDIRECTURL"]."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page']."'; ".$requiredChk.";\" ";

		//if delete 
		else if($controlArr[$x]['CONTROLTYPE'] == 8)
		{	
			$temp .= "type=\"submit\" onclick=\"form1.action = '".$controlArr[$x]["CONTROLREDIRECTURL"]."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page'];
			
			if($_GET['keyid'])
				$temp .= '&keyid='.$_GET['keyid'];
			
			$temp .= "';\" ";
			
			//$temp .= 'type="submit" ';
		}
		//if save and redirect
		else if($controlArr[$x]['CONTROLTYPE'] == 15)
		{	
			$temp .= "type=\"submit\" onclick=\"form1.action = '".$controlArr[$x]["CONTROLREDIRECTURL"]."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page'];
			
			$temp .= "';".$requiredChk."\" ";
		}	
		
		//if API Stored Procedure or save and stored procedure
		else if($controlArr[$x]['CONTROLTYPE'] == 16 || $controlArr[$x]['CONTROLTYPE'] == 9)
		{	
			if($controlArr[$x]["CONTROLREDIRECTURL"] != '')
				$temp .= "type=\"submit\" onclick=\"form1.action = '".$controlArr[$x]["CONTROLREDIRECTURL"]."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page']."';".$requiredChk."\" ";
			else
				$temp .= "type=\"submit\" onclick=\"form1.action = '';".$requiredChk."\" ";
		}
		
		//if new popup - GET
		else if($controlArr[$x]['CONTROLTYPE'] == 20)
		{	
			$temp .= " type=\"button\" ";		 
			$temp .= " onclick=\"".$requiredChk.";my_new_window(getInputList('form1','".$controlArr[$x]["CONTROLREDIRECTURL"]."'),'',800,500)\"";
		}
		
		//if new popup - POST
		else if($controlArr[$x]['CONTROLTYPE'] == 21)
		{	
			$temp .= " type=\"button\" ";		 
			$temp .= " onclick=\"".$requiredChk.";form1.target='_blank'; form1.action='".$controlArr[$x]["CONTROLREDIRECTURL"]."'; form1.submit()\" ";
		}
		
		//if new popup - SP REFRESH & POST NI BLUM LAGI
		else if($controlArr[$x]['CONTROLTYPE'] == 22)
		{	
			$temp .= " type=\"submit\" ";		 
			$temp .= " onclick=\"".$requiredChk.";form1.submit(); form1.target='_blank'; form1.action='".$controlArr[$x]["CONTROLREDIRECTURL"]."'; \" ";
		}
		
		//if new popup - SP REFRESH & GET
		else if($controlArr[$x]['CONTROLTYPE'] == 23)
		{	
			$temp .= " type=\"submit\" ";		 
			$temp .= " onclick=\"".$requiredChk.";form1.submit(); my_new_window(getInputList('form1','".$controlArr[$x]["CONTROLREDIRECTURL"]."'),'',800,500)\"";
		}
		
		//if BL
		else if($controlArr[$x]['CONTROLTYPE'] == 24)
		{	
			$temp .= "type=\"submit\" onclick=\"form1.action = '".$controlArr[$x]["CONTROLREDIRECTURL"]."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page']."'; ".$requiredChk.";\" ";
		}
		
		//if unsubmit button, normal button
		else if($controlArr[$x]['CONTROLTYPE'] == 25)
		{	
			$temp .= "type=\"button\" onclick=\"\"";
		}
		
		//if loading button
		else if($controlArr[$x]['CONTROLTYPE'] == 26)
		{	
			//get component id of loading
			$loading_componentID = "select componentid 
									from FLC_PAGE_COMPONENT 
									where pageid=(select pageid from FLC_PAGE_CONTROL where controlid='".$controlArr[$x]["CONTROLID"]."') 
									and componenttype='loading'";
			$loading_componentIDRs = $myQuery->query($loading_componentID,'SELECT','NAME');
			
			//button for loading
			$temp .= "type=\"submit\" onclick=\"form1.action = '".$controlArr[$x]["CONTROLREDIRECTURL"]."&prevID=".$_GET['menuID']."&prevFormat=".$_GET['page']."'; 
						(document.getElementById('upload_frame_".$loading_componentIDRs[0]['COMPONENTID']."').contentDocument).getElementById('save_spreadsheet_data').onclick();
						document.getElementById('upload_loading_".$loading_componentIDRs[0]['COMPONENTID']."').value =(document.getElementById('upload_frame_".$loading_componentIDRs[0]['COMPONENTID']."').contentDocument).getElementById('code').value;form1.submit()\"";
		}
		
		//FOR JAVASCRIPT
		if($controlArr[$x]["CONTROLJAVASCRIPTEVENT"] != "")
		{	
			//if onclick is selected, check for existing onclick event
			if(strtolower(trim($getJavascriptEvent[0]["DESCRIPTION1"])) == 'onclick')
			{
				$temp = str_replace('onclick="','onclick="'.str_replace('\"',"'",convertDBSafeToQuery($controlArr[$x]["CONTROLJAVASCRIPT"])).'; ',$temp);
			}
			else
				$temp .= $getJavascriptEvent[0]["DESCRIPTION1"]." = \"".str_replace('\"',"'",convertDBSafeToQuery($controlArr[$x]["CONTROLJAVASCRIPT"]))."\"";
		}
		
		//if image
		if($controlArr[$x]['CONTROLIMAGEURL'])
		{
			//if file exist
			if(is_file($controlArr[$x]['CONTROLIMAGEURL']))
			{
				//size of original image
				$imgSize=getimagesize($controlArr[$x]['CONTROLIMAGEURL']);
				$imgWidth=$imgSize[0];		//array [0] - width
				$imgHeight=$imgSize[1];		//array [1] - height
			}
			
			$temp .= " class=\"inputButtonImage\" style=\"background-image:url(".$controlArr[$x]['CONTROLIMAGEURL'].");width:".$imgWidth."px;height:".$imgHeight."px;\"
						 value=\"\"";
		}//eof if
		else
			$temp .= " class=\"inputButton\" value=\"".$controlArr[$x]["CONTROLNAME"]."\"";
		
		//end tag for button
		$temp .= " />";
		echo $temp;
	}
}
?>