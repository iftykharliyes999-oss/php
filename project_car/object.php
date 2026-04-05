<?php 
require_once('car_class.php');
require_once('user_class.php');
require_once('user_class2.php');

use USERONE\user;
use USERTWO\user as user2;
use Car2\car;


$result = new car();
$result->user(); 

echo"<br>";

$r = new  user();
$r->userInfo();

echo"<br>";

$u = new  user2();
$u->show();


   
?>