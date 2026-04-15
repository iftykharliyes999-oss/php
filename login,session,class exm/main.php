<?php
session_start();

if(!isset($_SESSION['user'])){
    header("location: login.php");
    exit();
}

$msg = "";

/* LOGOUT */
if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
    exit();
}

/* UPLOAD */
if(isset($_POST['Upload'])){

    $fileName = $_FILES['myfile']['name'];
    $tmp = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    $price = $_POST['price'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ["jpg","jpeg","png"];

    if($size > 2*1024*1024){
        $msg = "Max 2MB allowed!";
    }
    elseif(!in_array($ext,$allowed)){
        $msg = "Only JPG/PNG allowed!";
    }
    else {

        $newName = time()."_".$fileName;

        $path = __DIR__ . "/images/";

        if(!is_dir($path)){
            mkdir($path,0777,true);
        }

        if(move_uploaded_file($tmp,$path.$newName)){

            file_put_contents(
                __DIR__ . "/products.txt",
                $newName . "," . $price . "\r\n",
                FILE_APPEND
            );

            $msg = "Upload successful!";
        }
    }
}

/* LOAD PRODUCTS */
$products = [];

$file = __DIR__ . "/products.txt";

if(file_exists($file)){
    $lines = file($file);

    foreach($lines as $line){
        $parts = explode(",", trim($line));
        if(count($parts) < 2) continue;

        $products[] = [
            "img"=>$parts[0],
            "price"=>$parts[1]
        ];
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    padding:15px 30px;
    background:linear-gradient(90deg,#667eea,#764ba2);
    color:white;
}

.logo{
    font-size:22px;
    font-weight:bold;
    transition:0.3s;
}
.logo:hover{
    color:#ffd700;
    transform:scale(1.1);
}

/* BOX */
.container{
    text-align:center;
    margin-top:40px;
}

.box{
    background:white;
    width:350px;
    margin:auto;
    padding:20px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

input,button{
    margin:5px;
    padding:10px;
    width:90%;
}

.upload-btn{
    background:green;
    color:white;
    border:none;
}

.logout-btn{
    background:red;
    color:white;
    border:none;
}

/* TABLE */
.table-container{
    width:85%;
    margin:40px auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#667eea;
    color:white;
    padding:10px;
}

td{
    text-align:center;
    padding:10px;
}

img{
    width:80px;
    border-radius:6px;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">IFTYKHAR</div>
</div>

<!-- UPLOAD -->
<div class="container">
<div class="box">

<h3>Welcome <?php echo $_SESSION['user']; ?></h3>

<form method="post" enctype="multipart/form-data">
<input type="file" name="myfile" required>
<input type="number" name="price" placeholder="Enter Price" required>
<button class="upload-btn" name="Upload">Upload</button>
</form>

<form method="post">
<button class="logout-btn" name="logout">Logout</button>
</form>

<p><?php echo $msg; ?></p>

</div>
</div>

<!-- TABLE -->
<div class="table-container">
<table>
<tr>
<th>NAME</th>
<th>IMAGE</th>
<th>PRICE</th>
<th>ADD TO CART</th>
</tr>

<?php foreach($products as $p){ ?>
<tr>
<td><?php echo $p['img']; ?></td>
<td><img src="images/<?php echo $p['img']; ?>"></td>
<td>$<?php echo $p['price']; ?></td>
<td><button>Add to Cart</button></td>
</tr>
<?php } ?>

</table>
</div>

</body>
</html>