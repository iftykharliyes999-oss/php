<?php

class Student
{

    protected $id;
    public $name;
    public $batch;

    public static $file_source = "student-text.txt";


    public function __construct($id, $name, $batch)
    {
        $this->id = $id;
        $this->name = $name;
        $this->batch = $batch;
    }


    public function store()
    {
        $data = $this->id . "," . $this->name . "," . $this->batch . PHP_EOL;
        file_put_contents(self::$file_source, $data, FILE_APPEND);
    }


    public function result($search_id)
    {

        if (!file_exists(self::$file_source)) {
            echo "File not found!";
            return;
        }

        $file = file(self::$file_source);
        $found = false;

        foreach ($file as $line) {

            list($id, $name, $batch) = explode(",", trim($line));

            if ($id == $search_id) {

                echo "ID: " . $id . "<br>";
                echo "Name: " . $name . "<br>";
                echo "Batch: " . $batch . "<br>";

                $found = true;
                break;
            }
        }

        if (!$found) {
            echo "<h3>Result not found!</h3>";
        }
    }


    public static function display()
    {

        if (!file_exists(self::$file_source)) {
            return;
        }

        $file = file(self::$file_source);

        foreach ($file as $line) {
            list($id, $name, $batch) = explode(",", trim($line));
            echo "<tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$batch</td>
                  </tr>";
        }
    }
}

?>