<?php

if(isset($_POST['submit'])){

    $num = $_POST['number'];
    $flag = true;

    if($num <= 1){
        $flag = false;
    } else {
        for($i = 2; $i < $num; $i++){
            if($num % $i == 0){
                $flag = false;
                break;
            }
        }
    }

    if($flag){
        echo $num . " is a Prime Number";
    } else {
        echo $num . " is NOT a Prime Number";
    }
}
?>

<form method="post">
    Enter Number: <input type="number" name="number">
    <input type="submit" name="submit" value="Check">
</form>
