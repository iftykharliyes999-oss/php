<!DOCTYPE html>
<html>
<body>

<form method="post">
    Enter first number: <input type="number" name="a" required><br><br>
    Enter second number: <input type="number" name="b" required><br><br>
    Enter third number: <input type="number" name="c" required><br><br>
    <input type="submit" value="Find Largest">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];

    $largest = max($a, $b, $c);

    echo "<h3>Largest number is: $largest</h3>";
}
?>

</body>
</html>