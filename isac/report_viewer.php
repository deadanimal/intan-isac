<?php

	include('db.php');
	include('system_prerequisite.php');	
	$id_report = $_GET['keyid'];

	//====== For listing (array) search ====== //
	
	$elemNamePrefix = "input_map_";
	ksort($_POST);
	//get list of items ID grouped in component ID
	$theComponent = postDataSplit($_POST,$elemNamePrefix);
	
	foreach($_POST as $key => $val){
	
	
	if(is_array($val)){
	
		$newVal = $val;
		$input = $key;
		
		foreach($newVal as $key => $val){
		
			if($key > 0){ $res .= ',';}
				$res .= $val;
				$_POST[$input] = $res;
		}

	
	}	
	
	}
	
	//====== EOF For listing (array) search ====== //
	
	
	//============== Get query from FLC_REPORT ===========================//
	
	$queryMain = "select * from FLC_REPORT where reportid = '$id_report'";
	$resultMain = $myQuery->query($queryMain,'SELECT','NAME');
	
	$reporttitle = convertDBSafeToQuery($resultMain[0][REPORTTITLE]);
	$reportheader = convertDBSafeToQuery($resultMain[0][REPORTHEADER]);
	$customheader = $resultMain[0][CUSTOMHEADER];
	$reportgroup1 = $resultMain[0][REPORTGROUP1];
	$reportgroup2 = $resultMain[0][REPORTGROUP2];
	$reportformula = $resultMain[0][REPORTFORMULA];

	$group1 = explode(',',$reportgroup1);
	
	// ========   rebuild header	====== //
	$startpos = strpos($reportheader, '<tbody>');
	$endpos = strpos($reportheader, '</tbody>');
	$lastpos = strlen($reportheader)-$endpos;
	$header_asal =  substr($reportheader,$startpos, -($lastpos));
	
	$header = str_replace('<td','<td class="listingHead" ',$header_asal);

	
	
	//======================================//
	
	$theQuery = convertDBSafeToQuery($resultMain[0]['REPORTSQL']);	
	
	strpos($theQuery,'{');
	strpos($theQuery,'}');
	
	
	//echo substr($theQuery,
	
	//$theQuery = "select * from usr_eaduan.view1";
	
	//=============== Get Data from query above ==========================//
	$resultSelect = $myQuery->query($theQuery,'SELECT','NAME');
	
	//================ Get All fields from query =========================//
	if(count($resultSelect) > 0){
	foreach($resultSelect[0] as $key => $value)
	{ 
		$queryField[] = $key;
	}
	}
	
	//================= After click Bina Laporan ==========================//
	
	$pilihanmedan = $_POST['checkmedan'];
	
	for($m=0;$m<count($pilihanmedan);$m++){
		
		$selectedField .= "`".$pilihanmedan[$m]."`";
		
		if($m<count($pilihanmedan)-1)
		{
			$selectedField .= ', ';
		}
		else
		{
			$selectedField .= ' ';
		}
	}
	
	//================ If got where condition =======================//
	if($_POST['kField'] != ""){
	
		$kAwal = $_POST['kAwal'];
		$kField = $_POST['kField'];
		$kKriteria = $_POST['kKriteria'];
		$kText = $_POST['kText'];
		$kAkhir = $_POST['kAkhir'];
		$con = $_POST['con'];
		
		foreach($kField as $a => $b)
		{ 
		
			if($kField[$a] != ""){
			//untuk add where
			if($checkWhere == false)
			{
				$addback = ' where ';
			}
			else
			{
				$addback = ' and ';
			}
		
			if($kField[$a] != "" && $kKriteria[$a] != "" && $kText[$a] != "")
			{
				
				if($kKriteria[$a] == "LIKE"){
					$kText[$a] = "'%".$kText[$a]."%'";
				}
				else{
					$kText[$a] = "'".$kText[$a]."'";
				}
		 		$where .= " $kAwal[$a] $kField[$a] $kKriteria[$a] $kText[$a] $kAkhir[$a] $con[$a] ";
			}
		}}

	}
	
	if($selectedField == ''){
		$selectedField = '*';
	}
	
