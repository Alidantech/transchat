<?php 
#connect to the database
    $conn = new mysqli("localhost", "root", "", "wechat_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM group_members JOIN users_data ON group_members.member_id = users_data.id";
    $conn->close();
?>