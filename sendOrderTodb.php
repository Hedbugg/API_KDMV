<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "towndb"; // change to your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  echo json_encode(["success" => false, "message" => "Connection failed"]);
  exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["items"]) || count($data["items"]) === 0) {
  echo json_encode(["success" => false, "message" => "No order data received"]);
  exit();
}

foreach ($data["items"] as $item) {
  $product_name = $conn->real_escape_string($item["product_name"]);
  $price = floatval($item["price"]);
  $quantity = intval($item["quantity"]);
  $total_amount = $price * $quantity;
  $order_date = date("Y-m-d H:i:s");

  $sql = "INSERT INTO orderinfo (product_name, price, quantity, total_amount, order_date)
          VALUES ('$product_name', $price, $quantity, $total_amount, '$order_date')";
  $conn->query($sql);
}

echo json_encode(["success" => true, "message" => "Order saved successfully"]);
$conn->close();
?>