/*	if($group1 != ""){
	
	$selectedField = ' count(id_aduan) ';
	
	}*/

 //============= Final Query ===============================//
  	if($group1[0] == ""){

		$reportsql = 'select '.$selectedField.' from ('.$theQuery.') as a '.$addback.$where;
		
		$reportsql =  str_replace('"',"'",$reportsql);
		
	}
	
	else{
	
		$selectedField = $reportgroup1;
		$reportsql = 'select * from ('.$theQuery.') as a '.$addback.$where;
	  	$reportsql =  str_replace('"',"'",$reportsql);
 
 		//======= Nak tentukan column first : cth = negeri ============//
		
 		$sqlcolumn = 'select '.$group1[0].' from ('.$theQuery.') as a group by '.$group1[0];
 		$sqlcolumn =  str_replace('"',"'",$sqlcolumn);
		$resultTableGroup = $myQuery->query($sqlcolumn,'SELECT','NAME');

		//=============================================================//
		

	} 




	



 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
FAREEDA</title>
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="tools/datepicker/datepicker.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="tools/datepicker/datepicker.js"></script>
<script language="javascript" type="text/javascript" src="tools/prototype.js"></script>
<script language="javascript" type="text/javascript" src="tools/scriptaculous/scriptaculous.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>

<script language="javascript" type="text/javascript" src="js/maths_functions.js"></script>
<script language="javascript" type="text/javascript" src="js/string_functions.js"></script>
<script language="javascript" type="text/javascript" src="js/dfilter.js"></script>

<style type="text/css">
 @media print
 {
 
 body{font-family:georgia,times,sans-serif;
 
 margin-top:-30px;}
 #left{display:none;}
 #bucu{display:none;}
  #center{display:block;}
 #right{display:none;}
  #bottomLinks{display:none;}
    #footer{display:none;}
    #bottomText{display:none;}
	.footer{display:none;}
	
	#sideMenuLeft{display:none;}

	
	
}

/* ----- table content -----  */
#dataTable2{
	border-top:2px solid #B3C5D7;
	border-left:2px solid #B3C5D7;
	margin-left: 10px;
	width:99%;					/* addded cikkim 20080707. kalo problem buang jer. */
}

#tableContentx th{
	text-align:left;
	padding: 2px 10px 2px 10px;
	height:25px;
	color:#FFFFFF;
}

#dataTable2 th{
border-top:1px solid #B3C5D7;
	text-align:left;
	background-image:url(img/content/header_bar.jpg);
	background-repeat:repeat-x;
	padding: 2px 10px 2px 10px;
	height:25px;
	color:#FFFFFF;
}
tr { page-break-inside:avoid}

#dataTable2 .inputList{
	font-family:"Trebuchet MS", Verdana, Arial;
	padding: 1px;
	border: 2px solid #CCCCCC;
	font-size: 12px;
}

#dataTable2 .color2{
background-color:#FFFF99;

	

}

#dataTable2 .inputInput, .inputInput, .w8em{
	font-family:"Trebuchet MS", Verdana, Arial;
	padding: 1px;
	border: 2px solid #CCCCCC;
	font-size: 12px;
}

#dataTable2 .listingHead{
	text-align:center;
	background-color:#F3F3F3;
	padding: 2px 5px 2px 5px;
	border-right: 2px solid #B3C5D7;
	border-bottom: 1px solid #B3C5D7;
	font-weight:bold;
	white-space:nowrap;
}

#dataTable2 .listingContent{
	text-align:left;
	padding: 2px 3px 2px 3px;
	border-right: 2px solid #B3C5D7;
	border-bottom: 1px solid #B3C5D7;
	border-top: 1px solid #B3C5D7;
}

#dataTable2 .listingContentR{
	text-align:right;
	padding: 2px 3px 2px 3px;
	border-right: 2px solid #B3C5D7;
	border-bottom: 1px solid #B3C5D7;
	border-top: 1px solid #B3C5D7;
}


#dataTable2 .listingNumber{
text-align:center;
	padding: 2px 3px 2px 3px;
	border-right: 2px solid #B3C5D7;
	border-bottom: 1px solid #B3C5D7;
	border-top: 1px solid #B3C5D7;
}

#dataTable2 .all{
text-align:left;
	padding: 2px 3px 2px 3px;
	border-right: 2px solid #B3C5D7;
	border-bottom: 1px solid #B3C5D7;
	border-top: 1px solid #B3C5D7;
}

#dataTable2 .listingNumberAll{
text-align:center;
	padding: 2px 3px 2px 3px;
	border-right: 2px solid #B3C5D7;
	border-bottom: 2px solid #B3C5D7;
	background-color:#F5DEEE;
}

#footer{
padding-top:50px;

}

</style>

<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#center").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>


