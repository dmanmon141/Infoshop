function enviarFormulario(event) {
    event.preventDefault(); // Evita el envío predeterminado del formulario
  
    function validarCorreo(correo) {
        // Expresión regular para verificar el formato del correo electrónico
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Verificar si el correo cumple con el formato válido
        if (regex.test(correo)) {
          console.log("Correo válido");
          return true;
          // Aquí puedes realizar las acciones que desees cuando el correo es válido
        } else {
          console.log("Correo inválido");
          mensajeElemento.style.display = "block";
          mensajeElemento.innerHTML = "Correo inválido";
          mensajeElemento.style.color = "red";
          return false;
          // Aquí puedes realizar las acciones que desees cuando el correo es inválido
        }
      }
    
    // Obtén los valores de los campos del formulario
    var correo = document.getElementById("correo-input").value;
    var btnLogin = document.getElementById("btn-login");
    var loader = document.getElementById("loader");
    var mensajeElemento = document.getElementById("mensaje");

    

    if (!validarCorreo(correo)) {
        return;
      }

      loader.style.display = "block";
  
    // Crea una instancia de XMLHttpRequest o utiliza una biblioteca como jQuery.ajax
  
    var xhr = new XMLHttpRequest();
  
    // Configura la solicitud POST al servidor
    xhr.open("POST", "backend/recuperacion-correo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    // Define una función de devolución de llamada para manejar la respuesta del servidor
    xhr.onreadystatechange = function() {
        btnLogin.disabled = true;
        console.log(correo);
        console.log(xhr.responseText);
      if (xhr.readyState === 4) {

        if (xhr.status === 200) {
          // La solicitud se completó con éxito
          if(xhr.responseText.trim() !== "") {
          // Verifica la respuesta del servidor y muestra el mensaje correspondiente en el elemento <div> de mensajes
          btnLogin.disabled = false;
          var mensajeElemento = document.getElementById("mensaje");
          loader.style.display = "none"; 
          mensajeElemento.style.display = "block";
          if (xhr.responseText.trim() === "success") {
            // El inicio de sesión fue exitoso
            mensajeElemento.style.borderColor = "green";
            mensajeElemento.innerHTML = "Se ha enviado un correo de restablecimiento de contraseña a la dirección introducida.";
            mensajeElemento.style.color = "black";
            mensajeElemento.style.fontSize = "13px";
            return;
          } else {
            // El inicio de sesión fue incorrecto
            mensajeElemento.innerHTML = "Este correo no tiene una cuenta asociada.";
            mensajeElemento.style.color = "red";
          }
        } else {
          // La solicitud no se completó correctamente, maneja el error aquí
        
        }
      }
    } else{
        var mensajeElemento = document.getElementById("mensaje");
        mensajeElemento.innerHTML = "Error en la respuesta del servidor";
        mensajeElemento.style.color = "red";
    }
    };
  
    // Envía los datos del formulario al servidor
    var datos = 
    "correo=" + encodeURIComponent(correo);
    xhr.send(datos);

};

document.addEventListener("DOMContentLoaded", function () {
    var formulario = document.getElementById("login-form");
    formulario.addEventListener("submit", enviarFormulario);
  });

  function redireccionar(url, params) {
    var form = document.createElement("form");
    form.action = url;
    form.method = "POST";
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
