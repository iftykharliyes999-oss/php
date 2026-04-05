<?php

class Person {
    public $name;
    public $address;

    function __construct($name, $address) {
        $this->name = $name;
        $this->address = $address;
    }
}

class Student extends Person {
    public $id;

    function __construct($name, $id, $address) {
        parent::__construct($name, $address);
        $this->id = $id;
    }

    function format() {
        return $this->name . "," . $this->id . "," . $this->address . "\n";
    }
}

?>