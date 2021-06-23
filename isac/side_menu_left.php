<?php 
//if ajax is called 
if($_GET['type'] == 'ajax')
	include_once('system_prerequisite.php');

//if menu state is toggled
if($_GET['toggle'])
	toggleMenu($_GET['toggle'],$_GET['state']);			//call function to toggle menu

//get parent menu
if((!isset($_SESSION['menuArr']) || $_POST['menuForceRefresh']) && $_SESSION['userID'])
{	
	/*//if user is admin, FULL PERMISSION
	if($_SESSION['userName'] == 'admin' and $_SESSION['userID'] == 1)
	{
		//menu with permission								
		$menuArr = $myQuery->query("select a.MENUNAME, a.MENUID
										from FLC_MENU a 
										where a.menuParent = '0' 
										and a.MENUSTATUS = '1'  
										order by a.menuOrder",'SELECT','NAME');
		
		//menu permission
		$menuPermission = "select menuid from FLC_MENU";							
		$menuPermissionArr = $myQuery->query($menuPermission,'SELECT','NAME');
		$countMenuPermissionArr = count($menuPermissionArr);
	
		//copy array to new array 
		for($x=0; $x < $countMenuPermissionArr; $x++)
			$thePermissionArr[] = $menuPermissionArr[$x]['MENUID'];
	}//end if

	//else if user is not admin or id 1
	else
	{
		//menu permission
		$menuPermission = "select distinct perm_item from FLC_PERMISSION 
							where perm_type = 'menu' 
							and group_id in (
								select group_id from FLC_USER_GROUP_MAPPING 
								where group_id in
								(
									select c.group_id 
									from PRUSER a, FLC_USER_GROUP_MAPPING b, FLC_USER_GROUP c 
									where a.userid = b.USER_ID 
									and b.group_id = c.GROUP_ID 
									and userid = ".$_SESSION['userID']."  
								) 
								and user_id = ".$_SESSION['userID']."
							)";							
		$menuPermissionArr = $myQuery->query($menuPermission,'SELECT','NAME');
		$countMenuPermissionArr = count($menuPermissionArr);
		
		//copy array to new array 
		for($x=0; $x < $countMenuPermissionArr; $x++)
			$thePermissionArr[] = $menuPermissionArr[$x]['PERM_ITEM'];
		
		//if have permission
		if($thePermissionArr)
		{
			//menu with permission								
			$permissionQry = "select a.MENUNAME, a.MENUID
										from FLC_MENU a 
										where a.menuParent = '0' 
										and a.MENUSTATUS = '1'  
										and a.menuID in (".$menuPermission.")
										order by a.menuOrder";
			$menuArr = $myQuery->query($permissionQry,'SELECT','NAME');
		}//eof if
		else
			$noMenu=true;
	}//eof else*/
	
	//list of parent menu
	$menuArr = $mySQL->getMenuArr($_GET['menuRoot']);
	$menuArrCount = count($menuArr);

	//store in session
	$_SESSION['menuArr'] = $menuArr;
	$_SESSION["menuArrCount"] = $menuArrCount;

	//get submenu
	for($x=0; $x < $_SESSION["menuArrCount"]; $x++)
	{
		//to get child sub menus
		$menuChildArr = $myQuery->query("select a.MENUPARENT, a.MENULEVEL, a.MENUORDER, a.MENUNAME, a.MENULINK, a.MENUID, a.MENUTARGET,
												(select count(menuparent) from FLC_MENU where menuparent=a.menuid and menustatus='1') MENUSUB
											from FLC_MENU a
											where 
											a.MENUPARENT != '0' 
											and a.MENUSTATUS = '1' 
											and a.MENUPARENT = '".$_SESSION["menuArr"][$x]['MENUID']."' 
											and a.MENUID in (".$mySQL->menuPermission().")
											order by a.MENUORDER",'SELECT','NAME');
											
		//declare empty array
		$tempArr = array();
		
		//for each menu child array element
		for($a=0; $a < count($menuChildArr); $a++)
		{					
			$tempArr[] = $menuChildArr[$a];
			
			//check menu child, its own child
			$check = $myQuery->query("select a.MENUPARENT, a.MENULEVEL, a.MENUORDER, a.MENUNAME, a.MENULINK, a.MENUID, a.MENUTARGET,
											(select count(menuparent) from FLC_MENU where menuparent=a.menuid and menustatus='1') MENUSUB 
										from FLC_MENU a
										where a.MENUPARENT = ".$menuChildArr[$a]['MENUID']."  
										and a.MENUSTATUS = '1' 
										and a.MENUID in (".$mySQL->menuPermission().")
										order by a.MENUORDER",'SELECT','NAME');

			//for each child in CHECK
			for($b=0; $b < count($check); $b++)
			{	
				//copy to temp array
				$tempArr[] = $check[$b];
			}//eof for
		}//eof for
		
		//assign temp arr to menu child arr
		$menuChildArr = $tempArr;
		
		//store submenu in session
		$_SESSION['menuChildArr'][$x] = $menuChildArr;
		$_SESSION["menuChildArrCount"][$x] = count($menuChildArr);
	}//eof for
}

//set icon of 'bukaktutup
$minusIcon = '<img src="img/minus.gif" align="absmiddle" class="bukakTutup" />';
$plusIcon = '<img src="img/plus.gif" align="absmiddle" class="bukakTutup" />';

//-----prepare query string--------------
$qryStrArr = array();

//prepare query string
if(isset($_GET['page']))
	$qryStrArr[] = 'page='.$_GET['page'];
	
if(isset($_GET['menuID']))
	$qryStrArr[] = 'menuID='.$_GET['menuID'];
	
if(isset($_GET['reftype']))
	$qryStrArr[] = 'reftype='.$_GET['reftype'];

$qryStr = implode('&',$qryStrArr);
//---------------------------------------

//if $_SESSION['menuMinimized'] not set 
if($_SESSION['menuMinimized'] == false)
{
?>

<table id="sideMenuLeft" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15" height="15" valign="bottom"><img src="img/menu/a.jpg" width="15" height="15"></td>
    <td height="15" style="background-image:url(img/menu/menu_atas.jpg); background-repeat:repeat-x; background-position:bottom">&nbsp;</td>
    <td width="15" height="15" valign="bottom"><img src="img/menu/b.jpg" width="15" height="15"></td>
  </tr>
  <tr>
    <td style="background-image:url(img/menu/menu_kiri.jpg); background-repeat:repeat-y">&nbsp;</td>
    <td bgcolor="#EFEFF7"><table width="100%" cellpadding="0" cellspacing="0" style=" padding-top:0px;" border="0">
        <?php if($_SESSION['userID'] && PROFILE_ENABLED){?>
        <tr>
          <td width="10%" rowspan="2" style="padding-bottom:5px; color:#666666; font-size:12px; font-weight:bold; text-align:left; "><img src="<?php if($_SESSION['userImage'] != '') echo $_SESSION['userImage']; else echo 'img/default.gif'; ?>" width="70" height="70" style="border:1px solid #CCCCCC;" /></td>
          <td style="padding-bottom:5px; padding-left:7px; vertical-align:top; color:#333333; font-size:12px; font-weight:bold; text-align:left; "><?php echo ucwords($_SESSION['userName']);?><br />
          <!--Level: <?php echo ucwords(strtolower($_SESSION['userGroupCode']));?><br />
          Jabatan: <?php echo $_SESSION['departmentCode'];?>--></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="2" class="topLinks">
		  	<?php if(!$_SESSION['loginFlag']){echo 'Sesi anda telah tamat. Sila <a href="index.php">log masuk</a> semula untuk menggunakan sistem.';}?>
		  </td>
        </tr>
        <?php for($x=0; $x < $_SESSION["menuArrCount"]; $x++) 
		{	?>
        <!-- start parent menu section -->
        <tr>
          <td colspan="2" id="sideMenuTitle">
          	<a href="javascript:void(0)" onclick="ajaxToggleMenu('sideMenuLeft','index.php?<?php echo $qryStr?>&toggle=<?php echo $_SESSION["menuArr"][$x]['MENUID']?>&state=<?php echo $_SESSION['toggleState'][$_SESSION["menuArr"][$x]['MENUID']]?>')">
				<?php if($_SESSION['toggleState'][$_SESSION["menuArr"][$x]['MENUID']] == MENU_DEFAULT) {echo $minusIcon;} else {echo $plusIcon;} ?>
                <?php echo $_SESSION["menuArr"][$x]['MENUNAME']?>
            </a>
          </td>
        </tr>
        <!-- //end parent menu section -->
        <?php 	if($_SESSION['toggleState'][$_SESSION["menuArr"][$x]['MENUID']] == MENU_DEFAULT) 
				{ 	
					//show all child menus
					for($y=0; $y < $_SESSION["menuChildArrCount"][$x]; $y++) 
					{ 	
						if($y+1 == $_SESSION["menuChildArrCount"][$x]) 
							$TDid="sideMenuItemBottom";
						
						else 
							$TDid="sideMenuItem";
						
						//to underline selected menu
						if($_GET["menuID"] == $_SESSION["menuChildArr"][$x][$y]['MENUID']) 
							$TDid .= 'Active';
						 
					 //if state is 1 (show sub)
					  $getStateID = array_keys($_SESSION['toggleState']);
					  $getStateIDCount = count($getStateID);
					  
					  //set initial visibility
					  $childVisible = false;
					  
					  //loop on state count
					  for($z=0; $z<$getStateIDCount; $z++)
					  {
					  	//if toggle state true
						if($_SESSION['toggleState'][$getStateID[$z]])
							//if menu parent's toggle state true
							if($_SESSION["menuChildArr"][$x][$y]['MENUPARENT'] == $getStateID[$z])
								$childVisible = true;
					  }//eof for
					  
					  //if child visible
					  if($childVisible){
					?>
        <tr>
          <td colspan="2" id="<?php echo $TDid;?>"></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              <?php if($_SESSION["menuChildArr"][$x][$y]['MENUSUB']){ //if menu have sub?>
              	<td><span id="sideMenuSubTitle" onclick="ajaxToggleMenu('sideMenuLeft','index.php?<?php echo $qryStr?>&toggle=<?php echo $_SESSION["menuChildArr"][$x][$y]['MENUID']?>&state=<?php echo $_SESSION['toggleState'][$_SESSION["menuChildArr"][$x][$y]['MENUID']]?>')">
					<?php if($_SESSION['toggleState'][$_SESSION["menuChildArr"][$x][$y]['MENUID']] == MENU_DEFAULT) {echo $minusIcon;} else {echo $plusIcon;}?>
                    <?php echo '<b>'.$_SESSION["menuChildArr"][$x][$y]['MENUNAME'].'</b>';?>
                </span></td>
              <?php }else{	//if don't have sub-menu?>
                <td align="right" style="padding-right:3px;" width="<?php if($_SESSION["menuChildArr"][$x][$y]['MENULEVEL'] == '3')
																			{ echo '25';} else echo '10';?>" valign="top"><?php 
			  	//if menu is not null, and ade child, show bullet
				if($_SESSION["menuChildArr"][$x][$y]['MENULINK'] != "") 
				{	
			  		if($y+1 != $_SESSION["menuChildArrCount"][$x] + 1) 
					{	
						echo '<span style="color:#0099CC">&bull;</span>';
					}
				}
				else { }?></td>
                <td valign="top"><?php 
			//if menu is not null
			if($_SESSION["menuChildArr"][$x][$y]['MENULINK'] != "") 
			{	
				//echo '<a href="javascript:void(0)" onclick="loadPage(\''.str_replace('index.php?page=','',$_SESSION["menuChildArr"][$x][$y]['MENULINK']).'.php?menuID='.$_SESSION["menuChildArr"][$x][$y]['MENUID'].'&type=ajax\',\'contentCenter\')">[x]</a>';
				echo '<a  href="';
						
				//if menu is not null
				if($_SESSION["menuChildArr"][$x][$y]['MENULINK'] != "") 
				{	
					//get current running no
					if(eregi("{GET|keyid}",$_SESSION["menuChildArr"][$x][$y]['MENULINK']))
					{
						$_SESSION["menuChildArr"][$x][$y]['MENULINK'] = str_replace("{GET|keyid}",$_SESSION['userID'],$_SESSION["menuChildArr"][$x][$y]['MENULINK']);
					}
				
					echo ($_SESSION["menuChildArr"][$x][$y]['MENULINK']);
					
					//if($_SESSION["menuChildArr"][$x][$y]['MENUID'] == '196')
						//echo '&type=toggleBanner';
					
										
					if($_SESSION["menuChildArr"][$x][$y]['MENUTARGET'] == "")
						echo "&menuID=".$_SESSION["menuChildArr"][$x][$y]['MENUID']; 
					else
						echo '" ';
					
					//for target
					if($_SESSION["menuChildArr"][$x][$y]['MENUTARGET'] != "")
						echo " target=\"".$_SESSION["menuChildArr"][$x][$y]['MENUTARGET']."\" ";
				}
				else 
					echo "javascript:void(0)";
				
				echo '" ';
				
				//---ADDED TEMPORARILY---
				//added if page is terima kutipan (kaunter)
				if($_SESSION["menuChildArr"][$x][$y]['MENUID'] == '196')
					echo " onclick=\"toggleBanner($('toggleBannerLabel'))\" ";
				//-----------------------
				
				//close A tag, print menu name
				echo '> '.$_SESSION['menuChildArr'][$x][$y]['MENUNAME'].'</a></div>';
			}
			//else if menu is menu link is null, just show the name
			else
				echo '<b>'.$_SESSION["menuChildArr"][$x][$y]['MENUNAME'].'</b>'; ?></td>
              <?php }//eof else?>
              </tr>
            </table></td>
        </tr>	<?php }//eof else?>
        <?php 		}//end for ?>
        <?php 	}//end if togglestate ?>
        <?php }//end for ?>
        
		<?php if($_SESSION['userID']){?>
		<tr>
          <td colspan="2" id="sideMenuBottomLine"><div id="miniLinks"><a href="index.php?page=<?php echo $_GET['page']?>&menuID=<?php echo $_GET['menuID']?>&menuMinimized=1">&laquo; Minimize</a></div></td>
        </tr>
		<?php }?>
      </table></td>
    <td style="background-image:url(img/menu/menu_kanan.jpg); background-repeat:repeat-y">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><img src="img/menu/c.jpg" width="15" height="15"></td>
    <td style="background-image:url(img/menu/menu_bawah.jpg); background-repeat:repeat-x">&nbsp;</td>
    <td valign="top"><img src="img/menu/d.jpg" width="15" height="15"></td>
  </tr>
</table>
<?php } else { ?>
<table width="35" border="0" cellspacing="0" cellpadding="0" id="optimize">
  <tr>
    <td width="15" height="15" valign="bottom"><img src="img/menu/a.jpg" width="15" height="15" /></td>
    <td style="background-image:url(img/menu/menu_atas.jpg); background-repeat:repeat-x; background-position:bottom">&nbsp;</td>
    <td width="15" height="15" valign="bottom"><img src="img/menu/b.jpg" width="15" height="15" /></td>
  </tr>
  <tr>
    <td style="background-image:url(img/menu/menu_kiri.jpg); background-repeat:repeat-y">&nbsp;</td>
    <td bgcolor="#EFEFF7"><table width="5" cellpadding="0" cellspacing="0" style="padding:0px;">
        <tr>
          <td style="color:#666666; font-size:12px; font-weight:bold; text-align:left"><div id="miniLinks"><a href="index.php?page=<?php echo $_GET['page']?>&menuID=<?php echo $_GET['menuID']?>&menuMinimized=0">[+]</a></div></td>
        </tr>
      </table></td>
    <td style="background-image:url(img/menu/menu_kanan.jpg); background-repeat:repeat-y">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><img src="img/menu/c.jpg" width="15" height="15" /></td>
    <td style="background-image:url(img/menu/menu_bawah.jpg); background-repeat:repeat-x">&nbsp;</td>
    <td valign="top"><img src="img/menu/d.jpg" width="15" height="15" /></td>
  </tr>
</table>
<?php } ?>