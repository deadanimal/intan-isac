<?php 
include('system_prerequisite.php');						//include stuff needed for session, database connection, and stuff

//if have post
if(is_array($_POST))
	$_POST=convertToDBSafe($_POST);

$start = utime(); 										//start calculate page generation time
checkLogout($myQuery,$mySQL,$mySession,$_GET['logout'],$cas);		//check if user logged out

if(!isset($_SESSION['bannerShow']))
	$_SESSION['bannerShow'] = true;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php echo SYSTEM_FULL_NAME;?>
</title>
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="tools/datepicker/datepicker.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="tools/datepicker/datepicker.js"></script>
<script language="javascript" type="text/javascript" src="tools/prototype.js"></script>
<script language="javascript" type="text/javascript" src="tools/scriptaculous/scriptaculous.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script language="javascript" type="text/javascript" src="js/maths_functions.js"></script>
<script language="javascript" type="text/javascript" src="js/string_functions.js"></script>
<script language="javascript" type="text/javascript" src="js/dfilter.js"></script>

<?php include('ajax_updater.php');?>
<script language="javascript" type="text/javascript">
function toggleBanner(elem)
{	
	if(elem.innerHTML.strip() == '[ - ]') 
	{ 	
		$('header').fade();
		elem.innerHTML = '[ + ]'; 
	} 
	else if (elem.innerHTML.strip() == '[ + ]')
	{ 	
		$('header').appear();
		elem.innerHTML = '[ - ]'; 
	} 
	
	var target = 'header';
	var url = 'ajax_updater.php';
	var params = '?a=1';
	var ajax = new Ajax.Updater({success: target},url,{method: 'get', parameters: params + '&type=toggleBanner', onFailure: reportError});

}

function loadPage(theUrl,target)
{	//window.alert(theUrl);
	var url = theUrl
	var params = '?a=1';
	//var ajax = new Ajax.Updater({success: target},url,{method: 'get', parameters: params + '&type=ajax',onLoading: function(request) {Element.show('spinner'); Element.hide('contentCenter');},onLoaded: function(request) {Element.hide('spinner');Element.show('contentCenter');}, onFailure: reportError});
	var ajax = new Ajax.Updater({success: target},url,{method: 'get', parameters: params + '&type=ajax',onFailure: reportError});
}

function logoutFader()
{
	//new Effect.Opacity(document.getElementsByTagName('body')[0], { from: 1.0, to: 0.5, duration: 0.4 }); 
	if(window.confirm('Anda pasti untuk log keluar?')) 
	{
		window.location = 'index.php?logout=true';
		
	} 
	else 
	{
		//new Effect.Opacity(document.getElementsByTagName('body')[0], { from: 1.0, to: 1.0, duration: 0.1 });
		return false;
	}
}

</script>
</head>
<body>
<?php 


