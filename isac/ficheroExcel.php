<?php

header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename= laporan.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $_POST['datos_a_enviar'];



?>

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


