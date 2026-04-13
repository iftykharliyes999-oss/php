<?php 
session_start();

$msg = "";

if(isset($_POST["login"])){ 
    $us = $_POST["user"];
    $pa = $_POST["pass"];

    $filepath = __DIR__ . "/data.txt";

    if(file_exists($filepath)){
        $file = file($filepath);
        $found = false;

        foreach($file as $line){
            list($_username, $_password) = explode(",", trim($line));

            if($_username == $us && $_password == $pa){
                $_SESSION['user'] = $us;
                header("location: main.php");
                exit();
            }
        }

        if(!$found){
            $msg = "Username or Password incorrect!";
        }
    } else {
        $msg = "data.txt file not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.box {
    background: #fff;
    padding: 30px;
    width: 320px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    text-align: center;
}

h2 { margin-bottom: 20px; }

input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
}

input:focus {
    border-color: #667eea;
}

button {
    width: 100%;
    padding: 10px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #5a67d8;
}

.error {
    color: red;
    font-size: 14px;
}
</style>

</head>
<body>

<div class="box">
<h2>Login</h2>

<div class="error"><?php echo $msg; ?></div>

<form method="post">
<input type="text" name="user" placeholder="Email" required>
<input type="password" name="pass" placeholder="Password" required>

<button name="login">Login</button>
</form>

</div>

</body>
</html>