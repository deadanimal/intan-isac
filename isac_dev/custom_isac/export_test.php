<?php

$querys = mysql_query("select * from ruj_hari");
$oldid = mysql_query("select max(referenceid)+1 from refgeneral");

while($rsId = mysql_fetch_array($oldid)){
 $id =  $rsId[0];
}


$x = $myQuery->query("select * from ruj_hari",'SELECT','NAME');
$xx = array_keys($x[0]);

$count = count($x);


for($i=0;$i<$count;$i++){

$newid = $id + $i;
$kod = $x[$i][$xx[0]];
$ket = $x[$i][$xx[1]];

$insert = mysql_query("insert into refgeneral (referenceid,mastercode,referencecode,description1,userid,referencestatuscode) values
		('".$newid."','10011','".$kod."','".$ket."','1','00')") or die(mysql_error());
		
}

if ($insert){
			echo "masuk";
		}
		else{
			echo "nope";
		}



?>