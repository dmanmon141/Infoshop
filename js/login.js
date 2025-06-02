function enviarFormulario(event) {
    event.preventDefault(); // Evita el envío predeterminado del formulario
  
    // Obtén los valores de los campos del formulario
    var correo = document.getElementById("correo-input").value;
    var contraseña = document.getElementById("contraseña-input").value;
    var btnLogin = document.getElementById("btn-login");
  

    btnLogin.disabled = true;
  
    // Crea una instancia de XMLHttpRequest o utiliza una biblioteca como jQuery.ajax
  
    var xhr = new XMLHttpRequest();
  
    // Configura la solicitud POST al servidor
    xhr.open("POST", "backend/logincheck.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    // Define una función de devolución de llamada para manejar la respuesta del servidor
    xhr.onreadystatechange = function() {
        console.log(correo);
        console.log(contraseña);
        console.log(xhr.responseText);
      if (xhr.readyState === 4) {

        if (xhr.status === 200) {
          // La solicitud se completó con éxito
          if(xhr.responseText.trim() !== "") {
          // Verifica la respuesta del servidor y muestra el mensaje correspondiente en el elemento <div> de mensajes
          var respuesta = xhr.responseText.trim();
          var mensajeElemento = document.getElementById("mensaje");
          mensajeElemento.style.display = "block";
          btnLogin.disabled = false;  
          if (respuesta === "success") {
            // El inicio de sesión fue exitoso
            redireccionar("/", { correo: correo });
            mensajeElemento.style.display = "none";
          } else {
            // El inicio de sesión fue incorrecto
            mensajeElemento.innerHTML = "Correo o contraseña incorrectos";
            mensajeElemento.style.color = "red";
          }
        } else {
          // La solicitud no se completó correctamente, maneja el error aquí
        
        }
      }
    } else if(xhr.readyState === 5) {
        var mensajeElemento = document.getElementById("mensaje");
        mensajeElemento.innerHTML = "Error en la respuesta del servidor";
        mensajeElemento.style.color = "red";
    }
    };
  
    // Envía los datos del formulario al servidor
    var datos = 
    "correo=" + encodeURIComponent(correo) + "&contraseña=" + encodeURIComponent(contraseña);
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
