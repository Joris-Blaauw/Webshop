<?php
session_start();
if (!array_key_exists("ShoppingCartItems", $_SESSION)) {
    $_SESSION['ShoppingCartItems'] = array();
}

require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Cart");
$Queries = new Shared\Queries();

$PageInfo = $DBHandler->FetchPageInfo();

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
    <link rel="stylesheet" href="Prefabs/defaultStyle.css">
</head>
<body>
<?php include('Prefabs/header.html')?>
<?php
if (empty($_SESSION["ShoppingCartItems"])) {
    echo "<h2>No items in shopping cart</h2>";
} else {
    echo "<ul class='ItemList'>";
    foreach ($_SESSION["ShoppingCartItems"] as $Item) {
        echo "<li class='Item'></li>";
        print_r($Item);
    }
    echo "</ul>";
}
?>
<?php include('Prefabs/footer.html')?>
</body>
</html>
