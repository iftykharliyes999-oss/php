<?php 
class car
{ 
    public $name;
    public $color;


    public function setName($nam)
    { 
        $this->name = $nam;

    }
    public function getName() 
    { 
        return $this->name;
    }

    public function __destruct()
    {
       echo "<br>BYE";
    }

    public function __construct($n, $c)
    {
        echo "HELLO" . $this->name = $n . " is " . $this->color = $c;
    }
}

$result = new Car("TOYOTA","RED");
$result->setName("BMW");
echo "<br>";
echo $result->getname();


?>