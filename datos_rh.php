<?php
// Verifica si la sesión ya está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión si no está activa
}

if (!isset($_SESSION['rol'])) {
    // Si no hay rol en la sesión, redirige al login
    header('Location: login.php');
    exit();
}

$rol = $_SESSION['rol']; // Recupera el rol del usuario
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Datos</title>

    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/datos_rh.css">

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body id="page-top">
<div class="container mt-5">
        <!-- Pestañas de navegación -->
        <ul class="tabs">
            <li class="active" onclick="showTab(0)">Información Personal</li>
            <li onclick="showTab(1)">Dirección</li>
            <li onclick="showTab(2)">Contacto</li>
            <li onclick="showTab(3)">Prueba</li>
        </ul>

        <!-- Formulario -->
        <form id="formulario">
            <!-- Sección 1: Información Personal -->
            <div class="form-section active" id="section-1">
                <div class="card">
                    <div class="card-header">
                        <h2>Información Personal</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-user"></i>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s)" required>
                                </div>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-user-tie"></i>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos" required>
                                </div>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-phone-alt"></i>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                                </div>
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-birthday-cake"></i>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-12 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-home"></i>
                                    <textarea class="form-control" id="direccion" name="direccion" rows="3" placeholder="Dirección" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-secondary">
                        <h2>Seleccion y puesto</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">

                        </div>
                    </div>
                </div>

                <!-- Información Profesional -->
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h2>Información Profesional</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Puesto de Interés -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-briefcase"></i>
                                    <select class="form-select" id="puesto" name="puesto" required>
                                        <option value="Desarrollador">Desarrollador</option>
                                        <option value="Analista">Analista</option>
                                        <option value="Gerente">Gerente</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nivel de Experiencia -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-star"></i>
                                    <select class="form-select" id="experiencia" name="experiencia">
                                        <option value="Junior">Junior</option>
                                        <option value="Semi-Senior">Semi-Senior</option>
                                        <option value="Senior">Senior</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Años de Experiencia -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-clock"></i>
                                    <input type="number" class="form-control" id="anos_experiencia" name="anos_experiencia" placeholder="Años de Experiencia" required>
                                </div>
                            </div>

                            <!-- Formación Académica -->
                            <div class="col-md-6 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-graduation-cap"></i>
                                    <input type="text" class="form-control" id="formacion" name="formacion" placeholder="Formación Académica" required>
                                </div>
                            </div>

                            <!-- Currículum -->
                            <div class="col-md-12 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-file-alt"></i>
                                    <input type="file" class="form-control" id="cv" name="cv" required>
                                </div>
                            </div>

                            <!-- Referencias -->
                            <div class="col-md-12 mb-3">
                                <div class="icon-input">
                                    <i class="fas fa-address-card"></i>
                                    <textarea class="form-control" id="referencias" name="referencias" placeholder="Referencias Laborales" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 2: Dirección -->
            <div class="form-section" id="section-2">
  <h2 class="text-center">Gestión de Archivos con Indicadores</h2>
  <div class="row row-cols-1 row-cols-md-2 g-4 mt-4">
    <!-- Modal Buttons -->
    <div class="col">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Archivo 1</h5>
          <p class="card-text" id="status1">Documento A: Pendiente de subir</p>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileUploadModal1">Subir Archivo</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Archivo 2</h5>
          <p class="card-text" id="status2">Documento B: Pendiente de subir</p>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileUploadModal2">Subir Archivo</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Archivo 3</h5>
          <p class="card-text" id="status3">Documento C: Pendiente de subir</p>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileUploadModal3">Subir Archivo</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Archivo 4</h5>
          <p class="card-text" id="status4">Documento D: Pendiente de subir</p>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileUploadModal4">Subir Archivo</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Archivo 5</h5>
          <p class="card-text" id="status5">Documento E: Pendiente de subir</p>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileUploadModal5">Subir Archivo</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Template -->
<template id="modalTemplate">
  <div class="modal fade" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Subir y Gestionar Archivos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- File Input -->
          <div class="mb-3">
            <label class="form-label">Selecciona un archivo</label>
            <input type="file" class="form-control file-input" accept="image/*,application/pdf">
          </div>
          <!-- Preview Container -->
          <div class="file-preview-container">
            <img class="preview-image d-none" alt="Previsualización">
            <iframe class="preview-pdf d-none"></iframe>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary save-button" disabled>Guardar</button>
        </div>
      </div>
    </div>
  </div>
