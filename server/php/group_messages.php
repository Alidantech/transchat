<?php 
#connect to the database

    $conn = new mysqli("localhost", "root", "", "wechat_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM group_messages JOIN users_data ON group_messages.sender_id = users_data.id";
    $result = $conn->query($sql);
    #$result = mysqli_query($conn, $sql);
       // Create an associative array to group messages by their group ID
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
        $xml->save('server/xml/groupmessages.xml');
        $conn->close();

        function addMessageToXML($group_id, $message_id, $user_name, $phone_number, $message_body, $sent_at) {
            // Load the XML document
            $xml = simplexml_load_file('server/xml/groupmessages.xml');
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
            $xml->asXML('group-messages.xml');
          }
?>