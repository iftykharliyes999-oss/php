<?php

//pattern/modifier//(i-case - insensative)
//preg_match all
$str = "Lorem Ipsum is simply dummy text of the printing and typesetting industry";
$pattern = "/s/i";
echo preg_match_all($pattern,$str);



?>