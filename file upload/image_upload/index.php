<?php
if(isset($_POST['Upload'])){

    // File variables
    $fileName = $_FILES['myfile']['name'];
    $tempName = $_FILES['myfile']['tmp_name'];
    $fileSize = $_FILES['myfile']['size'];

    // Convert size to KB
    $kb = $fileSize / 1024;

    // Get file extension
    $typ = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Destination folder
    $destination = "images/";

    // Create folder if it doesn't exist
    if(!is_dir($destination)){
        mkdir($destination, 0777, true);
    }

    // Max size 2 MB
    $maxSize = 2048; // KB
    $allowed = ["jpg","jpeg","png"];

    // Validation
    if($kb > $maxSize){
        echo " File is too large. Max 2 MB allowed.";
    } elseif(!in_array($typ, $allowed)){
        echo " Only jpg, jpeg, png files are allowed.";
    } else {
        // Rename file to avoid overwrite
        $newName = time() . "_" . $fileName;

        if(move_uploaded_file($tempName, $destination.$newName)){
            echo "✅ File uploaded successfully!<br>";
            echo "<img src='".$destination.$newName."' width='200'>";
        } else {
            echo " Upload failed!";
        }
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<body>

<h2>Upload Your Image</h2>
<form action="" method="post" enctype="multipart/form-data">
    Select Image:
    <input type="file" name="myfile" required>
    <br><br>
    <input type="submit" name="Upload" value="Upload">
</form>

</body>
</html>