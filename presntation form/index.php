<?php
include "classes.php";

// SAVE
if (isset($_POST["submit"])) {
    $s = new Student($_POST["name"], $_POST["id"], $_POST["address"]);
    file_put_contents("data.txt", $s->format(), FILE_APPEND);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple System</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            text-align: center;
        }

        form {
            background: white;
            padding: 20px;
            margin: 20px auto;
            width: 300px;
            border-radius: 10px;
        }

        input, button {
            width: 90%;
            padding: 8px;
            margin: 5px;
        }

        button {
            background: green;
            color: white;
            border: none;
        }

        table {
            margin: auto;
            background: white;
            border-collapse: collapse;
            width: 70%;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        a {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Student Form</h2>

<form method="post">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="id" placeholder="ID" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <button name="submit">Save</button>
</form>

<table>
<tr>
    <th>Name</th>
    <th>ID</th>
    <th>Address</th>
</tr>

<?php
if (file_exists("data.txt")) {
    $data = file("data.txt");

    foreach ($data as $i => $line) {
        $row = explode(",", $line);

        echo "<tr>
                <td>$row[0]</td>
                <td>$row[1]</td>
                <td>$row[2]</td>
              </tr>";
    }
}
?>

</table>

</body>
</html>