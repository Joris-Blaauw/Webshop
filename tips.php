<?php
$PageName = "Tips";

require 'Prefabs/Shared.php';
$DBHandler = new Shared\DB($PageName);
$Queries = new Shared\Queries();

$PageInfo = $DBHandler->FetchPageInfo();


$Tips = $DBHandler->FetchAssoc("SELECT Title, Content, Img FROM section WHERE Page = '$PageName' ORDER BY Ordrr");

$DBHandler->CloseConn();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Prefabs/defaultStyle.css" rel="stylesheet">
    <title>Tips & Tricks</title>
</head>
    <body>
        <?php include('Prefabs/header.html')?>
        <?php
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
