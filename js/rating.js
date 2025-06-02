$(document).ready(function() {
    $('.star').click(function() {
      var value = $(this).data('value');
      
      $(this).find('img').attr('src', 'img/star-on.png');
      $(this).prevAll('.star').find('img').attr('src', 'img/star-on.png');
      $(this).nextAll('.star').find('img').attr('src', 'img/star-off.png');
      
      // Actualizar el valor de la selección en el campo oculto
      $(this).closest('form').find('select[name="valoracion"]').val(value);

        });

      });

      function enviarFormulario(event) {
        event.preventDefault(); // Evita el envío predeterminado del formulario
      
        // Obtén los valores de los campos del formulario
        var contenido = document.getElementById("comentario-input").value;
        var valoracion = document.getElementById("valoracion-input").value;
        var prodcod = document.getElementById("prodcod").value;
        var mensaje = document.getElementById("mensaje");

        var formData = new FormData();
        formData.append('contenido', contenido);
        formData.append('valoracion', valoracion);
        formData.append('prodcod', prodcod);

        if(contenido.length >= 50) {

        var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'resenacheck', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 

      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          mensaje.style.display = "none";
          var respuesta = xhr.responseText;
          setTimeout(function() {
            location.reload();
          }, 500);
          if( respuesta === "success") {
           console.log(respuesta);
          }else{
            console.log(respuesta);
        } 
      }
    };
    
  };
  
}else{
  mensaje.style.display = "block";
  mensaje.innerHTML = "Por favor, introduzca más de 50 caracteres.";
};

      }
