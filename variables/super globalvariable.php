<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>
    super global variable.
    $_REQUEST, $_GET,$_POST
    </h2>
    <!-- <div> 
        <?php 
        echo $_REQUEST['n']
        ?>
        <form action=""> 
            Name : <br>
            <input type="text" name="n">
            <input type="submit" value="SUBMIT">
        </form>
    </div> -->
    <?php 
    echo $_POST['a']
    ?>

    <div>
        <form action="#" method="post">
              Name : <br>
            <input type="text" name="a">m
            <input type="reset">
        </form>
    </div>
</body>
</html>