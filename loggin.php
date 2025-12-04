<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "towndb";

$conn = new mysqli($host, $user, $pass, $dbname);

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

$sql = "SELECT * FROM logins WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['username'] = $username; // store user in session
    echo json_encode(["success" => true, "message" => "Login successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid credentials"]);
}
$conn->close();
?>
