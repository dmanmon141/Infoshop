function enviarFormulario(event) {
    event.preventDefault(); // Evita que se envíe el formulario de forma convencional

    function limpiarCampoContraseña(){
        document.getElementById("contraseña-input").value = "";
        document.getElementById("repetir-contraseña-input").value = "";
      }

      function validarCorreo(correo) {
        // Expresión regular para verificar el formato del correo electrónico
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Verificar si el correo cumple con el formato válido
        if (regex.test(correo)) {
          console.log("Correo válido");
          return true;
          
        } else {
          console.log("Correo inválido");
          mensajeElemento.style.display = "block";
          mensajeElemento.innerHTML = "Correo inválido";
          mensajeElemento.style.color = "red";
          return false;
          
        }
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
    var nombre = document.getElementById('nombre-input').value;
    var apellidos = document.getElementById('apellidos-input').value;
    var correo = document.getElementById('correo-input').value;
    var contraseña = document.getElementById('contraseña-input').value;
    var repetirContraseña = document.getElementById('repetir-contraseña-input').value;
    var politicas = document.getElementById('politicas-input').checked;
    var mensajeElemento = document.getElementById("mensaje");


      

    if (correo.trim() === "" || contraseña.trim() === "" || repetirContraseña.trim() === "" || nombre.trim() === "" || apellidos.trim() === "") {
        mensajeElemento.style.display = "block";
        mensajeElemento.innerHTML = "Por favor, introduzca todos los datos";
        mensajeElemento.style.color = "red";
        limpiarCampoContraseña();
        return;
      }

      if (!validarCorreo(correo)) {
        return;
      }

      if (contraseña != repetirContraseña){
        mensajeElemento.style.display = "block";
        mensajeElemento.innerHTML = "Las contraseñas no coinciden";
        mensajeElemento.style.color = "red";
        return;
    }

      if (!validarContraseña(contraseña)){
        return;
      }

    if (!politicas){
        mensajeElemento.style.display = "block";
        mensajeElemento.innerHTML = "Debe de aceptar la política de privacidad.";
        mensajeElemento.style.color = "red";
        return;
      }

    // Crear un objeto FormData y agregar los datos del formulario
    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('apellidos', apellidos);
    formData.append('correo', correo);
    formData.append('contraseña', contraseña);
    formData.append('repetir-contraseña', repetirContraseña);
    formData.append('politicas', politicas);

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'registercheck', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 
          console.log(politicas);

      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var respuesta = xhr.responseText;
          console.log(respuesta);
          if( respuesta === "success") {
            mensajeElemento.style.display = "none";
            console.log(respuesta); // Puedes hacer algo con la respuesta del servidor aquí
            redireccionar("/", { correo: correo });
          }else{
            console.log(respuesta);
            mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "El correo introducido ya tiene una cuenta asociada";
            mensajeElemento.style.color = "red";
          }
        } else {
          // Hubo un error en la solicitud
          console.error('Error en la solicitud AJAX');
        }
      }
    };

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
  }






