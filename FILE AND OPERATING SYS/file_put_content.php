<?php 
$write = file_put_contents("store.txt", "hello\n",FILE_APPEND);
echo "successfully";
echo file_get_contents("store.txt");

foreach ($result as $r) { 
 echo $r . "<br>";
}


?>