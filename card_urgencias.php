<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards de Urgencia</title>
    <link rel="stylesheet" href="css/card_urgencias.css"> <!-- Ruta al archivo CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de incluir jQuery -->
</head>

<body>
    <!-- Content Row -->
    <div class="row">
        <!-- 25% de urgencia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-u card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-l font-weight-bold text-info text-uppercase mb-3">
                                Registros con 25% de urgencia</div>
                            <!-- Actualización dinámica -->
                            <div id="urgencia-0-2" class="h3 mb-0 font-weight-bold text-gray-800">0</div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                0-2 días
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-3x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 50% de urgencia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-u card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-l font-weight-bold text-success text-uppercase mb-3">
                                Registros con 50% de urgencia</div>
                            <!-- Actualización dinámica -->
                            <div id="urgencia-3-5" class="h3 mb-0 font-weight-bold text-gray-800">0</div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                3-5 días
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 75% de urgencia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-u card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-l font-weight-bold text-warning text-uppercase mb-3">
                                Registros con 75% de urgencia</div>
                            <!-- Actualización dinámica -->
                            <div id="urgencia-6-14" class="h3 mb-0 font-weight-bold text-gray-800">0</div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                6-14 días
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 100% de urgencia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-u card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-l font-weight-bold text-danger text-uppercase mb-3">
                                Registros con 100% de urgencia</div>
                            <!-- Actualización dinámica -->
                            <div id="urgencia-15-plus" class="h3 mb-0 font-weight-bold text-gray-800">0</div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                >= 15 días
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-3x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para actualizar los valores dinámicamente -->
    <script>
        $(document).ready(function() {
            // Llamada AJAX para obtener los datos de urgencia
            $.ajax({
                url: 'proc/get_urgencias.php', // Cambia a la ruta del archivo PHP
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Actualiza las tarjetas dinámicamente
                    $('#urgencia-0-2').text(response['0-2 días'] || 0);
                    $('#urgencia-3-5').text(response['3-5 días'] || 0);
                    $('#urgencia-6-14').text(response['6-14 días'] || 0);
                    $('#urgencia-15-plus').text(response['>= 15 días'] || 0);

                    console.log("Datos cargados correctamente: ", response);
                },
                error: function(error) {
                    console.error("Error al cargar los datos: ", error);
                }
            });
        });
    </script>
</body>

</html>