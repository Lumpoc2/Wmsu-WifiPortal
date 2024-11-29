const WebSocket = require('ws');

// Create a WebSocket server listening on port 8080
const wss = new WebSocket.Server({ port: 8082 });

// Handle incoming connections
wss.on('connection', (ws) => {
    console.log('Client connected');
    
    // Handle incoming messages from the client
    ws.on('message', (message) => {
        console.log(`Received: ${message}`);
        ws.send('Message received!');
    });

    // Send a welcome message when a new connection is established
    ws.send('Welcome to the WebSocket server!');
});

console.log('WebSocket server running on ws://localhost:8080');

