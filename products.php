<?php
session_start();

require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Products");
$Queries = new Shared\Queries();

$PageInfo = $DBHandler->FetchPageInfo();
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
    <link rel="stylesheet" href="Styles/Products.css">
    <title><?php echo $PageInfo["Title"]?></title>
</head>
<body>
<?php include('Prefabs/header.html') ?>
<div class="ProductContainer">
    <?php
    foreach ($AllProducts as $Product) {
        echo "<div class='ProductCard'><h2 class='ProductTitle'>$Product[Title]</h2><br><img src='$Product[Img]' alt='Product Image' class='ProductImg'><br><span class='ProductDesc'>$Product[Description]</span><br><span class='ProductPrice'>".($Product["Discount"] ? "<span class='ProductOldPrice'>$$Product[Price]</span> <span class='ProductNewPrice'>$".$Product["Price"]-$Product["Discount"]."</span>" : "$".$Product["Price"])."</span></div>";
    }
    ?>
</div>
<?php include('Prefabs/footer.html') ?>
</body>
</html>