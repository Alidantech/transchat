<?php
session_start();
echo "<style>
html, body {
  background-color: gray;
}
</style>";
sendNewMessage();
//echo isset($_SESSION['phone_number']);

#function to clean the sent messages to avoid harm.
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//GETTING THE SESSION USER ID(this id will be embeded to the messages table as the sender id).
function getSenderID(){
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
#this funtion checks if a message is clean then sends it else warns the sender if its not.
function sendNewMessage(){
  $message_body = test_input($_POST['message_body']);
  $sender_id = getSenderID();
  $conn = new mysqli("localhost", "root", "", "wechat_db");
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }  else{
          echo"connected successifully <br>"; 
      }
      #check if the message contains vulgar words.
      $bad_message = false;
      $vulgar_word = array(); 
      $bad_words = file('vulgar_words.txt', FILE_IGNORE_NEW_LINES);
      foreach ($bad_words as $bad_word) {
          if(strpos(strtolower($message_body), $bad_word)){
            $bad_message = true;
            $vulgar_word = $bad_word;
            echo $vulgar_word."<br>";
          }
      }
      if($bad_message){# if the message is bad warn the user.
          echo "you are using bad words in this group and you might get yourself removed.";
          echo $message_body;
          
      }else{ #if the message is fine add it to messages
          $sql = $conn->prepare("INSERT INTO messages(sender_id, message_body) VALUES(?, ?)");
          $sql->bind_param("is",$sender_id, $message_body);
          try{
            if ($sql->execute() === TRUE) {
              echo "message sent successifully<br>";
            }
          } catch(Exception $e){
            if ($e->getCode() == 1062) {
              echo "Error 123: " . $e->getMessage();
            } else {
              echo "An error occurred: " . $e->getMessage();
            }
          }
          displayMessagesList();
    }
  $conn->close();
}
#function for the db admin to see the messages list
 function displayMessagesList(){
  // CONNECTING TO THE DATABASE
  #Check connection
  $servername = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "wechat_db";
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  #$sender_id = getSenderID()();
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
?>