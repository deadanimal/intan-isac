<?php
//4 sept 2009
ob_start();
session_start();
//connection to database
//must include this file in every file to undeny data access

$DbServer = "localhost";
$DbUser = "root";
$DbPass = "";
$DbName = "isac";

// make connection to database
$dblink=mysql_connect($DbServer, $DbUser, $DbPass) OR DIE("Unable to connect to database");
@mysql_select_db("$DbName") or die( "Unable to select database");

?>