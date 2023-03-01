<?php
    #check that the phone number is not registered.

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'wechat_db';
$number = $_POST["number"];
// Check if number already exists in database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT * FROM users_data WHERE phone_number = ?");
$stmt->execute([$number]);
$row = $stmt->fetch();
if ($row) {
  // Number already exists in database
  echo json_encode(array("error" => "Number already registered."));
} else {
  // Number doesn't exist in database
  echo json_encode(array("success" => "Number available."));
}
$conn->close();
?>
