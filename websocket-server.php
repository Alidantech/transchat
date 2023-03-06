<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'Server_Scripts\messages.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ChatServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "connection establishe({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "message recieved: {$msg}\n";
         $recievedmsg = "{$msg}";
         $sender_id = "200";   
         #TODO: make the message has all its details by getting them from the database. parse it to the client as json format.                                   
         sendNewMessage($sender_id, $recievedmsg);
        foreach ($this->clients as $client) {
            if ($client !== $from) {                                                                
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "connection closed \n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
session_start();
function getSenderID(){
    $phone_number = $_SESSION["phone_number"];
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
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8080
);

echo "WebSocket server running on port 8080...\n";
$server->run();
?>