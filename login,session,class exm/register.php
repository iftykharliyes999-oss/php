<?php
session_start();

$msg = "";

if(isset($_POST["register"])){

    $us = trim($_POST["user"]);
    $pa = trim($_POST["pass"]);

    if(!filter_var($us, FILTER_VALIDATE_EMAIL)){
        $msg = "Invalid email format!";
    }
    elseif(strlen($pa) < 8){
        $msg = "Password must be at least 8 characters!";
    }
    else {

        $file = __DIR__ . "/data.txt";

        if(!file_exists($file)){
            file_put_contents($file, "");
        }

        $lines = file($file);
        $exists = false;

        foreach($lines as $line){
            $parts = explode(",", trim($line));
            if(count($parts) < 2) continue;

            if($parts[0] == $us){
                $exists = true;
                break;
            }
        }

        if($exists){
            $msg = "User already exists!";
        } else {

            $hash = password_hash($pa, PASSWORD_DEFAULT);

            file_put_contents($file, $us . "," . $hash . "\r\n", FILE_APPEND);

            $msg = "Registration successful!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #43cea2, #185a9d);
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

button {
    width: 100%;
    padding: 10px;
    background: #43cea2;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #2bbbad;
}

.msg {
    font-size: 14px;
    margin-bottom: 10px;
    color: red;
}
</style>

</head>
<body>

<div class="box">
<h2>Register</h2>

<div class="msg"><?php echo $msg; ?></div>

<form method="post">
<input type="text" name="user" placeholder="Email" required>
<input type="password" name="pass" placeholder="Password" required>

<button name="register">Register</button>
</form>

<br>
<a href="login.php">Go to Login</a>

</div>

</body>
</html>