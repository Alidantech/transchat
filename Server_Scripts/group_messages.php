<?php 
#connect to the database

    $conn = new mysqli("localhost", "root", "", "wechat_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM group_messages JOIN users_data ON group_messages.sender_id = users_data.id";
    $result = $conn->query($sql);
    // Fetch the data
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Convert the data to JSON format
    $json = json_encode($data);
    // Write the JSON data to a file
    $file_path = 'group_messages.json';
    file_put_contents($file_path, $json);

    $conn->close();
?>