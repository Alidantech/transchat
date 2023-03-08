<?php
//GETTING THE SESSION USER ID(this id will be embeded to the messages table as the sender id).
#this funtion checks if a message is clean then sends it else warns the sender if its not.
function sendNewMessage($sender_id, $message_body){
  $conn = new mysqli("localhost", "root", "", "wechat_db");
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }  else{
          echo"connected successifully <br>"; 
      }
      #check if the message contains vulgar words.
      $bad_message = false;
      $vulgar_word = array(); 
      $bad_words = file('Server_Scripts/vulgar_words.txt', FILE_IGNORE_NEW_LINES);
      foreach ($bad_words as $bad_word) {
          if(strpos(strtolower($message_body), $bad_word)){
            $bad_message = true;
            $vulgar_word = $bad_word;
            echo $vulgar_word."<br>";
          }
      }
      if($bad_message){# if the message is bad warn the user.
          echo "you are using bad words in this group and you might get yourself removed.<BR>";
          echo $message_body;
          
          $sql = $conn->prepare("INSERT INTO junk_messages(sender_id, junk_words, message_body) VALUES(?, ?, ?)");
        $sql->bind_param("iss",$sender_id, $vulgar_word, $message_body);
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
          return false;      
      } else{ #if the message is fine add it to messages
          $sql = $conn->prepare("INSERT INTO messages(sender_id, message_body) VALUES(?, ?)");
          $sql->bind_param("is",$sender_id, $message_body);
          try{
            if ($sql->execute() === TRUE) {
              echo "message sent successifully<br>";
              createMessagesXML();
            }
          } catch(Exception $e){
            if ($e->getCode() == 1062) {
              echo "Error 123: " . $e->getMessage();
            } else {
              echo "An error occurred: " . $e->getMessage();
            }
          }
          
        }
  $conn->close();
  return true;
}
#function for the db admin to see the messages list
 function displayMessagesList(){
  // CONNECTING TO THE DATABASE
  echo "<style>html, body {background-color: gray;}</style>";
  #Check connection
  $servername = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "wechat_db";
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  #$sender_id = getSenderID()();
  $sql = ("SELECT * fROM messages JOIN users_data ON messages.sender_id = users_data.id;");
  $result = mysqli_query($conn, $sql);
//   // Check for errors
  if(!$result) {
    die("Error retrieving the data!!: " . $sql . "<br>" . mysqli_error($conn));
  }
//Output the table data
  if(mysqli_num_rows($result) > 0) {
//creating and styling a table to display the data
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
          <th>PHONE NUMBER</th>
          <th>USER NAME</th>
          <th>MESSAGE BODY</th>
          <th>SEND TIME</th>
          </tr>";
    while($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr><td>" . "M". $row["message_id"].
          "</td><td>" . $row["phone_number"].
          "</td><td>" . $row["user_name"].
          "</td><td>"  . $row["message_body"]. 
          "</td><td>" . $row["send_time"].
          "</td></tr>";
    }
echo "</table>";
} else {
echo "0 results";
}
$conn->close();
}
function displayJunkMessagesList(){
  // CONNECTING TO THE DATABASE
  echo "<style>html, body {background-color: gray;}</style>";
  #Check connection
  $servername = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "wechat_db";
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  #$sender_id = getSenderID()();
  $sql = ("SELECT * fROM junk_messages JOIN users_data ON junk_messages.sender_id = users_data.id;");
  $result = mysqli_query($conn, $sql);
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
              border-color: red; 
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
              border-color: red; 
              padding: 0.5em;
            }
            tbody tr:nth-child(even) {
              background-color: #f2f2f2;
              color: black;
            }
          </style>
          <table>
          <tr><th>MESSAGE ID</th>
          <th>SENDER PHONE</th>
          <th>USER NAME</th>
          <th>MESSAGE BODY</th>
          <th>SEND TIME</th>
          <th>JUNK WORDS</th>
          </tr>";
    while($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr><td>" . "M". $row["junk_id"].
          "</td><td>" . $row["phone_number"].
          "</td><td>" . $row["user_name"].
                    "</td><td>"  . $row["message_body"]. 
                    "</td><td>" . $row["send_time"].
                    "</td><td>" . $row["junk_words"].
               "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }
}

#READ THE MESSAGES DATA AND PUT IT INSIDE AN XML FILE
function createMessagesXML(){
  echo "created xml successifully";
   // Create a new XML document to store all the messages
   $dom = new DOMDocument('1.0', 'UTF-8');
   // Create the root element
   $root = $dom->createElement('messages');
   $dom->appendChild($root);
  $conn = new mysqli("localhost", "root", "", "wechat_db");
  $sql = "SELECT *
          FROM messages
          JOIN users_data ON messages.sender_id = users_data.id
          ORDER BY message_id ASC;";
  $result = mysqli_query($conn, $sql);
  if(!$result) {
    die("Error retrieving the data!!: " . $sql . "<br>" . mysqli_error($conn));
  }
  if(mysqli_num_rows($result) > 0) {
    
    // Iterate through the result set and add each row to the array as key-value pairs
    while($row = mysqli_fetch_assoc($result)) {
       // Create a message element
       $message = $dom->createElement('message');
       $root->appendChild($message);
        // Add message details
        $message_id = $dom->createElement('message_id', $row["message_id"]);
        $message->appendChild($message_id);
        $user_name = $dom->createElement('user_name', $row['user_name']);
        $message->appendChild($user_name);
        $phone_number = $dom->createElement('phone_number', $row['phone_number']);
        $message->appendChild($phone_number);
        $message_body = $dom->createElement('message_body', $row['message_body']);
        $message->appendChild($message_body);
        $send_time = $dom->createElement('send_time', $row['send_time']);
        $message->appendChild($send_time);
    }
  }
 // Set the content type to text/xml and save the XML document to a file
 #header('Content-type: text/xml');
 $dom->formatOutput = true;
 $dom->save('Server_Scripts\messages.xml');
 $conn->close();
}
?>