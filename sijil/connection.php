<?php
class connect
{
 public function connect()
 {
mysql_connect("10.1.3.91","isac79","isac2009");
 mysql_select_db("usr_isac");
 }
 public function setdata($sql)
 {
  mysql_query($sql);
 }
 public function getdata($sql)
 {
  return mysql_query($sql);
 }
 public function getdata2($sql)
 {
  return mysql_query($sql);
 }
 public function delete($sql)
 {
  mysql_query($sql);
 }
}

?>