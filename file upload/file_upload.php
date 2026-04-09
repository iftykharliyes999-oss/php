<?php

if(isset($_FILES['myfile'])){

    $fileName = $_FILES['myfile']['name'];
    $tempName = $_FILES['myfile']['tmp_name'];
    $fileSize = $_FILES['myfile']['size'];
    $error = $_FILES['myfile']['error'];

    $maxSize = 2 * 1024 * 1024; // 2MB
    $allowedExt = ['jpg', 'jpeg', 'png'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $uploadDir = "imges/";

    // folder না থাকলে create করবে
    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0777, true);
    }

    if($error === 0){

        // extension check
        if(!in_array($fileExt, $allowedExt)){
            echo " Only JPG, JPEG, PNG allowed!";
        }

        // size check
        elseif($fileSize > $maxSize){
            echo " File too large! Max 2MB allowed.";
        }

        else{
            // unique file name
            $newName = time() . "_" . uniqid() . "." . $fileExt;

            $uploadPath = $uploadDir . $newName;

            if(move_uploaded_file($tempName, $uploadPath)){
                echo " Upload Successful! <br><br>";

                // image show
                echo "<img src='".$uploadPath."' width='300'>";
            } else {
                echo "Failed to upload!";
            }
        }

    } else {
        echo " Error uploading file!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<body>

<h2>Upload Image</h2>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="myfile" required>
    <br><br>
    <input type="submit" value="Upload Image">
</form>

</body>
</html>