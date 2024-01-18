<?php
// Loading shared class
require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Tips");

// Fetch page info and tips out of database
$PageInfo = $DBHandler->FetchPageInfo();
$Tips = $DBHandler->FetchAssoc("SELECT Title, Content, Img FROM section WHERE Page = 'Tips'");

$DBHandler->CloseConn();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Images/favicon.png">
    <link href="Prefabs/defaultStyle.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/Tips.css">
    <title><?php echo $PageInfo["Title"]?></title>
</head>
    <body>
        <?php include('Prefabs/header.html')?>
        <?php // Loop over each tip in the database if there are any, and display it in html format
        echo "<h2 class='TipHeader'>". $PageInfo["Title"] . "</h2>";

        if ($Tips) {
            foreach ($Tips as $Tip) {
                echo "<div class='TipContainer'><h3 class='TipTitle'>$Tip[Title]</h3><p class='TipText'>$Tip[Content]</p></div>";
            }
        }
        ?>
        <?php include('Prefabs/footer.html')?>
    </body>
</html>
