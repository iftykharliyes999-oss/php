<!DOCTYPE html>
<html>
<head>
    <title>Fibonacci in PHP</title>
</head>
<body>

<form method="post">
    Enter number: 
    <input type="number" name="num" required>
    <input type="submit" name="submit" value="Generate">
</form>

<?php

if(isset($_POST['submit'])){

    $num = $_POST['num'];

    $first = 0;
    $second = 1;

    echo "<h3>Fibonacci Series:</h3>";

    if($num <= 0){
        echo "Invalid number";
    }
    else if($num == 1){
        echo $first;
    }
    else{
        echo $first . " , " . $second;

        for($i = 3; $i <= $num; $i++){
            $next = $first + $second;
            echo " , " . $next;

            $first = $second;
            $second = $next;
        }
    }
}

?>

</body>
</html>