<SCRIPT language="javascript">
	function addRow(tableID) {
		
		var table = document.getElementById(tableID);

		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);

		var colCount = table.rows[0].cells.length;

		for(var i=0; i<colCount; i++) {

			var newcell	= row.insertCell(i);

			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			//alert(newcell.childNodes);
			switch(newcell.childNodes[0].type) {
				case "text":
						newcell.childNodes[0].value = "";
						break;
				case "checkbox":
						newcell.childNodes[0].checked = false;
						break;
				case "select-one":
						newcell.childNodes[0].selectedIndex = 0;
						break;
			}
		}

	}

	function deleteRow(tableID) {
		try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;

		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				if(rowCount <= 1) {
					alert("Cannot delete all the rows.");
					break;
				}
				table.deleteRow(i);
				rowCount--;
				i--;
			}


		}
		}catch(e) {
			alert(e);
		}
	}

</SCRIPT>



</head>
<body>


<form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data">
  <!-- ============================================================ FORM BASED 1 COLUMN BLOCK ============================================================ -->

<table style="display:none" width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
  <tr>
    <th colspan="2">Pemilihan Graf</th>
  </tr>
  <tr>
    <td width="150" class="inputLabel">Tajuk :</td>
    <td class="inputArea">
		<input name="namagraf" id="namagraf" type="text" tabindex="" maxlength="" class="inputInput" value="<?php echo $_POST['namagraf']; ?>" size="50" style="text-align:left; "  /> 
			<input name="myquery" id="myquery" type="hidden"  value="<?php echo $reportsql; ?>"  />
		<input type="hidden" name="report_id" id="report_id" value="<?php echo $_GET['keyid']; ?>"  />
		<input type="hidden"  name="queryfrom" id="queryfrom" value="<?php echo $queryfrom; ?>" />
	</td>
  </tr>
  <tr>
    <td width="150" class="inputLabel">Jenis Graf :</td>
    <td class="inputArea">

		<select name="jenisgraf" tabindex="" id="jenisgraf" class="inputList"   >
        
          <option value="bars" 
		  <?php if($_POST['jenisgraf'] == 'bars')
				{
			echo 'selected';
			} ?>
			
			>bar</option>
          <option value="pie" <?php if($_POST['jenisgraf'] == 'pie')
		{
			echo 'selected';
		} ?>
		>pie</option>
          
        </select> 
	</td>
  </tr>
  <tr>
    <td width="150" class="inputLabel">Paksi-x :</td>
    <td class="inputArea">      
			<SELECT class="inputList" name="grafmedan" id="grafmedan">
				<OPTION value=""></OPTION>
				<?php
				
				
				for($q2=0;$q2<count($queryField);$q2++){
						
						if( $queryField[$q2] == $_POST['grafmedan']){
						$selected2 = 'selected';
						}
						else{
						$selected2 = '';
						}	
						echo '<option '.$selected2.' value="'.$queryField[$q2].'">'.$queryField[$q2].'</option>';
				}
				
					
				
									
				?>
					
				</SELECT> 
		
	</td>
  </tr>
  <tr>
    <td width="150" class="inputLabel">Label Paksi-x :</td>
    <td class="inputArea">    
	<input name="labelx" id="labelx" type="text" tabindex="" maxlength="" class="inputInput" value="<?php echo $_POST['labelx']; ?>" size="50" style="text-align:left; "  /> exp: Bangsa  
	</td>
  </tr>
   <tr>
    <td width="150" class="inputLabel">Label Paksi-y :</td>
    <td class="inputArea">    
	<input name="labely" id="labely" type="text" tabindex="" maxlength="" class="inputInput" value="<?php echo $_POST['labely']; ?>" size="50" style="text-align:left; "  /> exp: Jumlah Pelanggan Mengikut Bangsa   
	</td>
  </tr>
  
</table>

<!-- ========================================================== END FORM BASED 1 COLUMN BLOCK ========================================================== -->
 
<!-- ============================================================= REPORT BASED BLOCK ============================================================ -->
<table style="display:none" border="0" cellspacing="0" cellpadding="0" id="tableContent" width="99%">
	<tr>
		<th colspan="7">Pemilihan Medan</th>
	</tr>
	<?php if(count($resultSelect) > 0){ ?>
	<tr>
		<td class="listingHead">Nama Medan</td>
		<td class="listingHead">Pilih Medan</td>
	</tr>						
	<?php } else { echo '<tr><td>Tiada Maklumat</td></tr>';}?>
<tbody id="tableGridLayer29081" >


