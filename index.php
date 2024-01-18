<?php

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
    <link rel="stylesheet" href="Prefabs/defaultStyle.css">
    <link rel="stylesheet" href="Styles/Index.css">      
    <title><?php echo $PageInfo["Title"]?></title>
</head>
<body>
<?php include('Prefabs/header.html') ?>
<h1 class="infotextheader">About us</h1>
<p class="infotextbody">Don't know where to start searching for top notch cleaning products? You've come to the right place!</p>
<p class="infotextbody">Partners in Grime is a cleaning company with well over 20 years of experience in keeping your house clean and tidy.</p>
<p class="infotextbody">The best cleaning company in all of Europe!</p>
<p class="infotextbody">Need tips on how to keep your house clean? Visit our Tips and Tricks page to view the possibilities.</p>
<p class="infotextbody">Got a question? You can always reach out to us at the bottom of the page.</p>
<div class="infotextbuttoncontainer"><a href="products.php" class="infotextbodybutton">Take me to the shop!</a></div>
<?php include('Prefabs/footer.html') ?>
</body>
</html>