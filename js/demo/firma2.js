// Obtener el elemento canvas y el contexto de dibujo
const canvas = document.getElementById("firmaCanvas2");
const ctx = canvas.getContext("2d");

// Variables para el dibujo
let dibujando = false;
let ultimaPos = { x: 0, y: 0 };

// Función para comenzar a dibujar
function comenzarDibujo(e) {
  dibujando = true;
  ultimaPos = obtenerPosicion(e);
}

// Función para dibujar en el canvas
function dibujar(e) {
  if (!dibujando) return;

  const pos = obtenerPosicion(e);
  ctx.beginPath();
  ctx.moveTo(ultimaPos.x, ultimaPos.y);
  ctx.lineTo(pos.x, pos.y);
  ctx.strokeStyle = "black";
  ctx.lineWidth = 2;
  ctx.lineCap = "round";
  ctx.stroke();
  ultimaPos = pos;
}

// Función para obtener la posición del mouse sobre el canvas
function obtenerPosicion(e) {
  const rect = canvas.getBoundingClientRect();
  return {
    x: e.clientX - rect.left,
    y: e.clientY - rect.top,
  };
}

// Función para finalizar el dibujo
function finalizarDibujo() {
  dibujando = false;
}

// Limpiar el canvas
document.getElementById("limpiar").addEventListener("click", () => {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
});

// Agregar los eventos de mouse
canvas.addEventListener("mousedown", comenzarDibujo);
canvas.addEventListener("mousemove", dibujar);
canvas.addEventListener("mouseup", finalizarDibujo);
canvas.addEventListener("mouseout", finalizarDibujo);
