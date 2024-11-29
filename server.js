// Load required modules
const http = require("http");
const WebSocket = require("ws");

// Create an HTTP server
const server = http.createServer((req, res) => {
	res.writeHead(200, { "Content-Type": "text/plain" });
	res.end("WebSocket server is running");
});

// Create a WebSocket server using the HTTP server
const wss = new WebSocket.Server({ server });

// Handle WebSocket connections
wss.on("connection", (ws) => {
	console.log("A new client connected");

	// When the server receives a message from the client
	ws.on("message", (message) => {
		console.log("received: %s", message);
	});

	// Send a message to the client
	ws.send("Welcome to the WebSocket server!");
});

// Handle server errors
wss.on("error", (error) => {
	console.error("WebSocket server error:", error);
});

// Listen on port 8080
server.listen(8080, () => {
	console.log("WebSocket server is running on ws://localhost:8080");
});
