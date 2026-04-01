<?php





interface liyes{


public function info2();
public function info3();
public function info4();



}

class Teacher implements liyes{

    public function info2()
    {
        echo "allah mohan";
    }
    public function info3()
    {
         echo "allah mohan 2";
    }
    public function info4()
    {
         echo "allah mohan 3";
    }
}


$t = new Teacher;

$t->info2();
$t->info3();
$t->info4();



?>