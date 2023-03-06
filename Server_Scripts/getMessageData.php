<?php
session_start();
$phone_number = $_SESSION["phone_number"];
$conn = new mysqli("localhost", "root", "", "wechat_db");
if(!$conn){
    die("Connection failed: " . $conn->connect_error);
}
$sql = ""
?>