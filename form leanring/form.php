<?php

class DataSaver {

    public function save($name, $id) {
        $file = fopen("data.txt", "a");
        fwrite($file, "Name: $name, ID: $id\n");
        fclose($file);
    }
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $id   = $_POST['id'];

    $obj = new DataSaver();
    $obj->save($name, $id);
}

?>
<form method="post">
    Name: <input type="text" name="name"><br><br>
    ID: <input type="text" name="id"><br><br>
    <input type="submit" name="submit" value="Save">
</form>

