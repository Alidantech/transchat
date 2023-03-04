<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MyWebSocketServer implements MessageComponentInterface {
  protected $clients;

  public function __construct() {
    $this->clients = new \SplObjectStorage;
  }

  public function onOpen(ConnectionInterface $conn) {
    $this->clients->attach($conn);
    echo 'WebSocket connection established.' . PHP_EOL;
  }

  public function onMessage(ConnectionInterface $from, $msg) {
    foreach ($this->clients as $client) {
      if ($client !== $from) {
        $client->send($msg);
      }
    }
  }

  public function onClose(ConnectionInterface $conn) {
    $this->clients->detach($conn);
    echo 'WebSocket connection closed.' . PHP_EOL;
  }

  public function onError(ConnectionInterface $conn, \Exception $e) {
    echo 'WebSocket error: ' . $e->getMessage() . PHP_EOL;
  }
}

$server = new \Ratchet\App('example.com', 8080);
$server->route('/', new MyWebSocketServer);
$server->run();
?>