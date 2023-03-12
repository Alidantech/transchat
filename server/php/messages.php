<?php
function sendNewMessage($sender_id, $message_body){
  $conn = new mysqli("localhost", "root", "", "wechat_db");
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      #check if the message contains vulgar words.
      $bad_message = false;
      $vulgar_word = array(); 
      $bad_words = file('library/vulgar_words.txt', FILE_IGNORE_NEW_LINES);
      foreach ($bad_words as $bad_word) {
          if(strpos(strtolower($message_body), $bad_word)){
            $bad_message = true;
            $vulgar_word = $bad_word;
          }
      }
      if($bad_message){# if the message is bad warn the user.
        $sql = $conn->prepare("INSERT INTO junk_messages(sender_id, junk_words, message_body) VALUES(?, ?, ?)");
        $sql->bind_param("iss",$sender_id, $vulgar_word, $message_body);
          try{
            if ($sql->execute() === TRUE) {
              echo "message sent successifully.";
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
function updateMessagesXML(){
}
?>