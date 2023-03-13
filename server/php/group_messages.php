<?php 
require_once "groups.php";
function createGroupMessagesXML(){
    $conn = new mysqli("localhost", "root", "", "wechat_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM group_messages 
            JOIN users_data ON group_messages.sender_id = users_data.id";
    $result = $conn->query($sql);
        $groups = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $group_id = $row["group_id"];
            if (!isset($groups[$group_id])) {
                $groups[$group_id] = array();
            }
            $groups[$group_id][] = $row;
        }
        // Create a new XML document
        $xml = new DomDocument("1.0", "UTF-8");
        // Create the root element
        $root = $xml->createElement("group-messages");
        $xml->appendChild($root);
        // Loop through the groups and add them to the XML document
        foreach ($groups as $group_id => $group_messages) {
            // Create the group element
            $group = $xml->createElement("group");
            $group->setAttribute("id", $group_id);
            $root->appendChild($group);
            // Loop through the messages in the group and add them to the XML document
            foreach ($group_messages as $message) {
                $message_element = $xml->createElement("message");
                $group->appendChild($message_element);
                $message_element->appendChild($xml->createElement("message_id", $message["message_id"]));
                $message_element->appendChild($xml->createElement("user_name", $message["user_name"]));
                $message_element->appendChild($xml->createElement("phone_number", $message["phone_number"]));
                $message_element->appendChild($xml->createElement("message_body", $message["message_body"]));
                $message_element->appendChild($xml->createElement("sent_at", $message["short_time"]));
            }
        }
        // Output the XML document
        $xml->formatOutput = true;
        $xml->save('server\xml\groupmessages.xml');
        $conn->close();
    }

function sendNewMessage($sender_id, $group_id, $message_body){
    $conn = new mysqli("localhost", "root", "", "wechat_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        #check if the message contains vulgar words.
        $bad_message = false;
        $vulgar_word = array(); 
        $bad_words = file('server\library\vulgar_words.txt', FILE_IGNORE_NEW_LINES);
        foreach ($bad_words as $bad_word) {
            if(strpos(strtolower($message_body), $bad_word)){
                $bad_message = true;
                $vulgar_word = $bad_word;
            }
        }
        if($bad_message){# if the message is bad warn the user.
            $sql = $conn->prepare("INSERT INTO junk_messages(sender_id, group_id, junk_words, message_body) VALUES(?, ?, ?, ?)");
            $sql->bind_param("iiss", $sender_id, $group_id, $vulgar_word, $message_body);
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
            $sql = $conn->prepare("INSERT INTO group_messages(sender_id, group_id, message_body) VALUES(?, ?, ?)");
            $sql->bind_param("iis",$sender_id, $group_id, $message_body);
            try{
                if ($sql->execute() === TRUE) {
                    echo "message sent successifully.";
                    createGroupMessagesXML();
                    $sql = "SELECT * FROM group_messages 
                            JOIN users_data ON group_messages.sender_id = users_data.id
                            WHERE sender_id = $sender_id AND group_id = $group_id
                            ORDER BY sent_at
                            LIMIT 1";
                    $result = $conn->query($sql);
                    if($row = mysqli_fetch_assoc($result)){
                        $group_id = $row["group_id"];
                        $message_id = $row["message_id"];
                        $user_name = $row["user_name"];
                        $phone_number = $row["phone_number"];
                        $message_body = $row["message_body"];
                        $sent_at = $row["short_time"];
                        updateMessagesXML($group_id, $message_id, $user_name, $phone_number, $message_body, $sent_at);
                        createGroupsListXML();
                    }
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
function updateMessagesXML($group_id, $message_id, $user_name, $phone_number, $message_body, $sent_at) {
    // Load the XML document
    $xml = simplexml_load_file('server\xml\groupmessages.xml');
    // Find the group element with the specified id
    $group = $xml->xpath("//group[@id='$group_id']")[0];
    // Create a new message element
    $newMessage = $group->addChild('message');
    $newMessage->addChild('message_id', $message_id);
    $newMessage->addChild('user_name', $user_name);
    $newMessage->addChild('phone_number', $phone_number);
    $newMessage->addChild('message_body', $message_body);
    $newMessage->addChild('sent_at', $sent_at);
    // Save the updated XML document
$xml->asXML('groupmessages.xml');
}
?>