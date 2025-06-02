function mostrarPopup2() {
    document.getElementById("popup2").style.display = "flex";
  }
  
  function cerrarPopup2() {
    document.getElementById("popup2").style.display = "none";
  }
  
  function submitForm() {
    // Obtener el formulario por su ID
    var form = document.getElementById("resena-form2");

    var submitEvent = new Event("submit", {
        bubbles: true, // Permite la propagación del evento
        cancelable: true // Permite cancelar el evento
      });
    
      // Desencadenar el evento de envío del formulario
      form.dispatchEvent(submitEvent);
  }

  function editarReseña(event) {

    event.preventDefault();

    var prodcod = document.getElementById("idProducto").getAttribute("data-id");
    var contenido = document.getElementById("comentario-input2").value;
    var valoracion = document.getElementById("valoracion-input2").value;
    var mensaje = document.getElementById("mensaje2");

    var formData = new FormData();

    formData.append('prodcod', prodcod);
    formData.append('contenido', contenido);
    formData.append('valoracion', valoracion);

    if (contenido.length >= 50){
    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'backend/editar-resena.php', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 

      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var respuesta = xhr.responseText;
          if( respuesta === "success") {
            mensaje.style.display = "none";
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
    cerrarPopup2(); // Cerrar el popup después de editar la reseña
    }else{
        mensaje.style.display = "block";
        mensaje.innerHTML = "Por favor, introduzca más de 50 caracteres.";
    }
  }