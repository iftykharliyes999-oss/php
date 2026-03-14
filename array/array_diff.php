<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

use LDAP\Result;

    $array1 = ["a","b","u"];
    $array2 = ["a","w","t"];
    $array3 = ["g","s","c"];
    $result = array_diff($array1,$array2,$array3);
    print_r($result);
    ?>
</body>
</html>