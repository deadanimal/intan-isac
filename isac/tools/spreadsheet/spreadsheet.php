<?php //print_r($_GET);
include('../../system_prerequisite.php');

//------- loading header ---------------
$header="select loading_header from FLC_LOADING where loading_name='".$_GET['id']."' and loading_status='00'";
$headerRs=$myQuery->query($header);

if($headerRs)
{
	$loading_header = explode(',',$headerRs[0][0]);
	$loading_headerCount=count($loading_header);
	
	//loop on count of header
	for($x=0;$x<$loading_headerCount;$x++)
	{
		//if append
		if($loading_header_code)
			$loading_header_code .= ',';
			
		$loading_header_code .= '['.$x.',-1,"'.ltrim(rtrim($loading_header[$x])).'","font-weight:bold;"]';
	}//eof for
}//eof if
//------ eof loading header -------------

//------- loading body ---------------
//if file uploaded
if($_SESSION['loading'])
{
	//if have content of loading
	if(is_array($_SESSION['loading']['content']))
	{
		//count rows
		$loading_body_rows=count($_SESSION['loading']['content']);
		
		//loop on count of row
		for($x=0;$x<$loading_body_rows;$x++)
		{
			//count columns
			if($loading_body_cols<count($_SESSION['loading']['content'][$x]))
				$loading_body_cols=count($_SESSION['loading']['content'][$x]);
			
			//loop on count of column
			for($y=0;$y<$loading_body_cols;$y++)
			{
				//if append
				if($loading_body_code)
					$loading_body_code .= ',';
					
				$loading_body_code .= '['.$y.','.$x.',"'.$_SESSION['loading']['content'][$x][$y].'","'.$_SESSION['loading']['style'][$x][$y].'"]'."\n";
			}//eof for
		}//eof for
	}//eof if
}//eof if

//temp
$loading_body_code = str_replace("''","'",$loading_body_code);
//------ eof loading body -------------
?>
<!-- GPL -->
<html>
<head>
  <title>Simple Spreadsheet 0.8</title>
  <link media="all" href="styles.css" rel="stylesheet" type="text/css" />
  <script src="spreadsheet.js" type="text/javascript"></script>
</head>
<body>
<!--
	Simple Spreadsheet is an open source Component created by Thomas Bley and licensed under GNU GPL v2.
	Simple Spreadsheet is copyright 2006-2007 by Thomas Bley.
	Translations writte by Sophie Lee.
	More information and documentation at http://www.simple-groupware.de/
-->
<!--<link media="all" href="tools/spreadsheet/styles.css" rel="stylesheet" type="text/css" />
<script src="tools/spreadsheet/spreadsheet.js" type="text/javascript"></script>-->
<div id="data"></div>
<div id="source" align="center">
<script>
var lang = "en";
if (m = /lang=([^&]*)/.exec(document.location.href)) {
  if (m[1]) lang = m[1];
}
loadScriptFile("translations/"+lang+".js");
</script>


<textarea id="code" wrap="off">
	cols = <?php if($loading_body_cols){echo $loading_body_cols;}else{echo 11;}?>;rows = <?php if($loading_body_rows){echo $loading_body_rows;}else{echo 15;}?>;
	<?php 
		echo 'dbCells = ['.$loading_header_code.','.$loading_body_code.'];';
	?>
</textarea>

<input type="button" id="load_spreadsheet_data" value="Load" onClick="load(getObj('code').value);">
<input type="button" value="Cancel" onClick="cancelLoad();">

<script>load(getObj('code').value);</script>
</div>
<?php if($_SESSION['loading']['error']){?><script>alert('<?php echo $_SESSION['loading']['error'];?> ralat ditemui');</script><?php }?>
</body>
</html>
<?php unset($_SESSION['loading']);?>