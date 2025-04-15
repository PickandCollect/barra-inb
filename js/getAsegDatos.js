 // Función para obtener los datos del asegurado
        function obtenerDatosAsegurado(no_siniestro) {
            console.log("Enviando solicitud AJAX con no_siniestro:", no_siniestro);

            $.ajax({
                url: "proc/get_aseg_datos.php",
                type: "POST",
                data: {
                    no_siniestro: no_siniestro
                },
                dataType: "json",
                success: function(response) {
                    console.log("Respuesta del servidor:", response);

                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    // Llenar los campos del formulario con los datos recibidos
                    $("#asegurado_ed").val(response.nom_asegurado || "");
                    $("#email_ed").val(response.email || "");
                    $("#telefono1_ed").val(response.tel1 || "");
                    $("#bancoaseg").val(response.banco || "");
                    $("#clabeaseg").val(response.clabe || "");
                    $("#titularcuenta").val(response.titular_cuenta || "");
                    $("#id_asegurado").val(response.id_asegurado || "");
                    $("#id_vehiculo").val(response.id_vehiculo || "");
                    $("#marca_veh").val(response.marca || "");
                    $("#tipo_veh").val(response.tipo || "");
                    $("#placas_veh_aseg").val(response.pk_placas || "");
                    $("#no_serie_veh_aseg").val(response.pk_no_serie || "");
                    $("#nsiniestro").val(response.no_siniestro || "");
                    $("#npoliza").val(response.poliza || "");
                    $("#fechasinaseg").val(response.fecha_siniestro || "");

                    console.log("Datos cargados correctamente.");
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX:", error);
                    console.log("Detalles:", xhr.responseText);
                    alert("Error al obtener datos.");
                }
            });
        }

        // Cuando el documento esté listo
        $(document).ready(function() {
            // Obtener el número de siniestro desde PHP
            var noSiniestro = <?php echo json_encode($_SESSION['no_siniestro'] ?? ''); ?>;
            console.log("Valor de noSiniestro desde PHP:", noSiniestro);

            // Asegurar que sea string y eliminar espacios en blanco
            noSiniestro = noSiniestro ? String(noSiniestro).trim() : "";

            // Verificar si noSiniestro tiene un valor válido
            if (noSiniestro) {
                // Llamar a la función para obtener los datos del asegurado
                obtenerDatosAsegurado(noSiniestro);
            } else {
                console.error("No se proporcionó un número de siniestro válido.");
                alert("No se proporcionó un número de siniestro válido.");
            }
        });