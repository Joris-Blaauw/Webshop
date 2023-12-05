<?php

$servername = "145.53.245.193";
$username = "webshop";
$password = "webcrimes";
$dbname = "webshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT role FROM page";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo $row["role"] . "<br>";
  }
} else {
  echo "0 results";
}

mysqli_close($conn);