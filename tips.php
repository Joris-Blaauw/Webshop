<?php
// Loading shared class
require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB("Tips");
$Queries = new Shared\Queries();

// Fetch page info and tips out of database
$PageInfo = $DBHandler->FetchPageInfo();
$Tips = $DBHandler->FetchAssoc("SELECT Title, Content, Img FROM section WHERE Page = 'Tips' ORDER BY Ordrr");

$DBHandler->CloseConn();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Prefabs/defaultStyle.css" rel="stylesheet">
    <title><?php echo $PageInfo["Title"]?></title>
</head>
    <body>
        <?php include('Prefabs/header.html')?>
        <?php // Loop over each tip in the database if there are any, and display it in html format
        echo "<h1>". $PageInfo["Title"] . "</h1>";

        if ($Tips) {
            foreach ($Tips as $Tip) {
                echo $Tip["Title"] . "<br>" . $Tip["Content"] . "<br> <br>";
            }
        }
        ?>
        <?php include('Prefabs/footer.html')?>
    </body>
</html>
