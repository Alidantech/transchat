//create a web socket and refference to the desired server-socket.
var socket = new WebSocket('ws://example.com:8080');

socket.onopen = function() {
  console.log('WebSocket connection established.');
};

socket.onmessage = function(event) {
  console.log('Received message: ' + event.data);
};

socket.onerror = function(error) {
  console.log('WebSocket error: ' + error);
};

socket.onclose = function(event) {
  console.log('WebSocket connection closed with code ' + event.code + ', reason: ' + event.reason);
};
