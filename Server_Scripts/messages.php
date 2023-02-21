<?php
session_start();
sendNewMessage();

function sendNewMessage(){
#function to clean the sent messages to avoid harm
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$message_body = test_input($_POST['message_body']);
$sender_id = senderID();
    $conn = new mysqli("localhost", "root", "", "wechat_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  else{
        echo"connected successifully <br>"; 
    }
    //echo "<br> sender id:".$sender_id;
    //$sql = "INSERT INTO messages(sender_id, message_body) VALUES(?,?)";
    $sql = $conn->prepare("INSERT INTO messages(sender_id, message_body) VALUES(?, ?)");
    $sql->bind_param("is",$sender_id, $message_body);
    try{
      if ($sql->execute() === TRUE) {
        echo "message sent successifully<br>";
      }
    }catch(Exception $e){
      if ($e->getCode() == 1062) {
        // Handle the exception with error code 123
        echo "Error 123: " . $e->getMessage();
      } else {
        // Handle all other exceptions
        echo "An error occurred: " . $e->getMessage();
      }
    }
$conn->close();
}
displayUsersList();
#function for the db admin to see the messages list
 function displayUsersList(){
  // CONNECTING TO THE DATABASE
  #Check connection
  $servername = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "wechat_db";
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  $sender_id = senderID();
  $sql = ("SELECT * fROM messages;");
  $result = mysqli_query($conn, $sql);
//   // Check for errors
  if(!$result) {
    die("Error retrieving the data!!: " . $sql . "<br>" . mysqli_error($conn));
  }
//   // Output the table data
  if(mysqli_num_rows($result) > 0) {
//     //creating and styling a table to display the data
    echo "<style >
            table {
              border-collapse: collapse;
              width: 100%;
              margin: 20px 0;
              font-size: 18px;
              color: #333;
              background-color: lightgrey;
              color: black;
              font-family: Verdana, Geneva, Tahoma, sans-serif;
              font-size: 0.8em;
            }
            th, td {
              text-align: left;
              padding: 8px;
              border: solid 1px;
              border-color: green; 
            }
            th {
              background-color: #f2f2f2;
              color: #555;
              font-weight: bold;
              boder-width: 0.3em;
            }
            td {
              border-bottom: 1px solid #ddd;
              border: solid 1px;
              border-color: green; 
              padding: 0.5em;
            }
            tbody tr:nth-child(even) {
              background-color: #f2f2f2;
              color: black;
            }
          </style>
          <table>
          <tr><th>MESSAGE ID</th>
          <th>SENDER ID</th>
          <th>MESSAGE BODY</th>
          <th>SEND TIME</th>
          </tr>";
    while($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr><td>" . "M". $row["message_id"].
                    "</td><td>" ."U". $row["sender_id"].
                    "</td><td>"  . $row["message_body"]. 
                    "</td><td>" . $row["send_time"].
               "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }
}
//GETTING THE SESSION USER ID(this id will be embeded to the messages table as the sender id).
function senderID(){
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