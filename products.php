<?php
session_start(); // Initialise session
if (!array_key_exists("ShoppingCartItems", $_SESSION)) {
    $_SESSION['ShoppingCartItems'] = array();
}

// Load shared class
require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Products");
$Queries = new Shared\Queries();

// Fetch page info and products
$PageInfo = $DBHandler->FetchPageInfo();
$AllProducts = $DBHandler->FetchAssoc("SELECT * FROM product");

if (!empty($_POST)) { // If $_POST Not empty
    if (array_key_exists("ClickedProductId", $_POST)) { // Check if a product is clicked
        if (array_key_exists("ShoppingCartItems", $_SESSION)) { // Check if there is a shopping cart. *1
            // Fetch the clicked product from the database using its id, and add amount (currently 1)
            $ProductToAdd = $DBHandler->FetchAssoc("SELECT * FROM product WHERE Id = $_POST[ClickedProductId]")[0];
            $ProductToAdd["Amount"] = 1;
            $ProductFound = false;
            if (!empty($_SESSION['ShoppingCartItems'])) { /* If the shopping cart is not empty, check each item and
                see if it matches the clicked item. if so, increment the amount by 1 instead of adding a new instance */
                foreach ($_SESSION["ShoppingCartItems"] as $Key => $Product) {
                    if ($Product["Id"] == $_POST['ClickedProductId']) {
                        $_SESSION["ShoppingCartItems"][$Key]["Amount"] += 1;
                        $ProductFound = true;
                    }
                }
            }
            if (!$ProductFound) { // If there was no instance of the product in the cart, add it to the cart as its own instance.
                $_SESSION["ShoppingCartItems"][] = $ProductToAdd;
            }
        } else { // *1 If not, set it to an empty array
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
    <?php // List and format all products fetched from the database
    foreach ($AllProducts as $Product) {
        echo "<div class='ProductCard'><h2 class='ProductTitle'>$Product[Title]</h2><br><img src='$Product[Img]' alt='Product Image' class='ProductImg'><br><span class='ProductDesc'>$Product[Description]</span><br><span class='ProductPrice'>".($Product["Discount"] ? "<span class='ProductOldPrice'>€$Product[Price]</span> <span class='ProductNewPrice'>€".$Product["Price"]-$Product["Discount"]."</span>" : "€".$Product["Price"])."</span><br><form action='products.php' method='post'><input type='hidden' name='ClickedProductId' value='$Product[Id]'><input type='submit' class='ProductButton' value='In Winkelmandje'></form></div>";
    }
    ?>
</div>
<a href="cart.php" class="ShoppingCartIcon"><img src="Images/cart.webp" alt="Shopping Cart"></a>
<?php include('Prefabs/footer.html') ?>
</body>
</html>