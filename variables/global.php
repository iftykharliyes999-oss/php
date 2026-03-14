<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    $a= 12;
    $b= 10;
    function add (){ 
        global $a,$b,$c;
        $c=$a+$b;
    }
    add();
    echo $c;
    ?>
</body>
</html>