<?php
	
	for($q=0;$q<count($queryField);$q++){
		echo '</td><td class="listingContent">';
		echo $queryField[$q];
		echo '<input type="hidden" value="'.$queryField[$q].'" id="medan" name="medan[]" />';
		echo '</td><td class="listingContent">';
		echo '<input type="checkbox" value="'.$queryField[$q].'" id="checkmedan" name="checkmedan[]" />';
		echo '</td></tr>';
	}

	?>

</tbody>
</table>

<!--used for sorting-->
<input id="11_order" name="11_order" type="hidden" /><!-- =========================================================== END REPORT BASED BLOCK ========================================================== -->

<table style="display:none" border="0" cellspacing="0" cellpadding="0" id="tableContent" width="99%">
	<tr>
		<th colspan="7">Pemilihan Kriteria</th>
	</tr>
	</table>

<!-- utk tabular -->
	<TABLE style="display:none"  border="0" cellspacing="0" cellpadding="2px" id="dataTable" width="350px">
		<TR><TD><INPUT type="checkbox" name="chk"/></TD>
			<TD >
				<SELECT class="inputList" name="kAwal[]">
					<OPTION value=""></OPTION>
					<OPTION value="(">(</OPTION>
					<OPTION value="((">((</OPTION>

					<OPTION value="(((">(((</OPTION>
				</SELECT>
			</TD>
				<TD>
				<SELECT class="inputList" name="kField[]">
				<OPTION value=""></OPTION>
				<?php
					
					for($q2=0;$q2<count($queryField);$q2++){
						echo '<option value="'.$queryField[$q2].'">'.$queryField[$q2].'</option>';
					}
				
				?>
					
				</SELECT>
			</TD>
			
				<TD>
				<SELECT class="inputList" name="kKriteria[]">
					<OPTION value=""></OPTION>
					<OPTION value=">">></OPTION>
					<OPTION value="<"><</OPTION>
					<OPTION value="=">=</OPTION>
					<OPTION value=">=">>=</OPTION>
					<OPTION value="<="><=</OPTION>
					<OPTION value="!=">!=</OPTION>
					<OPTION value="LIKE">Like</OPTION>
				</SELECT>
			</TD>
			
			
			<TD><INPUT class="inputInput" type="text" name="kText[]"/></TD>
			
			<TD>
				<SELECT class="inputList" name="kAkhir[]">
				<OPTION value=""></OPTION>
					<OPTION value=")">)</OPTION>
					<OPTION value="))">))</OPTION>

					<OPTION value=")))">)))</OPTION>
				</SELECT>
			</TD>
			
			<TD >
				<SELECT class="inputList" name="con[]">
					<OPTION value=""></OPTION>
					<OPTION value="and">And</OPTION>
					<OPTION value="or">Or</OPTION>

				</SELECT>
			</TD>
		
			
		</TR>
	</TABLE>
	<table style="display:none" border="0" cellspacing="0" cellpadding="0" id="tableContentx" width="99%">
	<tr>
		<th colspan="7"><INPUT class="inputButton" type="button" value="Add Row" onclick="addRow('dataTable')" />
	<INPUT class="inputButton" type="button" value="Delete Row" onclick="deleteRow('dataTable')" /></th>
	</tr>
	
	</table>
	
	
	<br />
<!-- eof tabular -->


<!--</div>-->  <!-- ========================================================== END TABULAR/REPORT BASED BLOCK ========================================================== -->
 <!-- =============================================================== PAGE CONTROL =============================================================== -->
  <table style="display:none" width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">
    <tr>
      <td colspan="2" class="footer">&nbsp;<input name="bina" id="bina" type="submit"  class="inputButton" value="Bina Laporan" /></td>



    </tr>
  </table>
