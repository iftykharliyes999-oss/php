<?php 
class car { 
public $model="seadn1279";
public $color="Blue";
public $name ="BMW";

function info($c){ 
    $this->color = $c;
    return $this->color;

}
 function start(){
        return "Car is starting...";
    }
function reverse(){
        return "Car is moving backward...";
    }
}
$result=new car();
echo $result->color;
echo "<br>";
echo $result->info("BLACK"); 
echo "<br>";
echo $result->start();
echo "<br>";
echo $result->reverse();
?>