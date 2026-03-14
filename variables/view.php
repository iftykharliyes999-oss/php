<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    echo $_REQUEST['uname']; 
    echo "<br>"
    echo $_REQUEST['ik'];
    ?>

    <form action="#" method="post"> 
        USER NAME: <br>
        <input type="text" name="uname"> <br>
        Email: <br> 
        <input type="email" name="ik">
        <input type="submit" value="Submit">
        
    </form>
    
