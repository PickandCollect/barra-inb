$(document).ready(function () {
  // Cuando se haga click en el botón con el id "btnSeg"
  $("#btnSeg").click(function () {
    // Obtener los valores de los campos del formulario
    var fecha_seguimiento = $("#fecha_reconocimiento_seg").val();
    var estatus_seg = $("#estatus_seg_ed").val();
    var sub_seg = $("#subestatus_seg_ed").val();
    var estacion_seg = $("#estacion_seg_ed").val();
    var comentario = $("#comentario_seg").val();
    var estatus_seg_ed = $("#estatus_seg_ed").val();
    var subestatus_seg_ed = $("#subestatus_seg_ed").val();
    var estacion_seg_ed = $("#estacion_seg_ed").val();
    var mensaje_seg_ed = $("#mensaje_seg_ed").val();
    var fecha_reconocimiento_seg = $("#fecha_reconocimiento_seg").val();
    var hora_seguimiento_seg = $("#hora_seguimiento_seg").val();
    var fecha_cita_seg = $("#fecha_cita_seg").val();
    var hora_cita_seg = $("#hora_cita_seg").val();
    var persona_seg = $("#persona_seg").val();
    var tipo_persona_seg = $("#tipo_persona_seg").val();
    var contacto_p_seg = $("#contacto_p_seg").val();
    var fecha_envio_seg = $("#fecha_envio_seg").val();
    var fecha_expediente_seg = $("#fecha_expediente_seg").val();
    var fecha_fact_seg = $("#fecha_fact_seg").val();
    var fecha_termino_Seg = $("#fecha_termino_Seg").val();

    // Obtener el valor de "cedula_id_ed" y el ID del asegurado
    var fk_cedula = $("#cedula_id_ed").val();
    var id_asegurado = $("#id_asegurado").val();
    var no_siniestro_exp = $("#no_siniestro_exp").val();

    // Validar que no falten datos necesarios
    if (!mensaje_seg_ed || !id_asegurado || !no_siniestro_exp) {
      alert(
        "Faltan datos necesarios: número de siniestro, usuario receptor o mensaje."
      );
      return; // Detener la ejecución si falta algún dato
    }

    // Crear un objeto con los datos del formulario
    var data = {
      fecha_seguimiento: fecha_seguimiento,
      estatus_seg: estatus_seg,
      sub_seg: sub_seg,
      estacion_seg: estacion_seg,
      comentario: comentario,
      estatus_seg_ed: estatus_seg_ed,
      subestatus_seg_ed: subestatus_seg_ed,
      estacion_seg_ed: estacion_seg_ed,
      mensaje_seg_ed: mensaje_seg_ed,
      fecha_reconocimiento_seg: fecha_reconocimiento_seg,
      hora_seguimiento_seg: hora_seguimiento_seg,
      fecha_cita_seg: fecha_cita_seg,
      hora_cita_seg: hora_cita_seg,
      persona_seg: persona_seg,
      tipo_persona_seg: tipo_persona_seg,
      contacto_p_seg: contacto_p_seg,
      fecha_envio_seg: fecha_envio_seg,
      fecha_expediente_seg: fecha_expediente_seg,
      fecha_fact_seg: fecha_fact_seg,
      fecha_termino_Seg: fecha_termino_Seg,
      fk_cedula: fk_cedula,
      no_siniestro: no_siniestro_exp,
      usuario_emisor: "<?php echo $_SESSION['id_usuario'] ?? ''; ?>", // El usuario_emisor es el ID del usuario actual
      usuario_receptor: id_asegurado, // El receptor es el ID del asegurado
    };

    // Mostrar los datos que se enviarán a insert_seguimiento.php
    console.log("Datos enviados a insert_seguimiento.php:", data);

    // Enviar los datos al servidor usando AJAX para el insert_seguimiento.php
    $.ajax({
      url: "proc/insert_seguimiento.php",
      type: "POST",
      data: data, // Verifica que 'data' sea un objeto o string válido
      success: function (response) {
        console.log(response);
        if (response.success) {
          var messageData = {
            id_usuario_emisor: id_asegurado,
            id_usuario_receptor: "<?php echo $_SESSION['id_usuario'] ?? ''; ?>",
            mensaje: comentario,
            fecha_envio: fecha_envio_seg,
            no_siniestro: no_siniestro_exp,
          };

          console.log("Enviados a insert_mensajes_op.php:", messageData);

          $.ajax({
            url: "proc/insert_mensajes_op.php",
            type: "POST",
            data: messageData, // Los datos se deben enviar correctamente formateados
            success: function (response) {
              if (response.success) {
                alert("Mensaje enviado correctamente.");
              } else {
                alert("Error al enviar el mensaje.");
              }
            },
            error: function (xhr, status, error) {
              console.log(xhr.responseText); // Muestra más detalles sobre el error
              alert("Hubo un error al enviar el mensaje.");
            },
          });
        } else {
          alert(response.error);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText); // Ver el detalle del error para el seguimiento
        alert("Hubo un error al enviar los datos de seguimiento.");
      },
    });
  });
});
