document.addEventListener('DOMContentLoaded', function () {
    const cedulaId = obtenerIdCedula(); // Obtener el ID de la cédula desde la URL o algún otro método

    if (cedulaId) {
        cargarHistorialEstatus(cedulaId); // Cargar el historial de estatus
    } else {
        console.error('No se encontró el ID de la cédula.');
    }
});

function obtenerIdCedula() {
    // Obtener el ID de la cédula desde la URL (ejemplo: ?id_cedula=123)
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id_cedula');
}

function cargarHistorialEstatus(cedulaId) {
    fetch(`getHistorialEstatus.php?id_cedula=${cedulaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }

            if (data.historialEstatus && data.historialEstatus.length > 0) {
                llenarTabla(data.historialEstatus); // Llenar la tabla con los datos
            } else {
                mostrarMensajeSinDatos(); // Mostrar mensaje si no hay datos
            }
        })
        .catch(error => {
            console.error('Error al cargar el historial de estatus:', error);
        });
}

function llenarTabla(historial) {
    const tbody = document.querySelector('#dataTable tbody');
    tbody.innerHTML = ''; // Limpiar el contenido actual de la tabla

    historial.forEach(estatus => {
        const fila = document.createElement('tr');

        // Celda para el usuario (aquí puedes ajustar según tu lógica)
        const celdaUsuario = document.createElement('td');
        celdaUsuario.textContent = 'Usuario no disponible'; // Puedes obtener el usuario de otra tabla o API
        fila.appendChild(celdaUsuario);

        // Celda para la fecha de cambio de estatus
        const celdaFecha = document.createElement('td');
        celdaFecha.textContent = estatus.fecha_cambio;
        fila.appendChild(celdaFecha);

        // Celda para las observaciones
        const celdaComentario = document.createElement('td');
        celdaComentario.textContent = estatus.observaciones || 'Sin comentarios';
        fila.appendChild(celdaComentario);

        tbody.appendChild(fila); // Agregar la fila a la tabla
    });
}

function mostrarMensajeSinDatos() {
    const tbody = document.querySelector('#dataTable tbody');
    tbody.innerHTML = '<tr><td colspan="3" class="text-center">No se encontró historial de estatus.</td></tr>';
}