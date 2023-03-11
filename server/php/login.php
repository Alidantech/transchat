<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phoneNumber = $_POST['phone_no'];
    $password = $_POST['password'];
    $mysqli = new mysqli("localhost", "root", "", "wechat_db");
    // Query the database for the user with the specified username
    $stmt = $mysqli->prepare("SELECT * FROM users_data WHERE phone_number = ?");
    $stmt->bind_param("s", $phoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Login successful
            echo json_encode(array("success" => true));
            $_SESSION["phone_number"] = $phoneNumber;
            $_SESSION["logged_in"] = true;
            header("Location: /Layouts/chatpage.html");
        } else {
            // Incorrect password
            echo json_encode(array("error" => "Incorrect password"));
        }
    } else {
        // User not found
        echo json_encode(array("error" => "phone number not found"));
    }
    $stmt->close();
    $mysqli->close();
  }
?>
