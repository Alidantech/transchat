<?php 
#READ THE MESSAGES DATA AND PUT IT INSIDE AN XML FILE   
function createGroupsListXML(){
    echo "created xml successifully";
     // Create a new XML document to store all the messages
     $dom = new DOMDocument('1.0', 'UTF-8');
     // Create the root element
     $root = $dom->createElement('GROUPS');
     $dom->appendChild($root);
     //GET DATA FROM THE DATABASE
     $conn = new mysqli("localhost", "root", "", "wechat_db");
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     $sql = "SELECT groups_data.group_id, group_name, message_body, short_time, user_name 
              FROM groups_data 
              JOIN group_messages 
              ON groups_data.group_id = group_messages.group_id
              JOIN users_data 
              ON group_messages.sender_id = users_data.id
              GROUP BY groups_data.group_id
              ORDER BY group_messages.sent_at DESC";
    $result = mysqli_query($conn, $sql);
    if(!$result) {
      die("Error retrieving the data!!: " . $sql . "<br>" . mysqli_error($conn));
    }
    if(mysqli_num_rows($result) > 0) {
      // Iterate through the result set and add each row to the array as key-value pairs
      while($row = mysqli_fetch_assoc($result)) {
         // Create a group element
         $group = $dom->createElement('group');
         $root->appendChild($group);
          // Add group details
          $group_id = $dom->createElement('group_id', $row["group_id"]);
          $group->appendChild($group_id);
          $group_name = $dom->createElement('group_name', $row['group_name']);
          $group->appendChild($group_name);
          $user_name = $dom->createElement('sender_name', $row['user_name']);
          $group->appendChild($user_name);
          $message_body = $dom->createElement('message_body', $row['message_body']);
          $group->appendChild($message_body);
          $send_time = $dom->createElement('send_at', $row['short_time']);
          $group->appendChild($send_time);
      }
    }
   // Set the content type to text/xml and save the XML document to a file
   #header('Content-type: text/xml');
   $dom->formatOutput = true;
   $dom->save('server\xml\groups.xml');
   $conn->close();
  }
  
?>