function enviarTicket(){
event.preventDefault;

var contenido = document.getElementById("contenido").value;

var formData = new FormData();

formData.append('contenido', contenido);


if(contenido.length < 30){
alert("Por favor, introduzca más de 30 caracteres.")
return;
}

var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'backend/crear-ticket.php', true);

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
            window.location.href ="perfil";
          }else{
            console.log(respuesta);
          }
        } else {
          // Hubo un error en la solicitud
          console.error('Error en la solicitud AJAX');
        }
      }
    };


}

function eliminarTicket(){

  event.preventDefault();

  var ticketid = document.getElementById("ticketid").value;

  var formData = new FormData();

  formData.append('ticketid', ticketid);

   var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'eliminar-ticket', true);

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
          console.error('Error en la solicitud AJAX');
        }
      }
    };

}