<br />

  <!-- =============================================================== END PAGE CONTROL =============================================================== -->
  <div id="center">
  <?php
 		
		$resultTablex = $myQuery->query($reportsql,'SELECT','NAME');
		if($resultTablex[0] != ""){
		foreach ($resultTablex[0] as $key => $val) {
		static $bilcolumn;
		
			$reportgroup1 = $resultMain[0][REPORTGROUP1];
			$reportgroup2 = $resultMain[0][REPORTGROUP2];
			$reporttotal = $resultMain[0][REPORTTOTAL];
			
		//===== Build field for group only ========
		
		if($reportgroup1 != "" and $reportgroup2 == ""){
		
			if($bilcolumn > 0){
			
			$structfield .= ','.$key;
			
			}
		}
		elseif($reportgroup2 != ""){
		
			if($bilcolumn > 1){
			
			$structfield .= ','.$key;
			
			}
		}
		
		
		$bilcolumn++;
		
		}
		}
		
		$structfield = substr($structfield,1);
		//==========================
		
		
		
		
		echo $reporttitle.'<br>';
		
		//Built Report
		echo '<table border="1" cellspacing="0" cellpadding="0" id="dataTable2">';
		echo '<tr>';
		
		
		
		if(count($resultTablex[0]) != '0'){
		
		//================  report header ====================
			
		if($customheader == "custom" && $header != ""){
		
			echo '<td>';
			echo $header;
			echo '</td>';
	
		}
		
		else{
		
			echo '<td width="5px" class="listingHead">Bil</td>';
			
			foreach ($resultTablex[0] as $key => $val) { 
				
				echo '<td class="listingHead">'.$key.'</td>';
			
			}
		}
		
		
		echo '</tr>';
		
		// =============  report content ==================
		
		// =================== if report no group ==================
		if($group1[0] == ""){
		
		
		for($t=0;$t<count($resultTablex);$t++){
			
			echo '<tr >';
			echo '<td class="listingNumber">'.($t+1).'.</td>';
			
			foreach ($resultTablex[$t] as $key => $val) { 
			
			$sum[$key][] = $val;
			
			if(is_numeric($val) == true){$class = "listingNumber";}
			else{$class = "listingContent";}
			
			
			echo '<td class="'.$class.'">'.$val.'</td>';
			}
		
		echo '</tr>';
		
		}
		
		// =================== eof if report no group ==================
			
		}
		
		// =================== elseif report have group ==================

		else{
	
			static $count = 1;		
		
			for($f=0;$f<count($resultTableGroup);$f++){
				
				static $bil = 0;
				//subheader
				echo "<tr class='color2'><td class='listingContent'>&nbsp;</td><td colspan='".($bilcolumn-1)."' class='listingContent'><strong>".$resultTableGroup[$f][strtoupper(				$group1[0])]."</strong></td></tr>";
				
				
				//====================  if only have 2 grouping ================================//
				
				//======= Nak tentukan column second : cth = kategori ============//
		
				if($reportgroup2 != ""){
				
					$sqlcolumn2 = "select ".$reportgroup2." from (".$theQuery.") as a where 
					".$group1[0]." = '".$resultTableGroup[$f][strtoupper($group1[0])]."' group by ".$reportgroup2;
					$sqlcolumn2 =  str_replace('"',"'",$sqlcolumn2);
					$resultTableGroup2 = $myQuery->query($sqlcolumn2,'SELECT','NAME');
					
				//=============================================================//
				
				for($j=0;$j<count($resultTableGroup2);$j++){
				
				//subsubheader
				echo "<tr><td class='listingContent'>&nbsp;</td><td colspan='".($bilcolumn-1)."' class='listingContent'><strong>".$resultTableGroup2[$j][strtoupper($reportgroup2)]."</strong></td></tr>";
				
				
				$sqlgroup = "select ".$structfield." from (".$reportsql.") as c where ".$group1[0]." = '".$resultTableGroup[$f][strtoupper($group1[0])]."'
				and ".$reportgroup2." = '".$resultTableGroup2[$j][strtoupper($reportgroup2)]."'";
				
				 '<br><br>';
				
				$resultTablex = $myQuery->query($sqlgroup,'SELECT','NAME');
				
				for($t=0;$t<count($resultTablex);$t++){
				
 				echo '<tr>';
				echo '<td width="5px" class="listingNumber">'.($count).'.</td>';
				
					foreach ($resultTablex[$t] as $key => $val) { 
					
					$sum[$key][$f][] = $val;
					
					if(is_numeric($val) == true){$class = "listingNumber";}
					else{$class = "listingContent";}
					
					
					echo '<td class="'.$class.'">'.$val.'</td>';
			
					}
					
				$count++;
				echo '</tr>';
				
				}
				
				}
				
				}
				//==================== eof if have 2 grouping ================================//
				
				//====================  if only have 1 grouping ================================//
				



				else{
				
				
				$sqlgroup = "select ".$structfield." from (".$reportsql.") as c where ".$group1[0]." = '".$resultTableGroup[$f][strtoupper($group1[0])]."'";
			
				
				 '<br><br>';
				
				$resultTablex = $myQuery->query($sqlgroup,'SELECT','NAME');
				
				for($t=0;$t<count($resultTablex);$t++){
				
 				echo '<tr>';
				echo '<td width="5px" class="listingNumber">'.($count).'.</td>';
				
					foreach ($resultTablex[$t] as $key => $val) { 
					
					$sum[$key][$f][] = $val;
					
					if(is_numeric($val) == true){$class = "listingNumber";}
					else{$class = "listingContent";}
					
					
					echo '<td class="'.$class.'">'.$val.'</td>';
					
					
					}
					
				$count++;
				echo '</tr>';
				
			
				}
			
				
				}
				
				//====================  if only have 1 grouping ================================//

			//tempat asal
			
			
			
			
			//jumlah
			
			$formula =  explode(',',strtoupper($reportformula));
			
			if($reportformula != ""){
			
			echo '<tr>';
			echo '<td class="listingContentR"><strong><center>Jumlah</center></strong></td>';

			
			foreach ($resultTablex[0] as $key => $val) { 
			
				if(in_array(strtoupper($key),$formula)){
					if(is_numeric($val) == true){
						$all[strtoupper($key)][] = array_sum($sum[$key][$f]);
						echo '<td class="listingNumber"><strong>'.array_sum($sum[$key][$f]).'</strong></td>';
					
					}
					else{
						
						//echo '<td class="listingNumber">&nbsp;</td>';
						
					}
				}
				
				else{
					
					echo '<td class="listingNumber">&nbsp;</td>';
					
				}
			}
			
			echo '</tr>';
			
			}
			//eof jumlah
		
			
			}
					
		
		//Jumlah Keseluruhan
		
		if($reporttotal == "enable"){
		
		echo '<tr><td class="all" colspan='.($bilcolumn).'><strong><br>Jumlah Keseluruhan</strong></td><tr><tr><td class="listingNumberAll">&nbsp;</td>';
		
		$keyMain = array_keys($resultTablex[0]);
		$keySub = array_keys($all);
			
		foreach ($keyMain as $key => $val) {
			$newval = strtoupper($val);
			if(in_array($newval,$keySub)){
			
				echo '<td class="listingNumberAll"><strong>'.array_sum($all[$newval]).'</strong></td>';
			}
			else{
			
				echo '<td class="listingNumberAll">&nbsp;</td>';
			}
		
		}
		
		echo '</tr>';
		}
		//eof Jumlah Keseluruhan
		
		}
		
			
		// =================== eof elseif report have group ==================
		
		}
		else{
			echo '<tr>';
			
			
			echo '<td class="listingContent">Tiada maklumat</td>';
			
		
			echo '</tr>';
		}
		
		
		if($group1[0] == ""){
		
		//for jumlah
		
	
		
			$formula =  explode(',',strtoupper($reportformula));
			
			if($reportformula != ""){
			
			echo '<tr>';
			echo '<td class="listingContent"><strong><center>Jumlah</center></strong></td>';

			if($resultTablex[0] != ""){
			
			foreach ($resultTablex[0] as $key => $val) { 
			$newkey = strtoupper($key);
			if(in_array($newkey,$formula)){
			
			if(is_numeric($val) == true){
			
				echo '<td class="listingNumber"><strong>'.array_sum($sum[$key]).'</strong></td>';
			
			}
			else{
				
				echo '<td class="listingNumber">&nbsp;</td>';
				
			}
			
			}
			
			else{
				
				echo '<td class="listingNumber">&nbsp;</td>';
				
			}
			
			}
			
			echo '</tr>';
			}
			
			}
			//} enable
			
			
			echo '</table>';
			
		
			
		//}enable
		
		}
		//eof jumlah
		
		
		// =============  eof report content ==================
		
		//eof built report

  ?>
  </div>
  <br />
  <div id="footer">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableContent">

    <tr>
      <td  colspan="2" class="footer">&nbsp;
	  <!--<input name="back" id="back" type="button" onClick="window.location='index.php?page=report_list'"  class="inputButton" value="Kembali" />-->
      <input name="kembali" id="kembali" type="button" onClick="history.go(-1)"  class="inputButton" value="Kembali" />
	  <input name="back" id="back" type="button" onClick="window.print()"  class="inputButton" value="Cetak" />
	  <!--<input name="show" id="show" type="submit" onClick="document.form1.action='index.php?page=report_print'"  class="inputButton" value="Lihat Laporan" />--></td>

    </tr>
  </table>
  </div>
</form>
<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<p>Print in Excel  <img src="export_to_excel.gif" class="botonExcel" /></p>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
</body></html>