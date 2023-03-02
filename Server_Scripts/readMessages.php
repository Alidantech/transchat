<?php
// Load the XML file
$xml = new DOMDocument();
$xml->load('messages.xml');

// Get the root element
$root = $xml->documentElement;

// Loop through the message elements
foreach ($root->getElementsByTagName('message') as $message) {
    // Get the message details
    $message_id = $message->getElementsByTagName('message_id')->item(0)->nodeValue;
    $user_name = $message->getElementsByTagName('user_name')->item(0)->nodeValue;
    $phone_number = $message->getElementsByTagName('phone_number')->item(0)->nodeValue;
    $message_body = $message->getElementsByTagName('message_body')->item(0)->nodeValue;
    $send_time = $message->getElementsByTagName('send_time')->item(0)->nodeValue;

    // Print the message details
    echo "message_id: $message_id <br>";
    echo "user_name: $user_name <br>";
    echo "phone_number: $phone_number <br>";
    echo "message_body: $message_body <br>";
    echo "send_time: $send_time <br><br>";
}
?>
