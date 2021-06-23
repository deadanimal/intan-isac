<?php
include('db.php');

// select dropdown iac
$iac = "select referencecode, description1
from ISAC.REFGENERAL
where mastercode = (select referencecode from ISAC.REFGENERAL
where description1 = 'IAC' )and referencecode != '01' and referencestatuscode='00' order by referencecode asc";

$iac2 = "select
kod_iac,
(SELECT description1 FROM isac.refgeneral 
WHERE
mastercode=(SELECT referencecode
FROM isac.refgeneral where mastercode='XXX' 
AND description1='iac') 
and referencecode != '01' and 
referencestatuscode='00' 
AND referencecode=kod_iac) as 'nama_iac',
server_ip
from
usr_isac.pro_push_iac
where
kod_iac != '01' and kod_iac != '011'
order by
kod_iac asc";
$result = $myQuery->query($iac2,'SELECT','NAME');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>

<script type="text/javascript">
	
	function clickPush(){
		var iac = document.getElementById("iac").value;
		var split_iac = iac.split('||');
		var kod_iac = split_iac[0];
		var server_ip = split_iac[1];
		
		var jQ = jQuery.noConflict();
		
		//untuk ke cwgn
		
jQ(document).ready(function(){

        jQ("#divContent").empty().html(
                        '<div align="center" class="namehead"><img src="img/ajax-loader.gif" /><br><strong>Please Wait...</strong></div>');
        jQ('#divContent').load(
                encodeURI('pushpull/push_iframe.php?server_ip='+server_ip+'&kod_iac='+kod_iac),
                        "",
                        function(responseText, textStatus,XMLHttpRequest) {
                            if (textStatus == 'error') {
                                jQ('#divContent').html(
                                                '<p>There are some error. Please reload page</p>');
                            }
                        });
        });
		
		//untuk test local
		/*
		encodeURI('http://'+server_ip+':8080/isac/pushpull/push_client.php?kod_iac='+kod_iac),
		jQ(document).ready(function(){

		jQ("#divContent").empty().html(
						'<div align="center" class="namehead"><img src="img/ajax-loader.gif" /><br><strong>Please Wait...</strong></div>');
		jQ('#divContent').load(
				encodeURI('http://localhost:8081/isac_caw/pushpull/push_client.php?kod_iac='+kod_iac),
						"",
						function(responseText, textStatus,XMLHttpRequest) {
							if (textStatus == 'error') {
								jQ('#divContent').html(
												'<p>There are some error. Please reload page</p>');
							}
						});
		});
		*/
	}
	
	
</script>

</head>

<body o>
<table width="50%" border="0">
  <tr>
    <td width="14%"><span class="style1">To IAC :</span></td>
    <td width="86%"><form id="form1" name="form1" method="post" action="button_push.php">
      <span class="inputArea">
      <select name="iac" id="iac">
        <option value="00" selected="selected">[Please Choose]</option>
        <?php for($d=0;$d<count($result);$d++){ ?>
        <option value="<?php echo $result[$d]['KOD_IAC']."||".$result[$d]['SERVER_IP']; ?>" ><?php echo $result[$d]['NAMA_IAC']; ?></option>
        <?php }?>
      </select>
      </span> <span class="inputArea">
      <input type="button" onclick="clickPush()" name="button" id="button" value="Submit" />
      </span>
    </form></td>
  </tr>
</table>
<label></label>
<br/><br/>
<div id="divContent">


</div>
 <!-- <input type="button" name="button" id="button" value="Push to INTIM" onclick="window.location='push_intim_peserta.php'" />-->
  
<br/><br/>
</body>
</html>
