<?php 
$result = fopen("first.txt","r") ;
// echo fread($result,filesize("first.txt"));
// fclose($result);
// echo readfile("data.txt");
$r = file_get_contents("data.txt", "HELLO WORLD");
echo $r;



?>