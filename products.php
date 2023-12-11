<?php
session_start();

$servername = "145.53.245.193";
$username = "webshop";
$password = "webcrimes";
$dbname = "webshop";
$page = "Products";
$sql = "SELECT * FROM product";

$conn = new mysqli($servername, $username, $password, $dbname);
$result = mysqli_query($conn, $sql);
$AllProducts = mysqli_fetch_all($result);
mysqli_close($conn);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Prefabs/defaultStyle.css">
    <title>Webshop</title>
</head>
<body>
<?php include('Prefabs/header.html') ?>
<ul>
    <?php
    foreach ($AllProducts as $Product) {
        echo "<li>Name: $Product[1]<br>Image: $Product[2]<br>Description: $Product[3]<br>Price: $Product[4]<br>Unit: $Product[5]<br>Delivery_Time: $Product[6]<br>Stock: $Product[7]<br>Sale: $Product[8]<br>Category: $Product[9]</li><br>";
    }
    ?>
</ul>
<?php include('Prefabs/footer.html') ?>
</body>
</html>