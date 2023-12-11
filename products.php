<?php
session_start();

require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Products");
$Queries = new Shared\Queries();

$AllProducts = $DBHandler->FetchAssoc("SELECT * FROM product");

$DBHandler->CloseConn();
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
        echo "<li>Name: $Product[Title]<br>Image: $Product[Img]<br>Description: $Product[Description]<br>Price: $Product[Price]<br>Unit: $Product[Unit]<br>Delivery_Time: $Product[Delivery_Time]<br>Stock: $Product[Stock]<br>Sale: $Product[Discount]<br>Category: $Product[Category]</li><br>";
    }
    ?>
</ul>
<?php include('Prefabs/footer.html') ?>
</body>
</html>