// Función para manejar los eventos de firma en un canvas
function configurarFirmaCanvas(canvasId, limpiarBtnId) {
  const canvas = document.getElementById(canvasId);
  const ctx = canvas.getContext("2d");

  // Variables para el dibujo
  let dibujando = false;
  let ultimaPos = { x: 0, y: 0 };

  // Función para comenzar a dibujar
  function comenzarDibujo(e) {
    dibujando = true;
    ultimaPos = obtenerPosicion(e, canvas);
  }

  // Función para dibujar en el canvas
  function dibujar(e) {
    if (!dibujando) return;

    const pos = obtenerPosicion(e, canvas);
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
  function obtenerPosicion(e, canvas) {
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

  // Limpiar el canvas cuando se haga clic en el botón de limpiar
  const limpiarButton = document.getElementById(limpiarBtnId);
  limpiarButton.addEventListener("click", () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
  });

  // Agregar los eventos de mouse al canvas
  canvas.addEventListener("mousedown", comenzarDibujo);
  canvas.addEventListener("mousemove", dibujar);
  canvas.addEventListener("mouseup", finalizarDibujo);
  canvas.addEventListener("mouseout", finalizarDibujo);
}

// Configurar los dos campos de firma
configurarFirmaCanvas("firmaCanvas", "limpiarCanvas1");
configurarFirmaCanvas("firmaCanvas2", "limpiarCanvas2");
