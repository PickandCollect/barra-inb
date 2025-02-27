<?php 
    include 'conexion.php';
    //consulta estados
    $sql_estados = "SELECT DISTINCT pk_estado FROM Direccion";
    $resultado_estados = $conexion->query($sql_estados);

    //consulta regiones
    $sql_regiones = "SELECT DISTINCT region FROM Direccion";
    $resultados_regiones = $conexion->query($sql_regiones);

    ///consultar ciudades
    $sql_ciudades = "SELECT DISTINCT ciudad FROM Direccion";
    $resultado_ciudades = $conexion->query($sql_ciudades);

    //consultar cedula
    $sql_cedula = "SELECT 
                    C.id_registro AS ID_Registro,
                    C.siniestro AS Siniestro,
                    C.poliza AS Poliza,
                    V.marca AS Marca,
                    V.tipo AS Tipo,
                    V.ano AS Modelo,
                    V.pk_no_serie AS Serie,
                    C.fecha_siniestro AS FecSiniestro,
                    C.estacion AS Estacion,
                    C.estatus AS Estatus,
                    C.subestatus AS Subestatus,
                    C.porc_doc AS '% Documentos',
                    C.porc_total AS '% Total',
                    C.nom_estado AS Estado
                FROM 
                    Cedula C
                LEFT JOIN 
                    Vehiculo V ON C.fk_vehiculo = V.id_vehiculo
                LEFT JOIN 
                    Expediente E ON C.fk_expediente = E.id_exp
                ORDER BY 
                    C.id_registro";

    // Ejecutar la consulta
    $resultado_cedula = $conexion->query($sql_cedula);

    if (!$resultado_cedula) {
        die("Error en la consulta: " . $conexion->error);
    }

    $sql_usuarios = "SELECT 
                    U.id_usuario AS ID_Usuario,
                    U.nombre AS Nombre,
                    U.usuario AS Usuario,
                    U.perfil AS Perfil,
                    U.celular AS Celular,
                    U.email AS Email,
                    U.estado_online AS estado_online,
                    U.tipo AS Tipo,
                    U.extension AS Extension

                    FROM Usuario U
                    WHERE usuario != 'root'";

    // Ejecutar la consulta
    $resultado_us = $conexion->query($sql_usuarios);

    if (!$resultado_us) {
        die("Error en la consulta: " . $conexion->error);
    }


?>