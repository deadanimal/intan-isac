<?php
include "db.php";
session_start();

function login($user_id,$password)
{

if(($user_id!=='')&&($password!==''))
{
$query="SELECT * FROM login WHERE (user_id='$user_id') && (password='$password')";
$result=mysql_query($query);
  
while($row=mysql_fetch_assoc($result))
{
   $_SESSION['user_id']=$row['user_id'];
   $_SESSION['status']=$row['status'];
   $_SESSION['name']=$row['name'];
   
 $semak1=$row['user_id']; 
 $semak2=$row['password']; 
 $semak3=$row['status'];
}
if(($semak1==$user_id)&&($semak2==$password)&&($semak3=='Admin'))
{
	session_register('user_id');
	session_register('password');
	header("Location: home_admin.php");
	exit;
}
if(($semak1==$user_id)&&($semak2==$password)&&($semak3=='Officer'))
{
	session_register('user_id');
	session_register('password');
	header("Location: home_officer.php");
	exit;
}
if(($semak1==$user_id)&&($semak2==$password)&&($semak3=='Student'))
{
	session_register('user_id');
	session_register('password');
	header("Location: home_student.php");
	exit;
}

else 
{
echo "<script type='text/javascript'>\n";
echo "alert('Wrong User ID or Password!');\n";
echo "history.go(-1);\n";
echo "</script>";
}
}
else 
{	
echo "<script type='text/javascript'>\n";
echo "alert('Make sure you entered the User ID and Password!');\n";
echo "history.go(-1);\n";
echo "</script>";
}	 
mysql_close();
}
/*
$password=($password);
$result=mysql_query("SELECT * FROM login WHERE `user_id`='$user_id' AND `password`='$password'");

if((!$user_id) || (!$password))
{
	echo '<script = "JAVASCRIPT">alert("Make sure you entered the User ID and Password");
			window.location="index.php"</script>';
	
	exit();
}

if( mysql_num_rows($result) > 0 )
{
   $data=mysql_fetch_array($result);

   $_SESSION['user_id']=$data['user_id'];
   $_SESSION['status']=$data['status'];
   $_SESSION['name']=$data['name'];
	
   header("Location:home_officer.php");
   }
   else
   {
  	echo '<script = "JAVASCRIPT">alert("Wrong User ID or Password!");
		window.location="index.php"</script>';
   } 
{

}
*/

function AccessDenied()
{
if($_SESSION['user_id']=="")
{
echo "<script language=javascript> alert('Invalid Access! Please Login');</script>";
header("Refresh:0;url=index.php");
}
}
?>