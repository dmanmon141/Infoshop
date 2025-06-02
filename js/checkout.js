function enviarFormulario(event) {
    event.preventDefault(); // Evita que se envíe el formulario de forma convencional


      

    // Obtener los valores del formulario
    var tarjeta = document.getElementById('tarjeta-input').value;
    var caducidad = document.getElementById('caducidad-input').value;
    var codigoseg = document.getElementById('codigoseg-input').value;
    var prodcod = document.getElementById("idProducto").getAttribute("data-id");

    var nombre = document.getElementById('nombre-input').value;
    var apellidos = document.getElementById('apellidos-input').value;
    var ciudad = document.getElementById('ciudad-input').value;
    var direccion = document.getElementById('direccion-input').value;
    var codigopost = document.getElementById('codigopost-input').value;
    var pais = document.getElementById('pais-input').value;
    var telefono = document.getElementById('telefono-input').value;
    var politicas = document.getElementById('politicas-input').checked;
    var guardar = document.getElementById('guardar').checked;
    var mensajeElemento = document.getElementById("mensaje");


      

    if (nombre.trim() === "" || apellidos.trim() === "" || ciudad.trim() === "" || direccion.trim() === "" || codigopost.trim() === "" || pais.trim() === "" || telefono.trim() === "") {
        mensajeElemento.style.display = "none";  
        mensajeElemento.style.display = "block";
        mensajeElemento.innerHTML = "Por favor, introduzca todos los datos";
        mensajeElemento.style.color = "red";
        return;
      }

    if(tarjeta.length != 16){
      mensajeElemento.style.display = "none";
      mensajeElemento.style.display= "block";
      mensajeElemento.innerHTML = "Número de tarjeta incorrecto";
      mensajeElemento.style.color = "red";
      return;
    }

    if(caducidad.length != 5){
      mensajeElemento.style.display = "none";
      mensajeElemento.style.display= "block";
      mensajeElemento.innerHTML = "Fecha de caducidad incorrecta";
      mensajeElemento.style.color = "red";
      return;      
    }

    if(codigoseg.length != 3){
      mensajeElemento.style.display = "none";
      mensajeElemento.style.display= "block";
      mensajeElemento.innerHTML = "Código de seguridad incorrecto";
      mensajeElemento.style.color = "red";
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
    formData.append('prodcod', prodcod);
    formData.append('guardar', guardar);
    formData.append('nombre', nombre);
    formData.append('apellidos', apellidos);
    formData.append('tarjeta', tarjeta);
    formData.append('caducidad', caducidad);
    formData.append('codigoseg', codigoseg);
    formData.append('ciudad', ciudad);
    formData.append('direccion', direccion);
    formData.append('codigopost', codigopost);
    formData.append('pais', pais);
    formData.append('telefono', telefono);
    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'pedidocheck', true);

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
            redireccionar("exitocompra", {});
          }else if( respuesta === "error1"){
            console.log(respuesta);
            mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "El usuario ya tiene 3 tarjetas / direcciones registradas. Por favor, edite o elimine una ya guardada.";
            mensajeElemento.style.color = "red";
          }else{
            console.log(respuesta);
            mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "Esta tarjeta ya está registrada.";
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