</template> 


            <!-- Sección 3: Contacto -->
            <div class="form-section" id="section-3">
                <h2>Contacto</h2>
                <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
        <select class="form-select" id="tipo_contrato" name="tipo_contrato" required>
            <option value="">Seleccione</option>
            <option value="Indefinido">Indefinido</option>
            <option value="Temporal">Temporal</option>
            <option value="Por Proyecto">Por Proyecto</option>
            <option value="Honorarios">Honorarios</option>
        </select>
                
        <label for="sueldo_acordado" class="form-label">Sueldo Acordado (MXN)</label>
        <input type="number" class="form-control" id="sueldo_acordado" name="sueldo_acordado" step="0.01" required>

        <label for="dias_laborales" class="form-label">Días Laborales</label>
        <input type="text" class="form-control" id="dias_laborales" name="dias_laborales" placeholder="Ej. Lunes a Viernes" required>

        <label for="horario" class="form-label">Horario de Trabajo</label>
        <input type="text" class="form-control" id="horario" name="horario" placeholder="Ej. 9:00 AM - 6:00 PM" required>

        <label for="prestaciones" class="form-label">Prestaciones</label>
        <textarea class="form-control" id="prestaciones" name="prestaciones" rows="3" placeholder="Ej. Seguro médico, Aguinaldo, Vacaciones, etc." required></textarea>

        <label for="cuenta_bancaria" class="form-label">Número de Cuenta Bancaria</label>
        <input type="text" class="form-control" id="cuenta_bancaria" name="cuenta_bancaria" required>

        <label for="rfc" class="form-label">RFC</label>
        <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Ej. ABCD123456EF7" required>
            </div>

            <!-- Botón de Envío -->
            <div class="d-flex justify-content-center mt-4 col-12">
                <button type="submit" class="btn btn-primary btn-lg px-4 py-2 shadow-sm">Enviar</button>
            </div>


            <!-- Seccion 4 -->


        </form>
    </div>

    

    <!-- Bootstrap core JavaScript (CDN)-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="main/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="main/datatables/jquery.dataTables.min.js"></script>
    <script src="main/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Date Range Picker JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Inicialización de Date Range Picker -->
    <script>
        $(document).ready(function() {
            $('#miFecha').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });
    </script>
    <script>
        // Función para mostrar las pestañas correspondientes
    function showTab(index) {
        // Obtener todas las pestañas y secciones
        const tabs = document.querySelectorAll('.tabs li');
        const sections = document.querySelectorAll('.form-section');
        
        // Ocultar todas las secciones y quitar la clase activa de todas las pestañas
        tabs.forEach(tab => tab.classList.remove('active'));
        sections.forEach(section => section.classList.remove('active'));
        
        // Activar la pestaña seleccionada y mostrar la sección correspondiente
        tabs[index].classList.add('active');
        sections[index].classList.add('active');
    }
    </script>

<script>
    function handleFileSelect(event) {
        const files = event.target.files;
        const filePreviews = document.getElementById('filePreviews');
        
        // Limpiar los previos elementos
        filePreviews.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileType = file.type;
            const fileName = file.name;
            const fileURL = URL.createObjectURL(file);

            // Crear una tarjeta para cada archivo
            const card = document.createElement('div');
            card.classList.add('card', 'file-card');
            
            const cardBody = document.createElement('div');
            cardBody.classList.add('card-body');
            
            // Condicional para tipo de archivo
            if (fileType.startsWith('image/')) {
                // Vista previa de imagen
                const image = document.createElement('img');
                image.src = fileURL;
                image.alt = fileName;
                cardBody.appendChild(image);
            } else if (fileType === 'application/pdf') {
                // Vista previa de PDF
                const iframe = document.createElement('iframe');
                iframe.src = fileURL;
                iframe.title = fileName;
                cardBody.appendChild(iframe);
            } else {
                // Otro tipo de archivo
                const icon = document.createElement('i');
                icon.classList.add('fas', 'fa-file-alt', 'fa-3x');
                cardBody.appendChild(icon);
            }

            // Añadir nombre de archivo y tipo
            const fileInfo = document.createElement('p');
            fileInfo.classList.add('mt-2');8
            fileInfo.textContent = `Nombre: ${fileName}`;
            cardBody.appendChild(fileInfo);

            // Agregar la tarjeta al contenedor de previsualización
            card.appendChild(cardBody);
            filePreviews.appendChild(card);
        }
    }
    const modalContainer = document.querySelector('body');
    const modalTemplate = document.getElementById('modalTemplate');

   for (let i = 1; i <= 5; i++) {
    const modalClone = modalTemplate.content.cloneNode(true);
    const modal = modalClone.querySelector('.modal');
    modal.id = `fileUploadModal${i}`;

    const fileInput = modalClone.querySelector('.file-input');
    const previewImage = modalClone.querySelector('.preview-image');
    const previewPdf = modalClone.querySelector('.preview-pdf');
    const saveButton = modalClone.querySelector('.save-button');
    const statusText = document.getElementById(`status${i}`);

    // Manejo de archivo
    fileInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;

      const fileURL = URL.createObjectURL(file);
      if (file.type.startsWith('image/')) {
        previewImage.src = fileURL;
        previewImage.classList.remove('d-none');
        previewPdf.classList.add('d-none');
      } else if (file.type === 'application/pdf') {
        previewPdf.src = fileURL;
        previewPdf.classList.remove('d-none');
        previewImage.classList.add('d-none');
      }

      saveButton.disabled = false;
    });

    // Guardar archivo
    saveButton.addEventListener('click', () => {
      statusText.textContent = "Archivo cargado correctamente";
      modal.querySelector('[data-bs-dismiss="modal"]').click(); // Cerrar modal
    });

    modalContainer.appendChild(modalClone);
  }

</script>
</body>

</html>