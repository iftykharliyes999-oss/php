<?php
require_once("classes.php");

$message = "";
$searchResult = "";

if (isset($_POST["btnsubmit"])) {

    $uid = $_POST["id"];
    $uname = $_POST["name"];
    $ubatch = $_POST["batch"];

    $s = new Student($uid, $uname, $ubatch);
    $s->store();

    $message = "Data Successfully Added!";
}


if (isset($_POST["btnsearch"])) {

    $search_id = $_POST["search_id"];

    $s = new Student($search_id, "", "");
    ob_start(); 
    $s->result($search_id);
    $searchResult = ob_get_clean();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student System</title>
</head>
<body>

<h2>Student Entry Form</h2>

<?php if ($message != "") echo $message; ?>

<form method="post">
    <input type="number" name="id" placeholder="id" ><br><br>
    <input type="text" name="name" placeholder="name" ><br><br>
    <input type="number" name="batch" placeholder="batch" ><br><br>
    <button type="submit" name="btnsubmit">Submit</button>
</form>

<hr>

<h2>Search Result by ID</h2>

<form method="post">
    <input type="number" name="search_id" placeholder="Enter ID" required>
    <button type="submit" name="btnsearch">Search</button>
</form>

<br>

<?php echo $searchResult; ?>

<hr>

<h2>All Students</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Batch</th>
    </tr>

    <?php Student::display(); ?>

</table>

</body>
</html>