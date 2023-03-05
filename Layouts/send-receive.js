const socket = new WebSocket('ws://localhost:8080');

socket.addEventListener('open', function (event) {
    console.log('WebSocket connection established.');
});

socket.addEventListener('message', function (event) {
    const message = event.data;
    console.log('Received message:', message);
    // TODO: Update chat UI with received message
     
});

function sendMessage(message) {
    socket.send(message);
}

//send a message
const sendButton = document.getElementById('send-button');
sendButton.addEventListener('click', function () {
    const messageInput = document.getElementById('message-body');
    const message = messageInput.value;
    sendMessage(message);
    console.log(message);
    messageInput.value = ''; // Clear input field
});
