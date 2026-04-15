<?php
session_start();

if(!isset($_SESSION['user'])){
    header("location: login.php");
    exit();
}

if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
    exit();
}

$msg = "";

if(isset($_POST['Upload'])){

    $fileName = $_FILES['myfile']['name'];
    $tempName = $_FILES['myfile']['tmp_name'];
    $fileSize = $_FILES['myfile']['size'];

    $kb = $fileSize / 1024;
    $typ = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $destination = __DIR__ . "/images/";

    if(!is_dir($destination)){
        mkdir($destination, 0777, true);
    }

    $maxSize = 2048;
    $allowed = ["jpg","jpeg","png"];

    if($kb > $maxSize){
        $msg = "File too large (Max 2MB)";
    } elseif(!in_array($typ, $allowed)){
        $msg = "Only JPG, JPEG, PNG allowed";
    } else {

        $newName = time() . "_" . $fileName;

        if(move_uploaded_file($tempName, $destination.$newName)){
            $msg = "Upload successful!";
            $imgPath = "images/" . $newName;
        } else {
            $msg = "Upload failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    text-align: center;
}

.container {
    margin-top: 80px;
}

.box {
    background: white;
    padding: 25px;
    width: 350px;
    margin: auto;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

button {
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.upload-btn {
    background: #28a745;
    color: white;
}

.logout-btn {
    background: red;
    color: white;
    margin-top: 15px;
}

.msg {
    margin: 10px 0;
}

img {
    margin-top: 10px;
    border-radius: 8px;
}
</style>

</head>
<body>

<div class="container">
<div class="box">

<h2>Welcome, <?php echo $_SESSION['user']; ?></h2>

<div class="msg"><?php echo $msg; ?></div>

<form method="post" enctype="multipart/form-data">
<input type="file" name="myfile" required><br><br>
<button class="upload-btn" name="Upload">Upload Image</button>
</form>

<?php if(isset($imgPath)){ ?>
<img src="<?php echo $imgPath; ?>" width="200">
<?php } ?>

<form method="post">
<button class="logout-btn" name="logout">Logout</button>
</form>

</div>
</div>

</body>
</html>