<?php
  // process_form.php

  // Get the form data from the $_POST superglobal
  $name = $_POST['user_name'];
  $phone = $_POST['phone_no'];
  $password = $_POST['password'];
  // ...more form data here...

  // Process the form data and do something with it
  // ...

  #The database conection
 
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "wechat_db";

    // Create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
         die("Connection failed: ". $conn->connect_error);
    }else{
        echo "Connected successfully";
        $statement = $conn->prepare("insert into user_data(user_name, phone_number, password) values(?, ?, ?)");
        $statement ->bind_param("sss",$name,  $phone, $password);
        $statement ->execute();
        $statement ->close();
        $conn ->close();
        echo "registration successfully";

    }
?>
