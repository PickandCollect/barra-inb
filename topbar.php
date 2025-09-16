<?php
// Verifica si la sesión ya está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión si no está activa
}

// Redirigir al login si no hay rol en la sesión
if (!isset($_SESSION['rol'])) {
    echo 'No se encontró un rol en la sesión. Redirigiendo al login...';
    header('Location: login.php');
    exit();
}

// Recuperar el rol de la sesión
$rol = $_SESSION['rol'];
$nombre = $_SESSION['nombre_usuario']; // Asegúrate de definir el nombre de usuario en la sesión
?>


<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Topbar</title>

<head>
    <!-- CSS -->
    <link rel="stylesheet" href="css/topbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>

<body>
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow style=" padding: 0.5rem 1rem; background-color:rgb(255, 255, 255) !important; border-bottom: 2px solid #e0e0e0;"">
        <!-- Sidebar Toggle (Topbar) -->
        <form class="form-inline">
            <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3" style="background-color: #6c757d; color: white; border: none; padding: 0.75rem; transition: background-color 0.3s ease;">
                <i class="fa fa-bars"></i>
            </button>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #6c757d; font-weight: 500; padding: 0.5rem;">
                    <i class="fas fa-bell fa-fw" style="font-size: 1.2rem;"></i>
                    <span class="badge badge-danger badge-counter" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; background-color: #dc3545;"></span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="min-width: 300px; border: none;">
                    <h6 class="dropdown-header" style="font-size: 0.9rem; font-weight: 600; color: #495057; background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Centro de Alertas</h6>
                    <!-- Alerts content will be injected here -->
                </div>
            </li>

            <!-- Nav Item - Messages 
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">Centro de Mensajes</h6>
                </div>
            </li>-->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #6c757d; font-weight: 500; padding: 0.5rem;">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size: 0.9rem; color: #6c757d;">
                        <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                    <?php
                    // Nombre exacto que se muestra en el top bar
                    $nombreMostrado = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
                    $directorioImagenes = 'img/img_user/';

                    // Función para buscar archivos que contengan el nombre (sin importar mayúsculas/minúsculas)
                    function buscarImagenUsuario($directorio, $nombreBuscado)
                    {
                        $archivos = scandir($directorio);
                        $nombreBuscado = strtolower($nombreBuscado);
                        $resultados = [];

                        foreach ($archivos as $archivo) {
                            if ($archivo !== '.' && $archivo !== '..') {
                                if (stripos($archivo, $nombreBuscado) !== false) {
                                    $resultados[] = $archivo;
                                }
                            }
                        }

                        return $resultados;
                    }

                    // Buscar imágenes que contengan el nombre
                    $imagenesEncontradas = buscarImagenUsuario($directorioImagenes, $nombreMostrado);
                    $imagenSrc = 'img/undraw_profile.svg'; // Valor por defecto

                    // Debug: Ver información de búsqueda (puedes comentar esto después de probar)
                    $debugInfo = [
                        'nombre_buscado' => $nombreMostrado,
                        'imagenes_encontradas' => $imagenesEncontradas,
                        'directorio' => $directorioImagenes,
                        'error' => null
                    ];

                    if (!empty($imagenesEncontradas)) {
                        // Tomar la primera imagen encontrada
                        $imagenSrc = $directorioImagenes . $imagenesEncontradas[0];

                        // Verificar si realmente existe el archivo
                        if (!file_exists($imagenSrc)) {
                            $debugInfo['error'] = 'La imagen encontrada no existe físicamente';
                            $imagenSrc = 'img/undraw_profile.svg';
                        }
                    } else {
                        $debugInfo['error'] = 'No se encontraron imágenes que coincidan con el nombre';
                    }

                    // Mostrar información de debug (solo en entorno de desarrollo)
                    if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') {
                        echo '<!-- DEBUG INFO: ' . print_r($debugInfo, true) . ' -->';
                    }
                    ?>
                    <img class="img-profile rounded-circle" src="<?php echo $imagenSrc; ?>"
                        alt="Foto de perfil de <?php echo $nombreMostrado; ?>"
                        style="width: 40px; height: 40px; border: 2px solid #6c757d;"
                        onerror="this.src='img/undraw_profile.svg'; console.error('Error al cargar la imagen de perfil: <?php echo $imagenSrc; ?>')">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" style="min-width: 200px; border: none;" style="border-top: 1px solid #e0e0e0;">
                    <div class="dropdown-divider" href="logout.php" style="font-size: 0.9rem; color: #6c757d; padding: 0.5rem 1rem;"></div>
                    <a class="dropdown-item" href="logout.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>



    <!-- Toast Notification Container -->
    <div id="toastContainer" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; "></div>

    <!-- Modal cedula parciales-->
    <div class="modal" id="cedulaModalA" role="dialog" aria-labelledby="cedulaModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="custom-modal" role="document">
            <div class="custom-modal-content">
                <div class="custom-modal-header">
                    <h5 id="cedulaModalLabel">Cedula Parciales</h5>


                    <button type="button" id="btnguardarM" class="close" style="margin-left: 770px;">
                        <span aria-hidden="true">Guardar</span>
                    </button>

                    <!--BTN SALIR M, que no se muestra pero la funcion la utiliza el js de pdf-->
                    <button type="button" id="btnsalirM" class="close" data-dismiss="modal" aria-label="Close" hidden>
                        <span aria-hidden="true"></span>
                    </button>

                </div>
                <div class="custom-modal-body" id="cedulaModalContent">
                    <!-- Contenido del modal -->

                </div>

            </div>
        </div>
    </div>

    <!-- Modal cedula BBVA-->
    <div class="modal" id="cedulaModalBBVA" role="dialog" aria-labelledby="cedulaModalLabelBBVA" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="custom-modal" role="document">
            <div class="custom-modal-content-BBVA">
                <div class="custom-modal-header">
                    <h5 id="cedulaModalLabel">Cedula BBVA</h5>


                    <button type="button" id="btnguardarMBBVA" class="close" style="margin-left: 770px;">
                        <span aria-hidden="true">Guardar</span>
                    </button>

                    <!--BTN SALIR M, que no se muestra pero la funcion la utiliza el js de pdf-->
                    <button type="button" id="btnsalirMBBVA" class="close" data-dismiss="modal" aria-label="Close" hidden>
                        <span aria-hidden="true"></span>
                    </button>

                </div>
                <div class="custom-modal-body" id="cedulaModalContentBBVA">
                    <!-- Contenido del modal -->

                </div>

            </div>
        </div>
    </div>

    <!-- Modal cedula HDI-->
    <div class="modal" id="cedulaModalHDI" role="dialog" aria-labelledby="cedulaModalLabelHDI" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="custom-modal" role="document">
            <div class="custom-modal-content-HDI">
                <div class="custom-modal-header">
                    <h5 id="cedulaModalLabel">Cedula HDI</h5>


                    <button type="button" id="btnguardarMHDI" class="close" style="margin-left: 770px;">
                        <span aria-hidden="true">Guardar</span>
                    </button>

                    <!--BTN SALIR M, que no se muestra pero la funcion la utiliza el js de pdf-->
                    <button type="button" id="btnsalirMHDI" class="close" data-dismiss="modal" aria-label="Close" hidden>
                        <span aria-hidden="true"></span>
                    </button>

                </div>
                <div class="custom-modal-body" id="cedulaModalContentHDI">
                    <!-- Contenido del modal -->

                </div>

            </div>
        </div>
    </div>

    <!-- Modal cedula RH-->
    <div class="modal" id="cedulaModalRH" role="dialog" aria-labelledby="cedulaModalLabelRH" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="custom-modal" role="document">
            <div class="custom-modal-content-BBVA">
                <div class="custom-modal-header">
                    <h5 id="cedulaModalLabel">Cedula RH</h5>


                    <button type="button" id="btnguardarRH" class="close" style="margin-left: 770px;">
                        <span aria-hidden="true">Guardar</span>
                    </button>

                    <!--BTN SALIR M, que no se muestra pero la funcion la utiliza el js de pdf-->
                    <button type="button" id="btnsalirRH" class="close" data-dismiss="modal" aria-label="Close" hidden>
                        <span aria-hidden="true"></span>
                    </button>

                </div>
                <div class="custom-modal-body" id="cedulaModalContentRH">
                    <!-- Contenido del modal -->

                </div>

            </div>
        </div>
    </div>

    <!-- Incluye SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script que genera el PDF DEL MODAL CEDULA_CALIDAD2.PHP -->
    <script>
        document.getElementById('btnguardarM')?.addEventListener('click', async function() {
            // Validar la firma en el canvas
            const canvas = document.getElementById('firmaAsesorCanvas');
            const ctx = canvas.getContext('2d');
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            let isCanvasEmpty = true;

            for (let i = 0; i < imageData.length; i += 4) {
                if (imageData[i + 3] !== 0) { // Si el pixel no es transparente
                    isCanvasEmpty = false;
                    break;
                }
            }

            if (isCanvasEmpty) {
                // Mostrar alerta de SweetAlert2 para la firma
                Swal.fire({
                    icon: 'warning',
                    title: 'Firma requerida 😅',
                    confirmButtonText: 'Entendido',
                });
                return; // Detener la ejecución si el canvas está vacío
            }

            // Validar el contenido del div (compromiso)
            const compromisoDiv = document.getElementById('compromiso_cedula');
            const evaluacionDiv = document.getElementById('compromiso_cedula');

            if (compromisoDiv.innerText.trim() === '') {
                // Mostrar alerta de SweetAlert2 para el compromiso
                Swal.fire({
                    icon: 'warning',
                    title: 'Compromiso requerido 😅',
                    confirmButtonText: 'Entendido',
                });
                return; // Detener la ejecución si el compromiso está vacío
            }

            const modal = document.querySelector('.custom-modal-content');
            const buttons = modal.querySelectorAll('button');

            // Oculta los botones
            hideElements(buttons);

            // Mostrar alerta de carga
            Swal.fire({
                title: 'Generando PDF...',
                allowOutsideClick: false,
                allowEscapeKey: false, // Evita que se cierre con la tecla Esc
                didOpen: () => {
                    Swal.showLoading();
                }
            });


            try {
                // Espera a que los elementos dinámicos se carguen
                await waitForDynamicContent(modal);

                // Convierte las imágenes a Base64
                await convertImagesToBase64(modal);

                // Captura el modal y genera el PDF
                const pdfBlob = await captureModalWithStyles(modal, -100, -70, 1200, 2400);

                // Enviar el PDF al servidor
                const operador = modal.querySelector('#nombre_c').value;
                const campana = modal.querySelector('#campana_c').value;

                const formData = new FormData();
                formData.append('operador', operador);
                formData.append('campana', campana);
                formData.append('archivo', pdfBlob, 'cedula_parciales.pdf');

                const response = await fetch('proc/insertPDF.php', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.success) {
                    // Cerrar la alerta de carga
                    Swal.close();

                    // Mostrar alerta de éxito y cerrarla automáticamente
                    Swal.fire({
                        icon: 'success',
                        title: '¡ El PDF  <i class="fas fa-file-pdf" style="color:red;" ></i> se ha guardado correctamente. !',
                        timer: 4500, // Duración de la alerta en milisegundos (2 segundos)
                        showConfirmButton: false, // No mostrar botón de confirmación
                    }).then(() => {
                        // Cerrar el modal después de que la alerta se cierre
                        document.getElementById('btnsalirM')?.click();
                        // Recargar la página completamente (desde el servidor)
                        location.reload(true);
                    });
                } else {
                    throw new Error(result.error || 'Error al subir el PDF a S3');
                }
            } catch (error) {
                console.error('Error:', error);
                // Cerrar la alerta de carga en caso de error
                Swal.close();
                showErrorAlert();
            } finally {
                // Restaura el estado original
                showElements(buttons);
                restoreModalStyles(modal);
            }
        });

        // Función para esperar a que los elementos dinámicos se carguen
        function waitForDynamicContent(container) {
            return new Promise((resolve) => {
                const observer = new MutationObserver((mutationsList, observer) => {
                    resolve();
                    observer.disconnect();
                });
                observer.observe(container, {
                    childList: true,
                    subtree: true
                });
                setTimeout(resolve, 500); // Timeout de seguridad
            });
        }

        // Función para ocultar elementos
        function hideElements(elements) {
            elements.forEach(element => (element.style.display = 'none'));
        }

        // Función para mostrar elementos
        function showElements(elements) {
            elements.forEach(element => (element.style.display = ''));
        }

        // Función para convertir imágenes a Base64
        function convertImagesToBase64(container) {
            const images = container.querySelectorAll('img');
            return Promise.all(
                Array.from(images).map(img => {
                    return new Promise((resolve) => {
                        if (img.complete && img.naturalHeight !== 0) {
                            convertToBase64(img);
                            resolve();
                        } else {
                            img.addEventListener('load', () => {
                                convertToBase64(img);
                                resolve();
                            });
                            img.addEventListener('error', () => {
                                console.error("Error cargando la imagen:", img.src);
                                resolve();
                            });
                        }
                    });
                })
            );
        }

        // Función para convertir una imagen a Base64
        function convertToBase64(img) {
            if (img.src && !img.src.startsWith('data:image')) {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.naturalWidth;
                canvas.height = img.naturalHeight;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                img.src = canvas.toDataURL('image/png');
            }
        }

        // Función para capturar el modal y generar el PDF
        async function captureModalWithStyles(modal, x, y, width, height) {
            const originalOverflow = modal.style.overflow;
            modal.style.overflow = 'visible';
            modal.style.width = `${modal.scrollWidth}px`;

            const canvas = await html2canvas(modal, {
                scale: window.devicePixelRatio * 2,
                logging: true,
                useCORS: true,
                allowTaint: true,
                backgroundColor: null,
                foreignObjectRendering: true,
                imageTimeout: 5000, // Aumenta el timeout para imágenes
                width,
                height,
                windowWidth: modal.scrollWidth,
                windowHeight: modal.scrollHeight,
                scrollX: x,
                scrollY: y,
            });

            const imgData = canvas.toDataURL('image/png', 1.0);
            const pdf = new jspdf.jsPDF({
                orientation: 'portrait',
                unit: 'px',
                format: [width, height]
            });
            pdf.addImage(imgData, 'PNG', 0, 0, width, height);

            // Convertir el PDF a Blob
            const pdfBlob = pdf.output('blob');
            return pdfBlob;
        }

        // Función para mostrar una alerta de error
        function showErrorAlert() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al generar o subir el PDF. Por favor, inténtalo de nuevo.',
                confirmButtonText: 'Salir',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnsalirM')?.click();
                }
            });
        }

        // Función para restaurar los estilos del modal
        function restoreModalStyles(modal) {
            modal.style.overflow = '';
            modal.style.width = '';
        }
    </script>

    <!-- Script que genera el PDF DEL MODAL CEDULA_BBVA.PHP -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btnguardarMBBVA')?.addEventListener('click', async function() {
                // Validar el contenido del div (compromiso)
                const compromisoDiv = document.getElementById('compromiso_cedula');
                const checkbox = document.getElementById('compromisoCheck');

                if (!compromisoDiv || compromisoDiv.innerText.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Compromiso requerido 😅',
                        confirmButtonText: 'Entendido',
                    });
                    return;
                }

                if (!checkbox?.checked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Compromiso requerido 😅',
                        text: 'Debes aceptar de enterado/a antes de guardar.',
                        confirmButtonText: 'Entendido',
                    });
                    return;
                }

                const modal = document.querySelector('.custom-modal-content-BBVA');
                if (!modal) {
                    console.error('No se encontró el modal');
                    showErrorAlert('No se pudo encontrar el contenido del modal');
                    return;
                }

                const buttons = modal.querySelectorAll('button');

                // Oculta los botones
                hideElements(buttons);

                // Mostrar alerta de carga
                const loadingAlert = Swal.fire({
                    title: 'Generando PDF...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    // Espera a que los elementos dinámicos se carguen
                    await waitForDynamicContent(modal);

                    // Convierte las imágenes a Base64
                    await convertImagesToBase64(modal);

                    // Captura el modal y genera el PDF
                    const pdfBlob = await captureModalWithStyles(modal, -100, -70, 1300, 2800);

                    // Enviar el PDF al servidor con control de errores
                    let operador = '';
                    const nombreElemento = document.getElementById('nombre_cb');

                    if (!nombreElemento) {
                        throw new Error('Elemento con id "nombre_cb" no encontrado en el DOM');
                    }

                    // Detectar si es un input o un span/div
                    if (nombreElemento.tagName === 'INPUT' || nombreElemento.tagName === 'TEXTAREA') {
                        operador = nombreElemento.value.trim();
                    } else {
                        operador = nombreElemento.textContent.trim();
                    }

                    if (!operador) {
                        throw new Error('El campo del operador está vacío');
                    }

                    const formData = new FormData();
                    formData.append('operador', operador);
                    formData.append('archivo', pdfBlob, 'cedula_BBVA.pdf');

                    const response = await fetch('proc/insertPDF_BBVA.php', {
                        method: 'POST',
                        body: formData,
                    });

                    // Verificar si la respuesta es JSON válido
                    const responseText = await response.text();
                    let result;

                    try {
                        result = JSON.parse(responseText);
                    } catch (e) {
                        console.error('Respuesta del servidor no es JSON válido:', responseText);
                        throw new Error(`El servidor respondió con un formato inválido: ${responseText.substring(0, 100)}...`);
                    }

                    if (!response.ok || !result.success) {
                        throw new Error(result.error || `Error al subir el PDF (${response.status})`);
                    }

                    // Cerrar la alerta de carga
                    await loadingAlert.close();

                    // Mostrar alerta de éxito
                    await Swal.fire({
                        icon: 'success',
                        title: '¡El PDF <i class="fas fa-file-pdf" style="color:red;"></i> se ha guardado correctamente!',
                        timer: 4500,
                        showConfirmButton: false,
                    });

                    // Cerrar el modal y recargar
                    document.getElementById('btnsalirMBBVA')?.click();
                    location.reload(true);

                } catch (error) {
                    console.error('Error:', error);
                    await loadingAlert.close();
                    showErrorAlert(error.message || 'Error desconocido al procesar el PDF');
                } finally {
                    // Restaura el estado original
                    showElements(buttons);
                    restoreModalStyles(modal);
                }
            });
        });

        // [Resto de las funciones auxiliares permanecen igual...]

        // Función para esperar a que los elementos dinámicos se carguen
        function waitForDynamicContent(container) {
            return new Promise((resolve) => {
                // Verificar si ya hay contenido
                if (container.querySelectorAll('*').length > 0) {
                    return resolve();
                }

                const observer = new MutationObserver((mutationsList, observer) => {
                    if (container.querySelectorAll('*').length > 0) {
                        resolve();
                        observer.disconnect();
                    }
                });

                observer.observe(container, {
                    childList: true,
                    subtree: true
                });

                // Timeout de seguridad
                setTimeout(() => {
                    observer.disconnect();
                    resolve();
                }, 2000);
            });
        }

        // Función para ocultar elementos
        function hideElements(elements) {
            elements.forEach(element => {
                if (element) element.style.display = 'none';
            });
        }

        // Función para mostrar elementos
        function showElements(elements) {
            elements.forEach(element => {
                if (element) element.style.display = '';
            });
        }

        // Función para convertir imágenes a Base64
        async function convertImagesToBase64(container) {
            const images = container.querySelectorAll('img');
            if (!images.length) return;

            const conversionPromises = Array.from(images).map(img => {
                return new Promise((resolve) => {
                    if (!img.src) return resolve();

                    // Si ya es base64, no hacer nada
                    if (img.src.startsWith('data:image')) return resolve();

                    if (img.complete && img.naturalHeight !== 0) {
                        convertToBase64(img);
                        resolve();
                    } else {
                        const onLoad = () => {
                            convertToBase64(img);
                            img.removeEventListener('load', onLoad);
                            resolve();
                        };

                        const onError = () => {
                            console.warn("Error cargando la imagen:", img.src);
                            img.removeEventListener('error', onError);
                            resolve();
                        };

                        img.addEventListener('load', onLoad);
                        img.addEventListener('error', onError);
                    }
                });
            });

            await Promise.all(conversionPromises);
        }

        // Función para convertir una imagen a Base64
        function convertToBase64(img) {
            try {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.naturalWidth || img.width;
                canvas.height = img.naturalHeight || img.height;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                img.src = canvas.toDataURL('image/png');
            } catch (error) {
                console.error('Error convirtiendo imagen a Base64:', error);
            }
        }

        // Función para capturar el modal y generar el PDF
        async function captureModalWithStyles(modal, x, y, width, height) {
            if (!modal) throw new Error('Elemento modal no encontrado');

            const originalOverflow = modal.style.overflow;
            const originalWidth = modal.style.width;

            modal.style.overflow = 'visible';
            modal.style.width = `${modal.scrollWidth}px`;

            try {
                const canvas = await html2canvas(modal, {
                    scale: window.devicePixelRatio * 2,
                    logging: true,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: null,
                    foreignObjectRendering: true,
                    imageTimeout: 15000, // Aumentamos el timeout
                    width,
                    height,
                    windowWidth: modal.scrollWidth,
                    windowHeight: modal.scrollHeight,
                    scrollX: x,
                    scrollY: y,
                });

                const imgData = canvas.toDataURL('image/png', 1.0);
                const pdf = new jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'px',
                    format: [width, height]
                });
                pdf.addImage(imgData, 'PNG', 0, 0, width, height);

                return pdf.output('blob');
            } finally {
                // Restaurar estilos siempre
                modal.style.overflow = originalOverflow;
                modal.style.width = originalWidth;
            }
        }

        // Función para mostrar una alerta de error
        function showErrorAlert(message = 'Hubo un problema al generar o subir el PDF. Por favor, inténtalo de nuevo.') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'Salir',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnsalirMBBVA')?.click();
                }
            });
        }

        // Función para restaurar los estilos del modal
        function restoreModalStyles(modal) {
            if (modal) {
                modal.style.overflow = '';
                modal.style.width = '';
            }
        }
    </script>

    <!-- Script que genera el PDF DEL MODAL CEDULA_HDI.PHP -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btnguardarMHDI')?.addEventListener('click', async function() {
                // Validar el contenido del div (compromiso)
                const compromisoDiv = document.getElementById('compromiso_cedula');
                //Validar el contenido del CheckBox
                const checkbox = document.getElementById('compromisoCheck');

                if (!compromisoDiv || compromisoDiv.innerText.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Compromiso requerido 😅',
                        confirmButtonText: 'Entendido',
                    });
                    return;
                }

                if (!checkbox?.checked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Compromiso requerido 😅',
                        text: 'Debes aceptar de enterado/a antes de guardar.',
                        confirmButtonText: 'Entendido',
                    });
                    return;
                }

                const modal = document.querySelector('.custom-modal-content-HDI');
                if (!modal) {
                    console.error('No se encontró el modal');
                    showErrorAlert('No se pudo encontrar el contenido del modal');
                    return;
                }

                const buttons = modal.querySelectorAll('button');

                // Oculta los botones
                hideElements(buttons);

                // Mostrar alerta de carga
                const loadingAlert = Swal.fire({
                    title: 'Generando PDF...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    // Espera a que los elementos dinámicos se carguen
                    await waitForDynamicContent(modal);

                    // Convierte las imágenes a Base64
                    await convertImagesToBase64(modal);

                    // Captura el modal y genera el PDF
                    const pdfBlob = await captureModalWithStyles(modal, -100, -70, 1300, 2800);

                    // Enviar el PDF al servidor con control de errores
                    let operador = '';
                    const nombreElemento = document.getElementById('nombre_ch');

                    if (!nombreElemento) {
                        throw new Error('Elemento con id "nombre_ch" no encontrado en el DOM');
                    }

                    // Detectar si es un input o un span/div
                    if (nombreElemento.tagName === 'INPUT' || nombreElemento.tagName === 'TEXTAREA') {
                        operador = nombreElemento.value.trim();
                    } else {
                        operador = nombreElemento.textContent.trim();
                    }

                    if (!operador) {
                        throw new Error('El campo del operador está vacío');
                    }

                    const formData = new FormData();
                    formData.append('operador', operador);
                    formData.append('archivo', pdfBlob, 'cedula_HDI.pdf');

                    const response = await fetch('proc/insertPDF_HDI.php', {
                        method: 'POST',
                        body: formData,
                    });

                    // Verificar si la respuesta es JSON válido
                    const responseText = await response.text();
                    let result;

                    try {
                        result = JSON.parse(responseText);
                    } catch (e) {
                        console.error('Respuesta del servidor no es JSON válido:', responseText);
                        throw new Error(`El servidor respondió con un formato inválido: ${responseText.substring(0, 100)}...`);
                    }

                    if (!response.ok || !result.success) {
                        throw new Error(result.error || `Error al subir el PDF (${response.status})`);
                    }

                    // Cerrar la alerta de carga
                    await loadingAlert.close();

                    // Mostrar alerta de éxito
                    await Swal.fire({
                        icon: 'success',
                        title: '¡El PDF <i class="fas fa-file-pdf" style="color:red;"></i> se ha guardado correctamente!',
                        timer: 4500,
                        showConfirmButton: false,
                    });

                    // Cerrar el modal y recargar
                    document.getElementById('btnsalirMHDI')?.click();
                    location.reload(true);

                } catch (error) {
                    console.error('Error:', error);
                    await loadingAlert.close();
                    showErrorAlert(error.message || 'Error desconocido al procesar el PDF');
                } finally {
                    // Restaura el estado original
                    showElements(buttons);
                    restoreModalStyles(modal);
                }
            });
        });

        // [Resto de las funciones auxiliares permanecen igual...]

        // Función para esperar a que los elementos dinámicos se carguen
        function waitForDynamicContent(container) {
            return new Promise((resolve) => {
                // Verificar si ya hay contenido
                if (container.querySelectorAll('*').length > 0) {
                    return resolve();
                }

                const observer = new MutationObserver((mutationsList, observer) => {
                    if (container.querySelectorAll('*').length > 0) {
                        resolve();
                        observer.disconnect();
                    }
                });

                observer.observe(container, {
                    childList: true,
                    subtree: true
                });

                // Timeout de seguridad
                setTimeout(() => {
                    observer.disconnect();
                    resolve();
                }, 2000);
            });
        }

        // Función para ocultar elementos
        function hideElements(elements) {
            elements.forEach(element => {
                if (element) element.style.display = 'none';
            });
        }

        // Función para mostrar elementos
        function showElements(elements) {
            elements.forEach(element => {
                if (element) element.style.display = '';
            });
        }

        // Función para convertir imágenes a Base64
        async function convertImagesToBase64(container) {
            const images = container.querySelectorAll('img');
            if (!images.length) return;

            const conversionPromises = Array.from(images).map(img => {
                return new Promise((resolve) => {
                    if (!img.src) return resolve();

                    // Si ya es base64, no hacer nada
                    if (img.src.startsWith('data:image')) return resolve();

                    if (img.complete && img.naturalHeight !== 0) {
                        convertToBase64(img);
                        resolve();
                    } else {
                        const onLoad = () => {
                            convertToBase64(img);
                            img.removeEventListener('load', onLoad);
                            resolve();
                        };

                        const onError = () => {
                            console.warn("Error cargando la imagen:", img.src);
                            img.removeEventListener('error', onError);
                            resolve();
                        };

                        img.addEventListener('load', onLoad);
                        img.addEventListener('error', onError);
                    }
                });
            });

            await Promise.all(conversionPromises);
        }

        // Función para convertir una imagen a Base64
        function convertToBase64(img) {
            try {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.naturalWidth || img.width;
                canvas.height = img.naturalHeight || img.height;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                img.src = canvas.toDataURL('image/png');
            } catch (error) {
                console.error('Error convirtiendo imagen a Base64:', error);
            }
        }

        // Función para capturar el modal y generar el PDF
        async function captureModalWithStyles(modal, x, y, width, height) {
            if (!modal) throw new Error('Elemento modal no encontrado');

            const originalOverflow = modal.style.overflow;
            const originalWidth = modal.style.width;

            modal.style.overflow = 'visible';
            modal.style.width = `${modal.scrollWidth}px`;

            try {
                const canvas = await html2canvas(modal, {
                    scale: window.devicePixelRatio * 2,
                    logging: true,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: null,
                    foreignObjectRendering: true,
                    imageTimeout: 15000, // Aumentamos el timeout
                    width,
                    height,
                    windowWidth: modal.scrollWidth,
                    windowHeight: modal.scrollHeight,
                    scrollX: x,
                    scrollY: y,
                });

                const imgData = canvas.toDataURL('image/png', 1.0);
                const pdf = new jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'px',
                    format: [width, height]
                });
                pdf.addImage(imgData, 'PNG', 0, 0, width, height);

                return pdf.output('blob');
            } finally {
                // Restaurar estilos siempre
                modal.style.overflow = originalOverflow;
                modal.style.width = originalWidth;
            }
        }

        // Función para mostrar una alerta de error
        function showErrorAlert(message = 'Hubo un problema al generar o subir el PDF. Por favor, inténtalo de nuevo.') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'Salir',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnsalirMHDI')?.click();
                }
            });
        }

        // Función para restaurar los estilos del modal
        function restoreModalStyles(modal) {
            if (modal) {
                modal.style.overflow = '';
                modal.style.width = '';
            }
        }
    </script>

    <!-- Script que genera el PDF DEL MODAL CEDULA_RH.PHP -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btnguardarMRH')?.addEventListener('click', async function() {
                // Validar el contenido del div (compromiso)
                const compromisoDiv = document.getElementById('compromiso_cedula');

                if (!compromisoDiv || compromisoDiv.innerText.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Compromiso requerido 😅',
                        confirmButtonText: 'Entendido',
                    });
                    return;
                }

                const modal = document.querySelector('.custom-modal-content-RH');
                if (!modal) {
                    console.error('No se encontró el modal');
                    showErrorAlert('No se pudo encontrar el contenido del modal');
                    return;
                }

                const buttons = modal.querySelectorAll('button');

                // Oculta los botones
                hideElements(buttons);

                // Mostrar alerta de carga
                const loadingAlert = Swal.fire({
                    title: 'Generando PDF...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    // Espera a que los elementos dinámicos se carguen
                    await waitForDynamicContent(modal);

                    // Convierte las imágenes a Base64
                    await convertImagesToBase64(modal);

                    // Captura el modal y genera el PDF
                    const pdfBlob = await captureModalWithStyles(modal, -100, -70, 1200, 2800);

                    // Enviar el PDF al servidor con control de errores
                    let operador = '';
                    const nombreElemento = document.getElementById('nombre_cr');

                    if (!nombreElemento) {
                        throw new Error('Elemento con id "nombre_cr" no encontrado en el DOM');
                    }

                    // Detectar si es un input o un span/div
                    if (nombreElemento.tagName === 'INPUT' || nombreElemento.tagName === 'TEXTAREA') {
                        operador = nombreElemento.value.trim();
                    } else {
                        operador = nombreElemento.textContent.trim();
                    }

                    if (!operador) {
                        throw new Error('El campo del operador está vacío');
                    }

                    const formData = new FormData();
                    formData.append('operador', operador);
                    formData.append('archivo', pdfBlob, 'cedula_RH.pdf');

                    const response = await fetch('proc/insertPDF_RH.php', {
                        method: 'POST',
                        body: formData,
                    });

                    // Verificar si la respuesta es JSON válido
                    const responseText = await response.text();
                    let result;

                    try {
                        result = JSON.parse(responseText);
                    } catch (e) {
                        console.error('Respuesta del servidor no es JSON válido:', responseText);
                        throw new Error(`El servidor respondió con un formato inválido: ${responseText.substring(0, 100)}...`);
                    }

                    if (!response.ok || !result.success) {
                        throw new Error(result.error || `Error al subir el PDF (${response.status})`);
                    }

                    // Cerrar la alerta de carga
                    await loadingAlert.close();

                    // Mostrar alerta de éxito
                    await Swal.fire({
                        icon: 'success',
                        title: '¡El PDF <i class="fas fa-file-pdf" style="color:red;"></i> se ha guardado correctamente!',
                        timer: 4500,
                        showConfirmButton: false,
                    });

                    // Cerrar el modal y recargar
                    document.getElementById('btnsalirMRH')?.click();
                    location.reload(true);

                } catch (error) {
                    console.error('Error:', error);
                    await loadingAlert.close();
                    showErrorAlert(error.message || 'Error desconocido al procesar el PDF');
                } finally {
                    // Restaura el estado original
                    showElements(buttons);
                    restoreModalStyles(modal);
                }
            });
        });

        // [Resto de las funciones auxiliares permanecen igual...]

        // Función para esperar a que los elementos dinámicos se carguen
        function waitForDynamicContent(container) {
            return new Promise((resolve) => {
                // Verificar si ya hay contenido
                if (container.querySelectorAll('*').length > 0) {
                    return resolve();
                }

                const observer = new MutationObserver((mutationsList, observer) => {
                    if (container.querySelectorAll('*').length > 0) {
                        resolve();
                        observer.disconnect();
                    }
                });

                observer.observe(container, {
                    childList: true,
                    subtree: true
                });

                // Timeout de seguridad
                setTimeout(() => {
                    observer.disconnect();
                    resolve();
                }, 2000);
            });
        }

        // Función para ocultar elementos
        function hideElements(elements) {
            elements.forEach(element => {
                if (element) element.style.display = 'none';
            });
        }

        // Función para mostrar elementos
        function showElements(elements) {
            elements.forEach(element => {
                if (element) element.style.display = '';
            });
        }

        // Función para convertir imágenes a Base64
        async function convertImagesToBase64(container) {
            const images = container.querySelectorAll('img');
            if (!images.length) return;

            const conversionPromises = Array.from(images).map(img => {
                return new Promise((resolve) => {
                    if (!img.src) return resolve();

                    // Si ya es base64, no hacer nada
                    if (img.src.startsWith('data:image')) return resolve();

                    if (img.complete && img.naturalHeight !== 0) {
                        convertToBase64(img);
                        resolve();
                    } else {
                        const onLoad = () => {
                            convertToBase64(img);
                            img.removeEventListener('load', onLoad);
                            resolve();
                        };

                        const onError = () => {
                            console.warn("Error cargando la imagen:", img.src);
                            img.removeEventListener('error', onError);
                            resolve();
                        };

                        img.addEventListener('load', onLoad);
                        img.addEventListener('error', onError);
                    }
                });
            });

            await Promise.all(conversionPromises);
        }

        // Función para convertir una imagen a Base64
        function convertToBase64(img) {
            try {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.naturalWidth || img.width;
                canvas.height = img.naturalHeight || img.height;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                img.src = canvas.toDataURL('image/png');
            } catch (error) {
                console.error('Error convirtiendo imagen a Base64:', error);
            }
        }

        // Función para capturar el modal y generar el PDF
        async function captureModalWithStyles(modal, x, y, width, height) {
            if (!modal) throw new Error('Elemento modal no encontrado');

            const originalOverflow = modal.style.overflow;
            const originalWidth = modal.style.width;

            modal.style.overflow = 'visible';
            modal.style.width = `${modal.scrollWidth}px`;

            try {
                const canvas = await html2canvas(modal, {
                    scale: window.devicePixelRatio * 2,
                    logging: true,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: null,
                    foreignObjectRendering: true,
                    imageTimeout: 15000, // Aumentamos el timeout
                    width,
                    height,
                    windowWidth: modal.scrollWidth,
                    windowHeight: modal.scrollHeight,
                    scrollX: x,
                    scrollY: y,
                });

                const imgData = canvas.toDataURL('image/png', 1.0);
                const pdf = new jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'px',
                    format: [width, height]
                });
                pdf.addImage(imgData, 'PNG', 0, 0, width, height);

                return pdf.output('blob');
            } finally {
                // Restaurar estilos siempre
                modal.style.overflow = originalOverflow;
                modal.style.width = originalWidth;
            }
        }

        // Función para mostrar una alerta de error
        function showErrorAlert(message = 'Hubo un problema al generar o subir el PDF. Por favor, inténtalo de nuevo.') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'Salir',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnsalirMRH')?.click();
                }
            });
        }

        // Función para restaurar los estilos del modal
        function restoreModalStyles(modal) {
            if (modal) {
                modal.style.overflow = '';
                modal.style.width = '';
            }
        }
    </script>


    <!--SCRIPT de las notificaciones y contenidos del modal-->
    <script type="module">
        let modalAbierto = null;

        function abrirModal(modalId) {
            if (modalAbierto) {
                $(modalAbierto).modal('hide');
            }
            const modal = document.getElementById(modalId);
            if (modal) {
                $(modal).modal('show');
                modalAbierto = modalId;
            }
        }


        $(document).on('hidden.bs.modal', '.modal', function() {
            modalAbierto = null;
        });

        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
        import {
            getDatabase,
            ref,
            onValue,
            update
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

        const firebaseConfig = {
            apiKey: "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
            authDomain: "prueba-pickcollect.firebaseapp.com",
            databaseURL: "https://prueba-pickcollect-default-rtdb.firebaseio.com",
            projectId: "prueba-pickcollect",
            storageBucket: "prueba-pickcollect.firebasestorage.app",
            messagingSenderId: "343351102325",
            appId: "1:343351102325:web:a6e4184d4752c6cbcfe13c",
            measurementId: "G-6864KLZWKP"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const operadorActual = "<?php echo $_SESSION['nombre_usuario']; ?>";
        const notificacionesRef = ref(db, "notificaciones");

        // Función para mostrar el toast
        function mostrarToast(mensaje) {
            const toastContainer = document.getElementById("toastContainer");

            // Limpiar toasts anteriores
            toastContainer.innerHTML = '';

            // Crear el toast
            const toast = document.createElement("div");
            toast.classList.add("toast");
            toast.setAttribute("role", "alert");
            toast.setAttribute("aria-live", "assertive");
            toast.setAttribute("aria-atomic", "true");

            // Estilos del toast
            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.right = "20px";
            toast.style.zIndex = "9999";
            toast.style.backgroundColor = "rgb(64, 148, 61)";
            toast.style.border = "none"; // Borde
            toast.style.borderRadius = "5px"; // Bordes redondeados
            toast.style.padding = "10px"; // Espaciado interno
            toast.style.boxShadow = "0 4px 8px rgb(0, 0, 0)"; // Sombra
            toast.style.maxWidth = "300px"; // Ancho máximo

            // Contenido del toast
            toast.innerHTML = `

            <div class="toast-body">
                ${mensaje}
            </div>
        `;

            // Agregar el toast al contenedor
            toastContainer.appendChild(toast);

            // Mostrar el toast
            toast.style.display = "block";

            // Ocultar el toast después de 4 segundos
            setTimeout(() => {
                toast.style.display = "none";
            }, 4000);
        }

        // Función para cerrar el toast manualmente
        window.cerrarToast = function(btn) {
            const toast = btn.closest(".toast");
            if (toast) {
                toast.style.display = "none";
            }
        };

        // Función para cargar notificaciones
        function cargarNotificaciones() {
            onValue(notificacionesRef, (snapshot) => {
                const notificaciones = snapshot.val() || {};
                let contador = 0;
                let htmlNotificaciones = "";

                for (let key in notificaciones) {
                    let notificacion = notificaciones[key];
                    if (notificacion.operador === operadorActual && notificacion.leido === false) {
                        contador++;
                        htmlNotificaciones += `
                    <a class="dropdown-item d-flex align-items-center" href="#" 
                        data-id="${key}" 
                        data-siniestro="${notificacion.siniestro}" 
                        data-fecha="${notificacion.fecha}" 
                        data-tipo="${notificacion.tipo}" 
                        data-url="${notificacion.url}" 
                        onclick="leerNotificacion(event, this)">
                            <div>
                                <div class="text-truncate">${notificacion.mensaje}</div>
                                <div class="small text-gray-500">${notificacion.fecha}</div>
                            </div>
                    </a>`;

                        // Mostrar toast solo si es una notificación nueva
                        if (contador === 1) { // Solo mostrar el toast para la primera notificación no leída
                            mostrarToast(notificacion.mensaje);
                        }
                    }
                }

                const badge = document.querySelector("#alertsDropdown .badge-counter");
                badge.textContent = contador > 0 ? contador : "";
                badge.style.display = contador > 0 ? "inline-block" : "none";

                const dropdown = document.querySelector("#alertsDropdown + .dropdown-menu");
                dropdown.innerHTML = `
                        <h6 class="dropdown-header" style="
                            font-size: 1.1rem;
                            font-weight: 600;
                            color:rgb(255, 255, 255);
                            background-color:rgb(82, 63, 151);
                            padding: 0.75rem 1rem;
                            border-bottom: none;
                            margin: 0;
                        ">🟣 Centro de Alertas</h6>
                        <div style="
                            max-height: 300px;
                            overflow-y: auto;
                            padding: 0.5rem 0;
                        ">
                            ${htmlNotificaciones}
                        </div>
                    `;
            });
        }

        // Cargar notificaciones al inicio
        cargarNotificaciones();

        window.leerNotificacion = function(event, element) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace

            const notificacionId = element.getAttribute("data-id");
            const siniestroId = element.getAttribute("data-siniestro");
            const tipoNotificacion = element.getAttribute("data-tipo");

            console.log("📌 Notificación clickeada, ID Expediente:", siniestroId);
            console.log("📌 Tipo de notificación:", tipoNotificacion);
            console.log("📌 ID de la notificación en Firebase:", notificacionId);

            // Marcar la notificación como leída en Firebase
            if (notificacionId) {
                const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
                update(notificacionRef, {
                        leido: true
                    })
                    .then(() => {
                        console.log(`✅ Notificación ${notificacionId} marcada como leída`);
                        // Ocultar la notificación en el UI y actualizar el contador
                        element.style.display = "none";
                        const badge = document.querySelector("#alertsDropdown .badge-counter");
                        let count = parseInt(badge.textContent) || 0;
                        if (count > 0) {
                            badge.textContent = count - 1;
                            if (count - 1 === 0) {
                                badge.style.display = "none";
                            }
                        }
                        // Recargar notificaciones después de marcar como leída
                        cargarNotificaciones();
                    })
                    .catch((error) => console.error("❌ Error al actualizar la notificación:", error));
            }

            // Abrir modal solo si el tipo de notificación es "evaluacion" y se hace clic explícitamente
            if (tipoNotificacion === "evaluacion") {
                const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
                onValue(notificacionRef, (snapshot) => {
                    const notificacion = snapshot.val();
                    if (notificacion) {
                        $.ajax({
                            url: 'cedula_parciales2.php',
                            type: 'POST',
                            data: {
                                operador: notificacion.operador,
                                campana: notificacion.campana,
                                posicion: notificacion.posicion,
                                supervisor: notificacion.supervisor,
                                tipoTramite: notificacion.tipoTramite,
                                id_C: notificacion.id_C,
                                nombreTer: notificacion.nombreTerc,
                                siniestro_c: notificacion.siniestro_c,
                                cumple: notificacion.cumple,
                                cumple1: notificacion.cumple1,
                                cumple2: notificacion.cumple2,
                                cumple3: notificacion.cumple3,
                                cumple4: notificacion.cumple4,
                                cumple5: notificacion.cumple5,
                                cumple6: notificacion.cumple6,
                                cumple7: notificacion.cumple7,
                                cumple8: notificacion.cumple8,
                                cumple9: notificacion.cumple9,
                                cumple10: notificacion.cumple10,
                                cumple11: notificacion.cumple11,
                                cumple12: notificacion.cumple12,
                                cumple13: notificacion.cumple13,
                                cumple14: notificacion.cumple14,
                                fortalezas: notificacion.fortalezas,
                                areaOpor: notificacion.areaOpor,
                                comentarios_c: notificacion.comentarios_c,
                                notaCalidad: notificacion.siniestro,
                                tipo: notificacion.tipo,
                                firmaAnalista: notificacion.firmaAnalista,
                                firmaAnalistaImg: notificacion.firmaAnalistaImg, // Nueva propiedad agregada
                                urlAudio: notificacion.urlArchivoSubido // Asegúrate de que la URL del audio esté en Firebase

                            },
                            success: function(data) {
                                $('#cedulaModalContent').html(data);
                                $('#nombre_c').text(notificacion.operador);

                                // Actualizar el reproductor de audio con la URL del archivo
                                const audioPlayer = document.getElementById('audioPlayer');
                                if (audioPlayer && notificacion.urlAudio) {
                                    audioPlayer.src = notificacion.urlAudio;
                                    audioPlayer.load(); // Recargar el reproductor de audio
                                }
                                abrirModal('cedulaModalA');
                            },
                            error: function() {
                                $('#cedulaModalContent').html('<p>Error al cargar el contenido.</p>');
                            }
                        });
                    }
                }, {
                    onlyOnce: true
                });

                // Usar onlyOnce para evitar múltiples llamadas
            } else if (tipoNotificacion === "BBVA") {
                const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
                onValue(notificacionRef, (snapshot) => {
                    const notificacion = snapshot.val();
                    if (notificacion) {
                        $.ajax({
                            url: 'cedula_bbva.php',
                            type: 'POST',
                            data: {
                                calificacion1: notificacion.calificacion1,
                                calificacion2: notificacion.calificacion2,
                                calificacion3: notificacion.calificacion3,
                                calificacion4: notificacion.calificacion4,
                                llamada_1: notificacion.llamada_1,
                                llamada_2: notificacion.llamada_2,
                                llamada_3: notificacion.llamada_3,
                                llamada_4: notificacion.llamada_4,
                                duracion_1: notificacion.duracion_1,
                                duracion_2: notificacion.duracion_2,
                                duracion_3: notificacion.duracion_3,
                                duracion_4: notificacion.duracion_4,
                                fecha_llamada_1: notificacion.fecha_llamada_1,
                                fecha_llamada_2: notificacion.fecha_llamada_2,
                                fecha_llamada_3: notificacion.fecha_llamada_3,
                                fecha_llamada_4: notificacion.fecha_llamada_4,
                                hora_llamada_1: notificacion.hora_llamada_1,
                                hora_llamada_2: notificacion.hora_llamada_2,
                                hora_llamada_3: notificacion.hora_llamada_3,
                                hora_llamada_4: notificacion.hora_llamada_4,
                                operador: notificacion.operador,
                                posicion: notificacion.posicion,
                                supervisor: notificacion.evaluador,

                                cumple1_1: notificacion.cumple1_1,
                                cumple1_2: notificacion.cumple1_2,
                                cumple1_3: notificacion.cumple1_3,
                                cumple1_4: notificacion.cumple1_4,

                                cumple2_1: notificacion.cumple2_1,
                                cumple2_2: notificacion.cumple2_2,
                                cumple2_3: notificacion.cumple2_3,
                                cumple2_4: notificacion.cumple2_4,

                                cumple3_1: notificacion.cumple3_1,
                                cumple3_2: notificacion.cumple3_2,
                                cumple3_3: notificacion.cumple3_3,
                                cumple3_4: notificacion.cumple3_4,

                                cumple4_1: notificacion.cumple4_1,
                                cumple4_2: notificacion.cumple4_2,
                                cumple4_3: notificacion.cumple4_3,
                                cumple4_4: notificacion.cumple4_4,

                                cumple5_1: notificacion.cumple5_1,
                                cumple5_2: notificacion.cumple5_2,
                                cumple5_3: notificacion.cumple5_3,
                                cumple5_4: notificacion.cumple5_4,

                                cumple6_1: notificacion.cumple6_1,
                                cumple6_2: notificacion.cumple6_2,
                                cumple6_3: notificacion.cumple6_3,
                                cumple6_4: notificacion.cumple6_4,

                                cumple7_1: notificacion.cumple7_1,
                                cumple7_2: notificacion.cumple7_2,
                                cumple7_3: notificacion.cumple7_3,
                                cumple7_4: notificacion.cumple7_4,

                                cumple8_1: notificacion.cumple8_1,
                                cumple8_2: notificacion.cumple8_2,
                                cumple8_3: notificacion.cumple8_3,
                                cumple8_4: notificacion.cumple8_4,

                                cumple9_1: notificacion.cumple9_1,
                                cumple9_2: notificacion.cumple9_2,
                                cumple9_3: notificacion.cumple9_3,
                                cumple9_4: notificacion.cumple9_4,

                                cumple10_1: notificacion.cumple10_1,
                                cumple10_2: notificacion.cumple10_2,
                                cumple10_3: notificacion.cumple10_3,
                                cumple10_4: notificacion.cumple10_4,

                                cumple11_1: notificacion.cumple11_1,
                                cumple11_2: notificacion.cumple11_2,
                                cumple11_3: notificacion.cumple11_3,
                                cumple11_4: notificacion.cumple11_4,

                                cumple12_1: notificacion.cumple12_1,
                                cumple12_2: notificacion.cumple12_2,
                                cumple12_3: notificacion.cumple12_3,
                                cumple12_4: notificacion.cumple12_4,

                                cumple13_1: notificacion.cumple13_1,
                                cumple13_2: notificacion.cumple13_2,
                                cumple13_3: notificacion.cumple13_3,
                                cumple13_4: notificacion.cumple13_4,

                                cumple14_1: notificacion.cumple14_1,
                                cumple14_2: notificacion.cumple14_2,
                                cumple14_3: notificacion.cumple14_3,
                                cumple14_4: notificacion.cumple14_4,

                                cumple15_1: notificacion.cumple15_1,
                                cumple15_2: notificacion.cumple15_2,
                                cumple15_3: notificacion.cumple15_3,
                                cumple15_4: notificacion.cumple15_4,

                                cumple16_1: notificacion.cumple16_1,
                                cumple16_2: notificacion.cumple16_2,
                                cumple16_3: notificacion.cumple16_3,
                                cumple16_4: notificacion.cumple16_4,

                                cumple17_1: notificacion.cumple17_1,
                                cumple17_2: notificacion.cumple17_2,
                                cumple17_3: notificacion.cumple17_3,
                                cumple17_4: notificacion.cumple17_4,


                                fortalezas: notificacion.fortalezas,
                                areaOpor: notificacion.oportunidades,
                                comentarios_cb: notificacion.comentarios_cb,
                                notaCalidad: notificacion.notaCalidad,
                                firmaAnalista: notificacion.firmaAnalista,
                                llamada1_url: notificacion.llamada1_url, // Asegúrate de que la URL del audio esté en Firebase
                                llamada2_url: notificacion.llamada2_url,
                                llamada3_url: notificacion.llamada3_url,
                                llamada4_url: notificacion.llamada4_url,
                                tipo: notificacion.tipo
                            },
                            success: function(data) {
                                $('#cedulaModalContentBBVA').html(data);
                                $('#nombre_cb').text(notificacion.operador);
                                abrirModal('cedulaModalBBVA');
                            },
                            error: function() {
                                $('#cedulaModalContentBBVA').html('<p>Error al cargar el contenido.</p>');
                            }
                        });
                    }
                }, {
                    onlyOnce: true
                });

                // Usar onlyOnce para evitar múltiples llamadas
            } else if (tipoNotificacion === "HDI") {
                const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
                onValue(notificacionRef, (snapshot) => {
                    const notificacion = snapshot.val();
                    if (notificacion) {
                        $.ajax({
                            url: 'cedula_hdi.php',
                            type: 'POST',
                            data: {
                                calificacion1: notificacion.calificacion1,
                                calificacion2: notificacion.calificacion2,
                                calificacion3: notificacion.calificacion3,
                                calificacion4: notificacion.calificacion4,
                                llamada_1: notificacion.llamada_1,
                                llamada_2: notificacion.llamada_2,
                                llamada_3: notificacion.llamada_3,
                                llamada_4: notificacion.llamada_4,
                                duracion_1: notificacion.duracion_1,
                                duracion_2: notificacion.duracion_2,
                                duracion_3: notificacion.duracion_3,
                                duracion_4: notificacion.duracion_4,
                                fecha_llamada_1: notificacion.fecha_llamada_1,
                                fecha_llamada_2: notificacion.fecha_llamada_2,
                                fecha_llamada_3: notificacion.fecha_llamada_3,
                                fecha_llamada_4: notificacion.fecha_llamada_4,
                                hora_llamada_1: notificacion.hora_llamada_1,
                                hora_llamada_2: notificacion.hora_llamada_2,
                                hora_llamada_3: notificacion.hora_llamada_3,
                                hora_llamada_4: notificacion.hora_llamada_4,
                                operador: notificacion.operador,
                                posicion: notificacion.posicion,
                                supervisor: notificacion.evaluador,

                                cumple1_1: notificacion.cumple1_1,
                                cumple1_2: notificacion.cumple1_2,
                                cumple1_3: notificacion.cumple1_3,
                                cumple1_4: notificacion.cumple1_4,

                                cumple2_1: notificacion.cumple2_1,
                                cumple2_2: notificacion.cumple2_2,
                                cumple2_3: notificacion.cumple2_3,
                                cumple2_4: notificacion.cumple2_4,

                                cumple3_1: notificacion.cumple3_1,
                                cumple3_2: notificacion.cumple3_2,
                                cumple3_3: notificacion.cumple3_3,
                                cumple3_4: notificacion.cumple3_4,

                                cumple4_1: notificacion.cumple4_1,
                                cumple4_2: notificacion.cumple4_2,
                                cumple4_3: notificacion.cumple4_3,
                                cumple4_4: notificacion.cumple4_4,

                                cumple5_1: notificacion.cumple5_1,
                                cumple5_2: notificacion.cumple5_2,
                                cumple5_3: notificacion.cumple5_3,
                                cumple5_4: notificacion.cumple5_4,

                                cumple6_1: notificacion.cumple6_1,
                                cumple6_2: notificacion.cumple6_2,
                                cumple6_3: notificacion.cumple6_3,
                                cumple6_4: notificacion.cumple6_4,

                                cumple7_1: notificacion.cumple7_1,
                                cumple7_2: notificacion.cumple7_2,
                                cumple7_3: notificacion.cumple7_3,
                                cumple7_4: notificacion.cumple7_4,

                                cumple8_1: notificacion.cumple8_1,
                                cumple8_2: notificacion.cumple8_2,
                                cumple8_3: notificacion.cumple8_3,
                                cumple8_4: notificacion.cumple8_4,

                                cumple9_1: notificacion.cumple9_1,
                                cumple9_2: notificacion.cumple9_2,
                                cumple9_3: notificacion.cumple9_3,
                                cumple9_4: notificacion.cumple9_4,

                                cumple10_1: notificacion.cumple10_1,
                                cumple10_2: notificacion.cumple10_2,
                                cumple10_3: notificacion.cumple10_3,
                                cumple10_4: notificacion.cumple10_4,

                                cumple11_1: notificacion.cumple11_1,
                                cumple11_2: notificacion.cumple11_2,
                                cumple11_3: notificacion.cumple11_3,
                                cumple11_4: notificacion.cumple11_4,

                                cumple12_1: notificacion.cumple12_1,
                                cumple12_2: notificacion.cumple12_2,
                                cumple12_3: notificacion.cumple12_3,
                                cumple12_4: notificacion.cumple12_4,

                                cumple13_1: notificacion.cumple13_1,
                                cumple13_2: notificacion.cumple13_2,
                                cumple13_3: notificacion.cumple13_3,
                                cumple13_4: notificacion.cumple13_4,

                                cumple14_1: notificacion.cumple14_1,
                                cumple14_2: notificacion.cumple14_2,
                                cumple14_3: notificacion.cumple14_3,
                                cumple14_4: notificacion.cumple14_4,

                                cumple15_1: notificacion.cumple15_1,
                                cumple15_2: notificacion.cumple15_2,
                                cumple15_3: notificacion.cumple15_3,
                                cumple15_4: notificacion.cumple15_4,

                                fortalezas: notificacion.fortalezas,
                                areaOpor: notificacion.oportunidades,
                                comentarios_ch: notificacion.comentarios_ch,
                                comentariosTextarea: notificacion.comentariosTextarea,
                                notaCalidad: notificacion.notaCalidad,
                                llamada1_url: notificacion.llamada1_url, // Asegúrate de que la URL del audio esté en Firebase
                                llamada2_url: notificacion.llamada2_url,
                                llamada3_url: notificacion.llamada3_url,
                                llamada4_url: notificacion.llamada4_url
                            },
                            success: function(data) {
                                $('#cedulaModalContentHDI').html(data);
                                $('#nombre_ch').text(notificacion.operador);
                                abrirModal('cedulaModalHDI');
                            },
                            error: function() {
                                $('#cedulaModalContentHDI').html('<p>Error al cargar el contenido.</p>');
                            }
                        });
                    }
                }, {
                    onlyOnce: true
                });

            } else if (tipoNotificacion === "Supervisor") {
                const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
                onValue(notificacionRef, (snapshot) => {
                    const notificacion = snapshot.val();
                    if (notificacion) {
                        $.ajax({
                            url: 'cedula_rh.php',
                            type: 'POST',
                            data: {
                                calificacion1: notificacion.calificacion1,
                                calificacion2: notificacion.calificacion2,
                                calificacion3: notificacion.calificacion3,
                                calificacion4: notificacion.calificacion4,
                                llamada_1: notificacion.llamada_1,
                                llamada_2: notificacion.llamada_2,
                                llamada_3: notificacion.llamada_3,
                                llamada_4: notificacion.llamada_4,
                                duracion_1: notificacion.duracion_1,
                                duracion_2: notificacion.duracion_2,
                                duracion_3: notificacion.duracion_3,
                                duracion_4: notificacion.duracion_4,
                                fecha_llamada_1: notificacion.fecha_llamada_1,
                                fecha_llamada_2: notificacion.fecha_llamada_2,
                                fecha_llamada_3: notificacion.fecha_llamada_3,
                                fecha_llamada_4: notificacion.fecha_llamada_4,
                                hora_llamada_1: notificacion.hora_llamada_1,
                                hora_llamada_2: notificacion.hora_llamada_2,
                                hora_llamada_3: notificacion.hora_llamada_3,
                                hora_llamada_4: notificacion.hora_llamada_4,
                                operador: notificacion.operador,
                                posicion: notificacion.posicion,
                                supervisor: notificacion.evaluador,

                                cumple1_1: notificacion.cumple1_1,
                                cumple1_2: notificacion.cumple1_2,
                                cumple1_3: notificacion.cumple1_3,
                                cumple1_4: notificacion.cumple1_4,

                                cumple2_1: notificacion.cumple2_1,
                                cumple2_2: notificacion.cumple2_2,
                                cumple2_3: notificacion.cumple2_3,
                                cumple2_4: notificacion.cumple2_4,

                                cumple3_1: notificacion.cumple3_1,
                                cumple3_2: notificacion.cumple3_2,
                                cumple3_3: notificacion.cumple3_3,
                                cumple3_4: notificacion.cumple3_4,

                                cumple4_1: notificacion.cumple4_1,
                                cumple4_2: notificacion.cumple4_2,
                                cumple4_3: notificacion.cumple4_3,
                                cumple4_4: notificacion.cumple4_4,

                                cumple5_1: notificacion.cumple5_1,
                                cumple5_2: notificacion.cumple5_2,
                                cumple5_3: notificacion.cumple5_3,
                                cumple5_4: notificacion.cumple5_4,

                                cumple6_1: notificacion.cumple6_1,
                                cumple6_2: notificacion.cumple6_2,
                                cumple6_3: notificacion.cumple6_3,
                                cumple6_4: notificacion.cumple6_4,

                                cumple7_1: notificacion.cumple7_1,
                                cumple7_2: notificacion.cumple7_2,
                                cumple7_3: notificacion.cumple7_3,
                                cumple7_4: notificacion.cumple7_4,

                                cumple8_1: notificacion.cumple8_1,
                                cumple8_2: notificacion.cumple8_2,
                                cumple8_3: notificacion.cumple8_3,
                                cumple8_4: notificacion.cumple8_4,

                                cumple9_1: notificacion.cumple9_1,
                                cumple9_2: notificacion.cumple9_2,
                                cumple9_3: notificacion.cumple9_3,
                                cumple9_4: notificacion.cumple9_4,

                                cumple10_1: notificacion.cumple10_1,
                                cumple10_2: notificacion.cumple10_2,
                                cumple10_3: notificacion.cumple10_3,
                                cumple10_4: notificacion.cumple10_4,

                                cumple11_1: notificacion.cumple11_1,
                                cumple11_2: notificacion.cumple11_2,
                                cumple11_3: notificacion.cumple11_3,
                                cumple11_4: notificacion.cumple11_4,

                                fortalezas: notificacion.fortalezas,
                                areaOpor: notificacion.oportunidades,
                                comentarios_c: notificacion.comentarios_cb,
                                notaCalidad: notificacion.notaCalidad,
                                firmaAnalista: notificacion.firmaAnalista,
                                llamada1_url: notificacion.llamada1_url, // Asegúrate de que la URL del audio esté en Firebase
                                llamada2_url: notificacion.llamada2_url,
                                llamada3_url: notificacion.llamada3_url,
                                llamada4_url: notificacion.llamada4_url,
                                tipo: notificacion.tipo
                            },
                            success: function(data) {
                                $('#cedulaModalContentRH').html(data);
                                $('#nombre_cr').text(notificacion.operador);
                                abrirModal('cedulaModalRH');
                            },
                            error: function() {
                                $('#cedulaModalContentRH').html('<p>Error al cargar el contenido.</p>');
                            }
                        });
                    }
                }, {
                    onlyOnce: true
                });

            } else if (tipoNotificacion === "asignacion") {
                const btnEditar = document.querySelector(`.custom-table-style-edit-btn[data-id="${siniestroId}"]`);
                if (btnEditar) {
                    console.log("✅ Botón encontrado, simulando clic...");
                    btnEditar.click();
                } else {
                    console.warn("⚠️ No se encontró el botón en la tabla. Abriendo modal manualmente.");
                    $('#editarCedulaModal').modal('show');
                }
            }
        };

        $(document).ready(function() {
            $('#btnEditTabla').on('click', function() {
                abrirModal('editarCedulaModal');
            });
        });

        const canvas = document.getElementById("firmaAsesorCanvas");
        const ctx = canvas.getContext("2d");
        const limpiarBtn = document.getElementById("limpiar_f");

        let dibujando = false;

        function getCoordenadas(event) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;
            let x, y;

            if (event.touches) {
                x = (event.touches[0].clientX - rect.left) * scaleX;
                y = (event.touches[0].clientY - rect.top) * scaleY;
            } else {
                x = (event.clientX - rect.left) * scaleX;
                y = (event.clientY - rect.top) * scaleY;
            }
            return {
                x,
                y
            };
        }

        function empezarDibujo(event) {
            event.preventDefault();
            dibujando = true;
            const {
                x,
                y
            } = getCoordenadas(event);
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        function dibujar(event) {
            event.preventDefault();
            if (!dibujando) return;
            const {
                x,
                y
            } = getCoordenadas(event);
            ctx.lineTo(x, y);
            ctx.strokeStyle = "black";
            ctx.lineWidth = 2;
            ctx.lineCap = "round";
            ctx.stroke();
        }

        function finalizarDibujo(event) {
            event.preventDefault();
            dibujando = false;
            ctx.closePath();
        }

        function desbloquearFirma() {
            canvas.style.pointerEvents = "auto";
        }

        canvas.addEventListener("mousedown", empezarDibujo);
        canvas.addEventListener("mousemove", dibujar);
        canvas.addEventListener("mouseup", finalizarDibujo);
        canvas.addEventListener("mouseleave", finalizarDibujo);

        canvas.addEventListener("touchstart", empezarDibujo);
        canvas.addEventListener("touchmove", dibujar);
        canvas.addEventListener("touchend", finalizarDibujo);

        limpiarBtn.addEventListener("click", () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            desbloquearFirma();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

</body>

</html>