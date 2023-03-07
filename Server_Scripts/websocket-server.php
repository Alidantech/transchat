<?php
require_once 'vendor/autoload.php';
require_once 'messages.php';
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
        echo "connection established ({$conn->resourceId})\n";
    }
    public function onMessage(ConnectionInterface $from, $msg) {
        echo "message recieved: {$msg}\n";
        $data = json_decode($msg);
        $phoneNumber = $data->phone_number;
        $message = $data->message;
        //get the sender id from the database.
         $conn = new mysqli("localhost", "root", "", "wechat_db");
         $sql = $conn->prepare("SELECT * FROM users_data WHERE phone_number = ?");
         $sql->bind_param("s", $phoneNumber);
         $sql->execute();
         $result = $sql->get_result();         
         if(!$result){
            die("failed to connect to database". $sql . "<br>" . mysqli_error($conn));
         }
          $sender = $result->fetch_assoc();
          $sender_id = $sender["id"];
          $userName = $sender["user_name"];
          $data->user_name = $userName;
          $new_msg = json_encode($data);
        
         #TODO: make the message has all its details by getting them from the database. parse it to the client as json format.                                   
    if(sendNewMessage($sender_id, $message)){
        foreach ($this->clients as $client) {
            if ($client !== $from) {                                                                
                $client->send($new_msg);
            }
        }
    }else{#when the message contains vulgar words.
        //TODO: add a functionality to remove a user who misbehaves
        foreach ($this->clients as $client) {
            if ($client !== $from) {                                                                
                $client->send("<style>#bad{
                    color:red;
                    background: rgba(29, 39, 29, 0.74);
                }</style><p id=\"bad\">message contains bad words!!</p>");
            }else{
                $client->send("<style>#bad{
                    color:red;
                    background: black;
                }</style><p id=\"bad\">you are using a bad language!!</p>");
            }
        }    
    }
    }
    //when someone disconects from the web socket.
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "connection closed \n";
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
//creating the server socket
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