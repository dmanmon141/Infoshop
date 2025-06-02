function enviarFormulario(event) {
    event.preventDefault(); // Evita que se envíe el formulario de forma convencional

    function limpiarCampoContraseña(){
        document.getElementById("contraseña-input").value = "";
        document.getElementById("repetir-contraseña-input").value = "";
      }


      function validarContraseña(contraseña) {
        // Comprobar si la contraseña tiene al menos 8 caracteres, una mayúscula, una minúscula y un símbolo
        var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;
        if (regex.test(contraseña)) {
            return true;
        }else {
          mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "La contraseña debe de ser de 8 caracteres, contener mayúsculas y minúsculas, un símbolo (*, #, º) y un dígito (1, 4, 9).";
            mensajeElemento.style.color = "red";
            return false;
        }
      }
      
      

    // Obtener los valores del formulario
   
    var input = document.getElementById('btn-login');
    var token = input.getAttribute('data-token');
    var contraseña = document.getElementById('contraseña-input').value;
    var repetirContraseña = document.getElementById('repetir-contraseña-input').value;
    var mensajeElemento = document.getElementById("mensaje");
    var loader = document.getElementById("loader");



      if (contraseña != repetirContraseña){
        mensajeElemento.style.display = "block";
        mensajeElemento.innerHTML = "Las contraseñas no coinciden";
        mensajeElemento.style.color = "red";
        return;
    }

      if (!validarContraseña(contraseña)){
        return;
      }


      loader.style.display = "block";

    // Crear un objeto FormData y agregar los datos del formulario
    var formData = new FormData();

    formData.append('contraseña', contraseña);
    formData.append('repetir-contraseña', repetirContraseña);
    formData.append('token', token);

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'cambiar-contraseña', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 

      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var respuesta = xhr.responseText;
          if( respuesta === "success") {
            mensajeElemento.style.display = "none";
            console.log(respuesta); // Puedes hacer algo con la respuesta del servidor aquí 
            redireccionar("exito", {});
          }else if ( respuesta === "expirado") {
            redireccionar("restablecer-contraseña", {token: token});
            console.log(respuesta);
          }
        } else {
          // Hubo un error en la solicitud
          console.error('Error en la solicitud AJAX');
          console.log(respuesta);
        }
      }
    };

    function redireccionar(url, params) {
        var form = document.createElement("form");
        form.action = url;
        form.method = "GET";
        for (var key in params) {
          if (params.hasOwnProperty(key)) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = params[key];
            form.appendChild(input);
          }
        }
        document.body.appendChild(form);
        form.submit();
      }
  }

  document.addEventListener("DOMContentLoaded", function () {
    var formulario = document.getElementById("login-form");
    formulario.addEventListener("submit", enviarFormulario);
  });






