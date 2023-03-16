<?php
session_start();
 function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

#insert the data and catch the exception if the number is already registered.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    addNewUser();
    #displayUsersList();
    $phone_number = test_input($_POST["phone_no"]);
    $_SESSION["phone_number"] = $phone_number;
    $_SESSION["logged_in"] = true;
    header("Location: /Layouts/chatpage.html");
  } catch (mysqli_sql_exception $e) {
    if($e->getCode() == 1062) {
      echo "<h3 align=center>Error: The form has already been submitted please refresh and start again.</h3>";
      echo "<style>html, body { background: linear-gradient(to right, #021100b7, #5f260681); color: lightgreen;}<style>";
    } else {
      echo "Error another error occured: " . $e->getMessage();
    }
  }
}

 #function for all the time a user registers
function addNewUser(){
  # getting the values that the user entered validating them and testing them for safety.
    $name = $phone = $password = "";
    $name = test_input($_POST["user_name"]);
    $phone = test_input($_POST["phone_no"]);
    $password = test_input($_POST["password"]);
    $timestamp = date('Y-m-d H:i:s');
  # CONNECTING TO THE DATABASE
    #Check connection
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $conn = new mysqli('localhost', "root", "", 'wechat_db');
    if($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } else{
      #echo"connected successifully";
    }
    #insert the user's data to the database
    $sql = "INSERT INTO users_data (user_name, phone_number, password, registration_date) 
            VALUES ('$name', '$phone', '$password_hash', '$timestamp')";
  if($conn->query($sql) === TRUE) {
    #echo "New record created successfully<br>";
  } else {
    echo "Error: You cannot register at the moment, try again. <br>
    If the problem persists contact your admin<br> " .$sql . "<br>" . $conn->error;
  }
  $conn->close();
}
?>
