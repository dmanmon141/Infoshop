function checkDatos(){
    var checkbox = document.getElementById("suscripcion");
    if(checkbox.checked === true){
        var suscrito = true;
    }else{
        var suscrito = false;
    }

    enviarDatos(suscrito);

    }

    function enviarDatos(suscrito){
        var suscripcion = suscrito;
        var mensajeElemento = document.getElementById("mensaje");
        var formData = new FormData();
        formData.append('suscripcion', suscripcion);
        var xhr = new XMLHttpRequest();

        // Configurar la solicitud AJAX
        xhr.open('POST', 'backend/newsletter.php', true);
    
        // Enviar la solicitud AJAX con los datos del formulario
        xhr.send(formData);
    
        // Manejar la respuesta del servidor
        xhr.onreadystatechange = function() { 
    
    
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              var respuesta = xhr.responseText;
              console.log(respuesta);
              if( respuesta === "success") {
                console.log(respuesta);
                mensajeElemento.style.display = "none";
                window.location.reload(); 
              }else{
                console.log(respuesta);
                mensajeElemento.style.display = "block";
                mensajeElemento.innerHTML = "Error de servidor interno.";
                mensajeElemento.style.color = "red";
              }
            } else {
              // Hubo un error en la solicitud
              console.error('Error en la solicitud AJAX');
            }
          }
        };
    }
