<?php

// Load shared class
require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Admin");

if (array_key_exists("AdminTitleClickedId", $_POST)) { // Handle tip deletion
    $sql = "DELETE FROM section WHERE Id = $_POST[AdminTitleClickedId]";
    unset($_POST["AdminTitleClickedId"]);
    $DBHandler->ExecuteQuery($sql);
}

if (array_key_exists("AdminTitleClickedProductId", $_POST)) {
    $sql = "DELETE FROM product WHERE Id = $_POST[AdminTitleClickedProductId]";
    unset($_POST["AdminTitleClickedProductId"]);
    $DBHandler->ExecuteQuery($sql);
}

// Tip adding thing with all the validation condensed into 1 line for readability of the rest. (Title upper limit = 255 and Content upper limit = 1000)
// If content is invalid, $ValidContent won't be set to true!
$ValidContent = false;
if (array_key_exists("TipTitle", $_POST)) {if (array_key_exists("TipContent", $_POST)) {if (strlen($_POST["TipTitle"] > 0 && strlen($_POST["TipTitle"]) < 256)) {if (strlen($_POST["TipContent"] > 0 && strlen($_POST["TipContent"]) < 1001)) {
    $DBHandler->ExecuteQuery("INSERT INTO section (Title, content, Page) VALUES ('$_POST[TipTitle]','$_POST[TipContent]','Tips')");
    unset($_POST["TipTitle"]);
    unset($_POST["TipContent"]);
    $ValidContent = true;
}}}}

// Same as for the tips, but for the products.
if (array_key_exists("ProductTitle", $_POST)) {if (array_key_exists("ProductImage", $_POST)) {if (array_key_exists("ProductDescription", $_POST)) {if (array_key_exists("ProductPrice", $_POST)) {if (array_key_exists("ProductDiscount", $_POST)) {if (array_key_exists("ProductCategory", $_POST)) {if (strlen($_POST["ProductTitle"]) < 256) {if (strlen($_POST["ProductDescription"]) < 256) {if (strlen($_POST["ProductImage"]) < 256) {
    $FormattedCategories = implode(',',$_POST["ProductCategory"]);
    $DBHandler->ExecuteQuery("INSERT INTO product (Title, Img, Description, Price, Discount, Category) VALUES ('$_POST[ProductTitle]','$_POST[ProductImage]','$_POST[ProductDescription]',$_POST[ProductPrice],$_POST[ProductPrice],'$FormattedCategories')");
    unset($_POST["ProductTitle"]);
    unset($_POST["ProductImage"]);
    unset($_POST["ProductDescription"]);
    unset($_POST["ProductPrice"]);
    unset($_POST["ProductDiscount"]);
    unset($_POST["ProductCategory"]);
    $ValidContent = true;
}}}}}}}}}

// Fetch page info
$PageInfo = $DBHandler->FetchPageInfo();
$AllTips = $DBHandler->FetchAssoc("SELECT Title, Id FROM section");
$AllProducts = $DBHandler->FetchAssoc("SELECT Title, Id FROM product");

$DBHandler->CloseConn();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $PageInfo["Title"];?></title>
    <link rel="stylesheet" href="Prefabs/defaultStyle.css">
    <link rel="icon" href="Images/favicon.png">
    <link rel="stylesheet" href="Styles/Admin.css">
    <script src="Scripts/admin.js"></script>
</head>
<body>
<?php include('Prefabs/header.html') ?>
<!-- Popups -->
<div class="popup hidden" id="AddTip">
    <h2>Add Tip</h2>
    <form method="POST">
        <div class="PopupInputContainer">
            <label for="Title">Title: </label>
            <input required type="text" id="Title" name="TipTitle" maxlength="255" placeholder="Title...">
        </div>
        <div class="PopupInputContainer">
            <label for="Title">Content: </label>
            <textarea required id="Title" name="TipContent" maxlength="1000" placeholder="Content..."></textarea>
        </div>
        <div class="PopupInputContainer">
            <input class="PopupSubmitButton" type="submit" value="Add">
            <button class="PopupCancelButton" name="AddTip" onclick="TogglePopup('AddTip')">Cancel</button>
        </div>
    </form>
</div>
<!-- TOP = Tips Popup | BOTTOM = Product Popup -->
<div class="popup hidden" id="AddProduct">
    <h2>Add Product</h2>
    <form method="POST">
        <div class="PopupInputContainer">
            <label for="Title">Title: </label>
            <input required type="text" id="Title" name="ProductTitle" maxlength="255" placeholder="Title...">
        </div>
        <div class="PopupInputContainer">
            <label for="Image">Image: </label>
            <input required type="url" id="Image" name="ProductImage" maxlength="255" placeholder="Image URL...">
        </div>
        <div class="PopupInputContainer">
            <label for="Description">Description: </label>
            <textarea required id="Description" name="ProductDescription" maxlength="255" placeholder="Description..."></textarea>
        </div>
        <div class="PopupInputContainer">
            <label for="Price">Price: </label>
            <input required type="number" id="Price" name="ProductPrice" placeholder="Price..." step="0.01">
        </div>
        <div class="PopupInputContainer">
            <label for="Discount">Discount: </label>
            <input required type="number" id="Discount" name="ProductDiscount" placeholder="Discount..." step="0.01">
        </div>
        <div class="PopupInputContainer">
            <label for="Category">Category: </label>
            <select id="Category" name="ProductCategory[]" multiple><?php
                foreach (unserialize($PageInfo["Metadata"]) as $Category) {echo "<option value='$Category'>$Category</option>";};
            ?></select>
        </div>
        <div class="PopupInputContainer">
            <input class="PopupSubmitButton" type="submit" value="Add">
            <button class="PopupCancelButton" onclick="TogglePopup('AddProduct')">Cancel</button>
        </div>
    </form>
</div>

<!-- Rest of the page -->

<h2 class="AdminPageTitle"><?php echo $PageInfo["Title"];?></h2>
<h2 class="Subtitle">Tips:</h2>
<div class="AdminPageList">
    <?php
    foreach ($AllTips as $Tip) {
        echo "<div class='AdminPageItem'><h3 class='AdminPageItemTitle'>$Tip[Title]</h3><form method='POST' class='AdminPageControlButtons'><input type='hidden' name='AdminTitleClickedId' value='$Tip[Id]'><input type='submit' class='AdminTitleDelete' value='X'></form></div>";
    }
    ?>
    <button class="AddButton" onclick="TogglePopup('AddTip')">Add Tip</button>
</div>
<h2 class="Subtitle">Products:</h2>
<div class="AdminPageList">
    <?php
    foreach ($AllProducts as $Product) {
        echo "<div class='AdminPageItem'><h3 class='AdminPageItemTitle'>$Product[Title]</h3><form method='POST' class='AdminPageControlButtons'><input type='hidden' name='AdminTitleClickedProductId' value='$Product[Id]'><input type='submit' class='AdminTitleDelete' value='X'></form></div>";
    }
    ?>
    <button class="AddButton" onclick="TogglePopup('AddProduct')">Add Product</button>
</div>
<?php include('Prefabs/footer.html') ?>
</body>
</html>