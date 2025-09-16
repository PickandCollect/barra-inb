$(document).ready(function () {
  // Manejar la selección de archivo para mostrar la vista previa
  $("#fileInput").on("change", function () {
    const file = this.files[0];
    if (file) {
      // Crear una URL de la imagen para la vista previa
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#profilePreview").attr("src", e.target.result); // Actualizar la imagen de vista previa
      };
      reader.readAsDataURL(file);
    }
  });

  // Manejar el evento de click para insertar o actualizar el usuario
  $("#btnInsertarUsuario").on("click", function (e) {
    e.preventDefault();

    // Crear FormData
    const formData = new FormData();
    formData.append("usuario", $("#usuario").val());
    formData.append("nombre_us", $("#nombre_us").val());
    formData.append("curp", $("#curp").val());
    formData.append("rfc", $("#rfc").val());
    formData.append("telefono1", $("#telefono1").val());
    formData.append("celular", $("#celular").val());
    formData.append("email", $("#email").val());
    formData.append("passemail", $("#passemail").val());
    formData.append("extension", $("#extension").val());
    formData.append("jefe", $("#jefe").val());
    formData.append("perfil", $("#perfil").val());

    // Agregar la imagen seleccionada al FormData
    const profileImageInput = $("#fileInput")[0];
    if (profileImageInput.files[0]) {
      formData.append("profileImage", profileImageInput.files[0]);
    }

    // Realizar la solicitud AJAX
    $.ajax({
      url: "proc/update_usuario.php", // Cambia esta URL por la que corresponda
      type: "POST",
      data: formData,
      processData: false, // Importante para enviar FormData con archivos
      contentType: false, // Importante para enviar FormData con archivos
      success: function (response) {
        // Asegúrate de que la respuesta sea un objeto JSON
        console.log("Respuesta recibida del servidor:", response);

        try {
          // Intentar parsear la respuesta (en caso de que no sea JSON)
          response = JSON.parse(response);
        } catch (e) {
          console.error("Error al parsear la respuesta:", e);
          alert("Hubo un error en la respuesta del servidor.");
          return;
        }

        // Comprobar si la respuesta tiene los campos success y error
        if (response.success !== undefined) {
          if (response.success) {
            alert("Usuario actualizado correctamente");
          } else {
            alert(
              "Error al actualizar el usuario: " +
                (response.error || "Desconocido")
            );
          }
        } else {
          alert("La respuesta del servidor es incorrecta");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud:", error);
        alert("Hubo un error al procesar la solicitud.");
      },
    });
  });
});
