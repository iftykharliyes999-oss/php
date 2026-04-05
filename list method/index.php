<?php
// $array = [
//     [1, "ifty", 23, "ifty99@gmail.com", "+02454484"],
//     [2, "khar", 20, "khar499@gmail.com", "+02454484"],
//     [3, "liyes", 22, "yes45@gmail.com", "+0246878"],
//     [4, "kokaggi", 33, "nfkf99@gmail.com", "+0854484"],
// ];


// //for variable value assign and array distructing

// foreach ($array as list($id, $name, $age, $gmail, $number)) {
//     echo "$id | $name |$age |$gmail |$number <br> ";
// }




$files = file("data.txt");

foreach ($files as $file){
    list($id, $name, $address) = explode(",", $file);
    echo "ID:" . $id . " NAME:" . $name . " ADDRESS:" . $address . "<br>";
}











?>



