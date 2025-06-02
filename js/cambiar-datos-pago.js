function permitirEditar(dato){
    event.preventDefault();
    var inputid = dato;
    var inputs = document.querySelectorAll('input[id$="' + inputid + '"]');

    var mensaje = document.getElementById("mensaje");
    var boton = document.getElementById("aplicarcambios" + inputid);
    boton.style.display = "inline-block";
        for (var i = 0; i < inputs.length; i++) {
            if(inputs[i].readOnly === true){
                console.log("enabled");
                inputs[i].classList.remove('disabled');
                inputs[i].readOnly = false;
                mensaje.style.display = "none";
            }else{
                mensaje.style.display = "none";
                boton.style.display = "none";
                console.log("disabled");
                inputs[i].classList.add('disabled');
                inputs[i].readOnly = true;
                if (inputs[i].hasAttribute('data-original-value')) {
                    inputs[i].value = inputs[i].getAttribute('data-original-value');
                  }
            }
        }
    
    }
    

    function cambiarDatos(bloque){

        event.preventDefault();
          
        // Obtener los valores del formulario
        var nombre = document.getElementById('nombre-input' + bloque).value;
        var apellidos = document.getElementById('apellidos-input' + bloque).value;
        var ciudad = document.getElementById('ciudad-input' + bloque).value;
        var direccion = document.getElementById('direccion-input' + bloque).value;
        var codigopost = document.getElementById('codigopost-input' + bloque).value;
        var pais = document.getElementById('pais-input' + bloque).value;
        var telefono = document.getElementById('telefono-input' + bloque).value;
        var mensajeElemento = document.getElementById("mensaje");
        var tarjetaoriginal = document.getElementById("tarjeta-hidden" + bloque).getAttribute('data-value');
        var caducidad = document.getElementById('caducidad-input' + bloque).value;
        var codigoseg = document.getElementById('codigoseg-input' + bloque).value;
        var tarjeta = document.getElementById("tarjeta-input" + bloque).value;

    
        if (direccion.trim() === "" || ciudad.trim() === "" || nombre.trim() === "" || apellidos.trim() === "" || codigopost.trim() === "" || pais.trim() === "" || telefono.trim() === ""){ 
        mensajeElemento.style.display = "block";
        mensajeElemento.innerHTML = "Por favor, introduzca todos los datos.";
        mensajeElemento.style.color = "red";
        return;
        }

        if (caducidad.length != 5){
          mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "La fecha de caducidad es inválida.";
            mensajeElemento.style.color ="red";
            return;
        }

        if (codigoseg.length != 3){
          mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "El código de seguridad es inválido.";
            mensajeElemento.style.color ="red";
            return;
        }

        if (telefono.length != 9){
            mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "El teléfono introducido es inválido.";
            mensajeElemento.style.color ="red";
            return;
        }

        if(codigopost.length != 5){
            mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "El código postal introducido es inválido.";
            mensajeElemento.style.color ="red";
            return;
        }

        if(tarjeta.length != 12){
          mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "La tarjeta introducida es inválida.";
            mensajeElemento.style.color ="red";
            return;
        }

        
        

            
        // Crear un objeto FormData y agregar los datos del formulario
        var formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('apellidos', apellidos);
        formData.append('ciudad', ciudad);
        formData.append('direccion', direccion);
        formData.append('codigopost', codigopost);
        formData.append('pais', pais);
        formData.append('telefono', telefono);
        formData.append('tarjetaoriginal', tarjetaoriginal);
        formData.append('tarjeta', tarjeta);
        formData.append('caducidad', caducidad);
        formData.append('codigoseg', codigoseg);
        
    
        // Crear una instancia de XMLHttpRequest
        var xhr = new XMLHttpRequest();
    
        // Configurar la solicitud AJAX
        xhr.open('POST', 'backend/editar-datos-pago.php', true);
    
        // Enviar la solicitud AJAX con los datos del formulario
        xhr.send(formData);
    
        // Manejar la respuesta del servidor
        xhr.onreadystatechange = function() { 
    
    
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              var respuesta = xhr.responseText;
              console.log(respuesta);
              if( respuesta === "success") {
                mensajeElemento.style.display = "none";
                window.location.reload(); 
              }else{
                console.log(respuesta);
                mensajeElemento.style.display = "block";
                mensajeElemento.innerHTML = "Ha ocurrido un error interno.";
                mensajeElemento.style.color = "red";
              }
            } else {
              // Hubo un error en la solicitud
              console.error('Error en la solicitud AJAX');
            }
          }
        };
    }

    function mostrarPopup(bloque){

      event.preventDefault();
   var popup = document.getElementById(bloque);
     popup.style.display = "flex";
  }
  
  function cerrarPopup(bloque){
      var popup = document.getElementById(bloque);
      popup.style.display = "none";
  }

    function Eliminar(bloque){
      event.preventDefault();
      var tarjetaoriginal = document.getElementById("tarjeta-hidden" + bloque).getAttribute('data-value');
      
      var formData = new FormData();

      formData.append('tarjetaoriginal', tarjetaoriginal);

      var xhr = new XMLHttpRequest();
    
      // Configurar la solicitud AJAX
      xhr.open('POST', 'eliminar-datos-pago', true);
  
      // Enviar la solicitud AJAX con los datos del formulario
      xhr.send(formData);
  
      // Manejar la respuesta del servidor
      xhr.onreadystatechange = function() { 
  
  
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var respuesta = xhr.responseText;
            console.log(respuesta);
            if( respuesta === "success") {
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
    
