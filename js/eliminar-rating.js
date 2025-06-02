function mostrarPopup() {
    document.getElementById("popup").style.display = "flex";
  }
  
  function cerrarPopup() {
    document.getElementById("popup").style.display = "none";
  }
  
  function eliminarReseña() {

    var idProducto = document.getElementById("idProducto").getAttribute("data-id");
    var idUsuario = document.getElementById("idUsuario").getAttribute("data-id");
    var formData = new FormData();

    formData.append('idProducto', idProducto);
    formData.append('idUsuario', idUsuario);
    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'backend/eliminar-resena.php', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 

      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var respuesta = xhr.responseText;
          if( respuesta === "success") {
            setTimeout(function() {
                location.reload();
              }, 500);
          }else if ( respuesta === "expirado") {
            console.log(respuesta);
          }
        } else {
          // Hubo un error en la solicitud
          console.error('Error en la solicitud AJAX');
          console.log(respuesta);
        }
      }
    };
  
    cerrarPopup(); // Cerrar el popup después de eliminar la reseña
  }

  