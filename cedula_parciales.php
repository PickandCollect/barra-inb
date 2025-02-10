<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEDULA PARCIALES</title>
    <link rel="stylesheet" href="cedula_parciales.css">
</head>
<!-- Encabezado -->
<div class="header">
    <div class="title">CALIDAD PARCIALES</div>
    <div class="container_logo">
        <img src="img/logos2.gif" alt="Logo de la página">
    </div>
</div>

<!-- Contenedor principal -->
<div class="main-container">
    <!-- Sección Calidad 1 -->
    <div class="section-calidad">
        <div class="form-section">
            <div class="form-group">
                <label for="nombre_c">
                    <h6>Nombre del agente:</h6>
                </label>
                <select id="nombre_c" name="nombre_c" class="form-control">
                    <option value="" hidden>Selecciona</option>
                    <option value="ASEGURADO">ASEGURADO</option>
                    <option value="TERCERO">TERCERO</option>
                </select>
            </div>
            <div class="form-group">
                <label for="campana_c">
                    <h6>Campaña:</h6>
                </label>
                <select id="campana_c" name="campana_c" class="form-control">
                    <option value="" hidden>Selecciona</option>
                    <option value="ASEGURADO">ASEGURADO</option>
                    <option value="TERCERO">TERCERO</option>
                </select>
            </div>
            <!-- Más campos de formulario aquí -->
        </div>
    </div>

    <!-- Sección Calidad 2 (Nota de Calidad y Performance) -->
    <div class="section-nota-calidad">
        <div class="nota-calidad">
            <label for="nota_c">
                <h4>Nota de calidad:</h4>
            </label>
            <div id="nota_c" name="nota_c">0%</div>
        </div>
        <div class="performance">
            <h4>Performance:</h4>
            <img id="performance_img" src="img/cuidado.jpg" alt="performance">
        </div>
    </div>
</div>

<!-- Sección de Impacto Negocio -->
<div class="section-impacto">
    <div class="seccion-titulo">
        <h1>Impacto Negocio</h1>
        <span class="flecha">
            <i class="fas fa-chevron-down"></i>
        </span>
    </div>
    <div class="rubros-grid">
        <label for="rubro_c">
            <h6>Rubro</h6>
        </label>
        <label for="ponderacion_c">
            <h6>Ponderación</h6>
        </label>
        <label for="cumple_c">
            <h6>Cumple / No cumple</h6>
        </label>
        <!-- Ejemplo de rubro -->
        <label for="presentacion_c">
            <h6>Presentación institucional</h6>
        </label>
        <input type="text" id="pon1" name="pon1" class="form-control" value="6" readonly>
        <select id="cumple" name="cumple" class="form-control">
            <option value="" hidden>Selecciona</option>
            <option value="SI">SI</option>
            <option value="NO">NO</option>
        </select>
        <!-- Más rubros aquí -->
    </div>
</div>

<!-- Sección de Fortalezas y Áreas de Oportunidad -->
<div class="section-fortalezas-oportunidades">
    <div class="fortalezas">
        <label for="fortalezas">
            <h6>Fortalezas</h6>
        </label>
        <textarea id="fortalezas" class="form-control" readonly></textarea>
    </div>
    <div class="oportunidades">
        <label for="oportunidades">
            <h6>Áreas de Oportunidad</h6>
        </label>
        <textarea id="oportunidades" class="form-control" readonly></textarea>
    </div>
</div>

<!-- Sección de Comentarios y Compromiso -->
<div class="section-comentarios-compromiso">
    <div class="comentarios">
        <label for="comentarios">
            <h6>Comentarios</h6>
        </label>
        <textarea id="comentarios" class="form-control"></textarea>
    </div>
    <div class="compromiso">
        <label for="compromiso">
            <h6>Compromiso</h6>
        </label>
        <textarea id="compromiso" class="form-control"></textarea>
    </div>
</div>

<!-- Sección de Firmas -->
<div class="section-firmas">
    <div class="firma-asesor">
        <h6>Firma del asesor</h6>
        <canvas id="firmaAsesorCanvas" width="300" height="100"></canvas>
        <div class="firma-botones">
            <button class="btn-limpiar">Limpiar</button>
            <button class="btn-capturar">Capturar</button>
        </div>
    </div>
    <div class="firma-analista">
        <h6>Firma del analista</h6>
        <canvas id="firmaAnalistaCanvas" width="300" height="100"></canvas>
        <div class="firma-botones">
            <button class="btn-limpiar">Limpiar</button>
            <button class="btn-capturar">Capturar</button>
        </div>
    </div>
</div>
</body>

</html>