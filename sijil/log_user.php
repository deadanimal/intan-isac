<?php
//include "connection.php";
//$con = new connect();
//$username = $_SESSION['username'];

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


function datelog(){
        date_default_timezone_set("Asia/Kuala_Lumpur");
		$datelog = date("Y-m-d H:i:s");  

    return $datelog;
}
?>