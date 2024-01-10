<?php
session_start();
if (!array_key_exists("ShoppingCartItems", $_SESSION)) {
    $_SESSION['ShoppingCartItems'] = array();
}

require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Products");
$Queries = new Shared\Queries();

$PageInfo = $DBHandler->FetchPageInfo();
$AllProducts = $DBHandler->FetchAssoc("SELECT * FROM product");

if (!empty($_POST)) {
    if (array_key_exists("ClickedProductId", $_POST)) {
        if (array_key_exists("ShoppingCartItems", $_SESSION)) {
            $ProductToAdd = $DBHandler->FetchAssoc("SELECT * FROM product WHERE Id = $_POST[ClickedProductId]")[0];
            $ProductToAdd["Amount"] = 1;
            if (!empty($_SESSION['ShoppingCartItems'])) {
                foreach ($_SESSION["ShoppingCartItems"] as $Product) {
                    if ($Product["Id"] == $_POST['ClickedProductId']) {
                        $ProductToAdd["Amount"] = $Product["Amount"] + 1;
                    }
                }
            }
            $_SESSION["ShoppingCartItems"][] = $ProductToAdd;
        } else {
            $_SESSION["ShoppingCartItems"] = array();
        }
    }
}

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
        echo "<div class='ProductCard'><h2 class='ProductTitle'>$Product[Title]</h2><br><img src='$Product[Img]' alt='Product Image' class='ProductImg'><br><span class='ProductDesc'>$Product[Description]</span><br><span class='ProductPrice'>".($Product["Discount"] ? "<span class='ProductOldPrice'>€$Product[Price]</span> <span class='ProductNewPrice'>€".$Product["Price"]-$Product["Discount"]."</span>" : "€".$Product["Price"])."</span><br><form action='products.php' method='post'><input type='hidden' name='ClickedProductId' value='$Product[Id]'><input type='submit' class='ProductButton' value='In Winkelmandje'></form></div>";
    }
    ?>
</div>
<a href="cart.php" class="ShoppingCartIcon"><img src="Images/cart.webp" alt="Shopping Cart"></a>
<?php include('Prefabs/footer.html') ?>
</body>
</html>