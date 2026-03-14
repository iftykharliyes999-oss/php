<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    //anonymus_function
    // $add = function ($a, $b)|{ 
    //     echo "HELLO $a";
    // }
    // $add(" world");



    // arrow function 
    $functionvarName = fn() => "HELLO WORLD";
    echo $functionvarName();

    $a = function () {};

   $b = fn($a,$b) => $a + $b;
    echo $b(5,10)



//sum
$sum = fn($a, $b) => $a + $b;

echo $sum(5, 10);

//multiplication

$multiplication = fn($a, $b) => $a * $b;

echo $multiplication(5, 10);
    ?>

</body>
</html>