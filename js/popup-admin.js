function mostrarPopup(div) {
event.preventDefault();
    console.log(div);
    document.getElementById(div).style.display = "flex";
  }


    
  
  
  function cerrarPopup(div) {
    document.getElementById(div).style.display = "none";
  }

function eliminarProducto(){

    var prodcod = document.getElementById("prodcod2").value;

    var formData = new FormData();

    formData.append('prodcod', prodcod);

     var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'eliminar-producto', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 
         

      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var respuesta = xhr.responseText;
          console.log(respuesta);
          if( respuesta === "success") {
            console.log(respuesta); // Puedes hacer algo con la respuesta del servidor aquí
            window.location.reload();
          }else{
            console.log(respuesta);
          }
        } else {
          // Hubo un error en la solicitud
          console.log(respuesta);
          console.error('Error en la solicitud AJAX');
        }
      }
    };
}

function limpiarNotificacion(indice){
event.preventDefault();



var notcod = document.getElementById("notcod-input" + indice).value;


    var formData = new FormData();

    formData.append('notcod', notcod);

     var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'limpiar-notificacion', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 
         

      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var respuesta = xhr.responseText;
          console.log(respuesta);
          if( respuesta === "success") {
            console.log(respuesta); // Puedes hacer algo con la respuesta del servidor aquí
            window.location.reload();
          }else{
            console.log(respuesta);
          }
        } else {
          // Hubo un error en la solicitud
          console.log(respuesta);
          console.error('Error en la solicitud AJAX');
        }
      }
    };

}