if($_SESSION['loginFlag']) {  //if session var login flag is set to true, user is logged in ?>
<!-- LOGGED IN USER SECTION ONLY ---------------------------------------------------------------------------------------------->
<!-- MAIN CONTENT SECTION -->
<?php if(HEADER_ENABLED){?>
<div id="header">
  <?php if($_SESSION['bannerShow'] == true) include('views/index_header.php');?>
</div>
<?php }?>
<?php if(SUB_HEADER_ENABLED){?>
<div id="topMenu">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="left"><label style="cursor:pointer" onclick="toggleBanner(this)" title="Toggle Banner" id="toggleBannerLabel">
        <?php if($_SESSION['bannerShow'] == true) echo '[ - ]'; else echo '[ + ]';?></label></td>
      <td class="right"><?php echo dayToMalay(date(l)).', '.monthToMalay(date('F'),'long').' '.date('d, Y');?> <?php if(HOME_PAGE&&HOME_PAGE_URL){?>| <a href="<?php echo HOME_PAGE_URL;?>"><?php /*echo HOME_PAGE;*/?></a><?php }?> <?php if(LOGOUT&&LOGOUT_URL){?> <a href="javascript:void(0)" onclick="logoutFader()"><?php echo LOGOUT;?></a><?php }?></td>
    </tr>
  </table>
</div>
<?php }?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!-- LEFT MENU SECTION -->
    <?php if(LEFT_MENU_ENABLED){?>
	<?php if(count($mySQL->getMenuArr())){?>
    <td width="<?php echo LEFT_MENU_WIDTH;?>" id="<?php echo LEFT_MENU_ID;?>" class="<?php echo LEFT_MENU_CLASS;?>"><div id="sideMenuLeft">
        <?php displayLeftMenu($dbc,$myQuery,$mySQL); ?>
      </div></td>
    <?php }} ?>
    <!-- //END LEFT MENU SECTION -->
    <!-- CENTER CONTENT SECTION -->
    <td id="content" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;">
        <tr>
          <td width="15" valign="bottom"><img src="img/content/1.jpg" width="15" height="15" /></td>
          <td style="background-image:url(img/content/content_atas.jpg); background-repeat:repeat-x; background-position:bottom">&nbsp;</td>
          <td width="15" valign="bottom"><img src="img/content/2.jpg" width="15" height="15" /></td>
        </tr>
        <tr>
          <td style="background-image:url(img/content/content_kiri.jpg); background-repeat:repeat-y">&nbsp;</td>
         <td id="spinner" style="display:none"><img src="img/roller.gif" /></td>
		  <td id="contentCenter"><?php displayContent($dbc,$myQuery,$mySQL,$dal); ?>
            </td>
          <td style="background-image:url(img/content/content_kanan.jpg); background-repeat:repeat-y">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><img src="img/content/3.jpg" width="15" height="15" /></td>
          <td style="background-image:url(img/content/content_bawah.jpg); background-repeat:repeat-x">&nbsp;</td>
          <td valign="top"><img src="img/content/4.jpg" width="15" height="15" /></td>
        </tr>
      </table></td>
    <!-- CENTER CONTENT SECTION -->
    <!-- RIGHT MENU SECTION -->
    <?php if(RIGHT_MENU_ENABLED) {?>
	<?php if(count($mySQL->getMenuArr())){?>
    <td width="<?php echo RIGHT_MENU_WIDTH;?>" id="<?php echo RIGHT_MENU_ID;?>" class="<?php echo RIGHT_MENU_CLASS;?>"><?php displayRightMenu($dbc,$myQuery,$mySQL); ?></td>
    <?php }} ?>
    <!-- //END RIGHT MENU SECTION -->
  </tr>
</table>
<!-- BOTTOM LINKS SECTION -->
<?php if(BOTTOM_LINKS_ENABLED) {?>
<div id="<?php echo BOTTOM_LINKS_ID;?>"><a href="index.php">Muka Utama</a> | <a href="javascript:void(0)">Bantuan</a> | <a href="javascript:void(0)">FAQ</a></div>
<?php } ?>
<!-- //END BOTTOM LINKS SECTION -->
<!-- FOOTER SECTION -->
<?php if(FOOTER_ENABLED == true) {?>
<div id="<?php echo FOOTER_ID;?>">
  <?php echo FOOTER_TEXT;?>
</div>
<?php } ?>
<!-- //END FOOTER SECTION -->
<!-- BOTTOM TEXT SECTION -->
<?php if(BOTTOM_TEXT_ENABLED) {?>
<div id="<?php echo BOTTOM_TEXT_ID;?>"><?php echo BOTTOM_TEXT_TEXT; ?></div>
<?php } ?>
<!-- //END BOTTOM TEXT SECTION -->
<!-- //END MAIN CONTENT SECTION -->
<!-- PAGE GENERATION TIME -->
<?php if(PAGE_RESPONSE_ENABLED) { ?>
<div id="<?php echo PAGE_RESPONSE_ID?>">Response time: <?php echo pageGenerationTime($start,' secs');?> </div>
<?php } ?>
<!-- //END PAGE GENERATION TIME -->
<!-- //END LOGGED IN USER SECTION ONLY ------------------------------------------------------------------------------------------>
<?php } //END if session var login flag is set to true, user is logged in
//else show login screen
else
	//include('login.php');
	
	redirect('main_page.php?'.$_SERVER['QUERY_STRING']);
	//unset($_SESSION['curtime']);
?>
</body>
</html>