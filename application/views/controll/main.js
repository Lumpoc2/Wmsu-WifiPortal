const ws = new WebSocket(
	"ws://localhost:8080/Wmsu-WifiPortal/controll/block/ws"
);

// WebSocket events
ws.onopen = () => console.log("Connected to WebSocket!");
ws.onerror = (e) => console.error("WebSocket Error:", e);
ws.onmessage = (msg) => console.log("Received message:", msg.data);

// Optionally handle connection close
ws.onclose = () => console.log("WebSocket connection closed.");
