<?php
session_start(); // Initialise Session
if (!array_key_exists("ShoppingCartItems", $_SESSION)) {
    $_SESSION['ShoppingCartItems'] = array();
}

if (array_key_exists("DeleteItemId", $_POST)) { // If the "DeleteItemId" key exists in $_POST, go over each item in the shopping list to check if the id matches the clicked button.
    foreach ($_SESSION["ShoppingCartItems"] as $Id => $Item) {
        if ($Item["Id"] == $_POST["DeleteItemId"]) { // If the id is a positive match, unset the item in the shopping cart, dismiss the signal and break out of the loop
            unset($_SESSION["ShoppingCartItems"][$Id]);
            unset($_POST["DeleteItemId"]);
            break;
        }
    }
} elseif (array_key_exists("DecrementAmount", $_POST)) { // If the "DecrementAmount" key exists in $_POST, go over each item in the shopping list to check if the id matches the clicked button.
    foreach ($_SESSION["ShoppingCartItems"] as $Id => $Item) {
        if ($Item["Id"] == $_POST["DecrementAmount"]) { // If the id is a positive match, decrement the amount value, check if its 0 (if so, remove the item from the shopping cart), dismiss the signal and break out of the loop
            $_SESSION["ShoppingCartItems"][$Id]["Amount"] -= 1;
            if ($_SESSION["ShoppingCartItems"][$Id]["Amount"] == 0) {
                unset($_SESSION["ShoppingCartItems"][$Id]);
            }
            unset($_POST["DecrementAmount"]);
            break;
        }
    }
} elseif (array_key_exists("IncrementAmount", $_POST)) { // If the "IncrementAmount" key exists in $_POST, go over each item in the shopping list to check if the id matches the clicked button.
    foreach ($_SESSION["ShoppingCartItems"] as $Id => $Item) {
        if ($Item["Id"] == $_POST["IncrementAmount"]) { // If the id is a positive match, increment the amount value, dismiss the signal and break out of the loop
            $_SESSION["ShoppingCartItems"][$Id]["Amount"] += 1;
            unset($_POST["IncrementAmount"]);
            break;
        }
    }
}

require 'Prefabs/Shared.php'; // Add Shared Class (db manager and stuff)
$DBHandler = new Shared\DB("Cart");

$PageInfo = $DBHandler->FetchPageInfo(); // Fetch Page Info

$DBHandler->CloseConn();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $PageInfo["Title"]?></title>
    <link rel="icon" href="Images/favicon.png">
    <link rel="stylesheet" href="Prefabs/defaultStyle.css">
    <link rel="stylesheet" href="Styles/Cart.css">
</head>
<body>
<?php include('Prefabs/header.html')?>
<?php
if (empty($_SESSION["ShoppingCartItems"])) { // If Shopping Cart Empty, Say So.
    echo "<h2>No items in shopping cart</h2>";
} else { // If shopping cart not empty, go over each of the items in the shopping cart and echo the "formatted" version of it (just the values applied in html)
    echo "<div class='ItemList'>";
    foreach ($_SESSION["ShoppingCartItems"] as $Item) {
        $DeleteButton = "<span class='CartItemButtons'><form method='POST'><input type='hidden' value='$Item[Id]' name='DecrementAmount'><input class='CartItemSubmitButton CartItemDecrementSubmitButton' type='submit' value='-'></form><form method='POST'><input type='hidden' value='$Item[Id]' name='DeleteItemId'><input class='CartItemSubmitButton CartItemDeleteSubmitButton' type='submit' value='X'></form><form method='POST'><input type='hidden' value='$Item[Id]' name='IncrementAmount'><input class='CartItemSubmitButton CartItemIncrementSubmitButton' type='submit' value='+'></form></span>";
        echo "<div class='CartItem'><span class='CartItemTitle'>$Item[Title]</span><span class='CartItemPrice'>".($Item["Discount"] ? "<div class='CartItemOldPrice'>€$Item[Price]</div><div class='CartItemNewPrice'>€".$Item["Price"]-$Item["Discount"]."</div>" : "€$Item[Price]")."</span><span class='CartItemProductDesc'>$Item[Description]</span><span class='CartItemAmount'>$Item[Amount]</span>".$DeleteButton."</div>";
    }
    echo "</div><br><br><br><br>";

    $TotalPrice = 0.00;
    foreach ($_SESSION["ShoppingCartItems"] as $Item) {
        $TotalPrice += ($Item["Price"] * $Item["Amount"]);
    }

    echo "Total Price: €".number_format($TotalPrice, 2);
}
?>
<?php include('Prefabs/footer.html')?>
</body>
</html>
