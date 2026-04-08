<?php

// $data = "jd867kA";
// $s = "/^[a-zA-Z0-9@#$^+=]{8,12}$/";
// echo preg_match_all($s, $data);



$email = "iftykharliyes999@gmail.com";
$p = "/^[a-zA-Z0-9-+]+@[a-zA-Z]+\.[a-zA-Z0-9]{3,}$/";
echo preg_match_all($p,$email);
?>