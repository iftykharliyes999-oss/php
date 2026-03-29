<?php 
class student  
{ 
    public $name = "ifty";
    private $age = 44 ;
    protected $degree = "DIPLOMA";

    public function fullInfo()
    { 
        echo $this->name;
        echo $this->age;
        echo $this->degree;

    }

}
class child extends student
{ 
    public function show()
    { 
        echo "my degreeee" .this->degree;
        
    }

}


$result = new student();
echo $result->name;
echo "<br>";




?>