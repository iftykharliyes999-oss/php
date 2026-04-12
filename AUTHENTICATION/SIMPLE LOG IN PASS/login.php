<?php session_start();
if(isset($_POST["login"])){ 
    $us = $_POST["user"];
    $pa = $_POST["pass"];
    $file = file("data.txt"); 

    $found = false;

    foreach($file as $line){
        list($_username, $_password) = explode(",", trim($line));

        if($_username == $us && $_password == $pa){
            $found = true;
            header("location: main.php");
            exit();
        }
    }

    if(!$found){
        $msg = "Username or Password is incorrect!";
    }
}
?>

<form action="#" method="post"> 
USERNAME: <br> 
<input type="text" name="user"> <br> 
PASSWORD: <br> 
<input type="text" name="pass"> <br>
<input type="submit" value="login" name="login">
</form>