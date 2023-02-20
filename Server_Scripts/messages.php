<?php
 $timestamp = date('Y-m-d H:i:s');
 $sender_id = senderID();
 $message_body = test_input($_POST['message_body']);
 $reciever_id = 0001;
#function to clean the sent messages to avoid harm
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function sendNewMessage($sender_id, $message_body, $reciever_id, $timestamp){
    $conn = new mysqli("localhost", "root", "", "wechat_db");
    $sql = "INSERT INTO messages(sender_id, reciever_id, message_body, send_time)
            VALUES($sender_id, $message_body, $reciever_id, $timestamp); ";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  else{
        echo"connected successifully";
    }
    if ($conn->query($sql) === TRUE) {
         echo "New table created successfully<br>";
    }  else {
        echo "failed to create table " .$sql . "<br>" . $conn->error;
    }
$conn->close();
}
#function for the db admin to see the messages list
 function displayUsersList(){
  // CONNECTING TO THE DATABASE
  #Check connection
  $servername = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "wechat_db";
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  $sql = ("SELECT * fROM messages;");
  $result = mysqli_query($conn, $sql);
//   // Check for errors
  if(!$result) {
    die("Error retrieving the data!!: " . $sql . "<br>" . mysqli_error($conn));
  }
//   // Output the table data
  if(mysqli_num_rows($result) > 0) {
//     //creating and styling a table to display the data
    echo "<style>
            table {
              border-collapse: collapse;
              width: 100%;
              margin: 20px 0;
              font-size: 18px;
              color: #333;
            }
            
            th, td {
              text-align: left;
              padding: 8px;
            }
            
            th {
              background-color: #f2f2f2;
              color: #555;
              font-weight: bold;
            }
            
            td {
              border-bottom: 1px solid #ddd;
            }
            
            tbody tr:nth-child(even) {
              background-color: #f2f2f2;
            }
            
          </style>
          <table>";
    while($row = mysqli_fetch_assoc($result)) {
          echo "<tr><td>" .  $row["id"].
                    "</td><td>" . $row["user_id"].
                    "</td><td>" . $row[""]. 
                    "</td><td>" . $row["password"]. 
                    "</td><td>" . $row["registration_date"].
               "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }
}
//GETTING THE SESSION USER ID(this id will be embeded to the messages table as the sender id).
function senderID(){
  session_start();
  $phone_number = $_SESSION['phone_number'];
  $conn = mysqli_connect('localhost', 'root', '', 'wechat_db');
  if (!$conn) {
      die('Connection failed: ' . mysqli_connect_error());
  }
  $sql = "SELECT id FROM users_data WHERE phone_number = '$phone_number'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $user_id = $row['id'];
  } else {
      echo "Error: No user found with phone number $phone_number";
  }
  mysqli_close($conn);
  return  $user_id;
}

?>