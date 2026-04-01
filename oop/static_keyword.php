<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
class User{ 
    const name="Hello world!"."<br>";
    
public static function info(){ 
   echo "This is static method <br>";
}
}

// $person =new User();
// $person->info();

echo User::info();
echo User::name;
// echo User::$name="Hello dfg!"."<br>";//error


?>
</body>
</html>