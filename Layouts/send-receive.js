const socket = new WebSocket('ws://localhost:8080');

socket.addEventListener('open', function (event) {
    console.log('WebSocket connection established.');
});

socket.addEventListener('message', function (event) {
    const message = event.data;//TODO: after making the data carry a json format parse it to javascript using json.parse().
    console.log('Received message:', message);
    // TODO: Update chat UI with received message, create div elements to show the new messages.
    
});
//get the message from the user in order to send it.
function submitMessage(){
    var messagebox = document.getElementById('message-body');
    var message = messagebox.value; //TODO: make sure a user does not send a blank message. and color the send button accordingly.
        sendMessage(message);
        messagebox.value = "";
}
function sendMessage(message) {
    socket.send(message);
    //TODO: make the user to see his message by creating a div containing the message. and the current time.
}

