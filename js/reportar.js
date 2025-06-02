function mostrarPopup3(){

var popup = document.getElementById("popup3");

popup.style.display = "flex";

}

function cerrarPopup3(){

var popup = document.getElementById("popup3");

popup.style.display = "none";
}

function reportar(){
var rescod = document.getElementById("rescod").value;

var formData = new FormData();

formData.append('rescod', rescod)

 var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'backend/enviar-report.php', true);

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