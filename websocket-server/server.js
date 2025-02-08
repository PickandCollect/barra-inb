const express = require("express");
const http = require("http");
const https = require("https");
const socketIo = require("socket.io");
const fs = require("fs");

// Ruta a tu certificado SSL y clave privada
const privateKey = fs.readFileSync("path/to/your/private-key.pem", "utf8");
const certificate = fs.readFileSync("path/to/your/certificate.pem", "utf8");
const ca = fs.readFileSync("path/to/your/ca.pem", "utf8");

const credentials = { key: privateKey, cert: certificate, ca: ca };

const app = express();

// Crear servidor HTTPS
const server = https.createServer(credentials, app);

// Crear servidor de WebSocket
const io = socketIo(server, {
  cors: {
    origin: "https://bestcontact.mx", // Asegúrate de usar https aquí
    methods: ["GET", "POST"],
  },
});

// Configurar los eventos de socket
io.on("connection", (socket) => {
  console.log("Un usuario se ha conectado");

  socket.on("mensaje", (data) => {
    console.log("Mensaje recibido:", data);
    io.emit("mensaje", data);
  });

  socket.on("disconnect", () => {
    console.log("Un usuario se ha desconectado");
  });
});

// Iniciar el servidor HTTPS en el puerto 3000
server.listen(22, () => {
  console.log("Servidor HTTPS corriendo en https://tu-dominio.com:3000");
});
