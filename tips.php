<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="defaultStyle.css" rel="stylesheet">
    <title>Tips & Tricks</title>
</head>
    <body>
        <?php include('header.html')?>
    </body>
</html>

<?php

$servername = "145.53.245.193";
$username = "webshop";
$password = "webcrimes";
$dbname = "webshop";
$page = "Tips";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

/* create header*/
$sql = "SELECT Title, Logo FROM page WHERE Role = '$page'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "<img src='" . $row["Logo"] . "'>" . "<h1>". $row["Title"] . "</h1>";
  }
} else {
  echo "error";
}

$sql = "SELECT Title, Content FROM section WHERE Page = '$page' ORDER BY Ordrr";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo $row["Title"] . "<br>" . $row["Content"] . "<br> <br>";
  }
} else {
  echo "0 results";
}

mysqli_close($conn); 

?>