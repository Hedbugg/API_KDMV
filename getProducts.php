<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// $servername = "sql306.infinityfree.com";
// $username   = "if0_40250901";
// $password   = "5H0xj3XLsZ2W";
// $dbname     = "if0_40250901_towndb";



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "towndb"; // change if your database name is different

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  echo json_encode(["success" => false, "message" => "Connection failed"]);
  exit();
}

$sql = "SELECT id, name, price, img FROM products";
$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
  $products[] = $row;
}

echo json_encode(["success" => true, "data" => $products]);

$conn->close();
?>
