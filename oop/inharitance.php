<?php 
class students
{
    public $name;
    public $age;
    public $address;


    public function __construct()
    {
        echo "HELLO STUDENT";
    }
        
    public function __destruct()
    {
        echo "<br>GOOD BYE";
    }

    public function details($nm){
        echo "my name is " .$this->name =$nm;
    }

}
class teacher extends students
{ 
    public $experiance;
   
    public function teacherDetails($ad) 
    {
        echo "Hi teacher" .$this->address =$ad;
    }

}




$st= new students();

$st->details("luiyes");
$st->details("yes");
echo "<br>";
$tr= new teacher();
$tr->teacherDetails("jsfhsfiuh");





?>