<?php
echo "</pre>";
print_r($_FILES['myfile']);
echo "</pre>";

echo "File Name: " . $_FILES['myfile']['name'] . "<br>";
echo "Temp Name: " . $_FILES['myfile']['tmp_name'] . "<br>";
echo "File Size: " . $_FILES['myfile']['size'] . "<br>";
echo "Error: " . $_FILES['myfile']['error'] . "<br>";

echo $_FILES['myfile']['full_path'];

echo "Done Upload";

?>


<form action="file_upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="myfile">
    <input type="submit" value="Upload">
</form>