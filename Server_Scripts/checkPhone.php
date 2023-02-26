<?php

    #check that the phone number is not registered.
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'wechat_db';
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $phone_number = $_REQUEST['phone_no'];
    $sql = "SELECT * FROM users_data WHERE phone_number = '$phone_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "The phone number is already registered ";
    } else {
        echo "success";
    }
    $conn->close();

?>
