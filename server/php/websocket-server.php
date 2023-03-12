<?php
require_once 'vendor/autoload.php';
require_once 'group_messages.php';
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
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $params);
        $phone_number = $params['phone_number'];
    }
    public function onMessage(ConnectionInterface $from, $msg) {
        echo "message recieved: {$msg}\n";
        $data = json_decode($msg);
        $phoneNumber = $data->phone_number;
        $message = $data->message;
        $group_id = $data->group_id;
        //get the sender id from the database.
         $conn = new mysqli("localhost", "root", "", "wechat_db");
         $sql = $conn->prepare("SELECT * FROM users_data WHERE phone_number = ?");
         $sql->bind_param("s", $phoneNumber);
         $sql->execute();
         $result = $sql->get_result();         
         if(!$result){
            die("failed to connect to database". $sql . ", " . mysqli_error($conn));
         }
          $sender = $result->fetch_assoc();
          $sender_id = $sender["id"];
          $userName = $sender["user_name"];
          $data->user_name = $userName;
         #TODO: make the message has all its details by getting them from the database. parse it to the client as json format.                                   
    if(sendNewMessage($sender_id, $group_id, $message)){
        $data->good_message = true;
        $new_msg = json_encode($data);
        foreach ($this->clients as $client) {
            if ($client !== $from) {                                                              
                $client->send($new_msg);
            }
        }
    }else{#when the message contains vulgar words.
        //TODO: add a functionality to remove a user who misbehaves
        $data->good_message = false;
        foreach ($this->clients as $client) {
            if ($client !== $from) {      
                $data->message = "this message can't be displayed! It contains bad words;";
                $bad_msg = json_encode($data);                                                         
                $client->send($bad_msg);
            }else{
                $data->phone_number = "100";
                $data->user_name = "ADMIN";
                $data->message = "Warning! you are using bad language!";
                $warn_msg = json_encode($data);  
                $client->send($warn_msg);
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