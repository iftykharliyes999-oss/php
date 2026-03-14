<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    //pre
    $x = 10;
    echo ++$x;
    echo "<br>";

    echo "post";
    echo "<br>";

    //post
    $x = 10;
    echo $x++;
    echo "<br>"
    echo $x;    
    ?>
</body>
</html>