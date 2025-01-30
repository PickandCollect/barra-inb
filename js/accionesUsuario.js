$(document).ready(function () {
  const modalUrl = "nuevo_usuario.php"; // URL para cargar contenido dinámico

  // Evento para abrir modal con datos dinámicos
  $(".custom-table-style-edit-btn").on("click", function () {
    const usuario = $(this).data("usuario"); // Obtiene el nombre de usuario

    console.log("Usuario enviado:", usuario); // Verifica el nombre de usuario en la consola

    $.ajax({
      url: "proc/obtener_usuario.php", // Cambiado a 'obtener_usuario.php' para obtener los datos
      type: "GET",
      data: {
        usuario: usuario, // Envía el nombre de usuario como parámetro
      },
      success: function (response) {
        console.log("Respuesta del servidor:", response); // Verifica la respuesta en la consola

        if (response.success) {
          const usuario = response.data[0]; // Suponiendo que solo hay un usuario con el id
          console.log("Datos del usuario:", usuario);

          // Rellenamos el modal con los datos del usuario
          $("#nombre_us").val(usuario.nombre || "");
          $("#curp").val(usuario.curp || "");
          $("#rfc").val(usuario.rfc || "");
          $("#telefono1").val(usuario.telefono1 || "");
          $("#celular").val(usuario.celular || "");
          $("#email").val(usuario.email || "");
          $("#passemail").val(usuario.passemail || "");
          $("#extension").val(usuario.extension || "");
          $("#jefe").val(usuario.jefe_directo || "");
          $("#usuario").val(usuario.usuario || "");
          $("#contrasena").val(usuario.contrasena || "");
          $("#perfil").val(usuario.perfil || "");

          // Si hay imagen de perfil, mostrarla
          if (usuario.imagen_perfil) {
            $("#profilePreview").attr("src", usuario.imagen_perfil);
          } else {
            $("#profilePreview").attr("src", "https://via.placeholder.com/150");
          }

          // Muestra el modal_p
          $("#modal_p").modal("show");
        } else {
          alert("Error: " + response.error);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos del usuario: ", error);
        alert("No se pudo cargar el usuario.");
      },
    });
  });
});

$(".delete-btn").on("click", function () {
  const nombreUsuario = $(this).data("usuario"); // Obtener el nombre de usuario desde el atributo data-usuario
  console.log("Nombre de usuario:", nombreUsuario); // Para verificar que se está capturando correctamente

  if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
    $.ajax({
      url: "proc/borra_usuario.php", // El archivo PHP que maneja la eliminación
      type: "POST",
      data: {
        nombre_usuario: nombreUsuario, // Enviar el nombre del usuario al servidor
      },
      success: function (response) {
        console.log("Respuesta de eliminación:", response); // Ver la respuesta del servidor
        try {
          const data = JSON.parse(response);
          if (data.status === "success") {
            alert("Usuario eliminado exitosamente");
            // Eliminar la fila de la tabla
            $(`button[data-usuario="${nombreUsuario}"]`).closest("tr").remove();
          } else {
            alert("Error al eliminar el usuario: " + data.message);
          }
        } catch (e) {
          console.error("Error al procesar la respuesta JSON:", e);
          alert("Error en la respuesta del servidor.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud de eliminación:", error);
        alert("Error al eliminar el usuario: " + xhr.responseText);
      },
    });
  }
});
// Limpiar el contenido del modal al cerrarlo
$("#nuevaCedulaModal").on("hidden.bs.modal", function () {
  $("#modalContent").empty();
});
